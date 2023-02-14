@extends('layouts.adminrequest')

@section('request_content')
<section class="contactdetail">
    <div class="progress">
        <div class="progress-bar progressbarr4u" role="progressbar" style="width: 10%;" aria-valuenow="25"
             aria-valuemin="0" aria-valuemax="100"></div>
    </div>
    <div class="container">
        <div class="contactheading">
            <h2>{{ __('About') }}</h2>
        </div>
       
		{{Form::model($dataRequest, array('url'=>'request-form/s1','method'=>'post','name'=>'myform', 'class'=>'disabled', 'files'=>'true', 'onsubmit' => "return validate();"))}}
            @csrf
            <div class="filldetail">
                <div class="row">
                    <div class="col-lg-6">
						<div class="form-group">
							<label class="iconlabel">
								<div class="d-flex align-items-center">
									<img src="{{ asset('storage/app/public/asset_request/images/icons/SVG/metro-shop.svg') }}" alt="">
									<span>{{ __('Shop name') }}*</span>
								</div>
							</label>
							{{Form::text('store_name',NULL,array('class'=>'storname contact disabled','autocomplete'=>'off', 'disabled', 'placeholder'=>__('Shop name')))}}
							<span id="storename"  class="text-danger"></span>
						</div>
                    </div>
                    <div class="col-lg-6">
						<div class="form-group">
							<label class="iconlabel">
								<div class="d-flex align-items-center">
									<img src="{{ asset('storage/app/public/asset_request/images/icons/SVG/awesome-phone.svg') }}" alt="">
									<span>{{ __('Phone Number') }}*</span>
								</div>
							</label>
							<div class="mobile-number">
								<img src="{{asset('storage/app/public/asset_request/images/germany-flag.png')}}" alt="">
								<!-- <span>+49</span> -->
								<input type="mobile" disabled name="store_contact_number" value="{{!empty($dataRequest['store_contact_number'])?$dataRequest['store_contact_number']:NULL}}" autocomplete="off" class="mail contact" placeholder="{{ __('Phone Number') }}">
							</div>
							<span id="phone" class="text-danger"></span>
						</div>
                    </div>
                    <div class="col-lg-6">
						<div class="form-group">
							<label class="iconlabel">
								<div class="d-flex align-items-center">
									<img src="{{ asset('storage/app/public/asset_request/images/icons/SVG/awesome-address-book.svg') }}" alt="">
									<span>{{ __('Address') }}*</span>
								</div>
							</label>
							{{Form::text('store_address',NULL,array('disabled', 'class'=>'house_number contact','autocomplete'=>'off','placeholder'=>__('Address')))}}
							<div id="postal_code"></div>
							<div id="map_canvas"></div>
							<span id="address_error" class="text-danger"></span>
						</div>
                    </div>
                    <div class="col-lg-6">
						<div class="form-group">
							<label class="iconlabel">
								<div class="d-flex align-items-center">
									<img src="{{ asset('storage/app/public/asset_request/images/icons/SVG/awesome-link.svg') }}" alt="">
									<span>{{ __('Website Link') }}</span>
								</div>
							</label>
							<input type="text" disabled name="store_link_id" value="{{!empty($dataRequest['store_link_id'])?$dataRequest['store_link_id']:NULL}}"  placeholder="{{ __('Website Link') }}" autocomplete="off" class="mail contact">
							<span id="error_store_link_id"  class="text-danger"></span>
						</div>
                    </div>
					<div class="col-lg-12">
						<div class="form-group">
							<label class="iconlabel">
								<div class="d-flex align-items-center">
									<img src="{{ asset('storage/app/public/asset_request/images/icons/SVG/open-document.svg') }}" alt="">
									<span>{{ __('Description') }}</span>
									<small>
										{{ __('Description could also be implemented from your website') }}<br />
										{{ __('If yes, please add your website link') }}
									</small>
								</div>
							</label>
							<textarea rows="6" name="store_description" disabled placeholder="{{ __('Description') }}">{{!empty($dataRequest['store_description'])?$dataRequest['store_description']:NULL}}</textarea>
						</div>
                    </div>
				</div>
				<div class="row">
					<div class="col-12">
						<div class="form-group mb-2 mt-2">
							<label class="iconlabel">
								<div class="d-flex align-items-center">
									<img src="{{ asset('storage/app/public/asset_request/images/icons/SVG/Group7.svg') }}" alt="">
									<span>{{ __('Select Category') }}*</span>
									
								</div>
							</label>
							<span id="category_error" class="text-danger"></span>
						</div>
					</div>
				</div>
				<div class="form-group-check">
					<div class="row">
						@foreach($categoriesArr as $val)
							<div class="col-lg-4">
								<div class="inputGroup">
									<input disabled id="{{$val->name}}" class="checkbox cat_select" <?php echo !empty($dataRequest['store_category']) && in_array($val->id, $dataRequest['store_category'])?'checked':''; ?> name="store_category[]" value="{{$val->id}}" type="checkbox"/>
									<label for="{{$val->name}}">
										<div class="icon_check">
											
											<img src="{{asset('storage/app/public/asset_request/images/icons/category/category' . $val->id.'.svg')}}" alt="">
										</div>
										<p>{{$val->name}}</p>
									</label>
								</div>
							</div>
						@endforeach
					</div>
					
				</div>
					<div class="row">
						<div class="col-lg-12">
							<div class="form-group">
								
								 <div class="edit-basic-detail edit-languages-detail">
									<label class="iconlabel">
										<div class="d-flex align-items-center">
											<img src="{{ asset('storage/app/public/asset_request/images/icons/SVG/material-featured-play-list.svg') }}" alt="">
											<span>{{ __('Features of the store') }}* ({{ __('multiple selection') }})</span>
										</div>
									</label>
									<span id="feature_error" class="text-danger"></span>
									<div class="select-arrows">
										{{Form::select('feature_of_the_store[]', $features,NULL,array('class'=>'select2', 'disabled', 'id'=>'feature_of_the_store','multiple'=>'multiple'))}}
										<i class="fas fa-angle-down"></i>
									</div>
								</div>
								
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-12">
							<div class="form-group">
								<label class="iconlabel">
									<div class="d-flex align-items-center">
										<img src="{{ asset('storage/app/public/asset_request/images/icons/SVG/metro-blocked.svg') }}" alt="">
										<span>{{ __('Cancellation period') }}</span>
									</div>
								</label>
							</div>
						</div>
					</div>
					<div class="form-group">
						<ul class="checklists">
							<li>
								<div class="custom-control custom-checkbox">
									{{ Form::radio('cancellation_period', "48h", NULL, array("class"=>"custom-control-input checkmark", "id"=>"c48h")) }}
									<label class="custom-control-label" for="c48h"><span>48h</span></label>
								</div>
							</li>
							<li>
								<div class="custom-control custom-checkbox">
									{{ Form::radio('cancellation_period', "24h", NULL, array("class"=>"custom-control-input checkmark", "id"=>"c24h")) }}
									<label class="custom-control-label" for="c24h"><span>24h</span></label>
								</div>
							</li>
							<li>
								<div class="custom-control custom-checkbox">
									{{ Form::radio('cancellation_period', "12h", NULL, array("class"=>"custom-control-input checkmark", "id"=>"c12h")) }}
									<label class="custom-control-label" for="c12h"><span>12h</span></label>
								</div>
							</li>
							<li>
								<div class="custom-control custom-checkbox">
									{{ Form::radio('cancellation_period', "none", NULL, array("class"=>"custom-control-input checkmark", "id"=>"cnone")) }}
									<label class="custom-control-label" for="cnone"><span>{{__('none') }}</span></label>
								</div>
							</li>
						</ul>
					</div>
					
					<div class="row">
						<div class="col-lg-12">
							<div class="form-group">
								<label class="iconlabel">
									<div class="d-flex align-items-center">
										<img src="{{ asset('storage/app/public/asset_request/images/icons/SVG/ionic-ios-wallet.svg') }}" alt="">
										<span>{{ __('Payment methods on site') }}* ({{ __('multiple selection') }})</span>
									</div>
								</label>
							</div>
						</div>
					</div>
					<div class="form-group">
						<ul class="checklists">
							<li>
								<div class="custom-control custom-checkbox">
									{{ Form::checkbox('payment_method[]', __('Cash on delivery'), (!empty($dataRequest['payment_method']) && (in_array(__('Cash on delivery'), $dataRequest['payment_method']) OR in_array('Cash on delivery', $dataRequest['payment_method'])))?true:false, array("class"=>"custom-control-input checkmark paymentmethod", "id"=>"COD")) }}
									<label class="custom-control-label" for="COD"><span>{{ __('Cash on delivery') }}</span></label>
								</div>
							</li>
							<li>
								<div class="custom-control custom-checkbox">
									{{ Form::checkbox('payment_method[]', __('Online payments'), (!empty($dataRequest['payment_method']) && (in_array(__('Online payments'), $dataRequest['payment_method']) OR in_array('Online payments',$dataRequest['payment_method'])))?true:false, array("class"=>"custom-control-input checkmark paymentmethod", "id"=>"Online")) }}
									<label class="custom-control-label" for="Online"><span>{{ __('Online payments') }}</span></label>
								</div>
							</li>
						</ul>
						<span id="paymentmethod_error" class="text-danger"></span>
					</div>
					<div class="row">
						<div class="col-12">
							<div class="form-group">
								<div class="edit-basic-detail-main">
									<div class="edit-basic-detail mb-0">
										<div class="store-date-head-wrap">
											<h4 class="text-center mb-4 mt-4">{{ __('Opening Hours') }}*</h4>
										</div>
										<div class="hours-tabel-main">
											<div class="hours-tabel-head-wrap">
												<h6>{{ __('Days') }}</h6>
												<h6 class="text-center">{{ __('Timeline') }}</h6>
												<h6>{{ __('Holiday') }}</h6>
											</div>
											@if(!empty($dataRequest['request_store_timing']))
												@foreach($dataRequest['request_store_timing'] as $key => $day)
													<div class="hours-tabel-body-wrap">
														<p>{{$day['day']}}</p>
														<div class="hours-time-wrap">
															<input type="text" value="{{!empty($day['start_time'])?$day['start_time']:NULL}}" class="timepicker start_time" name="start_time[]" placeholder=" -- --" data-id="{{$day['day']}}">
															<span>{{ __('to') }}</span>
															<input type="text" class="timepicker end_time" value="{{!empty($day['end_time'])?$day['end_time']:NULL}}" name="end_time[]" placeholder=" -- --" data-id="{{$day['day']}}">
														</div>
													   
														<label>
															<input type="checkbox" <?php echo !empty($day['is_off']) && $day['is_off'] == 'on'?'checked':'' ?> name="weekDays[]" data-id="{{$day['day']}}" class="weekdays" id="{{$day['day']}}-check">
															<span><i class="fas fa-check"></i></span>
														</label>
													</div>
												@endforeach
											@else
												<div class="hours-tabel-body-wrap">
													<p>Montag</p>
													<div class="hours-time-wrap">
														{{Form::hidden('day[]','Montag')}}
														<input type="text" class="timepicker start_time" name="start_time[]" placeholder=" -- --" data-id="Monday">
														<span>{{ __('to') }}</span>
														<input type="text" class="timepicker end_time" name="end_time[]" placeholder=" -- --" data-id="Monday">
													</div>
												   
													<label>
														<input type="checkbox" name="weekDays[]" data-id="Monday" class="weekdays" id="monday-check">
														<span><i class="fas fa-check"></i></span>
													</label>
												</div>
												<div class="hours-tabel-body-wrap">
													<p>Dienstag</p>
													<div class="hours-time-wrap">
														{{Form::hidden('day[]','Dienstag')}}
														<input type="text" class="timepicker start_time" name="start_time[]" placeholder=" -- --" data-id="Tuesday">
														<span>{{ __('to') }}</span>
														<input type="text" class="timepicker end_time" name="end_time[]" placeholder=" -- --" data-id="Tuesday">
													</div>
												   
													<label>
														<input type="checkbox" name="weekDays[]" data-id="Tuesday" class="weekdays" id="tuesday-check" >
														<span><i class="fas fa-check"></i></span>
													</label>
												</div>
												<div class="hours-tabel-body-wrap  ">
													<p>Mittwoch</p>
													<div class="hours-time-wrap">
														{{Form::hidden('day[]','Mittwoch')}}
														<input type="text" class="timepicker start_time" name="start_time[]" placeholder=" -- --" data-id="Wednesday">
														<span>{{ __('to') }}</span>
														<input type="text" class="timepicker end_time" name="end_time[]" placeholder=" -- --" data-id="Wednesday">
													</div>
												   
													<label>
														<input type="checkbox" name="weekDays[]" id="wednesday-check" class="weekdays" data-id="Wednesday" >
														<span><i class="fas fa-check"></i></span>
													</label>
												</div>
												<div class="hours-tabel-body-wrap">
													<p>Donnerstag</p>
													<div class="hours-time-wrap">
														{{Form::hidden('day[]','Donnerstag')}}
														<input type="text" class="timepicker start_time" name="start_time[]" placeholder=" -- --" data-id="Thursday">
														<span>{{ __('to') }}</span>
														<input type="text" class="timepicker end_time" name="end_time[]" placeholder=" -- --" data-id="Thursday">
													</div>
												   
													<label>
														<input type="checkbox" name="weekDays[]" id="thursday-check" class="weekdays" data-id="Thursday" >
														<span><i class="fas fa-check"></i></span>
													</label>
												</div>
												<div class="hours-tabel-body-wrap ">
													<p>Freitag</p>
													<div class="hours-time-wrap">
														{{Form::hidden('day[]','Freitag')}}
														<input type="text" class="timepicker start_time" name="start_time[]" placeholder=" -- --" data-id="Friday">
														<span>{{ __('to') }}</span>
														<input type="text" class="timepicker end_time" name="end_time[]" placeholder=" -- --" data-id="Friday">
													</div>
													
													<label>
														<input type="checkbox" name="weekDays[]" id="friday-check" class="weekdays" data-id="Friday">
														<span><i class="fas fa-check"></i></span>
													</label>
												</div>
												<div class="hours-tabel-body-wrap  ">
													<p>Samstag</p>
													<div class="hours-time-wrap">
														{{Form::hidden('day[]','Samstag')}}
														<input type="text" class="timepicker start_time" name="start_time[]" placeholder=" -- --" data-id="Saturday">
														<span>{{ __('to') }}</span>
														<input type="text" class="timepicker end_time" name="end_time[]" placeholder=" -- --" data-id="Saturday">
													</div>
												  
													<label>
														<input type="checkbox" name="weekDays[]" data-id="Saturday" class="weekdays" id="saturday-check" >
														<span><i class="fas fa-check"></i></span>
													</label>
												</div>
												<div class="hours-tabel-body-wrap  ">
													<p>Sonntag</p>
													<div class="hours-time-wrap">
														{{Form::hidden('day[]','Sonntag')}}
														<input type="text" class="timepicker start_time" name="start_time[]" placeholder=" -- --" data-id="Sunday">
														<span>{{ __('to') }}</span>
														<input type="text" class="timepicker end_time" name="end_time[]" placeholder=" -- --" data-id="Sunday">
													</div>
													
													<label>
														<input type="checkbox" name="weekDays[]" id="sunday-check" class="weekdays" data-id="Sunday">
														<span><i class="fas fa-check"></i></span>
													</label>
												</div>
											@endif
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-12">
							<div class="form-group">
								<div class="d-flex align-items-center justify-content-between position-relative">
									<p>&nbsp;</p>
									<h5 class="sechead">{{ __('Advantages') }}</h5>
								</div>
							</div>
						</div>
						
						@if(!empty($dataRequest['advantage_data']))
							<div class="col-lg-12">
								<div class="form-group">
									<label class="iconlabel">
										<div class="d-flex align-items-center">
											<img src="{{ asset('storage/app/public/asset_request/images/icons/SVG/simple-microsoftexcel.svg') }}" alt="">
											<span>{{ __('Upload a table from excel with advantages data') }}</span>
										</div>
									</label>
									 <div class="field">
										<div class="files-upload-box">
											<a class="downloadlink" href="{{ route('admin_download', array($dataRequest['advantage_data'], 'req_cust_data')) }}">{{__('Download') }}</a>
										</div>
									</div>
									<span id="xlx_adv_datafile">{{ !empty($dataRequest['advantage_data'])?$dataRequest['advantage_data']:NULL}}</span>
								</div>
							</div>
						@endif
					</div>
					<div id="advantages">
						@if(!empty($dataRequest['advantages']))
							@foreach($dataRequest['advantages'] as $i=> $adv)
								@include('Admin/RequestForm/advantages', ['i' => $i])
							@endforeach
						@endif
					</div>
					
				<div class="row">
					<div class="col-12">
						<div class="form-group">
							<h5 class="sechead">{{ __('Public transport') }}</h5>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="form-group">
							<label class="iconlabel">
								<div class="d-flex align-items-center">
									<img src="{{ asset('storage/app/public/asset_request/images/icons/SVG/awesome-stop-circle.svg') }}" alt="">
									<span>{{ __('Next stop') }}</span>
								</div>
							</label>
							{{Form::text('next_stop',NULL,array('class'=>'storname contact','autocomplete'=>'off','placeholder'=>__('Next stop')))}}
							<span id="next_stop" class="text-danger"></span>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="form-group">
							<label class="iconlabel">
								<div class="d-flex align-items-center">
									<img src="{{ asset('storage/app/public/asset_request/images/icons/SVG/ionic-ios-bus.svg') }}" alt="">
									<span>{{ __('Bus or train line') }}</span>
								</div>
							</label>
							{{Form::text('bus_or_train_line',NULL,array('class'=>'storname contact','autocomplete'=>'off','placeholder'=>__('Bus or train line')))}}
							<span id="bus_or_train_line" class="text-danger"></span>
						</div>
					</div>
				</div>
				
				
				<div class="row">
					<div class="col-12">
						<div class="form-group">
							<h5 class="sechead">{{ __('Customer') }}</h5>
						</div>
					</div>
					@if(!empty($dataRequest['customer_data']))
						<div class="col-lg-12">
							<div class="form-group">
								<label class="iconlabel">
									<div class="d-flex align-items-center">
										<img src="{{ asset('storage/app/public/asset_request/images/icons/SVG/simple-microsoftexcel.svg') }}" alt="">
										<span>{{ __('Upload a table from excel with customer data') }}</span>
									</div>
								</label>
								 <div class="field">
									<div class="files-upload-box">
										<a class="downloadlink" href="{{ route('admin_download', array($dataRequest['customer_data'], 'req_cust_data')) }}">{{__('Download') }}</a>
									</div>
								</div>
								<span id="xlx_cust_datafile">{{ !empty($dataRequest['customer_data'])?$dataRequest['customer_data']:NULL}}</span>
							</div>
						</div>
					@endif
				
					<div class="col-lg-12">
						<div class="form-group">
							<label class="iconlabel">
								<div class="d-flex align-items-center">
									<img src="{{ asset('storage/app/public/asset_request/images/icons/SVG/metro-profile.svg') }}" alt="">
									<span>{{ __('Profile Image') }}</span>
								</div>
							</label>
							<div class="image-box" rel="imgUpload" id="image_drop_area">
								<div class="customer-image">
									<img id="image_imgUpload" src="{{ asset('storage/app/public/asset_request/images/icons/PNG/Group30.png') }}">
								</div>
								<label id="file_name" for="imgUpload" class="d-flex align-items-center" >
									<p class="ml-20 mr-5">{{-- Drag & Drop the image file or --}}</p>
									@if(!empty($dataRequest['customer_image_name']))
										<a  href="{{ route('admin_download', array($dataRequest['customer_image_name'], 'requestFormTemp')) }}" class="btn btn-pink btn-photo ml-5">
											{{__('Download') }}
										</a>
									@endif
								</label>
							</div>
						</div>
					</div>
				</div>
				
				<div class="row">
                    <div class="col-lg-6">
						<div class="form-group">
							<label class="iconlabel">
								<div class="d-flex align-items-center">
									<img src="{{ asset('storage/app/public/asset_request/images/icons/SVG/open-person.svg') }}" alt="">
									<span>{{ __('Name') }}*</span>
								</div>
							</label>
							{{Form::text('customer_name',NULL,array('class'=>'storname contact','autocomplete'=>'off','placeholder'=>__('Name')))}}
							<span id="customer_name" class="text-danger"></span>
						</div>
                    </div>
					 <div class="col-lg-6">
						<div class="form-group">
							<label class="iconlabel">
								<div class="d-flex align-items-center">
									<img src="{{ asset('storage/app/public/asset_request/images/icons/SVG/awesome-address-book.svg') }}" alt="">
									<span>{{ __('Address') }}</span>
								</div>
							</label>
							{{Form::text('cust_address',NULL,array('class'=>'house_number contact','autocomplete'=>'off','id'=>'cus_address','placeholder'=>__('Address')))}}
							<div id="cus_postal_code"></div>
							<div id="cus_map_canvas"></div>
							<span id="cus_addr" class="text-danger"></span>
						</div>
                    </div>
                    
                    <div class="col-lg-6">
						<div class="form-group">
							<label class="iconlabel">
								<div class="d-flex align-items-center">
									<img src="{{ asset('storage/app/public/asset_request/images/icons/SVG/zocial-email.svg') }}" alt="">
									<span>{{ __('Email') }}*</span>
								</div>
							</label>
							<input type="email" name="customer_email" value="{{!empty($dataRequest['customer_email'])?$dataRequest['customer_email']:NULL}}" placeholder="{{ __('Email') }}" autocomplete="off" class="mail contact">
							<span id="customer_email" class="text-danger"></span>
						</div>
                    </div>
                    <div class="col-lg-6">
						<div class="form-group">
							<label class="iconlabel">
								<div class="d-flex align-items-center">
									<img src="{{ asset('storage/app/public/asset_request/images/icons/SVG/awesome-map-marked-alt.svg') }}" alt="">
									<span>{{ __('Country') }}</span>
								</div>
							</label>
							{{Form::select('customer_country',$countries,NULL,array('class'=>'select select-time'))}}
						</div>
                    </div>
					 <div class="col-lg-6">
						<div class="form-group">
							<label class="iconlabel">
								<div class="d-flex align-items-center">
									<img src="{{ asset('storage/app/public/asset_request/images/icons/SVG/awesome-phone.svg') }}" alt="">
									<span>{{ __('Phone Number') }}</span>
								</div>
							</label>
							<div class="mobile-number">
								<img src="{{asset('storage/app/public/asset_request/images/germany-flag.png')}}" alt="">
								<!-- <span>+49</span> -->
								<input type="mobile" name="customer_phone" value="{{!empty($dataRequest['customer_phone'])?$dataRequest['customer_phone']:NULL}}"  autocomplete="off" class="mail contact" placeholder="{{ __('Phone Number') }}">
								<span class="text-danger"></span>
							</div>
						</div>
                    </div>
					
					<div class="col-lg-6">
						<div class="form-group">
							<label class="iconlabel">
								<div class="d-flex align-items-center">
									<img src="{{ asset('storage/app/public/asset_request/images/icons/SVG/map-post-box.svg') }}" alt="">
									<span>{{ __('Postal Code') }}</span>
								</div>
							</label>
							{{Form::text('postal_code',NULL,array('class'=>'lname contact', 'placeholder'=>__('Postal Code'), 'autocomplete'=>'off'))}}
							<span class="text-danger"></span>
						</div>
                    </div>
				</div>
				
				<div class="row">
					<div class="col-12">
						<div class="form-group">
							<label class="iconlabel w-100">
								<div class="d-flex align-items-center justify-content-between position-relative">
									<p>&nbsp;</p>
									<h5 class="sechead">{{ __('Employees') }}*</h5>
								</div>
							</label>
						</div>
					</div>
					@if(!empty($dataRequest['employee_data']))
						<div class="col-lg-12">
							<div class="form-group">
								<label class="iconlabel">
									<div class="d-flex align-items-center">
										<img src="{{ asset('storage/app/public/asset_request/images/icons/SVG/simple-microsoftexcel.svg') }}" alt="">
										<span>{{ __('Upload a table from excel with employee data') }}</span>
									</div>
								</label>
								 <div class="field">
									<div class="files-upload-box">
										<a class="downloadlink" href="{{ route('admin_download', array($dataRequest['employee_data'], 'req_cust_data')) }}">{{__('Download') }}</a>
									</div>
								</div>
								<span id="xlx_emp_datafile">{{ !empty($dataRequest['employee_data'])?$dataRequest['employee_data']:NULL}}</span>
							</div>
						</div>
					@endif
				</div>
				
				<div class="accordion" id="accordionExample">
					@if(!empty($dataRequest['employees']))
						@foreach($dataRequest['employees'] as $k=>$item)
							@include('Admin/RequestForm/employees', ['i' =>$k, 'category' => $category, 'languages' => $languages, 'countries' => $countries])
						@endforeach
					@endif
				</div>
            </div>
            <div class="letscountinuesbtn">
                <a class="letscontinues" href="{{route('admin_request_step2', $slug)}}">{{ __('Continue') }}</a>
            </div>
		{{Form::close()}}
    </div>
</section>
 
<script>
@if(!empty($dataRequest['customer_image_name']))
	var imagename = "{{ $dataRequest['customer_image_name'] }}";
	$('#image_imgUpload').attr('src', "{{ asset('storage/app/public/requestFormTemp') }}/"+imagename);
@endif
@if(!empty($dataRequest['employees']))
	@foreach($dataRequest['employees'] as $k=>$item)
		var id = "{{ $k }}";
		@if(!empty($item['imagename']))
			var imagename = "{{ $item['imagename'] }}";
			$('#image_imgUpload'+id).attr('src', "{{ asset('storage/app/public/requestFormTemp') }}/"+imagename);
		@endif
	@endforeach
@endif
	
$('.collapse').on('shown.bs.collapse', function () {
	 $(this).prev().find('.fas').removeClass("fa-caret-right").addClass("fa-caret-down");
});

$('.collapse').on('hidden.bs.collapse', function () {
	 $(this).prev().find('.fas').removeClass("fa-caret-down").addClass("fa-caret-right");
});

</script>
@endsection
