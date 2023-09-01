
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
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            <select name="{{$field_name}}" class="form-control">
                @foreach($tags as $key=>$tag)
                    <option value="{{$key}}" style="color:{{$tag}}" ><i class="fas fa-lg fa-circle"></i>{{strtoupper($tagsName[$key])}}</option>
                @endforeach
            </select>
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
