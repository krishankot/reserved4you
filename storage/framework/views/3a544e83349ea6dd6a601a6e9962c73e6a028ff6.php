<?php $__env->startSection('front_title'); ?>
Einstellungen
<?php $__env->stopSection(); ?>
<?php $__env->startSection('front_css'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('front_content'); ?>
    <section class="d-margin notification-section">
        <div class="container">
            <h5 class="setting-title">Einstellungen</h5>

            <div class="row setting-row">
                <div class="col-md-12">
                    <?php if(Session::has('message')): ?>
                        <?php echo Session::get('message'); ?>

                    <?php endif; ?>
                </div>
                <div class="col-xl-3">
                    <div class="nav flex-column nav-pills setting-flex-pills" id="v-pills-tab" role="tablist"
                         aria-orientation="vertical">
                        <a class="nav-link active" id="v-pills-password-tab" data-toggle="pill" href="#v-pills-password"
                           role="tab" aria-controls="v-pills-password" aria-selected="true">
                            <span
                                class="setting-pill-icon"><?php echo file_get_contents(URL::to('storage/app/public/Frontassets/images/profile/password.svg')) ?></span>
                            Passwort ändern
                        </a>
                        <a class="nav-link" id="v-pills-reviews-tab" data-toggle="pill" href="#v-pills-reviews"
                           role="tab" aria-controls="v-pills-reviews" aria-selected="false">
                            <span
                                class="setting-pill-icon"><?php echo file_get_contents(URL::to('storage/app/public/Frontassets/images/profile/star.svg')) ?></span>
                                Meine Bewertungen
                        </a>
                        <a class="nav-link" id="v-pills-about-tab" data-toggle="pill" href="#v-pills-about" role="tab"
                           aria-controls="v-pills-about" aria-selected="false">
                            <span
                                class="setting-pill-icon"><?php echo file_get_contents(URL::to('storage/app/public/Frontassets/images/profile/about-us.svg')) ?></span>
                                Über Uns
                        </a>
                        <a class="nav-link" id="v-pills-terms-tab" data-toggle="pill" href="#v-pills-terms" role="tab"
                           aria-controls="v-pills-terms" aria-selected="false">
                            <span
                                class="setting-pill-icon"><?php echo file_get_contents(URL::to('storage/app/public/Frontassets/images/profile/terms.svg')) ?></span>
                                AGB
                        </a>
                        <a class="nav-link" id="v-pills-cancelation-tab" data-toggle="pill" href="#v-pills-cancelation"
                           role="tab" aria-controls="v-pills-cancelation" aria-selected="false">
                            <span
                                class="setting-pill-icon"><?php echo file_get_contents(URL::to('storage/app/public/Frontassets/images/profile/policy.svg')) ?></span>
                                Stornierungsrichtlinien
                        </a>
                        <a class="nav-link" id="v-pills-privacy-tab" data-toggle="pill" href="#v-pills-privacy"
                           role="tab" aria-controls="v-pills-privacy" aria-selected="false">
                            <span
                                class="setting-pill-icon"><?php echo file_get_contents(URL::to('storage/app/public/Frontassets/images/profile/privacy.svg')) ?></span>
                                Datenschutz
                        </a>
                    </div>
                    <a href="javascript:void(0)" class="nav-link-delete delete_profile">
                        <span><?php echo file_get_contents(URL::to('storage/app/public/Frontassets/images/profile/delete.svg')) ?></span>
                        Profil löschen
                    </a>
                </div>
                <div class="col-xl-9">
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-pills-password" role="tabpanel"
                             aria-labelledby="v-pills-password-tab">
                            <?php echo e(Form::open(array('url'=>'change-password','method'=>'post','name'=>'change-password','class'=>'change-passowrd-form'))); ?>

                            <div class="passowrd-input">
                                <input type="password" placeholder="Altes Passwort" name="old_password" required
                                       class="<?php $__errorArgs = ['old_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                <span><img
                                        src="<?php echo e(URL::to('storage/app/public/Frontassets/images/profile/lock.svg')); ?>"
                                        alt=""></span>
                                <?php $__errorArgs = ['old_password'];
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
                            <div class="passowrd-input">
                                <input type="password" placeholder="Neues Passwort" name="new_password" required
                                       class="<?php $__errorArgs = ['new_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                <span><img
                                        src="<?php echo e(URL::to('storage/app/public/Frontassets/images/profile/lock.svg')); ?>"
                                        alt=""></span>
                                <?php $__errorArgs = ['new_password'];
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
                            <div class="passowrd-input">
                                <input type="password" placeholder="Bestätige dein Passwort" name="confirm_password"
                                       required class="<?php $__errorArgs = ['confirm_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                <span><img
                                        src="<?php echo e(URL::to('storage/app/public/Frontassets/images/profile/lock.svg')); ?>"
                                        alt=""></span>
                                <?php $__errorArgs = ['confirm_password'];
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
                            <button type="submit" class="btn btn-block main-btn">Passwort ändern</button>
                            <?php echo e(Form::close()); ?>

                        </div>
                        <div class="tab-pane fade" id="v-pills-reviews" role="tabpanel"
                             aria-labelledby="v-pills-reviews-tab">
                            <?php $__empty_1 = true; $__currentLoopData = $getReview; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
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
                                                        src="https://via.placeholder.com/150x150/00000/FABA5F?text=<?php echo e(strtoupper(substr(@$row->userDetails->first_name, 0, 1))); ?><?php echo e(strtoupper(substr($row->userDetails->last_name, 0, 1))); ?>"
                                                        alt="user">
                                                <?php endif; ?>
                                            </span>
                                            <div>
                                                <h6><?php echo e($row->userDetails->first_name); ?> <?php echo e($row->userDetails->last_name); ?></h6>
                                                <p>Service von <span><?php echo e(@$row->empDetails->emp_name); ?></span></p>
                                            </div>
                                        </div>
                                        <div class="main-review-info-tag-box">
                                            <p class="review-info-tag-box"><?php echo e(@$row->categoryDetails->name); ?> -
                                                <?php echo e(@$row->serviceDetails->service_name); ?></p>
                                            <h5><?php echo e(\Carbon\Carbon::parse($row->updated_at)->diffForHumans()); ?></h5>
                                        </div>
                                    </div>
                                     <div class="setting-store-detail" onclick="window.location.href='<?php echo e(URL::to('cosmetic/'.@$row->storeDetaials->slug)); ?>'">
                                          <span><?php echo file_get_contents(URL::to('storage/app/public/Frontassets/images/icon/location.svg')) ?></span>
                                          <div class="setting-store-info">
                                        <h5><?php echo e(@$row->storeDetaials->store_name); ?></h5>
                                        <p><?php echo e(@$row->storeDetaials->store_address); ?></p>
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
                                    <a href="javascript:void(0)" class="show-full-ratings-link" data-id="<?php echo e($row->id); ?>">Mehr anzeigen
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
                                                    <p>Waiting periodWartezeit</p>
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
                                Leider keine Bewertungen gefunden.
                                </div>
                            <?php endif; ?>
                           
                        </div>
                        <div class="tab-pane fade" id="v-pills-about" role="tabpanel"
                             aria-labelledby="v-pills-about-tab">
                            <div class="setting-about-info">
                                <h4><span><img
                                            src="<?php echo e(URL::to('storage/app/public/Frontassets/images/logo.png')); ?>"
                                            alt=""></span></h4>
                                <p>Bequem und schnell buchen – das ist der neue Trend.
                                Wie unser System funktioniert? Ganz einfach: Wir
                                schaffen Verbindungen. Und zwar kombinieren wir
                                Buchungen, Übersichtslisten und weitere vorteilhafte
                                Funktionen in mehreren verschiedenen Bereichen.
                                Damit seid ihr für die Zukunft gewappnet.
                                </p>
                                <form class="setting-about-form" action="<?php echo e(URL::to('/contact-us')); ?>" method="POST" name="contact_form">
                                    <?php echo csrf_field(); ?>
                                    <h5>Fragen & Anmerkungen</h5>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="about-input">
                                                <input type="text" placeholder="Your full name" name="name" required value="<?php echo e(Auth::user()->first_name); ?> <?php echo e(Auth::user()->last_name); ?>">
                                            </div>
                                            <div class="about-input">
                                                <input type="email" placeholder="Your email address" name="email" required value="<?php echo e(Auth::user()->email); ?>">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="about-input about-textarea">
                                                <textarea placeholder="Bitte gib hier deine Frage oder Nachricht ein. .." name="message" required></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <button href="javascript:void(0)" type="submit" class="btn btn-send main-btn btn-block">Senden
                                        </button>
                                </form>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-pills-terms" role="tabpanel" aria-labelledby="v-pills-terms-tab">
							<?php echo $__env->make('Includes/Front/AGB', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                        <div class="tab-pane fade" id="v-pills-cancelation" role="tabpanel"  aria-labelledby="v-pills-cancelation-tab">
                            <?php echo $__env->make('Includes/Front/stornierung', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                        <div class="tab-pane fade" id="v-pills-privacy" role="tabpanel"
                             aria-labelledby="v-pills-privacy-tab">
                             <?php echo $__env->make('Includes/Front/datenschutz', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="delete-profile-modal" tabindex="-1" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
                <div class="modal-body confirmation-modal-body">
                    <div class="confirmation-modal mb-5">
                        <h5>Bestätigung</h5>
                        <p>Bist du sicher, dass du dein Profil
löschen möchtest ?</p>









                    </div>
                    <button type="button" class="btn btn-black btn-block btn-yes confirm_delete">Ja, löschen!
                    </button>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('front_js'); ?>
    <script>
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

            $(document).on('click', '.delete_profile', function () {
                $('#delete-profile-modal').modal('toggle');
            });

            $(document).on('click','.confirm_delete',function (){
                    window.location.href='delete-user-profile';
            });
			
			$('a[data-toggle="pill"]').on('shown.bs.tab', function (e) {
			  var target = $(e.target).attr("href") // activated tab
			 if(target == "#v-pills-cancelation"){
				  $('html,body').animate({
					scrollTop: $("#stornierung").offset().top - 70
				}, 'fast');
			 }
			});
			
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.front', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/Front/User/setting.blade.php ENDPATH**/ ?>