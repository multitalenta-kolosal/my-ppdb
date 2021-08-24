<div>
    <ul>
    @if($item && is_array($item))
        @foreach($item as $key => $amount)
            <li>{{ html()->div(str_replace("quota_", "", $key).': '.$amount ?? null)}}</li>
        @endforeach
    @endif
    <ul>
</div>