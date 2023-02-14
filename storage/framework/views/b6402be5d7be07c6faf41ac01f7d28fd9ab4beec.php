
<?php $__env->startSection('front_title'); ?>
    Cosmetic Advantages
<?php $__env->stopSection(); ?>
<?php $__env->startSection('front_css'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('front_content'); ?>
    <!-- Home-banner -->
    <section class="home-banner-section">
        <div class="home-banner bpartners-banner cosmetics-banner">
            <div class="home-banner-img cosmetics-banner-imgs">
                <img src="<?php echo e(URL::to('storage/app/public/Frontassets/images/cosmetics-advantages-banner.jpg')); ?>" alt="">
            </div>
            <div class="banner-text-info">
                <h3>Recommended for you</h3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Harum soluta quos ipsum dolore suscipit
                    reiciendis fugit quasi error tenetur pariatur!</p>
            </div>
        </div>
    </section>
    <!-- Filter Section -->
    <section class="pt-0">
        <div class="container">
            <div class="mb-5">
                <h3 class="areas-title">Berlin Saloon </h3>
                <p class="areas-title-text"><span class="store_count"><?php echo e(count($getStore)); ?></span> Result found</p>
            </div>
            <div class="row filters-rows">
                <div class="col-lg-12">
                    <div class="filter_data">
                        <?php $__currentLoopData = $getStore; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="cosmetics-area-item-wrap">
                                <div class="cosmetics-area-item-img">
                                    <a href="<?php echo e(URL::to('cosmetic/'.$row->slug)); ?>">
                                        <?php if(file_exists(storage_path('app/public/store/'.$row->store_profile)) && $row->store_profile != ''): ?>
                                            <img src="<?php echo e(URL::to('storage/app/public/store/'.$row->store_profile)); ?>"
                                                 alt=""
                                                 style="object-fit:fill !important;">
                                        <?php else: ?>
                                            <img src="<?php echo e(URL::to('storage/app/public/default/store_default.png')); ?>"
                                                 alt=""
                                                 style="object-fit:fill !important;">
                                        <?php endif; ?>
                                    </a>
                                </div>
                                <div class="cosmetics-area-item-info">
                                    <h5>
                                        <a href="<?php echo e(URL::to('cosmetic/'.$row->slug)); ?>"> <?php echo e($row->store_name); ?> </a><span><i
                                                class="fas fa-star"></i> <?php echo e($row->rating); ?></span>
                                        <span><i class="fas fa-user"></i> 128</span>
                                    </h5>
                                    <p>
                                        <span><?php echo file_get_contents(URL::to('storage/app/public/Frontassets/images/location.svg')) ?></span>
                                        <?php echo e($row->store_address); ?>

                                    </p>
                                    <p>
                                        <span><?php echo file_get_contents(URL::to('storage/app/public/Frontassets/images/eyelash.svg')); ?></span>
                                        Cosmetic
                                    </p>
                                    <ul>
                                        <?php $__currentLoopData = $row->categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li><?php echo e(@$item->CategoryData->name); ?></li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <li class="more">More</li>
                                    </ul>
                                </div>
                                <div class="cosmetics-area-item-wishlist">
                                    <a href="javascript:void(0)"
                                       class="wishlist-icon <?php echo e($row->isFavorite == 'true' ? 'active' : ''); ?> favorite"
                                       data-id="<?php echo e($row->id); ?>"><i class="far fa-heart"></i></a>
                                    <p><?php echo e($row->is_value); ?></p>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <section class="register-cosmetic-section ">
        <div class="container">
            <div class="register-cosmetic-areas">
            <span class="register-cosmetic-lines"><img
                    src="<?php echo e(URL::to('storage/app/public/Frontassets/images/area-line.svg')); ?>" alt=""></span>
                <span class="register-cosmetic-lines2"><img
                        src="<?php echo e(URL::to('storage/app/public/Frontassets/images/area-line.svg')); ?>" alt=""></span>
                <div class="register-cosmetic-areas-info">
                    <?php if(!Auth::check()): ?>
                        <h6>Register here to be able to use all the advantages</h6>

                        <a href="javascript:void(0)" class="btn btn-white" data-toggle="modal"
                           data-target="#register-modal">Register Now</a>

                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('front_js'); ?>
    <script>
        $("body").addClass("cosmetics-body");
        $("body").addClass("cosmetics-area-body");

        $(document).on('click', '.favorite', function () {
            var auth = '<?php echo e(Auth::check()); ?>';

            if (auth == '1') {
                var id = $(this).data('id');

                $.ajax({
                    type: 'POST',
                    async: true,
                    dataType: "json",
                    url: "<?php echo e(URL::to('favorite-store')); ?>",
                    data: {
                        _token: '<?php echo e(csrf_token()); ?>',
                        id: id,
                    },
                    success: function (response) {
                        var status = response.status;
                        var type = response.data;
                        if (status == 'true') {
                            if (type == 'remove') {
                                $('.wishlist-icon[data-id=' + id + ']').removeClass('active');
                            } else if (type == 'add') {
                                $('.wishlist-icon[data-id=' + id + ']').addClass('active');
                            }
                        } else {

                        }

                    },
                    error: function (e) {

                    }
                });
            } else {
                $('#login-modal').modal('toggle');
            }
        });

    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.front', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/Front/Cosmetic/recommended.blade.php ENDPATH**/ ?>