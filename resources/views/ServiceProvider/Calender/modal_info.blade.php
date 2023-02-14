<div class="row">
    <div class="col-12 p-0">
        <div class="appointment-item completed-item mb-0 p-0">
            <div class="appointment-profile-wrap py-4 px-3 mb-0 {{$appointmentDetail->status}}">
                <div class="appointment-profile-left mb-0">
                    <div class="appointment-profile-img">
					
                        @if(file_exists(storage_path('app/public/user/'.@$row->userDetails->profile_pic)) && @$row->userDetails->profile_pic != '')
                            <img src="{{URL::to('storage/app/public/user/'.@$row->userDetails->profile_pic)}}"
                                 class="rounded avatar-sm"
                                 alt="user">
                        @else
                            <img
                                src="https://via.placeholder.com/1080x1080/00000/FABA5F?text={{strtoupper(substr($row['first_name'], 0, 1))}}{{strtoupper(substr($row['last_name'], 0, 1))}}"
                                alt="user">
                        @endif
                    </div>
					@php
						$cust_exist =  false;
						if(!empty($row->email)){
							$cust_exist =  \BaseFunction::checkCustomerExists($row->email, $row->store_id);
						}
					@endphp
                    <div class="appointment-profile-info " style="width: 60%">
                        <h5 class="mb-1" >{{@$row->first_name}} {{@$row->last_name}} &nbsp;&nbsp;&nbsp;<span>@if($cust_exist)<a href="{{url('service-provider/appointment/detail',$row->id)}}">Profil anzeigen</a>@endif </span></h5>
                        <p  class="mb-1" >Buchungs-ID: <span> #{{$row->order_id}}</span></p>
                        <p  class="mb-1" >Uhrzeit: <span>{{date(Carbon\Carbon::parse($appointmentDetail->appo_time)->format('H:i'))}}-{{date(Carbon\Carbon::parse($appointmentDetail->app_end_time)->format('H:i'))}}</span>  </p>

                    </div>
                    <div class="text-right" style="width: 30%">
                         <p class="mb-1" >
							@if(!empty($appointmentDetail->payment_method) && strtolower($appointmentDetail->payment_method) == 'cash')
								Zahlungsmethode: vor Ort
							@elseif(!empty($appointmentDetail->payment_method) && strtolower($appointmentDetail->payment_method) == 'stripe' && !empty($appointmentDetail->card_type))
								Zahlungsmethode: {{ $appointmentDetail->card_type }}
							@elseif(!empty($appointmentDetail->payment_method))
								Zahlungsmethode: {{ ucfirst($appointmentDetail->payment_method) }}
							@else
								Zahlungsmethode vor Ort
							@endif
						</p>
                        <h5 class="mb-1" >Gesamt {{number_format($appointmentDetail->price,2,',','.')}}€</h5>
                        <span class="{{$appointmentDetail->status}} mb-1">
                            <span class="badge badge-outline badge-pill bg-white text-dark py-1 text-capitalize {{$appointmentDetail->status}}-border">
                                @if($appointmentDetail->status=='running') aktiv
                                @elseif($appointmentDetail->status=='cancel') Storniert
                                @elseif($appointmentDetail->status=='completed') Erledigt
                                @elseif($appointmentDetail->status=='booked') Neu
								@elseif($appointmentDetail->status=='reschedule') Verschoben
                                @else {{$appointmentDetail->status}} @endif
                            </span>
                        </span>
                    </div>
                </div>

            </div>
            <div class="appointment-cato-wrap mt-2">
                <div class="appointment-cato-item">
                    <span>
                        <img src="{{asset(URL::to('storage/app/public/category/' . @$appointmentDetail->categoryDetails->image))}}"></span>
                    <h6>{{$appointmentDetail->categoryDetails->name}}</h6>
                </div>
				<a class="text-link btn-sm" onclick="closeModal();" href="{{ url('dienstleister/buchung#'.$appointmentDetail->id) }}">Termin anzeigen</a>
                <div class="appointment-cato-date " style="background: none!important;">
                    <h6>{{\Carbon\Carbon::parse($appointmentDetail->appo_date)->translatedFormat('d F, Y')}}
                        ({{\Carbon\Carbon::parse($appointmentDetail->appo_date)->translatedFormat('D')}})</h6>
                    <span class="bg-white text-dark">{{\Carbon\Carbon::parse($appointmentDetail->appo_time)->format('H:i')}} </span>
                </div>
            </div>

            <div class="appointment-info-profile">
                    <span>
                         @if(file_exists(storage_path('app/public/store/employee/'.@$appointmentDetail->employeeDetails->image)) && @$appointmentDetail->employeeDetails->image != '')
                            <img src="{{URL::to('storage/app/public/store/employee/'.@$appointmentDetail->employeeDetails->image)}}"
                                 alt=""
                            >
						@elseif($appointmentDetail->store_emp_id)
												@php
												$empname = "";
												if(!empty($appointmentDetail->employeeDetails->emp_name)){
													$empnameArr = explode(" ", $appointmentDetail->employeeDetails->emp_name);
													
													if(count($empnameArr) > 1){
														$empname = strtoupper(substr($empnameArr[0], 0, 1)).strtoupper(substr($empnameArr[1], 0, 1));
													}else{
														$empname = strtoupper(substr( $appointmentDetail->employeeDetails->emp_name, 0, 2));
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
                    <p>Mitarbeiter/-in</p>
                    <h6>{{$appointmentDetail->store_emp_id == '' ? 'Any Employee' : @$appointmentDetail->employeeDetails->emp_name}}</h6>
                </div>
            </div>
            <div class="appointment-item-price-info">
                <h5>{{$appointmentDetail->subCategoryDetails->name}} - {{@$appointmentDetail->service_name}}</h5>
                <h6>{{@$appointmentDetail->variantData->description}} </h6>
                <p>{{@$appointmentDetail->variantData->duration_of_service}} {{__('Min') }} <strong>{{number_format($appointmentDetail->price, 2, ',', '.')}}€</strong></p>
            </div>
        </div>
    </div>
</div>
<script>
	function closeModal(){
		$('.modal').modal('hide');
	}
</script>
