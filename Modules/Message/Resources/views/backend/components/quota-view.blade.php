<div>
    <ul>
    @if($quota && is_array($quota))
        @foreach($quota as $key => $amount)
            <li>{{ html()->div(str_replace("quota_", "", $key).': '.$amount ?? null)}}</li>
        @endforeach
    @endif
    <ul>
</div>