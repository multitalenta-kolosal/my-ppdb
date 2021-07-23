<script>
    $(document).ready(function(){
        $('#va_confirm_{{$model["registrant_id"]  ?? "0" }}').on('click', function(e) {
            e.preventDefault();
            Swal.fire({
                title: "Verifikasi Virtual Account ",
                html: "VA: {{$model['va_number']  ?? '0' }}<br> ID: {{$model['registrant_id']  ?? '0' }} <br> Nama: {{$model['name']  ?? '0' }}",
                type: "question",
                showCancelButton: true,
                confirmButtonText: "Verifikasi",
                footer: 'Anda dapat merubah nomor VA di edit Pendaftar',
                closeOnConfirm: false
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: '{{route("backend.registrantstages.update", $model["registrant_id"]  ?? "0")}}',
                        data: {
                            "_method":"PATCH",
                            "_token": "{{ csrf_token() }}",
                            "registrant_id": '{{$model["registrant_id"]  ?? "0" }}',
                            "notified" : "{{$module_name_singular->id  ?? "0" }}",
                            "va_pass": 1,
                        } ,
                        success: function (response) {
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
                            var verified_row = $("tr#row_{{$module_name_singular->id ?? '0'}}") ?? false;

                            if(verified_row){
                                verified_row.removeClass('table-info');
                            }
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            Toast.fire({
                                icon: 'error',
                                title: '@lang("Error Verified")'
                            });
                        }
                    });
                }
            });
        });
    });
</script>