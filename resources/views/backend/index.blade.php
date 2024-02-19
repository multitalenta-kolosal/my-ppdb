@extends('backend.layouts.app')

@section('title') 
    @lang("Dashboard") 
@endsection

@section('breadcrumbs')
<x-backend-breadcrumbs/>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-8">
                <h4 class="card-title mb-0"> 
                    @lang("Welcome to", ['name'=>config('app.name')])
                </h4>
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
        <hr>
        <div id="heregistrant_chart" style="height: 300px;"></div>
       
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

@can('inter_unit')
<div class="card">
    <div class="card-header">
        <h2>Data Peserta Didik by Jalur Pendaftaran</h2>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-sm-3">
                <div class="form-group">
                    <?php
                    $field_name = 'start_date';
                    $field_lable = "Start Date";
                    $field_placeholder = $field_lable;
                    $required = "";
                    ?>
                    {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
                    <div class="input-group date datetime" id="{{$field_name}}" data-target-input="nearest">
                        {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control datetimepicker-input')->attributes(["$required", 'data-target'=>"#$field_name"]) }}
                        <div class="input-group-append" data-target="#{{$field_name}}" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-3">
                <div class="form-group">
                    <?php
                    $field_name = 'end_date';
                    $field_lable = "End Date";
                    $field_placeholder = $field_lable;
                    $required = "";
                    ?>
                    {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
                    <div class="input-group date datetime" id="{{$field_name}}" data-target-input="nearest">
                        {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control datetimepicker-input')->attributes(["$required", 'data-target'=>"#$field_name"]) }}
                        <div class="input-group-append" data-target="#{{$field_name}}" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-3">
                <div class="form-group">
                    <?php
                    $field_name = 'unit';
                    $field_data_id = 'unit_id';
                    $field_lable = "Unit";
                    $field_placeholder = __("Select an option");
                    $required = "";
                    $select_options = \Modules\Core\Entities\Unit::pluck("name","id");

                    ?>
                    {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
                    {{ html()->select($field_data_id, $select_options)->placeholder($field_placeholder)->class('form-control select2') }}
                </div>
            </div>
            <div class="col-12 col-sm-3 d-flex mt-2 align-self-center">
                <button class="btn btn-lg btn-primary" id="filter-type">Filter</button>
            </div>
        </div>
        <div class="row justify-content-center" id="type-stats">
           -- Pilih Filter terlebih dahulu --
        </div>
    </div>
</div>
@endcan
<div class="card">
    <div class="card-body">
        <hr>

        <div id="path_chart_bar" style="height: 300px;"></div>
        <hr>

        <div id="hereg_path_chart_bar" style="height: 300px;"></div>
       
    </div>
</div>
@endsection

@push('after-scripts')

<!-- Charting library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
<!-- Chartisan -->
@php
 $chartisan_url = "https://cdn.jsdelivr.net/npm/@chartisan/chartjs@2.1.0/dist/chartisan_chartjs.umd.js";
@endphp
<script src="{{$chartisan_url}}"></script>

<x-library.datetime-picker />

<!-- Date Time Picker & Moment Js-->
<script type="text/javascript">
    $(function() {
        $('.datetime').datetimepicker({
            format: 'DD/MM/YYYY',
            icons: {
                time: 'far fa-clock',
                date: 'far fa-calendar-alt',
                up: 'fas fa-arrow-up',
                down: 'fas fa-arrow-down',
                previous: 'fas fa-chevron-left',
                next: 'fas fa-chevron-right',
                today: 'far fa-calendar-check',
                clear: 'far fa-trash-alt',
                close: 'fas fa-times'
            }
        });
    });
    
    $(document).ready(function() {
        $("#filter-type").on("click", function() {
            var unitId = $("#unit_id").val();
            var startDate = $("#start_date").data('datetimepicker').date();
            var endDate = $("#end_date").data('datetimepicker').date();

            if (unitId != "" && startDate != "" && endDate != "") {
                
                formattedStartDate = startDate.format("YYYY-MM-DD");
                formattedEndDate = endDate.format("YYYY-MM-DD");
                $.ajax({
                    url: "/admin/typeStats",
                    method: "GET",
                    data: {
                        unit_id: unitId,
                        start_date: formattedStartDate,
                        end_date: formattedEndDate
                    },
                    dataType: "html", // Expecting HTML data
                    success: function(data) {
                        $("#type-stats").html(data);
                    },
                    error: function(error) {
                        console.error("Ajax request failed:", error);
                    }
                });
            }else{
                alert("Lengkapi tanggal dan unit sebelum melakukan filtering");
            }
        });
    });
</script>

<script type="text/javascript">
    
    var chartUrl = "@chartisan('registrant_chart')"+"?periods="+$('#periods').val();
    const registrant_chart = new Chartisan({
        el: '#registrant_chart',
        url: chartUrl,
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

    var chartUrl = "@chartisan('heregistrant_chart')"+"?periods="+$('#periods').val();
    const heregistrant_chart = new Chartisan({
        el: '#heregistrant_chart',
        url: chartUrl,
        hooks: new ChartisanHooks()
            .title('Heregistran')
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
                url: "@chartisan('registrant_chart')"+"?periods="+$('#periods').val(),
            })

            heregistrant_chart.update({
                url: "@chartisan('heregistrant_chart')"+"?periods="+$('#periods').val(),
            })
        });
    });
</script>

<script>

    const path_chart_bar = new Chartisan({
        el: '#path_chart_bar',
        url: "@chartisan('path_chart_bar')",
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

    const hereg_path_chart_bar = new Chartisan({
        el: '#hereg_path_chart_bar',
        url: "@chartisan('hereg_path_chart_bar')",
        hooks: new ChartisanHooks()
            .title('Heregistran')
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