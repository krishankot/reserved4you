<?php $__env->startSection('front_title'); ?>
    Reset Password
<?php $__env->stopSection(); ?>
<?php $__env->startSection('front_css'); ?>
	<style>
		.reset_box{max-width:800px;width:550px;padding:25px;background:#FBFBFB;border-radius:15px;}
	</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('front_content'); ?>
    <section class="d-margin notification-section ">
        <div class="container ">
			<div class="d-flex align-items-center justify-content-center">
            <div style="reset_box">
                <a href="<?php echo e(url('/')); ?>" class="login-logo">
                    <img src="<?php echo e(asset('storage/app/public/Frontassets/images/logo.svg')); ?>" alt="">
                </a>
                <h6 class="login-modal-title">Passwort zurücksetzen <strong> reserved4you</strong></h6>
				<?php echo e(Form::open(array('url'=>route('resetPassword'),'method'=>'post','name'=>'login_form','class'=>"reset_form"))); ?>

               <div class="login-modal-box">
					<div class="login-modal-input">
                        <label
                            for=""><span><img src="<?php echo e(URL::to('storage/app/public/Frontassets/images/icon/password.svg')); ?>" alt=""></span>
                            Passwort</label>
                        <?php echo e(Form::password('new_password',array('placeholder'=>'* * * * * * * * *','required','id'=>"new_password"))); ?>

                        <span class="invalid-feedback new_password_err" role="alert" style="display: none !important;">
                            <strong>
                                <p class="new_password_err-ee"></p>
                            </strong>
                        </span>
                    </div>
                    <div class="login-modal-input">
                        <label
                            for=""><span><img src="<?php echo e(URL::to('storage/app/public/Frontassets/images/icon/password.svg')); ?>" alt=""></span>
                            Passwort bestätigen</label>
                        <?php echo e(Form::password('new_cnf_password',array('placeholder'=>'* * * * * * * * *','required'))); ?>

                        <span class="invalid-feedback new_cnf_password" role="alert" style="display: none !important;">
                            <strong>
                                <p class="new_cnf_password-ee"></p>
                            </strong>
                        </span>

                    </div>
                </div>
				<a href="javascript:void(0)" class="btn btn-black login-modal-btn reset_va">Passwort zurücksetzen</a>
                <?php echo e(Form::close()); ?>										  
            </div>
			</div>
        </div>
    </section>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('front_js'); ?>
   <script>
   $('.reset_form').validate({ // initialize the plugin
        rules: {
            new_password: {
                required: true,
                minlength: 5
            },
            new_cnf_password: {
                required: true,
                minlength: 5,
                equalTo: "#new_password"
            }
        },
        // Specify validation error messages
        messages: {
            new_password: {
                required: "Bitte gib dein Passwort ein",
                minlength: "Dein Passwort muss mindestens aus 5 Zeichen bestehen"
            },
            new_cnf_password: {
                required: "Bitte bestätige dein Passwort",
                equalTo: "Dein Passwort und die Passwortbestätigung müssen übereinstimmen",
                minlength: "Dein Passwort muss mindestens aus 5 Zeichen bestehen"
            },
        },
    });
	$(document).on('click', '.reset_va', function () {
        if ($('.reset_form').valid()) {
			$('.reset_form').submit();
		}
	});
   </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.front', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/Front/Auth/resetPassword.blade.php ENDPATH**/ ?>