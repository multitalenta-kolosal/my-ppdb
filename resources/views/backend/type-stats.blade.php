
<div class="col-lg-6">
    <h4 class="card-title">Pendaftar</h4>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                <th scope="col">Jalur</th>
                <th scope="col">Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $total = 0;
                ?>
                @foreach($statsRegistrant as $value)
                    @php
                        $total += $value->count;
                    @endphp
                    <tr>
                        <th scope="row">{{$value->path_name}}</th>
                        <td class="font-weight-bold text-primary">{{$value->count}}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th scope="col"><h5>Total</h5></th>
                    <th scope="col"><h5 class="font-weight-bold text-primary">{{$total}}</h5</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
<div class="col-lg-6">
    <h4 class="card-title">Heregistrasi</h4>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                <th scope="col">Jalur</th>
                <th scope="col">Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $total = 0;
                ?>
                @foreach($statsRegistrantHereg as $value)
                    @php
                        $total += $value->count;
                    @endphp
                    <tr>
                        <th scope="row">{{$value->path_name}}</th>
                        <td class="font-weight-bold text-primary">{{$value->count}}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th scope="col"><h5>Total</h5></th>
                    <th scope="col"><h5 class="font-weight-bold text-primary">{{$total}}</h5</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>