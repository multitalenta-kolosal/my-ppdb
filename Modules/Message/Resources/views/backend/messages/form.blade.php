<div class="row">
    <div class="col">
        <div class="form-group">
            <?php
            $field_name = 'code';
            $field_lable = __("message::$module_name.$field_name");
            $field_placeholder = $field_lable;
            $required = "required";
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="form-group">
            <?php
            $field_name = 'message';
            $field_lable = __("message::$module_name.$field_name");
            $field_placeholder = $field_lable;
            $required = "required";
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->textarea($field_name)->rows(15)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
        </div>
    </div>
</div>
<a class="btn btn-primary text-light m-1" id="button-clone">Tambah Variabel</a>
<div class="row">
    <?php
        $field_name = '';
        $key_field = 'rep-key';
        $val_field = 'rep-val';
        $placholder_key = 'Key';
        $placholder_val = 'Value';
        $required = "";
    ?>
    @if($module_action == 'Edit')
        <?php
            $rep_inputs = json_decode($message->replacement);
            $i = 1;
        ?>
        <div id="rep">
            @if($rep_inputs)
                @foreach($rep_inputs as $key => $value)
                    <div class="row m-1" id="rep-input">
                        <div class="col-4">
                                {{ html()->text($key_field.$i)->id($key_field.($i > 1 ? $i : ''))->value($key)->placeholder($placholder_key)->class('form-control m-1')->attributes(["$required"]) }}
                        </div>
                        <div class="col-4">
                                {{ html()->text($val_field.$i)->id($val_field.($i > 1 ? $i : ''))->value($value)->placeholder($placholder_val)->class('form-control m-1')->attributes(["$required"]) }}
                        </div>            
                    </div>
                    <?php
                        $i = $i+1;
                    ?>
                @endforeach
            @else
            <div id="rep">
                <div class="row m-1" id="rep-input">
                    <div class="col-4">
                            {{ html()->text($key_field)->id($key_field)->placeholder($placholder_key)->class('form-control m-1')->attributes(["$required"]) }}
                    </div>
                    <div class="col-4">
                            {{ html()->text($val_field)->id($val_field)->placeholder($placholder_val)->class('form-control m-1')->attributes(["$required"]) }}
                    </div>            
                </div>
            </div>
            @endif
        </div>
    @else
        <div id="rep">
            <div class="row m-1" id="rep-input">
                <div class="col-4">
                        {{ html()->text($key_field)->id($key_field)->placeholder($placholder_key)->class('form-control m-1')->attributes(["$required"]) }}
                </div>
                <div class="col-4">
                        {{ html()->text($val_field)->id($val_field)->placeholder($placholder_val)->class('form-control m-1')->attributes(["$required"]) }}
                </div>            
            </div>
        </div>
    @endif
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

var input_id = {{$i ?? 1}};
 $('#button-clone').click(function() {
        console.log(input_id);
        $('#rep-input').clone().appendTo('#rep').prop('id', 'rep-input' + input_id);
        $('#rep-input'+input_id).find('#rep-key').prop('id', 'rep-key' + input_id).prop('name', 'rep-key' + input_id).val('');
        $('#rep-input'+input_id).find('#rep-val').prop('id', 'rep-val' + input_id).prop('name', 'rep-val' + input_id).val('');
        input_id++; 
 });
</script>

@endpush
