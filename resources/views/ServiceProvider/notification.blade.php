@extends('layouts.serviceProvider')
@section('service_title')
    Dashboard
@endsection
@section('service_css')
    <?php
    use App\Models\StoreProfile;
    $getStore = StoreProfile::where('user_id', Auth::user()->id)->get();
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
            background-color: #FFD2D2!important;
            border: #FFD2D2!important;
        }
        .reschedule-border{
            border:2px solid  #FF3D3D!important;
        }
        .reschedule .fc-event-main{
            border-left: 2px solid #FF3D3D;
        }
        .reschedule .bg-white.text-dark{
            background: white!important;
            color: #FF3D3D!important;
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
@section('service_content')

    <div class="main-content">
        <h2 class="page-title">Notifications</h2>
        <div class="d-margin notification-section">
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
				<div class="notification-item">
					<div class="noti-heading-wrap">
					   <?php /* <h5 class="{{ (strpos($row->title, 'Termin') === false)?((strpos($row->title, 'Reschedule') !== false)?'text-warning':'text-info'):'' }}">{{$row->title}}</h5> */ ?>
						 <h5 class="{{ (strpos($row->title, 'Termin') === false)?((strpos(strtolower($row->title), 'verschoben') !== false)?'text-warning':'text-info'):'' }}">{{$row->title}}</h5>
						<span>- {{\Carbon\Carbon::parse($row->created_at)->diffForHumans()}}</span>
					</div>
					<p>{{$row->description}}</p>
					<div class="noti-btn-wrap">
					   <a href="javascript:void(0);" onclick="getAppointmentDetails({!! $appointmentDetail->id !!});" class="btn {{ (strpos($row->title, 'Termin') === false)?((strpos(strtolower($row->title), 'verschoben') !== false)?'btn-warning':'btn-info'):'btn-details' }}">Get Details</a>
					</div>
				</div>
				@endforeach
            @elseif($row->type == 'rating')
				<div class="notification-item">
					<div class="noti-heading-wrap">
						<h5 class="text-yellow">{{$row->title}}</h5>
						<span>- {{\Carbon\Carbon::parse($row->created_at)->diffForHumans()}}</span>
					</div>
					<p>{{$row->description}}</p>
					<div class="noti-btn-wrap">
						<a href="{{URL::to('dienstleister/betriebsprofil?t=reviews')}}" class="btn btn-details2">Get Details</a>
					</div>
				</div>
			@elseif($row->type == 'customer_accepted' OR $row->type == 'customer_rejected')
				<div class="notification-item">
					<div class="noti-heading-wrap">
						<h5 class="{{$row->type == 'customer_accepted'?'text-yellow':'text-danger' }}">{{$row->title}}</h5>
						<span>- {{\Carbon\Carbon::parse($row->created_at)->diffForHumans()}}</span>
					</div>
					<p>{{$row->description}}</p>
				</div>
            @endif
            @endforeach
            <!-- <div class="notification-item">
                <div class="noti-heading-wrap">
                    <h5 class="text-yellow">To Remind</h5>
                    <span>- Yesterday</span>
                </div>
                <p>Your today's appointments is <strong> 15:00 at Vengola nails </strong></p>
                <div class="noti-btn-wrap">
                    <a href="#" class="btn btn-details2">Get Details</a>
                </div>
            </div>
            <div class="notification-item">
                <div class="noti-heading-wrap">
                    <h5 class="text-green">Booking Completed</h5>
                    <span>- 23 Mar 2021</span>
                </div>
                <p>Your booking <strong> #R4U4215, Shemo Hair Care </strong> has been competed, Please share your experience.</p>
                <div class="noti-btn-wrap">
                    <a href="#" class="btn btn-cancel">Give Review</a>
                </div>
            </div> -->
        </div>
    </div>
	 <!-- Modal -->
    <div class="modal fade bd-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content modal-body pt-0 pb-0">

            </div>
        </div>
    </div>
@endsection

@section('service_js')
<script>
    $('html').addClass('notification-page');

     setInterval(function() {
                  window.location.reload();
                }, 60000); 
	function getAppointmentDetails(id){
		let url='{{url('service-provider/appointment-detail/find')}}/'+id;
		$.get(url,function (response) {
		   $('.modal-body').html(response);
		   $('#myModal').modal('show');
		});
	}
</script>
@endsection
