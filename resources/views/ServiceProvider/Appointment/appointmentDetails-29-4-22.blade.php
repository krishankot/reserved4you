@forelse($appointment as $row)
    <div class="appointment-item completed-item">
        <div class="appointment-profile-wrap">
            <div class="appointment-profile-left">
                <div class="appointment-profile-img">
                    @if(file_exists(storage_path('app/public/user/'.@$row->userDetails->profile_pic)) && @$row->userDetails->profile_pic != '')
                        <img src="{{URL::to('storage/app/public/user/'.@$row->userDetails->profile_pic)}}"
                             class="rounded avatar-sm"
                             alt="user">
							 @php $image = URL::to('storage/app/public/user/'.@$row->userDetails->profile_pic); @endphp
                    @else
                        <img
                            src="https://via.placeholder.com/1080x1080/00000/FABA5F?text={{strtoupper(substr($row['first_name'], 0, 1))}}{{strtoupper(substr($row['last_name'], 0, 1))}}"
                            alt="user">
							@php $image = 'https://via.placeholder.com/1080x1080/00000/FABA5F?text='.strtoupper(substr($row['first_name'], 0, 1)).strtoupper(substr($row['last_name'], 0, 1)); @endphp
                    @endif
                </div>
                <div class="appointment-profile-info">
                    <h5>{{@$row->first_name}} {{@$row->last_name}}
						@if(!\BaseFunction::checkCustomerExists(@$row->email, @$row->store_id))
							@php $requestStatus = \BaseFunction::isCustomerRequested(@$row['store_id'], @$row['user_id']); @endphp
							@if($requestStatus == 'Requested')
								<a href="javascript:void(0);" class="text-warning disabled">Angefragt</a>
							@elseif($requestStatus == 'Rejected')
								<a href="javascript:void(0);" class="text-danger disabled">Abgelehnt</a>
							@else
								<a href="javascript:void(0);" class="text-info add_cust" data-customer="{{@$row['user_id']}}" data-id="{{@$row['store_id']}}">Kundenprofil anlegen ?</a>
							@endif
						@endif
					</h5>
                    <ul>
                        <li>
                            <p>Buchungs-ID: <span> #{{$row->order_id}}</span></p>
                        </li>
                        <li>
                            <p>Status:
                                @if($row->status == 'booked' || $row->status == 'pending')
                                    <span class="new-appointment-label"> {{$row->status == 'booked' ? 'Neu' : 'Steht aus'}}</span>
                                @elseif($row->status == 'running' || $row->status == 'reschedule')
                                    <span class="running-label"> {{$row->status == 'running' ? 'Aktiv' : 'Verschoben'}}</span>
                                @elseif($row->status == 'completed')
                                    <span class="completed-label"> Erledigt </span>
                                @elseif($row->status == 'cancel')
                                    <span class="cancel-label"> Storniert </span>
                                @endif
                            </p>
                        </li>
						
						@if($row->status == 'cancel')
							 <li>
								<a style="color: #DB8A8A;text-decoration: underline;"  href="javascript:void(0);" class="cancel_reason" data-image="{{$image}}"
								   data-booking="{{$row->order_id}}"
								   data-service="{{$row['service_name']}}"
								   data-cancelledby="{{$row['cancelled_by']}}"
								   data-storename="Customer"
								   data-description="{{@$row['variantData']['description']}}"
								   data-reason="{{$row['cancel_reason']}}">
									Stornierungsgrund
								</a>
							</li>
						@endif
                        @if(file_exists(storage_path('app/public/service/'.$row->image)) && $row->image != '')

                            <div
                                style="display: none">{{$imge = URL::to('storage/app/public/service/'.$row->image)}}</div>
                        @else
                            <div
                                style="display: none">{{$imge = URL::to('storage/app/public/default/default-user.png')}}</div>
                        @endif
                        @if(empty($row->is_reviewed))
                            @if($row->status == 'completed')
                                @if(!empty($row->review_requested))
									<li><a href="javascript:void(0);" class="btn btn-black btn-review-request disabled mt-0">Angefragt</a></li>
								@else
									<li><a href="javascript:void(0);" data-id="{{$row['id']}}" class="btn btn-black btn-review-request mt-0">Bewertungsanfrage senden</a></li>
								@endif
                            @endif
                        @else
                            <li class="review-see-wrap">
                                <p>
                                            <span><i
                                                    class="fas fa-star"></i></span> {{@$row->is_reviewed->total_avg_rating}}
                                </p>
                                <a href="{{ url('dienstleister/betriebsprofil?t=reviews#t'.@$row->is_reviewed->id) }}" class="btn see-review">Bewertung anzeigen</a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
            <div class="appointment-profile-right">
                <div class="app-payment-info-type">
                    <p>Zahlungsmethode  <i></i> <span>{{ucfirst($row->payment_method == 'cash' ? 'vor Ort' : ((strtolower($row->payment_method) == 'stripe' && !empty($row->card_type))?$row->card_type:$row->payment_method))}}</span></p>
                    <h6>Gesamtbetrag <span>{{number_format($row->price, 2, ',', '.')}}€</span></h6>
                </div>
                @if($row->status == 'booked' || $row->status == 'pending')
                    <a href="javascript:void(0)" class="btn btn-black-yellow postpond_app" data-id="{{@$row['id']}}">Verschieben</a>
                    
                @elseif($row->status == 'reschedule')
				{{--<a href="javascript:void(0)" class="btn btn-black-yellow postpond_app" data-id="{{@$row['id']}}">Verschieben</a>--}}
                    
                @elseif($row->status == 'completed' || $row->status == 'cancel')
                      <a href="javascript:void(0)" class="btn btn-black-yellow book_agian" 
                                    data-id="{{@$row['id']}}"
                                   >Erneut Buchen ?</a>
                @endif
                @if($row->status != 'cancel')
					<a href="javascript:void(0)" class="btn btn-yellow-black ask_cancel"
					   data-id="{{@$row['variantData']['id']}}"
					   data-order="{{$row['order_id']}}"
					   data-appointment="{{$row['appointment_id']}}"
					   data-image="{{$imge}}"
					   data-service="{{$row['service_name']}}"
					   data-description="{{@$row['variantData']['description']}}"
					>Stornieren?</a>
				@endif

            </div>
        </div>
        <div class="appointment-cato-wrap">
            <div class="appointment-cato-item">
                <span><?php echo file_get_contents(URL::to('storage/app/public/category/' . @$row->categoryDetails->image)) ?></span>
                <h6>{{$row->categoryDetails->name}}</h6>
            </div>
			@if($row->status != 'reschedule')
				<div class="appointment-cato-date">
					<h6>{{\Carbon\Carbon::parse($row->appo_date)->translatedFormat('d F, Y')}}
						({{\Carbon\Carbon::parse($row->appo_date)->translatedFormat('D')}})</h6>
					<span>{{\Carbon\Carbon::parse($row->appo_time)->translatedFormat('H:i')}} </span>
				</div>
			@endif
        </div>
        <div class="appointment-info-profile">
                    <span>
                         @if(file_exists(storage_path('app/public/store/employee/'.@$row->employeeDetails->image)) && @$row->employeeDetails->image != '')
                            <img src="{{URL::to('storage/app/public/store/employee/'.@$row->employeeDetails->image)}}"
                                 alt=""
                            >
						 @elseif($row->store_emp_id)
							@php
								$empname = "";
								if(!empty($row->employeeDetails->emp_name)){
									$empnameArr = explode(" ", $row->employeeDetails->emp_name);
									
									if(count($empnameArr) > 1){
										$empname = strtoupper(substr($empnameArr[0], 0, 1)).strtoupper(substr($empnameArr[1], 0, 1));
									}else{
										$empname = strtoupper(substr( $row->employeeDetails->emp_name, 0, 2));
									}
								}
							@endphp
							 <img src="https://via.placeholder.com/150x150/00000/FABA5F?text={{$empname}}" alt="employee">
                        @else
                            <img src="{{URL::to('storage/app/public/default/default-user.png')}}"
                                 alt=""
                            >
                        @endif
                    </span>
            <div>
                <p>Mitarbeiter</p>
                <h6>{{$row->store_emp_id == '' ? 'Any Employee' : @$row->employeeDetails->emp_name}}</h6>
            </div>
        </div>
        <div class="appointment-item-price-info">
            <h5>{{$row->subCategoryDetails->name}} - {{@$row->service_name}}</h5>
            <h6>{{@$row->variantData->description}} </h6>
            <p>{{@$row->variantData->duration_of_service}} {{__('Min') }} <strong>{{number_format($row->price, 2, ',', '.')}}€</strong></p>
        </div>
    </div>
@empty
@endforelse

