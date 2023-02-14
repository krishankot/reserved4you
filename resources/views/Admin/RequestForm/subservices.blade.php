<div class="subservice-box mt-2 position-relative">
	
	<div class="row">
		<div class="col-lg-12">
			<div class="form-group">
				<label class="iconlabel">
					<div class="d-flex align-items-center">
						<img src="{{ asset('storage/app/public/asset_request/images/icons/SVG/metro-profile.svg') }}" alt="">
						<span>{{ __('Name of Subservice') }}</span>
					</div>
				</label>
				{{ Form::text('service['.$i.'][sub_service]['.$s.'][subservice]', NULL, array("placeholder" => __('Name of Subservice'), "autocomplete" => "off",  "class" => "storname contact subservice")) }}
				<span class="text-danger"></span>
			</div>
		</div>
		<div class="col-lg-12">
			<div class="form-group">
				<label class="iconlabel">
					<div class="d-flex align-items-center">
						<img src="{{ asset('storage/app/public/asset_request/images/icons/SVG/awesome-dollar-sign.svg') }}" alt="">
						<span>{{ __('Price') }}</span>
					</div>
				</label>
				{{ Form::text('service['.$i.'][sub_service]['.$s.'][price_subservice]', NULL, array("placeholder" => __('Price')." (€)", "autocomplete" => "off",  "class" => "storname contact price_subservice")) }}
				<span class="text-danger"></span>
			</div>
		</div>
		<div class="col-lg-12">
			<div class="form-group">
				<label class="iconlabel">
					<div class="d-flex align-items-center">
						<img src="{{ asset('storage/app/public/asset_request/images/icons/SVG/ionic-ios-clock.svg') }}" alt="">
						<span>{{ __('Duration') }}</span>
					</div>
				</label>
				{{ Form::text('service['.$i.'][sub_service]['.$s.'][duration_subservice]', NULL, array("placeholder" => __('Duration')." (min)", "autocomplete" => "off",  "class" => "storname contact duration_subservice")) }}
				<span class="text-danger"></span>
			</div>
		</div>
	</div>
</div>