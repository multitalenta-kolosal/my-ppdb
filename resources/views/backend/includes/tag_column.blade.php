<div class="text-right">
    @php
        $colors = config('tag-color.code');
    @endphp
    <i class="fas fa-lg fa-circle" style="color:{{$colors[$data->tag_color ?? 0]}};"></i>
    @can('edit_'.$module_name)
    <x-buttons.edit icon="fas fa-sm fa-edit" route='{!!route("backend.$module_name.edit-tag", $data)!!}' title="{{__('Edit')}} {{ ucwords(Str::singular($module_name)) }}" small="true" button=""/>
    @endcan
</div>