<input name="is_backoffice" type="hidden" value="1">
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
            $select_options = [];
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->select($field_name, $select_options)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
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
                @if($module_action != 'Edit' && is_same_period() )
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
    <div class="col-md-6 col-sm-6">
        <div class="form-group">
            <?php
            $field_name = 'former_school';
            $field_data_id = 'former_school';
            $field_lable = __("registrant::$module_name.$field_name");
            $field_placeholder = $field_lable;
            $required = "";
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control border-purple')->attributes(["$required", 'aria-label'=>'Image']) }}    
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <?php
            $field_name = 'installment';
            $field_data_id = 'scheme_tenor';
            $field_lable = __("registrant::$module_name.$field_name");
            $field_placeholder = "-- Silakan memilih unit terlebih dahulu --";
            $required = "required";
            $select_options = [];
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->select($field_data_id, $select_options)->placeholder($field_placeholder)->class('form-control border-purple')->attributes(["$required"]) }}
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <?php
            $field_name = 'info';
            $field_data_id = 'info';
            $field_lable = __("registrant::$module_name.$field_name");
            $field_placeholder = __("Select an option");
            $required = "required";
            $register_infos = explode(",",setting('register_info'));

            $select_options = [];
            foreach($register_infos as $register_info){
                $select_options[$register_info] = $register_info;
            }
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->select($field_data_id, $select_options)->placeholder($field_placeholder)->class('form-control border-purple')->attributes(["$required"]) }}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <?php
            $field_name = 'tag_color';
            $field_data_id = 'tag_color';
            $field_lable = __("registrant::$module_name.$field_name");
            $field_placeholder = $field_lable;
            $required = "";

            // compose select options
            $tags = config('tag-color.code');
            $tagsName = config('tag-color.name');
            $select_options = [];

            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}<i class="fas fa-lg fa-circle" style="color:{{$tags[$registrant->tag_color ?? 0]}}"></i>
            <select name="{{$field_name}}" class="form-control">
                @foreach($tags as $key=>$tag)
                    <option value="{{$key}}" style="color:{{$tag}}" ><i class="fas fa-lg fa-circle"></i>{{strtoupper($tagsName[$key])}}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <?php
            $field_name = 'has_scholarship';
            $field_data_id = 'has_scholarship';
            $field_lable = __("registrant::$module_name.$field_name");
            $field_placeholder = $field_lable;
            $required = "";
            $select_options = [0=>"tidak",1=>"ya"];
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->select($field_data_id, $select_options)->placeholder($field_placeholder)->class('form-control border-purple')->attributes(["$required"]) }}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <?php
            $field_name = 'scholarship_amount';
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
    resetTypeTier();
    resetScheme();
});

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

    $('#unit_id').on('change', function(){
        resetTypeTier();
        resetScheme();
    });

    $('#tier_id').on('change', function(){
        resetScheme();
    });

    $('#type').on('change', function(){
        resetScheme();
    });

    $('#former_school').select2({
        theme: "bootstrap",
        placeholder: '@lang("Select an option")',
        minimumInputLength: 3,
        allowClear: true,
        tags: true,
        ajax: {
            url : 'https://api-sekolah-indonesia.adaptable.app',
            dataType: 'json',
            headers: {
                accept: "application/json",
            },
            data: function (params) {
                return {
                    keyword: $.trim(params.term),
                    perPage: 100
                };
            },
            processResults: function (data) {
                console.log(data);
                return {
                    results: data.map(function(sekolah) {
                        return {
                            id: sekolah.nama_sekolah+", "+sekolah.kabupaten,
                            text: sekolah.nama_sekolah+", "+sekolah.kabupaten,
                        };
                    })
                };
            },
            cache: true,
        },
        createTag: function (params) {
            var term = $.trim(params.term);

            if (term === '') {
            return null;
            }

            return {
                id: term,
                text: term,
                newTag: true // add additional parameters
            }
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

function resetTypeTier(){
    $('#type').empty();
    var unit_id = $('#unit_id').val();
    if(unit_id){
        $.ajax({
            type: "GET",
            url: '{{route("frontend.units.getunitopt",'')}}'+'/'+unit_id,
            beforeSend: function () {
                var loader = $('<option value="0">Loading...</option>');
                $('#type').append(loader);
            },
            complete: function () {
                $("#type option[value='0']").remove();
            },
            success: function (response) {
                var defaultOption = $('<option value="">-- Pilih --</option>');
                $('#type').append(defaultOption);
                
                $.each(response.path,function(key, val) {
                    var newOption = $('<option value="'+key+'">'+val+'</option>');
                    $('#type').append(newOption);
                });

                $('#type').val("{{$registrant->type ?? ''}}");

                if(response.tier){
                    $('#tier_id').empty();
                    $('#tier_options').show();
                    $('#tier_id').attr('required');

                    var defaultOption = $('<option value="">-- Pilih --</option>');
                    $('#tier_id').append(defaultOption);
                    $.each(response.tier,function(key, val) {
                        var newOption = $('<option value="'+key+'">'+val+'</option>');
                        $('#tier_id').append(newOption);
                    });

                    $('#tier_id').val("{{$registrant->tier_id ?? ''}}");
                }else{
                    $('#tier_id').empty();
                    $('#tier_options').hide();
                    $('#tier_id').removeAttr('required');

                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                Swal.fire("Silakan coba lagi beberapa saat", "@lang('error')", "error");
            }
        });
    }else{
        var defaultOption = $('<option value="">--Silakan Pilih Sekolah Dahulu--</option>');
        $('#type').append(defaultOption);
    }
}

function resetScheme(){
    $('#scheme_tenor').empty();
    var unit_id = $('#unit_id').val();
    var tier_id = $('#tier_id').val();
    var path_id = $('#type').val();
    if(tier_id == null || tier_id == ""){
        tier_id = 0;
    }
    if(unit_id){
        if(unit_id){
            $.ajax({
                type: "GET",
                url: '/getunitfee/' + path_id + '/' + unit_id + '/' + tier_id,
                beforeSend: function () {
                    var loader = $('<option value="0">Loading...</option>');
                    $('#scheme_tenor').append(loader);
                },
                complete: function () {
                    $("#scheme_tenor option[value='0']").remove();
                },
                success: function (response) {
                    var defaultOption = $('<option value="">-- Pilih --</option>');
                    $('#scheme_tenor').append(defaultOption);
                    
                    $.each(response.fees,function(key, val) {
                        var newOption = $('<option value="'+key+'">'+val+'</option>');
                        $('#scheme_tenor').append(newOption);
                    });

                    $('#scheme_tenor').val("{{$registrant->scheme_tenor ?? ''}}");

                },
                error: function (xhr, ajaxOptions, thrownError) {
                    Swal.fire("Silakan coba lagi beberapa saat", "@lang('error')", "error");
                }
            });
        }
    }else{
        var defaultOption = $('<option value="">--Silakan Pilih Sekolah Dahulu--</option>');
        $('#scheme_tenor').append(defaultOption);
    }
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
