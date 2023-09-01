@props(["route"=>"", "icon"=>"fas fa-edit", "title", "small"=>"", "class"=>"", "button"=>"btn btn-primary my-1"])

@if($route)
<a href='{{$route}}'
    class='{{$button}} {{($small=='true')? 'btn-sm' : ''}} {{$class}}'
    data-toggle="tooltip"
    title="{{ $title }}">
    <i class="{{$icon}}"></i>
    {{ $slot }}
</a>
@else
<button type="submit"
    class='{{$button}} {{($small=='true')? 'btn-sm' : ''}} {{$class}}'
    data-toggle="tooltip"
    title="{{ $title }}">
    <i class="{{$icon}}"></i>
    {{ $slot }}
</button>
@endif
