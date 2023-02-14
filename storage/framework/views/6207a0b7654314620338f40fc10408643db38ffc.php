<?php $__env->startSection('service_title'); ?>
    Add Service
<?php $__env->stopSection(); ?>
<?php $__env->startSection('service_css'); ?>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <style>
        .discountType {
            width: 100%;
            border: 2px solid hsl(216deg 5% 64% / 20%);
            margin-bottom: 20px;
            border-radius: 20px;
            height: 60px;
            padding: 0 15px 0 30px;
            font-size: 17px;
            font-weight: 400;
            line-height: 53px;
        }

        .removeVariant {
            top: 20px;
            right: -10px;
        }
    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('service_content'); ?>
    <div class="main-content">
        <div class="page-title-div">
            <h2 class="page-title">Betriebsprofil</h2>
            <p><a href="<?php echo e(URL::to('dienstleister/betriebsprofil')); ?>">Betriebsprofil</a> <i> / Service hinzufügen</i></p>
        </div>
        <?php echo e(Form::open(array('url'=>'service-provider/add-service','method'=>'post','name'=>'create_service','files'=>'true','id'=>'create_service'))); ?>

        <div class="appointment-header customers-header">
            <h4>Neuen Service hinzufügen</h4>
            <!--<a href="#" class="btn btn-black-yellow">See Preview</a>-->
            <button type="submit" class="btn btn-yellow ml-2">Veröffentlichen</button>
        </div>

        <div class="service-body">
            <div class="store-service">
                <div class="store-main-service">
                    <div class="service-header-wrap">
                        <h5>Kategorien</h5>
                    </div>
                    <ul>
                        <div style="display: none"><?php echo e($i=1); ?></div>
                        <?php $__currentLoopData = $storeCategory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li>
                                <label for="hair-categories<?php echo e($row->id); ?>">
                                    <input type="radio" name="category_id" class="category_select"
                                           value="<?php echo e(@$row['category_id']); ?>"
                                           id="hair-categories<?php echo e($row->id); ?>"
                                           data-id="<?php echo e(@$row['category_id']); ?>" <?php echo e($i == 1 ? 'checked':''); ?>>
                                    <div class="categories-box">
                                        <span><?php echo file_get_contents(URL::to('storage/app/public/category/' . @$row['CategoryData']['image'])) ?></span>
                                        <h6><?php echo e(@$row['CategoryData']['name']); ?></h6>
                                    </div>
                                </label>
                            </li>
                            <div style="display: none"><?php echo e($i++); ?></div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
                <div class="store-sub-categories">
                    <div class="service-header-wrap">
                        <h5>Unterkategorien</h5>
                    </div>
                    <?php echo e(Form::select('subcategory_id',$storeSubCategory,'',array('class'=>'select subcategories'))); ?>

                    <?php $__errorArgs = ['subcategory_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($message); ?></strong>
                                    </span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>
        </div>
        <hr class="store-service-hr">
        <div class="service-body">

            <div class="thumbnail-div mb-30">
                <h6 class="new-service-title">Bilddatei hochladen</h6>
                <div class="col-6">
                    <div class="image-box">
                        <div class="customer-image">

                            <img id="output"
                                 src="<?php echo e(URL::to('storage/app/public/Serviceassets/images/default-profile.jpg')); ?>"/>

                        </div>
                        <label for="imgUpload">
                            <p>Service Bild </p>
                            <input id="imgUpload" type="file" accept="image/*" name="image"
                                   onchange="loadFile(event)">
                            <span class="btn btn-yellow btn-photo">Ändern</span>
                        </label>
                    </div>
                    <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($message); ?></strong>
                                    </span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>
            <div class="mb-30">
                <div class="title-btn-wrap">
                    <h6 class="new-service-title">Hauptservice</h6>
                </div>
                <input type="text" placeholder="Name des Service" class="consumer-input" name="service_name"
                       required>
                <?php $__errorArgs = ['service_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($message); ?></strong>
                                    </span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="mb-30">
                <h6 class="new-service-title">Beschreibung </h6>
                <textarea placeholder="Beschreibung hinzufügen …..." name="description" required
                          class="consumer-input consumer-textarea mb-0"
                          rows="10"></textarea>
                <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($message); ?></strong>
                                    </span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <?php if($store_data['is_discount'] == 'yes'): ?>
            <div class="mb-30">
                <h6 class="new-service-title">Rabatt %</h6>
                <?php echo e(Form::number('discount','',array('class'=>'consumer-input','id'=>'validationCustom03','step' =>0.01, "lang"=>"de", 'placeholder'=>'Rabatt(%)','min'=>0))); ?>

                <?php echo e(Form::hidden('discount_type','percentage')); ?>

            </div>
            <?php endif; ?>
            <ul class="nav nav-pills eprofile-navs eprofile-navs2" id="pills-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active service-tab" id="pills-single-service-tab" data-id="pills-single-service">Einzelner Service</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link service-tab" id="pills-sub-services-tab" data-id="pills-sub-services">Service mit Unterservices</a>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-single-service" role="tabpanel"
                     aria-labelledby="pills-single-service-tab">

                    <div class="add_variant">
                        <div class="single-service">
                            <div class="position-relative  sservice">

                                <?php echo e(Form::hidden('description_variant[]','')); ?>

                                <label for="" style="pointer-events: none!important;">Preis €</label>
                                <?php echo e(Form::number('price_variant[]','',array('class'=>'consumer-input','step' =>0.01, "lang"=>"de", 'placeholder'=>'Preis €','min'=>0.1,'required'))); ?>

                                <label class="d-block" for="" style="pointer-events: none!important;">Dauer (min)</label>
                                <?php echo e(Form::number('duration_of_service_variant[]','',array('class'=>'consumer-input','placeholder'=>'Dauer (min)','min'=>5,'required'))); ?>

                            </div>
                        </div>
                    </div>

                </div>
                <div class="tab-pane fade" id="pills-sub-services" role="tabpanel"
                     aria-labelledby="pills-sub-services-tab" style="display: none;opacity: 1">
                    <h4 class="yellow-title">Unterservices</h4>
                    <div class="add_variant add_sub">
                        <div class="sub-services">

                        </div>
                    </div>
                    <div class="text-right">
                        <a href="javascript:void(0)" class="btn btn-black-yellow add_another">Weiteren Service hinzufügen</a>
                    </div>
                </div>
            </div>


            <?php echo e(Form::close()); ?>


        </div>
        <?php $__env->stopSection(); ?>
        <?php $__env->startSection('service_js'); ?>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
            <script>
                $(document).on('click', '.category_select', function () {
                    var id = $(this).data('id');
                    changeSubCategory(id);
                });
                var loadFile = function (event) {
                    var reader = new FileReader();
                    reader.onload = function () {
                        var output = document.getElementById('output');
                        output.src = reader.result;
                    };
                    reader.readAsDataURL(event.target.files[0]);
                };

                function changeSubCategory(id) {
                    $.ajax({
                        type: 'POST',
                        url: "<?php echo e(URL::to('service-provider/service/category')); ?>",
                        data: {
                            _token: '<?php echo e(csrf_token()); ?>',
                            id: id,
                        },
                        success: function (response) {
                            var html = '<option value="">Unterkategorie wählen</option>';
                            if (response.status == 'true') {
                                $.each(response.data, function (i, row) {
                                    html += '<option value="' + row.id + '">' + row.name + '</option>';
                                });
                            }
                            $('.subcategories').html(html);
                            $('.subcategories').niceSelect('update');
                        },
                        error: function (error) {


                        }
                    });
                }

                $(document).on('click', '.add_another', function () {
                    var html = '<div class="sub-light-dark-bg position-relative">\n' +
                        '                    <label for="" style="pointer-events: none!important;">Name des Unterservice</label><input type="text" name="description_variant[]" class="consumer-input" placeholder="Name des Unterservice" required>\n' +
                        '                    <label for="" style="pointer-events: none!important;">Preis (€)</label><input type="number" name="price_variant[]" step = 0.01 lang="de" class="consumer-input" placeholder="Preis (€)" required min="0.1">\n' +
                        '                    <label for="" style="pointer-events: none!important;">Dauer (min)</label><input type="number" name="duration_of_service_variant[]" class="consumer-input" placeholder="Dauer (min)" required min="5">' +
                        '<span class="remove removeVariant" ></span>\n' +
                        '                 </div>';

                    $('.add_sub').append(html);
                })
                $(document).on('click', '.removeVariant', function () {
                    $(this).closest('.sub-light-dark-bg').remove();
                });

                $('#create_service').validate({ // initialize the plugin
                    rules: {
                        category_id: {
                            required: true,
                        },
                        subcategory_id: {
                            required: true,
                        },
                        service_name: {
                            required: true,
                        },
                        description: {
                            required: true,
                        },
                        discount: {
                            number: true
                        },
						 "price_variant[]": {
                            required: true,
							min:0.1,
							max:999,
                        },
						"duration_of_service_variant[]": {
                            required: true,
							min:5,
                        }
                    },
					messages: {
						category_id: {
							required: "<?php echo e(__('Please select category')); ?>",
						},
						subcategory_id: {
							required: "<?php echo e(__('Please select sub category')); ?>",
						},
						service_name: {
							required: "<?php echo e(__('Please enter main service name')); ?>",
						},
						description: {
							required: "<?php echo e(__('Please enter description')); ?>",
						},
						discount: {
							number: "<?php echo e(__('Please enter description')); ?>",
						},
						"price_variant[]": {
							required: "<?php echo e(__('Please enter Price')); ?>",
							min: "<?php echo e(__('Please enter a value greater than or equal to 1')); ?>",
							max: "<?php echo e(__('Please enter a value less than or equal to 999')); ?>",
						},
						"duration_of_service_variant[]": {
							required: "<?php echo e(__('Please enter duration')); ?>",
							min: "<?php echo e(__('Please enter a value greater than or equal to 5')); ?>",
						},
						
					},
                });

                $(document).on('click', '.service-tab', function () {
                    var id = $(this).data('id');

                    $('.service-tab').removeClass('active');
                    $(this).addClass('active');

                    if (id == 'pills-sub-services') {
                        var html = '<div class="sub-light-dark-bg position-relative  subservice"><label for="" style="pointer-events: none!important;">Name des Unterservice</label><input type="text" name="description_variant[]" class="consumer-input" placeholder="Name des Unterservice" required>\n' +
                            '<label for="" style="pointer-events: none!important;">Preis (€)</label>'+
                            '<input type="number" name="price_variant[]" class="consumer-input" step = 0.01 lang="de" placeholder="Preis (€)" min="0.1" required>\n' +
                            '<label for="" style="pointer-events: none!important;">Dauer (min)</label>'+
                            '<input type="number" name="duration_of_service_variant[]" class="consumer-input" placeholder="Dauer (min)" min="5" required></div>';

                        $('.sub-services').html(html);
                        $('.sservice').remove();
                        $('#pills-sub-services').css('display', 'block');
                        $('#pills-single-service').css('display', 'none');
                    } else {
                        var html = '<div class="position-relative  sservice">' +
                            '<input type="hidden" name="description_variant[]" value="">\n' +
                            '<label for="" style="pointer-events: none!important;">Preis (€)</label>'+
                            '<input type="number" name="price_variant[]" step = 0.01 lang="de" class="consumer-input" placeholder="Preis (€)" min="0.1" required>\n' +
                            '<label for="" style="pointer-events: none!important;">Dauer (min)</label>'+
                            '<input type="number" name="duration_of_service_variant[]" class="consumer-input" placeholder="Dauer (min)" min="5" required></div>';
                        $('.single-service').html(html);
                        $('.subservice').remove();
                        $('#pills-sub-services').css('display', 'none');
                        $('#pills-single-service').css('display', 'block');
                    }
                })

            </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.serviceProvider', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\projects\laravel\reserved4you_dev\resources\views/ServiceProvider/Service/add_service.blade.php ENDPATH**/ ?>