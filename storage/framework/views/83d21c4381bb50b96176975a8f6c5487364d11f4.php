<?php $__env->startSection('service_title'); ?>
    Store Profile
<?php $__env->stopSection(); ?>
<?php $__env->startSection('service_css'); ?>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <style>
        .note-editor.note-frame.panel.panel-default {
            border: 2px solid rgba(159, 163, 169, 0.15) !important;
            border-radius: 15px;
            overflow: hidden;
            margin-bottom: 30px;
        }
		#pills-services .nice-select{width:auto !important; padding: 0 30px 0 18px !important;}
		.review_sorting.nice-select{width:200px !important;}
    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('service_content'); ?>

    <div class="main-content">
        <div class="page-title-div">
            <h2 class="page-title">Betriebsprofil</h2>
        </div>
        <div class="store-profile-width store-profile-index">
            <div class="upload-banner-img">
                <h3 class="store-edit-title">Ihr Betriebsprofil Banner
                </h3>
                <div class="main-store-profile">
                    <?php if(file_exists(storage_path('app/public/store/banner/'.$data->store_banner)) && $data->store_banner != ''): ?>
                        <img id="outputbanner"
                             src="<?php echo e(URL::to('storage/app/public/store/banner/'.$data->store_banner)); ?>"/>
                    <?php else: ?>
                        <img id="outputbanner"
                             src="<?php echo e(URL::to('storage/app/public/Serviceassets/images/store-slider.jpg')); ?>"
                             alt="">
                    <?php endif; ?>

                </div>

            </div>
            <div class="store-basic-details">
                <h3 class="store-edit-title">Betriebsinformationen</h3>
                <?php echo e(Form::open(array('url'=>'service-provider/update-store','method'=>'post','id'=>'store_basic_details','name'=>'store_basic_details','files'=>'true'))); ?>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="image-box">
                            <div class="customer-image">
                                <?php if(file_exists(storage_path('app/public/store/'.$data->store_profile)) && $data->store_profile != ''): ?>
                                    <img id="output"
                                         src="<?php echo e(URL::to('storage/app/public/store/'.$data->store_profile)); ?>"/>
                                <?php else: ?>
                                    <img id="output"
                                         src="<?php echo e(URL::to('storage/app/public/Serviceassets/images/default-profile.jpg')); ?>"/>
                                <?php endif; ?>
                            </div>
                            <label for="imgUpload">
                                <p>Betriebsprofilbild</p>
                                <input id="imgUpload" type="file" accept="image/*" name="store_profile"
                                       onchange="loadFile(event)">
                                <span class="btn btn-yellow btn-photo">Ändern</span>
                                
                            </label>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="image-box">
                            <div class="customer-image">
                                <?php if(file_exists(storage_path('app/public/store/banner/'.$data->store_banner)) && $data->store_banner != ''): ?>
                                    <img id="output1"
                                         src="<?php echo e(URL::to('storage/app/public/store/banner/'.$data->store_banner)); ?>"/>
                                <?php else: ?>
                                    <img id="output1"
                                         src="<?php echo e(URL::to('storage/app/public/Serviceassets/images/default-profile.jpg')); ?>"/>
                                <?php endif; ?>
                            </div>
                            <label for="imgUpload1">
                                <p>Betriebsprofil Banner</p>
                                <input id="imgUpload1" type="file" accept="image/*" name="store_banner"
                                       onchange="loadFileBanner(event)">
                                <span class="btn btn-yellow btn-photo">Ändern</span>
                                
                            </label>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <?php echo e(Form::text('store_name',$data['store_name'],array('class'=>'consumer-input','placeholder'=>'Store Name','required'))); ?>

                    </div>
                    <div class="col-lg-6">
                        <?php echo e(Form::text('store_address',$data['store_address'],array('class'=>'consumer-input','placeholder'=>'Store Address','id'=>'autocomplete','required'))); ?>

                        <?php echo e(Form::hidden('latitude',$data['latitude'],array('id'=>'latitude'))); ?>

                        <?php echo e(Form::hidden('longitude',$data['longitude'],array('id'=>'longitude'))); ?>

                    </div>
                    <div class="col-lg-6">
                        <?php echo e(Form::text('store_link_id',$data['store_link_id'],array('class'=>'consumer-input','placeholder'=>'Store website link'))); ?>

                    </div>
                    <div class="col-lg-6">
                        <?php echo e(Form::text('store_district',$data['store_district'],array('class'=>'consumer-input','placeholder'=>'Store District','required'))); ?>

                    </div>
                    <div class="col-lg-6">
                        <?php echo e(Form::text('store_contact_number',$data['store_contact_number'],array('class'=>'consumer-input','placeholder'=>'Store Contact Number','required'))); ?>

                    </div>
                    <div class="col-lg-6">
                        <?php echo e(Form::text('zipcode',$data['zipcode'],array('class'=>'consumer-input zipcodes','placeholder'=>'Area zip code','required'))); ?>

                    </div>
                </div>
                <div class="button-wrap">
                    <button type="submit" class="btn btn-black-yellow">Profilinformationen speichern</button>
                </div>
                <?php echo e(Form::close()); ?>

            </div>
            <ul class="nav nav-pills eprofile-navs" id="pills-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link <?php echo e((!empty($_GET['t']) && $_GET['t'] == 'reviews')?'':'active'); ?>" id="pills-about-tab" data-toggle="pill" href="#pills-about" role="tab"
                       aria-controls="pills-about" aria-selected="<?php echo e((!empty($_GET['t']) && $_GET['t'] == 'reviews')?false:true); ?>">Allgemein</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-services-tab" data-toggle="pill" href="#pills-services" role="tab"
                       aria-controls="pills-services" aria-selected="false">Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-portfolio-tab" data-toggle="pill" href="#pills-portfolio" role="tab"
                       aria-controls="pills-portfolio" aria-selected="false">Portfolio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo e((!empty($_GET['t']) && $_GET['t'] == 'reviews')?'active':''); ?>" id="pills-reviews-tab" data-toggle="pill" href="#pills-reviews" role="tab"
                       aria-controls="pills-reviews" aria-selected="<?php echo e((!empty($_GET['t']) && $_GET['t'] == 'reviews')?true:false); ?>">Bewertungen </a>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade <?php echo e((!empty($_GET['t']) && $_GET['t'] == 'reviews')?'':'show active'); ?>" id="pills-about" role="tabpanel"
                     aria-labelledby="pills-about-tab">
                    <?php echo e(Form::open(array('url'=>'service-provider/update-other-details','method'=>'post','id'=>'store_other_details','name'=>'store_other_details','files'=>'true'))); ?>

                    <div class="store-about">
                        <h4>Beschreibung</h4>
                        <div class="store-discription">
                            <textarea rows="10" name="store_description" placeholder="Write discription here..."
                                      class="mb-5" id="summernote"><?php echo e($data['store_description']); ?></textarea>
                        </div>
                        <div class="edit-basic-detail edit-languages-detail">
                            <h4>Eigenschaften <span> (Mehrfachauswahl)</span></h4>
                            <div class="select-arrows">
                                <?php echo e(Form::select('features[]',$features,$storeFeatures,array('class'=>'select2','multiple'=>'multiple'))); ?>

                                <i class="fas fa-angle-down"></i>
                            </div>
                        </div>
                        <div class="edit-basic-detail advantage-detail">

                            <div class="service-header-wrap">
                                <h4 class="mb-0">Vorteile</h4>
                                <a href="#" data-toggle="modal" data-target="#createNowModal"
                                   class="btn btn-black-yellow">Hinzufügen</a>
                            </div>
                            <ul class="advantage-ul-store">
                                <?php $__currentLoopData = $storeAdvantages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li>
                                    <span><img
                                            src="<?php echo e(URL::to('storage/app/public/store/advantage/'.$row->image)); ?>"
                                            alt=""></span>
                                        <h6><?php echo e($row->title); ?></h6>
                                        <p><?php echo e($row->description); ?></p>
                                        <a href="javascript:void(0)" class="remove_advantages"
                                           data-id="<?php echo e($row->id); ?>"><img
                                                src="<?php echo e(URL::to('storage/app/public/Serviceassets/images/icon/close-3.svg')); ?>"
                                                alt=""></a>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                        <div class="edit-basic-detail edit-transportation-detail">
                            <div class="service-header-wrap">
                                <h4 class="mb-0">Öffentliche Verkehrsanbindungen <span> (Nächste Haltestelle)</span></h4>
                                <a href="#" data-toggle="modal" data-target="#storeTransportation"
                                   class="btn btn-black-yellow">Hinzufügen</a>
                            </div>
                            <ul class="advantage-ul-store">
                                <?php $__currentLoopData = $storePublicTransport; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li>
                                        
                                        
                                        
                                        <h6><?php echo e($row->title); ?></h6>
                                        <p><?php echo e($row->transportation_no); ?></p>
                                        <a href="javascript:void(0)" class="remove_transporation"
                                           data-id="<?php echo e($row->id); ?>"><img
                                                src="<?php echo e(URL::to('storage/app/public/Serviceassets/images/icon/close-3.svg')); ?>"
                                                alt=""></a>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                        <div class="edit-basic-detail-main">
                            <div class="edit-basic-detail mb-0">
                                <div class="store-date-head-wrap">
                                    <h4>Öffnungszeiten</h4>
                                    <!-- <div class="datepiker-arrow">
                                        <input type="text" class="datepicker" value="15. September 2021">
                                        <i class="fas fa-chevron-down"></i>
                                    </div>
                                    <a href="#" class="btn btn-black btn-today">Heute</a> -->
                                </div>
                                <div class="hours-tabel-main">
                                    <div class="hours-tabel-head-wrap">
                                        <h6>Tag</h6>
                                        <h6>Zeiten</h6>
                                        <h6>Geschlossen</h6>
                                    </div>
                                    <div class="hours-tabel-body-wrap  <?php if(\Carbon\Carbon::now()->format('l') == @$store_time[0]['day']): ?> active <?php endif; ?>">
                                        <p>Montag</p>
                                        <div class="hours-time-wrap">
                                            <?php echo e(Form::hidden('day[]','Monday')); ?>

                                            <span>Von</span>
                                            <input type="text" class="timepicker start_time" name="start_time[]"
                                                   placeholder=" -- --" value="<?php echo e(@$store_time[0]['start_time']); ?>"
                                                   <?php echo e(@$store_time[0]['is_off'] == 'on' ? 'readonly'  :''); ?> <?php echo e(@$store_time[0]['is_off'] == 'on' ? 'style=pointer-events:none !important'  :''); ?>

                                                   data-id="Monday">
                                            <span>Bis</span>
                                            <input type="text" class="timepicker end_time" name="end_time[]"
                                                   placeholder=" -- --" value="<?php echo e(@$store_time[0]['end_time']); ?>"
                                                   <?php echo e(@$store_time[0]['is_off'] == 'on' ? 'readonly'  :''); ?> <?php echo e(@$store_time[0]['is_off'] == 'on' ? 'style=pointer-events:none !important'  :''); ?>

                                                   data-id="Monday">
                                        </div>
                                        <?php if(\Carbon\Carbon::now()->format('l') == @$store_time[0]['day']): ?>
                                            <i class="present-label">Jetzt</i>
                                        <?php endif; ?>
                                        <label for="monday-check">
                                            <input type="checkbox" name="weekDays[]" data-id="Monday" class="weekdays"
                                                   id="monday-check" <?php echo e(@$store_time[0]['is_off'] == 'on' ? 'checked'  :''); ?>>
                                            <span><i class="fas fa-check"></i></span>
                                        </label>
                                    </div>
                                    <div class="hours-tabel-body-wrap  <?php if(\Carbon\Carbon::now()->format('l') == @$store_time[1]['day']): ?> active <?php endif; ?>">
                                        <p>Dienstag</p>
                                        <div class="hours-time-wrap">
                                            <?php echo e(Form::hidden('day[]','Tuesday')); ?>

                                            <span>Von</span>
                                            <input type="text" class="timepicker start_time" name="start_time[]"
                                                   placeholder=" -- --" value="<?php echo e(@$store_time[1]['start_time']); ?>"
                                                   <?php echo e(@$store_time[1]['is_off'] == 'on' ? 'readonly'  :''); ?> <?php echo e(@$store_time[1]['is_off'] == 'on' ? 'style=pointer-events:none !important'  :''); ?>

                                                   data-id="Tuesday">
                                            <span>Bis</span>
                                            <input type="text" class="timepicker end_time" name="end_time[]"
                                                   placeholder=" -- --" value="<?php echo e(@$store_time[1]['end_time']); ?>"
                                                   <?php echo e(@$store_time[1]['is_off'] == 'on' ? 'readonly'  :''); ?> <?php echo e(@$store_time[1]['is_off'] == 'on' ? 'style=pointer-events:none !important'  :''); ?>

                                                   data-id="Tuesday">
                                        </div>
                                        <?php if(\Carbon\Carbon::now()->format('l') == @$store_time[1]['day']): ?>
                                            <i class="present-label">Jetzt</i>
                                        <?php endif; ?>
                                        <label for="tuesday-check">
                                            <input type="checkbox" name="weekDays[]" data-id="Tuesday" class="weekdays"
                                                   id="tuesday-check" <?php echo e(@$store_time[1]['is_off'] == 'on' ? 'checked'  :''); ?>>
                                            <span><i class="fas fa-check"></i></span>
                                        </label>
                                    </div>
                                    <div class="hours-tabel-body-wrap  <?php if(\Carbon\Carbon::now()->format('l') == @$store_time[2]['day']): ?> active <?php endif; ?>">
                                        <p>Mittwoch</p>
                                        <div class="hours-time-wrap">
                                            <?php echo e(Form::hidden('day[]','Wednesday')); ?>

                                            <span>Von</span>
                                            <input type="text" class="timepicker start_time" name="start_time[]"
                                                   placeholder=" -- --" value="<?php echo e(@$store_time[2]['start_time']); ?>"
                                                   <?php echo e(@$store_time[2]['is_off'] == 'on' ? 'readonly'  :''); ?> <?php echo e(@$store_time[2]['is_off'] == 'on' ? 'style=pointer-events:none !important'  :''); ?>

                                                   data-id="Wednesday">
                                            <span>Bis</span>
                                            <input type="text" class="timepicker end_time" name="end_time[]"
                                                   placeholder=" -- --" value="<?php echo e(@$store_time[2]['end_time']); ?>"
                                                   <?php echo e(@$store_time[2]['is_off'] == 'on' ? 'readonly'  :''); ?> <?php echo e(@$store_time[2]['is_off'] == 'on' ? 'style=pointer-events:none !important'  :''); ?>

                                                   data-id="Wednesday">
                                        </div>
                                        <?php if(\Carbon\Carbon::now()->format('l') == @$store_time[2]['day']): ?>
                                            <i class="present-label">Jetzt</i>
                                        <?php endif; ?>
                                        <label for="wednesday-check">
                                            <input type="checkbox" name="weekDays[]" id="wednesday-check"
                                                   class="weekdays"
                                                   data-id="Wednesday" <?php echo e(@$store_time[2]['is_off'] == 'on' ? 'checked'  :''); ?>>
                                            <span><i class="fas fa-check"></i></span>
                                        </label>
                                    </div>
                                    <div class="hours-tabel-body-wrap  <?php if(\Carbon\Carbon::now()->format('l') == @$store_time[3]['day']): ?> active <?php endif; ?>">
                                        <p>Donnerstag</p>
                                        <div class="hours-time-wrap">
                                            <?php echo e(Form::hidden('day[]','Thursday')); ?>

                                            <span>Von</span>
                                            <input type="text" class="timepicker start_time" name="start_time[]"
                                                   placeholder=" -- --" value="<?php echo e(@$store_time[3]['start_time']); ?>"
                                                   <?php echo e(@$store_time[3]['is_off'] == 'on' ? 'readonly'  :''); ?> <?php echo e(@$store_time[3]['is_off'] == 'on' ? 'style=pointer-events:none !important'  :''); ?>

                                                   data-id="Thursday">
                                            <span>Bis</span>
                                            <input type="text" class="timepicker end_time" name="end_time[]"
                                                   placeholder=" -- --" value="<?php echo e(@$store_time[3]['end_time']); ?>"
                                                   <?php echo e(@$store_time[3]['is_off'] == 'on' ? 'readonly'  :''); ?> <?php echo e(@$store_time[3]['is_off'] == 'on' ? 'style=pointer-events:none !important'  :''); ?>

                                                   data-id="Thursday">
                                        </div>
                                        <?php if(\Carbon\Carbon::now()->format('l') == @$store_time[3]['day']): ?>
                                            <i class="present-label">Jetzt</i>
                                        <?php endif; ?>
                                        <label for="thursday-check">
                                            <input type="checkbox" name="weekDays[]" id="thursday-check"
                                                   class="weekdays"
                                                   data-id="Thursday" <?php echo e(@$store_time[3]['is_off'] == 'on' ? 'checked'  :''); ?>>
                                            <span><i class="fas fa-check"></i></span>
                                        </label>
                                    </div>
                                    <div class="hours-tabel-body-wrap   <?php if(\Carbon\Carbon::now()->format('l') == @$store_time[4]['day']): ?> active <?php endif; ?>">
                                        <p>Freitag</p>
                                        <div class="hours-time-wrap">
                                            <?php echo e(Form::hidden('day[]','Friday')); ?>

                                            <span>Von</span>
                                            <input type="text" class="timepicker start_time" name="start_time[]"
                                                   placeholder=" -- --" value="<?php echo e(@$store_time[4]['start_time']); ?>"
                                                   <?php echo e(@$store_time[4]['is_off'] == 'on' ? 'readonly'  :''); ?> <?php echo e(@$store_time[4]['is_off'] == 'on' ? 'style=pointer-events:none !important'  :''); ?>

                                                   data-id="Friday">
                                            <span>Bis</span>
                                            <input type="text" class="timepicker end_time" name="end_time[]"
                                                   value="<?php echo e(@$store_time[4]['end_time']); ?>"
                                                   <?php echo e(@$store_time[4]['is_off'] == 'on' ? 'readonly'  :''); ?> <?php echo e(@$store_time[4]['is_off'] == 'on' ? 'style=pointer-events:none !important'  :''); ?>

                                                   placeholder=" -- --" data-id="Friday">
                                        </div>
                                        <?php if(\Carbon\Carbon::now()->format('l') == @$store_time[4]['day']): ?>
                                            <i class="present-label">Jetzt</i>
                                        <?php endif; ?>
                                        <label for="friday-check">
                                            <input type="checkbox" name="weekDays[]" id="friday-check" class="weekdays"
                                                   data-id="Friday" <?php echo e(@$store_time[4]['is_off'] == 'on' ? 'checked'  :''); ?>>
                                            <span><i class="fas fa-check"></i></span>
                                        </label>
                                    </div>
                                    <div class="hours-tabel-body-wrap  <?php if(\Carbon\Carbon::now()->format('l') == @$store_time[5]['day']): ?> active <?php endif; ?>">
                                        <p>Samstag</p>
                                        <div class="hours-time-wrap">
                                            <?php echo e(Form::hidden('day[]','Saturday')); ?>

                                            <span>Von</span>
                                            <input type="text" class="timepicker start_time" name="start_time[]"
                                                   placeholder=" -- --" value="<?php echo e(@$store_time[5]['start_time']); ?>"
                                                   <?php echo e(@$store_time[5]['is_off'] == 'on' ? 'readonly'  :''); ?> <?php echo e(@$store_time[5]['is_off'] == 'on' ? 'style=pointer-events:none !important'  :''); ?>

                                                   data-id="Saturday">
                                            <span>Bis</span>
                                            <input type="text" class="timepicker end_time" name="end_time[]"
                                                   placeholder=" -- --" value="<?php echo e(@$store_time[5]['end_time']); ?>"
                                                   <?php echo e(@$store_time[5]['is_off'] == 'on' ? 'readonly'  :''); ?> <?php echo e(@$store_time[5]['is_off'] == 'on' ? 'style=pointer-events:none !important'  :''); ?>

                                                   data-id="Saturday">
                                        </div>
                                        <?php if(\Carbon\Carbon::now()->format('l') == @$store_time[5]['day']): ?>
                                            <i class="present-label">Jetzt</i>
                                        <?php endif; ?>
                                        <label for="saturday-check">
                                            <input type="checkbox" name="weekDays[]" data-id="Saturday" class="weekdays"
                                                   id="saturday-check" <?php echo e(@$store_time[5]['is_off'] == 'on' ? 'checked'  :''); ?>>
                                            <span><i class="fas fa-check"></i></span>
                                        </label>
                                    </div>
                                    <div class="hours-tabel-body-wrap  <?php if(\Carbon\Carbon::now()->format('l') == @$store_time[6]['day']): ?> active <?php endif; ?>">
                                        <p>Sonntag</p>
                                        <div class="hours-time-wrap">
                                            <?php echo e(Form::hidden('day[]','Sunday')); ?>

                                            <span>Von</span>
                                            <input type="text" class="timepicker start_time" name="start_time[]"
                                                   placeholder=" -- --" value="<?php echo e(@$store_time[6]['start_time']); ?>"
                                                   <?php echo e(@$store_time[6]['is_off'] == 'on' ? 'readonly'  :''); ?> <?php echo e(@$store_time[6]['is_off'] == 'on' ? 'style=pointer-events:none !important'  :''); ?>

                                                   data-id="Sunday">
                                            <span>Bis</span>
                                            <input type="text" class="timepicker end_time" name="end_time[]"
                                                   placeholder=" -- --" value="<?php echo e(@$store_time[6]['end_time']); ?>"
                                                   <?php echo e(@$store_time[6]['is_off'] == 'on' ? 'readonly'  :''); ?> <?php echo e(@$store_time[6]['is_off'] == 'on' ? 'style=pointer-events:none !important'  :''); ?>

                                                   data-id="Sunday">
                                        </div>
                                        <?php if(\Carbon\Carbon::now()->format('l') == @$store_time[6]['day']): ?>
                                            <i class="present-label">Jetzt</i>
                                        <?php endif; ?>
                                        <label for="sunday-check">
                                            <input type="checkbox" name="weekDays[]" id="sunday-check" class="weekdays"
                                                   data-id="Sunday" <?php echo e(@$store_time[6]['is_off'] == 'on' ? 'checked'  :''); ?>>
                                            <span><i class="fas fa-check"></i></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="button-wrap">
                        <button type="submit" class="btn btn-black-yellow">Speichern</button>
                        <a href="<?php echo e(URL::to('service-provider/store-profile/view/'.$data->id)); ?>"
                           class="btn btn-border-black">Profil Vorschau</a>
                    </div>
                    <?php echo e(Form::close()); ?>

                </div>
                <div class="tab-pane fade" id="pills-services" role="tabpanel" aria-labelledby="pills-services-tab">

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
                                            <input type="radio" name="categories-label" class="category_select"
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
                            <?php echo e(Form::select('subcategory',@$storeSubCategorys,@$storeSubCategory[0]['id'],array('class'=>'select subcategories'))); ?>

                        </div>
                    </div>

                    <hr class="store-service-hr">

                    <div class="store-service">
                        <div class="store-main-service">
                            <div class="service-header-wrap">
                                <h5>Services</h5>
                                <div>
                                    <a href="<?php echo e(URL::to('service-provider/add-service')); ?>" class="btn btn-black-yellow">Service hinzufügen</a>
                                </div>
                            </div>
                            <div class="servicedata">
                                <?php $__empty_1 = true; $__currentLoopData = $service; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <?php if(count($row->variants)==1): ?>
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
                                                                <h5><?php echo e(number_format(\BaseFunction::finalPriceVariant($row->id,$item['id']),2,',','.')); ?>

                                                                    €
                                                                    <span><?php echo e(number_format($item['price'],2,',','.')); ?>€</span>
                                                                </h5>
                                                            <?php else: ?>
                                                                <h5><?php echo e(number_format($item['price'],2,',','.')); ?>€</h5>
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
                                                                    <h5><?php echo e(number_format(\BaseFunction::finalPriceVariant($row->id,$item['id']),2,',','.')); ?>

                                                                        €
                                                                        <span><?php echo e(number_format($item['price'],2, ',', '.')); ?>€</span>
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
                                    Keine Bewertungen verfügbar.
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="tab-pane fade" id="pills-portfolio" role="tabpanel" aria-labelledby="pills-portfolio-tab">

                    <div class="store-service">
                        <?php echo e(Form::open(array('url'=>'service-provider/update-store-gallery','name'=>'store_gallery','id'=>'store_gallery' ,'files'=>'true','method'=>'post'))); ?>

                        <div class="field">
                            <input type="file" id="files" class="store_profile" name="store_gallery[]" multiple/>
                            <?php $__currentLoopData = $storeGallery; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <span class="pip" data-id="<?php echo e($row['id']); ?>">
                                    <img class="imageThumb"
                                         src="<?php echo e(URL::to('storage/app/public/store/gallery/'.$row['file'])); ?>"
                                         title="undefined"><br>
                                    <span class="remove remove_image delete-link"  data-id="<?php echo e($row['id']); ?>">

                                </span>
                            </span>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <div class="files-upload-box">
                                <img src="<?php echo e(URL::to('storage/app/public/Serviceassets/images/icon/pulse.svg')); ?>" alt="">
                                <h6>Neues Bild hinzufügen</h6>
                            </div>
                        </div>
                        <?php echo e(Form::close()); ?>

                    </div>

                </div>
                <div class="tab-pane fade <?php echo e((!empty($_GET['t']) && $_GET['t'] == 'reviews')?'show active':''); ?>" id="pills-reviews" role="tabpanel" aria-labelledby="pills-reviews-tab">

                    <div class="review-main-box">
                        <div class="review-left-box">
                            <h6><?php echo e($data['rating']); ?><span>/5.0</span></h6>
                            <ul class="rating-ul">
                                <?php echo \BaseFunction::getRatingStar($data['rating']); ?>

                            </ul>
                            <p>(<?php echo e(count($feedback)); ?>) Bewertungen</p>
                        </div>
                        <div class="review-right-box">
                            <ul>
                                <li>
                                    <h6><?php echo e(number_format($rating['service_rate'],1)); ?>/5.0</h6>
                                    <p>Service & Mitarbeiter</p>
                                </li>
                                <li>
                                    <h6><?php echo e(number_format($rating['wartezeit'],1)); ?>/5.0</h6>
                                    <p>Wartezeit </p>
                                </li>
                                <li>
                                    <h6><?php echo e(number_format($rating['ambiente'],1)); ?>/5.0</h6>
                                    <p>Ambiente</p>
                                </li>
                                <li>
                                    <h6><?php echo e(number_format($rating['atmosphare'],1)); ?>/5.0</h6>
                                    <p>Atmosphäre</p>
                                </li>
                                <li>
                                    <h6><?php echo e(number_format($rating['preie_leistungs_rate'],1)); ?>/5.0</h6>
                                    <p>Preis-Leistung</p>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="review-body-header w-100">
                        <h5>Kundenbewertungen</h5>
                        <div class="review-header-right">
                            <label>Sortieren </label>
                            <select class="select review_sorting">
                                <option value="" style="padding-left:10px;">Sortieren </option>
                                <option value="newest" style="padding-left:10px;">Neueste</option>
                                <option value="best_rated" style="padding-left:10px;">Beste Bewertung</option>
                                <option value="worst_rated" style="padding-left:10px;">Schlechteste Bewertung</option>
                            </select>
                            <!-- <a href="#" class="btn btn-black">Filter</a> -->
                        </div>
                    </div>
                    <div class="review-info-body">
                        <?php $__empty_1 = true; $__currentLoopData = $feedback; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="review-info-items" id="t<?php echo e($row->id); ?>">
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
                                            <p>Service von <span><?php echo e(@$row->empDetails->emp_name); ?></span></p>
                                        </div>
                                    </div>
                                    <?php if($row->category_id != '' || $row->service_id != ''): ?>
                                        <p class="review-info-tag-box"><?php echo e(@$row->categoryDetails->name); ?>

                                            -
                                            <?php echo e(@$row->serviceDetails->service_name); ?></p>
                                    <?php endif; ?>
                                    <div class="review-info-timeline">
                                        <p class="review-box"><span><i
                                                    class="fas fa-star"></i></span> <?php echo e(number_format($row->total_avg_rating, 1)); ?></p>
                                        <h5><?php echo e(\Carbon\Carbon::parse($row->created_at)->diffForHumans()); ?></h5>
                                    </div>
                                </div>
                                <p class="review-information">
                                    <?php echo $row->write_comment; ?></p>
                                <a href="javascript:void(0)" class="venue-replay-link active">Antwort <i
                                        class="far fa-chevron-down"></i></a>
                                <?php if(!empty($row->store_replay)): ?>
                                    <div class="venue-replay-info active" style="display: block;">
                                        <p><i class="far fa-undo-alt"></i> <?php echo $row->store_replay; ?></p>
                                        <a href="javascript:void(0)" class="btn btn-black-yellow btn-edit-review edit_review" data-id="<?php echo e($row->id); ?>">Antwort bearbeiten</a>
                                    </div>
                                <?php else: ?>
                                    <a href="javascript:void(0)" class="btn btn-yellow btn-edit-review mb-3 give_review"
                                       data-id="<?php echo e($row->id); ?>">Antworten</a>
                                <?php endif; ?>
                                <a href="javascript:void(0)" class="show-full-ratings-link" data-id="<?php echo e($row->id); ?>">Mehr anzeigen<i
                                        class="far fa-chevron-down"></i></a>
                                <div class="show-full-ratings-info" data-id="<?php echo e($row->id); ?>" style="display: none;">
                                    <div class="row">
                                        <div class="col col-sm-6 col-md-4">
                                            <div class="ratings-items-box">
                                                <ul class="rating-ul">
                                                    <?php echo \BaseFunction::getRatingStar($row['service_rate']); ?>

                                                </ul>
                                                <p>Service &amp; Mitarbeiter</p>
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
                                                <p>Preis- Leistung</p>
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

    <!-- createNowModal -->
    <div class="modal fade" id="createNowModal" tabindex="-1" role="dialog" aria-labelledby="GiveReviewTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <?php echo e(Form::open(array('url'=>'service-provider/add-advantages','method'=>'post','name'=>'add_advantages','id'=>'add_advantages','files'=>'true'))); ?>

                <div class="store-modal-body">
                    <h5>Store Vorteil erstellen</h5>
                    <div class="advantages-form">
                        <label>Bezeichnung </label>
                        <?php echo e(Form::text('title','',array('class'=>'consumer-input','placeholder'=>'Bezeichnung ','required'))); ?>

                    </div>
                    <div class="advantages-form">
                        <label>Beschreibung</label>
                        <?php echo e(Form::textarea('description','',array('class'=>'consumer-input consumer-textarea','placeholder'=>'Beschreibung','required','rows'=>3))); ?>

                    </div>
                    <div class="advantages-form">
                        <label>Bild  (SVG only)</label>
                        <?php echo e(Form::file('image',array('id'=>'customFile','accept'=>"image/*",'required'))); ?>

                    </div>
                </div>
                <div class="review-modal-footer">
                    <button type="submit" class="btn btn-black-yellow submit_advantages">Speichern</button>
                    <button type="button" class="btn btn-border-black" data-dismiss="modal">Abbrechen</button>
                </div>
                <?php echo e(Form::close()); ?>

            </div>
        </div>
    </div>

    <!-- Create Store Public Transportation -->
    <div class="modal fade" id="storeTransportation" tabindex="-1" role="dialog" aria-labelledby="GiveReviewTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <?php echo e(Form::open(array('url'=>'service-provider/add-transportation','method'=>'post','name'=>'add_transportation','id'=>'add_transportation','files'=>'true'))); ?>

                <div class="store-modal-body">
                    <h5>Öffentliche Verkehrsanbindung erstellen</h5>
                    <div class="advantages-form">
                        <label>Haltestelle</label>
                        <?php echo e(Form::text('title','',array('class'=>'consumer-input','placeholder'=>'Haltestelle','required'))); ?>

                    </div>
                    <div class="advantages-form">
                        <label>Bahn-/ Buslinie</label>
                        <?php echo e(Form::text('transportation_no','',array('class'=>'consumer-input','placeholder'=>'Bahn-/ Buslinie','required'))); ?>

                    </div>
                    
                    
                    
                    
                </div>
                <div class="review-modal-footer">
                    <button type="submit" class="btn btn-black-yellow">Speichern</button>
                    <button type="button" class="btn btn-border-black" data-dismiss="modal">Abbrechen</button>
                </div>
                <?php echo e(Form::close()); ?>

            </div>
        </div>
    </div>

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

    <!-- GiveReview -->
    <div class="modal fade" id="GiveReview" tabindex="-1" role="dialog" aria-labelledby="GiveReviewTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <?php echo e(Form::open(array('url'=>'service-provider/venue-replay','name'=>'venue_replay','method'=>'post','id'=>"venue_replay"))); ?>

                <div class="review-modal-body">
                    <div class="review-modal-header">
                        <div class="review-m-profile-img">
                            <img src="./assets/images/profile-1.jpg" id="user_image" alt="">
                        </div>
                        <div class="review-m-profile-info">
                            <h5 id="user_name">Sohni Kenon</h5>
                            <p>Service von: <span id="emp_name"> Michal Doe</span></p>
                            <p>Service: <span id="service_name"> Ladies - Tint re-growth</span></p>
                        </div>
                        <div class="review-m-profile-review">
                            <h6 id="time">vor 2 Tag</h6>
                            <p class="review-box"><span><i class="fas fa-star"></i></span> <label
                                    id="rating">4.5</label></p>
                        </div>
                    </div>
                    <p class="modal-review-info" id="comments">"It was friendly and professional. The colour and cut are
                        both great, and the salon was following Covid-19 safety measures."</p>
                    <div class="review-reply">
                        <label>Kundenbewertung beantworten</label>
                        <textarea cols="30" rows="10" name="store_replay" required id="store_replay"
                                  placeholder="Antwort hinzufügen …"></textarea>
                    </div>
                    <input type="hidden" name="id" id="review_id">
                </div>
                <div class="review-modal-footer">
                    <button type="button" class="btn btn-black-yellow submit_review">Posten</button>
                    <button type="button" class="btn btn-border-black" data-dismiss="modal">Schließen</button>
                </div>
                <?php echo e(Form::close()); ?>

            </div>
        </div>
    </div>

    <div class="modal fade" id="updateGiveReview" tabindex="-1" role="dialog" aria-labelledby="GiveReviewTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <?php echo e(Form::open(array('url'=>'service-provider/venue-replay/update','name'=>'venue_replay','method'=>'post','id'=>'venue_replay_update'))); ?>

                <div class="review-modal-body">
                    <div class="review-modal-header">
                        <div class="review-m-profile-img">
                            <img src="./assets/images/profile-1.jpg" id="user_images" alt="">
                        </div>
                        <div class="review-m-profile-info">
                            <h5 id="user_names">Sohni Kenon</h5>
                            <p>Service von: <span id="emp_names"> Michal Doe</span></p>
                            <p>Service: <span id="service_names"> Ladies - Tint re-growth</span></p>
                        </div>
                        <div class="review-m-profile-review">
                            <h6 id="times">2 d ago</h6>
                            <p class="review-box"><span><i class="fas fa-star"></i></span> <label
                                    id="ratings">4.5</label></p>
                        </div>
                    </div>
                    <p class="modal-review-info" id="commentss">"It was friendly and professional. The colour and cut are
                        both great, and the salon was following Covid-19 safety measures."</p>
                    <div class="review-reply">
                        <label> Antwort auf die Kundenbewertung</label>
                        <textarea cols="30" rows="10" name="store_replay" id="replay" required
                                  placeholder="Write your replay to review given by customer ..."></textarea>
                    </div>
                    <input type="hidden" name="id" id="review_ids">
                </div>
                <div class="review-modal-footer">
                    <button type="button" class="btn btn-black-yellow update_review">Veröffentlichen</button>
                    <button type="button" class="btn btn-border-black" data-dismiss="modal">Schließen</button>
                </div>
                <?php echo e(Form::close()); ?>

            </div>
        </div>
    </div>

    <!-- deleteProfilemodal -->
    <div class="modal fade" id="deleteProfilemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="delete-profile-box">
                        <h4>Bestätigung    </h4>
                        <p>Sind Sie sicher, dass Sie dieses Bild endgültig aus dem Portfolio löschen möchten ? </p>
                    </div>
                    <div class="notes-btn-wrap">

                        <button type="button"  class="btn btn-black-yellow remove_gallery" data-id="">Ja, löschen!</button>
                        <a href="#" class="btn btn-gray" data-dismiss="modal" >Nein, zurück!</a>

                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- deleteServicesmodal -->
    <div class="modal fade" id="deleteServicemodal" tabindex="-1" role="dialog" data-backdrop="false" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="delete-profile-box">
                        <h4>Bestätigung    </h4>
                        <p>Sind Sie sicher, dass Sie diesen Service endgültig löschen möchten? </p>
                    </div>
                    <div class="notes-btn-wrap">

                        <button type="button"  class="btn btn-black-yellow remove_service">Ja, löschen!</button>
                        <a href="#" class="btn btn-gray" data-dismiss="modal" >Nein, zurück!</a>

                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('service_js'); ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
    <script
        src="https://maps.google.com/maps/api/js?key=AIzaSyBSItHxCbk9qBcXp1XTysVLYcJick5K8mU&libraries=places&callback=initialize"
        type="text/javascript"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script>

        var baseurls = '<?php echo e(URL::to("/")); ?>';
        google.maps.event.addDomListener(window, 'load', initialize);

        function initialize() {
            var input = document.getElementById('autocomplete');
            var options = {
                componentRestrictions: {country: 'de'}
            };
            var autocomplete = new google.maps.places.Autocomplete(input, options);
            autocomplete.addListener('place_changed', function () {
                var place = autocomplete.getPlace();
                $('#latitude').val(place.geometry['location'].lat());
                $('#longitude').val(place.geometry['location'].lng());
                getZipcode(place.geometry['location'].lat(), place.geometry['location'].lng())
            });

        }

        function getZipcode(latitude, logitude) {
            var latlng = new google.maps.LatLng(latitude, logitude);
            geocoder = new google.maps.Geocoder();

            geocoder.geocode({'latLng': latlng}, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    if (results[0]) {
                        for (j = 0; j < results[0].address_components.length; j++) {
                            if (results[0].address_components[j].types[0] == 'postal_code')
                                $('.zipcodes').val(results[0].address_components[j].short_name);
                        }
                    }
                } else {
                    alert("Geocoder failed due to: " + status);
                }
            });
        }

        var loadFile = function (event) {
            var reader = new FileReader();
            reader.onload = function () {
                var output = document.getElementById('output');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        };

        var loadFileBanner = function (event) {
            var reader = new FileReader();
            reader.onload = function () {
                var output = document.getElementById('output1');
                var outputmain = document.getElementById('outputbanner');
                output.src = reader.result;
                outputmain.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        };

        $(document).ready(function () {
            $("#flip").click(function () {
                $("#sliderr").slideToggle();
                $("#flip").toggleClass('active');
            });
        });

        $(document).ready(function () {
            $("#flip").click(function () {
                $("#sliderr").slideToggle("slow");
                $("#sliderr").toggleClass("active");
                $("#flip").toggleClass("active");
            });
            $(".select--btnn").click(function () {
                $('.select--btnn').removeClass("active");
                $(this).toggleClass("active");
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

        $('#store_basic_details').validate({ // initialize the plugin
            rules: {
                store_name: {
                    required: true,
                },
                store_address: {
                    required: true,
                },
                store_district: {
                    required: true,
                },
                store_contact_number: {
                    required: true,
                    number: true,
                    minlength: 11,
                    maxlength: 11
                },
                zipcode: {
                    required: true,
                    number: true,
                },
            },
            // Specify validation error messages
            messages: {
                store_name: {
                    required: "Bitte geben Sie einen Mitarbeiternamen an"
                },
                store_address: {
                    required: "Bitte geben Sie eine Adresse an"
                },
                store_contact_number: {
                    required: "Bitte die Telefonnummer eingeben.",
                    minlength: "Bitte geben Sie eine gültige Telefonnummer ein",
                    maxlength: "Bitte geben Sie eine gültige Telefonnummer ein",
                },
                store_district: "Bitte geben Sie einen gültigen Bezirk ein",
                zipcode: "Bitte geben Sie eine gültige Postleitzahl ein",
            },
        });

        $('#add_advantages').validate({ // initialize the plugin
            rules: {
                title: {
                    required: true,
                },
                description: {
                    required: true,
                },
                image: {
                    required: true,
                },

            },
            // Specify validation error messages
            messages: {
                title: {
                    required: "Please provide a Title"
                },
                description: {
                    required: "Please provide a Description"
                },
                image: {
                    required: "Please Select a valid Image",

                }
            },
        });

        $('#add_transportation').validate({ // initialize the plugin
            rules: {
                title: {
                    required: true,
                },
                transportation_no: {
                    required: true,
                },
                // image: {
                //     required: true,
                // },

            },
            // Specify validation error messages
            messages: {
                title: {
                    required: "Bitte geben Sie einen Titel an"
                },
                transportation_no: {
                    required: "Bitte geben Sie eine Beschreibung an"
                },
                // image: {
                //     required: "Please Select a valid Image",
                //
                // }
            },
        });

        $("#customFile").change(function () {
            var fileExtension = ['svg'];
            if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
                swal("Alert!", "Nur SVG-Formate sind möglich", "error");
                $("#customFile").val(null);
            }
        });

        // $("#customFile1").change(function () {
        //     var fileExtension = ['svg'];
        //     if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
        //         swal("Alert!", "Only SVG formats are allowed", "error");
        //         $("#customFile1").val(null);
        //     }
        // });

        $(document).on('change', '.review_sorting', function () {
            var value = $(this).val();
            var id = "<?php echo e($data['id']); ?>";

            $.ajax({
                type: 'GET',
                url: "<?php echo e(URL::to('service-provider/rate-shorting')); ?>",
                data: {type: value, id: id},
                success: function (response) {
                    $(".review-info-body").html(response);
                    $("#filterModal").modal('hide');
                },
                error: function (error) {


                }
            });
        })
		
		 $('body').on('click','.delete_service',function (){
            var id = $(this).data('id');
			 var encrypt = $(this).data('encrypt');
			 
            $('.remove_service').attr('onclick',"removeService("+id+")");
            $('.remove_service').attr('data-encrypt',encrypt);
            $('#deleteServicemodal').modal('toggle');
        });
		function removeService(id){
			var encrypt =  $('.delete_service[data-id=' + id + ']').data('encrypt');
            $.ajax({
                type: 'GET',
                url: "<?php echo e(URL::to('service-provider/remove-service')); ?>/"+encrypt,
                success: function (response) {
                    $('#service_item'+id).remove();
					$('#deleteServicemodal').modal('toggle');
                },
                error: function (error) {

                }
            });
		}
		
        $(document).on('click','.remove_image',function (){
            var id = $(this).data('id');
            $('.remove_gallery').attr('data-id',id);
            $('#deleteProfilemodal').modal('toggle');
        });

        $(document).on('click', '.remove_gallery', function () {
            var id = $(this).data('id');

            $.ajax({
                type: 'POST',
                url: "<?php echo e(URL::to('service-provider/remove-portfolio')); ?>",
                data: {
                    _token: '<?php echo e(csrf_token()); ?>',
                    id: id
                },
                success: function (response) {
                    if (response.status == 'true') {
                        $('.pip[data-id='+id+']').remove();
                        $('#deleteProfilemodal').modal('toggle');
                    }
                },
                error: function (error) {

                }
            });
        });

        $(document).on('click', '.remove_advantages', function () {
            var id = $(this).data('id');

            $.ajax({
                type: 'POST',
                url: "<?php echo e(URL::to('service-provider/remove-advantages')); ?>",
                data: {
                    _token: '<?php echo e(csrf_token()); ?>',
                    id: id
                },
                success: function (response) {
                    if (response.status == 'true') {
                        $('.remove_advantages[data-id=' + id + ']').parent('li').remove();
                    }
                },
                error: function (error) {

                }
            });
        });

        $(document).on('click', '.remove_transporation', function () {
            var id = $(this).data('id');

            $.ajax({
                type: 'POST',
                url: "<?php echo e(URL::to('service-provider/remove-transportation')); ?>",
                data: {
                    _token: '<?php echo e(csrf_token()); ?>',
                    id: id
                },
                success: function (response) {
                    if (response.status == 'true') {
                        $('.remove_transporation[data-id=' + id + ']').parent('li').remove();
                    }
                },
                error: function (error) {

                }
            });
        });

        $(document).on('change', '.store_profile', function () {
            $('#store_gallery').submit();
        })

        $('#summernote').summernote({
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['view', ['fullscreen', 'codeview']]
            ]
        });

        $(document).on('click', '.weekdays', function () {
            var id = $(this).data('id');
            if ($(this).prop('checked') == true) {
                $('.start_time[data-id=' + id + ']').css('pointer-events', 'none');
                $('.start_time[data-id=' + id + ']').attr('readonly', true);
                $('.start_time[data-id=' + id + ']').val('');
                $('.end_time[data-id=' + id + ']').css('pointer-events', 'none');
                $('.end_time[data-id=' + id + ']').attr('readonly', true);
                $('.end_time[data-id=' + id + ']').val('');
            } else {
                $('.start_time[data-id=' + id + ']').css('pointer-events', 'all');
                $('.start_time[data-id=' + id + ']').attr('readonly', false);
                $('.end_time[data-id=' + id + ']').css('pointer-events', 'all');
                $('.end_time[data-id=' + id + ']').attr('readonly', false);
                $('.start_time[data-id=' + id + ']').val('10:00');
                $('.end_time[data-id=' + id + ']').val('20:00');
            }
        })

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

        $(document).on('click', '.category_select', function () {
            var id = $(this).data('id');
            changeSubCategory(id);
        });

        $(document).on('change', '.subcategories', function () {
            var category = $('.category_select:checked').val();
            var id = $(this).val();
            getServiceData(category, id);
        });

        function changeSubCategory(id) {
            $.ajax({
                type: 'POST',
                url: "<?php echo e(URL::to('service-provider/get-subcategory')); ?>",
                data: {
                    _token: '<?php echo e(csrf_token()); ?>',
                    id: id,
                },
                success: function (response) {
                    var html = '';
                    var sub_id = '';
                    if (response.status == 'true') {
                        $.each(response.data, function (i, row) {
                            if(i == 0){
                                sub_id = row.id;
                            }
                            html += '<option value="' + row.id + '">' + row.name + '</option>';
                        });
                    }
                    $('.subcategories').html(html);
                    $('.subcategories').niceSelect('update');
                    getServiceData(id, sub_id);
                },
                error: function (error) {


                }
            });
        }

        function getServiceData(category, id) {
            $.ajax({
                type: 'POST',
                url: "<?php echo e(URL::to('service-provider/get-services')); ?>",
                data: {
                    _token: '<?php echo e(csrf_token()); ?>',
                    id: id,
                    category: category,
                },
                beforesend: $('#loading').css('display', 'block'),
                success: function (response) {

                    $('.servicedata').html(response);
                    $('#loading').css('display', 'none');
                },
                error: function (error) {


                }
            });
        }

        $(document).on('click', '.give_review', function () {
            var id = $(this).data('id');

            $.ajax({
                type: 'POST',
                url: "<?php echo e(URL::to('service-provider/get-review-details')); ?>",
                data: {
                    _token: '<?php echo e(csrf_token()); ?>',
                    id: id,
                },
                success: function (response) {
                    var data = response.data;
                    $('#user_image').attr('src', data.image);
                    $('#user_name').text(data.name);
                    $('#emp_name').text(data.emp);
                    $('#service_name').text(data.category + ' - ' + data.service_name);
                    $('#time').text(data.time);
                    $('#review_id').val(data.id);
                    $('#rating').text(data.total_avg_rating.toFixed(1));
                    $('#comments').text('"' + data.write_comment + '"');
                    $('#GiveReview').modal('toggle');
                },
                error: function (error) {


                }
            });

        });

        $(document).on('click','.submit_review',function(){
                
                var id = $('#review_id').val();
                var store_replay = $('#store_replay').val();

                $.ajax({
                    type: 'POST',
                    url: "<?php echo e(URL::to('service-provider/venue-replay')); ?>",
                    data: {
                        _token: '<?php echo e(csrf_token()); ?>',
                        id: id,
                        store_replay: store_replay,
                    },
                    success: function (response) {
                        var status = response.status;
                        if(status == 'true'){
                            $('.review_sorting').trigger('change');
                            $('#GiveReview').modal('toggle');
                        }
                        
                    },
                    error: function (error) {


                    }
                });
        });

        $(document).on('click', '.edit_review', function () {
            var id = $(this).data('id');

            $.ajax({
                type: 'POST',
                url: "<?php echo e(URL::to('service-provider/get-review-details')); ?>",
                data: {
                    _token: '<?php echo e(csrf_token()); ?>',
                    id: id,
                },
                success: function (response) {
                    var data = response.data;
                    $('#user_images').attr('src', data.image);
                    $('#user_names').text(data.name);
                    $('#emp_names').text(data.emp);
                    $('#service_names').text(data.category + ' - ' + data.service_name);
                    $('#times').text(data.time);
                    $('#review_ids').val(data.id);
                    $('#ratings').text(data.total_avg_rating);
                    $('#replay').text(data.store_replay);
                    $('#commentss').text('"' + data.write_comment + '"');
                    $('#updateGiveReview').modal('toggle');
                },
                error: function (error) {


                }
            });

        });

        $(document).on('click','.update_review',function(){
                 var id = $('#review_ids').val();
                var store_replay = $('#replay').val();

                $.ajax({
                    type: 'POST',
                    url: "<?php echo e(URL::to('service-provider/venue-replay/update')); ?>",
                    data: {
                        _token: '<?php echo e(csrf_token()); ?>',
                        id: id,
                        store_replay: store_replay,
                    },
                    success: function (response) {
                        var status = response.status;
                        if(status == 'true'){
                            $('.review_sorting').trigger('change');
                            $('#updateGiveReview').modal('toggle');
                        }
                        
                    },
                    error: function (error) {


                    }
                });
        });

    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.serviceProvider', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/ServiceProvider/Store/index.blade.php ENDPATH**/ ?>