<div class="row" id="advantage_div<?php echo e($i); ?>">
	<div class="col-lg-12">
		<div class="form-group">
			<label class="iconlabel">
				<div class="d-flex align-items-center">
					<img src="<?php echo e(asset('storage/app/public/asset_request/images/icons/SVG/open-person.svg')); ?>" alt="">
					<span><?php echo e(__('Name')); ?></span>
					<a class="btn btn-remove-icon d-flex align-items-center remove_advantages ml-auto" rel="<?php echo e($i); ?>" href="javascript:void(0);"><span><i class="fa fa-times"></span></i>&nbsp;<?php echo e(__('Delete')); ?></a>
				</div>
			</label>
			<?php echo e(Form::text('advantages['.$i.'][title]',NULL,array('class'=>'storname contact','autocomplete'=>'off','placeholder'=>__('Name')))); ?>

			<span id="advantage_name<?php echo e($i); ?>" class="text-danger"></span>
		</div>
	</div>
	<div class="col-lg-12">
		<div class="form-group">
			<label class="iconlabel">
				<div class="d-flex align-items-center">
					<img src="<?php echo e(asset('storage/app/public/asset_request/images/icons/SVG/open-document.svg')); ?>" alt="">
					<span><?php echo e(__('Description')); ?></span>
				</div>
			</label>
			<?php echo e(Form::textarea('advantages['.$i.'][description]',NULL,array('rows'=>'6','placeholder'=> __('Description')))); ?>

		</div>
	</div>
</div><?php /**PATH F:\projects\laravel\reserved4you_dev\resources\views/RequestForm/advantages.blade.php ENDPATH**/ ?>