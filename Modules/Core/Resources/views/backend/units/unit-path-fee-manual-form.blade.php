<div class="card">
    <div class="card-header">
        <h5>Angsuran SPM Jalur {{$path}}</h5>
    </div>
    <div class="card-body">
        <div class="row">
            @foreach(config('tenor.list') as $value)
            <div class="col">
                <div class="form-group">
                    <?php
                    $field_name = $value;
                    $field_lable = "Angsuran x".$value;
                    $field_placeholder = $field_lable;
                    $required = "";
                    ?>
                    {{ html()->label($field_lable, $field_name)->class('font-weight-bold') }} {!! fielf_required($required) !!}
                </div>
                <div class="row">
                    @for ($i = 1; $i <=$value; $i++)
                        <div class="form-group">
                            <?php
                            $field_name = 'path-feeManual-'.$key.'-'.$value.'-'.$i.'-'.'school_fee';
                            $field_lable = 'payment '.$i;
                            $field_placeholder = $field_lable;
                            $required = "";
                            ?>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">Rp.</span>
                                </div>
                                {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
                            </div>
                        </div>
                    @endfor
                </div>
            </div>
            @endforeach
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
