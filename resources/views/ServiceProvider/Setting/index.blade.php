@extends('layouts.serviceProvider')
@section('service_title')
    Setting
@endsection

@section('service_css')
<style>
    a.btn.btnyellow.cancelbtn.btn-yellow {
        padding: 7px;
        width: 130px;
    }
    @media only screen and (min-width: 1199px) {
        .dashboard-box h5 {
            font-size: 26px !important;
        }
    }
    .next-pay-date {
        padding: 0;
        background: none;
        border-radius: 0%;
        border: none;
    }
    .next-pay-date a {
        margin-left: auto;
    }
    .plan-btns {
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    @media only screen and (max-width: 575px) {
        .plan-btns {
            align-items: flex-start;
        }
        .btn-upgrad a {
            margin-top: 20px!important;
        }
        .next-pay-date a {
            margin-top: 20px!important;
        }

    }
    /* #chat-widget-container{left:0px !important;right:unset !important;} */
    .card-type h5 {
        font-size: 16px;
        font-weight: 400;
        margin-top: 5px;
    }
    .card-type p {
        font-size: 14px;
    }
    .card-payment.card-pay-pdf {
        padding: 25px 10px;
    }
    .btn-download a {
        padding: 12px 20px;
    }
    .btn_status {
        padding-top: 0px;
        padding-bottom: 2px;
        border-radius: 8rem;
        padding-left: 10px;
        padding-right: 10px;
        cursor: unset;
    }
    .btn-outline-purple {
        color: #cf25e3;
        border-color: #cf25e3;
    }
    .btn-outline-purple:hover {
        color: #cf25e3;
        border-color: #cf25e3;
    }
</style>
@endsection
@section('service_content')
    <div class="main-content">
        <h2 class="page-title static-page-title">Einstellungen</h2>
        <div class="setting-title">
            <h3>Meine Einstellungen</h3>
            <a href="{{URL::to('dienstleister/logout')}}" class="btn btnyellow cancelbtn btn-yellow">Logout</a>
        </div>
        <div class="setting-wrap">
		<div class="col-md-12">
            @if(Session::has('message'))
                {!! Session::get('message') !!}
            @endif
        </div>
        <ul class="nav nav-pills eprofile-navs setting-nav" id="pills-tab" role="tablist"
            style="margin: 20px auto 80px; !important;">
            <!-- <li class="nav-item">
                <a class="nav-link active" id="pills-change-pswrd-tab" data-toggle="pill" href="#pills-change-pswrd"
                   role="tab" aria-controls="pills-change-pswrd" aria-selected="false">Change password</a>
            </li> -->
            <li class="nav-item about-us">
                <a class="nav-link " id="pills-about-us-tab" data-toggle="pill" href="#pills-about-us" role="tab"
                   aria-controls="pills-about-us" aria-selected="false">Über Uns</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" id="pills-contact-us-tab" data-toggle="pill" href="#pills-contact-us" role="tab"
                   aria-controls="pills-contact-us" aria-selected="true">Kontakt </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="pills-substription-us-tab" data-toggle="pill" href="#pills-substription-us" role="tab"
                   aria-controls="pills-substription-us" aria-selected="true">Abonnement</a>
            </li>
			<li class="nav-item">
                <a class="nav-link" id="pills-Hilfe-tab" data-toggle="pill" href="#pills-Hilfe" role="tab"
                   aria-controls="pills-Hilfe" aria-selected="false">Hilfe</a>
            </li>
            <!-- <li class="nav-item">
                <a class="nav-link" id="pills-cancelation-tab" data-toggle="pill" href="#pills-cancelation" role="tab"
                   aria-controls="pills-cancelation" aria-selected="false">Cancellation policy</a>
            </li> -->
            <li class="nav-item">
                <a class="nav-link" id="pills-terms-tab" data-toggle="pill" href="#pills-terms" role="tab"
                   aria-controls="pills-terms" aria-selected="true">AGB</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="pills-privancy-tab" data-toggle="pill" href="#pills-privancy" role="tab"
                   aria-controls="pills-privancy" aria-selected="false">Datenschutz</a>
            </li>
        </ul>
    </div>
        <div class="store-profile-width setting-width">
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show" id="pills-change-pswrd" role="tabpanel"
                     aria-labelledby="pills-change-pswrd-tab">
                    {{Form::open(array('url'=>'service-provider/change-password','method'=>'post','name'=>'change-password','class'=>'change-passowrd-form'))}}
                    <div class="change-pswrd-pills">
                        <div class="change-pswrd">
                            <h3>Change Your Password</h3>
                            <button type="submit" class="btn-yellow">Save</button>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="change-pswrd-input">
                                    <img src="{{URL::to('storage/app/public/Serviceassets/images/setting/lock.svg')}}"
                                         alt="">
                                    <input type="password" name="old_password" class="@error('old_password') is-invalid @enderror" placeholder="Old password" required>
                                </div>
                                @error('old_password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-lg-12">
                                <div class="change-pswrd-input">
                                    <img src="{{URL::to('storage/app/public/Serviceassets/images/setting/lock.svg')}}"
                                         alt="">
                                    <input type="password" name="new_password" class="@error('new_password') is-invalid @enderror" placeholder="New password" required>
                                </div>
                                @error('new_password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-lg-12">
                                <div class="change-pswrd-input">
                                    <img src="{{URL::to('storage/app/public/Serviceassets/images/setting/lock.svg')}}"
                                         alt="">
                                    <input type="password" class="@error('confirm_password') is-invalid @enderror" name="confirm_password" placeholder="Confirm password" required>
                                </div>
                                @error('confirm_password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    {{Form::close()}}
                </div>
                <div class="tab-pane fade show " id="pills-about-us" role="tabpanel"
                     aria-labelledby="pills-about-us-tab">
                    <div class="setting-about-us">
                        <h5>Lorem ipsum dolor sit amet.</h5>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse bibendum semper odio vel
                            imperdiet. Quisque varius a nibh in
                            commodo. Cras nisi orci, rutrum eget lorem vitae, laoreet vehicula nunc. Nulla pellentesque,
                            dolor sit amet sollicitudin sodales, nisl
                            massa blandit leo, id iaculis magna arcu et metus.</p>
                        <h6>Lorem ipsum dolor sit amet.</h6>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse bibendum semper odio vel
                            imperdiet. Quisque varius a nibh in
                            commodo. Cras nisi orci, rutrum eget lorem vitae, laoreet vehicula nunc. Nulla pellentesque,
                            dolor sit amet sollicitudin sodales, nisl
                            massa blandit leo, id iaculis magna arcu et metus. In nec ipsum nisi. Nunc vel hendrerit
                            eros, sit amet egestas leo. In fermentum enim
                            mollis, placerat augue sed, ornare elit. Ut vitae pellentesque tellus, sed posuere sapien.
                            Integer venenatis arcu ultrices tortor tristique,
                            ut mattis tellus lacinia. Maecenas molestie, dolor ut molestie cursus, lacus augue
                            vestibulum nibh, in efficitur augue arcu ullamcorper
                            ipsum. Nam sed orci ullamcorper, elementum urna at, faucibus nunc.</p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse bibendum semper odio vel
                            imperdiet. Quisque varius a nibh in
                            commodo. Cras nisi orci, rutrum eget lorem vitae.</p>
                        <h5>Lorem ipsum dolor sit amet.</h5>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse bibendum semper odio vel
                            imperdiet. Quisque varius a nibh in
                            commodo. Cras nisi orci, rutrum eget lorem vitae, laoreet vehicula nunc. Nulla pellentesque,
                            dolor sit amet sollicitudin sodales, nisl
                            massa blandit leo, id iaculis magna arcu et metus. In nec ipsum nisi. Nunc vel hendrerit
                            eros, sit amet egestas leo. In fermentum enim
                            mollis, placerat augue sed, ornare elit. Ut vitae pellentesque tellus, sed posuere sapien.
                            Integer venenatis arcu ultrices tortor tristique,
                            ut mattis tellus lacinia. Maecenas molestie, dolor ut molestie cursus, lacus augue
                            vestibulum nibh, in efficitur augue arcu ullamcorper
                            ipsum. Nam sed orci ullamcorper, elementum urna at, faucibus nunc.</p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse bibendum semper odio vel
                            imperdiet. Quisque varius a nibh in
                            commodo. Cras nisi orci, rutrum eget lorem vitae, laoreet vehicula nunc. Nulla pellentesque,
                            dolor sit amet sollicitudin sodales, nisl
                            massa blandit leo, id iaculis magna arcu et metus.</p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse bibendum semper odio vel
                            imperdiet. Quisque varius a nibh in
                            commodo. Cras nisi orci, rutrum eget lorem vitae.</p>
                        <h6>Lorem ipsum dolor sit amet.</h6>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse bibendum semper odio vel
                            imperdiet. Quisque varius a nibh in
                            commodo. Cras nisi orci, rutrum eget lorem vitae.</p>
                        <h6>Lorem ipsum dolor sit amet.</h6>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse bibendum semper odio vel
                            imperdiet. Quisque varius a nibh in
                            commodo. Cras nisi orci, rutrum eget lorem vitae.</p>
                        <h6>Lorem ipsum dolor sit amet.</h6>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse bibendum semper odio vel
                            imperdiet. Quisque varius a nibh in
                            commodo. Cras nisi orci, rutrum eget lorem vitae.</p>
                    </div>
                </div>
                <div class="tab-pane fade show active" id="pills-contact-us" role="tabpanel"
                     aria-labelledby="pills-contact-us-tab">
                    <div class="contact-us-pills">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="setting-contact-info">
                                    <h5> Kontaktinformationen</h5>
                                    <p> So erreichen Sie unser Team</p>
									<div class="row">
										<div class="col-md-6">
											<div class="setting-call-info mt-4">
												<img
													src="{{URL::to('storage/app/public/Serviceassets/images/setting/setting-phone.svg')}}"
													alt="">
													<div class="phone-num">
													<h6>Telefonnummer </h6>
													<p>+49 30 1663969318</p>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="setting-msg-info mt-4">
												<img
													src="{{URL::to('storage/app/public/Serviceassets/images/setting/setting-msg.svg')}}"
													alt="">
													<div class="phone-num">
													<h6>E-Mail</h6>
												<p>b2b.support@reserved4you.de</p>
											  </div>
											</div>
										</div>
									</div>
                                    <!-- <div class="setting-location-info">
                                        <img
                                            src="{{URL::to('storage/app/public/Serviceassets/images/setting/setting-location.svg')}}"
                                            alt="">
                                        <p>1.st Floor, Vorderhaus Gaststätte</p>
                                    </div> -->
                                   <!-- <div class="setting-logo">
                                        <img
                                            src="{{URL::to('storage/app/public/Serviceassets/images/setting/setting-logo.svg')}}"
                                            alt="">
                                    </div> -->
                                </div>
                            </div>

                            <div class="col-lg-12 d-none">
                                <form class="setting-about-form" action="{{URL::to('service-provider/contact-us')}}" method="POST" name="contact_form">
                                    @csrf

                                    <div class="contact-chat">
                                         <ul class="chat">
                                             <li class="admin-chat">Hallo,<br>wie können wir Ihnen helfen ? </li><span class="lbladmin">10:15 pm</span>
                                             <li class="user-chat">Order is not confirmed, Order ID is #25124621</li><span class="lbluser">10:30 pm</span>
                                         </ul>
                                        <div class="msg-send">
                                            <input type="text" name="send" placeholder="Geben Sie hier Ihre Nachricht ein …">
                                            <a href="#">  <img
                                            src="{{URL::to('storage/app/public/Serviceassets/images/setting/send.svg')}}"
                                            alt=""></a>
                                        </div>
                                    </div>
                                <!-- <div class="row">
                                    <div class="col-lg-12">
                                        <input type="text" name="name" placeholder="First name" value="{{Auth::user()->first_name}} {{Auth::user()->last_name}}" required class="about-fname">
                                    </div>

                                    <div class="col-lg-12">
                                        <input type="text" name="email" placeholder="Email address" value="{{Auth::user()->email}}" required class="about-fname">
                                    </div>
                                    <div class="col-lg-12">
                                        <textarea class="about-msg" name="message" placeholder="Write your message..." required></textarea>

                                    </div>
                                </div> -->

                                <!-- <div class="send-info">
                                    <button type="submit">Send</button>
                                </div> -->
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade show" id="pills-substription-us" role="tabpanel"
                     aria-labelledby="pills-substription-us-tab">
                    <div class="substition">
                        @foreach ($plans as $plan)
                        <h5 class="mt-2">{{$plan->store_name}}</h5>
                        <div class="row">
                            <div class="col-lg-7">
                                <div class="sub-payment-plan mb-1">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="sub-plan">
                                                <p>Subscribed Plan</p>
                                                <h5>{{$plan->plan_name}}</h5>
                                            </div>
                                            <div class="sub-plan-time">
                                                <p>Plan time</p>
                                                <h6>
                                                    @if (str_contains($plan->store_active_actual_plan, 'monthly'))
                                                        Monthly
                                                    @else
                                                        Annual
                                                    @endif
                                                    Payment
                                                </h6>
                                            </div>
                                        </div>
                                        {{-- <div class="col-sm-6">
                                            <div class="payment-val">
                                                <p> 
                                                    <span class="uro-icon"> € </span> 
                                                    <span>{{$plan->price}}</span> 
                                                    @if (str_contains($plan->store_active_actual_plan, 'monthly'))
                                                        /mo
                                                    @else
                                                        /yr
                                                    @endif
                                                </p>
                                            </div>
                                        </div> --}}
                                        <div class="col-sm-6 plan-btns">
                                            <div class="btn-upgrad">
                                                <a href="#">Upgrade Plan</a>
                                            </div>
                                            <div class="next-pay-date">
                                                <a href="#">Cancel Subscription</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5 d-flex align-items-center">
                               
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="extra-service-title">
                        <p>Extra Service</p>
                        {{-- <a href="#">Upgrade Extra Services</a> --}}
                    </div>
                    @if (!empty($extraService))
                        @foreach($extraService as $key => $row)
                        <ul class="service-plans">
                            <h6 class="d-block w-100 mt-2">{{$key}}</h5>
                            @foreach ($row as $service)
                                <li>
                                    <div class="dashboard-box gray-box">
                                        <span>
                                            @if(str_contains($service->Service_plan, 'Rabatte für Kunden'))
                                                <img src="{{URL::to('storage/app/public/Serviceassets/images/icon/discount.svg')}}" alt="">
                                            @else
                                                <img src="{{URL::to('storage/app/public/Serviceassets/images/icon/card.svg')}}" alt="">
                                            @endif
                                        </span>
                                        <p>{{$service->plan_type}}</p>
                                
                                        <h6>{{$service->Service_plan}}</h6>
                                        <h5>
                                            {{$service->Service_amount}}
                                            {{ (str_contains($service->Service_amount, '%') != false) ?  '' : '€' }} 
                                            @if ($service->plan_type != "onetime")
                                                / mo
                                            @endif
                                        </h5>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                        @endforeach
                    @else
                        <ul class="service-plans">
                            <li>
                                <div class="dashboard-box gray-box justify-content-center">
                                    <h6>No Extra Service Found</h6>
                                </div>
                            </li>
                        </ul>
                    @endif

                    {{-- START HARDWARE SECTION --}}
                    @if (count($hardware) > 0)
                        <div class="d-flex justify-content-between align-items-center w-100 mt-2 mb-4">
                            <h3 class="section-title">
                                Hardware 
                            </h3>
                        </div>
                        @foreach ($hardware as $key => $row)
                        <ul class="service-plans">
                            <h6 class="d-block w-100 mt-2">{{$key}}</h5>
                            @foreach ($row as $service)
                                <li>
                                    <div class="dashboard-box gray-box">
                                        <span>
                                            <img src="{{URL::to('storage/app/public/Serviceassets/images/icon/hardware-phone.svg')}}" alt="">
                                        </span>
                                        <p>{{$service->plan_type}}</p>
                                
                                        <h6>{{$service->Service_plan}}</h6>
                                        <h5>
                                            {{$service->Service_amount}}
                                            {{ (str_contains($service->Service_amount, '%') != false) ?  '' : '€' }} 
                                            @if ($service->plan_type != "onetime")
                                                / mo
                                            @endif
                                        </h5>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                        @endforeach
                    @endif
                    {{-- END HARDWARE SECTION --}}

                    {{-- START MARKETING SECTION --}}
                    {{-- @if (!empty($marketing))
                        <div class="d-flex justify-content-between align-items-center w-100 mt-2 mb-4">
                            <h3 class="section-title">
                                Marketing 
                            </h3>
                        </div>
                        @foreach ($marketing as $key => $row)
                        <h6 class="d-block w-100 mt-2">{{$key}}</h5>
                        <ul class="service-plans">
                            @foreach ($row as $service)
                                <li>
                                    <div class="dashboard-box gray-box">
                                        <span>
                                            <img src="https://www.delemontstudio.com/reserved4younew/storage/app/public/Serviceassets/images/icon/card.svg" alt="">
                                        </span>
                                        <p>{{$service->plan_type}}</p>
                                
                                        <h6>{{$service->Service_plan}}</h6>
                                        <h5>
                                            {{$service->Service_amount}}
                                            {{ (str_contains($service->Service_amount, '%') != false) ?  '' : '€' }} 
                                            @if ($service->plan_type != "onetime")
                                                / mo
                                            @endif
                                        </h5>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                        @endforeach
                    @endif --}}
                    {{-- END MARKETING SECTION --}}

                    <div class="cust-title"><h4>Customer</h4></div>
                    @if (count($paymentDetail) > 0)
                        @foreach ($paymentDetail as $row)
                            <div class="card-payment">
                                <div class="card-icon">
                                    <img src="{{asset('storage/app/public/Serviceassets/images/icon/cust-card.svg')}}" alt="">
                                </div>
                                <div class="card-type">
                                    <p>Card Type</p>
                                    <h5>{{$row->payment_method}}</h5>
                                </div>
                                <div class="card-type">
                                    <p>Card holder name</p>
                                    <h5>{{$row->card_holder_name}}</h5>
                                </div>
                                <div class="card-type">
                                    <p>Credit card</p>
                                    <h5>{{ substr($row->card_number, 0, 4) }}  . . . .   . . . .  {{ substr($row->card_number, -4, 4) }}</h5>
                                </div>
                                {{-- <div class="btn-change">
                                    <a href="#">Change it</a>
                                </div> --}}
                            </div>
                        @endforeach
                    @else 
                        <div class="card-payment card-pay-pdf align-items-center justify-content-center">
                            <h6>No Customers' Card data</h6>
                        </div>
                    @endif
                    <div class="cust-title"><h4>Invoices</h4></div>
                    @if (count($invoices) > 0)
                        @foreach ($invoices as $key => $allInvoices)
                            <h6 class="d-block w-100 mt-2">{{$key}}</h5>
                            @if (count($allInvoices) > 0)
                                @foreach ($allInvoices as $invoice)
                                @foreach ($invoice as $row)
                                    <div class="card-payment card-pay-pdf row">   
                                        <div class="card-icon-pdf col-3 col-sm-1 px-0">
                                            <img src="{{URL::to('storage/app/public/Serviceassets/images/icon/pdf-icon.svg')}}" alt="">
                                        </div>
                                        
                                        <div class="card-type card-info mr-0 col-9 col-sm-5">
                                            <p>Name of invoice file</p>
                                            <h5>{{$row->title .'.pdf'}}</h5>
                                            <p>
                                                Status: 
                                                @if ($row->status=="open")
                                                    <button disabled class="btn btn_status btn-outline-info">{{$row->status}}</button>
                                                @elseif ($row->status == "cancelled") 
                                                    <button disabled class="btn btn_status btn-outline-danger">{{$row->status}}</button>
                                                @elseif ($row->status == "due") 
                                                    <button disabled class="btn btn_status btn-outline-warning">{{$row->status}}</button>
                                                @elseif ($row->status == "paid") 
                                                    <button disabled class="btn btn_status btn-outline-success">{{$row->status}}</button>
                                                @elseif ($row->status == "in arrears") 
                                                    <button disabled class="btn btn_status btn-outline-purple">In arrears</button>
                                                @else 
                                                    {{$row->status}}
                                                @endif
                                            </p>
                                        </div>
                                        <div class="card-type card-info mr-0 col-6 col-sm-2 mt-3 mt-sm-0">
                                            <p>Invoice Number</p>
                                            <h5>{{$row->invoice_number}}</h5>
                                        </div>
                                        <div class="card-type col-6 col-sm-2 mt-3 mt-sm-0">
                                            <p>Date of invoice</p>
                                            <h5>{{\Carbon\Carbon::parse($row->created_at)->format('M d, Y')}}</h5>
                                        </div>
                                        <div class="col-12 col-sm-2 mt-4 mt-sm-0">
                                            <div class="btn-download">
                                                @if ($row->bill_type == 'payout')
                                                    <a target="_blank" href="{{route('payout.download', ['id' => $row->id, 'number' => $row->invoice_number])}}">Download</a>
                                                @else 
                                                    <a target="_blank" href="{{route('invoice.download', ['id'=>$row->id, 'number'=>$row->invoice_number])}}">Download</a>
                                                @endif
                                                {{-- <a href="{{route('invoice.pdf', ['id' => $row->invoice_id, 'bill' => $row->id])}}">Preview</a> --}}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                @endforeach
                            @else 
                                <div class="card-payment card-pay-pdf align-items-center justify-content-center">
                                    <h6>No invoice data</h6>
                                </div>
                            @endif
                        @endforeach
                    @else 
                        <div class="card-payment card-pay-pdf align-items-center justify-content-center">
                            <h6>No invoice data</h6>
                        </div>
                    @endif
                 </div>
				  <div class="tab-pane fade show" id="pills-Hilfe" role="tabpanel" aria-labelledby="pills-Hilfe-tab">
                    <div class="setting-about-us">
						 <h5 class="mb-3">So Funktioniert´s</h5>
						<div class="row">
							<div class="col-md-6 mb-4">
								 <h6>How to # 0 Login</h6>
								 <video width="100%"  poster="{{ asset('storage/app/public/Serviceassets/videos/banner.png') }}" controls>
									  <source src="{{ asset('storage/app/public/Serviceassets/videos/Login.mp4') }}" type="video/mp4">
								</video> 
							</div>
							<div class="col-md-6 mb-4">
								 <h6>How to # 1 Dashboard</h6>
								 <video width="100%" poster="{{ asset('storage/app/public/Serviceassets/videos/banner.png') }}" controls>
									  <source src="{{ asset('storage/app/public/Serviceassets/videos/Dashboard.mp4') }}" type="video/mp4">
								</video> 
							</div>
							<div class="col-md-6  mb-4">
								 <h6>How to # 2 Kalender</h6>
								 <video width="100%" poster="{{ asset('storage/app/public/Serviceassets/videos/banner.png') }}" controls>
									  <source src="{{ asset('storage/app/public/Serviceassets/videos/Kalender.mp4') }}" type="video/mp4">
								</video> 
							</div>
							<div class="col-md-6  mb-4">
								 <h6>How to # 3 Buchungen</h6>
								 <video width="100%" poster="{{ asset('storage/app/public/Serviceassets/videos/banner.png') }}" controls>
									  <source src="{{ asset('storage/app/public/Serviceassets/videos/Buchungen.mp4') }}" type="video/mp4">
								</video> 
							</div>
							<div class="col-md-6  mb-4">
								 <h6>How to # 4 Kunden</h6>
								 <video width="100%" poster="{{ asset('storage/app/public/Serviceassets/videos/banner.png') }}" controls>
									  <source src="{{ asset('storage/app/public/Serviceassets/videos/Kunden.mp4') }}" type="video/mp4">
								</video> 
							</div>
							<div class="col-md-6  mb-4">
								 <h6>How to # 5 Mitarbeiter</h6>
								 <video width="100%" poster="{{ asset('storage/app/public/Serviceassets/videos/banner.png') }}" controls>
									  <source src="{{ asset('storage/app/public/Serviceassets/videos/Mitarbeiter.mp4') }}" type="video/mp4">
								</video> 
							</div>
							<div class="col-md-6  mb-4">
								 <h6>How to # 6 Betriebsprofil</h6>
								 <video width="100%" poster="{{ asset('storage/app/public/Serviceassets/videos/banner.png') }}" controls>
									  <source src="{{ asset('storage/app/public/Serviceassets/videos/Betriebsprofil.mp4') }}" type="video/mp4">
								</video> 
							</div>
							<div class="col-md-6  mb-4">
								 <h6>How to # 7 Statistiken</h6>
								 <video width="100%" poster="{{ asset('storage/app/public/Serviceassets/videos/banner.png') }}" controls>
									  <source src="{{ asset('storage/app/public/Serviceassets/videos/Statistiken.mp4') }}" type="video/mp4">
								</video> 
							</div>
							<div class="col-md-6  mb-4">
								 <h6>How to # 8 Finanzen</h6>
								 <video width="100%" poster="{{ asset('storage/app/public/Serviceassets/videos/banner.png') }}" controls>
									  <source src="{{ asset('storage/app/public/Serviceassets/videos/Finanzen.mp4') }}" type="video/mp4">
								</video> 
							</div>
							<div class="col-md-6  mb-4">
								 <h6>How to # 9 Einstellungen</h6>
								 <video width="100%" poster="{{ asset('storage/app/public/Serviceassets/videos/banner.png') }}" controls>
									  <source src="{{ asset('storage/app/public/Serviceassets/videos/Einstellungen.mp4') }}" type="video/mp4">
								</video> 
							</div>
						</div>
					</div>
				</div>
                <!-- <div class="tab-pane fade show" id="pills-cancelation" role="tabpanel"
                     aria-labelledby="pills-cancelation-tab">
                    <div class="setting-about-us">
                        <h5>Lorem ipsum dolor sit amet.</h5>
                        <p class="cancelation-bg">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse
                            bibendum semper odio vel imperdiet. Quisque varius a nibh in
                            commodo. Cras nisi orci, rutrum eget lorem vitae, laoreet vehicula nunc. Nulla pellentesque,
                            dolor sit amet sollicitudin sodales, nisl
                            massa blandit leo, id iaculis magna arcu et metus.</p>
                        <h6>Lorem ipsum dolor sit amet.</h6>

                        <ul class="cancelation-info">
                            <li>Lorem ipsum dolor sit amet.</li>
                            <li>Lorem ipsum dolor sit amet.</li>
                            <li>Lorem ipsum dolor sit amet.</li>
                            <li>Lorem ipsum dolor sit amet.</li>
                        </ul>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse bibendum semper odio vel
                            imperdiet. Quisque varius a nibh in
                            commodo. Cras nisi orci, rutrum eget lorem vitae, laoreet vehicula nunc. Nulla pellentesque,
                            dolor sit amet sollicitudin sodales, nisl
                            massa blandit leo, id iaculis magna arcu et metus. In nec ipsum nisi. Nunc vel hendrerit
                            eros, sit amet egestas leo. In fermentum enim
                            mollis, placerat augue sed, ornare elit. Ut vitae pellentesque tellus, sed posuere sapien.
                            Integer venenatis arcu ultrices tortor tristique,
                            ut mattis tellus lacinia. Maecenas molestie, dolor ut molestie cursus, lacus augue
                            vestibulum nibh, in efficitur augue arcu ullamcorper
                            ipsum. Nam sed orci ullamcorper, elementum urna at, faucibus nunc.</p>

                        <h5>Lorem ipsum dolor sit amet.</h5>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse bibendum semper odio vel
                            imperdiet. Quisque varius a nibh in
                            commodo. Cras nisi orci, rutrum eget lorem vitae, laoreet vehicula nunc. Nulla pellentesque,
                            dolor sit amet sollicitudin sodales, nisl
                            massa blandit leo, id iaculis magna arcu et metus. In nec ipsum nisi. Nunc vel hendrerit
                            eros, sit amet egestas leo. In fermentum enim
                            mollis, placerat augue sed, ornare elit. Ut vitae pellentesque tellus, sed posuere sapien.
                            Integer venenatis arcu ultrices tortor tristique,
                            ut mattis tellus lacinia. Maecenas molestie, dolor ut molestie cursus, lacus augue
                            vestibulum nibh, in efficitur augue arcu ullamcorper
                            ipsum. Nam sed orci ullamcorper, elementum urna at, faucibus nunc.</p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse bibendum semper odio vel
                            imperdiet. Quisque varius a nibh in
                            commodo. Cras nisi orci, rutrum eget lorem vitae, laoreet vehicula nunc. Nulla pellentesque,
                            dolor sit amet sollicitudin sodales, nisl
                            massa blandit leo, id iaculis magna arcu et metus.</p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse bibendum semper odio vel
                            imperdiet. Quisque varius a nibh in
                            commodo. Cras nisi orci, rutrum eget lorem vitae.</p>
                        <h6>Lorem ipsum dolor sit amet.</h6>
                        <p class="cancelation-bg">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse
                            bibendum semper odio vel imperdiet. Quisque varius a nibh in
                            commodo. Cras nisi orci, rutrum eget lorem vitae.</p>
                        <h6>Lorem ipsum dolor sit amet.</h6>
                        <p class="cancelation-bg">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse
                            bibendum semper odio vel imperdiet. Quisque varius a nibh in
                            commodo. Cras nisi orci, rutrum eget lorem vitae.</p>
                        <h6>Lorem ipsum dolor sit amet.</h6>
                        <p class="cancelation-bg">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse
                            bibendum semper odio vel imperdiet. Quisque varius a nibh in
                            commodo. Cras nisi orci, rutrum eget lorem vitae.</p>
                    </div>

                </div> -->
                <div class="tab-pane fade show" id="pills-terms" role="tabpanel" aria-labelledby="pills-terms-tab">
                    <div class="setting-about-us">
                        <h4>VERKAUFSBEDINGUNGEN</h4>
                        <span>Letztes Update: Juli 2021</span>
                        <h5>PRÄAMBEL</h5>
                        <p><strong>TLTR:</strong> Die Präambel beschreibt die in den Verkaufsbedingungen erwähnten Klauseln. Diese regelt den Verkauf von Dienstleistungen des Dienstleisters und Sie werden gebeten, diese sorgfältig zu lesen, bevor Sie mit dem Verkauf Ihrer Dienstleistungen bei uns beginnen.</p>
                        <ul>
                            <li> <span>1. </span> <p>Diese Allgemeinen Geschäftsbedingungen für Verkaufsbedingungen (im Folgenden „Verkaufsbedingungen“ genannt) werden zwischen R.F.U. reserved4you GmbH in der Wilmersdorfer Straße 122-123 10627 / Berlin (nachfolgend „Unternehmen“, „wir“, „unser“ oder „uns“ genannt), die Eigentümer der Webseite <a href="https://www.reserved4you.de/">https://www.reserved4you.de/</a> (die “) und der reserved4you-Mobilanwendung („App“) und Ihnen („Sie“ oder „Ihr“ oder „Dienstanbieter“). Diese Verkaufsbedingungen regeln Ihren Verkauf (nachfolgend definiert) auf der Webseite/App, sowie den Zugriff und die Nutzung der Website/App.</p></li>
                            <li><span>2. </span> <p>Bitte lesen Sie die Allgemeinen Geschäftsbedingungen sorgfältig durch, bevor Sie mit dem Verkauf Ihrer Dienstleistungen bei uns beginnen. Indem Sie Ihren Verkauf (im Folgenden definiert) auf der Webseite/App bewerben, stimmen Sie der Anwendung der Verkaufsbedingungen zu.</p></li>
                            <li><span>3. </span> <p>Hintergrund & Verkauf: Die Webseite/App bietet Ihnen eine Plattform, auf der Sie Ihre Dienstleistungen, die Sie in Ihrem Geschäft zum Verkauf („Verkauf“) anbieten, an potenzielle Kunden bewerben können. Wir sind nur Vermittler zwischen Ihnen und dem Kunden und nehmen Zahlungen in Ihrem Namen von Kunden ein, die die Webseite/App verwenden. Wenn wir erfolgreich Zahlungen von Kunden erhalten, wird dieser Kunde von seiner bestehenden Zahlungsverpflichtung Ihnen gegenüber befreit.</p></li>
                        </ul>
                        <p>Diese Verkaufsbedingungen regeln das Rechtsverhältnis zwischen dem Dienstleister und dem Unternehmen. Alle Verkäufe, die durch die Terminvereinbarung durch den Dienstleister bereitgestellt werden, basieren auf diesen Verkaufsbedingungen. Der Dienstanbieter sollte die Verkaufsbedingungen der Webseite/App vollständig lesen, bevor er auf der Webseite/App verkauft.</p>
                        <h5>VERTRAGSABSCHLUSS</h5>
                        <p><strong>TLTR:</strong> Die unten aufgeführten Verfahren sind für den Abschluss eines Vertrages mit uns. Sie müssen sich mit uns in Verbindung setzen und unser Vertriebsmitarbeiter wird Sie hinsichtlich des Vertragsverfahrens begleiten. Sie können den Vertrag mit uns abschließen, indem Sie das Vertragsformular ausfüllen. Zahlungsdetails sollten uns ebenfalls mitgeteilt werden.</p>
                        <ul>
                            <li>
                                <span>4.</span>
                                <p>Wenn Sie ein Dienstleister sind und an einem Verkauf auf unserer Webseite/App interessiert sind, können Sie unsere Zentrale unter +49 30 1663969314 anrufen oder uns unter vertrieb@reserved4you.de schreiben oder das Kontaktformular auf unserer Webseite/App ausfüllen, welches im Kontaktbereich verfügbar ist. Einer unserer Vertriebsmitarbeiter führt ein persönliches oder telefonisches Gespräch mit Ihnen und unterstützt Sie bei unserem Vertragsabschluss.</p>
                            </li>
                            <li>
                                <span>5.</span>
                                <p>Sie haben die Möglichkeit den Vertrag mit uns abzuschließen, indem Sie sich mit den folgenden Angaben im Vertragsformular („Vertragsformular“) registrieren:</p>
                            </li>
                            <ul>
                                <li>1.	Kontaktdetails</li>
                                <li>2.	Salonname</li>
                                <li>3.	Name</li>
                                <li>4.	E-Mail</li>
                                <li>5.	Telefonnummer </li>
                                <li>6.	Adresse <br> Darüber hinaus müssen Sie das Paket und die zusätzlichen Dienstleistungen angeben, die Sie auswählen und die in Abschnitt 7 dieser Verkaufsbedingungen näher erläutert werden.</li>
                            </ul>
                            <li>
                                <span>6.</span>
                                <p>Außerdem müssen Sie auch die Zahlungsdaten angeben, die den Namen des Bankkontoinhabers, die Bankleitzahl und die IBAN umfassen.</p>
                            </li>
                        </ul>
                        <h5>PAKETE & ZAHLUNGEN</h5>
                        <p><strong>TLTR:</strong> Die unten aufgeführten Pakete stehen Ihnen zur Auswahl und die Preise verstehen sich zuzüglich aller anfallenden Steuern. Es gibt zwei unterschiedliche Vertragslaufzeiten, nämlich monatlich und jährlich. Wir können Ihnen Hardware zur Verfügung stellen, die wir für Sie kaufen und die Sie uns bezahlen. Die Zahlungen für Hardware und die Einstellungsgebühr werden einmalig am Anfang der Vertragslaufzeit abgebucht, weitere Zahlungen erfolgen monatlich und die Rechnung wird Ihnen per E-Mail zugesandt. Durch die Zahlung stimmen Sie den Nutzungsbedingungen zu und es gibt keine Rückerstattung, nachdem die Zahlung erfolgt ist. Kunden zahlen die Services an uns, es sei denn, sie entscheiden sich dafür, direkt vor Ort bei Ihnen zu bezahlen. Sie sind für die Zahlungen verantwortlich, die die Kunden direkt an Sie leisten. Sie können Ihr Geld zweiwöchentlich oder monatlich bei uns erhalten. Die Zahlung hat innerhalb einer Woche nach Rechnungsfreigabe an uns zu erfolgen.</p>
                        <ul>
                            <li>
                                <span>7.</span>
                                <p>Wir haben diese drei verschiedenen Pakete für Sie zur Auswahl, die in der folgenden Tabelle dargestellt sind:</p>
                            </li>
                        </ul>
                        <table>
                            <thead>
                              <tr>
                                  <th>Pakete</th>
                                  <th>BASIC</th>
                                  <th>BASIC PLUS</th>
                                  <th>BUSINESS</th>
                              </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Preis (monatlich)</td>
                                    <td>€0</td>
                                    <td>39.99 €</td>
                                    <td>79.99 €</td>
                                </tr>
                                <tr>
                                    <td>Preis (jährlich)</td>
                                    <td>€0</td>
                                    <td>29.99 €</td>
                                    <td>69.99 €</td>
                                </tr>
                                <tr>
                                    <td>Einstellungsgebühren (einmalig)</td>
                                    <td>-</td>
                                    <td>50 €</td>
                                    <td>100 €</td>
                                </tr>
                                <tr>
                                    <td>Inhalte</td>
                                    <td>-	Auflistung auf reserved4you  <br>-	Optimiert für mobile Endgeräte <br> -	48h E-Mail Support </td>
                                    <td>-	Auflistung auf reserved4you  <br>-	Optimiert für mobile Endgeräte <br>-	48h E-Mail Support, Live Chat  <br>-	eigener Admin Bereich </td>
                                    <td>-	Auflistung auf reserved4you  <br>-	Optimiert für mobile Endgeräte <br>-	24h E-Mail Support, Live Chat, Telefonsupport <br>-	eigener Admin Bereich <br>-	Newslettermarketing  <br>-	BUCHUNGSSYSTEM <br>-	Managementtools <br>-	kostenlose Schulung <br>-	individueller Newsletter <br>-	Statistiken</td>
                                </tr>
                            </tbody>
                        </table>
                        <table>
                            <thead>
                              <tr>
                                  <th>EXTRA SERVICES</th>
                                  <th>Onlinezahlungen</th>
                                  <th>Rabatte </th>
                                  <th>Empfehlungslisten</th>
                              </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Preis (monatlich)</td>
                                    <td>2,5 % Bearbeitungsgebühr für Online Zahlungen/ Monat</td>
                                    <td>15,00€/ Monat</td>
                                    <td>30,00€/ Monat</td>
                                </tr>
                                <tr>
                                    <td>Preis (jährlich)</td>
                                    <td>2,5 % Bearbeitungsgebühr für Online Zahlungen/ Monat</td>
                                    <td>7,50€/ Monat</td>
                                    <td>20,00€/ Monat</td>
                                </tr>
                                <tr>
                                    <td>Inhalt</td>
                                    <td>Ihre Kunden haben die Möglichkeit ihre gebuchten Services vorher schon online zu bezahlen, mit allen gängigen Zahlungsmöglichkeiten (PayPal, Klarna, SofortÜberweisung, etc.), dennoch besteht auch die Möglichkeit vor Ort zu zahlen.</td>
                                    <td>Sie haben die Möglichkeit Ihren Kunden auf Dienstleistungen Rabatte anzubieten (Rabatte zum umsatzschwächeren Zeiten, um den Laden zu füllen). Die Rabatte sind jederzeit veränderbar und können neu hinzugefügt werden.</td>
                                    <td>Um eine größere Reichweite zu generieren , haben Sie die Möglichkeit in unseren Empfehlungslisten aufgelistet zu sein. Diese findet man in jedem Bereich auf unserer Webseite.</td>
                                </tr>
                            </tbody>
                        </table>
                        <ul>
                            <li>
                                <span>8.</span>
                                <p>	Die oben angegebenen Preise verstehen sich zuzüglich aller anwendbaren Steuern und wenn Sie die Bestellung aufgeben, werden die geltenden Steuern gemäß dem Gesetz erhoben.</p>
                            </li>
                            <li>
                                <span>9.</span>
                                <p>	Es gibt zwei verschiedene Vertragslaufzeiten, aus denen Sie wählen können, d. h. monatlich oder jährlich, die für die Pakete und die Zusatzleistungen gelten, mit Ausnahme des Basic Pakets, welches kostenlos ist.</p>
                            </li>
                            <li>
                                <span>10.</span>
                                <p>	Sie können auch elektronisches Zubehör wie ein iPad oder jedes andere von uns zur Verfügung gestellte Gerät buchen, bei dem wir diese Hardware für Sie kaufen und Ihnen zusenden. Sie müssen die Kosten für dieses Gerät im Voraus bezahlen.</p>
                            </li>
                            <li>
                                <span>11.</span>
                                <p>Es gibt zwei Möglichkeiten, wie Sie Zahlungen an uns leisten können: </p>
                            </li>
                            <ul>
                                <li>
                                    <span>1.</span>
                                    <p>der erste Weg ist das Sepa-Lastschriftverfahren, bei dem Ihnen die Rechnung vorab zugesandt und die Zahlung nach einer Woche nach Zusendung der Rechnung abgebucht wird <br> ODER</p>
                                </li>
                                <li>
                                    <span>2.</span>
                                    <p>	der zweite Weg ist, dass wir Ihnen die Rechnung zusenden und Sie die Zahlung innerhalb einer Woche nach Erhalt der Rechnung selbst vornehmen müssen.</p>
                                </li>
                            </ul>
                            <li>
                                <span>12.</span>
                                <p>	Sobald Sie die Zahlung für Ihre Bestellung getätigt haben, können Sie die Bestellung nicht mehr stornieren und wir können Ihnen diese nicht erstatten. Daher ist die von Ihnen geleistete Zahlung dauerhaft und unterliegt keiner Rückerstattung oder Stornierung.</p>
                            </li>
                            <li>
                                <span>13.</span>
                                <p>	Wir werden die Zahlungen in Ihrem Namen vom Kunden einziehen, es sei denn, der Kunde beschließt, in Ihrem Geschäft in bar zu bezahlen. Sie sind für jede Zahlung verantwortlich, wenn der Kunde in Ihrem Geschäft in bar bezahlt und Sie werden uns nicht für diese Zahlung im Geschäft verantwortlich machen können. Sie können sich die eingezahlten Zahlungen einmal alle zwei Wochen oder zum Ende eines jeden Monats auf Ihren Wunsch auf Ihr Konto überweisen lassen. Dies ist wie eine Sicherheit für den Kunden, bei der der Kunde im Falle einer Stornierung die Rückerstattung sofort zurückerhalten kann.</p>
                            </li>
                            <li>
                                <span>14.</span>
                                <p>	Wir können den Preis des Pakets und/oder der Zusatzleistungen nach eigenem Ermessen jederzeit mit einer Frist von dreißig (30) Tagen ändern, außer in Fällen, in denen Ihre Vertragslaufzeit für das Jahrespaket läuft, die nicht einem Wechsel unterliegt. Wenn Sie die monatlichen Dienste nach Erhalt einer entsprechenden Preisänderungsmitteilung weiter nutzen, gilt dies als Annahme der neuen Gebühren bzw. Provisionen.</p>
                            </li>
                        </ul>
                        <h5>KONTO DES DIENSTLEISTERS</h5>
                        <p><strong>TLTR:</strong> Nachdem die Zahlung erfolgt ist, werden wir alle Ihre Informationen in 2-5 Werktagen hochladen und Sie erhalten nach Abschluss des Vorgangs eine Bestätigungs-E-Mail. Sie erhalten auch einen Link, über den Sie die Inhalte Ihres Stores hinzufügen können. Nachdem wir alle Details über den Link erhalten haben, werden wir sie in Ihr Profil hochladen und Sie haben Zugriff auf Ihr Dienstanbieter-Panel. Sie können die im Panel erwähnten Informationen bearbeiten.</p>
                        <ul>
                            <li>
                                <span>15.</span>
                                <p>	Sobald Sie die Zahlung getätigt haben, werden Sie bei uns als unser Dienstleister registriert und wir werden alle Ihre Informationen innerhalb von 2-5 Werktagen in unserem System hochladen. Sobald der Vorgang bei uns abgeschlossen ist, erhalten Sie eine Bestätigungs-E-Mail mit allen Bestätigungen über den erfolgreichen Abschluss unseres Vertrags.</p>
                            </li>
                            <li>
                                <span>16.</span>
                                <p>	Neben der Bestätigungs-E-Mail senden wir Ihnen auch einen Link, über den Sie den Inhalt Ihres Shops hinzufügen können, der (beschränkt sich nicht auf) Bilder Ihrer Dienstleistungen, Öffnungszeiten usw. enthalten kann, die in Ihr Profil hochgeladen werden müssen . Wir senden Ihnen auch ein vom System generiertes Passwort für Ihr Website-/App-Konto und Sie können dieses Passwort nicht ändern. Daher ist es wichtig, dass Sie dieses Passwort sicher aufbewahren und nicht an Dritte weitergeben.</p>
                            </li>
                            <li>
                                <span>17.</span>
                                <p>	Sobald Sie uns alle Details über den Link zusenden, laden wir die Details innerhalb von 2-5 Werktagen in Ihrem Profil hoch, woraufhin Sie einen Zugang zu Ihrem Dienstanbieter-Panel haben, wo Sie alle Ihre Daten einsehen können.</p>
                            </li>
                            <li>
                                <span>18.</span>
                                <p>Sie haben die Möglichkeit, Ihre im Panel genannten Informationen zu überprüfen und zu bearbeiten. Im Folgenden finden Sie die Informationen, die Sie auf dem Panel anzeigen und bearbeiten können, die in dem von Ihnen ausgewählten Paket miteinbegriffen sind</p>
                            </li>
                            <ul>
                                <li>
                                    <span>1.</span>
                                    <p>	Dashboard</p>
                                </li>
                                <li>
                                    <span>2.</span>
                                    <p>	Übersicht Ihrer aktuellen Termine</p>
                                </li>
                                <li>
                                    <span>3.</span>
                                    <p>	Übersicht der eigenen Mitarbeiter, wer an diesem Tag verfügbar ist</p>
                                </li>
                                <li>
                                    <span>4.</span>
                                    <p>	Übersicht aller Buchungen</p>
                                </li>
                                <li>
                                    <span>5.</span>
                                    <p>	Übersicht Ihrer Einnahmen</p>
                                </li>
                                <li>
                                    <span>6.</span>
                                    <p>	Kalender</p>
                                </li>
                                <li>
                                    <span>7.</span>
                                    <p>	Übersicht der Termine während des Tages, der Woche und des gesamten Monats.</p>
                                </li>
                                <li>
                                    <span>8.</span>
                                    <p>	Terminbuchungen</p>
                                </li>
                                <li>
                                    <span>9.</span>
                                    <p>	Sie können Termine stornieren</p>
                                </li>
                                <li>
                                    <span>10.</span>
                                    <p>	Sie können Termine verschieben</p>
                                </li>
                                <li>
                                    <span>11.</span>
                                    <p>	Alle Informationen zu den Terminen können eingesehen werden:</p>
                                </li>
                                <ul>
                                    <li>
                                        <span>1.</span>
                                        <p>	Name</p>
                                    </li>
                                    <li>
                                        <span>2.</span>
                                        <p>	Buchungs-ID</p>
                                    </li>
                                    <li>
                                        <span>3.</span>
                                        <p>	Sie können eine Anfrage an den Kunden für eine Überprüfung senden, wenn Sie den Termin verschieben möchten</p>
                                    </li>
                                    <li>
                                        <span>4.</span>
                                        <p>	Zahlungsart und -betrag/p>
                                    </li>
                                    <li>
                                        <span>5.</span>
                                        <p>	Datum und Uhrzeit</p>
                                    </li>
                                    <li>
                                        <span>6.</span>
                                        <p>	Mitarbeiter</p>
                                    </li>
                                    <li>
                                        <span>7.</span>
                                        <p>	Service</p>
                                    </li>
                                </ul>
                                <li>
                                    <span>12.</span>
                                    <p>	Kunden</p>                                    
                                </li>
                                <ul>
                                    <li>
                                            <span>1.</span>
                                            <p>	Sie können Stammkunden hinzufügen, nachdem der Kunde zugestimmt hat, dass Sie ein Profil für ihn erstellen können.</p>
                                        </li>
                                        <li>
                                            <span>2.</span>
                                            <p>	Sie finden alle Informationen, darunter:</p>
                                        </li>
                                        <li>
                                            <span>3.</span>
                                            <p>	Profilbild</p>
                                        </li>
                                        <li>
                                            <span>4.</span>
                                            <p>	Anzahl der Buchungen</p>
                                        </li>
                                        <li>
                                            <span>5.</span>
                                            <p>	Anzahl der Verkäufe, die der Kunde bisher bezahlt hat</p>
                                        </li>
                                </ul>
                                <li>
                                    <span>13.</span>
                                    <p>	Mitarbeiter</p>
                                </li>
                                <ul>
                                    <li>
                                        <span>1.</span>
                                        <p>	Sie können die Mitarbeiterdaten im Panel hochladen</p>
                                    </li>
                                </ul>
                                <li>
                                    <span>14.</span>
                                    <p>	Ihr Betriebs-Profil</p>
                                </li>
                                <ul>
                                    <li>
                                        <span>1.</span>
                                        <p>	Sie können Profilinformationen ändern</p>
                                    </li>
                                    <li>
                                        <span>2.</span>
                                        <p>	Bewertungen ansehen und beantworten</p>
                                    </li>
                                </ul>
                                <li>
                                    <span>15.</span>
                                    <p>	Statistiken</p>
                                </li>
                                <ul>
                                    <li>
                                        <span>1.</span>
                                        <p>	Alle notwendigen Statistiken sind auf dem Panel verfügbar, das Ihnen hilft, Ihre Verkäufe zu überwachen.</p>
                                    </li>
                                </ul>
                                <li>
                                    <span>16.</span>
                                    <p>	Finanzen</p>
                                </li>
                                <ul>
                                    <li>
                                        <span>1.</span>
                                        <p>	Alle Ihre Buchungen und Verkäufe werden verfügbar sein.</p>
                                    </li>
                                </ul>
                            </ul>
                        </ul>
                        <h5>LAUFZEIT UND KÜNDIGUNG</h5>
                        <p>
                            <strong>TLTR:</strong>
                            Der Vertrag läuft nicht ab, es sei denn, er wird von einer der Parteien gekündigt. Die Kündigung des Vertrages sollte bei Monatsabonnement zwei Wochen im Voraus per E-Mail und bei Jahresabonnement 30 Tage vorher per E-Mail erfolgen. Bei Verstößen gegen die Verkaufsbedingungen behalten wir uns das Recht vor, den Vertrag mit Ihnen fristlos zu kündigen.
                        </p>
                        <ul>
                            <li>
                                <span>19.</span>
                                <p>	Ihr Vertrag mit uns läuft nicht aus, es sei denn, er wird von einer der Parteien gekündigt. Der Vertrag beginnt mit dem Tag der Zahlung.</p>
                            </li>
                            <li>
                                <span>20.</span>
                                <p>	Sie müssen diese Vereinbarung über die Nutzungsdauer kündigen, indem Sie uns zwei (2) Wochen im Voraus schriftlich unter unserer Mail Adresse kuendigung@reserved4you.de mitteilen, wenn Sie die monatliche Zahlungsmethode in Anspruch genommen haben. Falls Sie die jährliche Zahlungsmethode in Anspruch genommen haben, müssen Sie diese Vereinbarung über die Nutzungsdauer mit einer Frist von dreißig (30) Tagen schriftlich unter unserer Mail Adresse kuendigung@reserved4you.de kündigen.</p>
                            </li>
                            <li>
                                <span>21.</span>
                                <p>	Die Beendigung oder Aussetzung dieser Verkaufsbedingungen aus welchem Anlass auch immer, lässt die Rechte und Pflichten unberührt, die vor dem Ablaufdatum oder der Beendigung aufgetreten oder entstanden sind und Rechnungen oder andere Verpflichtungen sind innerhalb von dreißig (30) Tagen nach einer solchen Beendigung zu begleichen.</p>
                            </li>
                            <li>
                                <span>22.</span>
                                <p>	Wir behalten uns das Recht vor, Ihr Konto und den Zugriff auf die Webseite/App ohne vorherige Ankündigung und nach unserem alleinigen Ermessen zu kündigen oder zu sperren und Ihren zukünftigen Zugriff und Ihre Nutzung Ihres Kontos zu sperren oder zu verhindern, wenn Sie gegen die Verkaufsbedingungen verstoßen. Falls erforderlich, können wir auch alle von Ihnen geteilten Inhalte oder Informationen entfernen, wenn wir glauben, dass sie gegen die Verkaufsbedingungen verstoßen.</p>
                            </li>
                        </ul>
                        <h5>VERPFLICHTUNGEN ALS DIENSTLEISTER</h5>
                        <p><strong>TLTR:</strong> Um einen Kaufvertrag mit uns abzuschließen, sollten Sie mindestens 18 Jahre alt sein. Sie müssen die in diesen Verkaufsbedingungen genannten Bedingungen einhalten und dürfen Ihre Kontodaten, Ihr Passwort und Ihre Registrierungsdaten nicht an andere Personen weitergeben. Im Falle eines Versuchs, sich unbefugten Zugriff auf eine Funktion der Webseite/App auf unrechtmäßige Weise zu verschaffen, kann dies eine Straftat darstellen und wir werden den Behörden Anzeige erstatten und Ihr Konto erlischt mit sofortiger Wirkung. Sie sollten uns im Falle einer unbefugten Nutzung Ihres Kontos informieren und keine Inhalte einstellen, die obszön, diffamierend oder gegen die Rechte Dritter verstoßen. Im Falle obszöner Inhalte, die Sie auf der Webseite/App finden, können Sie uns dies per E-Mail melden.</p>
                        <ul>
                            <li>
                                <span>23.</span>
                                <p>	Sie sollten mindestens achtzehn (18) Jahre alt sein, um einen Kaufvertrag mit uns abzuschließen.</p>
                            </li>
                            <li>
                                <span>24.</span>
                                <p>	Für den Verkauf müssen Sie sich immer an die in diesen Verkaufsbedingungen genannten Bedingungen halten und dies nur zu den in diesen Verkaufsbedingungen genannten Zwecken.</p>
                            </li>
                            <li>
                                <span>25.</span>
                                <p>	Sie dürfen Ihre Kontodaten, Passwörter und Registrierungsdaten nicht an andere Personen weitergeben.</p>
                            </li>
                            <li>
                                <span>26.</span>
                                <p>	Sie dürfen nicht versuchen, sich auf unrechtmäßige Weise, einschließlich Cyberkriminalität, unbefugten Zugriff auf Teile oder Funktionen der Website/App oder anderer Systeme oder Netzwerke zu verschaffen, die mit dem Panel oder den Servern verbunden sind. Ein Verstoß gegen diese Bestimmung kann eine Straftat darstellen. Wir werden einen solchen Verstoß den zuständigen Strafverfolgungsbehörden melden und mit diesen zusammenarbeiten, indem wir Ihre Identität offenlegen. Bei einem entsprechenden Verstoß erlischt Ihr Recht zur Nutzung unserer Webseite/App mit sofortiger Wirkung.</p>
                            </li>
                            <li>
                                <span>27.</span>
                                <p>	Sie sollten uns unverzüglich über jede unbefugte Nutzung Ihres registrierten Kontos oder über die versehentliche Weitergabe Ihres Kontopassworts benachrichtigen.</p>
                            </li>
                            <li>
                                <span>28.</span>
                                <p>	Es gibt Funktionen auf der Webseite/App, die es Ihnen ermöglichen, Bilder zu veröffentlichen, Ihre Dienste zu erwähnen und andere Inhalte zu erwähnen. Sie dürfen keine anstößigen, obszönen, verleumderischen, rassistischen, schädlichen, ungenauen, rechtswidrigen, illegalen, irreführenden Inhalte oder die Rechte Dritter verletzen, auf der Webseite/App veröffentlichen. In solchen Fällen geben wir Ihnen bis zu 3 Warnungen, nach denen wir Ihre Nutzung der Webseite/App sperren können. Im Falle eines schwerwiegenden Verstoßes gegen diese Klausel wird Ihre Nutzung der Webseite/App von uns ohne Vorwarnung gesperrt.</p>
                            </li>
                            <li>
                                <span>29.</span>
                                <p>	Wenn Sie der Meinung sind, dass ein Beitrag anstößig, obszön, diffamierend, rassistisch, schädlich, ungenau, rechtswidrig, illegal oder in irgendeiner Weise irreführend ist, teilen Sie uns dies bitte mit, indem Sie uns eine E-Mail an b2b.support@reserved4you.de. Nach Eingang Ihrer Beschwerde ist es möglich, dass wir den betreffenden Beitrag entfernen oder den Zugriff darauf sperren.</p>
                            </li>
                        </ul>
                        <h5>RECHTE DES UNTERNEHMENS</h5>
                        <p><strong>TLTR:</strong> Das Unternehmen behält sich das Recht vor, die Nutzung des Panels zu überwachen und bei Verstößen gegen Gesetze oder Verkaufsbedingungen geeignete rechtliche Schritte einzuleiten. Wir behalten uns auch das Recht vor, alle Informationen zu überwachen, aufzubewahren und offenzulegen, die für eine gesetzliche Anforderung, polizeiliche Untersuchung oder behördliche Untersuchung erforderlich sind.</p>
                        <ul>
                            <li>
                                <span>30.</span>
                                <p>	Wir behalten uns das Recht vor, Ihre Nutzung des Panels auf Verstöße gegen die Verkaufsbedingungen zu überwachen.</p>
                            </li>
                            <li>
                                <span>31.</span>
                                <p>	Wir werden angemessene rechtliche Schritte gegen jeden einleiten, der nach unserem alleinigen Ermessen gegen Gesetze oder Verkaufsbedingungen verstößt.</p>
                            </li>
                            <li>
                                <span>32.</span>
                                <p>	Wir behalten uns das Recht vor, alle Informationen zu überwachen, aufzubewahren und offenzulegen, wenn dies erforderlich ist, um geltende Gesetze, rechtliche Anforderungen, polizeiliche Ermittlungen oder andere behördliche Ermittlungen zu erfüllen.</p>
                            </li>
                            <li>
                                <span>33.</span>
                                <p>	Wir behalten uns das Recht vor, unsere Dienste so zu verwalten, dass unsere Rechte geschützt und die ordnungsgemäße Bereitstellung unserer Dienste erleichtert wird.</p>
                            </li>
                        </ul>
                        <h5>WEBSEITE UND POSTS VON DRITTANBIETERN</h5>
                        <p>TLTR: Sie sind für alle von Ihnen eingestellten Inhalte verantwortlich. Die Webseite/App kann Links zu Ihrer Website enthalten und Sie sind für den Besuch Ihrer Webseite durch Kunden verantwortlich.</p>
                        <ul>
                            <li>
                                <span>34.</span>
                                <p>	Sie und andere Dienstanbieter haben möglicherweise viele Anzeigen und Beiträge auf unserer Webseite/App. Sie sind allein verantwortlich für den Inhalt Ihrer Anzeigen und für deren Übereinstimmung mit allen einschlägigen Gesetzen und Vorschriften. Wir übernehmen keinerlei Verantwortung für Ihre Inhalte, Anzeigen, Beiträge oder Links.</p>
                            </li>
                            <li>
                                <span>35.</span>
                                <p>	Die Webseite/App kann Links zu Ihrer Website enthalten, die von Ihnen betrieben wird. Wenn die Kunden Ihre Website besuchen, sind Sie für ihren Besuch verantwortlich. Wir sind weder direkt noch indirekt verantwortlich oder haftbar für den Inhalt, die Genauigkeit oder die Meinungen, die auf Ihren Websites, Links und/oder der Qualität der Waren oder Dienstleistungen, die durch oder auf solchen Websites angeboten werden, zum Ausdruck kommen.</p>
                            </li>
                        </ul>
                        <h5>PRIVATSPHÄRE</h5>
                        <p><strong>TLTR:</strong> Die Datenschutzrichtlinie ist Teil dieser Verkaufsbedingungen und Sie müssen die Datenschutzrichtlinie lesen, bevor Sie die Webseite/App nutzen.</p>
                        <ul>
                            <li>
                                <span>36.</span>
                                <p>	Die Datenschutzrichtlinie erwähnt die Art und Weise, wie wir Ihre Informationen sammeln und verwenden, und finden Sie unter diesem Link https://www.reserved4you.de/datenschutz . Durch die Nutzung unserer Dienste stimmen Sie der darin beschriebenen Verarbeitung zu und garantieren, dass alle von Ihnen bereitgestellten Daten korrekt sind. Die Datenschutzrichtlinie ist Bestandteil dieser Verkaufsbedingungen. Sie müssen die Datenschutzrichtlinie lesen, bevor Sie die Webseite/App nutzen.</p>
                            </li>
                        </ul>
                        <h5>GEISTIGES EIGENTUM</h5>
                        <p><strong>TLTR:</strong> Das gesamte geistige Eigentum in Bezug auf die Webseite/App gehört dem Unternehmen und alles andere geistige Eigentum ist das Eigentum ihrer jeweiligen Eigentümer. Gemäß den Verkaufs- und Vertragsbedingungen gestatten Sie uns, Ihr geistiges Eigentum ausschließlich gemäß den Verkaufsbedingungen zu verwenden. Sie haben nicht das Recht, das geistige Eigentum unseres Unternehmens ohne unsere ausdrückliche Zustimmung zu nutzen. Wenn Sie dazu neigen, uns eine kreative Idee zuzusenden, erklären Sie sich damit einverstanden, dass wir die Idee jederzeit uneingeschränkt verwenden können. Wir sind nicht verpflichtet, die Idee geheim zu halten, eine Entschädigung zu zahlen oder Sie für die Idee anzuerkennen. Wenn Sie der Meinung sind, dass Inhalte auf der Webseite/App Ihr geistiges Eigentum verletzt haben, benachrichtigen Sie uns bitte umgehend per E-Mail.</p>
                        <ul>
                            <li>
                                <span>37.</span>
                                <p>	Geistiges Eigentum bezeichnet alle geistigen Eigentumsrechte, ob eingetragen oder anderweitig erworben oder bedingt, einschließlich (aber nicht beschränkt auf) Urheberrechte (einschließlich Rechte zur Übersetzung in Fremdsprachen), Geschmacksmusterrechte, Datenbankrechte, Rechte an Domainnamen , Gebrauchsmuster, Patente, Marken, Handelsnamen, Warenzeichen und sonstige Bezeichnungen, sofern die vorstehenden Rechte unter gewerbliche Schutzrechte fallen, sowie ähnliche Rechte, unabhängig davon, ob diese eingetragen sind oder sonst bestehen (wie alle Erweiterungen, alle Sachverhalte) des Rückfalls oder der Wiederbelebung von Rechten sowie deren Erneuerung) („Geistiges Eigentum“).</p>
                            </li>
                            <li>
                                <span>38.</span>
                                <p>	Jegliches geistiges Eigentum in Bezug auf die Webseite/App gehört dem Unternehmen, und all jenes geistiges Eigentum, das nicht im Besitz des Unternehmens ist und auf der Webseite/App erscheint, ist Eigentum der jeweiligen Eigentümer/Ihnen/anderen Dienstleister.</p>
                            </li>
                            <li>
                                <span>39.</span>
                                <p>	Gemäß diesen Verkaufsbedingungen und dem Vertrag zwischen uns gestatten Sie uns, Ihr geistiges Eigentum für die Zwecke dieser Verkaufsbedingungen und nicht für andere Zwecke außerhalb dieser Bedingungen zu verwenden. Sie bestätigen und erklären auch, dass Sie der wahre und rechtmäßige Eigentümer des geistigen Eigentums sind, das Sie uns erlauben, in Ihrem Namen auf unserer Webseite/App zu veröffentlichen und dass keine anderen Rechte Dritter mit Ihrem geistigen Eigentum verbunden sind, das Sie auf unserer Webseite/App veröffentlichen.</p>
                            </li>
                            <li>
                                <span>40.</span>
                                <p>	Sie dürfen das geistige Eigentum des Unternehmens verwenden, um mit vorheriger schriftlicher Genehmigung des Unternehmens für unsere Zusammenarbeit zu werben. Es liegt im Ermessen des Unternehmens, Ihnen die Nutzung des geistigen Eigentums des Unternehmens zu gewähren. Diese Verwendung bedeutet keine Abtretung oder Lizenzierung von geistigem Eigentum des Unternehmens und darf nur zu Werbezwecken verwendet werden. Sie müssen auch sicherstellen, dass das geistige Eigentum nicht in abfälligem Licht dargestellt und nicht herabgesetzt wird. Wenn Ihnen die Nutzung unseres geistigen Eigentums gewährt wird, erfolgt dies nur zum Zweck dieser Verkaufsbedingungen und nicht zu anderen Zwecken außerhalb dieser Bedingungen.</p>
                            </li>
                            <li>
                                <span>41.</span>
                                <p>	Wenn Sie uns zu irgendeinem Zeitpunkt mit oder ohne unsere Aufforderung kreative Ideen, Kommentare, Vorschläge, Vorschläge, Pläne oder anderes Material per Post oder einem anderen Medium (zusammen „Idee“ genannt) senden, bestätigen Sie hiermit und stimmen zu, dass wir jederzeit ohne Einschränkung alle Medien und Ideen, die Sie an uns übermitteln, bearbeiten, kopieren, veröffentlichen, verteilen, übersetzen und anderweitig verwenden dürfen. Wir sind nicht verpflichtet, (a) die Idee(n) vertraulich zu behandeln (b) eine Entschädigung für jede Idee(n) zu zahlen (c) auf eine Idee(n) zu reagieren (d) Sie für die Idee anzuerkennen.</p>
                            </li>
                            <li>
                                <span>42.</span>
                                <p>	Da es viele Dienstleister und Kunden gibt, die viele Inhalte auf unserer Webseite/App posten dürfen, ist es für uns unmöglich, den Inhaber des geistigen Eigentums zu verfolgen. Wenn Sie der Meinung sind, dass ein Inhalt der Webseite/App Ihr geistiges Eigentum verletzt, benachrichtigen Sie uns bitte umgehend über unsere E-Mail-Adresse b2b.support@reservedyou.de . Sobald dieses Verfahren befolgt wurde, werden wir alle angemessenen Anstrengungen unternehmen, um solche Inhalte innerhalb einer angemessenen Zeit zu entfernen. Bitte beachten Sie, dass wir nicht für die Inhalte Dritter verantwortlich sind, die auf der Webseite/App veröffentlicht werden, aber wir werden selbstverständlich angemessene Schritte unternehmen, um Ihre Erfahrung mit uns zufriedenstellend zu gestalten.</p>
                            </li>
                        </ul>
                        <h5>UNSERE HAFTUNG</h5>
                        <p><strong>TLTR:</strong> Unsere Dienstleistungen werden je nach Verfügbarkeit bereitgestellt. Wir garantieren nicht, dass Sie Kunden für Ihren Verkauf gewinnen, da die Häufigkeit der Kunden außerhalb unserer Kontrolle liegt. Auch die unterbrechungsfreie Funktion der Dienste wird von uns nicht gewährleistet. Wir bemühen uns, Ihnen einen fehlerfreien Service zu bieten. Wir garantieren nicht, dass die Webseite und die App virenfrei sind. Es gibt keine Garantie dafür, dass die Nutzung unserer Dienste Ihren Anforderungen entspricht. Wir übernehmen auch keine Gewähr für die Richtigkeit oder Vollständigkeit der Ungenauigkeiten und Tippfehler.</p>
                        <ul>
                            <li>
                                <span>43.</span>
                                <p>	Wir stellen Ihnen unsere Dienstleistungen „nach Verfügbarkeit“ ohne jegliche ausdrückliche oder stillschweigende Gewährleistung zur Verfügung.</p>
                            </li>
                            <li>
                                <span>44.</span>
                                <p>	Wir garantieren nicht, dass Sie durch die Nutzung unserer Dienste, Webseite/App Kunden für Ihren Verkauf gewinnen, da die Häufigkeit der Kunden außerhalb unserer Kontrolle liegt.</p>
                            </li>
                            <li>
                                <span>45.</span>
                                <p>	Wir garantieren nicht, dass die App, die Webseite und das System ununterbrochen funktionieren und dass die Dienste immer zur Nutzung verfügbar sind.</p>
                            </li>
                            <li>
                                <span>46.</span>
                                <p>	Wir bemühen uns stets sicherzustellen, dass die Webseite/App ohne Unterbrechungen verfügbar ist und die Übertragungen fehlerfrei sind. Aufgrund der Beschaffenheit des Internets und verschiedener anderer Faktoren können wir jedoch nicht garantieren, dass die Webseite und die App fehlerfrei sind oder die Mängel behoben werden. Darüber hinaus garantieren wir nicht, dass die Webseite und die App virenfrei oder ohne andere schädliche Komponenten sind. In dieser Hinsicht müssen Sie Ihre eigenen Vorkehrungen treffen. In jedem Fall übernehmen wir keine Haftung für Verluste oder Schäden, die durch Distributed-Denial-of-Service-Angriffe, Computerviren oder andere technisch schädliche Materialien Ihrer Datenverarbeitungsgeräte, Datenverarbeitungsprogramme verursacht werden.</p>
                            </li>
                            <li>
                                <span>47.</span>
                                <p>	Wir übernehmen keine Gewähr für diese Ergebnisse oder dass die Nutzung der App/Webseite und des Systems Ihren Anforderungen entsprechen wird.</p>
                            </li>
                            <li>
                                <span>48.</span>
                                <p>	Wir haften nicht für die Folgen von Unterbrechungen oder Fehlern in der App/Webseite oder den Diensten und wir garantieren nicht für die Richtigkeit oder Vollständigkeit, Ungenauigkeiten und typografischen Fehler.</p>
                            </li>
                        </ul>
                        <h5>ENTSCHÄDIGUNG</h5>
                        <p><strong>TLTR:</strong> Sie erklären sich damit einverstanden, das Unternehmen für alle entstandenen Kosten, Ansprüche von Ihnen oder Dritten, für Verbindlichkeiten, die gegen das Unternehmen erhoben werden, zu entschädigen, wenn Sie diese Verkaufsbedingungen nicht erfüllen oder verletzen.</p>
                        <ul>
                            <li>
                                <span>49.</span>
                                <p> Sie erklären sich damit einverstanden, das Unternehmen von allen entstandenen Kosten, Ansprüchen von Ihnen oder Dritten für Verbindlichkeiten, die gegen das Unternehmen erhoben werden, einschließlich, aber nicht beschränkt auf Gerichtskosten, Anwaltskosten und Prozesskosten, schadlos zu halten, zu verteidigen und schadlos zu halten aus oder resultierend aus, direkt oder indirekt, ganz oder teilweise, Ihrer Verletzung oder Nichteinhaltung eines Teils dieser Verkaufsbedingungen und/oder Ihrer Handlungen oder Unterlassungen, die Ihnen oder Dritten Verletzungen oder Schäden zufügen.</p>
                            </li>
                        </ul>
                        <h5>HAFTUNGSBESCHRÄNKUNG</h5>
                        <p><strong>TLTR:</strong> Die unten genannten sind Haftungsbeschränkungen des Unternehmens und die Haftung des Unternehmens ist auf einen bestimmten Betrag wie erwähnt begrenzt. Das Unternehmen haftet nicht für Schäden, die durch die Nutzung der Dienste entstehen.</p>
                        <ul>
                            <li>
                                <span>50.</span>
                                <p> Sie erkennen hiermit an und stimmen zu, dass, wenn festgestellt wird, dass das Unternehmen für Ansprüche aus irgendeinem Grund haftbar ist, diese Haftung auf den höheren Betrag von (a) den von Ihnen auf der Webseite/App gezahlten Gesamtgebühren oder (b ) Einhundert Euro (100 €).</p>
                            </li>
                            <li>
                                <span>51.</span>
                                <p> Sie stimmen zu, dass wir nicht für Schäden haften, die durch die Nutzung der App/Webseite oder unserer Dienste entstehen.</p>
                            </li>
                            <li>
                                <span>52.</span>
                                <p> In keinem Fall haften wir für indirekte, strafrechtliche, besondere, zufällige oder Folgeschäden (einschließlich Geschäfts-, Umsatz-, Gewinn-, Nutzungs-, Datenschutz-, Daten-, Goodwill- oder sonstiger wirtschaftlicher Vorteil), wie auch immer sie entstehen, sei es für Vertragsverletzung oder aus unerlaubter Handlung, auch wenn er zuvor auf die Möglichkeit eines solchen Schadens hingewiesen wurde.</p>
                            </li>
                            <li>
                                <span>53.</span>
                                <p> Ohne Einschränkung des Vorstehenden übersteigt unsere Gesamthaftung Ihnen gegenüber in keinem Fall den Betrag, den Sie für die Dienste erworben haben.</p>
                            </li>
                        </ul>
                        <h5>ÄNDERUNG DER VERKAUFSBEDINGUNGEN</h5>
                        <p><strong>TLTR:</strong> Das Unternehmen hat das Recht, die Klauseln dieser Verkaufsbedingungen jederzeit mit einer Frist von dreißig Tagen im Voraus zu ändern (Ausnahme ist der Jahresvertrag mit uns). Sie sind dafür verantwortlich, die Verkaufsbedingungen regelmäßig zu überprüfen.</p>
                        <ul>
                            <li>
                                <span>54.</span>
                                <p> Wir behalten uns das Recht vor, diese Bedingungen dieser Verkaufsbedingungen jederzeit und nach eigenem Ermessen zu ändern, zu modifizieren, hinzuzufügen oder zu entfernen, es sei denn, Sie haben bereits einen Jahresvertrag mit uns abgeschlossen, da ist die Vereinbarung bereits vollzogen. Wir werden Sie mindestens dreißig (30) Tage über Änderungen informieren oder Sie bei Ihrem nächsten Zugriff auf die Webseite/App über die Änderungen informieren. Es liegt in Ihrer Verantwortung, die Verkaufsbedingungen regelmäßig auf Änderungen zu überprüfen. Ihre fortgesetzte Nutzung der Dienste nach der Veröffentlichung von Änderungen dieser Verkaufsbedingungen bedeutet, dass Sie die Änderungen akzeptieren und ihnen zustimmen.</p>
                            </li>
                        </ul>
                        <h5>GELTENDES RECHT UND GERICHTSSTAND</h5>
                        <p><strong>TLTR:</strong> Dieser Vertrag unterliegt dem Recht von Berlin, Deutschland.</p>
                        <ul>
                            <li>
                                <span>55.</span>
                                <p> Dieser Vertrag unterliegt dem Recht von Berlin, Deutschland und wird in Übereinstimmung mit diesem ausgelegt.</p>
                            </li>
                            <li>
                                <span>56.</span>
                                <p> Jede Partei stimmt hiermit absolut und unwiderruflich zu und unterwirft sich dem ausschließlichen Gerichtsstand und der ausschließlichen Zuständigkeit der Gerichte in Berlin und der dort ansässigen Gerichte im Zusammenhang mit Klagen oder Verfahren, die sich aus oder im Zusammenhang mit diesen Verkaufsbedingungen ergeben.</p>
                            </li>
                        </ul>
                        <h5>SONSTIGES</h5>
                        <p><strong>TLTR:</strong> Es wird darauf hingewiesen, dass der Verzicht auf eine der Bedingungen dieser Verkaufsbedingungen nicht auch andere Bedingungen umfasst. Auch die Unwirksamkeit einer der Bestimmungen dieser Verkaufsbedingungen berührt die Gültigkeit der übrigen Bestimmungen nicht. Sie haben kein Recht zur Abtretung dieser Bedingungen, es sei denn, wir haben Ihnen schriftlich zugestimmt. Außerdem dient die TLTR nur als Referenz und ist nicht bindend.</p>
                        <ul>
                            <li>
                                <span>57.</span>
                                <p> Kein Verzicht einer der Parteien auf eine Bestimmung dieser Verkaufsbedingungen, sei es durch Verhalten oder anderweitig, in einem oder mehreren Fällen, gilt als fortwährender Verzicht auf eine solche Bestimmung oder Bedingung oder als Verzicht auf eine andere Bestimmung oder term Bedingungen dieser Verkaufsbedingungen. Der Singular umfasst den Plural und das männliche Geschlecht umfasst das Weibliche und das Neutrum und umgekehrt, sofern der Kontext nichts anderes erfordert.</p>
                            </li>
                            <li>
                                <span>58.</span>
                                <p> Sollte eine Bestimmung dieser Verkaufsbedingungen von einem zuständigen Gericht für ungültig befunden werden, berührt die Ungültigkeit dieser Bestimmung nicht die Gültigkeit der übrigen Bestimmungen dieser Verkaufsbedingungen.</p>
                            </li>
                            <li>
                                <span>59.</span>
                                <p> Sie dürfen diese Verkaufsbedingungen oder Ihre Rechte und Rechtsmittel nicht abtreten, es sei denn, wir haben dies schriftlich genehmigt.</p>
                            </li>
                            <li>
                                <span>60.</span>
                                <p> Bildunterschriften und Zusammenfassungen: Die Bildunterschrift und TLTR, die die verschiedenen Abschnitte und Unterabschnitte, die in den Verkaufsbedingungen erwähnt werden, identifizieren, dienen nur als Referenz und definieren, ändern, erweitern oder beschränken keine der Bestimmungen dieser Verkaufsbedingungen und dies hat auch keinen Einfluss auf die Auslegung dieser Verkaufsbedingungen.</p>
                            </li>
                        </ul>
                        <h5>BESCHWERDE</h5>
                        <p><strong>TLTR:</strong> Bei Fragen, Beschwerden oder Reklamationen zu den Verkaufsbedingungen sind diese an uns zu richten.</p>
                        <ul>
                            <li>
                                <span>61.</span>
                                <p> Alle Fragen, Beschwerden oder Ansprüche in Bezug auf diese Verkaufsbedingungen sind zu richten an:</p>
                            </li>
                            <a href="mailto:b2b.support@reserved4you.de"><i>Email:</i> b2b.support@reserved4you.de</a>
                        </ul>
                    </div>
                </div>
                <div class="tab-pane fade show" id="pills-privancy" role="tabpanel"
                     aria-labelledby="pills-privancy-tab">
                    <div class="setting-about-us ">
                        <h5>Datenschutzerklärung</h5>
                        <p>Diese Datenschutzerklärung klärt Sie über die Art, den Umfang und Zweck der Verarbeitung von personenbezogenen Daten (nachfolgend kurz „Daten“) innerhalb unseres Onlineangebotes und der mit ihm verbundenen Webseiten, Funktionen und Inhalte sowie externen Onlinepräsenzen, wie z.B. unser Social Media Profile auf. (nachfolgend gemeinsam bezeichnet als „Onlineangebot“). Im Hinblick auf die verwendeten Begrifflichkeiten, wie z.B. „Verarbeitung“ oder „Verantwortlicher“ verweisen wir auf die Definitionen im Art. 4 der Datenschutzgrundverordnung (DSGVO).</p>
                        <h6>Verantwortlicher:</h6>
                        <p>R.F.U. reserved4you GmbH</p>
						<p>Wilmersdorfer Straße 122-123, </p>
						<p>10627 Berlin,</p>
						<p>Deutschland</p>
						<p>Register: Handelsregister</p>
						<p>Registernummer: HRB 208249B</p>
						<p>Registergericht: Berlin Charlottenburg</p>
						<p>Tel.: +49 30 364 299 61</p>
						<p>E-Mail: info@reserved4you.de</p>
						<h6>Arten der verarbeiteten Daten:</h6>
                        <p>
							Bestandsdaten (z.B., Namen, Adressen).<br />
							Kontaktdaten (z.B., E-Mail, Telefonnummern).<br />
							Inhaltsdaten (z.B., Texteingaben, Fotografien, Videos).<br />
							Vertragsdaten (z.B., Vertragsgegenstand, Laufzeit, Kundenkategorie).<br />
							Zahlungsdaten (z.B., Bankverbindung, Zahlungshistorie).<br />
							Nutzungsdaten (z.B., besuchte Webseiten, Interesse an Inhalten, Zugriffszeiten).<br />
							Meta-/Kommunikationsdaten (z.B., Geräte-Informationen, IP-Adressen).
						</p>
                        <h6>Verarbeitung besonderer Kategorien von Daten (Art. 9 Abs. 1 DSGVO):</h6>
                        <p>Es werden keine besonderen Kategorien von Daten verarbeitet.</p>
                        <h6>Kategorien der von der Verarbeitung betroffenen Personen:</h6>
                        <p>Kunden, Interessenten, Besucher und Nutzer des Onlineangebotes, Geschäftspartner.<br />
						Besucher und Nutzer des Onlineangebotes.<br />
						Nachfolgend bezeichnen wir die betroffenen Personen zusammenfassend auch als „Nutzer“.<br />
						</p>
						<h6>Zweck der Verarbeitung:</h6>
						<p>Zurverfügungstellung des Onlineangebotes, seiner Inhalte und Shop-Funktionen.<br />
						Erbringung vertraglicher Leistungen, Service und Kundenpflege.<br />
						Beantwortung von Kontaktanfragen und Kommunikation mit Nutzern.<br />
						Marketing, Werbung und Marktforschung.<br />
						Sicherheitsmaßnahmen.
						</p>
						<p>Stand: May 2020</p>

						<h6>Verwendete Begrifflichkeiten</h6>
						<p>„Personenbezogene Daten“ sind alle Informationen, die sich auf eine identifizierte oder identifizierbare natürliche Person (im Folgenden „betroffene Person“) beziehen; als identifizierbar wird eine natürliche Person angesehen, die direkt oder indirekt, insbesondere mittels Zuordnung zu einer Kennung wie einem Namen, zu einer Kennnummer, zu Standortdaten, zu einer Online-Kennung (z.B. Cookie) oder zu einem oder mehreren besonderen Merkmalen identifiziert werden kann, die Ausdruck der physischen, physiologischen, genetischen, psychischen, wirtschaftlichen, kulturellen oder sozialen Identität dieser natürlichen Person sind.</p>
						<p>Verarbeitung“ ist jeder mit oder ohne Hilfe automatisierter Verfahren ausgeführten Vorgang oder jede solche Vorgangsreihe im Zusammenhang mit personenbezogenen Daten. Der Begriff reicht weit und umfasst praktisch jeden Umgang mit Daten.</p>
						<p>Als „Verantwortlicher“ wird die natürliche oder juristische Person, Behörde, Einrichtung oder andere Stelle, die allein oder gemeinsam mit anderen über die Zwecke und Mittel der Verarbeitung von personenbezogenen Daten entscheidet, bezeichnet.</p>
						
						<h6>Maßgebliche Rechtsgrundlagen</h6>
						<p>Nach Maßgabe des Art. 13 DSGVO teilen wir Ihnen die Rechtsgrundlagen unserer Datenverarbeitungen mit. Sofern die Rechtsgrundlage in der Datenschutzerklärung nicht genannt wird, gilt Folgendes: Die Rechtsgrundlage für die Einholung von Einwilligungen ist Art. 6 Abs. 1 lit. a und Art. 7 DSGVO, die Rechtsgrundlage für die Verarbeitung zur Erfüllung unserer Leistungen und Durchführung vertraglicher Maßnahmen sowie Beantwortung von Anfragen ist Art. 6 Abs. 1 lit. b DSGVO, die Rechtsgrundlage für die Verarbeitung zur Erfüllung unserer rechtlichen Verpflichtungen ist Art. 6 Abs. 1 lit. c DSGVO, und die Rechtsgrundlage für die Verarbeitung zur Wahrung unserer berechtigten Interessen ist Art. 6 Abs. 1 lit. f DSGVO. Für den Fall, dass lebenswichtige Interessen der betroffenen Person oder einer anderen natürlichen Person eine Verarbeitung personenbezogener Daten erforderlich machen, dient Art. 6 Abs. 1 lit. d DSGVO als Rechtsgrundlage.</p>
						<h6>Sicherheitsmaßnahmen</h6>
						<p>Wir treffen nach Maßgabe des Art. 32 DSGVO unter Berücksichtigung des Stands der Technik, der Implementierungskosten und der Art, des Umfangs, der Umstände und der Zwecke der Verarbeitung sowie der unterschiedlichen Eintrittswahrscheinlichkeit und Schwere des Risikos für die Rechte und Freiheiten natürlicher Personen, geeignete technische und organisatorische Maßnahmen, um ein dem Risiko angemessenes Schutzniveau zu gewährleisten; Zu den Maßnahmen gehören insbesondere die Sicherung der Vertraulichkeit, Integrität und Verfügbarkeit von Daten durch Kontrolle des physischen Zugangs zu den Daten, als auch des sie betreffenden Zugriffs, der Eingabe, Weitergabe, der Sicherung der Verfügbarkeit und ihrer Trennung. Des Weiteren haben wir Verfahren eingerichtet, die eine Wahrnehmung von Betroffenenrechten, Löschung von Daten und Reaktion auf Gefährdung der Daten gewährleisten. Ferner berücksichtigen wir den Schutz personenbezogener Daten bereits bei der Entwicklung, bzw. Auswahl von Hardware, Software sowie Verfahren, entsprechend dem Prinzip des Datenschutzes durch Technikgestaltung und durch datenschutzfreundliche Voreinstellungen berücksichtigt (Art. 25 DSGVO).</p>
						<p>Zu den Sicherheitsmaßnahmen gehört insbesondere die verschlüsselte Übertragung von Daten zwischen Ihrem Browser und unserem Server.</p>

						<h6>Offenlegung und Übermittlung von Daten</h6>
						<p>Sofern wir im Rahmen unserer Verarbeitung Daten gegenüber anderen Personen und Unternehmen (Auftragsverarbeitern oder Dritten) offenbaren, sie an diese übermitteln oder ihnen sonst Zugriff auf die Daten gewähren, erfolgt dies nur auf Grundlage einer gesetzlichen Erlaubnis (z.B. wenn eine Übermittlung der Daten an Dritte, wie an Zahlungsdienstleister, gem. Art. 6 Abs. 1 lit. b DSGVO zur Vertragserfüllung erforderlich ist), Sie eingewilligt haben, eine rechtliche Verpflichtung dies vorsieht oder auf Grundlage unserer berechtigten Interessen (z.B. beim Einsatz von Beauftragten, Hostinganbietern, Steuer-, Wirtschafts- und Rechtsberatern, Kundenpflege-, Buchführungs-, Abrechnungs- und ähnlichen Diensten, die uns eine effiziente und effektive Erfüllung unserer Vertragspflichten, Verwaltungsaufgaben und Pflichten erlauben).</p>
						<p>Sofern wir Dritte mit der Verarbeitung von Daten auf Grundlage eines sog. „Auftragsverarbeitungsvertrages“ beauftragen, geschieht dies auf Grundlage des Art. 28 DSGVO.</p>

						<h6>Übermittlungen in Drittländer</h6>
						<p>Sofern wir Daten in einem Drittland (d.h. außerhalb der Europäischen Union (EU) oder des Europäischen Wirtschaftsraums (EWR)) verarbeiten oder dies im Rahmen der Inanspruchnahme von Diensten Dritter oder Offenlegung, bzw. Übermittlung von Daten an Dritte geschieht, erfolgt dies nur, wenn es zur Erfüllung unserer (vor)vertraglichen Pflichten, auf Grundlage Ihrer Einwilligung, aufgrund einer rechtlichen Verpflichtung oder auf Grundlage unserer berechtigten Interessen geschieht. Vorbehaltlich gesetzlicher oder vertraglicher Erlaubnisse, verarbeiten oder lassen wir die Daten in einem Drittland nur beim Vorliegen der besonderen Voraussetzungen der Art. 44 ff. DSGVO verarbeiten. D.h. die Verarbeitung erfolgt z.B. auf Grundlage besonderer Garantien, wie der offiziell anerkannten Feststellung eines der EU entsprechenden Datenschutzniveaus (z.B. für die USA durch das „Privacy Shield“) oder Beachtung offiziell anerkannter spezieller vertraglicher Verpflichtungen (so genannte „Standardvertragsklauseln“).</p>
						
						<h6>Ihre Rechte</h6>
						<p>Sie haben das Recht, eine Bestätigung darüber zu verlangen, ob betreffende Daten verarbeitet werden und auf Auskunft über diese Daten sowie auf weitere Informationen und Kopie der Daten entsprechend Art. 15 DSGVO.</p>
						<p>Sie haben entsprechend. Art. 16 DSGVO das Recht, die Vervollständigung der Sie betreffenden Daten oder die Berichtigung der Sie betreffenden unrichtigen Daten zu verlangen.</p>
						<p>Sie haben nach Maßgabe des Art. 17 DSGVO das Recht zu verlangen, dass betreffende Daten unverzüglich gelöscht werden, bzw. alternativ nach Maßgabe des Art. 18 DSGVO eine Einschränkung der Verarbeitung der Daten zu verlangen.</p>
						<p>Sie haben das Recht zu verlangen, dass die Sie betreffenden Daten, die Sie uns bereitgestellt haben nach Maßgabe des Art. 20 DSGVO zu erhalten und deren Übermittlung an andere Verantwortliche zu fordern.</p>
						<p>Sie haben ferner gem. Art. 77 DSGVO das Recht, eine Beschwerde bei der zuständigen Aufsichtsbehörde einzureichen.</p>
					
						<h6>Widerrufsrecht</h6>
						<p>Sie haben das Recht, erteilte Einwilligungen gem. Art. 7 Abs. 3 DSGVO mit Wirkung für die Zukunft zu widerrufen.</p>
						<h6>Widerspruchsrecht</h6>
						<p>Sie können der künftigen Verarbeitung der Sie betreffenden Daten nach Maßgabe des Art. 21 DSGVO jederzeit widersprechen. Der Widerspruch kann insbesondere gegen die Verarbeitung für Zwecke der Direktwerbung erfolgen.</p>

						<h6>Cookies und Widerspruchsrecht bei Direktwerbung</h6>
						<p>Als „Cookies“ werden kleine Dateien bezeichnet, die auf Rechnern der Nutzer gespeichert werden. Innerhalb der Cookies können unterschiedliche Angaben gespeichert werden. Ein Cookie dient primär dazu, die Angaben zu einem Nutzer (bzw. dem Gerät auf dem das Cookie gespeichert ist) während oder auch nach seinem Besuch innerhalb eines Onlineangebotes zu speichern. Als temporäre Cookies, bzw. „Session-Cookies“ oder „transiente Cookies“, werden Cookies bezeichnet, die gelöscht werden, nachdem ein Nutzer ein Onlineangebot verlässt und seinen Browser schließt. In einem solchen Cookie kann z.B. der Inhalt eines Warenkorbs in einem Onlineshop oder ein Login-Status gespeichert werden. Als „permanent“ oder „persistent“ werden Cookies bezeichnet, die auch nach dem Schließen des Browsers gespeichert bleiben. So kann z.B. der Login-Status gespeichert werden, wenn die Nutzer diese nach mehreren Tagen aufsuchen. Ebenso können in einem solchen Cookie die Interessen der Nutzer gespeichert werden, die für Reichweitenmessung oder Marketingzwecke verwendet werden. Als „Third-Party-Cookie“ werden Cookies von anderen Anbietern als dem Verantwortlichen, der das Onlineangebot betreibt, bezeichnet (andernfalls, wenn es nur dessen Cookies sind spricht man von „First-Party Cookies“).</p>
						<p>Wir setzen temporäre und permanente Cookies ein und klären hierüber im Rahmen unserer Datenschutzerklärung auf.</p>
						<p>Falls die Nutzer nicht möchten, dass Cookies auf ihrem Rechner gespeichert werden, werden sie gebeten die entsprechende Option in den Systemeinstellungen ihres Browsers zu deaktivieren. Gespeicherte Cookies können in den Systemeinstellungen des Browsers gelöscht werden. Der Ausschluss von Cookies kann zu Funktionseinschränkungen dieses Onlineangebotes führen.</p>
						<p>Ein genereller Widerspruch gegen den Einsatz der zu Zwecken des Onlinemarketing eingesetzten Cookies kann bei einer Vielzahl der Dienste, vor allem im Fall des Trackings, über die US-amerikanische Seite <a class="text-warning" href="http://www.aboutads.info/choices/">http://www.aboutads.info/choices/</a> oder die EU-Seite <a class="text-warning" href="http://www.youronlinechoices.com/">http://www.youronlinechoices.com/</a> erklärt werden. Des Weiteren kann die Speicherung von Cookies mittels deren Abschaltung in den Einstellungen des Browsers erreicht werden. Bitte beachten Sie, dass dann gegebenenfalls nicht alle Funktionen dieses Onlineangebotes genutzt werden können.</p>

						<h6>Löschung von Daten</h6>
						<p>Die von uns verarbeiteten Daten werden nach Maßgabe der Art. 17 und 18 DSGVO gelöscht oder in ihrer Verarbeitung eingeschränkt. Sofern nicht im Rahmen dieser Datenschutzerklärung ausdrücklich angegeben, werden die bei uns gespeicherten Daten gelöscht, sobald sie für ihre Zweckbestimmung nicht mehr erforderlich sind und der Löschung keine gesetzlichen Aufbewahrungspflichten entgegenstehen. Sofern die Daten nicht gelöscht werden, weil sie für andere und gesetzlich zulässige Zwecke erforderlich sind, wird deren Verarbeitung eingeschränkt. D.h. die Daten werden gesperrt und nicht für andere Zwecke verarbeitet. Das gilt z.B. für Daten, die aus handels- oder steuerrechtlichen Gründen aufbewahrt werden müssen.</p>
						<p>Deutschland: Nach gesetzlichen Vorgaben erfolgt die Aufbewahrung insbesondere für 6 Jahre gemäß § 257 Abs. 1 HGB (Handelsbücher, Inventare, Eröffnungsbilanzen, Jahresabschlüsse, Handelsbriefe, Buchungsbelege, etc.) sowie für 10 Jahre gemäß § 147 Abs. 1 AO (Bücher, Aufzeichnungen, Lageberichte, Buchungsbelege, Handels- und Geschäftsbriefe, für Besteuerung relevante Unterlagen, etc</p>

						<h6>Dienstleistungsvermittlung, Kundenkonto, Geschäftskonto</h6>
						<p>Wir verarbeiten die Daten unserer Kunden im Rahmen der Vorgänge in unsererReservierungs- und Lieferplattform, um ihnen die Auswahl und die Bestellung der gewählten Leistungen, sowie deren Bezahlung und Ausführung zu ermöglichen.</p>
						<p>Zu den verarbeiteten Daten gehören Bestandsdaten, Kommunikationsdaten, Vertragsdaten, Zahlungsdaten und zu den betroffenen Personen unsere Kunden, Interessenten und sonstige Geschäftspartner. Die Verarbeitung erfolgt zum Zweck der Erbringung von Vertragsleistungen im Rahmen des Betriebs unsererReservierungs- und Lieferplattform, Abrechnung, Auslieferung und der Kundenservices. Hierbei setzen wir Session Cookies für die Speicherung des Warenkorb-Inhalts und permanente Cookies für die Speicherung des Login-Status ein.</p>
						<p>Die Verarbeitung erfolgt auf Grundlage des Art. 6 Abs. 1 lit. b (Durchführung Bestellvorgänge) und c (Gesetzlich erforderliche Archivierung) DSGVO. Dabei sind die als erforderlich gekennzeichneten Angaben zur Begründung und Erfüllung des Vertrages erforderlich. Die Daten offenbaren wir gegenüber Dritten nur im Rahmen der Auslieferung, Zahlung oder im Rahmen der gesetzlichen Erlaubnisse und Pflichten gegenüber Rechtsberatern und Behörden. Die Daten werden in Drittländern nur dann verarbeitet, wenn dies zur Vertragserfüllung erforderlich ist.</p>
						<p>Nutzer können ein Nutzerkonto anlegen, indem sie insbesondere ihre Bestellungen einsehen können. Im Rahmen der Registrierung, werden die erforderlichen Pflichtangaben den Nutzern mitgeteilt. Die Nutzerkonten sind nicht öffentlich und können von Suchmaschinen nicht indexiert werden. Wenn Nutzer ihr Nutzerkonto gekündigt haben, werden deren Daten im Hinblick auf das Nutzerkonto gelöscht, vorbehaltlich deren Aufbewahrung ist aus handels- oder steuerrechtlichen Gründen entspr. Art. 6 Abs. 1 lit. c DSGVO notwendig. Angaben im Kundenkonto verbleiben bis zu dessen Löschung mit anschließender Archivierung im Fall einer rechtlichen Verpflichtung. Es obliegt den Nutzern, ihre Daten bei erfolgter Kündigung vor dem Vertragsende zu sichern.</p>
						<p>Im Rahmen der Registrierung und erneuter Anmeldungen sowie Inanspruchnahme unserer Onlinedienste, speichern wir die IP-Adresse und den Zeitpunkt der jeweiligen Nutzerhandlung. Die Speicherung erfolgt auf Grundlage unserer berechtigten Interessen, als auch der Nutzer an Schutz vor Missbrauch und sonstiger unbefugter Nutzung. Eine Weitergabe dieser Daten an Dritte erfolgt grundsätzlich nicht, außer sie ist zur Verfolgung unserer Ansprüche erforderlich oder es besteht hierzu eine gesetzliche Verpflichtung gem. Art. 6 Abs. 1 lit. c DSGVO.</p>
						<p>Die Löschung erfolgt nach Ablauf gesetzlicher Gewährleistungs- und vergleichbarer Pflichten, die Erforderlichkeit der Aufbewahrung der Daten wird alle drei Jahre überprüft; im Fall der gesetzlichen Archivierungspflichten erfolgt die Löschung nach deren Ablauf (Ende handelsrechtlicher (6 Jahre) und steuerrechtlicher (10 Jahre) Aufbewahrungspflicht); Angaben im Kundenkonto verbleiben bis zu dessen Löschung.</p>

						<h6>Betriebswirtschaftliche Analysen und Marktforschung</h6>
						<p>Um unser Geschäft wirtschaftlich betreiben, Markttendenzen, Kunden- und Nutzerwünsche erkennen zu können, analysieren wir die uns vorliegenden Daten zu Geschäftsvorgängen, Verträgen, Anfragen, etc. Wir verarbeiten dabei Bestandsdaten, Kommunikationsdaten, Vertragsdaten, Zahlungsdaten, Nutzungsdaten, Metadaten auf Grundlage des Art. 6 Abs. 1 lit. f. DSGVO, wobei zu den betroffenen Personen Kunden, Interessenten, Geschäftspartner, Besucher und Nutzer des Onlineangebotes gehören. Die Analysen erfolgen zum Zweck Betriebswirtschaftliche Auswertungen, des Marketings und der Marktforschung. Dabei können wir die Profile der registrierten Nutzer mit Angaben z.B. zu deren Dienstleistungsvermittlung berücksichtigen. Die Analysen dienen uns zur Steigerung der Nutzerfreundlichkeit, der Optimierung unseres Angebotes und der Betriebswirtschaftlichkeit. Die Analysen dienen alleine uns und werden nicht extern offenbart, sofern es sich nicht um anonyme Analysen mit zusammengefassten Werten handelt.</p>
						<p>Sofern diese Analysen oder Profile personenbezogen sind, werden sie mit Kündigung der Nutzer gelöscht oder anonymisiert, sonst nach zwei Jahren ab Vertragsschluss. Im Übrigen werden die gesamtbetriebswirtschaftlichen Analysen und allgemeine Tendenzbestimmungen nach Möglichkeit anonym erstellt.</p>

						<h6>Kontaktaufnahme und Kundenservice</h6>
						<p>Bei der Kontaktaufnahme mit uns (per Kontaktformular oder E-Mail) werden die Angaben des Nutzers zur Bearbeitung der Kontaktanfrage und deren Abwicklung gem. Art. 6 Abs. 1 lit. b) DSGVO verarbeitet.</p>
						<p>Die Angaben der Nutzer können in unserem Customer-Relationship-Management System („CRM System“) oder vergleichbarer Anfragenorganisation gespeichert werden.</p>
						<p>Wir löschen die Anfragen, sofern diese nicht mehr erforderlich sind. Wir überprüfen die Erforderlichkeit alle zwei Jahre; Anfragen von Kunden, die über ein Kundenkonto verfügen, speichern wir dauerhaft und verweisen zur Löschung auf die Angaben zum Kundenkonto. Ferner gelten die gesetzlichen Archivierungspflichten.</p>

						<h6>Erhebung von Zugriffsdaten und Logfiles</h6>
						<p>Wir erheben auf Grundlage unserer berechtigten Interessen im Sinne des Art. 6 Abs. 1 lit. f. DSGVO Daten über jeden Zugriff auf den Server, auf dem sich dieser Dienst befindet (sogenannte Serverlogfiles). Zu den Zugriffsdaten gehören Name der abgerufenen Webseite, Datei, Datum und Uhrzeit des Abrufs, übertragene Datenmenge, Meldung über erfolgreichen Abruf, Browsertyp nebst Version, das Betriebssystem des Nutzers, Referrer URL (die zuvor besuchte Seite), IP-Adresse und der anfragende Provider.</p>
						<p>Logfile-Informationen werden aus Sicherheitsgründen (z.B. zur Aufklärung von Missbrauchs- oder Betrugshandlungen) für die Dauer von maximal sieben Tagen gespeichert und danach gelöscht. Daten, deren weitere Aufbewahrung zu Beweiszwecken erforderlich ist, sind bis zur endgültigen Klärung des jeweiligen Vorfalls von der Löschung ausgenommen.</p>

						<h6>Onlinepräsenzen in sozialen Medien</h6>
						<p>Wir unterhalten auf Grundlage unserer berechtigten Interessen im Sinne des Art. 6 Abs. 1 lit. f. DSGVO Onlinepräsenzen innerhalb sozialer Netzwerke und Plattformen, um mit den dort aktiven Kunden, Interessenten und Nutzern kommunizieren und sie dort über unsere Leistungen informieren zu können. Beim Aufruf der jeweiligen Netzwerke und Plattformen gelten die Geschäftsbedingungen und die Datenverarbeitungsrichtlinien deren jeweiligen Betreiber.</p>
						<p>Soweit nicht anders im Rahmen unserer Datenschutzerklärung angegeben, verarbeiten wir die Daten der Nutzer sofern diese mit uns innerhalb der sozialen Netzwerke und Plattformen kommunizieren, z.B. Beiträge auf unseren Onlinepräsenzen verfassen oder uns Nachrichten zusenden.</p>

						<h6>Google Analytics</h6>
						<p>Wir setzen auf Grundlage unserer berechtigten Interessen (d.h. Interesse an der Analyse, Optimierung und wirtschaftlichem Betrieb unseres Onlineangebotes im Sinne des Art. 6 Abs. 1 lit. f. DSGVO) Google Analytics, einen Webanalysedienst der Google LLC („Google“) ein. Google verwendet Cookies. Die durch das Cookie erzeugten Informationen über Benutzung des Onlineangebotes durch die Nutzer werden in der Regel an einen Server von Google in den USA übertragen und dort gespeichert.</p>
						<p>Google ist unter dem Privacy-Shield-Abkommen zertifiziert und bietet hierdurch eine Garantie, das europäische Datenschutzrecht einzuhalten (<a class="text-warning" href="https://www.privacyshield.gov/participant?id=a2zt000000001L5AAI&status=Active">https://www.privacyshield.gov/participant?id=a2zt000000001L5AAI&status=Active</a>).</p>
						<p>Google wird diese Informationen in unserem Auftrag benutzen, um die Nutzung unseres Onlineangebotes durch die Nutzer auszuwerten, um Reports über die Aktivitäten innerhalb dieses Onlineangebotes zusammenzustellen und um weitere, mit der Nutzung dieses Onlineangebotes und der Internetnutzung verbundene Dienstleistungen, uns gegenüber zu erbringen. Dabei können aus den verarbeiteten Daten pseudonyme Nutzungsprofile der Nutzer erstellt werden.</p>
						<p>Wir setzen Google Analytics nur mit aktivierter IP-Anonymisierung ein. Das bedeutet, die IP-Adresse der Nutzer wird von Google innerhalb von Mitgliedstaaten der Europäischen Union oder in anderen Vertragsstaaten des Abkommens über den Europäischen Wirtschaftsraum gekürzt. Nur in Ausnahmefällen wird die volle IP-Adresse an einen Server von Google in den USA übertragen und dort gekürzt.</p>
						<p>Die von dem Browser des Nutzers übermittelte IP-Adresse wird nicht mit anderen Daten von Google zusammengeführt. Die Nutzer können die Speicherung der Cookies durch eine entsprechende Einstellung ihrer Browser-Software verhindern; die Nutzer können darüber hinaus die Erfassung der durch das Cookie erzeugten und auf ihre Nutzung des Onlineangebotes bezogenen Daten an Google sowie die Verarbeitung dieser Daten durch Google verhindern, indem sie das unter folgendem Link verfügbare Browser-Plugin herunterladen und installieren: <a class="text-warning" href="https://tools.google.com/dlpage/gaoptout?hl=de">https://tools.google.com/dlpage/gaoptout?hl=de</a>.</p>
						<p>Weitere Informationen zur Datennutzung durch Google, Einstellungs- und Widerspruchsmöglichkeiten erfahren Sie auf den Webseiten von Google: <a href="https://www.google.com/intl/de/policies/privacy/partners" class="text-warning" >https://www.google.com/intl/de/policies/privacy/partners</a> („Datennutzung durch Google bei Ihrer Nutzung von Websites oder Apps unserer Partner“), <a href="https://policies.google.com/technologies/ads" class="text-warning" >https://policies.google.com/technologies/ads</a> („Datennutzung zu Werbezwecken“), <a class="text-warning" href="https://adssettings.google.com/authenticated">https://adssettings.google.com/authenticated</a> („Informationen verwalten, die Google verwendet, um Ihnen Werbung einzublenden“).</p>

						<h6>Google-Re/Marketing-Services</h6>
						<p>Wir nutzen auf Grundlage unserer berechtigten Interessen (d.h. Interesse an der Analyse, Optimierung und wirtschaftlichem Betrieb unseres Onlineangebotes im Sinne des Art. 6 Abs. 1 lit. f. DSGVO) die Marketing- und Remarketing-Dienste (kurz „Google-Marketing-Services”) der Google LLC, 1600 Amphitheatre Parkway, Mountain View, CA 94043, USA, („Google“).</p>
						<p>Google ist unter dem Privacy-Shield-Abkommen zertifiziert und bietet hierdurch eine Garantie, das europäische Datenschutzrecht einzuhalten (<a href="https://www.privacyshield.gov/participant?id=a2zt000000001L5AAI&status=Active" class="text-warning">https://www.privacyshield.gov/participant?id=a2zt000000001L5AAI&status=Active</a>).</p>
						<p>Die Google-Marketing-Services erlauben uns Werbeanzeigen für und auf unserer Website gezielter anzuzeigen, um Nutzern nur Anzeigen zu präsentieren, die potentiell deren Interessen entsprechen. Falls einem Nutzer z.B. Anzeigen für Produkte angezeigt werden, für die er sich auf anderen Webseiten interessiert hat, spricht man hierbei vom „Remarketing“. Zu diesen Zwecken wird bei Aufruf unserer und anderer Webseiten, auf denen Google-Marketing-Services aktiv sind, unmittelbar durch Google ein Code von Google ausgeführt und es werden sog. (Re)marketing-Tags (unsichtbare Grafiken oder Code, auch als „Web Beacons“ bezeichnet) in die Webseite eingebunden. Mit deren Hilfe wird auf dem Gerät der Nutzer ein individuelles Cookie, d.h. eine kleine Datei abgespeichert (statt Cookies können auch vergleichbare Technologien verwendet werden). Die Cookies können von verschiedenen Domains gesetzt werden, unter anderem von google.com, doubleclick.net, invitemedia.com, admeld.com, googlesyndication.com oder googleadservices.com. In dieser Datei wird vermerkt, welche Webseiten der Nutzer aufgesucht, für welche Inhalte er sich interessiert und welche Angebote er geklickt hat, ferner technische Informationen zum Browser und Betriebssystem, verweisende Webseiten, Besuchszeit sowie weitere Angaben zur Nutzung des Onlineangebotes. Es wird ebenfalls die IP-Adresse der Nutzer erfasst, wobei wir im Rahmen von Google-Analytics mitteilen, dass die IP-Adresse innerhalb von Mitgliedstaaten der Europäischen Union oder in anderen Vertragsstaaten des Abkommens über den Europäischen Wirtschaftsraum gekürzt und nur in Ausnahmefällen ganz an einen Server von Google in den USA übertragen und dort gekürzt wird. Die IP-Adresse wird nicht mit Daten des Nutzers innerhalb von anderen Angeboten von Google zusammengeführt. Die vorstehend genannten Informationen können seitens Google auch mit solchen Informationen aus anderen Quellen verbunden werden. Wenn der Nutzer anschließend andere Webseiten besucht, können ihm entsprechend seiner Interessen die auf ihn abgestimmten Anzeigen angezeigt werden.</p>
						<p>Die Daten der Nutzer werden im Rahmen der Google-Marketing-Services pseudonym verarbeitet. D.h. Google speichert und verarbeitet z.B. nicht den Namen oder E-Mailadresse der Nutzer, sondern verarbeitet die relevanten Daten Cookie-bezogen innerhalb pseudonymer Nutzer-Profile. D.h. aus der Sicht von Google werden die Anzeigen nicht für eine konkret identifizierte Person verwaltet und angezeigt, sondern für den Cookie-Inhaber, unabhängig davon wer dieser Cookie-Inhaber ist. Dies gilt nicht, wenn ein Nutzer Google ausdrücklich erlaubt hat, die Daten ohne diese Pseudonymisierung zu verarbeiten. Die von Google-Marketing-Services über die Nutzer gesammelten Informationen werden an Google übermittelt und auf Googles Servern in den USA gespeichert.</p>
						<p>Zu den von uns eingesetzten Google-Marketing-Services gehört u.a. das Online-Werbeprogramm „Google AdWords“. Im Fall von Google AdWords, erhält jeder AdWords-Kunde ein anderes „Conversion-Cookie“. Cookies können somit nicht über die Websites von AdWords-Kunden nachverfolgt werden. Die mit Hilfe des Cookies eingeholten Informationen dienen dazu, Conversion-Statistiken für AdWords-Kunden zu erstellen, die sich für Conversion-Tracking entschieden haben. Die AdWords-Kunden erfahren die Gesamtanzahl der Nutzer, die auf ihre Anzeige geklickt haben und zu einer mit einem Conversion-Tracking-Tag versehenen Seite weitergeleitet wurden. Sie erhalten jedoch keine Informationen, mit denen sich Nutzer persönlich identifizieren lassen.</p>
						<p>19.6. Wir können auf Grundlage des Google-Marketing-Services „DoubleClick“ Werbeanzeigen Dritter einbinden. DoubleClick verwendet Cookies, mit denen Google und seinen Partner-Websites, die Schaltung von Anzeigen auf Basis der Besuche von Nutzern auf dieser Website bzw. anderen Websites im Internet ermöglicht wird.</p>
						<p>19.7. Wir können auf Grundlage des Google-Marketing-Services „AdSense“ Werbeanzeigen Dritter einbinden. AdSense verwendet Cookies, mit denen Google und seinen Partner-Websites, die Schaltung von Anzeigen auf Basis der Besuche von Nutzern auf dieser Website bzw. anderen Websites im Internet ermöglicht wird.</p>
						<p>19.8. Ebenfalls können wir den Dienst „Google Optimizer“ einsetzen. Google Optimizer erlaubt uns im Rahmen so genannten „A/B-Testings“ nachzuvollziehen, wie sich verschiedene Änderungen einer Website auswirken (z.B. Veränderungen der Eingabefelder, des Designs, etc.). Für diese Testzwecke werden Cookies auf den Geräten der Nutzer abgelegt. Dabei werden nur pseudonyme Daten der Nutzer verarbeitet.</p>
						<p>19.9. Ferner können wir den „Google Tag Manager“ einsetzen, um die Google Analyse- und Marketing-Dienste in unsere Website einzubinden und zu verwalten.</p>
						<p>19.10. Weitere Informationen zur Datennutzung zu Marketingzwecken durch Google, erfahren Sie auf der Übersichtsseite: <a href="https://policies.google.com/technologies/ads" class="text-warning">https://policies.google.com/technologies/ads</a>, die Datenschutzerklärung von Google ist unter <a href="https://adssettings.google.com/authenticated" class="text-warning">https://adssettings.google.com/authenticated.</a></p>
						<p>Des Weiteren nutzen wir beim Einsatz des Facebook-Pixels die Zusatzfunktion „erweiterter Abgleich“ (hierbei werden Daten wie Telefonnummern, E-Mailadressen oder Facebook-IDs der Nutzer) zur Bildung von Zielgruppen („Custom Audiences“ oder „Look Alike Audiences“) an Facebook (verschlüsselt) übermittelt. Weitere Hinweise zum „erweiterten Abgleich“: <a href="https://www.facebook.com/business/help/611774685654668" class="text-warning">https://www.facebook.com/business/help/611774685654668</a>).</p>
						<p>Wir nutzen ebenfalls das Verfahren „Custom Audiences from File“ des sozialen Netzwerks Facebook, Inc. In diesem Fall werden die E-Mail-Adressen der Newsletterempfänger bei Facebook hochgeladen. Der Upload-Vorgang findet verschlüsselt statt. Der Upload dient alleine, um Empfänger unserer Facebook-Anzeigen zu bestimmen. Wir möchten damit sicherstellen, dass die Anzeigen nur Nutzern angezeigt werden, die ein Interesse an unseren Informationen und Leistungen haben.</p>
						<p>Hinweis zum Opt-Out: Beachten Sie bitte, dass Facebook im Zeitpunkt der Erstellung dieses Musters kein Opt-Out anbietet und Sie es selbst implementieren müssen. Falls Sie es nicht tun, müssen Sie diesen Passus entfernen. Die Umsetzung kann z.B. mittels Javascript (Setzen des Opt-Out-Links) und beim Laden der Seite via PHP (das prüft, ob das Opt-Out-Cookies gesetzt wurde und nur beim negativen Ergebnis das Facebook-Pixel lädt) erfolgen. Besucht ein Nutzer die Website, muss geprüft werden, ob das “Opt-Out“-Cookie gesetzt ist. Falls ja, darf das „Facebook-Pixel“ nicht geladen werden.</p>
						<p>Um die Erfassung Ihrer Daten mittels des Facebook-Pixels auf unserer Webseite zu verhindern, klicken Sie bitten den folgenden Link: Facebook-Opt-Out Hinweis: Wenn Sie den Link klicken, wird ein „Opt-Out“-Cookie auf Ihrem Gerät gespeichert. Wenn Sie die Cookies in diesem Browser löschen, dann müssen Sie den Link erneut klicken. Ferner gilt das Opt-Out nur innerhalb des von Ihnen verwendeten Browsers und nur innerhalb unserer Webdomain, auf der der Link geklickt wurde.</p>

						<h6>Facebook-, Custom Audiences und Facebook-Marketing-Dienste</h6>
						<p>Innerhalb unseres Onlineangebotes wird aufgrund unserer berechtigten Interessen an Analyse, Optimierung und wirtschaftlichem Betrieb unseres Onlineangebotes und zu diesen Zwecken das sog. „Facebook-Pixel“ des sozialen Netzwerkes Facebook, welches von der Facebook Inc., 1 Hacker Way, Menlo Park, CA 94025, USA, bzw. falls Sie in der EU ansässig sind, Facebook Ireland Ltd., 4 Grand Canal Square, Grand Canal Harbour, Dublin 2, Irland betrieben wird („Facebook“), eingesetzt.</p>
						<p>Facebook ist unter dem Privacy-Shield-Abkommen zertifiziert und bietet hierdurch eine Garantie, das europäische Datenschutzrecht einzuhalten (https://www.privacyshield.gov/participant?id=a2zt0000000GnywAAC&status=Active).</p>
						<p>Mit Hilfe des Facebook-Pixels ist es Facebook zum einen möglich, die Besucher unseres Onlineangebotes als Zielgruppe für die Darstellung von Anzeigen (sog. „Facebook-Ads“) zu bestimmen. Dementsprechend setzen wir das Facebook-Pixel ein, um die durch uns geschalteten Facebook-Ads nur solchen Facebook-Nutzern anzuzeigen, die auch ein Interesse an unserem Onlineangebot gezeigt haben oder die bestimmte Merkmale (z.B. Interessen an bestimmten Themen oder Produkten, die anhand der besuchten Webseiten bestimmt werden) aufweisen, die wir an Facebook übermitteln (sog. „Custom Audiences“). Mit Hilfe des Facebook-Pixels möchten wir auch sicherstellen, dass unsere Facebook-Ads dem potentiellen Interesse der Nutzer entsprechen und nicht belästigend wirken. Mit Hilfe des Facebook-Pixels können wir ferner die Wirksamkeit der Facebook-Werbeanzeigen für statistische und Marktforschungszwecke nachvollziehen, in dem wir sehen ob Nutzer nachdem Klick auf eine Facebook-Werbeanzeige auf unsere Website weitergeleitet wurden (sog. „Conversion“).</p>
						<p>Die Verarbeitung der Daten durch Facebook erfolgt im Rahmen von Facebooks Datenverwendungsrichtlinie. Dementsprechend generelle Hinweise zur Darstellung von Facebook-Ads, in der Datenverwendungsrichtlinie von Facebook: https://www.facebook.com/policy.php. Spezielle Informationen und Details zum Facebook-Pixel und seiner Funktionsweise erhalten Sie im Hilfebereich von Facebook: https://www.facebook.com/business/help/651294705016616.</p>
						<p>Sie können der Erfassung durch den Facebook-Pixel und Verwendung Ihrer Daten zur Darstellung von Facebook-Ads widersprechen. Um einzustellen, welche Arten von Werbeanzeigen Ihnen innerhalb von Facebook angezeigt werden, können Sie die von Facebook eingerichtete Seite aufrufen und dort die Hinweise zu den Einstellungen nutzungsbasierter Werbung befolgen: https://www.facebook.com/settings?tab=ads. Die Einstellungen erfolgen plattformunabhängig, d.h. sie werden für alle Geräte, wie Desktopcomputer oder mobile Geräte übernommen.</p>
						<p>Sie können dem Einsatz von Cookies, die der Reichweitenmessung und Werbezwecken dienen, ferner über die Deaktivierungsseite der Netzwerkwerbeinitiative (http://optout.networkadvertising.org/) und zusätzlich die US-amerikanische Webseite (http://www.aboutads.info/choices) oder die europäische Webseite (http://www.youronlinechoices.com/uk/your-ad-choices/) widersprechen.</p>

						<h6>Facebook Social Plugins</h6>
						<p>Wir nutzen auf Grundlage unserer berechtigten Interessen (d.h. Interesse an der Analyse, Optimierung und wirtschaftlichem Betrieb unseres Onlineangebotes im Sinne des Art. 6 Abs. 1 lit. f. DSGVO) Social Plugins („Plugins“) des sozialen Netzwerkes facebook.com, welches von der Facebook Ireland Ltd., 4 Grand Canal Square, Grand Canal Harbour, Dublin 2, Irland betrieben wird („Facebook“). Die Plugins können Interaktionselemente oder Inhalte (z.B. Videos, Grafiken oder Textbeiträge) darstellen und sind an einem der Facebook Logos erkennbar (weißes „f“ auf blauer Kachel, den Begriffen „Like“, „Gefällt mir“ oder einem „Daumen hoch“-Zeichen) oder sind mit dem Zusatz „Facebook Social Plugin“ gekennzeichnet. Die Liste und das Aussehen der Facebook Social Plugins kann hier eingesehen werden: https://developers.facebook.com/docs/plugins/.</p>
						<p>Facebook ist unter dem Privacy-Shield-Abkommen zertifiziert und bietet hierdurch eine Garantie, das europäische Datenschutzrecht einzuhalten (https://www.privacyshield.gov/participant?id=a2zt0000000GnywAAC&status=Active).</p>
						<p>Wenn ein Nutzer eine Funktion dieses Onlineangebotes aufruft, die ein solches Plugin enthält, baut sein Gerät eine direkte Verbindung mit den Servern von Facebook auf. Der Inhalt des Plugins wird von Facebook direkt an das Gerät des Nutzers übermittelt und von diesem in das Onlineangebot eingebunden. Dabei können aus den verarbeiteten Daten Nutzungsprofile der Nutzer erstellt werden. Wir haben daher keinen Einfluss auf den Umfang der Daten, die Facebook mit Hilfe dieses Plugins erhebt und informiert die Nutzer daher entsprechend unserem Kenntnisstand.</p>
						<p>Durch die Einbindung der Plugins erhält Facebook die Information, dass ein Nutzer die entsprechende Seite des Onlineangebotes aufgerufen hat. Ist der Nutzer bei Facebook eingeloggt, kann Facebook den Besuch seinem Facebook-Konto zuordnen. Wenn Nutzer mit den Plugins interagieren, zum Beispiel den Like Button betätigen oder einen Kommentar abgeben, wird die entsprechende Information von Ihrem Gerät direkt an Facebook übermittelt und dort gespeichert. Falls ein Nutzer kein Mitglied von Facebook ist, besteht trotzdem die Möglichkeit, dass Facebook seine IP-Adresse in Erfahrung bringt und speichert. Laut Facebook wird in Deutschland nur eine anonymisierte IP-Adresse gespeichert.</p>
						<p>Zweck und Umfang der Datenerhebung und die weitere Verarbeitung und Nutzung der Daten durch Facebook sowie die diesbezüglichen Rechte und Einstellungsmöglichkeiten zum Schutz der Privatsphäre der Nutzer, können diese den Datenschutzhinweisen von Facebook entnehmen: https://www.facebook.com/about/privacy/.</p>
						<p>Wenn ein Nutzer Facebookmitglied ist und nicht möchte, dass Facebook über dieses Onlineangebot Daten über ihn sammelt und mit seinen bei Facebook gespeicherten Mitgliedsdaten verknüpft, muss er sich vor der Nutzung unseres Onlineangebotes bei Facebook ausloggen und seine Cookies löschen. Weitere Einstellungen und Widersprüche zur Nutzung von Daten für Werbezwecke, sind innerhalb der Facebook-Profileinstellungen möglich: https://www.facebook.com/settings?tab=ads  oder über die US-amerikanische Seite http://www.aboutads.info/choices/  oder die EU-Seite http://www.youronlinechoices.com/. Die Einstellungen erfolgen plattformunabhängig, d.h. sie werden für alle Geräte, wie Desktopcomputer oder mobile Geräte übernommen.</p>

						<h6>Kommunikation via Post, E-Mail, Fax oder Telefon</h6>
						<p>Wir nutzen für die Geschäftsabwicklung und für Marketingzwecke Fernkommunikationsmittel, wie z.B. Post, Telefon oder E-Mail. Dabei verarbeiten wir Bestandsdaten, Adress- und Kontaktdaten sowie Vertragsdaten von Kunden, Teilnehmern, Interessenten und Kommunikationspartner.</p>
						<p>Die Verarbeitung erfolgt auf Grundlage des Art. 6 Abs. 1 lit. a, Art. 7 DSGVO, Art. 6 Abs. 1 lit. f DSGVO in Verbindung mit gesetzlichen Vorgaben für werbliche Kommunikationen. Die Kontaktaufnahme erfolgt nur mit Einwilligung der Kontaktpartner oder im Rahmen der gesetzlichen Erlaubnisse und die verarbeiteten Daten werden gelöscht, sobald sie nicht erforderlich sind und ansonsten mit Widerspruch/ Widerruf oder Wegfall der Berechtigungsgrundlagen oder gesetzlicher Archivierungspflichten.</p>

						<h6>Newsletter</h6>
						<p>Mit den nachfolgenden Hinweisen informieren wir Sie über die Inhalte unseres Newsletters sowie das Anmelde-, Versand- und das statistische Auswertungsverfahren sowie Ihre Widerspruchsrechte auf. Indem Sie unseren Newsletter abonnieren, erklären Sie sich mit dem Empfang und den beschriebenen Verfahren einverstanden.</p>
						<p>Inhalt des Newsletters: Wir versenden Newsletter, E-Mails und weitere elektronische Benachrichtigungen mit werblichen Informationen (nachfolgend „Newsletter“) nur mit der Einwilligung der Empfänger oder einer gesetzlichen Erlaubnis. Sofern im Rahmen einer Anmeldung zum Newsletter dessen Inhalte konkret umschrieben werden, sind sie für die Einwilligung der Nutzer maßgeblich. Im Übrigen enthalten unsere Newsletter Informationen zu unseren Produkten, Angeboten, Aktionen und unserem Unternehmen.</p>
						<p>Double-Opt-In und Protokollierung: Die Anmeldung zu unserem Newsletter erfolgt in einem sog. Double-Opt-In-Verfahren. D.h. Sie erhalten nach der Anmeldung eine E-Mail, in der Sie um die Bestätigung Ihrer Anmeldung gebeten werden. Diese Bestätigung ist notwendig, damit sich niemand mit fremden E-Mailadressen anmelden kann. Die Anmeldungen zum Newsletter werden protokolliert, um den Anmeldeprozess entsprechend den rechtlichen Anforderungen nachweisen zu können. Hierzu gehört die Speicherung des Anmelde- und des Bestätigungszeitpunkts, als auch der IP-Adresse. Ebenso werden die Änderungen Ihrer bei dem Versanddienstleister gespeicherten Daten protokolliert.</p>
						<p>Versanddienstleister: Der Versand der Newsletter erfolgt mittels „MailChimp“, einer Newsletterversandplattform des US-Anbieters Rocket Science Group, LLC, 675 Ponce De Leon Ave NE #5000, Atlanta, GA 30308, USA. Die Datenschutzbestimmungen des Versanddienstleisters können Sie hier einsehen: https://mailchimp.com/legal/privacy/. The Rocket Science Group LLC d/b/a MailChimp ist unter dem Privacy-Shield-Abkommen zertifiziert und bietet hierdurch eine Garantie, das europäisches Datenschutzniveau einzuhalten (https://www.privacyshield.gov/participant?id=a2zt0000000TO6hAAG&status=Active).</p>
						<p>Soweit wir einen Versanddienstleister einsetzen, kann der Versanddienstleister nach eigenen Informationen diese Daten in pseudonymer Form, d.h. ohne Zuordnung zu einem Nutzer, zur Optimierung oder Verbesserung der eigenen Services nutzen, z.B. zur technischen Optimierung des Versandes und der Darstellung der Newsletter oder für statistische Zwecke, um zu bestimmen aus welchen Ländern die Empfänger kommen, verwenden. Der Versanddienstleister nutzt die Daten unserer Newsletterempfänger jedoch nicht, um diese selbst anzuschreiben oder an Dritte weiterzugeben.</p>
						<p>Anmeldedaten: Um sich für den Newsletter anzumelden, reicht es aus, wenn Sie Ihre E-Mailadresse angeben. Optional bitten wir Sie einen Namen, zwecks persönlicher Ansprache im Newsletters anzugeben.</p>
						<p>Erfolgsmessung – Die Newsletter enthalten einen sog. „web-beacon“, d.h. eine pixelgroße Datei, die beim Öffnen des Newsletters von unserem Server, bzw. sofern wir einen Versanddienstleister einsetzen, von dessen Server abgerufen wird. Im Rahmen dieses Abrufs werden zunächst technische Informationen, wie Informationen zum Browser und Ihrem System, als auch Ihre IP-Adresse und Zeitpunkt des Abrufs erhoben. Diese Informationen werden zur technischen Verbesserung der Services anhand der technischen Daten oder der Zielgruppen und ihres Leseverhaltens anhand derer Abruforte (die mit Hilfe der IP-Adresse bestimmbar sind) oder der Zugriffszeiten genutzt. Zu den statistischen Erhebungen gehört ebenfalls die Feststellung, ob die Newsletter geöffnet werden, wann sie geöffnet werden und welche Links geklickt werden. Diese Informationen können aus technischen Gründen zwar den einzelnen Newsletterempfängern zugeordnet werden. Es ist jedoch weder unser Bestreben, noch, sofern eingesetzt, das des Versanddienstleisters, einzelne Nutzer zu beobachten. Die Auswertungen dienen uns viel mehr dazu, die Lesegewohnheiten unserer Nutzer zu erkennen und unsere Inhalte auf sie anzupassen oder unterschiedliche Inhalte entsprechend den Interessen unserer Nutzer zu versenden.</p>
						<p>Der Versand des Newsletters und die Erfolgsmessung erfolgen auf Grundlage einer Einwilligung der Empfänger gem. Art. 6 Abs. 1 lit. a, Art. 7 DSGVO i.V.m § 7 Abs. 2 Nr. 3 UWG bzw. auf Grundlage der gesetzlichen Erlaubnis gem. § 7 Abs. 3 UWG.</p>
						<p>Die Protokollierung des Anmeldeverfahrens erfolgt auf Grundlage unserer berechtigten Interessen gem. Art. 6 Abs. 1 lit. f DSGVO und dient dem Nachweis der Einwilligung in den Empfang des Newsletters.</p>
						<p>Newsletterempfänger können den Empfang unseres Newsletters jederzeit kündigen, d.h. Ihre Einwilligungen widerrufen. Einen Link zur Kündigung des Newsletters finden sie am Ende eines jeden Newsletters. Damit erlöschen gleichzeitig ihre Einwilligungen in die Erfolgsmessung. Ein getrennter Widerruf der Erfolgsmessung ist leider nicht möglich, in diesem Fall muss das gesamte Newsletterabonnement gekündigt werden. Mit der Abmeldung von Newsletter, werden die personenbezogenen Daten gelöscht, es sei denn deren Aufbewahrung ist rechtlich geboten oder gerechtfertigt, wobei deren Verarbeitung in diesem Fall nur auf diese Ausnahmezwecke beschränkt wird. Wir können insbesondere die ausgetragenen E-Mailadressen bis zu drei Jahren auf Grundlage unserer berechtigten Interessen speichern bevor wir sie für Zwecke des Newsletterversandes löschen, um eine ehemals gegebene Einwilligung nachweisen zu können. Die Verarbeitung dieser Daten wird auf den Zweck einer möglichen Abwehr von Ansprüchen beschränkt. Ein individueller Löschungsantrag ist jederzeit möglich, sofern zugleich das ehemalige Bestehen einer Einwilligung bestätigt wird.</p>

						<h6>Einbindung von Diensten und Inhalten Dritter<h6>
						<p>Wir setzen innerhalb unseres Onlineangebotes auf Grundlage unserer berechtigten Interessen (d.h. Interesse an der Analyse, Optimierung und wirtschaftlichem Betrieb unseres Onlineangebotes im Sinne des Art. 6 Abs. 1 lit. f. DSGVO) Inhalts- oder Serviceangebote von Drittanbietern ein, um deren Inhalte und Services, wie z.B. Videos oder Schriftarten einzubinden (nachfolgend einheitlich bezeichnet als “Inhalte”). Dies setzt immer voraus, dass die Drittanbieter dieser Inhalte, die IP-Adresse der Nutzer wahrnehmen, da sie ohne die IP-Adresse die Inhalte nicht an deren Browser senden könnten. Die IP-Adresse ist damit für die Darstellung dieser Inhalte erforderlich. Wir bemühen uns nur solche Inhalte zu verwenden, deren jeweilige Anbieter die IP-Adresse lediglich zur Auslieferung der Inhalte verwenden. Drittanbieter können ferner so genannte Pixel-Tags (unsichtbare Grafiken, auch als „Web Beacons“ bezeichnet) für statistische oder Marketingzwecke verwenden. Durch die „Pixel-Tags“ können Informationen, wie der Besucherverkehr auf den Seiten dieser Website ausgewertet werden. Die pseudonymen Informationen können ferner in Cookies auf dem Gerät der Nutzer gespeichert werden und unter anderem technische Informationen zum Browser und Betriebssystem, verweisende Webseiten, Besuchszeit sowie weitere Angaben zur Nutzung unseres Onlineangebotes enthalten, als auch mit solchen Informationen aus anderen Quellen verbunden werden können.</p>
						<p>Die nachfolgende Darstellung bietet eine Übersicht von Drittanbietern sowie ihrer Inhalte, nebst Links zu deren Datenschutzerklärungen, welche weitere Hinweise zur Verarbeitung von Daten und, z.T. bereits hier genannt, Widerspruchsmöglichkeiten (sog. Opt-Out) enthalten</p>
						<p>– Falls unsere Kunden die Zahlungsdienste Dritter (z.B. PayPal oder Sofortüberweisung) nutzen, gelten die Geschäftsbedingungen und die Datenschutzhinweise der jeweiligen Drittanbieter, welche innerhalb der jeweiligen Webseiten, bzw. Transaktionsapplikationen abrufbar sind.</p>
						<p>– Externe Schriftarten von Google, LLC., https://www.google.com/fonts („Google Fonts“). Die Einbindung der Google Fonts erfolgt durch einen Serveraufruf bei Google (in der Regel in den USA). Datenschutzerklärung: https://policies.google.com/privacy, Opt-Out: https://adssettings.google.com/authenticated.</p>
						<p>– Landkarten des Dienstes „Google Maps“ des Drittanbieters Google LLC, 1600 Amphitheatre Parkway, Mountain View, CA 94043, USA, gestellt. Datenschutzerklärung: https://www.google.com/policies/privacy/, Opt-Out: https://www.google.com/settings/ads/.</p>
						<p>– Videos der Plattform „YouTube“ des Dritt-Anbieters Google Inc., 1600 Amphitheatre Parkway, Mountain View, CA 94043, USA. Datenschutzerklärung: https://www.google.com/policies/privacy/, Opt-Out: https://www.google.com/settings/ads/.</p>
						<p>– Innerhalb unseres Onlineangebotes sind Funktionen des Dienstes Google+ eingebunden. Diese Funktionen werden angeboten durch den Drittanbieter Google LLC, 1600 Amphitheatre Parkway, Mountain View, CA 94043, USA. Wenn Sie in Ihrem Google+ – Account eingeloggt sind können Sie durch Anklicken des Google+ – Buttons die Inhalte unserer Seiten mit Ihrem Google+ – Profil verlinken. Dadurch kann Google den Besuch unserer Seiten Ihrem Benutzerkonto zuordnen. Wir weisen darauf hin, dass wir als Anbieter der Seiten keine Kenntnis vom Inhalt der übermittelten Daten sowie deren Nutzung durch Google+ erhalten. Datenschutzerklärung: https://policies.google.com/privacy, Opt-Out: https://adssettings.google.com/authenticated.</p>
						<p>– Innerhalb unseres Onlineangebotes sind Funktionen des Dienstes Instagram eingebunden. Diese Funktionen werden angeboten durch die Instagram Inc., 1601 Willow Road, Menlo Park, CA, 94025, USA integriert. Wenn Sie in Ihrem Instagram – Account eingeloggt sind können Sie durch Anklicken des Instagram – Buttons die Inhalte unserer Seiten mit Ihrem Instagram – Profil verlinken. Dadurch kann Instagram den Besuch unserer Seiten Ihrem Benutzerkonto zuordnen. Wir weisen darauf hin, dass wir als Anbieter der Seiten keine Kenntnis vom Inhalt der übermittelten Daten sowie deren Nutzung durch Instagram erhalten. Datenschutzerklärung: http://instagram.com/about/legal/privacy/.</p>
						<p>– Wir verwenden Social Plugins des sozialen Netzwerkes Pinterest, das von der Pinterest Inc., 635 High Street, Palo Alto, CA, 94301, USA (“Pinterest”) betrieben wird. Wenn Sie eine Seite aufrufen die ein solches Plugin enthält, stellt Ihr Browser eine direkte Verbindung zu den Servern von Pinterest her. Das Plugin übermittelt dabei Protokolldaten an den Server von Pinterest in die USA. Diese Protokolldaten enthalten möglicherweise Ihre IP-Adresse, die Adresse der besuchten Websites, die ebenfalls Pinterest-Funktionen enthalten, Art und Einstellungen des Browsers, Datum und Zeitpunkt der Anfrage, Ihre Verwendungsweise von Pinterest sowie Cookies. Datenschutzerklärung: https://about.pinterest.com/de/privacy-policy.</p>
						<p>– Innerhalb unseres Onlineangebotes können Funktionen des Dienstes, bzw. der Plattform Twitter eingebunden (nachfolgend bezeichnet als „Twitter“). Twitter ist ein Angebot der Twitter Inc., 1355 Market Street, Suite 900, San Francisco, CA 94103, USA. Die Funktionen beinhalten die Darstellung unserer Beiträge innerhalb von Twitter innerhalb unseres Onlineangebotes, die Verknüpfung zu unserem Profil bei Twitter sowie die Möglichkeit mit den Beiträgen und den Funktionen von Twitter zu interagieren, als auch zu messen, ob Nutzer über die von uns bei Twitter geschalteten Werbeanzeigen auf unser Onlineangebot gelangen (sog. Conversion-Messung). Twitter ist unter dem Privacy-Shield-Abkommen zertifiziert und bietet hierdurch eine Garantie, das europäische Datenschutzrecht einzuhalten (https://www.privacyshield.gov/participant?id=a2zt0000000TORzAAO&status=Active). Datenschutzerklärung: https://twitter.com/de/privacy, Opt-Out: .</p>

						<h6>Änderungen und Aktualisierungen der Datenschutzerklärung</h6>
						<p>Wir bitten Sie sich regelmäßig über den Inhalt unserer Datenschutzerklärung zu informieren. Wir passen die Datenschutzerklärung an, sobald die Änderungen der von uns durchgeführten Datenverarbeitungen dies erforderlich machen. Wir informieren Sie, sobald durch die Änderungen eine Mitwirkungshandlung Ihrerseits (z.B. Einwilligung) oder eine sonstige individuelle Benachrichtigung erforderlich wird.</p>

					</div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('service_js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
    <script>
        $('.change-passowrd-form').validate({ // initialize the plugin
            rules: {
                old_password: {
                    required: true,
                },
                new_password: {
                    required: true,
                },
                confirm_password: {
                    required: true,
                }
            }
        });
    </script>
	<!-- Start of LiveChat (www.livechatinc.com) code -->
<script>
    window.__lc = window.__lc || {};
    window.__lc.license = 13059087;
    ;(function(n,t,c){function i(n){return e._h?e._h.apply(null,n):e._q.push(n)}var e={_q:[],_h:null,_v:"2.0",on:function(){i(["on",c.call(arguments)])},once:function(){i(["once",c.call(arguments)])},off:function(){i(["off",c.call(arguments)])},get:function(){if(!e._h)throw new Error("[LiveChatWidget] You can't use getters before load.");return i(["get",c.call(arguments)])},call:function(){i(["call",c.call(arguments)])},init:function(){var n=t.createElement("script");n.async=!0,n.type="text/javascript",n.src="https://cdn.livechatinc.com/tracking.js",t.head.appendChild(n)}};!n.__lc.asyncInit&&e.init(),n.LiveChatWidget=n.LiveChatWidget||e}(window,document,[].slice))
</script>
<noscript><a href="https://www.livechatinc.com/chat-with/13059087/" rel="nofollow">Chat with us</a>, powered by <a href="https://www.livechatinc.com/?welcome" rel="noopener nofollow" target="_blank">LiveChat</a></noscript>
<!-- End of LiveChat code -->
@endsection
