@extends('layouts.front')
@section('front_title')
Kosmetik Termine online buchen
@endsection
@section('front_css')

<script src="https://www.gstatic.com/charts/loader.js"></script>
<style>
		.search_value_data{
			position: absolute;
			top: 0;
			left: 0;
			background: #fff;
			z-index: 999;
			border-radius: 10px;
			-webkit-box-shadow: 0 10px 50px rgb(0 0 0 / 10%);
			box-shadow: 0 10px 50px rgb(0 0 0 / 10%);
			padding: 0 12px;
			list-style: none;
			margin-top: 5px;
			max-width: 300px;
			width: 100%;
			min-width: 300px;
		}
		ul.search_value{
			position:unset;
			padding:0px;
			min-width:288px;
			box-shadow:none;
			margin-bottom:10px;
		}
		.search_value_data ul.nav-pills{margin-top:0px}
	</style>
@endsection
@section('front_content')

<!-- Home banner -->
<section class="index-banner">
    <div class="index-banner-img">
        <img loading="lazy" src="{{URL::to('storage/app/public/Frontassets/images/index-banner.webp')}}" alt="">
    </div>
    <span class="about-banner-after"></span>
    <div class="cosmetics-box-main">
        <div class="cosmetics-box-header">
            <h4> Kosmetik</h4>
        </div>
        {{Form::open(array('url'=>route('kosmetic.search'),'method'=>'GET','name'=>'search_form','class'=>'search_form'))}}
        <div class="cosmetics-box-body">
            <div class="owl-carousel owl-theme" id="service-item-owl2">
                @forelse($data as $raw)
                <div class="item">
                    <label href="javascript:void(0)"
                        class="service-item-icon service-item-icon-index service-item-label" data-id="{{$raw->id}}">
                        <input type="radio" name="categories" class="main_cate" value="{{$raw->id}}">
                        <span><?php echo file_get_contents(URL::to('storage/app/public/category/'.$raw->image)); ?></span>
                        <h6>{{$raw->name}}</h6>

                    </label>
                </div>
                @empty
                @endforelse
            </div>
            <ul>
                <li class="index-filter-li">
{{--                    <select name="sab_cats" class="sub_cat select">--}}
{{--                        <option value="">Sub-categories</option>--}}
{{--                    </select>--}}
                    {{Form::select('sub_cat',[''=>'Unterkategorien'],'',array('class'=>'sub_cat','id'=>'sub_cat'))}}
                    <span><img loading="lazy" src="{{URL::to('storage/app/public/Frontassets/images/icon/categories.svg')}}" alt=""></span>
                </li>
                <li class="index-filter-li">
                    <input type="text" name="stores" placeholder="Nach Salon oder Service suchen" class="" autocomplete="off" id="search_data">
                    <div class="search_data">
                    <div class="search_value_data"></div>
                </div>
                        <!-- <option>Find salon or parlor</option>
                    </select> -->
                    <span><img loading="lazy" src="{{URL::to('storage/app/public/Frontassets/images/icon/store.svg')}}" alt=""></span>
                </li>
                <li class="index-filter-li">
                    <input type="text" id="autocomplete" name="location" autocomplete="off" placeholder="PLZ oder Ort suchen">
					<input type="hidden" id="postal_code" name="postal_code" autocomplete="off" placeholder="PLZ oder Ort suchen">
                    <input type="hidden" id="distric" name="distric" autocomplete="off" placeholder="PLZ oder Ort suchen">
					<input type="hidden" id="search_type" name="search_type">
					<input type="hidden" id="search_el" name="search_el">
                    <span><img loading="lazy" src="{{URL::to('storage/app/public/Frontassets/images/icon/pin-2.svg')}}" alt=""></span>
                </li>
                <li class="index-filter-li">
                    <input class="datepicker" id="datepickerhome" name="date" data-date-format="mm-dd-yyyy" readonly="true"  placeholder="Datum">
                    <span><img loading="lazy" src="{{URL::to('storage/app/public/Frontassets/images/icon/calendar.svg')}}" alt=""></span>
                </li>
                <button type="submit" class="btn btn-black btn-search-now btn-block">Suchen</button>
                <a href="#" class="filter-clear-link clear_data">Löschen</a>
            </ul>
        </div>
        {{Form::close()}}
        <div class="cosmetics-box-footer"></div>
    </div>
</section>

<section class="index-service-section">
    <div class="container">
        <div class="who-r4u-section">
            <span><img loading="lazy" src="{{URL::to('storage/app/public/Frontassets/images/service-heading-icon.')}}svg" alt=""></span>
            <h6>Unsere Bereiche</h6>
            <h5>Welche Bereiche
                bieten wir dir ? </h5>
        </div>
        <ul class="catagory-item-ull">
            <li class="catagory-item-1">
                <a href="javascript:void(0)" class="before-catagory">
                    <img loading="lazy" src="{{URL::to('storage/app/public/Frontassets/images/category-before-1.')}}svg" alt="">
                </a>
            </li>
            <li class="catagory-item-2">
                <a href="javascript:void(0)" class="after-catagory">
                    <img loading="lazy" src="{{URL::to('storage/app/public/Frontassets/images/category-2.svg')}}" alt="">
                </a>
                <h6>Kosmetik</h6>
            </li>
            <li class="catagory-item-3">
                <a href="javascript:void(0)" class="before-catagory">
                    <img loading="lazy" src="{{URL::to('storage/app/public/Frontassets/images/category-before-3.svg')}}" alt="">
                </a>
            </li>
            <li class="catagory-item-4">
                <a href="javascript:void(0)" class="before-catagory">
                    <img loading="lazy" src="{{URL::to('storage/app/public/Frontassets/images/category-before-4.svg')}}" alt="">
                </a>
            </li>
        </ul>
    </div>
</section>

<section class="pocket-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="pocket-info">
                    <h3>Buche deinen nächsten Termin wann und wo du willst,
                        direkt im Handumdrehen -</h3>
                    <p>Wir sind mobil und flexibel erreichbar – mit Android und iOS.
                        Damit kannst du bequem buchen, was dir viel Zeit und Geld einspart..</p>
                    <ul>
                        <li>
                            <a href="#"><img loading="lazy" src="{{URL::to('storage/app/public/Frontassets/images/play-store.svg')}}" alt=""></a>
                        </li>
                        <li>
                            <a href="#"><img loading="lazy" src="{{URL::to('storage/app/public/Frontassets/images/app-store.svg')}}" alt=""></a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 pocket-order-1">
                <div class="pocket-img">
                    <img loading="lazy" src="{{URL::to('storage/app/public/Frontassets/images/pocket-phone.png')}}" alt="">
                </div>
            </div>
        </div>
    </div>
</section>

<section class="advantages-home-section padding-100">
    <div class="container">
        <div class="advantages-home-title">
            <h6>Unsere Vorteile</h6>
            <h5>Wovon profitierst du durch uns ?</h5>
        </div>
        <div class="row advantages-home-row">
            <div class="col-lg-6 col-md-6">
                <div class="advantages-home-item-img">
                    <img loading="lazy" src="{{URL::to('storage/app/public/Frontassets/images/advantages-home-1.png')}}" alt="">
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="advantages-home-item-info">
                    <span><img loading="lazy" src="{{URL::to('storage/app/public/Frontassets/images/icon/advantages-home-icon-1.svg')}}" alt=""></span>
                    <h5>Registriere dich jetzt kostenlos und
                        nutze unsere Funktionen zu deinem Vorteil!</h5>
{{--                    <h6>Free Registration</h6>--}}
                </div>
            </div>
        </div>
        <div class="row advantages-home-row">
            <div class="col-lg-6 col-md-6">
                <div class="advantages-home-item-info">
                    <span><img loading="lazy" src="{{URL::to('storage/app/public/Frontassets/images/icon/advantages-home-icon-2.svg')}}" alt=""></span>
                    <h5>Unser Service steht rund um die Uhr
                        zur Verfügung, wann und wo du willst</h5>
{{--                    <h6>Use Anywhere, Anytime</h6>--}}
                </div>
            </div>
            <div class="col-lg-6 col-md-6 advantages-ordermd">
                <div class="advantages-home-item-img">
                    <img loading="lazy" src="{{URL::to('storage/app/public/Frontassets/images/advantages-home-2.png')}}" alt="">
                </div>
            </div>
        </div>
        <div class="row advantages-home-row">
            <div class="col-lg-6 col-md-6">
                <div class="advantages-home-item-img">
                    <img loading="lazy" src="{{URL::to('storage/app/public/Frontassets/images/advantages-home-3.png')}}" alt="">
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="advantages-home-item-info">
                    <span><img loading="lazy" src="{{URL::to('storage/app/public/Frontassets/images/icon/advantages-home-icon-3.svg')}}" alt=""></span>
                    <h5>Mehrere Bereiche kombiniert –
                        auf einer Plattform gebündelt.</h5>
{{--                    <h6>Four in One</h6>--}}
                </div>
            </div>
        </div>
        <div class="row advantages-home-row">
            <div class="col-lg-6 col-md-6">
                <div class="advantages-home-item-info">
                    <span><img loading="lazy" src="{{URL::to('storage/app/public/Frontassets/images/icon/advantages-home-icon-4.svg')}}" alt=""></span>
                    <h5>Buchen, Bezahlen und Bewerten,
                        das gelingt dir ganz einfach mit jedem Endgerät:
                        Smartphone, Tablet und Laptop..</h5>
{{--                    <h6>Book, Pay & Rate</h6>--}}
                </div>
            </div>
            <div class="col-lg-6 col-md-6 advantages-ordermd">
                <div class="advantages-home-item-img  ">
                    <img loading="lazy" src="{{URL::to('storage/app/public/Frontassets/images/advantages-home-4.png')}}" alt="">
                </div>
            </div>
        </div>
    </div>
</section>

<section class="digital-main-section">
    <div class="container">
        <div class="digital-main-title">
            <h6>Wir helfen Ihnen dabei, Ihre Reichweite zu vergrößern</h6>
            <h4>Bringen Sie Ihr Geschäft auf unsere
                digitale Plattform!</h4>
        </div>
        <ul class="digital-main-ul">
            <li>
                <h5>{{ \BaseFunction::getStatisticWebsite('provider') }}+</h5>
                <p>Geschäftspartner</p>
            </li>
            <li>
                <h5>{{ \BaseFunction::getStatisticWebsite('appointments') }}+</h5>
                <p>gebuchte Termine</p>
            </li>
            <li>
                <h5>{{ \BaseFunction::getStatisticWebsite('customer') }}+</h5>
                <p>Nutzer</p>
            </li>
        </ul>
        <!--<div class="owl-carousel owl-theme" id="digital-main-owl">
            <div class="item">
                <div class="digital-main-partner">
                    <img loading="lazy" src="{{URL::to('storage/app/public/Frontassets/images/client-1.png')}}" alt="">
                </div>
            </div>
            <div class="item">
                <div class="digital-main-partner">
                    <img loading="lazy" src="{{URL::to('storage/app/public/Frontassets/images/client-2.png')}}" alt="">
                </div>
            </div>
            <div class="item">
                <div class="digital-main-partner">
                    <img loading="lazy" src="{{URL::to('storage/app/public/Frontassets/images/client-3.png')}}" alt="">
                </div>
            </div>
            <div class="item">
                <div class="digital-main-partner">
                    <img loading="lazy" src="{{URL::to('storage/app/public/Frontassets/images/client-4.png')}}" alt="">
                </div>
            </div>
            <div class="item">
                <div class="digital-main-partner">
                    <img loading="lazy" src="{{URL::to('storage/app/public/Frontassets/images/client-5.png')}}" alt="">
                </div>
            </div>
        </div> -->
    </div>
</section>

<section class="index-map-section padding-100">
    <div class="container">
        <div class="index-map-title">
            <h6>Unsere Standorte</h6>
            <h5>Wo sind wir bereits für dich
                verfügbar?</h5>
        </div>
    </div>
    <div class="index-map-image">
        <!-- <img loading="lazy" src="{{URL::to('storage/app/public/Frontassets/images/map.png')}}" alt=""> -->
        <div class="index-dekstop-mobile">
            <?php echo file_get_contents(URL::to('storage/app/public/Frontassets/images/map-svg.svg')); ?>
        </div>
        <div class="index-map-mobile">
            <?php echo file_get_contents(URL::to('storage/app/public/Frontassets/images/risponsive-map.svg')); ?>
        </div>
        <div class="map-info-box">
            <div class="map-store-img">
                <img loading="lazy" src="{{URL::to('storage/app/public/Frontassets/images/serimg1.png')}}" alt="">
            </div>
            <div class="map-store-info">
                <h5>Berlin</h5>
                <p>100 <span> Partner</span></p>
                <h6>Bezirke</h6>
                <p><span>{{ __('wir sind in') }} </span> Charlottenburg-Wilmersdorf, Friedrichshain-Kreuzberg, Lichtenberg, Marzahn-Hellersdorf, Mitte, Neukölln, Pankow, Reinickendorf, Spandau, Steglitz-Zehlendorf, Tempelhof-Schöneberg, Treptow-Köpenick <!--<a href="#">+30 More</a>--></p>

            </div>
        </div>
    </div>

    <!-- <div id="map_info" style="display: none;">
        <div class="map-box">
            <div class="map-box-img">
                <img loading="lazy" src="{{URL::to('storage/app/public/Frontassets/images/pocket-bg.jpg')}}" alt="">
            </div>
            <div class="map-box-info">
                <h6>Thuringia</h6>
                <p>26,520 <span>Business Partner</span></p>
                <h6>Cities</h6>
                <p class="mb-0"><span>We are in </span> {{$cities}}</p>
                <a href="#">+30 More</a>
            </div>
        </div>
    </div> -->
</section>


<section class="padding-100 social-media-section">
    <div class="container">
        <div class="row align-items-center ">
            <div class="col-lg-6 col-md-6">
                <div class="social-media-img">
                    <img loading="lazy" src="{{URL::to('storage/app/public/Frontassets/images/facebook.png')}}" alt="" class="social_imgs">
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="soical-media-info">
                    <h5>Folg uns <br /> auf unseren <span> Social Media </span> Plattformen</h5>
                    <ul class="soical-media-ul">
                        <li class="instagram scl_img" data-url="{{URL::to('storage/app/public/Frontassets/images/facebook.png')}}">
                            <span><?php echo file_get_contents(URL::to('storage/app/public/Frontassets/images/icon/instagram.svg')); ?></span>
                            <h6>Instagram</h6>
                        </li>
                        <li class="active facebook scl_img" data-url="{{URL::to('storage/app/public/Frontassets/images/facebook.png')}}">
                            <span><?php echo file_get_contents(URL::to('storage/app/public/Frontassets/images/icon/facebook.svg')); ?></span>
                            <h6>Facebook</h6>
                        </li>
                        <li class="tiktok scl_img" data-url="{{URL::to('storage/app/public/Frontassets/images/facebook.png')}}">
                            <span><?php echo file_get_contents(URL::to('storage/app/public/Frontassets/images/icon/tiktok.svg')); ?></span>
                            <h6>TikTok</h6>
                        </li>
                        <li class="snapchat scl_img" data-url="{{URL::to('storage/app/public/Frontassets/images/facebook.png')}}">
                            <span><?php echo file_get_contents(URL::to('storage/app/public/Frontassets/images/icon/snapchat.svg')); ?></span>
                            <h6>Snapchat</h6>
                        </li>
                        <li class="linkedin scl_img" data-url="{{URL::to('storage/app/public/Frontassets/images/facebook.png')}}">
                            <span><?php echo file_get_contents(URL::to('storage/app/public/Frontassets/images/icon/linkedin.svg')); ?></span>
                            <h6>Linkedin</h6>
                        </li>
                        <li class="whatsapp scl_img" data-url="{{URL::to('storage/app/public/Frontassets/images/facebook.png')}}">
                            <span><?php echo file_get_contents(URL::to('storage/app/public/Frontassets/images/icon/whatsapp.svg')); ?></span>
                            <h6>Whatsapp</h6>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="register-cosmetic-section">
    <div class="container">
        <div class="register-cosmetic-areas">
            <span class="register-cosmetic-lines"><img loading="lazy" src="{{URL::to('storage/app/public/Frontassets/images/area-line.svg')}}" alt=""></span>
            <span class="register-cosmetic-lines2"><img loading="lazy" src="{{URL::to('storage/app/public/Frontassets/images/area-line.svg')}}" alt=""></span>
			@if(!Auth::check())
            <div class="register-cosmetic-areas-info">
                <h6>Registriere dich hier,
                    um alle Vorteile zu nutzen</h6>
                   
                <a href="javascript:void(0)" data-toggle="modal" data-target="#register-modal" class="btn btn-white">Jetzt registrieren!</a>
              
            </div>
			  @endif
        </div>
    </div>
</section>

@endsection
@section('front_js')
<script
        src="https://maps.google.com/maps/api/js?key=AIzaSyBSItHxCbk9qBcXp1XTysVLYcJick5K8mU&libraries=places&v=weekly"
        type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#sub_cat').niceSelect();
    });

    $("body").addClass("header-transparent");

    $('#datepickerhome').datepicker({
        autoclose: true,
        min: 0,
        startDate: new Date(),
    });

    google.maps.event.addDomListener(window, 'load', initialize);
    // $(document).on('click','.btn-search-now',function (){
    //
    //     var id = $(".sub_cat").val(); //returns value
    //     console.log(id);
    //     // console.log(value);
    //
    // })

	$(document).on('keyup','#autocomplete',function (){
		var value = $(this).val();
		if(value == ''){
			$('#postal_code').val('');
			 $('#distric').val('');
		}
		$('#distric').val("");
		$('#postal_code').val("");
	});
	
    function initialize() {
		$('#distric').val("");
		$('#postal_code').val("");
        var input = document.getElementById('autocomplete');
        var options = {
            types: ['(regions)'],
            componentRestrictions: {
                country: 'de'
            }
        };
        var autocomplete = new google.maps.places.Autocomplete(input, options);
        autocomplete.addListener('place_changed', function () {
            var place = autocomplete.getPlace();
			$('#distric').val(place.vicinity);
			localStorage.setItem('placelocation', place.geometry.location);
            for (var j = 0; j < place.address_components.length; j++) {
                for (var k = 0; k < place.address_components[j].types.length; k++) {
                    if (place.address_components[j].types[k] == "postal_code") {
                        $('#postal_code').val(place.address_components[j].short_name);
                    }else if(place.address_components[j].types[k] == "locality"){
						//$('#distric').val(place.address_components[j].long_name);
					}
                }
            }

        });
    }


    google.charts.load('current', {
      packages:['geochart'],
      mapsApiKey: 'AIzaSyBSItHxCbk9qBcXp1XTysVLYcJick5K8mU'
    });
    google.charts.setOnLoadCallback(drawRegionsMap);

    function drawRegionsMap() {

      var states = (<?php echo json_encode($cities) ?>).split(",");

      var provinces = [];

      provinces.push(['State']);

     $.each(states,function(i,data){
        if(data == "Berlin")
            provinces.push([data]);
        else
            provinces.push([data]);
    })

      var data = google.visualization.arrayToDataTable(provinces);

      var options = {
        region: 'DE',
        dataMode: 'markers',
        colorAxis: {
          colors: ['yellow']
        },
        resolution: 'provinces',
        legend: 'none'
      };

      var chart = new google.visualization.GeoChart(document.getElementById('map'));
      chart.draw(data, options);
    }

    $('.main_cate').on('click',function(){
        var cat = $(this).val();
        $.ajax({
          type: 'GET',
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          url: "{{URL::to('get_sub_cat')}}",
          data: {cat:cat},
          success: function(response) {
            // console.log(response.length);
            // if(response.length > 0){
                var html = "<option value='' selected>Unterkategorien</option>";
                $.each(response, function(i,data){
                    html += "<option value="+i+">"+data+"</option>";
                });

                $('.sub_cat').html(html);
              $('.sub_cat').niceSelect('update');
            // }
          },
          error: function(error) {


          }
        });
    });

    $('.sub_cat').on('change',function(){
        var sub_cat = $(this).val();
        var cat = $('input[name=categories]:checked').val();
        $.ajax({
          type: 'GET',
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          url: "{{URL::to('get_stores')}}",
          data: {cat:cat,sub_cat:sub_cat},
          success: function(response) {
            // console.log(response.length);
            // if(response.length > 0){
                var html = "<option>Nach Salon oder Service suchen</option>";
                $.each(response, function(i,data){
                    html += "<option value="+i+">"+data+"</option>";
                });

                $('.stores').html(html);
            // }
          },
          error: function(error) {


          }
        });
    });

</script>
<script type="text/javascript">
	
	var store_active = "active";
	var service_active = "";
	function activeTabs(value_tab){
		if(value_tab == 1){
			store_active = "active";
			service_active = "";
		}else{
			service_active = "active";
			store_active = "";
		}
	}
	
    $(document).on('keyup', '#search_data', function () {
            var search = $(this).val();
			$('#search_type').val('');
			$('#search_el').val('');
            var baseURL = '{{URL::to('/')}}';
            if (search.length >= 3) {
                $.ajax({
                    type: 'POST',
                    async: true,
                    dataType: "json",
                    url: "{{URL::to('get-search-data')}}",
                    data: {
                        _token: '{{ csrf_token() }}',
                         search: encodeURIComponent(search),
                    },
                    // beforesend: $('#loading').css('display', 'block'),
                    success: function (response) {
                        var status = response.status;
                        var data = response.data;
                        var html = '';
						var show_tab_store = "show active";
						var show_tab_service = "";
						if(service_active == 'active'){
							show_tab_store = "";
							show_tab_service = "show active";
						}
						if(store_active == 'active'){
							show_tab_store = "show active";
							show_tab_service = "";
						}
                        if (status == 'true') {
							html += '<ul class="nav nav nav-pills" id="pills-tab" role="tablist">';
								html += '<li class="nav-item '+store_active+'" style="width:calc(50% - 10px);border:0px;padding-top:5px;">';
									html += '<a class="nav-link '+store_active+' text-center" onclick="activeTabs(1);" id="pills-stores-tab" data-toggle="pill" href="#pills-stores" role="tab" aria-controls="pills-stores" aria-selected="true">Stores</a>';
								html += '</li>';
								html += '<li class="nav-item '+service_active+'" style="width:calc(50% - 10px);border:0px;padding-top:5px;">';
									html += '<a class="nav-link '+service_active+' text-center" onclick="activeTabs(2);" id="pills-services-tab" data-toggle="pill" href="#pills-services" role="tab" aria-controls="pills-services" aria-selected="false">Services</a>';
								html += '</li></ul>';
								
							var store_html = ''; var service_html = '';
                            $(data).each(function (i, item) {
                                if (item.url == 'store') {
                                    store_html += '<li><a href="javascript:void(0)"  data-type="store" class="select_search" data-value="' + item.search_name + '">' + item.search_name + '</a></li>';
                                }
								if (item.url == 'service') {
                                    service_html += '<li><a href="javascript:void(0)"  data-type="service" class="select_search" data-value="' + item.search_name + '">' + item.search_name + '</a></li>';
                                }
                            });
							
							 html += '<div class="tab-content" id="pills-tabContent">';
							 
							  html += '<div class="tab-pane fade '+show_tab_store+'" id="pills-stores" role="tabpanel" aria-labelledby="pills-stores-tab">';
							 html += '<ul class="search_value" >';
							 if(store_html){
								  html += store_html;
							 }else{
								 html += '<li>No stores found</li>';
							 }
							
							 html += '</ul>';
							 html += '</div>';
							 
							 html += '<div class="tab-pane fade '+show_tab_service+'" id="pills-services" role="tabpanel" aria-labelledby="pills-services-tab">';
							 html += '<ul class="search_value">';
							 if(service_html){
								 html += service_html;
							 }else{
								 html += '<li>No services found</li>';
							 }
							 
							 html += '</ul>';
							 html += '</div>';
							  html += '</div>';
                            $('.search_value_data').html(html);
                        }else{
							
							 $('.search_value_data').html('');
						}
                        // $('#loading').css('display', 'none');
                    },
                    error: function (e) {

                    }
                });
            }else if(search.length == 0){
                $('.search_value_data').html('');
            }
        });

        $(document).on('click','.select_search',function (){
            var value = $(this).data('value');
			var type = $(this).data('type');
			$('#search_type').val(type);
			$('#search_el').val(value);
            $('#search_data').val(value);
            $('.search_value_data').html('');

        })

        $('.scl_img').on('click',function(){
            $('.scl_img').removeClass('active');
            $(this).addClass('active');

            var image = $(this).data("url");

            $(".social_imgs").attr('src',image);

        })

          // service-item-owl //
    $('#service-item-owl2').owlCarousel({
        loop: false,
        margin: 10,
        nav: true,
        dots: false,
        navText: ["<i class='fas fa-chevron-left'></i>", "<i class='fas fa-chevron-right'></i>"],
        responsive: {
            0: {
                items: 2
            },
            430: {
                items: 3
            },
            1000: {
                items: 4
            }
        }
    })
    $(document).ready(function(){
        $(document).click(function(e){
           if(e.target.id == 'parlour-name')
           {
                $("#Layer_1 #parlour-tick").addClass("active");
                $("#Layer_1 .map-part").addClass("active");
                $("#Layer_1 .stroke").addClass("active");
                $("#Layer_1 .name-box").addClass("active");
                $("#Layer_1 .box-name").addClass("active");
                $("#Layer_1 .name_i").addClass("active");
                $("#Layer_1 .i-letter").addClass("active");
                $(".map-info-box").toggleClass("active");
                console.log('true');
           }
           else
           {
                $("#Layer_1 #parlour-tick").removeClass("active");
                $("#Layer_1 .map-part").removeClass("active");
                $("#Layer_1 .stroke").removeClass("active");
                $("#Layer_1 .name-box").removeClass("active");
                $("#Layer_1 .box-name").removeClass("active");
                $("#Layer_1 .name_i").removeClass("active");
                $("#Layer_1 .i-letter").removeClass("active");
                $(".map-info-box").removeClass("active");
                console.log('false');
           }
        })
    })
    $(document).on('click','.clear_data',function (){
        $('.service-item-icon').removeClass('active');
        $(".sub_cat").val("");
        $("#search_data").val("");
        $("#postal_code").val("");
        $("#autocomplete").val("");
        $("#datepickerhome").val("");
		$('#search_type').val('');
		$('#search_el').val('');
        var html = "<option value='' selected>Unterkategorien</option>";
        $('.sub_cat').html(html);
        $('.sub_cat').niceSelect('update');
        $("input:radio[name=categories]:checked")[0].checked = false;
        $('input[type=radio]').removeAttr('checked');


    })
    $('#Layer_1 .name-box').click(function() {
        // e.preventDefault();
                $("#Layer_1 #parlour-tick").removeClass("active");
                $("#Layer_1 .map-part").removeClass("active");
                $("#Layer_1 .stroke").removeClass("active");
                $("#Layer_1 .name-box").removeClass("active");
                $("#Layer_1 .box-name").removeClass("active");
                $("#Layer_1 .name_i").removeClass("active");
                $("#Layer_1 .i-letter").removeClass("active");
                $(".map-info-box").removeClass("active");
                console.log('asdasdasd');
    });
	
	// When the user clicks anywhere outside of the modal, close it
	window.onclick = function(e) {
		var container_popup = $('.index-filter-li');

		if (!container_popup.is(e.target) && container_popup.has(e.target).length === 0) {
			$('.search_value_data').html("");
		}
		
		
	}


</script>
@endsection
