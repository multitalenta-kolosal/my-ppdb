<div class="row">
    <div class="col">
        <div class="form-group">
            <?php
            $field_name = 'name';
            $field_lable = __("core::$module_name.$field_name");
            $field_placeholder = $field_lable;
            $required = "required";
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-3">
        <div class="form-group">
            <?php
            $field_name = 'unit_code';
            $field_lable = __("core::$module_name.$field_name");
            $field_placeholder = $field_lable;
            $required = "";
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required", 'aria-label'=>'Image']) }}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-2">
        <div class="form-group">
            <?php
            $field_name = 'order';
            $field_lable = __("core::$module_name.$field_name");
            $field_placeholder = $field_lable;
            $required = "required";
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required", 'aria-label'=>'Image']) }}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-3">
        <div class="form-group">
            <?php
            $field_name = 'referal_reward';
            $field_lable = __("core::$module_name.$field_name");
            $field_placeholder = $field_lable;
            $required = "";
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Rp.</span>
                </div>
                {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required", 'aria-label'=>'Image', 'aria-describedby'=>'button-image']) }}
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-4">
        <div class="form-group">
            <?php
            $field_name = 'api_key';
            $field_lable = __("core::$module_name.$field_name");
            $field_placeholder = $field_lable;
            $required = "";
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required", 'aria-label'=>'Image']) }}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-6">
        <div class="form-group">
            <?php
            $field_name = 'contact_number';
            $field_lable = __("core::$module_name.$field_name");
            $field_placeholder = $field_lable;
            $required = "required";
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required", 'aria-label'=>'Image']) }}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-6">
        <div class="form-group">
            <?php
            $field_name = 'contact_email';
            $field_lable = __("core::$module_name.$field_name");
            $field_placeholder = $field_lable;
            $required = "";
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->email($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required", 'aria-label'=>'Image']) }}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-6">
        <div class="form-group">
            <?php
            $field_name = 'register_form_link';
            $field_lable = __("core::$module_name.$field_name");
            $field_placeholder = $field_lable;
            $required = "";
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required", 'aria-label'=>'Image']) }}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-6">
        <div class="form-group">
            <?php
            $field_name = 'entrance_fee';
            $field_lable = __("core::$module_name.$field_name");
            $field_placeholder = $field_lable;
            $required = "";
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required", 'aria-label'=>'Image']) }}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="form-group">
            <?php
            $field_name = 'requirements';
            $field_lable = __("core::$module_name.$field_name");
            $field_placeholder = $field_lable;
            $required = "required";
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->textarea($field_name)->rows(10)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="form-group">
            <?php
            $field_name = 'additional_lines_payment';
            $field_lable = __("core::$module_name.$field_name");
            $field_placeholder = $field_lable;
            $required = "";
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->textarea($field_name)->rows(5)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="form-group">
            <?php
            $field_name = 'additional_lines_test';
            $field_lable = __("core::$module_name.$field_name");
            $field_placeholder = $field_lable;
            $required = "";
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->textarea($field_name)->rows(5)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-6">
        <div class="form-group">
            <?php
            $field_name = 'registration_veriform_link';
            $field_lable = __("core::$module_name.$field_name");
            $field_placeholder = $field_lable;
            $required = "";
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required", 'aria-label'=>'Image']) }}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-6">
        <div class="form-group">
            <?php
            $field_name = 'tuition_veriform_link';
            $field_lable = __("core::$module_name.$field_name");
            $field_placeholder = $field_lable;
            $required = "";
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required", 'aria-label'=>'Image']) }}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-6">
        <div class="form-group">
            <?php
            $field_name = 'entrance_test_url';
            $field_lable = __("core::$module_name.$field_name");
            $field_placeholder = $field_lable;
            $required = "";
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required", 'aria-label'=>'Image']) }}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-4">
        <div class="form-group float-left">
            <?php
            $field_name = 'have_major';
            $field_lable = __("core::$module_name.$field_name");
            $required = "";
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            @if($module_action == 'Edit')
                {{ html()->checkbox($field_name)->class('form-control float-left')->attributes(["$required"])->checked(old($field_name, $$module_name_singular->$field_name == true)) }}
            @else
                {{ html()->checkbox($field_name)->class('form-control float-left')->attributes(["$required"]) }}
            @endif
        </div>
    </div>
</div>

<div class="h3">Jalur Pendaftaran</div>
<div class="row">
    <?php
        $field_name = 'path';
        $field_lable = __("core::$module_name.$field_name");
        $field_placeholder = $field_lable;
        $field_value = $path_value ?? [];
        $required = "";
    ?>
    @foreach($path_options as $key => $path)
        <div class="col-sm-6 col-md-3 col-lg-2 m-2">
            <div class="form-group">
                    {{ html()->label($path)->class('float-center') }} {!! fielf_required($required) !!}
                    {{ html()->checkbox($field_name.'_'.strtolower($path), array_key_exists($key, $field_value) ? true : false, $key)->class('inline m-1 display-1')->attributes(["$required"]) }}
            </div>
        </div>
    @endforeach
</div>
<hr>

<h3>Biaya Default</h3>
<div class="row">
    <div class="col-3">
        <div class="form-group">
            <?php
            $field_name = 'dpp';
            $field_lable = __("core::$module_name.$field_name");
            $field_placeholder = $field_lable;
            $required = "";
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required", 'aria-label'=>'Image']) }}
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <?php
            $field_name = 'dp';
            $field_lable = __("core::$module_name.$field_name");
            $field_placeholder = $field_lable;
            $required = "";
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required", 'aria-label'=>'Image']) }}
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <?php
            $field_name = 'spp';
            $field_lable = __("core::$module_name.$field_name");
            $field_placeholder = $field_lable;
            $required = "";
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required", 'aria-label'=>'Image']) }}
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <?php
            $field_name = 'school_fee';
            $field_lable = __("core::$module_name.$field_name");
            $field_placeholder = $field_lable."(Kosongkan bila tidak ada)";
            $required = "";
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required", 'aria-label'=>'Image']) }}
        </div>
    </div>
</div>

<hr>
<h3>Biaya Per Jalur</h3>
@include('core::backend.units.unit-path-fee-form')
<hr>

<!-- <div class="h3">Angsuran</div>
<div class="row">
    <div class="col-4">
        <div class="form-group">
            <?php
            $field_name = 'installments';
            $field_data_id = 'installment_ids';
            $field_lable = __("registrant::$module_name.$field_name");
            $field_placeholder = "--Silakan Pilih Angsuran (bisa lebih dari satu)--";
            $required = "required";
            $select_options = $installment_options;
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->multiselect($field_data_id, $select_options)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
        </div>
    </div>
</div> -->

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
