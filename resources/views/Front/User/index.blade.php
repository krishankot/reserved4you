@extends('layouts.front')
@section('front_title')
    User Profile
@endsection
@section('front_css')
    <link type="text/css" rel="stylesheet" href="{{URL::to('storage/app/public/Frontassets/css/FullCalendar.css')}}"/>
	
    <link type="text/css" rel="stylesheet" href="{{URL::to('storage/app/public/Frontassets/css/styles-2.css')}}"/>
    <link type="text/css" rel="stylesheet" href="{{URL::to('storage/app/public/Frontassets/css/responsive.css')}}"/>
    <style>
        textarea.textarea-area {
            width: 100%;
            padding: 15px;
            border-radius: 10px;
            font-size: 18px;
            font-weight: 400;
            margin-bottom: 20px;
            resize: none;
            height: 190px;
        }
		
		.fc-event-title {
		   padding: 0 1px;
		   white-space:nowrap; 
		   overflow: hidden;
		} 
		 .disabled {
            pointer-events:none; //This makes it not clickable
        /*opacity:0.6;         //This grays it out to look disabled*/
        }

        
        .delete-profile-box {
            text-align: center;
            padding: 30px 0 30px;
        }

        .delete-profile-box h4 {
            font-size: 32px;
            color: #101928;
            font-weight: 700;
            margin-bottom: 19px;
        }

        .delete-profile-box p {
            font-size: 18px;
            color: #101928;
            font-weight: 400;
            opacity: 0.50;
            max-width: 340px;
            margin: auto;
        }

        .btn-gray {
            background: #0f1928;
            font-size: 17px;
            color: #ffffff;
            font-weight: 500;
            border: 2px solid #F9F9FB;
            border-radius: 15px;
            padding: 11px 22px;
            transition: all 0.5s;
        }

        .btn-gray:hover {
            background: #101928;
            color: #FABA5F;
        }


        .notes-btn-wrap {
            text-align: center;
        }
		
		.avatar-upload .avatar-delete label {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    width: 50px;
    height: 50px;
    margin-bottom: 0;
    border-radius: 100%;
    background: #FFFFFF;
    border: 1px solid #E8E8EC;
    -webkit-box-shadow: 0px 13px 26px 0px hsl(0deg 0% 90% / 60%);
    box-shadow: 0px 13px 26px 0px hsl(0deg 0% 90% / 60%);
    cursor: pointer;
    font-weight: normal;
    -webkit-transition: all 0.2s ease-in-out;
    -o-transition: all 0.2s ease-in-out;
    transition: all 0.2s ease-in-out;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
}
.avatar-upload .avatar-delete label::after {
    content: "\f00d";
    font-family: 'Font Awesome 5 Free';
    position: absolute;
    top: 50%;
    left: 50%;
    text-align: center;
    margin: auto;
    -webkit-transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);
    transform: translate(-50%, -50%);
    color: #101928;
    font-size: 20px;
}
    </style>
@endsection
@section('front_content')

    <section class="profile-section-bg d-margin">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="profile-index-wrap">
                    <span>
                        @if(Auth::user()->profile_pic == '')
                            <img
                                src="https://via.placeholder.com/1080x1080/00000/FABA5F?text={{strtoupper(substr(Auth::user()->first_name, 0, 1))}}{{strtoupper(substr(Auth::user()->last_name, 0, 1))}}"
                                alt="user">
                        @else
                            @if(file_exists(storage_path('app/public/user/'.Auth::user()->profile_pic)) && Auth::user()->profile_pic != '')
                                <img src="{{URL::to('storage/app/public/user/'.Auth::user()->profile_pic)}}"
                                     alt="user">
                            @else
                                <img
                                    src="https://via.placeholder.com/1080x1080/00000/FABA5F?text={{strtoupper(substr(Auth::user()->first_name, 0, 1))}}{{strtoupper(substr(Auth::user()->last_name, 0, 1))}}"
                                    alt="user">
                            @endif
                        @endif
                    </span>
                        <div>
                            <h6>{{Auth::user()->first_name}} {{Auth::user()->last_name}}</h6>
                            <p>{{Auth::user()->email}}</p>
                            <ul>
                                <li><a data-toggle="modal" data-target="#editProfile" href="#"> <i
                                            class="fas fa-user"></i> Profil bearbeiten</a></li>
                                <li><a href="{{route('users.settings')}}">Passwort ändern</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <ul class="nav nav-pills profile-navs-pills" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="pills-bookings-tab" data-toggle="pill" href="#pills-bookings"
                               role="tab" aria-controls="pills-bookings" aria-selected="true">
                                <span><?php echo file_get_contents(URL::to('storage/app/public/Frontassets/images/profile/booking.svg')) ?></span>
                                Meine Buchungen
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="pills-favourites-tab" data-toggle="pill" href="#pills-favourites"
                               role="tab" aria-controls="pills-favourites" aria-selected="false">
                                <span><?php echo file_get_contents(URL::to('storage/app/public/Frontassets/images/profile/love.svg')) ?></span>
                                Favoriten
                            </a>
                        </li>
						<li class="nav-item" role="presentation" style="pointer-event:none">
                            <a class="nav-link" id="pills-addresses-tab" data-toggle="pill" href="#pills-addresses"
                               role="tab" aria-controls="pills-addresses" aria-selected="false">
                                <span><?php echo file_get_contents(URL::to('storage/app/public/Frontassets/images/profile/location.svg')) ?></span>
                                Adressen
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-bookings" role="tabpanel"
                     aria-labelledby="pills-bookings-tab">
                    <ul class="nav nav-pills index-booking-pills" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link " id="pills-calanderIcon-tab" data-toggle="pill"
                               href="#pills-calanderIcon" role="tab" aria-controls="pills-calanderIcon"
                               aria-selected="false">
                                <span><?php echo file_get_contents(URL::to('storage/app/public/Frontassets/images/profile/calendar.svg')) ?></span>
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="pills-listIcon-tab" data-toggle="pill" href="#pills-listIcon"
                               role="tab" aria-controls="pills-listIcon" aria-selected="true">
                                <span><?php echo file_get_contents(URL::to('storage/app/public/Frontassets/images/profile/list.svg')) ?></span>
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade " id="pills-calanderIcon" role="tabpanel"
                             aria-labelledby="pills-calanderIcon-tab">
                            <div class="calendar-wrap-flexx">
                                <div id="calendar"></div>

                            </div>
                        </div>
                        <div class="tab-pane fade show active" id="pills-listIcon" role="tabpanel"
                             aria-labelledby="pills-listIcon-tab">
                            <div class="list-header-wrap">
                                <h2>Meine Buchungen</h2>
                                <ul class="nav nav-pills listing-pills" id="pills-tab" role="tablist">
                                    <li role="presentation">
                                        <a class="active" id="pills-pending-tab" data-toggle="pill"
                                           href="#pills-pending" role="tab" aria-controls="pills-pending"
                                           aria-selected="true">Bevorstehend</a>
                                    </li>
                                    <li role="presentation">
                                        <a class="" id="pills-running-tab" data-toggle="pill" href="#pills-running"
                                           role="tab" aria-controls="pills-running" aria-selected="false">Aktuell</a>
                                    </li>
                                    <li role="presentation">
                                        <a class="" id="pills-completed-tab" data-toggle="pill" href="#pills-completed"
                                           role="tab" aria-controls="pills-completed"
                                           aria-selected="false">Erledigt</a>
                                    </li>
                                    <li role="presentation">
                                        <a class="" id="pills-canceled-tab" data-toggle="pill" href="#pills-canceled"
                                           role="tab" aria-controls="pills-canceled" aria-selected="false">Storniert</a>
                                    </li>
                                </ul>

                            </div>
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-pending" role="tabpanel"
                                     aria-labelledby="pills-pending-tab">
                                    <div class="list-section">
                                        @foreach($pendingAppointment as $key =>$row)
                                            <h5 class="list-section-title mt-4">{{\Carbon\Carbon::parse($key)->translatedFormat('d M Y')}}</h5>
                                            @foreach($row as $value)
												
                                                <div class="list-item-box" rel="{{ base64_encode('pe358'.$value['id'].'n') }}">
                                                    <div class="list-item-top-wrap">
                                                        <div class="list-item-img">
                                                            @if(file_exists(storage_path('app/public/service/'.$value->image)) && $value->image != '')
                                                                <img
                                                                    src="{{URL::to('storage/app/public/service/'.$value->image)}}"
                                                                    alt="user">
                                                                <div
                                                                    style="display: none">{{$imge = URL::to('storage/app/public/service/'.$value->image)}}</div>
                                                            @else
                                                                <img
                                                                    src="{{URL::to('storage/app/public/default/default-user.png')}}"
                                                                    alt="user">
                                                                <div
                                                                    style="display: none">{{$imge = URL::to('storage/app/public/default/default-user.png')}}</div>
                                                            @endif
                                                        </div>
                                                        <div class="list-item-info">
                                                            <div class="list-item-info-top">
                                                                <h5>
                                                                    <a href="{{URL::to('kosmetik/'.@$value['storeData']['slug'])}}">{{@$value['storeData']['store_name']}}</a>
                                                                </h5>
                                                                <h6><span><img
                                                                            src="{{URL::to('storage/app/public/Frontassets/images/profile/location.svg')}}"
                                                                            alt=""></span>
                                                                    {{@$value['storeData']['store_address']}}</h6>
                                                            </div>
                                                            <h3>{{$value['service_name']}}</h3>
                                                            <h4>{{@$value['variantData']['description']}}</h4>
                                                        </div>
                                                        <div class="list-item-price">
                                                            @if($value['cancellation'] == 'yes' && $value['status'] != 'reschedule')
                                                                <a href="#" class="btn btn-black btn-cancel ask_cancel"
                                                                   data-id="{{@$value['variantData']['id']}}"
                                                                   data-order="{{$value['order_id']}}"
                                                                   data-appointment="{{$value['appointment_id']}}"
                                                                   data-image="{{$imge}}"
                                                                   data-service="{{$value['service_name']}}"
                                                                   data-description="{{@$value['variantData']['description']}}">Stornieren?</a>
                                                            @endif
															@if($value['status'] == 'reschedule')
																<P class="text-right">Termin verschieben?</p>
																<div class="d-flex float-right mb-3">
																<a href="javascript:void(0)"
															   class="btn  main-btn btn-choose chooseDate mr-1"
															   data-id="{{$value['category_id']}}"  data-appointment="{{$value['id']}}" data-store="{{$value['store_id']}}"  data-time="{{ $value['variantData']['duration_of_service'] }}" data-change="0">Verschieben
																</a>
																<a href="#" class="btn btn-black btn-cancel ask_cancel" style="margin:0px;padding:10px 20px;"
                                                                   data-id="{{@$value['variantData']['id']}}"
                                                                   data-order="{{$value['order_id']}}"
                                                                   data-appointment="{{$value['appointment_id']}}"
                                                                   data-image="{{$imge}}"
																   data-reason="Reschedule Cancelled"
                                                                   data-service="{{$value['service_name']}}"
                                                                   data-description="{{@$value['variantData']['description']}}">Stornieren?</a>
																	</div>
															@endif
                                                            <h4>
																{{$value['status'] == 'succeeded' ? 'Paid' : ($value['status'] == 'failed'?'Unpaid':($value['status'] == 'reschedule'?'Verschoben':'Gebucht'))}}
                                                                {{number_format($value['price'],2,',','.')}}
                                                                €</h4>
                                                        </div>
                                                    </div>
                                                    <div class="list-item-bottom-wrap">
                                                        <p>{{@$value['variantData']['duration_of_service']}} min</p>
                                                        <div class="list-item-profile-wrap">
                                                            @if(!empty($value['empData']))
                                                                <span>
                                                                    @if(file_exists(storage_path('app/public/store/employee/'.@$value['empData']['image'])) && @$value['empData']['image'] != '')
                                                                        <img
                                                                            src="{{URL::to('storage/app/public/store/employee/'.@$value['empData']['image'])}}"
                                                                            alt=""
                                                                        >
                                                                    @else
                                                                        <img
                                                                            src="{{URL::to('storage/app/public/default/default-user.png')}}"
                                                                            alt=""
                                                                        >
                                                                    @endif
                                                                </span>
                                                                @else
                                                                <span><img src="{{URL::to('storage/app/public/default/default-user.png')}}" alt=""> </span>
                                                            @endif
                                                            <h6>@if(!empty($value['empData'])){{@$value['empData']['emp_name']}} @else Any Employee
                                                                , @endif
																
																	<i>{{\Carbon\Carbon::parse($value['appo_date'])->translatedFormat('d F, Y')}}
																		({{\Carbon\Carbon::parse($value['appo_date'])->translatedFormat('D')}}
																		)
																		- {{\Carbon\Carbon::parse($value['appo_time'])->translatedFormat('H:i')}}</i>
																@if($value['status'] == 'reschedule')
																	(<i>Reschedule</i>)
																@endif
                                                            </h6>
                                                        </div>
                                                        <h5>Buchungs-ID: <strong>#{{$value['order_id']}}</strong></h5>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endforeach

                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-running" role="tabpanel"
                                     aria-labelledby="pills-running-tab">
                                    <div class="list-section">
                                        @foreach($runningAppointments as $key =>$value)
                                            <div class="list-item-box">
                                                <div class="list-item-top-wrap">
                                                    <div class="list-item-img">
                                                        @if(file_exists(storage_path('app/public/service/'.$value->image)) && $value->image != '')
                                                            <img
                                                                src="{{URL::to('storage/app/public/service/'.$value->image)}}"
                                                                alt="user">
                                                        @else
                                                            <img
                                                                src="{{URL::to('storage/app/public/default/default-user.png')}}"
                                                                alt="user">
                                                        @endif
                                                    </div>
                                                    <div class="list-item-info">
                                                        <div class="list-item-info-top">
                                                            <h5>
                                                                <a href="{{URL::to('kosmetik/'.@$value['storeData']['slug'])}}">{{@$value['storeData']['store_name']}}</a>
                                                            </h5>
                                                            <h6><span><img
                                                                        src="{{URL::to('storage/app/public/Frontassets/images/profile/location.svg')}}"
                                                                        alt=""></span>
                                                                {{@$value['storeData']['store_address']}}</h6>
                                                        </div>
                                                        <h3>{{$value['service_name']}}</h3>
                                                        <h4>{{@$value['variantData']['description']}}</h4>
                                                    </div>
                                                    <div class="list-item-price">
                                                        <div class="btn-wrap">
                                                        </div>
                                                        <h4>{{$value['status'] == 'succeeded' ? 'Paid' : ($value['status'] == 'failed'?'Unpaid':'Gebucht')}} {{number_format($value['price'],2,',','.')}}
                                                            €</h4>
                                                    </div>
                                                </div>
                                                <div class="list-item-bottom-wrap">
                                                    <p>{{@$value['variantData']['duration_of_service']}} min</p>
                                                    <div class="list-item-profile-wrap">
                                                        @if(!empty($value['empData']))
                                                            <span>
                                                                    @if(file_exists(storage_path('app/public/store/employee/'.@$value['empData']['image'])) && @$value['empData']['image'] != '')
                                                                    <img
                                                                        src="{{URL::to('storage/app/public/store/employee/'.@$value['empData']['image'])}}"
                                                                        alt=""
                                                                    >
                                                                @else
                                                                    <img
                                                                        src="{{URL::to('storage/app/public/default/default-user.png')}}"
                                                                        alt=""
                                                                    >
                                                                @endif
                                                                </span>
                                                        @else
                                                            <span><img src="{{URL::to('storage/app/public/default/default-user.png')}}" alt=""> </span>
                                                        @endif
                                                        <h6>@if(!empty($value['empData'])){{@$value['empData']['emp_name']}} @else Any Employee
                                                            , @endif
                                                            <i>{{\Carbon\Carbon::parse($value['appo_date'])->translatedFormat('M d, Y')}}
                                                                ({{\Carbon\Carbon::parse($value['appo_date'])->translatedFormat('D')}}
                                                                )
                                                                - {{\Carbon\Carbon::parse($value['appo_time'])->translatedFormat('H:i')}}</i>
                                                        </h6>
                                                    </div>
                                                    <h5>Buchungs-ID:: <strong>#{{$value['order_id']}}</strong></h5>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-completed" role="tabpanel"
                                     aria-labelledby="pills-completed-tab">
                                    <div class="list-section">
                                        @foreach($completeAppointments as $key =>$value)
                                            <div class="list-item-box">
                                                <div class="list-item-top-wrap">
                                                    <div class="list-item-img">
                                                        @if(file_exists(storage_path('app/public/service/'.$value->image)) && $value->image != '')
                                                            <img
                                                                src="{{URL::to('storage/app/public/service/'.$value->image)}}"
                                                                alt="user">
                                                        @else
                                                            <img
                                                                src="{{URL::to('storage/app/public/default/default-user.png')}}"
                                                                alt="user">
                                                        @endif
                                                    </div>
                                                    <div class="list-item-info">
                                                        <div class="list-item-info-top">
                                                            <h5>
                                                                <a href="{{URL::to('kosmetik/'.@$value['storeData']['slug'])}}">{{@$value['storeData']['store_name']}}</a>
                                                            </h5>
                                                            <h6><span><img
                                                                        src="{{URL::to('storage/app/public/Frontassets/images/profile/location.svg')}}"
                                                                        alt=""></span>
                                                                {{@$value['storeData']['store_address']}}</h6>
																@if(empty($value->is_reviewed))
																	<a href="{{ route('users.feedback',['slug' => @$value['storeData']['slug'], 'service_id' => $value['service_id'],'emp' => @$value['empData']['id'], 'ap' => @$value['id']])}}">Bewertung schreiben</a>
																@endif
                                                        </div>
                                                        <h3>{{$value['service_name']}}</h3>
                                                        <h4>{{@$value['variantData']['description']}}</h4>
                                                    </div>
                                                    <div class="list-item-price">
                                                        <a href="javascript:void(0)"
                                                           class="btn btn-booking-again main-btn book_again"
                                                           data-id="{{$value['id']}}">Erneut Buchen?
                                                            </a>
                                                        <h4>{{$value['status'] == 'succeeded' ? 'Paid' : ($value['status'] == 'failed'?'Unpaid':'Gebucht')}} {{number_format($value['price'],2,',','.')}}
                                                            €</h4>
                                                    </div>
                                                </div>
                                                <div class="list-item-bottom-wrap">
                                                    <p>{{@$value['variantData']['duration_of_service']}} min</p>
                                                    <div class="list-item-profile-wrap">
                                                        @if(!empty($value['empData']))
                                                            <span>
                                                                    @if(file_exists(storage_path('app/public/store/employee/'.@$value['empData']['image'])) && @$value['empData']['image'] != '')
                                                                    <img
                                                                        src="{{URL::to('storage/app/public/store/employee/'.@$value['empData']['image'])}}"
                                                                        alt=""
                                                                    >
                                                                @else
                                                                    <img
                                                                        src="{{URL::to('storage/app/public/default/default-user.png')}}"
                                                                        alt=""
                                                                    >
                                                                @endif
                                                                </span>
                                                        @else
                                                            <span><img src="{{URL::to('storage/app/public/default/default-user.png')}}" alt=""> </span>
                                                        @endif
                                                        <h6>@if(!empty($value['empData'])){{@$value['empData']['emp_name']}} @else Any Employee
                                                            , @endif
                                                            <i>{{\Carbon\Carbon::parse($value['appo_date'])->translatedFormat('M d, Y')}}
                                                                ({{\Carbon\Carbon::parse($value['appo_date'])->translatedFormat('D')}}
                                                                )
                                                                - {{\Carbon\Carbon::parse($value['appo_time'])->translatedFormat('H:i')}}</i>
                                                        </h6>
                                                    </div>
                                                    <h5>Buchungs-ID: <strong>#{{$value['order_id']}}</strong></h5>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-canceled" role="tabpanel"
                                     aria-labelledby="pills-canceled-tab">
                                    <div class="list-section">
                                        @foreach($cancelAppointments as $key =>$value)
                                            <div class="list-item-box">
                                                <div class="list-item-top-wrap">
                                                    <div class="list-item-img">
                                                        @if(file_exists(storage_path('app/public/service/'.$value->image)) && $value->image != '')
                                                            <img
                                                                src="{{URL::to('storage/app/public/service/'.$value->image)}}"
                                                                alt="user">
                                                            <div
                                                                style="display: none">{{$image = URL::to('storage/app/public/service/'.$value->image)}}</div>
                                                        @else
                                                            <img
                                                                src="{{URL::to('storage/app/public/default/default-user.png')}}"
                                                                alt="user">
                                                            <div
                                                                style="display: none">{{$image = URL::to('storage/app/public/default/default-user.png')}}</div>
                                                        @endif
                                                    </div>
                                                    <div class="list-item-info">
                                                        <div class="list-item-info-top">
                                                            <h5>
                                                                <a href="{{URL::to('kosmetik/'.@$value['storeData']['slug'])}}">{{@$value['storeData']['store_name']}}</a>
                                                            </h5>
                                                            <h6><span><img
                                                                        src="{{URL::to('storage/app/public/Frontassets/images/profile/location.svg')}}"
                                                                        alt=""></span>
                                                                {{@$value['storeData']['store_address']}}</h6>
                                                           <?php /* <a href="#" class="cancel_reason" data-image="{{$image}}"
                                                               data-booking="{{$value['order_id']}}"
                                                               data-service="{{$value['service_name']}}"
                                                               data-description="{{@$value['variantData']['description']}}"
                                                               data-reason="{{$value['cancel_reason']}}">
                                                                Cancelation Reason
                                                            </a> */ ?>
															 <a href="javascript:void(0);" class="cancel_reason" data-image="{{$image}}"
                                                               data-booking="{{$value['order_id']}}"
                                                               data-service="{{$value['service_name']}}"
															   data-cancelledby="{{$value['cancelled_by']}}"
                                                               data-storename="{{@$value['storeData']['store_name']}}"
                                                               data-description="{{@$value['variantData']['description']}}"
                                                               data-reason="{{$value['cancel_reason']}}">
                                                                Stornierungsgrund anzeigen
                                                            </a>
                                                        </div>
                                                        <h3>{{$value['service_name']}}</h3>
                                                        <h4>{{@$value['variantData']['description']}}</h4>
                                                    </div>
                                                    <div class="list-item-price">
                                                        <a href="javascript:void(0)"
                                                           class="btn btn-booking-again main-btn book_again"
                                                           data-id="{{$value['id']}}">Erneut buchen?</a>
                                                        <h4>{{$value['status'] == 'succeeded' ? 'Paid' : ($value['status'] == 'failed'?'Unpaid':'Gebucht')}} {{number_format($value['price'],2,',','.')}}
                                                            €</h4>
                                                    </div>
                                                </div>
                                                <div class="list-item-bottom-wrap">
                                                    <p>{{@$value['variantData']['duration_of_service']}} min</p>
                                                    <div class="list-item-profile-wrap">
                                                        @if(!empty($value['empData']))
                                                            <span>
                                                                    @if(file_exists(storage_path('app/public/store/employee/'.@$value['empData']['image'])) && @$value['empData']['image'] != '')
                                                                    <img
                                                                        src="{{URL::to('storage/app/public/store/employee/'.@$value['empData']['image'])}}"
                                                                        alt=""
                                                                    >
                                                                @else
                                                                    <img
                                                                        src="{{URL::to('storage/app/public/default/default-user.png')}}"
                                                                        alt=""
                                                                    >
                                                                @endif
                                                                </span>
                                                        @else
                                                            <span><img src="{{URL::to('storage/app/public/default/default-user.png')}}" alt=""> </span>
                                                        @endif
                                                        <h6>@if(!empty($value['empData'])){{@$value['empData']['emp_name']}} @else Any Employee
                                                            , @endif
                                                            <i>{{\Carbon\Carbon::parse($value['appo_date'])->translatedFormat('M d, Y')}}
                                                                ({{\Carbon\Carbon::parse($value['appo_date'])->translatedFormat('D')}}
                                                                )
                                                                - {{\Carbon\Carbon::parse($value['appo_time'])->translatedFormat('H:i')}}</i>
                                                        </h6>
                                                    </div>
                                                    <h5>Buchungs-ID: <strong>#{{$value['order_id']}}</strong></h5>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-favourites" role="tabpanel" aria-labelledby="pills-favourites-tab">
                    <div class="favourites-header-wrap">
                        <div class="favourites-header-left">
                            <h5>Favoriten</h5>
                            @if(count($favorites) == 1)
                            <h6><span class="favorite_count">{{count($favorites)}}</span> Favorit</h6>
                            @else
                            <h6><span class="favorite_count">{{count($favorites)}}</span> Favoriten</h6>
                            @endif
                        </div>
                        <div class="favourites-header-right">
                            {{--                            <div class="dropdown">--}}
                            {{--                                <a class="dropdown-toggle cosmetics-toggle" type="button" id="dropdownMenuButton"--}}
                            {{--                                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
                            {{--                                    Cosmetics--}}
                            {{--                                    <span><i class="fas fa-chevron-circle-down"></i></span>--}}
                            {{--                                </a>--}}
                            {{--                                <div class="dropdown-menu dropdown-new-menu" aria-labelledby="dropdownMenuButton">--}}
                            {{--                                    <a class="dropdown-item" href="#">Cosmetics</a>--}}
                            {{--                                    <a class="dropdown-item" href="#">Cosmetics</a>--}}
                            {{--                                    <a class="dropdown-item" href="#">Cosmetics</a>--}}
                            {{--                                </div>--}}
                            {{--                            </div>--}}
                        </div>
                    </div>
                    @foreach($favorites as $row)

                        <div class="area-item-wrap">
                            <div class="area_img">
                                <div class="owl-carousel owl-theme area-img-owl" id="area-img-owl">
                                    <div class="item"
                                         onclick="window.location.href='{{URL::to('kosmetik/'.$row['slug'])}}'">
                                        <div class="area-img">
                                            <img
                                                src="{{URL::to('storage/app/public/store/'.(($row->store_profile == '')?'Store-6058bde8bf5a8.JPEG':$row->store_profile))}}"
                                                alt="">
                                        </div>
                                    </div>
                                    @foreach($row->storeGallery as $item)
                                        <div class="item"
                                             onclick="window.location.href='{{URL::to('kosmetik/'.$row['slug'])}}'">
                                            <div class="area-img">
                                                <img src="{{URL::to('storage/app/public/store/gallery/'.$item->file)}}"
                                                     alt="">
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                @if($row->discount != 0)
                                    <p class="disscount-box">%</p>
                                @endif
                            </div>
                            <div class="area_info">
                                <h6 onclick="window.location.href='{{URL::to('kosmetik/'.$row['slug'])}}'">{{$row->store_name}}</h6>
                                <p>
                                    <span><?php echo file_get_contents(URL::to('storage/app/public/Frontassets/images/icon/location.svg')) ?></span>
                                    {{$row->store_address}}</p>
                                <p>
                                    <span><?php echo file_get_contents(URL::to('storage/app/public/Frontassets/images/icon/cream.svg')) ?></span>
                                    Kosmetik
                                </p>
                                <div class="area_info_rating_wrap">
                                    <ul class="rating-ul">
                                        {!! \BaseFunction::getRatingStar($row['rating']) !!}
                                    </ul>
                                    @if(@$row->ratingCount == 1 )
                                        <p>{{$row['rating']}} <span> ({{@$row->ratingCount}} Bewertung)</span>
                                    @else
                                        <p>{{$row['rating']}} <span> ({{@$row->ratingCount}} Bewertungen)</span>
                                    @endif
                                    </p>
                                </div>
                                <ul class="area_tag">
                                    @forelse(@$row->categories as $cat)
                                        @if(@$cat->CategoryData->main_category == null)
                                            <li>
                                                {{@$cat->CategoryData->name}}
                                            </li>
                                        @endif
                                    @empty
                                    @endforelse
                                </ul>
                            </div>
                            <div class="area_price">
                                <a class="wishlist_icon {{$row['isFavorite'] == 'true' ? 'active' : ''}}"
                                   data-id="{{$row['id']}}"
                                   href="javascript:void(0)"><i class="far fa-heart"></i></a>
                                <h5>{{$row->is_value}}</h5>
                            </div>
                        </div>
                    @endforeach

                </div>
                <div class="tab-pane fade" id="pills-addresses" role="tabpanel" aria-labelledby="pills-addresses-tab">
                    <div class="favourites-header-wrap">
                        <div class="favourites-header-left">
                            <h5>Adressen verwalten</h5>
                        </div>
                        <div class="favourites-header-right">
                            <!-- <a href="#" class="btn btn-adress"><i class="fas fa-plus-circle"></i> Add New Address</a> -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 text-center mb-5 mt-3">
                           <h5>Coming Soon!</h5>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="cancelBooking-modal" tabindex="-1" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
                <div class="modal-body confirmation-modal-body">
                    <div class="confirmation-modal">
                        <h5>{{__('Confirmation') }}</h5>
                        <p>{{ __('Are you sure you want to cancel the booking') }}</p>
                        <div class="confirmation-modal-wrap">
                <span>
                    <img src="{{URL::to('storage/app/public/Frontassets/images/profile/insurance.svg')}}" alt="">
                </span>
                            <div>
                                <h5>{{__('Cancellation Policy') }}</h5>
                                <a href="{{URL::to('cancellation-policy')}}" target="_blank">{{ __('Show Policy') }}</a>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-black btn-block btn-yes confirm_cancel">Ja, stornieren??
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editProfile" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
                <div class="modal-body confirmation-modal-body">
                    {{Form::open(array('url'=>'change-profile','method'=>'post','name'=>'change_profile','id'=>"change_profile",'files'=>'true'))}}
                    <div class="confirmation-modal">
                        <div class="avatar-upload">
                            <div class="avatar-edit">
                                <input type='file' id="imageUpload" accept=".png, .jpg, .jpeg" name="profile_pic"/>
                                <label for="imageUpload"></label>
                            </div>
							 <div class="avatar-delete" style="{{Auth::user()->profile_pic == ''?'display:none;':''}}position:absolute;bottom:-5px;left:-5px;z-index:1;">
                               <label></label>
                            </div>
                            <div class="avatar-preview">
                                @if(Auth::user()->profile_pic == '')
                                    <div id="imagePreview"
                                         style="background-image: url(https://via.placeholder.com/1080x1080/00000/FABA5F?text={{strtoupper(substr(Auth::user()->first_name, 0, 1))}}{{strtoupper(substr(Auth::user()->last_name, 0, 1))}});">
                                    </div>
                                @else
                                    <div id="imagePreview"
                                         style="background-image: url({{URL::to('storage/app/public/user/'.Auth::user()->profile_pic)}});">
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="modal-input">
                                <input type="text" name="first_name" value="{{Auth::user()->first_name}}">
                                <span><img src="{{URL::to('storage/app/public/Frontassets/images/profile/user.svg')}}"
                                           alt=""></span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="modal-input">
                                <input type="text" name="last_name" value="{{Auth::user()->last_name}}">
                                <span><img src="{{URL::to('storage/app/public/Frontassets/images/profile/user.svg')}}"
                                           alt=""></span>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="modal-input">
                                <input type="text" name="email" value="{{Auth::user()->email}}">
                                <span><img src="{{URL::to('storage/app/public/Frontassets/images/profile/mail.svg')}}"
                                           alt=""></span>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="modal-input">
                                <input type="text" name="phone_number" value="{{Auth::user()->phone_number}}">
                                <span><img src="{{URL::to('storage/app/public/Frontassets/images/profile/call.svg')}}"
                                           alt=""></span>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-black btn-block btn-yes">Speichern</button>
                    {{Form::close()}}
                    <a href="#" class="close-link" data-dismiss="modal">Löschen</a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="detail-polish" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
                <div class="modal-body confirmation-modal-body">
                    <div class="confirmation-modal">
                        <div class="detail-wrap-box">
                            <span class="detail-wrap-box-img simage"><img
                                    src="{{URL::to('storage/app/public/Frontassets/images/profile/woman-salon-balayage-min.jpg')}}"
                                    alt=""></span>
                            <div class="detail-wrap-box-infos">
                                <h6>Buchungs-ID: <span class="b_id">#R4U49258</span></h6>
                                <h4 class="b_service_name">Ladies - Balayage & Blow Dry</h4>
                                <h5 class="b_service_descirption">Balayage</h5>
                            </div>
                        </div>
                        <div class="detail-wrap-box-info">
                            <h5 id="whom">Die Buchung wurde storniert, weil …</h5>
                            <p class="b_reason">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod
                                tempor incididunt
                                ut labore et dolore magna aliqua. Ut enim ad minim veniam</p>
                            <a href="#" data-dismiss="modal">Schließen</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="cancel_appointment" class="modal modal-top fade calendar-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
                {{Form::open(array('url'=>'cancel-appointment','method'=>'post','name'=>'cancel_appointmnet', 'class'=>'cancel_appointmnet_form'))}}
                <div class="modal-body confirmation-modal-body">
                    <div class="confirmation-modal">
                        <div class="detail-wrap-box">
                            <span class="detail-wrap-box-img simages"><img
                                    src="{{URL::to('storage/app/public/Frontassets/images/profile/woman-salon-balayage-min.jpg')}}"
                                    alt=""></span>
                            <div class="detail-wrap-box-infos">
                                <h6>Buchungs-ID: <span class="b_ids">#R4U49258</span></h6>
                                <h4 class="b_service_names">Ladies - Balayage & Blow Dry</h4>
                                <h5 class="b_service_descirptions">Balayage</h5>
                            </div>
                        </div>
                        <div class="detail-wrap-box-info">
                            <h5>Die Buchung wurde storniert, weil …</h5>
                            {{Form::hidden('variant_id','',array('class'=>'variant_cancel'))}}
                            {{Form::hidden('appointment_id','',array('class'=>'appointment_cancel'))}}
                            <textarea class="textarea-area" name="cancel_reason" required></textarea>

                            <button type="submit" class="btn btn-black btn-block btn-yes">Ja, stornieren?</button>
                            {{--                            <a href="#" data-dismiss="modal">Close</a>--}}
                        </div>
                    </div>
                </div>
                {{Form::close()}}
            </div>
        </div>
    </div>

    <!-- calendar modal -->

    <div id="modal-view-event" class="modal modal-top fade calendar-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <h4 class="modal-title"><span class="event-icon"></span><span class="event-title"></span></h4>
                    <div class="event-body"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div id="modal-view-event-add" class="modal modal-top fade calendar-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="add-events">
                    <div class="modal-body modal-body22">
                        <div class="modals-profile-wrap">
                            <div class="modals-modals-profile">
                                <img src="{{URL::to('storage/app/public/Frontassets/images/bookingperson.png')}}"
                                     alt="">
                            </div>
                            <div class="modals-modals-info">
                                <h6>Salon</h6>
                                <h5>Lounge Hair & Care</h5>
                            </div>
                        </div>
                        <div class="modal-profile-address">
                            <span><?php echo file_get_contents(URL::to('storage/app/public/Frontassets/images/profile/location.svg')) ?></span>
                            <p>Bruchwiesenstraße 6, 66849 <br> Landstuhl, Germany</p>
                        </div>
                        <div class="accordion" id="accordionExample">
                            <div class="paymentaccordion">
                                <a href="javascript:void(0)" class="payment-box-link" data-toggle="collapse"
                                   data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    <span
                                        class="payment-box-icon"><?php echo file_get_contents(URL::to('storage/app/public/Frontassets/images/icon/hair.svg')) ?></span>
                                    <h6>Hair</h6>
                                    <span class="downn-arroww"><i class="far fa-chevron-down"></i></span>
                                </a>
                                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                                     data-parent="#accordionExample">
                                    <div class="payment-body-box">
                                        <div class="payment-box-profile-wrap">
                                            <span><img
                                                    src="{{URL::to('storage/app/public/Frontassets/images/experts-1.jpg')}}"
                                                    alt=""></span>
                                            <div>
                                                <p>Retained Stylist</p>
                                                <h6>Oben Decson</h6>
                                            </div>
                                        </div>
                                        <div class="payment-item-infos">
                                            <h5>Ladies - Balayage & Blow Dry</h5>
                                            <h6>Balayage</h6>
                                            <div class="payment-item-infos-wrap">
                                                <span>1 hr 30 min</span>
                                                <p>35€</p>
                                            </div>
                                        </div>
                                        <div class="payment-item-infos">
                                            <h5>Ladies - Balayage & Blow Dry</h5>
                                            <h6>Balayage</h6>
                                            <div class="payment-item-infos-wrap">
                                                <span>1 hr 30 min</span>
                                                <p>35€</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="paymentaccordion">
                                <a href="javascript:void(0)" class="payment-box-link collapsed" data-toggle="collapse"
                                   data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    <span
                                        class="payment-box-icon"><?php echo file_get_contents(URL::to('storage/app/public/Frontassets/images/icon/nails.svg')) ?></span>
                                    <h6>Nails</h6>
                                    <span class="downn-arroww"><i class="far fa-chevron-down"></i></span>
                                </a>
                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                                     data-parent="#accordionExample">
                                    <div class="payment-body-box">
                                        <div class="payment-box-profile-wrap">
                                            <span><img
                                                    src="{{URL::to('storage/app/public/Frontassets/images/experts-1.jpg')}}"
                                                    alt=""></span>
                                            <div>
                                                <p>Retained Stylist</p>
                                                <h6>Oben Decson</h6>
                                            </div>
                                        </div>
                                        <div class="payment-item-infos">
                                            <h5>Ladies - Balayage & Blow Dry</h5>
                                            <h6>Balayage</h6>
                                            <div class="payment-item-infos-wrap">
                                                <span>1 hr 30 min</span>
                                                <p>35€</p>
                                            </div>
                                        </div>
                                        <div class="payment-item-infos">
                                            <h5>Ladies - Balayage & Blow Dry</h5>
                                            <h6>Balayage</h6>
                                            <div class="payment-item-infos-wrap">
                                                <span>1 hr 30 min</span>
                                                <p>35€</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-items-pricing">
                            <h4>Gesamtbetrag <i> 120€</i></h4>
                            <h6>Pbezahlt mit <span><img
                                        src="{{URL::to('storage/app/public/Frontassets/images/master.svg')}}"
                                        alt=""></span> Master card</h6>
                        </div>

                        <a href="#" class="btn btn-black btn-block btn-modal-cancel">Cancel Booking</a>
                        <a href="#" class="cancelation-policy">Read Cancelation Policy</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

<div class="modal fade" id="chooseNowModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body choose-modal-body">
                <button type="button" class="close"  aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
                <div class="hairchoosbox">
                    <span class="categoryImage"></span>
                    <h5 class="categoryName">Hair</h5>
                    <h6>Please choose stylist and set date and time</h6>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="hairchoosbox-left">
                            <div class="hairchoosbox-profile">
                                <span><img class="storeimage" src="{{URL::to('storage/app/public/Frontassets/images/profile1.png')}}"
                                           alt=""></span>
                                <h6 class="storename">Lounge Hair & Care</h6>
                            </div>
                            <div class="hairchoosbox-select-box ">
                                <select class="vodiapicker emplist">
                                    <option value="en" class="test"
                                            data-thumbnail="{{URL::to('storage/app/public/Frontassets/images/icon/profile-icon.svg')}}">
                                        Profile
                                    </option>
                                    <option value="au"
                                            data-thumbnail="{{URL::to('storage/app/public/Frontassets/images/profile1.png')}}">
                                        Profile 2
                                    </option>
                                    <option value="uk"
                                            data-thumbnail="{{URL::to('storage/app/public/Frontassets/images/profile.jpg')}}">
                                        Profile 3
                                    </option>
                                    <option value="cn"
                                            data-thumbnail="{{URL::to('storage/app/public/Frontassets/images/profile-img.jpg')}}">
                                        Profile 4
                                    </option>
                                </select>
                                <div class="lang-select">
                                    <button class="btn-select" value=""></button>
                                    <div class="b">
                                        <ul id="a" class="lang_ul"></ul>
                                    </div>
                                </div>
                            </div>
                            <div class="hairchoosbox-date">
                                <h6>Set your Booking Date</h6>
                                <div id="calendar2"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="set-time-head">
                            <h6>Set your Booking Time</h6>
                            <ul class="scheduletime scheduletime2">

                            </ul>
                        </div>
                    </div>
                </div>
                <a href="#" class="btn btn-book-block mt-5 disabled" id="reschedule_booking">
                    <p>Verschieben</p>
                    <div>
                        <span class="dateshow">16 May 2021</span>
                        <h6 class="timeshow">-</h6>
                    </div>
                </a>
                <input type="hidden" name="category" class="category_ids">
                <input type="hidden" name="store" class="store_ids">
                <input type="hidden" name="date" class="date_ids">
                <input type="hidden" name="employee" class="emp_ids">
                <input type="hidden" name="totalTime" class="totalTimes">
                <input type="hidden" name="time" class="timeslotsa">
            </div>
        </div>
    </div>
</div>


@endsection
@section('front_js')
<script src="{{URL::to('storage/app/public/Frontassets/js/popper.min.js')}}"></script>
    <script src="{{URL::to('storage/app/public/Frontassets/js/moment.js')}}"></script>
    <script src="{{URL::to('storage/app/public/Frontassets/js/fullcalendar.min.js')}}"></script>
    <script src="{{URL::to('storage/app/public/Frontassets/js/FullCalendar.js')}}"></script>
<script src="{{URL::to('storage/app/public/Frontassets/js/data.js')}}"></script>
    <script>
		
		if(localStorage.getItem('reshedule_redirect')){
			var reshedule_redirect = localStorage.getItem('reshedule_redirect');
			var y = $(".list-item-box[rel='"+reshedule_redirect+"']").offset().top;
			$('html,body').animate({
				scrollTop: y - 70
			}, 'fast');
			localStorage.removeItem('reshedule_redirect');
		}
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#imagePreview').css('background-image', 'url(' + e.target.result + ')');
                    $('#imagePreview').hide();
                    $('#imagePreview').fadeIn(650);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#imageUpload").change(function () {
            readURL(this);
			  $('.avatar-delete').show();
        });

        $(document).on('click', '.cancel_reason', function () {
            var booking = $(this).data('booking');
            var image = $(this).data('image');
            var service = $(this).data('service');
            var description = $(this).data('description');
            var reason = $(this).data('reason');
			var cancelled_by = $(this).data('cancelledby');
			var storename = $(this).data('storename');
			var messagewho = 'Die Buchung wurde storniert, weil...';
			
            $('.simage img').attr('src', image);
            $('.b_id').text('#' + booking);
            $('.b_service_name').text(service);
            $('.b_service_descirption').text(description);
            $('.b_reason').text(reason);
			$('#whom').text(messagewho);

            $('#detail-polish').modal('toggle');

        });

        $(document).on('click', '.ask_cancel', function () {
            var id = $(this).data('id');
            var appointment_cancel = $(this).data('appointment');
            var image = $(this).data('image');
            var service = $(this).data('service');
            var description = $(this).data('description');
            var order = $(this).data('order');
			var reason = $(this).data('reason');
			
			
            $('.variant_cancel').val(id);
            $('.textarea-area').val(reason);
            $('.b_ids').text('#' + order);
            $('.b_service_names').text(service);
            $('.b_service_descirptions').text(description);
            $('.appointment_cancel').val(appointment_cancel);
            $('.simages img').attr('src', image);
            $('#modal-view-event-add').modal('hide');
            $('#cancelBooking-modal').modal('toggle');
        });

        $(document).on('click', '.confirm_cancel', function () {
            $('#cancelBooking-modal').modal('toggle');
			var reason = $('.textarea-area').val();
			if(reason == "Reschedule Cancelled"){
				$('.cancel_appointmnet_form').submit();
			}else{
				$('#cancel_appointment').modal('toggle');
			}
        });

        $(document).on('click', '.book_again', function () {
            var id = $(this).data('id');

            $.ajax({
                type: 'POST',
                async: true,
                dataType: "json",
                url: baseurl + '/book-again',
                data: {
                    _token: token,
                    id: id,
                },
                beforesend: $('#loading').css('display', 'block'),
                success: function (response) {
                    var status = response.status;
                    $('#loading').css('display', 'none')
                    if (status == 'true') {
						window.location.href = baseurl +'/checkout-prozess';
                        //window.open(baseurl + '/checkout-data', '_blank');
                    } else {

                    }
                },
                error: function (e) {

                }
            });
        });

		 $(document).on('click', '.reschedule', function () {
            var id = $(this).data('appointment');

            $.ajax({
                type: 'POST',
                async: true,
                dataType: "json",
                url: baseurl + '/book-again',
                data: {
                    _token: token,
                    id: id,
                },
                beforesend: $('#loading').css('display', 'block'),
                success: function (response) {
                    var status = response.status;
                    $('#loading').css('display', 'none')
                    if (status == 'true') {
						//window.location.href = baseurl +'/checkout-data';
                        //window.open(baseurl + '/checkout-data', '_blank');
                    } else {

                    }
                },
                error: function (e) {

                }
            });
        });
		
		
		$(document).on('click', '.avatar-delete', function () {
            $.ajax({
				type: 'GET',
				url: baseurl + '/delete-profile-picture',
				success: function (response) {
					$('#imagePreview').css('background-image', "url("+response.ResponseData+")");
					$('#dropdownMenuButton span img').attr('src', response.ResponseData);
					$('.profile-index-wrap span img').attr('src', response.ResponseData);
					$('.avatar-delete').hide();
					$('#imageUpload').val("");
				}
			});
        });
	

        $(document).on('click', '.wishlist_icon', function () {


            if (authCheck != '') {
                var id = $(this).data('id');
                var count = $('.favorite_count').text();
                $.ajax({
                    type: 'POST',
                    async: true,
                    dataType: "json",
                    url: baseurl + '/favorite-store',
                    data: {
                        _token: token,
                        id: id,
                    },
                    beforesend: $('#loading').css('display', 'block'),
                    success: function (response) {
                        var status = response.status;
                        var type = response.data;
                        if (status == 'true') {
                            if (type == 'remove') {
                                $('.wishlist_icon[data-id=' + id + ']').removeClass('active');
                                $('.wishlist_icon[data-id=' + id + ']').parent('div').parent('div').remove();
                                var newCount = count - 1;
                                $('.favorite_count').text(newCount);
                            } else if (type == 'add') {
                                $('.wishlist_icon[data-id=' + id + ']').addClass('active');
                            }
                        } else {

                        }
                        $('#loading').css('display', 'none');
                    },
                    error: function (e) {

                    }
                });
            } else {
                $('#login-modal').modal('toggle');
            }
        });

    </script>
    <script>
        (function () {
            'use strict';
            // ------------------------------------------------------- //
            // Calendar
            // ------------------------------------------------------ //
            var calData = <?php echo json_encode($calander); ?>;
            jQuery(function () {
                // page is ready
                jQuery('#calendar').fullCalendar({
                    themeSystem: 'bootstrap4',
                    // emphasizes business hours
                    businessHours: false,
                    defaultView: 'month',
                    // event dragging & resizing
                    // editable: true,
                    // header
                    slotLabelFormat:"HH:mm",
                    timeFormat: 'H:mm',
                   locale: 'de',
				    monthNames: ['Januar','Februar','März','April','Mai','Juni','Juli','August','September','Oktober','November','Dezember'],
                    monthNamesShort: ['Jan','Feb','Mär','Apr','Mai','Jun','Jul','Aug','Sep','Okt','Nov','Dez'],
                    dayNames: ['Montag','Dienstag','Mittwoch','Donnerstag','Freitag','Samstag','Sonntag'],
                    dayNamesShort: ['Mo','Di','Mi','Do','Fr','Sa','So'],
                    header: {
                        left: 'title',
                        center: 'month,agendaWeek,agendaDay',
                        right: 'Heute prev,next'
                    },
					buttonText: {
					   month: 'Monat', 
					   agendaDay: 'Tag', 
					   agendaWeek: 'Woche'
					},
                    events: calData,
                    eventClick: function (event, jsEvent, view) {
                        console.log(event);
                        opencanlenderModal(event);
                    },
                    //  timeFormat: {
                    //     agenda: 'H:mm{ - h:mm}'
                    // },
                })
            });

        })(jQuery);

        function opencanlenderModal(event){
            console.log(event);
            console.log(event.description);
            $('#add-events').html(event.description);
            $('#modal-view-event-add').modal('toggle');
        }
    </script>
	<script>
    var authCheck = '{{Auth::check()}}';
    var baseurl = '{{URL::to('/')}}';
    var token = '{{ csrf_token() }}';
    var loginUser = localStorage.getItem('loginuser');
    
    $(document).ready(function () {

        var berror = '{{\Session::get("booking_error")}}';
        if(berror == 'yes'){
            $('#deleteProfilemodal').modal('toggle');
            var value = '{{\Session::forget("booking_error")}}'
        }
        localStorage.removeItem('lastValue');
        $(document).on('click','.scheduletime li',function (){
            $('li').removeClass("activetime");
            $(this).addClass("activetime");
            $('.timeslotsa').val($(this).data('id'));
            $('.timeshow').text($(this).data('id'));
            $('#reschedule_booking').removeClass('disabled');
        });
    });

    //test for iterating over child elements
    var langArray = [];
    $('.vodiapicker option').each(function () {
        var img = $(this).attr("data-thumbnail");
        var text = this.innerText;
        var value = $(this).val();
        var item = '<li><img src="' + img + '" alt="" value="' + value + '"/><span>' + text + '</span></li>';
        langArray.push(item);
    })

    $('#a').html(langArray);

    //Set the button value to the first el of the array
    $('.btn-select').html(langArray[0]);
    $('.btn-select').attr('value', 'en');

    //change button stuff on click
    $('#a li').click(function () {
        var img = $(this).find('img').attr("src");
        var value = $(this).find('img').attr('value');
        var text = this.innerText;
        var item = '<li><img src="' + img + '" alt="" /><span>' + text + '</span></li>';
        $('.btn-select').html(item);
        $('.btn-select').attr('value', value);


        $(".b").toggle();
        // console.log(value);
    });

    $(".btn-select").click(function () {
        // console.log('value');
        $(".b").toggle();
    });

    //check local storage for the lang
    var sessionLang = localStorage.getItem('lang');
    if (sessionLang) {
        //find an item with value of sessionLang
        var langIndex = langArray.indexOf(sessionLang);
        $('.btn-select').html(langArray[langIndex]);
        $('.btn-select').attr('value', sessionLang);
    } else {
        var langIndex = langArray.indexOf('ch');
        $('.btn-select').html(langArray[langIndex]);
        //$('.btn-select').attr('value', 'en');
    }
    $(document).ready(function () {
        $('.scheduletime li ').click(function () {
            $('li').removeClass("activetime");
            $(this).addClass("activetime");
        });
    });
    $('#calendar2').datepicker({
        language: "nl",
        format: 'yyyy-mm-dd',
        min: 0,
        startDate: new Date(),
    }).on('changeDate', function(e) {
        $('.date_ids').val(e.format());
        $('.dateshow').text(e.format('dd-mm-yyyy'));
        $('.timeshow').text('-');
        $('#reschedule_booking').addClass('disabled');
        changeDate();
    });

    $(document).on('click','.close',function (){
        $('#chooseNowModal').modal('hide');
		$('#loading').hide();
    });
	$(document).on('click', '#reschedule_booking', function () {
		var category_id = $('.category_ids').val();
		var date = $('.date_ids').val();
		var emp_id = $('.emp_ids').val();
		var timeslot = $('.timeslotsa').val();
		var totalTime = $('.chooseDate[data-id='+ category_id +']').data('time');
		var id = $('.chooseDate[data-id='+ category_id +']').data('appointment');
		$.ajax({
			type: 'POST',
			async: true,
			dataType: "json",
			url: baseurl + '/reschedule-appointment',
			data: {
				_token: token,
				id: parseInt(id),
				date: date,
				time: timeslot,
				totalTime: totalTime,
				emp_id: emp_id,
			},
			beforesend: $('#loading').css('display', 'block'),
			success: function (response) {
				$('#chooseNowModal').modal('toggle');
				$('#loading').css('display', 'none');
				
				if(response.ResponseCode == "success"){
					window.location.href =  baseurl + '/buchungsbestaetigung';
				}else{
					window.location.href =  "{{ route('users.profile') }}";
				}
			},
			error: function (e) {

			}
		});

	});
	
	$('#chooseNowModal').on('hidden.bs.modal', function () {
	 $('#loading').css('display', 'none');
	})

</script>
@endsection
