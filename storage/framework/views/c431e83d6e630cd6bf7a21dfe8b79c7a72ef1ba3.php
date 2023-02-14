<div class="card" id="employee_div<?php echo e($i); ?>">
	<div class="card-header" id="heading<?php echo e($i); ?>">
		<h2 class="mb-0">
			<button class="d-flex align-items-center justify-content-between btn btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapse<?php echo e($i); ?>" aria-expanded="false" aria-controls="collapse<?php echo e($i); ?>">
				<div class="d-flex align-items-center">
				<?php echo e(__('Employee')); ?> <?php echo e($i); ?>

				<a class="btn btn-remove-icon d-flex align-items-center remove_employees ml-5" rel="<?php echo e($i); ?>" href="javascript:void(0);"><span><i class="fa fa-times"></span></i>&nbsp;<?php echo e(__('Delete')); ?></a>
				</div>
				<span>
					<?php if($i == 1): ?>
						<i class="fas fa-caret-down"></i>
					<?php else: ?>
						<i class="fas fa-caret-right"></i>
					<?php endif; ?>
				</span>
			</button>
		</h2>
	</div>

	<div id="collapse<?php echo e($i); ?>" class="collapse <?php echo e(($i == 1)?'show':''); ?>" aria-labelledby="heading<?php echo e($i); ?>" data-parent="#accordionExample">
		<div class="card-body">
			<div class="row">
				<div class="col-12">
					<div class="form-group">
						<label class="iconlabel">
							<div class="d-flex align-items-center">
								<img src="<?php echo e(asset('storage/app/public/asset_request/images/icons/SVG/metro-profile.svg')); ?>" alt="">
								<span><?php echo e(__('Profile Image')); ?> <small class="text-right"><?php echo e(__('Max upload size 10mb')); ?></small></span>
							</div>
						</label>
						<div class="image-box" rel="imgUpload<?php echo e($i); ?>" id="image_drop_area<?php echo e($i); ?>">
							<div class="customer-image">
								<img id="image_imgUpload<?php echo e($i); ?>" src="<?php echo e(asset('storage/app/public/asset_request/images/icons/PNG/Group30.png')); ?>">
							</div>
							<label id="file_name<?php echo e($i); ?>" for="imgUpload<?php echo e($i); ?>" class="d-flex align-items-center" >
								<p class="ml-20 mr-5"></p>
								<?php $imageID = 'imgUpload'.$i; ?>
								<?php echo e(Form::hidden('employees['.$i.'][imagename]', NULL)); ?>

								<input id="imgUpload<?php echo e($i); ?>" type="file" name="employees[<?php echo e($i); ?>][profile_image]" accept=".jpg,.jpeg,.png,.gif, .bmp, .ico, .tiff, .svg,.webp" onchange="loadFile(event, '<?php echo e($imageID); ?>')">
								<span class="btn btn-pink btn-photo ml-5"><?php echo e(__('Upload file here')); ?></span>
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
								<img src="<?php echo e(asset('storage/app/public/asset_request/images/icons/SVG/open-person.svg')); ?>" alt="">
								<span><?php echo e(__('Name')); ?>*</span>
							</div>
						</label>
						<?php echo e(Form::text('employees['.$i.'][emp_name]',NULL,array('class'=>'empname storname contact','autocomplete'=>'off','placeholder'=>__('Name')))); ?>

						<span id="employee_<?php echo e($i); ?>_name" class="text-danger"></span>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
						<label class="iconlabel">
							<div class="d-flex align-items-center">
								<img src="<?php echo e(asset('storage/app/public/asset_request/images/icons/SVG/awesome-address-book.svg')); ?>" alt="">
								<span><?php echo e(__('Address')); ?></span>
							</div>
						</label>
						<?php echo e(Form::text('employees['.$i.'][address]',NULL,array('class'=>'house_number contact','autocomplete'=>'off','placeholder'=> __('Address'),'id'=>'id_address'.$i))); ?>

						<div id="map_canvas<?php echo e($i); ?>"></div>
						<span id="addr<?php echo e($i); ?>" class="text-danger"></span>
					</div>
				</div>
				
				<!-- <div class="col-lg-6">
					
					<div class="form-group">
						<label class="iconlabel">
							<div class="d-flex align-items-center">
								<img src="<?php echo e(asset('storage/app/public/asset_request/images/icons/SVG/awesome-address-book.svg')); ?>" alt="">
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
								<img src="<?php echo e(asset('storage/app/public/asset_request/images/icons/SVG/zocial-email.svg')); ?>" alt="">
								<span><?php echo e(__('Email')); ?>*</span>
							</div>
						</label>
						<input type="email" name="employees[<?php echo e($i); ?>][email]" value="<?php echo e(!empty($dataRequest['employees'][$i]['email'])?$dataRequest['employees'][$i]['email']:NULL); ?>" rel="<?php echo e($i); ?>" placeholder="<?php echo e(__('Email')); ?>" autocomplete="off" class="empemail mail contact">
						<span id="employee_<?php echo e($i); ?>_email" class="text-danger"></span>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
						<label class="iconlabel">
							<div class="d-flex align-items-center">
								<img src="<?php echo e(asset('storage/app/public/asset_request/images/icons/SVG/awesome-map-marked-alt.svg')); ?>" alt="">
								<span><?php echo e(__('Country')); ?></span>
							</div>
						</label>
						<?php echo e(Form::select('employees['.$i.'][country]',$countries,NULL,array('class'=>'select selectS'.$i.' select-time'))); ?>

					</div>
				</div>
				 <div class="col-lg-6">
					<div class="form-group">
						<label class="iconlabel">
							<div class="d-flex align-items-center">
								<img src="<?php echo e(asset('storage/app/public/asset_request/images/icons/SVG/awesome-phone.svg')); ?>" alt="">
								<span><?php echo e(__('Phone Number')); ?></span>
							</div>
						</label>
						<div class="mobile-number">
							<img src="<?php echo e(asset('storage/app/public/asset_request/images/germany-flag.png')); ?>" alt="">
							<!-- <span>+49</span> -->
							<input type="mobile" value="<?php echo e(!empty($dataRequest['employees'][$i]['phone_number'])?$dataRequest['employees'][$i]['phone_number']:NULL); ?>" name="employees[<?php echo e($i); ?>][phone_number]" rel="<?php echo e($i); ?>" autocomplete="off" class="empphone mail contact" placeholder="<?php echo e(__('Phone Number')); ?>">
						</div>
						<span id="employee_<?php echo e($i); ?>_phone" class="text-danger"></span>
					</div>
				</div>
				
				<div class="col-lg-6">
					<div class="form-group">
						<label class="iconlabel">
							<div class="d-flex align-items-center">
								<img src="<?php echo e(asset('storage/app/public/asset_request/images/icons/SVG/map-post-box.svg')); ?>" alt="">
								<span><?php echo e(__('Postal Code')); ?></span>
							</div>
						</label>
						<input type="text" name="employees[<?php echo e($i); ?>][zipcode]" value="<?php echo e(!empty($dataRequest['employees'][$i]['zipcode'])?$dataRequest['employees'][$i]['zipcode']:NULL); ?>" id="zipcodeid_address<?php echo e($i); ?>" placeholder="<?php echo e(__('Postal Code')); ?>" autocomplete="off" class="lname contact">
						<span class="text-danger"></span>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
						<label class="iconlabel">
							<div class="d-flex align-items-center">
								<img src="<?php echo e(asset('storage/app/public/asset_request/images/icons/SVG/awesome-id-card.svg')); ?>" alt="">
								<span><?php echo e(__('Employee ID')); ?></span>
							</div>
						</label>
						<input type="text" name="employees[<?php echo e($i); ?>][employee_id]" value="<?php echo e(!empty($dataRequest['employees'][$i]['employee_id'])?$dataRequest['employees'][$i]['employee_id']:NULL); ?>" placeholder="<?php echo e(__('Employee ID')); ?>" autocomplete="off" class="lname contact">
						<span class="text-danger"></span>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
						<div class="edit-basic-detail edit-languages-detail">
							<label class="iconlabel">
								<div class="d-flex align-items-center">
									<img src="<?php echo e(asset('storage/app/public/asset_request/images/icons/SVG/material-language.svg')); ?>" alt="">
									<span><?php echo e(__('Language')); ?></span>
								</div>
							</label>
						   <div class="select-arrows">
								<?php echo e(Form::select('employees['.$i.'][languages][]',$languages,NULL,array('class'=>'select2 select2'.$i,'multiple'=>'multiple'))); ?>

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
									<img src="<?php echo e(asset('storage/app/public/asset_request/images/icons/SVG/Group7.svg')); ?>" alt="">
									<span><?php echo e(__('Categories')); ?>* (<?php echo e(__('multiple selection')); ?>)   <span id="employee_<?php echo e($i); ?>_category" class="text-danger ml-3"></span></span>
								</div>
							</label>
							<div class="select-arrows">
								<?php echo e(Form::select('employees['.$i.'][categories][]',$category,NULL,array('rel' => $i, 'class'=>'emp_select select2 select2'.$i,'multiple'=>'multiple'))); ?>

								<i class="fas fa-angle-down"></i>
							</div>
							
						</div>
						
					</div>
				</div>
				
				<div class="col-12">
					<div class="form-group">
						<h5 class="sechead"><?php echo e(__('Contract information')); ?></h5>
					</div>
				</div>
				
				 <div class="col-lg-6">
					<div class="form-group">
						<label class="iconlabel">
							<div class="d-flex align-items-center">
								<img src="<?php echo e(asset('storage/app/public/asset_request/images/icons/SVG/awesome-calendar-day.svg')); ?>" alt="">
								<span><?php echo e(__('Start of activity')); ?></span>
							</div>
						</label>
                        <input type="text" name="employees[<?php echo e($i); ?>][start_of_activity]" value="<?php echo e(!empty($dataRequest['employees'][$i]['start_of_activity'])?$dataRequest['employees'][$i]['start_of_activity']:NULL); ?>" placeholder="<?php echo e(__('Start of activity')); ?>" autocomplete="off" class="storname contact dateselection">
                        <span class="text-danger"></span>
                    </div>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
						<label class="iconlabel">
							<div class="d-flex align-items-center">
								<img src="<?php echo e(asset('storage/app/public/asset_request/images/icons/SVG/awesome-dollar-sign.svg')); ?>" alt="">
								<span><?php echo e(__('Wage')); ?></span>
							</div>
						</label>
						<input type="text" name="employees[<?php echo e($i); ?>][payout]" value="<?php echo e(!empty($dataRequest['employees'][$i]['payout'])?$dataRequest['employees'][$i]['payout']:NULL); ?>" placeholder="<?php echo e(__('Wage')); ?> (€)" autocomplete="off" class="fname contact">
						<span class="text-danger"></span>
					</div>
				</div>
                <div class="col-lg-6">
					<div class="form-group">
						<label class="iconlabel">
							<div class="d-flex align-items-center">
								<img src="<?php echo e(asset('storage/app/public/asset_request/images/icons/SVG/awesome-user-clock.svg')); ?>" alt="">
								<span><?php echo e(__('Working Hours')); ?></span>
							</div>
						</label>
                       <?php echo e(Form::select('employees['.$i.'][worktype]',array(''=>'Arbeitsstunden', 'Full-Time'=>'Vollzeit', 'Part-Time'=>'Teilzeit'),NULL,array('class'=>'select select-time selectS'.$i))); ?>

                        <span class="text-danger"></span>
                    </div>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
						<label class="iconlabel">
							<div class="d-flex align-items-center">
								<img src="<?php echo e(asset('storage/app/public/asset_request/images/icons/SVG/ionic-ios-clock.svg')); ?>" alt="">
								<span><?php echo e(__('Hours per week')); ?></span>
							</div>
						</label>
						<input type="text" name="employees[<?php echo e($i); ?>][hours_per_week]" value="<?php echo e(!empty($dataRequest['employees'][$i]['hours_per_week'])?$dataRequest['employees'][$i]['hours_per_week']:NULL); ?>" placeholder="<?php echo e(__('Hours per week')); ?> (Std.)" autocomplete="off" class="lname contact">
						<span class="text-danger"></span>
					</div>
				</div>
			</div>
			
			
			<div class="row">
				<div class="col-12">
					<div class="form-group">
						<h5 class="sechead"><?php echo e(__('Bank details')); ?></h5>
					</div>
				</div>
				
				<div class="col-lg-6">
					<div class="form-group">
						<label class="iconlabel">
							<div class="d-flex align-items-center">
								<img src="<?php echo e(asset('storage/app/public/asset_request/images/icons/SVG/awesome-piggy-bank.svg')); ?>" alt="">
								<span><?php echo e(__('Name of the bank')); ?></span>
							</div>
						</label>
						<?php echo e(Form::text('employees['.$i.'][bank_name]',NULL,array('class'=>'lname contact','autocomplete'=>'off','placeholder'=>__('Name of the bank')))); ?>

						<span class="text-danger"></span>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
						<label class="iconlabel">
							<div class="d-flex align-items-center">
								<img src="<?php echo e(asset('storage/app/public/asset_request/images/icons/SVG/open-person.svg')); ?>" alt="">
								<span><?php echo e(__('Account holder name')); ?></span>
							</div>
						</label>
						<?php echo e(Form::text('employees['.$i.'][account_holder]',NULL,array('class'=>'lname contact','autocomplete'=>'off','placeholder'=> __('Account holder name')))); ?>

						<span class="text-danger"></span>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
						<label class="iconlabel">
							<div class="d-flex align-items-center">
								<img src="<?php echo e(asset('storage/app/public/asset_request/images/icons/SVG/material-account-circle.svg')); ?>" alt="">
								<span><?php echo e(__('Account number')); ?></span>
							</div>
						</label>
						<?php echo e(Form::text('employees['.$i.'][account_number]',NULL,array('class'=>'lname contact','autocomplete'=>'off','placeholder'=> __('Account number')))); ?>

						<span class="text-danger"></span>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
						<label class="iconlabel">
							<div class="d-flex align-items-center">
								<img src="<?php echo e(asset('storage/app/public/asset_request/images/icons/SVG/material-account-balance.svg')); ?>" alt="">
								<span><?php echo e(__('IBAN')); ?></span>
							</div>
						</label>
						<?php echo e(Form::text('employees['.$i.'][iban]',NULL,array('class'=>'lname contact','autocomplete'=>'off','placeholder'=> __('IBAN')))); ?>

					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
						<label class="iconlabel">
							<div class="d-flex align-items-center">
								<img src="<?php echo e(asset('storage/app/public/asset_request/images/icons/SVG/awesome-pen-alt.svg')); ?>" alt="">
								<span><?php echo e(__('BIC')); ?></span>
							</div>
						</label>
						<?php echo e(Form::text('employees['.$i.'][swift_code]',NULL,array('class'=>'lname contact','autocomplete'=>'off','placeholder'=> __('BIC')))); ?>

					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
						<label class="iconlabel">
							<div class="d-flex align-items-center">
								<img src="<?php echo e(asset('storage/app/public/asset_request/images/icons/SVG/ionic-ios-clock.svg')); ?>" alt="">
								<span><?php echo e(__('Usage')); ?></span>
							</div>
						</label>
						<?php echo e(Form::text('employees['.$i.'][branch]',NULL,array('class'=>'lname contact','autocomplete'=>'off','placeholder'=> __('Usage')))); ?>

					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<div class="form-group">
						<div class="edit-basic-detail-main">
							<div class="edit-basic-detail mb-0">
								<div class="store-date-head-wrap">
									<h4 class="text-center mb-4 mt-4"><?php echo e(__('Working Hours')); ?>*</h4>
								</div>
								<div class="hours-tabel-main">
									<div class="hours-tabel-head-wrap">
										<h6><?php echo e(__('Days')); ?></h6>
										<h6 class="text-center"><?php echo e(__('Timeline')); ?></h6>
										<h6><?php echo e(__('Holiday')); ?></h6>
									</div>
									<?php echo e(Form::hidden('igonore_me[$i]', "", array('rel' => $i, 'class' => 'employee_timing'))); ?>

									<?php if(!empty($dataRequest['employees'][$i]['day'])): ?>
										<?php $__currentLoopData = $dataRequest['employees'][$i]['day']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<div class="hours-tabel-body-wrap">
												<p><?php echo e($day); ?></p>
												<div class="hours-time-wrap">
													<?php echo e(Form::hidden('employees['.$i.'][day]['.$key.']',$day)); ?>

													<input type="text" value="<?php echo e(!empty($dataRequest['employees'][$i]['start_time'][$key])?$dataRequest['employees'][$i]['start_time'][$key]:NULL); ?>" class="timepicker start_time" name="employees[<?php echo e($i); ?>][start_time][<?php echo e($key); ?>]" placeholder=" -- --" data-id="<?php echo e($day.$i); ?>">
													<span><?php echo e(__('to')); ?></span>
													<input type="text" value="<?php echo e(!empty($dataRequest['employees'][$i]['end_time'][$key])?$dataRequest['employees'][$i]['end_time'][$key]:NULL); ?>" class="timepicker start_time" name="employees[<?php echo e($i); ?>][end_time][<?php echo e($key); ?>]" placeholder=" -- --" data-id="<?php echo e($day.$i); ?>">
												</div>
											   
												<label>
													<input type="checkbox" <?php echo !empty($dataRequest['employees'][$i]['weekDays'][$key]) && $dataRequest['employees'][$i]['weekDays'][$key] == 'on'?'checked':'' ?> name="employees[<?php echo e($i); ?>][weekDays][<?php echo e($key); ?>]" data-id="<?php echo e($day.$i); ?>" class="weekdays  employee_opening<?php echo e($i); ?>" id="<?php echo e($day); ?>-check<?php echo e($i); ?>">
													<span><i class="fas fa-check"></i></span>
												</label>
											</div>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									<?php else: ?>
										<div class="hours-tabel-body-wrap">
											<p>Montag</p>
											<div class="hours-time-wrap">
												<?php echo e(Form::hidden('employees['.$i.'][day][]','Monday')); ?>

												<input type="text" class="timepicker start_time" name="employees[<?php echo e($i); ?>][start_time][]" placeholder=" -- --" data-id="Monday<?php echo e($i); ?>">
												<span><?php echo e(__('to')); ?></span>
												<input type="text" class="timepicker end_time" name="employees[<?php echo e($i); ?>][end_time][]" placeholder=" -- --" data-id="Monday<?php echo e($i); ?>">
											</div>
										   
											<label>
												<input type="checkbox" name="employees[<?php echo e($i); ?>][weekDays][]" data-id="Monday<?php echo e($i); ?>" class="weekdays  employee_opening<?php echo e($i); ?>" id="monday-check<?php echo e($i); ?>">
												<span><i class="fas fa-check"></i></span>
											</label>
										</div>
										<div class="hours-tabel-body-wrap">
											<p>Dienstag</p>
											<div class="hours-time-wrap">
												<?php echo e(Form::hidden('employees['.$i.'][day][]','Tuesday')); ?>

												<input type="text" class="timepicker start_time" name="employees[<?php echo e($i); ?>][start_time][]" placeholder=" -- --" data-id="Tuesday<?php echo e($i); ?>">
												<span><?php echo e(__('to')); ?></span>
												<input type="text" class="timepicker end_time" name="employees[<?php echo e($i); ?>][end_time][]" placeholder=" -- --" data-id="Tuesday<?php echo e($i); ?>">
											</div>
										   
											<label>
												<input type="checkbox" name="employees[<?php echo e($i); ?>][weekDays][]" data-id="Tuesday<?php echo e($i); ?>" class="weekdays  employee_opening<?php echo e($i); ?>" id="tuesday-check<?php echo e($i); ?>" >
												<span><i class="fas fa-check"></i></span>
											</label>
										</div>
										<div class="hours-tabel-body-wrap  ">
											<p>Mittwoch</p>
											<div class="hours-time-wrap">
												<?php echo e(Form::hidden('employees['.$i.'][day][]','Wednesday')); ?>

												<input type="text" class="timepicker start_time" name="employees[<?php echo e($i); ?>][start_time][]" placeholder=" -- --" data-id="Wednesday<?php echo e($i); ?>">
												<span><?php echo e(__('to')); ?></span>
												<input type="text" class="timepicker end_time" name="employees[<?php echo e($i); ?>][end_time][]" placeholder=" -- --" data-id="Wednesday<?php echo e($i); ?>">
											</div>
										   
											<label>
												<input type="checkbox" name="employees[<?php echo e($i); ?>][weekDays][]" id="wednesday-check<?php echo e($i); ?>" class="weekdays  employee_opening<?php echo e($i); ?>" data-id="Wednesday<?php echo e($i); ?>" >
												<span><i class="fas fa-check"></i></span>
											</label>
										</div>
										<div class="hours-tabel-body-wrap">
											<p>Donnerstag</p>
											<div class="hours-time-wrap">
												<?php echo e(Form::hidden('employees['.$i.'][day][]','Thursday')); ?>

												<input type="text" class="timepicker start_time" name="employees[<?php echo e($i); ?>][start_time][]" placeholder=" -- --" data-id="Thursday<?php echo e($i); ?>">
												<span><?php echo e(__('to')); ?></span>
												<input type="text" class="timepicker end_time" name="employees[<?php echo e($i); ?>][end_time][]" placeholder=" -- --" data-id="Thursday<?php echo e($i); ?>">
											</div>
										   
											<label>
												<input type="checkbox" name="employees[<?php echo e($i); ?>][weekDays][]" id="thursday-check<?php echo e($i); ?>" class="weekdays  employee_opening<?php echo e($i); ?>" data-id="Thursday<?php echo e($i); ?>" >
												<span><i class="fas fa-check"></i></span>
											</label>
										</div>
										<div class="hours-tabel-body-wrap ">
											<p>Freitag</p>
											<div class="hours-time-wrap">
												<?php echo e(Form::hidden('employees['.$i.'][day][]','Friday')); ?>

												<input type="text" class="timepicker start_time" name="employees[<?php echo e($i); ?>][start_time][]" placeholder=" -- --" data-id="Friday<?php echo e($i); ?>">
												<span><?php echo e(__('to')); ?></span>
												<input type="text" class="timepicker end_time" name="employees[<?php echo e($i); ?>][end_time][]" placeholder=" -- --" data-id="Friday<?php echo e($i); ?>">
											</div>
											
											<label>
												<input type="checkbox" name="employees[<?php echo e($i); ?>][weekDays][]" id="friday-check<?php echo e($i); ?>" class="weekdays  employee_opening<?php echo e($i); ?>" data-id="Friday<?php echo e($i); ?>">
												<span><i class="fas fa-check"></i></span>
											</label>
										</div>
										<div class="hours-tabel-body-wrap  ">
											<p>Samstag</p>
											<div class="hours-time-wrap">
												<?php echo e(Form::hidden('employees['.$i.'][day][]','Saturday')); ?>

												<input type="text" class="timepicker start_time" name="employees[<?php echo e($i); ?>][start_time][]" placeholder=" -- --" data-id="Saturday<?php echo e($i); ?>">
												<span><?php echo e(__('to')); ?></span>
												<input type="text" class="timepicker end_time" name="employees[<?php echo e($i); ?>][end_time][]" placeholder=" -- --" data-id="Saturday<?php echo e($i); ?>">
											</div>
										  
											<label>
												<input type="checkbox" name="employees[<?php echo e($i); ?>][weekDays][]" data-id="Saturday<?php echo e($i); ?>" class="weekdays  employee_opening<?php echo e($i); ?>" id="saturday-check<?php echo e($i); ?>" >
												<span><i class="fas fa-check"></i></span>
											</label>
										</div>
										<div class="hours-tabel-body-wrap  ">
											<p>Sonntag</p>
											<div class="hours-time-wrap">
												<?php echo e(Form::hidden('employees['.$i.'][day][]','Sunday')); ?>

												<input type="text" class="timepicker start_time" name="employees[<?php echo e($i); ?>][start_time][]" placeholder=" -- --" data-id="Sunday<?php echo e($i); ?>">
												<span><?php echo e(__('to')); ?></span>
												<input type="text" class="timepicker end_time" name="employees[<?php echo e($i); ?>][end_time][]" placeholder=" -- --" data-id="Sunday<?php echo e($i); ?>">
											</div>
											
											<label>
												<input type="checkbox" name="employees[<?php echo e($i); ?>][weekDays][]" id="sunday-check<?php echo e($i); ?>" class="weekdays  employee_opening<?php echo e($i); ?>" data-id="Sunday<?php echo e($i); ?>">
												<span><i class="fas fa-check"></i></span>
											</label>
										</div>
									<?php endif; ?>
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
	var i = "<?php echo e($i); ?>";
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
</script><?php /**PATH F:\projects\laravel\reserved4you_dev\resources\views/RequestForm/employees.blade.php ENDPATH**/ ?>