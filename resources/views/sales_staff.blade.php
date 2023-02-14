<!doctype html>
<html dir="ltr" lang="en-US">

<head>
<title>Sales Staff</title>
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
<body>
	<!--Header-->
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
	<section class="contactdetail extraservices">
        <form method="post" name="myform"  action="{{url('contact')}}" >
        @csrf
		<div class="progress">
			<div class="progress-bar progressbarr4u" role="progressbar" style="width: 70%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
		</div>
		<div class="container">
			<div class="contactheading">
				<h2>Vertriebsmitarbeiter</h2>
			</div>
			<div class="paymentterms bankpaydetail">
				<h2>Mitarbeiterdetails</h2>
				<div class="sales">
					<div class="salesrepresentative">
					<div class="row align-items-center">

							<div class="col-lg-4">
							<label>Berater:</label>
							</div>

							<div class="col-lg-8">
								<div class="row">
								<div class="col-lg-6">
							<input type="text" name="firstname" class="salesname" id="firstname" placeholder="Vorname">
							<sapn id="first" class="text-danger"></sapn>
							</div>
							<div class="col-lg-6">
							<input type="text" name="lastname" class="salesname" id="lastname" placeholder="Nachname">
							<sapn id="last" class="text-danger"></sapn>

							</div>
							</div>
							</div>

						</div>
						</div>
						<div class="stafid">
					<div class="row align-items-center">

							<div class="col-lg-4">
							<label>Mitarbeiternummer :</label>
							</div>
							<div class="col-lg-8">
							<input type="text" name="Staff_id_no"  id="staffid"class="backdetail">
							<sapn id="staffidno" class="text-danger"></sapn>

							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="servicebtns  salesstaffbtn"> <a href="{{url('finance')}}" class="previous" type="btn">Zurück</a>
				<a href="#" class="next" type="btn" onclick="validate()">Weiter</a>
			</div>
		</div>
         </form>
	</section>
	<!-- Optional JavaScript -->
	<script src="{{asset('public/asset_front/assets/js/jquery.min.js')}}"></script>
	<script src="{{asset('public/asset_front/assets/js/bootstrap.bundle.min.js')}}"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="{{asset('public/asset_front/assets/js/owl.carousel.min.js')}}"></script>
	<script src="{{asset('public/asset_front/assets/js/bootstrap-datepicker.min.js')}}"></script>
	<script src="{{asset('public/asset_front/assets/js/custom3.js')}}"></script>
</body>
<script>
function validate(){
	var abc = document.getElementById("firstname").value;
	var lastname = document.getElementById("lastname").value;
	var staffid = document.getElementById("staffid").value;



	if (abc==null ||abc ==""){
    	document.getElementById("first").innerHTML="Please Enter Firstname.";
    	return false;
    }else{
        document.getElementById("first").innerHTML="";
    }
	if (lastname==null ||lastname ==""){
    	document.getElementById("last").innerHTML="Please Enter Lastname.";
    	return false;
    }else{
        document.getElementById("last").innerHTML="";
    }
	if (staffid==null ||staffid ==""){
    	document.getElementById("staffidno").innerHTML="Please Enter staff id number.";
    	return false;
    }else{
        document.getElementById("staffidno").innerHTML="";
    }


			var firstname=$("input[name=firstname]").val();
			var lastname=$("input[name=lastname]").val();
     		var Staff_id_no=$("input[name=Staff_id_no]").val();

			var _token=$("input[name=_token]").val();

           		 $.ajax({
                	type: 'post',
                	url: '{{ route("sales_details_add")}}',
                	data: {
                    	'firstname':firstname,
						'lastname':lastname,
						'Staff_id_no':Staff_id_no,
						_token:_token
                	},
                	success: function(data) {
                   	 window.location.replace("{{url('contact')}}");

               	 }
            });
        }

	</script>
</html>
