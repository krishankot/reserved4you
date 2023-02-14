<?php $__empty_1 = true; $__currentLoopData = $feedback; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <div class="review-info-items">
        <div class="review-info-header-wrap">
            <div class="review-info-profile">
        <span>
            <?php if(file_exists(storage_path('app/public/user/'.@$row->userDetails->profile_pic)) &&
            @$row->userDetails->profile_pic != ''): ?>
                <img
                    src="<?php echo e(URL::to('storage/app/public/user/'.@$row->userDetails->profile_pic)); ?>"
                    alt="user">
            <?php else: ?>
                <img
                    src="https://via.placeholder.com/1080x1080/00000/FABA5F?text=<?php echo e(strtoupper(substr(@$row->userDetails->first_name, 0, 1))); ?><?php echo e(strtoupper(substr(@$row->userDetails->last_name, 0, 1))); ?>"
                    alt="user">
            <?php endif; ?>
        </span>
                <div>
                    <h6><?php echo e(@$row->userDetails->first_name); ?> <?php echo e(@$row->userDetails->last_name); ?></h6>
                    <?php if(@$row->empDetails->emp_name != ''): ?>
                        <p>Service by <span><?php echo e(@$row->empDetails->emp_name); ?></span></p>
                    <?php endif; ?>
                </div>
                <?php if($row->category_id != '' || $row->service_id != ''): ?>
                    <p class="review-info-tag-box review-info-tag-box2"><?php echo e(@$row->categoryDetails->name); ?>

                        -
                        <?php echo e(@$row->serviceDetails->service_name); ?></p>
                <?php endif; ?>
            </div>
            <div class="main-review-info-tag-box">
                <p class="review-box"><span><i class="fas fa-star"></i></span><?php echo e($row->total_avg_rating); ?></p>

                <h5><?php echo e(\Carbon\Carbon::parse($row->updated_at)->diffForHumans()); ?></h5>
            </div>
        </div>
        <p class="review-information">
            <?php echo $row->write_comment; ?></p>
        <?php if(!empty($row->store_replay)): ?>
            <a href="javascript:void(0)" class="venue-replay-link">Venue replay <i
                    class="far fa-chevron-down"></i></a>
            <div class="venue-replay-info">
                <p><i class="far fa-undo-alt"></i> <?php echo $row->store_replay; ?></p>
            </div>
        <?php endif; ?>
        <a href="javascript:void(0)" class="show-full-ratings-link"
           data-id="<?php echo e($row->id); ?>">Show full
            ratings <i
                class="far fa-chevron-down"></i></a>
        <div class="show-full-ratings-info" data-id="<?php echo e($row->id); ?>">
            <div class="row">
                <div class="col col-sm-6 col-md-4">
                    <div class="ratings-items-box">
                        <ul class="rating-ul">
                            <?php echo \BaseFunction::getRatingStar(ceil($row['service_rate'])); ?>

                        </ul>
                        <p>Service & staff</p>
                    </div>
                </div>
                <div class="col col-sm-6 col-md-4">
                    <div class="ratings-items-box">
                        <ul class="rating-ul">
                            <?php echo \BaseFunction::getRatingStar(ceil($row['ambiente'])); ?>

                        </ul>
                        <p>Ambiance</p>
                    </div>
                </div>
                <div class="col col-sm-6 col-md-4">
                    <div class="ratings-items-box">
                        <ul class="rating-ul">
                            <?php echo \BaseFunction::getRatingStar(ceil($row['preie_leistungs_rate'])); ?>

                        </ul>
                        <p>Price-Performance Ratio</p>
                    </div>
                </div>
                <div class="col col-sm-6 col-md-4">
                    <div class="ratings-items-box">
                        <ul class="rating-ul">
                            <?php echo \BaseFunction::getRatingStar(ceil($row['wartezeit'])); ?>

                        </ul>
                        <p>Waiting period</p>
                    </div>
                </div>
                <div class="col col-sm-6 col-md-4">
                    <div class="ratings-items-box">
                        <ul class="rating-ul">
                            <?php echo \BaseFunction::getRatingStar(ceil($row['atmosphare'])); ?>

                        </ul>
                        <p>Atmosphere</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <div class="text-center">
    Keine Bewertungen verfügbar.
    </div>
<?php endif; ?>
<?php /**PATH /var/www/html/resources/views/Front/Cosmetic/rating-review.blade.php ENDPATH**/ ?>