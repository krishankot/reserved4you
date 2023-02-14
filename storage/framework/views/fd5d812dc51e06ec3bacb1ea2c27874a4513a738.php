<!doctype html>
<html dir="ltr" lang="en-US">

<head>
    <title>Reserved4you</title>
    <link type="image/x-icon" rel="shortcut icon" href="<?php echo e(URL::to('storage/app/public/Serviceassets/images/favicon.png')); ?>" />
    <!-- Required meta tags -->
    <meta charset="UTF-8" />
    <meta name="HandheldFriendly" content="true">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link type="text/css" rel="stylesheet" href="<?php echo e(URL::to('storage/app/public/Serviceassets/font/stylesheet.css')); ?>" />
    <link type="text/css" rel="stylesheet" href="<?php echo e(URL::to('storage/app/public/Serviceassets/css/all.min.css')); ?>" />
    <link type="text/css" rel="stylesheet" href="<?php echo e(URL::to('storage/app/public/Serviceassets/css/bootstrap.min.css')); ?>" />
    <link type="text/css" rel="stylesheet" href="<?php echo e(URL::to('storage/app/public/Serviceassets/css/nice-select.css')); ?>" />
    <link type="text/css" rel="stylesheet" href="<?php echo e(URL::to('storage/app/public/Serviceassets/css/styles.css')); ?>" />
    <link type="text/css" rel="stylesheet" href="<?php echo e(URL::to('storage/app/public/Serviceassets/css/responsive.css')); ?>" />
    <style>
        .invalid-feedback {
            display: block;
        }
    </style>
</head>

<body>

<section class="login-modal">
    <div class="container">
        <div class="row no-gutter">
            <div class="col-lg-6">
                <div class="login-header-wrap justify-content-center">
                    <a href="<?php echo e(URL::to('/')); ?>" class="login-logo"><img src="<?php echo e(URL::to('storage/app/public/Serviceassets/images/logo.png')); ?>" alt=""></a>





                </div>
                <div class="login-form">
                    <h3>Willkommen im Dienstleister Panel von reserved4you.</h3>
                    <?php echo Form::open(array('url'=>'service-provider/login','method'=>'post','name'=>'login','class'=>'authentication-form','autocomplete'=>'off')); ?>

                        <?php echo csrf_field(); ?>
						<div class="login-input">
                            <img src="<?php echo e(URL::to('storage/app/public/Serviceassets/images/icon/mail.svg')); ?>" alt="">
                            <input type="email" id="mail" placeholder="E-Mail"
                                   class="<?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="email" >
                            <?php $__errorArgs = ['email'];
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
                        <div class="login-input">
                            <img src="<?php echo e(URL::to('storage/app/public/Serviceassets/images/icon/password.svg')); ?>" alt="">
                            <input type="password" id="password" placeholder="Passwort "
                                   class="<?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="password" >
                            <?php $__errorArgs = ['password'];
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
                        <div class="form-submit-wrap">
                            <button class="btn btn-black" type="submit" name="login">Login <i class="far fa-arrow-right"></i></button>
                            <a href="#" class="forgot-pass-link">Passwort vergessen ?</a>
                        </div>
                    <?php echo e(Form::close()); ?>

                </div>
            </div>
            <div class="col-lg-6">
                <div class="login-info">
                    <div class="login-vector">
                        <img src="<?php echo e(URL::to('storage/app/public/Serviceassets/images/login-vector.svg')); ?>" alt="">
                    </div>
                    <h4>SMART MANAGEMENT. BETTER SERVICE.</h4>
                    <p>Wir bieten Ihnen die Möglichkeit, Ihren Arbeitsalltag noch effizienter zu managen und alle Termine im Überblick zu behalten. </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Optional JavaScript -->
<script src="<?php echo e(URL::to('storage/app/public/Serviceassets/js/jquery.min.js')); ?>"></script>
<script src="<?php echo e(URL::to('storage/app/public/Serviceassets/js/bootstrap.bundle.min.js')); ?>"></script>
<script src="<?php echo e(URL::to('storage/app/public/Serviceassets/js/jquery.nice-select.min.js')); ?>"></script>
<script src="<?php echo e(URL::to('storage/app/public/Serviceassets/js/custom.js')); ?>"></script>
</body>
</html>

<?php /**PATH F:\projects\laravel\reserved4you_dev\resources\views/ServiceProvider/Auth/login.blade.php ENDPATH**/ ?>