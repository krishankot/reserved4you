<!--Header-->
<header>
	<style>
			ul.navbar-nav.text-uppercase.ml-auto li a {
				pointer-events: inherit !important;opacity: 1 !important;
			}
            ul.footer-menu li a {
                pointer-events: inherit !important;
            }
		</style>
	
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="{{URL::to('/')}}"><img
                    src="{{URL::to('storage/app/public/Frontassets/images/logo.png')}}" alt="logo"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <div class="burger">
                    <span class="burger__line burger__line_first"></span>
                    <span class="burger__line burger__line_second"></span>
                    <span class="burger__line burger__line_third"></span>
                    <span class="burger__line burger__line_fourth"></span>
                </div>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav text-uppercase ml-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" href="{{URL::to('/')}}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('kosmetik-bereiche') ? 'active' : '' }}" href="{{route('kosmetic.search')}}">Bereiche</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('kosmetik-deine-vorteile') ? 'active' : '' }}" href="{{URL::to('/kosmetik-deine-vorteile')}}">Deine Vorteile</a>
                    </li>
                    @if(!Auth::check())
                        <li class="nav-item">
                            <a class="nav-link btn become-btn btn-business {{ Request::is('geschaeftspartner') ? 'active' : '' }}" href="{{URL::to('geschaeftspartner')}}">Geschäftspartner</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn btn-login cl_login" href="javascript:void(0);" >Anmelden | Registrieren</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('geschaeftspartner') ? 'active' : '' }} btn btn-business" href="{{URL::to('geschaeftspartner')}}">Geschäftspartner</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a href="javascript:void(0);" class="profile-header dropdown-toggle" id="dropdownMenuButton"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span>
                                    @if(Auth::user()->profile_pic == '')
                                        <img src="https://via.placeholder.com/1080x1080/00000/FABA5F?text={{strtoupper(substr(Auth::user()->first_name, 0, 1))}}{{strtoupper(substr(Auth::user()->last_name, 0, 1))}}" alt="">

                                    @else
                                        <img src="{{URL::to('storage/app/public/user/'.Auth::user()->profile_pic)}}" alt="">
                                    @endif
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-new-menu" aria-labelledby="dropdownMenuButton">
                                <div class="header-profile-info">
                                    <span>
                                        @if(Auth::user()->profile_pic == '')
                                        <img src="https://via.placeholder.com/1080x1080/00000/FABA5F?text={{strtoupper(substr(Auth::user()->first_name, 0, 1))}}{{strtoupper(substr(Auth::user()->last_name, 0, 1))}}" alt="">
                                        @else
                                        <img src="{{URL::to('storage/app/public/user/'.Auth::user()->profile_pic)}}" alt="">
                                        @endif
                                    </span>
                                    <div>
                                        <h6>{{Auth::user()->first_name}} {{Auth::user()->last_name}}</h6>
                                        <p>{{Auth::user()->email}}</p>
                                    </div>
                                </div>
                                <a href="{{route('users.profile')}}" class="h-dropdown-item-wrap">Mein Profil <i class="fas fa-chevron-right"></i></a>
                                <a href="{{route('users.settings')}}" class="h-dropdown-item-wrap">Einstellungen <i
                                        class="fas fa-chevron-right"></i></a>
                                <a href="{{route('users.notifications')}}" class="h-dropdown-item-wrap">Mitteilungen <i
                                        class="fas fa-chevron-right"></i></a>
                                <a href="{{ route('users.logout')}}" class="h-dropdown-item-wrap logout-header">Logout <i
                                        class="fas fa-chevron-right"></i></a>
                            </div>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
    <!-- Modal -->
</header>

<!-- login-modal -->
<div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-radius">
            <button type="button" class="close-btn" data-dismiss="modal" aria-label="Close">
                <i class="fas fa-times"></i>
            </button>
            <div class="modal-body modal-bg">
                <a href="index.php" class="login-logo">
                    <img src="{{URL::to('storage/app/public/Frontassets/images/logo.png')}}" alt="">
                </a>
                <h6 class="login-modal-title">Willkommen bei <strong> reserved4you</strong></h6>
                {{Form::open(array('url'=>'','method'=>'post','name'=>'login_form','class'=>"login_form"))}}
                <div class="login-modal-box">
                    <div class="login-modal-input">
                        <label
                            for="mail"><span><?php echo file_get_contents(('storage/app/public/Frontassets/images/icon/email.svg')) ?></span>
                            E-Mail Adresse</label>

                        {{Form::email('email','',array('id'=>'mail','placeholder'=>"beispiel@beispiel.de",'required'))}}
                        <span class="invalid-feedback email_err" role="alert" style="display: none !important;">
                            <strong>
                                <p class="email-ee">E-Mail is required</p>
                            </strong>
                        </span>
                    </div>
                    <div class="login-modal-input">
                        <label
                            for=""><span><img src="{{URL::to('storage/app/public/Frontassets/images/icon/password.svg')}}" alt=""></span>
                            Passwort</label>
                        {{Form::password('password',array('placeholder'=>'* * * * * * * * *','required'))}}

                        <a href="javascript:void(0)" class="forgot-link">Vergessen?</a>
                    </div>
                </div>
                <a href="javascript:void(0)" class="btn btn-black login-modal-btn login_va">Login</a>
                {{Form::close()}}
                <span class="or">oder</span>
                <ul class="login-with-social-media">
                    <li><a href="{{URL::to('/auth/facebook')}}" class="social-btn"
                           data-id="facebook"><?php echo file_get_contents(('storage/app/public/Frontassets/images/icon/facebook.svg')) ?></a>
                    </li>
                    <li><a href="{{URL::to('/auth/google')}}" class="social-btn"
                           data-id="google"><?php echo file_get_contents(('storage/app/public/Frontassets/images/icon/google.svg')) ?></a>
                    </li>
                </ul>
                <p class="sign-up-link">Noch keinen Account ? <a href="javascript:void(0)" class="cl_login"
                                                                  data-toggle="modal" data-target="#register-modal">Jetzt registrieren</a></p>

																  {{-- <p class="sign-up-link"><a href="javascript:void(0)" class="cl_guest" data-toggle="modal"
																  data-target="#guest-modal">Als Gast fortfahren? </a></p> --}}
            </div>
        </div>
    </div>
</div>
<!-- register-modal -->
<div class="modal fade" id="register-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-radius">
            <button type="button" class="close-btn" data-dismiss="modal" aria-label="Close">
                <i class="fas fa-times"></i>
            </button>
            <div class="modal-body modal-bg">
                <a href="index.php" class="login-logo">
                    <img src="{{URL::to('storage/app/public/Frontassets/images/logo.png')}}" alt="">
                </a>
                <h6 class="login-modal-title"> Willkommen bei <strong> reserved4you</strong></h6>
                {{Form::open(array('url'=>'','method'=>'post','name'=>'register_form','class'=>"register_form"))}}
                <div class="login-modal-box">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="login-modal-input border-modal-input">
                                <label class="user-lable-icon"
                                    for=""><span>
                                    <img src="{{URL::to('storage/app/public/Frontassets/images/icon/user.svg')}}" alt="">
                                   </span>
                                    Vorname</label>
                                {{Form::text('first_name','',array('placeholder'=>"Vorname",'required'))}}
                                <span class="invalid-feedback first_name_err" role="alert"
                                      style="display: none !important;">
                                    <strong>
                                        <p class="first_name-ee">Vorname is required</p>
                                    </strong>
                                </span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="login-modal-input border-modal-input">
                                <label class="user-lable-icon"
                                    for=""><span><img src="{{URL::to('storage/app/public/Frontassets/images/icon/user.svg')}}" alt=""></span>
                                    Nachname</label>
                                {{Form::text('last_name','',array('placeholder'=>"Nachname",'required'))}}
                                <span class="invalid-feedback last_name_err" role="alert"
                                      style="display: none !important;">
                                    <strong>
                                        <p class="last_name-ee">Nachname is required</p>
                                    </strong>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="login-modal-input">
                        <label
                            for="mail"><span><?php echo file_get_contents(('storage/app/public/Frontassets/images/icon/email.svg')) ?></span>
                            E-Mail Adresse</label>
                        {{Form::email('email','',array('id'=>'mail','placeholder'=>"beispiel@beispiel.de"))}}
                        <span class="invalid-feedback mail_err" role="alert" style="display: none !important;">
                            <strong>
                                <p class="mail-ee">Last Name is required</p>
                            </strong>
                        </span>
                    </div>
                    <div class="login-modal-input">
                        <label
                            for=""><span><img src="{{URL::to('storage/app/public/Frontassets/images/icon/password.svg')}}" alt=""></span>
                            Passwort</label>
                        {{Form::password('password',array('placeholder'=>'* * * * * * * * *','required','id'=>"password"))}}
                        <span class="invalid-feedback pass_err" role="alert" style="display: none !important;">
                            <strong>
                                <p class="pass_err-ee">Passwort is required</p>
                            </strong>
                        </span>
                    </div>
                    <div class="login-modal-input">
                        <label
                            for=""><span><img src="{{URL::to('storage/app/public/Frontassets/images/icon/password.svg')}}" alt=""></span>
                            Passwort bestätigen</label>
                        {{Form::password('cnf_password',array('placeholder'=>'* * * * * * * * *','required'))}}
                        <span class="invalid-feedback cnf_pass" role="alert" style="display: none !important;">
                            <strong>
                                <p class="cnf_pass-ee">Last Name is required</p>
                            </strong>
                        </span>

                    </div>
					<div class="form-group mt-2">
						<div class="custom-control custom-checkbox area-checkbox">
							<input type="checkbox"  class="custom-control-input fil_advatace" name="join_newsletter" value="1" id="areacustomCheck1">
							<label class="custom-control-label" for="areacustomCheck1">
								<span>Ich möchte E-Mails von reserved4you mit aktuellen Angeboten und Neuigkeiten erhalten. 
Weitere Informationen findest du in unseren </span><a target="_blank" class="plink" href="{{ url('datenschutz') }}">Datenschutzbestimmungen</a><span>.</span>
							</label>
						</div>
					</div>
                </div>
                <a href="javascript:void(0)" class="btn btn-black login-modal-btn register_va">Registrieren</a>
                {{Form::close()}}
                <span class="or">oder</span>
                <ul class="login-with-social-media">
                    <li><a
                            href="{{URL::to('/auth/facebook')}}"><?php echo file_get_contents(('storage/app/public/Frontassets/images/icon/facebook.svg')) ?></a>
                    </li>
                    <li><a
                            href="{{URL::to('/auth/google')}}"><?php echo file_get_contents(('storage/app/public/Frontassets/images/icon/google.svg')) ?></a>
                    </li>
                </ul>
                <p class="sign-up-link">Du hast bereits einen Account? <a href="javascript:void(0)" class="cl_register"
                                                                    data-toggle="modal" data-target="#login-modal">Einloggen</a></p>
																	<div class="login-modal-box text-center" ><small class="text-muted">Mit der Registrierung stimme ich den Allgemeine Geschäftsbedingungen von reserved4you zu.</small></div>
            </div>
        </div>
    </div>
</div>
<!-- Guest Modal -->
<div class="modal fade" id="guest-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-radius">
            <button type="button" class="close-btn" data-dismiss="modal" aria-label="Close">
                <i class="fas fa-times"></i>
            </button>
            <div class="modal-body modal-bg">
                <a href="index.php" class="login-logo">
                    <img src="{{URL::to('storage/app/public/Frontassets/images/logo.png')}}" alt="">
                </a>
                <h6 class="login-modal-title">Willkommen bei <strong> reserved4you</strong></h6>
                {{Form::open(array('url'=>'','method'=>'post','name'=>'guest_form','class'=>"guest_form"))}}
                <div class="login-modal-box">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="login-modal-input border-modal-input">
                                <label
                                    for=""><span><img src="{{URL::to('storage/app/public/Frontassets/images/icon/user.svg')}}" alt=""></span>
                                    Vorname</label>
                                {{Form::text('first_name','',array('placeholder'=>"Vorname",'required','class'=>'g_first_name'))}}
                                <span class="invalid-feedback first_name_err" role="alert"
                                      style="display: none !important;">
                                    <strong>
                                        <p class="first_name-ee">Vorname is required</p>
                                    </strong>
                                </span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="login-modal-input border-modal-input">
                                <label
                                    for=""><span><img src="{{URL::to('storage/app/public/Frontassets/images/icon/user.svg')}}" alt=""></span>
                                    Nachname</label>
                                {{Form::text('last_name','',array('placeholder'=>"Nachname",'required','class'=>'g_last_name'))}}
                                <span class="invalid-feedback last_name_err" role="alert"
                                      style="display: none !important;">
                                    <strong>
                                        <p class="last_name-ee">Nachname is required</p>
                                    </strong>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="login-modal-input">
                        <label
                            for="mail"><span><?php echo file_get_contents(('storage/app/public/Frontassets/images/icon/email.svg')) ?></span>
                            E-mail Address</label>
                        {{Form::email('email','',array('id'=>'mail','placeholder'=>"beispiel@beispiel.de",'class'=>'g_email'))}}
                        <span class="invalid-feedback mail_err" role="alert" style="display: none !important;">
                            <strong>
                                <p class="mail-ee">Last Name is required</p>
                            </strong>
                        </span>
                    </div>
                    <div class="login-modal-input">
                        <label
                            for="phone"><span><?php echo file_get_contents(('storage/app/public/Frontassets/images/icon/phone.svg')) ?></span>
                            Telefonnummer</label>
                        {{Form::text('phone_number','',array('id'=>'phone_number','placeholder'=>"01234567891",'required','class'=>'g_phone_number'))}}
                        <span class="invalid-feedback phone_err" role="alert" style="display: none !important;">
                            <strong>
                                <p class="mail-ee">Phone Number is required</p>
                            </strong>
                        </span>
                    </div>

                </div>
                <a href="javascript:void(0)" class="btn btn-black login-modal-btn guest_va">Als Gast fortfahren</a>
                {{Form::close()}}
            </div>
        </div>
    </div>
</div>

<!-- Forgotpassword-modal -->
<div class="modal fade" id="forgot-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-radius">
            <button type="button" class="close-btn" data-dismiss="modal" aria-label="Close">
                <i class="fas fa-times"></i>
            </button>
            <div class="modal-body modal-bg">
                <a href="index.php" class="login-logo">
                    <img src="{{URL::to('storage/app/public/Frontassets/images/logo.png')}}" alt="">
                </a>
                <h6 class="login-modal-title"> Oops! Passwort vergessen ?</h6>
                {{Form::open(array('url'=>'','method'=>'post','name'=>'forgot_form','class'=>"forgot_form"))}}
                <div class="login-modal-box">
                    <div class="login-modal-input">
                        <label
                            for="mail"><span><?php echo file_get_contents(('storage/app/public/Frontassets/images/icon/email.svg')) ?></span>
                            E-Mail Adresse</label>

                        {{Form::email('email','',array('id'=>'mail','placeholder'=>"beispiel@beispiel.de",'required'))}}
                        <span class="invalid-feedback email_err" role="alert" style="display: none !important;">
                            <strong>
                                <p class="email-ee">E-mail is required</p>
                            </strong>
                        </span>
                    </div>

                </div>
                <a href="javascript:void(0)" class="btn btn-black login-modal-btn forgot_va">Passwort zurücksetzen</a>
                {{Form::close()}}

            </div>
        </div>
    </div>
</div>
