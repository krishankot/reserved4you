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
                    <p>Service by <span>{{@$row->empDetails->emp_name}}</span></p>
                </div>
            </div>
            @if($row->category_id != '' || $row->service_id != '')
                <p class="review-info-tag-box">{{@$row->categoryDetails->name}}
                    -
                    {{@$row->serviceDetails->service_name}}</p>
            @endif
            <div class="review-info-timeline">
                <p class="review-box"><span><i
                            class="fas fa-star"></i></span> {{$row->total_avg_rating}}</p>
                <h5>{{\Carbon\Carbon::parse($row->created_at)->diffForHumans()}}</h5>
            </div>
        </div>
        <p class="review-information">
            {!! $row->write_comment !!}</p>
        <a href="javascript:void(0)" class="venue-replay-link active">Antwort <i
                class="far fa-chevron-down"></i></a>
        @if(!empty($row->store_replay))
            <div class="venue-replay-info active" style="display: block;">
                <p><i class="far fa-undo-alt"></i> {!! $row->store_replay !!}</p>
                <a href="javascript:void(0)" class="btn btn-black-yellow btn-edit-review edit_review" data-id="{{$row->id}}">Antwort bearbeiten</a>
            </div>
        @else
            <a href="javascript:void(0)" class="btn btn-yellow btn-edit-review mb-3 give_review"
               data-id="{{$row->id}}">Antworten</a>
        @endif
        <a href="javascript:void(0)" class="show-full-ratings-link" data-id="{{$row->id}}">Mehr anzeigen <i
                class="far fa-chevron-down"></i></a>
        <div class="show-full-ratings-info" data-id="{{$row->id}}" style="display: none;">
            <div class="row">
                <div class="col col-sm-6 col-md-4">
                    <div class="ratings-items-box">
                        <ul class="rating-ul">
                            {!! \BaseFunction::getRatingStar($row['service_rate']) !!}
                        </ul>
                        <p>Service &amp; Mitarbeiter</p>
                    </div>
                </div>
                <div class="col col-sm-6 col-md-4">
                    <div class="ratings-items-box">
                        <ul class="rating-ul">
                            {!! \BaseFunction::getRatingStar($row['ambiente']) !!}
                        </ul>
                        <p>Ambiance</p>
                    </div>
                </div>
                <div class="col col-sm-6 col-md-4">
                    <div class="ratings-items-box">
                        <ul class="rating-ul">
                            {!! \BaseFunction::getRatingStar($row['preie_leistungs_rate']) !!}
                        </ul>
                        <p>Preis- Leistung</p>
                    </div>
                </div>
                <div class="col col-sm-6 col-md-4">
                    <div class="ratings-items-box">
                        <ul class="rating-ul">
                            {!! \BaseFunction::getRatingStar($row['wartezeit']) !!}
                        </ul>
                        <p>Wartezeit</p>
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
