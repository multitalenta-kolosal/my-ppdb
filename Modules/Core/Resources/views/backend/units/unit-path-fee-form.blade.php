@foreach($path_options as $key => $path)
    <div class="card">
        <div class="card-body bg-light">
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <?php
                        $field_name = $path;
                        $field_lable = "Jalur ".$path;
                        $field_placeholder = $field_lable;
                        $required = "";
                        ?>
                        {{ html()->label($field_lable, $field_name)->class('h5 font-weight-bold') }} {!! fielf_required($required) !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-lg">
                    <div class="form-group">
                        <?php
                        $field_name = 'path-fee-'.$key.'-'.'school_fee';
                        $field_lable = 'SPM Default';
                        $field_placeholder = $field_lable;
                        $required = "";
                        ?>
                        {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
                        {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
                    </div>
                </div>
                <div class="col-12 col-lg">
                    <div class="form-group">
                        <?php
                        $field_name = 'path-fee-'.$key.'-'.'spp';
                        $field_lable = 'SPP Default';
                        $field_placeholder = $field_lable;
                        $required = "";
                        ?>
                        {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
                        {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
                    </div>
                </div>
                <div class="col-12 col-lg">
                    <div class="form-group">
                        <?php
                        $field_name = 'path-fee-'.$key.'-'.'use_credit_scheme';
                        $field_data_id = 'path-fee-'.$key.'-'.'use_credit_scheme';
                        $field_lable = 'Bisa dicicil?';
                        $required = "";
                        $select_options = [0=>"tidak",1=>"ya"];
                        ?>
                        {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
                        {{ html()->select($field_data_id, $select_options)->class('form-control border-purple')->attributes(["$required"]) }}
                    </div>
                </div>
                <div class="col-12 col-lg">
                    <div class="form-group">
                        <?php
                        $field_name = 'path-fee-'.$key.'-'.'enabled';
                        $field_data_id = 'path-fee-'.$key.'-'.'enabled';
                        $field_lable = 'Aktif?';
                        $required = "";
                        $select_options = [0=>"tidak",1=>"ya"];
                        ?>
                        {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
                        {{ html()->select($field_data_id, $select_options)->class('form-control border-purple')->attributes(["$required"]) }}
                    </div>
                </div>
            </div>
            @include('core::backend.units.unit-path-fee-manual-form')
        </div>
    </div>
@endforeach

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
