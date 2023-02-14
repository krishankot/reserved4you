@extends('layouts.front')
@section('front_title')
    Reset Password
@endsection
@section('front_css')
	<style>
		.reset_box{max-width:800px;width:550px;padding:25px;background:#FBFBFB;border-radius:15px;}
	</style>
@endsection
@section('front_content')
    <section class="d-margin notification-section ">
        <div class="container ">
			<div class="d-flex align-items-center justify-content-center">
            <div style="reset_box">
                <a href="{{ url('/') }}" class="login-logo">
                    <img src="{{ asset('storage/app/public/Frontassets/images/logo.svg') }}" alt="">
                </a>
                <h6 class="login-modal-title">Passwort zurücksetzen <strong> reserved4you</strong></h6>
				{{Form::open(array('url'=>route('resetPassword'),'method'=>'post','name'=>'login_form','class'=>"reset_form"))}}
               <div class="login-modal-box">
					<div class="login-modal-input">
                        <label
                            for=""><span><img src="{{URL::to('storage/app/public/Frontassets/images/icon/password.svg')}}" alt=""></span>
                            Passwort</label>
                        {{Form::password('new_password',array('placeholder'=>'* * * * * * * * *','required','id'=>"new_password"))}}
                        <span class="invalid-feedback new_password_err" role="alert" style="display: none !important;">
                            <strong>
                                <p class="new_password_err-ee"></p>
                            </strong>
                        </span>
                    </div>
                    <div class="login-modal-input">
                        <label
                            for=""><span><img src="{{URL::to('storage/app/public/Frontassets/images/icon/password.svg')}}" alt=""></span>
                            Passwort bestätigen</label>
                        {{Form::password('new_cnf_password',array('placeholder'=>'* * * * * * * * *','required'))}}
                        <span class="invalid-feedback new_cnf_password" role="alert" style="display: none !important;">
                            <strong>
                                <p class="new_cnf_password-ee"></p>
                            </strong>
                        </span>

                    </div>
                </div>
				<a href="javascript:void(0)" class="btn btn-black login-modal-btn reset_va">Passwort zurücksetzen</a>
                {{Form::close()}}										  
            </div>
			</div>
        </div>
    </section>
@endsection
@section('front_js')
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
@endsection
