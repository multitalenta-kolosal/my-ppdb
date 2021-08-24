<div class="row">
    <div class="col">
        <div class="form-group shadow p-2 mb-2 bg-white rounded">
            <?php
            $field_name = 'va_pass';
            $field_info = 'va_number';
            $field_lable = __("registrant::$module_name.$module_sub.$field_name");
            $field_placeholder = $field_lable;
            $required = "";
            $checked = ( ($data->registrant_stage->$field_name ?? 'nope') == '1' ) ? 'checked' : '';
            ?>
            <div class="row">
                <div class="col-5 text-right align-self-center">
                    {{ html()->div($field_lable, $field_name) }} {!! fielf_required($required) !!}
                </div>
                <div class="col-3 align-self-center">
                    {{ $data->$field_info ?? 'BELUM DIBUAT' }}
                </div>
                <div class="col-2">
                    @can('add_va')
                        {{ html()->checkbox($field_name.$data->id)->class('form-control float-left')->attributes(["$required", "$checked"]) }}
                    @endcan
                </div>
                <div class="col-2 align-self-center text-success"  id="col_{{$field_name}}_{{$data->id}}">
                    @if($data->registrant_stage)
                        @if($data->registrant_stage->$field_name)
                            <i class="far fa-lg fa-check-circle"></i>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="form-group shadow p-2 mb-2 bg-white rounded">
            <?php
            $field_name = 'entrance_fee_pass';
            $field_info = 'entrance_fee';
            $field_lable = __("registrant::$module_name.$module_sub.$field_name");
            $field_placeholder = $field_lable;
            $required = "";
            $checked = ( ($data->registrant_stage->$field_name ?? 'nope') == '1' ) ? 'checked' : '';
            ?>
            <div class="row">
                <div class="col-5 text-right align-self-center">
                    {{ html()->div($field_lable, $field_name) }} {!! fielf_required($required) !!}
                </div>
                <div class="col-3 align-self-center">
                    {{ number_format($data->period->$field_info ?? 0 , 2, ',', '.')}}
                </div>
                <div class="col-2">
                    {{ html()->checkbox($field_name.$data->id)->class('form-control float-left')->attributes(["$required", "$checked"]) }}
                </div>
                <div class="col-2 align-self-center text-success" id="col_{{$field_name}}_{{$data->id}}">
                    @if($data->registrant_stage)
                        @if($data->registrant_stage->$field_name)
                            <i class="far fa-lg fa-check-circle"></i>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="form-group shadow p-2 mb-2 bg-white rounded">
            <?php
            $field_name = 'requirements_pass';
            $field_info = 'requirements';
            $field_lable = __("registrant::$module_name.$module_sub.$field_name");
            $field_placeholder = $field_lable;
            $required = "";
            $checked = ( ($data->registrant_stage->$field_name ?? 'nope') == '1' ) ? 'checked' : '';
            ?>
            <div class="row">
                <div class="col-5 text-right align-self-center">
                    {{ html()->div($field_lable, $field_name) }} {!! fielf_required($required) !!}
                </div>
                <div class="col-3 align-self-center">
                    <button type="button" class="btn btn-sm btn-info" 
                        data-toggle="popover" 
                        title="Persyaratan {{$data->unit->name ?? 'NO DATA'}}"
                        data-placement="bottom"
                        data-html="true"
                        data-trigger="focus" 
                        data-content= '<div>{!! $data->unit->$field_info  ?? "Persyaratan Kosong" !!}</div>'>
                            Lihat Persyaratan
                    </button>
                </div>
                <div class="col-2">
                    {{ html()->checkbox($field_name.$data->id)->class('form-control float-left')->attributes(["$required", "$checked"]) }}

                    {{ html()->label('kirim pesan', $field_name.$data->id.'_message') }}
                    {{ html()->checkbox($field_name.$data->id.'_message',false,'Kirim pesan')->class('my-auto form-check-label') }}             
                </div>
                <div class="col-2 align-self-center text-success" id="col_{{$field_name}}_{{$data->id}}">
                    @if($data->registrant_stage)
                        @if($data->registrant_stage->$field_name)
                            <i class="far fa-lg fa-check-circle"></i>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="form-group shadow p-2 mb-2 bg-white rounded">
            <?php
            $field_name = 'test_pass';
            $field_info = 'entrance_test_url';
            $field_lable = __("registrant::$module_name.$module_sub.$field_name");
            $field_placeholder = $field_lable;
            $required = "";
            $checked = ( ($data->registrant_stage->$field_name ?? 'nope') == '1' ) ? 'checked' : '';
            ?>
            <div class="row">
                <div class="col-5 text-right align-self-center">
                    {{ html()->div($field_lable, $field_name) }} {!! fielf_required($required) !!}
                </div>
                <div class="col-3 align-self-center">
                    {{ $data->unit->$field_info ?? 'NO DATA YET' }}
                </div>
                <div class="col-2">
                    {{ html()->checkbox($field_name.$data->id)->class('form-control float-left')->attributes(["$required", "$checked"]) }}

                    {{ html()->label('kirim pesan', $field_name.$data->id.'_message') }}
                    {{ html()->checkbox($field_name.$data->id.'_message',false,'Kirim pesan')->class('my-auto form-check-label') }}                </div>
                <div class="col-2 align-self-center text-success" id="col_{{$field_name}}_{{$data->id}}">
                        @if($data->registrant_stage)
                            @if($data->registrant_stage->$field_name)
                                <i class="far fa-lg fa-check-circle"></i>
                            @endif
                        @endif
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="form-group shadow p-2 mb-2 bg-white rounded">
            <?php
            $field_name = 'installment';
            $field_data_id = 'installment_id';
            $field_lable = __("registrant::$module_name.$module_sub.$field_name");
            $field_placeholder = __("Select an option");;
            $required = "";
            $select_options = $installment;
            ?>
            <div class="row">
                <div class="col-5 text-right align-self-center">
                    {{ html()->div($field_lable, $field_name) }} {!! fielf_required($required) !!}
                </div>
                <div class="col-5 align-self-center">
                    {{ html()->select($field_data_id.$data->id,$select_options, $data->registrant_stage->$field_data_id)->placeholder($field_placeholder)->class('form-control select2')->attributes(["$required"]) }}
                </div>
                <div class="col-2 align-self-center text-success" id="col_{{$field_data_id}}_{{$data->id}}">
                    @if($data->registrant_stage)
                        @if($data->registrant_stage->$field_data_id)
                            <i class="far fa-lg fa-check-circle"></i>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="form-group shadow p-2 mb-2 bg-white rounded">
            <?php
            $field_name = 'accepted_pass';
            $field_info = '';
            $field_lable = __("registrant::$module_name.$module_sub.$field_name");
            $field_placeholder = $field_lable;
            $required = "";
            $checked = ( ($data->registrant_stage->$field_name ?? 'nope') == '1' ) ? 'checked' : '';
            ?>
            <div class="row">
                <div class="col-5 text-right align-self-center">
                    {{ html()->div($field_lable, $field_name) }} {!! fielf_required($required) !!}
                </div>
                <div class="col-3 align-self-center">
                    
                </div>
                <div class="col-2">
                    {{ html()->checkbox($field_name.$data->id)->class('form-control float-left')->attributes(["$required", "$checked"]) }}
                    
                    {{ html()->label('kirim pesan', $field_name.$data->id.'_message') }}
                    {{ html()->checkbox($field_name.$data->id.'_message',false,'Kirim pesan')->class('my-auto form-check-label') }}
                </div>
                <div class="col-2 align-self-center text-success" id="col_{{$field_name}}_{{$data->id}}">
                    @if($data->registrant_stage)
                        @if($data->registrant_stage->$field_name)
                            <i class="far fa-2x fa-check-circle"></i>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
