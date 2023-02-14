<?php $__env->startSection('service_title'); ?>
    Billing
<?php $__env->stopSection(); ?>
<?php $__env->startSection('service_css'); ?>

<link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.7.0/chosen.min.css" />
<?php $__env->stopSection(); ?>
<?php $__env->startSection('service_content'); ?>
    <div class="main-content">
        <h2 class="page-title static-page-title">Buchungen</h2>
        <div class="setting-title">
            <h3>Termin hinzufügen</h3>

        </div>
        <?php echo e(Form::open(array('url'=>'service-provider/submit-payment-booking','method'=>'post','name'=>'payment','id'=>'payment-form','class'=>'require-validation'))); ?>

        <div class="main-dic-appoinment-booking">
            <div class="person-booking-info">
                <h3 class="billing-heading">Buchungsübersicht</h3>
                <div class="appoinment-book">

                    <div class="bookingtimesummry">

                        <div class="bookingsummry">
                            <div class="profile d-flex align-items-center justify-content-lg-start">
                                <div class="profileimg">
                                    <?php if(file_exists(storage_path('app/public/store/'.$store['store_profile'])) && $store['store_profile'] != ''): ?>
                                        <img src="<?php echo e(URL::to('storage/app/public/store/'.$store['store_profile'])); ?>"
                                             alt="">

                                    <?php else: ?>
                                        <img src="<?php echo e(URL::to('storage/app/public/default/store_default.png')); ?>" alt="">
                                    <?php endif; ?>
                                </div>
                                <div class="profiledetail">
                                    <h6>Salon</h6>
                                    <p><?php echo e($store['store_name']); ?></p>
                                </div>

                            </div>
                            <div class="payment-location">
                                <span><img
                                        src="<?php echo e(URL::to('storage/app/public/Serviceassets/images/new-appoi/payment-location.svg')); ?>"></span>
                                <p><?php echo e($store['store_address']); ?></p>
                            </div>
                            <div class="paymentinformation-wrap">
                                <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="accordion pb-3" id="accordionExample-<?php echo e($row['category']['id']); ?>">
                                    <div style="display: none"><?php echo e($i = 0); ?><?php echo e($j = 1); ?></div>
                                        <div class="paymentaccordion paymentaccordion2">
                                            <a href="javascript:void(0)" class="payment-box-link" data-toggle="collapse"
                                               data-target="#collapse<?php echo e($row['category']['id']); ?>"
                                               aria-expanded="true" aria-controls="collapse<?php echo e($row['category']['id']); ?>">
                                            <span
                                                class="payment-box-icon"><?php echo file_get_contents(URL::to('storage/app/public/category/' . @$row['category']['image'])) ?></span>
                                                <h6><?php echo e($row['category']['name']); ?></h6>
                                                <span class="downn-arroww"><i class="far fa-chevron-down"></i></span>
                                            </a>
                                            <div id="collapse<?php echo e($row['category']['id']); ?>" class="collapse show"
                                                 aria-labelledby="heading<?php echo e($row['category']['id']); ?>"
                                                 data-parent="#accordionExample-<?php echo e($row['category']['id']); ?>">
                                                <div class="payment-body-box">
                                                    <div
                                                        class="payment-box-profile-wrap payment-box-profile-wrap2 emplistdata"
                                                        data-id="<?php echo e($row['category']['id']); ?>">
                                                        <?php if($row['data'][0]['employee'] != null): ?>
                                                            <span class="empname" data-id="<?php echo e($row['category']['id']); ?>">
																<?php if(\BaseFunction::getEmployeeDetails($row['data'][0]['employee'],'image')): ?>
																	<img src="<?php echo e(URL::to('storage/app/public/store/employee/'.\BaseFunction::getEmployeeDetails($row['data'][0]['employee'],'image'))); ?>" alt="">
																<?php else: ?>
																	<?php
																		$employee_name = \BaseFunction::getEmployeeDetails($row['data'][0]['employee'],'emp_name');
																		$empnameArr = explode(" ", $employee_name);
																		$empname = "";
																		if(count($empnameArr) > 1){
																			$empname = strtoupper(substr($empnameArr[0], 0, 1)).strtoupper(substr($empnameArr[1], 0, 1));
																		}else{
																			$empname = strtoupper(substr($employee_name, 0, 2));
																		}
																	?>
																	 <img src="https://via.placeholder.com/150x150/00000/FABA5F?text=<?php echo e($empname); ?>" alt="employee">
																<?php endif; ?>
																
															</span>
                                                            <div class="empname " data-id="<?php echo e($row['category']['id']); ?>">
                                                                <p>Mitarbeiter</p>
                                                                <h6><?php echo e(\BaseFunction::getEmployeeDetails($row['data'][0]['employee'],'emp_name')); ?></h6>
                                                            </div>
                                                        <?php else: ?>
                                                            <span class="empname"
                                                                  data-id="<?php echo e($row['category']['id']); ?>"><img
                                                                    src="<?php echo e(URL::to('storage/app/public/default/default-user.png')); ?>"
                                                                    alt=""></span>
                                                            <div class="empname " data-id="<?php echo e($row['category']['id']); ?>">
                                                                <p>Mitarbeiter</p>
                                                                <h6>Any Person</h6>
                                                            </div>
                                                        <?php endif; ?>
                                                        <div class="datetimeslot" data-id="<?php echo e($row['category']['id']); ?>">
                                                            <p><?php echo e(\Carbon\Carbon::parse($row['data'][0]['date'])->translatedFormat('d-m-Y')); ?></p>
                                                            <h6><?php echo e(\Carbon\Carbon::parse($row['data'][0]['time'])->format('H:i')); ?></h6>
                                                        </div>
                                                    </div>
                                                    <?php $__currentLoopData = $row['data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <div class="payment-item-infos booking-infor-wrap">
                                                            <div class="booking-infor-left">
                                                                <h5><?php echo e(@$item['service_data']['service_name']); ?></h5>
                                                                <h6><?php echo e(@$item['variant_data']['description']); ?></h6>
                                                                <span><?php echo e(@$item['variant_data']['duration_of_service']); ?> <?php echo e(__('Min')); ?></span>
                                                            </div>
                                                            <div class="booking-infor-right">
                                                                <p><?php echo e(number_format($item['price'],2)); ?>€</p>
                                                            </div>
                                                        </div>

                                                        <input type="hidden" name="category[]" class="category_id"
                                                               data-id="<?php echo e($row['category']['id']); ?>"
                                                               value="<?php echo e($row['category']['id']); ?>">
                                                        <input type="hidden" name="store[]" class="store_id"
                                                               data-id="<?php echo e($row['category']['id']); ?>"
                                                               value="<?php echo e($store['id']); ?>">
                                                        <input type="hidden" name="date[]" class="date_id"
                                                               data-id="<?php echo e($row['category']['id']); ?>"
                                                               value="<?php echo e($item['date']); ?>">
                                                        <input type="hidden" name="employee[]" class="emp_id"
                                                               data-id="<?php echo e($row['category']['id']); ?>"
                                                               value="<?php echo e($item['employee']); ?>">
                                                        <input type="hidden" name="time[]" class="timeslot"
                                                               data-id="<?php echo e($row['category']['id']); ?>"
                                                               value="<?php echo e($item['time']); ?>">
                                                        <input type="hidden" name="variant[]" class="variant"
                                                               data-id="<?php echo e($row['category']['id']); ?>"
                                                               value="<?php echo e($item['variant']); ?>">
                                                        <input type="hidden" name="service[]" class="service"
                                                               data-id="<?php echo e($row['category']['id']); ?>"
                                                               value="<?php echo e($item['service']); ?>">
                                                        <input type="hidden" name="service_data[]" class="service_data"
                                                               data-id="<?php echo e($row['category']['id']); ?>"
                                                               value="<?php echo e(@$item['service_data']['service_name']); ?>">
                                                        <input type="hidden" name="subcategory[]" class="subcategory"
                                                               data-id="<?php echo e($row['category']['id']); ?>"
                                                               value="<?php echo e(@$item['subcategory']); ?>">
                                                        <input type="hidden" name="price[]" class="price"
                                                               data-id="<?php echo e($row['category']['id']); ?>"
                                                               value="<?php echo e(@$item['price']); ?>">
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div style="display: none"><?php echo e($i++); ?><?php echo e($j++); ?></div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            <!-- Ladies-Balayage & Blow Dry end -->
                            <a href="#" class="btn totalbook">Gesamt  <p><?php echo e(number_format($totalamount,2)); ?>€</p>
                            </a>

                        </div>

                    </div>
                </div>

            </div>

            <div class="billing-details">
                <h3 class="billing-heading">Kontaktdaten</h3>
                <div class="billing-input">
                    <?php echo e(Form::select('customer_id',$customer,'',array('class'=>'billing-detail select customerData','id'=>'customer'))); ?>

                    <input type="text" name="fname" class="billing-detail fname" placeholder="Vorname" required>
                    <input type="text" name="lname" class="billing-detail lname" placeholder="Nachname">
                    <input type="text" name="email" class="billing-detail email" Placeholder="E-Mail Adresse" required>
                    <input type="text" name="phone_number" class="billing-detail phone_number" Placeholder="Telefonnummer ">
                    <input type="hidden" name="choosepayment" value="cash">
                    <input type="hidden" name="totalAmount" value="<?php echo e($totalamount); ?>">
                    <input type="hidden" name="usertype" id="usertype" value="">
                </div>
                <button type="submit"  class="btn btn-book-block mt-5 checkout-btn " id="booking">
                    <p>Buchen</p>
                    <div>
                        <span><img
                                src="<?php echo e(URL::to('storage/app/public/Serviceassets/images/new-appoi/right-arrow.svg')); ?>"
                                alt=""></span>
                    </div>
                </button>
            </div>
        </div>
        <?php echo e(Form::close()); ?>

        <!-- modal -->
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('service_js'); ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.7.0/chosen.jquery.min.js"></script>
    <script>
		
        $('#payment-form').validate({ // initialize the plugin
            rules: {
                fname: {
                    required: true,
                },
                email: {
                    required: true,
                    email: true
                },
                phone_number: {
                    //required: true,
                    number: true,
                    minlength: 11,
                    maxlength: 13
                }
            },
            // Specify validation error messages
            messages: {
                fname: {
                    required: "Bitte den Vornamen eingeben"
                },
                phone_number: {
                    required: "Bitte die Telefonnummer eingeben.",
                    minlength: "Bitte geben Sie eine gültige Telefonnummer ein",
                    maxlength: "Bitte geben Sie eine gültige Telefonnummer ein",
					 number: "Bitte geben Sie eine gültige Telefonnummer ein",
                },
                email: "Bitte die E-Mail Adresse eingeben"
            },
        });
        var authCheck = '<?php echo e(Auth::check()); ?>';
        var baseurl = '<?php echo e(URL::to('/service-provider')); ?>';
        var token = '<?php echo e(csrf_token()); ?>';
        var loginUser = localStorage.getItem('loginuser');
        $(document).on('change','.customerData',function (){
            var id = $(this).val();
            $.ajax({
                type: 'POST',
                async: true,
                dataType: "json",
                url: baseurl + '/get-customer-details',
                data: {
                    _token: token,
                    id: id,
                },
                beforesend: $('#loading').css('display', 'block'),
                success: function (response) {
                        var data = response.data;
                        $('.fname').val(data.first_name);
						if(data.first_name != ""){
							$('.fname').removeClass('error');
							$('#fname-error').hide();
						}
                        $('.lname').val(data.last_name);
                        $('.email').val(data.email);
						if(data.email != ""){
							$('.email').removeClass('error');
							$('#email-error').hide();
						}
                        $('.phone_number').val(data.phone_number);
						if(data.phone_number != ""){
							$('.phone_number').removeClass('error');
							$('#phone_number-error').hide();
						}
                        $('#loading').css('display', 'none');
                }
            });
        })
        $("#customer").chosen({no_results_text: "Oops, nothing found!"}); 
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.serviceProvider', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/ServiceProvider/Appointment/Create/billing.blade.php ENDPATH**/ ?>