@extends('layouts.serviceProvider')
@section('service_title')
    Billing
@endsection
@section('service_css')

<link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.7.0/chosen.min.css" />
@endsection
@section('service_content')
    <div class="main-content">
        <h2 class="page-title static-page-title">Buchungen</h2>
        <div class="setting-title">
            <h3>Termin hinzufügen</h3>

        </div>
        {{Form::open(array('url'=>'service-provider/submit-payment-booking','method'=>'post','name'=>'payment','id'=>'payment-form','class'=>'require-validation'))}}
        <div class="main-dic-appoinment-booking">
            <div class="person-booking-info">
                <h3 class="billing-heading">Buchungsübersicht</h3>
                <div class="appoinment-book">

                    <div class="bookingtimesummry">

                        <div class="bookingsummry">
                            <div class="profile d-flex align-items-center justify-content-lg-start">
                                <div class="profileimg">
                                    @if(file_exists(storage_path('app/public/store/'.$store['store_profile'])) && $store['store_profile'] != '')
                                        <img src="{{URL::to('storage/app/public/store/'.$store['store_profile'])}}"
                                             alt="">

                                    @else
                                        <img src="{{URL::to('storage/app/public/default/store_default.png')}}" alt="">
                                    @endif
                                </div>
                                <div class="profiledetail">
                                    <h6>Salon</h6>
                                    <p>{{$store['store_name']}}</p>
                                </div>

                            </div>
                            <div class="payment-location">
                                <span><img
                                        src="{{URL::to('storage/app/public/Serviceassets/images/new-appoi/payment-location.svg')}}"></span>
                                <p>{{$store['store_address']}}</p>
                            </div>
                            <div class="paymentinformation-wrap">
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
                                                    <div
                                                        class="payment-box-profile-wrap payment-box-profile-wrap2 emplistdata"
                                                        data-id="{{$row['category']['id']}}">
                                                        @if($row['data'][0]['employee'] != null)
                                                            <span class="empname" data-id="{{$row['category']['id']}}">
																@if(\BaseFunction::getEmployeeDetails($row['data'][0]['employee'],'image'))
																	<img src="{{URL::to('storage/app/public/store/employee/'.\BaseFunction::getEmployeeDetails($row['data'][0]['employee'],'image'))}}" alt="">
																@else
																	@php
																		$employee_name = \BaseFunction::getEmployeeDetails($row['data'][0]['employee'],'emp_name');
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
                                                                <h6>{{\BaseFunction::getEmployeeDetails($row['data'][0]['employee'],'emp_name')}}</h6>
                                                            </div>
                                                        @else
                                                            <span class="empname"
                                                                  data-id="{{$row['category']['id']}}"><img
                                                                    src="{{URL::to('storage/app/public/default/default-user.png')}}"
                                                                    alt=""></span>
                                                            <div class="empname " data-id="{{$row['category']['id']}}">
                                                                <p>Mitarbeiter</p>
                                                                <h6>Any Person</h6>
                                                            </div>
                                                        @endif
                                                        <div class="datetimeslot" data-id="{{$row['category']['id']}}">
                                                            <p>{{\Carbon\Carbon::parse($row['data'][0]['date'])->translatedFormat('d-m-Y')}}</p>
                                                            <h6>{{\Carbon\Carbon::parse($row['data'][0]['time'])->format('H:i')}}</h6>
                                                        </div>
                                                    </div>
                                                    @foreach($row['data'] as $item)
                                                        <div class="payment-item-infos booking-infor-wrap">
                                                            <div class="booking-infor-left">
                                                                <h5>{{@$item['service_data']['service_name']}}</h5>
                                                                <h6>{{@$item['variant_data']['description']}}</h6>
                                                                <span>{{@$item['variant_data']['duration_of_service']}} {{__('Min') }}</span>
                                                            </div>
                                                            <div class="booking-infor-right">
                                                                <p>{{number_format($item['price'],2)}}€</p>
                                                            </div>
                                                        </div>

                                                        <input type="hidden" name="category[]" class="category_id"
                                                               data-id="{{$row['category']['id']}}"
                                                               value="{{$row['category']['id']}}">
                                                        <input type="hidden" name="store[]" class="store_id"
                                                               data-id="{{$row['category']['id']}}"
                                                               value="{{$store['id']}}">
                                                        <input type="hidden" name="date[]" class="date_id"
                                                               data-id="{{$row['category']['id']}}"
                                                               value="{{$item['date']}}">
                                                        <input type="hidden" name="employee[]" class="emp_id"
                                                               data-id="{{$row['category']['id']}}"
                                                               value="{{$item['employee']}}">
                                                        <input type="hidden" name="time[]" class="timeslot"
                                                               data-id="{{$row['category']['id']}}"
                                                               value="{{$item['time']}}">
                                                        <input type="hidden" name="variant[]" class="variant"
                                                               data-id="{{$row['category']['id']}}"
                                                               value="{{$item['variant']}}">
                                                        <input type="hidden" name="service[]" class="service"
                                                               data-id="{{$row['category']['id']}}"
                                                               value="{{$item['service']}}">
                                                        <input type="hidden" name="service_data[]" class="service_data"
                                                               data-id="{{$row['category']['id']}}"
                                                               value="{{@$item['service_data']['service_name']}}">
                                                        <input type="hidden" name="subcategory[]" class="subcategory"
                                                               data-id="{{$row['category']['id']}}"
                                                               value="{{@$item['subcategory']}}">
                                                        <input type="hidden" name="price[]" class="price"
                                                               data-id="{{$row['category']['id']}}"
                                                               value="{{@$item['price']}}">
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <div style="display: none">{{$i++}}{{$j++}}</div>
                                    </div>
                                @endforeach
                            </div>
                            <!-- Ladies-Balayage & Blow Dry end -->
                            <a href="#" class="btn totalbook">Gesamt  <p>{{number_format($totalamount,2)}}€</p>
                            </a>

                        </div>

                    </div>
                </div>

            </div>

            <div class="billing-details">
                <h3 class="billing-heading">Kontaktdaten</h3>
                <div class="billing-input">
                    {{Form::select('customer_id',$customer,'',array('class'=>'billing-detail select customerData','id'=>'customer'))}}
                    <input type="text" name="fname" class="billing-detail fname" placeholder="Vorname" required>
                    <input type="text" name="lname" class="billing-detail lname" placeholder="Nachname">
                    <input type="text" name="email" class="billing-detail email" Placeholder="E-Mail Adresse" required>
                    <input type="text" name="phone_number" class="billing-detail phone_number" Placeholder="Telefonnummer ">
                    <input type="hidden" name="choosepayment" value="cash">
                    <input type="hidden" name="totalAmount" value="{{$totalamount}}">
                    <input type="hidden" name="usertype" id="usertype" value="">
                </div>
                <button type="submit"  class="btn btn-book-block mt-5 checkout-btn " id="booking">
                    <p>Buchen</p>
                    <div>
                        <span><img
                                src="{{URL::to('storage/app/public/Serviceassets/images/new-appoi/right-arrow.svg')}}"
                                alt=""></span>
                    </div>
                </button>
            </div>
        </div>
        {{Form::close()}}
        <!-- modal -->
    </div>
@endsection
@section('service_js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.7.0/chosen.jquery.min.js"></script>
    <script>
		
        $('#payment-form').validate({ // initialize the plugin
            rules: {
                fname: {
                    required: true,
                },
                email: {
                    required: true,
                    email: true
                },
                phone_number: {
                    //required: true,
                    number: true,
                    minlength: 11,
                    maxlength: 13
                }
            },
            // Specify validation error messages
            messages: {
                fname: {
                    required: "Bitte den Vornamen eingeben"
                },
                phone_number: {
                    required: "Bitte die Telefonnummer eingeben.",
                    minlength: "Bitte geben Sie eine gültige Telefonnummer ein",
                    maxlength: "Bitte geben Sie eine gültige Telefonnummer ein",
					 number: "Bitte geben Sie eine gültige Telefonnummer ein",
                },
                email: "Bitte die E-Mail Adresse eingeben"
            },
        });
        var authCheck = '{{Auth::check()}}';
        var baseurl = '{{URL::to('/service-provider')}}';
        var token = '{{ csrf_token() }}';
        var loginUser = localStorage.getItem('loginuser');
        $(document).on('change','.customerData',function (){
            var id = $(this).val();
            $.ajax({
                type: 'POST',
                async: true,
                dataType: "json",
                url: baseurl + '/get-customer-details',
                data: {
                    _token: token,
                    id: id,
                },
                beforesend: $('#loading').css('display', 'block'),
                success: function (response) {
                        var data = response.data;
                        $('.fname').val(data.first_name);
						if(data.first_name != ""){
							$('.fname').removeClass('error');
							$('#fname-error').hide();
						}
                        $('.lname').val(data.last_name);
                        $('.email').val(data.email);
						if(data.email != ""){
							$('.email').removeClass('error');
							$('#email-error').hide();
						}
                        $('.phone_number').val(data.phone_number);
						if(data.phone_number != ""){
							$('.phone_number').removeClass('error');
							$('#phone_number-error').hide();
						}
                        $('#loading').css('display', 'none');
                }
            });
        })
        $("#customer").chosen({no_results_text: "Oops, nothing found!"}); 
    </script>
@endsection
