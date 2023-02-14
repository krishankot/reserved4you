@extends('ServiceProvider.pdf.layout')

@section('title')
    {{$items->title}}
@endsection
@section('css')
<style> 
    body {
        font-size: 16px;
        line-height: 1.8;
    }
    .booking-table {
        margin-top: 50px;
    }
</style>
<style type="text/css" media="print">
    @media print {
        @page { margin: 0; }
        body { margin: 1.6cm; }
        .first-booking-table {
            page-break-after:always;
            margin-top: 150px!important;
            margin-bottom: 150px!important;
        }
        .other-tables {
            page-break-after:always;
            margin-top: 180px!important;
            margin-bottom: 150px!important;
        }
        /* .footer3 {} */
    }
</style>
<style>
    .logo-text {
        margin-left: -50px;
        margin-right: -50px;
    }
    .invoice-total {
        margin-left: 20px;
    }
    .footer3 {
        margin: 0;
        margin-bottom: 10px;
    }
    td.text-center {
        display: flex;
        justify-content: center;
    }
    .table-amount {
        display: flex;
        justify-content: end;
        width: 40%;
    }
    .price-off-width {
        position: absolute;right: 5%;
    }
    @media(max-width: 1200px) {
        .col-3.reduce {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 20%;
            flex: 0 0 20%;
            max-width: 20%;
        }
        .col-3.wide {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 30%;
            flex: 0 0 30%;
            max-width: 30%;
        }
    }
    @media(min-width: 1200px) {
        .pdf-logo {
            width: 90%!important;
        }
    }
    @media(min-width: 1440px) {
        #pdf, header, footer {
            width: 1200px;
            margin: 0 auto;
        }
        .footer3 {
            margin-left: 50px!important;
        }
        header .row {
            margin: 0 50px;
        }
        .price-off-width {
            right: 12%;
        }
    }
    @media(min-width: 1500px) {
        .price-off-width {
            right: 14%;
        }
    }
    @media(min-width: 1640px) {
        .price-off-width {
            right: 17%;
        }
    }
    
</style>
@endsection
@section('content')
@if(empty($viewtype) OR (!empty($viewtype) && $viewtype != 'webview'))
	<button class="btn btn-secondary print-btn position-absolute" >Download</button>
@endif
{{-- <button onclick="window.print();" class="btn btn-secondary print-btn position-absolute" >Download</button> --}}
<div id="pdf">
    <header>
        <div class="row" style="padding-top: 50px;">
            <div class="col-2 col-xl-2 pl-0 pr-0">
                <span class="dash-black">
                    <hr>
                </span>
            </div>
            <div class="col-2 col-xl-2 text-center">
                {{-- <img class="w-100" style="object-fit: contain;" src="{{asset('storage/Adminassets/images/logo.png')}}" alt="Reserved4you" height="40" /> --}}
                <img class="w-100 pdf-logo" style="margin-top: -5px;" src="{{URL::to('storage/app/public/Serviceassets/images/logo.png')}}" alt="Reserved4you" height="40" />
                <span class="d-block logo-text">SMART MANAGEMENT. BETTER SERVICE.</span>
            </div>
            <div class="col-8 col-xl-8 pl-0 pr-0">
                <span class="dash-black">
                    <hr>
                    <span class="d-block line-text">
                        R.F.U. reserved4you GmbH | Wilmersdorfer Straße 122/123 | 10627 Berlin
                    </span>
                </span>
            </div>
        </div>
    </header>
    <main class="body">
        <section style="page-break-after:always;">
            <div class="address">
                <address>
                    {{$data->contract->storename}}<br>
                    @if (!empty($store->store_address))
                        @php $address = explode(',', $store->store_address) @endphp
                        @for ($i = 0; $i < count($address); $i++)
                            @if($i == 1)
                                {{$store->zipcode ?? $data->contract->Zipcode}}
                            @endif
                            {{$address[$i]}}<br>
                        @endfor
                    @else
                        @php $address = explode(',', $data->contract->Address) @endphp
                        @for ($i = 0; $i < count($address); $i++)
                            @if($i == 1)
                                {{$data->contract->Zipcode}}
                            @endif
                            {{$address[$i]}}<br>
                        @endfor
                    @endif
                </address>
            </div>
    
            <div class="mt-5 mb-3">
                <h5>
                    Sehr geehrte/r {{$data->contract->firstname ?? ''}} {{$data->contract->Lastname ?? ''}},
                </h5>
                @if (empty($items->reminders))    
                
                    @if ($items->bill_type == 'cancelled')
                        <div style="text-align: justify" class="text-justify">
                            gemäß unserer Absprache stornieren wir die Rechnung {{$items->booking_ids}} vom {{Carbon\Carbon::parse($items->due_date)->format('d.m.Y')}} wie folgt:
                        </div>
                    @else
                        <div style="text-align: justify" class="text-justify">
                            wir bedanken uns für lhr Vertrauen und hoffen Sie sind stets mit uns zufrieden. Hiermit berechnen wir lhnen folgende Leistungen:
                        </div>
                    @endif
                @endif
            </div>
    
            <div class="invoice-table">
                
                @if ($items->bill_type == 'cancelled')
                    <h3 class="section-title mt-5 mb-2">Stornorechnung</h3>
                @else
                    <h3 class="section-title mt-5 mb-2">Rechnung</h3>
                @endif
                
                <span class="dash-black">
                    <hr class="mt-0">
                </span> 
    
                <div class="row text-center mt-3">
                    <div class="col-md-3">
                        <span class="sub-heading">
                            Kundennummer:
                        </span>
                        <p>{{$store->id ?? 'noch nicht verfügbar'}}</p>
                    </div>
                    <div class="col-md-3">
                        <span class="sub-heading">
                            Steuernummer:
                        </span>
                        <p>{{$bankdetails->taxnumber ?? '---'}}</p>
                    </div>
                    <div class="col-md-3">
                        <span class="sub-heading">
                            Rechnungsnummer:
                        </span>
                        <p>{{$items->invoice_number}}</p>
                    </div>
                    <div class="col-md-3">
                        <span class="sub-heading">
                            Rechnungsdatum:
                        </span>
                        <p>{{Carbon\Carbon::parse($items->created_at)->format('d.m.Y')}}</p>
                    </div>
                </div>
                
                <table class="table mb-5">
                    <thead>
                        <tr>
                            <th>Pos.</th>
                            <th>Details</th>
                            <th>Menge</th>
                            <th class="text-center">Gesamtpreis</th>
                        </tr>
                    </thead>
                    @php 
                        $i = 1;
                    @endphp
                    <tbody>
                        @foreach ($items->details as $item)
                        @if(!str_contains($item->price, '%'))
                        <tr>
                            <td>{{$i}}</td>
                            <td>
                                {{$item->item_name}} <br />
                                {{Carbon\Carbon::parse($items->start_date)->format('d.m.Y')}} - {{Carbon\Carbon::parse($items->due_date)->format('d.m.Y')}} <br />
                                2,5% von {{number_format($totalBooking, 2, ',', '.') }}€
                            </td>
                            <td>
                                {{count($items->booking_ids)}}
                            </td>
                            <td class="text-center">
                                <span></span>
                                <span class="table-amount text-right">
                                    <span>{{ number_format($item->price, 2, ',', '.') }} €</span>
                                    <span></span>
                                </span>
                                <span></span>
                            </td>
                        </tr>
                        @php $i++; @endphp
                        @endif
                        @endforeach
                        
                    </tbody>
                </table>
                <div class="float-right invoice-total">
                    <div class="row">
                        <div class="col-7">Gesamtbetrag (Netto)</div>
                        <div class="col-5 pr-4 text-right">{{number_format($items->sub_total, 2, ',', '.')}} €</div>
                    </div>
                    <div class="row">
                        <div class="col-7">Mwst 19%</div>
                        <div class="col-5 pr-4 text-right">{{number_format($items->vat, 2,',','.')}} €</div>
                    </div>
                    @if (!empty($items->discount) || $items->discount != 0)
                    <div class="row">
                        <div class="col-7">Discount</div>
                        <div class="col-5 pr-4 text-right">{{$items->discount}} %</div>
                    </div>
                    @endif
                    <div class="row">
                        <div class="col-7">Gesamtbetrag (Brutto)</div>
                        <div class="col-5 pr-4 text-right">{{number_format($items->total, 2,',','.')}} €</div>
                    </div>
                    <div class="row">
                        <div class="col-7">Auszahlungsbetrag</div>
                        <div class="col-5 pr-4 text-right">{{number_format($items->final_amount, 2,',','.')}} €</div>
                    </div>
                </div>
    
                {{-- <div class="footer1">
                    Den genannten Forderungsbetrag werden wir lhnen zum Fälligkeitstermin, den {{Carbon\Carbon::parse($items->payment_at)->format('d.m.Y')}}, <br>
                    von lhrem Konto per SEPA-Lastschrift einziehen.
                </div> --}}
                <div class="footer2">
                   <div class="d-flex">
                       <div class="bank-details mr-4">
                           <p>IBAN: <span class="font-weight-bolder">{{$bankdetails->Iban ?? '---'}}</span></p>
                           <p>Kontoinhaber: <span class="font-weight-bolder">{{$bankdetails->Account_holder ?? '---'}}</span></p>
                           <p>Mandatsreferenz-Nr: <span class="font-weight-bolder">{{$store->id ?? $items->invoice_number}}</span></p>
                        </div>
                        <div class="bank-details">
                            <p>Bankleitzahl: <span class="font-weight-bolder">{{$bankdetails->Bank_code ?? '---'}}</span></p>
                            <br />
                            <p>Gläubiger-ID: <span class="font-weight-bolder"> DE36ZZZ00002263980</span>
                        </div>
                   </div>
                </div>
    
    
                <div class="clearfix"></div>
    
    
            </div>
        </section>
        @php $i = 0; @endphp
        @foreach ($bookings as $booking)    
            <section class="booking-table @if($i > 0) other-tables @else first-booking-table @endif">
                <table class="table mb-4">
                    <thead>
                        <tr>
                            <th>Buchungs-ID</th>
                            <th style="text-align: center;">Datum</th>
                            <th style="text-align: center;">Service</th>
                            <th style="text-align: right;">Preis</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($booking as $row)
                            <tr class="table-body">
                                <td>#{{$row->appointmentDetails->order_id}}</td>
                                <td style="text-align: center;">{{\Carbon\Carbon::parse($row->updated_at)->format('d M, Y | H:i')}}</td>
                                <td style="text-align: center;">{{@$row->serviceDetails->service_name == '' ? '-' : @$row->serviceDetails->service_name}}</td>
                                <td style="text-align: right;">{{number_format($row->price, 2,',','.')}} €</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </section>
            @php $i++; @endphp
        @endforeach
    </main>
    <footer>
        <div class="row footer3">
            <div class="px-0 col-3 wide">
                <address>
                    Firma: R.F.U.reserved4you GmbH<br />
                    Geschäftsführung: Pia Lulei und Hadi Ballout<br />
                    Adresse: Wilmersdorfer Straße 122-123, 10627 Berlin
                </address>
            </div>
            <div class="col-3">
                <address>
                    E-Mail: buchhaltung@reserved4you.de<br />
                    Telefon: +49 30 1663969316<br />
                    Website: www.reserved4you.de
                </address>
            </div>
            <div class="col-3 px-0 reduce">
                <address>
                    Steuernummer: 37/491/50313<br />
                    Handelsregister: HRB 208249B<br />
                    Amtsgericht: Charlottenburg
                </address>
            </div>
            <div class="col-3">
                <address>
                    Bank: Berliner Sparkasse<br>
                    BLZ: BELADEBEXXX<br>
                    IBAN: DE48 1005 0000 0190 8386 39
                </address>
            </div>
        </div>
    </footer>
</div>    
@endsection

@section('js')
    <script>
        document.querySelector('.print-btn').addEventListener('click', function() {
            setTimeout(() => {
                try {
                    document.execCommand('print');
                    // document.execCommand('print', false, null);
                }
                catch(e) {
                    window.print();
                }
            }, 1000);
        });
    </script>
@endsection