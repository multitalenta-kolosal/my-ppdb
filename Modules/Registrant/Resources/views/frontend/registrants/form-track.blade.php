<div class="row justify-content-center">
    <div class="col-10">
        <div class="form-group">
            <?php
            $field_name = 'registrant_id';
            $field_lable = __("registrant::$module_name.$field_name");
            $field_placeholder = $field_lable;
            $required = "required";
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control border-purple')->attributes(["$required"]) }}
        </div>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-10">
        <div class="form-group">
            <?php
            $field_name = 'phone';
            $field_lable = __("registrant::$module_name.$field_name");
            $field_placeholder = $field_lable;
            $required = "required";
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control border-purple')->attributes(["$required", 'aria-label'=>'Image']) }}
        </div>
    </div>
</div>

<div></div>

@push ('after-scripts')

@endpush
