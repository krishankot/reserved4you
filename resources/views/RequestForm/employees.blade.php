<div class="card" id="employee_div{{ $i }}">
	<div class="card-header" id="heading{{$i}}">
		<h2 class="mb-0">
			<button class="d-flex align-items-center justify-content-between btn btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapse{{$i}}" aria-expanded="false" aria-controls="collapse{{$i}}">
				<div class="d-flex align-items-center">
				{{ __('Employee') }} {{$i}}
				<a class="btn btn-remove-icon d-flex align-items-center remove_employees ml-5" rel="{{ $i }}" href="javascript:void(0);"><span><i class="fa fa-times"></span></i>&nbsp;{{ __('Delete') }}</a>
				</div>
				<span>
					@if($i == 1)
						<i class="fas fa-caret-down"></i>
					@else
						<i class="fas fa-caret-right"></i>
					@endif
				</span>
			</button>
		</h2>
	</div>

	<div id="collapse{{$i}}" class="collapse {{ ($i == 1)?'show':'' }}" aria-labelledby="heading{{$i}}" data-parent="#accordionExample">
		<div class="card-body">
			<div class="row">
				<div class="col-12">
					<div class="form-group">
						<label class="iconlabel">
							<div class="d-flex align-items-center">
								<img src="{{ asset('storage/app/public/asset_request/images/icons/SVG/metro-profile.svg') }}" alt="">
								<span>{{ __('Profile Image') }} <small class="text-right">{{__('Max upload size 10mb')}}</small></span>
							</div>
						</label>
						<div class="image-box" rel="imgUpload{{$i}}" id="image_drop_area{{$i}}">
							<div class="customer-image">
								<img id="image_imgUpload{{$i}}" src="{{ asset('storage/app/public/asset_request/images/icons/PNG/Group30.png') }}">
							</div>
							<label id="file_name{{$i}}" for="imgUpload{{$i}}" class="d-flex align-items-center" >
								<p class="ml-20 mr-5">{{-- Drag & Drop the image file or --}}</p>
								@php $imageID = 'imgUpload'.$i; @endphp
								{{ Form::hidden('employees['.$i.'][imagename]', NULL) }}
								<input id="imgUpload{{$i}}" type="file" name="employees[{{$i}}][profile_image]" accept=".jpg,.jpeg,.png,.gif, .bmp, .ico, .tiff, .svg,.webp" onchange="loadFile(event, '{{ $imageID }}')">
								<span class="btn btn-pink btn-photo ml-5">{{ __('Upload file here') }}</span>
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
						{{Form::text('employees['.$i.'][emp_name]',NULL,array('class'=>'empname storname contact','autocomplete'=>'off','placeholder'=>__('Name')))}}
						<span id="employee_{{$i}}_name" class="text-danger"></span>
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
						{{Form::text('employees['.$i.'][address]',NULL,array('class'=>'house_number contact','autocomplete'=>'off','placeholder'=> __('Address'),'id'=>'id_address'.$i))}}
						<div id="map_canvas{{$i}}"></div>
						<span id="addr{{$i}}" class="text-danger"></span>
					</div>
				</div>
				
				<!-- <div class="col-lg-6">
					
					<div class="form-group">
						<label class="iconlabel">
							<div class="d-flex align-items-center">
								<img src="{{ asset('storage/app/public/asset_request/images/icons/SVG/awesome-address-book.svg') }}" alt="">
								<span>Address*</span>
							</div>
						</label>
						<input type="text" name="firstname" placeholder="Address" autocomplete="off" class="fname contact">
						<span class="text-danger"></span>
					</div>
				</div> --> 
				<div class="col-lg-6">
					<div class="form-group">
						<label class="iconlabel">
							<div class="d-flex align-items-center">
								<img src="{{ asset('storage/app/public/asset_request/images/icons/SVG/zocial-email.svg') }}" alt="">
								<span>{{ __('Email') }}*</span>
							</div>
						</label>
						<input type="email" name="employees[{{$i}}][email]" value="{{!empty($dataRequest['employees'][$i]['email'])?$dataRequest['employees'][$i]['email']:NULL}}" rel="{{$i}}" placeholder="{{ __('Email') }}" autocomplete="off" class="empemail mail contact">
						<span id="employee_{{$i}}_email" class="text-danger"></span>
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
						{{Form::select('employees['.$i.'][country]',$countries,NULL,array('class'=>'select selectS'.$i.' select-time'))}}
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
							<input type="mobile" value="{{!empty($dataRequest['employees'][$i]['phone_number'])?$dataRequest['employees'][$i]['phone_number']:NULL}}" name="employees[{{$i}}][phone_number]" rel="{{$i}}" autocomplete="off" class="empphone mail contact" placeholder="{{ __('Phone Number') }}">
						</div>
						<span id="employee_{{$i}}_phone" class="text-danger"></span>
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
						<input type="text" name="employees[{{$i}}][zipcode]" value="{{!empty($dataRequest['employees'][$i]['zipcode'])?$dataRequest['employees'][$i]['zipcode']:NULL}}" id="zipcodeid_address{{$i}}" placeholder="{{ __('Postal Code') }}" autocomplete="off" class="lname contact">
						<span class="text-danger"></span>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
						<label class="iconlabel">
							<div class="d-flex align-items-center">
								<img src="{{ asset('storage/app/public/asset_request/images/icons/SVG/awesome-id-card.svg') }}" alt="">
								<span>{{ __('Employee ID') }}</span>
							</div>
						</label>
						<input type="text" name="employees[{{$i}}][employee_id]" value="{{!empty($dataRequest['employees'][$i]['employee_id'])?$dataRequest['employees'][$i]['employee_id']:NULL}}" placeholder="{{ __('Employee ID') }}" autocomplete="off" class="lname contact">
						<span class="text-danger"></span>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
						<div class="edit-basic-detail edit-languages-detail">
							<label class="iconlabel">
								<div class="d-flex align-items-center">
									<img src="{{ asset('storage/app/public/asset_request/images/icons/SVG/material-language.svg') }}" alt="">
									<span>{{ __('Language') }}</span>
								</div>
							</label>
						   <div class="select-arrows">
								{{Form::select('employees['.$i.'][languages][]',$languages,NULL,array('class'=>'select2 select2'.$i,'multiple'=>'multiple'))}}
								<i class="fas fa-angle-down"></i>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-12">
					<div class="form-group">
						<div class="edit-basic-detail edit-languages-detail">
							<label class="iconlabel">
								<div class="d-flex align-items-center">
									<img src="{{ asset('storage/app/public/asset_request/images/icons/SVG/Group7.svg') }}" alt="">
									<span>{{ __('Categories') }}* ({{ __('multiple selection') }})   <span id="employee_{{$i}}_category" class="text-danger ml-3"></span></span>
								</div>
							</label>
							<div class="select-arrows">
								{{Form::select('employees['.$i.'][categories][]',$category,NULL,array('rel' => $i, 'class'=>'emp_select select2 select2'.$i,'multiple'=>'multiple'))}}
								<i class="fas fa-angle-down"></i>
							</div>
							
						</div>
						
					</div>
				</div>
				
				<div class="col-12">
					<div class="form-group">
						<h5 class="sechead">{{ __('Contract information') }}</h5>
					</div>
				</div>
				
				 <div class="col-lg-6">
					<div class="form-group">
						<label class="iconlabel">
							<div class="d-flex align-items-center">
								<img src="{{ asset('storage/app/public/asset_request/images/icons/SVG/awesome-calendar-day.svg') }}" alt="">
								<span>{{ __('Start of activity') }}</span>
							</div>
						</label>
                        <input type="text" name="employees[{{$i}}][start_of_activity]" value="{{!empty($dataRequest['employees'][$i]['start_of_activity'])?$dataRequest['employees'][$i]['start_of_activity']:NULL}}" placeholder="{{ __('Start of activity') }}" autocomplete="off" class="storname contact dateselection">
                        <span class="text-danger"></span>
                    </div>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
						<label class="iconlabel">
							<div class="d-flex align-items-center">
								<img src="{{ asset('storage/app/public/asset_request/images/icons/SVG/awesome-dollar-sign.svg') }}" alt="">
								<span>{{ __('Wage') }}</span>
							</div>
						</label>
						<input type="text" name="employees[{{$i}}][payout]" value="{{!empty($dataRequest['employees'][$i]['payout'])?$dataRequest['employees'][$i]['payout']:NULL}}" placeholder="{{ __('Wage') }} (€)" autocomplete="off" class="fname contact">
						<span class="text-danger"></span>
					</div>
				</div>
                <div class="col-lg-6">
					<div class="form-group">
						<label class="iconlabel">
							<div class="d-flex align-items-center">
								<img src="{{ asset('storage/app/public/asset_request/images/icons/SVG/awesome-user-clock.svg') }}" alt="">
								<span>{{ __('Working Hours') }}</span>
							</div>
						</label>
                       {{Form::select('employees['.$i.'][worktype]',array(''=>'Arbeitsstunden', 'Full-Time'=>'Vollzeit', 'Part-Time'=>'Teilzeit'),NULL,array('class'=>'select select-time selectS'.$i))}}
                        <span class="text-danger"></span>
                    </div>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
						<label class="iconlabel">
							<div class="d-flex align-items-center">
								<img src="{{ asset('storage/app/public/asset_request/images/icons/SVG/ionic-ios-clock.svg') }}" alt="">
								<span>{{ __('Hours per week') }}</span>
							</div>
						</label>
						<input type="text" name="employees[{{$i}}][hours_per_week]" value="{{!empty($dataRequest['employees'][$i]['hours_per_week'])?$dataRequest['employees'][$i]['hours_per_week']:NULL}}" placeholder="{{ __('Hours per week') }} (Std.)" autocomplete="off" class="lname contact">
						<span class="text-danger"></span>
					</div>
				</div>
			</div>
			
			
			<div class="row">
				<div class="col-12">
					<div class="form-group">
						<h5 class="sechead">{{ __('Bank details') }}</h5>
					</div>
				</div>
				
				<div class="col-lg-6">
					<div class="form-group">
						<label class="iconlabel">
							<div class="d-flex align-items-center">
								<img src="{{ asset('storage/app/public/asset_request/images/icons/SVG/awesome-piggy-bank.svg') }}" alt="">
								<span>{{ __('Name of the bank') }}</span>
							</div>
						</label>
						{{Form::text('employees['.$i.'][bank_name]',NULL,array('class'=>'lname contact','autocomplete'=>'off','placeholder'=>__('Name of the bank')))}}
						<span class="text-danger"></span>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
						<label class="iconlabel">
							<div class="d-flex align-items-center">
								<img src="{{ asset('storage/app/public/asset_request/images/icons/SVG/open-person.svg') }}" alt="">
								<span>{{ __('Account holder name') }}</span>
							</div>
						</label>
						{{Form::text('employees['.$i.'][account_holder]',NULL,array('class'=>'lname contact','autocomplete'=>'off','placeholder'=> __('Account holder name')))}}
						<span class="text-danger"></span>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
						<label class="iconlabel">
							<div class="d-flex align-items-center">
								<img src="{{ asset('storage/app/public/asset_request/images/icons/SVG/material-account-circle.svg') }}" alt="">
								<span>{{ __('Account number') }}</span>
							</div>
						</label>
						{{Form::text('employees['.$i.'][account_number]',NULL,array('class'=>'lname contact','autocomplete'=>'off','placeholder'=> __('Account number')))}}
						<span class="text-danger"></span>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
						<label class="iconlabel">
							<div class="d-flex align-items-center">
								<img src="{{ asset('storage/app/public/asset_request/images/icons/SVG/material-account-balance.svg') }}" alt="">
								<span>{{ __('IBAN') }}</span>
							</div>
						</label>
						{{Form::text('employees['.$i.'][iban]',NULL,array('class'=>'lname contact','autocomplete'=>'off','placeholder'=> __('IBAN')))}}
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
						<label class="iconlabel">
							<div class="d-flex align-items-center">
								<img src="{{ asset('storage/app/public/asset_request/images/icons/SVG/awesome-pen-alt.svg') }}" alt="">
								<span>{{ __('BIC') }}</span>
							</div>
						</label>
						{{Form::text('employees['.$i.'][swift_code]',NULL,array('class'=>'lname contact','autocomplete'=>'off','placeholder'=> __('BIC')))}}
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
						<label class="iconlabel">
							<div class="d-flex align-items-center">
								<img src="{{ asset('storage/app/public/asset_request/images/icons/SVG/ionic-ios-clock.svg') }}" alt="">
								<span>{{ __('Usage') }}</span>
							</div>
						</label>
						{{Form::text('employees['.$i.'][branch]',NULL,array('class'=>'lname contact','autocomplete'=>'off','placeholder'=> __('Usage')))}}
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<div class="form-group">
						<div class="edit-basic-detail-main">
							<div class="edit-basic-detail mb-0">
								<div class="store-date-head-wrap">
									<h4 class="text-center mb-4 mt-4">{{ __('Working Hours') }}*</h4>
								</div>
								<div class="hours-tabel-main">
									<div class="hours-tabel-head-wrap">
										<h6>{{ __('Days') }}</h6>
										<h6 class="text-center">{{ __('Timeline') }}</h6>
										<h6>{{ __('Holiday') }}</h6>
									</div>
									{{Form::hidden('igonore_me[$i]', "", array('rel' => $i, 'class' => 'employee_timing'))}}
									@if(!empty($dataRequest['employees'][$i]['day']))
										@foreach($dataRequest['employees'][$i]['day'] as $key => $day)
											<div class="hours-tabel-body-wrap">
												<p>{{$day}}</p>
												<div class="hours-time-wrap">
													{{Form::hidden('employees['.$i.'][day]['.$key.']',$day)}}
													<input type="text" value="{{!empty($dataRequest['employees'][$i]['start_time'][$key])?$dataRequest['employees'][$i]['start_time'][$key]:NULL}}" class="timepicker start_time" name="employees[{{$i}}][start_time][{{$key}}]" placeholder=" -- --" data-id="{{$day.$i}}">
													<span>{{ __('to') }}</span>
													<input type="text" value="{{!empty($dataRequest['employees'][$i]['end_time'][$key])?$dataRequest['employees'][$i]['end_time'][$key]:NULL}}" class="timepicker start_time" name="employees[{{$i}}][end_time][{{$key}}]" placeholder=" -- --" data-id="{{$day.$i}}">
												</div>
											   
												<label>
													<input type="checkbox" <?php echo !empty($dataRequest['employees'][$i]['weekDays'][$key]) && $dataRequest['employees'][$i]['weekDays'][$key] == 'on'?'checked':'' ?> name="employees[{{$i}}][weekDays][{{$key}}]" data-id="{{$day.$i}}" class="weekdays  employee_opening{{$i}}" id="{{$day}}-check{{$i}}">
													<span><i class="fas fa-check"></i></span>
												</label>
											</div>
										@endforeach
									@else
										<div class="hours-tabel-body-wrap">
											<p>Montag</p>
											<div class="hours-time-wrap">
												{{Form::hidden('employees['.$i.'][day][]','Monday')}}
												<input type="text" class="timepicker start_time" name="employees[{{$i}}][start_time][]" placeholder=" -- --" data-id="Monday{{$i}}">
												<span>{{ __('to') }}</span>
												<input type="text" class="timepicker end_time" name="employees[{{$i}}][end_time][]" placeholder=" -- --" data-id="Monday{{$i}}">
											</div>
										   
											<label>
												<input type="checkbox" name="employees[{{$i}}][weekDays][]" data-id="Monday{{$i}}" class="weekdays  employee_opening{{$i}}" id="monday-check{{$i}}">
												<span><i class="fas fa-check"></i></span>
											</label>
										</div>
										<div class="hours-tabel-body-wrap">
											<p>Dienstag</p>
											<div class="hours-time-wrap">
												{{Form::hidden('employees['.$i.'][day][]','Tuesday')}}
												<input type="text" class="timepicker start_time" name="employees[{{$i}}][start_time][]" placeholder=" -- --" data-id="Tuesday{{$i}}">
												<span>{{ __('to') }}</span>
												<input type="text" class="timepicker end_time" name="employees[{{$i}}][end_time][]" placeholder=" -- --" data-id="Tuesday{{$i}}">
											</div>
										   
											<label>
												<input type="checkbox" name="employees[{{$i}}][weekDays][]" data-id="Tuesday{{$i}}" class="weekdays  employee_opening{{$i}}" id="tuesday-check{{$i}}" >
												<span><i class="fas fa-check"></i></span>
											</label>
										</div>
										<div class="hours-tabel-body-wrap  ">
											<p>Mittwoch</p>
											<div class="hours-time-wrap">
												{{Form::hidden('employees['.$i.'][day][]','Wednesday')}}
												<input type="text" class="timepicker start_time" name="employees[{{$i}}][start_time][]" placeholder=" -- --" data-id="Wednesday{{$i}}">
												<span>{{ __('to') }}</span>
												<input type="text" class="timepicker end_time" name="employees[{{$i}}][end_time][]" placeholder=" -- --" data-id="Wednesday{{$i}}">
											</div>
										   
											<label>
												<input type="checkbox" name="employees[{{$i}}][weekDays][]" id="wednesday-check{{$i}}" class="weekdays  employee_opening{{$i}}" data-id="Wednesday{{$i}}" >
												<span><i class="fas fa-check"></i></span>
											</label>
										</div>
										<div class="hours-tabel-body-wrap">
											<p>Donnerstag</p>
											<div class="hours-time-wrap">
												{{Form::hidden('employees['.$i.'][day][]','Thursday')}}
												<input type="text" class="timepicker start_time" name="employees[{{$i}}][start_time][]" placeholder=" -- --" data-id="Thursday{{$i}}">
												<span>{{ __('to') }}</span>
												<input type="text" class="timepicker end_time" name="employees[{{$i}}][end_time][]" placeholder=" -- --" data-id="Thursday{{$i}}">
											</div>
										   
											<label>
												<input type="checkbox" name="employees[{{$i}}][weekDays][]" id="thursday-check{{$i}}" class="weekdays  employee_opening{{$i}}" data-id="Thursday{{$i}}" >
												<span><i class="fas fa-check"></i></span>
											</label>
										</div>
										<div class="hours-tabel-body-wrap ">
											<p>Freitag</p>
											<div class="hours-time-wrap">
												{{Form::hidden('employees['.$i.'][day][]','Friday')}}
												<input type="text" class="timepicker start_time" name="employees[{{$i}}][start_time][]" placeholder=" -- --" data-id="Friday{{$i}}">
												<span>{{ __('to') }}</span>
												<input type="text" class="timepicker end_time" name="employees[{{$i}}][end_time][]" placeholder=" -- --" data-id="Friday{{$i}}">
											</div>
											
											<label>
												<input type="checkbox" name="employees[{{$i}}][weekDays][]" id="friday-check{{$i}}" class="weekdays  employee_opening{{$i}}" data-id="Friday{{$i}}">
												<span><i class="fas fa-check"></i></span>
											</label>
										</div>
										<div class="hours-tabel-body-wrap  ">
											<p>Samstag</p>
											<div class="hours-time-wrap">
												{{Form::hidden('employees['.$i.'][day][]','Saturday')}}
												<input type="text" class="timepicker start_time" name="employees[{{$i}}][start_time][]" placeholder=" -- --" data-id="Saturday{{$i}}">
												<span>{{ __('to') }}</span>
												<input type="text" class="timepicker end_time" name="employees[{{$i}}][end_time][]" placeholder=" -- --" data-id="Saturday{{$i}}">
											</div>
										  
											<label>
												<input type="checkbox" name="employees[{{$i}}][weekDays][]" data-id="Saturday{{$i}}" class="weekdays  employee_opening{{$i}}" id="saturday-check{{$i}}" >
												<span><i class="fas fa-check"></i></span>
											</label>
										</div>
										<div class="hours-tabel-body-wrap  ">
											<p>Sonntag</p>
											<div class="hours-time-wrap">
												{{Form::hidden('employees['.$i.'][day][]','Sunday')}}
												<input type="text" class="timepicker start_time" name="employees[{{$i}}][start_time][]" placeholder=" -- --" data-id="Sunday{{$i}}">
												<span>{{ __('to') }}</span>
												<input type="text" class="timepicker end_time" name="employees[{{$i}}][end_time][]" placeholder=" -- --" data-id="Sunday{{$i}}">
											</div>
											
											<label>
												<input type="checkbox" name="employees[{{$i}}][weekDays][]" id="sunday-check{{$i}}" class="weekdays  employee_opening{{$i}}" data-id="Sunday{{$i}}">
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
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		 $('.dateselection').datepicker({
            endDate: new Date(),
            language: "de",
            format: "dd-mm-yyyy",
            todayHighlight: true,
            autoclose: true,
        });
		
		$('.start_time').datetimepicker({format: 'HH:mm', icons: {up: 'fa fa-angle-up', down: 'fa fa-angle-down'} }).on('dp.hide',function(e){
			var id = $(this).data('id');
			var formatedValue = e.date.format('HH:mm');
			startTime(formatedValue,id);
		});
			
			
		$('.end_time').datetimepicker({format: 'HH:mm',  icons: {up: 'fa fa-angle-up', down: 'fa fa-angle-down'} }).on('dp.hide',function(e){
			var id = $(this).data('id');
			var formatedValue = e.date.format('HH:mm');
			endTime(formatedValue,id);
		});
		 
		/*  $(document).on('click', '.weekdays', function () {
            var id = $(this).data('id');
			
            if ($(this).prop('checked') == true) {
                $('.start_time[data-id=' + id + ']').css('pointer-events', 'none');
                $('.start_time[data-id=' + id + ']').attr('readonly', true);
                $('.start_time[data-id=' + id + ']').val('');
                $('.end_time[data-id=' + id + ']').css('pointer-events', 'none');
                $('.end_time[data-id=' + id + ']').attr('readonly', true);
                $('.end_time[data-id=' + id + ']').val('');
            } else {
                $('.start_time[data-id=' + id + ']').css('pointer-events', 'all');
                $('.start_time[data-id=' + id + ']').attr('readonly', false);
                $('.end_time[data-id=' + id + ']').css('pointer-events', 'all');
                $('.end_time[data-id=' + id + ']').attr('readonly', false);
                $('.start_time[data-id=' + id + ']').val('10:00');
                $('.end_time[data-id=' + id + ']').val('20:00');
            }
        }); */
	});
	var i = "{{$i}}";
	$('.selectS'+i).niceSelect();
	$('.select2'+i).select2();
		
/* 	vars['image_drop_area'+i] = document.querySelector("#image_drop_area"+i);
	uploaded_imageN['uploaded_imageN'+i];
    img_relN['img_relN'+i];
	// Event listener for dragging the image over the div
	vars['image_drop_area'+i].addEventListener('dragover', (event) => {
		event.stopPropagation();
		event.preventDefault();
	  // Style the drag-and-drop as a "copy file" operation.
		event.dataTransfer.dropEffect = 'copy';
	});

	// Event listener for dropping the image inside the div
	vars['image_drop_area'+i].addEventListener('drop', (event) => {
			var img_id = event.target.id;
			img_relN['img_relN'+i] = $('#'+img_id).attr('rel');
		
		  event.stopPropagation();
		  event.preventDefault();
		  fileList = event.dataTransfer.files;

		  //document.querySelector("#file_name").textContent = fileList[0].name;
		  
		  readImageN(fileList[0]);
	});

// Converts the image into a data URI
readImageN = (file) => {
	const reader = new FileReader();
	reader.addEventListener('load', (event) => {
	 
    uploaded_imageN['uploaded_imageN'+i] = event.target.result;
    //document.querySelector(".customer-image").style.backgroundImage = `url(${uploaded_image})`;
	var image_url = `url(${uploaded_imageN['uploaded_imageN'+i]})`;
	
		$("#image_"+img_relN['img_relN'+i]).attr('src', uploaded_imageN['uploaded_imageN'+i]);
 });
  reader.readAsDataURL(file);
} */
</script>