@extends('layouts.serviceProvider')
@section('service_title')
    Customer List
@endsection
@section('service_css')
	<style>
	.customer-image .owl-nav button{top:40%;font-size:24px;width:28px;height:28px;}
	.NoteModalInfo .owl-nav button{font-size:36px !important;}
	.NoteModalInfo .owl-nav button span{margin-right:0px;margin-top:-20px;}
	.customer-image .owl-nav button.owl-next{right:0px;}
	.customer-image .owl-nav button.owl-prev{left:0px;}
	.customer-image .owl-nav button span{margin-top:-5px;}
	.image-sq .item{width:100px;height:100px;}
	.tooltip-inner {
    max-width: 500px !important;
	
}
.carousel-inner {
   overflow: visible;
}
	</style>
@endsection
@section('service_content')
    <div class="main-content">
        <div class="page-title-div">
            <h2 class="page-title">Kunden</h2>
            <p><a href="{{URL::to('dienstleister/kunden')}}">Kunden</a> <span>/ Kundeninformationen </span></p>
        </div>
        <div class="cd-main-wrap">
            <div class="cd-main-profile">
                 @if($customer['is_appo'] != 'yes')
                @if(file_exists(storage_path('app/public/store/customer/'.@$customer['image'])) && @$customer['image'] != '')
                    <img src="{{URL::to('storage/app/public/store/customer/'.@$customer['image'])}}"
                         alt="user">
                @elseif(\BaseFunction::getUserDetailsByEmail(@$customer->email, 'user_image_path'))
					 <img src="{{\BaseFunction::getUserDetailsByEmail(@$customer->email, 'user_image_path')}}"
                         alt="user">
				@else
					@php
						$cusnameArr = explode(" ", $customer->name);
						$custname = "";
						if(count($cusnameArr) > 1){
							$custname = strtoupper(substr($cusnameArr[0], 0, 1)).strtoupper(substr($cusnameArr[1], 0, 1));
						}else{
							$custname = strtoupper(substr( $customer->name, 0, 2));
						}
					@endphp
                    <img
                        src="https://via.placeholder.com/1080x1080/00000/FABA5F?text={{$custname}}"
                        alt="user">
                @endif
                @else 
                 <img
                        src="https://via.placeholder.com/1080x1080/00000/FABA5F?text={{strtoupper(substr($customer['first_name'], 0, 1))}}{{strtoupper(substr($customer['last_name'], 0, 1))}}"
                        alt="user">
                @endif
            </div>
            <div class="cd-main-profile-info">
                <h4> @if($customer['is_appo'] == 'yes'){{$customer['first_name']}}  {{$customer['last_name']}}@else {{$customer['name']}} @endif</h4>
                <h6>{{@$customer['address']}}</h6>
                <ul>
                    <li>
                        <p>Telefon <a href="tel:{{@$customer['phone_number']}}">{{@$customer['phone_number']}}</a>
                        </p>
                    </li>
                    <li>
                        <p>E-Mail <a href="mailto:{{@$customer['email']}}">{{@$customer['email']}}</a></p>
                    </li>
                </ul>
            </div>
            <div class="cd-main-action-info">
                @if($customer['is_appo'] != 'yes')
                <a class="delete-icon" data-id="{{$customer['id']}}"  href="#"><img
                        src="{{URL::to('storage/app/public/Serviceassets/images/icon/delete-2.svg')}}" alt=""></a>
                        @endif
                <ul>
                    <li>
                        <p>Buchungen: <span> {{$customerData['total_booking']}}</span></p>
                    </li>
                    <li>
                        <p>Zahlungen: <span> {{number_format($customerData['total_payment'], 2, ',', '.')}}€</span></p>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row view-rows view-rows2">
            <div class="col-lg-12">
                <div class="bservices-heading-wrap">
                    <h5>Buchungen</h5>
                    <div>
                        {{--                        <label>Sort by</label>--}}
                        {{--                        <select class="select">--}}
                        {{--                            <option>Additional Notes</option>--}}
                        {{--                            <option>Additional Notes 2</option>--}}
                        {{--                            <option>Additional Notes 3</option>--}}
                        {{--                        </select>--}}
                    </div>
                </div>
                @foreach($appointment as $row)
                    <div class="appointment-item completed-appointment-item" rel="{{ ($row['id']) }}">
                        <div class="appointment-profile-wrap">
                            <div class="appointment-profile-left">
                                <div class="appointment-profile-img">
                                    @if(file_exists(storage_path('app/public/user/'.@$row->userDetails->profile_pic)) && @$row->userDetails->profile_pic != '')
                                        <img
                                            src="{{URL::to('storage/app/public/user/'.@$row->userDetails->profile_pic)}}"
                                            class="rounded avatar-sm"
                                            alt="user">
											@php $imageuser = URL::to('storage/app/public/user/'.@$row->userDetails->profile_pic); @endphp
                                    @else
                                        <img
                                            src="https://via.placeholder.com/1080x1080/00000/FABA5F?text={{strtoupper(substr($row['first_name'], 0, 1))}}{{strtoupper(substr($row['last_name'], 0, 1))}}"
                                            alt="user">
											@php $imageuser = 'https://via.placeholder.com/1080x1080/00000/FABA5F?text='.strtoupper(substr($row['first_name'], 0, 1)).strtoupper(substr($row['last_name'], 0, 1)); @endphp
                                    @endif
                                        @if(file_exists(storage_path('app/public/service/'.$row->image)) && $row->image != '')

                                            <div
                                                style="display: none">{{$imge = URL::to('storage/app/public/service/'.$row->image)}}</div>
                                        @else
                                            <div
                                                style="display: none">{{$imge = URL::to('storage/app/public/default/default-user.png')}}</div>
                                        @endif
                                </div>
                                <div class="appointment-profile-info">
                                    <h5>{{@$row->first_name}} {{@$row->last_name}}</h5>
                                    <ul class="appointment-d-block">
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
												<a style="color: #DB8A8A;text-decoration: underline;" href="javascript:void(0);" class="cancel_reason" data-image="{{$imageuser}}"
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
                                    </ul>
                                </div>
                            </div>
                            <div class="appointment-profile-right">
                                <div class="app-payment-info-type">
									 <p>Bezahlt mit  <i></i> <span>{{ucfirst($row->payment_method == 'cash' ? 'vor Ort' : ((strtolower($row->payment_method) == 'stripe' && !empty($row->card_type))?$row->card_type:$row->payment_method))}}</span></p>
									<h6>Gesamtbetrag <span>{{ number_format($row->price, 2, ',', '.') }}€</span></h6>
                                </div>
                                @if($row->status == 'booked' || $row->status == 'pending')
                                    <a href="javascript:void(0)" class="btn btn-black-yellow postpond_app" data-id="{{@$row['id']}}">Verschieben</a>
                                @elseif($row->status == 'reschedule')
								{{--<a href="javascript:void(0)" class="btn btn-black-yellow postpond_app" data-id="{{@$row['id']}}">Verschieben</a>--}}
                                   
                                @elseif($row->status == 'completed' || $row->status == 'cancel')
                                    <a href="#" class="btn btn-black-yellow book_agian" data-id="{{@$row['id']}}">Erneut Buchen ?</a>
                                @endif
								@if($row->status != 'cancel')
									 <a href="#" class="btn btn-yellow-black ask_cancel"
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
									<span>{{\Carbon\Carbon::parse($row->appo_time)->format('H:i')}} </span>
								</div>
							@endif
                        </div>
                        <div class="appointment-info-profile">
                    <span>
                          @if(file_exists(storage_path('app/public/store/employee/'.@$row->employeeDetails->image)) && @$row->employeeDetails->image != '')
                            <img src="{{URL::to('storage/app/public/store/employee/'.@$row->employeeDetails->image)}}"
                                 alt=""
                            >
						 @elseif($row->store_emp_id && !empty($row->employeeDetails->emp_name))
							@php
								$empnameArr = explode(" ", $row->employeeDetails->emp_name);
								$empname = "";
								if(count($empnameArr) > 1){
									$empname = strtoupper(substr($empnameArr[0], 0, 1)).strtoupper(substr($empnameArr[1], 0, 1));
								}else{
									$empname = strtoupper(substr( $row->employeeDetails->emp_name, 0, 2));
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
                                <p>Mitarbeiter </p>
                                <h6>{{$row->store_emp_id == '' ? 'Any Employee' : @$row->employeeDetails->emp_name}}</h6>
                            </div>
                            @if(!empty($row->note))
                                <div class="a-info-profile-action">
									@if(!empty($row->note_image))
										@php $notesimages = explode(",", $row->note_image); @endphp
											<div class="modal fade NoteModalInfo" id="NoteModalInfo" data-id="{{$row->id}}" tabindex="-1" role="dialog"
												 aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
												<div class="modal-dialog modal-dialog-centered" role="document">
													<div class="modal-content">
														<div class="modal-body">
															<div class="owl-carousel owl-theme">
																@foreach($notesimages as $notesimage)
																	 @if($notesimage != "" && file_exists('storage/app/public/store/customernotes/'.$notesimage))
																			<div class="item" ><img src="{{asset('storage/app/public/store/customernotes/'.$notesimage)}}"></div>
																	 @endif
																@endforeach
															</div>
															<p class="mt-1">{{$row->note}}</p>
														</div>
													</div>
												</div>
											</div>
                                    <a href="javascript:void(0)" class="info-action" data-id="{{$row->id}}"><img
                                            src="{{URL::to('storage/app/public/Serviceassets/images/icon/info.svg')}}"
                                            alt=""></a>
									@else
										 <a href="javascript:void(0)" class="info-action" data-toggle="tooltip" data-placement="left"
                                       title="{{$row->note}}"><img
                                            src="{{URL::to('storage/app/public/Serviceassets/images/icon/info.svg')}}"
                                            alt=""></a>
									@endif
                                    <a href="javascript:void(0)" class="edit-action edit_note" data-id="{{$row->id}}"><img
                                            src="{{URL::to('storage/app/public/Serviceassets/images/icon/edit-2.svg')}}"
                                            alt=""></a>
                                </div>
                            @else
                                <a href="javascript:void(0)" class="btn btn-add-note create_note" data-id="{{$row->id}}">+ Notiz</a>
                            @endif
                        </div>
                        <div class="appointment-item-info border-0 mb-0">
                            <h5>{{$row->subCategoryDetails->name}} - {{@$row->service_name}}</h5>
                            <h6>{{@$row->variantData->description}} </h6>
                            <p>{{@$row->variantData->duration_of_service}} {{__('Min') }} <strong>{{ number_format($row->price, 2, ',', '.') }}€</strong></p>
                        </div>
                    </div>
                    @if(empty($row->note))
                        <div class="modal fade AddNoteModal" id="" data-id="{{$row->id}}" tabindex="-1" role="dialog"
                             aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        {{Form::open(array('url'=>'service-provider/customer/add-note','method'=>'post','files'=>true,'name'=>'add_note'))}}
                                        <div class="appointment-item note-appointment-item">
                                            <div class="appointment-profile-wrap">
                                                <div class="appointment-profile-left">
                                                    <div class="appointment-profile-img">
                                                        @if(file_exists(storage_path('app/public/user/'.@$row->userDetails->profile_pic)) && @$row->userDetails->profile_pic != '')
                                                            <img
                                                                src="{{URL::to('storage/app/public/user/'.@$row->userDetails->profile_pic)}}"
                                                                class="rounded avatar-sm"
                                                                alt="user">
																@php $image = URL::to('storage/app/public/user/'.@$row->userDetails->profile_pic); @endphp
                                                        @else
                                                           
																@php $image = 'https://via.placeholder.com/1080x1080/00000/FABA5F?text='.strtoupper(substr($row['first_name'], 0, 1)).strtoupper(substr($row['last_name'], 0, 1)); @endphp
															 <img
                                                                src="{{$image}}"
                                                                class="rounded avatar-sm"
                                                                alt="user">
													  @endif
                                                    </div>
                                                    <div class="appointment-profile-info">
                                                        <h5>{{@$row->first_name}} {{@$row->last_name}}</h5>
                                                        <ul class="appointment-d-block">
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
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="appointment-profile-right">
                                                    <div class="app-payment-info-type mr-0">
                                                        <p>Bezahlt mit <i></i>
                                                            <span>{{ucfirst($row->payment_method == 'cash' ? 'vor Ort' : ((strtolower($row->payment_method) == 'stripe' && !empty($row->card_type))?$row->card_type:$row->payment_method))}}</span></p>
                                                        <h6>Gesamtbetrag <span>{{ number_format($row->price, 2, ',', '.') }}€</span></h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="appointment-cato-wrap">
                                                <div class="appointment-cato-item">
                                                    <span><?php echo file_get_contents(URL::to('storage/app/public/category/' . @$row->categoryDetails->image)) ?></span>
                                                    <h6>{{$row->categoryDetails->name}}</h6>
                                                </div>
                                                <div class="appointment-cato-date">
                                                    <h6>{{\Carbon\Carbon::parse($row->appo_date)->translatedFormat('d F, Y')}}
                                                        ({{\Carbon\Carbon::parse($row->appo_date)->translatedFormat('D')}})</h6>
                                                    <span>{{\Carbon\Carbon::parse($row->appo_time)->format('H:i')}} </span>
                                                </div>
                                            </div>
                                            <div class="appointment-info-profile">
                                                    <span>
                                                         @if(file_exists(storage_path('app/public/store/employee/'.@$row->employeeDetails->image)) && @$row->employeeDetails->image != '')
                                                            <img
                                                                src="{{URL::to('storage/app/public/store/employee/'.@$row->employeeDetails->image)}}"
                                                                alt=""
                                                            >
                                                        @else
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
                                                        @endif
                                                    </span>
                                                <div>
                                                    <p>Mitarbeiter </p>
                                                    <h6>{{$row->store_emp_id == '' ? 'Any Employee' : @$row->employeeDetails->emp_name}}</h6>
                                                </div>
                                            </div>
                                            <div class="appointment-item-info border-0 mb-0">
                                                <h5>{{$row->subCategoryDetails->name}} - {{@$row->service_name}}</h5>
                                                <h6>{{@$row->variantData->description}} </h6>
                                            </div>
                                        </div>
                                        <div class="notes-textarea">
                                            <h4>Notiz</h4>
											<div class="image-box">
												<div class="customer-image image-sq">
													<div id="add_owl_carousel" class="owl-carousel owl-theme">
														<div class="item"><img id="output" src="{{URL::to('storage/app/public/Serviceassets/images/default-profile.jpg')}}"></div>
													</div>
												</div>
												<label for="imgUpload">
													<input id="imgUpload" name="image[]" type="file" accept="image/*" multiple onchange="loadFile(event)">
													<span class="btn btn-yellow btn-photo">Datei wählen</span>
												</label>
											</div>
                                            <textarea placeholder="Zusätzliche Informationen hinzufügen ..."
                                                      name="note" required></textarea>
                                            <input type="hidden" name="app_id" value="{{$row->id}}">
                                        </div>
                                        <dvi class="notes-btn-wrap">
                                            <button class="btn btn-black-yellow" type="submit">Posten</button>
                                            <a href="#" class="btn btn-border-yellow close_modal"
                                               data-id="{{$row->id}}">Schließen</a>
                                        </dvi>
                                        {{Form::close()}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if(!empty($row->note))
                        <div class="modal fade EditNoteModal" id="" data-id="{{$row->id}}" tabindex="-1" role="dialog"
                             aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        {{Form::open(array('url'=>'service-provider/customer/update-note','method'=>'post','files'=>true,'name'=>'add_note'))}}
                                        <div class="appointment-item note-appointment-item">
                                            <div class="appointment-profile-wrap">
                                                <div class="appointment-profile-left">
                                                    <div class="appointment-profile-img">
                                                        @if(file_exists(storage_path('app/public/user/'.@$row->userDetails->profile_pic)) && @$row->userDetails->profile_pic != '')
                                                            <img
                                                                src="{{URL::to('storage/app/public/user/'.@$row->userDetails->profile_pic)}}"
                                                                class="rounded avatar-sm"
                                                                alt="user">
                                                        @else
															<img
															src="https://via.placeholder.com/1080x1080/00000/FABA5F?text={{strtoupper(substr(@$row->first_name, 0, 1))}}{{strtoupper(substr($row->last_name, 0, 1))}}"
															alt="user">
                                                        @endif
                                                    </div>
                                                    <div class="appointment-profile-info">
                                                        <h5>{{@$row->first_name}} {{@$row->last_name}}</h5>
                                                        <ul class="appointment-d-block">
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
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="appointment-profile-right">
                                                    <div class="app-payment-info-type mr-0">
                                                        <p>Bezahlt mit <i></i>
                                                            <span>{{ucfirst($row->payment_method)}}</span></p>
                                                        <h6>Gesamtbetrag <span>{{number_format($row->price, 2, ',', '.')}}€</span></h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="appointment-cato-wrap">
                                                <div class="appointment-cato-item">
                                                    <span><?php echo file_get_contents(URL::to('storage/app/public/category/' . @$row->categoryDetails->image)) ?></span>
                                                    <h6>{{$row->categoryDetails->name}}</h6>
                                                </div>
                                                <div class="appointment-cato-date">
                                                    <h6>{{\Carbon\Carbon::parse($row->appo_date)->translatedFormat('d F, Y')}}
                                                        ({{\Carbon\Carbon::parse($row->appo_date)->translatedFormat('D')}})</h6>
                                                    <span>{{\Carbon\Carbon::parse($row->appo_time)->format('H:i')}} </span>
                                                </div>
                                            </div>
                                            <div class="appointment-info-profile">
                                                    <span>
                                                         @if(file_exists(storage_path('app/public/store/employee/'.@$row->employeeDetails->image)) && @$row->employeeDetails->image != '')
                                                            <img
                                                                src="{{URL::to('storage/app/public/store/employee/'.@$row->employeeDetails->image)}}"
                                                                alt=""
                                                            >
                                                        @else
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
                                                        @endif
                                                    </span>
                                                <div>
                                                    <p>Mitarbeiter </p>
                                                    <h6>{{$row->store_emp_id == '' ? 'Any Employee' : @$row->employeeDetails->emp_name}}</h6>
                                                </div>
                                            </div>
                                            <div class="appointment-item-info border-0 mb-0">
                                                <h5>{{$row->subCategoryDetails->name}} - {{@$row->service_name}}</h5>
                                                <h6>{{@$row->variantData->description}} </h6>
                                            </div>
                                        </div>
                                        <div class="notes-textarea">
                                            <h4>Notiz</h4>
											<div class="image-box">
												<div class="customer-image image-sq">
													<div id="edit_owl_carousel" class="owl-carousel owl-theme">
														@if(!empty($row->note_image))
															@php $noteimages = explode(",", $row->note_image); @endphp 
															@foreach($noteimages as $noteimage)
																@if(!empty( $noteimage) && file_exists('storage/app/public/store/customernotes/'. $noteimage))
																	<div class="item"><img id="output_edit" src="{{URL::to('storage/app/public/store/customernotes/'. $noteimage)}}"></div>
																@endif
															@endforeach
														@else
															<div class="item"><img id="output_edit" src="{{URL::to('storage/app/public/Serviceassets/images/default-profile.jpg')}}"></div>
														@endif
													</div>
												</div>
												<label for="imgUploadEdit">
													<input id="imgUploadEdit" name="image[]" type="file" multiple accept="image/*" onchange="loadFileEdit(event)">
													<span class="btn btn-yellow btn-photo">Ändern</span>
												</label>
											</div>
                                            <textarea placeholder="Zusätzliche Informationen hinzufügen ..."
                                                      name="note" required>{{$row->note}}</textarea>
                                            <input type="hidden" name="app_id" value="{{$row->id}}">
                                        </div>
                                        <dvi class="notes-btn-wrap">
                                            <button class="btn btn-black-yellow" type="submit">bearbeiten</button>
                                            <a href="#" class="btn btn-border-yellow close_edit_modal"
                                               data-id="{{$row->id}}">Schließen</a>
                                        </dvi>
                                        {{Form::close()}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach

            </div>
            <div class="col-lg-4">
                {{--                <div class="bservices-heading-wrap">--}}
                {{--                    <h5>Work Portfolio</h5>--}}
                {{--                </div>--}}
                {{--                <div class="field">--}}
                {{--                    <input type="file" id="files" name="files[]" multiple/>--}}
                {{--                    <div class="files-upload-box">--}}
                {{--                        <img src="./assets/images/icon/pulse.svg" alt="">--}}
                {{--                        <h6>Add New Photo</h6>--}}
                {{--                    </div>--}}
                {{--                </div>--}}
            </div>
        </div>
    </div>
    <div id="cancel_appointment" class="modal modal-top fade calendar-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
                {{Form::open(array('url'=>'service-provider/cancel-appointment','method'=>'post','name'=>'cancel_appointmnet'))}}
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
                            <h5> Buchung stornieren, weil …</h5>
                            {{Form::hidden('variant_id','',array('class'=>'variant_cancel'))}}
                            {{Form::hidden('appointment_id','',array('class'=>'appointment_cancel'))}}
                            <textarea class="textarea-area" name="cancel_reason" required></textarea>

                            <button type="submit" class="btn btn-black btn-block btn-yes"> Ja, stornieren</button>
                            {{--                            <a href="#" data-dismiss="modal">Close</a>--}}
                        </div>
                    </div>
                </div>
                {{Form::close()}}
            </div>
        </div>
    </div>

    <!-- deleteProfilemodal -->
    <div class="modal fade" id="deleteProfilemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="delete-profile-box">
                        <h4>Bestätigung</h4>
                        <p>Sind Sie sicher, dass Sie diesen Mitarbeiter endgültig löschen möchten ? </p>
                    </div>
                    <div class="notes-btn-wrap">
                        {{Form::open(array('url'=>'service-provider/delete-customer','name'=>'delete-customer','method'=>'post'))}}
                        {{Form::hidden('id','',array('class'=>'delete_id'))}}
                        <button type="submit"  class="btn btn-black-yellow"> Ja, löschen?</button>
                        <a href="#" class="btn btn-gray" data-dismiss="modal" >Nein, zurück</a>
                        {{Form::close()}}
                    </div>
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
                                <h6>Booking ID: <span class="b_id">#R4U49258</span></h6>
                                <h4 class="b_service_name">Ladies - Balayage & Blow Dry</h4>
                                <h5 class="b_service_descirption">Balayage</h5>
                            </div>
                        </div>
                        <div class="detail-wrap-box-info">
                            <h5 id="whom">Booking has been cancelled because of</h5>
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
	
@endsection
@section('service_js')
    <script>
		if(localStorage.getItem('walletapid')){
			var walletapid = localStorage.getItem('walletapid');
			var y = $(".appointment-item[rel='"+walletapid+"']").offset().top;
			$('html,body').animate({
				scrollTop: y
			}, 'fast');
			localStorage.removeItem('walletapid');
		}
		 $(document).on('mouseover', '.info-action', function () {
			 var id = $(this).data('id');
            $('.NoteModalInfo[data-id=' + id + ']').modal('toggle');
		});
		$('.owl-carousel').owlCarousel({
			loop:true,
			nav:true,
			items:1
		})
		
		var loadFile = function (event) {
			if (event.target.files) {
				var filesAmount = event.target.files.length;
				for (var i=0; i<$('.item').length; i++) {
				   $("#add_owl_carousel").trigger('remove.owl.carousel', [i]).trigger('refresh.owl.carousel');
				}
				for (i = 0; i < filesAmount; i++) {
					var reader = new FileReader();
					reader.onload = function(event2) {
					   $('#add_owl_carousel').trigger('add.owl.carousel', ['<div class="item"><img id="output" src="'+event2.target.result+'"></div>']).trigger('refresh.owl.carousel');
					}
					reader.readAsDataURL(event.target.files[i]);
				}
			}
		};
		/*  var loadFile = function (event) {
            var reader = new FileReader();
            reader.onload = function () {
                var output = document.getElementById('output');
                output.src = reader.result;
				 $('.owl-carousel').trigger('add.owl.carousel', ['<div class="item"><p><img id="output" src="'+reader.result+'"></p></div>']).trigger('refresh.owl.carousel');
            };
            reader.readAsDataURL(event.target.files[0]);
			reader.readAsDataURL(event.target.files[1]);
			reader.readAsDataURL(event.target.files[2]);
			reader.readAsDataURL(event.target.files[3]);
			
			
        };  */
		
		/* var loadFileEdit = function (event) {
            var reader = new FileReader();
            reader.onload = function () {
                var output = document.getElementById('output_edit');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }; */
		var loadFileEdit = function (event) {
			if (event.target.files) {
				var filesAmount = event.target.files.length;
				for (var i=0; i<$('.item').length; i++) {
				   $("#edit_owl_carousel").trigger('remove.owl.carousel', [i]).trigger('refresh.owl.carousel');
				}
				for (i = 0; i < filesAmount; i++) {
					var reader = new FileReader();
					reader.onload = function(event2) {
					   $('#edit_owl_carousel').trigger('add.owl.carousel', ['<div class="item"><img id="output" src="'+event2.target.result+'"></div>']).trigger('refresh.owl.carousel');
					}
					reader.readAsDataURL(event.target.files[i]);
				}
			}
		};
        $(function () {
            //$('[data-toggle="tooltip"]').tooltip()
			$('[data-toggle="tooltip"]').tooltip({
				animated: 'fade',
				placement: 'left',
				container: 'body',
				html: true
			});
        })

        $(document).on('click', '.create_note', function () {
            var id = $(this).data('id');
            $('.AddNoteModal[data-id=' + id + ']').modal('toggle');
        });

        $(document).on('click', '.close_modal', function () {
            var id = $(this).data('id');
            $('.AddNoteModal[data-id=' + id + ']').modal('toggle');
        });


        $(document).on('click', '.edit_note', function () {
            var id = $(this).data('id');
            $('.EditNoteModal[data-id=' + id + ']').modal('toggle');
        });

        $(document).on('click', '.close_edit_modal', function () {
            var id = $(this).data('id');
            $('.EditNoteModal[data-id=' + id + ']').modal('toggle');
        });

        $(document).ready(function () {
            if (window.File && window.FileList && window.FileReader) {
                $("#files").on("change", function (e) {
                    var files = e.target.files,
                        filesLength = files.length;
                    for (var i = 0; i < filesLength; i++) {
                        var f = files[i]
                        var fileReader = new FileReader();
                        fileReader.onload = (function (e) {
                            var file = e.target;
                            $("<span class=\"pip\">" +
                                "<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
                                "<br/><span class=\"remove\"></span>" +
                                "</span>").insertAfter("#files");
                            $(".remove").click(function () {
                                $(this).parent(".pip").remove();
                            });

                        });
                        fileReader.readAsDataURL(f);
                    }
                    console.log(files);
                });
            } else {
                alert("Your browser doesn't support to File API")
            }
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

            $('.variant_cancel').val(id);
            $('.b_ids').text('#' + order);
            $('.b_service_names').text(service);
            $('.b_service_descirptions').text(description);
            $('.appointment_cancel').val(appointment_cancel);
            $('.simages img').attr('src', image);
            $('#cancel_appointment').modal('toggle');
        });

        $(document).on('click','.delete-icon',function (){
            var id = $(this).data('id');
            $('.delete_id').val(id);
            $('#deleteProfilemodal').modal('toggle');
        })

        $(document).on('click', '.book_agian', function () {
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
		
		$(document).on('click', '.postpond_app', function () {
            var id = $(this).data('id');
			swal({
				title: false,
				text: "Möchten Sie eine Anfrage schicken, um den Termin zu verschieben ?",
				type: "warning",
				buttons: {
					confirm:  'Ja !',
					cancel: 'Nein !'
				},
				dangerMode: true,
				buttonsStyling: false
			}).then((value) => {
				if(value){
					$.ajax({
						type: 'POST',
						async: true,
						dataType: "json",
						url: baseurl + '/postpond-appointment',
						data: {
							_token: token,
							id: id,
						},
						beforesend: $('#loading').css('display', 'block'),
						success: function (response) {
							var status = response.status;
							$('#loading').css('display', 'none')
							if (status == 'true') {
							   window.location.href = "{!! URL::current() !!}";
							} else {

							}
						},
						error: function (e) {

						}
					});
				}
			});
        });
		
    </script>
@endsection
