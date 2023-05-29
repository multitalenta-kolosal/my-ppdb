@extends('backend.layouts.app')

@section('title') Analytics @lang("Dashboard") @endsection

@section('breadcrumbs')
<x-backend-breadcrumbs/>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-8">
                <h4 class="card-title mb-0">@lang("Welcome to", ['name'=>config('app.name')])</h4>
                <div class="small text-muted">{{ date_today() }}</div>
            </div>
        </div>
        <hr>

        <!-- Dashboard Content Area -->
        <div class="form-group">
            <?php
            $field_name = 'unit';
            $field_data_id = 'periods';
            $field_lable = 'Periode Waktu Grafik';
            $default = 7;
            $field_placeholder =  "--Pilih--";
            $required = "";
            $select_options = [
                7       => '7 Hari',
                15      => '15 Hari',
                30      => '30 Hari',
                'monthly' => '6 Bulan',
                'year'   => '1 Tahun',
            ];
            ?>
            <h4>{{ html()->label($field_lable, $field_name)->class('text-primary') }} {!! fielf_required($required) !!}</h4>
            {{ html()->select($field_data_id, $select_options, $default)->placeholder($field_placeholder)->class('form-control select2')->attributes(["$required"]) }}
        </div>

        <div id="registrant_chart" style="height: 300px;"></div>
       
        <!-- / Dashboard Content Area -->

    </div>
</div>

<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
            <h4 class="card-title">Pendaftar Per Bulan</h4>
                <div class="table-responsive">
                    <table class="table">
                        <caption>Jumlah Pendaftar</caption>
                        <thead>
                            <tr>
                            <th scope="col">Bulan</th>
                            @foreach($insights->units as $unit)
                                <th scope="col">{{$unit->name}}</th>
                            @endforeach
                            <th scope="col">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($insights->register as $month => $unit_counts)
                                @php
                                    $total = 0;
                                @endphp
                                <tr>
                                    <th scope="row">{{$month}}</th>
                                    @foreach($unit_counts as $key => $count)
                                        <td>{{$count}}</td>
                                        @php
                                            $total += $count;
                                        @endphp
                                    @endforeach
                                    <td class="font-weight-bold text-primary">{{$total}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
            <h4 class="card-title">Heregistrasi Per Bulan</h4>
                <div class="table-responsive">
                    <table class="table">
                        <caption>Jumlah Heregistrasi</caption>
                        <thead>
                            <tr>
                            <th scope="col">Bulan</th>
                            @foreach($insights->units as $unit)
                                <th scope="col">{{$unit->name}}</th>
                            @endforeach
                            <th scope="col">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($insights->hereg as $month => $unit_counts)
                                @php
                                    $total = 0;
                                @endphp
                                <tr>
                                    <th scope="row">{{$month}}</th>
                                    @foreach($unit_counts as $key => $count)
                                        <td>{{$count}}</td>
                                        @php
                                            $total += $count;
                                        @endphp
                                    @endforeach
                                    <td class="font-weight-bold text-primary">{{$total}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
            <h4 class="card-title">Pendaftar Per Bulan</h4>
                <div class="table-responsive">
                    <table class="table">
                        <caption>Jumlah Pendaftar</caption>
                        <thead>
                            <tr>
                            <th scope="col">Bulan</th>
                            @foreach($insights->units as $unit)
                                <th scope="col">{{$unit->name}}</th>
                            @endforeach
                            <th scope="col">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($insights->register as $month => $unit_counts)
                                @php
                                    $total = 0;
                                @endphp
                                <tr>
                                    <th scope="row">{{$month}}</th>
                                    @foreach($unit_counts as $key => $count)
                                        <td>{{$count}}</td>
                                        @php
                                            $total += $count;
                                        @endphp
                                    @endforeach
                                    <td class="font-weight-bold text-primary">{{$total}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <hr>

        <div id="path_chart_bar" style="height: 300px;"></div>
       
    </div>
</div>
@endsection

@push('after-scripts')

<!-- Charting library -->
<script src="https://unpkg.com/chart.js@2.9.3/dist/Chart.min.js"></script>
<!-- Chartisan -->
<script src="https://unpkg.com/@chartisan/chartjs@^2.1.0/dist/chartisan_chartjs.umd.js"></script>


<script>

    const registrant_chart = new Chartisan({
        el: '#registrant_chart',
        url: "@chart('registrant_chart')"+"?periods="+$('#periods').val(),
        hooks: new ChartisanHooks()
            .title('Pendaftar')
            .colors({!! $color !!})
            .borderColors({!! $color !!})
            .responsive(true)
            .tooltip(true)
            .stepSize(2,'y')
            .datasets([
                { 
                    type: 'line', 
                    fill: false,
                    borderWidth: 2,
                    bezierCurve: false,
                }
            ]),
    });

    $(document).ready(function(){
        $("#periods").change(function () {
            registrant_chart.update({
                url: "@chart('registrant_chart')"+"?periods="+$('#periods').val(),
            })
        });
    });
</script>

<script>
    const path_chart_bar = new Chartisan({
        el: '#path_chart_bar',
        url: "@chart('path_chart_bar')",
        hooks: new ChartisanHooks()
            .title('Pendaftar')
            .colors({!! $color !!})
            .borderColors({!! $color !!})
            .responsive(true)
            .beginAtZero(true,'y')
            .tooltip(true)
            .datasets([
                { 
                    type: 'bar', 
                }
            ]),
    });
</script>
@endpush