<!doctype html>
<html dir="ltr" lang="en-US">

<head>
    <title>Recommanded Plans</title>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <link type="image/x-icon" rel="shortcut icon" href="{{asset('public/asset_front/assets/images/favicon.jpg')}}"/>
    <meta charset="UTF-8"/>
    <meta name="HandheldFriendly" content="true">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link type="text/css" rel="stylesheet" href="{{asset('public/asset_front/assets/css/all.min.css')}}"/>
    <link type="text/css" rel="stylesheet" href="{{asset('public/asset_front/assets/fonts/stylesheet.css')}}"/>
    <link type="text/css" rel="stylesheet" href="{{asset('public/asset_front/assets/css/owl.carousel.min.css')}}">
    <link type="text/css" rel="stylesheet" href="{{asset('public/asset_front/assets/css/bootstrap.min.css')}}"/>
    <link type="text/css" rel="stylesheet" href="{{asset('public/asset_front/assets/css/bootstrap-datepicker.css')}}"/>
    <link type="text/css" rel="stylesheet" href="{{asset('public/asset_front/assets/css/styles3.css')}}"/>
    <link type="text/css" rel="stylesheet" href="{{asset('public/asset_front/assets/css/responsive.css')}}"/>
</head>
<style>
    .custom_radio {
        /* position: fixed;
    opacity: 0;
    pointer-events: none; */
    }
    .pricemonthly h1 {
        margin-right: 0;
    }
    p.extra-text {
    text-align: end;
    margin-top: 6px;
    font-size: 15px;
    font-weight: 500;
}
</style>
<script>
    var plan_type = 'Monthly';
</script>
<body>
<header>
    <nav class="navbar navbar-expand-lg logo">
        <div class="container">
            <a class="navbar-brand" href="{{URL::to('/')}}">
                <img src="{{asset('public/asset_front/assets/images/logo.svg')}}" alt="logo">
            </a>
            <div class="contractheading">
                <p>Contract With <span>Reserved4you</span>
                </p>
            </div>
        </div>
    </nav>
    <!-- Modal -->
</header>
<!-- Contact detail -->
<section class="contactdetail">
    <div class="progress">
        <div class="progress-bar progressbarr4u" role="progressbar" style="width: 20%;" aria-valuenow="25"
             aria-valuemin="0" aria-valuemax="100"></div>
    </div>
    <div class="container">
        <div class="recomanded">
        <h2>Unsere Pakete</h2>
				<p>*Einzelauswahl</p>
        </div>

        <div class="monthly_annually_plans">
            <div class="monthly_annually_plans-wrap">
                <ul class="nav nav-pills recommandedmonthlyannuallplan" id="pills-tab" role="tablist">
                    <li class="nav-item aaf" role="presentation" onclick="plan_type='Monthly';">
                        <a type="button"
                           class="nav-link monthlyplan {{$contactdetails->Plan == 'Monthly' ? 'active' : '' }}"
                           at="Monthly" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab"
                           aria-controls="pills-home" aria-selected="true">Monatlich</a>
                    </li>

                    <li class="nav-item aaf" role="presentation" onclick="plan_type='Annually';">
                        <!-- <input type="radio" class="custom_radio" id="huey" name="plan" value="Annually" checked> -->
                        <a name="plan"
                           class="nav-link monthlyplan  {{$contactdetails->Plan == 'Annually' ? 'active' : '' }}"
                           at="Annually" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab"
                           aria-controls="pills-profile" aria-selected="false">Jährlich</a>
                    </li>

                </ul>
                <div class="saveplannow">
                    <p>Spare <span>120€</span> jährlich</p>
                </div>
            </div>
        </div>
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                <div class="container chooseplan">
                    <div class="row justify-content-center">
                        <!-- Basic plans -->
                        <div class="col-lg-4 col-md-6 ">
                            <label for="plans-1" class="plans-label">

                                @if($contactdetails->Plan == 'Monthly' && $contactdetails->Actual_plan == 'Basic')
                                    <input type="radio" name="plans" id="plans-1" checked data-plan="Basic" data-amount="0" data-id="plans-1">
                                @else
                                    <input type="radio" name="plans" id="plans-1" data-plan="Basic" data-amount="0" data-id="plans-1">
                                @endif
                                <div class="plans">
                                    <div class="basicplanimg">
                                        <img src="{{asset('public/asset_front/assets/images/basic.svg')}}" class="basic">
                                    </div>
                                    <h2>Basic</h2>
                                    <p class="auflis">Auflistung + Profilgestaltung</p>
                                    <div class="pricemonthly">
                                    <h1>0€ </h1>
											<div class="cancelprice">,
												<h5> /  / Pro Monat</h5>
											</div>
                                    </div>
                                    <div class="facilty">
                                    <div class="facility1">
												<img src="{{asset('public/asset_front/assets/images/id_card.svg')}}">
												<p>Auflistung auf reserved4you </p>
											</div>
											<div class="facility2">
												<img src="{{asset('public/asset_front/assets/images/computer.svg')}}">
												<p>Optimiert für mobile Endgeräte</p>
											</div>
											<div class="facility3">
												<img src="{{asset('public/asset_front/assets/images/support.svg')}}">
												<p> 48h E-Mail Support</p>
											</div>
                                        <div class="facility4">
                                            <img src="{{asset('public/asset_front/assets/images/news-letter.svg')}}">
                                            <p>Individueller Newsletter</p>
                                        </div>
                                        <div class="facility5">
                                            <img src="{{asset('public/asset_front/assets/images/megaphone.svg')}}">
                                            <p>Werbung auf reserved4you + Social Media</p>
                                        </div>
                                    </div>
                                    <div class="recruitmentfee">
											<p>Recruitment Fee : <span>0€ </span>
											</p>
											<p>Cancellation Time: <span>/</span>
											</p>
										</div>
                                    <div class="selectbtn">
                                    @if($contactdetails->Plan == 'Monthly' && $contactdetails->Actual_plan == 'Basic')
                                            <p class="selectbtntext" data-id="plans-1">Ausgewählt</p>
                                        @else
                                            <p class="selectbtntext" data-id="plans-1">Auswählen</p>
                                        @endif
                                    </div>
                                </div>
                            </label>
                        </div>
                        <!-- Basic plan end -->
                        <!-- Basic plus plan -->
                        <div class="col-lg-4 col-md-6 ">
                            <label for="plans-2" class="plans-label plan-2">

                                @if($contactdetails->Plan == 'Monthly' && $contactdetails->Actual_plan == 'Basic Plus')
                                    <input type="radio" name="plans" id="plans-2" checked data-plan="Basic Plus" data-amount="39.99" data-id="plans-2">
                                @else
                                    <input type="radio" name="plans" id="plans-2" data-plan="Basic Plus" data-amount="39.99" data-id="plans-2">
                                @endif
                                <div class="plans" onclick="plan='Basic Plus',amount='39.99';">
                                    <div class="basicplanimg">
                                        <img src="{{asset('public/asset_front/assets/images/basic-plus.svg')}}" class="basic">
                                    </div>
                                    <h2>Basic Plus</h2>
                                    <p class="auflis"> Auflistung + Profilgestaltung</p>
                                    <div class="pricemonthly">
                                    <h1 id="plans2"> 39,99€</h1>
											<div class="cancelprice">
												<h5> /  / Pro Monat</h5>
											</div>
                                    </div>
                                    <div class="facilty">
                                        <div class="facility1">
                                            <img src="{{asset('public/asset_front/assets/images/id_card.svg')}}">
                                            <p>Auflistung auf reserved4you inkl. Profilgestaltung</p>
                                        </div>
                                        <div class="facility2">
                                            <img src="{{asset('public/asset_front/assets/images/computer.svg')}}">
                                            <p>Optimiert fur mobile Endgerate</p>
                                        </div>
                                        <div class="facility3">
                                            <img src="{{asset('public/asset_front/assets/images/support.svg')}}">
                                            <p>Support 24/7 - Live Chat, E-Mail</p>
                                        </div>
                                        <div class="facility3">
												<img src="{{asset('public/asset_front/assets/images/eigner.svg')}}">
												<p>eigener Admin Bereich</p>
											</div>
                                    </div>
                                    <div class="recruitmentfee">
											<p>Einstellungsgebühr : <span>50€</span>
											</p>
											<div class="recruitmentfee-info"><p>Kündigungsfrist:  <div class="cancelation-time"><span> 2 Wochen</span></div></div>
											</p>
										</div>
                                    <div class="selectbtn">
                                        @if($contactdetails->Plan == 'Monthly' && $contactdetails->Actual_plan == 'Basic Plus')
                                            <p class="selectbtntext" data-id="plans-2">Ausgewählt</p>
                                        @else
                                            <p class="selectbtntext" data-id="plans-2">Auswählen</p>
                                        @endif
                                    </div>
                                </div>
                            </label>
                        </div>
                        <!-- Basic plus plan end -->
                        <!-- Bussiness plan -->
                        <div class="col-lg-4 col-md-6 ">
                            <label for="plans-3" class="plans-label plan-3">
                                @if($contactdetails->Plan == 'Monthly' && $contactdetails->Actual_plan == 'Business')
                                    <input type="radio" name="plans" id="plans-3" checked data-plan="Business" data-amount="79.99" data-id="plans-3">
                                @else
                                    <input type="radio" name="plans" id="plans-3" data-plan="Business" data-amount="79.99" data-id="plans-3">
                                @endif
                                <div class="plans" onclick="plan='Business',amount='79.99';">
                                    <div class="basicplanimg">
                                        <img src="{{asset('public/asset_front/assets/images/business-plan.svg')}}" class="basic">
                                    </div>
                                    <h2>Business</h2>
                                    <p class="auflis">Auflistung + Profilgestaltung <br> + Buchungssystem</p>
                                    <div class="pricemonthly">
                                    <h1  id="plans3">79,99€ </h1>
											<div class="cancelprice">
												<h5> / Pro Monat</h5>
											</div>
                                    </div>
                                    <div class="facilty">
											<div class="facility1">
												<img src="{{asset('public/asset_front/assets/images/id_card.svg')}}">
												<p>Auflistung auf reserved4you</p>
											</div>
											<div class="facility2">
												<img src="{{asset('public/asset_front/assets/images/computer.svg')}}">
												<p>Optimiert für mobile Endgerät</p>
											</div>
											<div class="facility2">
												<img src="{{asset('public/asset_front/assets/images/profile.svg')}}">
												<p>24h E-Mail Support, Live Chat, Telefonsupport</p>
											</div>
											<div class="facility2">
												<img src="{{asset('public/asset_front/assets/images/reception.svg')}}">
												<p>eigener Admin Bereich</p>
											</div>
											<div class="facility3">
												<img src="{{asset('public/asset_front/assets/images/support.svg')}}">
												<p>Newslettermarketing</p>
											</div>
											<div class="facility4">
												<img src="{{asset('public/asset_front/assets/images/news-letter.svg')}}">
												<p>Werbung auf reserved4you + Social Media</p>
											</div>
											<div class="facility5">
												<img src="{{asset('public/asset_front/assets/images/buchu.svg')}}">
												<p>BUCHUNGSSYSTEM</p>
											</div>
                                            <div class="facility5">
												<img src="{{asset('public/asset_front/assets/images/manage.svg')}}">
												<p>Managementtools</p>
											</div>
											<div class="facility5">
												<img src="{{asset('public/asset_front/assets/images/koste.svg')}}">
												<p>kostenlose Schulung</p>
											</div>
											<div class="facility5">
												<img src="{{asset('public/asset_front/assets/images/indi-news.svg')}}">
												<p>individueller Newsletter</p>
											</div>
											<div class="facility5">
												<img src="{{asset('public/asset_front/assets/images/stat.svg')}}">
												<p>Statistiken</p>
											</div>
										</div>
                                        <div class="recruitmentfee">
											<p>Einstellungsgebühr : <span>100€ </span>
											</p>
											<div class="recruitmentfee-info"><p>Kündigungsfrist:  <div class="cancelation-time"><span> 2 Wochen</span></div></div>
											</p>
										</div>
                                    <div class="selectbtn">
                                    
                                        @if($contactdetails->Plan == 'Monthly' && $contactdetails->Actual_plan == 'Business')
                                            <p class="selectbtntext" data-id="plans-3">Ausgewählt</p>
                                        @else
                                            <p class="selectbtntext" data-id="plans-3">Auswählen</p>
                                        @endif
                                    </div>
                                </div>
                            </label>
                        </div>
                        <!-- Bussiness plan end -->
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                <div class="container chooseplan">
                    <div class="row">
                        <!-- Basic plan -->
                        <div class="col-lg-4">
                            <label for="plans-4" class="plans-label">
                                @if($contactdetails->Plan == 'Annually' && $contactdetails->Actual_plan == 'Basic')
                                    <input type="radio" name="plans" id="plans-4" checked data-plan="Basic" data-amount="0" data-id="plans-4">
                                @else
                                    <input type="radio" name="plans" id="plans-4" data-plan="Basic" data-amount="0" data-id="plans-4">
                                @endif
                                <div class="plans" onclick="plan='Basic',amount='0';">
                                    <div class="basicplanimg">
                                        <img src="{{asset('public/asset_front/assets/images/basic.svg')}}" class="basic">
                                    </div>
                                    <h2>Basic</h2>
                                    <p class="auflis">Auflistung </p>
                                    <div class="pricemonthly" >
											<h1>0€ </h1>
											<div class="cancelprice">
												<h5> / Pro Monat</h5>
											</div>
										</div>
                                        <div class="facilty">
											<div class="facility1">
												<img src="{{asset('public/asset_front/assets/images/id_card.svg')}}">
												<p>Auflistung auf reserved4you inkl. Profilgestaltung</p>
											</div>
											<div class="facility2">
												<img src="{{asset('public/asset_front/assets/images/computer.svg')}}">
												<p>Optimiert fur mobile Endgerate</p>
											</div>
											<div class="facility3">
												<img src="{{asset('public/asset_front/assets/images/support.svg')}}">
												<p>Support 24/7 - Live Chat, E-Mail</p>
											</div>
											<!-- <div class="facility4">
												<img src="{{asset('public/asset_front/assets/images/news.svg')}}">
												<p>Individueller Newsletter</p>
											</div>
											<div class="facility5">
												<img src="{{asset('public/asset_front/assets/images/megaphone.svg')}}">
												<p>Werbung auf reserved4you + Social Media</p>
											</div> -->
										</div>
										<div class="recruitmentfee">
											<p>Einstellungsgebühr : <span>0€ </span>
											</p>
											<p>Kündigungsfrist : <span>/</span>
											</p>
										</div>
                                    <div class="selectbtn">
                                        @if($contactdetails->Plan == 'Annually' && $contactdetails->Actual_plan == 'Basic')
                                            <p class="selectbtntext" data-id="plans-4">Ausgewählt</p>
                                        @else
                                            <p class="selectbtntext" data-id="plans-4">Auswählen</p>
                                        @endif
                                    </div>
                                </div>
                            </label>
                        </div>
                        <!-- Basic end -->
                        <!-- Basic plus plan -->
                        <div class="col-lg-4">
                            <label for="plans-5" class="plans-label">
                                @if($contactdetails->Plan == 'Annually' && $contactdetails->Actual_plan == 'Basic Plus')
                                    <input type="radio" name="plans" id="plans-5" checked data-plan="Basic Plus" data-amount="29.99" data-id="plans-5">
                                @else
                                    <input type="radio" name="plans" id="plans-5" data-plan="Basic Plus" data-amount="29.99" data-id="plans-5">
                                @endif
                                <div class="plans" onclick="plan='Basic Plus',amount='29.99';">
                                    <div class="basicplanimg">
                                        <img src="{{asset('public/asset_front/assets/images/basic-plus.svg')}}" class="basic">
                                    </div>
                                    <h2>Basic Plus</h2>
                                    <p class="auflis">Auflistung + Profilgestaltung</p>
                                    <div class="pricemonthly">
                                    <h1  id="plans5">29,99€ </h1>
											<div class="cancelprice">
												<!-- <h6>43,99€ </h6> -->
												<h5> / Pro Monat</h5>
											</div>
                                    </div>
                                    <div class="facilty">
											<div class="facility1">
												<img src="{{asset('public/asset_front/assets/images/id_card.svg')}}">
												<p> Auflistung auf reserved4you </p>
											</div>
											<div class="facility2">
												<img src="{{asset('public/asset_front/assets/images/computer.svg')}}">
												<p>Optimiert für mobile Endgeräte</p>
											</div>
											<div class="facility3">
												<img src="{{asset('public/asset_front/assets/images/support.svg')}}">
												<p>48h E-Mail Support, Live Chat</p>
											</div>
											<div class="facility3">
												<img src="{{asset('public/asset_front/assets/images/eigner.svg')}}">
												<p>eigener Admin Bereich</p>
											</div>

										</div>
                                        <div class="recruitmentfee">
											<p>Einstellungsgebühr : <span>50€</span>
											</p>
											<div class="recruitmentfee-info"><p>Kündigungsfrist:  <div class="cancelation-time"><span> 4 Wochen</span></div></div>
											</p>
										</div>
                                    <div class="selectbtn">
                                        
                                        @if($contactdetails->Plan == 'Annually' && $contactdetails->Actual_plan == 'Basic Plus')
                                            <p class="selectbtntext" data-id="plans-5">Ausgewählt</p>
                                        @else
                                            <p class="selectbtntext" data-id="plans-5">Auswählen</p>
                                        @endif
                                    </div>
                                </div>
                            </label>
                        </div>
                        <!-- Basic plus plan end -->
                        <!-- Bussiness plan -->
                        <div class="col-lg-4">
                            <label for="plans-6" class="plans-label">
                                @if($contactdetails->Plan == 'Annually' && $contactdetails->Actual_plan == 'Business')
                                    <input type="radio" name="plans" id="plans-6" checked data-plan="Business" data-amount="69.99" data-id="plans-6">
                                @else
                                    <input type="radio" name="plans" id="plans-6" data-plan="Business" data-amount="69.99" data-id="plans-6">
                                @endif
                                <div class="plans" onclick="plan='Business',amount='69.99';">
                                    <div class="basicplanimg">
                                        <img src="{{asset('public/asset_front/assets/images/business-plan.svg')}}" class="basic">
                                    </div>
                                    <h2>Business</h2>
                                    <p class="auflis"> Auflistung + Profilgestaltung <br> + Buchungssystem</p>
										<div class="pricemonthly">
                                        <h1  id="plans6">69,99€ </h1>
											<div class="cancelprice">
												<!-- <h6>83,99€ </h6> -->
												<h5> / Pro Monat</h5>
											</div>
										</div>
										<div class="facilty">
											<div class="facility1">
												<img src="{{asset('public/asset_front/assets/images/id_card.svg')}}">
												<p>Auflistung auf reserved4you</p>
											</div>
											<div class="facility2">
												<img src="{{asset('public/asset_front/assets/images/computer.svg')}}">
												<p>Optimiert für mobile Endgeräte</p>
											</div>
											<div class="facility2">
												<img src="{{asset('public/asset_front/assets/images/profile.svg')}}">
												<p>24h E-Mail Support, Live Chat, Telefonsupport</p>
											</div>
											<div class="facility2">
												<img src="{{asset('public/asset_front/assets/images/reception.svg')}}">
												<p>eigener Admin Bereich</p>
											</div>
											<div class="facility3">
												<img src="{{asset('public/asset_front/assets/images/support.svg')}}">
												<p>Newslettermarketing</p>
											</div>
											<div class="facility4">
												<img src="{{asset('public/asset_front/assets/images/news-letter.svg')}}">
												<p>Werbung auf reserved4you + Social Media</p>
											</div>
											<div class="facility5">
												<img src="{{asset('public/asset_front/assets/images/buchu.svg')}}">
												<p>BUCHUNGSSYSTEM</p>
											</div>
                                            <div class="facility5">
												<img src="{{asset('public/asset_front/assets/images/manage.svg')}}">
												<p>Managementtools</p>
											</div>
											<div class="facility5">
												<img src="{{asset('public/asset_front/assets/images/koste.svg')}}">
												<p>kostenlose Schulung</p>
											</div>
											<div class="facility5">
												<img src="{{asset('public/asset_front/assets/images/indi-news.svg')}}">
												<p>individueller Newsletter</p>
											</div>
											<div class="facility5">
												<img src="{{asset('public/asset_front/assets/images/stat.svg')}}">
												<p>Statistiken</p>
											</div>
										</div>
										<div class="recruitmentfee">
											<p>Einstellungsgebühr : <span>100€ </span>
											</p>
											<div class="recruitmentfee-info"><p>Kündigungsfrist:  <div class="cancelation-time"><span> 4 Wochen</span></div></div>
											</p>
                                    <div class="selectbtn">
                                        @if($contactdetails->Plan == 'Annually' && $contactdetails->Actual_plan == 'Business')
                                            <p class="selectbtntext" data-id="plans-6">Ausgewählt</p>
                                        @else
                                            <p class="selectbtntext" data-id="plans-6">Auswählen</p>
                                        @endif
                                    </div>
                                </div>
                            </label>
                        </div>
                        <!-- Bussiness plan end -->
                    </div>
                </div>
            </div>
        </div>
        <p class="extra-text">*Alle Preise zzgl. Mwst.</p>
        <div class="nextprevious servicebtns letscountinuesbtn nextprevious"><a href="{{url('contactdetail')}}"
                                                                                class="previous" type="btn">Zurück</a>
            <a href="javascript:void(0)" class="next" type="btn" onclick="plan_store()">Weiter</a>
        </div>

    </div>
</section>
<script src="{{asset('public/asset_front/assets/js/jquery.min.js')}}"></script>
<script src="{{asset('public/asset_front/assets/js/bootstrap.bundle.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="{{asset('public/asset_front/assets/js/owl.carousel.min.js')}}"></script>
<script src="{{asset('public/asset_front/assets/js/bootstrap-datepicker.min.js')}}"></script>
<script src="{{asset('public/asset_front/assets/js/custom3.js')}}"></script>

<script>
    var plan_type = "{{$contactdetails->Plan == 'Annually' ? 'Annually' : 'Monthly' }}"
    function plan_store() {
        var URL = '{{URL::to('plan/update')}}';
        var id = '{{$contactdetails->id}}';
        var plan = $('input[name="plans"]:checked').data('plan');
        var amount = $('input[name="plans"]:checked').data('amount');

        $.ajax({
            type: 'post',
            url: URL + '/' + id,
            data: {
                'plan_type': plan_type,
                'plan': plan,
                'amount': amount
            },
            success: function (data) {
                if (data.status == 'true') {
                    window.location.replace("{{url('contact')}}");
                }
            }
        });
    }

    $('.plans-label').click(function() {
			
			var inputId = $(this).children("input:first").data("id");
			// alert(inputId);
			var textId = $(this).find('.selectbtntext').data("id");
			// alert(textId);
           
                
                if (inputId == textId) {
                    $('.selectbtntext').text('Ausgewählt ');
                    $(this).find('.selectbtntext').text('Auswählen')
                }
                else{
                    ('.selectbtntext').text('Ausgewählt ')
                }
        
		});
</script>

<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
</body>

</html>
