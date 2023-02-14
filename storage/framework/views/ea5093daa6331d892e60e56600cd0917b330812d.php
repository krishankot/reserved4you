<?php $__empty_1 = true; $__currentLoopData = $service; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <?php if(count($row->variants)==1): ?>
        <div class="service-item-main"  id="service_item<?php echo e($row->id); ?>">
            <div class="service-item-img">
                <img
                    src="<?php echo e(URL::to('storage/app/public/service/'.$row['image'])); ?>"
                    alt="">
                <?php if($row->discount_type != null && $row->discount != '0' && $row->discount != ''): ?>
                    <p class="service-discount"><?php echo e($row->discount); ?>

                        <span><?php echo e($row->discount_type == 'percentage' ? '%' : '€'); ?></span>
                    </p>
                <?php endif; ?>
            </div>
            <div class="service-item-info">
                <div class="service-action-wrap">
                    <a href="<?php echo e(URL::to('service-provider/edit-service/'.encrypt($row->id))); ?>"><img
                            src="<?php echo e(URL::to('storage/app/public/Serviceassets/images/icon/edit-2.svg')); ?>"
                            alt=""></a>
                     <a class="delete_service" data-id="<?php echo e($row->id); ?>" data-encrypt="<?php echo e(encrypt($row->id)); ?>" href="javascript:void(0);"><img
                                                            src="<?php echo e(URL::to('storage/app/public/Serviceassets/images/icon/delete-3.svg')); ?>"
                                                            alt=""></a>
                </div>
                <div class="service-info-top">
                    <h6><?php echo e($row->service_name); ?></h6>
                    <a href="javascript:void(0)" class="showDetails"
                       data-service="<?php echo e($row->service_name); ?>"
                       data-descri="<?php echo e($row->description); ?>"
                       data-image="<?php echo e(URL::to('storage/app/public/service/'.$row['image'])); ?>"
                       data-rating="<?php echo e($row->rating); ?>"
                    >
                    Details anzeigen</a>
                </div>
                <div class="time_price_info">
                    <?php $__currentLoopData = $row->variants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <h6><?php echo e($item['duration_of_service']); ?> <?php echo e(__('Min')); ?></h6>
                        <div class="price-info">
                            <?php if($row->discount_type != null && $row->discount != '0' && $row->discount != ''): ?>
                                <h5><?php echo e(number_format(\BaseFunction::finalPriceVariant($row->id,$item['id']),2, ',', '.')); ?>

                                    €
                                    <span><?php echo e(number_format($item['price'],2,',','.')); ?>€</span>
                                </h5>
                            <?php else: ?>
                                <h5><?php echo e($item['price']); ?>€</h5>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="service-item-main" id="service_item<?php echo e($row->id); ?>">
            <div class="service-item-img">
                <img
                    src="<?php echo e(URL::to('storage/app/public/service/'.$row['image'])); ?>"
                    alt="">
                <?php if($row->discount_type != null && $row->discount != '0' && $row->discount != ''): ?>
                    <p class="service-discount"><?php echo e($row->discount); ?>

                        <span><?php echo e($row->discount_type == 'percentage' ? '%' : '€'); ?></span>
                    </p>
                <?php endif; ?>
            </div>
            <div class="service-item-info">
                <div class="service-action-wrap">
                    <a href="<?php echo e(URL::to('service-provider/edit-service/'.encrypt($row->id))); ?>"><img
                            src="<?php echo e(URL::to('storage/app/public/Serviceassets/images/icon/edit-2.svg')); ?>"
                            alt=""></a>
                     <a class="delete_service" data-id="<?php echo e($row->id); ?>" data-encrypt="<?php echo e(encrypt($row->id)); ?>" href="javascript:void(0);"><img
						src="<?php echo e(URL::to('storage/app/public/Serviceassets/images/icon/delete-3.svg')); ?>"
						alt=""></a>
                </div>
                <div class="service-info-top">
                    <h6><?php echo e($row->service_name); ?>

                        <span id="flip" class="down-arroww flip"
                              data-id="p<?php echo e($row->id); ?>"><i
                                class="far fa-chevron-down"></i></span>
                    </h6>
                    <a href="javascript:void(0)" class="showDetails"
                       data-service="<?php echo e($row->service_name); ?>"
                       data-descri="<?php echo e($row->description); ?>"
                       data-image="<?php echo e(URL::to('storage/app/public/service/'.$row['image'])); ?>"
                       data-rating="<?php echo e($row->rating); ?>"
                    >
                    Details anzeigen</a>
                </div>
                <div id="sliderr" class="active" style="display: block;">
                    <?php $__currentLoopData = $row->variants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="service-media-wrap">
                            <div class="service-media-infos">
                                <h6><?php echo e($item['description']); ?></h6>
                                <p><?php echo e($item['duration_of_service']); ?> <?php echo e(__('Min')); ?></p>
                            </div>
                            <div class="price-info">
                                <?php if($row->discount_type != null && $row->discount != '0' && $row->discount != ''): ?>
                                    <h5><?php echo e(number_format(\BaseFunction::finalPriceVariant($row->id,$item['id']),2, ',', '.')); ?>

                                        €
                                        <span><?php echo e(number_format($item['price'],2,',','.')); ?>€</span>
                                    </h5>
                                <?php else: ?>
                                    <h5><?php echo e(number_format($item['price'],2, ',', '.')); ?>€</h5>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <div class="text-center">
        No service Found.
    </div>
<?php endif; ?>
<?php /**PATH /var/www/html/resources/views/ServiceProvider/Store/store_details.blade.php ENDPATH**/ ?>