<?php $__env->startSection('service_title'); ?>
    Wallet
<?php $__env->stopSection(); ?>
<?php $__env->startSection('service_css'); ?>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
	<style>
	.nice-select.select.selectweek,.nice-select.select.selectmonth{background:#F9F9FB;}
	 .daterangepicker td.active, .daterangepicker td.active:hover{background-color:#101928;color:#FABA5F !important;font-weight:800;}
     .wallet-row .dashboard-box p {max-width: 155px;}
	</style>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('service_content'); ?>
<?php echo e(setlocale(LC_MONETARY,"de_DE")); ?>

    <div class="main-content">

        <div class="withdraw-now">
            <h2 class="page-title">Finanzen</h2>
            <div class="withdraw">
                <div class="available-bal">
                    <p>Verfügbare Summe</p>
                    <h6><?php echo e(number_format($availableBalance,2,',','.')); ?>€</h6>
                </div>
                

            </div>

        </div>
     <div class="wallet">
        <div class="dashboard-row wallet-row">

            <div class="dashboard-box  light-pink-box">
                        <span>
                            <img src="<?php echo e(URL::to('storage/app/public/Serviceassets/images/icon/euro.svg')); ?>" alt="">
                        </span>
                <p>Heutige Einnahmen</p>
                <h5><?php echo e(number_format($todayEarning,2, ',','.')); ?>€</h5>

            </div>


            <div class="dashboard-box light-blue-box">
                        <span>
                            <img src="<?php echo e(URL::to('storage/app/public/Serviceassets/images/icon/euro-money.svg')); ?>"
                                 alt="">
                        </span>
                <p>
                    Gesamt <br />
                    (vor Ort + Online)
                </p>
                <h5><?php echo e(number_format($netEarning,2,',','.')); ?>€</h5>

            </div>


            <div class="dashboard-box light-green-box">
                        <span>
                            <img src="<?php echo e(URL::to('storage/app/public/Serviceassets/images/icon/get-money.svg')); ?>" alt="">
                        </span>
                <p>Verfügbar <br />(Onlinezahlungen)</p>
                <h5><?php echo e(number_format($availableBalance,2,',','.')); ?>€</h5>

            </div>


            <div class="dashboard-box light-purple-box">
                        <span>
                            <img src="<?php echo e(URL::to('storage/app/public/Serviceassets/images/icon/withdrawal.svg')); ?>"
                                 alt="">
                        </span>
                <p>Auszahlung <br />(Onlinezahlungen)</p>
                <h5><?php echo e(number_format($withdrwalBalance,2,',','.')); ?>€</h5>

            </div>


            <div class="dashboard-box light-orange-box">
                        <span>
                            <img src="<?php echo e(URL::to('storage/app/public/Serviceassets/images/icon/refund.svg')); ?>" alt="">
                        </span>
                <p>Rückerstattung</p>
                <h5><?php echo e(number_format($refundableBalance,2,',','.')); ?>€</h5>

            </div>
        </div>
    </div>
		  <div class="transaction justify-content-end  mt-3">
				<ul class="nav nav-pills period-pills transac-tab" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link period-tab <?php echo e(($period == 'today')?'active':''); ?>" data-value="today" data-toggle="pill" href="#today" role="tab" aria-selected="false">heute</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link period-tab <?php echo e(($period == 'month' or $period == '')?'active':''); ?>" data-value="month" data-toggle="pill" href="#month" role="tab" aria-selected="false">diesen Monat</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link period-tab <?php echo e(($period == 'year')?'active':''); ?>" data-value="year" data-toggle="pill" href="#year" role="tab" aria-selected="false">Jahr</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link <?php echo e(($period == 'custom')?'active':''); ?>" id="daterange" data-value="custom" data-toggle="pill" href="#custom" role="tab" aria-selected="true">Benutzerdefiniert</a>
                    </li>
                </ul>
			</div>
			<div class="d-flex align-items-center justify-content-end">
				 <?php echo e(Form::open(array('url'=>"dienstleister/finanzen",'method'=>'get','name'=>'change_month','id'=>'change_month'))); ?>

					<?php echo e(Form::hidden('period', null ,array('class'=>'selected_period'))); ?>

					<?php echo e(Form::hidden('start_date', null ,array('class'=>'startdate'))); ?>

					<?php echo e(Form::hidden('end_date', null ,array('class'=>'enddate'))); ?>

                <?php echo e(Form::close()); ?>

			</div>
        <div class="transition-title">


            <div class="transaction">
                <ul class="nav nav-pills area-pills business-pills transac-tab" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="pills-transaction-tab" data-toggle="pill" href="#transaction"
                           role="tab" aria-controls="pills-transaction" aria-selected="true">Transaktionen</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="pills-refunds-tab" data-toggle="pill" href="#refund" role="tab"
                           aria-controls="pills-refund" aria-selected="false">Rückerstattungen </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="pills-withdraw-tab" data-toggle="pill" href="#withdraw" role="tab"
                           aria-controls="pills-withdraw" aria-selected="false">Auszahlungen</a>
                    </li>
                </ul>

            </div>
        </div>
        <div class="tab-content owl-buttons" id="pills-tabContent">
            <div class="tab-pane fade active show" id="transaction" role="tabpanel"
                 aria-labelledby="pills-transaction-tab">
                <div class="transaction-heading">
                    <p>
                        <span> <?php echo e(number_format(count($transaction),0)); ?> </span> Transaktionen 
                    </p>
                </div>
                <div class="table-responsive2">
                    <table id="example" class="table table-striped table-bordered  nowrap customers-table"
                        style="width:100%">
                        <thead>
                        <tr>
                            <th class="cous-name">Kunde</th>
							<th>Buchungs-ID </th>
                            <th>Transaktions-ID </th>
                            <th class="cous-name">Transaktionsdatum</th>
                            <th>Status</th>
                            <th>Betrag </th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $__currentLoopData = $transaction; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <div class="tabel-profile">
                                    <span>
                                        <?php if(file_exists(storage_path('app/public/user/'.\BaseFunction::getUserProfile($row['email']))) && \BaseFunction::getUserProfile($row['email']) != ''): ?>
                                            <img
                                                src="<?php echo e(URL::to('storage/app/public/user/'.\BaseFunction::getUserProfile($row['email']))); ?>"
                                                alt="user">
                                        <?php else: ?>
                                            <img
                                                src="https://via.placeholder.com/1080x1080/00000/FABA5F?text=<?php echo e(strtoupper(substr($row['first_name'], 0, 1))); ?><?php echo e(strtoupper(substr($row['last_name'], 0, 1))); ?>"
                                                alt="user">
                                        <?php endif; ?>
                                    </span>
                                        <h6><?php echo e($row['first_name']); ?> <?php echo e($row['last_name']); ?></h6>
                                    </div>
                                </td>
                                <td data-order="<?php echo e($row['order_id']); ?>">#<?php echo e($row['order_id']); ?></td>
								<td>#<?php echo e($row['payment_id'] == 'Cash' ? 'vor Ort' : $row->payment_id); ?></td>
                                <td><?php echo e(\Carbon\Carbon::parse($row['created_at'])->translatedFormat('d M, Y (D) H:i')); ?></td>
                               <td class="status">
								<span class="<?php echo e($row['payment_status'] == 'succeeded' ?'completed-label2' :($row['payment_status'] == 'failed' ? 'cancel-label2':($row->status == 'cancel'?'pending-label2':'completed-label2'))); ?>"><?php echo e($row->payment_status == 'succeeded' ? 'erfolgreich' : ($row->payment_status == 'failed' ? 'fehlgeschlagen' :($row->status == 'cancel'?'rückerstattet ':'erfolgreich '))); ?></span>
							</td>
                                <td><?php echo e(number_format(str_replace(",", '', $row['total_amount']),2,',','.')); ?>€</td>
                                <td>
                                    <div class="tabel-action">
                                        <a class="more-detail-link" onclick="redirectMoreDetails(<?php echo e($row['id']); ?>, '<?php echo e(encrypt($row['appointment_id'])); ?>');" href="javascript:void(0);">Mehr Details</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="tab-pane fade  show" id="refund" role="tabpanel" aria-labelledby="pills-refunds-tab">
                <div class="transaction-heading">
                    <p>
                        <span>  <?php echo e(number_format(count($refund),0)); ?>  </span> Rückerstattung
                    </p>
                </div>

                <table id="example1" class="table table-striped table-bordered  nowrap customers-table"
                       style="width:100%">
                    <thead>
                    <tr>
                        <th class="cous-name tran-name"><p>Kunde</p></th>
                        <th>Transaktions-ID </th>
                        <th class="cous-name trans-date">Transaktionsdatum </th>
                        <th class="cous-name">Erstattungsdatum </th>
                        <th>Erstattungsbetrag</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__currentLoopData = $refund; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>
                                <div class="tabel-profile">
                                <span>
                                    <?php if(file_exists(storage_path('app/public/user/'.\BaseFunction::getUserProfile($row['email']))) && \BaseFunction::getUserProfile($row['email']) != ''): ?>
                                        <img
                                            src="<?php echo e(URL::to('storage/app/public/user/'.\BaseFunction::getUserProfile($row['email']))); ?>"
                                            alt="user">
                                    <?php else: ?>
                                        <img
                                            src="https://via.placeholder.com/1080x1080/00000/FABA5F?text=<?php echo e(strtoupper(substr($row['first_name'], 0, 1))); ?><?php echo e(strtoupper(substr($row['last_name'], 0, 1))); ?>"
                                            alt="user">
                                    <?php endif; ?>
                                </span>
                                    <h6><?php echo e($row['first_name']); ?> <?php echo e($row['last_name']); ?></h6>
                                </div>
                            </td>
                            <td>#<?php echo e($row['refund_id']); ?></td>
                            <td><?php echo e(\Carbon\Carbon::parse($row['created_at'])->translatedFormat('d M, Y (D) H:i')); ?></td>
                            <td>
                            <?php echo e(\Carbon\Carbon::parse($row['updated_at'])->translatedFormat('d M, Y (D) H:i')); ?></td>
                            <td><?php echo e(number_format($row['price'],2,',','.')); ?>€</td>
                            <td>
                                <div class="tabel-action">
                                    <a class="more-detail-link"
                                       onclick="redirectMoreDetails(<?php echo e($row['id']); ?>, '<?php echo e(encrypt($row['appointment_id'])); ?>');" href="javascript:void(0);">Mehr Details</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade  show" id="withdraw" role="tabpanel" aria-labelledby="pills-withdraw-tab">
                <div class="transaction-heading">
                    <p>
                        <span> <?php echo e(number_format(count($withdraw),0)); ?> </span> Auszahlung
                    </p>
                </div>
                <table id="example2" class="table table-striped table-bordered  nowrap customers-table"
                       style="width:100%">
                    <thead>
                    <tr>
                        <th>Auszahlung-ID</th>
                        <th class="cous-name with-date">Auszahlungsdatum </th>
                        <th>Status</th>
                        <th>Auszahlungsbetrag</th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php $__currentLoopData = $withdraw; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>
                                <?php echo e($row['transaction_id']); ?>

                            </td>

                            <td><?php echo e(\Carbon\Carbon::parse($row['created_at'])->translatedFormat('d M, Y (D) H:i')); ?></td>
                            <td class="pending"><?php echo e($row['status']); ?></td>
                            <td><?php echo e(number_format($row['amount'],2,',','.')); ?>€</td>

                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <!-- deleteProfilemodal -->
    <div class="modal fade" id="deleteProfilemodal" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="delete-profile-box">
                        <h4>Bestätigung    </h4>
                        <p>Sind Sie sicher, dass Sie dieses Bild endgültig aus dem Portfolio löschen möchten ?</p>
                    </div>
                    <dvi class="notes-btn-wrap">
                        <a href="#" class="btn btn-black-yellow">Ja, löschen!   </a>
                        <a href="#" class="btn btn-gray">Nein, zurück!</a>
                    </dvi>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('service_js'); ?>
    <script src="<?php echo e(URL::to('storage/app/public/Serviceassets/js/jquery.md5.min.js')); ?>"></script>
	 
<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment-with-locales.min.js"></script>
   <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script>
        $(document).ready(function () {
            // var time = convertTo24Hour($("#starttime").val().toLowerCase());
            // slotLabelFormat =  {hour: 'numeric', minute: '2-digit', hour12: false}
			
            $('#example').DataTable({
                "language": {
                    "search": "Suche",
                    "sLengthMenu": "Zeige _MENU_ Einträge",
					"emptyTable":     "Keine Daten verfügbar.",
                    "paginate": {
                        "next":       "Nächste",
                        "previous":   "Vorherige "
                    },
                }
            });
            $('#example1').DataTable({
                "language": {
                    "search": "Suche",
					"emptyTable":     "Keine Daten verfügbar.",
                    "sLengthMenu": "Zeige _MENU_ Einträge",
                    "paginate": {
                        "next":       "Nächste",
                        "previous":   "Vorherige "
                    },
                }
            });
            $('#example2').DataTable({
                "language": {
                    "search": "Suche",
					"emptyTable":     "Keine Daten verfügbar.",
                    "sLengthMenu": "Zeige _MENU_ Einträge",
                    "paginate": {
                        "next":       "Nächste",
                        "previous":   "Vorherige "
                    },
                }
            });
          
        });

		
		$("#methodFilter").on("change",function() {
            // $(".period-pills").show();
            let value = period;
            if (value == 'custom') {
                cb(startPeriod, endPeriod)
            } else {
                updatePayment(value);
            }
        });
		
        $(".period-tab").on("click",function() {
            let value = $(this).data('value');
            if (value != 'custom') {
                period = value;
                updatePayment(value);
            }
        });
		var maxDate = "<?php echo e(date('d-m-Y')); ?>";
		moment.locale('de');
		<?php if($startdate && $enddate): ?>
			var startdateOld = "<?php echo e(date('d-m-Y', strtotime($startdate))); ?>";
			var enddateOld = "<?php echo e(date('d-m-Y', strtotime($enddate))); ?>";
        $('#daterange').daterangepicker({
			startDate:startdateOld,
			language: "de",
			endDate:enddateOld,
			maxDate:maxDate,
            locale: {
                format: 'DD-MM-YYYY',
				cancelLabel: 'schließen',
				applyLabel: 'auswählen'
            },
            "opens": 'left',
            "alwaysShowCalendars": true,
			'applyButtonClasses':'btn btn-black-yellow',
        }, cb)
        .on('click', function(e) {
            e.preventDefault();
        });
		<?php else: ?>
			$('#daterange').daterangepicker({
			maxDate:maxDate,
			language: "de",
			 locale: {
                format: 'DD-MM-YYYY',
				cancelLabel: 'schließen',
				applyLabel: 'auswählen'
            },
            "opens": 'left',
            "alwaysShowCalendars": true,
			'applyButtonClasses':'btn btn-black-yellow',
			}, cb)
			.on('click', function(e) {
				e.preventDefault();
			});
		<?php endif; ?>

        function cb(start, end) {
            period = 'custom';
			startPeriod = start.format('YYYY-MM-DD'); 
            endPeriod = end.format('YYYY-MM-DD');
			 $('.selected_period').val(period);
			 $('.startdate').val(startPeriod);
			 $('.enddate').val(endPeriod);
			 $('#change_month').submit();
        }
		
		function updatePayment(value) {
            $('.selected_period').val(value);
			 $('#change_month').submit();
        }
		
		function redirectMoreDetails(id, ap_id){
			localStorage.setItem('walletapid', id);
			window.location.href = "<?php echo e(url('dienstleister/kunden-details')); ?>/"+ap_id;
		}
       
	   
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.serviceProvider', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\projects\laravel\reserved4you_dev\resources\views/ServiceProvider/Wallet/index.blade.php ENDPATH**/ ?>