<!doctype html>
<html dir="ltr" lang="en-US">

<head>
    <title>Procceed To Pay</title>
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
        .disabled {
            pointer-events: none;
        / / This makes it not clickable
        }

        #card-element {
            margin: 20px;
            width: 100%;
            margin-top: 12px;
        }
		input[readonly]{cursor:not-allowed;}
		.condition{opacity:100%;}
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
                        <li class="breadcrumb-item"><a href="#">-Checkout Prozess</a>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </nav>
</div>
<!-- Booking Summery -->
<section class="secbookinfo pt-3">
    <?php echo e(Form::open(array('url'=>'submit-payment-booking','method'=>'post','name'=>'payment','id'=>'payment-form','class'=>'require-validation'))); ?>

    <div class="container">
        <div class="row paymentinformation checkout-section">
            <div class="person-booking-info">
                <h3>Buchungsübersicht</h3>
                <div class="bookingtimesummry">
                    <div class="bookingsummry">
                        <div class="profile d-flex align-items-center justify-content-lg-start">
                            <div class="profileimg">
                                <?php if(file_exists(storage_path('app/public/store/'.$store['store_profile'])) && $store['store_profile'] != ''): ?>
                                    <img src="<?php echo e(URL::to('storage/app/public/store/'.$store['store_profile'])); ?>" alt="">

                                <?php else: ?>
                                    <img src="<?php echo e(URL::to('storage/app/public/default/store_default.png')); ?>" alt="">
                                <?php endif; ?>
                            </div>
                            <div class="profiledetail">
                                <h6>Salonname</h6>
                                <p><?php echo e($store['store_name']); ?></p>
                            </div>
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
                                                <div class="payment-box-profile-wrap payment-box-profile-wrap2 emplistdata"
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
                                                        <span class="empname" data-id="<?php echo e($row['category']['id']); ?>"><img
                                                                src="<?php echo e(URL::to('storage/app/public/default/default-user.png')); ?>"
                                                                alt=""></span>
                                                        <div class="empname" data-id="<?php echo e($row['category']['id']); ?>">
                                                            <p>Mitarbeiter</p>
                                                            <h6>Any Person</h6>
                                                        </div>
                                                    <?php endif; ?>
                                                    <div class="datetimeslot" data-id="<?php echo e($row['category']['id']); ?>">
                                                        <p><?php echo e(\Carbon\Carbon::parse($row['data'][0]['date'])->format('d-m-Y')); ?></p>
                                                        <h6><?php echo e(\Carbon\Carbon::parse($row['data'][0]['time'])->format('H:i')); ?></h6>
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

                                                <input type="hidden" name="category[]" class="category_id"
                                                       data-id="<?php echo e($row['category']['id']); ?>"
                                                       value="<?php echo e($row['category']['id']); ?>">
                                                <input type="hidden" name="store[]" class="store_id"
                                                       data-id="<?php echo e($row['category']['id']); ?>" value="<?php echo e($store['id']); ?>">
                                                <input type="hidden" name="date[]" class="date_id"
                                                       data-id="<?php echo e($row['category']['id']); ?>" value="<?php echo e($item['date']); ?>">
                                                <input type="hidden" name="employee[]" class="emp_id"
                                                       data-id="<?php echo e($row['category']['id']); ?>"
                                                       value="<?php echo e($item['employee']); ?>">
                                                <input type="hidden" name="time[]" class="timeslot"
                                                       data-id="<?php echo e($row['category']['id']); ?>" value="<?php echo e($item['time']); ?>">
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
                    <a href="#" class="btn totalbook">Gesamt <p><?php echo e(number_format($totalamount,2,',','.')); ?>€</p></a>
                </div>
                <div class="cancelationpolicy d-flex align-items-center">
                    <div class="cancelpolicyimg">
                        <img src="<?php echo e(URL::to('storage/app/public/Frontassets/images/cancel.svg')); ?>" alt="">
                    </div>
                    <div class="policy">
                        <h4>Stornierungsrichtlinien</h4>
                        <a target="_blank" href="<?php echo e(route('agb')); ?>">Richtlinien anzeigen</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Booking Summery end -->
        <!-- Billing Detail -->
        <div class="personalbillinginfo">
            <div class="person-info">
                <h3>Kontaktdaten</h3>
                <div class="checkout-wrap">
                    <div class="row">
                        <div class="billdetail">
                            <div class="col-lg-12">
                                <div class="row">
                                <div class="col-sm-6">
                                        <input type="text" name="fname" placeholder="Vorname" class="fname" id="fname"
                                            value="<?php if(Auth::check()): ?><?php echo e(Auth::user()->first_name); ?><?php endif; ?>"  required>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" name="lname" placeholder="Nachname" class="fname" id="lname"
                                            value="<?php if(Auth::check()): ?><?php echo e(Auth::user()->last_name); ?><?php endif; ?>" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <input readonly type="text" name="email" placeholder="E-Mail Adresse" class="fname" id="email"
                                            value="<?php if(Auth::check()): ?><?php echo e(Auth::user()->email); ?><?php endif; ?>" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" name="phone_number" placeholder="Telefonnummer" class="fname"
                                            value="<?php if(Auth::check()): ?><?php echo e(Auth::user()->phone_number); ?><?php endif; ?>" id="phone_number"
                                            required>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Billing Detail end -->
                    <!-- Payment Detail -->
                    <div class="payment-details">
                        <h3>Zahlung</h3>

                        <div class="choosepaymentmethod d-flex align-items-center">
                            <div class="paymentmethodimg">
                                <img src="<?php echo e(URL::to('storage/app/public/Frontassets/images/paymentmethod.svg')); ?>"
                                     alt="">
                            </div>
                            <div class="paymentmethod">
                                <h4>Zahlungsmethode wählen</h4>
                                <p>Transaktionen sind gesichert und verschlüsselt.</p>
                            </div>
                        </div>
                        <div class="selectpaymentmethod d-flex align-items-center justify-content-md-between">
                            <?php if($store['payment_method'] == 'cash'): ?>
                            <div class="pay" data-id="cash" for="cash">
                                <input type="radio" class="paycash" value="cash" name="choosepayment" id="cash">
                                <div class="cashpay">
                                    <div class="cashimg">
                                        <img src="<?php echo e(URL::to('storage/app/public/Frontassets/images/cash.svg')); ?>" alt="">
                                    </div>
                                    <p>Vor Ort</p>
                                </div>
                            </div>
                            <?php elseif($store['payment_method'] == 'card'): ?>
                            <div class="pay" data-id="master_card" for="master_card">
                                <input type="radio" class="paycash" value="stripe" name="choosepayment"
                                       id="master_card">
                                <div class="cashpay">
                                    <div class="masterimg">
                                        <img src="<?php echo e(URL::to('storage/app/public/Frontassets/images/master.svg')); ?>"
                                             alt="">
                                    </div>
                                    <p>MasterCard</p>
                                </div>
                            </div>
                            <div class="pay" data-id="visa" for="visa">
                                <input type="radio" class="paycash" value="stripe" name="choosepayment" id="visa">
                                <div class="cashpay">
                                    <div class="visaimg">
                                        <img src="<?php echo e(URL::to('storage/app/public/Frontassets/images/visa.svg')); ?>" alt="">
                                    </div>
                                    <p>Visa</p>
                                </div>
                            </div>
                            <div class="pay" data-id="klarna" for="klarna">
                                <input type="radio" class="paycash" value="klarna" name="choosepayment" id="klarna">
                                <div class="cashpay">
                                    <div class="klarnaimg">
                                        <img src="<?php echo e(URL::to('storage/app/public/Frontassets/images/klarna.svg.svg')); ?>"
                                             alt="">
                                    </div>
                                    <p>Klarna</p>
                                </div>
                            </div>
                            
                            <?php else: ?>
                            <div class="pay" data-id="cash" for="cash">
                                <input type="radio" class="paycash" value="cash" name="choosepayment" id="cash">
                                <div class="cashpay">
                                    <div class="cashimg">
                                        <img src="<?php echo e(URL::to('storage/app/public/Frontassets/images/cash.svg')); ?>" alt="">
                                    </div>
                                    <p>Vor Ort</p>
                                </div>
                            </div>
                             <div class="pay" data-id="master_card" for="master_card">
                                <input type="radio" class="paycash" value="stripe" name="choosepayment"
                                       id="master_card">
                                <div class="cashpay">
                                    <div class="masterimg">
                                        <img src="<?php echo e(URL::to('storage/app/public/Frontassets/images/master.svg')); ?>"
                                             alt="">
                                    </div>
                                    <p>MasterCard</p>
                                </div>
                            </div>
                            <div class="pay" data-id="visa" for="visa">
                                <input type="radio" class="paycash" value="stripe" name="choosepayment" id="visa">
                                <div class="cashpay">
                                    <div class="visaimg">
                                        <img src="<?php echo e(URL::to('storage/app/public/Frontassets/images/visa.svg')); ?>" alt="">
                                    </div>
                                    <p>Visa</p>
                                </div>
                            </div>
                            <div class="pay" data-id="klarna" for="klarna">
                                <input type="radio" class="paycash" value="klarna" name="choosepayment" id="klarna">
                                <div class="cashpay">
                                    <div class="klarnaimg">
                                        <img src="<?php echo e(URL::to('storage/app/public/Frontassets/images/klarna.svg.svg')); ?>"
                                             alt="">
                                    </div>
                                    <p>Klarna</p>
                                </div>
                            </div>
                            
                            <?php endif; ?>
                        </div>
                        <div class="row d-flex align-items-center cardddetail" style="display: none !important;">
                            <div id="card-element">
                                <!-- A Stripe Element will be inserted here. -->
                            </div>
                            <div id="card-errors" role="alert"></div>
                            
                            
                            
                            
                            
                            
                            
                            
                            
                        </div>
                    </div>
                </div>

                
                
                
                
                <input type="hidden" name="totalAmount" value="<?php echo e($totalamount); ?>">
                <input type="hidden" name="usertype" id="usertype" value="">
                <button class="btn paybtn disabled">Zahlungspflichtig Buchen <?php echo e(number_format($totalamount,2,',','.')); ?>€</button>
                <div class="condition"><a target="_blank" href="<?php echo e(route('agb')); ?>" class="plink">Indem Sie fortfahren akzeptieren Sie unsere AGB.</a>
                </div>
            </div>
        </div>
    </div>
<?php echo e(Form::close()); ?>

<!-- Payment Detail end-->
<div class="modal fade" id="PaymentErrormodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="delete-profile-box">
                    <h4>Fehlgeschlagen</h4>
                    <p id="payment_error_msg"></p>
                </div>
                <div class="notes-btn-wrap">
                    
                    <a href="#" class="btn btn-gray" data-dismiss="modal" >Close</a>
                   
                </div>
            </div>
        </div>
    </div>
</div>

</section>
<!-- Optional JavaScript -->
<script src="<?php echo e(URL::to('storage/app/public/Frontassets/js/jquery.min.js')); ?>"></script>
<script src="<?php echo e(URL::to('storage/app/public/Frontassets/js/bootstrap.bundle.min.js')); ?>"></script>
<script src="<?php echo e(URL::to('storage/app/public/Frontassets/js/jquery.fancybox.min.js')); ?>"></script>
<script src="<?php echo e(URL::to('storage/app/public/Frontassets/js/owl.carousel.min.js')); ?>"></script>
<script src="<?php echo e(URL::to('storage/app/public/Frontassets/js/jquery.nice-select.min.js')); ?>"></script>
<script src="<?php echo e(URL::to('storage/app/public/Frontassets/js/bootstrap-datepicker.js')); ?>"></script>
<script src="<?php echo e(URL::to('storage/app/public/Frontassets/js/custom.js')); ?>"></script>
<script src="https://js.stripe.com/v3/"></script>
<script src="<?php echo e(URL::to('storage/app/public/Frontassets/js/pavuk.js')); ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
<script>
    var baseurl = '<?php echo e(URL::to('/')); ?>';
    var token = '<?php echo e(csrf_token()); ?>';
    var authCheck = '<?php echo e(Auth::check()); ?>';
    var loginUser = localStorage.getItem('loginuser');
	$(document).ready(function () {
        var berror = '<?php echo e(\Session::get("payment_error")); ?>';
        if(berror){
			$('#payment_error_msg').html(berror);
            $('#PaymentErrormodal').modal('toggle');
            var value = '<?php echo e(\Session::forget("payment_error")); ?>'
        }
    });
    if(loginUser == 'guest'){
        var fname = localStorage.getItem('first_name');
        var lname = localStorage.getItem('last_name');
        var email = localStorage.getItem('email');
        var phone_number = localStorage.getItem('phone_number');

        $('#fname').val(fname);
        $('#lname').val(lname);
        $('#email').val(email);
        $('#phone_number').val(phone_number);
    } else {
        var phone = '<?php echo e(@Auth::user()->phone_number); ?>';
    }

    $('#payment-form').validate({ // initialize the plugin
        rules: {
            fname: {
                required: true,
            },
            lname: {
                required: true,
            },
            email: {
                required: true,
                email: true
            },
            phone_number: {
                required: true,
                number: true,
                minlength: 11,
                maxlength: 13,
            }
        },
        // Specify validation error messages
        messages: {
            fname: {
                required: "Bitte gib deine Vorname"
            },
            lname: {
                required: "Bitte gib deine Nachname"
            },
            phone_number: {
                required: "Bitte gib deine Telefonnummer ein.",
                minlength: "Bitte gib deine Telefonnummer ein.",
                maxlength: "Bitte gib deine Telefonnummer ein.",
            },
            email: "Bitte gib eine gültige E-Mail Adresse ein."
        },
    });
</script>
</body>

</html>

<?php /**PATH /var/www/html/resources/views/Front/Cosmetic/booking/proccedToPay.blade.php ENDPATH**/ ?>