@props(["route"=>"", "icon"=>"fas fa-trash", "title", "small"=>"", "class"=>""])

@if($route)
<button type="button" 
    class="btn btn-danger delete-confirm {{($small=='true')? 'btn-sm' : ''}}">
    <i class="fas fa-trash-alt"></i>
</button>
@else
<button type="submit"
    class='btn btn-danger my-1 {{($small=='true')? 'btn-sm' : ''}} {{$class}}'
    data-toggle="tooltip"
    title="{{ $title }}">
    <i class="{{$icon}}"></i>
    {{ $slot }}
</button>
@endif

