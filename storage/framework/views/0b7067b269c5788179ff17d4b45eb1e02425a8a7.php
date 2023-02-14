<?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php if($row->type == 'appointment'): ?>
		<?php
			if(strpos($row->title, 'Neue Buchung') !== false){
				$appointmentDetails = \BaseFunction::getAppointmentData($row->appointment_id);
			}else{
				$appointmentDetails = \BaseFunction::getAppointmentDataByID($row->appointment_id);
			}
		?>
		<?php $__currentLoopData = $appointmentDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointmentDetail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>    
			<a href="javascript:void(0);" onclick="getAppointmentDetails(<?php echo $appointmentDetail->id; ?>);">
				<div class="notification-item">
					<div class="noti-heading-wrap">
					   <?php /* <h5 class="{{ (strpos($row->title, 'Termin') === false)?((strpos($row->title, 'Reschedule') !== false)?'text-warning':'text-info'):'' }}">{{$row->title}}</h5> */ ?>
						<h5 class="<?php echo e((strpos($row->title, 'Termin') === false)?((strpos(strtolower($row->title), 'verschoben') !== false)?'text-warning':'text-info'):''); ?>"><?php echo e($row->title); ?></h5>
						<span>- <?php echo e(\Carbon\Carbon::parse($row->created_at)->diffForHumans()); ?></span>
					</div>
					<p class="mb-0"><?php echo e($row->description); ?></p>
				</div>
			</a>
		 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	<?php elseif($row->type == 'rating'): ?>
		<a href="<?php echo e(URL::to('dienstleister/betriebsprofil?t=reviews')); ?>">
			<div class="notification-item">
				<div class="noti-heading-wrap">
					<h5 class="text-yellow"><?php echo e($row->title); ?></h5>
					<span>- <?php echo e(\Carbon\Carbon::parse($row->created_at)->diffForHumans()); ?></span>
				</div>
				<p class="mb-0"><?php echo e($row->description); ?></p>
			</div>
		</a>
	<?php elseif($row->type == 'customer_accepted' OR $row->type == 'customer_rejected'): ?>
		<?php if($row->type == 'customer_accepted'): ?>
			<a href="<?php echo e(URL::to('dienstleister/kunden-details/ansehen/'.encrypt($row->appointment_id))); ?>">
		<?php endif; ?>
		<div class="notification-item">
			<div class="noti-heading-wrap">
				<h5 class="<?php echo e($row->type == 'customer_accepted'?'text-yellow':'text-danger'); ?>"><?php echo e($row->title); ?></h5>
				<span>- <?php echo e(\Carbon\Carbon::parse($row->created_at)->diffForHumans()); ?></span>
			</div>
			<p class="mb-0"><?php echo e($row->description); ?></p>
		</div>
		<?php if($row->type == 'customer_accepted'): ?>
			</a>
		<?php endif; ?>
	<?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php /**PATH F:\projects\laravel\reserved4you_dev\resources\views/Includes/Service/notificationinner.blade.php ENDPATH**/ ?>