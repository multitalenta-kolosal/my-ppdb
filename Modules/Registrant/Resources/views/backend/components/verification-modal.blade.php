
<div class="modal fade" id="modal_{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    <span class="text-info font-weight-bold">{{$data->name}}</span> | {{$data->registrant_id}}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div name="form">
                <div class="modal-body bg-light">
                    <?php
                        $registrantStage = $data->registrant_stage;
                    ?>
                    <form role="form" id="form_{{$data->id}}" method="PATCH" action="{{ route('backend.registrantstages.update', $registrantStage ?? '0') }}">
                        @csrf
                        <!-- <input type="hidden" name="_method" id="_method" value="PATCH">-->
                        <input type="hidden" name="registrant_id" id="registrant_id_{{$data->id}}" value="{{ $data->registrant_id }}"> 
                        @include('registrant::backend.components.verification-form')
            
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="submit_data_{{$data->id}}" >Save changes</button>
                </div>
                    
            </div>
        </div>
    </div>
</div>
    
<script type="text/javascript">
    $('[data-toggle="popover"]').popover();
</script>

<script type="text/javascript">
    $(document).ready(function(){
        const messageables = ['requirements_pass','test_pass','accepted_pas'];
        $('#submit_data_{{$data->id}}').on('click', function(e) {
            e.preventDefault();
            var sender = [];
            var success_update = false;
            var request_data = {
                    "_method":"PATCH",
                    "_token": "{{ csrf_token() }}",
                    "registrant_id": $('#registrant_id_{{$data->id}}').val(),
                    "va_pass": +$('#va_pass{{$data->id}}').prop('checked'),
                    "entrance_fee_pass": +$('#entrance_fee_pass{{$data->id}}').prop('checked'),
                    "requirements_pass": +$('#requirements_pass{{$data->id}}').prop('checked'),
                    "test_pass": +$('#test_pass{{$data->id}}').prop('checked'),
                    "dpp_pass": +$('#dpp_pass{{$data->id}}').prop('checked'),
                    "dp_pass": +$('#dp_pass{{$data->id}}').prop('checked'),
                    "spp_pass": +$('#spp_pass{{$data->id}}').prop('checked'),
                    "accepted_pass": +$('#accepted_pass{{$data->id}}').prop('checked'),
                };

            $.ajax({
                type: "POST",
                url: '{{route("backend.registrantstages.update", $data->registrant_id)}}',
                data: request_data,
                success: function (response) {
                    success_update = true;
                    var data = response.data;
                    var will_send = false;

                    $.each(data,function(key, val) {
                        if(key && (val == 1)){
                            if($('#'+key+'{{$data->id}}_message').prop('checked')){
                                sender.push(key);
                            }
                        }
                    });

                    if(sender.length > 0){
                        Swal.fire({
                                title: "Kirim Pesan Ke Pendaftar?",
                                showCancelButton: true,
                                confirmButtonText: "Kirim",
                                footer: 'Jika menekan close maka data diverifikasi tanpa mengirim pesan',
                            })
                            .then((result) => {
                                
                                const Toast = Swal.mixin({
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 3000,
                                    timerProgressBar: true,
                                    didOpen: (toast) => {
                                        toast.addEventListener('mouseenter', Swal.stopTimer)
                                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                                    }
                                })

                                if (result.isConfirmed) {
                                    will_send = true;    
                                    $.each(sender,function(key, val) {
                                        var generateUrl = '{!! route("backend.messages.sendMessage") !!}';
                                        
                                        var val_spliter = val.split('_');
                                        var message_code_without_suffix = val_spliter[0];
                                        var message_code = message_code_without_suffix+'-message';
                                        
                                        var tracker_code = message_code_without_suffix;
                                        
                                        $.ajax({
                                            type: "POST",
                                            url: generateUrl,
                                            data: {
                                                "_token": "{{ csrf_token() }}",
                                                "registrant_id": '{{$data->registrant_id}}',
                                                "tracker_code" : tracker_code,
                                                "message_code" : message_code,
                                            } ,
                                            success: function (response) {
                                                Toast.fire({
                                                    icon: 'success',
                                                    title: '@lang("Data Verified")'
                                                })
                                                return false;
                                            },
                                            error: function (xhr, ajaxOptions, thrownError) {
                                                Toast.fire({
                                                    icon: 'error',
                                                    title: '@lang("Error Verified")'
                                                });
                                            }
                                        });
                                    });            
                                }else{
                                    const Toast = Swal.mixin({
                                        toast: true,
                                        position: 'top-end',
                                        showConfirmButton: false,
                                        timer: 3000,
                                        timerProgressBar: true,
                                        didOpen: (toast) => {
                                            toast.addEventListener('mouseenter', Swal.stopTimer)
                                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                                        }
                                    })              
                                    Toast.fire({
                                        icon: 'success',
                                        title: '@lang("Data Verified")',
                                        footer: 'Pesan tidak dikirim',
                                    })
                                }
                            });
                    }else{      
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        })              
                        Toast.fire({
                            icon: 'success',
                            title: '@lang("Data Verified")'
                        })
                    }

                    $.each(data,function(key, val) { 
                        var col = document.getElementById("col_"+key+"_{{$data->id}}")
                        $('#'+key+'{{$data->id}}_message').prop('checked',false)
                        if(col){
                            if(key && (val == 1)){
                                if(key == "accepted_pass"){
                                    col.innerHTML = '<i class="far fa-2x fa-check-circle"></i>';
                                }else{
                                    col.innerHTML = '<i class="far fa-lg fa-check-circle"></i>';
                                }
                            }else{
                                col.innerHTML = '';                                
                            }
                        }
                    });
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        })
                    Toast.fire({
                        icon: 'error',
                        title: '@lang("Error Verified")'
                    });
                }
            });
        });
    });
    $('#modal_{{$data->id}}').on('hidden.bs.modal', function (e) {
        $('#{{$module_name}}-table').DataTable().draw(false);
    })
</script>