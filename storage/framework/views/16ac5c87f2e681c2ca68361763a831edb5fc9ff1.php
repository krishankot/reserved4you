<div class="modal-body modal-body22">
    <div class="modals-profile-wrap">
        <div class="modals-modals-profile">
            <?php if(file_exists(storage_path('app/public/store/'.$row['storeData']['store_profile'])) && $row['storeData']['store_profile'] != ''): ?>
                <img src="<?php echo e(URL::to('storage/app/public/store/'.$row['storeData']['store_profile'])); ?>" alt="">

            <?php else: ?>
                <img src="<?php echo e(URL::to('storage/app/public/default/store_default.png')); ?>" alt="">
            <?php endif; ?>
        </div>
        <div class="modals-modals-info">
            <h6>Salon</h6>
            <h5><?php echo e(@$row['storeData']['store_name']); ?></h5>
        </div>
    </div>
    <div class="modal-profile-address">
        <span><?php echo file_get_contents(URL::to('storage/app/public/Frontassets/images/profile/location.svg')) ?></span>
        <p><?php echo e($row['storeData']['store_address']); ?></p>
    </div>
    <div class="accordion" id="accordionExample">
        <div class="paymentaccordion">
            <a href="javascript:void(0)" class="payment-box-link" data-toggle="collapse"
               data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    <span
                                        class="payment-box-icon"><?php echo file_get_contents(URL::to('storage/app/public/category/' . @$row['categoryDetails']['image'])) ?></span>
                <h6><?php echo e($row['categoryDetails']['name']); ?></h6>
                <span class="downn-arroww"><i class="far fa-chevron-down"></i></span>
            </a>
            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                 data-parent="#accordionExample">
                <div class="payment-body-box">
                    <div class="payment-box-profile-wrap">
                        <?php if($row['store_emp_id'] != ''): ?>
                            <span><img
                                    src="<?php echo e(URL::to('storage/app/public/store/employee/'.\BaseFunction::getEmployeeDetails($row['store_emp_id'],'image'))); ?>"
                                    alt=""></span>
                            <div>
                                <p>Retained Stylist</p>
                                <h6><?php echo e(\BaseFunction::getEmployeeDetails($row['store_emp_id'],'emp_name')); ?></h6>
                            </div>
                        <?php else: ?>
                            <span><img
                                    src="<?php echo e(URL::to('storage/app/public/default/default-user.png')); ?>"
                                    alt=""></span>
                            <div>
                                <p>Retained Stylist</p>
                                <h6>Any Person</h6>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="payment-item-infos">
                        <h5><?php echo e(@$row['subCategoryDetails']['name']); ?> - <?php echo e($row['service_name']); ?></h5>
                        <h6><?php echo e(@$row['variantData']['description']); ?></h6>
                        <div class="payment-item-infos-wrap">
                            <span><?php echo e(@$row['variantData']['duration_of_service']); ?> min</span>
                            <p><?php echo e(number_format($row['price'],2,',','.')); ?>€</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="modal-items-pricing">
        <h4>Gesamtbetrag <i> <?php echo e(number_format($row['price'],2, ',', '.')); ?>€</i></h4>
        <h6>bezahlt mit <?php echo e(strtolower($row['payment_method'] == 'cash'?'Vor Ort':$row['payment_method'])); ?></h6>
    </div>
    <?php if(file_exists(storage_path('app/public/service/'.$row->image)) && $row->image != ''): ?>

        <div
            style="display: none"><?php echo e($imge = URL::to('storage/app/public/service/'.$row->image)); ?></div>
    <?php else: ?>
        <div
            style="display: none"><?php echo e($imge = URL::to('storage/app/public/default/default-user.png')); ?></div>
    <?php endif; ?>
    <?php if($row['cancellation'] == 'yes'): ?>
        <a href="#" class="btn btn-black btn-block btn-modal-cancel ask_cancel"
           data-id="<?php echo e(@$row['variantData']['id']); ?>"
           data-order="<?php echo e($row['order_id']); ?>"
           data-appointment="<?php echo e($row['appointment_id']); ?>"
           data-image="<?php echo e($imge); ?>"
           data-service="<?php echo e($row['service_name']); ?>"
           data-description="<?php echo e(@$row['variantData']['description']); ?>"
        >Cancel Booking</a>
        <a href="#" class="cancelation-policy">Read Cancelation Policy</a>
    <?php endif; ?>
</div>

<?php /**PATH F:\projects\laravel\reserved4you_dev\resources\views/Front/User/calender_details.blade.php ENDPATH**/ ?>