<div class="text-right action-button-group">
    @can('edit_'.$module_name)
    <button type="button" id ="{{$data->name}}" class="btn btn-success" data-toggle="modal" data-target="#modal_{{$data->id}}">Verify</button>
    @endcan
    @can('edit_'.$module_name)
    <x-buttons.edit route='{!!route("backend.$module_name.edit", $data)!!}' title="{{__('Edit')}} {{ ucwords(Str::singular($module_name)) }}" small="true" />
    @endcan
    @can('delete_'.$module_name)
    <x-buttons.delete route='{!!route("backend.$module_name.destroy", $data)!!}'  title="{{__('Delete')}} {{ ucwords(Str::singular($module_name)) }}" small="true" />
    @endcan
</div>


<!-- verification modal -->
@include('registrant::backend.components.verification-modal', ['data' => $data, 'module_sub' => 'verification', 'installment' => $installment])