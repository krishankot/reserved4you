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
        .completed-label{
               border-color: #56C156 !important;
            color: #56C156;
            background: #fff;
        }
          .new-appointment-label{
               border-color: #5bc9ff !important;
            color: #5bc9ff;
            background: #fff;
        }
         .cancel-label{
               border-color: #d42e2e !important;
            color: #d42e2e;
            background: #fff;
        }
    </style>
@endsection
@section('service_content')

    <div class="main-content">
        <h2 class="page-title">Dashboard</h2>
        <div class="dashboard-main-wrap">
            <div class="dashboard-left-width">
                <select class="select store_category">
                    <option value=""
                            data-value="">Alle Stores
                    </option>
                    @foreach($getStore as $row)
                        @if(session('store_id') == $row->id)

                            <option value="{{$row->id}}"
                                    data-value="{{$row->store_address}}" selected>{{$row->store_name}}</option>
                        @else
                            <option value="{{$row->id}}"
                                    data-value="{{$row->store_address}}">{{$row->store_name}}</option>
                        @endif
                    @endforeach
                </select>
                <p class="str_address">{{session('address')}}</p>
                <div class="row dashboard-row">
                    <div class="col-lg-6">
                        <div class="dashboard-box yellow-box">
                        <span>
                            <img src="{{URL::to('storage/app/public/Serviceassets/images/icon/calendar.svg')}}" alt="">
                        </span>
                            <h5>{{number_format($activeAppointment)}}</h5>
                            <p>Aktive Buchungen </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="dashboard-box orange-box">
                        <span>
                            <img
                                src="{{URL::to('storage/app/public/Serviceassets/images/icon/pending-appointments.svg')}}"
                                alt="">
                        </span>
                            <h5>{{number_format($pendingAppointment)}}</h5>
                            <p>Bevorstehende Buchungen </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="dashboard-box green-box">
                        <span>
                            <img
                                src="{{URL::to('storage/app/public/Serviceassets/images/icon/completed-appointments.svg')}}"
                                alt="">
                        </span>
                            <h5>{{number_format($completedAppointment)}}</h5>
                            <p>Erledigte Buchungen </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="dashboard-box red-box">
                        <span>
                            <img
                                src="{{URL::to('storage/app/public/Serviceassets/images/icon/cancelled-appointments.svg')}}"
                                alt="">
                        </span>
                            <h5>{{number_format($canceledAppointment)}}</h5>
                            <p>Stornierte Buchungen </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="dashboard-box pink-box">
                        <span>
                            <img src="{{URL::to('storage/app/public/Serviceassets/images/icon/total-services.svg')}}"
                                 alt="">
                        </span>
                            <h5>{{number_format($totalService)}}</h5>
                            <p>Services</p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="dashboard-box purple-box">
                        <span>
                            <img src="{{URL::to('storage/app/public/Serviceassets/images/icon/total-employees.svg')}}"
                                 alt="">
                        </span>
                            <h5>{{number_format(count($totalEmp))}}</h5>
                            <p>Mitarbeiter </p>
                        </div>
                    </div>
                  
                    <div class="col-lg-6">
                        <div class="dashboard-box blue-box">
                        <span>
                            <img src="{{URL::to('storage/app/public/Serviceassets/images/icon/customer-reviews.svg')}}"
                                 alt="">
                        </span>
                            <h5>{{number_format($totalReview)}}</h5>
                            <p>Bewertungen </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="dashboard-box dblue-box">
                        <span>
                            <img src="{{URL::to('storage/app/public/Serviceassets/images/icon/total-customers.svg')}}"
                                 alt="">
                        </span>
                            <h5>{{number_format($totalCustomer)}}</h5>
                            <p>Kunden</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="dashboard-center-width">
                <div class="dashboard-center-header">
                    <h5>Heutige Termine </h5>
                    <div>
                        <label>Status</label>
                        <select class="select getAppo">
                            <option value="all">Alle</option>
                            <option value="booked">Neu</option>
                            <option value="running">Aktiv</option>
                            <option value="reschedule">Verschoben </option>
                            <option value="completed">Erledigt</option>
                            <option value="cancel">Storniert</option>
                        </select>
                    </div>
                </div>
                <ul class="timeline-ul">
                    @foreach($todayAppointment as $item =>$row)
                    <li rel="{{\Carbon\Carbon::parse($item)->format('H:i')}}" id="{{\Carbon\Carbon::parse($item)->format('Hi')}}">
                        <i>{{\Carbon\Carbon::parse($item)->format('H:i')}}</i>
                        @foreach($row as $value)
                        <div class="timeline-li-wrap" rel="{{$value->status}}">
                            <div class="timeline-profile-wrap">
                                <div class="timeline-profile-top-wrap">
                                    <div class="timeline-profile">
                                        @if(file_exists(storage_path('app/public/user/'.@$value->userDetails->profile_pic)) && @$value->userDetails->profile_pic != '')
                                            <img src="{{URL::to('storage/app/public/user/'.@$value->userDetails->profile_pic)}}"
                                                 class="rounded avatar-sm"
                                                 alt="user">
                                        @else
                                            <img class="rounded avatar-sm"
                                                 src="https://via.placeholder.com/150x150/00000/FABA5F?text={{strtoupper(substr(@$value->first_name, 0, 1))}}{{strtoupper(substr(@$value->last_name, 0, 1))}}"
                                                 alt="user">
                                        @endif
                                    </div>
                                    <div class="timeline-profile-info">
                                        @if($value->status == 'booked' || $value->status == 'pending')
                                            <span class="new-appointment-label"> {{$value->status == 'booked' ? 'Neu' : 'Steht aus'}}</span>
                                        @elseif($value->status == 'running' || $value->status == 'reschedule')
                                            <span class="running-label"> {{$value->status == 'running' ? 'Aktiv' : 'Verschoben'}}</span>
                                        @elseif($value->status == 'completed')
                                            <span class="completed-label"> Erledigt </span>
                                        @elseif($value->status == 'cancel')
                                            <span class="cancel-label"> Storniert </span>
                                        @endif

                                        <h6>{{@$value->first_name}} {{@$value->last_name}}</h6>
                                    </div>
                                    <div class="timeline-profile-price">
                                        <h6> <span>{{number_format($value->price,2,',','.')}}€</span></h6>
										 @if(!empty($value->payment_method))
											
											<p>{{ucfirst($value->payment_method == 'cash' ? 'vor Ort' : ((strtolower($value->payment_method) == 'stripe' && !empty($value->card_type))?$value->card_type:$value->payment_method))}}</p>
										@endif
                                    </div>
                                </div>
                                <div class="timeline-profile-bottom-wrap">
                                    <div>
                                        <p>Buchungs-ID: <span> #{{$value->order_id}}</span></p>
                                        <p>Uhrzeit : <span> {{\Carbon\Carbon::parse($value->appo_time)->format('H:i')}} - {{\Carbon\Carbon::parse($value->app_end_time)->format('H:i')}}</span></p>
                                    </div>
{{--                                    <a href="#" class="btn btn-complete">Complete?</a>--}}
                                </div>
                            </div>
                            <div class="accordion" id="accordionExample">
                                <div class="timeline-card">
                                    <a class="timeline-link" type="button" data-toggle="collapse"
                                       data-target="#collapse{{$value->id}}" aria-expanded="false" aria-controls="collapse{{$value->id}}">
                                       Gebuchter Service 
                                        <span class="arrow"><img
                                                src="{{URL::to('storage/app/public/Serviceassets/images/icon/down-arrow.svg')}}"
                                                alt=""></span>
                                    </a>
                                    <div id="collapse{{$value->id}}" class="collapse" aria-labelledby="heading{{$value->id}}"
                                         data-parent="#accordionExample">
                                        <div class="timeline-body ">
                                            <div class="timeline-heading-label">
                                            <span>

                                                <?php echo file_get_contents(URL::to('storage/app/public/category/'.@$value->categoryDetails->image)) ?>
                                            </span>
                                                <h6>{{$value->categoryDetails->name}}</h6>
												<a class="text-link btn-sm ml-auto" href="{{ url('dienstleister/buchung#'.$value->id) }}">Termin anzeigen</a>
{{--                                                <span class="timeline-time-box">23:52 mins</span>--}}
                                            </div>
                                            <div class="timeline-profile-label">
                                                <p>Mitarbeiter</p>
                                                <div>
                                                    <h6>{{$value->store_emp_id == '' ? 'Any Employee' : @$value->employeeDetails->emp_name}}</h6>
													@php
													$empnameArr = explode(" ", @$value->employeeDetails->emp_name);
													$empname = "";
													if(count($empnameArr) > 1){
														$empname = strtoupper(substr($empnameArr[0], 0, 1)).strtoupper(substr($empnameArr[1], 0, 1));
													}else{
														$empname = strtoupper(substr(@$value->employeeDetails->emp_name, 0, 2));
													}
												
												@endphp
                                                    <span>
                                                          @if(file_exists(storage_path('app/public/store/employee/'.@$value->employeeDetails->image)) && @$value->employeeDetails->image != '')
                                                            <img src="{{URL::to('storage/app/public/store/employee/'.@$value->employeeDetails->image)}}"
                                                                 alt=""
                                                            >
                                                        @else
                                                            <img src="https://via.placeholder.com/150x150/00000/FABA5F?text={{$empname}}" alt="employee">
                                                        @endif
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="timeline-body-info">
                                                <p>{{$value->subCategoryDetails->name}} - {{@$value->service_name}} - {{@$value->variantData->description}}</p>
                                            </div>
                                            <div class="timeline-footer-price">
                                                <p>{{@$value->variantData->duration_of_service}} {{__('Min') }}</p>
                                                <h6>{{number_format($value->price,2,',','.')}}€</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </li>
                    @endforeach
                </ul>
            </div>
            <div class="dashboard-right-width">
                <div class="index-earning-box">
                    <span><img src="{{URL::to('storage/app/public/Serviceassets/images/total-earning.svg')}}"
                               alt=""></span>
                    <h6>Heutige Einnahmen  : <strong> {{number_format($todayEarning, 2, ',', '.')}}€</strong></h6>
                </div>
                <div class="today-employee">
                <h6 class="index-employee">Mitarbeiter  <span> ({{count($totalEmp)}})</span></h6>
                <ul class="employee-listing">
                    @forelse($totalEmp as $row)
                        @if(@$row->time->is_off == 'off')
							@php
								$empnameArr = explode(" ", $row->emp_name);
								$empname = "";
								if(count($empnameArr) > 1){
									$empname = strtoupper(substr($empnameArr[0], 0, 1)).strtoupper(substr($empnameArr[1], 0, 1));
								}else{
									$empname = strtoupper(substr( $row->emp_name, 0, 2));
								}
							
							@endphp
                            <li>
                                <span>
                                    @if(file_exists(storage_path('app/public/store/employee/'.$row->image)) && $row->image != '')
                                        <img src="{{URL::to('storage/app/public/store/employee/'.$row->image)}}"
                                             alt=""
                                        >
                                    @else
                                        <img src="https://via.placeholder.com/150x150/00000/FABA5F?text={{$empname}}" alt="employee">
                                    @endif
                                </span>
                                <div>
                                    <h6>{{$row->emp_name}}</h6>
                                    @if(@$row->time->is_off == 'off')
                                        <p>Arbeitszeit<br>
                                            <span> ({{\Carbon\Carbon::parse(@$row->time->start_time)->translatedFormat('H:i')}} - {{\Carbon\Carbon::parse(@$row->time->end_time)->translatedFormat('H:i')}}) </span></p>
                                    @else
                                        <p>Today <br><span class="onleave"> On Leave </span></p>
                                    @endif
                                </div>
                            </li>
                        @endif
                    @empty
                        <div class="text-center">No Employee Found.</div>
                    @endforelse

                </ul>
                </div>
            </div>
        </div>
    </div>
@php $current_time = \Carbon\Carbon::now()->timezone('Europe/Berlin')->format('H:i'); @endphp
@endsection

@section('service_js')
    <script>
		/* if(localStorage.getItem('dashStatus')){
			getStatusAppointment(localStorage.getItem('dashStatus'));
			$('.getAppo').val(localStorage.getItem('dashStatus'));
		} */
		var currentTime = "{{ $current_time }}";
		var screenWidth = window.screen.width;
		var listItems = $(".timeline-ul li");
		
		listItems.each(function(idx, li) {
			var litime =li.attributes.rel.nodeValue;
			
			if(litime >=  currentTime || (idx === listItems.length - 1)){
				console.log(litime+'##'+currentTime);
				if(screenWidth > 1400){
					
					var len = $("div[rel='running']").length;
					if(len > 0){
						var x = $("div[rel='running']").offset().top;
					}else{
						var x = $("li[rel='"+litime+"']").offset().top;
					}
					
					 $('.timeline-ul').animate({
						scrollTop: x - $(".timeline-ul").offset().top
					}, 'fast');
				}else{
					 var len = $("div[rel='running']").length;
					if(len > 0){
						var y = $("div[rel='running']").offset().top;
					}else{
						var y = $("li[rel='"+litime+"']").offset().top;
					}
				
					$('html,body').animate({
						scrollTop: y
					}, 'fast');
				}
				return false;
			}
			
		});
        $(document).on('change','.getAppo',function (){
            var value = $(this).val();
			localStorage.setItem('dashStatus', value);
			getStatusAppointment(value);
        })

		function getStatusAppointment(value){
			 $.ajax({
                type: 'POST',
                url: baseurl + '/dashboard-appointment',
                data: {
                    _token: token,
                    shorting: value,
                },
                // beforesend: $('#loading').css('display', 'block'),
                success: function (response) {

                    $(".timeline-ul").html(response);
                    // $('#loading').css('display', 'none');
                },
                error: function (e) {

                }
            });
		}
		
        setInterval(function() {
                  window.location.reload();
                }, 60000);  

    </script>

@endsection
