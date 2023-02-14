<!doctype html>
<html dir="ltr" lang="en-US">

<head>
    <title>Reserved4you</title>
    <link type="image/x-icon" rel="shortcut icon" href="{{URL::to('storage/app/public/Serviceassets/images/favicon.png')}}" />
    <!-- Required meta tags -->
    <meta charset="UTF-8" />
    <meta name="HandheldFriendly" content="true">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link type="text/css" rel="stylesheet" href="{{URL::to('storage/app/public/Serviceassets/font/stylesheet.css')}}" />
    <link type="text/css" rel="stylesheet" href="{{URL::to('storage/app/public/Serviceassets/css/all.min.css')}}" />
    <link type="text/css" rel="stylesheet" href="{{URL::to('storage/app/public/Serviceassets/css/bootstrap.min.css')}}" />
    <link type="text/css" rel="stylesheet" href="{{URL::to('storage/app/public/Serviceassets/css/nice-select.css')}}" />
    <link type="text/css" rel="stylesheet" href="{{URL::to('storage/app/public/Serviceassets/css/styles.css')}}" />
    <link type="text/css" rel="stylesheet" href="{{URL::to('storage/app/public/Serviceassets/css/responsive.css')}}" />
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
                    <a href="{{URL::to('/')}}" class="login-logo"><img src="{{URL::to('storage/app/public/Serviceassets/images/logo.png')}}" alt=""></a>
{{--                    <select class="select">--}}
{{--                        <option>Cosmetic</option>--}}
{{--                        <option>Cosmetic 2</option>--}}
{{--                        <option>Cosmetic 3</option>--}}
{{--                    </select>--}}
                </div>
                <div class="login-form">
                    <h3>Willkommen im Dienstleister Panel von reserved4you.</h3>
                    {!! Form::open(array('url'=>'service-provider/login','method'=>'post','name'=>'login','class'=>'authentication-form','autocomplete'=>'off')) !!}
                        @csrf
						<div class="login-input">
                            <img src="{{URL::to('storage/app/public/Serviceassets/images/icon/mail.svg')}}" alt="">
                            <input type="email" id="mail" placeholder="E-Mail"
                                   class="@error('email') is-invalid @enderror" name="email" >
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="login-input">
                            <img src="{{URL::to('storage/app/public/Serviceassets/images/icon/password.svg')}}" alt="">
                            <input type="password" id="password" placeholder="Passwort "
                                   class="@error('password') is-invalid @enderror" name="password" >
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="form-submit-wrap">
                            <button class="btn btn-black" type="submit" name="login">Login <i class="far fa-arrow-right"></i></button>
                            <a href="#" class="forgot-pass-link">Passwort vergessen ?</a>
                        </div>
                    {{Form::close()}}
                </div>
            </div>
            <div class="col-lg-6">
                <div class="login-info">
                    <div class="login-vector">
                        <img src="{{URL::to('storage/app/public/Serviceassets/images/login-vector.svg')}}" alt="">
                    </div>
                    <h4>SMART MANAGEMENT. BETTER SERVICE.</h4>
                    <p>Wir bieten Ihnen die Möglichkeit, Ihren Arbeitsalltag noch effizienter zu managen und alle Termine im Überblick zu behalten. </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Optional JavaScript -->
<script src="{{URL::to('storage/app/public/Serviceassets/js/jquery.min.js')}}"></script>
<script src="{{URL::to('storage/app/public/Serviceassets/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{URL::to('storage/app/public/Serviceassets/js/jquery.nice-select.min.js')}}"></script>
<script src="{{URL::to('storage/app/public/Serviceassets/js/custom.js')}}"></script>
</body>
</html>

