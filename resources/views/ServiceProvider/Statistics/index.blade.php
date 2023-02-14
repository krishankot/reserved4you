@extends('layouts.serviceProvider')
@section('service_title')
    Statistics
@endsection
@section('service_css')
    <?php
    use App\Models\StoreProfile;
    $getStore = StoreProfile::where('user_id', Auth::user()->id)->get();
    ?>
    <style>
        .transac-tab {
            margin-left: auto;
        }

        .statistic-margin {
            margin-top: -42px;
        }
        .statistic-margin .nice-select.select.selectyear {
            width: 66%;
        }

        .statistic-margin .right-left-arrow a {
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
@endsection
@section('service_content')

    <div class="main-content">
        <h2 class="page-title static-page-title">Statistiken</h2>
        <div class="row">
            <div class="col-lg-6">
                <div class="booking-chart">
                    <p>Erledigte Buchungen</p>
                    <div class="booking-date">
                        <ul class="nav nav-pills area-pills business-pills transac-tab" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="pills-transaction-tab" data-toggle="pill" href="#stastic-week" role="tab" aria-controls="pills-transaction" aria-selected="true">Woche</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="pills-refunds-tab" data-toggle="pill" href="#stastic-month" role="tab" aria-controls="pills-refund" aria-selected="false">Monat </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="pills-withdraw-tab" data-toggle="pill" href="#stastic-year" role="tab" aria-controls="pills-withdraw" aria-selected="false">Jahr</a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content owl-buttons" id="pills-tabContent">
                        <div class="tab-pane fade active show" id="stastic-week" role="tabpanel" aria-labelledby="pills-transaction-tab">
                            <div class="statistic-margin">
                                <div class="select-year select-float-none">

                                    {{Form::select('select_week',$weekData,'',array('class'=>'select selectweek','data-value'=>'complete'))}}
{{--                                    <div class="right-left-arrow">--}}
{{--                                        <a href="#"><img src="{{URL::to('storage/app/public/Serviceassets/images/icon/arrow.svg')}}" alt=""></a>--}}
{{--                                        <a href="#"><img src="{{URL::to('storage/app/public/Serviceassets/images/icon/arrow-right.svg')}}" alt=""></a>--}}
{{--                                    </div>--}}
                                </div>
                                <div class="chart-earning myChart-statistic">
                                    <canvas id="myChart-statistic"></canvas>
                                </div>
                                
                                
                            </div>
                        </div>
                        <div class="tab-pane fade  show" id="stastic-month" role="tabpanel" aria-labelledby="pills-transaction-tab">
                            <div class="statistic-margin">
                                <div class="select-year select-float-none">
                                    {{Form::select('select_month',$monthData,'',array('class'=>'select selectmonth','data-value'=>'complete'))}}
{{--                                    <div class="right-left-arrow">--}}
{{--                                        <a href="#"><img src="{{URL::to('storage/app/public/Serviceassets/images/icon/arrow.svg')}}" alt=""></a>--}}
{{--                                        <a href="#"><img src="{{URL::to('storage/app/public/Serviceassets/images/icon/arrow-right.svg')}}" alt=""></a>--}}
{{--                                    </div>--}}
                                </div>
                                <div class="customer-chart myChart-statistic-month">
                                    
                                    <canvas id="myChart-statistic-month" class="mychart-stat" ></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade  show" id="stastic-year" role="tabpanel" aria-labelledby="pills-transaction-tab">
                            <div class="statistic-margin">
                                <div class="select-year select-float-none">
                                    {{Form::select('select_year',$yearData,'',array('class'=>'select selectyear','data-value'=>'complete'))}}
{{--                                    <div class="right-left-arrow">--}}
{{--                                        <a href="#"><img src="{{URL::to('storage/app/public/Serviceassets/images/icon/arrow.svg')}}" alt=""></a>--}}
{{--                                        <a href="#"><img src="{{URL::to('storage/app/public/Serviceassets/images/icon/arrow-right.svg')}}" alt=""></a>--}}
{{--                                    </div>--}}
                                </div>
                                <div class="customer-chart myChart-statistic-year">
                                    <canvas id="myChart-statistic-year" class="mychart-stat"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="booking-chart">
                    <p>Einnahmen</p>
                    <div class="booking-date">
                        <ul class="nav nav-pills area-pills business-pills transac-tab" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="pills-transaction-tab" data-toggle="pill" href="#day_earning" role="tab" aria-controls="pills-transaction" aria-selected="true">Tag</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link " id="pills-transaction-tab" data-toggle="pill" href="#week_earning" role="tab" aria-controls="pills-transaction" aria-selected="true">Woche</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="pills-refunds-tab" data-toggle="pill" href="#month_earning" role="tab" aria-controls="pills-refund" aria-selected="false">Monat </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="pills-withdraw-tab" data-toggle="pill" href="#year_earning" role="tab" aria-controls="pills-withdraw" aria-selected="false">Jahr</a>
                            </li>
                        </ul>
                    </div>

                    <div class="tab-content owl-buttons" id="pills-tabContent">
                        <div class="tab-pane fade active show" id="day_earning" role="tabpanel" aria-labelledby="pills-transaction-tab">
                            <div class="statistic-margin">
                                <div class="select-year">
                                    {{Form::select('select_day',$dayData,'',array('class'=>'select selectday','data-value'=>'earning'))}}
{{--                                    <div class="right-left-arrow">--}}
{{--                                        <a href="#"><img src="{{URL::to('storage/app/public/Serviceassets/images/icon/arrow.svg')}}" alt=""></a>--}}
{{--                                        <a href="#"><img src="{{URL::to('storage/app/public/Serviceassets/images/icon/arrow-right.svg')}}" alt=""></a>--}}
{{--                                    </div>--}}
                                </div>
                                <div class="chart-earning myChart_earning">
                                    <canvas id="myChart_earning" ></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade  show" id="week_earning" role="tabpanel" aria-labelledby="pills-transaction-tab">
                            <div class="statistic-margin">
                                <div class="select-year">
                                    {{Form::select('select_week',$weekData,'',array('class'=>'select selectweek','data-value'=>'earning'))}}
{{--                                    <div class="right-left-arrow">--}}
{{--                                        <a href="#"><img src="{{URL::to('storage/app/public/Serviceassets/images/icon/arrow.svg')}}" alt=""></a>--}}
{{--                                        <a href="#"><img src="{{URL::to('storage/app/public/Serviceassets/images/icon/arrow-right.svg')}}" alt=""></a>--}}
{{--                                    </div>--}}
                                </div>
                                <div class="chart-earning myChart_earning_week">
                                    <canvas id="myChart_earning_week" ></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade  show" id="month_earning" role="tabpanel" aria-labelledby="pills-transaction-tab">
                            <div class="statistic-margin">
                                <div class="select-year">
                                    {{Form::select('select_month',$monthData,'',array('class'=>'select selectmonth','data-value'=>'earning'))}}
{{--                                    <div class="right-left-arrow">--}}
{{--                                        <a href="#"><img src="{{URL::to('storage/app/public/Serviceassets/images/icon/arrow.svg')}}" alt=""></a>--}}
{{--                                        <a href="#"><img src="{{URL::to('storage/app/public/Serviceassets/images/icon/arrow-right.svg')}}" alt=""></a>--}}
{{--                                    </div>--}}
                                </div>
                                <div class="chart-earning myChart_earning_month">
                                    <canvas id="myChart_earning_month" ></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade  show" id="year_earning" role="tabpanel" aria-labelledby="pills-transaction-tab">
                            <div class="statistic-margin">
                                <div class="select-year">
                                    {{Form::select('select_year',$yearData,'',array('class'=>'select selectyear','data-value'=>'earning'))}}

{{--                                    <div class="right-left-arrow">--}}
{{--                                        <a href="#"><img src="{{URL::to('storage/app/public/Serviceassets/images/icon/arrow.svg')}}" alt=""></a>--}}
{{--                                        <a href="#"><img src="{{URL::to('storage/app/public/Serviceassets/images/icon/arrow-right.svg')}}" alt=""></a>--}}
{{--                                    </div>--}}
                                </div>
                                <div class="chart-earning myChart_earning_year">
                                    <canvas id="myChart_earning_year" ></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="booking-chart">
                    <p>Kunden</p>
                    <div class="booking-date">
                        <ul class="nav nav-pills area-pills business-pills transac-tab" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link " id="pills-transaction-tab" data-toggle="pill" href="#day" role="tab" aria-controls="pills-transaction" aria-selected="true">Tag</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link " id="pills-transaction-tab" data-toggle="pill" href="#week" role="tab" aria-controls="pills-transaction" aria-selected="true">Woche</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="pills-refunds-tab" data-toggle="pill" href="#month" role="tab" aria-controls="pills-refund" aria-selected="false">Monat </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="pills-withdraw-tab" data-toggle="pill" href="#year" role="tab" aria-controls="pills-withdraw" aria-selected="false">Jahr</a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content owl-buttons" id="pills-tabContent">
                        <div class="tab-pane fade  show" id="day" role="tabpanel" aria-labelledby="pills-transaction-tab">
                            <div class="statistic-margin">
                                <div class="select-year">
                                    {{Form::select('select_day',$dayData,'',array('class'=>'select selectday','data-value'=>'customer'))}}
{{--                                    <div class="right-left-arrow">--}}
{{--                                        <a href="#"><img src="{{URL::to('storage/app/public/Serviceassets/images/icon/arrow.svg')}}" alt=""></a>--}}
{{--                                        <a href="#"><img src="{{URL::to('storage/app/public/Serviceassets/images/icon/arrow-right.svg')}}" alt=""></a>--}}
{{--                                    </div>--}}
                                </div>
                                <div class="chart myChart">
                                    <canvas id="myChart"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade show" id="week" role="tabpanel" aria-labelledby="pills-transaction-tab">
                            <div class="statistic-margin">
                                <div class="select-year">
                                    {{Form::select('select_week',$weekData,'',array('class'=>'select selectweek','data-value'=>'customer'))}}
{{--                                    <div class="right-left-arrow">--}}
{{--                                        <a href="#"><img src="{{URL::to('storage/app/public/Serviceassets/images/icon/arrow.svg')}}" alt=""></a>--}}
{{--                                        <a href="#"><img src="{{URL::to('storage/app/public/Serviceassets/images/icon/arrow-right.svg')}}" alt=""></a>--}}
{{--                                    </div>--}}
                                </div>
                                <div class="chart_week myChart_week">
                                    <canvas id="myChart_week"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade active show" id="month" role="tabpanel" aria-labelledby="pills-transaction-tab">
                            <div class="statistic-margin">
                                <div class="select-year">
                                    {{Form::select('select_month',$monthData,'',array('class'=>'select selectmonth','data-value'=>'customer'))}}
{{--                                    <div class="right-left-arrow">--}}
{{--                                        <a href="#"><img src="{{URL::to('storage/app/public/Serviceassets/images/icon/arrow.svg')}}" alt=""></a>--}}
{{--                                        <a href="#"><img src="{{URL::to('storage/app/public/Serviceassets/images/icon/arrow-right.svg')}}" alt=""></a>--}}
{{--                                    </div>--}}
                                </div>
                                <div class="chart_month myChart_month">
                                    <canvas id="myChart_month"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade show" id="year" role="tabpanel" aria-labelledby="pills-transaction-tab">
                            <div class="statistic-margin">
                                <div class="select-year">
                                    {{Form::select('select_year',$yearData,'',array('class'=>'select selectyear','data-value'=>'customer'))}}
{{--                                    <div class="right-left-arrow">--}}
{{--                                        <a href="#"><img src="{{URL::to('storage/app/public/Serviceassets/images/icon/arrow.svg')}}" alt=""></a>--}}
{{--                                        <a href="#"><img src="{{URL::to('storage/app/public/Serviceassets/images/icon/arrow-right.svg')}}" alt=""></a>--}}
{{--                                    </div>--}}
                                </div>
                                <div class="chart_year myChart_year">
                                    <canvas id="myChart_year"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="booking-chart">
                    <p>Meist gebuchte Services</p>
                </div>

                <div class="service-book">
                    @foreach ($mservice as $row)
                    <div class="service-1">
                        <div class="imgservice">
                            <img src="{{$row['image']}}" alt="">
                        </div>
                        <div class="service-info">
                            <p>Service</p>
                            <h6><a href="#">{{$row['category']}} - {{$row['service_name']}}</a></h6>
                        </div>
                        <div class ="service-booked">
                            <p>Gebucht</p>
                            <h6>{{$row['count']}}</h6>
                        </div>
                    </div>
                    @endforeach


                </div>

            </div>

        </div>

        <div class="sales-by-channel">
            <p>Einnahmen der Mitarbeiter</p>
            <div class="income">
                <h6>Sortieren nach</h6>
                <select class="select selectyear ladies-hair sales-channel" style="display: none;">
                    <option>Einnahmen absteigend</option>
                    <option>Einnahmen absteigend</option>
                    <option>Einnahmen absteigend</option>
                    <option>Einnahmen absteigend</option>
                </select>

            </div>
        </div>
        <div class="employee-list">

            @foreach ($employeeData as $row)
            <div class="employee-list-1">
                <div class="employee-info">
                    <div class="employee-img">
                        <img src="{{$row['image']}}">
                    </div>
                    <div class="employe-name">
                        <h6>{{$row['name']}}</h6>
                        <p>Mitarbeiter ID: <span>{{$row['employee_id']}}</span></p>
                    </div>
                    <a href="{{URL::to('dienstleister/mitarbeiter-details/'.encrypt($row['id']))}}" class="employeeicon"><img src="{{URL::to('storage/app/public/Serviceassets/images/earning-employe/foreign.svg')}}"></a>
                </div>
                <div class="employee-earning">
                    <div class="emp-earn">
                        <h6>{{number_format($row['amount'], 2, ',', '.')}}€</h6>
                        <p>Gesamt Einnahmen</p>
                    </div>
                    <div class="com-booking">
                        <h6>{{$row['booking']}}</h6>
                        <p>Erledigte Buchungen</p>
                    </div>
                </div>
            </div>

            @endforeach

        </div>
    </div>
@endsection
@section('service_js')
    <script src="{{URL::to('storage/app/public/Serviceassets/js/mychart.js')}}"></script>
    <script>
        /**
         * Complete Booking Start
         */
        var completedBookingWeeks  = <?php  echo json_encode($completedBooking)?>;
        var weeklabel = [];
        var weekdata = [];
        $.each(completedBookingWeeks,function (i,row){
            weeklabel.push(row.date);
            weekdata.push(row.count);
        });
        completedbookingWeek(weeklabel,weekdata);

        var completedBookingMonth = <?php  echo json_encode($completedBookingMonth)?>;
        var monthlabel = [];
        var monthdata = [];
        $.each(completedBookingMonth,function (i,row){
            monthlabel.push(row.date);
            monthdata.push(row.count);
        });
        completedbookingMonthly(monthlabel,monthdata);

        var completedBookingYear = <?php  echo json_encode($completedBookingYear)?>;
        var yearlabel = [];
        var yeardata = [];
        $.each(completedBookingYear,function (i,row){
            yearlabel.push(row.date);
            yeardata.push(row.count);
        });
        completedbookingYearly(yearlabel,yeardata);
        /**
         * Complete Booking End
         */

        /**
         * Earning Start
         */
        var earningday  = <?php  echo json_encode($earningDay)?>;
        var daylabel = [];
        var daydata = [];
        $.each(earningday,function (i,row){
            daylabel.push(row.date);
            daydata.push(row.count);
        });
        earningDayData(daylabel,daydata);

        var earningweek  = <?php  echo json_encode($earningWeek)?>;
        var weeklabel = [];
        var weekdata = [];
        $.each(earningweek,function (i,row){
            weeklabel.push(row.date);
            weekdata.push(row.count);
        });
        earningWeekData(weeklabel,weekdata);

        var earningmonth  = <?php  echo json_encode($earningMonth)?>;

        var monthlabel = [];
        var monthdata = [];
        $.each(earningmonth,function (i,row){
            monthlabel.push(row.date);
            monthdata.push(row.count);
        });
        earningMonthData(monthlabel,monthdata);

        var earningyear  = <?php  echo json_encode($earningYear)?>;
        var yearlabel = [];
        var yeardata = [];
        $.each(earningyear,function (i,row){
            yearlabel.push(row.date);
            yeardata.push(row.count);
        });
        earningYearData(yearlabel,yeardata);
        /**
         * Earning End
         */

        /**
         * Customer Start
         */

        var customerDay  = <?php  echo json_encode($customerDay)?>;
        var daylabel = [];
        var daydata = [];
        $.each(customerDay,function (i,row){
            daylabel.push(row.date);
            daydata.push(row.count);
        });
        customerDays(daylabel,daydata);

        var customerWeek  = <?php  echo json_encode($customerWeek)?>;
        var weeklabel = [];
        var weekdata = [];
        $.each(customerWeek,function (i,row){
            weeklabel.push(row.date);
            weekdata.push(row.count);
        });
        customerWeeks(weeklabel,weekdata);

        var customerMonth  = <?php  echo json_encode($customerMonth)?>;

        var monthlabel = [];
        var monthdata = [];
        $.each(customerMonth,function (i,row){
            monthlabel.push(row.date);
            monthdata.push(row.count);
        });
        customerMonths(monthlabel,monthdata);

        var customerYear  = <?php  echo json_encode($customerYear)?>;
        var yearlabel = [];
        var yeardata = [];
        $.each(customerYear,function (i,row){
            yearlabel.push(row.date);
            yeardata.push(row.count);
        });
        customerYears(yearlabel,yeardata);

        /**
         * Customer End
         */
    </script>
    <script>
        $(document).on('change','.selectday',function (){
            var id = $(this).val();
            var value = $(this).data('value');

            $.ajax({
                type: 'POST',
                url: "{{URL::to('service-provider/statistics/get-day-data')}}",
                data: {
                    _token: '{{csrf_token()}}',
                    id: id,
                    value: value,
                },
                success: function (response) {
                    var daylabel = [];
                    var daydata = [];

                    $.each(response,function (i,row){
                        daylabel.push(row.date);
                        daydata.push(row.count);
                    });

                    if(value == 'customer'){
                        customerDays(daylabel,daydata);
                    }
                    if(value == 'earning'){
                        earningDayData(daylabel,daydata);
                    }
                },
                error: function (error) {


                }
            });

        });

        $(document).on('change','.selectweek',function (){
            var id = $(this).val();
            var value = $(this).data('value');

            $.ajax({
                type: 'POST',
                url: "{{URL::to('service-provider/statistics/get-week-data')}}",
                data: {
                    _token: '{{csrf_token()}}',
                    id: id,
                    value: value,
                },
                success: function (response) {
                    var daylabel = [];
                    var daydata = [];

                    $.each(response,function (i,row){
                        daylabel.push(row.date);
                        daydata.push(row.count);
                    });

                    if(value == 'customer'){
                        customerWeeks(daylabel,daydata);
                    }
                    if(value == 'earning'){
                        earningWeekData(daylabel,daydata);
                    }
                    if(value == 'complete'){
                        completedbookingWeek(daylabel,daydata);
                    }
                },
                error: function (error) {


                }
            });
        });

        $(document).on('change','.selectmonth',function (){
            var id = $(this).val();
            var value = $(this).data('value');

            $.ajax({
                type: 'POST',
                url: "{{URL::to('service-provider/statistics/get-month-data')}}",
                data: {
                    _token: '{{csrf_token()}}',
                    id: id,
                    value: value,
                },
                success: function (response) {
                    var daylabel = [];
                    var daydata = [];

                    $.each(response,function (i,row){
                        daylabel.push(row.date);
                        daydata.push(row.count);
                    });

                    if(value == 'customer'){
                        customerMonths(daylabel,daydata);
                    }
                    if(value == 'earning'){
                        earningMonthData(daylabel,daydata);
                    }
                    if(value == 'complete'){
                        completedbookingMonthly(daylabel,daydata);
                    }
                },
                error: function (error) {


                }
            });
        });

        $(document).on('change','.selectyear',function (){
            var id = $(this).val();
            var value = $(this).data('value');

            $.ajax({
                type: 'POST',
                url: "{{URL::to('service-provider/statistics/get-year-data')}}",
                data: {
                    _token: '{{csrf_token()}}',
                    id: id,
                    value: value,
                },
                success: function (response) {
                    var daylabel = [];
                    var daydata = [];

                    $.each(response,function (i,row){
                        daylabel.push(row.date);
                        daydata.push(row.count);
                    });

                    if(value == 'customer'){
                        customerYears(daylabel,daydata);
                    }
                    if(value == 'earning'){
                        earningYearData(daylabel,daydata);
                    }
                    if(value == 'complete'){
                        completedbookingYearly(daylabel,daydata);
                    }
                },
                error: function (error) {


                }
            });
        });
    </script>
   
@endsection
