<?php $__env->startSection('front_title'); ?>
    Cosmetic Adadvantages
<?php $__env->stopSection(); ?>
<?php $__env->startSection('front_css'); ?>
<style>
    .advantages-items:hover .advantages-information span {
        background: rgb(16 25 40 / 50%)!important;
    }
</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('front_content'); ?>
    <!-- adadvantages banner -->
    <section class="adadvantages-banner d-margin">
    <span class="adadvantages-banner-img">
        <img src="<?php echo e(URL::to('storage/app/public/Frontassets/images/adadvantages-banner.png')); ?>" alt="">
    </span>
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-lg-5 col-xl-6">
                    <div class="adadvantages-banner-box">
                        <h6>Wow!</h6>
                        <p>Wow ! Aktuell haben wir <span> <?php echo e(\BaseFunction::getStatisticWebsite('customer')); ?>+ </span> aktive Nutzer*innen auf unserer Buchungsplattform!</p>
                    </div>
                    <div class="adadvantages-banner-info">
                        <h4>Einfach. Schnell. Gebucht.</h4>
                        <p style="text-overflow:unset:overflow:unset;">
                            Termin per Telefon vereinbaren ? Keine Serviceliste mit Preisen verfügbar ? Salon online nicht gefunden ? Termin vergessen ? All das hat jetzt ein Ende. Du willst nichts mehr verpassen und alle Vorteile von reserved4you nutzen können ? Los geht's!
                        </p>
                        <?php if(!Auth::check()): ?>
                            <a href="javascript:void(0)" class="btn main-btn btn-register" data-toggle="modal"
                               data-target="#register-modal">Jetzt kostenlos registrieren <i
                                    class="far fa-arrow-right ml-2"></i></a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="padding-100 who-r4u-main-section">
        <div class="container">
            <div class="who-r4u-section">
                <h5> reserved4you <br/> Kurz für dich erklärt</h5>
                
                <p>
                    Bequem und schnell buchen - das ist der neue Trend. Wie unser System funktioniert? Ganz einfach: Wir schaffen Verbindungen. Und zwar kombinieren wir Buchungen, Übersichtslisten und weitere vorteilhafte Funktionen in mehreren verschiedenen Bereichen. Damit seid ihr für die Zukunft gewappnet.
                </p>

            </div>
            <ul class="catagory-item-ull">
                <li class="catagory-item-1">
                    <a href="javascript:void(0)" class="before-catagory">
                        <img src="<?php echo e(URL::to('storage/app/public/Frontassets/images/category-before-1.svg')); ?>" alt="">
                    </a>
                </li>
                <li class="catagory-item-2">
                    <a href="javascript:void(0)" class="after-catagory">
                        <img src="<?php echo e(URL::to('storage/app/public/Frontassets/images/category-2.svg')); ?>" alt="">
                    </a>
                    <h6>Kosmetik</h6>
                </li>
                <li class="catagory-item-3">
                    <a href="javascript:void(0)" class="before-catagory">
                        <img src="<?php echo e(URL::to('storage/app/public/Frontassets/images/category-before-3.svg')); ?>" alt="">
                    </a>
                </li>
                <li class="catagory-item-4">
                    <a href="javascript:void(0)" class="before-catagory">
                        <img src="<?php echo e(URL::to('storage/app/public/Frontassets/images/category-before-4.svg')); ?>" alt="">
                    </a>
                </li>
            </ul>
        </div>
    </section>

    <section class="padding-100">
        <div class="container">
            <div class="advantages-ico-title">
            <span>
                <img src="<?php echo e(URL::to('storage/app/public/Frontassets/images/advantages.svg')); ?>" alt="">
            </span>
                <h6> Vorteile</h6>
                <h5>Hier bei reserved4you erhältst du alle deine<br/> Lösungen auf nur einer Seite</h5>
            </div>
            <div class="row justify-content-center">
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="advantages-items">
                        <div class="advantages-image">
                            <img src="<?php echo e(URL::to('storage/app/public/Frontassets/images/advantages-img-1.jpg')); ?>" alt="">
                        </div>
                        <div class="advantages-information">
                            <span><?php echo file_get_contents(URL::to('storage/app/public/Frontassets/images/icon/love.svg')) ?></span>
                            <h5>Speichere deine Favoriten in deinem Kundenprofil.</h5>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="advantages-items">
                        <div class="advantages-image">
                            <img src="<?php echo e(URL::to('storage/app/public/Frontassets/images/advantages-img-2.jpg')); ?>" alt="">
                        </div>
                        <div class="advantages-information">
                            <span><?php echo file_get_contents(URL::to('storage/app/public/Frontassets/images/icon/smartphone.svg')) ?></span>
                            <h5 style="margin-top: 40px;">Immer und Überall! Nutze die mobile Version oder App auf allen Endgeräten, um deine Termine online zu buchen.</h5>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="advantages-items">
                        <div class="advantages-image">
                            <img src="<?php echo e(URL::to('storage/app/public/Frontassets/images/advantages-img-3.jpg')); ?>" alt="">
                        </div>
                        <div class="advantages-information">
                            <span><?php echo file_get_contents(URL::to('storage/app/public/Frontassets/images/icon/r4u.svg')) ?></span>
                            <h5>Mehrere Bereiche kombiniert.</h5>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="advantages-items">
                        <div class="advantages-image">
                            <img src="<?php echo e(URL::to('storage/app/public/Frontassets/images/advantages-img-4.jpg')); ?>" alt="">
                        </div>
                        <div class="advantages-information">
                            <span><?php echo file_get_contents(URL::to('storage/app/public/Frontassets/images/icon/calendar-2.svg')) ?></span>
                            <h5>Organisiere deine Termine im persönlichen Kalender.</h5>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="advantages-items">
                        <div class="advantages-image">
                            <img src="<?php echo e(URL::to('storage/app/public/Frontassets/images/advantages-img-5.jpg')); ?>" alt="">
                        </div>
                        <div class="advantages-information">
                            <span><?php echo file_get_contents(URL::to('storage/app/public/Frontassets/images/icon/review.svg')) ?></span>
                            <h5>Platz für dein Feedback und Rückmeldungen von anderen.</h5>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="advantages-items">
                        <div class="advantages-image">
                            <img src="<?php echo e(URL::to('storage/app/public/Frontassets/images/advantages-img-6.jpg')); ?>" alt="">
                        </div>
                        <div class="advantages-information">
                            <span><?php echo file_get_contents(URL::to('storage/app/public/Frontassets/images/icon/bell.svg')) ?></span>
                            <h5>Verpasse keinen Termin – mit der Erinnerungsfunktion.</h5>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="advantages-items">
                        <div class="advantages-image">
                            <img src="<?php echo e(URL::to('storage/app/public/Frontassets/images/advantages-img-7.jpg')); ?>" alt="">
                        </div>
                        <div class="advantages-information">
                            <span><?php echo file_get_contents(URL::to('storage/app/public/Frontassets/images/icon/email.svg')) ?></span>
                            <h5>Sei immer auf dem Laufenden mit unserem Newsletter.</h5>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="advantages-items">
                        <div class="advantages-image">
                            <img src="<?php echo e(URL::to('storage/app/public/Frontassets/images/advantages-img-8.jpg')); ?>" alt="">
                        </div>
                        <div class="advantages-information">
                            <span><?php echo file_get_contents(URL::to('storage/app/public/Frontassets/images/icon/hashtag.svg')) ?></span>
                            <h5>#staytuned über unsere Social Media Kanäle.</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="step-section padding-100">
        <div class="container">
            <div class="step-title">
                <h4>So funktioniert’s<br/>
                    in nur wenigen Steps</h4>
            </div>

            <div class="row step-roww step-roww-1">
                <div class="col-sm-6 col-xl-7">
                    <div class="step-img step-img-1">
                        <img src="<?php echo e(URL::to('storage/app/public/Frontassets/images/step-1.png')); ?>" alt="">
                    </div>
                </div>
                <div class="col-sm-6 col-xl-4">
                    <div class="step-info step-info-1">
                        <span>Step 1</span>
                        <p>Wähle deinen bevorzugten Bereich aus.
                        </p>
                    </div>
                </div>
            </div>
            <div class="row step-roww step-roww-2">
                <div class="col-sm-6 col-xl-4 order-2 order-sm-1">
                    <div class="step-info step-info-2">
                        <span>Step 2</span>
                        <p>Finde den <span> besten Anbieter </span> oder das beste Kosmetikstudio, sogar direkt in deiner Nähe.
                        </p>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-7 order-1 order-sm-2">
                    <div class="step-img step-img-2">
                        <img src="<?php echo e(URL::to('storage/app/public/Frontassets/images/step-2.png')); ?>" alt="">
                    </div>
                </div>
            </div>
            <div class="row step-roww step-roww-3">
                <div class="col-sm-6 col-xl-7">
                    <div class="step-img step-img-3">
                        <img src="<?php echo e(URL::to('storage/app/public/Frontassets/images/step-3.png')); ?>" alt="">
                    </div>
                </div>
                <div class="col-sm-6 col-xl-4">
                    <div class="step-info step-info-3">
                        <span>Step 3</span>
                        <p> Wähle bei deinem gewählten Salon deinen gewünschten Service aus.
                        </p>
                    </div>
                </div>
            </div>
            <div class="row step-roww step-roww-4">
                <div class="col-sm-6 col-xl-4 order-2 order-sm-1">
                    <div class="step-info step-info-4">
                        <span>Step 4</span>
                        <p> Wähle eine*n Mitarbeiter*in für deinen Service aus und vereinbare direkt online einen Termin.
                        </p>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-7 order-1 order-sm-2">
                    <div class="step-img step-img-4">
                        <img src="<?php echo e(URL::to('storage/app/public/Frontassets/images/step-4.png')); ?>" alt="">
                    </div>
                </div>
            </div>
            <div class="row step-roww step-roww-5">
                <div class="col-sm-6 col-xl-7">
                    <div class="step-img step-img-5">
                        <img src="<?php echo e(URL::to('storage/app/public/Frontassets/images/step-5.png')); ?>" alt="">
                    </div>
                </div>
                <div class="col-sm-6 col-xl-4">
                    <div class="step-info step-info-5">
                        <span>Step 5</span>
                        <p>Zuletzt nur noch die Zahlungsmethode auswählen und schon wird dein Termin bestätigt.</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="padding-100">
        <div class="container">
            <div class="testimonial-title">
                <h4>Was sagen unsere Kund*innen?</h4>
            </div>

            <div class="owl-carousel owl-theme" id="testimonial-owl">
                <div class="item">
                    <div class="testimonial-items">
                        <div class="testimonial-profile">
                            <img src="<?php echo e(URL::to('storage/app/public/Frontassets/images/expert-2.png')); ?>"
                                 alt="">
                            <span>vor 5 Tagen</span>
                        </div>
                        <div class="testimonial-profile-info">
                            <h5>Jessica Weber</h5>
                            <h6>Berlin</h6>
                            <div class="area_info_rating_wrap">
                                <ul class="rating-ul">
                                    <li class="active"><i class="fas fa-star"></i></li>
                                    <li class="active"><i class="fas fa-star"></i></li>
                                    <li class="active"><i class="fas fa-star"></i></li>
                                    <li class="active"><i class="fas fa-star"></i></li>
                                    <li><i class="fas fa-star"></i></li>
                                </ul>
                                <p>4.9</p>
                            </div>
                            <p>Online Beauty Termine buchen war für mich noch nie so einfach wie mit diesem Buchungssystem von reserved4you. Es spart so viel Zeit im Alltag, man hat alle Informationen direkt auf einen Blick und das ganze System ist sehr einfach zu handhaben. Ich bin super zufrieden und werde in Zukunft meine Friseur und Kosmetik Behandlungen immer online hierüber buchen.</p>
                        </div>
                        <span class="quote-icon"><img
                                src="<?php echo e(URL::to('storage/app/public/Frontassets/images/quote.svg')); ?>"
                                alt=""></span>
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
                    <h6>Registriere dich hier kostenlos, um alle Vorteile zu nutzen</h6>
                    <?php if(!Auth::check()): ?>
                        <a href="javascript:void(0)" class="btn btn-white" data-toggle="modal"
                           data-target="#register-modal">Jetzt registrieren</a>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </section>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('front_js'); ?>
    <script>
        $('#testimonial-owl').owlCarousel({
            loop: true,
            margin: 10,
            nav: true,
            navText: ["<i class='fas fa-chevron-left'></i>", "<i class='fas fa-chevron-right'></i>"],
            dots: false,
            responsive: {
                0: {
                    items: 1
                }
            }
        })
        // body class //
        $("body").addClass("footer-show");
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.front', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\projects\laravel\reserved4you_dev\resources\views/Front/Cosmetic/cosmeticAdvantages.blade.php ENDPATH**/ ?>