<?php $__env->startSection('service_title'); ?>
    New Appointment
<?php $__env->stopSection(); ?>
<?php $__env->startSection('service_css'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('service_content'); ?>
    <div class="main-content">
        <h2 class="page-title static-page-title">Buchungen</h2>
        <div class="setting-title">
            <h3>Termin hinzufügen</h3>

        </div>
        <div class="service-row row my-appoin">
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
                            <h6><span class="noOfPrice">0</span>€</h6>
                            <p><span class="noOfService">0</span> Service</p>
                        </div>
                        <a href="javascript:void(0)" class="btn main-btn paying-btn btn-yellow">Weiter zur Zahlung</a>
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
                                            <?php if($row->discount_type != null && $row->discount != '0' && $row->discount != ''): ?>
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
                                                Details anzeigen</a>
                                            </div>
                                            <div class="time_price_info">
                                                <?php $__currentLoopData = $row->variants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <h6><?php echo e($item['duration_of_service']); ?> <?php echo e(__('Min')); ?></h6>
                                                    <div class="price-info">
                                                        <?php if($row->discount_type != null && $row->discount != '0' && $row->discount != ''): ?>
                                                            <h5><?php echo e(number_format(\BaseFunction::finalPriceVariant($row->id,$item['id']),2, ',', '.')); ?>

                                                                €
                                                                <span><?php echo e(number_format($item['price'],2, ',', '.')); ?>€</span>
                                                            </h5>
                                                        <?php else: ?>
                                                            <h5><?php echo e($item['price']); ?>€</h5>
                                                        <?php endif; ?>
                                                        <div style="display: none">
                                                            <?php if($row->discount_type != null && $row->discount != '0'): ?>
                                                                <?php $newprice =  \BaseFunction::finalPriceVariant($row->id,$item['id']); ?>
																<?php echo e(number_format( $newprice,2, ',', '.')); ?>

                                                            <?php else: ?>
                                                                <?php $newprice = $item['price']; ?>
															<?php echo e(number_format( $newprice,2, ',', '.')); ?>

                                                            <?php endif; ?>
                                                        </div>
                                                        <a class="select--btnn"
                                                           data-service="<?php echo e($row->id); ?>"
                                                           data-price="<?php echo e($newprice); ?>"
                                                           data-store="<?php echo e($getStore); ?>"
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
                                            <?php if($row->discount_type != null && $row->discount != '0' && $row->discount != ''): ?>
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
                                                Details anzeigen</a>
                                            </div>
                                            <div class="time_price_info">
                                                <h6><?php echo e(min(array_map(function($a) { return $a['duration_of_service']; }, $row->variants))); ?>

                                                    <?php echo e(__('Min')); ?>

                                                    - <?php echo e(max(array_map(function($a) { return $a['duration_of_service']; }, $row->variants))); ?>

                                                    <?php echo e(__('Min')); ?></h6>
                                                <div class="price-info">
                                                    <h5>
                                                        ab <?php echo e(min(array_map(function($a) { return number_format($a['price'],2, ',', '.'); }, $row->variants))); ?>

                                                        €</h5>
                                                </div>
                                            </div>
                                            <div id="sliderr" class="sliderr" data-id="p<?php echo e($row->id); ?>">
                                                <?php $__currentLoopData = $row->variants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <div class="service-media-wrap">
                                                        <div class="service-media-infos">
                                                            <h6><?php echo e($item['description']); ?></h6>
                                                            <p><?php echo e($item['duration_of_service']); ?> <?php echo e(__('Min')); ?></p>
                                                        </div>
                                                        <div class="price-info">
                                                            <?php if($row->discount_type != null && $row->discount != '0' && $row->discount != ''): ?>
                                                                <h5><?php echo e(number_format(\BaseFunction::finalPriceVariant($row->id,$item['id']),2)); ?>

                                                                    € <span><?php echo e(number_format($item['price'],2, ',', '.')); ?>€</span>
                                                                </h5>
                                                            <?php else: ?>
                                                                <h5><?php echo e(number_format($item['price'],2, ',', '.')); ?>€</h5>
                                                            <?php endif; ?>
                                                            <div style="display: none">
                                                                <?php if($row->discount_type != null && $row->discount != '0'): ?>
                                                                    <?php $newprice =  \BaseFunction::finalPriceVariant($row->id,$item['id']); ?>
																	<?php echo e(number_format($newprice, ',', '.')); ?>

                                                                <?php else: ?>
                                                                    <?php $newprice = $item['price']; ?>
																	<?php echo e(number_format($newprice, ',', '.')); ?>

                                                                <?php endif; ?>
                                                            </div>
                                                            <a class="select--btnn"
                                                               data-service="<?php echo e($row->id); ?>"
                                                               data-price="<?php echo e($newprice); ?>"
                                                               data-store="<?php echo e($getStore); ?>"
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
                            Keine Bewertungen verfügbar.
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
                                        <?php if($row->discount_type != null && $row->discount != '0' && $row->discount != ''): ?>
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
                                            Details anzeigen</a>
                                        </div>
                                        <div class="time_price_info">
                                            <?php $__currentLoopData = $row->variants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <h6><?php echo e($item['duration_of_service']); ?> <?php echo e(__('Min')); ?></h6>
                                                <div class="price-info">
                                                    <?php if($row->discount_type != null && $row->discount != '0' && $row->discount != ''): ?>
                                                        <h5><?php echo e(number_format(\BaseFunction::finalPriceVariant($row->id,$item['id']),2, ',', '.')); ?>

                                                            €
                                                            <span><?php echo e(number_format($item['price'],2, ',', '.')); ?>€</span>
                                                        </h5>
                                                    <?php else: ?>
                                                        <h5><?php echo e(number_format($item['price'],2, ',', '.')); ?>€</h5>
                                                    <?php endif; ?>
                                                    <div style="display: none">
                                                        <?php if($row->discount_type != null && $row->discount != '0' && $row->discount != ''): ?>
                                                            <?php $newprice = \BaseFunction::finalPriceVariant($row->id,$item['id']); ?>
															<?php echo e(number_format($newprice,2, ',', '.')); ?>

                                                        <?php else: ?>
                                                            <?php $newprice = $item['price'];  ?>
															<?php echo e(number_format($newprice,2, ',', '.')); ?>

                                                        <?php endif; ?>
                                                    </div>
                                                    <a class="select--btnn"
                                                       data-service="<?php echo e($row->id); ?>"
                                                       data-price="<?php echo e($newprice); ?>"
                                                       data-store="<?php echo e($getStore); ?>"
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
                                        <?php if($row->discount_type != null && $row->discount != '0' && $row->discount != ''): ?>
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
                                            Details anzeigen</a>
                                        </div>
                                        <div class="time_price_info">
                                            <h6><?php echo e(min(array_map(function($a) { return $a['duration_of_service']; }, $row->variants))); ?>

                                                <?php echo e(__('Min')); ?>

                                                - <?php echo e(max(array_map(function($a) { return $a['duration_of_service']; }, $row->variants))); ?>

                                                <?php echo e(__('Min')); ?></h6>
                                            <div class="price-info">
                                                <h5>
                                                    ab <?php echo e(min(array_map(function($a) { return number_format($a['price'], 2, ',', '.'); }, $row->variants))); ?>

                                                    €</h5>
                                            </div>
                                        </div>
                                        <div id="sliderr" class="sliderr" data-id="<?php echo e($row->id); ?>">
                                            <?php $__currentLoopData = $row->variants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="service-media-wrap">
                                                    <div class="service-media-infos">
                                                        <h6><?php echo e($item['description']); ?></h6>
                                                        <p><?php echo e($item['duration_of_service']); ?> <?php echo e(__('Min')); ?></p>
                                                    </div>
                                                    <div class="price-info">
                                                        <?php if($row->discount_type != null && $row->discount != '0' && $row->discount != ''): ?>
                                                            <h5><?php echo e(number_format(\BaseFunction::finalPriceVariant($row->id,$item['id']),2)); ?>

                                                                € <span><?php echo e(number_format($item['price'],2, ',','.')); ?>€</span>
                                                            </h5>
                                                        <?php else: ?>
                                                            <h5><?php echo e(number_format($item['price'],2, ',', '.')); ?>€</h5>
                                                        <?php endif; ?>
                                                        <div style="display: none">
                                                            <?php if($row->discount_type != null && $row->discount != '0'): ?>
                                                                <?php $newprice = \BaseFunction::finalPriceVariant($row->id,$item['id']) ?>
																<?php echo e(number_format($newprice,2, ',', '.')); ?>

                                                            <?php else: ?>
                                                                <?php $newprice = $item['price']; ?>
																<?php echo e(number_format($newprice,2, ',', '.')); ?>

                                                            <?php endif; ?>
                                                        </div>
                                                        <a class="select--btnn"
                                                           data-service="<?php echo e($row->id); ?>"
                                                           data-store="<?php echo e($getStore); ?>"
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
                            Keine Bewertungen verfügbar.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

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

<?php $__env->stopSection(); ?>
<?php $__env->startSection('service_js'); ?>
    <script>
        $(document).ready(function () {
            var baseurls = '<?php echo e(URL::to("/")); ?>';
            localStorage.removeItem('selectedServices')
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
            $(document).on('click', '.select--btnn', function () {
                // $('.select--btnn').removeClass("active");
                var variant = $(this).data('variant');
                var service = $(this).data('service');
				var values = "";
                if($(this).hasClass('active')){
                    //$('.select--btnn[data-service=' + service + ']').text('Select');
                    $('.select--btnn[data-service=' + service + '][data-variant=' + variant + ']').toggleClass("active");
					values = "Selected";	
                } else {
					$('.select--btnn[data-service=' + service + ']').removeClass("active");
                    $('.select--btnn[data-service=' + service + ']').text('Wählen');
                    $('.select--btnn[data-service=' + service + '][data-variant=' + variant + ']').toggleClass("active");  
									
                }

              

                if (values == 'Selected') {
                    $('.select--btnn[data-service=' + service + '][data-variant=' + variant + ']').text('Wählen');

                    var getServiceData = localStorage.getItem('selectedServices');
                    if ((getServiceData == undefined) || (getServiceData == '')) {
                        var SelectedService = [];
                    } else {
                        var SelectedService = jQuery.parseJSON(getServiceData);
                    }

                    SelectedService = SelectedService.filter(function (elem) {
                        return elem.service !== service;
                    });

                    var totalAmount = 0;
                    SelectedService.forEach((num, index) => {
                        totalAmount += Number(num.price);
                    });
                    $(".noOfPrice").text(totalAmount);
                    $(".noOfService").text(SelectedService.length);

                    localStorage.setItem('selectedServices', JSON.stringify(SelectedService));


                } else {
                    $('.select--btnn[data-service=' + service + '][data-variant=' + variant + ']').text('Ausgewählt');

                    var service = $(this).data('service');
                    var category = $(this).data('category');
                    var subcategory = $(this).data('subcategory');
                    var variant = $(this).data('variant');
                    var price = $(this).data('price');
                    var store = $(this).data('store');
                    var SelectedServiceData = {};
                    var getServiceData = localStorage.getItem('selectedServices');
                    if ((getServiceData == undefined) || (getServiceData == '')) {
                        var SelectedService = [];
                    } else {
                        var SelectedService = jQuery.parseJSON(getServiceData);
                    }

                    SelectedService = SelectedService.filter(function (elem) {
                        return elem.service !== service;
                    });

                    SelectedServiceData['service'] = service;
                    SelectedServiceData['category'] = category;
                    SelectedServiceData['subcategory'] = subcategory;
                    SelectedServiceData['variant'] = variant;
                    SelectedServiceData['price'] = price;
                    SelectedServiceData['store'] = store;

                    SelectedService.push(SelectedServiceData);
                    var totalAmount = 0;
                    SelectedService.forEach((num, index) => {
                        totalAmount += Number(num.price);
                    });
                    $(".noOfPrice").text(totalAmount.toFixed(2));
                    $(".noOfService").text(SelectedService.length);
                    localStorage.setItem('selectedServices', JSON.stringify(SelectedService));
                }

            });

            $(document).on('click', '.subCategoryChange', function () {
                var category = $(this).data('category');
                var subCategory = $(this).data('id');
                var store = '<?php echo e($getStore); ?>';
                var _token = '<?php echo e(csrf_token()); ?>';
                var url = '<?php echo e(URL::to('get-service-list')); ?>';

                getServiceList(category, subCategory, store, _token, url);
            });

            function getServiceList(category, subCategory, store, _token, url) {
                $.ajax({
                    type: 'POST',
                    async: true,
                    dataType: "json",
                    url: url,
                    data: {
                        _token: _token,
                        category: category,
                        subCategory: subCategory,
                        store: store,
                    },
                    beforesend: $('#loading').css('display', 'block'),
                    success: function (response) {
                        var status = response.status;
                        var data = response.data;
                        var phtml = '';
                        var html = '';
                        if (status == 'true') {
                            $.each(data, function (index, value) {
                                var discounttype = value.discount_type == "percentage" ? "%" : "€";
                                if (value.is_popular == 'yes') {
                                    if (value.variants.length == 1) {
                                        phtml += '<div class="service-item-main">' +
                                            '<div class="service-item-img"><img src="' + value.image + '" alt="">';
                                        if (value.discount_type != null && value.discount != 0 && value.discount != null ) {
                                            phtml += '<p class="service-discount">' + value.discount + '<span>' + discounttype + ' </span>' +
                                                '</p>';
                                        }
                                        phtml += '</div>' +
                                            '<div class="service-item-info">' +
                                            '<div class="service-info-top">' +
                                            '<h6>' + value.service_name + '</h6>\n' +
                                            '<a href="javascript:void(0)" class="showDetails" data-service="' + value.service_name + '" data-descri="' + value.description + '"' +
                                            'data-image="' + value.image + '" data-rating="' + value.rating + '" >' +
                                            'Details anzeigen</a>' +
                                            '</div>' +
                                            '<div class="time_price_info">';
                                        $.each(value.variants, function (i, rows) {
                                            phtml += '<h6>' + rows.duration_of_service + ' min</h6>\n' +
                                                '<div class="price-info">';
                                            if (value.discount_type != null && value.discount != 0 && value.discount != null) {
                                                phtml += ' <h5>' + rows.finalPrice + '€ <span>' + rows.price + '€</span></h5>';
                                            } else {
                                                phtml += '<h5>' + rows.price + '€</h5>';
                                            }
                                            var newPrice = rows.price;
                                            if (value.discount_type != null && value.discount != 0 && value.discount != null) {
                                                var newPrice = rows.finalPrice;
                                            } else {
                                                var newPrice = rows.price;
                                            }
                                            phtml += '<a class="select--btnn" href="javascript:void(0)"  ' +
                                                'data-service="' + value.id + '"' +
                                                'data-price="' + newPrice + '"' +
                                                'data-store="' + store + '"' +
                                                'data-category="' + value.category_id + '"' +
                                                'data-subcategory="' + value.subcategory_id + '"' +
                                                'data-variant="' + rows.id + '">Wählen</a>' +
                                                '</div>';
                                        });
                                        phtml += '</div>' +
                                            '</div>' +
                                            '</div>';
                                    } else if (value.variants.length > 1) {
                                        phtml += '<div class="service-item-main">' +
                                            '<div class="service-item-img"><img src="' + value.image + '" alt="">';
                                        if (value.discount_type != null && value.discount != 0 && value.discount != null) {
                                            phtml += '<p class="service-discount">' + value.discount + '<span>' + discounttype + ' </span>' +
                                                '</p>';
                                        }
                                        phtml += '</div>' +
                                            '<div class="service-item-info">' +
                                            '<div class="service-info-top">' +
                                            '<h6>' + value.service_name + '' +
                                            '<span id="flip" class="down-arroww flip"' +
                                            'data-id="p' + value.id + '"><i\n' +
                                            'class="far fa-chevron-down"></i></span>' +
                                            '</h6>\n' +
                                            '<a href="javascript:void(0)" class="showDetails" data-service="' + value.service_name + '" data-descri="' + value.description + '"' +
                                            'data-image="' + value.image + '" data-rating="' + value.rating + '" >' +
                                            'Details anzeigen</a>' +
                                            '</div>' +
                                            '<div class="time_price_info">' +
                                            '<h6>' + value.minduration + ' min - ' + value.maxduration + ' min </h6>\n' +
                                            '<div class="price-info">' +
                                            '<h5> ab ' + value.minprice + ' €</h5>\n' +
                                            '</div>' +
                                            '</div>' +
                                            '<div id="sliderr" class="sliderr" data-id="p' + value.id + '">';
                                        $.each(value.variants, function (i, rows) {
                                            phtml += '<div class="service-media-wrap">\n' +
                                                '<div class="service-media-infos">' +
                                                ' <h6>' + rows.description + '</h6>\n' +
                                                '<p>' + rows.duration_of_service + ' min</p>\n' +
                                                '</div>' +
                                                ' <div class="price-info">';
                                            if (value.discount_type != null && value.discount != 0 && value.discount != null) {
                                                phtml += ' <h5>' + rows.finalPrice + '€ <span>' + rows.price + '€</span></h5>';
                                            } else {
                                                phtml += '<h5>' + rows.price + '€</h5>';
                                            }
                                            var newPrice = rows.price;
                                            if (value.discount_type != null && value.discount != 0 && value.discount != null) {
                                                var newPrice = rows.finalPrice;
                                            } else {
                                                var newPrice = rows.price;
                                            }

                                            phtml += '<a class="select--btnn" href="javascript:void(0)"  ' +
                                                'data-service="' + value.id + '"' +
                                                'data-store="' + store + '"' +
                                                'data-price="' + newPrice + '"' +
                                                'data-category="' + value.category_id + '"' +
                                                'data-subcategory="' + value.subcategory_id + '"\n' +
                                                'data-variant="' + rows.id + '">Wählen</a>' +
                                                '</div>' +
                                                '</div>';

                                        });
                                        phtml += '  </div>\n' +
                                            '</div>\n' +
                                            '</div>';

                                    }

                                }

                                if (value.variants.length == 1) {
                                    html += '<div class="service-item-main">' +
                                        '<div class="service-item-img"><img src="' + value.image + '" alt="">';
                                    if (value.discount_type != null && value.discount != 0 && value.discount != null) {
                                        html += '<p class="service-discount">' + value.discount + '<span>' + discounttype + ' </span>' +
                                            '</p>';
                                    }
                                    html += '</div>' +
                                        '<div class="service-item-info">' +
                                        '<div class="service-info-top">' +
                                        '<h6>' + value.service_name + '</h6>\n' +
                                        '<a href="javascript:void(0)" class="showDetails" data-service="' + value.service_name + '" data-descri="' + value.description + '"' +
                                        'data-image="' + value.image + '" data-rating="' + value.rating + '" >' +
                                        'Details anzeigen</a>' +
                                        '</div>' +
                                        '<div class="time_price_info">';
                                    $.each(value.variants, function (i, rows) {
                                        html += '<h6>' + rows.duration_of_service + ' min</h6>\n' +
                                            '<div class="price-info">';
                                        if (value.discount_type != null && value.discount != 0 && value.discount != null) {
                                            html += '<h5>' + rows.finalPrice + '€ <span>' + rows.price + '€</span></h5>';
                                        } else {
                                            html += '<h5>' + rows.price + '€</h5>';
                                        }
                                        var newPrice = rows.price;
                                        if (value.discount_type != null && value.discount != 0 && value.discount != null) {
                                            var newPrice = rows.finalPrice;
                                        } else {
                                            var newPrice = rows.price;
                                        }
                                        html += '<a class="select--btnn" href="javascript:void(0)"  ' +
                                            'data-service="' + value.id + '"' +
                                            'data-store="' + store + '"' +
                                            'data-price="' + newPrice + '"' +
                                            'data-category="' + value.category_id + '"' +
                                            'data-subcategory="' + value.subcategory_id + '"' +
                                            'data-variant="' + rows.id + '">Wählen</a>' +
                                            '</div>';
                                    });
                                    html += '</div>' +
                                        '</div>' +
                                        '</div>';
                                } else if (value.variants.length > 1) {
                                    html += '<div class="service-item-main">' +
                                        '<div class="service-item-img"><img src="' + value.image + '" alt="">';
                                    if (value.discount_type != null && value.discount != 0 && value.discount != null) {
                                        html += '<p class="service-discount">' + value.discount + '<span>' + discounttype + ' </span>' +
                                            '</p>';
                                    }
                                    html += '</div>' +
                                        '<div class="service-item-info">' +
                                        '<div class="service-info-top">' +
                                        '<h6>' + value.service_name +
                                        '<span id="flip" class="down-arroww flip"' +
                                        'data-id="' + value.id + '"><i ' +
                                        'class="far fa-chevron-down"></i></span>' +
                                        '</h6>\n' +
                                        '<a href="javascript:void(0)" class="showDetails" data-service="' + value.service_name + '" data-descri="' + value.description + '"' +
                                        'data-image="' + value.image + '" data-rating="' + value.rating + '" >' +
                                        'Details anzeigen</a>' +
                                        '</div>' +
                                        '<div class="time_price_info">' +
                                        '<h6>' + value.minduration + ' min - ' + value.maxduration + ' min </h6>\n' +
                                        '<div class="price-info">' +
                                        '<h5> ab ' + value.minprice + ' €</h5>\n' +
                                        '</div>' +
                                        '</div>' +
                                        '<div id="sliderr" class="sliderr" data-id="' + value.id + '">';
                                    $.each(value.variants, function (i, rows) {
                                        html += '<div class="service-media-wrap">\n' +
                                            '<div class="service-media-infos">' +
                                            ' <h6>' + rows.description + '</h6>\n' +
                                            '<p>' + rows.duration_of_service + ' min</p>\n' +
                                            '</div>' +
                                            ' <div class="price-info">';
                                        if (value.discount_type != null && value.discount != 0 && value.discount != null) {
                                            html += ' <h5>' + rows.finalPrice + '€ <span>' + rows.price + '€</span></h5>';
                                        } else {
                                            html += '<h5>' + rows.price + '€</h5>';
                                        }
                                        var newPrice = rows.price;
                                        if (value.discount_type != null && value.discount != 0 && value.discount != null) {
                                            var newPrice = rows.finalPrice;
                                        } else {
                                            var newPrice = rows.price;
                                        }

                                        html += '<a class="select--btnn" href="javascript:void(0)"  ' +
                                            'data-service="' + value.id + '"' +
                                            'data-store="' + store + '"' +
                                            'data-price="' + newPrice + '"' +
                                            'data-category="' + value.category_id + '"' +
                                            'data-subcategory="' + value.subcategory_id + '"\n' +
                                            'data-variant="' + rows.id + '">Wählen</a>' +
                                            '</div>' +
                                            '</div>';

                                    });
                                    html += '  </div>\n' +
                                        '</div>\n' +
                                        '</div>';

                                }
                            });

                            $('.popular').html(phtml);
                            $('.allService').html(html);

                            var getServiceData = localStorage.getItem('selectedService');
                            if ((getServiceData == undefined) || (getServiceData == '')) {
                                var SelectedService = [];
                            } else {
                                var SelectedService = jQuery.parseJSON(getServiceData);
                            }

                            SelectedService.forEach((num, index) => {
                                $('.select--btnn[data-variant=' + num.variant + ']').toggleClass("active");
                                $('.select--btnn[data-variant=' + num.variant + ']').text('Ausgewählt');
                            });

                        } else {
                            phtml += ' <div class="text-center">\n' +
                                'No service Found.\n' +
                                '</div>';
                            html += ' <div class="text-center">\n' +
                                'No service Found.\n' +
                                '</div>';
                            $('.popular').html(phtml);
                            $('.allService').html(html);


                        }
                        $('#loading').css('display', 'none');
                    },
                    error: function (e) {

                    }
                });
            }

            $(document).on('click', '.paying-btn', function () {
                var getServiceData = localStorage.getItem('selectedServices');

                if ((getServiceData == undefined) || (getServiceData == '')) {
                    var SelectedService = [];
                } else {
                    var SelectedService = jQuery.parseJSON(getServiceData);
                }

                if (SelectedService.length != 0) {
                    $.ajax({
                        type: 'POST',
                        async: true,
                        dataType: "json",
                        url: baseurl + '/checkout',
                        data: {
                            _token: '<?php echo e(csrf_token()); ?>',
                            servicelist: SelectedService
                        },
                        beforesend: $('#loading').css('display', 'block'),
                        success: function (response) {
                            var status = response.status;
							$('#loading').css('display', 'none');
                            if (status == 'true') {
                                window.location.href = baseurl + '/checkout-data';
                            } else {

                            }
                        },
                        error: function (e) {

                        }
                    });

                }

            });

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
              function getRatingStar(rating) {
                    $.ajax({
                        type: 'POST',
                        async: true,
                        dataType: "json",
                        url: baseurls + '/get-rating-star',
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


        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.serviceProvider', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/ServiceProvider/Appointment/Create/index.blade.php ENDPATH**/ ?>