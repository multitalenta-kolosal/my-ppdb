
<div class="row">
    <div class="col-6">
        <div class="form-group">
            <?php
            $field_name = 'unit';
            $field_data_id = 'unit_id';
            $field_lable = __("registrant::$module_name.$field_name");
            $field_placeholder = __("Select an option");
            $required = "required";
            $select_options = $unit_options;
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->select($field_data_id, $select_options)->placeholder($field_placeholder)->class('form-control select2 border-purple')->attributes(["$required"]) }}
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <?php
            $field_name = 'type';
            $field_lable = __("registrant::$module_name.$field_name");
            $field_placeholder = "-- Silakan memilih unit terlebih dahulu --";
            $required = "required";
            $select_options = [];
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->select($field_name, $select_options)->placeholder($field_placeholder)->class('form-control select2 border-purple')->attributes(["$required"]) }}
        </div>
    </div>
</div>
<div class="row">
    <div class="col d-none" id="tier_options">
        <div class="form-group">
            <?php
            $field_name = 'tier';
            $field_data_id = 'tier_id';
            $field_lable = __("registrant::$module_name.$field_name");
            $field_placeholder = __("Select an option");
            $required = "";
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->select($field_data_id, $select_options)->placeholder($field_placeholder)->class('form-control border-purple')->attributes(["$required"]) }}
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
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control border-purple')->attributes(["$required"]) }}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6 col-sm-6">
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
    <div class="col-md-6 col-sm-6">
        <div class="form-group">
            <?php
            $field_name = 'phone2';
            $field_lable = __("registrant::$module_name.$field_name");
            $field_placeholder = $field_lable;
            $required = "";
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control border-purple')->attributes(["$required", 'aria-label'=>'Image']) }}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6 col-sm-6">
        <div class="form-group">
            <?php
            $field_name = 'email';
            $field_lable = __("registrant::$module_name.$field_name");
            $field_placeholder = $field_lable;
            $required = "required";
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->email($field_name)->placeholder($field_placeholder)->class('form-control border-purple')->attributes(["$required", 'aria-label'=>'Image']) }}
        </div>
    </div>
    <div class="col-md-6 col-sm-6">
        <div class="form-group">
            <?php
            $field_name = 'former_school';
            $field_lable = __("registrant::$module_name.$field_name");
            $field_placeholder = $field_lable;
            $required = "";
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control border-purple')->attributes(["$required", 'aria-label'=>'Image']) }}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <?php
            $field_name = 'ref_code';
            $field_lable = __("registrant::$module_name.$field_name");
            $field_placeholder = $field_lable." Jika Ada";
            $required = "";
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->text($field_name, app('request')->input('ref') ?? '')->placeholder($field_placeholder)->class('form-control border-purple')->attributes(["$required", 'aria-label'=>'Image']) }}
            <span id="success-ref"></span>
        </div>
    </div>
</div>

<div></div>


<!-- Select2 Library -->
<x-library.datetime-picker />

@push('after-styles')
<!-- File Manager -->
@endpush

@push ('after-scripts')
<script>
    $(document).ready(function() {
        if({{ app('request')->filled('ref') == '' ? 'false' : 'true'}}){
            $('#success-ref').html("Referal telah aktif!");
            $('#success-ref').addClass("text-success");
        }

        $('#unit_id').on('change', function(){
            $('#type').empty();
            var unit_id = $('#unit_id').val();
            if(unit_id){
                $.ajax({
                    type: "GET",
                    url: '{{route("frontend.units.getunitopt",'')}}'+'/'+unit_id,
                    beforeSend: function () {
                        var loader = $('<option value="xloader">Loading...</option>');
                        $('#type').append(loader);
                    },
                    complete: function () {
                        $("#type option[value='xloader']").remove();
                    },
                    success: function (response) {
                        var defaultOption = $('<option value="">-- Pilih --</option>');
                        $('#type').append(defaultOption);
                        
                        $.each(response.path,function(key, val) {
                            var newOption = $('<option value="'+key+'">'+val+'</option>');
                            $('#type').append(newOption);
                        });


                        if(response.tier){
                            $('#tier_id').empty();
                            $('#tier_options').removeClass('d-none');

                            var defaultOption = $('<option value="">-- Pilih --</option>');
                            $('#tier_id').append(defaultOption);
                            $.each(response.tier,function(key, val) {
                                var newOption = $('<option value="'+key+'">'+val+'</option>');
                                $('#tier_id').append(newOption);
                            });
                        }else{
                            $('#tier_id').empty();
                            $('#tier_options').addClass('d-none');
                        }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        Swal.fire("Silakan coba lagi beberapa saat", "@lang('error')", "error");
                    }
                });
            }else{
                var defaultOption = $('<option value="">--Silakan Pilih Unit Dahulu--</option>');
                $('#type').append(defaultOption);
            }
        });
    });
</script>
@endpush
