<?php $__env->startSection('service_title'); ?>
    Customer List
<?php $__env->stopSection(); ?>
<?php $__env->startSection('service_css'); ?>
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
<?php $__env->stopSection(); ?>
<?php $__env->startSection('service_content'); ?>
    <div class="main-content">
        <div class="page-title-div">
            <h2 class="page-title">Kunden</h2>
            <p><a href="<?php echo e(URL::to('dienstleister/kunden')); ?>">Kunden</a> <span>/ Kundeninformationen </span></p>
        </div>
        <div class="cd-main-wrap">
            <div class="cd-main-profile">
                 <?php if($customer['is_appo'] != 'yes'): ?>
                <?php if(file_exists(storage_path('app/public/store/customer/'.@$customer['image'])) && @$customer['image'] != ''): ?>
                    <img src="<?php echo e(URL::to('storage/app/public/store/customer/'.@$customer['image'])); ?>"
                         alt="user">
                <?php elseif(\BaseFunction::getUserDetailsByEmail(@$customer->email, 'user_image_path')): ?>
					 <img src="<?php echo e(\BaseFunction::getUserDetailsByEmail(@$customer->email, 'user_image_path')); ?>"
                         alt="user">
				<?php else: ?>
					<?php
						$cusnameArr = explode(" ", $customer->name);
						$custname = "";
						if(count($cusnameArr) > 1){
							$custname = strtoupper(substr($cusnameArr[0], 0, 1)).strtoupper(substr($cusnameArr[1], 0, 1));
						}else{
							$custname = strtoupper(substr( $customer->name, 0, 2));
						}
					?>
                    <img
                        src="https://via.placeholder.com/1080x1080/00000/FABA5F?text=<?php echo e($custname); ?>"
                        alt="user">
                <?php endif; ?>
                <?php else: ?> 
                 <img
                        src="https://via.placeholder.com/1080x1080/00000/FABA5F?text=<?php echo e(strtoupper(substr($customer['first_name'], 0, 1))); ?><?php echo e(strtoupper(substr($customer['last_name'], 0, 1))); ?>"
                        alt="user">
                <?php endif; ?>
            </div>
            <div class="cd-main-profile-info">
                <h4> <?php if($customer['is_appo'] == 'yes'): ?><?php echo e($customer['first_name']); ?>  <?php echo e($customer['last_name']); ?><?php else: ?> <?php echo e($customer['name']); ?> <?php endif; ?></h4>
                <h6><?php echo e(@$customer['address']); ?></h6>
                <ul>
                    <li>
                        <p>Telefon <a href="tel:<?php echo e(@$customer['phone_number']); ?>"><?php echo e(@$customer['phone_number']); ?></a>
                        </p>
                    </li>
                    <li>
                        <p>E-Mail <a href="mailto:<?php echo e(@$customer['email']); ?>"><?php echo e(@$customer['email']); ?></a></p>
                    </li>
                </ul>
            </div>
            <div class="cd-main-action-info">
                <?php if($customer['is_appo'] != 'yes'): ?>
                <a class="delete-icon" data-id="<?php echo e($customer['id']); ?>"  href="#"><img
                        src="<?php echo e(URL::to('storage/app/public/Serviceassets/images/icon/delete-2.svg')); ?>" alt=""></a>
                        <?php endif; ?>
                <ul>
                    <li>
                        <p>Buchungen: <span> <?php echo e($customerData['total_booking']); ?></span></p>
                    </li>
                    <li>
                        <p>Zahlungen: <span> <?php echo e(number_format($customerData['total_payment'], 2, ',', '.')); ?>€</span></p>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row view-rows view-rows2">
            <div class="col-lg-12">
                <div class="bservices-heading-wrap">
                    <h5>Buchungen</h5>
                    <div>
                        
                        
                        
                        
                        
                        
                    </div>
                </div>
                <?php $__currentLoopData = $appointment; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="appointment-item completed-appointment-item" rel="<?php echo e(($row['id'])); ?>">
                        <div class="appointment-profile-wrap">
                            <div class="appointment-profile-left">
                                <div class="appointment-profile-img">
                                    <?php if(file_exists(storage_path('app/public/user/'.@$row->userDetails->profile_pic)) && @$row->userDetails->profile_pic != ''): ?>
                                        <img
                                            src="<?php echo e(URL::to('storage/app/public/user/'.@$row->userDetails->profile_pic)); ?>"
                                            class="rounded avatar-sm"
                                            alt="user">
											<?php $imageuser = URL::to('storage/app/public/user/'.@$row->userDetails->profile_pic); ?>
                                    <?php else: ?>
                                        <img
                                            src="https://via.placeholder.com/1080x1080/00000/FABA5F?text=<?php echo e(strtoupper(substr($row['first_name'], 0, 1))); ?><?php echo e(strtoupper(substr($row['last_name'], 0, 1))); ?>"
                                            alt="user">
											<?php $imageuser = 'https://via.placeholder.com/1080x1080/00000/FABA5F?text='.strtoupper(substr($row['first_name'], 0, 1)).strtoupper(substr($row['last_name'], 0, 1)); ?>
                                    <?php endif; ?>
                                        <?php if(file_exists(storage_path('app/public/service/'.$row->image)) && $row->image != ''): ?>

                                            <div
                                                style="display: none"><?php echo e($imge = URL::to('storage/app/public/service/'.$row->image)); ?></div>
                                        <?php else: ?>
                                            <div
                                                style="display: none"><?php echo e($imge = URL::to('storage/app/public/default/default-user.png')); ?></div>
                                        <?php endif; ?>
                                </div>
                                <div class="appointment-profile-info">
                                    <h5><?php echo e(@$row->first_name); ?> <?php echo e(@$row->last_name); ?></h5>
                                    <ul class="appointment-d-block">
                                        <li>
                                            <p>Buchungs-ID: <span> #<?php echo e($row->order_id); ?></span></p>
                                        </li>
                                        <li>
                                            <p>Status:
                                                <?php if($row->status == 'booked' || $row->status == 'pending'): ?>
                                                    <span class="new-appointment-label"> <?php echo e($row->status == 'booked' ? 'Neu' : 'Steht aus'); ?></span>
                                                <?php elseif($row->status == 'running' || $row->status == 'reschedule'): ?>
                                                    <span class="running-label"> <?php echo e($row->status == 'running' ? 'Aktiv' : 'Verschoben'); ?></span>
                                                <?php elseif($row->status == 'completed'): ?>
                                                    <span class="completed-label"> Erledigt </span>
                                                <?php elseif($row->status == 'cancel'): ?>
                                                    <span class="cancel-label"> Storniert </span>
                                                <?php endif; ?>
                                            </p>
                                        </li>
										<?php if($row->status == 'cancel'): ?>
											<li>
												<a style="color: #DB8A8A;text-decoration: underline;" href="javascript:void(0);" class="cancel_reason" data-image="<?php echo e($imageuser); ?>"
												   data-booking="<?php echo e($row->order_id); ?>"
												   data-service="<?php echo e($row['service_name']); ?>"
												   data-cancelledby="<?php echo e($row['cancelled_by']); ?>"
												   data-storename="Customer"
												   data-description="<?php echo e(@$row['variantData']['description']); ?>"
												   data-reason="<?php echo e($row['cancel_reason']); ?>">
													Stornierungsgrund
												</a>
											</li>
										<?php endif; ?>
                                    </ul>
                                </div>
                            </div>
                            <div class="appointment-profile-right">
                                <div class="app-payment-info-type">
									 <p>Bezahlt mit  <i></i> <span><?php echo e(ucfirst($row->payment_method == 'cash' ? 'vor Ort' : ((strtolower($row->payment_method) == 'stripe' && !empty($row->card_type))?$row->card_type:$row->payment_method))); ?></span></p>
									<h6>Gesamtbetrag <span><?php echo e(number_format($row->price, 2, ',', '.')); ?>€</span></h6>
                                </div>
                                <?php if($row->status == 'booked' || $row->status == 'pending'): ?>
                                    <a href="javascript:void(0)" class="btn btn-black-yellow postpond_app" data-id="<?php echo e(@$row['id']); ?>">Verschieben</a>
                                <?php elseif($row->status == 'reschedule'): ?>
								
                                   
                                <?php elseif($row->status == 'completed' || $row->status == 'cancel'): ?>
                                    <a href="#" class="btn btn-black-yellow book_agian" data-id="<?php echo e(@$row['id']); ?>">Erneut Buchen ?</a>
                                <?php endif; ?>
								<?php if($row->status != 'cancel'): ?>
									 <a href="#" class="btn btn-yellow-black ask_cancel"
                                       data-id="<?php echo e(@$row['variantData']['id']); ?>"
                                       data-order="<?php echo e($row['order_id']); ?>"
                                       data-appointment="<?php echo e($row['appointment_id']); ?>"
                                       data-image="<?php echo e($imge); ?>"
                                       data-service="<?php echo e($row['service_name']); ?>"
                                       data-description="<?php echo e(@$row['variantData']['description']); ?>"
                                    >Stornieren?</a>
								<?php endif; ?>
                            </div>
                        </div>
                        <div class="appointment-cato-wrap">
                            <div class="appointment-cato-item">
                                <span><?php echo file_get_contents(URL::to('storage/app/public/category/' . @$row->categoryDetails->image)) ?></span>
                                <h6><?php echo e($row->categoryDetails->name); ?></h6>
                            </div>
							<?php if($row->status != 'reschedule'): ?>
								<div class="appointment-cato-date">
									<h6><?php echo e(\Carbon\Carbon::parse($row->appo_date)->translatedFormat('d F, Y')); ?>

										(<?php echo e(\Carbon\Carbon::parse($row->appo_date)->translatedFormat('D')); ?>)</h6>
									<span><?php echo e(\Carbon\Carbon::parse($row->appo_time)->format('H:i')); ?> </span>
								</div>
							<?php endif; ?>
                        </div>
                        <div class="appointment-info-profile">
                    <span>
                          <?php if(file_exists(storage_path('app/public/store/employee/'.@$row->employeeDetails->image)) && @$row->employeeDetails->image != ''): ?>
                            <img src="<?php echo e(URL::to('storage/app/public/store/employee/'.@$row->employeeDetails->image)); ?>"
                                 alt=""
                            >
						 <?php elseif($row->store_emp_id && !empty($row->employeeDetails->emp_name)): ?>
							<?php
								$empnameArr = explode(" ", $row->employeeDetails->emp_name);
								$empname = "";
								if(count($empnameArr) > 1){
									$empname = strtoupper(substr($empnameArr[0], 0, 1)).strtoupper(substr($empnameArr[1], 0, 1));
								}else{
									$empname = strtoupper(substr( $row->employeeDetails->emp_name, 0, 2));
								}
							?>
							 <img src="https://via.placeholder.com/150x150/00000/FABA5F?text=<?php echo e($empname); ?>" alt="employee">
                        <?php else: ?>
                            <img src="<?php echo e(URL::to('storage/app/public/default/default-user.png')); ?>"
                                 alt=""
                            >
                        <?php endif; ?>
                    </span>
                            <div>
                                <p>Mitarbeiter </p>
                                <h6><?php echo e($row->store_emp_id == '' ? 'Any Employee' : @$row->employeeDetails->emp_name); ?></h6>
                            </div>
                            <?php if(!empty($row->note)): ?>
                                <div class="a-info-profile-action">
									<?php if(!empty($row->note_image)): ?>
										<?php $notesimages = explode(",", $row->note_image); ?>
											<div class="modal fade NoteModalInfo" id="NoteModalInfo" data-id="<?php echo e($row->id); ?>" tabindex="-1" role="dialog"
												 aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
												<div class="modal-dialog modal-dialog-centered" role="document">
													<div class="modal-content">
														<div class="modal-body">
															<div class="owl-carousel owl-theme">
																<?php $__currentLoopData = $notesimages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notesimage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
																	 <?php if($notesimage != "" && file_exists('storage/app/public/store/customernotes/'.$notesimage)): ?>
																			<div class="item" ><img src="<?php echo e(asset('storage/app/public/store/customernotes/'.$notesimage)); ?>"></div>
																	 <?php endif; ?>
																<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
															</div>
															<p class="mt-1"><?php echo e($row->note); ?></p>
														</div>
													</div>
												</div>
											</div>
                                    <a href="javascript:void(0)" class="info-action" data-id="<?php echo e($row->id); ?>"><img
                                            src="<?php echo e(URL::to('storage/app/public/Serviceassets/images/icon/info.svg')); ?>"
                                            alt=""></a>
									<?php else: ?>
										 <a href="javascript:void(0)" class="info-action" data-toggle="tooltip" data-placement="left"
                                       title="<?php echo e($row->note); ?>"><img
                                            src="<?php echo e(URL::to('storage/app/public/Serviceassets/images/icon/info.svg')); ?>"
                                            alt=""></a>
									<?php endif; ?>
                                    <a href="javascript:void(0)" class="edit-action edit_note" data-id="<?php echo e($row->id); ?>"><img
                                            src="<?php echo e(URL::to('storage/app/public/Serviceassets/images/icon/edit-2.svg')); ?>"
                                            alt=""></a>
                                </div>
                            <?php else: ?>
                                <a href="javascript:void(0)" class="btn btn-add-note create_note" data-id="<?php echo e($row->id); ?>">+ Notiz</a>
                            <?php endif; ?>
                        </div>
                        <div class="appointment-item-info border-0 mb-0">
                            <h5><?php echo e($row->subCategoryDetails->name); ?> - <?php echo e(@$row->service_name); ?></h5>
                            <h6><?php echo e(@$row->variantData->description); ?> </h6>
                            <p><?php echo e(@$row->variantData->duration_of_service); ?> <?php echo e(__('Min')); ?> <strong><?php echo e(number_format($row->price, 2, ',', '.')); ?>€</strong></p>
                        </div>
                    </div>
                    <?php if(empty($row->note)): ?>
                        <div class="modal fade AddNoteModal" id="" data-id="<?php echo e($row->id); ?>" tabindex="-1" role="dialog"
                             aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <?php echo e(Form::open(array('url'=>'service-provider/customer/add-note','method'=>'post','files'=>true,'name'=>'add_note'))); ?>

                                        <div class="appointment-item note-appointment-item">
                                            <div class="appointment-profile-wrap">
                                                <div class="appointment-profile-left">
                                                    <div class="appointment-profile-img">
                                                        <?php if(file_exists(storage_path('app/public/user/'.@$row->userDetails->profile_pic)) && @$row->userDetails->profile_pic != ''): ?>
                                                            <img
                                                                src="<?php echo e(URL::to('storage/app/public/user/'.@$row->userDetails->profile_pic)); ?>"
                                                                class="rounded avatar-sm"
                                                                alt="user">
																<?php $image = URL::to('storage/app/public/user/'.@$row->userDetails->profile_pic); ?>
                                                        <?php else: ?>
                                                           
																<?php $image = 'https://via.placeholder.com/1080x1080/00000/FABA5F?text='.strtoupper(substr($row['first_name'], 0, 1)).strtoupper(substr($row['last_name'], 0, 1)); ?>
															 <img
                                                                src="<?php echo e($image); ?>"
                                                                class="rounded avatar-sm"
                                                                alt="user">
													  <?php endif; ?>
                                                    </div>
                                                    <div class="appointment-profile-info">
                                                        <h5><?php echo e(@$row->first_name); ?> <?php echo e(@$row->last_name); ?></h5>
                                                        <ul class="appointment-d-block">
                                                            <li>
                                                                <p>Buchungs-ID: <span> #<?php echo e($row->order_id); ?></span></p>
                                                            </li>
                                                            <li>
                                                                <p>Status:
																	<?php if($row->status == 'booked' || $row->status == 'pending'): ?>
																		<span class="new-appointment-label"> <?php echo e($row->status == 'booked' ? 'Neu' : 'Steht aus'); ?></span>
																	<?php elseif($row->status == 'running' || $row->status == 'reschedule'): ?>
																		<span class="running-label"> <?php echo e($row->status == 'running' ? 'Aktiv' : 'Verschoben'); ?></span>
																	<?php elseif($row->status == 'completed'): ?>
																		<span class="completed-label"> Erledigt </span>
																	<?php elseif($row->status == 'cancel'): ?>
																		<span class="cancel-label"> Storniert </span>
																	<?php endif; ?>
                                                                </p>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="appointment-profile-right">
                                                    <div class="app-payment-info-type mr-0">
                                                        <p>Bezahlt mit <i></i>
                                                            <span><?php echo e(ucfirst($row->payment_method == 'cash' ? 'vor Ort' : ((strtolower($row->payment_method) == 'stripe' && !empty($row->card_type))?$row->card_type:$row->payment_method))); ?></span></p>
                                                        <h6>Gesamtbetrag <span><?php echo e(number_format($row->price, 2, ',', '.')); ?>€</span></h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="appointment-cato-wrap">
                                                <div class="appointment-cato-item">
                                                    <span><?php echo file_get_contents(URL::to('storage/app/public/category/' . @$row->categoryDetails->image)) ?></span>
                                                    <h6><?php echo e($row->categoryDetails->name); ?></h6>
                                                </div>
                                                <div class="appointment-cato-date">
                                                    <h6><?php echo e(\Carbon\Carbon::parse($row->appo_date)->translatedFormat('d F, Y')); ?>

                                                        (<?php echo e(\Carbon\Carbon::parse($row->appo_date)->translatedFormat('D')); ?>)</h6>
                                                    <span><?php echo e(\Carbon\Carbon::parse($row->appo_time)->format('H:i')); ?> </span>
                                                </div>
                                            </div>
                                            <div class="appointment-info-profile">
                                                    <span>
                                                         <?php if(file_exists(storage_path('app/public/store/employee/'.@$row->employeeDetails->image)) && @$row->employeeDetails->image != ''): ?>
                                                            <img
                                                                src="<?php echo e(URL::to('storage/app/public/store/employee/'.@$row->employeeDetails->image)); ?>"
                                                                alt=""
                                                            >
                                                        <?php else: ?>
                                                           <?php
																$empname = "";
																if(!empty($row->employeeDetails->emp_name)){
																	$empnameArr = explode(" ", $row->employeeDetails->emp_name);
																	
																	if(count($empnameArr) > 1){
																		$empname = strtoupper(substr($empnameArr[0], 0, 1)).strtoupper(substr($empnameArr[1], 0, 1));
																	}else{
																		$empname = strtoupper(substr( $row->employeeDetails->emp_name, 0, 2));
																	}
																}
															?>
															<img src="https://via.placeholder.com/150x150/00000/FABA5F?text=<?php echo e($empname); ?>" alt="employee">
                                                        <?php endif; ?>
                                                    </span>
                                                <div>
                                                    <p>Mitarbeiter </p>
                                                    <h6><?php echo e($row->store_emp_id == '' ? 'Any Employee' : @$row->employeeDetails->emp_name); ?></h6>
                                                </div>
                                            </div>
                                            <div class="appointment-item-info border-0 mb-0">
                                                <h5><?php echo e($row->subCategoryDetails->name); ?> - <?php echo e(@$row->service_name); ?></h5>
                                                <h6><?php echo e(@$row->variantData->description); ?> </h6>
                                            </div>
                                        </div>
                                        <div class="notes-textarea">
                                            <h4>Notiz</h4>
											<div class="image-box">
												<div class="customer-image image-sq">
													<div id="add_owl_carousel" class="owl-carousel owl-theme">
														<div class="item"><img id="output" src="<?php echo e(URL::to('storage/app/public/Serviceassets/images/default-profile.jpg')); ?>"></div>
													</div>
												</div>
												<label for="imgUpload">
													<input id="imgUpload" name="image[]" type="file" accept="image/*" multiple onchange="loadFile(event)">
													<span class="btn btn-yellow btn-photo">Datei wählen</span>
												</label>
											</div>
                                            <textarea placeholder="Zusätzliche Informationen hinzufügen ..."
                                                      name="note" required></textarea>
                                            <input type="hidden" name="app_id" value="<?php echo e($row->id); ?>">
                                        </div>
                                        <dvi class="notes-btn-wrap">
                                            <button class="btn btn-black-yellow" type="submit">Posten</button>
                                            <a href="#" class="btn btn-border-yellow close_modal"
                                               data-id="<?php echo e($row->id); ?>">Schließen</a>
                                        </dvi>
                                        <?php echo e(Form::close()); ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if(!empty($row->note)): ?>
                        <div class="modal fade EditNoteModal" id="" data-id="<?php echo e($row->id); ?>" tabindex="-1" role="dialog"
                             aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <?php echo e(Form::open(array('url'=>'service-provider/customer/update-note','method'=>'post','files'=>true,'name'=>'add_note'))); ?>

                                        <div class="appointment-item note-appointment-item">
                                            <div class="appointment-profile-wrap">
                                                <div class="appointment-profile-left">
                                                    <div class="appointment-profile-img">
                                                        <?php if(file_exists(storage_path('app/public/user/'.@$row->userDetails->profile_pic)) && @$row->userDetails->profile_pic != ''): ?>
                                                            <img
                                                                src="<?php echo e(URL::to('storage/app/public/user/'.@$row->userDetails->profile_pic)); ?>"
                                                                class="rounded avatar-sm"
                                                                alt="user">
                                                        <?php else: ?>
															<img
															src="https://via.placeholder.com/1080x1080/00000/FABA5F?text=<?php echo e(strtoupper(substr(@$row->first_name, 0, 1))); ?><?php echo e(strtoupper(substr($row->last_name, 0, 1))); ?>"
															alt="user">
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="appointment-profile-info">
                                                        <h5><?php echo e(@$row->first_name); ?> <?php echo e(@$row->last_name); ?></h5>
                                                        <ul class="appointment-d-block">
                                                            <li>
                                                                <p>Buchungs-ID: <span> #<?php echo e($row->order_id); ?></span></p>
                                                            </li>
                                                            <li>
                                                                <p>Status:
																	<?php if($row->status == 'booked' || $row->status == 'pending'): ?>
																		<span class="new-appointment-label"> <?php echo e($row->status == 'booked' ? 'Neu' : 'Steht aus'); ?></span>
																	<?php elseif($row->status == 'running' || $row->status == 'reschedule'): ?>
																		<span class="running-label"> <?php echo e($row->status == 'running' ? 'Aktiv' : 'Verschoben'); ?></span>
																	<?php elseif($row->status == 'completed'): ?>
																		<span class="completed-label"> Erledigt </span>
																	<?php elseif($row->status == 'cancel'): ?>
																		<span class="cancel-label"> Storniert </span>
																	<?php endif; ?>
                                                                </p>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="appointment-profile-right">
                                                    <div class="app-payment-info-type mr-0">
                                                        <p>Bezahlt mit <i></i>
                                                            <span><?php echo e(ucfirst($row->payment_method)); ?></span></p>
                                                        <h6>Gesamtbetrag <span><?php echo e(number_format($row->price, 2, ',', '.')); ?>€</span></h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="appointment-cato-wrap">
                                                <div class="appointment-cato-item">
                                                    <span><?php echo file_get_contents(URL::to('storage/app/public/category/' . @$row->categoryDetails->image)) ?></span>
                                                    <h6><?php echo e($row->categoryDetails->name); ?></h6>
                                                </div>
                                                <div class="appointment-cato-date">
                                                    <h6><?php echo e(\Carbon\Carbon::parse($row->appo_date)->translatedFormat('d F, Y')); ?>

                                                        (<?php echo e(\Carbon\Carbon::parse($row->appo_date)->translatedFormat('D')); ?>)</h6>
                                                    <span><?php echo e(\Carbon\Carbon::parse($row->appo_time)->format('H:i')); ?> </span>
                                                </div>
                                            </div>
                                            <div class="appointment-info-profile">
                                                    <span>
                                                         <?php if(file_exists(storage_path('app/public/store/employee/'.@$row->employeeDetails->image)) && @$row->employeeDetails->image != ''): ?>
                                                            <img
                                                                src="<?php echo e(URL::to('storage/app/public/store/employee/'.@$row->employeeDetails->image)); ?>"
                                                                alt=""
                                                            >
                                                        <?php else: ?>
															<?php
																$empname = "";
																if(!empty($row->employeeDetails->emp_name)){
																	$empnameArr = explode(" ", $row->employeeDetails->emp_name);
																	
																	if(count($empnameArr) > 1){
																		$empname = strtoupper(substr($empnameArr[0], 0, 1)).strtoupper(substr($empnameArr[1], 0, 1));
																	}else{
																		$empname = strtoupper(substr( $row->employeeDetails->emp_name, 0, 2));
																	}
																}
															?>
															<img src="https://via.placeholder.com/150x150/00000/FABA5F?text=<?php echo e($empname); ?>" alt="employee">
                                                        <?php endif; ?>
                                                    </span>
                                                <div>
                                                    <p>Mitarbeiter </p>
                                                    <h6><?php echo e($row->store_emp_id == '' ? 'Any Employee' : @$row->employeeDetails->emp_name); ?></h6>
                                                </div>
                                            </div>
                                            <div class="appointment-item-info border-0 mb-0">
                                                <h5><?php echo e($row->subCategoryDetails->name); ?> - <?php echo e(@$row->service_name); ?></h5>
                                                <h6><?php echo e(@$row->variantData->description); ?> </h6>
                                            </div>
                                        </div>
                                        <div class="notes-textarea">
                                            <h4>Notiz</h4>
											<div class="image-box">
												<div class="customer-image image-sq">
													<div id="edit_owl_carousel" class="owl-carousel owl-theme">
														<?php if(!empty($row->note_image)): ?>
															<?php $noteimages = explode(",", $row->note_image); ?> 
															<?php $__currentLoopData = $noteimages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $noteimage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
																<?php if(!empty( $noteimage) && file_exists('storage/app/public/store/customernotes/'. $noteimage)): ?>
																	<div class="item"><img id="output_edit" src="<?php echo e(URL::to('storage/app/public/store/customernotes/'. $noteimage)); ?>"></div>
																<?php endif; ?>
															<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
														<?php else: ?>
															<div class="item"><img id="output_edit" src="<?php echo e(URL::to('storage/app/public/Serviceassets/images/default-profile.jpg')); ?>"></div>
														<?php endif; ?>
													</div>
												</div>
												<label for="imgUploadEdit">
													<input id="imgUploadEdit" name="image[]" type="file" multiple accept="image/*" onchange="loadFileEdit(event)">
													<span class="btn btn-yellow btn-photo">Ändern</span>
												</label>
											</div>
                                            <textarea placeholder="Zusätzliche Informationen hinzufügen ..."
                                                      name="note" required><?php echo e($row->note); ?></textarea>
                                            <input type="hidden" name="app_id" value="<?php echo e($row->id); ?>">
                                        </div>
                                        <dvi class="notes-btn-wrap">
                                            <button class="btn btn-black-yellow" type="submit">bearbeiten</button>
                                            <a href="#" class="btn btn-border-yellow close_edit_modal"
                                               data-id="<?php echo e($row->id); ?>">Schließen</a>
                                        </dvi>
                                        <?php echo e(Form::close()); ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </div>
            <div class="col-lg-4">
                
                
                
                
                
                
                
                
                
                
            </div>
        </div>
    </div>
    <div id="cancel_appointment" class="modal modal-top fade calendar-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
                <?php echo e(Form::open(array('url'=>'service-provider/cancel-appointment','method'=>'post','name'=>'cancel_appointmnet'))); ?>

                <div class="modal-body confirmation-modal-body">
                    <div class="confirmation-modal">
                        <div class="detail-wrap-box">
                            <span class="detail-wrap-box-img simages"><img
                                    src="<?php echo e(URL::to('storage/app/public/Frontassets/images/profile/woman-salon-balayage-min.jpg')); ?>"
                                    alt=""></span>
                            <div class="detail-wrap-box-infos">
                                <h6>Buchungs-ID: <span class="b_ids">#R4U49258</span></h6>
                                <h4 class="b_service_names">Ladies - Balayage & Blow Dry</h4>
                                <h5 class="b_service_descirptions">Balayage</h5>
                            </div>
                        </div>
                        <div class="detail-wrap-box-info">
                            <h5> Buchung stornieren, weil …</h5>
                            <?php echo e(Form::hidden('variant_id','',array('class'=>'variant_cancel'))); ?>

                            <?php echo e(Form::hidden('appointment_id','',array('class'=>'appointment_cancel'))); ?>

                            <textarea class="textarea-area" name="cancel_reason" required></textarea>

                            <button type="submit" class="btn btn-black btn-block btn-yes"> Ja, stornieren</button>
                            
                        </div>
                    </div>
                </div>
                <?php echo e(Form::close()); ?>

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
                        <?php echo e(Form::open(array('url'=>'service-provider/delete-customer','name'=>'delete-customer','method'=>'post'))); ?>

                        <?php echo e(Form::hidden('id','',array('class'=>'delete_id'))); ?>

                        <button type="submit"  class="btn btn-black-yellow"> Ja, löschen?</button>
                        <a href="#" class="btn btn-gray" data-dismiss="modal" >Nein, zurück</a>
                        <?php echo e(Form::close()); ?>

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
                                    src="<?php echo e(URL::to('storage/app/public/Frontassets/images/profile/woman-salon-balayage-min.jpg')); ?>"
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
	
<?php $__env->stopSection(); ?>
<?php $__env->startSection('service_js'); ?>
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
							   window.location.href = "<?php echo URL::current(); ?>";
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.serviceProvider', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\projects\laravel\reserved4you_dev\resources\views/ServiceProvider/Customer/view.blade.php ENDPATH**/ ?>