<div class="col">
    <?php
    $module_name = 'registrants';
    $module_action = 'Create';
    ?>
    {{ html()->form('POST', route("frontend.$module_name.store"))->id("reg")->class('form')->open() }}

    @include('registrant::frontend.registrants.form',['module_name' => 'registrants'])

    <div class="row">
        <div class="col-12">
            <div class="float-right">
                <div class="form-group">
                {{ html()->button($text = "<i class='fas fa-long-arrow-alt-right'></i> " . ucfirst("Daftar") . "", $type = 'submit')->id("submit-reg")->class('btn btn-success btn-lg') }}
                </div>
            </div>
        </div>
    </div>

    {{ html()->form()->close() }}
    
</div>

@push('after-scripts')

<script type="text/javascript">
    $(document).ready(function(){
        $("#reg").on("submit", function (event) {
            $("#submit-reg").attr("disabled", true);
            Swal.fire({
                title: 'Sedang Diproses...',
                html: 'Jangan tutup atau refresh halaman ini.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                },
            });
        });
    });
</script>

@endpush
