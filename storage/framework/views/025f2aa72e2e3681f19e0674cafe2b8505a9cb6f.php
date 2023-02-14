<?php $__currentLoopData = $todayAppointment; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item =>$row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <li class="">
        <i><?php echo e(\Carbon\Carbon::parse($item)->format('H:i')); ?></i>
        <?php $__currentLoopData = $row; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="timeline-li-wrap">
                <div class="timeline-profile-wrap">
                    <div class="timeline-profile-top-wrap">
                        <div class="timeline-profile">
                            <?php if(file_exists(storage_path('app/public/user/'.@$value->userDetails->profile_pic)) && @$value->userDetails->profile_pic != ''): ?>
                                <img src="<?php echo e(URL::to('storage/app/public/user/'.@$value->userDetails->profile_pic)); ?>"
                                     class="rounded avatar-sm"
                                     alt="user">
                            <?php else: ?>
                                <img class="rounded avatar-sm"
                                    src="https://via.placeholder.com/150x150/00000/FABA5F?text=<?php echo e(strtoupper(substr(@$value->first_name, 0, 1))); ?><?php echo e(strtoupper(substr(@$value->last_name, 0, 1))); ?>"
                                    alt="user">
                            <?php endif; ?>
                        </div>
                        <div class="timeline-profile-info">
                                <?php if($value->status == 'booked' || $value->status == 'pending'): ?>
                                    <span class="new-appointment-label"> <?php echo e($value->status == 'booked' ? 'Neu' : 'Steht aus'); ?></span>
                                <?php elseif($value->status == 'running' || $value->status == 'reschedule'): ?>
                                    <span class="running-label"> <?php echo e($value->status == 'running' ? 'Aktiv' : 'Verschoben'); ?></span>
                                <?php elseif($value->status == 'completed'): ?>
                                    <span class="completed-label"> Erledigt </span>
                                <?php elseif($value->status == 'cancel'): ?>
                                    <span class="cancel-label"> Storniert </span>
                                <?php endif; ?>

                            <h6><?php echo e(@$value->first_name); ?> <?php echo e(@$value->last_name); ?></h6>
                        </div>
                        <div class="timeline-profile-price">
                            <h6>  <span><?php echo e($value->price); ?>€</span></h6>
                            <!-- <p><?php echo e(ucfirst($value->payment_method)); ?></p> -->
                            <p><?php echo e(ucfirst($value->payment_method == 'cash' ? 'Bar' : ((strtolower($value->payment_method) == 'stripe' && !empty($value->card_type))?$value->card_type:$value->payment_method))); ?></p>
                        </div>
                    </div>
                    <div class="timeline-profile-bottom-wrap">
                        <div>
                            <p>Buchungs-ID: <span> #<?php echo e($value->order_id); ?></span></p>
                            <p>Uhrzeit : <span> <?php echo e(\Carbon\Carbon::parse($value->appo_time)->format('H:i')); ?> - <?php echo e(\Carbon\Carbon::parse($value->appo_time)->addMinutes(@$value->variantData->duration_of_service)->format('H:i')); ?></span></p>
                        </div>

                    </div>
                </div>
                <div class="accordion" id="accordionExample">
                    <div class="timeline-card">
                        <a class="timeline-link" type="button" data-toggle="collapse"
                           data-target="#collapse<?php echo e($value->id); ?>" aria-expanded="false" aria-controls="collapse<?php echo e($value->id); ?>">
                           Gebuchter Service
                            <span class="arrow"><img
                                    src="<?php echo e(URL::to('storage/app/public/Serviceassets/images/icon/down-arrow.svg')); ?>"
                                    alt=""></span>
                        </a>
                        <div id="collapse<?php echo e($value->id); ?>" class="collapse" aria-labelledby="heading<?php echo e($value->id); ?>"
                             data-parent="#accordionExample">
                            <div class="timeline-body ">
                                <div class="timeline-heading-label">
                                            <span>

                                                <?php echo file_get_contents(URL::to('storage/app/public/category/'.@$value->categoryDetails->image)) ?>
                                            </span>
                                    <h6><?php echo e($value->categoryDetails->name); ?></h6>
                                    
                                </div>
                                <div class="timeline-profile-label">
                                    <p>Mitarbeiter</p>
                                    <div>
                                        <h6><?php echo e($value->store_emp_id == '' ? 'Any Employee' : @$value->employeeDetails->emp_name); ?></h6>
                                        <span>
                                                          <?php if(file_exists(storage_path('app/public/store/employee/'.@$value->employeeDetails->image)) && @$value->employeeDetails->image != ''): ?>
                                                <img src="<?php echo e(URL::to('storage/app/public/store/employee/'.@$value->employeeDetails->image)); ?>"
                                                     alt=""
                                                >
                                            <?php else: ?>
                                                <img src="<?php echo e(URL::to('storage/app/public/default/default-user.png')); ?>"
                                                     alt=""
                                                >
                                            <?php endif; ?>
                                                    </span>
                                    </div>
                                </div>
                                <div class="timeline-body-info">
                                    <p><?php echo e($value->subCategoryDetails->name); ?> - <?php echo e(@$value->service_name); ?> - <?php echo e(@$value->variantData->description); ?></p>
                                </div>
                                <div class="timeline-footer-price">
                                    <p><?php echo e(@$value->variantData->duration_of_service); ?> <?php echo e(__('Min')); ?></p>
                                    <h6><?php echo e($value->price); ?>€</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </li>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH /var/www/html/resources/views/ServiceProvider/appointmentDetails.blade.php ENDPATH**/ ?>