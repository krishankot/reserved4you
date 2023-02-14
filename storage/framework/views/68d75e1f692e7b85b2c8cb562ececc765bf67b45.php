<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" translate="no">
<head>
    <title>Contact Details</title>
    <link type="image/x-icon" rel="shortcut icon"
          href="<?php echo e(asset('storage/app/public/asset_request/images/favicon.png')); ?>"/>
    <meta charset="UTF-8"/>
    <meta name="HandheldFriendly" content="true">
	<meta name="google" content="notranslate"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link type="text/css" rel="stylesheet" href="<?php echo e(asset('storage/app/public/asset_request/css/all.min.css')); ?>"/>
    <link type="text/css" rel="stylesheet" href="<?php echo e(asset('storage/app/public/asset_request/fonts/stylesheet.css')); ?>"/>
    <link type="text/css" rel="stylesheet" href="<?php echo e(asset('storage/app/public/asset_request/css/owl.carousel.min.css')); ?>">
    <link type="text/css" rel="stylesheet" href="<?php echo e(asset('storage/app/public/asset_request/css/bootstrap.min.css')); ?>"/>
	<link type="text/css" rel="stylesheet" href="<?php echo e(asset('storage/app/public/Serviceassets/css/nice-select.css')); ?>" />
	<link type="text/css" rel="stylesheet" href="<?php echo e(asset('storage/app/public/Serviceassets/css/timepicker.css')); ?>" />
	<link type="text/css" rel="stylesheet" href="<?php echo e(asset('storage/app/public/Serviceassets/css/select2.min.css')); ?>" />
    <link type="text/css" rel="stylesheet" href="<?php echo e(asset('storage/app/public/asset_request/css/intlTelInput.css')); ?>"/>
    <link type="text/css" rel="stylesheet" href="<?php echo e(asset('storage/app/public/asset_request/css/bootstrap-datepicker.css')); ?>"/>
	<link type="text/css" rel="stylesheet" href="<?php echo e(asset('storage/app/public/asset_request/css/bootstrap-datetimepicker.css')); ?>"/>
    <link type="text/css" rel="stylesheet" href="<?php echo e(asset('storage/app/public/asset_request/css/styles3.css')); ?>"/>
	
	
	
    <link type="text/css" rel="stylesheet" href="<?php echo e(asset('storage/app/public/asset_request/css/responsive.css')); ?>"/>
	<script src="<?php echo e(asset('storage/app/public/asset_request/js/jquery.min.js')); ?>"></script>
	<script src="<?php echo e(URL::to('public/js/disable.js')); ?>"></script>
	
	<script>
		var token = '<?php echo e(csrf_token()); ?>';
		var vars = {};
		var uploaded_imageN = {};
		var autocomplete = {};
		var img_relN = {};
	</script>
	<style>
    button.letscontinues {
        background-color: #101928;
        padding: 19px 82px;
        font-size: 20px;
        color: #FABA5F;
        border-radius: 20px;
        border: none;
    }

    button.letscontinues:hover {
        background-color: transparent;
        color: #101928;
        box-shadow: 0 0 0 2px #101928;
    }
</style>
</head>

<body>
<header>
    <nav class="navbar navbar-expand-lg logo">
        <div class="container">
            <a class="navbar-brand " href="<?php echo e(URL::to('/')); ?>">
                <img src="<?php echo e(asset('storage/app/public/asset_request/images/logo.png')); ?>" alt="logo">
            </a>
            <div class="contractheading">
                <p>Anforderungsformular <span>Reserved4you</span>
                </p>
            </div>
        </div>
    </nav>
</header>
<?php echo $__env->yieldContent('request_content'); ?>


<script src="<?php echo e(asset('storage/app/public/asset_request/js/bootstrap.bundle.min.js')); ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="<?php echo e(asset('storage/app/public/asset_request/js/owl.carousel.min.js')); ?>"></script>
<script src="<?php echo e(asset('storage/app/public/asset_request/js/bootstrap-datepicker.min.js')); ?>"></script>
<script src="<?php echo e(asset('storage/app/public/asset_request/js/bootstrap-datepicker-de.min.js')); ?>"></script>
<script src="<?php echo e(asset('storage/app/public/asset_request/js/utils.js')); ?>"></script>
<script src="<?php echo e(asset('storage/app/public/Serviceassets/js/jquery.nice-select.min.js')); ?>"></script>
<script src="<?php echo e(asset('storage/app/public/Serviceassets/js/timepicker.js')); ?>"></script>
<script src="<?php echo e(asset('storage/app/public/Serviceassets/js/select2.min.js')); ?>"></script>
<script src="<?php echo e(asset('storage/app/public/asset_request/js/intlTelInput.js')); ?>"></script>
<script src="https://momentjs.com/downloads/moment-with-locales.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="<?php echo e(asset('storage/app/public/asset_request/js/custom3.js')); ?>"></script>
<script src="<?php echo e(asset('storage/app/public/asset_request/js/moment.js')); ?>"></script>
<script src="<?php echo e(asset('storage/app/public/asset_request/js/bootstrap-datetimepicker.min.js')); ?>"></script>
<script>
    $("#input").intlTelInput({
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/8.4.6/js/utils.js"
    });
	
</script>


<script>
	$('.start_time').datetimepicker({format: 'HH:mm', icons: {up: 'fa fa-angle-up', down: 'fa fa-angle-down'} }).on('dp.hide',function(e){
			var id = $(this).data('id');
			var formatedValue = e.date.format('HH:mm');
			startTime(formatedValue,id);
		});
			
			
		$('.end_time').datetimepicker({format: 'HH:mm',  icons: {up: 'fa fa-angle-up', down: 'fa fa-angle-down'} }).on('dp.hide',function(e){
			var id = $(this).data('id');
			var formatedValue = e.date.format('HH:mm');
			endTime(formatedValue,id);
		});
	$(document).ready(function() {
		$('.select').niceSelect();
		
		 $('body').on('click', '.weekdays', function () {
            var id = $(this).data('id');
            if ($(this).prop('checked') == true) {
                $('.start_time[data-id=' + id + ']').css('pointer-events', 'none');
                $('.start_time[data-id=' + id + ']').attr('readonly', true);
                $('.start_time[data-id=' + id + ']').val('');
                $('.end_time[data-id=' + id + ']').css('pointer-events', 'none');
                $('.end_time[data-id=' + id + ']').attr('readonly', true);
                $('.end_time[data-id=' + id + ']').val(''); 
				$('.start_time[data-id=' + id + ']').css('border-color', "hsl(218deg 43% 11% / 20%)");
				$('.end_time[data-id=' + id + ']').css('border-color', "hsl(218deg 43% 11% / 20%)");
            } else {
                $('.start_time[data-id=' + id + ']').css('pointer-events', 'all');
                $('.start_time[data-id=' + id + ']').attr('readonly', false);
                $('.end_time[data-id=' + id + ']').css('pointer-events', 'all');
                $('.end_time[data-id=' + id + ']').attr('readonly', false);
                $('.start_time[data-id=' + id + ']').val('10:00');
                $('.end_time[data-id=' + id + ']').val('20:00');
            }
        });
		
	});
	function startTime(time,id){
    	var end = $('.end_time[data-id='+id+']').val();
    	
    	if(end != ''){
    		var newtime = moment.utc(end,'HH:mm').subtract(30,'minutes').format('HH:mm');
   
			if(newtime < time){
				$('.start_time[data-id='+id+']').val('');
				swal("Alert!", "<?php echo e(__('Invalid Time, Please Use Small Time')); ?>", "error");
			}else{
				$('.start_time[data-id=' + id + ']').css('border-color', "hsl(218deg 43% 11% / 20%)");
			} 
    	}else{
			$('.start_time[data-id=' + id + ']').css('border-color', "hsl(218deg 43% 11% / 20%)");
		} 
    	
    }
    function endTime(time,id){
    	
    	var start = $('.start_time[data-id='+id+']').val();

    	if(start != ''){
			var newtime = moment.utc(start,'HH:mm').add(30,'minutes').format('HH:mm');
			
			if(newtime > time){
				$('.end_time[data-id='+id+']').val('');
				swal("Alert!", "<?php echo e(__('Invalid Time, Please Use Big Time')); ?>", "error");
			}else{
				$('.end_time[data-id=' + id + ']').css('border-color', "hsl(218deg 43% 11% / 20%)");
			} 
		}else{
				$('.end_time[data-id=' + id + ']').css('border-color', "hsl(218deg 43% 11% / 20%)");
			} 
    	
    }
</script>


<script
    src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyBSItHxCbk9qBcXp1XTysVLYcJick5K8mU "></script>

<script>
	$(document).ready(function() {
		$('.select2').select2();
	});
	
	var loadFileExcel = function (event, id) {
		var reader = new FileReader();
		var filesize = event.target.files[0].size;
		var sizeInMB = (filesize / (1024*1024)).toFixed(2);
		if(sizeInMB > 10){
			swal("Alert!", "<?php echo e(__('Maximum allowed file size is 10 MB')); ?>", "error");
			$('#'+id).val("");
			$('#xlx_'+id).html('');
			return false;
		}
		var output = document.getElementById('xlx_'+id);
		output.innerHTML = event.target.files[0].name + '<a href="javascript:void(0);" class="remove_xlx ml-2" id="remove_xlx_'+id+'" rel="'+id+'"><i class="fa fa-times-circle"></i></a>';
	};
	$('body').on('click', '.remove_xlx', function(){
		var rxlid = $(this).attr('rel');
		$('#xlx_'+rxlid).html('');
		$('#'+rxlid).val("");
	});
		
	var autocompletesWraps = ['id_address','cus_address','id_address1','id_address2','id_address3'];
    function initialize() {
		
		$.each(autocompletesWraps, function(index, name) {
			var input = document.getElementById(name);
			var options = {
				types: ['address'],
				componentRestrictions: {
					country: 'DE'
				}
			};
			autocomplete[name] = new google.maps.places.Autocomplete(input, options);
			google.maps.event.addListener(autocomplete[name], 'place_changed', function () {
				var place = autocomplete[name].getPlace();
				for (var i = 0; i < place.address_components.length; i++) {
					for (var j = 0; j < place.address_components[i].types.length; j++) {
						if (place.address_components[i].types[j] == "postal_code") {
							document.getElementById('zipcode'+name).value = place.address_components[i].long_name;

						}
					}
				}
			});
		});
    }
	
   google.maps.event.addDomListener(window, "load", initialize);
</script>
<!-- Start of LiveChat (www.livechatinc.com) code -->
<script>
    window.__lc = window.__lc || {};
    window.__lc.license = 13059087;
    ;(function(n,t,c){function i(n){return e._h?e._h.apply(null,n):e._q.push(n)}var e={_q:[],_h:null,_v:"2.0",on:function(){i(["on",c.call(arguments)])},once:function(){i(["once",c.call(arguments)])},off:function(){i(["off",c.call(arguments)])},get:function(){if(!e._h)throw new Error("[LiveChatWidget] You can't use getters before load.");return  i(["get",c.call(arguments)])},call:function(){i(["call",c.call(arguments)])},init:function(){var n=t.createElement("script");n.async=!0,n.type="text/javascript",n.src="https://cdn.livechatinc.com/tracking.js",t.head.appendChild(n)}};! n.__lc.asyncInit&&e.init(),n.LiveChatWidget=n.LiveChatWidget||e}(window,document,[].slice))
</script>
<noscript><a href="https://www.livechatinc.com/chat-with/13059087/" rel="nofollow">Chat withus</a>, powered by <a href="https://www.livechatinc.com/?welcome" rel="noopener nofollow" target="_blank">LiveChat</a></noscript>
<!-- End of LiveChat code -->
</body>

</html><?php /**PATH F:\projects\laravel\reserved4you_dev\resources\views/layouts/request.blade.php ENDPATH**/ ?>