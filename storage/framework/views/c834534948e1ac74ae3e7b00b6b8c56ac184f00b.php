<!doctype html>
<html dir="ltr" lang="en-US">

<head>
    <title>Checkout</title>
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
            pointer-events:none; //This makes it not clickable
        /*opacity:0.6;         //This grays it out to look disabled*/
        }

        
        .delete-profile-box {
            text-align: center;
            padding: 30px 0 30px;
        }

        .delete-profile-box h4 {
            font-size: 32px;
            color: #101928;
            font-weight: 700;
            margin-bottom: 19px;
        }

        .delete-profile-box p {
            font-size: 18px;
            color: #101928;
            font-weight: 400;
            opacity: 0.50;
            max-width: 340px;
            margin: auto;
        }

        .btn-gray {
            background: #0f1928;
            font-size: 17px;
            color: #ffffff;
            font-weight: 500;
            border: 2px solid #F9F9FB;
            border-radius: 15px;
            padding: 11px 22px;
            transition: all 0.5s;
        }

        .btn-gray:hover {
            background: #101928;
            color: #FABA5F;
        }


        .notes-btn-wrap {
            text-align: center;
        }
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
                        <li class="breadcrumb-item"><a href="#">- Checkout</a>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </nav>
</div>
<section class="secbookinfo pt-3">
    <div class="container">
        <h4 class="checkout-title">Checkout Prozess</h4>
        <div class="row">
            <div class="col-lg-6">
                <div class="checkout-header-profile">
                    <span>
                        <?php if(file_exists(storage_path('app/public/store/'.@$store['store_profile'])) && @$store['store_profile'] != ''): ?>
                            <img src="<?php echo e(URL::to('storage/app/public/store/'.@$store['store_profile'])); ?>" alt="">

                        <?php else: ?>
                            <img src="<?php echo e(URL::to('storage/app/public/default/store_default.png')); ?>" alt="">
                        <?php endif; ?>
                    </span>
                    <h6><?php echo e(@$store['store_name']); ?></h6>
                </div>
            </div>
            <div class="col-lg-6">
                <a href="<?php echo e(URL::to('cosmetic/'.@$store['slug'])); ?>" class="add-checkout-booking">
                    <span>
                        <img src="<?php echo e(URL::to('storage/app/public/Frontassets/images/icon/plus.svg')); ?>" alt=""></span> 
                        Weiteren Service hinzufügen <?php echo e(@$store['store_name']); ?></a>
            </div>
        </div>
        <?php echo e(Form::open(array('url'=>'update-checkout-data','method'=>'post','name'=>'update_checkout_data'))); ?>

		 <div style="display: none"><?php echo e($i = 0); ?><?php echo e($j = 1); ?></div>
        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="accordion pb-3" id="accordionExample-<?php echo e($row['category']['id']); ?>">
           
            <div class="paymentaccordion paymentaccordion2" data-id="<?php echo e($row['category']['id']); ?>">
                <a href="javascript:void(0)" class="payment-box-link" data-toggle="collapse" data-target="#collapse<?php echo e($row['category']['id']); ?>"
                   aria-expanded="true" aria-controls="collapse<?php echo e($row['category']['id']); ?>">
                    <span
                        class="payment-box-icon"><?php echo file_get_contents(URL::to('storage/app/public/category/' . @$row['category']['image'])) ?></span>
                    <h6><?php echo e($row['category']['name']); ?></h6>
                    <span class="downn-arroww"><i class="far fa-chevron-down"></i></span>
                </a>
                <div id="collapse<?php echo e($row['category']['id']); ?>" class="collapse show" aria-labelledby="heading<?php echo e($row['category']['id']); ?>"
                     data-parent="#accordionExample-<?php echo e($row['category']['id']); ?>">
                    <div class="worning-message" data-id="<?php echo e($row['category']['id']); ?>">
                        <h5>Mitarbeiter, Datum, Uhrzeit hier wählen</h5>
                        <h6><img src="<?php echo e(URL::to('storage/app/public/Frontassets/images/icon/warning.svg')); ?>" alt="">
                        Bitte wähle einen Mitarbeiter, Datum und Uhrzeit für Friseur Services</h6>
                        <a href="#" class="btn btn-choose chooseDate"  data-id="<?php echo e($row['category']['id']); ?>" data-store="<?php echo e($store['id']); ?>" data-time="<?php echo e($row['totaltime']); ?>" data-change="0">
                        Wählen</a>
                    </div>
                    <div class="payment-body-box">
                        <div class="payment-box-profile-wrap emplistdata" data-id="<?php echo e($row['category']['id']); ?>" style="display: none">
                            <span class="empname" data-id="<?php echo e($row['category']['id']); ?>"><img src="<?php echo e(URL::to('storage/app/public/default/default-user.png')); ?>" alt=""></span>
                            <div class="empname" data-id="<?php echo e($row['category']['id']); ?>">
                                <p>Mitarbeiter/-in</p>
                                <h6>Beliebiger Mitarbeiter</h6>
                            </div>
                            <div class="datetimeslot" data-id="<?php echo e($row['category']['id']); ?>">
                                <p></p>
                                <h6></h6>
                            </div>
                            <a href="#" class="btn btn-choose change_again chooseDate ml-3" data-id="<?php echo e($row['category']['id']); ?>" data-store="<?php echo e($store['id']); ?>" data-time="<?php echo e($row['totaltime']); ?>" data-change="1" style="display:none">Ändern</a>
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
                                <a href="#" class="btn btn-black mt-0 cancelService" data-time="<?php echo e(@$item['variant_data']['duration_of_service']); ?>" data-id="<?php echo e(@$item['variant_data']['id']); ?>" data-cateogry="<?php echo e($row['category']['id']); ?>">Löschen</a>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <input type="hidden" name="category[]" class="category_id" data-id="<?php echo e($row['category']['id']); ?>" value="<?php echo e($row['category']['id']); ?>">
                        <input type="hidden" name="store[]" class="store_id" data-id="<?php echo e($row['category']['id']); ?>" value="<?php echo e($store['id']); ?>">
                        <input type="hidden" name="date[]" class="date_id" data-id="<?php echo e($row['category']['id']); ?>" value="">
                        <input type="hidden" name="employee[]" class="emp_id" data-id="<?php echo e($row['category']['id']); ?>" value="">
                        <input type="hidden" name="totalTime[]" class="totalTime" data-id="<?php echo e($row['category']['id']); ?>" value="<?php echo e($row['totaltime']); ?>">
                        <input type="hidden" name="time[]" class="timeslot" data-id="<?php echo e($row['category']['id']); ?>" value="">
                    </div>
                </div>
            </div>
                <div style="display: none"><?php echo e($i++); ?><?php echo e($j++); ?></div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <input type="hidden" name="totalamount" class="totalamount" data-id="" value="<?php echo e($totalamount); ?>">
        <input type="hidden" name="totalcategory" class="totalcategory" data-id="" value="<?php echo e($i); ?>">
        <button type="submit"  class="btn btn-book-block mt-5 disabled checkout-move">
            <p>Checkout</p>
            <div>
                <span>Gesamt</span>
                <h6 class="tamount"><?php echo e(number_format($totalamount,2,',','.')); ?>€</h6>
            </div>
        </button>
        <?php echo e(Form::close()); ?>

    </div>
</section>
<!-- booking Detail end -->
<div class="modal fade" id="chooseNowModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body choose-modal-body">
                <button type="button" class="close"  aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
                <div class="hairchoosbox">
                    <span class="categoryImage"></span>
                    <h5 class="categoryName">Hair</h5>
                    <h6>Mitarbeiter, Datum, Uhrzeit hier wählen</h6>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="hairchoosbox-left">
                            <div class="hairchoosbox-profile">
                                <span><img class="storeimage" src="<?php echo e(URL::to('storage/app/public/Frontassets/images/profile1.png')); ?>"
                                           alt=""></span>
                                <h6 class="storename">Lounge Hair & Care</h6>
                            </div>
                            <div class="hairchoosbox-select-box">
                                <select class="vodiapicker emplist">
                                    <option value="en" class="test"
                                            data-thumbnail="<?php echo e(URL::to('storage/app/public/Frontassets/images/icon/profile-icon.svg')); ?>">
                                        Profile
                                    </option>
                                    <option value="au"
                                            data-thumbnail="<?php echo e(URL::to('storage/app/public/Frontassets/images/profile1.png')); ?>">
                                        Profile 2
                                    </option>
                                    <option value="uk"
                                            data-thumbnail="<?php echo e(URL::to('storage/app/public/Frontassets/images/profile.jpg')); ?>">
                                        Profile 3
                                    </option>
                                    <option value="cn"
                                            data-thumbnail="<?php echo e(URL::to('storage/app/public/Frontassets/images/profile-img.jpg')); ?>">
                                        Profile 4
                                    </option>
                                </select>
                                <div class="lang-select">
                                    <button class="btn-select" value=""></button>
                                    <div class="b">
                                        <ul id="a" class="lang_ul"></ul>
                                    </div>
                                </div>
                            </div>
                            <div class="hairchoosbox-date">
                                <h6>Datum wählen</h6>
                                <div id="calendar2"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="set-time-head">
                            <h6>Uhrzeit wählen</h6>
                            <ul class="scheduletime scheduletime2">

                            </ul>
                        </div>
                    </div>
                </div>
                <a href="#" class="btn btn-book-block mt-5 disabled" id="booking">
                    <p>Weiter</p>
                    <div>
                        <span class="dateshow">16 May 2021</span>
                        <h6 class="timeshow">-</h6>
                    </div>
                </a>
                <input type="hidden" name="category" class="category_ids">
                <input type="hidden" name="store" class="store_ids">
                <input type="hidden" name="date" class="date_ids">
                <input type="hidden" name="employee" class="emp_ids">
                <input type="hidden" name="totalTime" class="totalTimes">
                <input type="hidden" name="time" class="timeslotsa">
            </div>
        </div>
    </div>
</div>

<!-- deleteProfilemodal -->
<div class="modal fade" id="deleteProfilemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="delete-profile-box">
                    <h4>Fehlgeschlagen</h4>
                    <p>Tut uns Leid! Dieser Termin ist mit den angegebenen Daten nicht buchbar. Bitte wähle eine andere Uhrzeit.</p>
                </div>
                <div class="notes-btn-wrap">
                    
                    <a href="#" class="btn btn-gray" data-dismiss="modal" >Close</a>
                   
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Optional JavaScript -->
<script src="<?php echo e(URL::to('storage/app/public/Frontassets/js/jquery.min.js')); ?>"></script>
<script src="<?php echo e(URL::to('storage/app/public/Frontassets/js/bootstrap.bundle.min.js')); ?>"></script>
<script src="<?php echo e(URL::to('storage/app/public/Frontassets/js/jquery.fancybox.min.js')); ?>"></script>
<script src="<?php echo e(URL::to('storage/app/public/Frontassets/js/owl.carousel.min.js')); ?>"></script>
<script src="<?php echo e(URL::to('storage/app/public/Frontassets/js/jquery.nice-select.min.js')); ?>"></script>
<script src="<?php echo e(URL::to('storage/app/public/Frontassets/js/bootstrap-datepicker.js')); ?>"></script>
<script src="<?php echo e(URL::to('storage/app/public/Frontassets/js/custom.js')); ?>"></script>
<script src="<?php echo e(URL::to('storage/app/public/Frontassets/js/data.js')); ?>"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.de.min.js" charset="UTF-8"></script>
<script>
    var authCheck = '<?php echo e(Auth::check()); ?>';
    var baseurl = '<?php echo e(URL::to('/')); ?>';
    var token = '<?php echo e(csrf_token()); ?>';
    var loginUser = localStorage.getItem('loginuser');
    localStorage.removeItem('getBookingData');
    $(document).ready(function () {

        var berror = '<?php echo e(\Session::get("booking_error")); ?>';
        if(berror == 'yes'){
            $('#deleteProfilemodal').modal('toggle');
            var value = '<?php echo e(\Session::forget("booking_error")); ?>'
        }
        localStorage.removeItem('lastValue');
        $(document).on('click','.scheduletime li',function (){
            $('li').removeClass("activetime");
            $(this).addClass("activetime");
            $('.timeslotsa').val($(this).data('id'));
            $('.timeshow').text($(this).data('id'));
            $('#booking').removeClass('disabled');
        });
    });

    //test for iterating over child elements
    var langArray = [];
    $('.vodiapicker option').each(function () {
        var img = $(this).attr("data-thumbnail");
        var text = this.innerText;
        var value = $(this).val();
        var item = '<li><img src="' + img + '" alt="" value="' + value + '"/><span>' + text + '</span></li>';
        langArray.push(item);
    })

    $('#a').html(langArray);

    //Set the button value to the first el of the array
    $('.btn-select').html(langArray[0]);
    $('.btn-select').attr('value', 'en');

    //change button stuff on click
    $('#a li').click(function () {
        var img = $(this).find('img').attr("src");
        var value = $(this).find('img').attr('value');
        var text = this.innerText;
        var item = '<li><img src="' + img + '" alt="" /><span>' + text + '</span></li>';
        $('.btn-select').html(item);
        $('.btn-select').attr('value', value);


        $(".b").toggle();
        // console.log(value);
    });

    $(".btn-select").click(function () {
        // console.log('value');
        $(".b").toggle();
    });

    //check local storage for the lang
    var sessionLang = localStorage.getItem('lang');
    if (sessionLang) {
        //find an item with value of sessionLang
        var langIndex = langArray.indexOf(sessionLang);
        $('.btn-select').html(langArray[langIndex]);
        $('.btn-select').attr('value', sessionLang);
    } else {
        var langIndex = langArray.indexOf('ch');
        $('.btn-select').html(langArray[langIndex]);
        //$('.btn-select').attr('value', 'en');
    }
    $(document).ready(function () {
        $('.scheduletime li ').click(function () {
            $('li').removeClass("activetime");
            $(this).addClass("activetime");
        });
    });
    $('#calendar2').datepicker({
        language: "de",
        format: 'yyyy-mm-dd',
        min: 0,
        startDate: new Date(),
    }).on('changeDate', function(e) {
        $('.date_ids').val(e.format());
        $('.dateshow').text(e.format('dd-mm-yyyy'));
        $('.timeshow').text('-');
        $('#booking').addClass('disabled');
        changeDate();
    });

    $(document).on('click','.close',function (){
        $('#chooseNowModal').modal('toggle');
    })

</script>
</body>

</html>
<?php /**PATH /var/www/html/resources/views/Front/Cosmetic/booking/checkout.blade.php ENDPATH**/ ?>