@extends('backend.layouts.app')

@section('title') {{ $module_action }} {{ $module_title }} @endsection

@section('breadcrumbs')
<x-backend-breadcrumbs>
    <x-backend-breadcrumb-item route='{{route("backend.$module_name.index")}}' icon='{{ $module_icon }}' >
        {{ $module_title }}
    </x-backend-breadcrumb-item>
    <x-backend-breadcrumb-item type="active">{{ $module_action }}</x-backend-breadcrumb-item>
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
                    
                </div>
            </div>
            <!--/.col-->
        </div>
        <!--/.row-->

        <div class="row mt-4">
            <div class="col">

                @if (count($purges))
                <table id="datatable" class="table table-bordered table-hover table-responsive-sm">
                    <thead>
                        <tr>
                            <th>
                                @lang('Name')
                            </th>
                            <th class="text-right">
                                @lang('Action')
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($purges as $key => $purge)
                        <tr>
                            <td>
                                {{ $key }}
                            </td>
                            <td class="text-right">
                                <a href="{{ route("backend.$module_name.purgeAll", $key) }}" onclick="return confirm('INI AKAN MENGHAPUS PERMANEN SEMUA DATA DI TABEL. ANDA YAKIN?')" class="btn btn-danger m-1 btn-sm" data-toggle="tooltip" title="purge">Kosongkan Data</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                    <div class="text-center">
                        <h4>@lang('There are no purges')</h4>
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection


<script type="text/javascript">
    var elems = document.getElementsByClassName('confirmation');
    var confirmIt = function (e) {
        if (!confirm('Are you sure?')) e.preventDefault();
    };
    for (var i = 0, l = elems.length; i < l; i++) {
        console.log(elems[i].title);
        elems[i].addEventListener('click', confirmIt, false);
    }
</script>
