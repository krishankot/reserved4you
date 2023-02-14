@extends('layouts.serviceProvider')
@section('service_title')
    Order Confirmation
@endsection
@section('service_css')
@endsection
@section('service_content')
    <div class="main-content">
        <div class="booking-con text-center">
            <div class="booking">
                <h3>Buchung bestätigt!</h3>
                <p>Glückwunsch! Dein Termin wurde erfolgreich gebucht.</p>
            </div>
        </div>
        <div class="booking-id">
            <h4>Deine Buchungs-ID: <label>#{{$appointment['order_id']}}</label></h4>
        </div>

        <div class="appoinment-booking-con appoinment-booking-con2">
            <div class="person-booking-info-con">
                <h3>Buchungsdetails</h3>

                <div class="personinfo">
                    <div class="information d-flex justify-content-between">
                        <h6>Kunde</h6>
                        <p>{{$appointment['first_name']}} {{$appointment['last_name']}}</p>
                    </div>
                </div>
                <div class="personinfo">
                    <div class="information d-flex justify-content-between">
                        <h6> E-Mail Adresse</h6>
                        <p>{{$appointment['email']}}</p>
                    </div>
                </div>
                <div class="personinfo">
                    <div class="information d-flex justify-content-between">
                        <h6>Telefonnummer </h6>
                        <p>{{$appointment['phone_number']}}</p>
                    </div>
                </div>
                <div class="personinfo">
                    <div class="information d-flex justify-content-between">
                        <h6>Gesamtbetrag</h6>
                        <p class="total-amount">{{number_format($appointment['total_amount'],2, ',','.')}}€</p>
                    </div>
                </div>
            </div>

            <div class="paymentinformation-wrap">
                <h3>Zahlungsübersicht</h3>
                @foreach($data as $row)
                    <div class="accordion pb-3" id="accordionExample-{{$row['category']['id']}}">
                        <div style="display: none">{{$i = 0}}{{$j = 1}}</div>
                        <div class="paymentaccordion paymentaccordion2">
                            <a href="javascript:void(0)" class="payment-box-link" data-toggle="collapse"
                            data-target="#collapse{{$row['category']['id']}}"
                            aria-expanded="true" aria-controls="collapse{{$row['category']['id']}}">
                                                <span
                                                    class="payment-box-icon"><?php echo file_get_contents(URL::to('storage/app/public/category/' . @$row['category']['image'])) ?></span>
                                <h6>{{$row['category']['name']}}</h6>
                                <span class="downn-arroww"><i class="far fa-chevron-down"></i></span>
                            </a>
                            <div id="collapse{{$row['category']['id']}}" class="collapse show"
                                aria-labelledby="heading{{$row['category']['id']}}"
                                data-parent="#accordionExample-{{$row['category']['id']}}">
                                <div class="payment-body-box">
                                    <div class="payment-box-profile-wrap emplistdata"
                                        data-id="{{$row['category']['id']}}">
                                        @if($row['data'][0]['store_emp_id'] != null)
                                            <span class="empname" data-id="{{$row['category']['id']}}">
												@if(\BaseFunction::getEmployeeDetails($row['data'][0]['store_emp_id'],'image'))
													<img src="{{URL::to('storage/app/public/store/employee/'.\BaseFunction::getEmployeeDetails($row['data'][0]['store_emp_id'],'image'))}}" alt="">
												@else
													@php
														$employee_name = \BaseFunction::getEmployeeDetails($row['data'][0]['store_emp_id'],'emp_name');
														$empnameArr = explode(" ", $employee_name);
														$empname = "";
														if(count($empnameArr) > 1){
															$empname = strtoupper(substr($empnameArr[0], 0, 1)).strtoupper(substr($empnameArr[1], 0, 1));
														}else{
															$empname = strtoupper(substr($employee_name, 0, 2));
														}
													@endphp
													 <img src="https://via.placeholder.com/150x150/00000/FABA5F?text={{$empname}}" alt="employee">
												@endif
											</span>
                                            <div class="empname " data-id="{{$row['category']['id']}}">
                                                <p>Mitarbeiter</p>
                                                <h6>{{\BaseFunction::getEmployeeDetails($row['data'][0]['store_emp_id'],'emp_name')}}</h6>
                                            </div>
                                        @else
                                            <span class="empname"><img
                                                    src="{{URL::to('storage/app/public/default/default-user.png')}}"
                                                    alt=""></span>
                                            <div class="empname ">
                                                <p>Mitarbeiter</p>
                                                <h6>Any Person</h6>
                                            </div>
                                        @endif
										@php $catid = $row['category']['id']; @endphp
                                        <div class="datetimeslot data-id='{{$catid }}'">
                                        <p>{{\Carbon\Carbon::parse($row['data'][0]['appo_date'])->translatedFormat('d-m-Y')}}</p>
                                        <h6>{{\Carbon\Carbon::parse($row['data'][0]['appo_time'])->format('H:i')}}</h6>
                                    </div>
                                </div>
                                @foreach($row['data'] as $item)
                                    <div class="payment-item-infos booking-infor-wrap">
                                        <div class="booking-infor-left">
                                            <h5>{{@$item['service_data']['service_name']}}</h5>
                                            <h6>{{@$item['variant_data']['description']}}</h6>
                                            <span>{{@$item['variant_data']['duration_of_service']}} min</span>
                                        </div>
                                        <div class="booking-infor-right">
                                            <p>{{number_format($item['price'],2,',','.')}}€</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div style="display: none">{{$i++}}{{$j++}}</div>
                    </div>
					 </div>
                    @endforeach

           
        </div>

        </div>
        <div class="btn-done">
            <a href="{{URL::to('dienstleister/buchung')}}" class="donebtn btn">Bestätigen</a>
        </div>
    </div>
@endsection
@section('service_js')
@endsection
