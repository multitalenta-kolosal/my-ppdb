<div class="text-right">
    @can('edit_'.$module_name)
    <x-buttons.edit icon="fas fa-file-alt" route='{!!route("backend.$module_name.edit-note", $data)!!}' title="{{__('Edit')}} {{ ucwords(Str::singular($module_name)) }}" small="true" />
    @endcan
</div>