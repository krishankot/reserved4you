@extends('layouts.serviceProvider')
@section('service_title')
    Kalender
@endsection
@section('service_css')
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar-scheduler@5.9.0/main.min.css' rel='stylesheet' />
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    <style>
		.slick-disabled {
    opacity: 0;
    pointer-events:none;
}
.bootstrap-datetimepicker-widget{
	min-height:130px;
}
        .employee{
            cursor: pointer!important;
            /* min-height: 5em!important;*/
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
            font-size: .7em!important;
            margin-top: 6px!important;
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
            padding: 0px 0px 0px 6px!important;

            white-space: unset!important;
        }
        .fc-toolbar.fc-header-toolbar{
            background-color: #FFF4EE!important;
            padding: 11px 4px!important;
            border-radius: 5px;
        }
        .cancel{
            background-color: #ff3e3d!important;
            border: #ff3e3d!important;
        }
        .cancel .fc-event-main{
            border-left: 2px solid #F685AA;
        }
        .cancel-border{
            border:2px solid  #ff3e3d!important;
        }
        .cancel .bg-white.text-dark{
            background: white!important;
            color: #FF4646!important;
        }
        .booked{
            background-color: #5bc9ff !important;
            border: #5bc9ff !important;
        }
        .booked-border{
            border:2px solid  #5bc9ff !important;
        }
        .booked .fc-event-main{
            border-left: 2px solid #5bc9ff;
        }
        .booked .bg-white.text-dark{
            background: white !important;
            color: #5bc9ff !important;
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


        .fc-daygrid-event-dot{
            display: none!important;
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
            border-left: 2px solid #59C156;
        }

        .completed-border{
            border:2px solid  D6F6D6!important;
        }
        .completed .bg-white.text-dark{
            background: white!important;
            color: #56C156!important;
        }

        .pending{
            background-color: #5cc9ff!important;
            border: #5cc9ff!important;;
        }
        .pending-border{
            border:2px solid #5cc9ff!important;
        }
        .pending .fc-event-main{
            border-left: 2px solid #5BC9FF;
        }

        .pending .bg-white.text-dark{
            background: white!important;
            color: #5cc9ff!important;
        }

        .running{
            background-color: #f9bb5f!important;
            border: #f9bb5f!important;;
        }
        .running-border{
            border:2px solid  #FABA5F!important;
        }
        .running .fc-event-main{
            border-left: 2px solid #f9bb5f;
        }

        .fc-daygrid-event.fc-daygrid-dot-event.running .fc-event-title{
            border-left: 2px solid #FABA5F;
            padding-left: 4px!important;
            margin-left: 3px!important;
        }

        .fc-daygrid-event.fc-daygrid-dot-event.pending .fc-event-title{
            border-left: 2px solid #5BC9FF;
            padding-left: 4px!important;
            margin-left: 3px!important;
        }
        .fc-daygrid-event.fc-daygrid-dot-event.completed .fc-event-title{
            border-left: 2px solid #56C156;
            padding-left: 4px!important;
            margin-left: 3px!important;
        }
        .fc-daygrid-event.fc-daygrid-dot-event.reschedule .fc-event-title{
            border-left: 2px solid #FF3D3D;
            padding-left: 4px!important;
            margin-left: 3px!important;
        }
        .fc-daygrid-event.fc-daygrid-dot-event.booked .fc-event-title{
            border-left: 2px solid #5bc9ff;
            padding-left: 4px!important;
            margin-left: 3px!important;
        }
        .fc-daygrid-event.fc-daygrid-dot-event.cancel .fc-event-title{
            border-left: 2px solid #F685AA;
            padding-left: 4px!important;
            margin-left: 3px!important;
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

		.break {
		  background-color: #d8d8d8 !important;
		  border: #d8d8d8 !important;
		  pointer-events:none;
		}
		
    </style>

    @if(count($employees)==3)
        <style>
            .slick-track{
                width: 100%!important;
            }
            .slick-slide.slick-active{
                width: 33%!important;
            }
        </style>
    @elseif(count($employees)==2)
        <style>
            .slick-track{
             width: 100%!important;
            }
            .slick-slide.slick-active{
                width: 50%!important;
            }
        </style>
    @endif


@endsection
@section('service_content')
    <div class="main-content">
        <div class="page-title-div">
            <h2 class="page-title">Kalender </h2>
			<a href="javascript:void(0);" class="ml-3 add_break_hours btn-yellow">Pausenzeiten</a>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body p-0">
                        <div class="col-3" style="position:absolute;top: 11px">
                            <select class="form-control bg-white store_category" style="width: 90%;">
								 <option value="">Alle Stores</option>
                                @foreach($storeProfiles as $store)
                                    <option value="{{$store->id}}" {{$store->id==session('store_id')?'selected':''}}>{{$store->store_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <input type="hidden" id="selectedDat" value="{{date('N')}}">
                        <input type="hidden" id="selectedMonth" value="{{date('m')}}">
						 <div class="col-3" style="position:absolute;top: 20px;right:120px;">
						<a href="{{url('dienstleister/buchung-erstellen')}}" class="appointment-btn ml-auto btn-yellow">Neuen Termin hinzufügen</a>
						</div>
					   <div class="col-12 py-2" style="top:61px;background: #F9F9FB;position: absolute;padding-left: 58px!important;" >
                            <div class="center" >
                                @foreach($employees as $employee)
                                    <div>
                                        @php $image= $employee->image??'user.png';

                                        @endphp
										 @if(file_exists(storage_path('app/public/store/employee/'.$employee->image)) && $employee->image != '')
											<img style="height: 60px;width: 60px!important;" class="rounded-circle m-auto slider-change" data-id="{{$employee->id}}" src="{{URL::to('storage/app/public/store/employee/'.$image)}}" >
										@else
											<img style="height: 60px;width: 60px!important;" class="rounded-circle m-auto slider-change" data-id="{{$employee->id}}" src="https://via.placeholder.com/1080x1080/00000/FABA5F?text={{strtoupper(substr($employee->emp_name, 0, 2))}}" alt="">
											
										@endif
                                        
                                        <p class="mb-0 font-weight-bold text-dark  text-center" >{{$employee->emp_name}}</p>
                                        <p class="mb-0 font-weight-bold text-center f11 working-time" @foreach($employee->EmpTimeSlot as $slot) data-{{$slot->day}}="{{$slot->start_time.'-'.$slot->end_time}}"  @endforeach>
                                            Arbeitszeit @foreach($employee->EmpTimeSlot as $slot)
                                                {{$slot->day==date('l')? $slot->start_time.'-'.$slot->end_time:''}}
                                            @endforeach
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div id="kt_calendar"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>



    <!-- Modal -->
    <div class="modal fade bd-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content modal-body pt-0 pb-0">

            </div>
        </div>
    </div>
	
	<div class="modal fade" id="breakHoursModal" tabindex="-1" role="dialog" aria-labelledby="breakHoursModal" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				{{Form::open(array('url'=>'service-provider/add-break-hours','method'=>'post','name'=>'form_break_hours','id'=>'form_break_hours','files'=>'true'))}}
					
					<div class="store-modal-body">
						<h5>Pausenzeiten</h5>
						<div class="form-group">
							{{Form::select('break_store_emp_id', $employee_pluck, NULL,array('reuired', 'class'=>'select select-time'))}}
						</div>

						<div class="form-group">
							<input type="text" data-id="modal_add" placeholder="Datum auswählen" class="break_day datepicker consumer-input mb-0" value="{{\Carbon\Carbon::now()->format('d/m/Y')}}" name="breaks_day">
						</div>
						
						<div class="form-group">
							<div class="hours-time-wrap justify-content-right">
								<span class="ml-0">Von</span>
								<input type="text" id="timepicker-24" class="timepicker start_time_break" required name="breaks_start_time" placeholder=" -- --" value="" data-id="modal_add">
								<span>Bis</span>
								<input type="text" class="timepicker end_time_break" name="breaks_end_time" required placeholder=" -- --" value="" data-id="modal_add">
							</div>
						</div>
						
						<div class="hours-tabel-body-wrap ml-0 pl-0 mb-2 bgwhite">
							<label>täglich</label>
						   <label for="everyday-checkmodal_add">
								<input type="checkbox" name="breaks_everyday" value="on" data-id="modal_add" class="everydays" id="everyday-checkmodal_add" >
								<span><i class="fas fa-check"></i></span>
							</label>
						</div> 
						
						<div class="form-group">
							<label>Bitte beachte, dass alle Termine in dem gewählten Zeitraum automatisch verschoben bzw. storniert werden.</label>
							<div class="store-main-service mb-0 mt-2">
								<ul>
									<li>
										<label for="break-reshedule">
											<input type="radio" name="break_action" class="category_select" value="1" id="break-reshedule">
											<div class="categories-box justify-content-center">
												<h6>Verschieben</h6>
											</div>
										</label>
									</li>
									<li>
										<label for="break-cancel">
											<input type="radio" name="break_action" class="category_select" value="2" id="break-cancel" checked>
											<div class="categories-box justify-content-center">
												<h6>Stornieren</h6>
											</div>
										</label>
									</li>
								</ul>
							</div>
						
						</div>
					</div>
				
							
					<div class="review-modal-footer">
						<button type="submit" class="btn btn-black-yellow submit_break_hours">Speichern</button>
						<button type="button" class="btn btn-border-black" data-dismiss="modal">Abbrechen</button>
					</div>
				{{Form::close()}}
			</div>
		</div>
	</div>
@endsection
@section('service_js')
    {{--    <script src='https://unpkg.com/popper.js/dist/umd/popper.min.js'></script>--}}
    {{--    <script src='https://unpkg.com/tooltip.js/dist/umd/tooltip.min.js'></script>--}}
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar-scheduler@5.9.0/main.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/moment@2.27.0/min/moment.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/moment@5.5.0/main.global.min.js'></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>


    <script>
        $(document).ready(function () {

			@php
				$firstHourMinute =  \Carbon\Carbon::now()->format('i');
				if($firstHourMinute <= 30){
					$firstHour  =  \Carbon\Carbon::now()->format('H').":00:00";
				}else{
					$firstHour  =  \Carbon\Carbon::now()->format('H').":30:00";
				}
				$firstHourB  =  \Carbon\Carbon::parse($firstHour)->subMinutes(1)->format("H:i:s");
			@endphp
			var firstHour =  "{!! $firstHourB !!}";
			var defaultView  = "resourceTimeGridDay";
			if(localStorage.getItem('selectedView') == "Monat"){
				defaultView  = "dayGridMonth";
				localStorage.removeItem('selectedView');
			}
			
            var calendar;
            var KTCalendarBasic = function() {

                return {
                    //main function to initiate the module
                    init: function() {

                        var calendarEl = document.getElementById('kt_calendar');
                        calendar = new FullCalendar.Calendar(calendarEl, {
                            slotLabelFormat:
                                {
                                    hour: 'numeric',
                                    minute: '2-digit',
                                    omitZeroMinute: false,
                                    hour12: false
                                },
                            buttonText:{
                                month:    'Monat',
                                day:      'Tag',
                            },
                            slotDuration: "00:10",
							locale: 'de',
                            scrollTime: firstHour,
							nowIndicator: true,
							timezone: 'local',
                            firstDay: 1,
                            allDaySlot: false,
                            titleFormat: 'DD.MM.YYYY',
                            slotMinTime:'07:00:00',
                            slotMaxTime:'24:00:00',

                            headerToolbar: {
                                left: '',
                                center: 'prev next title',
                                right: 'resourceTimeGridDay,dayGridMonth'
                            },
                            views: {
                                resourceTimeGridTwoDay: {
                                    type: 'resourceTimeGrid',
                                    duration: { days: 2 },
                                    buttonText: '2 days',
                                }
                            },
                            initialView: defaultView,
					
                            displayEventTime:false, // don't show the time column in list view
                            height: 900,
                            contentHeight: 880,
                            aspectRatio: 3,  // see: https://fullcalendar.io/docs/aspectRatio
                            editable: false,
                            navLinks: false,
							resourceOrder:'order',


                            resources: [
                                    @for($i=0;$i<4;$i++)
                                    @if(isset($employees[$i]->id))

                                { id: '{{ $employees[$i]->id }}', title: '{{$employees[$i]->emp_name}}',order: "{{$i}}"},
                                @endif
                                @endfor
                            ],



                            // THIS KEY WON'T WORK IN PRODUCTION!!!
                            // To make your own Google API key, follow the directions here:
                            // http://fullcalendar.io/docs/google_calendar/
                            googleCalendarApiKey: 'AIzaSyDcnW6WejpTOCffshGDDb4neIrXVUA1EAE',

                            // eventRender: function(info) {
                            //     var tooltip = new Tooltip(info.el, {
                            //         title: info.event.extendedProps.description,
                            //         placement: 'top',
                            //         trigger: 'hover',
                            //         container: 'body'
                            //     });
                            // },

                            eventDidMount: function(info) {
								if(info.event.extendedProps.duration_of_service == 'break'){
									info.el.querySelector('.fc-event-title').innerHTML =
										'<div class="row">' +
										'<div class="col-12">' +
										 '<span class="float-left text-dark pt-1" style="font-size: 10px">'+info.event.extendedProps.duration+'' +
										'</span><span class="mr-1 float-right badge badge-outline badge-pill bg-white text-dark">'+info.event.extendedProps.status+'</span>'+
										'</div></div>';
								}else if(info.event.extendedProps.duration_of_service <= 10){
									info.el.querySelector('.fc-event-title').innerHTML =
										'<div class="row">' +
										'<div class="col-12 data-event" data-id="'+info.event.extendedProps.appointmentId+'">' +
										'<span class="float-left text-dark pt-1" style="font-size: 9px">'+info.event.title+'' +
										'</span></div></div>';
								}else if(info.event.extendedProps.duration_of_service <= 15){
									info.el.querySelector('.fc-event-title').innerHTML =
										'<div class="row">' +
										'<div class="col-12 data-event" data-id="'+info.event.extendedProps.appointmentId+'">' +
										'<span class="float-left text-dark pt-1" style="font-size: 12px">'+info.event.title+'' +
										'</span><span class="mr-1 float-right badge badge-outline badge-pill bg-white text-dark">'+info.event.extendedProps.status+'</span></div></div>'+
										'<span class="float-left text-dark pt-1" style="font-size: 9px">'+info.event.extendedProps.description+'</span>';
								}else if(info.event.extendedProps.duration_of_service <= 30){
									info.el.querySelector('.fc-event-title').innerHTML =
										'<div class="row">' +
										'<div class="col-12 data-event" data-id="'+info.event.extendedProps.appointmentId+'">' +
										'<span class="float-left text-dark pt-1" style="font-size: 12px">'+info.event.title+'' +
										'</span><span class="mr-1 float-right badge badge-outline badge-pill bg-white text-dark">'+info.event.extendedProps.status+'</span></div></div>'+
										'<span class="text-dark">'+info.event.extendedProps.description+'</span><br />'+
										'<span class="float-left text-dark pt-1" style="font-size: 9px">'+info.event.extendedProps.duration+'</span>';
								}else{
									info.el.querySelector('.fc-event-title').innerHTML =
										'<div class="row">' +
										'<div class="col-12 data-event" data-id="'+info.event.extendedProps.appointmentId+'">' +
										'<span class="float-left text-dark pt-1" style="font-size: 12px">'+info.event.title+'' +
										'</span><span class="mr-1 float-right badge badge-outline badge-pill bg-white text-dark">'+info.event.extendedProps.status+'</span></div></div>'+
										'<span class="text-dark">'+info.event.extendedProps.description+'</span></br />'+
										'<span class="float-left text-dark pt-1" style="font-size: 9px">'+info.event.extendedProps.duration+'</span>';
								}
                            },
                            events: [
									@foreach($employees as $emp)
										 @foreach($emp->EmpBreakSlot as $breakslot)
										@if($breakslot->everyday == 'on')	
										{
											@php
												$startTime = \Carbon\Carbon::parse($breakslot->start_time);
													$finishTime = \Carbon\Carbon::parse($breakslot->end_time);
													$duration_of_service  = $finishTime->diffInMinutes($startTime);
											@endphp
											resourceId:'{{ $breakslot->store_emp_id }}',
											title:'Break',
											startTime :'{{$breakslot->start_time}}',
											endTime:'{{$breakslot->end_time}}',
											className: " text-dark break employee employee-{{ $breakslot->store_emp_id }}",
											description: 'breaks',
											extendedProps: {

												status:'Pause',
												appointmentId:'{{$breakslot->id}}',
												duration:'{{date(Carbon\Carbon::parse($breakslot->start_time)->format('H:i'))}}-{{date(Carbon\Carbon::parse($breakslot->end_time)->format('H:i'))}}',
												description: 'sdas',
												 duration_of_service: 'break',
											},
										},
										@else
											{
												@php
													$startTime = \Carbon\Carbon::parse($breakslot->start_time);
														$finishTime = \Carbon\Carbon::parse($breakslot->end_time);
														$duration_of_service  = $finishTime->diffInMinutes($startTime);
												@endphp
												resourceId:'{{ $breakslot->store_emp_id }}',
												title:'Break',
												start :'{{ $breakslot->day}}T{{$breakslot->start_time}}',
												end:'{{ $breakslot->day}}T{{$breakslot->end_time}}',
												className: " text-dark break employee employee-{{ $breakslot->store_emp_id }}",
												description: 'breaks',
												extendedProps: {

													status:'Pause',
													appointmentId:'{{$breakslot->id}}',
													duration:'{{date(Carbon\Carbon::parse($breakslot->start_time)->format('H:i'))}}-{{date(Carbon\Carbon::parse($breakslot->end_time)->format('H:i'))}}',
													description: 'sdas',
													 duration_of_service: 'break',
												},
											},
												
											@endif
										 @endforeach
									@endforeach
                                    @foreach($appointments as $appointment)
                                        @foreach($appointment->appointmentDetail as $appointmentDetail)
                                {
									@php
										$startTime = \Carbon\Carbon::parse($appointmentDetail->appo_time);
										$finishTime = \Carbon\Carbon::parse($appointmentDetail->app_end_time);
										$duration_of_service  = $finishTime->diffInMinutes($startTime);
									@endphp
                                    resourceId:'{{ $appointmentDetail->store_emp_id }}',
                                    title:'{{ $appointment->first_name }} {{$appointment->last_name}}',
                                    start :'{{ $appointmentDetail->appo_date}}T{{$appointmentDetail->appo_time}}',
                                    end:'{{ $appointmentDetail->appo_date}}T{{$appointmentDetail->app_end_time}}',

                                    className: " text-dark {{$appointmentDetail->status}} employee employee-{{ $appointmentDetail->store_emp_id }}",
                                    description: '{{$appointmentDetail->service_name}}',
                                    extendedProps: {

                                        status:'@if($appointmentDetail->status=='running') aktiv @elseif($appointmentDetail->status=='cancel') Storniert @elseif($appointmentDetail->status=='completed') Erledigt @elseif($appointmentDetail->status=='booked') Neu @else {{$appointmentDetail->status}} @endif',
                                        appointmentId:'{{$appointmentDetail->id}}',
                                        duration:'{{date(Carbon\Carbon::parse($appointmentDetail->appo_time)->format('H:i'))}}-{{date(Carbon\Carbon::parse($appointmentDetail->app_end_time)->format('H:i'))}}',
                                        description: '{{$appointmentDetail->service_name}}',
										 duration_of_service: '{{$duration_of_service}}',
                                    },
                                },
                                    @endforeach
                                @endforeach
                            ],

                        });

                        calendar.render();
                    }
                };
            }();

            jQuery(document).ready(function() {
				KTCalendarBasic.init();
				if(defaultView  == "dayGridMonth"){
					var x = $('.fc-day-today').position().top;
					setTimeout(function(){
						$(".fc-scroller").animate({
							scrollTop: x // Scroll to this ID
						}, 'fast');
					}, 500); 
				}
				
				 setInterval(function(){   reloadCalendar();  }, 60000); 
               
                $('.fc-prev-button').addClass('day-event');
                $('.fc-next-button').addClass('day-event');
                removeAllDay();

            });
			
			function reloadCalendar() {
				var selectedBtn = $('.fc-button-active').text();
				localStorage.setItem('selectedView', selectedBtn);
				if($('#breakHoursModal').is(':visible')){
					
				}else{
					window.location.reload();
				}
            }
			
            function removeAllDay() {


            }


            $(document).on('click','.slick-arrow',function () {
                var ids=[];
                var tabShow='resourceTimeGridDay';
                if($('.fc-dayGridMonth-button').hasClass('fc-button-active'))
                {
                    tabShow='dayGridMonth';
					return false;
					
                }
                $('.employee').show();

                $('.slick-slide').removeClass('opacity');
                $('.slick-slide.slick-active').each(function (i,obj) {

                    ids[i]=$(obj).find('.slider-change').data('id');

                });

				var dat = $('.fc-toolbar-chunk .fc-toolbar-title').text();
				if (calendar) {
					calendar.destroy();
				}
				var resources = [];
				
				var events = [];

				let da=dat.replace(/[a-zA-Z]/g,'').replace('.',' ',2);

				var split=da.split(" – ");
				split[0]=split[0].replace('.',' ');
				var new_startDate = new Date(split[0].split(" ").reverse().join("-"));


				dat = moment(new_startDate).format('YYYY-MM-DD');
					
                let url='{{url('find-appointments')}}?ids='+ids+'&date='+dat;
                $.get(url,function (response) {

                    for (let j = 0; j <response.employees.length; j++) {
                        resources.push({id: response.employees[j].id, title: response.employees[j].emp_name, order:j});
                    }
					
					for (let r = 0; r < response.EmpBreakSlot.length; r++) {
						
                      let time_s =  response.EmpBreakSlot[r].start_time.split(":");

                      let time_e = response.EmpBreakSlot[r].end_time.split(":");
                        let status='break';
						if(response.EmpBreakSlot[r].everyday == 'on'){
							events.push({
								resourceId: response.EmpBreakSlot[r].store_emp_id,
								title: 'Break',
								startTime :response.EmpBreakSlot[r].start_time,
								endTime:response.EmpBreakSlot[r].end_time,
								className: ' text-dark break employee employee-'+response.EmpBreakSlot[r].store_emp_id,
								description: 'Break',
								extendedProps: {
									status: 'Pause',
									duration: time_s[0]+":"+ time_s[1]+ "-" +time_e[0]+":"+ time_e[1],
									appointmentId:response.EmpBreakSlot[r].id,
									description: 'Break',
									 duration_of_service: 'break',
								},

							});
						}else{
							events.push({
								resourceId: response.EmpBreakSlot[r].store_emp_id,
								title: 'Break',
								start: response.EmpBreakSlot[r].day + 'T' + response.EmpBreakSlot[r].start_time,
								end: response.EmpBreakSlot[r].day + 'T' + response.EmpBreakSlot[r].end_time,
								className: ' text-dark break employee employee-'+response.EmpBreakSlot[r].store_emp_id,
								description: 'Break',
								extendedProps: {
									status: 'Pause',
									duration: time_s[0]+":"+ time_s[1]+ "-" +time_e[0]+":"+ time_e[1],
									appointmentId:response.EmpBreakSlot[r].id,
									description: 'Break',
									 duration_of_service: 'break',
								},

							});
						}
					}

                    for (let k = 0; k < response.appointments.length; k++) {
						
                      let time_s =  response.appointments[k].appo_time.split(":");

                      let time_e = response.appointments[k].app_end_time.split(":");
                        let status=response.appointments[k].status;
                        if(response.appointments[k].status=='running')
                        {
                            status='aktiv';
                        }
                        else if(response.appointments[k].status=='cancel')
                        {
                            status='Storniert';
                        }
                        else if(response.appointments[k].status=='completed')
                        {
                            status='Erledigt';
                        }
                        else if(response.appointments[k].status=='booked')
                        {
                            status='Neu';
                        }else if(response.appointments[k].status=='reschedule')
                        {
                            status='Verschoben';
                        }

                        events.push({
                            resourceId: response.appointments[k].store_emp_id,
                            title: response.appointments[k].first_name + ' ' + response.appointments[k].last_name,
							allDay:true,
                            start: response.appointments[k].appo_date + 'T' + response.appointments[k].appo_time,
                            end: response.appointments[k].appo_date + 'T' + response.appointments[k].app_end_time,
                            className: ' text-dark ' + response.appointments[k].status+' employee employee-'+response.appointments[k].store_emp_id,
                            description: response.appointments[k].service_name,
                            extendedProps: {
                                status: status,
                                duration: time_s[0]+":"+ time_s[1]+ "-" +time_e[0]+":"+ time_e[1],
                                appointmentId:response.appointments[k].id,
                                description: response.appointments[k].service_name,
								 duration_of_service: response.appointments[k].duration_of_service,
                            },

                        });
					}
                       // jQuery(document).ready(function () {
						
                             var KTCalendarBasic = function() {

							return {
								//main function to initiate the module
								init: function() {

									var calendarEl = document.getElementById('kt_calendar');
									calendar = new FullCalendar.Calendar(calendarEl, {
										headerToolbar: {
															left: '',
															center: 'prev next title',
															right: 'resourceTimeGridDay,dayGridMonth'
														},
														buttonText:{
															month:    'Monat',
															day:      'Tag',
														},
														locale: 'de',
														titleFormat: 'DD.MM.YYYY',
														scrollTime: firstHour,
														nowIndicator: true,
														timezone: 'local',
														slotDuration: "00:10",
														firstDay: 1,
														allDaySlot: false,
														slotMinTime:'07:00:00',
														slotMaxTime:'24:00:00',
														views: {
															resourceTimeGridTwoDay: {
																type: 'resourceTimeGrid',
																duration: {days: 2},
																buttonText: '2 days',
															}
														},
														slotLabelFormat:
															{
																hour: 'numeric',
																minute: '2-digit',
																omitZeroMinute: false,
																hour12: false
															},
														initialView: tabShow,
														initialDate: dat,
														resourceOrder:'order',
														resources: resources,

														displayEventTime: false, // don't show the time column in list view

														height: 900,
														contentHeight: 880,
														aspectRatio: 3,  // see: https://fullcalendar.io/docs/aspectRatio
														editable: false,
														navLinks: false,



										// THIS KEY WON'T WORK IN PRODUCTION!!!
										// To make your own Google API key, follow the directions here:
										// http://fullcalendar.io/docs/google_calendar/
										googleCalendarApiKey: 'AIzaSyDcnW6WejpTOCffshGDDb4neIrXVUA1EAE',

										// eventRender: function(info) {
										//     var tooltip = new Tooltip(info.el, {
										//         title: info.event.extendedProps.description,
										//         placement: 'top',
										//         trigger: 'hover',
										//         container: 'body'
										//     });
										// },

										eventDidMount: function(info) {
											if(info.event.extendedProps.duration_of_service == 'break'){
												info.el.querySelector('.fc-event-title').innerHTML =
													'<div class="row">' +
													'<div class="col-12">' +
													 '<span class="float-left text-dark pt-1" style="font-size: 10px">'+info.event.extendedProps.duration+'' +
													'</span><span class="mr-1 float-right badge badge-outline badge-pill bg-white text-dark">'+info.event.extendedProps.status+'</span>'+
													'</div></div>';
											}else if(info.event.extendedProps.duration_of_service <= 10){
												info.el.querySelector('.fc-event-title').innerHTML =
													'<div class="row">' +
													'<div class="col-12 data-event" data-id="'+info.event.extendedProps.appointmentId+'">' +
													'<span class="float-left text-dark pt-1" style="font-size: 9px">'+info.event.title+'' +
													'</span></div></div>';
											}else if(info.event.extendedProps.duration_of_service <= 15){
												info.el.querySelector('.fc-event-title').innerHTML =
													'<div class="row">' +
													'<div class="col-12 data-event" data-id="'+info.event.extendedProps.appointmentId+'">' +
													'<span class="float-left text-dark pt-1" style="font-size: 12px">'+info.event.title+'' +
													'</span><span class="mr-1 float-right badge badge-outline badge-pill bg-white text-dark">'+info.event.extendedProps.status+'</span></div></div>'+
													'<span class="float-left text-dark pt-1" style="font-size: 9px">'+info.event.extendedProps.duration+'</span>';
											}else if(info.event.extendedProps.duration_of_service <= 30){
												info.el.querySelector('.fc-event-title').innerHTML =
													'<div class="row">' +
													'<div class="col-12 data-event" data-id="'+info.event.extendedProps.appointmentId+'">' +
													'<span class="float-left text-dark pt-1" style="font-size: 12px">'+info.event.title+'' +
													'</span><span class="mr-1 float-right badge badge-outline badge-pill bg-white text-dark">'+info.event.extendedProps.status+'</span></div></div>'+
													'<span class="text-dark">'+info.event.extendedProps.description+'</span><br />'+
													'<span class="float-left text-dark pt-1" style="font-size: 9px">'+info.event.extendedProps.duration+'</span>';
											}else{
												info.el.querySelector('.fc-event-title').innerHTML =
													'<div class="row">' +
													'<div class="col-12 data-event" data-id="'+info.event.extendedProps.appointmentId+'">' +
													'<span class="float-left text-dark pt-1" style="font-size: 12px">'+info.event.title+'' +
													'</span><span class="mr-1 float-right badge badge-outline badge-pill bg-white text-dark">'+info.event.extendedProps.status+'</span></div></div>'+
													'<span class="text-dark">'+info.event.extendedProps.description+'</span></br />'+
													'<span class="float-left text-dark pt-1" style="font-size: 9px">'+info.event.extendedProps.duration+'</span>';
											}
										},
										events: events,

									});

									calendar.render();
								}
							};
						}();



                            KTCalendarBasic.init();
                            $('.fc-prev-button').addClass('day-event');
                            $('.fc-next-button').addClass('day-event');
							//$('.fc-timegrid-slots').css('background-color', '#fc3e3e');
                            removeAllDay();

                       //});
                   
                });
            });




        });
		
    </script>

    <script>
        $(document).ready(function () {
            $(document).on('click','.fc-next-button',function () {
                if($('.fc-resourceTimeGridDay-button.fc-button.fc-button-primary').hasClass('fc-button-active'))
                {
                    var weekday=new Array(7);
                    weekday[0]="sunday";
                    weekday[1]="monday";
                    weekday[2]="tuesday";
                    weekday[3]="wednesday";
                    weekday[4]="thursday";
                    weekday[5]="friday";
                    weekday[6]="saturday";
                    let current = $('#selectedDat').val();
					
                    if(current==6)
                    {
                        var now=0;
                    }
                    else{
                        var now=parseInt(current)+1;
                    }
						
                    var n = weekday[now];
				
                    $('.working-time').each(function() {
                        let duration = $(this).data(n);
						
                        if(duration=='-')
                        {
                            $(this).text('OFF');
                        }
                        else{
                            $(this).text('Arbeitszeit '+duration);
                        }
                    });
                    removeAllDay();
                    $('#selectedDat').val(now);
                }
            });
            $(document).on('click','.fc-prev-button',function () {
                if($('.fc-resourceTimeGridDay-button.fc-button.fc-button-primary').hasClass('fc-button-active'))
                {
                    var weekday=new Array(7);
                    weekday[0]="sunday";
                    weekday[1]="monday";
                    weekday[2]="tuesday";
                    weekday[3]="wednesday";
                    weekday[4]="thursday";
                    weekday[5]="friday";
                    weekday[6]="saturday";

                    let current = $('#selectedDat').val();
                    if(current==0)
                    {
                        var now=6;
                    }
                    else{
                        var now=parseInt(current)-1;
                    }
                    var n = weekday[now];

                    $('.working-time').each(function() {
                        let duration = $(this).data(n);
                        if(duration=='-')
                        {
                            $(this).text('OFF');
                        }
                        else{
                            $(this).text('Arbeitszeit '+duration);
                        }
                    });
                    removeAllDay();
                    $('#selectedDat').val(now);
                }
            });
            $('.change-store').change(function () {
                let val=$(this).val();
                window.location.href="{{url('dienstleister/kalender')}}?id="+val;
            });
            function removeAllDay() {

            }
        });
    </script>


    <script>
        $(document).ready(function () {
            $('.center').slick({

                slidesToShow: 4,

                prevArrow:'<button class="prev"><i class="fc-icon fc-icon-chevron-left"></i></button>',
                nextArrow: '<button class="next"><i class="fc-icon fc-icon-chevron-right"></i></button>',
               infinite:false,
                responsive: [
                    {
                        breakpoint: 768,
                        settings: {
                            arrows: false,
                            centerMode: true,

                            slidesToShow: 1
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            arrows: false,
                            centerMode: true,

                            slidesToShow: 1
                        }
                    }
                ]
            });

            $(document).on('click','.slick-slide.slick-active',function () {
                if($('.fc-dayGridMonth-button').hasClass('fc-button-active'))
                {
                    $('.slick-slide').removeClass('shadow');
                    $('.slick-slide').addClass('opacity');
                    let id = $(this).find('img').data('id');
                    $(this).removeClass('opacity');
                    $('.employee').hide();
                    $('.employee-'+id).show();
                }
            });
			 $(document).on('click','.fc-dayGridMonth-button',function(){
				var x = $('.fc-day-today').position().top;
				setTimeout(function(){
					$(".fc-scroller").animate({
						scrollTop: x // Scroll to this ID
					}, 'fast');
				}, 500); 
			 });
            $(document).on('click','.fc-resourceTimeGridDay-button',function(){
				 let dated=$('.fc-toolbar-title').text();

                let curr='';
                dated=dated.split(' ');

                if(dated[1]=='Monday')
                {
                    curr=1;
                }
                else if(dated[1]=='Tuesday'){
                    curr=2;
                }
                else if(dated[1]=='Wednesday'){
                    curr=3;
                }
                else if(dated[1]=='Thursday'){
                    curr=4;
                }
                else if(dated[1]=='Friday'){
                    curr=5;
                }
                else if(dated[1]=='Saturday'){
                    curr=6;
                }
                else if(dated[1]=='Sunday'){
                    curr=0;
                }
                var split=$('.fc-toolbar-title').text().replace('.',' ');
                split=split.replace('.',' ');
                var new_startDate = new Date(split.split(" ").reverse().join("-")).getDay();


                // split = moment(new_startDate).format('YYYY-MM-DD');
                split = new_startDate;
                $('#selectedDat').val(split);

                var weekday=new Array(7);
                weekday[0]="sunday";
                weekday[1]="monday";
                weekday[2]="tuesday";
                weekday[3]="wednesday";
                weekday[4]="thursday";
                weekday[5]="friday";
                weekday[6]="saturday";
                var n = weekday[split];

                $('.working-time').each(function() {
                    let duration = $(this).data(n);
                    if(duration=='-')
                    {
                        $(this).text('OFF');
                    }
                    else{
                        $(this).text('Arbeitszeit '+duration);
                    }
                });
                $('.employee').show();
                $('.slick-slide').removeClass('opacity');
                removeAllDay()
            });


            function removeAllDay() {


            }


        });



    </script>
    <script>
        $(document).ready(function () {
            $(document).on('click','.employee',function () {

                    let id=$(this).find('.data-event').data('id');
                    let url='{{url('service-provider/appointment-detail/find')}}/'+id;
                    $.get(url,function (response) {
                       $('.modal-body').html(response);
                       $('#myModal').modal('show');
                    })

            });
			
			var todaydate = "{{\Carbon\Carbon::now()->format('d/m/Y')}}";
			$(document).on('click','.everydays',function (){
				var id  = $(this).data('id');
				if ($(this).prop('checked')==true){
					$('.break_day[data-id='+id+']').css('pointer-events','none');
					$('.break_day[data-id='+id+']').attr('readonly', true);
					$('.break_day[data-id='+id+']').val('');
					
				} else {
					$('.break_day[data-id='+id+']').css('pointer-events','all');
					$('.break_day[data-id='+id+']').attr('readonly', false);
					 $('.break_day[data-id='+id+']').val(todaydate);
					
				}
			});
			
			$(document).on('click', '.add_break_hours', function(){
				$('#breakHoursModal').modal('show');
			});
			
			$(document).on('submit', '#form_break_hours', function(e){
				e.preventDefault();
				data = $("#form_break_hours").serialize();
				
				$.ajax({
					type: 'POST',
					url: "{{URL::to('service-provider/add-break-hours')}}",
					data:data,
					success: function (response) {
						var selectedBtn = $('.fc-button-active').text();
						localStorage.setItem('selectedView', selectedBtn);
						window.location.reload();
					},
					error: function (error) {

					}
				});
			});
			
        });
		
    </script>

@endsection
