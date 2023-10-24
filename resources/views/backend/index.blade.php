@extends('backend.layouts.app')

@section('title') @lang("Dashboard") @endsection

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
<!-- / card for Desktop-->
<div class="row">
    <?php
    $total = 0;
    $total_acc = 0;
    if($batch_period){
        $quota = json_decode($batch_period->quota);
    }else{
        $quota = [];
    }
    
    $total_target = 1;

    if(is_null($quota)){
        $quota = [];
    }


    foreach($quota as $quota_amount){
        $total_target += $quota_amount;
    }
    foreach($unit_counts as $unit){
        $total += $unit->amount;
        $total_acc += $unit->accepted_amount;
    }

    $total_percentage_per_target = round( ( $total / $total_target) * 100, 2);
    $total_acc_per_target = round( ( $total_acc / $total_target) * 100, 2);

    ?>
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4 d-none d-sm-none d-md-block">
        <div class="card">
            <div class="card-body">
                <div>Total CPDB: <span class="text-value-lg">{{$total}}</span></div>
                <div><small class="text-muted">Total CPDB dari seluruh Unit Pendidikan</small></div>
                <div>Total CPDB heregistrasi: <span class="text-value-lg">{{$total_acc}}</span></div>
                <div><small class="text-muted">Total CPDB yang  sudah heregistrasi</small></div>
                <hr>
                <div class="">
                    <div class="row">
                        <div class="col-6">
                            <div class="text-value-lg"><span class="{{$total >= $total_target ? 'text-success' : ''}}">{{$total}}</span> /<span class="text-value-sm"> {{$total_target ?? '--'}} target</span></div>
                            <small class="{{$total_percentage_per_target < 100 ? 'text-danger' : 'text-success'}}">( {{$total_percentage_per_target}}% ) dari target</small>
                        </div>
                        <div class="col-6">
                            <div class="text-value-lg">{{$total_acc}} /<span class="text-value-sm"> {{$total_target}} Target </span></div>
                            <small class="{{$total_acc_per_target < 100 ? 'text-danger' : 'text-success'}}">( {{$total_acc_per_target}}% ) dari target</small>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    </div>
    @foreach($unit_counts as $unit)
        <?php 
        $unit_name = $unit->unit;
        $unit_quota = 'quota_'.$unit_name;
        $amount =$unit->amount;
        $amount_acc =$unit->accepted_amount;

        if($quota != ""){
            if(!isset($quota->$unit_quota)){
                $quota->$unit_quota = 1;
            }
            else if($quota->$unit_quota<1){
                $quota->$unit_quota = 1;
            }

            $bar_percentage = round( ( $amount / $quota->$unit_quota) * 100, 2);
            $accepted_per_amount_percentage = round( ( $amount_acc / $amount) * 100, 2);
            $accepted_per_target_percentage = round( ( $amount_acc / $quota->$unit_quota) * 100, 2);

        }else{
            $bar_percentage = '--';
            $accepted_per_amount_percentage= '--';
            $accepted_per_target_percentage= '--';
        }

        ?>
        <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4 d-none d-sm-none d-md-block">
            <div class="card">
                <div class="card-body">
                    <div class="text-value-lg"> <span class="{{$amount > $quota->$unit_quota ? 'text-success' : ''}}">{{$amount}}</span> /<span class="text-value-sm">{{$quota->$unit_quota ?? '--'}} target</span></div>
                    <div>{{$unit_name}}</div>
                    <div class="progress progress-xs my-2">
                        <div class="progress-bar" role="progressbar" style="width: {{$bar_percentage}}%; background-color: {{$color_array[$unit->unit] ?? ''}}" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div><small class="{{$bar_percentage < 100 ? 'text-danger' : 'text-success'}}">{{$bar_percentage}}% dari target</small>
                    <hr>
                    <div class="">Heregistrasi:
                        <div class="row">
                            <div class="col-6">
                                <div class="text-value-lg"><span class="{{$amount > $quota->$unit_quota ? 'text-success' : ''}}">{{$amount_acc}}</span> /<span class="text-value-sm"> {{$quota->$unit_quota ?? '--'}} target</span></div>
                                <small class="{{$accepted_per_target_percentage < 100 ? 'text-danger' : 'text-success'}}">( {{$accepted_per_target_percentage}}% ) dari target</small>
                            </div>
                            <div class="col-6">
                                <div class="text-value-lg">{{$amount_acc}} /<span class="text-value-sm"> {{$amount}} pendaftar </span></div>
                                <small class="{{$accepted_per_amount_percentage < 100 ? 'text-danger' : 'text-success'}}">( {{$accepted_per_amount_percentage}}% ) dari pendaftar</small>
                            </div>
                        </div> 
                    </div>

                </div>
            </div>
        </div>
    @endforeach
</div>

<!-- / card for Mobile-->
<div class="row d-sm-block d-md-none">
    <?php
    $total = 0;
    $total_acc = 0;
    if($batch_period){
        $quota = json_decode($batch_period->quota);
    }else{
        $quota = [];
    }

    if(is_null($quota)){
        $quota = [];
    }

    foreach($unit_counts as $unit){
        $total += $unit->amount;
        $total_acc += $unit->accepted_amount;
    }
    ?>
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4 d-sm-block d-md-none">
        <div class="card">
            <div class="row">
                <div class="col-5 ml-4 my-3">
                    <div class="text-value-lg"><span class="{{$total >= $total_target ? 'text-success' : ''}}">{{$total}}</span> /<span class="text-value-sm"> {{$total_target ?? '--'}} target</span></div>
                    <small class="{{$total_percentage_per_target < 100 ? 'text-danger' : 'text-success'}}">( {{$total_percentage_per_target}}% ) dari target</small>
                    <div>Total CPDB</div>
                </div>
                <div class="col-5 mr-4 my-3">
                    <div class="text-value-lg">{{$total_acc}} /<span class="text-value-sm"> {{$total_target}} Target </span></div>
                    <small class="{{$total_acc_per_target < 100 ? 'text-danger' : 'text-success'}}">( {{$total_acc_per_target}}% ) dari target</small>
                    <div>Total CPDB Heregistrasi</div>
                </div>
            </div>
            <hr>
            <div class="row">
                @foreach($unit_counts as $unit)
                    <?php 
                    $unit_name = $unit->unit;
                    $unit_quota = 'quota_'.$unit_name;
                    $amount =$unit->amount;
                    $amount_acc =$unit->accepted_amount;

                    
                    if($quota != ""){
                        if(!isset($quota->$unit_quota)){
                            $quota->$unit_quota = 1;
                        }
                        else if($quota->$unit_quota<1){
                            $quota->$unit_quota = 1;
                        }
            

                        $bar_percentage = round( ( $amount / $quota->$unit_quota) * 100, 2);
                        $accepted_per_amount_percentage = round( ( $amount_acc / $amount) * 100, 2);
                        $accepted_per_target_percentage = round( ( $amount_acc / $quota->$unit_quota) * 100, 2);

                    }else{
                        $bar_percentage = '--';
                        $accepted_per_amount_percentage= '--';
                        $accepted_per_target_percentage= '--';
                    }

                    ?>
                    <div class="col-md-9 my-2 mx-4">
                        <div class="text-value-lg"> <span class="h4">{{$unit_name}}: </span> <span class="{{$amount > $quota->$unit_quota ? 'text-success' : ''}}">{{$amount}}</span> /<span class="text-value-sm">{{$quota->$unit_quota ?? '--'}} target</span></div>
                        <div class="progress progress-xs my-2">
                            <div class="progress-bar" role="progressbar" style="width: {{$bar_percentage}}%; background-color: {{$color_array[$unit->unit] ?? ''}}" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div><small class="{{$bar_percentage < 100 ? 'text-danger' : 'text-success'}}">{{$bar_percentage}}% dari target</small>
                        <div class="row">
                            <div class="col-6">
                                <div class="text-value-lg"><span class="{{$amount > $quota->$unit_quota ? 'text-success' : ''}}">{{$amount_acc}}</span> /<span class="text-value-sm"> {{$quota->$unit_quota ?? '--'}} target</span></div>
                                <small class="{{$accepted_per_target_percentage < 100 ? 'text-danger' : 'text-success'}}">( {{$accepted_per_target_percentage}}% ) dari target</small>
                            </div>
                            <div class="col-6">
                                <div class="text-value-lg"><span class="{{$amount > $quota->$unit_quota ? 'text-success' : ''}}">{{$amount_acc}}</span> /<span class="text-value-sm"> {{$amount}} pendaftar </span></div>
                                <small class="{{$accepted_per_amount_percentage < 100 ? 'text-danger' : 'text-success'}}">( {{$accepted_per_amount_percentage}}% ) dari pendaftar</small>
                            </div>
                        </div>
                        <hr>                     
                    </div>
                @endforeach
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