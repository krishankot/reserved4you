<div class="row" id="transport_div<?php echo e($i); ?>">
	<?php if($i > 1): ?>
		<div class="col-12">
			<div class="form-group mb-1">
				<label class="iconlabel">
					<div class="d-flex align-items-center">
						<a class="btn btn-remove-icon d-flex align-items-center remove_transportation ml-auto" rel="<?php echo e($i); ?>" href="javascript:void(0);"><span><i class="fa fa-times"></span></i>&nbsp;<?php echo e(__('Delete')); ?></a>
					</div>
				</label>
			</div>
		</div>
	<?php endif; ?>
	<div class="col-lg-6">
		<div class="form-group">
			<label class="iconlabel">
				<div class="d-flex align-items-center">
					<img src="<?php echo e(asset('storage/app/public/asset_request/images/icons/SVG/awesome-stop-circle.svg')); ?>" alt="">
					<span><?php echo e(__('Next stop')); ?></span>
				</div>
			</label>
			<?php echo e(Form::text('transportations['.$i.'][title]',NULL,array('class'=>'storname contact','autocomplete'=>'off','placeholder'=>__('Next stop')))); ?>

			<span id="next_stop<?php echo e($i); ?>" class="text-danger"></span>
		</div>
	</div>
	<div class="col-lg-6">
		<div class="form-group">
			<label class="iconlabel">
				<div class="d-flex align-items-center">
					<img src="<?php echo e(asset('storage/app/public/asset_request/images/icons/SVG/ionic-ios-bus.svg')); ?>" alt="">
					<span><?php echo e(__('Bus or train line')); ?></span>
				</div>
			</label>
			<?php echo e(Form::text('transportations['.$i.'][transportation_no]',NULL,array('class'=>'storname contact','autocomplete'=>'off','placeholder'=>__('Bus or train line')))); ?>

			<span id="transportation_no<?php echo e($i); ?>" class="text-danger"></span>
		</div>
	</div>
</div><?php /**PATH /var/www/html/resources/views/RequestForm/transportations.blade.php ENDPATH**/ ?>