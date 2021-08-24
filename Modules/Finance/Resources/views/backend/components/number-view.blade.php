<div>
    <ol>
    @if($item && is_array($item))
        @foreach($item as $key => $amount)
            <li>{{ html()->div($amount ?? null)}}</li>
        @endforeach
    @endif
    <ol>
</div>