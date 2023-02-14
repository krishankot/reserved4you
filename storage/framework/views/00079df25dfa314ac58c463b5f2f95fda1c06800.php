<div class="row">
    <div class="col-12 p-0">
        <div class="appointment-item completed-item mb-0 p-0">
            <div class="appointment-profile-wrap py-4 px-3 mb-0 <?php echo e($appointmentDetail->status); ?>">
                <div class="appointment-profile-left mb-0">
                    <div class="appointment-profile-img">
					
                        <?php if(file_exists(storage_path('app/public/user/'.@$row->userDetails->profile_pic)) && @$row->userDetails->profile_pic != ''): ?>
                            <img src="<?php echo e(URL::to('storage/app/public/user/'.@$row->userDetails->profile_pic)); ?>"
                                 class="rounded avatar-sm"
                                 alt="user">
                        <?php else: ?>
                            <img
                                src="https://via.placeholder.com/1080x1080/00000/FABA5F?text=<?php echo e(strtoupper(substr($row['first_name'], 0, 1))); ?><?php echo e(strtoupper(substr($row['last_name'], 0, 1))); ?>"
                                alt="user">
                        <?php endif; ?>
                    </div>
					<?php
						$cust_exist =  false;
						if(!empty($row->email)){
							$cust_exist =  \BaseFunction::checkCustomerExists($row->email, $row->store_id);
						}
					?>
                    <div class="appointment-profile-info " style="width: 60%">
                        <h5 class="mb-1" ><?php echo e(@$row->first_name); ?> <?php echo e(@$row->last_name); ?> &nbsp;&nbsp;&nbsp;<span><?php if($cust_exist): ?><a href="<?php echo e(url('service-provider/appointment/detail',$row->id)); ?>">Profil anzeigen</a><?php endif; ?> </span></h5>
                        <p  class="mb-1" >Buchungs-ID: <span> #<?php echo e($row->order_id); ?></span></p>
                        <p  class="mb-1" >Uhrzeit: <span><?php echo e(date(Carbon\Carbon::parse($appointmentDetail->appo_time)->format('H:i'))); ?>-<?php echo e(date(Carbon\Carbon::parse($appointmentDetail->app_end_time)->format('H:i'))); ?></span>  </p>

                    </div>
                    <div class="text-right" style="width: 30%">
                         <p class="mb-1" >
							<?php if(!empty($appointmentDetail->payment_method) && strtolower($appointmentDetail->payment_method) == 'cash'): ?>
								Zahlungsmethode: vor Ort
							<?php elseif(!empty($appointmentDetail->payment_method) && strtolower($appointmentDetail->payment_method) == 'stripe' && !empty($appointmentDetail->card_type)): ?>
								Zahlungsmethode: <?php echo e($appointmentDetail->card_type); ?>

							<?php elseif(!empty($appointmentDetail->payment_method)): ?>
								Zahlungsmethode: <?php echo e(ucfirst($appointmentDetail->payment_method)); ?>

							<?php else: ?>
								Zahlungsmethode vor Ort
							<?php endif; ?>
						</p>
                        <h5 class="mb-1" >Gesamt <?php echo e(number_format($appointmentDetail->price,2,',','.')); ?>€</h5>
                        <span class="<?php echo e($appointmentDetail->status); ?> mb-1">
                            <span class="badge badge-outline badge-pill bg-white text-dark py-1 text-capitalize <?php echo e($appointmentDetail->status); ?>-border">
                                <?php if($appointmentDetail->status=='running'): ?> aktiv
                                <?php elseif($appointmentDetail->status=='cancel'): ?> Storniert
                                <?php elseif($appointmentDetail->status=='completed'): ?> Erledigt
                                <?php elseif($appointmentDetail->status=='booked'): ?> Neu
								<?php elseif($appointmentDetail->status=='reschedule'): ?> Verschoben
                                <?php else: ?> <?php echo e($appointmentDetail->status); ?> <?php endif; ?>
                            </span>
                        </span>
                    </div>
                </div>

            </div>
            <div class="appointment-cato-wrap mt-2">
                <div class="appointment-cato-item">
                    <span>
                        <img src="<?php echo e(asset(URL::to('storage/app/public/category/' . @$appointmentDetail->categoryDetails->image))); ?>"></span>
                    <h6><?php echo e($appointmentDetail->categoryDetails->name); ?></h6>
                </div>
				<a class="text-link btn-sm" onclick="closeModal();" href="<?php echo e(url('service-provider/appointment#'.$appointmentDetail->id)); ?>">Termin anzeigen</a>
                <div class="appointment-cato-date " style="background: none!important;">
                    <h6><?php echo e(\Carbon\Carbon::parse($appointmentDetail->appo_date)->translatedFormat('d F, Y')); ?>

                        (<?php echo e(\Carbon\Carbon::parse($appointmentDetail->appo_date)->translatedFormat('D')); ?>)</h6>
                    <span class="bg-white text-dark"><?php echo e(\Carbon\Carbon::parse($appointmentDetail->appo_time)->format('H:i')); ?> </span>
                </div>
            </div>

            <div class="appointment-info-profile">
                    <span>
                         <?php if(file_exists(storage_path('app/public/store/employee/'.@$appointmentDetail->employeeDetails->image)) && @$appointmentDetail->employeeDetails->image != ''): ?>
                            <img src="<?php echo e(URL::to('storage/app/public/store/employee/'.@$appointmentDetail->employeeDetails->image)); ?>"
                                 alt=""
                            >
						<?php elseif($appointmentDetail->store_emp_id): ?>
												<?php
												$empname = "";
												if(!empty($appointmentDetail->employeeDetails->emp_name)){
													$empnameArr = explode(" ", $appointmentDetail->employeeDetails->emp_name);
													
													if(count($empnameArr) > 1){
														$empname = strtoupper(substr($empnameArr[0], 0, 1)).strtoupper(substr($empnameArr[1], 0, 1));
													}else{
														$empname = strtoupper(substr( $appointmentDetail->employeeDetails->emp_name, 0, 2));
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
                    <p>Mitarbeiter/-in</p>
                    <h6><?php echo e($appointmentDetail->store_emp_id == '' ? 'Any Employee' : @$appointmentDetail->employeeDetails->emp_name); ?></h6>
                </div>
            </div>
            <div class="appointment-item-price-info">
                <h5><?php echo e($appointmentDetail->subCategoryDetails->name); ?> - <?php echo e(@$appointmentDetail->service_name); ?></h5>
                <h6><?php echo e(@$appointmentDetail->variantData->description); ?> </h6>
                <p><?php echo e(@$appointmentDetail->variantData->duration_of_service); ?> <?php echo e(__('Min')); ?> <strong><?php echo e(number_format($appointmentDetail->price, 2, ',', '.')); ?>€</strong></p>
            </div>
        </div>
    </div>
</div>
<script>
	function closeModal(){
		$('.modal').modal('hide');
	}
</script>
<?php /**PATH /var/www/html/resources/views/ServiceProvider/Calender/modal_info.blade.php ENDPATH**/ ?>