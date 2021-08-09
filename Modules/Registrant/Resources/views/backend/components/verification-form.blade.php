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
            $field_dpp = 'dpp_pass';
            $field_dp  = 'dp_pass';
            $field_spp = 'spp_pass';


            $field_info_dpp = 'dpp';
            $field_info_dp = 'dp';
            $field_info_spp = 'spp';

            $field_lable_dpp = __("registrant::$module_name.$module_sub.$field_dpp");
            $field_lable_dp = __("registrant::$module_name.$module_sub.$field_dp");
            $field_lable_spp = __("registrant::$module_name.$module_sub.$field_spp");
            $field_placeholder = $field_lable;
            $required = "";
            $checked_dpp = ( ($data->registrant_stage->$field_dpp ?? 'nope') == '1' ) ? 'checked' : ''; 
            $checked_dp = ( ($data->registrant_stage->$field_dp ?? 'nope') == '1' ) ? 'checked' : '';
            $checked_spp = ( ($data->registrant_stage->$field_spp ?? 'nope') == '1' ) ? 'checked' : '';
            ?>
            <div class="card-header text-center py-0" style="height: 2rem;">
                <h3>Biaya Pendidikan</h3>
            </div>
                <div class="row my-1">
                    <div class="col-5 text-right align-self-center">
                        {{ html()->div($field_lable_dpp, $field_dpp) }} {!! fielf_required($required) !!}
                    </div>
                    <div class="col-3 align-self-center">
                        @if($data->unit)
                            @if(!$data->unit->have_major)
                                {{ number_format($data->unit->$field_info_dpp ?? 0, 2, ',', '.') ?? 0 }}
                            @else
                                @if($data->tier)
                                    {{ number_format($data->tier->$field_info_dpp ?? 0, 2, ',', '.') ?? 0 }}
                                @else
                                    {{ number_format($data->unit->$field_info_dpp ?? 0, 2, ',', '.') ?? 0 }}
                                @endif
                            @endif
                        @endif
                    </div>
                    <div class="col-2">
                        {{ html()->checkbox($field_dpp.$data->id)->class('form-control float-left')->attributes(["$required", "$checked_dpp"]) }}
                    </div>
                    <div class="col-2 align-self-center text-success" id="col_{{$field_dpp}}_{{$data->id}}">
                        @if($data->registrant_stage)
                            @if($data->registrant_stage->$field_dpp)
                                <i class="far fa-lg fa-check-circle"></i>
                            @endif
                        @endif
                    </div>
                </div>
                <div class="row my-1">
                    <div class="col-5 text-right align-self-center">
                        {{ html()->div($field_lable_dp, $field_dp) }} {!! fielf_required($required) !!}
                    </div>
                    <div class="col-3 align-self-center">
                        @if($data->unit)
                            @if(!$data->unit->have_major)                        
                                {{  number_format($data->unit->$field_info_dp ?? 0, 2, ',', '.') }}
                            @else
                                @if($data->tier)
                                    {{ number_format($data->tier->$field_info_dp ?? 0, 2, ',', '.') ?? 0 }}
                                @else
                                    {{ number_format($data->unit->$field_info_dp ?? 0, 2, ',', '.') ?? 0 }}
                                @endif
                            @endif
                        @endif
                    </div>
                    <div class="col-2">
                        {{ html()->checkbox($field_dp.$data->id)->class('form-control float-left')->attributes(["$required", "$checked_dp"]) }}
                    </div>
                    <div class="col-2 align-self-center text-success" id="col_{{$field_dp}}_{{$data->id}}">
                        @if($data->registrant_stage)
                            @if($data->registrant_stage->$field_dp)
                                <i class="far fa-lg fa-check-circle"></i>
                            @endif
                        @endif
                    </div>
                </div>
                <div class="row my-1">
                    <div class="col-5 text-right align-self-center">
                        {{ html()->div($field_lable_spp, $field_spp) }} {!! fielf_required($required) !!}
                    </div>
                    <div class="col-3 align-self-center">
                        @if($data->unit)
                            @if(!$data->unit->have_major)       
                                {{ number_format($data->unit->$field_info_spp ?? 0, 2, ',', '.') }}
                            @else
                                @if($data->tier)
                                    {{ number_format($data->tier->$field_info_spp ?? 0, 2, ',', '.') ?? 0 }}
                                @else
                                    {{ number_format($data->unit->$field_info_spp ?? 0, 2, ',', '.') ?? 0 }}
                                @endif
                            @endif
                        @endif
                    </div>
                    <div class="col-2">
                        {{ html()->checkbox($field_spp.$data->id)->class('form-control float-left')->attributes(["$required", "$checked_spp"]) }}
                    </div>
                    <div class="col-2 align-self-center text-success" id="col_{{$field_spp}}_{{$data->id}}">
                        @if($data->registrant_stage)
                            @if($data->registrant_stage->$field_spp)
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
