@extends('pdf.layout')

@section('title')
    {{$items['0']->name}}
@endsection
@section('content')
<a href="javascript:void(0)" class="btn btn-secondary print-btn position-absolute" onclick="printInvoice()">Download</a>
<div id="pdf">
    <header>
        <div class="row" style="padding-top: 50px;">
            <div class="col-2 px-0">
                <span class="dash-black">
                    <hr>
                </span>
            </div>
            <div class="col-3">
                {{-- <img class="w-100" style="object-fit: contain;" src="{{asset('storage/Adminassets/images/logo.png')}}" alt="Reserved4you" height="40" /> --}}
                <img class="w-100" style="object-fit: contain;" src="{{asset('storage/Adminassets/images/reserved4you_logo_black.png')}}" alt="Reserved4you" height="40" />
                <span class="d-block logo-text">SMART MANAGEMENT. BETTER SERVICE.</span>
            </div>
            <div class="col-7 pl-0">
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
        <div class="address">
            <address>
                {{$data->contract->storename}}<br>
                {{$data->contract->Address}}<br>
                {{$data->contract->Zipcode}} {{$data->contract->District ? '/ '.$data->contract->District : ''}} 
            </address>
        </div>
    
        <div class="text pt-4">
            <p>
                We thank you for your trust and hope you are always satisfied with us.<br>
                We hereby charge you for the following services:
            </p>
        </div>

        <div class="invoice-table">
            <h3 class="section-title mt-5 mb-2">Rechnung</h3>
            <span class="dash-black">
                <hr class="mt-0">
            </span> 

            <div class="row text-center mt-3">
                <div class="col-md-3">
                    <span class="sub-heading">
                        Customer Number:
                    </span>
                    <p>{{$store->id ?? ''}}</p>
                </div>
                <div class="col-md-3">
                    <span class="sub-heading">
                        Tax Number:
                    </span>
                    <p></p>
                </div>
                <div class="col-md-3">
                    <span class="sub-heading">
                        Bill Number:
                    </span>
                    <p></p>
                </div>
                <div class="col-md-3">
                    <span class="sub-heading">
                        Date of Invoice:
                    </span>
                    <p>{{formatDate($items['0']->created_at)}}</p>
                </div>
            </div>
            
            <table class="table mb-5">
                <thead>
                    <tr>
                        <th>Pos.</th>
                        <th>Details</th>
                        <th>lot</th>
                        <th class="text-center">total price</th>
                    </tr>
                </thead>
                @php $i = 1; @endphp
                <tbody>
                    @foreach ($items as $item)
                    <tr>
                        <td>{{$i}}</td>
                        <td>{{$item->details}}</td>
                        <td>lot</td>
                        <td class="text-center">{{format_money($item->price)}}</td>
                    </tr>
                    @php $i++; @endphp
                    @endforeach
                    @if ($extraService->count() > 0)
                        @foreach ($extraService as $item)
                        @if (!str_contains($item->Service_amount, '%') && $item->plan_type != "onetime")    
                            <tr>
                                <td>{{$i}}</td>
                                <td>{{$item->Service_plan}}</td>
                                <td>lot</td>
                                <td class="text-center">{{format_money($item->Service_amount)}}</td>
                            </tr>
                            @php 
                                $i++; 
                            @endphp
                        @endif
                        @endforeach
                    @endif
                    @if ($hardware->count() > 0)
                        @foreach ($hardware as $item)
                        @if (!str_contains($item->Service_amount, '%') && $item->plan_type != "onetime")    
                            <tr>
                                <td>{{$i}}</td>
                                <td>{{$item->Service_plan}}</td>
                                <td>lot</td>
                                <td>{{format_money($item->Service_amount)}}</td>
                            </tr>
                            @php 
                                $i++; 
                            @endphp
                        @endif
                        @endforeach
                    @endif
                    @if ($marketing->count() > 0)
                        @foreach ($marketing as $item)
                        @if (!str_contains($item->Service_amount, '%') && $item->plan_type != "onetime")    
                            <tr>
                                <td>{{$i}}</td>
                                <td>{{$item->Service_plan}}</td>
                                <td>lot</td>
                                <td>{{format_money($item->Service_amount)}}</td>
                            </tr>
                            @php 
                                $i++; 
                            @endphp
                        @endif
                        @endforeach
                    @endif
                </tbody>
            </table>

            <div class="float-right invoice-total">
                <div class="row">
                    <div class="col-6">Subtotal</div>
                    <div class="col-6 text-center">{{format_money($subTotal)}}</div>
                </div>
                <div class="row">
                    <div class="col-6">excl. 19% VAT.</div>
                    <div class="col-6 text-center">{{format_money($vat)}}</div>
                </div>
                <div class="row">
                    <div class="col-6">Grand total</div>
                    <div class="col-6 text-center">{{format_money($totalAmount)}}</div>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="footer1">
                We will collect the specified claim amount from your account by SEPA direct debit on the due date {{formatDate($data->contract->Contact_end_date)}}.<br>
                If you are not the owner of the above account, please inform the account owner.
            </div>
            <div class="footer2">
               <div class="d-flex">
                   <div class="bank-details mr-4">
                       <p>IBAN: <span class="font-weight-bolder">{{$bankdetails->Iban ?? '---'}}</span></p>
                       <p>Kontoinhaber: <span class="font-weight-bolder">{{$bankdetails->Account_holder ?? '---'}}</span></p>
                       <p>Mandatsreferenz-Nr: <span class="font-weight-bolder"></span></p>
                    </div>
                   <div class="bank-details">
                       <p>BIC: <span class="font-weight-bolder">: {{$bankdetails->Bank_code ?? '---'}}</span></p>
                       <p></p>
                       <p>Mandatsreferenz-Nr: <span class="font-weight-bolder">DE36ZZZ00002263980</span></p>
                    </div>
               </div>
            </div>

        </div>
    </main>
    <footer>
        <div class="row footer3">
            <div class="col-3">
                <address>
                    Firma: R.F.U.reserved4you GmbH
                    Geschäftsführung: Pia Lulei und Hadi Ballout
                    Adresse: Wilmersdorfer Straße 122-123
                    10627 Berlin
                </address>
            </div>
            <div class="col-3">
                <address>
                    E-Mail: buchhaltung@reserved4you.de
                    Telefon: 030/36429961
                    Website: www.reserved4you.de
                </address>
            </div>
            <div class="col-3">
                <address>
                    Steuernummer: 37/491/50313
                    Handelsregister: HRB 208249B
                    Amtsgericht: Charlottenburg
                </address>
            </div>
            <div class="col-3">
                <address>
                    Bank: Berliner Sparkasse
                    BIC: BELADEBEXXX
                    IBAN: DE48 1005 0000 0100 8386 3
                </address>
            </div>
        </div>
    </footer>
</div>    
@endsection

@section('js')
    <script>
        // let stateCheck = setInterval(() => {
        //     if (document.readyState === 'complete') {
        //     clearInterval(stateCheck);
        //     // document ready
            
        // }
        // }, 100);
        function printInvoice() {
            setTimeout(() => {
                try {
                    document.execCommand('print', false, null);
                }
                catch(e) {
                    window.print();
                }
            }, 3000);
        }
    </script>
@endsection