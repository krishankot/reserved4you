@foreach($notifications as $row)
    @if($row->type == 'appointment')
		@php
			if(strpos($row->title, 'Neue Buchung') !== false){
				$appointmentDetails = \BaseFunction::getAppointmentData($row->appointment_id);
			}else{
				$appointmentDetails = \BaseFunction::getAppointmentDataByID($row->appointment_id);
			}
		@endphp
		@foreach ($appointmentDetails as $appointmentDetail)    
			<a href="javascript:void(0);" onclick="getAppointmentDetails({!! $appointmentDetail->id !!});">
				<div class="notification-item">
					<div class="noti-heading-wrap">
					   <?php /* <h5 class="{{ (strpos($row->title, 'Termin') === false)?((strpos($row->title, 'Reschedule') !== false)?'text-warning':'text-info'):'' }}">{{$row->title}}</h5> */ ?>
						<h5 class="{{ (strpos($row->title, 'Termin') === false)?((strpos(strtolower($row->title), 'verschoben') !== false)?'text-warning':'text-info'):'' }}">{{$row->title}}</h5>
						<span>- {{\Carbon\Carbon::parse($row->created_at)->diffForHumans()}}</span>
					</div>
					<p class="mb-0">{{$row->description}}</p>
				</div>
			</a>
		 @endforeach
	@elseif($row->type == 'rating')
		<a href="{{URL::to('dienstleister/betriebsprofil?t=reviews')}}">
			<div class="notification-item">
				<div class="noti-heading-wrap">
					<h5 class="text-yellow">{{$row->title}}</h5>
					<span>- {{\Carbon\Carbon::parse($row->created_at)->diffForHumans()}}</span>
				</div>
				<p class="mb-0">{{$row->description}}</p>
			</div>
		</a>
	@elseif($row->type == 'customer_accepted' OR $row->type == 'customer_rejected')
		@if($row->type == 'customer_accepted')
			<a href="{{URL::to('dienstleister/kunden-details/ansehen/'.encrypt($row->appointment_id))}}">
		@endif
		<div class="notification-item">
			<div class="noti-heading-wrap">
				<h5 class="{{$row->type == 'customer_accepted'?'text-yellow':'text-danger' }}">{{$row->title}}</h5>
				<span>- {{\Carbon\Carbon::parse($row->created_at)->diffForHumans()}}</span>
			</div>
			<p class="mb-0">{{$row->description}}</p>
		</div>
		@if($row->type == 'customer_accepted')
			</a>
		@endif
	@endif
@endforeach