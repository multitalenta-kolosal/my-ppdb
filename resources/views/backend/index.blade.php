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

            <div class="col-sm-4 hidden-sm-down">
                <div class="btn-toolbar float-right" role="toolbar" aria-label="Toolbar with button groups">
                    <button type="button" class="btn btn-info float-right">
                        <i class="c-icon cil-bullhorn"></i>
                    </button>
                </div>
            </div>
        </div>
        <hr>

        <!-- Dashboard Content Area -->
        <div class="form-group">
            <?php
            $field_name = 'unit';
            $field_data_id = 'periods';
            $field_lable = 'Periode Waktu';
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
<!-- / card -->
<div class="row">
    <?php
    $total = 0;
    if($batch_period){
        $quota = json_decode($batch_period->quota);
    }else{
        $quota = null;
    }
    foreach($unit_counts as $unit){
        $total += $unit->amount;
    }
    ?>
    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
        <div class="card">
            <div class="card-body">
                <div class="text-value-lg">{{$total}}</div>
                <div>kabeh</div>
                <div class="progress progress-xs my-2">
                    <div class="progress-bar bg-dark" role="progressbar" style="width: 12.5%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                </div><small class="text-muted">Widget helper text</small>
            </div>
        </div>
    </div>
    @if($unit_counts>0)
        @foreach($unit_counts as $unit)
            <?php
            $unit_name = $unit->unit;
            $unit_quota = 'quota_'.$unit_name;
            $amount =$unit->amount;

            $bar_percentage = round( ( $amount / $quota->$unit_quota) * 100, 2);
            ?>
            <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="text-value-lg">{{$amount}} /<span class="text-value-sm">{{$quota->$unit_quota}}</span></div>
                        <div>{{$unit_name}}</div>
                        <div class="progress progress-xs my-2">
                            <div class="progress-bar" role="progressbar" style="width: {{$bar_percentage}}%; background-color: {{$color_array[$unit->unit]}}" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div><small class="text-muted">{{$bar_percentage}}% dari target</small>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>


<!-- <div class="card">
    <div class="card-body">
        <hr>

        <div id="registrant_chart_bar" style="height: 300px;"></div>
       
    </div>
</div> -->
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
                }
            ]),
    });

    const registrant_chart_bar = new Chartisan({
        el: '#registrant_chart_bar',
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
                    type: 'bar', 
                    fill: false,
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
@endpush