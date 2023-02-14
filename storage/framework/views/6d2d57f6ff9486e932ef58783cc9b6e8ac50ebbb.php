

<?php $__env->startSection('title'); ?>
    <?php echo e($items->title); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
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
    @media  print {
        @page  { margin: 0; }
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
        width: 30%;
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
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<?php if(empty($viewtype) OR (!empty($viewtype) && $viewtype != 'webview')): ?>
	<button class="btn btn-secondary print-btn position-absolute" >Download</button>
<?php endif; ?>

<div id="pdf">
    <header>
        <div class="row" style="padding-top: 50px;">
            <div class="col-2 col-xl-2 pl-0 pr-0">
                <span class="dash-black">
                    <hr>
                </span>
            </div>
            <div class="col-3 col-xl-2 text-center">
                
                <img class="w-100 pdf-logo" style="margin-top: -5px;" src="<?php echo e(URL::to('storage/app/public/Serviceassets/images/logo.png')); ?>" alt="Reserved4you" height="40" />
                <span class="d-block logo-text">SMART MANAGEMENT. BETTER SERVICE.</span>
            </div>
            <div class="col-7 col-xl-8 pl-0 pr-0">
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
                    <?php echo e($data->contract->storename); ?><br>
                    <?php if(!empty($store->store_address)): ?>
                        <?php $address = explode(',', $store->store_address) ?>
                        <?php for($i = 0; $i < count($address); $i++): ?>
                            <?php if($i == 1): ?>
                                <?php echo e($store->zipcode ?? $data->contract->Zipcode); ?>

                            <?php endif; ?>
                            <?php echo e($address[$i]); ?><br>
                        <?php endfor; ?>
                    <?php else: ?>
                        <?php $address = explode(',', $data->contract->Address) ?>
                        <?php for($i = 0; $i < count($address); $i++): ?>
                            <?php if($i == 1): ?>
                                <?php echo e($data->contract->Zipcode); ?>

                            <?php endif; ?>
                            <?php echo e($address[$i]); ?><br>
                        <?php endfor; ?>
                    <?php endif; ?>
                </address>
            </div>
    
            <div class="mt-5 mb-3">
                <h5>
                    Sehr geehrte/r <?php echo e($data->contract->firstname ?? ''); ?> <?php echo e($data->contract->Lastname ?? ''); ?>,
                </h5>
                <?php if(empty($items->reminders)): ?>    
                    <div style="text-align: justify" class="text-justify">
                        wir bedanken uns für lhr Vertrauen und hoffen Sie sind stets mit uns zufrieden. Hiermit berechnen wir lhnen folgende Leistungen:
                    </div>
                <?php endif; ?>
            </div>
    
            <div class="invoice-table">
                
                <h3 class="section-title mt-5 mb-2">Rechnung</h3>
                
                <span class="dash-black">
                    <hr class="mt-0">
                </span> 
    
                <div class="row text-center mt-3">
                    <div class="col-md-3">
                        <span class="sub-heading">
                            Kundennummer:
                        </span>
                        <p><?php echo e($store->id ?? 'noch nicht verfügbar'); ?></p>
                    </div>
                    <div class="col-md-3">
                        <span class="sub-heading">
                            Steuernummer:
                        </span>
                        <p><?php echo e($bankdetails->taxnumber ?? '---'); ?></p>
                    </div>
                    <div class="col-md-3">
                        <span class="sub-heading">
                            Rechnungsnummer:
                        </span>
                        <p><?php echo e($items->invoice_number); ?></p>
                    </div>
                    <div class="col-md-3">
                        <span class="sub-heading">
                            Rechnungsdatum:
                        </span>
                        <p><?php echo e(Carbon\Carbon::parse($items->created_at)->format('d.m.Y')); ?></p>
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
                    <?php 
                        $i = 1;
                    ?>
                    <tbody>
                        <?php $__currentLoopData = $items->details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(!str_contains($item->price, '%')): ?>
                        <tr>
                            <td><?php echo e($i); ?></td>
                            <td>
                                <?php echo e($item->item_name); ?> <br />
                                <?php echo e(Carbon\Carbon::parse($items->start_date)->format('d.m.Y')); ?> - <?php echo e(Carbon\Carbon::parse($items->due_date)->format('d.m.Y')); ?> <br />
                                2,5% von <?php echo e(number_format($totalBooking, 2, ',', '.')); ?>€
                            </td>
                            <td>
                                <?php echo e(count($items->booking_ids)); ?>

                            </td>
                            <td class="text-center">
                                <span></span>
                                <span class="table-amount text-right">
                                    <span><?php echo e(number_format($item->price, 2, ',', '.')); ?> €</span>
                                    <span></span>
                                </span>
                                <span></span>
                            </td>
                        </tr>
                        <?php $i++; ?>
                        <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        
                    </tbody>
                </table>
                <div class="float-right invoice-total">
                    <div class="row">
                        <div class="col-7">Gesamtbetrag (Netto)</div>
                        <div class="col-5 pr-4 text-right"><?php echo e(number_format($items->sub_total, 2, ',', '.')); ?> €</div>
                    </div>
                    <div class="row">
                        <div class="col-7">Mwst 19%</div>
                        <div class="col-5 pr-4 text-right"><?php echo e(number_format($items->vat, 2,',','.')); ?> €</div>
                    </div>
                    <?php if(!empty($items->discount) || $items->discount != 0): ?>
                    <div class="row">
                        <div class="col-7">Discount</div>
                        <div class="col-5 pr-4 text-right"><?php echo e($items->discount); ?> %</div>
                    </div>
                    <?php endif; ?>
                    <div class="row">
                        <div class="col-7">Gesamtbetrag (Brutto)</div>
                        <div class="col-5 pr-4 text-right"><?php echo e(number_format($items->total, 2,',','.')); ?> €</div>
                    </div>
                    <div class="row">
                        <div class="col-7">Credited Amount</div>
                        <div class="col-5 pr-4 text-right"><?php echo e(number_format($items->final_amount, 2,',','.')); ?> €</div>
                    </div>
                </div>
    
                
                <div class="footer2">
                   <div class="d-flex">
                       <div class="bank-details mr-4">
                           <p>IBAN: <span class="font-weight-bolder"><?php echo e($bankdetails->Iban ?? '---'); ?></span></p>
                           <p>Kontoinhaber: <span class="font-weight-bolder"><?php echo e($bankdetails->Account_holder ?? '---'); ?></span></p>
                           <p>Mandatsreferenz-Nr: <span class="font-weight-bolder"><?php echo e($store->id ?? $items->invoice_number); ?></span></p>
                        </div>
                        <div class="bank-details">
                            <p>Bankleitzahl: <span class="font-weight-bolder"><?php echo e($bankdetails->Bank_code ?? '---'); ?></span></p>
                            <br />
                            <p>Gläubiger-ID: <span class="font-weight-bolder"> DE36ZZZ00002263980</span>
                        </div>
                   </div>
                </div>
    
    
                <div class="clearfix"></div>
    
    
            </div>
        </section>
        <?php $i = 0; ?>
        <?php $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>    
            <section class="booking-table <?php if($i > 0): ?> other-tables <?php else: ?> first-booking-table <?php endif; ?>">
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
                        <?php $__currentLoopData = $booking; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="table-body">
                                <td>#<?php echo e($row->appointmentDetails->order_id); ?></td>
                                <td style="text-align: center;"><?php echo e(\Carbon\Carbon::parse($row->updated_at)->format('d M, Y | H:i')); ?></td>
                                <td style="text-align: center;"><?php echo e(@$row->serviceDetails->service_name == '' ? '-' : @$row->serviceDetails->service_name); ?></td>
                                <td style="text-align: right;"><?php echo e(number_format($row->price, 2,',','.')); ?> €</td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </section>
            <?php $i++; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('ServiceProvider.pdf.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/ServiceProvider/pdf/payout.blade.php ENDPATH**/ ?>