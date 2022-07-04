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
        $quota = null;
    }
    foreach($unit_counts as $unit){
        $total += $unit->amount;
        $total_acc += $unit->accepted_amount;
    }
    ?>
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4 d-none d-sm-none d-md-block">
        <div class="card">
            <div class="card-body">
                <div>Total CPDB: <span class="text-value-lg">{{$total}}</span></div>
                <div><small class="text-muted">Total CPDB dari seluruh Unit Pendidikan</small></div>
                <div>Total CPDB diterima: <span class="text-value-lg">{{$total_acc}}</span></div>
                <div><small class="text-muted">Total CPDB yang  sudah diterima</small></div>
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
            if($quota->$unit_quota<1){
                $quota->$unit_quota = 1;
            }

            $bar_percentage = round( ( $amount / $quota->$unit_quota) * 100, 2);
            $accepted_percentage = round( ( $amount_acc / $amount) * 100, 2);
        }else{
            $bar_percentage = '--';
            $accepted_percentage= '--';
        }

        ?>
        <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4 d-none d-sm-none d-md-block">
            <div class="card">
                <div class="card-body">
                    <div class="text-value-lg">{{$amount}} /<span class="text-value-sm">{{$quota->$unit_quota ?? '--'}}</span></div>
                    <div>{{$unit_name}}</div>
                    <div class="progress progress-xs my-2">
                        <div class="progress-bar" role="progressbar" style="width: {{$bar_percentage}}%; background-color: {{$color_array[$unit->unit] ?? ''}}" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div><small class="{{$bar_percentage < 100 ? 'text-danger' : 'text-success'}}">{{$bar_percentage}}% dari target</small>
                    <div class="text-value-sm">Diterima: {{$amount_acc}} <span class="text-value-sm">dari {{$amount}} pendaftar (<span class="{{$amount_acc < $amount ? '' : 'text-success'}}">{{$accepted_percentage}}%</span>)</span></div>

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
        $quota = null;
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
                    <div class="text-value-lg">{{$total}}</div>
                    <div>Total CPDB</div>
                </div>
                <div class="col-5 mr-4 my-3">
                    <div class="text-value-lg">{{$total_acc}}</div>
                    <div>Total CPDB Diterima</div>
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
                        if($quota->$unit_quota<1){
                            $quota->$unit_quota = 1;
                        }

                        $bar_percentage = round( ( $amount / $quota->$unit_quota) * 100, 2);
                    }else{
                        $bar_percentage = '--';
                    }

                    ?>
                    <div class="col-md-9 my-2 mx-4">
                        <div class="text-value-lg"> <span class="h4">{{$unit_name}}: </span> {{$amount}} /<span class="text-value-sm">{{$quota->$unit_quota ?? '--'}}</span></div>
                        <div class="progress progress-xs my-2">
                            <div class="progress-bar" role="progressbar" style="width: {{$bar_percentage}}%; background-color: {{$color_array[$unit->unit] ?? ''}}" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div><small class="{{$bar_percentage < 100 ? 'text-danger' : 'text-success'}}">{{$bar_percentage}}% dari target</small>
                        <div class="text-value-sm">Diterima: {{$amount_acc}} <span class="text-value-sm">dari {{$amount}} pendaftar</span></div>
                    </div>
                @endforeach
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