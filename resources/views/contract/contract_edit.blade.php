<!doctype html>
<html dir="ltr" lang="en-US">

<head>
	<title>Contract Duration</title>
	<link type="image/x-icon" rel="shortcut icon" href="{{asset('public/asset_front/assets/images/favicon.jpg')}}" />
	<meta charset="UTF-8" />
	<meta name="HandheldFriendly" content="true">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="csrf-token" content="{{ csrf_token() }}" />
	<link type="text/css" rel="stylesheet" href="{{asset('public/asset_front/assets/css/all.min.css')}}" />
	<link type="text/css" rel="stylesheet" href="{{asset('public/asset_front/assets/fonts/stylesheet.css')}}" />
	<link type="text/css" rel="stylesheet" href="{{asset('public/asset_front/assets/css/owl.carousel.min.css')}}">
	<link type="text/css" rel="stylesheet" href="{{asset('public/asset_front/assets/css/bootstrap.min.css')}}" />
	<link type="text/css" rel="stylesheet" href="{{asset('public/asset_front/assets/css/bootstrap-datepicker.css')}}" />
	<link type="text/css" rel="stylesheet" href="{{asset('public/asset_front/assets/css/styles3.css')}}" />
	<link type="text/css" rel="stylesheet" href="{{asset('public/asset_front/assets/css/responsive.css')}}" />
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
		<!-- Modal -->
	</header>
	<!-- Contact detail -->
	<section class="extraservices">
		<div class="progress">
			<div class="progress-bar progressbarr4u" role="progressbar" style="width: 40%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
		</div>
		<div class="container">
			<div class="contactheading">
				<h2>Vertragsdauer</h2>
			</div>
			<div class="paymentterms bankpaydetail">
				<div class="row">
					<div class="col-lg-6">
						<div class="starttime">
							<div class="calenderdate">
								<div class="calenderricon">
									<img src="{{asset('public/asset_front/assets/images/calender.svg')}}">
								</div>
								<div class="timeinfo">
									<p>Eintrittsdatum</p>
									<h2 id="current_date">{{$contactdetails->Contract_Start_Date}}</h2>
								</div>
							</div>
							<div class="datebtn" >
							<a href="#"  class="changedatebtn date" name="start_date" id="datepicker">Ändern ?</a>
							</div>

						</div>
					</div>
					<div class="col-lg-6">
						<div class="starttime">
							<div class="calenderdate">
								<div class="calenderricon">
									<img src="{{asset('public/asset_front/assets/images/calender.svg')}}">
								</div>
								<div class="timeinfo">
									<p>Austrittsdatum</p>
									<h2 id="end_date">{{$contactdetails->Contact_end_date}}</h2>
								</div>
							</div>
							<div class="datebtn"> <a href="#" class="changedatebtn" name="end_date" id="date">Ändern ?</a>
							</div>

						</div>
					</div>
				</div>
			</div>
			<p class="mt-2">*Bei monatlicher Vertragslaufzeit entfällt das Austrittsdatum, da der Vertrag automatisch verlängert wird, wenn keine fristgerechte Kündigung vorliegt.</p>
			<div class="servicebtns  duration_of_date"> <a href="{{url('services')}}" class="previous" type="btn">Zurück</a>
				<a href="javascript:void(0)" class="next" type="btn" onclick="date_store()">Weiter</a>
			</div>

		</div>
	</section>
	<!-- Optional JavaScript -->
	<script src="{{asset('public/asset_front/assets/js/jquery.min.js')}}"></script>
	<script src="{{asset('public/asset_front/assets/js/bootstrap.bundle.min.js')}}"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="{{asset('public/asset_front/assets/js/owl.carousel.min.js')}}"></script>
	<script src="{{asset('public/asset_front/assets/js/bootstrap-datepicker.min.js')}}"></script>
	<script src="{{asset('public/asset_front/assets/js/custom3.js')}}"></script>

<script>
// START DATE
var start_date="";
	$('#datepicker').datepicker({
		format: 'dd-mm-yyyy',
        autoclose: true,
        min: 0,
		todayHighlight : true,
        startDate: new Date(),
		}).on('changeDate', function(e) {
			console.log(e.date);
			convert_start_date(e.date);
			$("#current_date").html(start_date);
	})
	function convert_start_date(str) {
		var s_date = new Date(str),
			s_mnth = ("0" + (s_date.getMonth() + 1)).slice(-2),
			s_day = ("0" + s_date.getDate()).slice(-2);
			start_date = [s_day, s_mnth,s_date.getFullYear()].join("-");
		// 	console.log('trial start date',s_date);
		// console.log('trial start date',start_date);
	}
	var start = '{{$contactdetails->Contract_Start_Date}}';

	if(start != ''){
		convert_start_date('{{\Carbon\Carbon::parse($contactdetails->Contract_Start_Date)->format("Y-m-d")}}');
	}


// END DATE

var end_date="";
	$('#date').datepicker({
		format: 'dd-mm-yyyy',
        autoclose: true,
        min: 0,
		todayHighlight : true,
        startDate: new Date(),
		}).on('changeDate', function(e) {
			// console.log(e.date);
			convert_end_date(e.date);
			$("#end_date").html(end_date);

	})
	function convert_end_date(str) {
		
		var e_date = new Date(str),
			e_mnth = ("0" + (e_date.getMonth() + 1)).slice(-2),
			e_day = ("0" + e_date.getDate()).slice(-2);
			end_date = [e_day, e_mnth,e_date.getFullYear()].join("-");
		// console.log('trial end date',end_date);
		// debugger;
	}
	var end = '{{$contactdetails->Contact_end_date}}';
	if(end != ''){
		convert_end_date('{{\Carbon\Carbon::parse($contactdetails->Contact_end_date)->format("Y-m-d")}}');
	}



function date_store(){

    var URL = '{{URL::to('contract/details/edit/')}}';
    var id = '{{$contactdetails->id}}';
    console.log(start_date);
    console.log(end_date);
	$.ajax({
		type: 'post',
        url: URL +'/'+id,
		data: {
			'start_date':start_date,
			'end_date':end_date
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
