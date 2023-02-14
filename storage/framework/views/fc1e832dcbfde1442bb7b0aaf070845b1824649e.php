<?php $__env->startSection('front_title'); ?>
    Cosmetic
<?php $__env->stopSection(); ?>
<?php $__env->startSection('front_css'); ?>
    <style>

        .close-now {
            text-align: center;
            background: #DB8A8A;
            width: max-content;
            margin: -15px auto 0;
            border-radius: 4em;
            color: #fff;
            font-size: 14px;
            font-weight: 400;
            padding: 6px 12px;
            display: flex;
            align-items: center;
        }

        .close-now span {
            display: block;
            width: 6px;
            height: 6px;
            background: #FABA5F;
            border-radius: 100%;
            margin-right: 8px;
        }

        .reservation-about-map {
            height: 300px !important;
            width: 320px !important;
        }
        .stylish-body-wrap ul li.active .stylish-profile-reviews {
            width: 95%;
            position: fixed;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            -webkit-transition: none!important;
            -o-transition: none!important;
            transition: none!important;
        }
        .stylish-body-wrap ul li.active .stylish-backdrop-overlay {
            display: block;
        }
        @media(min-width:992px) {
            .stylish-body-wrap ul li.active .stylish-profile-reviews {
                width: 70%!important;
            }
        }
        .stylish-backdrop-overlay {
            display: none; 
            position: fixed;
            z-index: 999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4);
        }
    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('front_content'); ?>

    <section class="about-banner">

        <div class="owl-carousel owl-theme" id="about-banner-owl">
            <div class="item">
                <div class="about-banner-img">
                    <?php if(file_exists(storage_path('app/public/store/banner/'.$store['store_banner'])) && $store['store_banner'] != ''): ?>
                        <img src="<?php echo e(URL::to('storage/app/public/store/banner/'.$store['store_banner'])); ?>" alt="">

                    <?php else: ?>
                        <img src="<?php echo e(URL::to('storage/app/public/default/default_banner.png')); ?>" alt="">
                    <?php endif; ?>
                </div>
            </div>
            <?php $__empty_1 = true; $__currentLoopData = $storeGallery; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="item">
                    <div class="about-banner-img">
                        <img src="<?php echo e(URL::to('storage/app/public/store/gallery/'.$row->file)); ?>" alt="">
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <?php endif; ?>

        </div>
        <span class="about-banner-after"></span>
    </section>

    <div class="container">
        <div class="about-profile">
            <div class="about-profile-img">
                <?php if(file_exists(storage_path('app/public/store/'.$store['store_profile'])) && $store['store_profile'] != ''): ?>
                    <img src="<?php echo e(URL::to('storage/app/public/store/'.$store['store_profile'])); ?>" alt="">

                <?php else: ?>
                    <img src="<?php echo e(URL::to('storage/app/public/store/Store-6058bde8bf5a8.JPEG')); ?>" alt="">
                <?php endif; ?>
                <a href="javascript:void(0)" class="favorite_icon <?php echo e($store['isFavorite'] == 'true' ? 'active' : ''); ?>"
                   data-id="<?php echo e($store['id']); ?>"><i class="far fa-heart"></i></a>
            </div>
            <div class="about-profile-info">
                <h5><?php echo e($store['store_name']); ?></h5>
                <h6><?php echo e($store['store_address']); ?></h6>
                <ul class="rating-ul">
                    <?php echo \BaseFunction::getRatingStar($store['rating']); ?>

                </ul>

               
                    <?php if((count($feedback)) > 1): ?>
                      <p>  (<?php echo e(count($feedback)); ?>)Bewertungen </p>
                    <?php else: ?>
                      <p>  (<?php echo e(count($feedback)); ?>)Bewertung </p>
                    <?php endif; ?>
                
            </div>
        </div>
        <ul class="about-box">
            <li>
            <span>
                <img src="<?php echo e(URL::to('storage/app/public/Frontassets/images/icon/service.svg')); ?>" alt="">
            </span>
                <h6>Services</h6>
                <p><?php echo e(implode(', ',$catlist)); ?></p>
            </li>
            <li>
            <span>
                <img src="<?php echo e(URL::to('storage/app/public/Frontassets/images/icon/clock.svg')); ?>" alt="">
            </span>
                <h6>Öffnungszeiten</h6>
                <p><?php echo e(\Carbon\Carbon::now()->translatedFormat('D')); ?> (<?php echo e(@$storeToday['start_time']); ?> - <?php echo e(@$storeToday['end_time']); ?>

                    )</p>
            </li>
            <li>
            <span>
                <img src="<?php echo e(URL::to('storage/app/public/Frontassets/images/icon/call.svg')); ?>" alt="">
            </span>
                <h6>Kontakt</h6>
                <p><a href="tel:<?php echo e($store['store_contact_number']); ?>"
                      style="color: #101928"> <?php echo e($store['store_contact_number']); ?></a></p>
            </li>
        </ul>
        <?php if($sstatus == 'off' || @$storeToday['is_off'] == 'on'): ?>
            <p class="close-now"><span></span>Geschlossen</p>
        <?php else: ?>
            <p class="open-now"><span></span>Geöffnet</p>
        <?php endif; ?>

    </div>

    <ul class="nav nav-pills about-pills about-pills2" id="pills-tab" role="tablist">
        <?php if($store['store_active_plan'] =='business'): ?>
            <li class="nav-item">
                <a class="nav-link <?php echo e((!empty($_GET['t']) && $_GET['t'] == 'reviews')?'':'active'); ?>" id="pills-services-tab" data-toggle="pill" href="#pills-services"
                   role="tab"
                   aria-controls="pills-services" aria-selected="false">Services</a>
            </li>
        <?php endif; ?>
        <li class="nav-item">
            <a class="nav-link " id="pills-about-tab" data-toggle="pill" href="#pills-about" role="tab"
               aria-controls="pills-about" aria-selected="true">Allgemein</a>
        </li>
        <?php if($store['store_active_plan'] !='basic'): ?>
            <li class="nav-item">
                <a class="nav-link" id="pills-work-tab" data-toggle="pill" href="#pills-work" role="tab"
                   aria-controls="pills-work" aria-selected="false">Portfolio</a>
            </li>

        <?php endif; ?>
        <li class="nav-item">
            <a class="nav-link <?php echo e((!empty($_GET['t']) && $_GET['t'] == 'reviews')?'active':''); ?>" id="pills-reviews-tab" data-toggle="pill" href="#pills-reviews" role="tab"
               aria-controls="pills-reviews" aria-selected="false">Bewertungen</a>
        </li>
    </ul>
    <section class="about-main-section">
        <div class="container">
            <div class="tab-content" id="pills-tabContent">
                <?php if($store['store_active_plan'] =='business'): ?>
                    <div class="tab-pane fade <?php echo e((!empty($_GET['t']) && $_GET['t'] == 'reviews')?'':'show active'); ?>" id="pills-services" role="tabpanel"
                         aria-labelledby="pills-services-tab">
                        <div class="service-row row">
                            <div class="col-xl-3">
                                <div class="box-fixed">
                                    <h4 class="about-title">Services</h4>
                                    <div class="accordion services-accordion" id="accordionExample">
                                        <div style="display: none"><?php echo e($i= 1); ?></div>
                                        <?php $__currentLoopData = $categoryData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                            <div class="service-accordion-margin">
                                                <a href="javascript:void(0)"
                                                   class="service-link-wrap  <?php echo e($i==1 ? '':'collapsed'); ?>"
                                                   data-toggle="collapse"
                                                   data-target="#<?php echo e(strtolower(@$row['categorys']['name'])); ?>_collapseOne"
                                                   aria-expanded="<?php echo e($i==1 ? 'true':'false'); ?>"
                                                   aria-controls="<?php echo e(strtolower(@$row['categorys']['name'])); ?>_collapseOne">
                                                    <span><?php echo file_get_contents(URL::to('storage/app/public/category/' . @$row['categorys']['image'])) ?></span>
                                                    <?php echo e(@$row['categorys']['name']); ?>

                                                    <span class="downn-arroww"><i
                                                            class="far fa-chevron-down"></i></span>
                                                </a>
                                                <div id="<?php echo e(strtolower(@$row['categorys']['name'])); ?>_collapseOne"
                                                     class="collapse <?php if($i==1): ?> show <?php endif; ?>"
                                                     aria-labelledby="headingOne"
                                                     data-parent="#accordionExample">
                                                    <div class="services-body">
                                                        <ul class="service-bodyy-ul">
                                                            <div style="display: none"><?php echo e($j= 1); ?></div>
                                                            <?php $__currentLoopData = $row['subcategory']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <li class="<?php if($j==1): ?> active <?php endif; ?>">
                                                                    <a href="javascript:void(0)"
                                                                       class="subCategoryChange" data-id="<?php echo e($item->id); ?>"
                                                                       data-category="<?php echo e(@$row['categorys']['id']); ?>">
                                                                        <p><?php echo e($item->name); ?></p>
                                                                        <i class="far fa-angle-right"></i>
                                                                    </a>
                                                                </li>
                                                                <div style="display: none"><?php echo e($j++); ?></div>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div style="display: none"><?php echo e($i++); ?></div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    </div>
                                    <div class="totla-service-wrap">
                                        <div>
                                            <h6><span class="noOfPrice">0,00</span>€</h6>
                                            <p><span class="noOfService">0</span> Service</p>
                                        </div>
                                        <a href="javascript:void(0)" class="btn main-btn paying-btn">Weiter zur Zahlung</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-9">
                                <div class="discount-populer-main">
                                    <h4 class="about-title">Beliebte Services</h4>
                                    <div class="popular">
                                        <?php $__empty_1 = true; $__currentLoopData = $service; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <?php if($row->is_popular == 'yes'): ?>
                                                <?php if(count($row->variants)==1): ?>
                                                    <div class="service-item-main">
                                                        <div class="service-item-img">
                                                            <img
                                                                src="<?php echo e(URL::to('storage/app/public/service/'.$row['image'])); ?>"
                                                                alt="">
                                                            <?php if($row->discount_type != null && $row->discount != '0' && $row->discount != null): ?>
                                                                <p class="service-discount"><?php echo e($row->discount); ?>

                                                                    <span><?php echo e($row->discount_type == 'percentage' ? '%' : '€'); ?></span>
                                                                </p>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="service-item-info">
                                                            <div class="service-info-top">
                                                                <h6><?php echo e($row->service_name); ?></h6>
                                                                <a href="javascript:void(0)" class="showDetails"
                                                                   data-service="<?php echo e($row->service_name); ?>"
                                                                   data-descri="<?php echo e($row->description); ?>"
                                                                   data-image="<?php echo e(URL::to('storage/app/public/service/'.$row['image'])); ?>"
                                                                   data-rating="<?php echo e($row->rating); ?>"
                                                                >
                                                                Zeige Details</a>
                                                            </div>
                                                            <div class="time_price_info">
                                                                <?php $__currentLoopData = $row->variants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <h6><?php echo e($item['duration_of_service']); ?> min</h6>
                                                                    <div class="price-info">
                                                                        <?php if($row->discount_type != null && $row->discount != '0' && $row->discount != null): ?>
                                                                            <h5><?php echo e(number_format(\BaseFunction::finalPriceVariant($row->id,$item['id']),2,',','.')); ?>

                                                                                €
                                                                                <span><?php echo e(number_format($item['price'],2,',','.')); ?>€</span>
                                                                            </h5>
                                                                        <?php else: ?>
                                                                            <h5><?php echo e(number_format($item['price'],2,',','.')); ?>€</h5>
                                                                        <?php endif; ?>
                                                                        <div style="display: none">
                                                                            <?php if($row->discount_type != null && $row->discount != '0' && $row->discount != null): ?>
																				<?php $newprice =  \BaseFunction::finalPriceVariant($row->id,$item['id']); ?>
                                                                                <?php echo e(number_format($newprice,2,',','.')); ?>

                                                                            <?php else: ?>
																				<?php $newprice = $item['price']; ?>
                                                                                <?php echo e(number_format($newprice,2,',','.')); ?>

                                                                            <?php endif; ?>
                                                                        </div>
                                                                        <a class="select--btnn"
                                                                           data-service="<?php echo e($row->id); ?>"
                                                                           data-price="<?php echo e($newprice); ?>"
                                                                           data-store="<?php echo e($store['id']); ?>"
                                                                           data-category="<?php echo e($row->category_id); ?>"
                                                                           data-subcategory="<?php echo e($row->subcategory_id); ?>"
                                                                           data-variant="<?php echo e($item['id']); ?>"
                                                                           href="javascript:void(0)">Wählen</a>
                                                                    </div>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php elseif(count($row->variants) > 1): ?>
                                                    <div class="service-item-main">
                                                        <div class="service-item-img">
                                                            <img
                                                                src="<?php echo e(URL::to('storage/app/public/service/'.$row['image'])); ?>"
                                                                alt="">
                                                            <?php if($row->discount_type != null && $row->discount != '0' && $row->discount != null): ?>
                                                                <p class="service-discount"><?php echo e($row->discount); ?>

                                                                    <span><?php echo e($row->discount_type == 'percentage' ? '%' : '€'); ?></span>
                                                                </p>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="service-item-info">
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
                                                                Zeige Details</a>
                                                            </div>
                                                            <div class="time_price_info">
                                                                <h6><?php echo e(min(array_map(function($a) { return $a['duration_of_service']; }, $row->variants))); ?>

                                                                    min
                                                                    - <?php echo e(max(array_map(function($a) { return $a['duration_of_service']; }, $row->variants))); ?>

                                                                    min</h6>
                                                                <div class="price-info">
                                                                    <h5>
																		<?php 
																			$origional = number_format(min(array_map(function($a) { return $a['price']; }, $row->variants)), 2, ',', '.');
																			$discounted = number_format(min(array_map(function($a) { return \BaseFunction::finalPriceVariant($a['service_id'],$a['id']); }, $row->variants)), 2, ',', '.');
																		?>
																		 <?php if($row->discount_type != null && $row->discount != '0' && $row->discount != null): ?>
																			ab <?php echo e($discounted); ?> €
																			<span><?php echo e($origional); ?> €</span>
																		 <?php else: ?>
																			 ab <?php echo e($origional); ?> €
																		 <?php endif; ?>
																		</h5>
                                                                </div>
                                                            </div>
                                                            <div id="sliderr" class="sliderr" data-id="p<?php echo e($row->id); ?>">
                                                                <?php $__currentLoopData = $row->variants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <div class="service-media-wrap">
                                                                        <div class="service-media-infos">
                                                                            <h6><?php echo e($item['description']); ?></h6>
                                                                            <p><?php echo e($item['duration_of_service']); ?> min</p>
                                                                        </div>
                                                                        <div class="price-info">
                                                                            <?php if($row->discount_type != null && $row->discount != '0' && $row->discount != null): ?>
                                                                                <h5><?php echo e(number_format(\BaseFunction::finalPriceVariant($row->id,$item['id']),2,',','.')); ?>

                                                                                    € <span><?php echo e(number_format($item['price'],2,',','.')); ?>€</span>
                                                                                </h5>
                                                                            <?php else: ?>
                                                                                <h5><?php echo e(number_format($item['price'],2,',','.')); ?>

                                                                                    €</h5>
                                                                            <?php endif; ?>
                                                                            <div style="display: none">
                                                                                <?php if($row->discount_type != null && $row->discount != '0'&& $row->discount != null): ?>
																					<?php $newprice = \BaseFunction::finalPriceVariant($row->id,$item['id']); ?>
                                                                                    <?php echo e(number_format($newprice,2,',','.')); ?>

                                                                                <?php else: ?>
																					<?php $newprice =  $item['price']; ?>
                                                                                    <?php echo e(number_format($newprice,2,',','.')); ?>

                                                                                <?php endif; ?>
                                                                            </div>
                                                                            <a class="select--btnn"
                                                                               data-service="<?php echo e($row->id); ?>"
                                                                               data-price="<?php echo e($newprice); ?>"
                                                                               data-store="<?php echo e($store['id']); ?>"
                                                                               data-category="<?php echo e($row->category_id); ?>"
                                                                               data-subcategory="<?php echo e($row->subcategory_id); ?>"
                                                                               data-variant="<?php echo e($item['id']); ?>"
                                                                               href="javascript:void(0)">Wählen</a>
                                                                        </div>
                                                                    </div>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <div class="text-center">
                                                Kein Service gefunden.
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="all-services-main">
                                    <h4 class="about-title">Alle Services</h4>
                                    <div class="allService">
                                        <?php $__empty_1 = true; $__currentLoopData = $service; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <?php if(count($row->variants)==1): ?>
                                                <div class="service-item-main">
                                                    <div class="service-item-img">
                                                        <img
                                                            src="<?php echo e(URL::to('storage/app/public/service/'.$row['image'])); ?>"
                                                            alt="">
                                                        <?php if($row->discount_type != null && $row->discount != '0'&& $row->discount != null): ?>
                                                            <p class="service-discount"><?php echo e($row->discount); ?>

                                                                <span><?php echo e($row->discount_type == 'percentage' ? '%' : '€'); ?></span>
                                                            </p>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="service-item-info">
                                                        <div class="service-info-top">
                                                            <h6><?php echo e($row->service_name); ?></h6>
                                                            <a href="javascript:void(0)" class="showDetails"
                                                               data-service="<?php echo e($row->service_name); ?>"
                                                               data-descri="<?php echo e($row->description); ?>"
                                                               data-image="<?php echo e(URL::to('storage/app/public/service/'.$row['image'])); ?>"
                                                               data-rating="<?php echo e($row->rating); ?>"
                                                            >
                                                            Zeige Details</a>
                                                        </div>
                                                        <div class="time_price_info">
                                                            <?php $__currentLoopData = $row->variants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <h6><?php echo e($item['duration_of_service']); ?> min</h6>
                                                                <div class="price-info">
                                                                    <?php if($row->discount_type != null && $row->discount != '0' && $row->discount != null): ?>
                                                                        <h5><?php echo e(number_format(\BaseFunction::finalPriceVariant($row->id,$item['id']),2,',','.')); ?>

                                                                            €
                                                                            <span><?php echo e(number_format($item['price'],2,',','.')); ?>€</span>
                                                                        </h5>
                                                                    <?php else: ?>
                                                                        <h5><?php echo e(number_format($item['price'],2,',','.')); ?>€</h5>
                                                                    <?php endif; ?>
                                                                    <div style="display: none">
                                                                        <?php if($row->discount_type != null && $row->discount != '0'): ?>
																			<?php $newprice = \BaseFunction::finalPriceVariant($row->id,$item['id']); ?>
                                                                            <?php echo e(number_format($newprice,2,',','.')); ?>

                                                                        <?php else: ?>
																			<?php $newprice =  $item['price']; ?>
                                                                            <?php echo e(number_format($newprice,2,',','.')); ?>

                                                                        <?php endif; ?>
                                                                    </div>
                                                                    <a class="select--btnn"
                                                                       data-service="<?php echo e($row->id); ?>"
                                                                       data-price="<?php echo e($newprice); ?>"
                                                                       data-store="<?php echo e($store['id']); ?>"
                                                                       data-category="<?php echo e($row->category_id); ?>"
                                                                       data-subcategory="<?php echo e($row->subcategory_id); ?>"
                                                                       data-variant="<?php echo e($item['id']); ?>"
                                                                       href="javascript:void(0)">Wählen</a>
                                                                </div>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php elseif(count($row->variants) > 1): ?>
                                                <div class="service-item-main">
                                                    <div class="service-item-img">
                                                        <img
                                                            src="<?php echo e(URL::to('storage/app/public/service/'.$row['image'])); ?>"
                                                            alt="">
                                                        <?php if($row->discount_type != null && $row->discount != '0' && $row->discount != null): ?>
                                                            <p class="service-discount"><?php echo e($row->discount); ?>

                                                                <span><?php echo e($row->discount_type == 'percentage' ? '%' : '€'); ?></span>
                                                            </p>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="service-item-info">
                                                        <div class="service-info-top">
                                                            <h6><?php echo e($row->service_name); ?>

                                                                <span id="flip" class="down-arroww flip"
                                                                      data-id="<?php echo e($row->id); ?>"><i
                                                                        class="far fa-chevron-down"></i></span>
                                                            </h6>
                                                            <a href="javascript:void(0)" class="showDetails"
                                                               data-service="<?php echo e($row->service_name); ?>"
                                                               data-descri="<?php echo e($row->description); ?>"
                                                               data-image="<?php echo e(URL::to('storage/app/public/service/'.$row['image'])); ?>"
                                                               data-rating="<?php echo e($row->rating); ?>"
                                                            >
                                                            Zeige Details</a>
                                                        </div>
                                                        <div class="time_price_info">
                                                            <h6><?php echo e(min(array_map(function($a) { return $a['duration_of_service']; }, $row->variants))); ?>

                                                                min
                                                                - <?php echo e(max(array_map(function($a) { return $a['duration_of_service']; }, $row->variants))); ?>

                                                                min</h6>
                                                            <div class="price-info">
                                                                <h5>
																	<?php 
																			$origional = number_format(min(array_map(function($a) { return $a['price']; }, $row->variants)), 2, ',', '.');
																			$discounted = number_format(min(array_map(function($a) { return \BaseFunction::finalPriceVariant($a['service_id'],$a['id']); }, $row->variants)), 2, ',', '.');
																		?>
																		 <?php if($row->discount_type != null && $row->discount != '0' && $row->discount != null): ?>
																			ab <?php echo e($discounted); ?> €
																			<span><?php echo e($origional); ?> €</span>
																		 <?php else: ?>
																			 ab <?php echo e($origional); ?> €
																		 <?php endif; ?>
                                                                 </h5>
                                                            </div>
                                                        </div>
                                                        <div id="sliderr" class="sliderr" data-id="<?php echo e($row->id); ?>">
                                                            <?php $__currentLoopData = $row->variants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <div class="service-media-wrap">
                                                                    <div class="service-media-infos">
                                                                        <h6><?php echo e($item['description']); ?></h6>
                                                                        <p><?php echo e($item['duration_of_service']); ?> min</p>
                                                                    </div>
                                                                    <div class="price-info">
                                                                        <?php if($row->discount_type != null && $row->discount != '0' && $row->discount != null): ?>
                                                                            <h5><?php echo e(number_format(\BaseFunction::finalPriceVariant($row->id,$item['id']),2,',','.')); ?>

                                                                                € <span><?php echo e(number_format($item['price'],2,',','.')); ?>€</span>
                                                                            </h5>
                                                                        <?php else: ?>
                                                                            <h5><?php echo e(number_format($item['price'],2,',','.')); ?>

                                                                                €</h5>
                                                                        <?php endif; ?>
                                                                        <div style="display: none">
                                                                            <?php if($row->discount_type != null && $row->discount != '0' && $row->discount != null): ?>
																				<?php $newprice = \BaseFunction::finalPriceVariant($row->id,$item['id']); ?>
                                                                                <?php echo e(number_format($newprice,2,',','.')); ?>

                                                                            <?php else: ?>
																				<?php $newprice = $item['price']; ?>
                                                                                <?php echo e(number_format($newprice,2,',','.')); ?>

                                                                            <?php endif; ?>
                                                                        </div>
                                                                        <a class="select--btnn"
                                                                           data-service="<?php echo e($row->id); ?>"
                                                                           data-store="<?php echo e($store['id']); ?>"
                                                                           data-price="<?php echo e($newprice); ?>"
                                                                           data-category="<?php echo e($row->category_id); ?>"
                                                                           data-subcategory="<?php echo e($row->subcategory_id); ?>"
                                                                           data-variant="<?php echo e($item['id']); ?>"
                                                                           href="javascript:void(0)">Wählen</a>
                                                                    </div>
                                                                </div>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <div class="text-center">
                                                Kein Service gefunden.
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="tab-pane fade " id="pills-about" role="tabpanel"
                     aria-labelledby="pills-about-tab">
                    <div class="service-row row">
                        <div class="col-xl-3">
                            <div class="box-fixed  map-box">
                                <div class="a-service-map">
                                    <div class="reservation-about-map" id="map">
                                    </div>
                                </div>
                                <div class="a-service-media">
                                    <span>
                                        <?php echo file_get_contents(URL::to('storage/app/public/Frontassets/images/icon/pin.svg')) ?>
                                    </span>
                                    <div>
                                        <h6>Bezirk</h6>
                                        <p><?php echo e($store['store_district']); ?></p>
                                    </div>
                                </div>
                                <div class="a-service-media">
                                    <span>
                                        <?php echo file_get_contents(URL::to('storage/app/public/Frontassets/images/icon/clock.svg')) ?>
                                    </span>
                                    <div>
                                        <h6>Öffnungszeiten</h6>
                                    </div>
                                </div>
                                <ul class="a-service-days">
                                    <?php $__currentLoopData = $storeTiming; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li class="<?php if(\Carbon\Carbon::now()->format('l') == $row->day): ?> active <?php endif; ?>">
                                            <p><?php echo e(\Carbon\Carbon::create($row->day)->locale('de_DE')->dayName); ?></p>
                                            <p><?php if($row->is_off == null): ?><?php echo e($row->start_time); ?>

                                                - <?php echo e($row->end_time); ?> <?php else: ?> Store Close <?php endif; ?></p>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                </ul>
                                <div class="a-service-media">
                                    <span>
                                        <?php echo file_get_contents(URL::to('storage/app/public/Frontassets/images/icon/earth.svg')) ?>
                                    </span>
                                    <div>
                                        <h6>Webseite</h6>
                                        <a href="<?php echo e($store['store_link_id'] == '' ? '#' :$store['store_link_id']); ?>"><?php echo e($store['store_link_id'] == '' ? '-' : $store['store_link_id']); ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-9">
                            <?php if(count($storeSpecific)>0): ?>
                                <div class="specifics-main">
                                    <h4 class="about-title">Eigenschaften</h4>
                                    <ul>
                                        <?php $__currentLoopData = $storeSpecific; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li>
                                                <span><?php echo file_get_contents(URL::to('storage/app/public/features/' . @$row->featureData->image)) ?></span>

                                                <?php echo e(@$row->featureData->name); ?></li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                            <?php if($store['store_description'] != ''): ?>
                                <div class="about-discription-main">
                                    <h4 class="about-title">Beschreibung</h4>
                                    <p><?php echo $store['store_description']; ?></p>
                                </div>
                            <?php endif; ?>
                            <div class="advantages-main">
                                <?php if(count($advantages) > 0): ?>
                                    <h4 class="about-title">Vorteile</h4>
                                    <div class="row">
                                        <?php $__currentLoopData = $advantages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="col-lg-6 col-md-6">
                                                <div class="advantages-item">
                                                    <span><?php echo file_get_contents(URL::to("storage/app/public/store/advantage/" . $row->image)) ?></span>
                                                    <h6><?php echo e($row->title); ?></h6>
                                                    <p><?php echo e($row->description); ?></p>
                                                </div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <?php if($store['store_active_plan'] =='business'): ?>
                                <?php if(count($expert)>0): ?>
                                    <div class="stylish-main-div">
                                        <div class="stylish-header-wrap">
                                            <h4 class="about-title">Mitarbeiter</h4>
                                            <div class="stylish-header-search">
                                                <input type="text" placeholder="Suche nach Mitarbeitern .." id="myInput">
                                                <a href="#"><i class="far fa-search"></i></a>
                                            </div>
                                            <!-- <a href="#" class="btn main-btn btn-stylish-next">Next</a> -->
                                        </div>
                                        <div class="stylish-body-wrap">
                                            <ul>
                                                <?php $__currentLoopData = $expert; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <li class="expert_li">
                                                        <div class="stylish-profile">
                                                            <span class="experts-imgg">
																 <?php if(file_exists(storage_path('app/public/store/employee/'.$row->image)) && @$row->image != ''): ?>
																	<img src="<?php echo e(URL::to('storage/app/public/store/employee/'.$row->image)); ?>" alt="">
																 <?php else: ?>
																	 <?php
																			$empnameArr = explode(" ", $row->emp_name);
																			$empname = "";
																			if(count($empnameArr) > 1){
																				$empname = strtoupper(substr($empnameArr[0], 0, 1)).strtoupper(substr($empnameArr[1], 0, 1));
																			}else{
																				$empname = strtoupper(substr( $row->emp_name, 0, 2));
																			}
																		?>
																	  <img src="https://via.placeholder.com/150x150/00000/FABA5F?text=<?php echo e($empname); ?>" alt="employee">
																 <?php endif; ?>
															</span>
                                                            <p class="review-box"><span><i
                                                                        class="fas fa-star"></i></span><?php echo e(\BaseFunction::finalRatingEmp($row->store_id,$row->id)); ?>

                                                            </p>
                                                            <h6><?php echo e($row->emp_name); ?></h6>
                                                        </div>
                                                        <div class="stylish-backdrop-overlay"></div>
                                                        <div class="stylish-profile-reviews">
                                                            <a href="javascript:void(0)"
                                                               class="profile-reviews-close"><i
                                                                    class="fas fa-times"></i></a>
                                                            <div class="scroll-class">


                                                                <?php $__empty_1 = true; $__currentLoopData = $row->getReviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                                    <div class="stylish-profile-review-item">
                                                                        <div class="profile-review-item-wrap">
                                                                            <div class="profile-review-info">
                                                                            <span>
                                                                                <?php if(file_exists(storage_path('app/public/user/'.@$item->userDetails->profile_pic)) && @$item->userDetails->profile_pic != ''): ?>
                                                                                    <img
                                                                                        src="<?php echo e(URL::to('storage/app/public/user/'.@$item->userDetails->profile_pic)); ?>"
                                                                                        alt="user">
                                                                                <?php else: ?>
                                                                                    <img
                                                                                        src="https://via.placeholder.com/1080x1080/00000/FABA5F?text=<?php echo e(strtoupper(substr(@$item->userDetails->first_name, 0, 1))); ?><?php echo e(strtoupper(substr(@$item->userDetails->last_name, 0, 1))); ?>"
                                                                                        alt="user">
                                                                                <?php endif; ?>
                                                                            </span>
                                                                                <div>
                                                                                    <h6><?php echo e(@$item->userDetails->first_name); ?> <?php echo e(@$item->userDetails->last_name); ?></h6>
                                                                                    <p><?php echo e(@$item->categoryDetails->name); ?>

                                                                                        - <?php echo e(@$item->serviceDetails->service_name); ?></p>
                                                                                </div>
                                                                            </div>
                                                                            <div class="review-infos">
                                                                                <p class="review-box"><span><i
                                                                                            class="fas fa-star"></i></span><?php echo e($item->total_avg_rating); ?>

                                                                                </p>
                                                                                <span><?php echo e(\Carbon\Carbon::parse($item->created_at)->diffForHumans()); ?></span>
                                                                            </div>
                                                                        </div>
                                                                        <p><?php echo $item->write_comment; ?></p>

                                                                         <?php if(!empty($item->store_replay)): ?>
                                                                            <a href="javascript:void(0)" class="venue-replay-link">Antwort <i
                                                                                    class="far fa-chevron-down"></i></a>
                                                                            <div class="venue-replay-info">
                                                                                <p><i class="far fa-undo-alt"></i> <?php echo $item->store_replay; ?></p>
                                                                            </div>
                                                                        <?php endif; ?>
                                                                        <a href="javascript:void(0)"
                                                                           class="show-full-ratings-link"
                                                                           data-id="emp-<?php echo e($item->id); ?>">Mehr anzeigen<i
                                                                                class="far fa-chevron-down"></i></a>
                                                                        <div class="show-full-ratings-info"
                                                                             data-id="emp-<?php echo e($item->id); ?>">
                                                                            <div class="row">
                                                                                <div class="col-md-4 col-sm-6">
                                                                                    <div class="ratings-items-box">
                                                                                        <ul class="rating-ul">
                                                                                            <?php echo \BaseFunction::getRatingStar($item['service_rate']); ?>

                                                                                        </ul>
                                                                                        <p>Service & Mitarbeiter</p>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-4 col-sm-6">
                                                                                    <div class="ratings-items-box">
                                                                                        <ul class="rating-ul">
                                                                                            <?php echo \BaseFunction::getRatingStar($item['ambiente']); ?>

                                                                                        </ul>
                                                                                        <p>Ambiente</p>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-4 col-sm-6">
                                                                                    <div class="ratings-items-box">
                                                                                        <ul class="rating-ul">
                                                                                            <?php echo \BaseFunction::getRatingStar($item['preie_leistungs_rate']); ?>

                                                                                        </ul>
                                                                                        <p>Preis-Leistung</p>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-4 col-sm-6">
                                                                                    <div class="ratings-items-box">
                                                                                        <ul class="rating-ul">
                                                                                            <?php echo \BaseFunction::getRatingStar($item['wartezeit']); ?>

                                                                                        </ul>
                                                                                        <p>Wartezeit </p>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-4 col-sm-6">
                                                                                    <div class="ratings-items-box">
                                                                                        <ul class="rating-ul">
                                                                                            <?php echo \BaseFunction::getRatingStar($item['atmosphare']); ?>

                                                                                        </ul>
                                                                                        <p>Atmosphäre</p>
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
                                                            </div>
                                                        </div>
                                                    </li>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                            </ul>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                            <?php if(count($transport)>0): ?>
                                <div class="public-main-div">
                                    <h4 class="about-title">Öffentliche Verkehrsmittel </h4>
                                    <h6>Nächste Haltestelle</h6>
                                    <ul>
                                        <?php $__currentLoopData = $transport; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li>
                                        <span>

                                             <?php echo e($row->transportation_no); ?>

                                        </span>
                                                <p><?php echo e($row->title); ?></p>
                                            </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php if($store['store_active_plan'] !='basic'): ?>
                    <div class="tab-pane fade" id="pills-work" role="tabpanel" aria-labelledby="pills-work-tab">
                        <div class="row pillss-row">
                            <?php $__empty_1 = true; $__currentLoopData = $storeGallery; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <div class="col-lg-3 col-md-6">
                                    <a class="c-gallery-item"
                                       href="<?php echo e(URL::to('storage/app/public/store/gallery/'.$row->file)); ?>"
                                       data-fancybox="gallery">
                                        <img src="<?php echo e(URL::to('storage/app/public/store/gallery/'.$row->file)); ?>"
                                             alt="">
                                    </a>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <div>
                                    <p class="text-center">No Images Found.</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                <?php endif; ?>
                <div class="tab-pane fade <?php echo e((!empty($_GET['t']) && $_GET['t'] == 'reviews')?'show active':''); ?>" id="pills-reviews" role="tabpanel" aria-labelledby="pills-reviews-tab">
                    <div class="service-row row">
                        <div class="col-xl-3">
                            <div class="review-main-box">
                                <div class="review-top-box">
                                    <h5><?php echo e($store['rating']); ?>/5.0</h5>
                                    <ul class="rating-ul">
                                        <?php echo \BaseFunction::getRatingStar($store['rating']); ?>

                                    </ul>
                                    <?php if((count($feedback)) > 1): ?>
                                        <p>(<?php echo e(count($feedback)); ?>)Bewertungen</p>
                                    <?php else: ?>
                                    <p>(<?php echo e(count($feedback)); ?>)Bewertung</p>
                                    <?php endif; ?>
                                </div>
                                <div class="text-center mb-4">
                                    <?php if(!Auth::check()): ?>
                                        <a href="javascript:void(0)"
                                           class="btn btn-black btn-feedback" data-toggle="modal"
                                           data-target="#login-modal">
                                           Feedback geben</a>
                                    <?php else: ?>
                                        <a href="<?php echo e(route('users.feedback', ['slug' => $store['slug']])); ?>"
                                           class="btn btn-black btn-feedback">
                                           Feedback geben</a>
                                    <?php endif; ?>
                                </div>
                                <ul class="reviews-ul-info">
                                    <li>
                                        <p><?php echo e(number_format($rating['service_rate'],1)); ?>/5.0</p>
                                        <span>Service & Mitarbeiter</span>
                                    </li>
                                    <li>
                                        <p><?php echo e(number_format($rating['ambiente'],1)); ?>/5.0</p> <span>Ambiente</span>
                                    </li>
                                    <li>
                                        <p><?php echo e(number_format($rating['preie_leistungs_rate'],1)); ?>/5.0</p> <span>Preis-Leistung</span>
                                    </li>
                                    <li>
                                        <p><?php echo e(number_format($rating['wartezeit'],1)); ?>/5.0</p>
                                        <span>Wartezeit </span>
                                    </li>
                                    <li>
                                        <p><?php echo e(number_format($rating['atmosphare'],1)); ?>/5.0</p> <span>Atmosphäre</span>
                                    </li>

                                </ul>
                            </div>
                        </div>
                        <div class="col-xl-9">
                            <div class="review-info-header">
                                <h5>Bewertungen</h5>
                                <div class="filter-items-widths">
                                    <div class="filter-box">
                                        <a class="filter-box-icon"
                                           href="javascript:void(0)" data-toggle="modal"
                                           data-target="#filterModal"><?php echo file_get_contents(URL::to('storage/app/public/Frontassets/images/icon/filtter.svg')) ?></a>
                                    </div>
                                    <select class="select review_sorting">
                                        <option value="">Sortieren </option>
                                        <option value="newest">Neueste Bewertung</option>
                                        <option value="best_rated">Beste Bewertung</option>
                                        <option value="worst_rated">Schlechteste Bewertung</option>
                                    </select>
                                </div>
                            </div>
                            <div class="review-info-search">
                                <input type="text" placeholder="Suche nach Mitarbeitern,Service, Bewertungen, …" id="myInputReview">
                                <a href="javascript:void(0)"><i class="far fa-search"></i></a>
                            </div>
                            <hr class="review-hr"/>
                            <div class="review-info-body">
                                <?php $__empty_1 = true; $__currentLoopData = $feedback; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                     <div class="review-info-items" id="<?php echo e(base64_encode('r'.$row->id)); ?>">
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
                                                        <p>Service von <span><?php echo e(@$row->empDetails->emp_name); ?></span></p>
                                                    <?php endif; ?>
                                                </div>
                                                <?php if($row->category_id != '' || $row->service_id != ''): ?>
                                                    <p class="review-info-tag-box review-info-tag-box2"><?php echo e(@$row->categoryDetails->name); ?>

                                                        -
                                                        <?php echo e(@$row->serviceDetails->service_name); ?></p>
                                                <?php endif; ?>

                                            </div>
                                            <div class="main-review-info-tag-box">
                                                <p class="review-box"><span><i
                                                            class="fas fa-star"></i></span><?php echo e($row->total_avg_rating); ?>

                                                </p>

                                                <h5><?php echo e(\Carbon\Carbon::parse($row->updated_at)->diffForHumans()); ?></h5>
                                            </div>
                                        </div>
                                        <p class="review-information">
                                            <?php echo $row->write_comment; ?></p>
                                        <?php if(!empty($row->store_replay)): ?>
                                            <a href="javascript:void(0)" class="venue-replay-link">Antwort <i
                                                    class="far fa-chevron-down"></i></a>
                                            <div class="venue-replay-info">
                                                <p><i class="far fa-undo-alt"></i> <?php echo $row->store_replay; ?></p>
                                            </div>
                                        <?php endif; ?>
                                        <a href="javascript:void(0)" class="show-full-ratings-link"
                                           data-id="<?php echo e($row->id); ?>">Mehr anzeigen
                                             <i
                                                class="far fa-chevron-down"></i></a>
                                        <div class="show-full-ratings-info" data-id="<?php echo e($row->id); ?>">
                                            <div class="row">
                                                <div class="col col-sm-6 col-md-4">
                                                    <div class="ratings-items-box">
                                                        <ul class="rating-ul">
                                                            <?php echo \BaseFunction::getRatingStar($row['service_rate']); ?>

                                                        </ul>
                                                        <p>Service & Mitarbeiter</p>
                                                    </div>
                                                </div>
                                                <div class="col col-sm-6 col-md-4">
                                                    <div class="ratings-items-box">
                                                        <ul class="rating-ul">
                                                            <?php echo \BaseFunction::getRatingStar($row['ambiente']); ?>

                                                        </ul>
                                                        <p>Ambiente</p>
                                                    </div>
                                                </div>
                                                <div class="col col-sm-6 col-md-4">
                                                    <div class="ratings-items-box">
                                                        <ul class="rating-ul">
                                                            <?php echo \BaseFunction::getRatingStar($row['preie_leistungs_rate']); ?>

                                                        </ul>
                                                        <p>Preis - Leistung</p>
                                                    </div>
                                                </div>
                                                <div class="col col-sm-6 col-md-4">
                                                    <div class="ratings-items-box">
                                                        <ul class="rating-ul">
                                                            <?php echo \BaseFunction::getRatingStar($row['wartezeit']); ?>

                                                        </ul>
                                                        <p>Wartezeit</p>
                                                    </div>
                                                </div>
                                                <div class="col col-sm-6 col-md-4">
                                                    <div class="ratings-items-box">
                                                        <ul class="rating-ul">
                                                            <?php echo \BaseFunction::getRatingStar($row['atmosphare']); ?>

                                                        </ul>
                                                        <p>Atmosphäre</p>
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="register-cosmetic-section">
        <div class="container">
            <div class="register-cosmetic-areas">
                <span class="register-cosmetic-lines"><img src="assets/images/area-line.svg" alt=""></span>
                <span class="register-cosmetic-lines2"><img src="assets/images/area-line.svg" alt=""></span>
                <div class="register-cosmetic-areas-info">
                    <h6>Registriere dich hier,
um alle Vorteile zu nutzen</h6>
                    <?php if(!Auth::check()): ?>
                        <a href="javascript:void(0)" class="btn btn-white" data-toggle="modal"
                           data-target="#register-modal">Jetzt registrieren</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- service-modal -->
    <div class="modal fade" id="service-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <a href="javascript:void(0)" data-dismiss="modal" class="close-modal-btn"><i
                        class="far fa-times"></i></a>
                <div class="servic-modal-header">
                    <div class="servic-modal-header-wrap">
                        <div class="servic-modal-img">
                            <img src="./assets/images/service-modal-img.jpg" alt="" class="serviceDescImage">
                        </div>
                        <div class="servic-modal-info">
                            <h5 class="serviceDesName">Ladies - Full Head
                                Highlights/Lowlights,
                                Haircut & Style</h5>
                        </div>
                    </div>
                    <div class="service-modal-rating-wrap">
                        <ul class="rating-ul servicerting">
                            <li class="active"><i class="fas fa-star"></i></li>
                            <li class="active"><i class="fas fa-star"></i></li>
                            <li class="active"><i class="fas fa-star"></i></li>
                            <li class="active"><i class="fas fa-star"></i></li>
                            <li class=""><i class="fas fa-star"></i></li>
                        </ul>
                        <p class="serviceDesRating">4.5</p>
                    </div>
                </div>
                <div class="servic-modal-body">
                    <h6>Beschreibung</h6>
                    <div class="serviceDesDescription"></div>
                </div>
                <div class="servic-modal-footer">
                    <a href="javascript:void(0)" data-dismiss="modal">Schließen</a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button> -->
                    <div class="filter-white-box">
                        <div class="filter-box-header">
                            <h4>Filter</h4>
                        </div>
                        <div class="filter-box-body">
                            <div class="accordion" id="accordionExample">
                                <div class="area-accordion-card">
                                    <a href="#" class="area-accordion-link "
                                       data-toggle="collapse"
                                       data-target="#area-collapseThree" aria-expanded="false"
                                       aria-controls="area-collapseThree">
                                        <p>Bewertung</p>
                                        <span><i class="far fa-chevron-down"></i></span>
                                    </a>
                                    <div id="area-collapseThree" class="collapse show"
                                         aria-labelledby="headingThree"
                                         data-parent="#accordionExample">
                                        <div class="card-body star-rating-body">
                                            <div class="star-rating">
                                                <input id="star-5" type="radio" name="rating"
                                                       value="5"/>
                                                <label for="star-5" title="5 stars">
                                                    <i class="active fa fa-star"
                                                       aria-hidden="true"></i>
                                                </label>
                                                <input id="star-4" type="radio" name="rating"
                                                       value="4"/>
                                                <label for="star-4" title="4 stars">
                                                    <i class="active fa fa-star"
                                                       aria-hidden="true"></i>
                                                </label>
                                                <input id="star-3" type="radio" name="rating"
                                                       value="3"/>
                                                <label for="star-3" title="3 stars">
                                                    <i class="active fa fa-star"
                                                       aria-hidden="true"></i>
                                                </label>
                                                <input id="star-2" type="radio" name="rating"
                                                       value="2"/>
                                                <label for="star-2" title="2 stars">
                                                    <i class="active fa fa-star"
                                                       aria-hidden="true"></i>
                                                </label>
                                                <input id="star-1" type="radio" name="rating"
                                                       value="1"/>
                                                <label for="star-1" title="1 star">
                                                    <i class="active fa fa-star"
                                                       aria-hidden="true"></i>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="area-accordion-card">
                                    <a href="#" class="area-accordion-link collapsed"
                                       data-toggle="collapse" data-target="#areacollapseOne"
                                       aria-expanded="" aria-controls="areacollapseOne">
                                        <p>Services</p>
                                        <span><i class="far fa-chevron-down"></i></span>
                                    </a>

                                    <div id="areacollapseOne" class="collapse show"
                                         aria-labelledby="headingOne"
                                         data-parent="#accordionExample">
                                        <div class="card-body store-body">
                                            <div class="owl-carousel owl-theme"
                                                 id="service-item-owl">
                                                <?php $__currentLoopData = $cate_subcategoryData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row=>$data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <div class="item">
                                                        <label href="javascript:void(0)"
                                                               class="service-item-icon main_ser"
                                                               data-id="<?php echo e($data['id']); ?>"
                                                               for="service-item-<?php echo e($data['id']); ?>">
                                                            <input type="radio" name="main_cate" value="<?php echo e($data['id']); ?>"
                                                                   id="service-item-<?php echo e($data['id']); ?>">
                                                            <span><?php echo file_get_contents(URL::to('storage/app/public/category/' . $data['image'])) ?></span>
                                                            <h6><?php echo e($data['name']); ?></h6>
                                                        </label>
                                                    </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                            </div>
                                            <ul class="service-sub-item">
                                                <?php $__currentLoopData = $cate_subcategoryData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php $__currentLoopData = $row['sub_cate']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row=>$data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <li class="sub_cate sub_cat_<?php echo e($data['main_category']); ?>">
                                                            <label for="sub-service-item-<?php echo e($data['id']); ?>">
                                                                <input type="radio" name="sub_cate"
                                                                       value="<?php echo e($data['id']); ?>"
                                                                       id="sub-service-item-<?php echo e($data['id']); ?>">
                                                                <p><?php echo e($data['name']); ?></p>
                                                                <i class="far fa-chevron-right"></i>
                                                            </label>
                                                        </li>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="filter-box-footer">
                            <a href="javascript:void(0)" class="btn btn-filter main-btn">Anwenden
                                </a>
                            <a href="javascript:void(0)" class="clear-filter">Löschen</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('front_js'); ?>
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBSItHxCbk9qBcXp1XTysVLYcJick5K8mU&callback=initMap">
    </script>

    <script src="<?php echo e(URL::to('storage/app/public/Frontassets/js/data.js')); ?>"></script>
    <script>


        var lat = "<?php echo e($store['latitude']); ?>";
        var long = "<?php echo e($store['longitude']); ?>";
        var store_id = '<?php echo e($store['id']); ?>';

        $(document).ready(function () {

            var lastvalue = localStorage.getItem('lastValue');

            if (lastvalue == 'proceed_to_pay') {

                $('.paying-btn').click();
            }
            $(document).on("keyup", '#myInput', function () {
                var value = $(this).val().toLowerCase();
                $(".stylish-body-wrap li .stylish-profile").filter(function () {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });

            $(document).on("keyup", '#myInputReview', function () {
                var value = $(this).val().toLowerCase();
                $(".review-info-body .review-info-items").filter(function () {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });

        function initMap() {
            var mapOptions = {
                zoom: 10,
                center: new google.maps.LatLng(parseFloat(lat), parseFloat(long)),
                mapTypeId: 'roadmap',
                fullscreenControl: false,
                StreetViewControlOptions: false,
                streetViewControl: false,
                streetView: false,

            };
            var map = new google.maps.Map(document.getElementById('map'), mapOptions);

            var goldenGatePosition = {
                lat: parseFloat(lat),
                lng: parseFloat(long)
            };
            var marker = new google.maps.Marker({
                position: goldenGatePosition,
                map: map
            });

        }

        $('#about-banner-owl').owlCarousel({
            loop: true,
            margin: 0,
            nav: true,
            navText: ["<i class='fas fa-chevron-left'></i>", "<i class='fas fa-chevron-right'></i>"],
            dots: true,
            responsive: {
                0: {
                    items: 1
                }
            }
        });
        $(document).ready(function () {
            $('.stylish-body-wrap ul .expert_li').click(function () {
                $('.stylish-body-wrap ul .expert_li').removeClass("active");
                $(this).addClass("active");
            });
            $(".profile-reviews-close").click(function () {
                $('.stylish-body-wrap ul .expert_li').removeClass("active");
            });
        });
        // body class //
        $("body").addClass("footer-show");

        // slider-up-slideDown //
        $(document).ready(function () {
            $(document).on('click', '.flip', function () {
                var id = $(this).data('id');
                $(".sliderr[data-id=" + id + "]").slideToggle("slow");
                $(".sliderr[data-id=" + id + "]").toggleClass("active");
                $(".flip[data-id=" + id + "]").toggleClass("active");
            });


            $(".service-bodyy-ul li").click(function () {
                $('.service-bodyy-ul li').removeClass("active");
                $(this).addClass("active");
            });
            $(".service-item-icon").click(function () {
                $('.service-item-icon').removeClass("active");
                $(this).addClass("active");
            });
            $(".service-sub-item li").click(function () {
                $('.service-sub-item li').removeClass("active");
                $(this).addClass("active");
            });
        });

        $(document).ready(function () {
            $(".venue-replay-link").click(function () {
                $(".venue-replay-info").slideToggle("slow");
                $(".venue-replay-info").toggleClass("active");
                $(".venue-replay-link").toggleClass("active");
            });
            $(document).on('click', '.show-full-ratings-link', function () {
                var id = $(this).data('id');
                $(".show-full-ratings-info[data-id='" + id + "']").slideToggle("slow");
                $(".show-full-ratings-info[data-id='" + id + "']").toggleClass("active");
                $(".show-full-ratings-link[data-id='" + id + "']").toggleClass("active");
            });
        });
        // filter-box //
        $(".filter-box-icon").click(function () {
            $(".filter-box").toggleClass("show");
            $(".area-section").toggleClass("show");
        });
        // filter-box //

        $(document).on('click', '.showDetails', function () {
            var baseurl = '<?php echo e(URL::to('storage/app/public/service/')); ?>';
            // alert('hi');
            var service = $(this).data('service');
            var descri = $(this).data('descri');
            var image = $(this).data('image');
            var rating = $(this).data('rating');
            $('.serviceDesName').text(service);
            $('.serviceDescImage').attr('src', image);
            $('.serviceDesRating').text(rating);
            $('.serviceDesDescription').text(descri);
            getRatingStar(rating);

            $('#service-modal').modal('toggle');
        });

        $(document).on('click', '.subCategoryChange', function () {
            var category = $(this).data('category');
            var subCategory = $(this).data('id');
            var store = '<?php echo e($store['id']); ?>';
            var _token = '<?php echo e(csrf_token()); ?>';
            var url = '<?php echo e(URL::to('get-service-list')); ?>';

            getServiceList(category, subCategory, store, _token, url);
        });

        $(document).ready(function () {
            var store = '<?php echo e($store['id']); ?>';
            var getServiceData = localStorage.getItem('selectedService');
            if ((getServiceData == undefined) || (getServiceData == '')) {
                var SelectedService = [];
            } else {
                var SelectedService = jQuery.parseJSON(getServiceData);
            }

            var vasd = SelectedService.filter(function (service) {
                // console.log(service.store);
                return service.store == store
            });
            if (vasd.length != 0) {

                var totalAmount = 0;
                SelectedService.forEach((num, index) => {
                    totalAmount += Number(num.price);
                    $('.select--btnn[data-variant=' + num.variant + ']').toggleClass("active");
                    $('.select--btnn[data-variant=' + num.variant + ']').text('Ausgewählt');
                });
                $(".noOfPrice").text(totalAmount.toLocaleString('de-DE', {minimumFractionDigits: 2, maximumFractionDigits: 2}));
                $(".noOfService").text(SelectedService.length);
            } else {
                localStorage.removeItem('selectedService');
                $(".noOfPrice").text('0,00');
                $(".noOfService").text(0);
            }

        });

        function getRatingStar(rating) {
            $.ajax({
                type: 'POST',
                async: true,
                dataType: "json",
                url: baseurl + '/get-rating-star',
                data: {
                    _token: token,
                    rating: rating,
                },
                beforesend: $('#loading').css('display', 'block'),
                success: function (response) {
                    var data = response.data;
                    $('.servicerting').html(data);
                    $('#loading').css('display', 'none');
                },
                error: function (e) {

                }
            });
        }

        $(document).on('click', '.profile-reviews-close', function () {
            $('.stylish-body-wrap ul .expert_li').removeClass("active");
        });

        //sub cate
        $('.sub_cate').css('display', 'none');
        $('.main_ser').on('click', function () {
            var id = $(this).data('id');
            var cate = $('input[name=main_cate]:checked').val();

            $('.sub_cate').css('display', 'none');
            $('.sub_cat_' + id).css('display', 'flex');
        });

        $('.clear-filter').on('click', function () {
            $('.service-item-icon').removeClass('active');
            $('.sub_cate').css('display', 'none');
            $("input:radio[name=rating]:checked")[0].checked = false;
            $("input:radio[name=main_cate]:checked")[0].checked = false;
            $("input:radio[name=sub_cate]:checked")[0].checked = false;
            $('input[type=radio]').removeAttr('checked');
            // $('.main-btn').click();

        });

        $('.main-btn').on('click', function () {

            var rate = $('input[name=rating]:checked').val();
            var cate = $('input[name=main_cate]:checked').val();
            var sub_cate = $('input[name=sub_cate]:checked').val();
            var id = "<?php echo e($store['id']); ?>";

            $.ajax({
                type: 'GET',
                url: "<?php echo e(URL::to('get-rates')); ?>",
                data: {rate: rate, cate: cate, sub_cate: sub_cate, id: id},
                success: function (response) {
                    $(".review-info-body").html(response);
                    $("#filterModal").modal('hide');
                },
                error: function (error) {


                }
            });
        });
		var hashed = window.location.hash;
		
		if(hashed){
			$(hashed+' .venue-replay-link').addClass('active');
			$(hashed+' .venue-replay-info').addClass('active');
			$(hashed+' .venue-replay-info').show();
		}
        $(document).on('change', '.review_sorting', function () {
            var value = $(this).val();
            var id = "<?php echo e($store['id']); ?>";

            $.ajax({
                type: 'GET',
                url: "<?php echo e(URL::to('rate-shorting')); ?>",
                data: {type: value, id: id},
                success: function (response) {
                    $(".review-info-body").html(response);
                    $("#filterModal").modal('hide');
                },
                error: function (error) {


                }
            });
        })
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.front', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\projects\laravel\reserved4you_dev\resources\views/Front/Cosmetic/about.blade.php ENDPATH**/ ?>