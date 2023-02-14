<!doctype html>
<html dir="ltr" lang="en-US">

<head>
    <title>Booking conformed</title>
    <link type="image/x-icon" rel="shortcut icon"
          href="<?php echo e(URL::to('storage/app/public/Frontassets/images/favicon.png')); ?>"/>
    <!-- Required meta tags -->
    <meta charset="UTF-8"/>
    <meta name="HandheldFriendly" content="true">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link type="text/css" rel="stylesheet" href="<?php echo e(URL::to('storage/app/public/Frontassets/font/stylesheet.css')); ?>"/>
    <link type="text/css" rel="stylesheet" href="<?php echo e(URL::to('storage/app/public/Frontassets/css/all.min.css')); ?>"/>
    <link type="text/css" rel="stylesheet" href="<?php echo e(URL::to('storage/app/public/Frontassets/css/bootstrap.min.css')); ?>"/>
    <link type="text/css" rel="stylesheet"
          href="<?php echo e(URL::to('storage/app/public/Frontassets/css/jquery.fancybox.min.css')); ?>"/>
    <link type="text/css" rel="stylesheet"
          href="<?php echo e(URL::to('storage/app/public/Frontassets/css/owl.carousel.min.css')); ?>"/>
    <link type="text/css" rel="stylesheet" href="<?php echo e(URL::to('storage/app/public/Frontassets/css/nice-select.css')); ?>"/>
    <link type="text/css" rel="stylesheet"
          href="<?php echo e(URL::to('storage/app/public/Frontassets/css/bootstrap-datepicker.css')); ?>"/>
    <link type="text/css" rel="stylesheet" href="<?php echo e(URL::to('storage/app/public/Frontassets/css/styles.css')); ?>"/>
    <link type="text/css" rel="stylesheet" href="<?php echo e(URL::to('storage/app/public/Frontassets/css/styles-2.css')); ?>"/>
    <link type="text/css" rel="stylesheet" href="<?php echo e(URL::to('storage/app/public/Frontassets/css/responsive.css')); ?>"/>
    <style>

    </style>
</head>

<body>
<!--Heading-->
<div>
    <nav class="navbar navbar-expand-lg processtopay-header">
        <div class="container">
            <div class="heading d-flex justify-content-between flex-wrap">
                <a class="navbar-brand logo" href="<?php echo e(URL::to('/')); ?>">
                    <img src="<?php echo e(URL::to('storage/app/public/Frontassets/images/logo.png')); ?>" alt="logo">
                </a>
                <nav aria-label="breadcrumb" class="breadcrumb-ol">
                    <ol class="breadcrumb">
                        <li onclick="window.location.href='<?php echo e(URL::to('/')); ?>'">
                            <img src="<?php echo e(URL::to('storage/app/public/Frontassets/images/home.svg')); ?>" alt="">
                        </li>
                        <li class="breadcrumb-item"><a href="#">-Buchung bestätigt!</a>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </nav>
</div>
<!-- Booking Confirm -->
<section>
    <div class="container">
        <?php if($status == 'success'): ?>
            <div class="booking-con text-center">
                <div class="booking">
                    <h3>Buchung bestätigt!</h3>
                    <p>Glückwunsch! Dein Termin wurde erfolgreich gebucht.</p>
                </div>
            </div>
        <?php else: ?>
            <div class="booking-failed text-center">
                <div class="booking">
                    <h3>Booking Failed</h3>
                    <p>Payment for Booking Could not be proceed. Please try again.</p>
                </div>
            </div>
        <?php endif; ?>
        <div class="booking-id">
            <h4>Deine Buchungs-ID: <label>#<?php echo e($appointment['order_id']); ?></label></h4>
        </div>
    </div>
</section>
<!-- Booking Confirm end -->
<!-- Booking Detaile -->
<section class="secbookinfo">
    <div class="container">
        <div class="row paymentinformation">
            <div class="col-sm-6">
                <div class="person-booking-info-con">
                    <h3>Buchungsdetails</h3>
                    <div class="bookingpersonimg">
                        <?php if(file_exists(storage_path('app/public/store/'.$store['store_profile'])) && $store['store_profile'] != ''): ?>
                            <img src="<?php echo e(URL::to('storage/app/public/store/'.$store['store_profile'])); ?>" alt="">

                        <?php else: ?>
                            <img src="<?php echo e(URL::to('storage/app/public/default/store_default.png')); ?>" alt="">
                        <?php endif; ?>
                    </div>
                    <div class="personinfo">
                        <div class="information d-flex justify-content-between">
                            <h6>Salon</h6>
                            <p><?php echo e($store['store_name']); ?></p>
                        </div>
                    </div>
                    <?php if($status == 'success'): ?>
                        <div class="personinfo">
                            <div class="information d-flex justify-content-between">
                                <h6>Zahlungsmethode</h6>
                                <p><?php echo e($paymentinfo['payment_method'] == 'cash' ? 'vor Ort' : ((strtolower($paymentinfo['payment_method']) == 'stripe' && !empty($paymentinfo['card_type']))?$paymentinfo['card_type']:$paymentinfo['payment_method'])); ?></p>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="personinfo">
                        <div class="information d-flex justify-content-between">
                            <h6>Gesamtbetrag</h6>
                            <p><?php echo e(number_format($appointment['total_amount'],2,',','.')); ?>€</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Booking detail end -->
            <!-- Payment Summry -->
            <div class="col-sm-6">
                <div class="person-info-payment">
                    <h3 class="summery">Zahlungsübersicht</h3>
                    <div class="paymentinfo">
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
                                            <div class="payment-box-profile-wrap emplistdata"
                                                 data-id="<?php echo e($row['category']['id']); ?>">
                                                <?php if($row['data'][0]['store_emp_id'] != null): ?>
                                                    <span class="empname" data-id="<?php echo e($row['category']['id']); ?>">
														<?php if(\BaseFunction::getEmployeeDetails($row['data'][0]['store_emp_id'],'image')): ?>
															<img src="<?php echo e(URL::to('storage/app/public/store/employee/'.\BaseFunction::getEmployeeDetails($row['data'][0]['store_emp_id'],'image'))); ?>" alt="">
														<?php else: ?>
															<?php
																$employee_name = \BaseFunction::getEmployeeDetails($row['data'][0]['store_emp_id'],'emp_name');
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
                                                        <h6><?php echo e(\BaseFunction::getEmployeeDetails($row['data'][0]['store_emp_id'],'emp_name')); ?></h6>
                                                    </div>
                                                <?php else: ?>
                                                    <span class="empname"><img
                                                            src="<?php echo e(URL::to('storage/app/public/default/default-user.png')); ?>"
                                                            alt=""></span>
                                                    <div class="empname ">
                                                        <p>Mitarbeiter</p>
                                                        <h6>Any Person</h6>
                                                    </div>
                                                <?php endif; ?>
                                                <div class="datetimeslot data-id="<?php echo e($row['category']['id']); ?>">
                                                <p><?php echo e(\Carbon\Carbon::parse($row['data'][0]['appo_date'])->format('d-m-Y')); ?></p>
                                                <h6><?php echo e(\Carbon\Carbon::parse($row['data'][0]['appo_time'])->format('H:i')); ?></h6>
                                            </div>
                                        </div>
                                        <?php $__currentLoopData = $row['data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="payment-item-infos booking-infor-wrap">
                                                <div class="booking-infor-left">
                                                    <h5><?php echo e(@$item['service_data']['service_name']); ?></h5>
                                                    <h6><?php echo e(@$item['variant_data']['description']); ?></h6>
                                                    <span><?php echo e(@$item['variant_data']['duration_of_service']); ?> min</span>
                                                </div>
                                                <div class="booking-infor-right">
                                                    <p><?php echo e(number_format($item['price'],2,',','.')); ?>€</p>
                                                </div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                            </div>
                            <div style="display: none"><?php echo e($i++); ?><?php echo e($j++); ?></div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
        <?php if($status == 'success'): ?>
            <a href="<?php echo e(URL::to('cosmetic/'.$slug)); ?>" class="btn confirmbtn">Bestätigen</a>
        <?php else: ?>
            <a href="<?php echo e(URL::to('cosmetic/'.$slug)); ?>" class="btn confirmbtn">Try again</a>
    <?php endif; ?>
    <!-- PAyment summry end -->
    </div>
</section>
<!-- Optional JavaScript -->
<script src="<?php echo e(URL::to('storage/app/public/Frontassets/js/jquery.min.js')); ?>"></script>
<script src="<?php echo e(URL::to('public/js/disable.js')); ?>"></script>
<script src="<?php echo e(URL::to('storage/app/public/Frontassets/js/bootstrap.bundle.min.js')); ?>"></script>
<script src="<?php echo e(URL::to('storage/app/public/Frontassets/js/jquery.fancybox.min.js')); ?>"></script>
<script src="<?php echo e(URL::to('storage/app/public/Frontassets/js/owl.carousel.min.js')); ?>"></script>
<script src="<?php echo e(URL::to('storage/app/public/Frontassets/js/jquery.nice-select.min.js')); ?>"></script>
<script src="<?php echo e(URL::to('storage/app/public/Frontassets/js/bootstrap-datepicker.js')); ?>"></script>
<script src="<?php echo e(URL::to('storage/app/public/Frontassets/js/custom.js')); ?>"></script>
<script>
    localStorage.removeItem('selectedService');
    localStorage.removeItem('last_name');
    localStorage.removeItem('first_name');
    localStorage.removeItem('loginuser');
    localStorage.removeItem('phone_number');
    localStorage.removeItem('email');
</script>
</body>

</html>
<?php /**PATH /var/www/html/resources/views/Front/Cosmetic/booking/confirmation.blade.php ENDPATH**/ ?>