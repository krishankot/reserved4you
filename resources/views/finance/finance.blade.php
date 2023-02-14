<!doctype html>
<html dir="ltr" lang="en-US">

<head>
	<title>Finace</title>
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

	var Invoice_method='via Email';
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
			<div class="progress-bar progressbarr4u" role="progressbar" style="width: 60%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
		</div>
		<div class="container">
			<div class="contactheading">
				<h2>Finanzen</h2>
			</div>
			<form name="myform" action="{{url('sales/staff')}}" >
			@csrf
			<div class="paymentterms bankpaydetail">
				<h2>Ihre Bankverbindung*</h2>
				<div class="row">
					<div class="col-lg-12">
						<div class="account_holder">
							<label>Kontoinhaber :</label>
							<input type="text" name="Account_holder" id="accountholder" class="backdetail">
						 	<sapn id="account" class="text-danger"></sapn>
						</div>

					</div>
					<div class="col-lg-12">
						<div class="bankcode">
							<label>Bankleitzahl :</label>
							<input type="text" name="Bank_code"  id="Bankcode" class="backdetail">
							<sapn id="bank" class="text-danger"></sapn>

						</div>
					</div>
					<div class="col-lg-12">
						<div class="iban">
							<label>IBAN :</label>
							<input type="text" name="Iban" id="Ibanno" class="backdetail">
							<sapn id="Iban" class="text-danger"></sapn>


						</div>
					</div>
				</div>
				<div class="invoicemethod">
					<h4>Rechnungsart*</h4>
				</div>
				<div class="financeviamail" >
					<label for="plans-1" class="sendmailvia">
						<input type="radio" name="Invoice_method" id="plans-1" value="Via Email" >
						<p class="viamail">Per E-Mail</p>
					</label>
					<label for="plans-2" class="plans-label paylbl sendmailvia">
						<input type="radio" name="Invoice_method" id="plans-2" value="By post" >
						<p class="viamail">Per Post <span>(zzgl. Versandkosten)</span>
						</p>
					</label>
				</div>
			</div>
			<div class="servicebtns  financebtn"> <a href="{{url('payment')}}" class="previous" type="btn">Zurück</a>
				<a href="#" class="next" type="btn" onclick="extra_service_store()">Weiter</a>
			</div>
			</form>
		</div>
	</section>
	<script src="{{asset('public/asset_front/assets/js/jquery.min.js')}}"></script>
	<script src="{{asset('public/asset_front/assets/js/bootstrap.bundle.min.js')}}"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="{{asset('public/asset_front/assets/js/owl.carousel.min.js')}}"></script>
	<script src="{{asset('public/asset_front/assets/js/bootstrap-datepicker.min.js')}}"></script>
	<script src="{{asset('public/asset_front/assets/js/custom3.js')}}"></script>
</body>
<script>

function extra_service_store(){

	var  accountholder= document.getElementById("accountholder").value;
	var  Bankcode= document.getElementById("Bankcode").value;
	var  Ibanno= document.getElementById("Ibanno").value;


	if (accountholder==null ||accountholder ==""){
    	document.getElementById("account").innerHTML="Please Enter Accountholder Name.";
    	return false;
    }else{
        document.getElementById("account").innerHTML="";
    }
	if (Bankcode==null ||Bankcode ==""){
    	document.getElementById("bank").innerHTML="Please Enter Bank code.";
    	return false;
	}
	else if (Bankcode.length != 8) {
		document.getElementById("bank").innerHTML = "Please enter only 8 digite.";
		return false;
    }else{
        document.getElementById("bank").innerHTML="";
    }
	if (Ibanno==null ||Ibanno ==""){
    	document.getElementById("Iban").innerHTML="Please Enter Iban.";
    	return false;
	}
	else if (Ibanno.length != 22) {
		document.getElementById("Iban").innerHTML = "Please enter only 22 digite.";
		return false;
    }
    else{
        document.getElementById("Iban").innerHTML="";
    }



			var Account_holder=$("input[name=Account_holder]").val();
			var Bank_code=$("input[name=Bank_code]").val();
     		var Iban=$("input[name=Iban]").val();
			 var Invoice_method = $('input[name=Invoice_method]:checked').val();
			var _token=$("input[name=_token]").val();

           		 $.ajax({
                	type: 'post',
                	url: '{{ route("bank_details_add")}}',
                	data: {
                    	'Account_holder':Account_holder,
						'Bank_code':Bank_code,
						'Iban':Iban,
						'Invoice_method':Invoice_method,
						_token:_token
                	},
                	success: function(data) {
						window.location.replace("{{url('sales/staff')}}");

               	 }
            });
        }

</script>

</html>
