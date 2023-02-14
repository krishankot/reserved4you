<?php $__empty_1 = true; $__currentLoopData = $appointment; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
	<tr>
	<td>
    <div class="appointment-item completed-item">
        <div class="appointment-profile-wrap">
            <div class="appointment-profile-left">
                <div class="appointment-profile-img">
                    <?php if(file_exists(storage_path('app/public/user/'.@$row->userDetails->profile_pic)) && @$row->userDetails->profile_pic != ''): ?>
                        <img src="<?php echo e(URL::to('storage/app/public/user/'.@$row->userDetails->profile_pic)); ?>"
                             class="rounded avatar-sm"
                             alt="user">
							 <?php $image = URL::to('storage/app/public/user/'.@$row->userDetails->profile_pic); ?>
                    <?php else: ?>
                        <img
                            src="https://via.placeholder.com/1080x1080/00000/FABA5F?text=<?php echo e(strtoupper(substr($row['first_name'], 0, 1))); ?><?php echo e(strtoupper(substr($row['last_name'], 0, 1))); ?>"
                            alt="user">
							<?php $image = 'https://via.placeholder.com/1080x1080/00000/FABA5F?text='.strtoupper(substr($row['first_name'], 0, 1)).strtoupper(substr($row['last_name'], 0, 1)); ?>
                    <?php endif; ?>
                </div>
                <div class="appointment-profile-info">
                    <h5><?php echo e(@$row->first_name); ?> <?php echo e(@$row->last_name); ?>

						<?php if(!\BaseFunction::checkCustomerExists(@$row->email, @$row->store_id)): ?>
							<?php $requestStatus = \BaseFunction::isCustomerRequested(@$row['store_id'], @$row['user_id']); ?>
							<?php if($requestStatus == 'Requested'): ?>
								<a href="javascript:void(0);" class="text-warning disabled">Angefragt</a>
							<?php elseif($requestStatus == 'Rejected'): ?>
								<a href="javascript:void(0);" class="text-danger disabled">Abgelehnt</a>
							<?php else: ?>
								<a href="javascript:void(0);" class="text-info add_cust" data-customer="<?php echo e(@$row['user_id']); ?>" data-id="<?php echo e(@$row['store_id']); ?>">Kundenprofil anlegen ?</a>
							<?php endif; ?>
						<?php endif; ?>
					</h5>
                    <ul>
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
								<a style="color: #DB8A8A;text-decoration: underline;"  href="javascript:void(0);" class="cancel_reason" data-image="<?php echo e($image); ?>"
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
                        <?php if(file_exists(storage_path('app/public/service/'.$row->image)) && $row->image != ''): ?>

                            <div
                                style="display: none"><?php echo e($imge = URL::to('storage/app/public/service/'.$row->image)); ?></div>
                        <?php else: ?>
                            <div
                                style="display: none"><?php echo e($imge = URL::to('storage/app/public/default/default-user.png')); ?></div>
                        <?php endif; ?>
                        <?php if(empty($row->is_reviewed)): ?>
                            <?php if($row->status == 'completed'): ?>
                                <?php if(!empty($row->review_requested)): ?>
									<li><a href="javascript:void(0);" class="btn btn-black btn-review-request disabled mt-0">Angefragt</a></li>
								<?php else: ?>
									<li><a href="javascript:void(0);" data-id="<?php echo e($row['id']); ?>" class="btn btn-black btn-review-request mt-0">Bewertungsanfrage senden</a></li>
								<?php endif; ?>
                            <?php endif; ?>
                        <?php else: ?>
                            <li class="review-see-wrap">
                                <p>
                                            <span><i
                                                    class="fas fa-star"></i></span> <?php echo e(@$row->is_reviewed->total_avg_rating); ?>

                                </p>
                                <a href="<?php echo e(url('dienstleister/betriebsprofil?t=reviews#t'.@$row->is_reviewed->id)); ?>" class="btn see-review">Bewertung anzeigen</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
            <div class="appointment-profile-right">
                <div class="app-payment-info-type">
                    <p>Zahlungsmethode  <i></i> <span><?php echo e(ucfirst($row->payment_method == 'cash' ? 'vor Ort' : ((strtolower($row->payment_method) == 'stripe' && !empty($row->card_type))?$row->card_type:$row->payment_method))); ?></span></p>
                    <h6>Gesamtbetrag <span><?php echo e(number_format($row->price, 2, ',', '.')); ?>€</span></h6>
                </div>
                <?php if($row->status == 'booked' || $row->status == 'pending'): ?>
                    <a href="javascript:void(0)" class="btn btn-black-yellow postpond_app" data-id="<?php echo e(@$row['id']); ?>">Verschieben</a>
                    
                <?php elseif($row->status == 'reschedule'): ?>
				
                    
                <?php elseif($row->status == 'completed' || $row->status == 'cancel'): ?>
                      <a href="javascript:void(0)" class="btn btn-black-yellow book_agian" 
                                    data-id="<?php echo e(@$row['id']); ?>"
                                   >Erneut Buchen ?</a>
                <?php endif; ?>
                <?php if($row->status != 'cancel'): ?>
					<a href="javascript:void(0)" class="btn btn-yellow-black ask_cancel"
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
					<span><?php echo e(\Carbon\Carbon::parse($row->appo_time)->translatedFormat('H:i')); ?> </span>
				</div>
			<?php endif; ?>
        </div>
        <div class="appointment-info-profile">
                    <span>
                         <?php if(file_exists(storage_path('app/public/store/employee/'.@$row->employeeDetails->image)) && @$row->employeeDetails->image != ''): ?>
                            <img src="<?php echo e(URL::to('storage/app/public/store/employee/'.@$row->employeeDetails->image)); ?>"
                                 alt=""
                            >
						 <?php elseif($row->store_emp_id): ?>
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
                        <?php else: ?>
                            <img src="<?php echo e(URL::to('storage/app/public/default/default-user.png')); ?>"
                                 alt=""
                            >
                        <?php endif; ?>
                    </span>
            <div>
                <p>Mitarbeiter</p>
                <h6><?php echo e($row->store_emp_id == '' ? 'Any Employee' : @$row->employeeDetails->emp_name); ?></h6>
            </div>
        </div>
        <div class="appointment-item-price-info">
            <h5><?php echo e($row->subCategoryDetails->name); ?> - <?php echo e(@$row->service_name); ?></h5>
            <h6><?php echo e(@$row->variantData->description); ?> </h6>
            <p><?php echo e(@$row->variantData->duration_of_service); ?> <?php echo e(__('Min')); ?> <strong><?php echo e(number_format($row->price, 2, ',', '.')); ?>€</strong></p>
        </div>
    </div>
	</tr>
	</td>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
<?php endif; ?>

<?php /**PATH F:\projects\laravel\reserved4you_dev\resources\views/ServiceProvider/Appointment/appointmentDetails.blade.php ENDPATH**/ ?>