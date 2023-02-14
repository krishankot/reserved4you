@extends('layouts.front')
@section('front_title')
    Notification
@endsection
@section('front_css')
 <?php
    use App\Models\StoreProfile;
	 use App\Models\AppointmentData;
    ?>
<style type="text/css">
        .text-red {
            color: #e82929;
        }
    
        .employee{
            cursor: pointer!important;
        }
        .fc-timegrid-slot{
            height: 2em!important;
        }
        .f11{
            font-size: 11px!important;
        }
        .opacity{
            opacity: .5;
        }
        .fc-license-message{
            display: none!important;
        }
        .fc-timegrid-col-frame {
            background: #FFF !important;
            border: none !important;
            border-top: 1px solid #ddd !important;
            font-weight: bold;
        }
        .slick-active{
            cursor: pointer;
        }
        .fc-toolbar-title{
            float: right!important;
            padding-top: 6px!important;
            font-size: 1.4em!important;
        }
        .fc-daygrid-dot-event .fc-event-title{
            font-weight: 500!important;
        }
        .fc-myCustomButton-button.fc-button{
            background: #FABA5F!important;
            color: white!important;
        }
        .prev.slick-arrow{
            z-index: 9;
        }
        .slick-arrow .fc-icon{
            margin-top: 4px!important;
        }
        .slick-arrow{
            position: absolute;
            top: 30px;
            border: 1px solid transparent;
            padding: .4em .65em;
            font-size: 1em;
            line-height: 1.5;
            border-radius: 50%!important;
            background: white!important;
            box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
        }
        .next.slick-arrow{
            right: 0px;
        }
        .fc-button-primary{
            color:black!important;
            background: white!important;
            border: white!important;
            padding-left: 16px!important;
            padding-right: 16px!important;
        }
        .fc-button-primary.fc-button-active{
            color: #fff!important;
            background-color: black!important;
            background-image: none;
            border-radius: 8px!important;
            box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;

        }
        .fc .fc-toolbar.fc-header-toolbar{
            margin-bottom: 113px!important;
        }
        .border-warning .fc-event-main{
            border-left: 2px solid yellow;
        }
        .border-primary .fc-event-main{
            border-left: 2px solid blue;
        }
        .fc-event-main{
            text-align: justify!important;
            padding: 4px 0px 4px 6px!important;

            white-space: unset!important;
        }
        .fc-toolbar.fc-header-toolbar{
            background-color: #FFF4EE!important;
            padding: 11px 4px!important;
            border-radius: 5px;
        }
        .cancel{
            background-color: #FFD8E5!important;
            border: #FFD8E5!important;
        }
        .cancel .fc-event-main{
            border-left: 2px solid #F685AA;
        }
        .cancel-border{
            border:2px solid  #F685AA!important;
        }
        .cancel .bg-white.text-dark{
            background: #FF4646!important;
            color: white!important;
        }
        .booked{
            background-color: #EEEBFF!important;
            border: #EEEBFF!important;
        }
        .booked-border{
            border:2px solid  #5F4FB7!important;
        }
        .booked .fc-event-main{
            border-left: 2px solid #5F4FB7;
        }
        .booked .bg-white.text-dark{
            background: white!important;
            color: #5F4FB7!important;
        }
        .reschedule{
            background-color: #fcf8e3 !important;
            border: #faebcc !important;
        }
        .reschedule-border{
            border:2px solid  #faebcc !important;
        }
        .reschedule .fc-event-main{
            border-left: 2px solid #faebcc;
        }
		.reschedule .bg-white.text-dark{
            background: white!important;
            color: #ffc107 !important;
        }

        .working-time{
            color: #DB8B8B!important;
        }


        .completed{
            background-color: #D6F6D6!important;
            border: #D6F6D6!important;;
        }
        .completed .fc-event-main{
            border-left: 2px solid #56C156;
        }
        .completed-border{
            border:2px solid  #56C156!important;
        }
        .completed .bg-white.text-dark{
            background: white!important;
            color: #56C156!important;
        }

        .pending{
            background-color: #CEEFFF!important;
            border: #CEEFFF!important;;
        }
        .pending-border{
            border:2px solid #5BC9FF!important;
        }
        .pending .fc-event-main{
            border-left: 2px solid #5BC9FF;
        }
        .pending .bg-white.text-dark{
            background: white!important;
            color: #5BC9FF!important;
        }

        .running{
            background-color: #FDE3BF!important;
            border: #D6F6D6!important;;
        }
        .running-border{
            border:2px solid  #FABA5F!important;
        }
        .running .fc-event-main{
            border-left: 2px solid #FABA5F;
        }
        .running .bg-white.text-dark{
            background: white!important;
            color: #FABA5F!important;
        }




        /*.popper,
        .tooltip {
            position: absolute;
            z-index: 9999;
            background: #FFC107;
            color: black;
            width: 150px;
            border-radius: 3px;
            box-shadow: 0 0 2px rgba(0,0,0,0.5);
            padding: 10px;
            text-align: center;
        }
        .style5 .tooltip {
            background: #1E252B;
            color: #FFFFFF;
            max-width: 200px;
            width: auto;
            font-size: .8rem;
            padding: .5em 1em;
        }
        .popper .popper__arrow,
        .tooltip .tooltip-arrow {
            width: 0;
            height: 0;
            border-style: solid;
            position: absolute;
            margin: 5px;
        }

        .tooltip .tooltip-arrow,
        .popper .popper__arrow {
            border-color: #FFC107;
        }
        .style5 .tooltip .tooltip-arrow {
            border-color: #1E252B;
        }
        .popper[x-placement^="top"],
        .tooltip[x-placement^="top"] {
            margin-bottom: 5px;
        }
        .popper[x-placement^="top"] .popper__arrow,
        .tooltip[x-placement^="top"] .tooltip-arrow {
            border-width: 5px 5px 0 5px;
            border-left-color: transparent;
            border-right-color: transparent;
            border-bottom-color: transparent;
            bottom: -5px;
            left: calc(50% - 5px);
            margin-top: 0;
            margin-bottom: 0;
        }
        .popper[x-placement^="bottom"],
        .tooltip[x-placement^="bottom"] {
            margin-top: 5px;
        }
        .tooltip[x-placement^="bottom"] .tooltip-arrow,
        .popper[x-placement^="bottom"] .popper__arrow {
            border-width: 0 5px 5px 5px;
            border-left-color: transparent;
            border-right-color: transparent;
            border-top-color: transparent;
            top: -5px;
            left: calc(50% - 5px);
            margin-top: 0;
            margin-bottom: 0;
        }
        .tooltip[x-placement^="right"],
        .popper[x-placement^="right"] {
            margin-left: 5px;
        }
        .popper[x-placement^="right"] .popper__arrow,
        .tooltip[x-placement^="right"] .tooltip-arrow {
            border-width: 5px 5px 5px 0;
            border-left-color: transparent;
            border-top-color: transparent;
            border-bottom-color: transparent;
            left: -5px;
            top: calc(50% - 5px);
            margin-left: 0;
            margin-right: 0;
        }
        .popper[x-placement^="left"],
        .tooltip[x-placement^="left"] {
            margin-right: 5px;
        }
        .popper[x-placement^="left"] .popper__arrow,
        .tooltip[x-placement^="left"] .tooltip-arrow {
            border-width: 5px 0 5px 5px;
            border-top-color: transparent;
            border-right-color: transparent;
            border-bottom-color: transparent;
            right: -5px;
            top: calc(50% - 5px);
            margin-left: 0;
            margin-right: 0;
        }
        .badge.badge-outlined {
            background-color: transparent!important;
        }*/

    </style>
@endsection
@section('front_content')
    <section class="d-margin notification-section">
        <div class="container">
            <div class="notification-header-wrap">
                <h5>Mitteilungen</h5>
                <label class="switch">
                    <p>Mitteilungen</p>
                    <input type="checkbox" id="allow_notifications" value="1" name="allow_notifications" <?php echo Auth::user()->allow_notifications==1?'checked':''; ?> >
                    <span class="slider round"></span>
                </label>
            </div>

            @foreach($data as $row)
				@if($row->type == 'appointment')
					@php
						if(strpos($row->title, 'Neue Buchung') !== false){
							$appointmentDetails = \BaseFunction::getAppointmentData($row->appointment_id);
						}else{
							$appointmentDetails = \BaseFunction::getAppointmentDataByID($row->appointment_id);
						}
					@endphp
					@foreach ($appointmentDetails as $appointmentDetail) 
						@if(strpos($row->title, 'Termin verschieben') !== false)
							<div class="notification-item">
								<div class="noti-heading-wrap">
								   <h5 class="text-warning">{{$row->title}}</h5>
									<span>- {{\Carbon\Carbon::parse($row->created_at)->diffForHumans()}}</span>
								</div>
								<p>{{$row->description}}</p>
								<div class="noti-btn-wrap">
									@if($appointmentDetail->status == 'reschedule')
										<a href="javascript:void(0);" onclick="redirectReschedule('{!! base64_encode('pe358'.$appointmentDetail->id.'n') !!}');" class="btn btn-warning">Zeige Details</a>
										<?php /* <a href="{{ url('user-profile#'.base64_encode('pe358'.$appointmentDetail->id.'n')) }}" class="btn btn-warning">Zeige Details</a> */ ?>
									@else
										<a href="javascript:void(0);" onclick="getAppointmentDetails({!! $appointmentDetail->id !!});" class="btn btn-warning">Zeige Details</a>
									@endif
								</div>
							</div>
						@else
							<div class="notification-item">
								<div class="noti-heading-wrap">
								   <h5 class="{{ (strpos($row->title, 'Termin') === false)?((strpos($row->title, 'Reschedule') !== false OR strpos($row->title, 'Postponed') !== false OR strpos($row->title, 'Postpond') !== false)?'text-warning':'text-info'):'' }}">{{$row->title}}</h5>
									<span>- {{\Carbon\Carbon::parse($row->created_at)->diffForHumans()}}</span>
								</div>
								<p>{{$row->description}}</p>
								<div class="noti-btn-wrap">
								   <a href="javascript:void(0);" onclick="getAppointmentDetails({!! $appointmentDetail->id !!});" class="btn {{ (strpos($row->title, 'Termin') === false)?((strpos($row->title, 'Reschedule') !== false OR strpos($row->title, 'Postponed') !== false OR strpos($row->title, 'Postpond') !== false)?'btn-warning':'btn-info'):'btn-details' }}">Zeige Details</a>
								</div>
							</div>
						@endif
					@endforeach
				@elseif($row->type == 'rating') 
					@php
					
					$getStore = StoreProfile::where('id', $row->store_id)->first(); @endphp
					<div class="notification-item">
						<div class="noti-heading-wrap">
							<h5 class="text-yellow">{{$row->title}}</h5>
							<span>- {{\Carbon\Carbon::parse($row->created_at)->diffForHumans()}}</span>
						</div>
						<p>{{$row->description}}</p>
						<div class="noti-btn-wrap">
							<a href="{{URL::to('kosmetik/'.$getStore->slug.'/?t=reviews#'.base64_encode('r'.$row->appointment_id))}}" class="btn btn-details2">Zeige Details</a>
						</div>
					</div>
				@elseif($row->type == 'customer_request') 
					@php
					
					$getStore = StoreProfile::where('id', $row->store_id)->first(); @endphp
					<div class="notification-item">
						<div class="noti-heading-wrap">
							<h5 class="text-yellow">{{$row->title}}</h5>
							<span>- {{\Carbon\Carbon::parse($row->created_at)->diffForHumans()}}</span>
						</div>
						<p>{{$row->description}}</p>
						<div class="noti-btn-wrap">
							<a href="{{URL::to('kundenprofil/'.$getStore->slug.'/1')}}" class="btn btn-details">Akzeptieren</a>
							<a href="{{URL::to('kundenprofil/'.$getStore->slug.'/2')}}" class="btn btn-details2">Ablehnen</a>
						</div>
					</div>
				@elseif($row->type == 'review_request') 
					@php
						$AppointmentData = AppointmentData::where('id', $row->appointment_id)->first();
						$getStore = StoreProfile::where('id', $row->store_id)->first();
					@endphp
					<div class="notification-item">
						<div class="noti-heading-wrap">
							<h5 class="text-yellow">{{$row->title}}</h5>
							<span>- {{\Carbon\Carbon::parse($row->created_at)->diffForHumans()}}</span>
						</div>
						<p>{{$row->description}}</p>
						<div class="noti-btn-wrap">
							<a href="{{ route('users.feedback',['slug' => $getStore->slug, 'service_id' => $AppointmentData->service_id,'emp' => $AppointmentData->store_emp_id, 'ap' => $AppointmentData->id])}}" class="btn btn-details">Feedback geben</a>
						
						</div>
					</div>
				@endif
            @endforeach
        </div>
    </section>
	<div class="modal fade bd-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content modal-body pt-0 pb-0">

            </div>
        </div>
    </div>
@endsection
@section('front_js')
    <script>
        
		 setInterval(function() {
			window.location.reload();
		}, 60000); 
					
		 $('#allow_notifications').change(function() {
			var allow_notifications = 1;
			if($(this).is(":checked")) {
				allow_notifications = 1; 
			}else{
				allow_notifications = 0; 
			}
			$.ajax({
				type: 'POST',
				url: '{{ route("users.allowNotification") }}',
				data: {
					allow_notifications: allow_notifications,
					_token: token
				},
				success: function (response) {
				}
			});
		});
		function getAppointmentDetails(id){
			let url="{{url('appointment-detail/find')}}/"+id;
			$.get(url,function (response) {
			   $('.modal-body').html(response);
			   $('#myModal').modal('show');
			});
		}
		
		function redirectReschedule(id){
			localStorage.setItem('reshedule_redirect', id);
			window.location.href = "{{ route('users.profile') }}";
		}
    </script>
@endsection
