<!doctype html>
<html dir="ltr" lang="en-US" translate="no">

<head>
    <title><?php echo $__env->yieldContent('front_title'); ?> - Reserved4you</title>
    <link type="image/x-icon" rel="shortcut icon"
          href="<?php echo e(URL::to('storage/app/public/Frontassets/images/favicon.png')); ?>"/>
    <!-- Required meta tags -->
    <meta charset="UTF-8"/>
    <meta name="HandheldFriendly" content="true">
	<meta name="google" content="notranslate"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <link type="text/css" rel="stylesheet" href="<?php echo e(URL::to('storage/app/public/Frontassets/font/stylesheet.css')); ?>"/>
    <link type="text/css" rel="stylesheet" href="<?php echo e(URL::to('storage/app/public/Frontassets/css/all.min.css')); ?>"/>
    <link type="text/css" rel="stylesheet" href="<?php echo e(URL::to('storage/app/public/Frontassets/css/bootstrap.min.css')); ?>"/>
    <link type="text/css" rel="stylesheet"
          href="<?php echo e(URL::to('storage/app/public/Frontassets/css/jquery.fancybox.min.css')); ?>"/>
    <link type="text/css" rel="stylesheet"
          href="<?php echo e(URL::to('storage/app/public/Frontassets/css/owl.carousel.min.css')); ?>"/>
    <link type="text/css" rel="stylesheet" href="<?php echo e(URL::to('storage/app/public/Frontassets/css/nice-select.css')); ?>"/>
    <link type="text/css" rel="stylesheet"
          href="<?php echo e(URL::to('storage/app/public/Frontassets/css/bootstrap-datepicker.css')); ?>">
    <link type="text/css" rel="stylesheet" href="<?php echo e(URL::to('storage/app/public/Frontassets/css/styles.css')); ?>"/>
    <link type="text/css" rel="stylesheet" href="<?php echo e(URL::to('storage/app/public/Frontassets/css/responsive.css')); ?>"/>
	<script id="Cookiebot" src="https://consent.cookiebot.com/uc.js" data-cbid="326ebe48-f789-4ceb-bc31-47460cf9c6c2" data-blockingmode="auto" type="text/javascript"></script>
    <?php echo $__env->yieldContent('front_css'); ?>
    <style>
	
        .error,
        .email-ee {
            color: red;
        }
		#CybotCookiebotDialogNav .CybotCookiebotDialogNavItemLink.active{
			color:#101928 !important;
			border-bottom:1px solid #101928 !important;
		}
		/* #CybotCookiebotDialogTabContent input[type=checkbox][disabled]:checked+.CybotCookiebotDialogBodyLevelButtonSlider{background-color:#D6D6D6 !important;}
		#CybotCookiebotDialogTabContent input:checked+.CybotCookiebotDialogBodyLevelButtonSlider{background-color:red !important;} */
		#CybotCookiebotDialogBodyEdgeMoreDetailsLink{color:#101928 !important;}
		#CybotCookiebotDialogNav .CybotCookiebotDialogNavItemLink:hover, #CybotCookiebotDialogBodyEdgeMoreDetailsLink:hover{color:#FABA5F !important;}
		#CybotCookiebotDialogHeader{display:none !important;}
		#CybotCookiebotDialogBodyButtonAccept {
			background: #101928 !important;
			color: #fff;
			border-radius: 10px !important;
			border: 2px solid #101928 !important;
		}
		#CybotCookiebotDialogBodyLevelButtonLevelOptinAllowAll {
			background: #101928 !important;
			color: #fff;
			border-radius: 10px !important;
			border: 2px solid transparent !important;
			-webkit-box-shadow: inset 0 0 0 2px rgb(16 25 40 / 20%)  !important;;
			box-shadow: inset 0 0 0 2px rgb(16 25 40 / 20%)  !important;
		}
		#CybotCookiebotDialogBodyLevelButtonLevelOptinAllowallSelection, #CybotCookiebotDialogBodyLevelButtonCustomize, #CybotCookiebotDialogBodyButtonDecline{
			border-radius: 10px !important;
			border: 1px solid transparent !important;
			color:#101928 !important;
			-webkit-box-shadow: inset 0 0 0 2px rgb(16 25 40 / 20%)  !important;;
			box-shadow: inset 0 0 0 2px rgb(16 25 40 / 20%)  !important;
		}
		
		
		
		.CybotEdge #CybotCookiebotDialogBodyButtonDecline{display:none !important}
      
        .invalid-feedback.email_err {
            display: block !important;
        }

        iframe.skiptranslate {
            display: none !important;
        }

        body {
            top: 0 !important;
        }

        #profileImage {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background: #512DA8;
            font-size: 35px;
            color: #fff;
            text-align: center;
            line-height: 150px;
            margin: 20px 0;
        }
		.swal-button{
		    background: #101928;
			border-radius: 12px;
			color: #fff;
			padding: 12px 21px;
			font-size: 16px;
			line-height: inherit;
			margin-left: 10px;
			border:0px;
			box-shadow:none;
			outline:0px;
		}
		.swal-button:focus{border:0px}
		.swal-button:not([disabled]):hover{
			box-shadow: inset 0 0 0 2px rgb(16 25 40 / 20%);
			color: #101928;
			background-color: #fff;
			border:0px;
		}

    </style>

</head>

<body>
<div id="loading2">

</div>

<div id="loading" style="display:none">

</div>

<?php
function chk_active($p)
{
    $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    if (strpos($actual_link, $p) !== false) {
        return true;
    } else {
        return false;
    }
}
?>
<?php echo $__env->make('Includes.Front.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php echo $__env->yieldContent('front_content'); ?>

<?php echo $__env->make('Includes.Front.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<!-- <script id="CookieDeclaration" src="https://consent.cookiebot.com/326ebe48-f789-4ceb-bc31-47460cf9c6c2/cd.js" type="text/javascript" async></script> -->
<a onclick="topFunction()" id="myBtn" title="Go to top" style="display: block;"><i class="fas fa-arrow-up"></i></a>
<!-- Optional JavaScript -->
<script src="<?php echo e(URL::to('storage/app/public/Frontassets/js/jquery.min.js')); ?>"></script>
<script src="<?php echo e(URL::to('public/js/disable.js')); ?>"></script>
<script src="<?php echo e(URL::to('storage/app/public/Frontassets/js/bootstrap.bundle.min.js')); ?>"></script>
<script src="<?php echo e(URL::to('storage/app/public/Frontassets/js/jquery.fancybox.min.js')); ?>"></script>
<script src="<?php echo e(URL::to('storage/app/public/Frontassets/js/owl.carousel.min.js')); ?>"></script>
<script src="<?php echo e(URL::to('storage/app/public/Frontassets/js/jquery.nice-select.min.js')); ?>"></script>
<script src="<?php echo e(URL::to('storage/app/public/Frontassets/js/bootstrap-datepicker.js')); ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
<script src="<?php echo e(URL::to('storage/app/public/Frontassets/js/custom.js')); ?>"></script>
 <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<?php echo $__env->yieldContent('front_js'); ?>
<script>
    var baseurl = '<?php echo e(URL::to('/')); ?>';
    var token = '<?php echo e(csrf_token()); ?>';
    var authCheck = '<?php echo e(Auth::check()); ?>';
    var loginUser = localStorage.getItem('loginuser');

    $(window).on('load', function () {
        $("#loading2").fadeOut("1500");
    });

    // google translate END
</script>


<script>
    (function () {
        const burger = document.querySelector('.burger');
        burger.addEventListener('click', () => {
            burger.classList.toggle('burger_active');
        });
    }());
</script>
<script>
    $("body").addClass("footer-show");
    $('#index-filter-owl').owlCarousel({
        loop: true,
        margin: 10,
        nav: true,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 3
            },
            1000: {
                items: 3
            }
        }
    });
    $(".service-item-icon").click(function () {
        $('.service-item-icon').removeClass("active");
        $(this).addClass("active");
    });
    $('#digital-main-owl').owlCarousel({
        loop: true,
        margin: 10,
        nav: false,
        dots: false,
        responsive: {
            0: {
                items: 2
            },
            480: {
                items: 3
            },
            1000: {
                items: 5
            }
        }
    })

    $('.login_form').validate({ // initialize the plugin
        rules: {
            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
                minlength: 5
            }
        },
        // Specify validation error messages
        messages: {
            password: {
                required: "Bitte gib dein Passwort ein",
                minlength: "Dein Passwort muss mindestens aus 5 Zeichen bestehen"
            },
            email: "Bitte gib deine E-Mail Adresse ein"
        },
    });

	
    $('body').on('click', '#CybotCookiebotDialogBodyEdgeMoreDetailsLink', function (e) { 
		e.preventDefault();
		window.location.href = "<?php echo e(route('datenschutz')); ?>";
	});
	$(document).on('click', '.login_va', function () {
        if ($('.login_form').valid()) {
			/* if(localStorage.getItem('lastValue') != 'proceed_to_pay'){
				localStorage.clear();
				sessionStorage.clear();
			} */
            var form = $('.login_form').serialize();
            $.ajax({
                type: 'POST',
                async: true,
                dataType: "json",
                url: "<?php echo e(URL::to('user-login')); ?>",
                data: form,
                beforesend: $('#loading').css('display', 'block'),
                success: function (data) {
                    console.log(data)
                    var status = data.ResponseCode;
                    var text = data.ResponseText;
                    console.log(status);
                    if (status == 0) {

                        $('.email-ee').text(text);
                        $('.invalid-feedback.email_err').removeAttr("style");
                    } else {
                        location.reload();
                        localStorage.setItem('loginuser', 'authuser');
                    }
                    $('#loading').css('display', 'none');


                },
                error: function (data) {
                    console.log(data)
                    var data = data.responseJSON.errors;
                }
            });
        }
    });

    $('.register_form').validate({ // initialize the plugin
        rules: {
            first_name: {
                required: true
            },
            last_name: {
                required: true
            },
            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
                minlength: 5
            },
            cnf_password: {
                required: true,
                minlength: 5,
                equalTo: "#password"
            }
        },
        // Specify validation error messages
        messages: {
            password: {
                required: "Bitte gib dein Passwort ein",
                minlength: "Dein Passwort muss mindestens aus 5 Zeichen bestehen"
            },
            cnf_password: {
                required: "Bitte bestätige dein Passwort",
                equalTo: "Dein Passwort und die Passwortbestätigung müssen übereinstimmen",
                minlength: "Dein Passwort muss mindestens aus 5 Zeichen bestehen"
            },
            email: "Bitte gib deine E-Mail Adresse ein",
            first_name: "Bitte gib deinen Vornamen ein",
            last_name: "Bitte gib deinen Nachnamen ein",
        },
    });


    $(document).on('click', '.register_va', function () {
		if ($('.register_form').valid()) {
            var form = $('.register_form').serialize();
            $.ajax({
                type: 'POST',
                async: true,
                dataType: "json",
                url: "<?php echo e(URL::to('user-register')); ?>",
                data: form,
                beforesend: $('#loading').css('display', 'block'),
                success: function (data) {
                    console.log(data)
                    var status = data.ResponseCode;
                    var text = data.ResponseText;

                    if (status == 0) {

                        $('.email-ee').text(text);
                        $('.invalid-feedback.email_err').removeAttr("style");
                    } else if(status == 2 || status == 3){
						//$('#email_sent').text(text);
						$('#register-modal').modal('hide');
						swal({
							title: false,
							text: text,
							type: "info",
							buttonsStyling: false
						});
                    }else{
                        location.reload();
                        localStorage.setItem('loginuser', 'authuser');
                    }

                    $('#loading').css('display', 'none');

                },
                error: function (data) {
                    var data = data.responseJSON.errors;
                    console.log(data);
                    $(data).each(function (index, element) {
                        if (element['first_name'] != undefined) {
                            $('.first_name_err').css('display', 'block');
                            $('.first_name-ee').text(element['first_name'][0]);
                        }
                        if (element['last_name'] != undefined) {
                            $('.last_name_err').css('display', 'block');
                            $('.last_name-ee').text(element['last_name'][0]);
                        }
                        if (element['email'] != undefined) {
                            $('.mail_err').css('display', 'block');
                            $('.mail-ee').text(element['email'][0]);
                        }
                        if (element['password'] != undefined) {
                            $('.pass_err').css('display', 'block');
                            $('.pass_err-ee').text(element['password'][0]);
                        }


                    });
                    $('#loading').css('display', 'none');
                }
            });
        }
    });


    $('.guest_form').validate({ // initialize the plugin
        rules: {
            first_name: {
                required: true
            },
            last_name: {
                required: true
            },
            email: {
                required: true,
                email: true
            },
            phone_number: {
                required: true,
                minlength: 11,
                maxlength: 11
            }
        },
        // Specify validation error messages
        messages: {
            password: {
                required: "Bitte gib dein Passwort ein",
                minlength: "Dein Passwort muss mindestens aus 5 Zeichen bestehen"
            },
            cnf_password: {
                required: "Bitte bestätige dein Passwort",
                equalTo: "Dein Passwort und die Passwortbestätigung müssen übereinstimmen",
                minlength: "Dein Passwort muss mindestens aus 5 Zeichen bestehen",
            },
            phone_number: {
                required: "Bitte gib deine Telefonnummer ein",
                matches: "Bitte gib eine gültige Telefonnummer ein.",
                minlength: "Bitte gib mindestens 11 Zeichen ein",
                maxlength: "Bitte gib mindestens 11 Zeichen ein",
            },
            email: "Bitte gib deine E-Mail Adresse ein",
            first_name: "Bitte gib deinen Vornamen ein",
            last_name: "Bitte gib deinen Nachnamen ein",
        },
    });

    $(document).on('click', '.guest_va', function () {
        if ($('.guest_form').valid()) {

            var g_first_name = $('.g_first_name').val();
            var g_last_name = $('.g_last_name').val();
            var g_email = $('.g_email').val();
            var g_phone_number = $('.g_phone_number').val();
            localStorage.setItem('first_name', g_first_name);
            localStorage.setItem('last_name', g_last_name);
            localStorage.setItem('email', g_email);
            localStorage.setItem('phone_number', g_phone_number);
            localStorage.setItem('loginuser', 'guest');
            $('#guest-modal').modal('toggle');

            var loginredirect = localStorage.getItem('loginredirect');
            if (loginredirect == 'book-modal') {
                var redirectId = localStorage.getItem('loginredirectid');
                redirectUser(redirectId);
                localStorage.removeItem('loginredirect');
                localStorage.removeItem('loginredirectid');
            }
            location.reload();
        }
    });

    $(document).on('click', '.cl_login', function () {
        $('#login-modal').modal('toggle');
        $('.cl_guest').css('display','block');
    });

    $(document).on('click', '.cl_register', function () {
		 $('#register-modal').modal('toggle');
		/*  $('#register-modal').css('padding-right', '17px');
		 $('body').css('padding-right', '17px'); */
	});

    $(document).on('click', '.cl_guest', function () {
        $('#login-modal').modal('toggle');
        $('#guest-modal').modal('toggle');
    });

    $(document).on('click', '.forgot-link', function () {
        $('#login-modal').modal('toggle');
        $('#forgot-modal').modal('toggle');
    })
	$('#login-modal, #register-modal, #forgot-modal, #guest-modal').on('hidden.bs.modal', function () {
		$('body').removeClass('modal-open');
	  $('.modal').css('padding-right', '0px');
		$('body').css('padding-right', '0px'); 
	});
	$('#login-modal, #register-modal, #forgot-modal, #guest-modal').on('shown.bs.modal', function () {
		$('body').addClass('modal-open');
		$('.modal').css('padding-right', '17px');
		$('body').css('padding-right', '17px'); 
	});
    $(document).on('click', '.social-btn', function () {
        var id = $(this).data('id');
        localStorage.setItem('loginuser', 'authuser');
    })

    $(document).on('click', '.logout, .logout-header', function () {
        localStorage.clear();
        sessionStorage.clear();
        window.location.href = "<?php echo e(route('users.logout')); ?>";
    });
	
	

    $('.forgot_form').validate({ // initialize the plugin
        rules: {
            email: {
                required: true,
                email: true
            }
        },
        // Specify validation error messages
        messages: {
            email: "Bitte gib deine E-Mail Adresse ein"
        },
    });
    $(document).on('click', '.forgot_va', function () {
        if ($('.forgot_form').valid()) {
            var form = $('.forgot_form').serialize();
            $.ajax({
                type: 'POST',
                async: true,
                dataType: "json",
                url: "<?php echo e(URL::to('user-forgot')); ?>",
                data: form,
                beforesend: $('#loading').css('display', 'block'),
                success: function (data) {
                    var status = data.ResponseCode;
                    var text = data.ResponseText;
                    if (status == 0) {

                        $('.email-ee').text(text);
                        $('.invalid-feedback.email_err').removeAttr("style");
                    } else {
                        $('#forgot-modal').modal('hide');
						 $('#loading').css('display', 'none');
							swal({
								title: false,
								text: text,
								type: "info",
								buttonsStyling: false
							});
                    }

                    $('#loading').css('display', 'none');
                },
                error: function (data) {
                    var data = data.responseJSON.errors;
                    $('.email-ee').text(text);
                    $('.invalid-feedback.email_err').removeAttr("style");
                    $('#loading').css('display', 'none');
                }
            });
        }


    });

    $(document).ready(function () {
        var loginredirect = localStorage.getItem('loginredirect');
        if (loginredirect == 'book-modal') {
            var redirectId = localStorage.getItem('loginredirectid');
            redirectUser(redirectId);
            localStorage.removeItem('loginredirect');
            localStorage.removeItem('loginredirectid');
        }
    });

    // function googleTranslateElementInit() {
    //     new google.translate.TranslateElement({
    //         includedLanguages: 'en,de,fr'
    //     }, 'google_translate_element');
    //
    //     let first = $('#google_translate_element'); //desktop
    //     let second = $('#google_translate_element_m');
    //     let nowChanging = false;
    //
    //     // we need to let it load, since it'll be in footer a small delay shouldn't be a problem
    //     setTimeout(function () {
    //         select = first.find('select');
    //         // lets clone the translate select
    //         second.html(first.clone());
    //         second.find('select').val(select.val());
    //
    //         // add our own event change
    //         first.find('select').on('change', function (event) {
    //             if (nowChanging == false) {
    //                 second.find('select').val($(this).val());
    //             }
    //             return true;
    //         });
    //
    //         second.find('select').on('change', function (event) {
    //             if (nowChanging) {
    //                 return;
    //             }
    //             nowChanging = true;
    //             first.find('select').val($(this).val());
    //             trackChange();
    //
    //             // give this some timeout incase changing events try to hit each other
    //             setTimeout(function () {
    //                 nowChanging = false;
    //             }, 1000);
    //
    //         });
    //     }, pageDelayed);
    // }

</script>
<!-- Start of LiveChat (www.livechatinc.com) code -->
<script>
    window.__lc = window.__lc || {};
    window.__lc.license = 13059087;
    ;(function(n,t,c){function i(n){return e._h?e._h.apply(null,n):e._q.push(n)}var e={_q:[],_h:null,_v:"2.0",on:function(){i(["on",c.call(arguments)])},once:function(){i(["once",c.call(arguments)])},off:function(){i(["off",c.call(arguments)])},get:function(){if(!e._h)throw new Error("[LiveChatWidget] You can't use getters before load.");return  i(["get",c.call(arguments)])},call:function(){i(["call",c.call(arguments)])},init:function(){var n=t.createElement("script");n.async=!0,n.type="text/javascript",n.src="https://cdn.livechatinc.com/tracking.js",t.head.appendChild(n)}};! n.__lc.asyncInit&&e.init(),n.LiveChatWidget=n.LiveChatWidget||e}(window,document,[].slice))
</script>
<noscript><a href="https://www.livechatinc.com/chat-with/13059087/" rel="nofollow">Chat withus</a>, powered by <a href="https://www.livechatinc.com/?welcome" rel="noopener nofollow" target="_blank">LiveChat</a></noscript>
<!-- End of LiveChat code -->
</body>

</html>
<?php /**PATH F:\projects\laravel\reserved4you_dev\resources\views/layouts/front.blade.php ENDPATH**/ ?>