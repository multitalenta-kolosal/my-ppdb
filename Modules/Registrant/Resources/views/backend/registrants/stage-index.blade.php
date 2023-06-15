@extends('backend.layouts.app')

@section('title') {{ __($module_action) }} {{ $module_title }} @stop

@section('breadcrumbs')
<x-backend-breadcrumbs>
    <x-backend-breadcrumb-item type="active" icon='{{ $module_icon }}'>{{ $module_title }}</x-backend-breadcrumb-item>
</x-backend-breadcrumbs>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-8">
                <h4 class="card-title mb-0">
                    <i class="{{ $module_icon }}"></i> Status {{ $module_title }} <small class="text-muted">{{ __($module_action) }}</small>
                </h4>
                <div class="small text-muted">
                    @lang(":module_name Management Dashboard", ['module_name'=>Str::title($module_name)])
                </div>
            </div>
            <!--/.col-->
            <div class="col-4">
                <div class="float-right">
                    @can('add_'.$module_name)
                        <x-buttons.create route='{{ route("backend.$module_name.create") }}' title="{{__('Create')}} {{ ucwords(Str::singular($module_name)) }}"/>
                    @endcan
                    <div class="btn-group" role="group" aria-label="Toolbar button groups">
                        <div class="btn-group" role="group">
                            <button id="btnGroupToolbar" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-cog"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="btnGroupToolbar">
                                @can('delete_'.$module_name)
                                    <a class="dropdown-item" href="{{ route("backend.$module_name.trashed") }}">
                                        <i class="fas fa-eye-slash"></i> View trash
                                    </a>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/.col-->
        </div>
        <!--/.row-->
        <div class="row mt-4">
            <div class="col">
                <div class="table-responsive">
                    <div id="filter-information">
                        <span class="text-danger" id="filter-count" name="filter-count"></span>
                        <a href="#" class="text-prmary ml-2" id="clear-filter" name="clear-filter" style="display: none;"><u><i class="fas fa-times"></i> clear filter</u></a>
                    </div>
                    <table class="table">
                        {{ $dataTable->table([], true) }}
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <div class="row">
            <div class="col-7">
                <div class="float-left">

                </div>
            </div>
            <div class="col-5">
                <div class="float-right">

                </div>
            </div>
        </div>
    </div>
</div>

@include('registrant::backend.components.filter-modal')

@stop


@push ('after-styles')
<link rel="stylesheet" href="{{ asset('vendor/datatable/datatables.min.css') }}">

@endpush

@push ('after-scripts')
<!-- DataTables Core and Extensions -->
{!! $dataTable->scripts()  !!}

<script>
    $(document).ready(function(){
        $('.sorting').on( 'click',  function () { 
            $('#{{$module_name}}-table').busyLoad("show", 
            { 
                fontawesome: "fa fa-cog fa-spin fa-3x fa-fw" ,
                background: "rgba(255, 255, 255, 0.56)",
                containerClass: "z-2",
            });

            $('#{{$module_name}}-table').on( 'order.dt',  function () { 
                $('#{{$module_name}}-table').busyLoad("hide");
            });
        });
    })
</script>

@endpush