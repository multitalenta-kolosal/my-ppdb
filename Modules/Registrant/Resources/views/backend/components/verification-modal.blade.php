
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
                    <button type="button" class="btn btn-danger mr-4" id="reject_{{$data->id}}" ><i class="fas fa-user-slash mr-2"></i>Tolak</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success" id="submit_data_{{$data->id}}" >Simpan</button>
                </div>
                    
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('[data-toggle="popover"]').popover();
</script>

<script src="https://cdn.jsdelivr.net/npm/busy-load/dist/app.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/busy-load/dist/app.min.css" rel="stylesheet">

<script type="text/javascript">
    $(document).ready(function(){
        $('#requirements_pass{{$data->id}}').on('change', function(){
            $('#requirements_pass{{$data->id}}_message').prop('checked',this.checked);
        });
        $('#test_pass{{$data->id}}').on('change', function(){
            $('#test_pass{{$data->id}}_message').prop('checked',this.checked);
        });
        $('#accepted_pass{{$data->id}}').on('change', function(){
            $('#accepted_pass{{$data->id}}_message').prop('checked',this.checked);
        });
    });

</script>   

<script type="text/javascript">
    $(document).ready(function(){
        const messageables = ['requirements_pass','test_pass','accepted_pas'];
        window.edited = false;

        $('#reject_{{$data->id}}').on('click', function(e) {
            e.preventDefault();
            var sender = [];
            var success_update = false;
            var request_data = {
                    "_method":"PATCH",
                    "_token": "{{ csrf_token() }}",
                    "registrant_id": $('#registrant_id_{{$data->id}}').val(),
                    "status_id": '-1',
                };

            $.ajax({
                type: "POST",
                url: '{{route("backend.registrantstages.update", $data->registrant_id)}}',
                data: request_data,
                success: function (response) {
                    success_update = true;
                    var data = response.data;
                    
                    Swal.fire({
                        title: "Menolak Pendaftar?",
                        showCancelButton: true,
                        confirmButtonText: "Tolak",
                        footer: 'Jika ya, maka status pendaftar menjadi "ditolak"',
                    }).then((result) => {
                        if (result.isConfirmed) {
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
                                    var generateUrl = '{!! route("backend.messages.sendMessage") !!}';
                                    
                                    var message_code = 'penolakan-message';
                                    
                                    var tracker_code = '';
                                    
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
                                                icon: 'warning',
                                                title: 'Pendaftar ditolak',
                                                footer: 'Mengirim pesan ke pengguna',
                                            })

                                            updateEditedStatus(true);
                                        },
                                        error: function (xhr, ajaxOptions, thrownError) {
                                            Toast.fire({
                                                icon: 'error',
                                                title: '@lang("Error Verified")',
                                                footer: 'Pesan tidak terkirim',
                                            });

                                            updateEditedStatus(false);
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
                                        icon: 'warning',
                                        title: 'Pendaftar ditolak',
                                        footer: 'Pesan tidak dikirim',
                                    })

                                    updateEditedStatus(true);
                                }
                            });
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

                    updateEditedStatus(false);
                }
            });
        });

        $('#submit_data_{{$data->id}}').on('click', function(e) {
            e.preventDefault();
            var sender = [];
            var success_update = false;
            var request_data = {
                    "_method":"PATCH",
                    "_token": "{{ csrf_token() }}",
                    "registrant_id": $('#registrant_id_{{$data->id}}').val(),
                    "va_pass": $.isNumeric(+$('#va_pass{{$data->id}}').prop('checked')) ? +$('#va_pass{{$data->id}}').prop('checked') : 0,
                    "entrance_fee_pass": +$('#entrance_fee_pass{{$data->id}}').prop('checked'),
                    "requirements_pass": +$('#requirements_pass{{$data->id}}').prop('checked'),
                    "test_pass": +$('#test_pass{{$data->id}}').prop('checked'),
                    "installment_id": $('#installment_id{{$data->id}}').val(),
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
                                                    title: '@lang("Data Verified")',
                                                    footer: 'Mengirimkan pesan ke pengguna...',
                                                })
                                            },
                                            error: function (xhr, ajaxOptions, thrownError) {
                                                Toast.fire({
                                                    icon: 'error',
                                                    title: '@lang("Error Verified")',
                                                    footer: 'Pesan tidak terkirim',
                                                });

                                                updateEditedStatus(false);
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
                            if(key == "installment_id" && val > 0){
                                col.innerHTML = '<i class="far fa-lg fa-check-circle"></i>';
                            }else{
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
                        }
                    });

                    updateEditedStatus(true);
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

                    updateEditedStatus(false);
                }
            });
            
        });

        function updateEditedStatus(status){
            window.edited = status;
        }

    });

    $('#modal_{{$data->id}}').on('hidden.bs.modal', function (e) {
        if(window.edited){
            $(".dtr-control").busyLoad("show", 
            { 
                fontawesome: "fa fa-cog fa-spin fa-3x fa-fw" ,
                background: "rgba(255, 152, 0, 0.86)",
                containerClass: "z-2",
            });
            $('#{{$module_name}}-table').DataTable().draw('page');
            window.edited = false;
        }

    });

    $('#button-installment-set-{{$data->id}}').on('click', function(){
        $.ajax({
            type: "POST",
            url: "{{route('backend.registrantstages.chooseInstallments')}}",
            data:{
                "_method":"POST",
                "_token": "{{ csrf_token() }}",
                "id": "{{ $data->id }}"
            },
            success: function(response) {
                if(!response.error){
                    var installment = response.data;

                    var installment_exists = false;

                    $('#installment_id{{$data->id}} option').each(function(){
                        if (this.value == installment.id) {
                            installment_exists = true;
                            return false;
                        }
                    });

                    if(installment_exists){
                        $('#installment_id{{$data->id}}').val(installment.id);
                    }else{
                        Swal.fire("Warning", "Jenis Angsuran "+installment.name+" tidak diperkenankan untuk unit {{$data->unit->name}}", "warning");
                    }
                }else{
                    Swal.fire("@lang('error')", response.message, "error");
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                Swal.fire("@lang('error')","error occured! please try again", "error");
            },
        });
    });
</script>
