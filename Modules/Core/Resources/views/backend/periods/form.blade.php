<div class="row">
    <div class="col-4">
        <div class="form-group float-left">
            <?php
            $field_name = 'active_state';
            $field_lable = __("core::$module_name.$field_name");
            $helper = __("core::$module_name.$field_name"."_helper",['active_period' => $nowActivePeriod->period_name ?? 'NULL']);
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
<div class="row">
    {{ html()->div($helper)->class('d-block mx-3 mb-3') }}
</div>
<div class="row">
    <div class="col">
        <div class="form-group">
            <?php
            $field_name = 'period_name';
            $field_lable = __("core::$module_name.$field_name");
            $field_placeholder = \Carbon\Carbon::now()->format('Y').'/'.\Carbon\Carbon::now()->addYears(1)->format('Y');
            $required = "required";
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-6">
        <div class="form-group">
            <?php
            $field_name = 'year_start';
            $field_lable = __("core::$module_name.$field_name");
            $field_placeholder = \Carbon\Carbon::now()->format('Y');
            $required = "required";
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required", 'aria-label'=>'Image']) }}
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <?php
            $field_name = 'year_end';
            $field_lable = __("core::$module_name.$field_name");
            $field_placeholder = \Carbon\Carbon::now()->addYears(1)->format('Y');
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
            $field_name = 'opening_date';
            $field_lable = __("core::$module_name.$field_name");
            $field_placeholder = $field_lable;
            $required = "";
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            <div class="input-group date datetime" id="{{$field_name}}" data-target-input="nearest">
                {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control datetimepicker-input')->attributes(["$required", 'data-target'=>"#$field_name"]) }}
                <div class="input-group-append" data-target="#{{$field_name}}" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <?php
            $field_name = 'closing_date';
            $field_lable = __("core::$module_name.$field_name");
            $field_placeholder = $field_lable;
            $required = "";
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            <div class="input-group date datetime" id="{{$field_name}}" data-target-input="nearest">
                {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control datetimepicker-input')->attributes(["$required", 'data-target'=>"#$field_name"]) }}
                <div class="input-group-append" data-target="#{{$field_name}}" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-4">
        <div class="form-group">
            <?php
            $field_name = 'wave_1';
            $field_lable = __("core::$module_name.$field_name");
            $field_placeholder = $field_lable;
            $required = "";
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            <div class="input-group date datetime" id="{{$field_name}}" data-target-input="nearest">
                {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control datetimepicker-input')->attributes(["$required", 'data-target'=>"#$field_name"]) }}
                <div class="input-group-append" data-target="#{{$field_name}}" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <?php
            $field_name = 'wave_2';
            $field_lable = __("core::$module_name.$field_name");
            $field_placeholder = $field_lable;
            $required = "";
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            <div class="input-group date datetime" id="{{$field_name}}" data-target-input="nearest">
                {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control datetimepicker-input')->attributes(["$required", 'data-target'=>"#$field_name"]) }}
                <div class="input-group-append" data-target="#{{$field_name}}" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <?php
            $field_name = 'wave_3';
            $field_lable = __("core::$module_name.$field_name");
            $field_placeholder = $field_lable;
            $required = "";
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            <div class="input-group date datetime" id="{{$field_name}}" data-target-input="nearest">
                {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control datetimepicker-input')->attributes(["$required", 'data-target'=>"#$field_name"]) }}
                <div class="input-group-append" data-target="#{{$field_name}}" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                </div>
            </div>
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
    <div class="col-4">
        <div class="form-group">
            <?php
            $field_name = 'quota';
            $field_lable = __("core::$module_name.$field_name");
            $field_placeholder = $field_lable;
            $field_value = $quota_value ?? [];
            $required = "";
            ?>
            @foreach($units as $key => $unit)
                {{ html()->label($field_lable.' '.$unit, $field_name) }} {!! fielf_required($required) !!}
                {{ html()->text($field_name.'_'. $unit,$field_value["quota_".$unit] ?? null)->placeholder($field_placeholder.' '.$unit)->class('form-control mb-2')->attributes(["$required", 'aria-label'=>'Image']) }}
            @endforeach
        </div>
    </div>
</div>

<div></div>


<!-- Select2 Library -->
<x-library.select2 />
<x-library.datetime-picker />

@push('after-styles')
<!-- File Manager -->
<link rel="stylesheet" href="{{ asset('vendor/file-manager/css/file-manager.css') }}">
@endpush

@push ('after-scripts')
<script type="text/javascript">
$(document).ready(function() {
    $('.select2-category').select2({
        theme: "bootstrap",
        placeholder: '@lang("Select an option")',
        minimumInputLength: 2,
        allowClear: true,
        ajax: {
            url: '{{route("backend.categories.index_list")}}',
            dataType: 'json',
            data: function (params) {
                return {
                    q: $.trim(params.term)
                };
            },
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: true
        }
    });

    $('.select2-tags').select2({
        theme: "bootstrap",
        placeholder: '@lang("Select an option")',
        minimumInputLength: 2,
        allowClear: true,
        ajax: {
            url: '{{route("backend.tags.index_list")}}',
            dataType: 'json',
            data: function (params) {
                return {
                    q: $.trim(params.term)
                };
            },
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: true
        }
    });
});
</script>

<!-- Date Time Picker & Moment Js-->
<script type="text/javascript">
$(function() {
    $('.datetime').datetimepicker({
        format: 'YYYY-MM-DD',
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

@endpush
