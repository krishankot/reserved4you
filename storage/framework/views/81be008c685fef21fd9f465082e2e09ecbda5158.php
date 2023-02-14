<?php $__env->startSection('service_title'); ?>
    Appointment List
<?php $__env->stopSection(); ?>
<?php $__env->startSection('service_css'); ?>
    <style>
		#render_Appo_length, #render_Appo_filter{display:none;}
		 div#render_Appo_wrapper .row:nth-last-child(1) .col-md-5{display:none;}
		 div#render_Appo_wrapper .row:nth-last-child(1) .col-md-7{
  -webkit-box-flex: 0;
  -ms-flex: 0 0 100%;
  flex: 0 0 100%;
  max-width: 100%;
}
		.swal-footer{text-align:center;}
        .modals-profile-wrap {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            margin-bottom: 20px;
        }

        .modals-modals-profile {
            width: 70px;
            height: 70px;
            border-radius: 100%;
            overflow: hidden;
            margin-right: 15px;
        }

        .modals-modals-info h6 {
            font-size: 15px;
            color: #101928;
            font-weight: 500;
            margin-bottom: 5px;
        }

        .modals-modals-info h5 {
            font-size: 20px;
            color: #DB8A8A;
            font-weight: 600;
        }

        .modal-profile-address {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            background: #FFF3F3;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .modal-profile-address span svg path {
            fill: #101928;
        }

        .modal-profile-address span {
            margin-right: 13px;
            margin-top: 2px;
        }

        .modal-profile-address p {
            font-size: 17px;
            font-weight: 500;
        }

        .modal-items-pricing {
            background: #FFF3F3;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            text-align: center;
        }

        .btn-modal-cancel {
            margin: 0 0 20px 0;
            font-weight: 700;
            height: 50px;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
        }

        .cancelation-policy {
            text-align: center;
            display: block;
            font-size: 16px;
            color: #101928;
            font-weight: 500;
            width: -webkit-max-content;
            width: -moz-max-content;
            width: max-content;
            margin: 0 auto 10px;
            border-bottom: 1px solid #101928;
        }

        .modal-items-pricing h4 {
            font-size: 18px;
            color: #101928;
            font-weight: 700;
        }

        .modal-items-pricing h4 i {
            color: #DB8A8A;
            font-style: normal;
            font-weight: 600;
        }

        .modal-items-pricing h6 {
            color: #101928;
            font-size: 16px;
            font-weight: 600;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
        }

        .modal-items-pricing h6 i {
            color: rgb(16 25 40 / 50%);
        }

        .modal-items-pricing h6 span {
            height: 14px;
            display: block;
            margin: 0 5px;
        }

        .modal-body.modal-body22 {
            padding: 1.6rem;
        }

        .list-item-img img {
            width: 100%;
            height: 100%;
            -o-object-fit: cover;
            object-fit: cover;
        }


        .payment-box-link {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            background: #E8E8EC;
            border-radius: 10px;
            padding: 8px 16px;
            margin-bottom: 15px;
        }

        span.payment-box-icon {
            width: 35px;
            height: 35px;
            border-radius: 100%;
            background: #DB8A8A;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
        }

        span.payment-box-icon svg {
            width: 22px;
        }

        span.payment-box-icon svg path {
            fill: #fff;
        }

        .payment-box-link h6 {
            font-size: 18px;
            color: #101928;
            font-weight: 700;
            margin: 0 0 0 18px;
        }

        .payment-box-profile-wrap {
            display: -webkit-box !important;
            display: -ms-flexbox !important;
            display: flex !important;
            border-bottom: 1px solid #E8E8EC;
            padding-bottom: 10px;
            margin-bottom: 16px;
        }

        .payment-box-profile-wrap span {
            width: 35px;
            height: 35px;
            border-radius: 100%;
            overflow: hidden;
            margin-right: 12px;
            padding: 0;
        }

        .payment-box-profile-wrap span img {
            width: 100%;
            height: 100%;
            -o-object-fit: cover;
            object-fit: cover;
        }

        .payment-box-profile-wrap p {
            font-size: 12px;
            color: #101928;
            margin-bottom: 0;
            font-weight: 600;
        }

        .payment-box-profile-wrap h6 {
            font-size: 16px;
            color: #DB8A8A;
            font-weight: 700;
        }

        .payment-item-infos h5 {
            font-size: 16px;
            color: #101928;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .payment-item-infos h6 {
            font-size: 16px;
            color: #101928;
            font-weight: 600;
            opacity: 0.50;
            margin-bottom: 6px;
        }

        .payment-item-infos-wrap {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            -webkit-box-pack: justify;
            -ms-flex-pack: justify;
            justify-content: space-between;
        }

        .payment-item-infos-wrap span {
            font-size: 14px;
            color: #101928;
            opacity: 0.40;
        }

        .payment-item-infos-wrap p {
            font-size: 16px;
            font-weight: 600;
            color: #101928;
        }

        .payment-item-infos {
            padding-bottom: 10px;
            margin-bottom: 16px;
            border-bottom: 1px solid #E8E8EC;
        }

        .payment-box-link[aria-expanded="true"] span.downn-arroww {
            -webkit-transform: rotate(180deg);
            -ms-transform: rotate(180deg);
            transform: rotate(180deg);
        }

		.swal-button--danger,.swal-button--danger:hover{background:#101928 !important;}
		.appointment-profile-info a.disabled{pointer-events:none;text-decoration:none;}
    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('service_content'); ?>
    <div class="main-content">
        <h2 class="page-title">Meine Buchungen</h2>

        <div class="appointment-header">
            <div class="appointment-search">
                <input type="text" placeholder="Suchen nach Buchungs-ID, Mitarbeiter, Kunde, Service, Status, ..."
                       id="myInput">
                <a href="#"><img src="<?php echo e(URL::to('storage/app/public/Serviceassets/images/icon/search.svg')); ?>"
                                 alt=""></a>
            </div>
            <a href="<?php echo e(URL::to('dienstleister/buchung-erstellen')); ?>" class="appointment-btn btn-yellow">Neuen Termin hinzufügen</a>
            
            
            
            
            
            <div class="sortby">
                <label>Sortieren nach</label>
                <select class="select shorting">
                    <option value="">Alle</option>
                    <option value="new">Neu</option>
                    <option value="running">Aktiv</option>
                    <option value="reschedule">Verschoben</option>
                    <option value="completed">Erledigt</option>
                    <option value="cancel">Storniert</option>
                </select>
            </div>
        </div>
		
        <table id="render_Appo" class="w-100">
					   <thead>
					   <tr>
					   <th style="display:none;"></th>
					   </tr>
					   </thead>
			<tbody>
            <?php $__empty_1 = true; $__currentLoopData = $appointment; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
				<tr>
				<td>
                 <div class="appointment-item completed-item" id="<?php echo e($row['id']); ?>">
                    <div class="appointment-profile-wrap">
                        <div class="appointment-profile-left">
                            <div class="appointment-profile-img">
                                <?php if(file_exists(storage_path('app/public/user/'.@$row->userDetails->profile_pic)) && @$row->userDetails->profile_pic != ''): ?>
                                    <img src="<?php echo e(URL::to('storage/app/public/user/'.@$row->userDetails->profile_pic)); ?>"
                                         class="rounded avatar-sm"
                                         alt="user">
									<?php $image = URL::to('storage/app/public/user/'.@$row->userDetails->profile_pic); ?>
                                <?php else: ?>
                                    <img
                                        src="https://via.placeholder.com/1080x1080/00000/FABA5F?text=<?php echo e(strtoupper(substr($row['first_name'], 0, 1))); ?><?php echo e(strtoupper(substr($row['last_name'], 0, 1))); ?>"
                                        alt="user">
										<?php $image = 'https://via.placeholder.com/1080x1080/00000/FABA5F?text='.strtoupper(substr($row['first_name'], 0, 1)).strtoupper(substr($row['last_name'], 0, 1)); ?>
                                <?php endif; ?>
                            </div>
                            <div class="appointment-profile-info">
                                <h5>
									<?php echo e(@$row->first_name); ?> <?php echo e(@$row->last_name); ?>

									
									<?php if(!\BaseFunction::checkCustomerExists(@$row->email, @$row['store_id'])): ?>
										<?php $requestStatus = \BaseFunction::isCustomerRequested(@$row['store_id'], @$row['user_id']); ?>
										<?php if($requestStatus == 'Requested'): ?>
											<a href="javascript:void(0);" class="text-warning disabled">Angefragt</a>
										<?php elseif($requestStatus == 'Rejected'): ?>
											<a href="javascript:void(0);" class="text-danger disabled">Abgelehnt</a>
										<?php else: ?>
											<a href="javascript:void(0);" class="text-info add_cust" data-customer="<?php echo e(@$row['user_id']); ?>" data-id="<?php echo e(@$row['store_id']); ?>">Kundenprofil anlegen ?</a>
										<?php endif; ?>
									<?php endif; ?>
								</h5>
                                <ul>
                                    <li>
                                        <p>Buchungs-ID: <span> #<?php echo e($row->order_id); ?></span></p>
                                    </li>
                                    <li>
                                        <p>Status:
                                            <?php if($row->status == 'booked' || $row->status == 'pending'): ?>
                                                <span class="new-appointment-label"> <?php echo e($row->status == 'booked' ? 'Neu' : 'Steht aus'); ?></span>
                                            <?php elseif($row->status == 'running' || $row->status == 'reschedule'): ?>
                                                <span class="running-label"> <?php echo e($row->status == 'running' ? 'Aktiv' : 'Verschoben'); ?></span>
                                            <?php elseif($row->status == 'completed'): ?>
                                                <span class="completed-label"> Erledigt </span>
                                            <?php elseif($row->status == 'cancel'): ?>
                                                <span class="cancel-label"> Storniert </span>
                                            <?php endif; ?>
                                        </p>
                                    </li>
									<?php if($row->status == 'cancel'): ?>
									 <li>
										<a style="color: #DB8A8A;text-decoration: underline;" href="javascript:void(0);" class="cancel_reason" data-image="<?php echo e($image); ?>"
										   data-booking="<?php echo e($row->order_id); ?>"
										   data-service="<?php echo e($row['service_name']); ?>"
										   data-cancelledby="<?php echo e($row['cancelled_by']); ?>"
										   data-storename="Customer"
										   data-description="<?php echo e(@$row['variantData']['description']); ?>"
										   data-reason="<?php echo e($row['cancel_reason']); ?>">
											Stornierungsgrund
										</a>
									</li>
									<?php endif; ?>
                                    <?php if(empty($row->is_reviewed)): ?>
                                        <?php if($row->status == 'completed'): ?>
											
											<?php if(!empty($row->review_requested)): ?>
												<li><a href="javascript:void(0);" class="btn btn-black btn-review-request disabled mt-0">Angefragt</a></li>
											<?php else: ?>
												<li><a href="javascript:void(0);" data-id="<?php echo e($row['id']); ?>" class="btn btn-black btn-review-request mt-0">Bewertungsanfrage senden</a></li>
											<?php endif; ?>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <li class="review-see-wrap">
                                            <p>
                                            <span><i
                                                    class="fas fa-star"></i></span> <?php echo e(@$row->is_reviewed->total_avg_rating); ?>

                                            </p>
                                            <a href="<?php echo e(url('dienstleister/betriebsprofil?t=reviews#t'.@$row->is_reviewed->id)); ?>" class="btn see-review">Bewertung anzeigen</a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </div>
							
                        </div>
                        <?php if(file_exists(storage_path('app/public/service/'.$row->image)) && $row->image != ''): ?>

                            <div
                                style="display: none"><?php echo e($imge = URL::to('storage/app/public/service/'.$row->image)); ?></div>
                        <?php else: ?>
                            <div
                                style="display: none"><?php echo e($imge = URL::to('storage/app/public/default/default-user.png')); ?></div>
                        <?php endif; ?>
                        <div class="appointment-profile-right">
                            <div class="app-payment-info-type">
                                <p>Zahlungsmethode  <i></i> <span><?php echo e(ucfirst($row->payment_method == 'cash' ? 'vor Ort' : ((strtolower($row->payment_method) == 'stripe' && !empty($row->card_type))?$row->card_type:$row->payment_method))); ?></span></p>
								<h6>Gesamtbetrag <span><?php echo e(number_format($row->price, 2, ',', '.')); ?>€</span></h6>
                            </div>
							
                            <?php if($row->status == 'booked' || $row->status == 'pending'): ?>
                                <a href="javascript:void(0)" class="btn btn-black-yellow postpond_app" data-id="<?php echo e(@$row['id']); ?>">Verschieben</a>
                                
                            <?php elseif($row->status == 'reschedule'): ?>
							
                                
                            <?php elseif($row->status == 'completed' || $row->status == 'cancel'): ?>
                                <a href="javascript:void(0);" class="btn btn-black-yellow book_agian" 
                                    data-id="<?php echo e(@$row['id']); ?>"
                                   >Erneut Buchen?</a>
                            <?php endif; ?>
							 <?php if($row->status != 'cancel'): ?>
								<a href="javascript:void(0)" class="btn btn-yellow-black ask_cancel"
                                   data-id="<?php echo e(@$row['variantData']['id']); ?>"
                                   data-order="<?php echo e($row['order_id']); ?>"
                                   data-appointment="<?php echo e($row['appointment_id']); ?>"
                                   data-image="<?php echo e($imge); ?>"
                                   data-service="<?php echo e($row['service_name']); ?>"
                                   data-description="<?php echo e(@$row['variantData']['description']); ?>"
                                >Stornieren?</a>
							<?php endif; ?>

                        </div>
                    </div>
                    <div class="appointment-cato-wrap">
                        <div class="appointment-cato-item">
                            <span><?php echo file_get_contents(URL::to('storage/app/public/category/' . @$row->categoryDetails->image)) ?></span>
                            <h6><?php echo e($row->categoryDetails->name); ?></h6>
                        </div>
						
							<div class="appointment-cato-date">
								
								<h6><?php echo e(\Carbon\Carbon::parse($row->appo_date)->translatedFormat('d F, Y')); ?>

									(<?php echo e(\Carbon\Carbon::parse($row->appo_date)->translatedFormat('D')); ?>)</h6>
								<span><?php echo e(\Carbon\Carbon::parse($row->appo_time)->translatedFormat('H:i')); ?> </span>
							</div>
						
                    </div>
                    <div class="appointment-info-profile">
                    <span>
                         <?php if(file_exists(storage_path('app/public/store/employee/'.@$row->employeeDetails->image)) && @$row->employeeDetails->image != ''): ?>
                            <img src="<?php echo e(URL::to('storage/app/public/store/employee/'.@$row->employeeDetails->image)); ?>"
                                 alt=""
                            >
                        <?php elseif($row->store_emp_id): ?>
							<?php
								$empname = "";
								if(!empty($row->employeeDetails->emp_name)){
									$empnameArr = explode(" ", $row->employeeDetails->emp_name);
									
									if(count($empnameArr) > 1){
										$empname = strtoupper(substr($empnameArr[0], 0, 1)).strtoupper(substr($empnameArr[1], 0, 1));
									}else{
										$empname = strtoupper(substr( $row->employeeDetails->emp_name, 0, 2));
									}
								}
							?>
							 <img src="https://via.placeholder.com/150x150/00000/FABA5F?text=<?php echo e($empname); ?>" alt="employee">
						<?php else: ?>
                            <img src="<?php echo e(URL::to('storage/app/public/default/default-user.png')); ?>"
                                 alt=""
                            >
                        <?php endif; ?>
                    </span>
                        <div>
                            <p>Mitarbeiter</p>
                            <h6><?php echo e($row->store_emp_id == '' ? 'Any Employee' : @$row->employeeDetails->emp_name); ?></h6>
                        </div>
                    </div>
                    <div class="appointment-item-price-info">
                        <h5><?php echo e($row->subCategoryDetails->name); ?> - <?php echo e(@$row->service_name); ?></h5>
                        <h6><?php echo e(@$row->variantData->description); ?> </h6>
                        <p><?php echo e(@$row->variantData->duration_of_service); ?> <?php echo e(__('Min')); ?> <strong><?php echo e(number_format($row->price, 2, ',', '.')); ?>€</strong></p>
                    </div>
                </div>
				</td>
				</tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <?php endif; ?>
			</tbody>
        </table>
    </div>

	<div class="modal fade" id="detail-polish" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
                <div class="modal-body confirmation-modal-body">
                    <div class="confirmation-modal">
                        <div class="detail-wrap-box">
                            <span class="detail-wrap-box-img simage"><img
                                    src="<?php echo e(URL::to('storage/app/public/Frontassets/images/profile/woman-salon-balayage-min.jpg')); ?>"
                                    alt=""></span>
                            <div class="detail-wrap-box-infos">
                                <h6>Buchungs-ID: <span class="b_id">#R4U49258</span></h6>
                                <h4 class="b_service_name">Ladies - Balayage & Blow Dry</h4>
                                <h5 class="b_service_descirption">Balayage</h5>
                            </div>
                        </div>
                        <div class="detail-wrap-box-info">
                            <h5 id="whom">Booking has been cancelled because of</h5>
                            <p class="b_reason">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod
                                tempor incididunt
                                ut labore et dolore magna aliqua. Ut enim ad minim veniam</p>
                            <a href="#" data-dismiss="modal">Schließen</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
	
    <div id="cancel_appointment" class="modal modal-top fade calendar-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
                <?php echo e(Form::open(array('url'=>'service-provider/cancel-appointment','method'=>'post','name'=>'cancel_appointmnet'))); ?>

                <div class="modal-body confirmation-modal-body">
                    <div class="confirmation-modal">
                        <div class="detail-wrap-box">
                            <span class="detail-wrap-box-img simages"><img
                                    src="<?php echo e(URL::to('storage/app/public/Frontassets/images/profile/woman-salon-balayage-min.jpg')); ?>"
                                    alt=""></span>
                            <div class="detail-wrap-box-infos">
                                <h6>Buchungs-ID: <span class="b_ids">#R4U49258</span></h6>
                                <h4 class="b_service_names">Ladies - Balayage & Blow Dry</h4>
                                <h5 class="b_service_descirptions">Balayage</h5>
                            </div>
                        </div>
                        <div class="detail-wrap-box-info">
                            <h5>Buchung stornieren, weil … </h5>
                            <?php echo e(Form::hidden('variant_id','',array('class'=>'variant_cancel'))); ?>

                            <?php echo e(Form::hidden('appointment_id','',array('class'=>'appointment_cancel'))); ?>

                            <textarea class="textarea-area" name="cancel_reason" required></textarea>

                            <button type="submit" class="btn btn-black btn-block btn-yes">Ja, stornieren?</button>
                            
                        </div>
                    </div>
                </div>
                <?php echo e(Form::close()); ?>

            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('service_js'); ?>

    <script>
	 var table;
	 var page = 2;
	 var locked = false;
	 var refreshId;
	  var lastpage = "<?php echo e($total_pages); ?>";
        $(document).ready(function () {
			table = $('#render_Appo').DataTable({
				"order": false,
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
			
			refreshId = setInterval(function() {
				if(page <= lastpage && locked === false){
					locked = true;
					loadResults(page);
				}
				if(page > lastpage){
					clearInterval(refreshId);
				}
			}, 100);
		});
        $('#datepicker').datepicker({
            startDate: new Date(),
            inline: true,
            format: "dd-mm-yyyy",
            todayHighlight: true,
            autoclose: true,
        }).datepicker('update', new Date());

		function loadResults(i){
			//alert(i);
			var url = "<?php echo e(url('dienstleister/buchung')); ?>";
			 $.ajax({
				type: 'GET',
				url: url + '?page='+i,
				success: function (response) {
					
					table.destroy();
					page = i+1;
					$("#render_Appo tbody").append(response);
					
					table = $('#render_Appo').DataTable({
						 "order": false,
						 "page":i,
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
					//table.page(i).draw(false);
					locked = false;
				
				},
				error: function (e) {

				}
			});
		}
		
        $(document).on('change', '.shorting', function () {
			clearInterval(refreshId);
			page =2;
            var value = $(this).val();
            $.ajax({
                type: 'POST',
                url: baseurl + '/shorting-appointment',
                data: {
                    _token: token,
                    shorting: value,
                },
                // beforesend: $('#loading').css('display', 'block'),
                success: function (response) {
					lastpage = response.total_pages;
					locked = false;
					table.destroy();
					
                    $("#render_Appo tbody").html(response.html);
					
					table = $('#render_Appo').DataTable({
						 "order": false,
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
					
					refreshId = setInterval(function() {
						if(page <= lastpage && locked === false){
							
							locked = true;
							loadResultsShorting(page, value);
						}
						if(page > lastpage){
							clearInterval(refreshId);
						}
					}, 100);
					 //table.search($(this).val()).draw();
                    // $('#loading').css('display', 'none');
                },
                error: function (e) {

                }
            });
        });
		
		function loadResultsShorting(i, value){
			//alert(i);
			
			  $.ajax({
                type: 'POST',
                url: baseurl + '/shorting-appointment?page='+i,
                data: {
                    _token: token,
                    shorting: value,
                },
                // beforesend: $('#loading').css('display', 'block'),
                success: function (response) {
					table.destroy();
					page = i+1;
                    $("#render_Appo tbody").append(response.html);
					
					table = $('#render_Appo').DataTable({
						 "order": false,
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
					locked = false;
					 //table.search($(this).val()).draw();
                    // $('#loading').css('display', 'none');
                },
                error: function (e) {

                }
            });
		}

		$(document).on("keyup", '#myInput', function () {
				table.search($(this).val()).draw();
			});
			
		 $(document).on('click', '.cancel_reason', function () {
            var booking = $(this).data('booking');
            var image = $(this).data('image');
            var service = $(this).data('service');
            var description = $(this).data('description');
            var reason = $(this).data('reason');
			var cancelled_by = $(this).data('cancelledby');
			var storename = $(this).data('storename');
			//var messagewho = (cancelled_by == 'store')?'I canceled the booking because':storename + ' canceled the booking because'
			var messagewho = 'Die Buchung wurde storniert, weil...';
			
            $('.simage img').attr('src', image);
            $('.b_id').text('#' + booking);
            $('.b_service_name').text(service);
            $('.b_service_descirption').text(description);
            $('.b_reason').text(reason);
			$('#whom').text(messagewho);

            $('#detail-polish').modal('toggle');

        });
		
        $(document).on('click', '.ask_cancel', function () {
            var id = $(this).data('id');
            var appointment_cancel = $(this).data('appointment');
            var image = $(this).data('image');
            var service = $(this).data('service');
            var description = $(this).data('description');
            var order = $(this).data('order');

            $('.variant_cancel').val(id);
            $('.b_ids').text('#' + order);
            $('.b_service_names').text(service);
            $('.b_service_descirptions').text(description);
            $('.appointment_cancel').val(appointment_cancel);
            $('.simages img').attr('src', image);
            $('#cancel_appointment').modal('toggle');
        });

        $(document).on('click', '.book_agian', function () {
            var id = $(this).data('id');

            $.ajax({
                type: 'POST',
                async: true,
                dataType: "json",
                url: baseurl + '/book-again',
                data: {
                    _token: token,
                    id: id,
                },
                beforesend: $('#loading').css('display', 'block'),
                success: function (response) {
                    var status = response.status;
                    $('#loading').css('display', 'none')
                    if (status == 'true') {
                         window.location.href = "<?php echo e(url('dienstleister/checkout-prozess')); ?>";
                        //window.open(baseurl + '/checkout-data', '_blank');
                    } else {

                    }
                },
                error: function (e) {

                }
            });
        });

		$(document).on('click', '.add_cust', function () {
			 var id = $(this).data('id');
			var customer = $(this).data('customer');
			var element = $(this);
            $.ajax({
                type: 'POST',
                async: true,
                dataType: "json",
                url: "<?php echo e(url('service-provider/add-customer-request')); ?>",
                data: {
                    _token: token,
                    id: id,
					customer: customer,
                },
                beforesend: $('#loading').css('display', 'block'),
                success: function (response) {
                    var status = response.status;
                    $('#loading').css('display', 'none');
                    if (status == 'true') {
                        /* element.addClass('disabled');
						element.addClass('text-warning');
						element.removeClass('add_cust');
						element.text('Angefragt'); */
						$('.add_cust[data-customer='+customer+']').addClass('disabled');
						$('.add_cust[data-customer='+customer+']').addClass('text-warning');
						$('.add_cust[data-customer='+customer+']').text('Angefragt');
						$('.add_cust[data-customer='+customer+']').removeClass('add_cust');
                    }
                },
                error: function (e) {

                }
            });
        });

		
		$(document).on('click', '.btn-review-request', function () {
			var id = $(this).data('id');
			var element = $(this);
            $.ajax({
                type: 'POST',
                async: true,
                dataType: "json",
                url: "<?php echo e(url('service-provider/review-request')); ?>",
                data: {
                    _token: token,
                    id: id
                },
                //beforesend: $('#loading').css('display', 'block'),
                success: function (response) {
                    var status = response.status;
                    if (status == 'true') {
                        element.addClass('disabled');
						element.text('Angefragt');
                    }
                },
                error: function (e) {

                }
            });
        });

		
		$(document).on('click', '.postpond_app', function () {
            var id = $(this).data('id');
			swal({
				title: false,
				text: "Möchten Sie eine Anfrage schicken, um den Termin zu verschieben ?",
				type: "warning",
				buttons: {
					confirm:  'Ja !',
					cancel: 'Nein !'
				},
				dangerMode: true,
				buttonsStyling: false
			}).then((value) => {
				if(value){
					$.ajax({
						type: 'POST',
						async: true,
						dataType: "json",
						url: baseurl + '/postpond-appointment',
						data: {
							_token: token,
							id: id,
						},
						beforesend: $('#loading').css('display', 'block'),
						success: function (response) {
							var status = response.status;
							$('#loading').css('display', 'none')
							if (status == 'true') {
							   window.location.href = "<?php echo e(url('dienstleister/buchung')); ?>";
							} else {

							}
						},
						error: function (e) {

						}
					});
				}
			});
        });
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.serviceProvider', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\projects\laravel\reserved4you_dev\resources\views/ServiceProvider/Appointment/index.blade.php ENDPATH**/ ?>