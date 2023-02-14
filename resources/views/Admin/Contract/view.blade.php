@extends('layouts.admin')
@section('title')
    View Contract
@endsection
@section('css')
    <style>
        .invalid-feedback {
            display: block;
        }

        /* contact-detail */
        .contact-info table {
            width: 100%;
        }

        .contact-info table tr td label {
            font-size: 14px;
            margin-bottom: 0;
        }

        .contact-title {
            border-bottom: 1px solid #f6f6f7;
            margin-bottom: 15px;
            /* padding-bottom: 7px; */
            background: #eeeeee;
            display: flex;
            padding: 0px 8px;
            border-radius: 5px;
        }

        .contact-info h4 {
            font-size: 14px;
        }

        .contact-title .row .col-6 {
            padding: 0px 5px;
        }

        .contract-duration-info .row {
            padding: 0px 5px;
        }

        .payment-terms .row {
            padding: 0px 5px;
        }

        .contact-title h3 {
            font-size: 18px;
        }

        .contact-detail {
            margin-bottom: 28px;
        }

        .contact-info table td {
            width: 50%;
            padding-bottom: 15px;
        }

        .contact-detail {
            margin: 25px 0px;
        }

        /* contact-detail end */
        /* Recommanded */
        .recomm-plan-info {
            display: flex;
            align-items: center;
            border-bottom: 1px solid #f6f6f7;
            margin-bottom: 10px;
            padding: 0px 5px;
        }

        .payment-monthly {
            margin: auto;
        }

        .table-responsive h5 {
            font-size: 18px;
            border-bottom: 1px solid #f6f6f7;
            padding: 10px 8px;
            margin-bottom: 14px;
            background: #f6f6f7;
            display: flex;
            align-items: center;
        }

        .table-responsive h6 {
            font-size: 16px;
            padding: 10px 5px;
        }

        .annuallyplans span {
            font-size: 16px;
        }

        .annuallyplans p {
            font-size: 16px;
        }

        .payment-monthly p {
            font-size: 16px;
            font-weight: 600;
        }

        /* recommnded-end */
        /* extra service */
        .extra-service-title h5 {
            font-size: 18px;
            border-bottom: 1px solid #f6f6f7;
            margin-bottom: 14px;
            background: #f6f6f7;
            padding: 10px 8px;
            border-radius: 5px;
        }

        .payment-title h6 {
            font-size: 16px;
            padding: 0px 5px;
        }

        table.table.mt-4.table-centered h5 {
            font-size: 16px;
            margin: 0px;
        }

        table.table.mt-4.table-centered p {
            margin: 5px 0px;
        }

        .extra-service-title {
            margin-top: 25px;
        }

        /* extra-service-end */
        /* contract duration */
        .contract-duration-info {
            padding: 0px 0px 20px;
            margin-top: 10px;
            margin-bottom: 20px;
        }

        .contract-duration-info h5 {
            font-size: 18px;
        }

        .contract-duration-info p {
            margin-bottom: 10px;
        }

        /* contract-duration-end */
        /* bank detail */
        .bank-detail .row {
            margin: 0;
        }

        .bank-detail {
            /* padding: 20px; */
            margin: 25px 0px;
        }

        .contact-info {
            width: 100%;
            padding: 0px 5px;
        }

        .bank-detail h5 {
            font-size: 18px;
        }

        /* bank detail -end */
        /* payment-method */
        .payment-method {
            margin: 50px 0px 20px;
        }

        .payment-mehtod-info h5 {
            font-size: 18px;
            /* border-bottom: 1px solid #f6f6f7; */
            /* padding-bottom: 18px; */
            /* margin-bottom: 14px; */
        }

        .payment-debit h6 {
            font-size: 16px;
            padding: 5px;
        }

        .sepacredit {
            border: 1px solid #f0f0f0;
            border-radius: 15px;
            padding: 10px;
        }

        .importantnote {
            border: 1px solid #f4f3f3;
            border-radius: 10px;
            padding: 10px 15px 0px;
        }

        .directdebit p {
            font-weight: 700;
            font-size: 14px;
        }

        .importantnote p:first-child {
            font-weight: 600;
            margin-bottom: 10px;
        }

        .importantnote p {
            margin-bottom: 10px;
        }

        .payment-terms {
            /* padding: 20px; */
            margin-bottom: 20px;
        }

        /* body{
            background:white;
        } */
        .container-fluid {
            margin: 0 !important;
            padding: 0 !important;
        }

        .text-right.d-print-none.print-page {
            padding-bottom: 20px;
        }

        .paymentterms {
	background-color: white;
	border-radius: 20px;
	
	margin-top: 30px;

   
    margin-bottom: 30px;
	/* height: 448px; */
}



.sales {
	margin-bottom: 15px;
}

.sales label {
	font-size: 14px;
	width:200px;
	font-weight: 400;
}

input.salesname {
	width: 36%;
	height: 60px;
	border-radius: 20px;
	border: 1px solid #9fa3a94f;
	padding: 0px 20px;
	width: 100%;
	margin-bottom: 15px;
}

.stafid {
	margin-bottom: 15px;
}

.stafid label {
	font-size: 14px;
	width:200px;
	font-weight: 400;
}

.salesstaffbtn {
	margin-top: 170px;
}

input.backdetail {
	width: 100%;
	height: 55px;
	border-radius: 20px;
	border: 1px solid #9fa3a94f;
	padding: 0px 20px;
}
        /* payment-method-end */
    </style>
@endsection

@section('content')
    <div class="row page-title">
        <div class="col-md-12">
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <!-- Logo & title -->
                    <div class="text-right d-print-none print-page">
                        <a href="javascript:window.print()" class="btn btn-primary"><i
                                class="uil uil-print mr-1"></i> Print</a>
                    </div>
                    <div class="clearfix">
                        <div class="float-sm-right">
                            <img
                                src="https://www.delemontstudio.com/reserved4younew/storage/app/public/Adminassets/images/log.png"
                                alt="" height="40"/><br/>
                            <address class="pl-2 mt-2">
                                Wilmersdorfer Str. 122/123<br>
                                10627 Berlin,Germany<br>
                                <abbr title="Phone">P:</abbr> +49 30 36429961
                            </address>
                        </div>
                        <div class="float-sm-left">
                            <h4 class="m-0 d-print-none">Vertrag</h4>
                            <dl class="row mb-2 mt-3">
                                <dt class="col-sm-3 font-weight-normal">Nr:</dt>
                                <dd class="col-sm-9 font-weight-normal">#{{$storedetails['id']}}</dd>
                                <dt class="col-sm-3 font-weight-normal">Datum:</dt>
                                <dd class="col-sm-9 font-weight-normal">{{\Carbon\Carbon::parse($storedetails['b2bdate'])->format('M d, Y')}}</dd>
                            </dl>
                        </div>
                    </div>
                    <div class="contact-detail">
                        <div class="contact-title">
                            <h3>Vertragsdetails</h3>
                        </div>
                        <div class="contact-info">
                            <table>
                                <tr>
                                    <td>
                                        <label>Name des Betriebs</label>
                                        <h4>{{@$storedetails['storename']}}</h4>
                                    </td>
                                    <td>
                                        <label>Vollständiger Name</label>
                                        <h4>{{@$storedetails['firstname']}} {{@$storedetails['Lastname']}}</h4>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>E-Mail Adresse</label>
                                        <h4>{{@$storedetails['Email']}}</h4>
                                    </td>
                                    <td>
                                        <label>Telefonnummer</label>
                                        <h4>{{@$storedetails['Phone']}}</h4>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>Straße, Hausnummer</label>
                                        <h4>{{@$storedetails['Address']}}</h4>
                                    </td>
                                    <td>
                                        <label>PLZ</label>
                                        <h4>{{@$storedetails['Zipcode']}}</h4>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div style="display: none">{{$total = 0}}{{$stotal = 0}}{{$online = 'no'}}</div>
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <h5>Unsere Pakete</h5>
                                <h6>Monatliche Zahlung</h6>
                                <div class="recomm-plan-info">
                                    <div class="annuallyplans">
                                        <span>{{@$storedetails['Plan']}}</span>
                                        <p>{{@$storedetails['Actual_plan']}}</p>
                                    </div>
                                    <div class="payment-monthly">
                                        <p><span>{{number_format(@$storedetails['plan_amount'],2)}}€</span> / pro Monat</p>
                                    </div>
                                </div>
                            </div>
                            <div style="display: none">{{$total += @$storedetails['plan_amount']}}</div>
                            <!-- end table-responsive -->
                        </div>
                        <!-- end col -->
                    </div>
                    <div class="extra-service-title">
                        <h5>Extra Services</h5>
                    </div>
                    <div class=row>
                        <div class="col-6">
                            <div class="payment-title">
                                <h6>Monatliche Zahlung</h6>
                            </div>
                            <table class="table mt-4 table-centered">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Details</th>
                                    <th style="width: 10%">Preis </th>
                                </tr>
                                <div style="display: none">{{$i = 1 }}</div>
                                @foreach($extraservice as $row)
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td>
                                            <p>Extra Services</p>
                                            <h5>{{$row->Service_plan}}</h5>
                                        </td>
                                        @if($row->Service_amount == '2.5%')
                                            <td>{{$row->Service_amount}}/ Per Onlinezahlung</td>
                                        @else
                                            <td>{{number_format($row->Service_amount,2)}}€ / Monat </td>
                                        @endif
                                    </tr>
                                    @if($row->Service_amount != '2.5%')
                                        <div style="display: none">{{$total += $row->Service_amount}}</div>
                                    @endif
                                    @if($row->Service_amount == '2.5%')
                                        <div style="display: none">{{$online = 'yes'}}</div>
                                    @endif
                                    <div style="display: none">{{$i++ }}</div>
                                @endforeach
                                @foreach($marketing as $row)
                                <tr>
                                    <td>{{$i}}</td>
                                    <td>
                                        <p>Marketing</p>
                                        <h5>{{$row->Service_plan}}</h5>
                                    </td>
                                    <td>{{number_format($row->Service_amount,2)}}€ / Monat </td>
                                    <div style="display: none">{{$total += $row->Service_amount}}</div>
                                </tr>
                                <div style="display: none">{{$i++ }}</div>
                                @endforeach
                                <tr>
                                    <td></td>
                                    <td>
                                        <p>Total</p>
                                        <h5>Monatliche Zahlung</h5>
                                    </td>
                                    <td>{{number_format($total,2)}}€ / Monat  @if($online == 'yes') + 2.5% / Per Onlinezahlung @endif</td>

                                </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="col-6">
                            <div class="payment-title">
                                <h6>Einmalige Zahlung</h6>
                            </div>
                            <table class="table mt-4 table-centered">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Details</th>
                                    <th style="width: 10%">Preis</th>
                                </tr>
                                <div style="display: none">
                                    {{$i = 1 }}
                                    {{$pricew = 0}}
                                    @if($storedetails->Actual_plan == 'Basic Plus')
                                        {{$pricew = 50}}
                                        {{$stotal += 50}}
                                    @elseif($storedetails->Actual_plan == 'Business Plan')
                                        {{$stotal += 100}}
                                        {{$pricew = 100}}
                                    @elseif($storedetails->Actual_plan == 'Basic')
                                        {{$stotal += 0}}
                                        {{$pricew = 0}}
                                    @endif
                                </div>
                                <tr>
                                    <td>{{$i}}</td>
                                    <td>
                                        <p>Einmalige Zahlung</p>
                                    </td>
                                    <td>{{number_format($pricew,2)}}€</td>
                                </tr>
                                @foreach($hardware as $row)
                                <tr>
                                    <td>{{$i}}</td>
                                    <td>
                                        <p>Hardware</p>
                                        <h5>{{$row->Service_plan}}</h5>
                                    </td>
                                    <td>{{number_format($row->Service_amount,2)}}€</td>
                                    <div style="display: none">{{$stotal += $row->Service_amount}}</div>
                                </tr>
                                <div style="display: none">{{$i++ }}</div>
                                @endforeach
                                <tr>
                                    <td></td>
                                    <td>
                                        <p>Total</p>
                                        <h5>Einmalige Zahlung</h5>
                                    </td>
                                    <td>{{number_format($stotal,2)}}€</td>

                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <p style="text-align:right"> *Alle Preise zzgl. Mwst.</p>
                    <div class="contract-duration-info">
                        <div class="contact-title">
                            <h5>Vertragslaufzeit </h5>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <p>Eintrittsdatum</p>
                                <h5 class="font-size-16 mt-0 mb-2">@if($storedetails['Contract_Start_Date'] != ''){{\Carbon\Carbon::parse(@$storedetails['Contract_Start_Date'])->format('F d, Y')}}@endif</h5>
                            </div>
                            <div class="col-6">
                                <p>Austrittsdatum </p>
                                <h5 class="font-size-16 mt-0 mb-2">@if($storedetails['Contact_end_date'] != ''){{\Carbon\Carbon::parse(@$storedetails['Contact_end_date'])->format('F d, Y')}}@endif</h5>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->
                    <div class="bank-detail">
                        <div class="contact-title">
                            <h5>Bankdaten</h5>
                        </div>
                        <div class="row">
                            <div class="contact-info">
                                <table>
                                    <tr>
                                        <td>
                                            <label>Kontoinhaber</label>
                                            <h4>{{@$bankdetails['Account_holder']}}</h4>
                                        </td>
                                        <td>
                                            <label>Bankleitzahl </label>
                                            <h4>{{@$bankdetails['Bank_code']}}</h4>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label>IBAN</label>
                                            <h4>{{@$bankdetails['Iban']}}</h4>
                                        </td>
                                        <td>
                                            <label>Rechnungszustellung</label>
                                            <h4>{{@$bankdetails['Invoice_method']}}</h4>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="payment-method">
                        <div class="payment-mehtod-info contact-title">
                            <h5>Zahlungsmethode</h5>
                        </div>
                        <div class="payment-debit">
                            @if(@$storedetails['Payment_terms'] == 'SEPA Direct Debit')
                            <h6>{{@$storedetails['Payment_terms']}}</h6>
                            <div class="sepacredit">
                                <div class="directdebit">
                                    <p>SEPA Lastschriftmandat Mandate</p>
                                    <p>Creditor ID: <span>DE36ZZZ00002263980</span>
                                    </p>
                                </div>
                                <div class="debitinfo">
                                    <p>Hiermit ermächtige ich R.F.U. reserved4you GmbH, Zahlungen für monatliche Beiträge mittels SEPA- Lastschrift von meinem Konto einzuziehen. Zugleich weise ich mein Kreditinstitut an, die von der Berliner Sparkasse auf mein Konto gezogenen Lastschriften einzulösen.</p>
                                </div>
                                <div class="importantnote">
                                    <p>Hinweis</p>
                                    <p>Sie können innerhalb von acht Wochen, beginnend mit dem Belastungsdatum, die Erstattung des belasteten Betrages verlangen. Es gelten dabei die mit Ihrem Kreditinstitut vereinbarten Bedingungen. Die Mandatsreferenznummer bekommen Sie mit Ihrem Vertrag zugeschickt.</p>
                                </div>
                            </div>
                            @else
                                <h6>{{@$storedetails['Payment_terms']}}</h6>
                            @endif
                        </div>
                    </div>
                    <div class="paymentterms bankpaydetail">
                        <div class="payment-mehtod-info contact-title">
				<h5>Mitarbeiterdetails</h5>
</div>
				<div class="sales">
					<div class="salesrepresentative">
					<div class="row align-items-center">

							<div class="col-lg-6">
                                <div class="employe-fmane d-flex">
                                   
							            <label>Berater-Vorname:</label>
							            <p>{{$salesStaff->firstname}}</p>
                                
                                </div>
                            
							</div>

							<div class="col-lg-6">
                            <div class="employe-fmane d-flex">
                                   
							            <label>Berater-Nachname:</label>
                                   
							            <p>{{$salesStaff->lastname}}</p>
                                  
                                </div>
							</div>

						</div>
						</div>
						<div class="stafid">
					<div class="row align-items-center">

							<div class="col-lg-12">
                            <div class="employe-fmane d-flex">
                                   
                            <label>Mitarbeiternummer :</label>
                              
                                   <p>{{$salesStaff->Staff_id_no}}</p>
                             
                           </div>
						
							</div>
							<div class="col-lg-9">
							<!-- <input type="text" name="Staff_id_no" id="staffid" class="backdetail"> -->
							<sapn id="staffidno" class="text-danger"></sapn>

							</div>
						</div>
					</div>
				</div>
			</div>
                    <div class="payment-terms">
                        <div class="contact-title">
                            <h5>Zahlungsbedingungen</h5>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <p>1. Geltungsbereich</p>
                                <p>Für die Geschäftsbeziehung zwischen R.F.U. reserved4you GmbH, Wilmersdorfer Straße
                                    122-
                                    123,
                                    10627Berlin (nachfolgend „reserved4you“) und dem Kunden (nachfolgend „Kunde“) gelten
                                    ausschließlich dienachfolgenden allgemeinen Geschäftsbedingungen in ihrer zum
                                    Zeitpunkt
                                    der
                                    Bestellung gültigenFassung. Die Bestimmungen dieser AGB gelten für Bestellungen,
                                    welche
                                    Kunden über die Webseitewww.reserved4you. de oder einen Vertriebspartner
                                    abschließen.
                                    Die
                                    Verwendung von anderen allgemeinenGeschäftsbedingungen, ist ausgeschlossen. Der
                                    Kunde
                                    ist
                                    allein verantwortlich für die Erfüllung der Vereinbarungen mit den Endkunden oder
                                    Verbraucher. www.reserved4you.de ist nicht Vertragspartnerdieser gesonderten
                                    Vereinbarungen
                                    und Rechtsbeziehung und hat keinerlei Erfüllungspflichten oderHaftungen.
                                </p>
                                <p>1.1 Abweichende Bedingungen & Konditionen</p>
                                <p>Abweichende Bedingungen oder Konditionen des Kunden werden nicht anerkannt, es sei
                                    denn,
                                    der
                                    Reserved4you stimmt ihrer Geltung ausdrücklich und in Schriftform zu.
                                </p>
                                <p>2. Angebote und Leistungsbeschreibungen</p>
                                <p>Auf www.reserved4you.de stellen wir eine Online-Plattform zur Verfügung, über die
                                    Dienstleister, in ihrer professionellen Kapazität, ihre Services bewerben,
                                    vermarkten,
                                    verkaufen und/oder zur Bestellung, zum Kauf, zur Reservierung anbieten können und
                                    über
                                    die
                                    Besucher dieser Plattform eine Bestellung, Reservierung, einen Kauf, oder eine
                                    Zahlung
                                    (d.
                                    h. den Buchungsservice) entdecken, suchen, vergleichen und durchführen können. Mit
                                    der
                                    Nutzung des Buchungsservice (z. B. indem Sie eine Buchung über den gewünschten
                                    Anbieter
                                    durchführen, gehen Sie ein unmittelbares rechtlich bindendes Vertragsverhältnis mit
                                    dem
                                    Endanbieter ein, bei dem Sie buchen oder einen Service erwerben. Ab dem Zeitpunkt
                                    Ihrer
                                    Buchung wirken wir ausschließlich als Vermittler zwischen Ihnen und dem Anbieter,
                                    indem
                                    wir
                                    dem jeweiligen Anbieter die Angaben zu Ihrer Buchung weiterleiten und Ihnen im
                                    Auftrag
                                    und
                                    im Namen des Anbieters eine Bestätigungs- E-Mail zusenden. Reserved4you verkauft,
                                    vermietet
                                    oder bietet keinerlei Produkte oder Services direkt an und ist nur Vermittler. Die
                                    Rolle
                                    von
                                    www.reserved4you.de beim Abschluss dieser Vereinbarungen ist nur die eines
                                    Vermittlers.
                                    Die
                                    Ausnahme stellen jedoch die Leistung auf www.reserved4you.de dar und wie in diesem
                                    Abschnitt
                                    beschrieben. Die Vorstellung und Beschreibung der Waren auf der Internetseite
                                    www.reserved4you.de stellt noch kein Vertragsangebot dar.
                                </p>
                                <p>2.1 Information auf der Webseite & deren Richtigkeit</p>
                                <p>Die Informationen, die wir für die Ausführung unserer Dienstleistungen verwenden,
                                    basieren
                                    auf den Informationen, die uns von den Anbietern zur Verfügung gestellt werden. Die
                                    Anbieter, die ihre Dienstleistungen oder Produkte auf unserer Plattform vermarkten
                                    und
                                    bewerben, haben Zugang zu unseren Systemen und dem Extranet und tragen somit die
                                    alleinige
                                    Verantwortung dafür, dass die Raten/Gebühren/Preise, die Verfügbarkeit, Richtlinien
                                    und
                                    Geschäftsbedingungen und andere wichtige Informationen, die auf unserer Webseite
                                    aufgeführt
                                    sind, stets Aktuell sind. Obwohl wir bei der Ausführung unserer Dienstleistungen
                                    sehr
                                    sorgfältig und gewissenhaft vorgehen, können wir weder überprüfen und garantieren,
                                    dass
                                    alle
                                    Informationen genau, richtig und vollständig sind, noch können wir für Fehler
                                    (einschließlich offenkundiger Fehler oder Tippfehler), Unterbrechungen (durch einen
                                    zeitlich
                                    begrenzten und/oder einen teilweisen Ausfall, Reparatur-, Aktualisierungs border
                                    Instandhaltungsarbeiten auf unserer Webseite oder einem anderen Grund), ungenaue,
                                    irreführende oder unwahre Informationen oder Nichtübermittlung der Informationen
                                    verantwortlich gemacht werden. Jeder Anbieter bleibt stets für die Genauigkeit,
                                    Vollständigkeit und Richtigkeit der (beschreibenden) Informationen (einschließlich
                                    der
                                    Raten/Preise/Gebühren, Richtlinien & Geschäftsbedingungen und Verfügbarkeiten) auf
                                    unserer
                                    Webseite verantwortlich. Unsere Webseite stellt keine Empfehlung oder Bestätigung
                                    der
                                    Qualität, des Serviceniveaus, der Qualifizierung, der Klassifikation eines Anbieters
                                    (oder
                                    seiner Einrichtungen, Veranstaltungsorte, (Haupt- oder Neben-Produkte oder Services)
                                    dar
                                    und
                                    soll auch nicht als solche angesehen werden, soweit nicht explizit angegeben.
                                </p>
                                <p>2.2 Nutzung der Dienstleistungen</p>
                                <p>Unsere Dienstleistungen stehen nur zu den Beschriebenen privaten und kommerziellen
                                    Nutzung
                                    zur Verfügung. Jedoch ist es Ihnen nicht gestattet, Inhalte oder Informationen,
                                    Produkte
                                    oder Dienstleistungen, die auf unserer Webseite verfügbar sind, zu gewerblichen oder
                                    wettbewerblichen Zwecken weiter zu vertreiben, mit Unterseiten von Webseiten zu
                                    verlinken,
                                    zu nutzen, zu vervielfältigen, zu extrahieren (zum Beispiel mit Spider, Scrape), neu
                                    zu
                                    veröffentlichen, hochzuladen oder zu reproduzieren. Falls dafür keine ausdrückliche
                                    und
                                    schriftliche Genehmigung von unserer Seite vorliegt.
                                </p>
                                <p>3. Vertragsabschluss</p>
                                <p>Die Leistungen der reserved4you können durch unser Vertragsformular entweder Online
                                    oder
                                    mithilfe eines Vertriebsmitarbeiters gebucht werden. Der Kunde kann beim Durchlaufen
                                    des
                                    Vertragsformulars individuelle Leistungen anpassen und z. B. den Leistungsumfang und
                                    die
                                    Vertragslaufzeit bestimmen und/oder eventuelle benötigte Hardware hinzufügen. Über
                                    die
                                    Schaltfläche absenden gibt der Kunde eine verbindliche Buchung der ausgewählten
                                    Leistungen
                                    ab.
                                </p>
                                <p>3.1 Empfangsbestätigung</p>
                                <p>Reserved4you schickt daraufhin dem Kunden eine automatische Empfangsbestätigung per
                                    EMail
                                    zu,
                                    in welcher die gewählten Leistungen nochmals aufgeführt wird und die der Kunde über
                                    die
                                    Funktion „Drucken“ ausdrucken kann (Bestellbestätigung). Die automatische
                                    Empfangsbestätigung dokumentiert lediglich, dass die Bestellung des Kunden bei
                                    Reserved4you
                                    eingegangen ist, und stellt keine Annahme des Antrags dar. Der Kaufvertrag kommt
                                    erst
                                    dann
                                    zustande, wenn Reserved4you die gewünschten Leistungen ausdrücklich bestätigt hat
                                    und
                                    der
                                    Zahlvorgang erfolgreich abgeschlossen wurde.
                                </p>
                                <p>3.2 Kündigung</p>
                                <p>Ein Vertrag ist mit einer Frist von vierzehn Kalendertage bei einer Vertragslaufzeit
                                    von
                                    einem Monat und von dreißig Kalendertagen bei einer Vertragslaufzeit von bis zu
                                    einem
                                    Jahr
                                    in Schriftform kündbar. Maßgeblich ist das Zugangsdatum der Kündigung. Angebrochene
                                    Kalendermonate werden als voller Vertragsmonat berechnet. Das Recht zur fristlosen
                                    Kündigung
                                    aus wichtigem Grund bleibt davon unberührt. Ein wichtiger Grund liegt insbesondere
                                    vor,
                                    wenn
                                    reserved4you seinen Dienst einstellt oder der Kunde gegen seine Pflichten aus diesem
                                    Vertrag
                                    verstößt. Ein etwaiger unverbindlicher Testzugang endet automatisch mit Ablauf des
                                    jeweiligen Testzeitraums und muss nicht gekündigt werden. Nach Ablauf des
                                    Abonnements
                                    wird
                                    der Zugriff des Nutzers auf das System gesperrt.
                                </p>
                                <p>3.3 Außerordentliche Kündigung</p>
                                <p>Bei einer grundlegenden Änderung von rechtlichen oder technischen Rahmenbedingungen
                                    wird
                                    reserved4you erlaubt außerordentlich und einseitig zu kündigen, wenn es dadurch für
                                    reserved4you unzumutbar wird, die vom Kunden gewählten Leistungen ganz oder
                                    teilweise im
                                    Rahmen des Vertragszwecks zu erbringen. Eine etwaige Teilerstattung von Leistungen
                                    wird
                                    in
                                    diesem Falle geprüft.
                                </p>
                                <p>Soweit reserved4you Leistungen und Dienste unentgeltlich erbringt, können diese
                                    jederzeit
                                    ohne Vorankündigung und ohne Angabe von Gründen eingestellt werden.
                                </p>
                                <p>3.4 Vorkasse und Vertragsabschluss</p>
                                <p>Sollte reserved4you eine Vorkasse Zahlung ermöglichen, kommt der Vertrag mit der
                                    Bereitstellung der Bankdaten und Zahlungsaufforderung zustande. Wenn die Zahlung
                                    trotz
                                    Fälligkeit auch nach erneuter Aufforderung nicht bis zu einem Zeitpunkt von zwei
                                    Kalendertagen nach Absendung der Bestellbestätigung bei Reserved4you eingegangen
                                    ist,
                                    tritt
                                    Reserved4you vom Vertrag zurück mit der Folge, dass die Bestellung hinfällig ist und
                                    Reserved4you keinerlei Erfüllungspflichten hat. Die Buchung ist dann für den Kunden
                                    und
                                    Reserved4you ohne weitere Folgen erledigt. Eine Reservierung mit Vorkasse erfolgt
                                    daher
                                    nicht mehr als fünf Kalendertage im Voraus.
                                </p>
                                <p>4. Vergütung, Preise und Zahlungsbedingungen</p>
                                <p>Alle Preise, die auf der Webseite von Reserved4you angegeben sind, verstehen sich
                                    einschließlich der jeweils gültigen gesetzlichen Umsatzsteuer, aller anderen Steuern
                                    und
                                    Abgaben (und unterliegen somit Steuerschwankungen) sowie aller Gebühren angezeigt,
                                    sofern
                                    dies nicht anders auf unserer Webseite angegeben werden.
                                </p>
                                <p>4.1 Gebühr für die Leistung</p>
                                <p>Reserved4you berechnet für die Bereitstellung der Leistung eine Gebühr, welche
                                    abhängig
                                    vom
                                    gewählten Leistungspaket und der vereinbarten Vertragslaufzeit ist. Näheres zu
                                    diesen
                                    Paketen unter www.reserved4you.de
                                </p>
                                <p>4.2 Testzugänge</p>
                                <p>Reserved4you kann Testzugänge anbieten. Während des jeweiligen Testzeitraums ist die
                                    Nutzung
                                    kostenlos. Wenn der Kunde die Dienstleistungen nach Ablauf des Testzeitraums weiter
                                    nutzen
                                    möchte, ist der Abschluss eines gesonderten kostenpflichtigen Vertrags erforderlich.
                                </p>
                                <p>4.3 Bereitstellungsgebühr</p>
                                <p>Die Bereitstellungsgebühr ist für die jeweilige Vertragslaufzeit im Voraus fällig und
                                    zahlbar, falls mit dem Kunden kein abweichender Abrechnungszeitraum vereinbart sein
                                    sollte.
                                </p>
                                <p>4.4 Sepa-Lastschrift</p>
                                <p>Der Kunde kann im Rahmen und vor Abschluss des Bestellvorgangs die Zahlungsart
                                    SEPALastschrift wählen. Wird per SEPA Lastschrift gezahlt, erteilt der Kunde hierzu
                                    bei
                                    Vertragsabschluss sein Einverständnis. Die Frist zur Vorabankündigung
                                    (Pre-Notifcation)
                                    von
                                    SEPA Lastschriften wird auf zwei Tage verkürzt. Der Kunde verpflichtet sich, zu dem
                                    Zeitpunkt der Abbuchung eine für den Betrag der Rechnung ausreichende Deckung auf
                                    dem
                                    von
                                    ihm angegebenen Konto zu unterhalten. Die Kosten für eine vom Geldinstitut
                                    zurückgegebene
                                    Lastschriftbuchung werden dem Kunden in Rechnung gestellt, sofern er die
                                    Zurückweisung
                                    der
                                    Buchung zu vertreten hat.
                                </p>
                                <p>4.5 Bezahlung durch Bezahldienstleister oder andere Dritte</p>
                                <p>Der Kunde hat im Rahmen und vor Abschluss des Bestellvorgangs auch die Möglichkeit,
                                    die
                                    Zahlung via Drittanbieter (wie zum Beispiel Paypal, Stripe, etc.) durchzuführen. Im
                                    Falle
                                    von Zahlung, via solcher Drittanbieter, gehen sämtliche damit verbunden Kosten und
                                    Gebühren
                                    zulasten des Kunden. Reserved4you verrechnet die effektiv entstanden Kosten weiter
                                    und
                                    bucht
                                    diese dem Dienstleister jeweils zusammen mit der monatlichen Rechnung ab.
                                </p>
                                <p>4.6 Fälligkeit</p>
                                <p>Ist die Fälligkeit der Zahlung nach dem Kalender bestimmt, so kommt der Kunde bereits
                                    durch
                                    Versäumnis am nächsten Kalendertag in Verzug. In diesem Fall hat der Kunde die
                                    gesetzlichen
                                    Verzugszinsen zu zahlen.
                                </p>
                                <p>4.7 Rechnungsstellung & Format der Rechnung</p>
                                <p>Reserved4you erstellt alle Rechnungen nur in digitalem Format. Die Rechnungen warden
                                    dem
                                    Kunden jeweils per E-Mail zugestellt. Hiermit erklärt sich der Kunde einverstanden.
                                    Verlangt
                                    der Kunde die postalische Zusendung einer Rechnung, wird reserved4you hierfür eine
                                    angemessene Aufwandsentschädigung je Rechnung verlangen.
                                </p>
                                <p>4.8 Sperrung oder Verweigerung der Leistung</p>
                                <p>Bei Zahlungsverzug ist reserved4you berechtigt Leistungen zu sperren oder nach
                                    entsprechender
                                    Androhung das Vertragsverhältnis zu kündigen. Die vorübergehende Sperrung von
                                    Diensten
                                    berührt die Zahlungspflicht des Kunden nicht.
                                </p>
                                <p>5. Zugriffsrecht & Ausschluss, Eigentumsvorbehalt</p>
                                <p>Der Kunde erhält das nicht ausschließliche, auf die Laufzeit dieses Vertrages
                                    zeitlich
                                    beschränkte Recht, auf reserved4you mit einem geeigneten Internetbrowser zuzugreifen
                                    und
                                    die
                                    mit reserved4you verbundenen Funktionalitäten gemäß diesem Vertrag zu nutzen.
                                    Darüberhinausgehende Rechte, insbesondere am Quellcode der Software erhält der Kunde
                                    nicht.
                                </p>
                                <p>5.1 Geistiges Eigentum</p>
                                <p>Es wird kein geistiges Eigentum an den Kunden übertragen. Auch individuell angepasste
                                    Software, die sich auf reserved4you bezieht, bleibt das geistige Eigentum des
                                    Dienstleisters, es sei denn, dass etwas Abweichendes vereinbart wird.
                                    <br>
                                    <br>Alle Logos und Markenzeichen des Kunden sowie andere mögliche eingetragene
                                    Marken,
                                    Copyrights und Muster sind und bleiben Eigentum des Kunden. Es wird aber
                                    www.reserved4you.de
                                    ein unentgeltliches Nutzungsrecht für die Dauer des Vertragsverhältnisses eingeräumt
                                    zur
                                    Ausübung der Dienstleistung. Der Kunde sieht davon ab andere Marken, Copyrights oder
                                    sonstige Markenzeichen anderen Anbieter, für die er nicht die notwendigen
                                    Nutzungsrechte
                                    hat
                                    zu verwenden. Der Kunde hält www.reserved4you.de von allen Schadensersatzansprüchen,
                                    Bußgeldern und allen sonstigen Kosten in solchen Streitigkeiten oder Konflikten
                                    frei.
                                </p>
                                <p>5.2 Nutzung</p>
                                <p>Der Kunde ist nicht berechtigt, reserved4you über die nach Maßgabe dieses Vertrages
                                    erlaubte
                                    Nutzung hinaus zu nutzen oder von Dritten nutzen zu lassen oder es Dritten
                                    zugänglich zu
                                    machen. Insbesondere ist es dem Kunden nicht gestattet, reserved4you oder Teile
                                    davon zu
                                    vervielfältigen, zu veräußern oder zeitlich begrenzt zu überlassen, vor allem nicht
                                    zu
                                    vermieten oder zu verleihen.
                                    <br>
                                    <br>Dem Kunden ist es untersagt, Werbung von reserved4you in jeglicher Form an die
                                    Endkunden
                                    eines Drittanbieters zu übermitteln, weiterzugeben oder zu senden.
                                </p>
                                <p>5.3 Doppelregistrierung & unrichtige Registrierung</p>
                                <p>Bei einer Doppelregistrierung oder unrichtigen Registrierung eines Accounts behält
                                    sich
                                    www.reserved4you.de eine Prüfung des Sachverhaltes vor und eine etwaige Kündigung
                                    zum
                                    nächst
                                    möglichen Vertragszeitpunkt sowie eine Sperrung oder Löschung des Accounts vor.
                                    Diese
                                    Maßnahmen dienen dem Interesse und Missbrauchsschutz aller Parteien.
                                </p>
                                <p>6. Vertragswidrige Nutzung</p>
                                <p>Reserved4you ist berechtigt, bei rechtswidrigem Verstoß des Kunden gegen eine der
                                    hier
                                    festgelegten wesentlichen Pflichten, den Zugang zu Reserved4you und zu dessen Daten
                                    zu
                                    sperren. Der Zugang wird erst dann wiederhergestellt, wenn der Verstoß gegen die
                                    betroffene
                                    wesentliche Pflicht dauerhaft beseitigt ist. Der Kunde bleibt in diesem Fall
                                    verpflichtet,
                                    die vereinbarte Vergütung zu zahlen.
                                </p>
                                <p>7. Haftung und Haftungsausschluss</p>
                                <p>Reserved4you haftet nur unbeschränkt, soweit die Schadensursache auf Vorsatz oder
                                    grober
                                    Fahrlässigkeit beruht.
                                    <br>
                                    <br>Ferner haftet Reserved4you nur für die leicht fahrlässige Verletzung von
                                    wesentlichen
                                    Pflichten, deren Verletzung die Erfüllung des Vertragszwecks gefährdet, oder für die
                                    Verletzung von Pflichten, deren Erfüllung die ordnungsgemäße Durchführung des
                                    Vertrages
                                    überhaupt erst ermöglicht und auf deren Einhaltung der Kunde regelmäßig vertraut. In
                                    diesem
                                    Fall haftet Reserved4you jedoch nur für den vorhersehbaren, vertragstypischen
                                    Schaden.
                                    Reserved4you haftet nicht für die leicht fahrlässige Verletzung anderer außer in den
                                    vorstehenden Absätzen genannten Pflichten.
                                    <br>
                                    <br>Die vorstehenden Haftungsbeschränkungen gelten nicht bei Verletzung von Leben,
                                    Körper
                                    und Gesundheit, für einen Mangel nach Übernahme einer Garantie für die
                                    Beschaffenheit
                                    des
                                    Produktes und bei arglistig verschwiegenen Mängeln. Die Haftung nach dem
                                    Produkthaftungsgesetz bleibt unberührt.
                                    <br>
                                    <br>Soweit die Haftung von Reserved4yous ausgeschlossen oder beschränkt ist, gilt
                                    dies
                                    auch
                                    für die persönliche Haftung von Arbeitnehmern, Vertretern und Erfüllungsgehilfen.
                                    <br>
                                    <br>Für eine sonstige Haftung von Reserved4yous auf Schadensersatz gelten
                                    unverändert
                                    die
                                    sonstigen gesetzlichen Anspruchsgrundlagen sowie Haftungsausschlüsse und
                                    -begrenzungen.
                                </p>
                                <p>7.1 Gefahrenübergang</p>
                                <p>Das Risiko einer zufälligen Verschlechterung oder einem zufälligen Verlust der Ware
                                    oder
                                    Dienstleistung liegt alleinig bis zur Übergabe dieser beim Kunden und geht mit der
                                    Übergabe
                                    auf den Verbraucher über.
                                </p>
                                <p>8. Datenschutz</p>
                                <p>Soweit reserved4you auf personenbezogene Daten des Kunden oder aus dessen Bereich
                                    zugreifen
                                    kann, wird er ausschließlich als Auftragsverarbeiter tätig und diese Daten nur zur
                                    Vertragsdurchführung verarbeiten und nutzen. Reserved4you wird Weisungen des Kunden
                                    für
                                    den
                                    Umgang mit diesen Daten beachten. Der Kunde trägt etwaige nachteilige Folgen solcher
                                    Weisungen für die Vertragsdurchführung. Weitere und genaue Details sind in den
                                    Datenschutzrichtlinien und der Datenschutzverordnung auf der Seite
                                    www.reserved4you.de
                                    unter
                                    Datenschutzrichtlinen einzusehen.
                                    <br>
                                    <br>Der Kunde bleibt sowohl allgemein im Auftragsverhältnis als auch im
                                    datenschutzrechtlichen Sinne der Verantwortliche. Verarbeitet der Kunde im
                                    Zusammenhang
                                    mit
                                    dem Vertrag personenbezogene Daten (einschließlich Erhebung und Nutzung), so steht
                                    er
                                    dafür
                                    ein, dass er dazu nach den anwendbaren, insbesondere datenschutzrechtlichen
                                    Bestimmungen
                                    berechtigt ist und stellt im Falle eines Verstoßes von Reserved4you von Ansprüchen
                                    Dritter
                                    frei. Weitere und genaue Details sind in den Datenschutzrichtlinien und der
                                    Datenschutzverordnung auf der Seite www.reserved4you.de unter Datenschutzrichtlinen
                                    einzusehen.
                                </p>
                                <p>8.1 Personenbezogene Daten</p>
                                <p>Für das Verhältnis zwischen Reserved4you und Kunde gilt: Gegenüber der betroffenen
                                    Person
                                    trägt die Verantwortung für die Verarbeitung (einschließlich Erhebung und Nutzung)
                                    personenbezogener Daten der Kunde, außer soweit reserved4you etwaige Ansprüche der
                                    betroffenen Person wegen einer ihm zuzurechnenden Pflichtverletzung zu vertreten
                                    hat.
                                    Der
                                    Kunde wird etwaige Anfragen, Anträge und Ansprüche der betroffenen Person
                                    verantwortlich
                                    prüfen, bearbeiten und beantworten. Das gilt auch bei einer Inanspruchnahme von
                                    Reserved4you
                                    durch die betroffene Person. Reserved4you wird den Kunden im Rahmen seiner Pflichten
                                    unterstützen. Weitere und genaue Details sind in den Datenschutzrichtlinien und der
                                    Datenschutzverordnung auf der Seite www.reserved4you.de unter Datenschutzrichtlinen
                                    einzusehen.
                                </p>
                                <p>8.2 Datenschutz</p>
                                <p>Reserved4you gewährleistet, dass Daten des Kunden ausschließlich im Gebiet der
                                    Bundesrepublik
                                    Deutschland, in einem Mitgliedsstaat der Europäischen Union oder in einem anderen
                                    Vertragsstaat des Abkommens über den europäischen Wirtschaftsraum gespeichert
                                    werden,
                                    soweit
                                    nichts anderes vereinbart. Weitere und genaue Details sind in den
                                    Datenschutzrichtlinien
                                    und
                                    der Datenschutzverordnung auf der Seite www.reserved4you.de unter
                                    Datenschutzrichtlinen
                                    einzusehen.
                                </p>
                                <p>9. Speicherung der AGB</p>
                                <p>Der Kunde kann diese AGB vor der Abgabe der Buchung auf reserved4you einsehen und
                                    ausdrucken,
                                    indem er die Druckfunktion seines Browsers nutzt. Die AGBs auf der Webseite sind
                                    immer
                                    die
                                    letzte gültige Version.
                                </p>
                                <p>9.1 Buchungsbestätigung</p>
                                <p>Reserved4you sendet dem Kunden außerdem eine Buchungsbestätigung mit allen
                                    Buchungsdaten
                                    an
                                    die angegebene E-Mail-Adresse zu. Mit der Buchungsbestätigung, spätestens jedoch bei
                                    der
                                    Buchung erhält der Kunde ferner eine Kopie der AGB nebst Widerrufsbelehrung und den
                                    Hinweisen zu den Zahlungsbedingungen. Darüber hinaus speichern wir den Vertragstext,
                                    machen
                                    ihn jedoch im Internet nicht frei zugänglich.
                                </p>
                                <p>10. Gerichts- & Rechtsstand</p>
                                <p>Gerichtsstand und Erfüllungsort ist der Sitz von Reserved4yous. Die AGB unterliegen
                                    deutschem
                                    Recht unter Ausschluss des UN-Kaufrechts.
                                </p>
                                <p>10.1 Vertrags und Kommunikationssprache</p>
                                <p>Vertragssprache und Kommunikationssprache ist ausschließlich Deutsch.</p>
                                <p>10.2 Schlichtung</p>
                                <p>Wir sind nicht bereit und nicht verpflichtet an einem Streitbeilegungsverfahren vor
                                    einer
                                    Verbraucherschlichtungsstelle teilzunehmen. Werden uns jedoch um eine Einigung im
                                    Interesse
                                    aller Parteien bemühen.
                                </p>
                                <p>11. Aufrechnung und Zusatzkosten</p>
                                <p>Der Kunde hat kein Recht, Ansprüche oder Zusatzkosten aufzurechnen, es sei denn, es
                                    handelt
                                    sich um unbestrittene oder rechtskräftig festgestellte Ansprüche oder um voneinander
                                    abhängige Forderungen. Der Kunde hat alle Kosten oder Zusatzkosten selbst zu tragen.
                                </p>
                                <p>12. Änderungen</p>
                                <p>Reserved4you ist berechtigt, diese AGBs zu ändern, soweit die Änderungen für den
                                    Kunden
                                    zumutbar sind. Über die beabsichtigten Änderungen wird Reserved4you den Kunden
                                    rechtzeitig
                                    und per E-Mail informieren. Sofern seitens des Kunden innerhalb von vierzehn
                                    Kalendertagen
                                    nach Zugang der Benachrichtigung kein Widerspruch erfolgt, gelten die Änderungen als
                                    angenommen. Über das Widerspruchsrecht sowie über Rechtsfolgen des Fristablaufs wird
                                    Reserved4you in der Benachrichtigung hinweisen.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2">
                            <label>Place</label>
                            <h5 class="font-size-14 mt-0 mb-2">{{@$storedetails['place']}}</h5>
                        </div>
                        <div class="col-10">
                        </div>
                    </div>
                    <div class="mt-5 mb-1">
                        <div class="text-right d-print-none">
                            <a href="javascript:window.print()" class="btn btn-primary"><i
                                    class="uil uil-print mr-1"></i> Print</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end col -->
    </div>
    <script>

    </script>
@endsection
@section('plugin')
@endsection
@section('js')
@endsection

