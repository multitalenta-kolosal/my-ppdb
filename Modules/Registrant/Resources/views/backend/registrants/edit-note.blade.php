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
                    <i class="fas fa-file-alt"></i> Notes  {{ $module_title }} <small class="text-muted">{{ __($module_action) }}</small>
                </h4>
                <div class="small text-muted">
                    @lang(":module_name Management Dashboard", ['module_name'=>Str::title($module_name)])
                </div>
            </div>
            <!--/.col-->
        </div>
        <!--/.row-->

        <hr>

        <div class="row mt-4">
            <div class="col">
                {{ html()->modelForm($$module_name_singular, 'PATCH', route("backend.$module_name.update-note", $$module_name_singular))->class('form')->open() }}

                @include ("registrant::backend.$module_name.form-note")

                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            {{ html()->submit($text = icon('fas fa-save')." Save")->class('btn btn-success') }}
                        </div>
                    </div>

                    <div class="col-8">
                        <div class="float-right">
                            <a href="{{ route("backend.$module_name.stage-index") }}" class="btn btn-warning" data-toggle="tooltip" title="{{__('labels.backend.cancel')}}"><i class="fas fa-reply"></i> Cancel</a>
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
                <small class="float-right text-muted">
                    Updated: {{$$module_name_singular->updated_at->diffForHumans()}},
                    Created at: {{$$module_name_singular->created_at->isoFormat('LLLL')}}
                </small>
            </div>
        </div>
    </div>
</div>

@stop

@push ('after-scripts')



<script type="text/javascript">

$(document).ready(function() {

        if({{$registrant->unit->have_major}}){
            $('#tier_options').removeClass('d-none');
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