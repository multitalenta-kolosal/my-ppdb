<div class="col">
    <?php
    $module_name = 'registrants';
    $module_action = 'Create';
    ?>
    {{ html()->form('POST', route("frontend.$module_name.store"))->class('form')->open() }}

    @include('registrant::frontend.registrants.form',['module_name' => 'registrants'])

    <div class="row">
        <div class="col-12">
            <div class="float-right">
                <div class="form-group">
                {{ html()->button($text = "<i class='fas fa-long-arrow-alt-right'></i> " . ucfirst("Daftar") . "", $type = 'submit')->class('btn btn-success btn-lg') }}
                </div>
            </div>
        </div>
    </div>

    {{ html()->form()->close() }}

</div>