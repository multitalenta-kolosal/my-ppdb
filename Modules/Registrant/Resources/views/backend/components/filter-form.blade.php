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
        @can('inter-unit')
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
            <div class="col-4">
                <div class="form-group">
                    <?php
                    $field_name = 'dpp_pass';
                    $field_lable = "DPP";
                    $field_placeholder = "Semua";
                    $select_options = [
                        "1"  => "Sudah",
                        "0"  => "Belum",
                    ];
                    ?>
                    {{ html()->label($field_lable, $field_name) }} 
                    {{ html()->select($field_name, $select_options)->placeholder($field_placeholder)->class('form-control') }}
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <?php
                    $field_name = 'dp_pass';
                    $field_lable = "DP";
                    $field_placeholder = "Semua";
                    $select_options = [
                        "1"  => "Sudah",
                        "0"  => "Belum",
                    ];
                    ?>
                    {{ html()->label($field_lable, $field_name) }} 
                    {{ html()->select($field_name, $select_options)->placeholder($field_placeholder)->class('form-control') }}
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <?php
                    $field_name = 'spp_pass';
                    $field_lable = "SPP";
                    $field_placeholder = "Semua";
                    $select_options = [
                        "1"  => "Sudah",
                        "0"  => "Belum",
                    ];
                    ?>
                    {{ html()->label($field_lable, $field_name) }} 
                    {{ html()->select($field_name, $select_options)->placeholder($field_placeholder)->class('form-control') }}
                </div>
            </div>
        </div>
    </div>
</div>