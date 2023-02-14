@extends('layouts.serviceProvider')
@section('service_title')
    View Store Profile
@endsection
@section('service_css')
@endsection
@section('service_content')
    <div class="main-content">
        <div class="backbtnstoreprofile"><a href="{{URL::to('dienstleister/betriebsprofil')}}">
        <i class="fas fa-arrow-left"></i></a>
        </div>
        <section class="about-banner">
            
            <div class="owl-carousel owl-theme" id="about-banner-owl">
                <div class="item">
                    <div class="about-banner-img">
                        @if(file_exists(storage_path('app/public/store/banner/'.$store['store_banner'])) && $store['store_banner'] != '')
                            <img src="{{URL::to('storage/app/public/store/banner/'.$store['store_banner'])}}" alt="">

                        @else
                            <img src="{{URL::to('storage/app/public/default/default_banner.png')}}" alt="">
                        @endif
                    </div>
                </div>
                @forelse($storeGallery as $row)
                    <div class="item">
                        <div class="about-banner-img">
                            <img src="{{URL::to('storage/app/public/store/gallery/'.$row->file)}}" alt="">
                        </div>
                    </div>
                @empty
                @endforelse

            </div>
            <span class="about-banner-after"></span>
        </section>
        <div class="container">
            <div class="about-profile">
                <div class="about-profile-img">
                    @if(file_exists(storage_path('app/public/store/'.$store['store_profile'])) && $store['store_profile'] != '')
                        <img src="{{URL::to('storage/app/public/store/'.$store['store_profile'])}}" alt="">

                    @else
                        <img src="{{URL::to('storage/app/public/store/Store-6058bde8bf5a8.JPEG')}}" alt="">
                    @endif
                    <a href="javascript:void(0)"
                       class="favorite_icon {{$store['isFavorite'] == 'true' ? 'active' : ''}}"
                       data-id="{{$store['id']}}"><i class="far fa-heart"></i></a>
                </div>
                <div class="about-profile-info">
                    <h5>{{$store['store_name']}}</h5>
                    <h6>{{$store['store_address']}}</h6>
                    <ul class="rating-ul">
                        {!! \BaseFunction::getRatingStar($store['rating']) !!}
                    </ul>

                    <p>({{count($feedback)}}) Bewertungen </p>
                </div>
            </div>
            <ul class="about-box">
                <li>
            <span>
                <img src="{{URL::to('storage/app/public/Frontassets/images/icon/service.svg')}}" alt="">
            </span>
                    <h6>Services</h6>
                    <p>{{implode(',',$catlist)}}</p>
                </li>
                <li>
            <span>
                <img src="{{URL::to('storage/app/public/Frontassets/images/icon/clock.svg')}}" alt="">
            </span>
                    <h6>Öffnungszeiten</h6>
                    <p>{{\Carbon\Carbon::now()->translatedFormat('D')}} ({{@$storeToday['start_time']}}
                        - {{@$storeToday['end_time']}}
                        )</p>
                </li>
                <li>
            <span>
                <img src="{{URL::to('storage/app/public/Frontassets/images/icon/call.svg')}}" alt="">
            </span>
                    <h6>Kontakt</h6>
                    <p><a href="tel:{{$store['store_contact_number']}}"
                          style="color: #101928"> {{$store['store_contact_number']}}</a></p>
                </li>
            </ul>
            @if($sstatus == 'off' || @$storeToday['is_off'] == 'on')
                <p class="close-now" style="width:160px !important"><span></span> Geschlossen</p>
            @else
                <p class="open-now"><span></span>open: Geöffnet</p>
            @endif

        </div>
        <section class="about-main-section">
            <div class="container">
                <ul class="nav nav-pills about-pills" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="pills-services-tab" data-toggle="pill" href="#pills-services"
                           role="tab"
                           aria-controls="pills-services" aria-selected="true">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-about-tab" data-toggle="pill" href="#pills-about" role="tab"
                           aria-controls="pills-about" aria-selected="false">Allgemein</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-work-tab" data-toggle="pill" href="#pills-work" role="tab"
                           aria-controls="pills-work" aria-selected="false">Portfolio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-reviews-tab" data-toggle="pill" href="#pills-reviews" role="tab"
                           aria-controls="pills-reviews" aria-selected="false">Bewertungen </a>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-services" role="tabpanel"
                         aria-labelledby="pills-services-tab">
                        <div class="service-row row">
                            <div class="col-lg-3">
                                <div class="box-fixed">
                                    <h4 class="about-title">Services</h4>
                                    <div class="accordion services-accordion" id="accordionExample">
                                        <div style="display: none">{{$i= 1}}</div>
                                        @foreach($categoryData as $row)

                                            <div class="service-accordion-margin">
                                                <a href="javascript:void(0)"
                                                   class="service-link-wrap  {{$i==1 ? '':'collapsed'}}"
                                                   data-toggle="collapse"
                                                   data-target="#{{strtolower(@$row['categorys']['name'])}}_collapseOne"
                                                   aria-expanded="{{$i==1 ? 'true':'false'}}"
                                                   aria-controls="{{strtolower(@$row['categorys']['name'])}}_collapseOne">
                                                    <span><?php echo file_get_contents(URL::to('storage/app/public/category/' . @$row['categorys']['image'])) ?></span>
                                                    {{@$row['categorys']['name']}}
                                                    <span class="downn-arroww"><i
                                                            class="far fa-chevron-down"></i></span>
                                                </a>
                                                <div id="{{strtolower(@$row['categorys']['name'])}}_collapseOne"
                                                     class="collapse @if($i==1) show @endif"
                                                     aria-labelledby="headingOne"
                                                     data-parent="#accordionExample">
                                                    <div class="services-body">
                                                        <ul class="service-bodyy-ul">
                                                            <div style="display: none">{{$j= 1}}</div>
                                                            @foreach($row['subcategory'] as $item)
                                                                <li class="@if($j==1) active @endif">
                                                                    <a href="javascript:void(0)"
                                                                       class="subCategoryChange" data-id="{{$item->id}}"
                                                                       data-category="{{@$row['categorys']['id']}}">
                                                                        <p>{{$item->name}}</p>
                                                                        <i class="far fa-angle-right"></i>
                                                                    </a>
                                                                </li>
                                                                <div style="display: none">{{$j++}}</div>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div style="display: none">{{$i++}}</div>
                                        @endforeach
                                    </div>
                                    {{--                                    <div class="totla-service-wrap">--}}
                                    {{--                                        <div>--}}
                                    {{--                                            <h6><span class="noOfPrice">0</span>€</h6>--}}
                                    {{--                                            <p><span class="noOfService">0</span> Service</p>--}}
                                    {{--                                        </div>--}}
                                    {{--                                        <a href="javascript:void(0)" class="btn main-btn paying-btn">Proceed to Pay</a>--}}
                                    {{--                                    </div>--}}
                                </div>
                            </div>
                            <div class="col-lg-9 service-order">
                                <div class="discount-populer-main">
                                    <h4 class="about-title">Top Discount & Populer</h4>
                                    <div class="popular">
                                        @forelse($service as $row)
                                            @if($row->is_popular == 'yes')
                                                @if(count($row->variants)==1)
                                                    <div class="service-item-main">
                                                        <div class="service-item-img">
                                                            <img
                                                                src="{{URL::to('storage/app/public/service/'.$row['image'])}}"
                                                                alt="">
                                                            @if($row->discount_type != null && $row->discount != '0')
                                                                <p class="service-discount">{{$row->discount}}
                                                                    <span>{{$row->discount_type == 'percentage' ? '%' : '€'}}</span>
                                                                </p>
                                                            @endif
                                                        </div>
                                                        <div class="service-item-info">
                                                            <div class="service-info-top">
                                                                <h6>{{$row->service_name}}</h6>
                                                                <a href="javascript:void(0)" class="showDetails"
                                                                   data-service="{{$row->service_name}}"
                                                                   data-descri="{{$row->description}}"
                                                                   data-image="{{URL::to('storage/app/public/service/'.$row['image'])}}"
                                                                   data-rating="{{$row->rating}}"
                                                                >
                                                                Details anzeigen</a>
                                                            </div>
                                                            <div class="time_price_info">
                                                                @foreach($row->variants as $item)
                                                                    <h6>{{$item['duration_of_service']}} {{__('Min') }}</h6>
                                                                    <div class="price-info">
                                                                        @if($row->discount_type != null && $row->discount != '0')
                                                                            <h5>{{number_format(\BaseFunction::finalPriceVariant($row->id,$item['id']),2, ',', '.')}}
                                                                                €
                                                                                <span>{{number_format($item['price'],2,',','.')}}€</span>
                                                                            </h5>
                                                                        @else
                                                                            <h5>{{number_format($item['price'],2,',','.')}}€</h5>
                                                                        @endif
                                                                        <div style="display: none">
                                                                            @if($row->discount_type != null && $row->discount != '0')
																				@php $newprice = \BaseFunction::finalPriceVariant($row->id,$item['id']); @endphp
                                                                                {{number_format($newprice,2,',','.')}}
                                                                            @else
																				@php $newprice = $item['price']; @endphp
                                                                                 {{number_format($newprice,2,',','.')}}
                                                                            @endif
                                                                        </div>
                                                                        <a class="select--btnn"
                                                                           data-service="{{$row->id}}"
                                                                           data-price="{{$newprice}}"
                                                                           data-store="{{$store['id']}}"
                                                                           data-category="{{$row->category_id}}"
                                                                           data-subcategory="{{$row->subcategory_id}}"
                                                                           data-variant="{{$item['id']}}"
                                                                           href="javascript:void(0)">Wählen</a>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                @elseif(count($row->variants) > 1)
                                                    <div class="service-item-main">
                                                        <div class="service-item-img">
                                                            <img
                                                                src="{{URL::to('storage/app/public/service/'.$row['image'])}}"
                                                                alt="">
                                                            @if($row->discount_type != null && $row->discount != '0')
                                                                <p class="service-discount">{{$row->discount}}
                                                                    <span>{{$row->discount_type == 'percentage' ? '%' : '€'}}</span>
                                                                </p>
                                                            @endif
                                                        </div>
                                                        <div class="service-item-info">
                                                            <div class="service-info-top">
                                                                <h6>{{$row->service_name}}
                                                                    <span id="flip" class="down-arroww flip"
                                                                          data-id="p{{$row->id}}"><i
                                                                            class="far fa-chevron-down"></i></span>
                                                                </h6>
                                                                <a href="javascript:void(0)" class="showDetails"
                                                                   data-service="{{$row->service_name}}"
                                                                   data-descri="{{$row->description}}"
                                                                   data-image="{{URL::to('storage/app/public/service/'.$row['image'])}}"
                                                                   data-rating="{{$row->rating}}"
                                                                >
                                                                Details anzeigen</a>
                                                            </div>
                                                            <div class="time_price_info">
                                                                <h6>{{min(array_map(function($a) { return $a['duration_of_service']; }, $row->variants))}}
                                                                    {{__('Min') }}
                                                                    - {{max(array_map(function($a) { return $a['duration_of_service']; }, $row->variants))}}
                                                                    {{__('Min') }}</h6>
                                                                <div class="price-info">
                                                                    <h5>
                                                                        From {{min(array_map(function($a) { return number_format($a['price'],2,',','.'); }, $row->variants))}}
                                                                        €</h5>
                                                                </div>
                                                            </div>
                                                            <div id="sliderr" class="sliderr" data-id="p{{$row->id}}">
                                                                @foreach($row->variants as $item)
                                                                    <div class="service-media-wrap">
                                                                        <div class="service-media-infos">
                                                                            <h6>{{$item['description']}}</h6>
                                                                            <p>{{$item['duration_of_service']}} {{__('Min') }}</p>
                                                                        </div>
                                                                        <div class="price-info">
                                                                            @if($row->discount_type != null && $row->discount != '0')
                                                                                <h5>{{number_format(\BaseFunction::finalPriceVariant($row->id,$item['id']),2, ',', '.')}}
                                                                                    € <span>{{number_format($item['price'],2, ',', '.')}}€</span>
                                                                                </h5>
                                                                            @else
                                                                                <h5>{{number_format($item['price'],2,',','.')}}
                                                                                    €</h5>
                                                                            @endif
                                                                            <div style="display: none">
                                                                                @if($row->discount_type != null && $row->discount != '0')
																					@php $newprice = \BaseFunction::finalPriceVariant($row->id,$item['id']); @endphp
                                                                                   {{number_format($newprice,2,',','.')}}
                                                                                @else
                                                                                    @php $newprice = $item['price']; @endphp
																					{{number_format($newprice,2,',','.')}}
                                                                                @endif
                                                                            </div>
                                                                            <a class="select--btnn"
                                                                               data-service="{{$row->id}}"
                                                                               data-price="{{$newprice}}"
                                                                               data-store="{{$store['id']}}"
                                                                               data-category="{{$row->category_id}}"
                                                                               data-subcategory="{{$row->subcategory_id}}"
                                                                               data-variant="{{$item['id']}}"
                                                                               href="javascript:void(0)">Wählen</a>
                                                                        </div>
                                                                    </div>
                                                                @endforeach

                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endif
                                        @empty
                                            <div class="text-center">
                                            Keine Bewertungen verfügbar.
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                                <div class="all-services-main">
                                    <h4 class="about-title">Alle Services</h4>
                                    <div class="allService">
                                        @forelse($service as $row)
                                            @if(count($row->variants)==1)
                                                <div class="service-item-main">
                                                    <div class="service-item-img">
                                                        <img
                                                            src="{{URL::to('storage/app/public/service/'.$row['image'])}}"
                                                            alt="">
                                                        @if($row->discount_type != null && $row->discount != '0')
                                                            <p class="service-discount">{{$row->discount}}
                                                                <span>{{$row->discount_type == 'percentage' ? '%' : '€'}}</span>
                                                            </p>
                                                        @endif
                                                    </div>
                                                    <div class="service-item-info">
                                                        <div class="service-info-top">
                                                            <h6>{{$row->service_name}}</h6>
                                                            <a href="javascript:void(0)" class="showDetails"
                                                               data-service="{{$row->service_name}}"
                                                               data-descri="{{$row->description}}"
                                                               data-image="{{URL::to('storage/app/public/service/'.$row['image'])}}"
                                                               data-rating="{{$row->rating}}"
                                                            >
                                                                Zeige Details</a>
                                                        </div>
                                                        <div class="time_price_info">
                                                            @foreach($row->variants as $item)
                                                                <h6>{{$item['duration_of_service']}} {{__('Min') }}</h6>
                                                                <div class="price-info">
                                                                    @if($row->discount_type != null && $row->discount != '0')
                                                                        <h5>{{number_format(\BaseFunction::finalPriceVariant($row->id,$item['id']),2, ',', '.')}}
                                                                            €
                                                                            <span>{{number_format($item['price'],2, ',', '.')}}€</span>
                                                                        </h5>
                                                                    @else
                                                                        <h5>{{number_format($item['price'],2, ',', '.')}}€</h5>
                                                                    @endif
                                                                    <div style="display: none">
                                                                        @if($row->discount_type != null && $row->discount != '0')
																			@php $newprice = \BaseFunction::finalPriceVariant($row->id,$item['id']); @endphp
                                                                            {{number_format($newprice,2, ',', '.')}}
                                                                        @else
                                                                           @php $newprice = $item['price']; @endphp
																			{{number_format($newprice,2, ',', '.')}}
                                                                        @endif
                                                                    </div>
                                                                    <a class="select--btnn"
                                                                       data-service="{{$row->id}}"
                                                                       data-price="{{$newprice}}"
                                                                       data-store="{{$store['id']}}"
                                                                       data-category="{{$row->category_id}}"
                                                                       data-subcategory="{{$row->subcategory_id}}"
                                                                       data-variant="{{$item['id']}}"
                                                                       href="javascript:void(0)">Wählen</a>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            @elseif(count($row->variants) > 1)
                                                <div class="service-item-main">
                                                    <div class="service-item-img">
                                                        <img
                                                            src="{{URL::to('storage/app/public/service/'.$row['image'])}}"
                                                            alt="">
                                                        @if($row->discount_type != null && $row->discount != '0')
                                                            <p class="service-discount">{{$row->discount}}
                                                                <span>{{$row->discount_type == 'percentage' ? '%' : '€'}}</span>
                                                            </p>
                                                        @endif
                                                    </div>
                                                    <div class="service-item-info">
                                                        <div class="service-info-top">
                                                            <h6>{{$row->service_name}}
                                                                <span id="flip" class="down-arroww flip"
                                                                      data-id="{{$row->id}}"><i
                                                                        class="far fa-chevron-down"></i></span>
                                                            </h6>
                                                            <a href="javascript:void(0)" class="showDetails"
                                                               data-service="{{$row->service_name}}"
                                                               data-descri="{{$row->description}}"
                                                               data-image="{{URL::to('storage/app/public/service/'.$row['image'])}}"
                                                               data-rating="{{$row->rating}}"
                                                            >
                                                            Details anzeigen</a>
                                                        </div>
                                                        <div class="time_price_info">
                                                            <h6>{{min(array_map(function($a) { return $a['duration_of_service']; }, $row->variants))}}
                                                                {{__('Min') }}
                                                                - {{max(array_map(function($a) { return $a['duration_of_service']; }, $row->variants))}}
                                                                {{__('Min') }}</h6>
                                                            <div class="price-info">
                                                                <h5>
                                                                    From {{min(array_map(function($a) { return number_format($a['price'],2, ',', '.'); }, $row->variants))}}
                                                                    €</h5>
                                                            </div>
                                                        </div>
                                                        <div id="sliderr" class="sliderr" data-id="{{$row->id}}">
                                                            @foreach($row->variants as $item)
                                                                <div class="service-media-wrap">
                                                                    <div class="service-media-infos">
                                                                        <h6>{{$item['description']}}</h6>
                                                                        <p>{{$item['duration_of_service']}} {{__('Min') }}</p>
                                                                    </div>
                                                                    <div class="price-info">
                                                                        @if($row->discount_type != null && $row->discount != '0')
                                                                            <h5>{{number_format(\BaseFunction::finalPriceVariant($row->id,$item['id']),2)}}
                                                                                € <span>{{number_format($item['price'],2,',','.')}}€</span>
                                                                            </h5>
                                                                        @else
                                                                            <h5>{{number_format($item['price'],2,',','.')}}
                                                                                €</h5>
                                                                        @endif
                                                                        <div style="display: none">
                                                                            @if($row->discount_type != null && $row->discount != '0')
                                                                                @php $newprice =  \BaseFunction::finalPriceVariant($row->id,$item['id']); @endphp
																				{{number_format($newprice,2,',','.')}}
                                                                            @else
                                                                                @php $newprice = $item['price']; @endphp
																				{{number_format($newprice,2,',','.')}}
                                                                            @endif
                                                                        </div>
                                                                        <a class="select--btnn"
                                                                           data-service="{{$row->id}}"
                                                                           data-store="{{$store['id']}}"
                                                                           data-price="{{$newprice}}"
                                                                           data-category="{{$row->category_id}}"
                                                                           data-subcategory="{{$row->subcategory_id}}"
                                                                           data-variant="{{$item['id']}}"
                                                                           href="javascript:void(0)">Wählen</a>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @empty
                                            <div class="text-center">
                                            Keine Bewertungen verfügbar.
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-about" role="tabpanel" aria-labelledby="pills-about-tab">
                        <div class="service-row row">
                            <div class="col-lg-3">
                                <div class="box-fixed">
                                    <div class="a-service-map">
                                        <div class="reservation-about-map" id="map">
                                        </div>
                                    </div>
                                    <div class="a-service-media">
                                <span>
                                    <?php echo file_get_contents(URL::to('storage/app/public/Frontassets/images/icon/pin.svg')) ?>
                                </span>
                                        <div>
                                            <h6>Bezirk</h6>
                                            <p>{{$store['store_district']}}</p>
                                        </div>
                                    </div>
                                    <div class="a-service-media">
                                <span>
                                    <?php echo file_get_contents(URL::to('storage/app/public/Frontassets/images/icon/clock.svg')) ?>
                                </span>
                                        <div>
                                            <h6>Öffnungszeiten</h6>
                                        </div>
                                    </div>
                                    <ul class="a-service-days">
                                        @foreach($storeTiming as $row)
                                            <li class="@if(\Carbon\Carbon::now()->format('l') == $row->day) active @endif">
                                                <p>{{ \Carbon\Carbon::create($row->day)->locale('de_DE')->dayName}}</p>
                                                <p>@if($row->is_off == null){{$row->start_time}}
                                                    - {{$row->end_time}} @else Store Close @endif</p>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="a-service-media">
                                <span>
                                   <?php echo file_get_contents(URL::to('storage/app/public/Frontassets/images/icon/earth.svg')) ?>
                                </span>
                                        <div>
                                            <h6>Webseite</h6>
                                            <a href="{{$store['store_link_id'] == '' ? '#' :$store['store_link_id']}}">{{$store['store_link_id'] == '' ? '-' : $store['store_link_id']}}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-9">
                                @if(count($storeSpecific)>0)
                                    <div class="specifics-main">
                                        <h4 class="about-title">Eigenschaften</h4>
                                        <ul>
                                            @foreach($storeSpecific as $row)
                                                <li>
                                                    <span><?php echo file_get_contents(URL::to('storage/app/public/features/' . @$row->featureData->image)) ?></span>
                                                    Free
                                                    {{@$row->featureData->name}}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <div class="about-discription-main">
                                    <h4 class="about-title">Beschreibung</h4>
                                    {!! $store['store_description'] !!}
                                </div>
                                @if(count($advantages) > 0)
                                    <div class="advantages-main">
                                        <h4 class="about-title">Vorteile</h4>
                                        <div class="row">
                                            @foreach($advantages as $row)
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="advantages-item">
                                                        <span><?php echo file_get_contents(URL::to("storage/app/public/store/advantage/" . $row->image)) ?></span>
                                                        <h6>{{$row->title}}</h6>
                                                        <p>{{$row->description}}</p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif


                                @if($store['store_active_plan'] =='business')
                                    @if(count($expert)>0)
                                        <div class="stylish-main-div">
                                            <div class="stylish-header-wrap">
                                                <h4 class="about-title">Mitarbeiter</h4>
                                                <div class="stylish-header-search">
                                                    <input type="text" placeholder="Find by employee name .."
                                                           id="myInput">
                                                    <a href="#"><i class="far fa-search"></i></a>
                                                </div>
                                                <!-- <a href="#" class="btn main-btn btn-stylish-next">Next</a> -->
                                            </div>
                                            <div class="stylish-body-wrap">
                                                <ul>
                                                    @foreach($expert as $row)
                                                        <li class="expert_li">
                                                            <div class="stylish-profile">
																<span class="experts-imgg">
																	@php
																		$empnameArr = explode(" ", $row->emp_name);
																		$empname = "";
																		if(count($empnameArr) > 1){
																			$empname = strtoupper(substr($empnameArr[0], 0, 1)).strtoupper(substr($empnameArr[1], 0, 1));
																		}else{
																			$empname = strtoupper(substr( $row->emp_name, 0, 2));
																		}
																	@endphp
																	@if(file_exists(storage_path('app/public/store/employee/'.$row->image)) && $row->image != '')
																		<img src="{{URL::to('storage/app/public/store/employee/'.$row->image)}}" alt="" >
																	@else
																		<img src="https://via.placeholder.com/150x150/00000/FABA5F?text={{$empname}}" alt="employee">
																	@endif
																</span>
                                                                <p class="review-box"><span><i
                                                                            class="fas fa-star"></i></span>{{\BaseFunction::finalRatingEmp($row->store_id,$row->id)}}
                                                                </p>
                                                                <h6>{{$row->emp_name}}</h6>
                                                            </div>
                                                            <div class="stylish-profile-reviews">
                                                                <a href="javascript:void(0)"
                                                                   class="profile-reviews-close"><i
                                                                        class="fas fa-times"></i></a>
                                                                <div class="scroll-class">


                                                                    @forelse($row->getReviews as $item)
                                                                        <div class="stylish-profile-review-item">
                                                                            <div class="profile-review-item-wrap">
                                                                                <div class="profile-review-info">
                                                                            <span>
                                                                                @if(file_exists(storage_path('app/public/user/'.@$item->userDetails->profile_pic)) && @$item->userDetails->profile_pic != '')
                                                                                    <img
                                                                                        src="{{URL::to('storage/app/public/user/'.@$item->userDetails->profile_pic)}}"
                                                                                        alt="user">
                                                                                @else
                                                                                    <img
                                                                                        src="https://via.placeholder.com/1080x1080/00000/FABA5F?text={{strtoupper(substr(@$item->userDetails->first_name, 0, 1))}}{{strtoupper(substr(@$item->userDetails->last_name, 0, 1))}}"
                                                                                        alt="user">
                                                                                @endif
                                                                            </span>
                                                                                    <div>
                                                                                        <h6>{{@$item->userDetails->first_name}} {{@$item->userDetails->last_name}}</h6>
                                                                                        <p>{{@$item->categoryDetails->name}}
                                                                                            - {{@$item->serviceDetails->service_name}}</p>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="review-infos">
                                                                                    <p class="review-box"><span><i
                                                                                                class="fas fa-star"></i></span>{{ number_format($item->total_avg_rating,1)}}
                                                                                    </p>
                                                                                    <span>{{\Carbon\Carbon::parse($item->created_at)->diffForHumans()}}</span>
                                                                                </div>
                                                                            </div>
                                                                            <p>{!! $item->write_comment !!}</p>
                                                                            <a href="javascript:void(0)"
                                                                               class="show-full-ratings-link"
                                                                               data-id="emp-{{$item->id}}">mehr anzeigen
                                                                                 <i
                                                                                    class="far fa-chevron-down"></i></a>
                                                                            <div class="show-full-ratings-info"
                                                                                 data-id="emp-{{$item->id}}">
                                                                                <div class="row">
                                                                                    <div class="col-md-4 col-sm-6">
                                                                                        <div class="ratings-items-box">
                                                                                            <ul class="rating-ul">
                                                                                                {!! \BaseFunction::getRatingStar($item['service_rate']) !!}
                                                                                            </ul>
                                                                                            <p>Service & Mitarbeiter</p>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-4 col-sm-6">
                                                                                        <div class="ratings-items-box">
                                                                                            <ul class="rating-ul">
                                                                                                {!! \BaseFunction::getRatingStar($item['ambiente']) !!}
                                                                                            </ul>
                                                                                            <p>Ambiente</p>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-4 col-sm-6">
                                                                                        <div class="ratings-items-box">
                                                                                            <ul class="rating-ul">
                                                                                                {!! \BaseFunction::getRatingStar($item['preie_leistungs_rate']) !!}
                                                                                            </ul>
                                                                                            <p>Preis-Leistung</p>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-4 col-sm-6">
                                                                                        <div class="ratings-items-box">
                                                                                            <ul class="rating-ul">
                                                                                                {!! \BaseFunction::getRatingStar($item['wartezeit']) !!}
                                                                                            </ul>
                                                                                            <p>Wartezeit </p>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-4 col-sm-6">
                                                                                        <div class="ratings-items-box">
                                                                                            <ul class="rating-ul">
                                                                                                {!! \BaseFunction::getRatingStar($item['atmosphare']) !!}
                                                                                            </ul>
                                                                                            <p>Atmosphäre</p>
                                                                                        </div>
                                                                                    </div>

                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                    @empty
                                                                        <div class="text-center">
                                                                        Keine Bewertungen verfügbar.
                                                                        </div>
                                                                    @endforelse
                                                                </div>
                                                            </div>
                                                        </li>
                                                    @endforeach

                                                </ul>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                                @if(count($transport)>0)
                                    <div class="public-main-div">
                                        <h4 class="about-title">Öffentliche Verkehrsmittel </h4>
                                        <h6>Nächste Haltestelle</h6>
                                        <ul>
                                            @foreach($transport as $row)
                                                <li>
                                        <span>
                                            @if(!empty($row->image))
                                            <i><?php echo file_get_contents(URL::to("storage/app/public/store/transportation/" . $row->image)) ?></i>
                                            @endif
                                             {{$row->transportation_no}}
                                        </span>
                                                    <p>{{$row->title}}</p>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-work" role="tabpanel" aria-labelledby="pills-work-tab">
                        <div class="row pillss-row">
                            @forelse($storeGallery as $row)
                                <div class="col-lg-3 col-md-6">
                                    <a class="c-gallery-item" href="{{URL::to('storage/app/public/store/gallery/'.$row->file)}}"
                                       data-fancybox="gallery">
                                        <img src="{{URL::to('storage/app/public/store/gallery/'.$row->file)}}"
                                             alt="">
                                    </a>
                                </div>
                            @empty
                                <div>
                                    <p class="text-center">Leider keine Bilder gefunden.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-reviews" role="tabpanel" aria-labelledby="pills-reviews-tab">
                        <div class="review-row row">
                            <div class="col-lg-3">
                                <div class="review-main-box2">
                                    <div class="review-top-box">
                                        <h5>{{$store['rating']}}/5.0</h5>
                                        <ul class="rating-ul">
                                            {!! \BaseFunction::getRatingStar($store['rating']) !!}
                                        </ul>
                                        <p>({{count($feedback)}}) Bewertungen</p>
                                    </div>
                                    <div class="text-center mb-4">
{{--                                        <a href="javascript:void(0)" class="btn btn-black btn-feedback">Give--}}
{{--                                            Feedback</a>--}}
                                    </div>
                                    <ul class="reviews-ul-info">
                                        <li>
                                            <p>{{number_format($rating['service_rate'],1)}}/5.0</p>
                                            <span>Service & Mitarbeiter</span>
                                        </li>
                                        <li>
                                            <p>{{number_format($rating['ambiente'],1)}}/5.0</p> <span>Ambiente</span>
                                        </li>
                                        <li>
                                            <p>{{number_format($rating['preie_leistungs_rate'],1)}}/5.0</p> <span>Preis-Leistung</span>
                                        </li>
                                        <li>
                                            <p>{{number_format($rating['wartezeit'],1)}}/5.0</p>
                                            <span>Wartezeit </span>
                                        </li>
                                        <li>
                                            <p>{{number_format($rating['atmosphare'],1)}}/5.0</p> <span>Atmosphäre</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-9">
                                <div class="review-info-header">
                                    <h5>Kundenbewertung teilen</h5>
                                    <div class="filter-items-widths">
{{--                                        <div class="filter-box">--}}
{{--                                            <a class="filter-box-icon"--}}
{{--                                               href="javascript:void(0)"><?php echo file_get_contents(URL::to('storage/app/public/Frontassets/images/icon/filtter.svg')) ?></a>--}}
{{--                                        </div>--}}
{{--                                        <select class="select">--}}
{{--                                            <option>Sort by</option>--}}
{{--                                            <option>Newest</option>--}}
{{--                                            <option>Best Ratings</option>--}}
{{--                                            <option>Worst Ratings</option>--}}
{{--                                        </select>--}}
                                    </div>
                                </div>
                                <div class="review-info-search">
                                    <input type="text" placeholder="Find by employee name, service ..">
                                    <a href="javascript:void(0)"><i class="far fa-search"></i></a>
                                </div>
                                <hr class="review-hr"/>
                                <div class="review-info-body">
                                    @forelse($feedback as $row)
                                        <div class="review-info-items">
                                            <div class="review-info-header-wrap">
                                                <div class="review-info-profile">
                                            <span>
                                                @if(file_exists(storage_path('app/public/user/'.@$row->userDetails->profile_pic)) &&
                                                @$row->userDetails->profile_pic != '')
                                                    <img
                                                        src="{{URL::to('storage/app/public/user/'.@$row->userDetails->profile_pic)}}"
                                                        alt="user">
                                                @else
                                                    <img
                                                        src="https://via.placeholder.com/1080x1080/00000/FABA5F?text={{strtoupper(substr(@$row->userDetails->first_name, 0, 1))}}{{strtoupper(substr(@$row->userDetails->last_name, 0, 1))}}"
                                                        alt="user">
                                                @endif
                                            </span>
                                                    <div>
                                                        <h6>{{@$row->userDetails->first_name}} {{@$row->userDetails->last_name}}</h6>
                                                        <p>Service von <span>{{@$row->empDetails->emp_name}}</span></p>
                                                    </div>
                                                    @if($row->category_id != '' || $row->service_id != '')
                                                        <p class="review-info-tag-box review-info-tag-box2">{{@$row->categoryDetails->name}}
                                                            -
                                                            {{@$row->serviceDetails->service_name}}</p>
                                                    @endif
                                                    {{--                                                    <p class="review-info-tag-box review-info-tag-box2">Ladies - Tint re-growth</p>--}}
                                                </div>
                                                <div class="main-review-info-tag-box">
                                                    <p class="review-box"><span><i class="fas fa-star"></i></span>{{number_format($row->total_avg_rating, 1)}}</p>

                                                    <h5>{{\Carbon\Carbon::parse($row->updated_at)->diffForHumans()}}</h5>
                                                </div>
                                            </div>
                                            <p class="review-information">
                                                {!! $row->write_comment !!}</p>
                                            @if(!empty($row->store_replay))
                                                <a href="javascript:void(0)" class="venue-replay-link">Antwort <i
                                                        class="far fa-chevron-down"></i></a>
                                                <div class="venue-replay-info">
                                                    <p><i class="far fa-undo-alt"></i> {!! $row->store_replay !!}</p>
                                                </div>
                                            @endif
                                            <a href="javascript:void(0)" class="show-full-ratings-link"
                                               data-id="{{$row->id}}">mehr anzeigen
                                                 <i
                                                    class="far fa-chevron-down"></i></a>
                                            <div class="show-full-ratings-info" data-id="{{$row->id}}">
                                                <div class="row">
                                                    <div class="col col-sm-6 col-md-4">
                                                        <div class="ratings-items-box">
                                                            <ul class="rating-ul">
                                                                {!! \BaseFunction::getRatingStar($row['service_rate']) !!}
                                                            </ul>
                                                            <p>Service & Mitarbeiter</p>
                                                        </div>
                                                    </div>
                                                    <div class="col col-sm-6 col-md-4">
                                                        <div class="ratings-items-box">
                                                            <ul class="rating-ul">
                                                                {!! \BaseFunction::getRatingStar($row['ambiente']) !!}
                                                            </ul>
                                                            <p>Ambiente</p>
                                                        </div>
                                                    </div>
                                                    <div class="col col-sm-6 col-md-4">
                                                        <div class="ratings-items-box">
                                                            <ul class="rating-ul">
                                                                {!! \BaseFunction::getRatingStar($row['preie_leistungs_rate']) !!}
                                                            </ul>
                                                            <p>Preis-Leistung</p>
                                                        </div>
                                                    </div>
                                                    <div class="col col-sm-6 col-md-4">
                                                        <div class="ratings-items-box">
                                                            <ul class="rating-ul">
                                                                {!! \BaseFunction::getRatingStar($row['wartezeit']) !!}
                                                            </ul>
                                                            <p>Wartezeit </p>
                                                        </div>
                                                    </div>
                                                    <div class="col col-sm-6 col-md-4">
                                                        <div class="ratings-items-box">
                                                            <ul class="rating-ul">
                                                                {!! \BaseFunction::getRatingStar($row['atmosphare']) !!}
                                                            </ul>
                                                            <p>Atmosphäre</p>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="text-center">
                                        Keine Bewertungen verfügbar.
                                        
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

 <div class="modal fade" id="service-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <a href="javascript:void(0)" data-dismiss="modal" class="close-modal-btn"><i
                        class="far fa-times"></i></a>
                <div class="servic-modal-header">
                    <div class="servic-modal-header-wrap">
                        <div class="servic-modal-img">
                            <img src="./assets/images/service-modal-img.jpg" alt="" class="serviceDescImage">
                        </div>
                        <div class="servic-modal-info">
                            <h5 class="serviceDesName">Ladies - Full Head
                                Highlights/Lowlights,
                                Haircut & Style</h5>
                        </div>
                    </div>
                    <div class="service-modal-rating-wrap">
                        <ul class="rating-ul servicerting">
                            <li class="active"><i class="fas fa-star"></i></li>
                            <li class="active"><i class="fas fa-star"></i></li>
                            <li class="active"><i class="fas fa-star"></i></li>
                            <li class="active"><i class="fas fa-star"></i></li>
                            <li class=""><i class="fas fa-star"></i></li>
                        </ul>
                        <p class="serviceDesRating">4.5</p>
                    </div>
                </div>
                <div class="servic-modal-body">
                    <h6>Beschreibung</h6>
                    <div class="serviceDesDescription"></div>
                </div>
                <div class="servic-modal-footer">
                    <a href="javascript:void(0)" data-dismiss="modal">Schließen</a>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('service_js')
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBSItHxCbk9qBcXp1XTysVLYcJick5K8mU&callback=initMap">
    </script>
    <script>
        var lat = "{{$store['latitude']}}";
        var long = "{{$store['longitude']}}";
        var store_id = '{{$store['id']}}';

        var baseurls = '{{URL::to("/")}}';

        function initMap() {
            var mapOptions = {
                zoom: 10,
                center: new google.maps.LatLng(parseFloat(lat), parseFloat(long)),
                mapTypeId: 'roadmap',
                fullscreenControl: false,
                StreetViewControlOptions: false,
                streetViewControl: false,
                streetView: false,

            };
            var map = new google.maps.Map(document.getElementById('map'), mapOptions);

            var goldenGatePosition = {
                lat: parseFloat(lat),
                lng: parseFloat(long)
            };
            var marker = new google.maps.Marker({
                position: goldenGatePosition,
                map: map
            });

        }

        $('#about-banner-owl').owlCarousel({
            loop: true,
            margin: 0,
            nav: true,
            navText: ["<i class='fas fa-chevron-left'></i>", "<i class='fas fa-chevron-right'></i>"],
            dots: true,
            responsive: {
                0: {
                    items: 1
                }
            }
        })

        $(document).ready(function () {
            $(document).on('click', '.flip', function () {
                var id = $(this).data('id');
                $(".sliderr[data-id=" + id + "]").slideToggle("slow");
                $(".sliderr[data-id=" + id + "]").toggleClass("active");
                $(".flip[data-id=" + id + "]").toggleClass("active");
            });


            $(".service-bodyy-ul li").click(function () {
                $('.service-bodyy-ul li').removeClass("active");
                $(this).addClass("active");
            });
            $(".service-item-icon").click(function () {
                $('.service-item-icon').removeClass("active");
                $(this).addClass("active");
            });
            $(".service-sub-item li").click(function () {
                $('.service-sub-item li').removeClass("active");
                $(this).addClass("active");
            });
        });

        $(document).ready(function () {
            $(".venue-replay-link").click(function () {
                $(".venue-replay-info").slideToggle("slow");
                $(".venue-replay-info").toggleClass("active");
                $(".venue-replay-link").toggleClass("active");
            });
            $(document).on('click', '.show-full-ratings-link', function () {
                var id = $(this).data('id');
                $(".show-full-ratings-info[data-id='" + id + "']").slideToggle("slow");
                $(".show-full-ratings-info[data-id='" + id + "']").toggleClass("active");
                $(".show-full-ratings-link[data-id='" + id + "']").toggleClass("active");
            });
        });
        // filter-box //
        $(".filter-box-icon").click(function () {
            $(".filter-box").toggleClass("show");
            $(".area-section").toggleClass("show");
        });
        // filter-box //

        $(document).on('click', '.showDetails', function () {
            var baseurl = '{{URL::to('storage/app/public/service/')}}';
            // alert('hi');
            var service = $(this).data('service');
            var descri = $(this).data('descri');
            var image = $(this).data('image');
            var rating = $(this).data('rating');
            $('.serviceDesName').text(service);
            $('.serviceDescImage').attr('src', image);
            $('.serviceDesRating').text(rating);
            $('.serviceDesDescription').text(descri);
            getRatingStar(rating);

            $('#service-modal').modal('toggle');
        });

        $(document).on('click', '.subCategoryChange', function () {
            var category = $(this).data('category');
            var subCategory = $(this).data('id');
            var store = store_id;
            var _token = '{{ csrf_token() }}';
            var url = '{{URL::to('get-service-list')}}';

            getServiceList(category, subCategory, store, _token, url);
        });

         $(document).on('click', '.showDetails', function () {
            var baseurl = '{{URL::to('storage/app/public/service/')}}';
            // alert('hi');
            var service = $(this).data('service');
            var descri = $(this).data('descri');
            var image = $(this).data('image');
            var rating = $(this).data('rating');
            $('.serviceDesName').text(service);
            $('.serviceDescImage').attr('src', image);
            $('.serviceDesRating').text(rating);
            $('.serviceDesDescription').text(descri);
            getRatingStar(rating);

            $('#service-modal').modal('toggle');
        });

        function getRatingStar(rating) {
            $.ajax({
                type: 'POST',
                async: true,
                dataType: "json",
                url: baseurls + '/get-rating-star',
                data: {
                    _token: token,
                    rating: rating,
                },
                beforesend: $('#loading').css('display', 'block'),
                success: function (response) {
                    var data = response.data;
                    $('.servicerting').html(data);
                    $('#loading').css('display', 'none');
                },
                error: function (e) {

                }
            });
        }

        function getServiceList(category, subCategory, store, _token, url) {
            $.ajax({
                type: 'POST',
                async: true,
                dataType: "json",
                url: url,
                data: {
                    _token: _token,
                    category: category,
                    subCategory: subCategory,
                    store: store,
                },
                beforesend: $('#loading').css('display', 'block'),
                success: function (response) {
                    var status = response.status;
                    var data = response.data;
                    var phtml = '';
                    var html = '';
                    if (status == 'true') {
                        $.each(data, function (index, value) {
                            var discounttype = value.discount_type == "percentage" ? "%" : "€";
                            if (value.is_popular == 'yes') {
                                if (value.variants.length == 1) {
                                    phtml += '<div class="service-item-main">' +
                                        '<div class="service-item-img"><img src="' + value.image + '" alt="">';
                                    if (value.discount_type != null && value.discount != 0) {
                                        phtml += '<p class="service-discount">' + value.discount + '<span>' + discounttype + ' </span>' +
                                            '</p>';
                                    }
                                    phtml += '</div>' +
                                        '<div class="service-item-info">' +
                                        '<div class="service-info-top">' +
                                        '<h6>' + value.service_name + '</h6>\n' +
                                        '<a href="javascript:void(0)" class="showDetails" data-service="' + value.service_name + '" data-descri="' + value.description + '"' +
                                        'data-image="' + value.image + '" data-rating="' + value.rating + '" >' +
                                        'Zeige Details</a>' +
                                        '</div>' +
                                        '<div class="time_price_info">';
                                    $.each(value.variants, function (i, rows) {
                                        phtml += '<h6>' + rows.duration_of_service + ' min</h6>\n' +
                                            '<div class="price-info">';
                                        if (value.discount_type != null && value.discount != 0) {
                                            phtml += ' <h5>' + rows.finalPrice + '€ <span>' + rows.price + '€</span></h5>';
                                        } else {
                                            phtml += '<h5>' + rows.price + '€</h5>';
                                        }
                                        var newPrice = rows.price;
                                        if (value.discount_type != null && value.discount != 0) {
                                            var newPrice = rows.finalPrice;
                                        } else {
                                            var newPrice = rows.price;
                                        }
                                        phtml += '<a class="select--btnn" href="javascript:void(0)"  ' +
                                            'data-service="' + value.id + '"' +
                                            'data-price="' + newPrice + '"' +
                                            'data-store="' + store + '"' +
                                            'data-category="' + value.category_id + '"' +
                                            'data-subcategory="' + value.subcategory_id + '"' +
                                            'data-variant="' + rows.id + '">Wählen</a>' +
                                            '</div>';
                                    });
                                    phtml += '</div>' +
                                        '</div>' +
                                        '</div>';
                                } else if (value.variants.length > 1) {
                                    phtml += '<div class="service-item-main">' +
                                        '<div class="service-item-img"><img src="' + value.image + '" alt="">';
                                    if (value.discount_type != null && value.discount != 0) {
                                        phtml += '<p class="service-discount">' + value.discount + '<span>' + discounttype + ' </span>' +
                                            '</p>';
                                    }
                                    phtml += '</div>' +
                                        '<div class="service-item-info">' +
                                        '<div class="service-info-top">' +
                                        '<h6>' + value.service_name + '' +
                                        '<span id="flip" class="down-arroww flip"' +
                                        'data-id="p' + value.id + '"><i\n' +
                                        'class="far fa-chevron-down"></i></span>' +
                                        '</h6>\n' +
                                        '<a href="javascript:void(0)" class="showDetails" data-service="' + value.service_name + '" data-descri="' + value.description + '"' +
                                        'data-image="' + value.image + '" data-rating="' + value.rating + '" >' +
                                        'Zeige Details</a>' +
                                        '</div>' +
                                        '<div class="time_price_info">' +
                                        '<h6>' + value.minduration + ' min - ' + value.maxduration + ' min </h6>\n' +
                                        '<div class="price-info">' +
                                        '<h5> From ' + value.minprice + ' €</h5>\n' +
                                        '</div>' +
                                        '</div>' +
                                        '<div id="sliderr" class="sliderr" data-id="p' + value.id + '">';
                                    $.each(value.variants, function (i, rows) {
                                        phtml += '<div class="service-media-wrap">\n' +
                                            '<div class="service-media-infos">' +
                                            ' <h6>' + rows.description + '</h6>\n' +
                                            '<p>' + rows.duration_of_service + ' min</p>\n' +
                                            '</div>' +
                                            ' <div class="price-info">';
                                        if (value.discount_type != null && value.discount != 0) {
                                            phtml += ' <h5>' + rows.finalPrice + '€ <span>' + rows.price + '€</span></h5>';
                                        } else {
                                            phtml += '<h5>' + rows.price + '€</h5>';
                                        }
                                        var newPrice = rows.price;
                                        if (value.discount_type != null && value.discount != 0) {
                                            var newPrice = rows.finalPrice;
                                        } else {
                                            var newPrice = rows.price;
                                        }

                                        phtml += '<a class="select--btnn" href="javascript:void(0)"  ' +
                                            'data-service="' + value.id + '"' +
                                            'data-store="' + store + '"' +
                                            'data-price="' + newPrice + '"' +
                                            'data-category="' + value.category_id + '"' +
                                            'data-subcategory="' + value.subcategory_id + '"\n' +
                                            'data-variant="' + rows.id + '">Wählen</a>' +
                                            '</div>' +
                                            '</div>';

                                    });
                                    phtml += '  </div>\n' +
                                        '</div>\n' +
                                        '</div>';

                                }

                            }

                            if (value.variants.length == 1) {
                                html += '<div class="service-item-main">' +
                                    '<div class="service-item-img"><img src="' + value.image + '" alt="">';
                                if (value.discount_type != null && value.discount != 0) {
                                    html += '<p class="service-discount">' + value.discount + '<span>' + discounttype + ' </span>' +
                                        '</p>';
                                }
                                html += '</div>' +
                                    '<div class="service-item-info">' +
                                    '<div class="service-info-top">' +
                                    '<h6>' + value.service_name + '</h6>\n' +
                                    '<a href="javascript:void(0)" class="showDetails" data-service="' + value.service_name + '" data-descri="' + value.description + '"' +
                                    'data-image="' + value.image + '" data-rating="' + value.rating + '" >' +
                                    'Zeige Details</a>' +
                                    '</div>' +
                                    '<div class="time_price_info">';
                                $.each(value.variants, function (i, rows) {
                                    html += '<h6>' + rows.duration_of_service + ' min</h6>\n' +
                                        '<div class="price-info">';
                                    if (value.discount_type != null && value.discount != 0) {
                                        html += '<h5>' + rows.finalPrice + '€ <span>' + rows.price + '€</span></h5>';
                                    } else {
                                        html += '<h5>' + rows.price + '€</h5>';
                                    }
                                    var newPrice = rows.price;
                                    if (value.discount_type != null && value.discount != 0) {
                                        var newPrice = rows.finalPrice;
                                    } else {
                                        var newPrice = rows.price;
                                    }
                                    html += '<a class="select--btnn" href="javascript:void(0)"  ' +
                                        'data-service="' + value.id + '"' +
                                        'data-store="' + store + '"' +
                                        'data-price="' + newPrice + '"' +
                                        'data-category="' + value.category_id + '"' +
                                        'data-subcategory="' + value.subcategory_id + '"' +
                                        'data-variant="' + rows.id + '">Wählen</a>' +
                                        '</div>';
                                });
                                html += '</div>' +
                                    '</div>' +
                                    '</div>';
                            } else if (value.variants.length > 1) {
                                html += '<div class="service-item-main">' +
                                    '<div class="service-item-img"><img src="' + value.image + '" alt="">';
                                if (value.discount_type != null && value.discount != 0) {
                                    html += '<p class="service-discount">' + value.discount + '<span>' + discounttype + ' </span>' +
                                        '</p>';
                                }
                                html += '</div>' +
                                    '<div class="service-item-info">' +
                                    '<div class="service-info-top">' +
                                    '<h6>' + value.service_name +
                                    '<span id="flip" class="down-arroww flip"' +
                                    'data-id="' + value.id + '"><i ' +
                                    'class="far fa-chevron-down"></i></span>' +
                                    '</h6>\n' +
                                    '<a href="javascript:void(0)" class="showDetails" data-service="' + value.service_name + '" data-descri="' + value.description + '"' +
                                    'data-image="' + value.image + '" data-rating="' + value.rating + '" >' +
                                    'Zeige Details</a>' +
                                    '</div>' +
                                    '<div class="time_price_info">' +
                                    '<h6>' + value.minduration + ' min - ' + value.maxduration + ' min </h6>\n' +
                                    '<div class="price-info">' +
                                    '<h5> From ' + value.minprice + ' €</h5>\n' +
                                    '</div>' +
                                    '</div>' +
                                    '<div id="sliderr" class="sliderr" data-id="' + value.id + '">';
                                $.each(value.variants, function (i, rows) {
                                    html += '<div class="service-media-wrap">\n' +
                                        '<div class="service-media-infos">' +
                                        ' <h6>' + rows.description + '</h6>\n' +
                                        '<p>' + rows.duration_of_service + ' min</p>\n' +
                                        '</div>' +
                                        ' <div class="price-info">';
                                    if (value.discount_type != null && value.discount != 0) {
                                        html += ' <h5>' + rows.finalPrice + '€ <span>' + rows.price + '€</span></h5>';
                                    } else {
                                        html += '<h5>' + rows.price + '€</h5>';
                                    }
                                    var newPrice = rows.price;
                                    if (value.discount_type != null && value.discount != 0) {
                                        var newPrice = rows.finalPrice;
                                    } else {
                                        var newPrice = rows.price;
                                    }

                                    html += '<a class="select--btnn" href="javascript:void(0)"  ' +
                                        'data-service="' + value.id + '"' +
                                        'data-store="' + store + '"' +
                                        'data-price="' + newPrice + '"' +
                                        'data-category="' + value.category_id + '"' +
                                        'data-subcategory="' + value.subcategory_id + '"\n' +
                                        'data-variant="' + rows.id + '">Wählen</a>' +
                                        '</div>' +
                                        '</div>';

                                });
                                html += '  </div>\n' +
                                    '</div>\n' +
                                    '</div>';

                            }
                        });

                        $('.popular').html(phtml);
                        $('.allService').html(html);

                        var getServiceData = localStorage.getItem('selectedService');
                        if ((getServiceData == undefined) || (getServiceData == '')) {
                            var SelectedService = [];
                        } else {
                            var SelectedService = jQuery.parseJSON(getServiceData);
                        }

                        SelectedService.forEach((num, index) => {
                            $('.select--btnn[data-variant=' + num.variant + ']').toggleClass("active");
                            $('.select--btnn[data-variant=' + num.variant + ']').text('Selected');
                        });

                    } else {
                        phtml += ' <div class="text-center">\n' +
                            'No service Found.\n' +
                            '</div>';
                        html += ' <div class="text-center">\n' +
                            'No service Found.\n' +
                            '</div>';
                        $('.popular').html(phtml);
                        $('.allService').html(html);


                    }
                    $('#loading').css('display', 'none');
                },
                error: function (e) {

                }
            });
        }
    </script>
@endsection
