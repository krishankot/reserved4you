<!doctype html>
<html dir="ltr" lang="en-US">

<head>
    <title>Extra Service</title>
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
    <style>
        p.extra-text {
            text-align: end;
            margin-top: 6px;
            font-size: 15px;
            font-weight: 500;
        }
        .selectitbtn {
            margin-top: auto;
        }

        .selectitbtn p {
            padding: 7px 19px;
            display: block;
        }

        .monthpriceplan {
            min-height: 550px;
            display: flex;
            flex-direction: column;
        }
    </style>
</head>
<script>
    var feature_plan_type = 'Monthly';
    var marketing_plan_type = 'Monthly';
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
</header>
<section class="contactdetail  extraservicesection">
    <div class="progress">
        <div class="progress-bar progressbarr4u" role="progressbar" style="width: 30%;" aria-valuenow="25"
             aria-valuemin="0" aria-valuemax="100"></div>
    </div>
    <div class="container">
        <div class="recomanded">
            <h2>Zusatzleistungen</h2>
            <p>*Mehrfachauswahl</p>
        </div>

        <div class="servicetype">
            <div class="service-type-wrap">
                <ul class="nav nav-pills service-nav" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation" onclick="Service_name='Features';">
                        <a class="nav-link service active" id="pills-home-tab" data-toggle="pill" href="#pills-home"
                           role="tab" aria-controls="pills-home" aria-selected="true"> Extra Services</a>
                    </li>
                    <li class="nav-item" role="presentation2" onclick="Service_name='Marketing';">
                        <a class="nav-link service" id="pills-profile-tab" data-toggle="pill" href="#pills-profile"
                           role="tab" aria-controls="pills-profile" aria-selected="false">Marketing</a>
                    </li>
                    <li class="nav-item" role="presentation3" onclick="Service_name='Hardware';">
                        <a class="nav-link service" id="pills-hardware-tab" data-toggle="pill" href="#pills-hardware"
                           role="tab" aria-controls="pills-hardware" aria-selected="false">Hardware</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="tab-content servicefeaturmark" id="pills-tabContent">
            <div class="tab-pane fade show active feature" id="pills-home" role="tabpanel"
                 aria-labelledby="pills-home-tab">
                <div class="container  chooseplan1">
                    <div class="owl-carousel owl-theme chooseservices">
                        <div class="item payadvance">
                            <div class="monthly_annually_plans">
                                <div class="monthly_annually_plans-wrap">
                                    <label for="plans-1" class="plans-label paylbl">
                                        <input type="checkbox" name="featur_plans" id="plans-1" class="features"
                                               data-id="f1"
                                               data-name="Onlinezahlungen" data-amount="2.5%" data-plan="Monthly">
                                        <div class="monthpriceplan">
                                            <div class="monthprice">
                                                <h2>2.5%<span>/ Per Onlinezahlung</span></h2>
                                            </div>
                                            <h3 class="advance">Onlinezahlungen </h3>
                                            <ul class="nav nav-pills payment" id="pills-tab" role="tablist">
                                                <li class="nav-item" role="presentation"
                                                    onclick="feature_plan_type='Monthly';">
                                                    <a class="nav-link monthlyplan active" id="pills-home-tab"
                                                       data-toggle="pill" href="#pills-home-01" role="tab" data-id="f1"
                                                       data-name="Monthly"
                                                       aria-controls="pills-home" aria-selected="true">Monatlich</a>
                                                </li>
                                                <li class="nav-item" role="presentation"
                                                    onclick="feature_plan_type='Annually';">
                                                    <a class="nav-link monthlyplan" id="pills-pay-tab"
                                                       data-toggle="pill" href="#pills-pay-01" role="tab" data-id="f1"
                                                       data-name="Annually"
                                                       aria-controls="pills-profile" aria-selected="false">Jährlich</a>
                                                </li>
                                            </ul>
                                            <div class="payimg">
                                                <img src="{{asset('public/asset_front/assets/images/pay.svg')}}">
                                                <p>Ihre Kunden haben die Möglichkeit ihre gebuchten Services
                                                   vorher schon online zu bezahlen, mit allen gängigen
                                                   Zahlungsmöglichkeiten (PayPal, Klarna, SofortÜberweisung,
                                                   etc.), dennoch besteht auch die Möglichkeit vor Ort zu zahlen.</p>
                                            </div>
                                            <div class="selectitbtn" onc>
                                                <p class="selectbtntext" data-id="f1">Auswählen</p>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="item payadvance">
                            <div class="monthly_annually_plans">
                                <div class="monthly_annually_plans-wrap">
                                    <label for="plans-2" class="plans-label paylbl">
                                        <input type="checkbox" name="featur_plans" id="plans-2" class="features"
                                               data-id="f2"
                                               data-name="Rabatte für Kunden" data-amount="15" data-plan="Monthly">
                                        <div class="monthpriceplan">
                                            <div class="monthprice">
                                                <h2><label class="monthprice_value" data-id="f2">15.00€</label><span>/ Monat</span></h2>
                                            </div>
                                            <h3 class="advance">Rabatte für Kunden</h3>
                                            <ul class="nav nav-pills payment" id="pills-tab" role="tablist">
                                                <li class="nav-item" role="presentation">
                                                    <a class="nav-link monthlyplan active" id="pills-home-tab"
                                                       data-toggle="pill" href="#pills-home-02" role="tab" data-id="f2"
                                                       data-name="Monthly" data-value="15.00"
                                                       aria-controls="pills-home" aria-selected="true">Monatlich</a>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <a class="nav-link monthlyplan" id="pills-pay-tab"
                                                       data-toggle="pill" href="#pills-pay-02" role="tab" data-id="f2"
                                                       data-name="Annually" data-value="7.50"
                                                       aria-controls="pills-profile" aria-selected="false">Jährlich</a>
                                                </li>
                                            </ul>
                                            <div class="payimg disimg">
                                                <img src="{{asset('public/asset_front/assets/images/disccount.svg')}}">
                                                <p>Sie haben die Möglichkeit Ihren Kunden auf
                                                   Dienstleistungen Rabatte anzubieten (Rabatte zum
                                                   umsatzschwächeren Zeiten, um den Laden zu füllen).</p>
                                                <p>Die Rabatte sind jederzeit veränderbar und können neu
                                                   hinzugefügt werden</p>
                                            </div>
                                            <div class="selectitbtn">
                                                <p class="selectbtntext" data-id="f2">Auswählen</p>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="item payadvance">
                            <div class="monthly_annually_plans">
                                <div class="monthly_annually_plans-wrap">
                                    <label for="plans-3" class="plans-label paylbl">
                                        <input type="checkbox" name="featur_plans" id="plans-3" class="features"
                                               data-id="f3"
                                               data-name="Empfehlungslisten" data-amount="30" data-plan="Monthly">
                                        <div class="monthpriceplan">
                                            <div class="monthprice">
                                            <h2><label class="monthprice_value" data-id="f3">30.00€</label><span>/ Monat</span></h2>
                                            </div>
                                            <h3 class="advance">Empfehlungslisten</h3>
                                            <ul class="nav nav-pills payment" id="pills-tab" role="tablist">
                                                <li class="nav-item" role="presentation">
                                                    <a class="nav-link monthlyplan active" id="pills-home-tab"
                                                       data-toggle="pill" href="#pills-home-03" role="tab" data-id="f3"
                                                       data-name="Monthly" data-value="30.00"
                                                       aria-controls="pills-home" aria-selected="true">Monatlich</a>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <a class="nav-link monthlyplan" id="pills-pay-tab"
                                                       data-toggle="pill" href="#pills-pay-03" role="tab" data-id="f3"
                                                       data-name="Annually" data-value="20.00"
                                                       aria-controls="pills-profile" aria-selected="false">Jährlich</a>
                                                </li>
                                            </ul>
                                            <div class="payimg recomimg">
                                                <img src="{{asset('public/asset_front/assets/images/recommandation.svg')}}">
                                                <p>Um eine größere Reichweite zu generieren , haben Sie die Möglichkeit in unseren
                                                   Empfehlungslisten aufgelistet zu sein. Diese findet man in jedem Bereich auf unserer
                                                    Webseite.</p>
                                            </div>
                                            <div class="selectitbtn">
                                                <p class="selectbtntext" data-id="f3">Auswählen</p>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="item payadvance">
                            <div class="monthly_annually_plans">
                                <div class="monthly_annually_plans-wrap">
                                    <label for="plans-4" class="plans-label paylbl">
                                        <input type="checkbox" name="featur_plans" id="plans-4" class="features"
                                               data-id="f4"
                                               data-name="Pay in advance 2" data-amount="40" data-plan="Monthly">
                                        <div class="monthpriceplan">
                                            <div class="monthprice">
                                                <h2>40€<span>/Monat</span></h2>
                                            </div>
                                            <h3 class="advance">Pay in advance</h3>
                                            <ul class="nav nav-pills payment" id="pills-tab" role="tablist">
                                                <li class="nav-item" role="presentation"><a
                                                        class="nav-link monthlyplan active" id="pills-home-tab"
                                                        data-id="f4" data-name="Monthly"
                                                        data-toggle="pill" href="#pills-home-1" role="tab"
                                                        aria-controls="pills-home" aria-selected="true">Monatlich</a>
                                                </li>
                                                <li class="nav-item" role="presentation"><a
                                                        class="nav-link monthlyplan" id="pills-pay-tab" data-id="f4"
                                                        data-name="Annually"
                                                        data-toggle="pill" href="#pills-pay-1" role="tab"
                                                        aria-controls="pills-profile" aria-selected="false">Jährlich</a>
                                                </li>
                                            </ul>
                                            <div class="tab-content" id="pills-tabContent">
                                                <div class="tab-pane fade show active" id="pills-home-1" role="tabpanel"
                                                     aria-labelledby="pills-home-tab">
                                                    <div class="payimg">
                                                        <img src="{{asset('public/asset_front/assets/images/pay.svg')}}">
                                                        <p>Ihre Kunden haben die Möglichkeit ihre gebuchten Services
                                                   vorher schon online zu bezahlen, mit allen gängigen
                                                   Zahlungsmöglichkeiten (PayPal, Klarna, SofortÜberweisung,
                                                   etc.), dennoch besteht auch die Möglichkeit vor Ort zu zahlen.r</p>
                                                    </div>
                                                    <div class="selectitbtn">
                                                        <p>Select it</p>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
            <div class="tab-pane fade show marketing" id="pills-profile" role="tabpanel"
                 aria-labelledby="pills-profile-tab">
                <div class="container  chooseplan1">
                    <div class="owl-carousel owl-theme chooseservices">
                        <div class="item payadvance">
                            <div class="monthly_annually_plans">
                                <div class="monthly_annually_plans-wrap">
                                    <label for="plans-5" class="plans-label paylbl">
                                        <input type="checkbox" name="marketing_plans" id="plans-5" class="features"
                                               data-id="f5"
                                               data-name="Pay in advance" data-amount="10" data-plan="Monthly">
                                        <div class="monthpriceplan">
                                            <div class="monthprice coming">
                                            <h2>Coming soon</h2>
                                            </div>
                                            <h3 class="advance">Individueller Newsletter </h3>

                                            <div class="tab-content" id="pills-tabContent">
                                                <div class="tab-pane fade show active" id="pills-home-1" role="tabpanel"
                                                     aria-labelledby="pills-home-tab">
                                                    <div class="payimg">
                                                        <img src="{{asset('public/asset_front/assets/images/news.svg')}}">
                                                        <!-- <p>Lorem ipsum dolor sit amet consectetur adipiscing eiusmod
                                                            tempor</p>   -->
                                                          
                                                    </div>
                                                    <!-- <div class="selectitbtn">
                                                        <p>Select it</p>
                                                    </div> -->
                                                </div>
                                                <div class="tab-pane fade" id="pills-pay-1" role="tabpanel"
                                                     aria-labelledby="pills-profile-tab">
                                                    <div class="payimg">
                                                    <img src="{{asset('public/asset_front/assets/images/news.svg')}}">
                                                        <!-- <p>Lorem ipsum dolor sit amet consectetur adipiscing eiusmod
                                                            tempor</p>   -->
                                                          
                                                    </div>
                                                    <!-- <div class="selectitbtn">
                                                        <p>Select it</p>
                                                    </div> -->
                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="item payadvance">
                            <div class="monthly_annually_plans">
                                <div class="monthly_annually_plans-wrap">
                                    <label for="plans-6" class="plans-label paylbl">
                                        <input type="checkbox" name="marketing_plans" id="plans-6" class="features"
                                               data-id="f6"
                                               data-name="Discount for customers" data-amount="20" data-plan="Monthly">
                                        <div class="monthpriceplan">
                                            <div class="monthprice coming">
                                                <h2>Coming soon</h2>
                                            </div>
                                            <h3 class="advance">Social Media Paket</h3>

                                            <div class="tab-content" id="pills-tabContent">
                                                <div class="tab-pane fade show active" id="pills-home-1" role="tabpanel"
                                                     aria-labelledby="pills-home-tab">
                                                    <div class="payimg">
                                                         <img src="{{asset('public/asset_front/assets/images/social-media.svg')}}">
                                                        <!-- <p>Lorem ipsum dolor sit amet consectetur adipiscing eiusmod
                                                            tempor</p>  -->
                                                          
                                                    </div>
                                                    <!-- <div class="selectitbtn">
                                                        <p>Select it</p>
                                                    </div> -->
                                                </div>
                                                <div class="tab-pane fade" id="pills-pay-1" role="tabpanel"
                                                     aria-labelledby="pills-pay-tab">
                                                    <div class="payimg">
                                                         <img src="{{asset('public/asset_front/assets/images/social-media.svg')}}">
                                                        <!-- <p>Lorem ipsum dolor sit amet consectetur adipiscing eiusmod
                                                            tempor</p> 
                                                           -->
                                                    </div>
                                                    <!-- <div class="selectitbtn">
                                                        <p>Select it</p>
                                                    </div> -->
                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="item payadvance">
                            <div class="monthly_annually_plans">
                                <div class="monthly_annually_plans-wrap">
                                    <label for="plans-7" class="plans-label paylbl">
                                        <input type="checkbox" name="marketing_plans" id="plans-7" class="features"
                                               data-id="f7"
                                               data-name="Recommerdation lists" data-amount="30" data-plan="Monthly">
                                        <div class="monthpriceplan">
                                            <div class="monthprice coming">
                                            <h2>Coming soon</h2>
                                            </div>
                                            <h3 class="advance">Eigene Webseite </h3>

                                            <div class="tab-content" id="pills-tabContent">
                                                <div class="tab-pane fade show active" id="pills-home-1" role="tabpanel"
                                                     aria-labelledby="pills-home-tab">
                                                    <div class="payimg">
                                                         <img
                                                            src="{{asset('public/asset_front/assets/images/own-website.svg')}}">
                                                        <!-- <p>Lorem ipsum dolor sit amet consectetur adipiscing eiusmod
                                                            tempor</p>  -->
                                                           
                                                    </div>
                                                    <!-- <div class="selectitbtn">
                                                        <p>Select it</p>
                                                    </div> -->
                                                </div>
                                                <div class="tab-pane fade" id="pills-pay-1" role="tabpanel"
                                                     aria-labelledby="pills-pay-tab">
                                                    <div class="payimg">
                                                         <img
                                                            src="{{asset('public/asset_front/assets/images/own-website.svg')}}">
                                                        <!-- <p>Lorem ipsum dolor sit amet consectetur adipiscing eiusmod
                                                            tempor</p>  -->
                                                           
                                                    </div>
                                                    <!-- <div class="selectitbtn">
                                                        <p>Select it</p>
                                                    </div> -->
                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="item payadvance">
                            <div class="monthly_annually_plans">
                                <div class="monthly_annually_plans-wrap">
                                    <label for="plans-8" class="plans-label paylbl">
                                        <input type="checkbox" name="marketing_plans" id="plans-8" class="features"
                                               data-id="f8"
                                               data-name="Pay in advance 2" data-amount="40" data-plan="Monthly">
                                        <div class="monthpriceplan">
                                            <div class="monthprice coming">
                                            <h2>Coming soon</h2>
                                            </div>
                                            <h3 class="advance">Pay in advance</h3>

                                            <div class="tab-content" id="pills-tabContent">
                                                <div class="tab-pane fade show active" id="pills-home-1" role="tabpanel"
                                                     aria-labelledby="pills-home-tab">
                                                    <div class="payimg">
                                                        <img src="{{asset('public/asset_front/assets/images/pay.svg')}}">
                                                        <!-- <p>Lorem ipsum dolor sit amet consectetur adipiscing eiusmod
                                                            tempor</p> 
                                                             -->
                                                    </div>
                                                  
                                                </div>
                                                <div class="tab-pane fade" id="pills-pay-1" role="tabpanel"
                                                     aria-labelledby="pills-pay-tab">
                                                    <div class="payimg">
                                                       <img src="{{asset('public/asset_front/assets/images/pay.svg')}}">
                                                         <!-- <p>Lorem ipsum dolor sit amet consectetur adipiscing eiusmod
                                                            tempor</p> -->
                                                            
                                                    </div>
                                                   
                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade show hardware" id="pills-hardware" role="tabpanel"
                 aria-labelledby="pills-hardware-tab">
                <div class="container  chooseplan1">
                    <div class="owl-carousel owl-theme chooseservices">
                        <div class="item payadvance">
                            <div class="monthly_annually_plans">
                                <div class="monthly_annually_plans-wrap">
                                    <label for="plans-09" class="plans-label paylbl">
                                        <input type="checkbox" name="hardware_plans" id="plans-09" class="features"
                                               data-id="f9"
                                               data-name="APPLE iPad" data-amount="294.11" data-plan="onetime">
                                        <div class="monthpriceplan">
                                            <div class="monthprice">
                                                <h2 class="hardware-price">294,11€</h2>
                                            </div>
                                            <h3 class="advance">APPLE iPad</h3>

                                            </ul>
                                            <div class="tab-content" id="pills-tabContent">
                                                <div class="tab-pane fade show active" id="pills-home-1" role="tabpanel"
                                                     aria-labelledby="pills-home-tab">
                                                    <div class="payimg">
                                                        <img
                                                            src="{{asset('public/asset_front/assets/images/hardware-phone.svg')}}">
                                                        <p>Sie haben die Möglichkeit ein Tablet über uns zu kaufen, um alle Funktionen noch effizienter nutzen zu können. Apple iPad 8. Generation 2020, Speicherplatz 32GB, 10,2 Zoll</p>

                                                    </div>
                                                    <div class="selectitbtn">
                                                        <p class="selectbtntext" data-id="f9">Auswählen</p>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <p class="extra-text">*Alle Preise zzgl. Mwst.</p>
        <div class="letscountinuesbtn nextprevious servicebtns"><a href="{{url('recom-plan')}}" class="previous"
                                                                   type="btn">Zurück</a>

            <a href="#" class="next" type="btn" onclick="extra_service_store()">Weiter</a>
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

    $(document).on('click', '.monthlyplan', function () {
        var id = $(this).data('id');
        var name = $(this).data('name');
        var value = $(this).data('value');

        $('.monthprice_value[data-id='+id+']').text(value +'€')
        $('.features[data-id=' + id + ']').attr('data-plan', name);
        $('.features[data-id=' + id + ']').attr('data-amount', value);
    })

    function extra_service_store() {
        //debugger;
        var Service_plan = [];
        var plan_type = [];
        var Service_amount = [];
        $('input[name="featur_plans"]:checked').each(function () {
            var fid = $(this).data('id');
            Service_plan.push($(this).data('name'));
            plan_type.push($(this).data('plan'));
            Service_amount.push($(this).data('amount'));
        });

        var m_service_plan = [];
        var m_plan_type = [];
        var m_service_amount = [];
        $('input[name="marketing_plans"]:checked').each(function () {
            var mid = $(this).data('id');
            m_service_plan.push($(this).data('name'));
            m_plan_type.push($(this).data('plan'));
            m_service_amount.push($(this).data('amount'));
        });

        var h_service_plan = [];
        var h_plan_type = [];
        var h_service_amount = [];
        $('input[name="hardware_plans"]:checked').each(function () {
            var hid = $(this).data('id');
            h_service_plan.push($(this).data('name'));
            h_plan_type.push($(this).data('plan'));
            h_service_amount.push($(this).data('amount'));
        });
        // console.log($('input[name="featur_plans"]:checked').serialize());

        $.ajax({
            type: 'post',
            url: '{{ URL::to("extra_service_store")}}',
            data: {
                '_token':"{{csrf_token()}}",
                'feature_plan': Service_plan,
                'marketing_plan': m_service_plan,
                'feature_plan_type': plan_type,
                'marketing_plan_type': m_plan_type,
                'feature_amount': Service_amount,
                'marketing_amount': m_service_amount,
                'hardware_plan': h_service_plan,
                'hardware_plan_type': h_plan_type,
                'hardware_amount': h_service_amount,
            },
            success: function (data) {
                if (data.status == 'true') {
                    window.location.replace("{{url('contract')}}");
                }

            }
        });
    }
</script>

<script type="text/javascript">
    $.ajaxSetup({

        headers: {

            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }

    });

    // $('.plans-label').click(function() {
			
	// 		var inputId = $(this).children("input:first").data("id");
	// 		// alert(inputId);
	// 		var textId = $(this).find('.selectbtntext').data("id");
	// 		// alert(textId);
	// 		if (inputId == textId) {
	// 			$('.selectbtntext').text('Auswählen ');
	// 			$(this).find('.selectbtntext').text('Ausgewählt')
	// 		}
	// 		else{
	// 			('.selectbtntext').text('Auswählen ')
	// 		}
	// 	});
</script>
</body>

</html>
