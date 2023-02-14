<?php $__env->startSection('service_title'); ?>
    Order Confirmation
<?php $__env->stopSection(); ?>
<?php $__env->startSection('service_css'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('service_content'); ?>
    <div class="main-content">
        <div class="booking-con text-center">
            <div class="booking">
                <h3>Buchung bestätigt!</h3>
                <p>Glückwunsch! Dein Termin wurde erfolgreich gebucht.</p>
            </div>
        </div>
        <div class="booking-id">
            <h4>Deine Buchungs-ID: <label>#<?php echo e($appointment['order_id']); ?></label></h4>
        </div>

        <div class="appoinment-booking-con appoinment-booking-con2">
            <div class="person-booking-info-con">
                <h3>Buchungsdetails</h3>

                <div class="personinfo">
                    <div class="information d-flex justify-content-between">
                        <h6>Kunde</h6>
                        <p><?php echo e($appointment['first_name']); ?> <?php echo e($appointment['last_name']); ?></p>
                    </div>
                </div>
                <div class="personinfo">
                    <div class="information d-flex justify-content-between">
                        <h6> E-Mail Adresse</h6>
                        <p><?php echo e($appointment['email']); ?></p>
                    </div>
                </div>
                <div class="personinfo">
                    <div class="information d-flex justify-content-between">
                        <h6>Telefonnummer </h6>
                        <p><?php echo e($appointment['phone_number']); ?></p>
                    </div>
                </div>
                <div class="personinfo">
                    <div class="information d-flex justify-content-between">
                        <h6>Gesamtbetrag</h6>
                        <p class="total-amount"><?php echo e(number_format($appointment['total_amount'],2, ',','.')); ?>€</p>
                    </div>
                </div>
            </div>

            <div class="paymentinformation-wrap">
                <h3>Zahlungsübersicht</h3>
                <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="accordion pb-3" id="accordionExample-<?php echo e($row['category']['id']); ?>">
                        <div style="display: none"><?php echo e($i = 0); ?><?php echo e($j = 1); ?></div>
                        <div class="paymentaccordion paymentaccordion2">
                            <a href="javascript:void(0)" class="payment-box-link" data-toggle="collapse"
                            data-target="#collapse<?php echo e($row['category']['id']); ?>"
                            aria-expanded="true" aria-controls="collapse<?php echo e($row['category']['id']); ?>">
                                                <span
                                                    class="payment-box-icon"><?php echo file_get_contents(URL::to('storage/app/public/category/' . @$row['category']['image'])) ?></span>
                                <h6><?php echo e($row['category']['name']); ?></h6>
                                <span class="downn-arroww"><i class="far fa-chevron-down"></i></span>
                            </a>
                            <div id="collapse<?php echo e($row['category']['id']); ?>" class="collapse show"
                                aria-labelledby="heading<?php echo e($row['category']['id']); ?>"
                                data-parent="#accordionExample-<?php echo e($row['category']['id']); ?>">
                                <div class="payment-body-box">
                                    <div class="payment-box-profile-wrap emplistdata"
                                        data-id="<?php echo e($row['category']['id']); ?>">
                                        <?php if($row['data'][0]['store_emp_id'] != null): ?>
                                            <span class="empname" data-id="<?php echo e($row['category']['id']); ?>">
												<?php if(\BaseFunction::getEmployeeDetails($row['data'][0]['store_emp_id'],'image')): ?>
													<img src="<?php echo e(URL::to('storage/app/public/store/employee/'.\BaseFunction::getEmployeeDetails($row['data'][0]['store_emp_id'],'image'))); ?>" alt="">
												<?php else: ?>
													<?php
														$employee_name = \BaseFunction::getEmployeeDetails($row['data'][0]['store_emp_id'],'emp_name');
														$empnameArr = explode(" ", $employee_name);
														$empname = "";
														if(count($empnameArr) > 1){
															$empname = strtoupper(substr($empnameArr[0], 0, 1)).strtoupper(substr($empnameArr[1], 0, 1));
														}else{
															$empname = strtoupper(substr($employee_name, 0, 2));
														}
													?>
													 <img src="https://via.placeholder.com/150x150/00000/FABA5F?text=<?php echo e($empname); ?>" alt="employee">
												<?php endif; ?>
											</span>
                                            <div class="empname " data-id="<?php echo e($row['category']['id']); ?>">
                                                <p>Mitarbeiter</p>
                                                <h6><?php echo e(\BaseFunction::getEmployeeDetails($row['data'][0]['store_emp_id'],'emp_name')); ?></h6>
                                            </div>
                                        <?php else: ?>
                                            <span class="empname"><img
                                                    src="<?php echo e(URL::to('storage/app/public/default/default-user.png')); ?>"
                                                    alt=""></span>
                                            <div class="empname ">
                                                <p>Mitarbeiter</p>
                                                <h6>Any Person</h6>
                                            </div>
                                        <?php endif; ?>
										<?php $catid = $row['category']['id']; ?>
                                        <div class="datetimeslot data-id='<?php echo e($catid); ?>'">
                                        <p><?php echo e(\Carbon\Carbon::parse($row['data'][0]['appo_date'])->translatedFormat('d-m-Y')); ?></p>
                                        <h6><?php echo e(\Carbon\Carbon::parse($row['data'][0]['appo_time'])->format('H:i')); ?></h6>
                                    </div>
                                </div>
                                <?php $__currentLoopData = $row['data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="payment-item-infos booking-infor-wrap">
                                        <div class="booking-infor-left">
                                            <h5><?php echo e(@$item['service_data']['service_name']); ?></h5>
                                            <h6><?php echo e(@$item['variant_data']['description']); ?></h6>
                                            <span><?php echo e(@$item['variant_data']['duration_of_service']); ?> min</span>
                                        </div>
                                        <div class="booking-infor-right">
                                            <p><?php echo e(number_format($item['price'],2,',','.')); ?>€</p>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>

                        <div style="display: none"><?php echo e($i++); ?><?php echo e($j++); ?></div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </div>
        </div>

        </div>
        <div class="btn-done">
            <a href="<?php echo e(URL::to('service-provider/appointment')); ?>" class="donebtn btn">Bestätigen</a>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('service_js'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.serviceProvider', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/ServiceProvider/Appointment/Create/confirmation.blade.php ENDPATH**/ ?>