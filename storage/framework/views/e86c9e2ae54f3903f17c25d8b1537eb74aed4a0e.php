<?php $__env->startSection('service_title'); ?>
    Dashboard
<?php $__env->stopSection(); ?>
<?php $__env->startSection('service_css'); ?>
    <?php
    use App\Models\StoreProfile;
    $getStore = StoreProfile::where('user_id', Auth::user()->id)->get();
    ?>
    <style type="text/css">
        .completed-label{
               border-color: #56C156 !important;
            color: #56C156;
            background: #fff;
        }
          .new-appointment-label{
               border-color: #5bc9ff !important;
            color: #5bc9ff;
            background: #fff;
        }
         .cancel-label{
               border-color: #d42e2e !important;
            color: #d42e2e;
            background: #fff;
        }
    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('service_content'); ?>

    <div class="main-content">
        <h2 class="page-title">Dashboard</h2>
        <div class="dashboard-main-wrap">
            <div class="dashboard-left-width">
                <select class="select store_category">
                    <option value=""
                            data-value="">Alle Stores
                    </option>
                    <?php $__currentLoopData = $getStore; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(session('store_id') == $row->id): ?>

                            <option value="<?php echo e($row->id); ?>"
                                    data-value="<?php echo e($row->store_address); ?>" selected><?php echo e($row->store_name); ?></option>
                        <?php else: ?>
                            <option value="<?php echo e($row->id); ?>"
                                    data-value="<?php echo e($row->store_address); ?>"><?php echo e($row->store_name); ?></option>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <p class="str_address"><?php echo e(session('address')); ?></p>
                <div class="row dashboard-row">
                    <div class="col-lg-6">
                        <div class="dashboard-box yellow-box">
                        <span>
                            <img src="<?php echo e(URL::to('storage/app/public/Serviceassets/images/icon/calendar.svg')); ?>" alt="">
                        </span>
                            <h5><?php echo e(number_format($activeAppointment)); ?></h5>
                            <p>Aktive Buchungen </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="dashboard-box orange-box">
                        <span>
                            <img
                                src="<?php echo e(URL::to('storage/app/public/Serviceassets/images/icon/pending-appointments.svg')); ?>"
                                alt="">
                        </span>
                            <h5><?php echo e(number_format($pendingAppointment)); ?></h5>
                            <p>Bevorstehende Buchungen </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="dashboard-box green-box">
                        <span>
                            <img
                                src="<?php echo e(URL::to('storage/app/public/Serviceassets/images/icon/completed-appointments.svg')); ?>"
                                alt="">
                        </span>
                            <h5><?php echo e(number_format($completedAppointment)); ?></h5>
                            <p>Erledigte Buchungen </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="dashboard-box red-box">
                        <span>
                            <img
                                src="<?php echo e(URL::to('storage/app/public/Serviceassets/images/icon/cancelled-appointments.svg')); ?>"
                                alt="">
                        </span>
                            <h5><?php echo e(number_format($canceledAppointment)); ?></h5>
                            <p>Stornierte Buchungen </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="dashboard-box pink-box">
                        <span>
                            <img src="<?php echo e(URL::to('storage/app/public/Serviceassets/images/icon/total-services.svg')); ?>"
                                 alt="">
                        </span>
                            <h5><?php echo e(number_format($totalService)); ?></h5>
                            <p>Services</p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="dashboard-box purple-box">
                        <span>
                            <img src="<?php echo e(URL::to('storage/app/public/Serviceassets/images/icon/total-employees.svg')); ?>"
                                 alt="">
                        </span>
                            <h5><?php echo e(number_format(count($totalEmp))); ?></h5>
                            <p>Mitarbeiter </p>
                        </div>
                    </div>
                  
                    <div class="col-lg-6">
                        <div class="dashboard-box blue-box">
                        <span>
                            <img src="<?php echo e(URL::to('storage/app/public/Serviceassets/images/icon/customer-reviews.svg')); ?>"
                                 alt="">
                        </span>
                            <h5><?php echo e(number_format($totalReview)); ?></h5>
                            <p>Bewertungen </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="dashboard-box dblue-box">
                        <span>
                            <img src="<?php echo e(URL::to('storage/app/public/Serviceassets/images/icon/total-customers.svg')); ?>"
                                 alt="">
                        </span>
                            <h5><?php echo e(number_format($totalCustomer)); ?></h5>
                            <p>Kunden</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="dashboard-center-width">
                <div class="dashboard-center-header">
                    <h5>Heutige Termine </h5>
                    <div>
                        <label>Status</label>
                        <select class="select getAppo">
                            <option value="all">Alle</option>
                            <option value="booked">Neu</option>
                            <option value="running">Aktiv</option>
                            <option value="reschedule">Verschoben </option>
                            <option value="completed">Erledigt</option>
                            <option value="cancel">Storniert</option>
                        </select>
                    </div>
                </div>
                <ul class="timeline-ul">
                    <?php $__currentLoopData = $todayAppointment; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item =>$row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li rel="<?php echo e(\Carbon\Carbon::parse($item)->format('H:i')); ?>" id="<?php echo e(\Carbon\Carbon::parse($item)->format('Hi')); ?>">
                        <i><?php echo e(\Carbon\Carbon::parse($item)->format('H:i')); ?></i>
                        <?php $__currentLoopData = $row; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="timeline-li-wrap" rel="<?php echo e($value->status); ?>">
                            <div class="timeline-profile-wrap">
                                <div class="timeline-profile-top-wrap">
                                    <div class="timeline-profile">
                                        <?php if(file_exists(storage_path('app/public/user/'.@$value->userDetails->profile_pic)) && @$value->userDetails->profile_pic != ''): ?>
                                            <img src="<?php echo e(URL::to('storage/app/public/user/'.@$value->userDetails->profile_pic)); ?>"
                                                 class="rounded avatar-sm"
                                                 alt="user">
                                        <?php else: ?>
                                            <img class="rounded avatar-sm"
                                                 src="https://via.placeholder.com/150x150/00000/FABA5F?text=<?php echo e(strtoupper(substr(@$value->first_name, 0, 1))); ?><?php echo e(strtoupper(substr(@$value->last_name, 0, 1))); ?>"
                                                 alt="user">
                                        <?php endif; ?>
                                    </div>
                                    <div class="timeline-profile-info">
                                        <?php if($value->status == 'booked' || $value->status == 'pending'): ?>
                                            <span class="new-appointment-label"> <?php echo e($value->status == 'booked' ? 'Neu' : 'Steht aus'); ?></span>
                                        <?php elseif($value->status == 'running' || $value->status == 'reschedule'): ?>
                                            <span class="running-label"> <?php echo e($value->status == 'running' ? 'Aktiv' : 'Verschoben'); ?></span>
                                        <?php elseif($value->status == 'completed'): ?>
                                            <span class="completed-label"> Erledigt </span>
                                        <?php elseif($value->status == 'cancel'): ?>
                                            <span class="cancel-label"> Storniert </span>
                                        <?php endif; ?>

                                        <h6><?php echo e(@$value->first_name); ?> <?php echo e(@$value->last_name); ?></h6>
                                    </div>
                                    <div class="timeline-profile-price">
                                        <h6> <span><?php echo e(number_format($value->price,2,',','.')); ?>€</span></h6>
										 <?php if(!empty($value->payment_method)): ?>
											
											<p><?php echo e(ucfirst($value->payment_method == 'cash' ? 'vor Ort' : ((strtolower($value->payment_method) == 'stripe' && !empty($value->card_type))?$value->card_type:$value->payment_method))); ?></p>
										<?php endif; ?>
                                    </div>
                                </div>
                                <div class="timeline-profile-bottom-wrap">
                                    <div>
                                        <p>Buchungs-ID: <span> #<?php echo e($value->order_id); ?></span></p>
                                        <p>Uhrzeit : <span> <?php echo e(\Carbon\Carbon::parse($value->appo_time)->format('H:i')); ?> - <?php echo e(\Carbon\Carbon::parse($value->app_end_time)->format('H:i')); ?></span></p>
                                    </div>

                                </div>
                            </div>
                            <div class="accordion" id="accordionExample">
                                <div class="timeline-card">
                                    <a class="timeline-link" type="button" data-toggle="collapse"
                                       data-target="#collapse<?php echo e($value->id); ?>" aria-expanded="false" aria-controls="collapse<?php echo e($value->id); ?>">
                                       Gebuchter Service 
                                        <span class="arrow"><img
                                                src="<?php echo e(URL::to('storage/app/public/Serviceassets/images/icon/down-arrow.svg')); ?>"
                                                alt=""></span>
                                    </a>
                                    <div id="collapse<?php echo e($value->id); ?>" class="collapse" aria-labelledby="heading<?php echo e($value->id); ?>"
                                         data-parent="#accordionExample">
                                        <div class="timeline-body ">
                                            <div class="timeline-heading-label">
                                            <span>

                                                <?php echo file_get_contents(URL::to('storage/app/public/category/'.@$value->categoryDetails->image)) ?>
                                            </span>
                                                <h6><?php echo e($value->categoryDetails->name); ?></h6>
												<a class="text-link btn-sm ml-auto" href="<?php echo e(url('dienstleister/buchung#'.$value->id)); ?>">Termin anzeigen</a>

                                            </div>
                                            <div class="timeline-profile-label">
                                                <p>Mitarbeiter</p>
                                                <div>
                                                    <h6><?php echo e($value->store_emp_id == '' ? 'Any Employee' : @$value->employeeDetails->emp_name); ?></h6>
													<?php
													$empnameArr = explode(" ", @$value->employeeDetails->emp_name);
													$empname = "";
													if(count($empnameArr) > 1){
														$empname = strtoupper(substr($empnameArr[0], 0, 1)).strtoupper(substr($empnameArr[1], 0, 1));
													}else{
														$empname = strtoupper(substr(@$value->employeeDetails->emp_name, 0, 2));
													}
												
												?>
                                                    <span>
                                                          <?php if(file_exists(storage_path('app/public/store/employee/'.@$value->employeeDetails->image)) && @$value->employeeDetails->image != ''): ?>
                                                            <img src="<?php echo e(URL::to('storage/app/public/store/employee/'.@$value->employeeDetails->image)); ?>"
                                                                 alt=""
                                                            >
                                                        <?php else: ?>
                                                            <img src="https://via.placeholder.com/150x150/00000/FABA5F?text=<?php echo e($empname); ?>" alt="employee">
                                                        <?php endif; ?>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="timeline-body-info">
                                                <p><?php echo e($value->subCategoryDetails->name); ?> - <?php echo e(@$value->service_name); ?> - <?php echo e(@$value->variantData->description); ?></p>
                                            </div>
                                            <div class="timeline-footer-price">
                                                <p><?php echo e(@$value->variantData->duration_of_service); ?> <?php echo e(__('Min')); ?></p>
                                                <h6><?php echo e(number_format($value->price,2,',','.')); ?>€</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
            <div class="dashboard-right-width">
                <div class="index-earning-box">
                    <span><img src="<?php echo e(URL::to('storage/app/public/Serviceassets/images/total-earning.svg')); ?>"
                               alt=""></span>
                    <h6>Heutige Einnahmen  : <strong> <?php echo e(number_format($todayEarning, 2, ',', '.')); ?>€</strong></h6>
                </div>
                <div class="today-employee">
                <h6 class="index-employee">Mitarbeiter  <span> (<?php echo e(count($totalEmp)); ?>)</span></h6>
                <ul class="employee-listing">
                    <?php $__empty_1 = true; $__currentLoopData = $totalEmp; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php if(@$row->time->is_off == 'off'): ?>
							<?php
								$empnameArr = explode(" ", $row->emp_name);
								$empname = "";
								if(count($empnameArr) > 1){
									$empname = strtoupper(substr($empnameArr[0], 0, 1)).strtoupper(substr($empnameArr[1], 0, 1));
								}else{
									$empname = strtoupper(substr( $row->emp_name, 0, 2));
								}
							
							?>
                            <li>
                                <span>
                                    <?php if(file_exists(storage_path('app/public/store/employee/'.$row->image)) && $row->image != ''): ?>
                                        <img src="<?php echo e(URL::to('storage/app/public/store/employee/'.$row->image)); ?>"
                                             alt=""
                                        >
                                    <?php else: ?>
                                        <img src="https://via.placeholder.com/150x150/00000/FABA5F?text=<?php echo e($empname); ?>" alt="employee">
                                    <?php endif; ?>
                                </span>
                                <div>
                                    <h6><?php echo e($row->emp_name); ?></h6>
                                    <?php if(@$row->time->is_off == 'off'): ?>
                                        <p>Arbeitszeit<br>
                                            <span> (<?php echo e(\Carbon\Carbon::parse(@$row->time->start_time)->translatedFormat('H:i')); ?> - <?php echo e(\Carbon\Carbon::parse(@$row->time->end_time)->translatedFormat('H:i')); ?>) </span></p>
                                    <?php else: ?>
                                        <p>Today <br><span class="onleave"> On Leave </span></p>
                                    <?php endif; ?>
                                </div>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="text-center">No Employee Found.</div>
                    <?php endif; ?>

                </ul>
                </div>
            </div>
        </div>
    </div>
<?php $current_time = \Carbon\Carbon::now()->timezone('Europe/Berlin')->format('H:i'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('service_js'); ?>
    <script>
		/* if(localStorage.getItem('dashStatus')){
			getStatusAppointment(localStorage.getItem('dashStatus'));
			$('.getAppo').val(localStorage.getItem('dashStatus'));
		} */
		var currentTime = "<?php echo e($current_time); ?>";
		var screenWidth = window.screen.width;
		var listItems = $(".timeline-ul li");
		
		listItems.each(function(idx, li) {
			var litime =li.attributes.rel.nodeValue;
			
			if(litime >=  currentTime || (idx === listItems.length - 1)){
				console.log(litime+'##'+currentTime);
				if(screenWidth > 1400){
					
					var len = $("div[rel='running']").length;
					if(len > 0){
						var x = $("div[rel='running']").offset().top;
					}else{
						var x = $("li[rel='"+litime+"']").offset().top;
					}
					
					 $('.timeline-ul').animate({
						scrollTop: x - $(".timeline-ul").offset().top
					}, 'fast');
				}else{
					 var len = $("div[rel='running']").length;
					if(len > 0){
						var y = $("div[rel='running']").offset().top;
					}else{
						var y = $("li[rel='"+litime+"']").offset().top;
					}
				
					$('html,body').animate({
						scrollTop: y
					}, 'fast');
				}
				return false;
			}
			
		});
        $(document).on('change','.getAppo',function (){
            var value = $(this).val();
			localStorage.setItem('dashStatus', value);
			getStatusAppointment(value);
        })

		function getStatusAppointment(value){
			 $.ajax({
                type: 'POST',
                url: baseurl + '/dashboard-appointment',
                data: {
                    _token: token,
                    shorting: value,
                },
                // beforesend: $('#loading').css('display', 'block'),
                success: function (response) {

                    $(".timeline-ul").html(response);
                    // $('#loading').css('display', 'none');
                },
                error: function (e) {

                }
            });
		}
		
        setInterval(function() {
                  window.location.reload();
                }, 60000);  

    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.serviceProvider', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\projects\laravel\reserved4you_dev\resources\views/ServiceProvider/dashboard.blade.php ENDPATH**/ ?>