<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>Contact Details</title>
    <link type="image/x-icon" rel="shortcut icon"
          href="{{asset('public/asset_front/assets/images/favicon.jpg')}}"/>
    <meta charset="UTF-8"/>
    <meta name="HandheldFriendly" content="true">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link type="text/css" rel="stylesheet" href="{{asset('public/asset_front/assets/css/all.min.css')}}"/>
    <link type="text/css" rel="stylesheet" href="{{asset('public/asset_front/assets/fonts/stylesheet.css')}}"/>
    <link type="text/css" rel="stylesheet" href="{{asset('public/asset_front/assets/css/owl.carousel.min.css')}}">
    <link type="text/css" rel="stylesheet" href="{{asset('public/asset_front/assets/css/bootstrap.min.css')}}"/>
    <link type="text/css" rel="stylesheet" href="{{asset('public/asset_front/assets/css/intlTelInput.css')}}"/>
    <link type="text/css" rel="stylesheet" href="{{asset('public/asset_front/assets/css/bootstrap-datepicker.css')}}"/>
    <link type="text/css" rel="stylesheet" href="{{asset('public/asset_front/assets/css/styles3.css')}}"/>
    <link type="text/css" rel="stylesheet" href="{{asset('public/asset_front/assets/css/responsive.css')}}"/>
</head>
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
</style>
<body>
<header>
    <nav class="navbar navbar-expand-lg logo">
        <div class="container">
            <a class="navbar-brand " href="{{URL::to('/')}}">
                <img src="{{asset('public/asset_front/assets/images/logo.svg')}}" alt="logo">
            </a>
            <div class="contractheading">
                <p>Contract With <span>Reserved4you</span>
                </p>
            </div>
        </div>
    </nav>
</header>
<section class="contactdetail">
    <div class="progress">
        <div class="progress-bar progressbarr4u" role="progressbar" style="width: 10%;" aria-valuenow="25"
             aria-valuemin="0" aria-valuemax="100"></div>
    </div>
    <div class="container">
        <div class="contactheading">
            <h2>Kontaktdetails</h2>
        </div>
        <form action="{{route('contactdetail/add')}}" method="post" name="myform" onsubmit="return validate()">
            @csrf
            <div class="filldetail">
                <div class="row">
                    <div class="col-lg-4">
                        <input type="text" name="storename" placeholder="Salonname" autocomplete="off"
                               class="storname contact">
                        <sapn id="store" style="padding:10px" class="text-danger"></sapn>
                    </div>
                    <div class="col-lg-4">
                        <input type="text" name="firstname" placeholder="Vorname" autocomplete="off"
                               class="fname contact">
                        <sapn id="fname" style="padding:10px" class="text-danger"></sapn>
                    </div>
                    <div class="col-lg-4">
                        <input type="text" name="Lastname" placeholder="Nachname" autocomplete="off"
                               class="lname contact">
                        <sapn id="lname" style="padding:10px" class="text-danger"></sapn>
                    </div>
                    <div class="col-lg-6">
                        <input type="email" name="Email" placeholder="Email" autocomplete="off" class="mail contact">
                        <sapn id="emailid" style="padding:10px" class="text-danger"></sapn>

                    </div>
                    <div class="col-lg-6">
                        <div class="mobile-number">
                            <img src="{{asset('public/asset_front/assets/images/germany-flag.png')}}" alt="">
                            <!-- <span><i>+49</i></span> -->
                            <input type="mobile" name="Phone"  autocomplete="off" class="mail contact" placeholder="Telefonnummer">
                            <sapn id="nophone" style="padding:10px" class="text-danger"></sapn>
                        </div>
                    </div>
                    <div class="storeadd col-lg-12">
                        <h2>Wo sind wir zu finden?</h2>
                    </div>
                    <div class="col-lg-6">
                        <input type="text" name="Address" class="house_number contact" id="id_address"
                               autocomplete="off" placeholder="Straße, Hausnummer">
                        <div id="postal_code"></div>
                        <div id="map_canvas"></div>
                        <sapn id="addr" style="padding:10px" class="text-danger"></sapn>

                    </div>
                  
                    <div class="col-lg-6">
                        <input type="text" name="Zipcode" id="zipcode" class="house_number contact" autocomplete="off"
                               placeholder="PLZ">
                        <sapn id="Zipcodes" style="padding:10px" class="text-danger"></sapn>

                    </div>
                </div>
            </div>

            <div class="letscountinuesbtn">
                <button class="letscontinues" type="submit">Weiter</a>
            </div>
        </form>
    </div>
</section>
<script src="{{asset('public/asset_front/assets/js/jquery.min.js')}}"></script>
<script src="{{asset('public/asset_front/assets/js/bootstrap.bundle.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="{{asset('public/asset_front/assets/js/owl.carousel.min.js')}}"></script>
<script src="{{asset('public/asset_front/assets/js/bootstrap-datepicker.min.js')}}"></script>
<script src="{{asset('public/asset_front/assets/js/utils.js')}}"></script>
<script src="{{asset('public/asset_front/assets/js/intlTelInput.js')}}"></script>
<script src="{{asset('public/asset_front/assets/js/custom3.js')}}"></script>
<script>
    $("#input").intlTelInput({
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/8.4.6/js/utils.js"
    });
</script>
</body>

</html>

<script>
    function validate() {
        var storename = document.myform.storename.value;
        var firstname = document.myform.firstname.value;
        var Lastname = document.myform.Lastname.value;
        var Email = document.myform.Email.value;
        var Phone = document.myform.Phone.value;
        var Address = document.myform.Address.value;
      
        var Zipcode = document.myform.Zipcode.value;


        if (storename == null || storename == "") {
            document.getElementById("store").innerHTML = "Please Enter Storename.";
            return false;
        } else {
            document.getElementById("store").innerHTML = "";
        }
        if (firstname == null || firstname == "") {
            document.getElementById("fname").innerHTML = "Please Enter firstname.";
            return false;
        } else {
            document.getElementById("fname").innerHTML = "";
        }
        if (Lastname == null || Lastname == "") {
            document.getElementById("lname").innerHTML = "Please Enter lastname.";
            return false;
        } else {
            document.getElementById("lname").innerHTML = "";
        }
        if (Email == null || Email == "") {
            document.getElementById("emailid").innerHTML = "Please Enter EmailId.";
            return false;
        } else {
            document.getElementById("emailid").innerHTML = "";
        }
        if (Phone == null || Phone == "") {
            document.getElementById("nophone").innerHTML = " Please Enter Mobile Number.";
            return false;
        } else if (isNaN(Phone)) {
            document.getElementById("nophone").innerHTML = "Please enter only digite.";
            return false;
        } else if (Phone.length < 11 || Phone.length > 13) {
            document.getElementById("nophone").innerHTML = "Please enter min 11digite.";
            return false;
        } else {
            document.getElementById("nophone").innerHTML = "";
        }

        if (Address == null || Address == "") {
            document.getElementById("addr").innerHTML = "Please Enter Address.";
            return false;
        } else {
            document.getElementById("addr").innerHTML = "";
        }
     
        if (Zipcode == null || Zipcode == "") {
            document.getElementById("Zipcodes").innerHTML = " Please Enter Zipcode.";
            return false;
        } else if (isNaN(Zipcode)) {
            document.getElementById("Zipcodes").innerHTML = "Please enter only digite.";
            return false;
        } else if (Zipcode.length != 5) {
            document.getElementById("Zipcodes").innerHTML = "Please enter only  5 digite.";
            return false;
        } else {
            document.getElementById("Zipcodes").innerHTML = "";
        }


    }
</script>


<script
    src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyBSItHxCbk9qBcXp1XTysVLYcJick5K8mU "></script>

<script>
    function initialize() {
        var input = document.getElementById('id_address');
        var options = {
            types: ['address'],
            componentRestrictions: {
                country: 'DE'
            }
        };
        autocomplete = new google.maps.places.Autocomplete(input, options);
        google.maps.event.addListener(autocomplete, 'place_changed', function () {
            var place = autocomplete.getPlace();
            for (var i = 0; i < place.address_components.length; i++) {
                for (var j = 0; j < place.address_components[i].types.length; j++) {
                    if (place.address_components[i].types[j] == "postal_code") {
                        document.getElementById('zipcode').value = place.address_components[i].long_name;

                    }
                }
            }
        })
    }

    google.maps.event.addDomListener(window, "load", initialize);
</script>
