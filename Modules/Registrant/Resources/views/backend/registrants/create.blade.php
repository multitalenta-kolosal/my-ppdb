@extends('backend.layouts.app')

@section('title') {{ __($module_action) }} {{ $module_title }} @endsection

@section('breadcrumbs')
<x-backend-breadcrumbs>
    <x-backend-breadcrumb-item route='{{route("backend.$module_name.index")}}' icon='{{ $module_icon }}' >
        {{ $module_title }}
    </x-backend-breadcrumb-item>
    <x-backend-breadcrumb-item type="active">{{ __($module_action) }}</x-backend-breadcrumb-item>
</x-backend-breadcrumbs>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-8">
                <h4 class="card-title mb-0">
                    <i class="{{ $module_icon }}"></i> {{ $module_title }} <small class="text-muted">{{ __($module_action) }}</small>
                </h4>
                <div class="small text-muted">
                    @lang(":module_name Management Dashboard", ['module_name'=>Str::title($module_name)])
                </div>
            </div>
            <!--/.col-->
            <div class="col-4">
                <div class="btn-toolbar float-right" role="toolbar" aria-label="Toolbar with button groups">
                    <a href="{{ route("backend.$module_name.index") }}" class="btn btn-secondary btn-sm ml-1" data-toggle="tooltip" title="{{ $module_title }} List"><i class="fas fa-list-ul"></i> List</a>
                </div>
            </div>
            <!--/.col-->
        </div>
        <!--/.row-->

        <hr>

        <div class="row mt-4">
            <div class="col">
                {{ html()->form('POST', route("backend.$module_name.store"))->class('form')->open() }}

                @include ("registrant::backend.$module_name.form")

                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            {{ html()->button($text = "<i class='fas fa-plus-circle'></i> " . ucfirst($module_action) . "", $type = 'submit')->class('btn btn-success') }}
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="float-right">
                            <div class="form-group">
                                <button type="button" class="btn btn-warning" onclick="history.back(-1)"><i class="fas fa-reply"></i> Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>

                {{ html()->form()->close() }}

            </div>
        </div>
    </div>

    <div class="card-footer">
        <div class="row">
            <div class="col">

            </div>
        </div>
    </div>
</div>

@stop


@push ('after-scripts')
<script type="text/javascript">

$(document).ready(function() {
        if($('#unit_id').val() != ""){
            setTier();
        }

        $('#unit_id').on('change', function(){
            setTier();
        });
    });

    function setTier(){
        $('#type').empty();
        var unit_id = $('#unit_id').val();
        if(unit_id){
            $.ajax({
                type: "GET",
                url: '{{route("frontend.units.getunitopt",'')}}'+'/'+unit_id,
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
                    Swal.fire("@lang('delete error')", "@lang('error')", "error");
                }
            });
        }else{
            var defaultOption = $('<option value="">--Silakan Pilih Sekolah Dahulu--</option>');
            $('#type').append(defaultOption);
        }

    }
</script>


@endpush