<!doctype html>
<html dir="ltr" lang="en-US">

<head>
	<title>Payment Terms</title>
	<meta name="csrf-token" content="{{ csrf_token() }}" />
	<link type="image/x-icon" rel="shortcut icon" href="{{asset('public/asset_front/assets/images/favicon.jpg')}}" />
	<meta charset="UTF-8" />
	<meta name="HandheldFriendly" content="true">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link type="text/css" rel="stylesheet" href="{{asset('public/asset_front/assets/css/all.min.css')}}" />
	<link type="text/css" rel="stylesheet" href="{{asset('public/asset_front/assets/fonts/stylesheet.css')}}" />
	<link type="text/css" rel="stylesheet" href="{{asset('public/asset_front/assets/css/owl.carousel.min.css')}}">
	<link type="text/css" rel="stylesheet" href="{{asset('public/asset_front/assets/css/bootstrap.min.css')}}" />
	<link type="text/css" rel="stylesheet" href="{{asset('public/asset_front/assets/css/bootstrap-datepicker.css')}}" />
	<link type="text/css" rel="stylesheet" href="{{asset('public/asset_front/assets/css/styles3.css')}}" />
	<link type="text/css" rel="stylesheet" href="{{asset('public/asset_front/assets/css/responsive.css')}}" />
</head>
<script>
    var Payment_terms='SEPA Direct Debit';
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
	<section class="contactdetail extraservices">
		<div class="progress">
			<div class="progress-bar progressbarr4u" role="progressbar" style="width: 50%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
		</div>
		<div class="container">
			<div class="contactheading">
				<h2>Zahlungsbedingungen</h2>
			</div>
			<div class="paymentterms">
				<div class="choospaymentmethod">
					<h2>Wählen Sie eine beliebige Zahlungsmethode*</h2>
					<div class="paymenttermsinfo">
						<div class="paymentterm-wrap">
							<ul class="nav nav-pills payment-nav" id="pills-tab" role="tablist">
								<li class="nav-item" role="presentation"  onclick="Payment_terms='SEPA Direct Debit';">
								<a class="nav-link paymentterm {{$contactdetails->Payment_terms == 'SEPA Direct Debit' ? 'active' : '' }}" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Sepa Lastschrift Mandat (empfohlen)</a>
								</li>
								<li class="nav-item "  role="presentation"  onclick="Payment_terms='Invoice Method';">
								<a class="nav-link peymentterm {{$contactdetails->Payment_terms == 'Invoice Method' ? 'active' : '' }}"  id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Invoice Methode</a>
								</li>
							</ul>
						</div>
					</div>
					<!--  -->
				</div>
				<div class="tab-content servicefeaturmark" id="pills-tabContent">
					<div class="tab-pane fade show active feature" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
						<div class="sepacredit">
							<div class="directdebit">
							<p>SEPA-Lastschriftmandat </p>
								<p>Gläubiger-ID: <span> DE36ZZZ00002263980</span>
								</p>
							</div>
							<div class="debitinfo">
								<p> Hiermit ermächtige ich R.F.U. reserved4you GmbH, Zahlungen für monatliche Beiträge mittels SEPA- Lastschrift von meinem Konto einzuziehen. Zugleich weise ich mein Kreditinstitut an, die von der Berliner Sparkasse auf mein Konto gezogenen Lastschriften einzulösen.
</p>
							</div>
							<div class="importantnote">
								<p>Hinweis:</p>
								<p>Sie können innerhalb von acht Wochen, beginnend mit dem Belastungsdatum, die Erstattung des belasteten Betrages verlangen. Es gelten dabei die mit Ihrem Kreditinstitut vereinbarten Bedingungen. Die Mandatsreferenznummer bekommen Sie mit Ihrem Vertrag zugeschickt.</p>
							</div>
						</div>
					</div>
					<div class="tab-pane fade show marketing" id="pills-profile" role="tabpanel" aria-labelledby="pills-home-tab">
						
					</div>
				</div>
			</div>
			<div class="servicebtns paymenttermbtn"> <a href="{{url('contract')}}" class="previous" type="btn">Zurück</a>
				<a href="javascript:void(0)" class="next" type="btn" onclick="plan_paytm()">Weiter</a>
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
        function plan_paytm(){
            var URL = '{{URL::to('payment/update')}}';
            var id = '{{$contactdetails->id}}';

            $.ajax({
                type: 'post',
                url: URL +'/'+id,
                data: {
                    'Payment_terms':Payment_terms
                },
                success: function(data) {
                    if (data.status == 'true') {
                        window.location.replace("{{url('contact')}}");
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
</script>
</body>

</html>
