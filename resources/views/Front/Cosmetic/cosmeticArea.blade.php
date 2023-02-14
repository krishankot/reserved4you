@extends('layouts.front')
@section('front_title')
    Cosmetic Area
@endsection
@section('front_css')
<style>
.mapMarker-module--outline--626df4 {
    fill: #fff;
}
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
.infowindow_box{
	 padding:10px
}
.infowindow_title{
    color: #101928;
    font-size: 16px;
    font-weight: 500;
}
.infowindow_box .review-box{margin:0px;margin-top:5px;font-size:12px;padding:5px;}

.infowindow_box .rcount{color:#9FA3A9 !important;margin:0px;margin-left:5px;font-weight:400;font-size:12px;}
.gm-style .gm-style-iw-c{padding:0px;}
.gm-style-iw-d{max-height:unset !important;overflow:hidden !important;}
button.gm-ui-hover-effect{top:0px !important;right:0px !important;height:26px !important;width:26px !important;background: #fff !important;border-radius: 50%;box-shadow: rgba(0, 0, 0, 0.7) 0px 4px 12px;}
button.gm-ui-hover-effect img{height:18px !important;width:18px !important;margin:4px !important;}
</style>
@endsection
@section('front_content')
    <!-- Home banner -->
    <section class="d-margin area-banner">
        <div class="container">
            <ul class="nav nav-pills area-pills" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="pills-new-tab" href="javascript:void(0)" data-target="pills-new" role="tab"
                       aria-controls="pills-new" aria-selected="true">Neu</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="pills-recommended-tab" href="javascript:void(0)" data-target="pills-recommended"
                       role="tab"
                       aria-controls="pills-recommended" aria-selected="false">Empfohlen</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="pills-rated-tab" href="javascript:void(0)" data-target="pills-rated" role="tab"
                       aria-controls="pills-rated" aria-selected="false">Top Rated</a>
                </li>
            </ul>
            <div class="tab-content owl-buttons" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-new" role="tabpanel" aria-labelledby="pills-new-tab">
                    <div class="owl-carousel owl-theme" id="new-area-owl">
                        @forelse($new_store as $key=>$row)
                            <div class="item" onclick="window.location.href='{{URL::to('kosmetik/'.$row['slug'])}}'" style="cursor: pointer;">
                                <div class="area-banner-item">
                                    <div class="area-banner-item-img">
                                        <img
                                            src="{{URL::to('storage/app/public/store/'.(($row->store_profile == '')?'Store-6058bde8bf5a8.JPEG':$row->store_profile))}}"
                                            alt="">
                                    </div>
                                    <div class="area-banner-item-info">
                                        <p class="review-box"><span><i class="fas fa-star"></i></span>{{$row->rating}}
                                        </p>
                                        <h6 data-toggle="tooltip" data-placement="bottom"
                                            title="{{$row->store_name}}">{{$row->store_name}}</h6>
                                    </div>
                                </div>
                            </div>
                        @empty
                        @endforelse
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-recommended" role="tabpanel"
                     aria-labelledby="pills-recommended-tab">
                    <div class="owl-carousel owl-theme" id="recommended-area-owl">
                        @forelse($recommandedforyou as $key=>$row)
                            <div class="item" onclick="window.location.href='{{URL::to('kosmetik/'.$row['slug'])}}'" style="cursor: pointer;">
                                <div class="area-banner-item">
                                    <div class="area-banner-item-img">
                                        <img
                                            src="{{URL::to('storage/app/public/store/'.(($row->store_profile == '')?'Store-6058bde8bf5a8.JPEG':$row->store_profile))}}"
                                            alt="">
                                    </div>
                                    <div class="area-banner-item-info">
                                        <p class="review-box"><span><i class="fas fa-star"></i></span>{{$row->rating}}
                                        </p>
                                        <h6 data-toggle="tooltip" data-placement="bottom"
                                        title="{{$row->store_name}}">{{$row->store_name}}</h6>
                                    </div>
                                </div>
                            </div>
                        @empty
                        @endforelse
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-rated" role="tabpanel" aria-labelledby="pills-rated-tab">
                    <div class="owl-carousel owl-theme" id="rated-area-owl">
                        @forelse($high_rate as $key=>$row)
                            <div class="item" onclick="window.location.href='{{URL::to('kosmetik/'.$row['slug'])}}'" style="cursor: pointer;">
                                <div class="area-banner-item">
                                    <div class="area-banner-item-img">
                                        <img
                                            src="{{URL::to('storage/app/public/store/'.(($row->store_profile == '')?'Store-6058bde8bf5a8.JPEG':$row->store_profile))}}"
                                            alt="">
                                    </div>
                                    <div class="area-banner-item-info">
                                        <p class="review-box"><span><i class="fas fa-star"></i></span>{{$row->rating}}
                                        </p>
                                        <h6 data-toggle="tooltip" data-placement="bottom"
                                            title="{{$row->store_name}}">{{$row->store_name}}</h6>
                                    </div>
                                </div>
                            </div>
                        @empty
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="area-filter">
        <div class="container">
            <ul class="area-filter-wrap">
                <li class="w-17">
                    <span><?php echo file_get_contents(URL::to('storage/app/public/Frontassets/images/icon/categories.svg')) ?></span>
                    <!-- <input type="text" placeholder="Categories"> -->
                    {{Form::select('categories',$category,$categorieData,array('class'=>'main_cate select'))}}
                </li>
                <li class="w-20">
                    <span><?php echo file_get_contents(URL::to('storage/app/public/Frontassets/images/icon/categories.svg')) ?></span>
                    {{Form::select('sab_cat',$subCategory,$sub_cat,array('class'=>'sub_cat select'))}}
                </li>
                <li class="w-18">
                    <span><?php echo file_get_contents(URL::to('storage/app/public/Frontassets/images/icon/store.svg')) ?></span>
                    <input type="text" name="stores" placeholder="Nach Salon oder Service suchen" class="stores" id="search_data"
                           value="{{$stores}}">
                    <div class="search_data">
                        <div class="search_value_data"></div>
                    </div>
                </li>
                <li class="w-16">
                    <span><?php echo file_get_contents(URL::to('storage/app/public/Frontassets/images/icon/location.svg')) ?></span>
                    <input type="text" id="autocomplete" name="location" autocomplete="off" placeholder="PLZ oder Ort suchen" value="{{$location}}">
                    <input type="hidden" id="distric" name="distric" autocomplete="off" value="{{$distric}}" placeholder="Post code or area">
                    <input type="hidden" id="postal_code" name="postal_code" autocomplete="off" value="{{$pincode}}" placeholder="Post code or area">
					<input type="hidden" id="search_type" name="search_type" value="{{$search_type}}">
					<input type="hidden" id="search_el" name="search_el" value="{{$search_el}}">
                </li>
                <li class="w-17">
                    <span><?php echo file_get_contents(URL::to('storage/app/public/Frontassets/images/icon/calendar.svg')) ?></span>
                    <input class="datepicker datepicker-areapage" name="date" data-date-format="mm/dd/yyyy" placeholder="Datum">
                </li>
                <li class="w-10 ml-auto">
                    <button href="javascript:void(0)" class="btn btn-blue btn-filter-search serach_btn" type="button">
                    Jetzt suchen
                    </button>
                </li>
            </ul>
        </div>
    </section>

    <section class="filter-wrap-main">
        <div class="container">
            <div class="filter-wrap">
                <p><span class="total_store">{{count($getStore)}}</span> Suchergebnisse</p>
                <div class="filter-right-info">
                    <label class="switch">
                        <input type="checkbox" class="map_toggle" checked>
                        <span class="slider round"></span>
                        <p>Karte</p>
                    </label>
                    <label class="switch">
                        <input type="checkbox" checked="checked" class="booking_toggle">
                        <span class="slider round"></span>
                        <p>Buchungssystem</p>
                    </label>
                    <label class="switch">
                        <input type="checkbox" class="discount_toggle">
                        <span class="slider round"></span>
                        <p>Rabatte</p>
                    </label>
                    <div class="filter-box">
                        <a class="filter-box-icon" data-toggle="modal" data-target="#filterModal"
                           href="javascript:void(0)"><?php echo file_get_contents(URL::to('storage/app/public/Frontassets/images/icon/filtter.svg')) ?></a>
                    </div>
                    <select class="select sort_data">
                        <option>Sortieren</option>
                        <option value="ASC">A-Z</option>
                        <option value="DESC">Z-A</option>
                    </select>
                </div>
            </div>
        </div>
    </section>

    <section class="area-section">
        <div class="container">
            <div class="row google-rowws">
                <div class="col-lg-5 google_map" style="display: block;">
                    <div class="area-section-map" id="area-section-map">

                    </div>
                </div>
                <div class="col-lg-7 search_div">
                    @forelse($getStore as $key=>$row)
                        @php $ids[] = $row->id; @endphp
                        <div class="area-item-wrap" onmouseenter="showme({!! $key !!});">
                            <div class="area_img">
                                <div class="owl-carousel owl-theme area-img-owl" id="area-img-owl">
                                    <div class="item"
                                         onclick="window.location.href='{{URL::to('kosmetik/'.$row['slug'])}}'">
                                        <div class="area-img">
                                            <img
                                                src="{{URL::to('storage/app/public/store/'.(($row->store_profile == '')?'Store-6058bde8bf5a8.JPEG':$row->store_profile))}}"
                                                alt="">
                                        </div>
                                    </div>
                                    @foreach($row->storeGallery as $item)
                                        <div class="item"
                                             onclick="window.location.href='{{URL::to('kosmetik/'.$row['slug'])}}'">
                                            <div class="area-img">
                                                <img src="{{URL::to('storage/app/public/store/gallery/'.$item->file)}}"
                                                     alt="">
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                @if($row->discount != 0)
                                    <p class="disscount-box">%</p>
                                @endif
                            </div>
                            <div class="area_info">
                                <h6 onclick="window.location.href='{{URL::to('kosmetik/'.$row['slug'])}}'">{{$row->store_name}}</h6>
                                <p>
                                    <span><?php echo file_get_contents(URL::to('storage/app/public/Frontassets/images/icon/location.svg')) ?></span>
                                    {{$row->store_address}}</p>
                                <p>
                                    <span><?php echo file_get_contents(URL::to('storage/app/public/Frontassets/images/icon/cream.svg')) ?></span>
                                    Kosmetik</p>
                                <div class="area_info_rating_wrap">
                                    <ul class="rating-ul">
                                        {!! \BaseFunction::getRatingStar($row['rating']) !!}
                                    </ul>
                                    <p>{{\BaseFunction::finalRating($row->id)}} <span> ({{@$row->storeRated->count()}} Bewertungen)</span>
                                    </p>
                                </div>
                                <ul class="area_tag">
                                    @forelse(@$row->storeCategory as $cat)
                                        @if(@$cat->CategoryData->main_category == null)
                                            <li>
                                                {{@$cat->CategoryData->name}}
                                            </li>
                                        @endif
                                    @empty
                                    @endforelse
                                </ul>
                            </div>
                            <div class="area_price">
                                <a class="wishlist_icon {{$row->isFavorite == 'true' ? 'active' : ''}}"
                                   data-id="{{$row['id']}}" href="javascript:void(0)"><i class="far fa-heart"></i></a>
                                <h5>{{$row->is_value}}</h5>
                            </div>
                        </div>
                    @empty
                    @endforelse
                </div>
            </div>
        </div>
    </section>


    <div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button> -->
                    <div class="filter-white-box">
                        <div class="filter-box-header">
                            <h4>Filter</h4>
                        </div>
                        <div class="filter-box-body">
                            <div class="accordion" id="accordionExample">
                            
                                <div class="area-accordion-card">
                                    <a href="#" class="area-accordion-link collapsed" data-toggle="collapse"
                                       data-target="#area-collapseTwo" aria-expanded="true"
                                       aria-controls="area-collapseTwo">
                                        <p>Preisklasse</p>
                                        <span><i class="far fa-chevron-down"></i></span>
                                    </a>
                                    <div id="area-collapseTwo" class="collapse show" aria-labelledby="headingTwo"
                                         data-parent="#accordionExample" style="">
                                        <div class="card-body fp-rating-body">
                                            <div class="star-rating">
                                                <input id="price-5" type="radio" name="value" class="fil_price"
                                                       value="5">
                                                <label for="price-5" title="5 prices">
                                                    <i class="active" aria-hidden="true">€</i>
                                                </label>
                                                <input id="price-4" type="radio" name="value" class="fil_price"
                                                       value="4">
                                                <label for="price-4" title="4 prices">
                                                    <i class="active" aria-hidden="true">€</i>
                                                </label>
                                                <input id="price-3" type="radio" name="value" class="fil_price"
                                                       value="3">
                                                <label for="price-3" title="3 prices">
                                                    <i class="active" aria-hidden="true">€</i>
                                                </label>
                                                <input id="price-2" type="radio" name="value" class="fil_price"
                                                       value="2">
                                                <label for="price-2" title="2 prices">
                                                    <i class="active" aria-hidden="true">€</i>
                                                </label>
                                                <input id="price-1" type="radio" name="value" class="fil_price"
                                                       value="1">
                                                <label for="price-1" title="1 prices">
                                                    <i class="active" aria-hidden="true">€</i>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion" id="accordionExample1">
                                <div class="area-accordion-card">
                                    <a href="#" class="area-accordion-link collapsed" data-toggle="collapse"
                                       data-target="#area-collapseThree" aria-expanded="true"
                                       aria-controls="area-collapseThree">
                                        <p>Bewertungen</p>
                                        <span><i class="far fa-chevron-down"></i></span>
                                    </a>
                                    <div id="area-collapseThree" class="collapse show"
                                         aria-labelledby="headingThree"
                                         data-parent="#accordionExample1" style="">
                                        <div class="card-body star-rating-body">
                                            <div class="star-rating">
                                                <input id="star-5" type="radio" name="rating" class="fil_rating"
                                                       value="5">
                                                <label for="star-5" title="5 stars">
                                                    <i class="active fa fa-star" aria-hidden="true"></i>
                                                </label>
                                                <input id="star-4" type="radio" name="rating" class="fil_rating"
                                                       value="4">
                                                <label for="star-4" title="4 stars">
                                                    <i class="active fa fa-star" aria-hidden="true"></i>
                                                </label>
                                                <input id="star-3" type="radio" name="rating" class="fil_rating"
                                                       value="3">
                                                <label for="star-3" title="3 stars">
                                                    <i class="active fa fa-star" aria-hidden="true"></i>
                                                </label>
                                                <input id="star-2" type="radio" name="rating" class="fil_rating"
                                                       value="2">
                                                <label for="star-2" title="2 stars">
                                                    <i class="active fa fa-star" aria-hidden="true"></i>
                                                </label>
                                                <input id="star-1" type="radio" name="rating" class="fil_rating"
                                                       value="1">
                                                <label for="star-1" title="1 star">
                                                    <i class="active fa fa-star" aria-hidden="true"></i>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion" id="accordionExample2">
                                <div class="area-accordion-card">
                                    <a href="#" class="area-accordion-link" data-toggle="collapse"
                                       data-target="#area-collapseFour" aria-expanded="true"
                                       aria-controls="area-collapseFour">
                                        <p>Eigenschaften</p>
                                        <span><i class="far fa-chevron-down"></i></span>
                                    </a>
                                    <div id="area-collapseFour" class="collapse show" aria-labelledby="headingFour"
                                         data-parent="#accordionExample2" style="">
                                        <div class="card-body specifics-body">
                                            <ul>
                                                @forelse($features as $feature)
                                                    <li>
                                                        <div class="custom-control custom-checkbox area-checkbox">
                                                            <input type="checkbox"
                                                                   class="custom-control-input fil_advatace"
                                                                   value="{{$feature['id']}}"
                                                                   id="areacustomCheck{{$feature['id']}}">
                                                            <label class="custom-control-label"
                                                                   for="areacustomCheck{{$feature['id']}}">{{$feature['name']}}</label>
                                                        </div>
                                                    </li>
                                                @empty
                                                @endforelse
                                            </ul>
                                            <a href="javascript:void(0)">Alle Eigenschaften anzeigen <i class="far fa-chevron-down"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="filter-box-footer">
                            <a href="javascript:void(0)" class="btn btn-filter main-btn">Anwenden</a>
                            <a href="javascript:void(0)" class="clear-filter">Löschen</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" name="stores" id="store_ids" value="{{isset($ids)?implode(',',$ids):''}}">

@endsection
@section('front_js')
    <script>
        $('.nav-pills a').click(function(){
            // pT for previous tab, ct for current tab  
            var tab = $('.nav-pills a');
            var pT = $.grep(tab, function (t) {return t.classList.contains('active') });
            var cT = $(this);

            pT[0].classList.remove('active');
            var pTarget = pT[0].getAttribute('data-target');

            cT.addClass('active');
            var cTarget = cT.attr('data-target');

            if (cTarget===pTarget) return;

            document.querySelector('#'+pTarget).classList.remove('show', 'active');

            console.log(cTarget);
            document.querySelector('#'+cTarget).classList.add('active');
            setTimeout(() => {
                document.querySelector('#'+cTarget).classList.add('show');
            }, 350);

        });
    </script>
    <script
        src="https://maps.google.com/maps/api/js?key=AIzaSyBSItHxCbk9qBcXp1XTysVLYcJick5K8mU&libraries=places"
        type="text/javascript"></script>
    <script type="text/javascript">
		@if(empty($distric))
			localStorage.removeItem('placeviewport');
			localStorage.removeItem('placelocation');
		@endif

        $('.datepicker').datepicker({
            widgetPositioning:{
                                horizontal: 'auto',
                                vertical: 'bottom'
                            }
        });

        var date = new Date('{{$date}}');

        $('.datepicker').datepicker('setDate', date);

        google.maps.event.addDomListener(window, 'load', initialize);
        changeMainC();

        function initialize() {
            var input = document.getElementById('autocomplete');
			$('#distric').val("");
		$('#postal_code').val("");
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
                        }
                    }
                }

            });
        }

        function changeMainC() {
            var cat = '{{$categorieData}}';
            var sub = '{{$sub_cat}}';
            if (cat != '' || sub != '') {
                $.ajax({
                    type: 'GET',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: "{{URL::to('get_sub_cat')}}",
                    data: {cat: cat},
                    beforesend: $('#loading').css('display', 'block'),
                    success: function (response) {
                        // console.log(response.length);
                        // if(response.length > 0){
                        var html = "<option value=''>Unterkategorien</option>";
                        $.each(response, function (i, data) {
                            if (sub == i) {
                                html += "<option value='" + i + "' selected >" + data + "</option>";
                            } else {
                                html += "<option value=" + i + ">" + data + "</option>";
                            }
                        });

                        $('.sub_cat').html(html);

                        $('.sub_cat').niceSelect('update');
                        // $('.sub_cat').niceSelect('update');
                        // }
                        $('#loading').css('display', 'none');
                    },
                    error: function (error) {


                    }
                });
            }

        }

        $(document).on('keyup','#autocomplete',function (){
            var value = $(this).val();
            if(value == ''){
                $('#postal_code').val('');
				 $('#distric').val('');
            }
			$('#distric').val("");
		$('#postal_code').val("");
            console.log(value);
        });

        $('.main_cate').on('change', function () {
            var cat = $(this).val();
            $.ajax({
                type: 'GET',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: "{{URL::to('get_sub_cat')}}",
                data: {cat: cat},
                beforesend: $('#loading').css('display', 'block'),
                success: function (response) {
                    // console.log(response.length);
                    // if(response.length > 0){
                    var html = "<option value='' selected>Unterkategorien</option>";
                    $.each(response, function (i, data) {
                        html += "<option value=" + i + ">" + data + "</option>";
                    });

                    $('.sub_cat').html(html);
                    $('.sub_cat').niceSelect('update');
                    // }
                    $('#loading').css('display', 'none');
                },
                error: function (error) {


                }
            });
        });

        $('.sub_cat').on('change', function () {
            var sub_cat = $(this).val();
            var cat = $('.main_cate').val();
            $.ajax({
                type: 'GET',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: "{{URL::to('get_stores')}}",
                data: {cat: cat, sub_cat: sub_cat},
                beforesend: $('#loading').css('display', 'block'),
                success: function (response) {
                    // console.log(response.length);
                    // if(response.length > 0){
                    var html = "<option>Store</option>";
                    $.each(response, function (i, data) {
                        html += "<option value=" + i + ">" + data + "</option>";
                    });

                    $('.stores').html(html);
                    // $('.stores').niceSelect('update');
                    // }
                    $('#loading').css('display', 'none');
                },
                error: function (error) {


                }
            });
        });

        $(".serach_btn").on('click', function () {
            var sub_cat = $('.sub_cat').val();
            var cat = $('.main_cate').val();
            var stores = $('.stores').val();
            var postal_code = $('input[name="postal_code"]').val();
            var date = $('input[name="date"]').val();
			var distric = $('input[name="distric"]').val();
			var location = $('input[name="location"]').val();
			var search_type = $('input[name="search_type"]').val();
			var search_el = $('input[name="search_el"]').val();


            if (!$('.discount_toggle').is(':checked')) {
                var discount = "no";
            } else {
                var discount = 'yes';
            }

            var data = {
                "_token": "{{ csrf_token() }}",
                categories: cat,
                sub_cat: sub_cat,
                postal_code: postal_code,
                stores: stores,
                date: date,
				search_type: search_type,
				search_el: search_el,
                is_ajax: true,
                discount:discount,
				 distric:distric,
				  location:location,
                plan: "business"
            };

            if (!$('.booking_toggle').is(':checked')) {

                var data = {
                    "_token": "{{ csrf_token() }}",
                    categories: cat,
                    sub_cat: sub_cat,
                    postal_code: postal_code,
                    stores: stores,
                    date: date,
                    is_ajax: true,
                    plan: "not_business",
					distric:distric,
				  location:location,
				  search_type: search_type,
				search_el: search_el,
                    discount:discount

                };
            }

            $.ajax({
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: "{{route('kosmetic.search')}}",
                beforesend: $('#loading').css('display', 'block'),
                data: data,
                success: function (response) {
                    updateSearch(response);
                    markers = []
					map_pin(response);
                    // $('#loading').css('display', 'none');
                },
                error: function (error) {


                }
            });
        });

        function updateSearch(data, is_filter = '') {

            $('.search_div').html('');
            $('.total_store').html(data.length);
            var ids = 0;
            $.each(data, function (i, row) {
                ids = ids + ',' + row.id;
                var html = `<div class="area-item-wrap" onmouseenter="showme(`+i+`);"><div class="area_img"><div class="owl-carousel owl-theme area-img-owl" id="area-img-owl` + row.id + `" class="area-img-owl"><div class="item" onclick="window.location.href='` + baseurl + `/kosmetik/` + row.slug + `'"><div class="area-img">`;
                html += `<img src="{{URL::to('storage/app/public/store/')}}` + '/' + ((row.store_profile == null) ? 'Store-6058bde8bf5a8.JPEG' : row.store_profile) + `" alt="">`;
                html += `</div></div>`;
                $.each(row.storeGallery, function (j, cat) {
                    html += `<div class="item" onclick="window.location.href='` + baseurl + `/kosmetik/` + row.slug + `'"><div class="area-img">`;
                    html += `<img src="{{URL::to('storage/app/public/store/')}}` + '/' + ((row.store_profile == null) ? 'Store-6058bde8bf5a8.JPEG' : row.store_profile) + `" alt="">`;
                    html += `</div></div>`;
                });
                var discount = row.discount == null ? '0' : row.discount;
                html += `</div>`;
                if (discount != 0) {
                    html += `<p class="disscount-box">%</p>`;
                }
                html += `</div><div class="area_info">`;
                html += `<h6 onclick="window.location.href='` + baseurl + `/kosmetik/` + row.slug + `'">` + row.store_name + `</h6>`;
                html += `<p> <span><?php echo file_get_contents(URL::to('storage/app/public/Frontassets/images/icon/location.svg')) ?></span>` + row.store_address + `</p>`
                html += `<p> <span><?php echo file_get_contents(URL::to('storage/app/public/Frontassets/images/icon/cream.svg')) ?></span>Kosmetik`;
                html += `</p><div class="area_info_rating_wrap">`;
                html += `<ul class="rating-ul">`;

                 if (row.rating >= '1.0' && row.rating < '1.5') {
                    html += `<li class="active"><i class="fas fa-star"></i></li><li class=""><i class="fas fa-star"></i></li><li class=""><i class="fas fa-star"></i></li><li class=""><i class="fas fa-star"></i></li><li class=""><i class="fas fa-star"></i></li>`;
                } else if (row.rating >= '1.5' && row.rating < '2.0') {
                    html += `<li class="active"><i class="fas fa-star"></i></li><li class="active"><i class="fas fa-star-half-alt"></i></li><li class=""><i class="fas fa-star"></i></li><li class=""><i class="fas fa-star"></i></li><li class=""><i class="fas fa-star"></i></li>`;
                } else if (row.rating >= '2.0' && row.rating < '2.5') {
                    html += `<li class="active"><i class="fas fa-star"></i></li><li class="active"><i class="fas fa-star"></i></li><li class=""><i class="fas fa-star"></i></li><li class=""><i class="fas fa-star"></i></li><li class=""><i class="fas fa-star"></i></li>`;
                } else if (row.rating >= '2.5' && row.rating < '3.0') {
                    html += `<li class="active"><i class="fas fa-star"></i></li><li class="active"><i class="fas fa-star"></i></li><li class="active"><i class="fas fa-star-half-alt"></i></li><li class=""><i class="fas fa-star"></i></li><li class=""><i class="fas fa-star"></i></li>`;
                } else if (row.rating >= '3.0' && row.rating < '3.5') {
                    html += `<li class="active"><i class="fas fa-star"></i></li><li class="active"><i class="fas fa-star"></i></li><li class="active"><i class="fas fa-star"></i></li><li class=""><i class="fas fa-star"></i></li><li class=""><i class="fas fa-star"></i></li>`;
                } else if (row.rating >= '3.5' && row.rating < '4.0') {
                    html += `<li class="active"><i class="fas fa-star"></i></li><li class="active"><i class="fas fa-star"></i></li><li class="active"><i class="fas fa-star"></i></li><li class="active"><i class="fas fa-star-half-alt"></i></li><li class=""><i class="fas fa-star"></i></li>`;
                } else if (row.rating >= '4.0' && row.rating < '4.5') {
                    html += `<li class="active"><i class="fas fa-star"></i></li><li class="active"><i class="fas fa-star"></i></li><li class="active"><i class="fas fa-star"></i></li><li class="active"><i class="fas fa-star"></i></li><li class=""><i class="fas fa-star"></i></li>`;
                } else if (row.rating >= '4.5' && row.rating < '5.0') {
                    html += `<li class="active"><i class="fas fa-star"></i></li><li class="active"><i class="fas fa-star"></i></li><li class="active"><i class="fas fa-star"></i></li><li class="active"><i class="fas fa-star"></i></li><li class="active"><i class="fas fa-star-half-alt"></i></li>`;
                } else if (row.rating == '5.0') {
                    html += `<li class="active"><i class="fas fa-star"></i></li><li class="active"><i class="fas fa-star"></i></li><li class="active"><i class="fas fa-star"></i></li><li class="active"><i class="fas fa-star"></i></li><li class="active"><i class="fas fa-star"></i></li>`;
                } else if (row.rating == '0.5' && row.rating < '1.0') {
                    html += `<li class=""><i class="fas fa-star-half-alt"></i></li><li class=""><i class="fas fa-star"></i></li><li class=""><i class="fas fa-star"></i></li><li class=""><i class="fas fa-star"></i></li><li class=""><i class="fas fa-star"></i></li>`;
                } else if (row.rating == '0.0') {
                     html += `<li class=""><i class="fas fa-star"></i></li><li class=""><i class="fas fa-star"></i></li><li class=""><i class="fas fa-star"></i></li><li class=""><i class="fas fa-star"></i></li><li class=""><i class="fas fa-star"></i></li>`;
                }
                // html += `<li class="` + ((row.rating > 0) ? 'active' : '') + `"><i class="fas fa-star"></i></li>`;
                // html += `<li class="` + ((row.rating > 1) ? 'active' : '') + `"><i class="fas fa-star"></i></li>`;
                // html += `<li class="` + ((row.rating > 2) ? 'active' : '') + `"><i class="fas fa-star"></i></li>`;
                // html += `<li class="` + ((row.rating > 3) ? 'active' : '') + `"><i class="fas fa-star"></i></li>`;
                // html += `<li class="` + ((row.rating > 4) ? 'active' : '') + `"><i class="fas fa-star"></i></li>`;
                html += `</ul>`;
                html += `<p>` + row.rating + ` <span> (` + row.rating_count + ` Reviews)</span></p>`;
                html += `</div>`;
                html += `<ul class="area_tag">`;
                $.each(row.store_category, function (j, cat) {
                    if (cat.category_data.main_category == null) {
                        html += `<li>`;
                        html += cat.category_data.name;
                        html += `</li>`;
                    }
                });
                html += `</ul>`;
                html += `</div>`;
                html += `<div class="area_price">`;
                var fav = row.isFavorite == 'true' ? 'active' : '';
                html += `<a class="wishlist_icon ` + fav + `" href="javascript:void(0)" data-id="` + row.id + `"><i class="far fa-heart"></i></a>`;
                var is_value = row.is_value == null ? '' : row.is_value;
                html += `<h5>` + is_value + `</h5>`;
                html += `</div>`;
                html += `</div>`;
                if (html != undefined) {
                    $('.search_div').append(html);
                }
                // $.getScript("{{URL::to('storage/app/public/Frontassets/js/owl.carousel.min.js')}}");
                $('.area-img-owl').owlCarousel({
                    loop: true,
                    nav: true,
                    navText: ["<i class='fas fa-chevron-left'></i>", "<i class='fas fa-chevron-right'></i>"],
                    dots: true,
                    responsive: {
                        0: {
                            items: 1
                        }
                    }
                })
            });

            if (is_filter != "filter") {

                $("#store_ids").val(ids);
            }
            $('#loading').css('display', 'none');

        }

        $('.sort_data').on('change', function () {
            var ids = $("#store_ids").val();
            var ord = $(this).val();

            if (ord != "") {
                $.ajax({
                    type: 'POST',
                    async: true,
                    dataType: "json",
                    url: "{{URL::to('sort-data')}}",
                    data: {
                        _token: '{{ csrf_token() }}',
                        ids: ids,
                        ord: ord
                    },
                    beforesend: $('#loading').css('display', 'block'),
                    success: function (response) {
                        updateSearch(response);
                        map_pin(response);
                        // $('#loading').css('display', 'none');
                    },
                    error: function (e) {

                    }
                });
            }

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
                    //beforesend: $('#loading').css('display', 'block'),
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
                                    store_html += '<li><a href="javascript:void(0)" class="select_search" data-type="store" data-value="' + item.search_name + '">' + item.search_name + '</a></li>';
                                }
								if (item.url == 'service') {
                                    service_html += '<li><a href="javascript:void(0)" class="select_search" data-type="service" data-value="' + item.search_name + '">' + item.search_name + '</a></li>';
                                }
                            });
							
							 html += '<div class="tab-content" id="pills-tabContent">';
							 
							  html += '<div class="tab-pane fade  '+show_tab_store+'" id="pills-stores" role="tabpanel" aria-labelledby="pills-stores-tab">';
							 html += '<ul class="search_value" >';
							 if(store_html){
								  html += store_html;
							 }else{
								 html += '<li>No stores found</li>';
							 }
							
							 html += '</ul>';
							 html += '</div>';
							 
							 html += '<div class="tab-pane fade  '+show_tab_service+'" id="pills-services" role="tabpanel" aria-labelledby="pills-services-tab">';
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
                        $('#loading').css('display', 'none');
                    },
                    error: function (e) {

                    }
                });
            } else if (search.length == 0) {
                $('.search_value_data').html('');
            }
        });

        $(document).on('click', '.select_search', function () {
            var value = $(this).data('value');
			var type = $(this).data('type');
			$('#search_type').val(type);
			$('#search_el').val(value);
            $('#search_data').val(value);
			
            $('.search_value_data').html('');

        });

        $(document).on('click', '.map_toggle', function () {
            if ($(this).is(':checked')) {
                $(".google_map").css('display', 'block');
            } else {
                $(".google_map").css('display', 'none');
            }
        });


        var markers = [];
		var allstores = [];
        function map_pin(data) {
			
			markers = [];
			allstores = data;
            var beaches = data;


            if (beaches.length > 0) {
                var lat = beaches[0]['latitude'];
                var lng = beaches[0]['longitude'];
            } else {
                var lat = 51.1657;
                var lng = 10.4515;
            }

             map = new google.maps.Map(document.getElementById('area-section-map'), {
                zoom: 11,
                center: new google.maps.LatLng(lat, lng),
                mapTypeId: google.maps.MapTypeId.ROADMAP,
				mapTypeControl: false
            });

			map.setOptions({styles: styles['hide']});
			
			if(localStorage.getItem('placeviewport')){
				map.fitBounds(localStorage.getItem('placeviewport'));
			} else if(localStorage.getItem('placelocation')){
				map.setCenter(localStorage.getItem('placelocation'));
				map.setZoom(13);
			}

           var infowindow = new google.maps.InfoWindow();

            for (var i = 0; i < beaches.length; i++) {
				var rating = beaches[i]['rating'];
				var filename = "star_"+rating+".svg";
				var cicon = '{{ asset("storage/app/public/Frontassets/images/stars/") }}/'+filename;
                var newMarker = new google.maps.Marker({
                    position: new google.maps.LatLng(beaches[i]['latitude'], beaches[i]['longitude']),
					icon:cicon,
                    map: map,
                    title: beaches[i]['store_name']
                });
				
				console.log(beaches);
                google.maps.event.addListener(newMarker, 'click', (function (newMarker, i) {
					var storeprofileimg = "{{URL::to('storage/app/public/store/')}}" + '/' + ((beaches[i]['store_profile'] == null) ? 'Store-6058bde8bf5a8.JPEG' : beaches[i]['store_profile'])
					if (beaches[i]['store_profile'] != "") {
						$.ajax({
							url: beaches[i]['store_profile_image_path'],
							type: 'HEAD',
							error: function() 
							{
								storeprofileimg = "{{URL::to('storage/app/public/store/')}}" + '/Store-6058bde8bf5a8.JPEG';
							},
							success: function() 
							{
								storeprofileimg = "{{URL::to('storage/app/public/store/')}}" + '/'+beaches[i]['store_profile'];
							}
						});
					} else {
						storeprofileimg = "{{URL::to('storage/app/public/store/')}}" + '/Store-6058bde8bf5a8.JPEG';
					}
					return function () {
						var infobox_html = "";
						var store_url = "{{url('cosmetic')}}/"+beaches[i]['slug'];
						infobox_html += '<a href="javascript:void(0);" onclick="window.location.href=`'+store_url+'`"><img src="'+storeprofileimg+'" style="width:100%;max-height:150px;" alt="'+beaches[i]['store_name']+'">';
						infobox_html += '<div class="infowindow_box"><div class="infowindow_title">'+beaches[i]['store_name']+'</div><div class="d-flex justify-content-between align-items-center"><p class="review-box"><span><i class="fas fa-star"></i></span>'+beaches[i]['rating']+'</p><p class="rcount">'+beaches[i]['store_rated'].length+' Bewertungen</p></div></div></a>';
						infowindow.setContent(infobox_html);
						infowindow.open(map, newMarker);
					}
                })(newMarker, i));

                markers.push(newMarker);
            }
        }
		
		var styles = {
			hide: [
			  {
				featureType: "road",
				elementType: "labels",
				stylers: [
				  { visibility: "off" }
				]
			  }
			]
      };


        map_pin(<?php echo json_encode($getStore) ?>);
		
		var selecteditem = 0;
		showme = function (index) {
			var rating = allstores[index].rating;
			var filename = "star_"+rating+".svg";
			var vicon = '{{ asset("storage/app/public/Frontassets/images/select_stars/") }}/'+filename;
			
			
			if (markers[index].getAnimation() != google.maps.Animation.BOUNCE) {
			    markers[index].setAnimation(google.maps.Animation.BOUNCE);
				markers[index].setIcon(vicon);
				if(selecteditem != index){
					var rating = allstores[selecteditem].rating;
					var filename = "star_"+rating+".svg";
					var cicon = '{{ asset("storage/app/public/Frontassets/images/stars/") }}/'+filename;
					markers[selecteditem].setAnimation(null);
					markers[selecteditem].setIcon(cicon);
				}
				selecteditem  = index;
			} 
		}
		
        $(".filter-box-icon").click(function () {
            $(".filter-box").toggleClass("show");
            $(".area-section").toggleClass("show");
        });

        $('.btn-filter').on('click', function () {
            var ids = $("#store_ids").val();
            var price = $(".fil_price:checked").val();
            var rating = $(".fil_rating:checked").val();
            var advat = [];

            $(".fil_advatace:checked").each(function () {
                advat.push($(this).val());
            });

            // if(ord != ""){
            $.ajax({
                type: 'POST',
                async: true,
                dataType: "json",
                url: "{{URL::to('filter-data')}}",
                data: {
                    _token: '{{ csrf_token() }}',
                    ids: ids,
                    price: price,
                    rating: rating,
                    advat: advat,
                },
                beforesend: $('#loading').css('display', 'block'),
                success: function (response) {
                    updateSearch(response, 'filter');
                    map_pin(response);
                    $(".filter-box").removeClass("show");
                    $(".area-section").removeClass("show");
                    // $('#loading').css('display', 'none');
                    $('#filterModal').modal('toggle');
                },
                error: function (e) {
                    $(".filter-box").toggleClass("show");
                    $(".area-section").toggleClass("show");
                    $('#loading').css('display', 'none');
                }


            });
            // }
        });

        $(".clear-filter").on('click', function () {
            $(".fil_price:checked").prop("checked", false);
            $(".fil_rating:checked").prop("checked", false);
            $(".fil_advatace").prop("checked", false);

            $('.serach_btn').click();

            $(".filter-box").toggleClass("show");
            $(".area-section").toggleClass("show");
        });

        $(".booking_toggle").on('click', function () {
            var sub_cat = $('.sub_cat').val();
            var cat = $('.main_cate').val();
            var stores = $('.stores').val();
            var postal_code = $('input[name="postal_code"]').val();
            var date = $('input[name="date"]').val();
			var distric = $('input[name="distric"]').val();
			var search_type = $('input[name="search_type"]').val();
			var search_el = $('input[name="search_el"]').val();
			var location = $('input[name="location"]').val();

            if (!$('.discount_toggle').is(':checked')) {
                var discount = "no";
            } else {
                var discount = 'yes';
            }


            var data = {
                "_token": "{{ csrf_token() }}",
                categories: cat,
                sub_cat: sub_cat,
                postal_code: postal_code,
                stores: stores,
                date: date,
                is_ajax: true,
                discount: discount, 
				distric: distric, 
				location: location,
				search_type: search_type,
				search_el: search_el,
                plan: "business"
            };

            if (!$('.booking_toggle').is(':checked')) {

                var data = {
                    "_token": "{{ csrf_token() }}",
                    categories: cat,
                    sub_cat: sub_cat,
                    postal_code: postal_code,
					distric: distric, 
					location: location,
                    stores: stores,
                    date: date,
                    is_ajax: true,
                    plan: "not_business",
					search_type: search_type,
					search_el: search_el,
                    discount: discount
                };
            }

            $.ajax({
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: "{{route('kosmetic.search')}}",
                data: data,
                beforesend: $('#loading').css('display', 'block'),
                success: function (response) {
                    var ids = 0;
                    $.each(response, function (i, row) {
                        ids = ids + ',' + row.id;
                    });

                    if (ids.length > 0) {
                        $("#store_ids").val(ids);
                        // $(".btn-filter").click();
                    }
                    updateSearch(response);
                    map_pin(response);
                    $('#loading').css('display', 'none');
                },
                error: function (error) {


                }
            });
        });


        $(".discount_toggle").on('click', function () {
            var sub_cat = $('.sub_cat').val();
            var cat = $('.main_cate').val();
            var stores = $('.stores').val();
            var postal_code = $('input[name="postal_code"]').val();
            var date = $('input[name="date"]').val();
			var distric = $('input[name="distric"]').val();
			var location = $('input[name="location"]').val();
			var search_type = $('input[name="search_type"]').val();
			var search_el = $('input[name="search_el"]').val();

            if (!$('.booking_toggle').is(':checked')) {
                var plan = "not_business";
            } else {
                var plan = 'business';
            }

            var data = {
                "_token": "{{ csrf_token() }}",
                categories: cat,
                sub_cat: sub_cat,
                postal_code: postal_code,
				distric: distric, 
				location: location,
                stores: stores,
                date: date,
                is_ajax: true,
                discount: "no",
				search_type: search_type,
				search_el: search_el,
                plan: plan
            };

            if ($('.discount_toggle').is(':checked')) {

                var data = {
                    "_token": "{{ csrf_token() }}",
                    categories: cat,
                    sub_cat: sub_cat,
                    postal_code: postal_code,
					distric: distric, 
					location: location,
                    stores: stores,
                    date: date,
                    is_ajax: true,
                    discount: "yes",
					search_type: search_type,
				search_el: search_el,
                    plan: plan
                };
            }

            $.ajax({
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: "{{route('kosmetic.search')}}",
                data: data,
                beforesend: $('#loading').css('display', 'block'),
                success: function (response) {
                    var ids = 0;
                    $.each(response, function (i, row) {
                        ids = ids + ',' + row.id;
                    });

                    if (ids.length > 0) {
                        $("#store_ids").val(ids);
                        // $(".btn-filter").click();
                    }
                    updateSearch(response);
                    map_pin(response);

                },
                error: function (error) {


                }
            });
        });


        $(document).on('click', '.wishlist_icon', function () {


            if (authCheck != '') {
                var id = $(this).data('id');

                $.ajax({
                    type: 'POST',
                    async: true,
                    dataType: "json",
                    url: baseurl + '/favorite-store',
                    data: {
                        _token: token,
                        id: id,
                    },
                    beforesend: $('#loading').css('display', 'block'),
                    success: function (response) {
                        var status = response.status;
                        var type = response.data;
                        if (status == 'true') {
                            if (type == 'remove') {
                                $('.wishlist_icon[data-id=' + id + ']').removeClass('active');
                            } else if (type == 'add') {
                                $('.wishlist_icon[data-id=' + id + ']').addClass('active');
                            }
                        } else {

                        }
                        $('#loading').css('display', 'none');
                    },
                    error: function (e) {

                    }
                });
            } else {
                $('.cl_guest').css('display','none');
                $('#login-modal').modal('toggle');
            }
        });
        $('html').addClass('position-class');
		window.onclick = function(e) {
		var container_popup = $('.w-18');

		if (!container_popup.is(e.target) && container_popup.has(e.target).length === 0) {
			$('.search_value_data').html("");
		}
		
	}
    </script>
@endsection
