<div class="row" id="advantage_div{{$i}}">
	<div class="col-lg-12">
		<div class="form-group">
			<label class="iconlabel">
				<div class="d-flex align-items-center">
					<img src="{{ asset('storage/app/public/asset_request/images/icons/SVG/open-person.svg') }}" alt="">
					<span>{{ __('Name') }}</span>
					<a class="btn btn-remove-icon d-flex align-items-center remove_advantages ml-auto" rel="{{ $i }}" href="javascript:void(0);"><span><i class="fa fa-times"></span></i>&nbsp;{{ __('Delete') }}</a>
				</div>
			</label>
			{{Form::text('advantages['.$i.'][title]',NULL,array('class'=>'storname contact','autocomplete'=>'off','placeholder'=>__('Name')))}}
			<span id="advantage_name{{$i}}" class="text-danger"></span>
		</div>
	</div>
	<div class="col-lg-12">
		<div class="form-group">
			<label class="iconlabel">
				<div class="d-flex align-items-center">
					<img src="{{ asset('storage/app/public/asset_request/images/icons/SVG/open-document.svg') }}" alt="">
					<span>{{ __('Description') }}</span>
				</div>
			</label>
			{{Form::textarea('advantages['.$i.'][description]',NULL,array('rows'=>'6','placeholder'=> __('Description')))}}
		</div>
	</div>
</div>