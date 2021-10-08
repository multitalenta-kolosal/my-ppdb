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
                <div class="float-right">
                    <a href="{{ route("backend.$module_name.index") }}" class="btn btn-secondary mt-1 btn-sm" data-toggle="tooltip" title="{{ ucwords($module_name) }} List"><i class="fas fa-list"></i> List</a>
                    @can('edit_'.$module_name)
                    <a href="{{ route("backend.$module_name.edit", $$module_name_singular) }}" class="btn btn-primary mt-1 btn-sm" data-toggle="tooltip" title="Edit {{ Str::singular($module_name) }} "><i class="fas fa-wrench"></i> Edit</a>
                    @endcan
                </div>
            </div>
            <!--/.col-->
        </div>
        <!--/.row-->

        <div class="row mt-4">
            <div class="col-12 col-sm-8">
                <hr>
                <h4 class="text-primary">Ringkasan Referal</h4>
                <hr>
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th scope="col">Total Referal</th>
                            <th scope="col">Total Terverifikasi</th>
                            <th scope="col">Reward Referee</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <strong class="text-danger">{{$$module_name_singular->registrants->count()}}</strong> CPDB
                            </td>
                            <td>
                                <strong class="text-danger">{{$$module_name_singular->verified_registrants->count()}}</strong> CPDB
                            </td>
                            <td>
                                <strong class="h5">Rp. {{number_format($$module_name_singular->verified_registrants->count() * setting('reward_referee'), 2, ',', '.')}}</strong>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <hr>
                <h4 class="text-primary">Pendaftar dari Referee</h4>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Nama</th>
                            <th scope="col">ID Pendaftaran</th>
                            <th scope="col">Unit</th>
                            <th scope="col">Verified</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($$module_name_singular->registrants as $registrant)
                            <tr>
                                <td>
                                    {{$registrant->name}}
                                </td>
                                <td>
                                    {{$registrant->registrant_id}}
                                </td>
                                <td>
                                    {{$registrant->unit->name}}
                                </td>
                                <td>
                                    @if($registrant->registrant_stage->accepted_pass)
                                        <i class="far fa-lg fa-check-circle text-success"></i>
                                    @else
                                        <i class="fas fa-lg fa-spinner fa-pulse text-primary"></i>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table> 
            </div>
            <div class="col-12 col-sm-4">
            <hr>
            @include('backend.includes.show')

            <hr>
                @include('referal::backend.includes.activitylog')
            <hr>
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
