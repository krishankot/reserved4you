<!doctype html>
<html dir="ltr" lang="en-US">

<head>
    <title>B2B</title>
    <link type="image/x-icon" rel="shortcut icon" href="{{asset('public/asset_front/assets/images/favicon.jpg')}}"/>
    <meta charset="UTF-8"/>
    <meta name="HandheldFriendly" content="true">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link type="text/css" rel="stylesheet" href="{{asset('public/asset_front/assets/css/all.min.css')}}"/>
    <link type="text/css" rel="stylesheet" href="{{asset('public/asset_front/assets/fonts/stylesheet.css')}}"/>
    <link type="text/css" rel="stylesheet" href="{{asset('public/asset_front/assets/css/owl.carousel.min.css')}}">
    <link type="text/css" rel="stylesheet" href="{{asset('public/asset_front/assets/css/bootstrap.min.css')}}"/>
    <link type="text/css" rel="stylesheet" href="{{asset('public/asset_front/assets/css/bootstrap-datepicker.css')}}"/>
    <link type="text/css" rel="stylesheet" href="{{asset('public/asset_front/assets/css/styles3.css')}}"/>
    <link type="text/css" rel="stylesheet" href="{{asset('public/asset_front/assets/css/responsive.css')}}"/>
</head>
<body>
<!--Header-->
<header>
    <nav class="navbar navbar-expand-lg logo">
        <div class="container">
            <a class="navbar-brand" href="{{URL::to('/')}}">
                <img src="{{asset('public/asset_front/assets/images/logo.svg')}}" alt="logo">
            </a>
            <div class="contractheading">
                <p>Contract With
                    <span>Reserved4you
							</span>
                </p>
            </div>
        </div>
    </nav>
    <!-- Modal -->
</header>
<!-- Contact detail -->
<section class="contactdetail extraservices">
    <div class="progress">
        <div class="progress-bar progressbarr4u" role="progressbar" style="width: 100%;" aria-valuenow="25"
             aria-valuemin="0" aria-valuemax="100"></div>
    </div>
    <div class="container">
        <div class="contactheading">
            <h2>Allgemeine Geschäftsbedingungen B2B</h2>
        </div>
        <div class="paymentterms bankpaydetail b2binfo">
            <form method="post">
                @csrf
                <div class="row">
                    <div class="col-lg-6">
                        <div class="datelbl">
                            <label>Datum</label>
                            <input type="text" name="b2bdate" value="{{\Carbon\Carbon::now()->timezone('Europe/Berlin')->format('d-m-Y')}}" class="b2bdate datepicker" placeholder="Enter date">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="datelbl">
                            <label>Platz</label>
                            <input type="text" name="place"  value="Berlin" class="b2bdate" placeholder="Enter Place">
                        </div>
                    </div>
                </div>
                <div class="allgemeineinformation">
                    <div class="allgemeineinfo">
                        <p>1. Geltungsbereich</p>
                        <p>Für die Geschäftsbeziehung zwischen R.F.U. reserved4you GmbH, Wilmersdorfer Straße 122- 123,
                            10627Berlin (nachfolgend „reserved4you“) und dem Kunden (nachfolgend „Kunde“) gelten
                            ausschließlich dienachfolgenden allgemeinen Geschäftsbedingungen in ihrer zum Zeitpunkt der
                            Bestellung gültigenFassung. Die Bestimmungen dieser AGB gelten für Bestellungen, welche
                            Kunden über die Webseitewww.reserved4you. de oder einen Vertriebspartner abschließen. Die
                            Verwendung von anderen allgemeinenGeschäftsbedingungen, ist ausgeschlossen. Der Kunde ist
                            allein verantwortlich für die Erfüllung der Vereinbarungen mit den Endkunden oder
                            Verbraucher. www.reserved4you.de ist nicht Vertragspartnerdieser gesonderten Vereinbarungen
                            und Rechtsbeziehung und hat keinerlei Erfüllungspflichten oderHaftungen.</p>
                    </div>
                    <div class="b2binformation">
                        <p>1.1 Abweichende Bedingungen & Konditionen</p>
                        <p>Abweichende Bedingungen oder Konditionen des Kunden werden nicht anerkannt, es sei denn, der
                            Reserved4you stimmt ihrer Geltung ausdrücklich und in Schriftform zu.</p>
                    </div>
                    <div class="allgemeineinfo">
                        <p>2. Angebote und Leistungsbeschreibungen</p>
                        <p>Auf www.reserved4you.de stellen wir eine Online-Plattform zur Verfügung, über die
                            Dienstleister, in ihrer professionellen Kapazität, ihre Services bewerben, vermarkten,
                            verkaufen und/oder zur Bestellung, zum Kauf, zur Reservierung anbieten können und über die
                            Besucher dieser Plattform eine Bestellung, Reservierung, einen Kauf, oder eine Zahlung (d.
                            h. den Buchungsservice) entdecken, suchen, vergleichen und durchführen können. Mit der
                            Nutzung des Buchungsservice (z. B. indem Sie eine Buchung über den gewünschten Anbieter
                            durchführen, gehen Sie ein unmittelbares rechtlich bindendes Vertragsverhältnis mit dem
                            Endanbieter ein, bei dem Sie buchen oder einen Service erwerben. Ab dem Zeitpunkt Ihrer
                            Buchung wirken wir ausschließlich als Vermittler zwischen Ihnen und dem Anbieter, indem wir
                            dem jeweiligen Anbieter die Angaben zu Ihrer Buchung weiterleiten und Ihnen im Auftrag und
                            im Namen des Anbieters eine Bestätigungs- E-Mail zusenden. Reserved4you verkauft, vermietet
                            oder bietet keinerlei Produkte oder Services direkt an und ist nur Vermittler. Die Rolle von
                            www.reserved4you.de beim Abschluss dieser Vereinbarungen ist nur die eines Vermittlers. Die
                            Ausnahme stellen jedoch die Leistung auf www.reserved4you.de dar und wie in diesem Abschnitt
                            beschrieben. Die Vorstellung und Beschreibung der Waren auf der Internetseite
                            www.reserved4you.de stellt noch kein Vertragsangebot dar.</p>
                    </div>
                    <div class="b2binformation">
                        <p>2.1 Information auf der Webseite & deren Richtigkeit</p>
                        <p>Die Informationen, die wir für die Ausführung unserer Dienstleistungen verwenden, basieren
                            auf den Informationen, die uns von den Anbietern zur Verfügung gestellt werden. Die
                            Anbieter, die ihre Dienstleistungen oder Produkte auf unserer Plattform vermarkten und
                            bewerben, haben Zugang zu unseren Systemen und dem Extranet und tragen somit die alleinige
                            Verantwortung dafür, dass die Raten/Gebühren/Preise, die Verfügbarkeit, Richtlinien und
                            Geschäftsbedingungen und andere wichtige Informationen, die auf unserer Webseite aufgeführt
                            sind, stets Aktuell sind. Obwohl wir bei der Ausführung unserer Dienstleistungen sehr
                            sorgfältig und gewissenhaft vorgehen, können wir weder überprüfen und garantieren, dass alle
                            Informationen genau, richtig und vollständig sind, noch können wir für Fehler
                            (einschließlich offenkundiger Fehler oder Tippfehler), Unterbrechungen (durch einen zeitlich
                            begrenzten und/oder einen teilweisen Ausfall, Reparatur-, Aktualisierungsoder
                            Instandhaltungsarbeiten auf unserer Webseite oder einem anderen Grund), ungenaue,
                            irreführende oder unwahre Informationen oder Nichtübermittlung der Informationen
                            verantwortlich gemacht werden. Jeder Anbieter bleibt stets für die Genauigkeit,
                            Vollständigkeit und Richtigkeit der (beschreibenden) Informationen (einschließlich der
                            Raten/Preise/Gebühren, Richtlinien & Geschäftsbedingungen und Verfügbarkeiten) auf unserer
                            Webseite verantwortlich. Unsere Webseite stellt keine Empfehlung oder Bestätigung der
                            Qualität, des Serviceniveaus, der Qualifizierung, der Klassifikation eines Anbieters (oder
                            seiner Einrichtungen, Veranstaltungsorte, (Haupt- oder Neben-Produkte oder Services) dar und
                            soll auch nicht als solche angesehen werden, soweit nicht explizit angegeben.</p>
                    </div>
                    <div class="b2binformation">
                        <p>2.2 Nutzung der Dienstleistungen</p>
                        <p>Unsere Dienstleistungen stehen nur zu den Beschriebenen privaten und kommerziellen Nutzung
                            zur Verfügung. Jedoch ist es Ihnen nicht gestattet, Inhalte oder Informationen, Produkte
                            oder Dienstleistungen, die auf unserer Webseite verfügbar sind, zu gewerblichen oder
                            wettbewerblichen Zwecken weiter zu vertreiben, mit Unterseiten von Webseiten zu verlinken,
                            zu nutzen, zu vervielfältigen, zu extrahieren (zum Beispiel mit Spider, Scrape), neu zu
                            veröffentlichen, hochzuladen oder zu reproduzieren. Falls dafür keine ausdrückliche und
                            schriftliche Genehmigung von unserer Seite vorliegt.</p>
                    </div>
                    <div class="allgemeineinfo">
                        <p>3. Vertragsabschluss</p>
                        <p>Die Leistungen der reserved4you können durch unser Vertragsformular entweder Online oder
                            mithilfe eines Vertriebsmitarbeiters gebucht werden. Der Kunde kann beim Durchlaufen des
                            Vertragsformulars individuelle Leistungen anpassen und z. B. den Leistungsumfang und die
                            Vertragslaufzeit bestimmen und/oder eventuelle benötigte Hardware hinzufügen. Über die
                            Schaltfläche absenden gibt der Kunde eine verbindliche Buchung der ausgewählten Leistungen
                            ab.</p>
                    </div>
                    <div class="b2binformation">
                        <p>3.1 Empfangsbestätigung</p>
                        <p>Reserved4you schickt daraufhin dem Kunden eine automatische Empfangsbestätigung per EMail zu,
                            in welcher die gewählten Leistungen nochmals aufgeführt wird und die der Kunde über die
                            Funktion „Drucken“ ausdrucken kann (Bestellbestätigung). Die automatische
                            Empfangsbestätigung dokumentiert lediglich, dass die Bestellung des Kunden bei Reserved4you
                            eingegangen ist, und stellt keine Annahme des Antrags dar. Der Kaufvertrag kommt erst dann
                            zustande, wenn Reserved4you die gewünschten Leistungen ausdrücklich bestätigt hat und der
                            Zahlvorgang erfolgreich abgeschlossen wurde.</p>
                    </div>
                    <div class="b2binformation">
                        <p>3.2 Kündigung</p>
                        <p>Ein Vertrag ist mit einer Frist von vierzehn Kalendertage bei einer Vertragslaufzeit von
                            einem Monat und von dreißig Kalendertagen bei einer Vertragslaufzeit von bis zu einem Jahr
                            in Schriftform kündbar. Maßgeblich ist das Zugangsdatum der Kündigung. Angebrochene
                            Kalendermonate werden als voller Vertragsmonat berechnet. Das Recht zur fristlosen Kündigung
                            aus wichtigem Grund bleibt davon unberührt. Ein wichtiger Grund liegt insbesondere vor, wenn
                            reserved4you seinen Dienst einstellt oder der Kunde gegen seine Pflichten aus diesem Vertrag
                            verstößt. Ein etwaiger unverbindlicher Testzugang endet automatisch mit Ablauf des
                            jeweiligen Testzeitraums und muss nicht gekündigt werden. Nach Ablauf des Abonnements wird
                            der Zugriff des Nutzers auf das System gesperrt.</p>
                    </div>
                    <div class="b2binformation">
                        <p>3.3 Außerordentliche Kündigung</p>
                        <p>Bei einer grundlegenden Änderung von rechtlichen oder technischen Rahmenbedingungen wird
                            reserved4you erlaubt außerordentlich und einseitig zu kündigen, wenn es dadurch für
                            reserved4you unzumutbar wird, die vom Kunden gewählten Leistungen ganz oder teilweise im
                            Rahmen des Vertragszwecks zu erbringen. Eine etwaige Teilerstattung von Leistungen wird in
                            diesem Falle geprüft.</p>
                        <p>Soweit reserved4you Leistungen und Dienste unentgeltlich erbringt, können diese jederzeit
                            ohne Vorankündigung und ohne Angabe von Gründen eingestellt werden.</p>
                    </div>
                    <div class="b2binformation">
                        <p>3.4 Vorkasse und Vertragsabschluss</p>
                        <p>Sollte reserved4you eine Vorkasse Zahlung ermöglichen, kommt der Vertrag mit der
                            Bereitstellung der Bankdaten und Zahlungsaufforderung zustande. Wenn die Zahlung trotz
                            Fälligkeit auch nach erneuter Aufforderung nicht bis zu einem Zeitpunkt von zwei
                            Kalendertagen nach Absendung der Bestellbestätigung bei Reserved4you eingegangen ist, tritt
                            Reserved4you vom Vertrag zurück mit der Folge, dass die Bestellung hinfällig ist und
                            Reserved4you keinerlei Erfüllungspflichten hat. Die Buchung ist dann für den Kunden und
                            Reserved4you ohne weitere Folgen erledigt. Eine Reservierung mit Vorkasse erfolgt daher
                            nicht mehr als fünf Kalendertage im Voraus.</p>
                    </div>
                    <div class="allgemeineinfo">
                        <p>4. Vergütung, Preise und Zahlungsbedingungen</p>
                        <p>Alle Preise, die auf der Webseite von Reserved4you angegeben sind, verstehen sich
                            einschließlich der jeweils gültigen gesetzlichen Umsatzsteuer, aller anderen Steuern und
                            Abgaben (und unterliegen somit Steuerschwankungen) sowie aller Gebühren angezeigt, sofern
                            dies nicht anders auf unserer Webseite angegeben werden.</p>
                    </div>
                    <div class="b2binformation">
                        <p>4.1 Gebühr für die Leistung</p>
                        <p>Reserved4you berechnet für die Bereitstellung der Leistung eine Gebühr, welche abhängig vom
                            gewählten Leistungspaket und der vereinbarten Vertragslaufzeit ist. Näheres zu diesen
                            Paketen unter www.reserved4you.de</p>
                    </div>
                    <div class="b2binformation">
                        <p>4.2 Testzugänge</p>
                        <p>Reserved4you kann Testzugänge anbieten. Während des jeweiligen Testzeitraums ist die Nutzung
                            kostenlos. Wenn der Kunde die Dienstleistungen nach Ablauf des Testzeitraums weiter nutzen
                            möchte, ist der Abschluss eines gesonderten kostenpflichtigen Vertrags erforderlich.</p>
                    </div>
                    <div class="b2binformation">
                        <p>4.3 Bereitstellungsgebühr</p>
                        <p>Die Bereitstellungsgebühr ist für die jeweilige Vertragslaufzeit im Voraus fällig und
                            zahlbar, falls mit dem Kunden kein abweichender Abrechnungszeitraum vereinbart sein
                            sollte.</p>
                    </div>
                    <div class="b2binformation">
                        <p>4.4 Sepa-Lastschrift</p>
                        <p>Der Kunde kann im Rahmen und vor Abschluss des Bestellvorgangs die Zahlungsart
                            SEPALastschrift wählen. Wird per SEPA Lastschrift gezahlt, erteilt der Kunde hierzu bei
                            Vertragsabschluss sein Einverständnis. Die Frist zur Vorabankündigung (Pre-Notifcation) von
                            SEPA Lastschriften wird auf zwei Tage verkürzt. Der Kunde verpflichtet sich, zu dem
                            Zeitpunkt der Abbuchung eine für den Betrag der Rechnung ausreichende Deckung auf dem von
                            ihm angegebenen Konto zu unterhalten. Die Kosten für eine vom Geldinstitut zurückgegebene
                            Lastschriftbuchung werden dem Kunden in Rechnung gestellt, sofern er die Zurückweisung der
                            Buchung zu vertreten hat.</p>
                    </div>
                    <div class="b2binformation">
                        <p>4.5 Bezahlung durch Bezahldienstleister oder andere Dritte</p>
                        <p>Der Kunde hat im Rahmen und vor Abschluss des Bestellvorgangs auch die Möglichkeit, die
                            Zahlung via Drittanbieter (wie zum Beispiel Paypal, Stripe, etc.) durchzuführen. Im Falle
                            von Zahlung, via solcher Drittanbieter, gehen sämtliche damit verbunden Kosten und Gebühren
                            zulasten des Kunden. Reserved4you verrechnet die effektiv entstanden Kosten weiter und bucht
                            diese dem Dienstleister jeweils zusammen mit der monatlichen Rechnung ab.</p>
                    </div>
                    <div class="b2binformation">
                        <p>4.6 Fälligkeit</p>
                        <p>Ist die Fälligkeit der Zahlung nach dem Kalender bestimmt, so kommt der Kunde bereits durch
                            Versäumnis am nächsten Kalendertag in Verzug. In diesem Fall hat der Kunde die gesetzlichen
                            Verzugszinsen zu zahlen.</p>
                    </div>
                    <div class="b2binformation">
                        <p>4.7 Rechnungsstellung & Format der Rechnung</p>
                        <p>Reserved4you erstellt alle Rechnungen nur in digitalem Format. Die Rechnungen warden dem
                            Kunden jeweils per E-Mail zugestellt. Hiermit erklärt sich der Kunde einverstanden. Verlangt
                            der Kunde die postalische Zusendung einer Rechnung, wird reserved4you hierfür eine
                            angemessene Aufwandsentschädigung je Rechnung verlangen.</p>
                    </div>
                    <div class="b2binformation">
                        <p>4.8 Sperrung oder Verweigerung der Leistung</p>
                        <p>Bei Zahlungsverzug ist reserved4you berechtigt Leistungen zu sperren oder nach entsprechender
                            Androhung das Vertragsverhältnis zu kündigen. Die vorübergehende Sperrung von Diensten
                            berührt die Zahlungspflicht des Kunden nicht.</p>
                    </div>
                    <div class="allgemeineinfo">
                        <p>5. Zugriffsrecht & Ausschluss, Eigentumsvorbehalt</p>
                        <p>Der Kunde erhält das nicht ausschließliche, auf die Laufzeit dieses Vertrages zeitlich
                            beschränkte Recht, auf reserved4you mit einem geeigneten Internetbrowser zuzugreifen und die
                            mit reserved4you verbundenen Funktionalitäten gemäß diesem Vertrag zu nutzen.
                            Darüberhinausgehende Rechte, insbesondere am Quellcode der Software erhält der Kunde
                            nicht.</p>
                    </div>
                    <div class="b2binformation">
                        <p>5.1 Geistiges Eigentum</p>
                        <p>Es wird kein geistiges Eigentum an den Kunden übertragen. Auch individuell angepasste
                            Software, die sich auf reserved4you bezieht, bleibt das geistige Eigentum des
                            Dienstleisters, es sei denn, dass etwas Abweichendes vereinbart wird.
                            <br>
                            <br>Alle Logos und Markenzeichen des Kunden sowie andere mögliche eingetragene Marken,
                            Copyrights und Muster sind und bleiben Eigentum des Kunden. Es wird aber www.reserved4you.de
                            ein unentgeltliches Nutzungsrecht für die Dauer des Vertragsverhältnisses eingeräumt zur
                            Ausübung der Dienstleistung. Der Kunde sieht davon ab andere Marken, Copyrights oder
                            sonstige Markenzeichen anderen Anbieter, für die er nicht die notwendigen Nutzungsrechte hat
                            zu verwenden. Der Kunde hält www.reserved4you.de von allen Schadensersatzansprüchen,
                            Bußgeldern und allen sonstigen Kosten in solchen Streitigkeiten oder Konflikten frei.</p>
                    </div>
                    <div class="b2binformation">
                        <p>5.2 Nutzung</p>
                        <p>Der Kunde ist nicht berechtigt, reserved4you über die nach Maßgabe dieses Vertrages erlaubte
                            Nutzung hinaus zu nutzen oder von Dritten nutzen zu lassen oder es Dritten zugänglich zu
                            machen. Insbesondere ist es dem Kunden nicht gestattet, reserved4you oder Teile davon zu
                            vervielfältigen, zu veräußern oder zeitlich begrenzt zu überlassen, vor allem nicht zu
                            vermieten oder zu verleihen.
                            <br>
                            <br>Dem Kunden ist es untersagt, Werbung von reserved4you in jeglicher Form an die Endkunden
                            eines Drittanbieters zu übermitteln, weiterzugeben oder zu senden.</p>
                    </div>
                    <div class="b2binformation">
                        <p>5.3 Doppelregistrierung & unrichtige Registrierung</p>
                        <p>Bei einer Doppelregistrierung oder unrichtigen Registrierung eines Accounts behält sich
                            www.reserved4you.de eine Prüfung des Sachverhaltes vor und eine etwaige Kündigung zum nächst
                            möglichen Vertragszeitpunkt sowie eine Sperrung oder Löschung des Accounts vor. Diese
                            Maßnahmen dienen dem Interesse und Missbrauchsschutz aller Parteien.</p>
                    </div>
                    <div class="allgemeineinfo">
                        <p>6. Vertragswidrige Nutzung</p>
                        <p>Reserved4you ist berechtigt, bei rechtswidrigem Verstoß des Kunden gegen eine der hier
                            festgelegten wesentlichen Pflichten, den Zugang zu Reserved4you und zu dessen Daten zu
                            sperren. Der Zugang wird erst dann wiederhergestellt, wenn der Verstoß gegen die betroffene
                            wesentliche Pflicht dauerhaft beseitigt ist. Der Kunde bleibt in diesem Fall verpflichtet,
                            die vereinbarte Vergütung zu zahlen.</p>
                    </div>
                    <div class="allgemeineinfo">
                        <p>7. Haftung und Haftungsausschluss</p>
                        <p>Reserved4you haftet nur unbeschränkt, soweit die Schadensursache auf Vorsatz oder grober
                            Fahrlässigkeit beruht.
                            <br>
                            <br>Ferner haftet Reserved4you nur für die leicht fahrlässige Verletzung von wesentlichen
                            Pflichten, deren Verletzung die Erfüllung des Vertragszwecks gefährdet, oder für die
                            Verletzung von Pflichten, deren Erfüllung die ordnungsgemäße Durchführung des Vertrages
                            überhaupt erst ermöglicht und auf deren Einhaltung der Kunde regelmäßig vertraut. In diesem
                            Fall haftet Reserved4you jedoch nur für den vorhersehbaren, vertragstypischen Schaden.
                            Reserved4you haftet nicht für die leicht fahrlässige Verletzung anderer außer in den
                            vorstehenden Absätzen genannten Pflichten.
                            <br>
                            <br>Die vorstehenden Haftungsbeschränkungen gelten nicht bei Verletzung von Leben, Körper
                            und Gesundheit, für einen Mangel nach Übernahme einer Garantie für die Beschaffenheit des
                            Produktes und bei arglistig verschwiegenen Mängeln. Die Haftung nach dem
                            Produkthaftungsgesetz bleibt unberührt.
                            <br>
                            <br>Soweit die Haftung von Reserved4yous ausgeschlossen oder beschränkt ist, gilt dies auch
                            für die persönliche Haftung von Arbeitnehmern, Vertretern und Erfüllungsgehilfen.
                            <br>
                            <br>Für eine sonstige Haftung von Reserved4yous auf Schadensersatz gelten unverändert die
                            sonstigen gesetzlichen Anspruchsgrundlagen sowie Haftungsausschlüsse und -begrenzungen.</p>
                    </div>
                    <div class="b2binformation">
                        <p>7.1 Gefahrenübergang</p>
                        <p>Das Risiko einer zufälligen Verschlechterung oder einem zufälligen Verlust der Ware oder
                            Dienstleistung liegt alleinig bis zur Übergabe dieser beim Kunden und geht mit der Übergabe
                            auf den Verbraucher über.</p>
                    </div>
                    <div class="allgemeineinfo">
                        <p>8. Datenschutz</p>
                        <p>Soweit reserved4you auf personenbezogene Daten des Kunden oder aus dessen Bereich zugreifen
                            kann, wird er ausschließlich als Auftragsverarbeiter tätig und diese Daten nur zur
                            Vertragsdurchführung verarbeiten und nutzen. Reserved4you wird Weisungen des Kunden für den
                            Umgang mit diesen Daten beachten. Der Kunde trägt etwaige nachteilige Folgen solcher
                            Weisungen für die Vertragsdurchführung. Weitere und genaue Details sind in den
                            Datenschutzrichtlinien und der Datenschutzverordnung auf der Seite www.reserved4you.de unter
                            Datenschutzrichtlinen einzusehen.
                            <br>
                            <br>Der Kunde bleibt sowohl allgemein im Auftragsverhältnis als auch im
                            datenschutzrechtlichen Sinne der Verantwortliche. Verarbeitet der Kunde im Zusammenhang mit
                            dem Vertrag personenbezogene Daten (einschließlich Erhebung und Nutzung), so steht er dafür
                            ein, dass er dazu nach den anwendbaren, insbesondere datenschutzrechtlichen Bestimmungen
                            berechtigt ist und stellt im Falle eines Verstoßes von Reserved4you von Ansprüchen Dritter
                            frei. Weitere und genaue Details sind in den Datenschutzrichtlinien und der
                            Datenschutzverordnung auf der Seite www.reserved4you.de unter Datenschutzrichtlinen
                            einzusehen.</p>
                    </div>
                    <div class="b2binformation">
                        <p>8.1 Personenbezogene Daten</p>
                        <p>Für das Verhältnis zwischen Reserved4you und Kunde gilt: Gegenüber der betroffenen Person
                            trägt die Verantwortung für die Verarbeitung (einschließlich Erhebung und Nutzung)
                            personenbezogener Daten der Kunde, außer soweit reserved4you etwaige Ansprüche der
                            betroffenen Person wegen einer ihm zuzurechnenden Pflichtverletzung zu vertreten hat. Der
                            Kunde wird etwaige Anfragen, Anträge und Ansprüche der betroffenen Person verantwortlich
                            prüfen, bearbeiten und beantworten. Das gilt auch bei einer Inanspruchnahme von Reserved4you
                            durch die betroffene Person. Reserved4you wird den Kunden im Rahmen seiner Pflichten
                            unterstützen. Weitere und genaue Details sind in den Datenschutzrichtlinien und der
                            Datenschutzverordnung auf der Seite www.reserved4you.de unter Datenschutzrichtlinen
                            einzusehen.</p>
                    </div>
                    <div class="b2binformation">
                        <p>8.2 Datenschutz</p>
                        <p>Reserved4you gewährleistet, dass Daten des Kunden ausschließlich im Gebiet der Bundesrepublik
                            Deutschland, in einem Mitgliedsstaat der Europäischen Union oder in einem anderen
                            Vertragsstaat des Abkommens über den europäischen Wirtschaftsraum gespeichert werden, soweit
                            nichts anderes vereinbart. Weitere und genaue Details sind in den Datenschutzrichtlinien und
                            der Datenschutzverordnung auf der Seite www.reserved4you.de unter Datenschutzrichtlinen
                            einzusehen.</p>
                    </div>
                    <div class="allgemeineinfo">
                        <p>9. Speicherung der AGB</p>
                        <p>Der Kunde kann diese AGB vor der Abgabe der Buchung auf reserved4you einsehen und ausdrucken,
                            indem er die Druckfunktion seines Browsers nutzt. Die AGBs auf der Webseite sind immer die
                            letzte gültige Version.</p>
                    </div>
                    <div class="b2binformation">
                        <p>9.1 Buchungsbestätigung</p>
                        <p>Reserved4you sendet dem Kunden außerdem eine Buchungsbestätigung mit allen Buchungsdaten an
                            die angegebene E-Mail-Adresse zu. Mit der Buchungsbestätigung, spätestens jedoch bei der
                            Buchung erhält der Kunde ferner eine Kopie der AGB nebst Widerrufsbelehrung und den
                            Hinweisen zu den Zahlungsbedingungen. Darüber hinaus speichern wir den Vertragstext, machen
                            ihn jedoch im Internet nicht frei zugänglich.</p>
                    </div>
                    <div class="allgemeineinfo">
                        <p>10. Gerichts- & Rechtsstand</p>
                        <p>Gerichtsstand und Erfüllungsort ist der Sitz von Reserved4yous. Die AGB unterliegen deutschem
                            Recht unter Ausschluss des UN-Kaufrechts.</p>
                    </div>
                    <div class="b2binformation">
                        <p>10.1 Vertrags und Kommunikationssprache</p>
                        <p>Vertragssprache und Kommunikationssprache ist ausschließlich Deutsch.</p>
                    </div>
                    <div class="b2binformation">
                        <p>10.2 Schlichtung</p>
                        <p>Wir sind nicht bereit und nicht verpflichtet an einem Streitbeilegungsverfahren vor einer
                            Verbraucherschlichtungsstelle teilzunehmen. Werden uns jedoch um eine Einigung im Interesse
                            aller Parteien bemühen.</p>
                    </div>
                    <div class="allgemeineinfo">
                        <p>11. Aufrechnung und Zusatzkosten</p>
                        <p>Der Kunde hat kein Recht, Ansprüche oder Zusatzkosten aufzurechnen, es sei denn, es handelt
                            sich um unbestrittene oder rechtskräftig festgestellte Ansprüche oder um voneinander
                            abhängige Forderungen. Der Kunde hat alle Kosten oder Zusatzkosten selbst zu tragen.</p>
                    </div>
                    <div class="allgemeineinfo">
                        <p>12. Änderungen</p>
                        <p>Reserved4you ist berechtigt, diese AGBs zu ändern, soweit die Änderungen für den Kunden
                            zumutbar sind. Über die beabsichtigten Änderungen wird Reserved4you den Kunden rechtzeitig
                            und per E-Mail informieren. Sofern seitens des Kunden innerhalb von vierzehn Kalendertagen
                            nach Zugang der Benachrichtigung kein Widerspruch erfolgt, gelten die Änderungen als
                            angenommen. Über das Widerspruchsrecht sowie über Rechtsfolgen des Fristablaufs wird
                            Reserved4you in der Benachrichtigung hinweisen.</p>
                    </div>
                </div>
        </div>
        <div class="servicebtns allgemeinebtn"><a href="{{URL::to('contact')}}" class="previous" type="btn">Zurück</a>
            <a href="javascript:void(0);" onclick="b2b_store();" class="next" >Fertig</a>
        </div>
        </form>
    </div>
</section>
<script src="{{asset('public/asset_front/assets/js/jquery.min.js')}}"></script>
<script src="{{asset('public/asset_front/assets/js/bootstrap.bundle.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="{{asset('public/asset_front/assets/js/owl.carousel.min.js')}}"></script>
<script src="{{asset('public/asset_front/assets/js/bootstrap-datepicker.min.js')}}"></script>
<script src="{{asset('public/asset_front/assets/js/custom3.js')}}"></script>


<script>


    function b2b_store() {
        var b2bdate = $("input[name=b2bdate]").val();
        var place = $("input[name=place]").val();
        var _token = $("input[name=_token]").val();

        $.ajax({
            type: 'post',
            url: '{{ route("b2b_store") }}',
            data: {
                'b2bdate': b2bdate,
                'place': place,
                _token: _token
            },
            success: function (data) {

                window.location.replace("https://delemontstudio.com/r4ucontract/done");

            }
        });
    }
</script>

<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
</body>
</html>
