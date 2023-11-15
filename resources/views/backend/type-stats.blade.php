
<div class="col-lg-6">
    <h4 class="card-title">Pendaftar</h4>
    <div class="table-responsive">
        <table class="table">
            <caption>Jumlah Pendaftar</caption>
            <thead>
                <tr>
                <th scope="col">Jalur</th>
                <th scope="col">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($statsRegistrant as $value)
                    @php
                        $total = 0;
                    @endphp
                    <tr>
                        <th scope="row">{{$value->path_name}}</th>
                        <td class="font-weight-bold text-primary">{{$value->count}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="col-lg-6">
    <h4 class="card-title">Heregistrasi</h4>
    <div class="table-responsive">
        <table class="table">
            <caption>Jumlah Heregistrasi</caption>
            <thead>
                <tr>
                <th scope="col">Jalur</th>
                <th scope="col">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($statsRegistrantHereg as $value)
                    @php
                        $total = 0;
                    @endphp
                    <tr>
                        <th scope="row">{{$value->path_name}}</th>
                        <td class="font-weight-bold text-primary">{{$value->count}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>