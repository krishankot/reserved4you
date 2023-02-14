@forelse($service as $row)
    @if(count($row->variants)==1)
        <div class="service-item-main"  id="service_item{{$row->id}}">
            <div class="service-item-img">
                <img
                    src="{{URL::to('storage/app/public/service/'.$row['image'])}}"
                    alt="">
                @if($row->discount_type != null && $row->discount != '0' && $row->discount != '')
                    <p class="service-discount">{{$row->discount}}
                        <span>{{$row->discount_type == 'percentage' ? '%' : '€'}}</span>
                    </p>
                @endif
            </div>
            <div class="service-item-info">
                <div class="service-action-wrap">
                    <a href="{{URL::to('dienstleister/service-bearbeiten/'.encrypt($row->id))}}"><img
                            src="{{URL::to('storage/app/public/Serviceassets/images/icon/edit-2.svg')}}"
                            alt=""></a>
                     <a class="delete_service" data-id="{{$row->id}}" data-encrypt="{{encrypt($row->id)}}" href="javascript:void(0);"><img
                                                            src="{{URL::to('storage/app/public/Serviceassets/images/icon/delete-3.svg')}}"
                                                            alt=""></a>
                </div>
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
                            @if($row->discount_type != null && $row->discount != '0' && $row->discount != '')
                                <h5>{{number_format(\BaseFunction::finalPriceVariant($row->id,$item['id']),2, ',', '.')}}
                                    €
                                    <span>{{number_format($item['price'],2,',','.')}}€</span>
                                </h5>
                            @else
                                <h5>{{$item['price']}}€</h5>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @else
        <div class="service-item-main" id="service_item{{$row->id}}">
            <div class="service-item-img">
                <img
                    src="{{URL::to('storage/app/public/service/'.$row['image'])}}"
                    alt="">
                @if($row->discount_type != null && $row->discount != '0' && $row->discount != '')
                    <p class="service-discount">{{$row->discount}}
                        <span>{{$row->discount_type == 'percentage' ? '%' : '€'}}</span>
                    </p>
                @endif
            </div>
            <div class="service-item-info">
                <div class="service-action-wrap">
                    <a href="{{URL::to('dienstleister/service-bearbeiten/'.encrypt($row->id))}}"><img
                            src="{{URL::to('storage/app/public/Serviceassets/images/icon/edit-2.svg')}}"
                            alt=""></a>
                     <a class="delete_service" data-id="{{$row->id}}" data-encrypt="{{encrypt($row->id)}}" href="javascript:void(0);"><img
						src="{{URL::to('storage/app/public/Serviceassets/images/icon/delete-3.svg')}}"
						alt=""></a>
                </div>
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
                <div id="sliderr" class="active" style="display: block;">
                    @foreach($row->variants as $item)
                        <div class="service-media-wrap">
                            <div class="service-media-infos">
                                <h6>{{$item['description']}}</h6>
                                <p>{{$item['duration_of_service']}} {{__('Min') }}</p>
                            </div>
                            <div class="price-info">
                                @if($row->discount_type != null && $row->discount != '0' && $row->discount != '')
                                    <h5>{{number_format(\BaseFunction::finalPriceVariant($row->id,$item['id']),2, ',', '.')}}
                                        €
                                        <span>{{number_format($item['price'],2,',','.')}}€</span>
                                    </h5>
                                @else
                                    <h5>{{number_format($item['price'],2, ',', '.')}}€</h5>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
@empty
    <div class="text-center">
        No service Found.
    </div>
@endforelse
