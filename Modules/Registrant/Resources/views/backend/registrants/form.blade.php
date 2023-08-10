
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <?php
            $field_name = 'unit';
            $field_data_id = 'unit_id';
            $field_lable = __("registrant::$module_name.$field_name");
            $field_placeholder = __("Select an option");
            $required = "required";
            $disabled = $module_action == 'Edit' ? 'disabled' : '';
            $select_options = $unit;

            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->select($field_data_id, $select_options)->placeholder($field_placeholder)->class('form-control select2')->attributes(["$required",$disabled]) }}
            @if($module_action == 'Edit')
                <!-- for submit selection when editing -->
                {{ html()->select($field_data_id, $select_options)->placeholder($field_placeholder)->class('form-control d-none')->attributes(["$required"]) }}
            @endif
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <?php
            $field_name = 'type';
            $field_lable = __("registrant::$module_name.$field_name");
            $field_placeholder = __("Select an option");
            $required = "required";
            $select_options = $type ?? [];
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->select($field_name, $select_options)->placeholder($field_placeholder)->class('form-control select2')->attributes(["$required"]) }}
            @if($module_action == 'Edit')
                <small id="nowPath" class="form-text text-muted">Jurusan pendaftar saat ini: <span class="text-primary">{{$registrant->path->name}}</span></small>      
            @endif
        </div>
    </div>
    <div class="col-md-4 d-none" id="tier_options">
        <div class="form-group">
            <?php
            $field_name = 'tier';
            $field_data_id = 'tier_id';
            $field_lable = __("registrant::$module_name.$field_name");
            $field_placeholder = __("Select an option");
            $required = "";
            $select_options = $tier ?? [];
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->select($field_data_id, $select_options)->placeholder($field_placeholder)->class('form-control select2')->attributes(["$required"]) }}
            @if($module_action == 'Edit')    
                <small id="nowTier" class="form-text text-muted">Kelas/Jurusan pendaftar saat ini: <span class="text-primary">{{$registrant->tier->tier_name}}</span></small>      
            @endif
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="form-group">
            <?php
            $field_name = 'name';
            $field_lable = __("registrant::$module_name.$field_name");
            $field_placeholder = $field_lable;
            $required = "required";
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <?php
            $field_name = 'registrant_id';
            $field_lable = __("registrant::$module_name.$field_name");
            $field_placeholder = $field_lable;
            $required = "required";
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            <div class="input-group mb-3">
                {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required", 'aria-label'=>'Image', 'aria-describedby'=>'button-generate-id']) }}
                @if($module_action != 'Edit')
                    <div class="input-group-append">
                        <button class="btn btn-info" type="button" id="button-generate-id"><i class="fas fa-sync"></i> @lang('Generate')</button>
                    </div>
                @endif
            </div>            
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <?php
            $field_name = 'va_number';
            $field_lable = __("registrant::$module_name.$field_name");
            $field_placeholder = $field_lable;
            $required = "";
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <?php
            $field_name = 'phone';
            $field_lable = __("registrant::$module_name.$field_name");
            $field_placeholder = $field_lable;
            $required = "required";
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required", 'aria-label'=>'Image']) }}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <?php
            $field_name = 'phone2';
            $field_lable = __("registrant::$module_name.$field_name");
            $field_placeholder = $field_lable;
            $required = "";
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required", 'aria-label'=>'Image']) }}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <?php
            $field_name = 'email';
            $field_lable = __("registrant::$module_name.$field_name");
            $field_placeholder = $field_lable;
            $required = "";
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->email($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required", 'aria-label'=>'Image']) }}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <?php
            $field_name = 'email_2';
            $field_lable = __("registrant::$module_name.$field_name");
            $field_placeholder = $field_lable;
            $required = "";
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->email($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required", 'aria-label'=>'Image']) }}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <?php
            $field_name = 'former_school';
            $field_lable = __("registrant::$module_name.$field_name");
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
            $field_name = 'notes';
            $field_lable = __("registrant::$module_name.$field_name");
            $field_placeholder = $field_lable;
            $required = "";
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->textarea($field_name)->rows(10)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
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

<script type="text/javascript" src="{{ asset('vendor/ckeditor/ckeditor.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/file-manager/js/file-manager.js') }}"></script>

<script type="text/javascript">

// set file link
function fmSetLink($url) {
  document.getElementById('featured_image').value = $url;
}

$(document).ready(function(){
    $('#button-generate-va').attr('disabled',);

    $("#button-generate-id").on("click", function (event) {
        var unit_id = $("#unit_id option:selected").val().toString();
        var generateUrl = '{!! route("backend.registrants.generateId") !!}';
        var va_prefix = "{{setting('va_prefix')}}";
        $.ajax({
            method: "POST",
            url: generateUrl,
            data:{
                "unit_id" : unit_id,
                "_token": "{{ csrf_token() }}"
            },
            success: function (data) {
                $('#registrant_id').val(data.id);
                $('#va_number').val(va_prefix+data.id);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                Swal.fire("@lang('error')", "@lang('select unit first')", "error");
            }
        });
    });

    // $(document).ready(function() {
    //     if($('#unit_id').val() != ""){
    //         setTier();
    //         $('#unit_id').trigger('change');
    //     }
    // });
});
</script>

@endpush
