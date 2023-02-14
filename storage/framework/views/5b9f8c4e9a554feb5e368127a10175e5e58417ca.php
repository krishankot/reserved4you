<?php $__env->startSection('request_content'); ?>
<section class="contactdetail">
    <div class="progress">
        <div class="progress-bar progressbarr4u" role="progressbar" style="width: 10%;" aria-valuenow="25"
             aria-valuemin="0" aria-valuemax="100"></div>
    </div>
    <div class="container">
        <div class="contactheading">
            <h2><?php echo e(__('About')); ?></h2>
        </div>
       
		<?php echo e(Form::model($dataRequest, array('url'=>'request-form/s1','method'=>'post','name'=>'myform', 'files'=>'true', 'onsubmit' => "return validate();"))); ?>

            <?php echo csrf_field(); ?>
            <div class="filldetail">
                <div class="row">
                    <div class="col-lg-6">
						<div class="form-group">
							<label class="iconlabel">
								<div class="d-flex align-items-center">
									<img src="<?php echo e(asset('storage/app/public/asset_request/images/icons/SVG/metro-shop.svg')); ?>" alt="">
									<span><?php echo e(__('Shop name')); ?>*</span>
								</div>
							</label>
							<?php echo e(Form::text('store_name',NULL,array('class'=>'storname contact','autocomplete'=>'off','placeholder'=>__('Shop name')))); ?>

							<span id="storename"  class="text-danger"></span>
						</div>
                    </div>
                    <div class="col-lg-6">
						<div class="form-group">
							<label class="iconlabel">
								<div class="d-flex align-items-center">
									<img src="<?php echo e(asset('storage/app/public/asset_request/images/icons/SVG/awesome-phone.svg')); ?>" alt="">
									<span><?php echo e(__('Phone Number')); ?>*</span>
								</div>
							</label>
							<div class="mobile-number">
								<img src="<?php echo e(asset('storage/app/public/asset_request/images/germany-flag.png')); ?>" alt="">
								<!-- <span>+49</span> -->
								<input type="mobile" name="store_contact_number" value="<?php echo e(!empty($dataRequest['store_contact_number'])?$dataRequest['store_contact_number']:NULL); ?>" autocomplete="off" class="mail contact" placeholder="<?php echo e(__('Phone Number')); ?>">
							</div>
							<span id="phone" class="text-danger"></span>
						</div>
                    </div>
                    <div class="col-lg-6">
						<div class="form-group">
							<label class="iconlabel">
								<div class="d-flex align-items-center">
									<img src="<?php echo e(asset('storage/app/public/asset_request/images/icons/SVG/awesome-address-book.svg')); ?>" alt="">
									<span><?php echo e(__('Address')); ?>*</span>
								</div>
							</label>
							<?php echo e(Form::text('store_address',NULL,array('class'=>'house_number contact','autocomplete'=>'off','placeholder'=>__('Address'),'id'=>'id_address'))); ?>

							<div id="postal_code"></div>
							<div id="map_canvas"></div>
							<span id="address_error" class="text-danger"></span>
						</div>
                    </div>
                    <div class="col-lg-6">
						<div class="form-group">
							<label class="iconlabel">
								<div class="d-flex align-items-center">
									<img src="<?php echo e(asset('storage/app/public/asset_request/images/icons/SVG/awesome-link.svg')); ?>" alt="">
									<span><?php echo e(__('Website Link')); ?></span>
								</div>
							</label>
							<input type="text" name="store_link_id" value="<?php echo e(!empty($dataRequest['store_link_id'])?$dataRequest['store_link_id']:NULL); ?>"  placeholder="<?php echo e(__('Website Link')); ?>" autocomplete="off" class="mail contact">
							<span id="error_store_link_id"  class="text-danger"></span>
						</div>
                    </div>
					<div class="col-lg-12">
						<div class="form-group">
							<label class="iconlabel">
								<div class="d-flex align-items-center">
									<img src="<?php echo e(asset('storage/app/public/asset_request/images/icons/SVG/open-document.svg')); ?>" alt="">
									<span><?php echo e(__('Description')); ?></span>
									<small>
										<?php echo e(__('Description could also be implemented from your website')); ?><br />
										<?php echo e(__('If yes, please add your website link')); ?>

									</small>
								</div>
							</label>
							<textarea rows="6" name="store_description" placeholder="<?php echo e(__('Description')); ?>"><?php echo e(!empty($dataRequest['store_description'])?$dataRequest['store_description']:NULL); ?></textarea>
						</div>
                    </div>
				</div>
				<div class="row">
					<div class="col-12">
						<div class="form-group mb-2 mt-2">
							<label class="iconlabel">
								<div class="d-flex align-items-center">
									<img src="<?php echo e(asset('storage/app/public/asset_request/images/icons/SVG/Group7.svg')); ?>" alt="">
									<span><?php echo e(__('Select Category')); ?>*</span>
									
								</div>
							</label>
							<span id="category_error" class="text-danger"></span>
						</div>
					</div>
				</div>
				<div class="form-group-check">
					<div class="row">
						<?php $__currentLoopData = $categoriesArr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<div class="col-lg-4">
								<div class="inputGroup">
									<input id="<?php echo e($val->name); ?>" class="checkbox cat_select" <?php echo !empty($dataRequest['store_category']) && in_array($val->id, $dataRequest['store_category'])?'checked':''; ?> name="store_category[]" value="<?php echo e($val->id); ?>" type="checkbox"/>
									<label for="<?php echo e($val->name); ?>">
										<div class="icon_check">
											
											<img src="<?php echo e(asset('storage/app/public/asset_request/images/icons/category/category' . $val->id.'.svg')); ?>" alt="">
										</div>
										<p><?php echo e($val->name); ?></p>
									</label>
								</div>
							</div>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</div>
					
				</div>
					<div class="row">
						<div class="col-lg-12">
							<div class="form-group">
								
								 <div class="edit-basic-detail edit-languages-detail">
									<label class="iconlabel">
										<div class="d-flex align-items-center">
											<img src="<?php echo e(asset('storage/app/public/asset_request/images/icons/SVG/material-featured-play-list.svg')); ?>" alt="">
											<span><?php echo e(__('Features of the store')); ?> (<?php echo e(__('multiple selection')); ?>)</span>
										</div>
									</label>
									<span id="feature_error" class="text-danger"></span>
									<div class="select-arrows">
										<?php echo e(Form::select('feature_of_the_store[]', $features,NULL,array('class'=>'select2','id'=>'feature_of_the_store','multiple'=>'multiple'))); ?>

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
										<img src="<?php echo e(asset('storage/app/public/asset_request/images/icons/SVG/metro-blocked.svg')); ?>" alt="">
										<span><?php echo e(__('Cancellation period')); ?></span>
									</div>
								</label>
							</div>
						</div>
					</div>
					<div class="form-group">
						<ul class="checklists">
							<li>
								<div class="custom-control custom-checkbox">
									<?php echo e(Form::radio('cancellation_period', "48h", NULL, array("class"=>"custom-control-input checkmark", "id"=>"c48h"))); ?>

									<label class="custom-control-label" for="c48h"><span>48h</span></label>
								</div>
							</li>
							<li>
								<div class="custom-control custom-checkbox">
									<?php echo e(Form::radio('cancellation_period', "24h", NULL, array("class"=>"custom-control-input checkmark", "id"=>"c24h"))); ?>

									<label class="custom-control-label" for="c24h"><span>24h</span></label>
								</div>
							</li>
							<li>
								<div class="custom-control custom-checkbox">
									<?php echo e(Form::radio('cancellation_period', "12h", NULL, array("class"=>"custom-control-input checkmark", "id"=>"c12h"))); ?>

									<label class="custom-control-label" for="c12h"><span>12h</span></label>
								</div>
							</li>
							<li>
								<div class="custom-control custom-checkbox">
									<?php echo e(Form::radio('cancellation_period', "none", NULL, array("class"=>"custom-control-input checkmark", "id"=>"cnone"))); ?>

									<label class="custom-control-label" for="cnone"><span><?php echo e(__('none')); ?></span></label>
								</div>
							</li>
						</ul>
					</div>
					
					<div class="row">
						<div class="col-lg-12">
							<div class="form-group">
								<label class="iconlabel">
									<div class="d-flex align-items-center">
										<img src="<?php echo e(asset('storage/app/public/asset_request/images/icons/SVG/ionic-ios-wallet.svg')); ?>" alt="">
										<span><?php echo e(__('Payment methods on site')); ?> (<?php echo e(__('multiple selection')); ?>)</span>
									</div>
								</label>
							</div>
						</div>
					</div>
					<div class="form-group">
						<ul class="checklists">
							<li>
								<div class="custom-control custom-checkbox">
									<?php echo e(Form::checkbox('payment_method[]', __('Cash on delivery'), NULL, array("class"=>"custom-control-input checkmark paymentmethod", "id"=>"COD"))); ?>

									<label class="custom-control-label" for="COD"><span><?php echo e(__('Cash on delivery')); ?></span></label>
								</div>
							</li>
							<li>
								<div class="custom-control custom-checkbox">
									<?php echo e(Form::checkbox('payment_method[]', __('Online payments'), NULL, array("class"=>"custom-control-input checkmark paymentmethod", "id"=>"Online"))); ?>

									<label class="custom-control-label" for="Online"><span><?php echo e(__('Online payments')); ?></span></label>
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
											<h4 class="text-center mb-4 mt-4"><?php echo e(__('Opening Hours')); ?>*</h4>
										</div>
										<div class="hours-tabel-main">
											<div class="hours-tabel-head-wrap">
												<h6><?php echo e(__('Days')); ?></h6>
												<h6 class="text-center"><?php echo e(__('Timeline')); ?></h6>
												<h6 style="margin-right: -17px;"><?php echo e(__('Geschlossen')); ?></h6>
											</div>
											<?php if(!empty($dataRequest['day'])): ?>
												<?php $__currentLoopData = $dataRequest['day']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
													<div class="hours-tabel-body-wrap">
														<p><?php echo e($day); ?></p>
														<div class="hours-time-wrap">
															<?php echo e(Form::hidden('day[]',$day)); ?>

															<input type="text" value="<?php echo e(!empty($dataRequest['start_time'][$key])?$dataRequest['start_time'][$key]:NULL); ?>" class="timepicker start_time start_time_opening" name="start_time[]" placeholder=" -- --" data-id="<?php echo e($day); ?>">
															<span><?php echo e(__('to')); ?></span>
															<input type="text" class="timepicker end_time end_time_opening" value="<?php echo e(!empty($dataRequest['end_time'][$key])?$dataRequest['end_time'][$key]:NULL); ?>" name="end_time[]" placeholder=" -- --" data-id="<?php echo e($day); ?>">
														</div>
													   
														<label>
															<input type="checkbox" <?php echo !empty($dataRequest['weekDays'][$key]) && $dataRequest['weekDays'][$key] == 'on'?'checked':'' ?> name="weekDays[]" data-id="<?php echo e($day); ?>" class="weekdays weekdays_opening" id="<?php echo e($day); ?>-check">
															<span><i class="fas fa-check"></i></span>
														</label>
													</div>
												<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
											<?php else: ?>
												<div class="hours-tabel-body-wrap">
													<p>Montag</p>
													<div class="hours-time-wrap">
														<?php echo e(Form::hidden('day[]','Montag')); ?>

														<input type="text" class="timepicker start_time start_time_opening" name="start_time[]" placeholder=" -- --" data-id="Monday">
														<span><?php echo e(__('to')); ?></span>
														<input type="text" class="timepicker end_time end_time_opening" name="end_time[]" placeholder=" -- --" data-id="Monday">
													</div>
												   
													<label>
														<input type="checkbox" name="weekDays[]" data-id="Monday" class="weekdays weekdays_opening" id="monday-check">
														<span><i class="fas fa-check"></i></span>
													</label>
												</div>
												<div class="hours-tabel-body-wrap">
													<p>Dienstag</p>
													<div class="hours-time-wrap">
														<?php echo e(Form::hidden('day[]','Dienstag')); ?>

														<input type="text" class="timepicker start_time start_time_opening" name="start_time[]" placeholder=" -- --" data-id="Tuesday">
														<span><?php echo e(__('to')); ?></span>
														<input type="text" class="timepicker end_time end_time_opening" name="end_time[]" placeholder=" -- --" data-id="Tuesday">
													</div>
												   
													<label>
														<input type="checkbox" name="weekDays[]" data-id="Tuesday" class="weekdays weekdays_opening" id="tuesday-check" >
														<span><i class="fas fa-check"></i></span>
													</label>
												</div>
												<div class="hours-tabel-body-wrap  ">
													<p>Mittwoch</p>
													<div class="hours-time-wrap">
														<?php echo e(Form::hidden('day[]','Mittwoch')); ?>

														<input type="text" class="timepicker start_time start_time_opening" name="start_time[]" placeholder=" -- --" data-id="Wednesday">
														<span><?php echo e(__('to')); ?></span>
														<input type="text" class="timepicker end_time end_time_opening" name="end_time[]" placeholder=" -- --" data-id="Wednesday">
													</div>
												   
													<label>
														<input type="checkbox" name="weekDays[]" id="wednesday-check" class="weekdays weekdays_opening" data-id="Wednesday" >
														<span><i class="fas fa-check"></i></span>
													</label>
												</div>
												<div class="hours-tabel-body-wrap">
													<p>Donnerstag</p>
													<div class="hours-time-wrap">
														<?php echo e(Form::hidden('day[]','Donnerstag')); ?>

														<input type="text" class="timepicker start_time start_time_opening" name="start_time[]" placeholder=" -- --" data-id="Thursday">
														<span><?php echo e(__('to')); ?></span>
														<input type="text" class="timepicker end_time end_time_opening" name="end_time[]" placeholder=" -- --" data-id="Thursday">
													</div>
												   
													<label>
														<input type="checkbox" name="weekDays[]" id="thursday-check" class="weekdays weekdays_opening" data-id="Thursday" >
														<span><i class="fas fa-check"></i></span>
													</label>
												</div>
												<div class="hours-tabel-body-wrap ">
													<p>Freitag</p>
													<div class="hours-time-wrap">
														<?php echo e(Form::hidden('day[]','Freitag')); ?>

														<input type="text" class="timepicker start_time start_time_opening" name="start_time[]" placeholder=" -- --" data-id="Friday">
														<span><?php echo e(__('to')); ?></span>
														<input type="text" class="timepicker end_time end_time_opening" name="end_time[]" placeholder=" -- --" data-id="Friday">
													</div>
													
													<label>
														<input type="checkbox" name="weekDays[]" id="friday-check" class="weekdays weekdays_opening" data-id="Friday">
														<span><i class="fas fa-check"></i></span>
													</label>
												</div>
												<div class="hours-tabel-body-wrap  ">
													<p>Samstag</p>
													<div class="hours-time-wrap">
														<?php echo e(Form::hidden('day[]','Samstag')); ?>

														<input type="text" class="timepicker start_time start_time_opening" name="start_time[]" placeholder=" -- --" data-id="Saturday">
														<span><?php echo e(__('to')); ?></span>
														<input type="text" class="timepicker end_time end_time_opening" name="end_time[]" placeholder=" -- --" data-id="Saturday">
													</div>
												  
													<label>
														<input type="checkbox" name="weekDays[]" data-id="Saturday" class="weekdays weekdays_opening" id="saturday-check" >
														<span><i class="fas fa-check"></i></span>
													</label>
												</div>
												<div class="hours-tabel-body-wrap  ">
													<p>Sonntag</p>
													<div class="hours-time-wrap">
														<?php echo e(Form::hidden('day[]','Sonntag')); ?>

														<input type="text" class="timepicker start_time start_time_opening" name="start_time[]" placeholder=" -- --" data-id="Sunday">
														<span><?php echo e(__('to')); ?></span>
														<input type="text" class="timepicker end_time end_time_opening" name="end_time[]" placeholder=" -- --" data-id="Sunday">
													</div>
													
													<label>
														<input type="checkbox" name="weekDays[]" id="sunday-check" class="weekdays weekdays_opening" data-id="Sunday">
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
					
					<div class="row">
						<div class="col-12">
							<div class="form-group">
								<div class="d-flex align-items-center justify-content-between position-relative">
									<p>&nbsp;</p>
									<h5 class="sechead"><?php echo e(__('Advantages')); ?></h5>
									<a class="btn btn-add-icon d-flex align-items-center add_advantages" rel="<?php echo e(!empty($dataRequest['advantages'])?max(array_keys($dataRequest['advantages'])):1); ?>" href="javascript:void(0);"><span><i class="fa fa-plus"></span></i>&nbsp;&nbsp;<?php echo e(__('Add')); ?></a>
								</div>
							</div>
						</div>
						<div class="col-lg-12">
							<div class="form-group">
								<label class="iconlabel">
									<div class="d-flex align-items-center">
										<img src="<?php echo e(asset('storage/app/public/asset_request/images/icons/SVG/simple-microsoftexcel.svg')); ?>" alt="">
										<span><?php echo e(__('Upload a table from excel with advantages data')); ?></span>
									</div>
									
								</label>
								<small class="text-right w-100"><?php echo e(__('Allowed file formats are doc, excel, text, pdf, images')); ?></small>
								 <div class="field">
									<small class="text-right w-100"><?php echo e(__('Max upload size 10mb')); ?></small>
									<?php /* <input type="file" id="adv_datafile" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint,text/plain, application/pdf, .jpg,.jpeg,.png,.gif, .bmp, .ico, .tiff, .svg,.webp" onchange="loadFileExcel(event, 'adv_datafile')" class="store_profile files_xls" name="advantage_data_file" /> */ ?>
									<input type="file" id="adv_datafile" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint,text/plain, application/pdf, .jpg,.jpeg,.png,.gif, .bmp, .ico, .tiff, .svg,.webp" onchange="loadFileExcel(event, 'adv_datafile')" class="store_profile files_xls" name="advantage_data_file" />
									<div class="files-upload-box">
										<img src="<?php echo e(asset('storage/app/public/asset_request/images/icons/SVG/upload_icon.svg')); ?>" alt="">
									</div>
								</div>
								<span class="position-relative" id="xlx_adv_datafile">
									<?php echo e(!empty($dataRequest['advantage_data'])?$dataRequest['advantage_data']:NULL); ?>

									<?php if(!empty($dataRequest['customer_data'])): ?>
										<a href="javascript:void(0);" class="remove_xlx ml-2 " id="remove_xlx_adv_datafile" rel="adv_datafile"><i class="fa fa-times-circle"></i></a>
									<?php endif; ?>
								</span>
							</div>
						</div>
					</div>
					<div id="advantages">
						<?php if(!empty($dataRequest['advantages'])): ?>
							<?php $__currentLoopData = $dataRequest['advantages']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=> $adv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<?php echo $__env->make('RequestForm/advantages', ['i' => $i], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						<?php else: ?>
							<?php echo $__env->make('RequestForm/advantages', ['i' => 1], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
						<?php endif; ?>
					</div>
					
				<div class="row">
					<div class="col-12">
						<div class="form-group">
							<div class="d-flex align-items-center justify-content-between position-relative">
								<p>&nbsp;</p>
								<h5 class="sechead"><?php echo e(__('Public transport')); ?></h5>
								<a class="btn btn-add-icon d-flex align-items-center add_transportation" rel="<?php echo e(!empty($dataRequest['transportations'])?max(array_keys($dataRequest['transportations'])):1); ?>" href="javascript:void(0);"><span><i class="fa fa-plus"></span></i>&nbsp;&nbsp;<?php echo e(__('Add')); ?></a>
							</div>
						</div>
					</div>
				</div>
				
				<div id="transportations">
					<?php if(!empty($dataRequest['transportations'])): ?>
						<?php $__currentLoopData = $dataRequest['transportations']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=> $adv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php echo $__env->make('RequestForm/transportations', ['i' => $i], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					<?php else: ?>
						<?php echo $__env->make('RequestForm/transportations', ['i' => 1], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
					<?php endif; ?>
				</div>
				
				
				<div class="row">
					<div class="col-12">
						<div class="form-group">
							<h5 class="sechead"><?php echo e(__('Customer')); ?></h5>
						</div>
					</div>
					
					<div class="col-lg-12">
						<div class="form-group">
							<label class="iconlabel">
								<div class="d-flex align-items-center">
									<img src="<?php echo e(asset('storage/app/public/asset_request/images/icons/SVG/simple-microsoftexcel.svg')); ?>" alt="">
									<span><?php echo e(__('Upload a table from excel with customer data')); ?></span>
								</div>
							</label>
							<small class="text-right w-100"><?php echo e(__('Allowed file formats are doc, excel, text, pdf, images')); ?></small>
							 <div class="field">
								<small class="text-right w-100"><?php echo e(__('Max upload size 10mb')); ?></small>
								<input type="file" id="cust_datafile" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint,text/plain, application/pdf, .jpg,.jpeg,.png,.gif, .bmp, .ico, .tiff, .svg,.webp"  onchange="loadFileExcel(event, 'cust_datafile')" class="store_profile files_xls" name="customer_data_file" />
								<div class="files-upload-box">
									<img src="<?php echo e(asset('storage/app/public/asset_request/images/icons/SVG/upload_icon.svg')); ?>" alt="">
								</div>
							</div>
							<span class="position-relative" id="xlx_cust_datafile">
								<?php echo e(!empty($dataRequest['customer_data'])?$dataRequest['customer_data']:NULL); ?>

								<?php if(!empty($dataRequest['customer_data'])): ?>
									<a href="javascript:void(0);" class="remove_xlx ml-2 " id="remove_xlx_cust_datafile" rel="cust_datafile"><i class="fa fa-times-circle"></i></a>
								<?php endif; ?>
							</span>
						</div>
                    </div>
				
					<div class="col-lg-12">
						<div class="form-group">
							<label class="iconlabel">
								<div class="d-flex align-items-center">
									<img src="<?php echo e(asset('storage/app/public/asset_request/images/icons/SVG/metro-profile.svg')); ?>" alt="">
									<span><?php echo e(__('Profile Image')); ?> <small class="text-right"><?php echo e(__('Max upload size 10mb')); ?></small></span>
								</div>
							</label>
							<div class="image-box" rel="imgUpload" id="image_drop_area">
								<div class="customer-image">
									<img id="image_imgUpload" src="<?php echo e(asset('storage/app/public/asset_request/images/icons/PNG/Group30.png')); ?>">
								</div>
								<label id="file_name" for="imgUpload" class="d-flex align-items-center" >
									<p class="ml-20 mr-5"></p>
									<?php echo e(Form::hidden('customer_image_name', NULL)); ?>

									<input id="imgUpload" type="file" name="customer_image" accept=".jpg,.jpeg,.png,.gif, .bmp, .ico, .tiff, .svg,.webp" onchange="loadFile(event, 'imgUpload')">
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
									<span><?php echo e(__('Name')); ?></span>
								</div>
							</label>
							<?php echo e(Form::text('customer_name',NULL,array('class'=>'storname contact','autocomplete'=>'off','placeholder'=>__('Name')))); ?>

							<span id="customer_name" class="text-danger"></span>
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
							<?php echo e(Form::text('cust_address',NULL,array('class'=>'house_number contact','autocomplete'=>'off','id'=>'cus_address','placeholder'=>__('Address')))); ?>

							<div id="cus_postal_code"></div>
							<div id="cus_map_canvas"></div>
							<span id="cus_addr" class="text-danger"></span>
						</div>
                    </div>
                    
                    <div class="col-lg-6">
						<div class="form-group">
							<label class="iconlabel">
								<div class="d-flex align-items-center">
									<img src="<?php echo e(asset('storage/app/public/asset_request/images/icons/SVG/zocial-email.svg')); ?>" alt="">
									<span><?php echo e(__('Email')); ?></span>
								</div>
							</label>
							<input type="email" name="customer_email" value="<?php echo e(!empty($dataRequest['customer_email'])?$dataRequest['customer_email']:NULL); ?>" placeholder="<?php echo e(__('Email')); ?>" autocomplete="off" class="mail contact">
							<span id="customer_email" class="text-danger"></span>
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
							<?php echo e(Form::select('customer_country',$countries,NULL,array('class'=>'select select-time'))); ?>

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
								<input type="mobile" name="customer_phone" value="<?php echo e(!empty($dataRequest['customer_phone'])?$dataRequest['customer_phone']:NULL); ?>"  autocomplete="off" class="mail contact" placeholder="<?php echo e(__('Phone Number')); ?>">
								<span class="text-danger"></span>
							</div>
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
							<?php echo e(Form::text('postal_code',NULL,array('class'=>'lname contact', 'id'=>'zipcodecus_address', 'placeholder'=>__('Postal Code'), 'autocomplete'=>'off'))); ?>

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
									<h5 class="sechead"><?php echo e(__('Employees')); ?>*</h5>
									<a class="btn btn-add-icon d-flex align-items-center add_employees" rel="<?php echo e(!empty($dataRequest['employees'])?max(array_keys($dataRequest['employees'])):1); ?>" href="javascript:void(0);"><span><i class="fa fa-plus"></span></i>&nbsp;&nbsp;<?php echo e(__('Add')); ?></a>
								</div>
							</label>
						</div>
					</div>
					<div class="col-lg-12">
						<div class="form-group">
							<label class="iconlabel">
								<div class="d-flex align-items-center">
									<img src="<?php echo e(asset('storage/app/public/asset_request/images/icons/SVG/simple-microsoftexcel.svg')); ?>" alt="">
									<span><?php echo e(__('Upload a table from excel with employee data')); ?></span>
								</div>
							</label>
							
							<small class="text-right w-100"><?php echo e(__('Allowed file formats are doc, excel, text, pdf, images')); ?></small>
							 <div class="field">
								<small class="text-right w-100"><?php echo e(__('Max upload size 10mb')); ?></small>
								<input type="file" id="emp_datafile" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint,text/plain, application/pdf, .jpg,.jpeg,.png,.gif, .bmp, .ico, .tiff, .svg,.webp"  onchange="loadFileExcel(event, 'emp_datafile')" class="store_profile files_xls" name="employee_data_file" />
								<div class="files-upload-box">
									<img src="<?php echo e(asset('storage/app/public/asset_request/images/icons/SVG/upload_icon.svg')); ?>" alt="">
									<small class="text-webcolor"><i>Bitte fügen Sie den Namen, die E-Mail Adresse, die Kategorien und die Arbeitszeiten Ihrer Mitarbeiter ein.</i></small>
								</div>
							</div>
							
							<span class="position-relative" id="xlx_emp_datafile">
								<?php echo e(!empty($dataRequest['employee_data'])?$dataRequest['employee_data']:NULL); ?>

								<?php if(!empty($dataRequest['employee_data'])): ?>
									<a href="javascript:void(0);" class="remove_xlx ml-2 " id="remove_xlx_emp_datafile" rel="emp_datafile"><i class="fa fa-times-circle"></i></a>
								<?php endif; ?>
							</span>
						</div>
                    </div>
				</div>
				<div class="text-right mb-1">*mind. einen Mitarbeiter hinzufügen</div>
				<div class="accordion" id="accordionExample">
					<?php if(!empty($dataRequest['employees'])): ?>
						<?php $__currentLoopData = $dataRequest['employees']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php echo $__env->make('RequestForm/employees', ['i' =>$k, 'category' => $category, 'languages' => $languages, 'countries' => $countries], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					<?php else: ?>
						<?php for($i=1;$i<=1; $i++): ?>
							<?php echo $__env->make('RequestForm/employees', ['i' => $i, 'category' => $category, 'languages' => $languages, 'countries' => $countries], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
						<?php endfor; ?>
					<?php endif; ?>
				</div>
            </div>
            <div class="letscountinuesbtn">
                <button class="letscontinues" type="submit"><?php echo e(__('Continue')); ?></button>
            </div>
		<?php echo e(Form::close()); ?>

    </div>
</section>
 
<script>
	<?php if(!empty($dataRequest['customer_image_name'])): ?>
		var imagename = "<?php echo e($dataRequest['customer_image_name']); ?>";
		$('#image_imgUpload').attr('src', "<?php echo e(asset('storage/app/public/requestFormTemp')); ?>/"+imagename);
	<?php endif; ?>
	<?php if(!empty($dataRequest['employees'])): ?>
		<?php $__currentLoopData = $dataRequest['employees']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			var id = "<?php echo e($k); ?>";
			<?php if(!empty($item['imagename'])): ?>
				var imagename = "<?php echo e($item['imagename']); ?>";
				$('#image_imgUpload'+id).attr('src', "<?php echo e(asset('storage/app/public/requestFormTemp')); ?>/"+imagename);
			<?php endif; ?>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	<?php endif; ?>
	
	function is_valid_url(url) {
		return /^(http(s)?:\/\/)?(www\.)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/.test(url);
	}
	function validate() {
		 var isvalid = true;
		
		 var storename = document.myform.store_name.value;
		 var Address = document.myform.store_address.value;
		 var Phone = document.myform.store_contact_number.value;
		 var customer_email = document.myform.customer_email.value;
		 var customer_name = document.myform.customer_name.value;
		 var customer_name = document.myform.customer_name.value;
		 var url = document.myform.store_link_id.value;
		 //var employees = document.myform.employees.value;
		 var lengthfile = $('#xlx_emp_datafile').text();
		 lengthfile = $.trim(lengthfile);
		 
		 $(".weekdays_opening").each(function(){
			 var id = $(this).data('id');
			 if ($(this).prop('checked') == true) {
				 $('.end_time[data-id=' + id + ']').css('border-color', "hsl(218deg 43% 11% / 20%)");
				 $('.start_time[data-id=' + id + ']').css('border-color', "hsl(218deg 43% 11% / 20%)");
			 }else{
				  var start_time_opening = $('.start_time_opening[data-id=' + id + ']').val();
				  var end_time_opening = $('.end_time_opening[data-id=' + id + ']').val();
				  if(start_time_opening == ""){
					  $('.start_time_opening[data-id=' + id + ']').css('border-color', 'red');
					  isvalid = false;
				  }else{
					  $('.start_time[data-id=' + id + ']').css('border-color', "hsl(218deg 43% 11% / 20%)");
				  }
				  if(end_time_opening == ""){
					  $('.end_time_opening[data-id=' + id + ']').css('border-color', 'red');
					  isvalid = false;
				  }else{
					  $('.end_time[data-id=' + id + ']').css('border-color', "hsl(218deg 43% 11% / 20%)");
				  }
			 }
		 });
		if(lengthfile.length > 3){
			
			$(".empname").each(function(){
				$(this).next('span.text-danger').html("");
			});
			$(".empemail").each(function(){
				$(this).next('span.text-danger').html("");
			});
			$(".empphone").each(function(){
				var empphoneid = $(this).attr('rel');
				$('#employee_'+empphoneid+'_phone').html("");
			});
			$(".emp_select").each(function(){
					var empcatid = $(this).attr('rel');
					$('#employee_'+empcatid+'_category').html("");
			  }); 
			 $(".employee_timing").each(function(){
				   rel  = $(this).attr('rel');
				    $(".employee_opening"+rel).each(function(){
						 var id = $(this).data('id');
						  $('.end_time[data-id=' + id + ']').css('border-color', "hsl(218deg 43% 11% / 20%)");
							$('.start_time[data-id=' + id + ']').css('border-color', "hsl(218deg 43% 11% / 20%)");
					})
			 });
		}else{
			
			 $(".empname").each(function(){
					if($(this).val() == ""){
						$(this).next('span.text-danger').html("<?php echo e(__('Please Enter Employee name')); ?>");
						
						isvalid = false;
					}else{
						$(this).next('span.text-danger').html("");
					}
			  });
			  
			  
			   $(".employee_timing").each(function(){
				   rel  = $(this).attr('rel');
				    $(".employee_opening"+rel).each(function(){
						 var id = $(this).data('id');
						 if ($(this).prop('checked') == true) {
							 $('.end_time[data-id=' + id + ']').css('border-color', "hsl(218deg 43% 11% / 20%)");
							 $('.start_time[data-id=' + id + ']').css('border-color', "hsl(218deg 43% 11% / 20%)");
						 }else{
							  var start_time_opening = $('.start_time[data-id=' + id + ']').val();
							  var end_time_opening = $('.end_time[data-id=' + id + ']').val();
							  if(start_time_opening == ""){
								  $('.start_time[data-id=' + id + ']').css('border-color', 'red');
								  isvalid = false;
							  }else{
								  $('.start_time[data-id=' + id + ']').css('border-color', "hsl(218deg 43% 11% / 20%)");
							  }
							  if(end_time_opening == ""){
								  $('.end_time[data-id=' + id + ']').css('border-color', 'red');
								  isvalid = false;
							  }else{
								  $('.end_time[data-id=' + id + ']').css('border-color', "hsl(218deg 43% 11% / 20%)");
							  }
						 }
					 });
			   });
			 
			  
			 /*  $(".empphone").each(function(){
					var empphoneid = $(this).attr('rel');
					
					if($(this).val() == ""){
						$('#employee_'+empphoneid+'_phone').html("<?php echo e(__('Please Enter Employee phone')); ?>");
						isvalid = false;
					}else{
						$('#employee_'+empphoneid+'_phone').html("");
					}
			  }); */
			  
			   $(".emp_select").each(function(){
					var empcatid = $(this).attr('rel');
					var count = $(this).find('option:selected').length;
					if(count == 0){
						$('#employee_'+empcatid+'_category').html("<?php echo e(__('Please Select Category')); ?>");
						isvalid = false;
					}else{
						$('#employee_'+empcatid+'_category').html("");
					}
			  }); 
			  
			   $(".empemail").each(function(){
					if($(this).val() == ""){
						$(this).next('span.text-danger').html("<?php echo e(__('Please Enter Employee email')); ?>");
						isvalid = false;
					}else{
						$(this).next('span.text-danger').html("");
					}
			  });
		}
		   
		/* var count = $('#feature_of_the_store').find('option:selected').length;
		 if (count == 0) {
			 document.getElementById("feature_error").innerHTML = "<?php echo e(__('Select feature of store')); ?>";
            isvalid = false;
        } else {
            document.getElementById("feature_error").innerHTML = "";
        } */
		if (storename == null || storename == "") {
			 document.getElementById("storename").innerHTML = "<?php echo e(__('Please Enter Shop name')); ?>";
            isvalid = false;
        } else {
            document.getElementById("storename").innerHTML = "";
        }
		
		if (Phone == null || Phone == "") {
            document.getElementById("phone").innerHTML = "<?php echo e(__('Please Enter Mobile Number')); ?>";
            isvalid = false;
        } else if (isNaN(Phone)) {
            document.getElementById("phone").innerHTML = "<?php echo e(__('Please enter only digite')); ?>";
            isvalid = false;
        } else if (Phone.length < 11 || Phone.length > 13) {
            document.getElementById("phone").innerHTML = "<?php echo e(__('Please enter min 11 digite')); ?>";
            isvalid = false;
        } else {
            document.getElementById("phone").innerHTML = "";
        }
		
		if (Address == null || Address == "") {
            document.getElementById("address_error").innerHTML = "<?php echo e(__('Please Enter Address')); ?>";
           isvalid = false;
        } else {
            document.getElementById("address_error").innerHTML = "";
        }
		
		if (url == null || url == "") {
            document.getElementById("error_store_link_id").innerHTML = "";
        }else if(is_valid_url(url)){
			 document.getElementById("error_store_link_id").innerHTML = "";
		}else{
			 document.getElementById("error_store_link_id").innerHTML = "<?php echo e(__('Please Enter valid url')); ?>";
			isvalid = false;
		}
		
		var boxes = $('.checkbox');
		if (boxes.filter(':checked').length == 0) {
			document.getElementById("category_error").innerHTML = "<?php echo e(__('Please Select Category')); ?>";
			 isvalid = false;
		}else{
			document.getElementById("category_error").innerHTML = "";
		}
		
		/* var paymentmethod = $('.paymentmethod');
		if (paymentmethod.filter(':checked').length == 0) {
			document.getElementById("paymentmethod_error").innerHTML = "<?php echo e(__('Please Select payment method')); ?>";
			 isvalid = false;
		}else{
			document.getElementById("paymentmethod_error").innerHTML = "";
		} 
		
		if (customer_name == null || customer_name == "") {
			 document.getElementById("customer_name").innerHTML = "<?php echo e(__('Please Enter Customer name')); ?>";
            isvalid = false;
        } else {
            document.getElementById("customer_name").innerHTML = "";
        }
		
		if (customer_email == null || customer_email == "") {
            document.getElementById("customer_email").innerHTML = "<?php echo e(__('Please Enter Customer Email')); ?>";
            return false;
        } else {
            document.getElementById("customer_email").innerHTML = "";
        } */
		if(!isvalid){
			swal("<?php echo e(__('Alert')); ?>!", "<?php echo e(__('Please provide all the required information')); ?>", "error");
		}
		return isvalid;
		
    }
	
	$('.collapse').on('shown.bs.collapse', function () {
		 $(this).prev().find('.fas').removeClass("fa-caret-right").addClass("fa-caret-down");
	});

	$('.collapse').on('hidden.bs.collapse', function () {
		 $(this).prev().find('.fas').removeClass("fa-caret-down").addClass("fa-caret-right");
	});

	var categoryAll = <?php echo json_encode($category); ?>;

$('body').on('change', '.cat_select', function(){
	var scat = [];
	var selected = $(this).val();
	
	$('.cat_select').each(function () {
		if ($(this).is(':checked')) {
			scat.push($(this).val());
		}
	});
	localStorage.setItem('category', JSON.stringify(scat));
	
	$(".emp_select").each(function(){
		var selectedVal = $(this).val();
		 $(this).empty();
		 var object = $(this);
		 $.each(scat, function(index, item) { 
			
			if (object.find("option[value='" + item + "']").length) {
				object.val(item).trigger('change');
			} else { 
				// Create a DOM Option and pre-select by default
				var newOption = new Option(categoryAll[item], item, false, false);
				// Append it to the select
				object.append(newOption).trigger('change');
			}
		});
		object.val(selectedVal).trigger('change');
	});
});

var rel = 3;
$('body').on('click', '.add_employees', function(){
	rel = $(this).attr('rel');
	rel++;
	$(this).attr('rel', rel);
	$.ajax({
		type: 'POST',
		url: '<?php echo e(route("add_req_employee")); ?>',
		data: {
			_token: token,
			rel: rel,
		},
		// beforesend: $('#loading').css('display', 'block'),
		success: function (response) {
			$("#accordionExample").append(response);
			changeEmpCat();
		}
	});
});
changeEmpCat();
function changeEmpCat(){
	var catselected = 0;
	$('.cat_select').each(function () {
		if ($(this).is(':checked')) {
			catselected = 1;
		}
	});
	if(catselected == 0){
		localStorage.removeItem("category"); 
		return false;
	}
	var scat  = JSON.parse(localStorage.getItem("category"));
	// $('#loading').css('display', 'none');
	$(".emp_select").each(function(){
		var selectedVal = $(this).val();
		 $(this).empty();
		 var object = $(this);
		 $.each(scat, function(index, item) { 
			
			if (object.find("option[value='" + item + "']").length) {
				object.val(item).trigger('change');
			} else { 
				// Create a DOM Option and pre-select by default
				var newOption = new Option(categoryAll[item], item, false, false);
				// Append it to the select
				object.append(newOption).trigger('change');
			}
		});
		object.val(selectedVal).trigger('change');
	});
}

$('body').on('click', '.remove_employees', function(){
	rel = $(this).attr('rel');
	$("#employee_div"+rel).remove();
});
$('body').on('click', '.add_advantages', function(){
	rel = $(this).attr('rel');
	rel++;
	$(this).attr('rel', rel);
	$.ajax({
		type: 'POST',
		url: '<?php echo e(route("add_req_advantages")); ?>',
		data: {
			rel: rel,
			_token: token
		},
		// beforesend: $('#loading').css('display', 'block'),
		success: function (response) {
			$("#advantages").append(response);
			// $('#loading').css('display', 'none');
		}
	});
});

$('body').on('click', '.remove_advantages', function(){
	rel = $(this).attr('rel');
	$("#advantage_div"+rel).remove();
});

$('body').on('click', '.add_transportation', function(){
	rel = $(this).attr('rel');
	rel++;
	$(this).attr('rel', rel);
	$.ajax({
		type: 'POST',
		url: '<?php echo e(route("add_req_transportations")); ?>',
		data: {
			rel: rel,
			_token: token
		},
		// beforesend: $('#loading').css('display', 'block'),
		success: function (response) {
			$("#transportations").append(response);
			// $('#loading').css('display', 'none');
		}
	});
});

$('body').on('click', '.remove_transportation', function(){
	rel = $(this).attr('rel');
	$("#transport_div"+rel).remove();
});

 var loadFile = function (event, id) {

	var reader = new FileReader();
	var filesize = event.target.files[0].size;
	var sizeInMB = (filesize / (1024*1024)).toFixed(2);
	if(sizeInMB > 10){
		swal("Alert!", "<?php echo e(__('Maximum allowed file size is 10 MB')); ?>", "error");
		$('#'+id).val("");
		return false;
	}
	reader.onload = function () {
		var output = document.getElementById('image_'+id);
		output.src = reader.result;
	};
	reader.readAsDataURL(event.target.files[0]);
};
		
/* const image_drop_area = document.querySelector("#image_drop_area");
var uploaded_image;
var img_rel;
// Event listener for dragging the image over the div
image_drop_area.addEventListener('dragover', (event) => {
	
  event.stopPropagation();
  event.preventDefault();
  // Style the drag-and-drop as a "copy file" operation.
  event.dataTransfer.dropEffect = 'copy';
});

// Event listener for dropping the image inside the div
image_drop_area.addEventListener('drop', (event) => {
	var img_id = event.target.id;
	
	img_rel = $('#'+img_id).attr('rel');
  event.stopPropagation();
  event.preventDefault();
  fileList = event.dataTransfer.files;

  //document.querySelector("#file_name").textContent = fileList[0].name;
  
  readImage(fileList[0]);
});

// Converts the image into a data URI
readImage = (file) => {
  const reader = new FileReader();
  reader.addEventListener('load', (event) => {
	 
    uploaded_image = event.target.result;
    //document.querySelector(".customer-image").style.backgroundImage = `url(${uploaded_image})`;
	var image_url = `url(${uploaded_image})`;
	$("#image_"+img_rel).attr('src', uploaded_image);
  });
  reader.readAsDataURL(file);
} */
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.request', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/RequestForm/index.blade.php ENDPATH**/ ?>