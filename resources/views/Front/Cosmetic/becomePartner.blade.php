@extends('layouts.front')
@section('front_title')
    Become Partner
@endsection
@section('front_css')
<link type="text/css" rel="stylesheet" href="{{URL::to('storage/app/public/Frontassets/css/plans.css')}}"/>
<style>
.modal-backdrop.show{z-index:99;}
header{z-index:9;}
</style>
 
@endsection
@section('front_content')

    <!-- Business banner -->
    <section class="d-margin business-banner-section">
        <div class="container">
            <div class="business-banner-info">
                <h2>Professionell auftreten und Kunden gewinnen – mit unserer Unterstützung</h2>
                <!-- <a href="#" class="btn main-btn btn-partner" data-toggle="modal" data-target="#new-appointment-modal">Jetzt
                    Partner werden</a> -->
					<a href="https://www.reserved4you.de/vertrag/" class="btn main-btn btn-partner" target="_blank">Jetzt
                    Partner werden</a>
					
                <div class="business-banner-img">
                    <span><img src="{{URL::to('storage/app/public/Frontassets/images/banner-hand.svg')}}" alt=""></span>
                    <img src="{{URL::to('storage/app/public/Frontassets/images/business-banner.jpg')}}" alt="">
                </div>
            </div>
        </div>
    </section>

    <section class="business-bluee">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="business-left-info">
                        <h6>Organisieren Sie Ihren Arbeitsalltag noch einfacher und schneller.
                        </h6>
                        <h4> Bringen Sie Ihren Salon
                            auf unsere digitale Plattform</h4>
                    </div>
                </div>
                <div class="col-lg-8">
                    <ul class="business-right-ul">
                        <li>
                            <h5>{{ \BaseFunction::getStatisticWebsite('provider') }}+</h5>
                            <p>zufriedene Geschäftspartner</p>
                        </li>
                        <li>
                            <h5>{{ \BaseFunction::getStatisticWebsite('appointments') }}+</h5>
                            <p>gebuchte Termine</p>
                        </li>
                        <li>
                            <h5>{{ \BaseFunction::getStatisticWebsite('customer') }}+</h5>
                            <p>aktive Nutzer</p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- <section class="client-profile">
        <div class="container">
            <div class="row client-profile-rows justify-content-center align-items-center">
                <div class="col-lg-2 col-md-2 col-2">
                    <div class="client-img">
                        <img src="{{URL::to('storage/app/public/Frontassets/images/client-1.png')}}" alt="">
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-2">
                    <div class="client-img">
                        <img src="{{URL::to('storage/app/public/Frontassets/images/client-2.png')}}" alt="">
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-2">
                    <div class="client-img">
                        <img src="{{URL::to('storage/app/public/Frontassets/images/client-3.png')}}" alt="">
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-2">
                    <div class="client-img">
                        <img src="{{URL::to('storage/app/public/Frontassets/images/client-4.png')}}" alt="">
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-2">
                    <div class="client-img">
                        <img src="{{URL::to('storage/app/public/Frontassets/images/client-5.png')}}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section> -->

    <section class="">
        <div class="container">
            <ul class="nav nav-pills area-pills business-pills" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="pills-advantages-tab" data-toggle="pill" href="#pills-advantages"
                       role="tab" aria-controls="pills-advantages" aria-selected="true">Vorteile</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="pills-features-tab" data-toggle="pill" href="#pills-features" role="tab"
                       aria-controls="pills-features" aria-selected="false">Funktionen</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="pills-pricing-plans-tab" data-toggle="pill" href="#pills-pricing-plans"
                       role="tab" aria-controls="pills-pricing-plans" aria-selected="false">Pakete</a>
                </li>
            </ul>
            <div class="tab-content owl-buttons" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-advantages" role="tabpanel"
                     aria-labelledby="pills-advantages-tab">
                    <div class="row advantages_rows">
                        <div class="col-lg-6 col-md-6">
                            <div class="advantages_item_img">
                                <img src="{{URL::to('storage/app/public/Frontassets/images/advantages-item-1.png')}}"
                                     alt="">
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-6">
                            <div class="advantages_item_info">
                            <span>
                                <img src="{{URL::to('storage/app/public/Frontassets/images/icon/advantages-1.svg')}}"
                                     alt="">
                            </span>
                                <h5> Keine Kosten pro Buchung oder Kunde</h5>
                                <p>Keine Berechnung nach Umsatz oder Anzahl der Kunden, keine versteckten Extrakosten:
                                    Wir offerieren Ihnen einen unschlagbaren Festpreis –
                                    das heißt, alle Kosten sind transparent.</p>
                            </div>
                        </div>
                    </div>
                    <div class="row advantages_rows">
                        <div class="col-lg-5 col-md-6">
                            <div class="advantages_item_info">
                            <span>
                                <img src="{{URL::to('storage/app/public/Frontassets/images/icon/advantages-2.svg')}}"
                                     alt="">
                            </span>
                                <h5> Flexible Terminvereinbarung</h5>
                                <p>Flexibel und übersichtlich Termine vereinbaren, verschieben oder stornieren:
                                    Dadurch behalten Sie stets den Überblick und können bei Bedarf schnell reagieren.
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 item-orders">
                            <div class="advantages_item_img">
                                <img src="{{URL::to('storage/app/public/Frontassets/images/advantages-item-2.png')}}"
                                     alt="">
                            </div>
                        </div>
                    </div>
                    <div class="row advantages_rows">
                        <div class="col-lg-6 col-md-6">
                            <div class="advantages_item_img">
                                <img src="{{URL::to('storage/app/public/Frontassets/images/advantages-item-3.png')}}"
                                     alt="">
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-6">
                            <div class="advantages_item_info">
                            <span>
                                <img src="{{URL::to('storage/app/public/Frontassets/images/icon/advantages-3.svg')}}"
                                     alt="">
                            </span>
                                <h5> Höhere Umsätze durch reserved4you</h5>
                                <p>Das Potenzial optimal ausnutzen –
                                    mit uns vergrößern Sie Ihre Reichweite und verbessern Ihren Service in allen
                                    Bereichen.</p>
                            </div>
                        </div>
                    </div>
                    <div class="row advantages_rows">
                        <div class="col-lg-5 col-md-6">
                            <div class="advantages_item_info">
                            <span>
                                <img src="{{URL::to('storage/app/public/Frontassets/images/icon/advantages-4.svg')}}"
                                     alt="">
                            </span>
                                <h5> Mehr Effizienz bei
                                    Planung und Zeitmanagement</h5>
                                <p>Den Erfolg optimieren –
                                    bei reserved4you unterstützen wir Sie mit einem modernen Planungstool bei der
                                    effizienten Zeitplanung, die Sie und Ihren Salon nach vorne bringt.</p>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 item-orders">
                            <div class="advantages_item_img">
                                <img src="{{URL::to('storage/app/public/Frontassets/images/advantages-item-4.png')}}"
                                     alt="">
                            </div>
                        </div>
                    </div>
                    <div class="row advantages_rows">
                        <div class="col-lg-6 col-md-6">
                            <div class="advantages_item_img">
                                <img src="{{URL::to('storage/app/public/Frontassets/images/advantages-item-5.png')}}"
                                     alt="">
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-6">
                            <div class="advantages_item_info">
                            <span>
                                <img src="{{URL::to('storage/app/public/Frontassets/images/icon/advantages-5.svg')}}"
                                     alt="">
                            </span>
                                <h5> Übersichtliche Listen
                                    & unkomplizierte Terminbuchung</h5>
                                <p>Eine übersichtliche Auflistung aller Partner im jeweiligen Bereich bringt Ihre
                                    Zielgruppe zu Ihnen.
                                    Außerdem profitieren Ihre Kunden von der unkomplizierten Terminbuchung:
                                    - Auswahl von Datum, Zeit und Mitarbeiter.</p>
                            </div>
                        </div>
                    </div>
                    <div class="row advantages_rows">
                        <div class="col-lg-5 col-md-6">
                            <div class="advantages_item_info">
                            <span>
                                <img src="{{URL::to('storage/app/public/Frontassets/images/icon/advantages-6.svg')}}"
                                     alt="">
                            </span>
                                <h5>Sichere Zahlung</h5>
                                <p>Überzeugen Sie Ihre Kundschaft durch eine Vielfalt von Zahlungsmethoden und einfache
                                    Bezahlung.
                                    Vorab Bezahlung durch PayPal, Klarna, Sofort Überweisung, Kreditkarten etc. möglich,
                                    oder selbstverständlich vor Ort.</p>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 item-orders">
                            <div class="advantages_item_img">
                                <img src="{{URL::to('storage/app/public/Frontassets/images/advantages-item-6.png')}}"
                                     alt="">
                            </div>
                        </div>
                    </div>
                    <div class="row advantages_rows">
                        <div class="col-lg-6 col-md-6">
                            <div class="advantages_item_img">
                                <img src="{{URL::to('storage/app/public/Frontassets/images/advantages-item-7.png')}}"
                                     alt="">
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-6">
                            <div class="advantages_item_info">
                            <span>
                                <img src="{{URL::to('storage/app/public/Frontassets/images/icon/advantages-7.svg')}}"
                                     alt="">
                            </span>
                                <h5> Innovatives Werbekonzept & Feedback</h5>
                                <p>Zielorientierte Marketing-Maßnahmen –
                                    so erreichen Sie die gewünschte Zielgruppe und verbessern Ihre Reichweite – eine
                                    Stärkung für Ihren gesamten Betrieb. Zusätzlich sorgen aktuelle Bewertungen für mehr
                                    Präsenz auf unsere Homepage und auf Social Media.</p>
                            </div>
                        </div>
                    </div>
                    <div class="row advantages_rows">
                        <div class="col-lg-5 col-md-6">
                            <div class="advantages_item_info">
                            <span>
                                <img src="{{URL::to('storage/app/public/Frontassets/images/icon/advantages-8.svg')}}"
                                     alt="">
                            </span>
                                <h5> Extra Services</h5>
                                <p>Vorteile nutzen – Wir bieten Ihnen eine Reihe von Extra Services, wodurch Sie alle
                                    geschäftlichen Abläufe mit unserer Unterstützung optimieren können.</p>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 item-orders">
                            <div class="advantages_item_img">
                                <img src="{{URL::to('storage/app/public/Frontassets/images/advantages-item-8.png')}}"
                                     alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-features" role="tabpanel" aria-labelledby="pills-features-tab">
                    <div class="row advantages_rows2 pink-after">
                        <div class="col-lg-7 col-md-6">
                            <div class="advantages_item_img">
                                <img src="{{URL::to('storage/app/public/Frontassets/images/features-img-1.png')}}"
                                     alt="">
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-6">
                            <div class="advantages_item_info">
                                <h5> Statistiken & Finanzen</h5>
                                <p>Über die Finanzen können Sie auf alle Zahlen zugreifen: Die Statistiken geben Ihnen einen guten Überblick über Erträge, Abhebungen, Erstattungen usw.</p>
                            </div>
                        </div>
                    </div>
                    <div class="row advantages_rows2 green-after">
                        <div class="col-lg-5 col-md-6">
                            <div class="advantages_item_info">
                                <h5> Profil Management</h5>
                                <p>Wichtig für die Vernetzung und den guten Überblick: Die übersichtlichen Tools helfen Ihnen dabei, ein individuelles Profil zu erstellen und die Zielgruppe zu erreichen.</p>
                            </div>
                        </div>
                        <div class="col-lg-7 col-md-6 item-orders">
                            <div class="advantages_item_img">
                                <img src="{{URL::to('storage/app/public/Frontassets/images/features-img-2.png')}}"
                                     alt="">
                            </div>
                        </div>
                    </div>
                    <div class="row advantages_rows2 blue-after">
                        <div class="col-lg-7 col-md-6">
                            <div class="advantages_item_img">
                                <img src="{{URL::to('storage/app/public/Frontassets/images/features-img-3.png')}}"
                                     alt="">
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-6">
                            <div class="advantages_item_info">
                                <h5> Mitarbeiter Verwaltung</h5>
                                <p>Mit der nutzerfreundlichen Software teilen Sie Ihr Personal optimal ein – für eine reibungslose Effizienz im alltäglichen Betrieb.</p>
                            </div>
                        </div>
                    </div>
                    <div class="row advantages_rows2 yellow-after">
                        <div class="col-lg-5 col-md-6">
                            <div class="advantages_item_info">
                                <h5> Termine organisieren</h5>
                                <p>Buchungen erledigen und den Service zum richtigen Zeitpunkt durchführen – mit dem innovativen System von reserved4you erledigen Sie alle Aufgaben ohne Verzögerung.</p>
                            </div>
                        </div>
                        <div class="col-lg-7 col-md-6 item-orders">
                            <div class="advantages_item_img">
                                <img src="{{URL::to('storage/app/public/Frontassets/images/features-img-4.png')}}"
                                     alt="">
                            </div>
                        </div>
                    </div>
                    <div class="row advantages_rows2 green--after">
                        <div class="col-lg-7 col-md-6">
                            <div class="advantages_item_img">
                                <img src="{{URL::to('storage/app/public/Frontassets/images/features-img-5.png')}}"
                                     alt="">
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-6">
                            <div class="advantages_item_info">
                                <h5>Kalender</h5>
                                <p>Für das Personal ebenso wichtig für die Kunden: Der Kalender gibt Ihnen einen guten Überblick über die Reservierungen. Die Termine haben Sie damit stets zur Hand.</p>
                            </div>
                        </div>
                    </div>
                    <div class="row advantages_rows2 blue--after">
                        <div class="col-lg-5 col-md-6">
                            <div class="advantages_item_info">
                                <h5> Kunden Verwaltung</h5>
                                <p>Spezielle Wünsche bei der Terminbuchung eingeben – die Individualisierung Ihrer Leistungen für die Kunden verstärkt die Bindung und erhöht das Vertrauen.</p>
                            </div>
                        </div>
                        <div class="col-lg-7 col-md-6 item-orders">
                            <div class="advantages_item_img ">
                                <img src="{{URL::to('storage/app/public/Frontassets/images/features-img-6.png')}}"
                                     alt="">
                            </div>
                        </div>
                    </div>
                    <div class="features-items-owl-section">
                        <div class="owl-carousel owl-theme" id="features-items-owl">
                            <div class="item">
                                <div class="testimonial-features-items">
                                    <div class="row">
                                        <div class="col-lg-5 col-md-5">
                                            <div class="features-profle">
                                                <img
                                                    src="{{URL::to('storage/app/public/Frontassets/images/testimonial.jpg')}}"
                                                    alt="">
                                            </div>
                                        </div>
                                        <div class="col-lg-7 col-md-6">
                                            <div class="features-profle-info">
                                                <span><img
                                                        src="{{URL::to('storage/app/public/Frontassets/images/icon/left-quote.svg')}}"
                                                        alt=""></span>
                                                <p>"I joined Reserve4you, thinking it was just a
                                                    salon listing site that would help me get
                                                    new clients. But it turned out to be so
                                                    much more than that. I ended up with a
                                                    whole software system for running my
                                                    business."</p>
                                                <h5>Elen Holder</h5>
                                                <h6>- Beauty Bar London</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="testimonial-features-items">
                                    <div class="row">
                                        <div class="col-lg-5 col-md-5">
                                            <div class="features-profle">
                                                <img
                                                    src="{{URL::to('storage/app/public/Frontassets/images/testimonial.jpg')}}"
                                                    alt="">
                                            </div>
                                        </div>
                                        <div class="col-lg-7 col-md-6">
                                            <div class="features-profle-info">
                                                <span><img
                                                        src="{{URL::to('storage/app/public/Frontassets/images/icon/left-quote.svg')}}"
                                                        alt=""></span>
                                                <p>"I joined Reserve4you, thinking it was just a
                                                    salon listing site that would help me get
                                                    new clients. But it turned out to be so
                                                    much more than that. I ended up with a
                                                    whole software system for running my
                                                    business."</p>
                                                <h5>Elen Holder</h5>
                                                <h6>- Beauty Bar London</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-pricing-plans" role="tabpanel"
                     aria-labelledby="pills-pricing-plans-tab">
                    <div class="pricing-title-info">
                        <h4>Sie haben die Wahl</h4>
                        <p>Mit dem Basic Plus und Business Paket haben Sie Zugang zu noch mehr Funktionen und Vorteilen
                        </p>
                    </div>
                    <div class="monthly_annually_plans">
						<div class="monthly_annually_plans-wrap">
							<ul class="nav nav-pills recommandedmonthlyannuallplan" id="pills-tab" role="tablist">
								<li class="nav-item aaf" role="presentation" onclick="plan_type='Monthly';">
									<a class="nav-link monthlyplan active " at="Monthly" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Monatlich</a>
								</li>

								<li class="nav-item aaf" role="presentation" onclick="plan_type='Annually';">
									<!-- <input type="radio" class="custom_radio" id="huey" name="plan" value="Annually" checked> -->
									<a name="plan" class="nav-link monthlyplan " at="Annually" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Jährlich</a>
								</li>

							</ul>
							<div class="saveplannow">
								<p>Spare <span>120€ </span>jährlich</p>
							</div>
						</div>
					</div>
					<div class="tab-content" id="pills-tabContent">
						<div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
							<div class="container chooseplan">
								<div class="row justify-content-center">
									<!-- Basic plans -->
									<div class="col-lg-4 col-md-6 ">
										<label for="plans-1" class="plans-label">
											<input type="radio" name="plans" id="plans-1" data-id="plans-1">
											<div class="plans" onclick="plan='Basic',amount='0';">
												<div class="basicplanimg">
													<img src="{{asset('public/asset_front/assets/images/basic.svg')}}" class="basic">
												</div>
												<h2>Basic</h2>
												<p class="auflis">Auflistung</p>
												<div class="pricemonthly" onclick="amount='0';">
													<h1>0€ </h1>
													<div class="cancelprice">
														<h5> / Pro Monat</h5>
													</div>
												</div>
												<div class="facilty">
													<div class="facility1">
														<img src="{{asset('public/asset_front/assets/images/id_card.svg')}}">
														<p>Auflistung auf reserved4you </p>
													</div>
													<div class="facility2">
														<img src="{{asset('public/asset_front/assets/images/computer.svg')}}">
														<p>Optimiert für mobile Endgeräte</p>
													</div>
													<div class="facility3">
														<img src="{{asset('public/asset_front/assets/images/support.svg')}}">
														<p> 48h E-Mail Support</p>
													</div>
													<!-- <div class="facility4">
														<img src="{{asset('public/asset_front/assets/images/news.svg')}}">
														<p>Individueller Newsletter</p>
													</div>
													<div class="facility5">
														<img src="{{asset('public/asset_front/assets/images/megaphone.svg')}}">
														<p>Werbung auf reserved4you + Social Media</p>
													</div> -->
												</div>
												<div class="recruitmentfee">
													<p>Recruitment Fee : <span>0€ </span>
													</p>
													<p>Cancellation Time: <span>/</span>
													</p>
												</div>
												<div class="selectbtn">
													<p class="selectbtntext" data-id="plans-1">Auswählen</p>
												</div>
											</div>
										</label>
									</div>
									<!-- Basic plan end -->
									<!-- Basic plus plan -->
									<div class="col-lg-4 col-md-6 ">
										<label for="plans-2" class="plans-label plan-2">
											<input type="radio" name="plans" id="plans-2" data-id="plans-2">
											<div class="plans" onclick="plan='Basic Plus',amount='39.99';">
												<div class="basicplanimg">
													<img src="{{asset('public/asset_front/assets/images/basic-plus.svg')}}" class="basic">
												</div>
												<h2>Basic Plus</h2>
												<p class="auflis"> Auflistung + Profilgestaltung</p>
												<div class="pricemonthly">
													<h1 id="plans2"> 39,99€</h1>
													<div class="cancelprice">
														<h5> / Pro Monat</h5>
													</div>
												</div>
												<div class="facilty">
													<div class="facility1">
														<img src="{{asset('public/asset_front/assets/images/id_card.svg')}}">
														<p>Auflistung auf reserved4you </p>
													</div>
													<div class="facility2">
														<img src="{{asset('public/asset_front/assets/images/computer.svg')}}">
														<p>Optimiert für mobile Endgeräte</p>
													</div>
													<div class="facility3">
														<img src="{{asset('public/asset_front/assets/images/support.svg')}}">
														<p>48h E-Mail Support, Live Chat</p>
													</div>
													<div class="facility3">
														<img src="{{asset('public/asset_front/assets/images/eigner.svg')}}">
														<p>eigener Admin Bereich</p>
													</div>
													
												</div>
												<div class="recruitmentfee">
													<p>Einstellungsgebühr : <span>50€</span>
													</p>
													<div class="recruitmentfee-info"><p>Kündigungsfrist:  <div class="cancelation-time"><span> 2 Wochen</span></div></div>
													</p>
												</div>
												<div class="selectbtn">
													<p class="selectbtntext" data-id="plans-2">Auswählen</p>
												</div>
											</div>
										</label>
									</div>
									<!-- Basic plus plan end -->
									<!-- Bussiness plan -->
									<div class="col-lg-4 col-md-6 ">
										<label for="plans-3" class="plans-label plan-3">
											<input type="radio" name="plans" id="plans-3"  data-id="plans-3">
											<div class="plans" onclick="plan='Business',amount='79.99';">
												<div class="basicplanimg">
													<img src="{{asset('public/asset_front/assets/images/business-plan.svg')}}" class="basic">
												</div>
												<h2>Business</h2>
												<div class="ribbon ribbon-top-right"><span>6 Monate kostenlos</span></div>
												<p class="auflis">Auflistung + Profilgestaltung <br> + Buchungssystem</p>
												<div class="pricemonthly">
													<h1  id="plans3">79,99€ </h1>
													<div class="cancelprice">
														<h5> / Pro Monat</h5>
													</div>
												</div>
												<div class="facilty">
													<div class="facility1">
														<img src="{{asset('public/asset_front/assets/images/id_card.svg')}}">
														<p>Auflistung auf reserved4you</p>
													</div>
													<div class="facility2">
														<img src="{{asset('public/asset_front/assets/images/computer.svg')}}">
														<p>Optimiert für mobile Endgerät</p>
													</div>
													<div class="facility2">
														<img src="{{asset('public/asset_front/assets/images/profile.svg')}}">
														<p>24h E-Mail Support, Live Chat, Telefonsupport</p>
													</div>
													<div class="facility2">
														<img src="{{asset('public/asset_front/assets/images/reception.svg')}}">
														<p>eigener Admin Bereich</p>
													</div>
													<div class="facility3">
														<img src="{{asset('public/asset_front/assets/images/support.svg')}}">
														<p>Newslettermarketing</p>
													</div>
													<div class="facility4">
														<img src="{{asset('public/asset_front/assets/images/news-letter.svg')}}">
														<p>Werbung auf reserved4you + Social Media</p>
													</div>
													<div class="facility5">
														<img src="{{asset('public/asset_front/assets/images/buchu.svg')}}">
														<p>BUCHUNGSSYSTEM</p>
													</div>
													<div class="facility5">
														<img src="{{asset('public/asset_front/assets/images/manage.svg')}}">
														<p>Managementtools</p>
													</div>
													<div class="facility5">
														<img src="{{asset('public/asset_front/assets/images/koste.svg')}}">
														<p>kostenlose Schulung</p>
													</div>
													<div class="facility5">
														<img src="{{asset('public/asset_front/assets/images/indi-news.svg')}}">
														<p>individueller Newsletter</p>
													</div>
													<div class="facility5">
														<img src="{{asset('public/asset_front/assets/images/stat.svg')}}">
														<p>Statistiken</p>
													</div>
												</div>
												<div class="recruitmentfee">
													<p>Einstellungsgebühr : <span>100€ </span>
													</p>
													<div class="recruitmentfee-info"><p>Kündigungsfrist:  <div class="cancelation-time"><span> 2 Wochen</span></div></div>
													</p>
												</div>
												<div class="selectbtn">
													<p class="selectbtntext" data-id="plans-3">Auswählen</p>
												</div>
											</div>
										</label>
									</div>
									<!-- Bussiness plan end -->
								</div>
							</div>
						</div>
						<div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
							<div class="container chooseplan">
								<div class="row">
									<!-- Basic plan -->
									<div class="col-lg-4">
										<label for="plans-4" class="plans-label">
											<input type="radio" name="plans" id="plans-4"  data-id="plans-4">
											<div class="plans" onclick="plan='Basic',amount='0';">
												<div class="basicplanimg">
													<img src="{{asset('public/asset_front/assets/images/basic.svg')}}" class="basic">
												</div>
												<h2>Basic</h2>
												<p class="auflis">Auflistung </p>
												<div class="pricemonthly" >
													<h1>0€ </h1>
													<div class="cancelprice">
														<h5> / Pro Monat</h5>
													</div>
												</div>
												<div class="facilty">
													<div class="facility1">
														<img src="{{asset('public/asset_front/assets/images/id_card.svg')}}">
														<p>Auflistung auf reserved4you inkl. Profilgestaltung</p>
													</div>
													<div class="facility2">
														<img src="{{asset('public/asset_front/assets/images/computer.svg')}}">
														<p>Optimiert fur mobile Endgerate</p>
													</div>
													<div class="facility3">
														<img src="{{asset('public/asset_front/assets/images/support.svg')}}">
														<p>Support 24/7 - Live Chat, E-Mail</p>
													</div>
													<!-- <div class="facility4">
														<img src="{{asset('public/asset_front/assets/images/news.svg')}}">
														<p>Individueller Newsletter</p>
													</div>
													<div class="facility5">
														<img src="{{asset('public/asset_front/assets/images/megaphone.svg')}}">
														<p>Werbung auf reserved4you + Social Media</p>
													</div> -->
												</div>
												<div class="recruitmentfee">
													<p>Einstellungsgebühr : <span>0€ </span>
													</p>
													<p>Kündigungsfrist : <span>/</span>
													</p>
												</div>
												<div class="selectbtn">
													<p class="selectbtntext" data-id="plans-4">Auswählen</p>
												</div>
											</div>
										</label>
									</div>
									<!-- Basic end -->
									<!-- Basic plus plan -->
									<div class="col-lg-4">
										<label for="plans-5" class="plans-label">
											<input type="radio" name="plans" id="plans-5"  data-id="plans-5">
											<div class="plans" onclick="plan='Basic Plus',amount='29.99';">
												<div class="basicplanimg">
													<img src="{{asset('public/asset_front/assets/images/basic-plus.svg')}}" class="basic">
												</div>
												<h2>Basic Plus</h2>
												<p class="auflis">Auflistung + Profilgestaltung</p>
												<div class="pricemonthly">
													<h1  id="plans5">29,99€ </h1>
													<div class="cancelprice">
														<!-- <h6>43,99€ </h6> -->
														<h5> / Pro Monat</h5>
													</div>
												</div>
												<div class="facilty">
													<div class="facility1">
														<img src="{{asset('public/asset_front/assets/images/id_card.svg')}}">
														<p> Auflistung auf reserved4you </p>
													</div>
													<div class="facility2">
														<img src="{{asset('public/asset_front/assets/images/computer.svg')}}">
														<p>Optimiert für mobile Endgeräte</p>
													</div>
													<div class="facility3">
														<img src="{{asset('public/asset_front/assets/images/support.svg')}}">
														<p>48h E-Mail Support, Live Chat</p>
													</div>
													<div class="facility3">
														<img src="{{asset('public/asset_front/assets/images/eigner.svg')}}">
														<p>eigener Admin Bereich</p>
													</div>

												</div>
												<div class="recruitmentfee">
													<p>Einstellungsgebühr : <span>50€</span>
													</p>
													<div class="recruitmentfee-info"><p>Kündigungsfrist:  <div class="cancelation-time"><span> 4 Wochen</span></div></div>
													</p>
												</div>
												<div class="selectbtn">
													<p class="selectbtntext" data-id="plans-5">Auswählen</p>
												</div>
											</div>
										</label>
									</div>
									<!-- Basic plus plan end -->
									<!-- Bussiness plan -->
									<div class="col-lg-4">
										<label for="plans-6" class="plans-label">
											<input type="radio" name="plans" id="plans-6"  data-id="plans-6">
											<div class="plans" onclick="plan='Business',amount='69.99';">
												<div class="basicplanimg">
													<img src="{{asset('public/asset_front/assets/images/business-plan.svg')}}" class="basic">
												</div>
												<h2>Business</h2>
												<div class="ribbon ribbon-top-right"><span>6 Monate kostenlos</span></div>
												<p class="auflis"> Auflistung + Profilgestaltung <br> + Buchungssystem</p>
												<div class="pricemonthly">
													<h1  id="plans6">69,99€ </h1>
													<div class="cancelprice">
														<!-- <h6>83,99€ </h6> -->
														<h5> / Pro Monat</h5>
													</div>
												</div>
												<div class="facilty">
													<div class="facility1">
														<img src="{{asset('public/asset_front/assets/images/id_card.svg')}}">
														<p>Auflistung auf reserved4you</p>
													</div>
													<div class="facility2">
														<img src="{{asset('public/asset_front/assets/images/computer.svg')}}">
														<p>Optimiert für mobile Endgeräte</p>
													</div>
													<div class="facility2">
														<img src="{{asset('public/asset_front/assets/images/profile.svg')}}">
														<p>24h E-Mail Support, Live Chat, Telefonsupport</p>
													</div>
													<div class="facility2">
														<img src="{{asset('public/asset_front/assets/images/reception.svg')}}">
														<p>eigener Admin Bereich</p>
													</div>
													<div class="facility3">
														<img src="{{asset('public/asset_front/assets/images/support.svg')}}">
														<p>Newslettermarketing</p>
													</div>
													<div class="facility4">
														<img src="{{asset('public/asset_front/assets/images/news-letter.svg')}}">
														<p>Werbung auf reserved4you + Social Media</p>
													</div>
													<div class="facility5">
														<img src="{{asset('public/asset_front/assets/images/buchu.svg')}}">
														<p>BUCHUNGSSYSTEM</p>
													</div>
													<div class="facility5">
														<img src="{{asset('public/asset_front/assets/images/manage.svg')}}">
														<p>Managementtools</p>
													</div>
													<div class="facility5">
														<img src="{{asset('public/asset_front/assets/images/koste.svg')}}">
														<p>kostenlose Schulung</p>
													</div>
													<div class="facility5">
														<img src="{{asset('public/asset_front/assets/images/indi-news.svg')}}">
														<p>individueller Newsletter</p>
													</div>
													<div class="facility5">
														<img src="{{asset('public/asset_front/assets/images/stat.svg')}}">
														<p>Statistiken</p>
													</div>
												</div>
												<div class="recruitmentfee">
													<p>Einstellungsgebühr : <span>100€ </span>
													</p>
													<div class="recruitmentfee-info"><p>Kündigungsfrist:  <div class="cancelation-time"><span>4 Wochen</span></div></div>
													</p>
												</div>
												<div class="selectbtn">
													<p class="selectbtntext" data-id="plans-6">Auswählen</p>
												</div>
											</div>
										</label>
									</div>
									<!-- Bussiness plan end -->
								</div>
							</div>
						</div>
						<p class="extra-text text-left">*Alle Preise zzgl. Mwst.</p>
						<p class="mb-3">*Startangebot für das Paket Business: Sie erhalten die ersten sechs Monate kostenlos. (Kostenlos bedeutet in dem Fall, dass die monatliche Grundgebühr entfällt.)</p>
			
					</div>
					
                </div>
            </div>
        </div>
    </section>

    <section class="partner-bg">
        <div class="container">
            <div class="partner-infos">
                <h6>{{ \BaseFunction::getStatisticWebsite('provider') }}+ Partner</h6>
                <h5>Möchten Sie auch gerne ein Teil von reserved4you werden und alle Vorteile für Ihren Salon und Ihre Kunden nutzen ?</h5>
                <p>Mit reserved4you wird Ihr traditioneller Betrieb modern, flexibel und bedienerfreundlich.</p>
                <a href="https://www.reserved4you.de/vertrag/" class="partner_btn btn main-btn"  target="_blank">Jetzt Partner werden</a>
            </div>
        </div>
    </section>
   
@endsection
@section('front_js')

    <script
        src="https://maps.google.com/maps/api/js?key=AIzaSyBSItHxCbk9qBcXp1XTysVLYcJick5K8mU&libraries=places&callback=initialize"
        type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
    <script>
        $("body").addClass("cosmetics-body");

        google.maps.event.addDomListener(window, 'load', initialize);
		 $(function () {
           $('.meeting_time').mdtimepicker({ is24hour: true,format: 'hh:mm', clearBtn: false,showMeridian:false }).on('timechanged',function(e){
    		var id = $(this).data('id');
    		
	});
	
	$('.datepicker').datepicker({
    format: "dd/mm/yyyy",
    autoclose: true,
    todayHighlight : true
});
		 });
        function initialize() {
            var input = document.getElementById('autocomplete');
            var options = {
                componentRestrictions: {country: 'de'}
            };
            var autocomplete = new google.maps.places.Autocomplete(input, options);
            autocomplete.addListener('place_changed', function () {
                var place = autocomplete.getPlace();
                $('#latitude').val(place.geometry['location'].lat());
                $('#longitude').val(place.geometry['location'].lng());
            });

        }

        $('#business_partner').validate({ // initialize the plugin
            rules: {
				store_name: {
                    required: true,
                },
                first_name: {
                    required: true,
                },
                last_name: {
                    required: true,
                },
                email: {
                    required: true,
                },
                phone_number: {
                    required: true,
                },
                postal_code: {
                    required: true,
                }
            }
        });
		$('.plans-label').click(function() {
			
			var inputId = $(this).children("input:first").data("id");
			// alert(inputId);
			var textId = $(this).find('.selectbtntext').data("id");
			// alert(textId);
			if (inputId == textId) {
				$('.selectbtntext').text('Auswählen ');
				$(this).find('.selectbtntext').text('Ausgewählt')
			}
			else{
				('.selectbtntext').text('Auswählen ')
			}
			//$('#new-appointment-modal').modal('toggle');
			window.location.replace("{{url('https://www.reserved4you.de/vertrag')}}");
		});
    </script>
@endsection
