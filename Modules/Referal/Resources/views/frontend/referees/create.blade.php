<div class="col">
    <?php
    $module_name = 'referees';
    $module_action = 'Create';
    ?>
    {{ html()->form('POST', route("frontend.$module_name.store"))->class('form')->open() }}

    @include('referal::frontend.referees.form',['module_name' => 'referees'])

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