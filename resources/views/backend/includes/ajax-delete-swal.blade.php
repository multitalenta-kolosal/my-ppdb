
<script>
    $(document).ready(function(){
        $('.delete-confirm').on('click', function(e) {
            e.preventDefault();
            Swal.fire({
                title: "@lang('Are you sure?')",
                text: "@lang('delete warning')",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "@lang('delete confirm')",
                closeOnConfirm: false
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: '{{route("backend.$module_name.destroy", $$module_name_singular)}}',
                        data: {
                            "_method":"DELETE",
                            "_token": "{{ csrf_token() }}"
                        },
                        success: function () {
                            setTimeout(function() {
                                window.location = "/admin/{{$module_name}}";
                            },1000);
                            Swal.fire({
                                icon: 'success',
                                title: "@lang('deleted')",
                                showConfirmButton: false,
                                timer: 1000
                            });
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            Swal.fire("@lang('delete error')", "@lang('error')", "error");
                        }
                    });
                }
            });
        });
    });
</script>