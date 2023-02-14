<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>Contact Details</title>
    <link type="image/x-icon" rel="shortcut icon"
          href="{{asset('storage/app/public/asset_request/images/favicon.png')}}"/>
    <meta charset="UTF-8"/>
    <meta name="HandheldFriendly" content="true">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link type="text/css" rel="stylesheet" href="{{asset('storage/app/public/asset_request/css/all.min.css')}}"/>
    <link type="text/css" rel="stylesheet" href="{{asset('storage/app/public/asset_request/fonts/stylesheet.css')}}"/>
    <link type="text/css" rel="stylesheet" href="{{asset('storage/app/public/asset_request/css/owl.carousel.min.css')}}">
    <link type="text/css" rel="stylesheet" href="{{asset('storage/app/public/asset_request/css/bootstrap.min.css')}}"/>
	<link type="text/css" rel="stylesheet" href="{{asset('storage/app/public/Serviceassets/css/nice-select.css')}}" />
	<link type="text/css" rel="stylesheet" href="{{asset('storage/app/public/Serviceassets/css/timepicker.css')}}" />
	<link type="text/css" rel="stylesheet" href="{{asset('storage/app/public/Serviceassets/css/select2.min.css')}}" />
    <link type="text/css" rel="stylesheet" href="{{asset('storage/app/public/asset_request/css/intlTelInput.css')}}"/>
    <link type="text/css" rel="stylesheet" href="{{asset('storage/app/public/asset_request/css/bootstrap-datepicker.css')}}"/>
    <link type="text/css" rel="stylesheet" href="{{asset('storage/app/public/asset_request/css/styles3.css')}}"/>
	
    <link type="text/css" rel="stylesheet" href="{{asset('storage/app/public/asset_request/css/responsive.css')}}"/>
	
	<script src="{{asset('storage/app/public/asset_request/js/jquery.min.js')}}"></script>
	<script src="{{URL::to('public/js/disable.js')}}"></script>
	<script>
		var token = '{{ csrf_token() }}';
		
	</script>
	<style>
	
    button.letscontinues {
        background-color: #101928;
        padding: 19px 82px;
        font-size: 20px;
        color: #FABA5F;
        border-radius: 20px;
        border: none;
    }

    button.letscontinues:hover {
        background-color: transparent;
        color: #101928;
        box-shadow: 0 0 0 2px #101928;
    }
	.select2-selection__choice__remove {display:none !important;}
	.select2-selection__choice{text-align:center !important;}
	.select2-container--default .select2-selection--multiple .select2-selection__choice{padding:12px 20px;}
	.custom-checkbox .custom-control-input:disabled:checked ~ .custom-control-label::before{background-color:#DB8A8A;}
	.downloadlink{color:#DB8A8A;}
</style>
</head>

<body>
<header>
    <nav class="navbar navbar-expand-lg logo">
        <div class="container">
            <a class="navbar-brand " href="{{URL::to('/')}}">
                <img src="{{asset('storage/app/public/asset_request/images/logo.png')}}" alt="logo">
            </a>
            <div class="contractheading">
                <p>Anforderungsformular <span>Reserved4you</span>
                </p>
            </div>
        </div>
    </nav>
</header>
@yield('request_content')


<script src="{{asset('storage/app/public/asset_request/js/bootstrap.bundle.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="{{asset('storage/app/public/asset_request/js/owl.carousel.min.js')}}"></script>
<script src="{{asset('storage/app/public/asset_request/js/bootstrap-datepicker.min.js')}}"></script>
<script src="{{asset('storage/app/public/asset_request/js/bootstrap-datepicker-de.min.js')}}"></script>
<script src="{{asset('storage/app/public/asset_request/js/utils.js')}}"></script>
<script src="{{asset('storage/app/public/Serviceassets/js/jquery.nice-select.min.js')}}"></script>
<script src="{{asset('storage/app/public/Serviceassets/js/timepicker.js')}}"></script>
<script src="{{asset('storage/app/public/Serviceassets/js/select2.min.js')}}"></script>
<script src="{{asset('storage/app/public/asset_request/js/intlTelInput.js')}}"></script>
<script src="https://momentjs.com/downloads/moment-with-locales.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="{{asset('storage/app/public/asset_request/js/custom3.js')}}"></script>

<script>
    $("#input").intlTelInput({
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/8.4.6/js/utils.js"
    });
	
</script>


<script>
	$(document).ready(function() {
		$('.select').niceSelect();
	});
</script>


<script>
	$(document).ready(function() {
		$('.select2').select2({disabled: true});
	});
	disableForm();
	function disableForm() {
    var inputs = document.getElementsByTagName("input");
    for (var i = 0; i < inputs.length; i++) {
        inputs[i].disabled = true;
    }
    var selects = document.getElementsByTagName("select");
    for (var i = 0; i < selects.length; i++) {
        selects[i].disabled = true;
    }
    var textareas = document.getElementsByTagName("textarea");
    for (var i = 0; i < textareas.length; i++) {
        textareas[i].disabled = true;
    }
   
}
</script>
</body>

</html>