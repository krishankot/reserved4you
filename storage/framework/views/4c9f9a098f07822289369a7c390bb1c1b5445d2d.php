<!doctype html>
<html dir="ltr" lang="en-US" translate="no">

<head>
    <title><?php echo $__env->yieldContent('service_title'); ?> Reserved4you</title>
    <link type="image/x-icon" rel="shortcut icon"
          href="<?php echo e(URL::to('storage/app/public/Serviceassets/images/favicon.png')); ?>"/>
    <!-- Required meta tags -->
    <meta charset="UTF-8"/>
    <meta name="HandheldFriendly" content="true">
	<meta name="google" content="notranslate"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <link type="text/css" rel="stylesheet" href="<?php echo e(URL::to('storage/app/public/Serviceassets/font/stylesheet.css')); ?>"/>
    <link type="text/css" rel="stylesheet" href="<?php echo e(URL::to('storage/app/public/Serviceassets/css/all.min.css')); ?>"/>
    <link type="text/css" rel="stylesheet"
          href="<?php echo e(URL::to('storage/app/public/Serviceassets/css/bootstrap.min.css')); ?>"/>
    <link type="text/css" rel="stylesheet"
          href="<?php echo e(URL::to('storage/app/public/Serviceassets/css/jquery.fancybox.min.css')); ?>"/>
    <link type="text/css" rel="stylesheet"
          href="<?php echo e(URL::to('storage/app/public/Serviceassets/css/owl.carousel.min.css')); ?>"/>
    <link type="text/css" rel="stylesheet" href="<?php echo e(URL::to('storage/app/public/Serviceassets/css/nice-select.css')); ?>"/>
    <link type="text/css" rel="stylesheet"
          href="<?php echo e(URL::to('storage/app/public/Serviceassets/css/bootstrap-datepicker.css')); ?>"/>
    <link type="text/css" rel="stylesheet"
          href="<?php echo e(URL::to('storage/app/public/Serviceassets/css/dataTables.bootstrap4.min.css')); ?>"/>
    <link type="text/css" rel="stylesheet"
          href="<?php echo e(URL::to('storage/app/public/Serviceassets/css/responsive.bootstrap4.min.css')); ?>"/>
    <link type="text/css" rel="stylesheet" href="<?php echo e(URL::to('storage/app/public/Serviceassets/css/select2.min.css')); ?>" />
    <link type="text/css" rel="stylesheet" href="<?php echo e(URL::to('storage/app/public/Serviceassets/css/timepicker.css')); ?>" />
	<link type="text/css" rel="stylesheet" href="<?php echo e(asset('storage/app/public/asset_request/css/bootstrap-datetimepicker.css')); ?>"/>
    <link type="text/css" rel="stylesheet" href="<?php echo e(URL::to('storage/app/public/Serviceassets/css/style2.css')); ?>"/>
    <link type="text/css" rel="stylesheet" href="<?php echo e(URL::to('storage/app/public/Serviceassets/css/styles.css')); ?>"/>
    <link type="text/css" rel="stylesheet" href="<?php echo e(URL::to('storage/app/public/Serviceassets/css/responsive.css')); ?>"/>
    <link type="text/css" rel="stylesheet" href="<?php echo e(URL::to('storage/app/public/Serviceassets/css/responsive2.css')); ?>"/>

    <style>
        .error,
        .email-ee {
            color: red;
        }
    </style>

    <?php echo $__env->yieldContent('service_css'); ?>
    <?php
    use App\Models\StoreProfile;
    $getStore = StoreProfile::where('user_id', Auth::user()->id)->get();
    ?>
</head>

<body>
<div id="loading" style="display:none">

</div>
<?php echo $__env->make('Includes.Service.notificationpopup', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<button class="button is-text" id="menu-button" onclick="buttonToggle()">
	<div class="button-inner-wrapper">
		<span class="icon menu-icon"></span>
	</div>
</button>
<?php echo $__env->make('Includes.Service.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->yieldContent('service_content'); ?>
<!-- Optional JavaScript -->

<!-- Optional JavaScript -->
<script src="<?php echo e(URL::to('storage/app/public/Serviceassets/js/jquery.min.js')); ?>"></script>
<script src="<?php echo e(URL::to('public/js/disable.js')); ?>"></script>
<script src="<?php echo e(URL::to('storage/app/public/Serviceassets/js/bootstrap.bundle.min.js')); ?>"></script>
<script src="<?php echo e(URL::to('storage/app/public/Serviceassets/js/jquery.fancybox.min.js')); ?>"></script>
<script src="<?php echo e(URL::to('storage/app/public/Serviceassets/js/owl.carousel.min.js')); ?>"></script>
<script src="<?php echo e(URL::to('storage/app/public/Serviceassets/js/jquery.nice-select.min.js')); ?>"></script>
<script src="<?php echo e(URL::to('storage/app/public/Serviceassets/js/bootstrap-datepicker.min.js')); ?>"></script>
<script src="<?php echo e(URL::to('storage/app/public/Serviceassets/js/jquery.dataTables.min.js')); ?>"></script>
<script src="<?php echo e(URL::to('storage/app/public/Serviceassets/js/dataTables.bootstrap4.min.js')); ?>"></script>
<script src="<?php echo e(URL::to('storage/app/public/Serviceassets/js/dataTables.responsive.min.js')); ?>"></script>
<script src="<?php echo e(URL::to('storage/app/public/Serviceassets/js/responsive.bootstrap4.min.js')); ?>"></script>
<script src="<?php echo e(URL::to('storage/app/public/Serviceassets/js/select2.min.js')); ?>"></script>
<script src="<?php echo e(URL::to('storage/app/public/Serviceassets/js/timepicker.js')); ?>"></script>
<script src="<?php echo e(URL::to('storage/app/public/Serviceassets/js/Chart.js')); ?>"></script>

<script src="https://momentjs.com/downloads/moment-with-locales.js"></script>
<script src="<?php echo e(asset('storage/app/public/asset_request/js/moment.js')); ?>"></script>
<script src="<?php echo e(asset('storage/app/public/asset_request/js/bootstrap-datetimepicker.min.js')); ?>"></script>
<script src="<?php echo e(URL::to('storage/app/public/Serviceassets/js/custom.js')); ?>"></script>
 <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.de.min.js" charset="UTF-8"></script>
<script>
    var baseurl = '<?php echo e(URL::to('/service-provider')); ?>';
    var token = '<?php echo e(csrf_token()); ?>';
    var authCheck = '<?php echo e(Auth::check()); ?>';
	
    $(document).on('change', '.store_category', function () {
        var value = $(this).val();

        $.ajax({
            type: 'POST',
            async: true,
            dataType: "json",
            url: "<?php echo e(URL::to('service-provider/set-store')); ?>",
            data: {
                _token: token,
                id: value,
            },
            success: function (response) {

                window.location.reload();
            }
        });
    })

    
	let buttonToggle = () => {
	  const button = document.getElementById("menu-button").classList,
	  isopened = "is-opened";
	  let isOpen = button.contains(isopened);
	  if(isOpen) {
		button.remove(isopened);
	  } 
	  else {
		button.add(isopened);
	  }
  } 
  $("#menu-button").click(function(){
	  $("html").toggleClass("show-menu");
	});

	$( document ).ready(function() {
		updateNotifications();
	});
	
	function getAppointmentDetails(id){
		let url="<?php echo e(url('service-provider/appointment-detail/find')); ?>/"+id;
		$.get(url,function (response) {
		   $('#myModalNotification .modal-body').html(response);
		   $('#myModalNotification').modal('show');
		});
	}
	var page = 1;
	var total_pages = 2;
	setInterval(function(){ 
		updateNotifications();
	}, 10000);
	
	function updateNotifications(){
		//page = $('.more_notifications').attr('rel');
		
		 $.ajax({
			type: 'POST',
			dataType: "json",
			data:{
				_token:token,
				page:page
			},
			url: "<?php echo e(URL::to('service-provider/notification_count')); ?>",
			success: function (response) {
				total_pages = response.total_pages;
				if(response.count > 0){
					$('#ncount').css('visibility', 'visible');
					$('#ncount').text(response.count);
				}else{
					$('#ncount').css('visibility', 'hidden');
					$('#ncount').text(0);
				}
				/* if(page == 1){
					$('.notification_reqajax').html(response.notifications);
				}else{
					$('.notification_reqajax').append(response.notifications);
				} */
			}
		});
	}
	
	$('#notification_reqajaxtest').on('scroll', function(e) {
		
        if($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight  && total_pages > page) {
			page++;
			if(total_pages >= page){
				 $.ajax({
					type: 'POST',
					dataType: "json",
					data:{
						_token:token,
						page:page
					},
					url: "<?php echo e(URL::to('service-provider/notification_count')); ?>",
					success: function (response) {
						if(page == 1){
							$('.notification_reqajax').html(response.notifications);
						}else{
							$('.notification_reqajax').append(response.notifications);
						}
						total_pages = response.total_pages;
						$('.more_notifications').attr('rel', page);
						
					}
				});
			}
        }
    })
	
	
	$(window).scroll(function() {
		if($(window).scrollTop() + $(window).height() >= $(document).height()) {
			if($('.ajax-load').attr('rel') == 1){
				page = 1;
			}
			page++;
			$('.ajax-load').attr('rel', page);
			loadMoreData(page);
		}
	});
		
	$('.dropdown-menu').on('mouseenter', function(event){
		if($(this).hasClass('header_notification')) {
			$.ajax({
				url: "<?php echo e(url('service-provider/ajaxnotificationsread')); ?>",
				method: 'GET',
				dataType: 'json',
				success: function (data) {
					$('#ncount').css('visibility', 'hidden');
					$('#ncount').text(0);
				},
				error: function (err) {
					
				}
			});
		}
	});
	
	$('.notification-icon').on('click', function(event){
		$.ajax({
				url: "<?php echo e(url('service-provider/ajaxnotificationsread')); ?>",
				method: 'GET',
				dataType: 'json',
				success: function (data) {
					$('#ncount').css('visibility', 'hidden');
					$('#ncount').text(0);
				},
				error: function (err) {
					
				}
			});
	});
	$('.dropdown-menu').on('click', function(event){
		// The event won't be propagated up to the document NODE and 
		// therefore delegated events won't be fired
		event.stopPropagation();
	});
</script>
<?php echo $__env->yieldContent('service_js'); ?>
</body>
</html>
<?php /**PATH F:\projects\laravel\reserved4you_dev\resources\views/layouts/serviceProvider.blade.php ENDPATH**/ ?>