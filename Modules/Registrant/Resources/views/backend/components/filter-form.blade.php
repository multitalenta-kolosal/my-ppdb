<div class="row"> 
    <div class="col">
            <div class="form-group">
                <?php
                $field_name = 'name';
                $field_lable = "Nama";
                $field_placeholder = "";
                $required = "";
                ?>
                {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
                {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
            </div>
    </div>
</div>
<div class="row"> 
    <div class="col-md-6">
        <!-- Unit -->
        @can('inter_unit')
            <div class="row"> 
                <div class="col">
                    <div class="form-group">
                        <?php
                        $field_name = 'unit_name';
                        $field_lable = "Nama Unit";
                        $field_placeholder = "Masukkan nama unit";
                        $required = "";
                        $select_options = $unit;
                        ?>
                        {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
                        {{ html()->select($field_name, $select_options)->placeholder($field_placeholder)->class('form-control select2') }}
                    </div>
                </div>
            </div>
        @endcan
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <?php
                    $field_name = 'path';
                    $field_lable = "Jalur Pendaftaran";
                    $field_placeholder = "";
                    $required = "";
                    $select_options = $type;
                    ?>
                    {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
                    {{ html()->select($field_name, $select_options)->placeholder($field_placeholder)->class('form-control select2') }}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <?php
                    $field_name = 'tier';
                    $field_lable = "Nama Jurusan / Kelas";
                    $field_placeholder = "";
                    $required = "";
                    $select_options = $tier;
                    ?>
                    {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
                    {{ html()->select($field_name, $select_options)->placeholder($field_placeholder)->class('form-control select2') }}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <?php
                    $field_name = 'phone';
                    $field_lable = "Telepon";
                    $field_placeholder = "";
                    $required = "";
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
                    $field_lable = "Email";
                    $field_placeholder = "";
                    $required = "";
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
                    $field_name = 'former_school';
                    $field_lable = "Asal Sekolah";
                    $field_placeholder = "";
                    $required = "";
                    ?>
                    {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
                    {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <?php
                    $field_name = 'start_month';
                    $field_lable = "Month";
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
            <div class="col">
                <div class="form-group">
                    <?php
                    $field_name = 'status';
                    $field_lable = "status peserta";
                    $field_placeholder = "";
                    $required = "";
                    $select_options = $status
                    ?>
                    {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
                    {{ html()->select($field_name, $select_options)->placeholder($field_placeholder)->class('form-control select2') }}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <?php
                    $field_name = 'installment';
                    $field_lable = "Angsuran Peserta";
                    $field_placeholder = "";
                    $required = "";
                    $select_options = ["1"=>"1","3"=>"3","6"=>"6"];
                    ?>
                    {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
                    {{ html()->select($field_name, $select_options)->placeholder($field_placeholder)->class('form-control select2') }}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-5">
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
                        <option value="" style="" ><i class="fas fa-lg fa-circle"></i>--Pilih--</option>
                        @foreach($tags as $key=>$tag)
                            <option value="{{$key}}" style="color:{{$tag}}" ><i class="fas fa-lg fa-circle"></i>{{strtoupper($tagsName[$key])}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <?php
                    $field_name = 'has_scholarship';
                    $field_lable = "Penerima Beasiswa?";
                    $field_placeholder = "";
                    $required = "";
                    $select_options = ["1" => "ya", "0" => "tidak"];
                    ?>
                    {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
                    {{ html()->select($field_name, $select_options)->placeholder($field_placeholder)->class('form-control select2') }}
                </div>
            </div>
        </div>
    </div>
</div>

@push('after-scripts')

    <x-library.datetime-picker />

    <!-- Date Time Picker & Moment Js-->
    <script type="text/javascript">
        $(function() {
            $('.datetime').datetimepicker({
                format: 'YYYY-MM',
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