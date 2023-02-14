@extends('layouts.front')
@section('front_title')
Einstellungen
@endsection
@section('front_css')
@endsection
@section('front_content')
    <section class="d-margin notification-section">
        <div class="container">
            <h5 class="setting-title">Einstellungen</h5>

            <div class="row setting-row">
                <div class="col-md-12">
                    @if(Session::has('message'))
                        {!! Session::get('message') !!}
                    @endif
                </div>
                <div class="col-xl-3">
                    <div class="nav flex-column nav-pills setting-flex-pills" id="v-pills-tab" role="tablist"
                         aria-orientation="vertical">
                        <a class="nav-link active" id="v-pills-password-tab" data-toggle="pill" href="#v-pills-password"
                           role="tab" aria-controls="v-pills-password" aria-selected="true">
                            <span
                                class="setting-pill-icon"><?php echo file_get_contents(URL::to('storage/app/public/Frontassets/images/profile/password.svg')) ?></span>
                            Passwort ändern
                        </a>
                        <a class="nav-link" id="v-pills-reviews-tab" data-toggle="pill" href="#v-pills-reviews"
                           role="tab" aria-controls="v-pills-reviews" aria-selected="false">
                            <span
                                class="setting-pill-icon"><?php echo file_get_contents(URL::to('storage/app/public/Frontassets/images/profile/star.svg')) ?></span>
                                Meine Bewertungen
                        </a>
                        <a class="nav-link" id="v-pills-about-tab" data-toggle="pill" href="#v-pills-about" role="tab"
                           aria-controls="v-pills-about" aria-selected="false">
                            <span
                                class="setting-pill-icon"><?php echo file_get_contents(URL::to('storage/app/public/Frontassets/images/profile/about-us.svg')) ?></span>
                                Über Uns
                        </a>
                        <a class="nav-link" id="v-pills-terms-tab" data-toggle="pill" href="#v-pills-terms" role="tab"
                           aria-controls="v-pills-terms" aria-selected="false">
                            <span
                                class="setting-pill-icon"><?php echo file_get_contents(URL::to('storage/app/public/Frontassets/images/profile/terms.svg')) ?></span>
                                AGB
                        </a>
                        <a class="nav-link" id="v-pills-cancelation-tab" data-toggle="pill" href="#v-pills-cancelation"
                           role="tab" aria-controls="v-pills-cancelation" aria-selected="false">
                            <span
                                class="setting-pill-icon"><?php echo file_get_contents(URL::to('storage/app/public/Frontassets/images/profile/policy.svg')) ?></span>
                                Stornierungsrichtlinien
                        </a>
                        <a class="nav-link" id="v-pills-privacy-tab" data-toggle="pill" href="#v-pills-privacy"
                           role="tab" aria-controls="v-pills-privacy" aria-selected="false">
                            <span
                                class="setting-pill-icon"><?php echo file_get_contents(URL::to('storage/app/public/Frontassets/images/profile/privacy.svg')) ?></span>
                                Datenschutz
                        </a>
                    </div>
                    <a href="javascript:void(0)" class="nav-link-delete delete_profile">
                        <span><?php echo file_get_contents(URL::to('storage/app/public/Frontassets/images/profile/delete.svg')) ?></span>
                        Profil löschen
                    </a>
                </div>
                <div class="col-xl-9">
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-pills-password" role="tabpanel"
                             aria-labelledby="v-pills-password-tab">
                            {{Form::open(array('url'=>'change-password','method'=>'post','name'=>'change-password','class'=>'change-passowrd-form'))}}
                            <div class="passowrd-input">
                                <input type="password" placeholder="Altes Passwort" name="old_password" required
                                       class="@error('old_password') is-invalid @enderror">
                                <span><img
                                        src="{{URL::to('storage/app/public/Frontassets/images/profile/lock.svg')}}"
                                        alt=""></span>
                                @error('old_password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="passowrd-input">
                                <input type="password" placeholder="Neues Passwort" name="new_password" required
                                       class="@error('new_password') is-invalid @enderror">
                                <span><img
                                        src="{{URL::to('storage/app/public/Frontassets/images/profile/lock.svg')}}"
                                        alt=""></span>
                                @error('new_password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="passowrd-input">
                                <input type="password" placeholder="Bestätige dein Passwort" name="confirm_password"
                                       required class="@error('confirm_password') is-invalid @enderror">
                                <span><img
                                        src="{{URL::to('storage/app/public/Frontassets/images/profile/lock.svg')}}"
                                        alt=""></span>
                                @error('confirm_password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-block main-btn">Passwort ändern</button>
                            {{Form::close()}}
                        </div>
                        <div class="tab-pane fade" id="v-pills-reviews" role="tabpanel"
                             aria-labelledby="v-pills-reviews-tab">
                            @forelse($getReview as $row)
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
                                                        src="https://via.placeholder.com/150x150/00000/FABA5F?text={{strtoupper(substr(@$row->userDetails->first_name, 0, 1))}}{{strtoupper(substr($row->userDetails->last_name, 0, 1))}}"
                                                        alt="user">
                                                @endif
                                            </span>
                                            <div>
                                                <h6>{{$row->userDetails->first_name}} {{$row->userDetails->last_name}}</h6>
                                                <p>Service von <span>{{@$row->empDetails->emp_name}}</span></p>
                                            </div>
                                        </div>
                                        <div class="main-review-info-tag-box">
                                            <p class="review-info-tag-box">{{@$row->categoryDetails->name}} -
                                                {{@$row->serviceDetails->service_name}}</p>
                                            <h5>{{\Carbon\Carbon::parse($row->updated_at)->diffForHumans()}}</h5>
                                        </div>
                                    </div>
                                     <div class="setting-store-detail" onclick="window.location.href='{{URL::to('kosmetik/'.@$row->storeDetaials->slug)}}'">
                                          <span><?php echo file_get_contents(URL::to('storage/app/public/Frontassets/images/icon/location.svg')) ?></span>
                                          <div class="setting-store-info">
                                        <h5>{{@$row->storeDetaials->store_name}}</h5>
                                        <p>{{@$row->storeDetaials->store_address}}</p>
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
                                    <a href="javascript:void(0)" class="show-full-ratings-link" data-id="{{$row->id}}">Mehr anzeigen
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
                                                    <p>Preis - Leistung</p>
                                                </div>
                                            </div>
                                            <div class="col col-sm-6 col-md-4">
                                                <div class="ratings-items-box">
                                                    <ul class="rating-ul">
                                                        {!! \BaseFunction::getRatingStar($row['wartezeit']) !!}
                                                    </ul>
                                                    <p>Waiting periodWartezeit</p>
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
                                Leider keine Bewertungen gefunden.
                                </div>
                            @endforelse
                           
                        </div>
                        <div class="tab-pane fade" id="v-pills-about" role="tabpanel"
                             aria-labelledby="v-pills-about-tab">
                            <div class="setting-about-info">
                                <h4><span><img
                                            src="{{URL::to('storage/app/public/Frontassets/images/logo.png')}}"
                                            alt=""></span></h4>
                                <p>Bequem und schnell buchen – das ist der neue Trend.
                                Wie unser System funktioniert? Ganz einfach: Wir
                                schaffen Verbindungen. Und zwar kombinieren wir
                                Buchungen, Übersichtslisten und weitere vorteilhafte
                                Funktionen in mehreren verschiedenen Bereichen.
                                Damit seid ihr für die Zukunft gewappnet.
                                </p>
                                <form class="setting-about-form" action="{{URL::to('/contact-us')}}" method="POST" name="contact_form">
                                    @csrf
                                    <h5>Fragen & Anmerkungen</h5>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="about-input">
                                                <input type="text" placeholder="Your full name" name="name" required value="{{Auth::user()->first_name}} {{Auth::user()->last_name}}">
                                            </div>
                                            <div class="about-input">
                                                <input type="email" placeholder="Your email address" name="email" required value="{{Auth::user()->email}}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="about-input about-textarea">
                                                <textarea placeholder="Bitte gib hier deine Frage oder Nachricht ein. .." name="message" required></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <button href="javascript:void(0)" type="submit" class="btn btn-send main-btn btn-block">Senden
                                        </button>
                                </form>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-pills-terms" role="tabpanel" aria-labelledby="v-pills-terms-tab">
							@include('Includes/Front/AGB')
                        </div>
                        <div class="tab-pane fade" id="v-pills-cancelation" role="tabpanel"  aria-labelledby="v-pills-cancelation-tab">
                            @include('Includes/Front/stornierung')
                        </div>
                        <div class="tab-pane fade" id="v-pills-privacy" role="tabpanel"
                             aria-labelledby="v-pills-privacy-tab">
                             @include('Includes/Front/datenschutz')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="delete-profile-modal" tabindex="-1" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
                <div class="modal-body confirmation-modal-body">
                    <div class="confirmation-modal mb-5">
                        <h5>Bestätigung</h5>
                        <p>Bist du sicher, dass du dein Profil
löschen möchtest ?</p>
{{--                        <div class="confirmation-modal-wrap">--}}
{{--                            <span>--}}
{{--                                <img src="{{URL::to('storage/app/public/Frontassets/images/profile/insurance.svg')}}" alt="">--}}
{{--                            </span>--}}
{{--                            <div>--}}
{{--                                <h5>Stornierungsrichtlinien</h5>--}}
{{--                                <a href="{{URL::to('cancellation-policy')}}" target="_blank">Richtlinien anzeigen</a>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                    </div>
                    <button type="button" class="btn btn-black btn-block btn-yes confirm_delete">Ja, löschen!
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('front_js')
    <script>
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

            $(document).on('click', '.delete_profile', function () {
                $('#delete-profile-modal').modal('toggle');
            });

            $(document).on('click','.confirm_delete',function (){
                    window.location.href="{{ route('users.deleteProfile') }}";
            });
			
			$('a[data-toggle="pill"]').on('shown.bs.tab', function (e) {
			  var target = $(e.target).attr("href") // activated tab
			 if(target == "#v-pills-cancelation"){
				  $('html,body').animate({
					scrollTop: $("#stornierung").offset().top - 70
				}, 'fast');
			 }
			});
			
        });
    </script>
@endsection
