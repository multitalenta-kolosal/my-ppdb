<div class="row">
    <div class="col">
        <div class="form-group">
            <?php
            $field_name = 'name';
            $field_lable = __("referal::$module_name.$field_name");
            $field_placeholder = $field_lable;
            $required = "required";
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="form-group">
            <?php
            $field_name = 'phone';
            $field_lable = __("referal::$module_name.$field_name");
            $field_placeholder = $field_lable;
            $required = "required";
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="form-group">
            <?php
            $field_name = 'email';
            $field_lable = __("referal::$module_name.$field_name");
            $field_placeholder = $field_lable;
            $required = "required";
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
        </div>
    </div>
</div>
@if($module_action == "Edit")
    <div class="row">
        <div class="col">
            <div class="form-group">
                <?php
                $field_name = 'bank_code';
                $field_lable = __("referal::$module_name.$field_name");
                $field_placeholder = $field_lable;
                $required = "required";
                ?>
                {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
                {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-5">
            <div class="form-group">
                <?php
                $field_name = 'bank_name';
                $field_data_id = 'bank_name';
                $field_lable = __("referal::$module_name.$field_name");
                $field_placeholder = __("Select an option");
                $required = "required";
                $select_options = $bank_names;
                ?>
                {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
                {{ html()->select($field_data_id, $select_options)->placeholder($field_placeholder)->class('form-control select2')->attributes(["$required"]) }}
            </div>
        </div>
    </div>
@endif
@if($module_action != "Edit")
<div class="row">
    <div class="col-md-5">
        <div class="form-group">
            <?php
            $field_name = 'bank_name';
            $field_data_id = 'bank_name';
            $field_lable = __("referal::$module_name.$field_name");
            $field_placeholder = __("Select an option");
            $required = "required";
            $select_options = $banks;
            \Log::debug($module_action.'now action');
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->select($field_data_id, $select_options)->placeholder($field_placeholder)->class('form-control select2')->attributes(["$required"]) }}
        </div>
    </div>
</div>
@endif
<div class="row">
    <div class="col">
        <div class="form-group">
            <?php
            $field_name = 'bank_account';
            $field_lable = __("referal::$module_name.$field_name");
            $field_placeholder = $field_lable;
            $required = "required";
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
        </div>
    </div>
</div>
@if($module_action == "Edit")
    <div class="row">
        <div class="col">
            <div class="form-group">
                <?php
                $field_name = 'ref_code';
                $field_lable = __("referal::$module_name.$field_name");
                $field_placeholder = $field_lable;
                $required = "required";
                ?>
                {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
                {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
            </div>
        </div>
    </div>
@endif


<!-- Select2 Library -->
<x-library.select2 />
<x-library.datetime-picker />

@push('after-styles')
<!-- File Manager -->
<link rel="stylesheet" href="{{ asset('vendor/file-manager/css/file-manager.css') }}">
@endpush

@push ('after-scripts')

<!-- Date Time Picker & Moment Js-->
<script type="text/javascript">
$(function() {
    $('.datetime').datetimepicker({
        format: 'YYYY-MM-DD HH:mm:ss',
        icons: {
            time: 'far fa-clock',
            date: 'far fa-calendar-alt',
            up: 'fas fa-arrow-up',
            down: 'fas fa-arrow-down',
            previous: 'fas fa-chevron-left',
            next: 'fas fa-chevron-right',
            today: 'far fa-calendar-check',
            clear: 'far fa-trash-alt',
            close: 'fas fa-times'
        }
    });
});
</script>

<script type="text/javascript">


</script>

@endpush
