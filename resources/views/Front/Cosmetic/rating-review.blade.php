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
                    @if(@$row->empDetails->emp_name != '')
                        <p>Service by <span>{{@$row->empDetails->emp_name}}</span></p>
                    @endif
                </div>
                @if($row->category_id != '' || $row->service_id != '')
                    <p class="review-info-tag-box review-info-tag-box2">{{@$row->categoryDetails->name}}
                        -
                        {{@$row->serviceDetails->service_name}}</p>
                @endif
            </div>
            <div class="main-review-info-tag-box">
                <p class="review-box"><span><i class="fas fa-star"></i></span>{{$row->total_avg_rating}}</p>

                <h5>{{\Carbon\Carbon::parse($row->updated_at)->diffForHumans()}}</h5>
            </div>
        </div>
        <p class="review-information">
            {!! $row->write_comment !!}</p>
        @if(!empty($row->store_replay))
            <a href="javascript:void(0)" class="venue-replay-link">Venue replay <i
                    class="far fa-chevron-down"></i></a>
            <div class="venue-replay-info">
                <p><i class="far fa-undo-alt"></i> {!! $row->store_replay !!}</p>
            </div>
        @endif
        <a href="javascript:void(0)" class="show-full-ratings-link"
           data-id="{{$row->id}}">Show full
            ratings <i
                class="far fa-chevron-down"></i></a>
        <div class="show-full-ratings-info" data-id="{{$row->id}}">
            <div class="row">
                <div class="col col-sm-6 col-md-4">
                    <div class="ratings-items-box">
                        <ul class="rating-ul">
                            {!! \BaseFunction::getRatingStar(ceil($row['service_rate'])) !!}
                        </ul>
                        <p>Service & staff</p>
                    </div>
                </div>
                <div class="col col-sm-6 col-md-4">
                    <div class="ratings-items-box">
                        <ul class="rating-ul">
                            {!! \BaseFunction::getRatingStar(ceil($row['ambiente'])) !!}
                        </ul>
                        <p>Ambiance</p>
                    </div>
                </div>
                <div class="col col-sm-6 col-md-4">
                    <div class="ratings-items-box">
                        <ul class="rating-ul">
                            {!! \BaseFunction::getRatingStar(ceil($row['preie_leistungs_rate'])) !!}
                        </ul>
                        <p>Price-Performance Ratio</p>
                    </div>
                </div>
                <div class="col col-sm-6 col-md-4">
                    <div class="ratings-items-box">
                        <ul class="rating-ul">
                            {!! \BaseFunction::getRatingStar(ceil($row['wartezeit'])) !!}
                        </ul>
                        <p>Waiting period</p>
                    </div>
                </div>
                <div class="col col-sm-6 col-md-4">
                    <div class="ratings-items-box">
                        <ul class="rating-ul">
                            {!! \BaseFunction::getRatingStar(ceil($row['atmosphare'])) !!}
                        </ul>
                        <p>Atmosphere</p>
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
