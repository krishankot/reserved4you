<div class="row" id="transport_div{{$i}}">
	@if($i > 1)
		<div class="col-12">
			<div class="form-group mb-1">
				<label class="iconlabel">
					<div class="d-flex align-items-center">
						<a class="btn btn-remove-icon d-flex align-items-center remove_transportation ml-auto" rel="{{ $i }}" href="javascript:void(0);"><span><i class="fa fa-times"></span></i>&nbsp;{{ __('Delete') }}</a>
					</div>
				</label>
			</div>
		</div>
	@endif
	<div class="col-lg-6">
		<div class="form-group">
			<label class="iconlabel">
				<div class="d-flex align-items-center">
					<img src="{{ asset('storage/app/public/asset_request/images/icons/SVG/awesome-stop-circle.svg') }}" alt="">
					<span>{{ __('Next stop') }}</span>
				</div>
			</label>
			{{Form::text('transportations['.$i.'][title]',NULL,array('class'=>'storname contact','autocomplete'=>'off','placeholder'=>__('Next stop')))}}
			<span id="next_stop{{$i}}" class="text-danger"></span>
		</div>
	</div>
	<div class="col-lg-6">
		<div class="form-group">
			<label class="iconlabel">
				<div class="d-flex align-items-center">
					<img src="{{ asset('storage/app/public/asset_request/images/icons/SVG/ionic-ios-bus.svg') }}" alt="">
					<span>{{ __('Bus or train line') }}</span>
				</div>
			</label>
			{{Form::text('transportations['.$i.'][transportation_no]',NULL,array('class'=>'storname contact','autocomplete'=>'off','placeholder'=>__('Bus or train line')))}}
			<span id="transportation_no{{$i}}" class="text-danger"></span>
		</div>
	</div>
</div>