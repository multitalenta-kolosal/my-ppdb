
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
            {{ html()->select($field_data_id, $select_options)->placeholder($field_placeholder)->class('form-control border-purple')->attributes(["$required"]) }}
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
            {{ html()->select($field_name, $select_options)->placeholder($field_placeholder)->class('form-control border-purple')->attributes(["$required"]) }}
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
            $field_placeholder = $field_lable." (Sesuai dengan akta kelahiran)";
            $required = "required";
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control border-purple')->attributes(["$required"]) }}
            <small>Pastikan nama sesuai dengan akta kelahiran</small>
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
            <small>Nomor telepon digunakan untuk penyampaian informasi melalui whatsapp</small>
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
            <small>Nomor telepon anak akan digunakan apabila nomor orang tua tidak dapat dijangkau saat kami akan menyampaikan informasi. Jika anak belum mempunyai nomor bisa diisi nomor orangtua.</small>
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
            <small>Email yang aktif di handphone</small>
        </div>
    </div>
    <div class="col-md-6 col-sm-6">
        <div class="form-group">
            <?php
            $field_name = 'email_2';
            $field_lable = __("registrant::$module_name.$field_name");
            $field_placeholder = $field_lable;
            $required = "required";
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->email($field_name)->placeholder($field_placeholder)->class('form-control border-purple')->attributes(["$required", 'aria-label'=>'Image']) }}
            <small>Jika anak belom memiliki email diisi sama dengan email orang tua</small>
        </div>
    </div>
    <div class="col-md-6 col-sm-6" id="former_school_group">
        <div class="form-group">
            <?php
            $field_name = 'former_school';
            $field_data_id = 'former_school';
            $field_lable = __("registrant::$module_name.$field_name");
            $field_placeholder = $field_lable;
            $required = "";
            ?>
            {{ html()->label($field_lable, $field_name) }} <span class="text-danger" id="{{$field_name}}-required">*</span>
            {{ html()->select($field_name, null)->placeholder($field_placeholder)->class('select2 form-control')->attributes(["$required"]) }}
            <!-- {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control border-purple')->attributes(["$required", 'aria-label'=>'Image']) }}     -->
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
</div>
<div class="row">
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
<x-library.select2 />

@push('after-styles')
<!-- File Manager -->
<style>
    .select2-selection{
        border: 1px solid #8965e0 !important;
        height: calc(1.5rem + 1.4rem) !important;
        border-radius: 0.5rem !important;
    }
</style>
@endpush

@push ('after-scripts')
<script>
    $(document).ready(function() {
        var unitOptions = $('#unit_id option'); // Select all option elements
        var unitObject = {};
        var correspondUnit = {
            "KB/TK" : undefined,
            "SD" : undefined,
            "SMP" : "SD",
            "SMA" : "SMP",
            "SMK" : "SMP"
        };
        var optionalFormer = [
            "KB/TK",
            "SD"
        ];
        var hideFormer = [
            "KB/TK",
            "SD"
        ];

        if({{ app('request')->filled('ref') == '' ? 'false' : 'true'}}){
            $('#success-ref').html("Referal telah aktif!");
            $('#success-ref').addClass("text-success");
        }

        $('#unit_id').on('change', function(){
            var unit_split = $('#unit_id').find(":selected").text().split(" ");

            if (optionalFormer.includes(unit_split[0])) {
                $('#former_school').removeAttr('required');
                $('#former_school-required').hide();
            }else{
                $('#former_school').attr('required');
                $('#former_school-required').show();
            }

            if (hideFormer.includes(unit_split[0])) {
                $('#former_school_group').hide();
            }else{
                $('#former_school_group').show();
            }

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
                            if(val.toLowerCase() == "istimewa"){
                                var newOption = $('<option class="font-weight-bold" value="'+key+'">'+val+'</option>');
                            }
                            $('#type').append(newOption);
                        });

                        $.each(response.path,function(key, val) {
                            if(val.toLowerCase() != "istimewa"){
                                var newOption = $('<option value="'+key+'">'+val+'</option>');
                            }
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
                var defaultOption = $('<option value="">--Silakan Pilih Sekolah Dahulu--</option>');
                $('#type').append(defaultOption);
            }
        });

        $(document).ready(function() {

            unitOptions.each(function() {
                var key = $(this).val();   // Get the value attribute
                var value = $(this).text(); // Get the text content
                
                unitObject[key] = value;    // Assign the value to the dynamic key
            });

            former_school_config = {
                theme: "bootstrap",
                placeholder: '@lang("Select an option")',
                minimumInputLength: 2,
                allowClear: true,
                ajax: {
                    url : 'https://api-sekolah-indonesia.vercel.app/sekolah/s',
                    dataType: 'json',
                    data: function (params) {
                        return {
                            sekolah: $.trim(params.term),
                            perPage: 100
                        };
                    },
                    processResults: function (data) {
                        raw_data_sekolah = data.dataSekolah;
                        var unit_raw = unitObject[$('#unit_id').val()];
                        var unit_split = unit_raw.split(" ");

                        var filteredSchools = raw_data_sekolah.filter(function(sekolah) {
                        return sekolah.bentuk == correspondUnit[unit_split[0]];
                        });
                    
                        return {
                            results: filteredSchools.map(function(sekolah) {
                                return {
                                    id: sekolah.sekolah+", "+sekolah.kabupaten_kota,
                                    text: sekolah.sekolah+", "+sekolah.kabupaten_kota,
                                };
                            })
                        };
                    },
                    cache: true
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
            };

            $('#former_school').select2(former_school_config);
        });

        function splitUnitDropdown(){
            var unitOptions = $('#unit_id option'); // Select all option elements
            var unitArray = [];

            unitOptions.each(function() {
                var key = $(this).val(); // Get the value attribute
                var value = $(this).text(); // Get the text content
                unitArray.push({ key: key, value: value });
            });
        }
        // $('#former_school').select2({
        //     theme: "bootstrap",
        //     placeholder: '@lang("Select an option")',
        //     minimumInputLength: 3,
        //     allowClear: true,
        //     tags: true,
        //     ajax: {
        //         url : 'https://api-sekolah-indonesia.adaptable.app',
        //         dataType: 'json',
        //         headers: {
        //             accept: "application/json",
        //         },
        //         data: function (params) {
        //             return {
        //                 keyword: $.trim(params.term),
        //                 perPage: 100
        //             };
        //         },
        //         processResults: function (data) {
        //             console.log(data);
        //             return {
        //                 results: data.map(function(sekolah) {
        //                     return {
        //                         id: sekolah.nama_sekolah+", "+sekolah.kabupaten,
        //                         text: sekolah.nama_sekolah+", "+sekolah.kabupaten,
        //                     };
        //                 })
        //             };
        //         },
        //         cache: true,
        //     },
        //     createTag: function (params) {
        //         var term = $.trim(params.term);

        //         if (term === '') {
        //         return null;
        //         }

        //         return {
        //             id: term,
        //             text: term,
        //             newTag: true // add additional parameters
        //         }
        //     }
        // });


        $('#unit_id').on('change', function(){
            $('#scheme_tenor').empty();
            var unit_id = $('#unit_id').val();
            tier_id = 0;
            if(unit_id){
                $.ajax({
                    type: "GET",
                    url: '/getunitfee/' + unit_id + '/' + tier_id,
                    beforeSend: function () {
                        var loader = $('<option value="xloader">Loading...</option>');
                        $('#scheme_tenor').append(loader);
                    },
                    complete: function () {
                        $("#scheme_tenor option[value='xloader']").remove();
                    },
                    success: function (response) {
                        var defaultOption = $('<option value="">-- Pilih --</option>');
                        $('#scheme_tenor').append(defaultOption);
                        
                        $.each(response.fees,function(key, val) {
                            var newOption = $('<option value="'+key+'">'+val+'</option>');
                            $('#scheme_tenor').append(newOption);
                        });

                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        Swal.fire("Silakan coba lagi beberapa saat", "@lang('error')", "error");
                    }
                });
            }else{
                var defaultOption = $('<option value="">--Silakan Pilih Sekolah Dahulu--</option>');
                $('#scheme_tenor').append(defaultOption);
            }
        });


        $('#tier_id').on('change', function(){
            $('#scheme_tenor').empty();
            var unit_id = $('#unit_id').val();
            var tier_id = $('#tier_id').val();
            if(unit_id){
                if(unit_id){
                    $.ajax({
                        type: "GET",
                        url: '/getunitfee/' + unit_id + '/' + tier_id,
                        beforeSend: function () {
                            var loader = $('<option value="xloader">Loading...</option>');
                            $('#scheme_tenor').append(loader);
                        },
                        complete: function () {
                            $("#scheme_tenor option[value='xloader']").remove();
                        },
                        success: function (response) {
                            var defaultOption = $('<option value="">-- Pilih --</option>');
                            $('#scheme_tenor').append(defaultOption);
                            
                            $.each(response.fees,function(key, val) {
                                var newOption = $('<option value="'+key+'">'+val+'</option>');
                                $('#scheme_tenor').append(newOption);
                            });

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
        });

    });

</script>
@endpush
