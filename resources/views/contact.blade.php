<!doctype html>
<html dir="ltr" lang="en-US">

<head>
    <title>Contract Details</title>
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
    .paymenticon img {
        max-width: 62px;
        max-height: 62px;
    }
    </style>
</head>

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
<section class="contactdetail extraservices summrysection">
    <div class="progress">
        <div class="progress-bar progressbarr4u" role="progressbar" style="width: 90%;" aria-valuenow="25"
             aria-valuemin="0" aria-valuemax="100"></div>
    </div>
    <div class="container">
        <div class="recomanded">
            <h2>Zusammenfassung</h2>
        </div>
        <div class="servicetype">
            <div class="service-type-wrap">
                <ul class="nav nav-pills summary" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation"><a class="nav-link service"
                                                                href="{{url('contact/edit/'.$storedetails->id)}}"
                                                                role="tab" aria-selected="true">Kontakt</a>
                    </li>
                    <li class="nav-item" role="presentation"><a class="nav-link service"
                                                                href="{{url('plan/edit/'.$storedetails->id)}}"
                                                                role="tab" aria-selected="false">Pläne</a>
                    </li>
                    <li class="nav-item" role="presentation"><a class="nav-link service "
                                                                href="{{url('extraservices/update/'.$storedetails->id)}}"
                                                                role="tab" aria-selected="true">Zusatzleistungen</a>
                    </li>
                    <li class="nav-item" role="presentation"><a class="nav-link service"
                                                                href="{{url('/contract/edit/'.$storedetails->id)}}"
                                                                role="tab" aria-selected="false">Vertragslaufzeit</a>
                    </li>
                    <li class="nav-item" role="presentation"><a class="nav-link service"
                                                                href="{{url('/payment/edit/'.$storedetails->id)}}"
                                                                role="tab" aria-selected="true">Zahlungsbedingungen</a>
                    </li>
                    <li class="nav-item" role="presentation"><a class="nav-link service"
                                                                href="{{url('/finance/edit/'.$storedetails->id)}}"
                                                                role="tab" aria-selected="false">Finanzen</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="tab-content servicefeaturmark" id="pills-tabContent">
            <div class="tab-pane fade show active feature" id="pills-contact" role="tabpanel"
                 aria-labelledby="pills-contact-tab">
                <div class="contactdetails" id="contactdetail">
                    <div class="details">
                        <h2>Kontaktdetails</h2>
                        <div class="contactedit">
                            <a href="{{url('contact/edit/'.$storedetails->id)}}">
                                <img src="{{asset('public/asset_front/assets/images/Edit.svg')}}">
                            </a>
                        </div>
                    </div>
                    <div class="contactinformation">
                        <ul class="storename">
                            <li><span>Name des Geschäfts</span>
                                <p>{{$storedetails->storename}}</p>
                            </li>
                            <li class="storename"><span>Vollständiger Name</span>
                                <p>{{$storedetails->firstname}} {{$storedetails->Lastname}}</p>
                            </li>
                            
                        <!-- <li class="storename"><span>Mobile Number</span>
                                <p>{{$storedetails->Phone}}</p>
                            </li> -->
                            <li><span>Adresse</span>
                                <p>{{$storedetails->Address}}</p>
                            </li>
                            <li class="storename"><span>Postleitzahl</span>
                                <p>{{$storedetails->Zipcode}}</p>
                            </li>
                            <li><span> E-Mail Adresse</span>
                                <p>{{$storedetails->Email}}</p>
                            </li>
                        </ul>
                    </div>
                </div>
                <div style="display: none">{{$total = 0}}{{$stotal = 0}}{{$online = 'no'}}</div>
                <div class="contactdetails recomm-plan" id="recom-plan">
                    <div class="details re-plans">
                        <h2>Pakete</h2>
                        <ul class="nav nav-pills payment summrypayment" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation"><a class="nav-link monthlyplan monthpayment active"
                                                                        id="pills-home-tab" data-toggle="pill"
                                                                        href="#pills-home-1" role="tab"
                                                                        aria-controls="pills-home" aria-selected="true">Monatliche Zahlung</a>
                            </li>
                            <li class="nav-item" role="presentation"><a class="nav-link monthlyplan annual-payment" id="pills-pay-tab"
                                                                        data-toggle="pill" href="#pills-pay-1"
                                                                        role="tab" aria-controls="pills-profile"
                                                                        aria-selected="false">Einmalige Zahlung</a>
                            </li>
                        </ul>
                        <div class="contactedit">
                            <a href="{{url('plan/edit/'.$storedetails->id)}}">
                                <img src="{{asset('public/asset_front/assets/images/Edit.svg')}}">
                            </a>
                        </div>
                    </div>
                    <div class="recomm-plan-info">
                        <div class="rocommicon">
                                @if($storedetails->Actual_plan == 'Basic')
                                
                                <img src="{{asset('public/asset_front/assets/images/basic.svg')}}" class="basic">
                                @elseif($storedetails->Actual_plan == 'Basic Plus')
                                    <img src="{{asset('public/asset_front/assets/images/basic-plus.svg')}}">
                                @elseif($storedetails->Actual_plan == 'Business Plan')
                                    <img src="{{asset('public/asset_front/assets/images/business-plan.svg')}}">
                                @endif
                            
                        </div>
                        <div class="annuallyplans"><span>{{$storedetails->Plan}}</span>
                            <p>{{$storedetails->Actual_plan}}</p>
                        </div>
                        <div style="display: none">{{$total += $storedetails->plan_amount}}</div>
                        <nav aria-label="breadcrumb " class="permonthprice">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">{{$storedetails->plan_amount}}€</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">pro Monat</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <p class="text-right mt-2">*Alle Preise zzgl. Mwst.</p>
                <div class="contactdetails recomm-plan" id="services">
                    <div class="details re-plans">
                        <h2>Zusatzleistungen</h2>

                        <div class="contactedit">
                            <a href="{{url('extraservices/update/'.$storedetails->id)}}">
                                <img src="{{asset('public/asset_front/assets/images/Edit.svg')}}">
                            </a>
                        </div>
                    </div>
                   
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home-1" role="tabpanel"
                             aria-labelledby="pills-home-tab">
                            @if(count($extraservice) > 0 )
                                @foreach($extraservice as $row)
                                    <div class="advance-payment-summry">
                                        <div class="paymenticon">
                                            @if($row->Service_plan == 'Onlinezahlungen')
                                            <img src="{{asset('public/asset_front/assets/images/pay.svg')}}">
                                            @elseif($row->Service_plan == 'Rabatte für Kunden')
                                            <img src="{{asset('public/asset_front/assets/images/disccount.svg')}}">
                                            @elseif($row->Service_plan == 'Empfehlungslisten')
                                            <img src="{{asset('public/asset_front/assets/images/recommandation.svg')}}">
                                            @endif
                                        </div>
                                        <div class="advance-payment-features">{{$row->Service_name}}
                                            <span></span>
                                            <p>{{$row->Service_plan}}</p>
                                        </div>
                                        <nav aria-label="breadcrumb " class="permonthprice">
                                            <ol class="breadcrumb">
                                                <li class="breadcrumb-item"><a
                                                        href="#">{{$row->Service_amount}}
                                                        @if($row->Service_amount != '2.5%')
                                                        €
                                                        @endif</a>
                                                </li>
                                                <li class="breadcrumb-item active" aria-current="page">@if($row->Service_amount != '2.5%')pro Monat @else Per Onlinezahlung @endif</li>
                                            </ol>
                                        </nav>
                                        @if($row->Service_amount != '2.5%')
                                        <div style="display: none">{{$total += $row->Service_amount}}</div>
                                        @endif
                                        @if($row->Service_amount == '2.5%')
                                        <div style="display: none">{{$online = 'yes'}}</div>
                                        @endif
                                        <div class="delicon">
                                            <a href="javascript:void(0)" data-id="{{$row->id}}" data-value="feature"
                                               class="delete_service">
                                                <img src="{{asset('public/asset_front/assets/images/Delete.svg')}}">
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                            @if(count($marketing) > 0 )
                                @foreach($marketing as $row)
                                    <div class="advance-payment-summry">

                                        <div class="paymenticon">
                                            <img src="{{asset('public/asset_front/assets/images/discounts.svg')}}">
                                        </div>
                                        <div class="advance-payment-features"><span>{{$row->Service_name}}</span>
                                            <p>{{$row->Service_plan}}</p>
                                        </div>
                                        <nav aria-label="breadcrumb " class="permonthprice">
                                            <ol class="breadcrumb">
                                                <li class="breadcrumb-item"><a href="#">{{$row->Service_amount}}
                                                        €</a>
                                                </li>
                                                <li class="breadcrumb-item active" aria-current="page">pro Monat</li>
                                            </ol>
                                        </nav>
                                        <div style="display: none">{{$total += $row->Service_amount}}</div>
                                        <div class="delicon">
                                            <a href="javascript:void(0)" data-id="{{$row->id}}" data-value="marketing"
                                               class="delete_service">
                                                <img src="{{asset('public/asset_front/assets/images/Delete.svg')}}">
                                            </a>
                                        </div>

                                    </div>
                                @endforeach
                            @endif
                            <div class="totalmonthlypayment">

                                <p>Monatliche Bezahlung</p>
                                <p class="text-right">{{number_format($total,2)}}€ 
                                @if($online == 'yes')<span class="d-block">+ 2.5% / per Onlinezahlung</span>@endif
                                </p>

                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-pay-1" role="tabpanel" aria-labelledby="pills-pay-tab">
                                <div class="advance-payment-summry">
                                    <div class="paymenticon">
                                        <img src="{{asset('public/asset_front/assets/images/recruitment.svg')}}">
                                    </div>
                                    <div class="advance-payment-features">
                                        <p>Recruitment Fee</p>
                                    </div>
                                    <div style="display: none">
                                    @if($storedetails->Actual_plan == 'Basic Plus')
                                    {{$stotal += 50}}
                                    {{$pricew = 50}}
                                    @elseif($storedetails->Actual_plan == 'Business')
                                    {{$stotal += 100}}
                                    {{$pricew = 100}}
                                    @elseif($storedetails->Actual_plan == 'Basic')
                                    {{$stotal += 0}}
                                    {{$pricew = 0}}
                                    @endif
                                    </div>
                                    <nav aria-label="breadcrumb " class="permonthprice">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="#">{{$pricew}}€</a>
                                            </li>
                                        </ol>
                                    </nav>
                                    
                                </div>
                            @if(count($hardware) > 0 )
                                @foreach($hardware as $rows)
                                <div class="advance-payment-summry">
                                    <div class="paymenticon">
                                            <img src="{{asset('public/asset_front/assets/images/hardware-phone.svg')}}">
                                    </div>
                                    <div class="advance-payment-features">
                                        <p>{{$rows->Service_plan}}</p>
                                    </div>
                                    <div style="display: none">{{$stotal += $rows->Service_amount}}</div>
                                    <nav aria-label="breadcrumb " class="permonthprice">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="#">{{$rows->Service_amount}}€</a>
                                            </li>
                                        </ol>
                                    </nav>
                                    <div class="delicon">
                                        <a href="javascript:void(0)" data-id="{{$rows->id}}" data-value="marketing"
                                           class="delete_service">
                                            <img src="{{asset('public/asset_front/assets/images/Delete.svg')}}">
                                        </a>
                                    </div>
                                </div>
                                @endforeach
                            @endif
                            <div class="totalmonthlypayment">
                                <p>Einmalige Zahlung</p>
                                <p>{{number_format($stotal,2)}}€</p>
                            </div>
                        </div>
                    </div>
                </div>
                <p class="text-right mt-2">*Alle Preise zzgl. Mwst.</p>
                <div class="con-detail" id="contract">
                    <div class="details">
                        <h2>Vertragsdauer</h2>
                        <div class="contactedit">
                            <a href="{{url('contract/edit/'.$storedetails->id)}}">
                                <img src="{{asset('public/asset_front/assets/images/Edit.svg')}}">
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="starttime">
                                <div class="calenderdate">
                                    <div class="calender-icon">
                                        <img src="{{asset('public/asset_front/assets/images/durationcal.svg')}}">
                                    </div>
                                    <div class="time-info">
                                        <p>Eintrittsdatum</p>
                                        <h2>{{$storedetails->Contract_Start_Date}}</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="starttime">
                                <div class="calenderdate">
                                    <div class="calender-icon">
                                        <img src="{{asset('public/asset_front/assets/images/durationcal.svg')}}">
                                    </div>
                                    <div class="time-info">
                                        <p>Austrittsdatum</p>
                                        <h2>{{$storedetails->Contact_end_date}}</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="con-detail" id="payment">
                    <div class="details">
                        <h2>Bankdaten</h2>
                        <div class="contactedit">
                            <a href="{{url('finance/edit/'.$bankdetails->id)}}">
                                <img src="{{asset('public/asset_front/assets/images/Edit.svg')}}">
                            </a>
                        </div>
                    </div>
                    <div class="contactinformation">
                        <ul class="storename">
                            <li><span>Kontoinhaber</span>
                                <p>{{$bankdetails->Account_holder}}</p>
                            </li>
                            <li class="storename"><span>Bankleitzahl</span>
                                <p>{{$bankdetails->Bank_code}}</p>
                            </li>
                            <li><span>IBAN</span>
                                <p>{{$bankdetails->Iban}}</p>
                            </li>
                            <li class="storename"><span>Rechnungsmethode</span>
                                <p>{{$bankdetails->Invoice_method}}</p>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="con-detail" id="finance">
                    <div class="details">
                        <h2>Finanzen</h2>
                        <div class="contactedit">
                            <a href="{{url('payment/edit/'.$storedetails->id)}}">
                                <img src="{{asset('public/asset_front/assets/images/Edit.svg')}}">
                            </a>
                        </div>
                    </div>
                    <div class="sepapayment">
                        <div class="sepadebit"><span>Zahlungsmethode</span>
                            <p>{{$storedetails->Payment_terms}}</p>
                        </div>
                        @if($storedetails->Payment_terms == 'SEPA Direct Debit')
                        <a class="btn btn-primary showdetails" data-toggle="collapse" href="#collapseExample"
                           role="button" aria-expanded="false" aria-controls="collapseExample">
                            Zeige Details
                        </a>
                        @endif
                    </div>
                    <div class="collapse" id="collapseExample">
                        <div class="sepacredit">
                            <div class="directdebit">
                                <p>SEPA-Lastschriftmandat </p>
                                <p>Gläubiger-ID: <span>DE36ZZZ00002263980</span>
                                </p>
                            </div>
                            <div class="debitinfo">
                                <p>Hiermit ermächtige ich R.F.U. reserved4you GmbH, Zahlungen für monatliche Beiträge
                                    mittels SEPA- Lastschrift von meinem Konto einzuziehen. Zugleich weise ich mein
                                    Kreditinstitut an, die von der Berliner Sparkasse auf mein Konto gezogenen
                                    Lastschriften einzulösen.
                                </p>
                            </div>
                            <div class="importantnote">
                                <p>Hinweis:</p>
                                <p>Sie können innerhalb von acht Wochen, beginnend mit dem Belastungsdatum, die
                                    Erstattung des belasteten Betrages verlangen. Es gelten dabei die mit Ihrem
                                    Kreditinstitut vereinbarten Bedingungen. Die Mandatsreferenznummer bekommen Sie mit
                                    Ihrem Vertrag zugeschickt.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="servicebtns letscountinuesbtn nextprevious summarynextbtn"><a href="#" class="previous" type="btn">Zurück</a>
            <a href="{{url('B2B-info')}}" class="next" type="btn">Weiter</a>
        </div>
    </div>
</section>
<script src="{{asset('public/asset_front/assets/js/jquery.min.js')}}"></script>
<script src="{{asset('public/asset_front/assets/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('public/asset_front/assets/js/owl.carousel.min.js')}}"></script>
<script src="{{asset('public/asset_front/assets/js/bootstrap-datepicker.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="{{asset('public/asset_front/assets/js/custom3.js')}}"></script>
<script>
    $(".annual-payment").click(function(){
        $(".recomm-plan-info").hide();
    });

    $(".monthpayment").click(function(){
        $(".recomm-plan-info").show();
    });
    $(document).on('click', '.delete_service', function () {
        var id = $(this).data('id');
        var name = $(this).data('value');

        $.ajax({
            type: 'post',
            url: '{{ route("remove-service")}}',
            data: {
                'id': id,
                'name': name,
                '_token': '{{csrf_token()}}',
            },
            success: function (data) {
                if (data.status == 'true') {
                    window.location.reload();
                }

            }
        });

        console.log(id);
        console.log(name);
    });
</script>
</body>
</html>
