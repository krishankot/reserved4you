<style>
	.notification_reqajax .notification-item{padding:15px;border:1px solid #A9A9A9;}
	.notification_reqajax .notification-item p{margin-bottom:15px;}
	.notification_reqajax .noti-heading-wrap h5{font-size:18px;}
	
	 .text-red {
		color: #e82929;
	}

	.employee{
		cursor: pointer!important;
	}
	.fc-timegrid-slot{
		height: 2em!important;
	}
	.f11{
		font-size: 11px!important;
	}
	.opacity{
		opacity: .5;
	}
	.fc-license-message{
		display: none!important;
	}
	.fc-timegrid-col-frame {
		background: #FFF !important;
		border: none !important;
		border-top: 1px solid #ddd !important;
		font-weight: bold;
	}
	.slick-active{
		cursor: pointer;
	}
	.fc-toolbar-title{
		float: right!important;
		padding-top: 6px!important;
		font-size: 1.4em!important;
	}
	.fc-daygrid-dot-event .fc-event-title{
		font-weight: 500!important;
	}
	.fc-myCustomButton-button.fc-button{
		background: #FABA5F!important;
		color: white!important;
	}
	.prev.slick-arrow{
		z-index: 9;
	}
	.slick-arrow .fc-icon{
		margin-top: 4px!important;
	}
	.slick-arrow{
		position: absolute;
		top: 30px;
		border: 1px solid transparent;
		padding: .4em .65em;
		font-size: 1em;
		line-height: 1.5;
		border-radius: 50%!important;
		background: white!important;
		box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
	}
	.next.slick-arrow{
		right: 0px;
	}
	.fc-button-primary{
		color:black!important;
		background: white!important;
		border: white!important;
		padding-left: 16px!important;
		padding-right: 16px!important;
	}
	.fc-button-primary.fc-button-active{
		color: #fff!important;
		background-color: black!important;
		background-image: none;
		border-radius: 8px!important;
		box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;

	}
	.fc .fc-toolbar.fc-header-toolbar{
		margin-bottom: 113px!important;
	}
	.border-warning .fc-event-main{
		border-left: 2px solid yellow;
	}
	.border-primary .fc-event-main{
		border-left: 2px solid blue;
	}
	.fc-event-main{
		text-align: justify!important;
		padding: 0px 0px 0px 6px!important;

		white-space: unset!important;
	}
	.fc-toolbar.fc-header-toolbar{
		background-color: #FFF4EE!important;
		padding: 11px 4px!important;
		border-radius: 5px;
	}
	.cancel{
		background-color: #FFD8E5!important;
		border: #FFD8E5!important;
	}
	.cancel .fc-event-main{
		border-left: 2px solid #F685AA;
	}
	.cancel-border{
		border:2px solid  #F685AA!important;
	}
	.cancel .bg-white.text-dark{
		background: #FF4646!important;
		color: white!important;
	}
	.booked{
		background-color: #EEEBFF!important;
		border: #EEEBFF!important;
	}
	.booked-border{
		border:2px solid  #5bc9ff!important;
	}
	.booked .fc-event-main{
		border-left: 2px solid #5bc9ff;
	}
	.booked .bg-white.text-dark{
		background: white!important;
		color: #5bc9ff!important;
	}
	 .reschedule{
            background-color: #fcf8e3 !important;
            border: #faebcc !important;
        }
        .reschedule-border{
            border:2px solid  #faebcc !important;
        }
        .reschedule .fc-event-main{
            border-left: 2px solid #faebcc;
        }
	.reschedule .bg-white.text-dark{
            background: white!important;
            color: #ffc107 !important;
        }

	.working-time{
		color: #DB8B8B!important;
	}


	.completed{
		background-color: #D6F6D6!important;
		border: #D6F6D6!important;;
	}
	.completed .fc-event-main{
		border-left: 2px solid #56C156;
	}
	.completed-border{
		border:2px solid  #56C156!important;
	}
	.completed .bg-white.text-dark{
		background: white!important;
		color: #56C156!important;
	}

	.pending{
		background-color: #CEEFFF!important;
		border: #CEEFFF!important;;
	}
	.pending-border{
		border:2px solid #5BC9FF!important;
	}
	.pending .fc-event-main{
		border-left: 2px solid #5BC9FF;
	}
	.pending .bg-white.text-dark{
		background: white!important;
		color: #5BC9FF!important;
	}

	.running{
		background-color: #FDE3BF!important;
		border: #D6F6D6!important;;
	}
	.running-border{
		border:2px solid  #FABA5F!important;
	}
	.running .fc-event-main{
		border-left: 2px solid #FABA5F;
	}
	.running .bg-white.text-dark{
		background: white!important;
		color: #FABA5F!important;
	}

	#ncount{
		position: absolute; left: -20px; font-size: 16px; visibility: hidden;
	}
	@media  only screen and (max-width:1198px) {
		#ncount{
			position: absolute; left: -6px; font-size: 12px; visibility: hidden;
		}
	}
</style>
<div class="position-relative">
	<a href="javascript:void(0);"  class="notification-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		<div class="notification-area">
			 <img src="<?php echo e(URL::to('storage/app/public/Serviceassets/images/icon/notification-light.svg')); ?>" alt="">
			<span class="badge badge-dark" id="ncount" style="">0</span>
		</div>
	</a>
	<div class="dropdown-menu dropdown-menu-right position-absolute header_notification" style="max-width:425px;padding:15px;border-radius:10px;background:#F9F9FB;border:1px solid #E8E8EC;">
		<div class=" row">
			<div class="col-md-12 mb-3"><h5>Notifications</h5></div>
			<div class="col-md-12" id="notification_reqajaxtest" style="max-height:350px;overflow-y:auto;">
				<div class="notification_reqajax">
					<?php $notifications = \BaseFunction::getNotifications(); ?>
					<?php echo $__env->make('Includes.Service.notificationinner', ['notifications' => $notifications], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				</div>
			</div>
			<div class="more_notifications" rel="1"></div>
			<div class="col-md-12 mt-2 text-center"><a href="<?php echo url('dienstleister/benachrichtigungen'); ?>">See all notifications</a></div>
		</div>
	</div>								
</div>	
<div class="modal fade bd-example-modal-lg" id="myModalNotification" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-centered">
		<div class="modal-content modal-body pt-0 pb-0">

		</div>
	</div>
</div><?php /**PATH F:\projects\laravel\reserved4you_dev\resources\views/Includes/Service/notificationpopup.blade.php ENDPATH**/ ?>