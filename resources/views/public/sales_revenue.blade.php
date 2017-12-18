@extends('admin_template')

@section('content')
<style>
    .cIndicator {
        padding:5px 10px;
        background-color: #e0e0e0;
        border: 1px solid #d0d0d0;
        margin: 10px;
        border-radius: 100%;
    }
    .cIndicator .fa-sort-desc {
        color: red;
    }
    .cIndicator .fa-sort-asc {
        color: green;
    }
    #chart, #reportTable, #mode1, #mode2, #cD, #btn-print {
        display: none;
    }
    .percUp {
        background-color: green;
        color: white;
        padding: 5px;
        vertical-align:middle;
    }
    .percDown {
        background-color: red;
        color: white;
        padding: 5px;
        vertical-align:middle;
    }

    @media print
    {    
        .no-print, .no-print *
        {
            display: none !important;
        }
    }
</style>
<div class="row">
    <div class="col-md-3 no-print">
        <div class="box box-solid box-warning">
            <div class="box-header">
                <h3 class="box-title">Select the type of report</h3>
            </div>
            <div class="box-body">
                <!-- <button class="btn btn-warning btn-block" id="showReportByMonth">Report By Month</button>
                <button class="btn btn-default btn-block" id="showReportByYear">Report By Year</button> -->
                <button class="btn btn-warning btn-block" id="showReportM2M">M2M Report</button>
                <!-- <button class="btn btn-default btn-block" id="showReportM2Y">M2Y Report</button> -->
                <button class="btn btn-default btn-block" id="showReportY2Y">Y2Y Report</button>
            </div>
        </div>
        <div class="setting-wrapper">
            <div class="small-box bg-red" id="ReportM2MSetting">
                <div class="inner">
                    <h3>M2M</h3>
                    <p>Month to Month Report</p>
                </div>
                <div class="icon"><i class="fa fa-table"></i></div>
                <a href="#" class="small-box-footer" data-toggle="modal" style="padding: 20px" data-target="#detailOOS">
                    <div class="form-group">
                        <label>Name Of Company</label>
                        <select id="M2MClient" class="form-control selectpicker" data-live-search="true">
                            <option value="0">All</option>
                            @foreach($clients as $item)
                            <option value="{{ $item->id }}">{{ $item->name_of_company }}</option>
                            @endforeach
                        </select>
                    </div>    
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Month 1</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input type="text" id="M2MMonth1" class="form-control monthpicker">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                        <div class="form-group">
                                <label>Month 2</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input type="text" id="M2MMonth2" class="form-control monthpicker">
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-warning btn-lg btn-block" id="M2MBtn">Get Report</button>
                    </div>
                </a>
            </div><!-- M2M -->

            <div class="small-box bg-red hide" id="ReportY2YSetting">
                <div class="inner">
                    <h3>Y2Y</h3>
                    <p>Year to Year Report</p>
                </div>
                <div class="icon"><i class="fa fa-table"></i></div>
                <a href="#" class="small-box-footer" data-toggle="modal" style="padding: 20px" data-target="#detailOOS">
                <div class="form-group">
                    <label>Name Of Company</label>
                    <select id="Y2YClient" class="form-control selectpicker" data-live-search="true">
                        <option value="0">All</option>
                        @foreach($clients as $item)
                        <option value="{{ $item->id }}">{{ $item->name_of_company }}</option>
                        @endforeach
                    </select>
                </div>    
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Month 1</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input type="text" id="Y2YMonth1" class="form-control monthpicker">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                    <div class="form-group">
                            <label>Month 2</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            <input type="text" id="Y2YMonth2" class="form-control monthpicker">
                        </div>
                    </div>
                    </div>
                </div>
                    <div class="form-group">
                        <button class="btn btn-warning btn-lg btn-block" id="Y2YBtn">Get Report</button>
                    </div>
                </a>
            </div><!-- M2Y -->
        </div>
    </div>
    <div class="col-md-9">
        <div class="jumbotron text-center" id="reportPlaceholder" style="background-color: white;">
            <h2 class="text-muted"><em>Please select the type of report!</em></h2>
        </div>
        
        <button class="btn btn-success pull-right no-print" id="btn-print" onclick="window.print()"><i class="fa fa-print"></i> Print</button>        
        <div class="clearfix"></div>
        <br>
        <div class="box box-success" id="cD">
            <div class="box-header with-border">
                <h3 class="box-title">Company Description</h3>
            </div>
            <div class="box-body">
                <table class="table table-bordered">
                    <tr>
                        <td rowspan="11" class="bg-green text-center" style="vertical-align:middle;"><i class="fa fa-building fa-5x"></i></td>
                        <td><strong>Classification</strong></td>
                        <td>:</td>
                        <td id="cDClassification"></td>
                    </tr>
                    <tr>
                        <td><strong>Name Of Company</strong></td>
                        <td>:</td>
                        <td id="cDNameOfCompany"></td>
                    </tr>
                    <tr>
                        <td><strong>Sales Rep.</strong></td>
                        <td>:</td>
                        <td id="cDSalesRep"></td>
                    </tr>
                    <tr>
                        <td colspan="3"><a href="#" class="btn btn-block btn-default" target="_blank">Company Details <i class="fa fa-arrow-right"></i></a></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="box box-danger" id="chart">
            <canvas id="myChart" width="700" height="300"></canvas>
        </div>
        <div class="box box-default" id="reportTable">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-table"></i> Sales Revenue Performance <span id="dateRange">{ month1 - month2 }</span></h3>
            </div>
            <div class="box-body">
                <table class="table table-bordered table-striped" id="mode1">
                    <thead>
                        <tr>
                            <th rowspan="3" class="text-center" style="vertical-align:middle">Subject</th>
                            <th colspan="6" class="text-center">Revenue (Rp)</th>
                            <th rowspan="3" class="text-center" style="vertical-align:middle">Differential</th>
                            <th rowspan="3" class="text-center" style="vertical-align:middle">%</th>
                        </tr>
                        <tr>
                            <th colspan="3"><span id="month1">{ Month 1 }</span></th>
                            <th colspan="3"><span id="month2">{ Month 2 }</span></th>
                        </tr>
                        <tr>
                            <th>Gross</th>
                            <th>Netto</th>
                            <th>Profit</th>
                            <th>Gross</th>
                            <th>Netto</th>
                            <th>Profit</th>
                        </tr>
                    </thead>
                    <thead>
                        <tr>
                            <th colspan="9" class="text-center"><strong>Domestic Airlines</strong></th>
                        </tr>
                    </thead>
                    <tbody id="cat1">
                    </tbody>
                    <thead>
                        <tr>
                            <th colspan="9" class="text-center"><strong>International Airlines</strong></th>
                        </tr>
                    </thead>
                    <tbody id="cat2">
                    </tbody>
                    <thead>
                        <tr>
                            <th colspan="9" class="text-center"><strong>Tour</strong></th>
                        </tr>
                    </thead>
                    <tbody id="cat3">
                    </tbody>
                    <thead>
                        <tr>
                            <th colspan="9" class="text-center"><strong>Others</strong></th>
                        </tr>
                    </thead>
                    <tbody id="cat4">
                    </tbody>
                </table>
                <table class="table table-bordered table-striped" id="mode2">
                    <thead>
                        <tr>
                            <th rowspan="2" style="vertical-align:middle;text-align:center;">Month</th>
                            <th colspan="3" style="vertical-align:middle;text-align:center;">Revenue</th>
                            <th rowspan="2" style="vertical-align:middle;text-align:center;">Differential</th>
                            <th rowspan="2" style="vertical-align:middle;text-align:center;">Percent</th>
                        </tr>
                        <tr>
                            <th style="vertical-align:middle;text-align:center;">Gross</th>
                            <th style="vertical-align:middle;text-align:center;">Netto</th>
                            <th style="vertical-align:middle;text-align:center;">Profit</th>
                        </tr>
                    </thead>
                    <tbody id="mode2Content">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(function(){
        $('.datatables').DataTable({
            "bSort" : false
        });
        $('[data-toggle="tooltip"]').tooltip();
        $('.selectpicker').selectpicker({
            style: 'btn-default',
            size: 5
        });
        $(".monthpicker").datepicker( {
            format: "mm-yyyy",
            viewMode: "months", 
            minViewMode: "months"
        });
        $(".yearpicker").datepicker( {
            format: "yyyy",
            viewMode: "years", 
            minViewMode: "years"
        });

        // $("#showReportByMonth").click(function(){
        //     $(this).removeClass('btn-default').addClass('btn-warning').siblings().removeClass('btn-warning').addClass('btn-default');
        //     $("#ReportByMonthSetting").removeClass('hide').siblings().addClass('hide');
        // });
        // $("#showReportByYear").click(function(){
        //     $(this).removeClass('btn-default').addClass('btn-warning').siblings().removeClass('btn-warning').addClass('btn-default');
        //     $("#ReportByYearSetting").removeClass('hide').siblings().addClass('hide');
        // });
        $("#showReportM2M").click(function(){
            $(this).removeClass('btn-default').addClass('btn-warning').siblings().removeClass('btn-warning').addClass('btn-default');
            $("#ReportM2MSetting").removeClass('hide').siblings().addClass('hide');
        });
        // $("#showReportM2Y").click(function(){
        //     $(this).removeClass('btn-default').addClass('btn-warning').siblings().removeClass('btn-warning').addClass('btn-default');
        //     $("#ReportM2YSetting").removeClass('hide').siblings().addClass('hide');
        // });
        $("#showReportY2Y").click(function(){
            $(this).removeClass('btn-default').addClass('btn-warning').siblings().removeClass('btn-warning').addClass('btn-default');
            $("#ReportY2YSetting").removeClass('hide').siblings().addClass('hide');
        });

        // Get Data M2M
        $("#M2MBtn").click(function(){
            var client = $("#M2MClient").val();
            var month1 = $("#M2MMonth1").val();
            var month2 = $("#M2MMonth2").val();
            
            $.ajax({
                url : '{{ url('api/sales/revenue/m2m') }}',
                data : { client : client, month1 : month1, month2 : month2 },
                type : 'GET',
                dataType : 'json',
                success : function(json){
                    
                    $("#reportPlaceholder").fadeOut('slow');
                    $("#chart").fadeIn('slow');
                    $("#reportTable").fadeIn('slow');
                    $("#btn-print").fadeIn('slow');

                    $("#dateRange").html("<strong><em>"+json.chart.labels[0]+" - "+json.chart.labels.slice(-1)[0]+"</em></strong>");
                    
                    if(json.company){

                        var classification;
                        if(json.company[0]['classification'] == 1 ){
                            classification = 'General Trading';
                        }else if(json.company[0]['classification'] == 2 ){
                            classification = 'Mining';
                        }else{
                            classification = 'Others';
                        }

                        $("#cDClassification").html(classification);
                        $("#cDNameOfCompany").html(json.company[0]['name_of_company']);
                        $("#cDSalesRep").html(json.company[0]['sales_rep']);
                        $("#cD").find('.btn').attr('href', '{{ url("sales/client-status/") }}/' + json.company[0]['id']);
                        $("#cD").fadeIn('slow');
                    }else{
                        $("#cD").fadeOut('slow');                        
                    }

                    if(json.mode == 1){
                        var cat1, cat2, cat3, cat4;
                        $.each(json.table, function(i,n){
                            // Domestic Airlines
                            if(i == 1){
                                $.each(n, function(a,b){
                                    cat1 += "<tr><td><strong>" + a + "</strong></td>";

                                    $.each(b, function(c,d){
                                        cat1 += "<td>" + delimitNumbers(d['gross']) + "</td>";
                                        cat1 += "<td>" + delimitNumbers(d['netto']) + "</td>";
                                        cat1 += "<td>" + delimitNumbers(d['profit']) + "</td>";
                                    });

                                    if(b.length > 1){
                                        var diff = (b[1]['profit'] - b[0]['profit']);
                                        var perc = diff / (b[0]['profit']/100);
                                        cat1 += "<td>" + delimitNumbers(diff) +"</td>";
                                        cat1 += "<td>" + perc +"%";
                                        if(perc < 0){ cat1 += "<img src='{{ asset('images/down.png') }}'  class='pull-right' />"; }else if(perc > 0){ cat1 += "<img src='{{ asset('images/up.png') }}'  class='pull-right' />"; }                                         
                                        cat1 += "</td>";
                                    }

                                    cat1 += "</tr>";

                                    $("#cat1").html(cat1);
                                });
                            }
                            // International Airlines
                            if(i == 2){
                                $.each(n, function(a,b){
                                    cat2 += "<tr><td><strong>" + a + "</strong></td>";

                                    $.each(b, function(c,d){
                                        cat2 += "<td>" + delimitNumbers(d['gross']) + "</td>";
                                        cat2 += "<td>" + delimitNumbers(d['netto']) + "</td>";
                                        cat2 += "<td>" + delimitNumbers(d['profit']) + "</td>";
                                    });

                                    if(b.length > 1){
                                        var diff = (b[1]['profit'] - b[0]['profit']);
                                        var perc = diff / (b[0]['profit']/100);
                                        cat2 += "<td>" + delimitNumbers(diff) +"</td>";
                                        cat2 += "<td>" + perc +"%";
                                        if(perc < 0){ cat2 += "<img src='{{ asset('images/down.png') }}'  class='pull-right' />"; }else if(perc > 0){ cat2 += "<img src='{{ asset('images/up.png') }}'  class='pull-right' />"; }                                         
                                        cat2 += "</td>";
                                    }

                                    cat2 += "</tr>";

                                    $("#cat2").html(cat2);
                                });
                            }
                            // Tour
                            if(i == 3){
                                $.each(n, function(a,b){
                                    cat3 += "<tr><td><strong>" + a + "</strong></td>";

                                    $.each(b, function(c,d){
                                        cat3 += "<td>" + delimitNumbers(d['gross']) + "</td>";
                                        cat3 += "<td>" + delimitNumbers(d['netto']) + "</td>";
                                        cat3 += "<td>" + delimitNumbers(d['profit']) + "</td>";
                                    });

                                    if(b.length > 1){
                                        var diff = (b[1]['profit'] - b[0]['profit']);
                                        var perc = diff / (b[0]['profit']/100);
                                        cat3 += "<td>" + delimitNumbers(diff) +"</td>";
                                        cat3 += "<td>" + perc +"%";
                                        if(perc < 0){ cat3 += "<img src='{{ asset('images/down.png') }}'  class='pull-right' />"; }else if(perc > 0){ cat3 += "<img src='{{ asset('images/up.png') }}'  class='pull-right' />"; }                                         
                                        cat3 += "</td>";
                                    }

                                    cat3 += "</tr>";

                                    $("#cat3").html(cat3);
                                });
                            }
                            // Others
                            if(i == 4){
                                $.each(n, function(a,b){
                                    cat4 += "<tr><td><strong>" + a + "</strong></td>";

                                    $.each(b, function(c,d){
                                        cat4 += "<td>" + delimitNumbers(d['gross']) + "</td>";
                                        cat4 += "<td>" + delimitNumbers(d['netto']) + "</td>";
                                        cat4 += "<td>" + delimitNumbers(d['profit']) + "</td>";
                                    });

                                    if(b.length > 1){
                                        var diff = (b[1]['profit'] - b[0]['profit']);
                                        var perc = diff / (b[0]['profit']/100);
                                        cat4 += "<td>" + delimitNumbers(diff) +"</td>";
                                        cat4 += "<td>" + perc +"%";
                                        if(perc < 0){ cat4 += "<img src='{{ asset('images/down.png') }}'  class='pull-right' />"; }else if(perc > 0){ cat4 += "<img src='{{ asset('images/up.png') }}'  class='pull-right' />"; }                                         
                                        cat4 += "</td>";
                                    }

                                    cat4 += "</tr>";

                                    $("#cat4").html(cat4);
                                });
                            }
                        });

                        $("#mode1").find("#month1").html(json.chart.labels[0]);
                        $("#mode1").find("#month2").html(json.chart.labels[1]);
                        $("#mode1").fadeIn('slow');
                        $("#mode2").fadeOut();
                    }else{
                        var html;
                        $.each(json.report, function(i,n){
                            html += "<tr>";
                            html += "<td><strong>"+ n['month'] +"</strong></td>";
                            html += "<td>"+ n['sum_gross'] +"</td>";
                            html += "<td>"+ n['sum_netto'] +"</td>";
                            html += "<td>"+ n['sum_profit'] +"</td>";
                            html += "<td>"+ json.differentials[i] +"</td>";
                            html += "<td>" + json.percents[i] +"%";
                            if(json.percents[i] < 0){ html += "<img src='{{ asset('images/down.png') }}'  class='pull-right' />"; }else if(json.percents[i] > 0){ html += "<img src='{{ asset('images/up.png') }}'  class='pull-right' />"; } 
                            // if(json.percents[i] < 0){ html += "<span class='percDown'><i class='fa fa-sort-desc fa-2x'></i></span>"; }else if(json.percents[i] > 0){ html += "<span class='percUp'><i class='fa fa-sort-asc fa-2x'></i></span>"; } 
                            html += "</td>";
                            html += "</tr>";
                        });
                        $("#mode2Content").html(html);
                        $("#mode1").fadeOut();
                        $("#mode2").fadeIn('slow');
                    }
                    
                    var ctx = document.getElementById("myChart").getContext('2d');
                    var myChart = new Chart(ctx, {
                        type: 'line',
                        data: json.chart,
                        options: {
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero:true
                                    }
                                }]
                            },
                        }
                    });
                }
            });
        });

        function delimitNumbers(str) {
            return (str + "").replace(/\b(\d+)((\.\d+)*)\b/g, function(a, b, c) {
                return (b.charAt(0) > 0 && !(c || ".").lastIndexOf(".") ? b.replace(/(\d)(?=(\d{3})+$)/g, "$1,") : b) + c;
            });
        }
    });
</script>
<script>
</script>
@endsection