<div id="service_div{{$i}}">
	 <div class="filldetail" >
		<div class="row">
			<div class="col-lg-12">
				<div class="form-group">
					<label class="iconlabel">
						<div class="d-flex align-items-center">
							<img src="{{ asset('storage/app/public/asset_request/images/icons/SVG/Group7.svg') }}" alt="">
							<span>{{ __('Categories') }}*</span>
							@if($i > 1)
								<a class="btn btn-remove-icon d-flex align-items-center remove_service ml-auto" rel="{{ $i }}" href="javascript:void(0);"><span><i class="fa fa-times"></span></i>&nbsp;{{ ('Delete') }}</a>
							@endif
						</div>
					</label>
				   {{Form::select('service['.$i.'][category_id]',[''=>__('Select Category')] + $categories,NULL,array('data-id' => $i, 'id' => 'select'.$i, 'class'=>'select select-time category_select'))}}
					<span class="text-danger" id="errorcat{{$i}}"></span>
					
				</div>
			</div>
			<div class="col-lg-12">
				<div class="form-group">
					<label class="iconlabel">
						<div class="d-flex align-items-center">
							<img src="{{ asset('storage/app/public/asset_request/images/icons/SVG/Group7.svg') }}" alt="">
							<span>{{ __('Subcategories') }}*</span>
						</div>
					</label>
				   {{Form::select('service['.$i.'][subcategory_id]',$subcategories,NULL,array('data-id' => $i, 'id' => 'subcategories'.$i, 'class'=>'select select-time subcategory_select'))}}
					<span class="text-danger" id="errorsub{{$i}}"></span>
				</div>
			 </div>
			<div class="col-12">
				<div class="form-group">
					<label class="iconlabel">
						<div class="d-flex align-items-center">
							<img src="{{ asset('storage/app/public/asset_request/images/icons/SVG/metro-profile.svg') }}" alt="">
							<span>{{ __('Service picture') }} <small class="text-right">{{__('Max upload size 10mb')}}</small></span>
						</div>
					</label>
					<div class="image-box" rel="imgUpload{{$i}}" id="image_drop_area{{$i}}">
						<div class="customer-image">
							<img id="image_imgUpload{{$i}}" src="{{ asset('storage/app/public/asset_request/images/icons/PNG/Group30.png') }}">
						</div>
						<label id="file_name{{$i}}" for="imgUpload{{$i}}" class="d-flex align-items-center" >
							<p class="ml-20 mr-5">{{-- Drag & Drop the image file or --}}</p>
							@php $imageID = 'imgUpload'.$i; @endphp
							{{ Form::hidden('service['.$i.'][imagename]', NULL) }}
							<input id="imgUpload{{$i}}" type="file" name="service[{{$i}}][image]" accept=".jpg,.jpeg,.png,.gif, .bmp, .ico, .tiff, .svg,.webp" onchange="loadFile(event, '{{ $imageID }}')">
							<span class="btn btn-pink btn-photo ml-5">{{ __('Upload file here') }}</span>
						</label>
					</div>
				</div>
			</div>
			<div class="col-lg-12">
				<div class="form-group">
					<label class="iconlabel">
						<div class="d-flex align-items-center">
							<img src="{{ asset('storage/app/public/asset_request/images/icons/SVG/Group10.svg') }}" alt="">
							<span>{{ __('Main Service name') }}*</span>
						</div>
					</label>
					{{ Form::text('service['.$i.'][service_name]', NULL, array("placeholder" => __('Main Service name'), "autocomplete" => "off",  "class" => "storname contact mainservice")) }}
					<span class="text-danger"></span>
				</div>
			</div>
			<div class="col-lg-12">
				<div class="form-group">
					<label class="iconlabel">
						<div class="d-flex align-items-center">
							<img src="{{ asset('storage/app/public/asset_request/images/icons/SVG/open-document.svg') }}" alt="">
							<span>{{ __('Description') }}*</span>
						</div>
					</label>
					{{ Form::textarea('service['.$i.'][description]', NULL, array("placeholder" => __('Description'), "rows" => "6", "class" => "description")) }}
					<span class="text-danger"></span>
				</div>
			</div>
			<?php /* <div class="col-lg-12">
				<div class="form-group">
					<label class="iconlabel">
						<div class="d-flex align-items-center">
							<img src="{{ asset('storage/app/public/asset_request/images/icons/SVG/awesome-percent.svg') }}" alt="">
							<span>Discount*</span>
						</div>
					</label>
					<input type="text" name="storename" placeholder="Discount" autocomplete="off" class="storname contact">
					<span class="text-danger"></span>
				</div>
			</div> */ ?>
		</div>
	</div>

	<div class="filldetail mt-5">
		<div class="row">
			<div class="col-12">
				<ul class="nav nav-pills customtabs" id="pills-tab" role="tablist">
					<li class="nav-item aaf" role="presentation">
						<a class="nav-link monthlyplan active" at="Monthly" id="pills-home-tab{{$i}}" data-toggle="pill" href="#pills-home{{$i}}" role="tab" aria-controls="pills-home{{$i}}" aria-selected="true">{{ __('Main Service') }}</a>
					</li>

					<li class="nav-item aaf" role="presentation">
						<a name="plan" class="nav-link monthlyplan" at="Annually" id="pills-profile-tab{{$i}}" data-toggle="pill" href="#pills-profile{{$i}}" role="tab" aria-controls="pills-profile{{$i}}" aria-selected="false">{{ __('Service with category') }}</a>
					</li>
				</ul>
			</div>
		</div>
		<div class="tab-content" id="pills-tabContent">
			<div class="tab-pane fade active show" id="pills-home{{$i}}" role="tabpanel" aria-labelledby="pills-home-tab{{$i}}">
				<div class="col-lg-12">
					<div class="form-group">
						<label class="iconlabel">
							<div class="d-flex align-items-center">
								<img src="{{ asset('storage/app/public/asset_request/images/icons/SVG/awesome-dollar-sign.svg') }}" alt="">
								<span>{{ __('Price') }}*</span>
							</div>
						</label>
						{{ Form::text('service['.$i.'][price]', NULL, array("placeholder" => __('Price')." (€)", "autocomplete" => "off",  "class" => "storname contact price")) }}
						<span class="text-danger"></span>
					</div>
				</div>
				<div class="col-lg-12">
					<div class="form-group">
						<label class="iconlabel">
							<div class="d-flex align-items-center">
								<img src="{{ asset('storage/app/public/asset_request/images/icons/SVG/ionic-ios-clock.svg') }}" alt="">
								<span>{{ __('Duration') }}*</span>
							</div>
						</label>
						{{ Form::text('service['.$i.'][duration_of_service]', NULL, array("placeholder" => __('Duration')." (min)", "autocomplete" => "off",  "class" => "storname contact duration_of_service")) }}
						<span class="text-danger"></span>
					</div>
				</div>
			</div>
			<div class="tab-pane fade" id="pills-profile{{$i}}" role="tabpanel" aria-labelledby="pills-profile-tab{{$i}}">
				<div class="w-100 text-right mb-2">
					<a class="btn btn-add-icon text-right add_subservices" data-id="{{$i}}" rel="{{ !empty($dataRequest['service'][$i]['sub_service'])?max(array_keys($dataRequest['service'][$i]['sub_service'])):1 }}" href="javascript:void(0);"><i class="fa fa-plus"></i>&nbsp;&nbsp;{{ __('Add Sub Service') }}</a>
				</div>
				<div id="div_subservices{{$i}}">
					@if(!empty($dataRequest['service'][$i]['sub_service']))
						@foreach($dataRequest['service'][$i]['sub_service'] as $s=>$item)
							@include('RequestForm/subservices', ['i' =>$i, 's' => $s])
						@endforeach
					@else
						@include('RequestForm/subservices', ['i' =>$i, 's' => 1])
					@endif
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	var i = "{{$i}}";
	$(document).ready(function() {
		$('#select'+i).niceSelect();
		$('#subcategories'+i).niceSelect();
		
	
		 $('body').on('change', '.category_select', function () {
			var id = $(this).data('id');
			 var category_id = $(this).val();
			changeSubCategory(category_id, id,"");
		});
	});
	
	
/* 				
	vars['image_drop_area'+i] = document.querySelector("#image_drop_area"+i);
	uploaded_imageN['uploaded_imageN'+i];
    img_relN['img_relN'+i];
	// Event listener for dragging the image over the div
	vars['image_drop_area'+i].addEventListener('dragover', (event) => {
	  event.stopPropagation();
	  event.preventDefault();
	  // Style the drag-and-drop as a "copy file" operation.
	  event.dataTransfer.dropEffect = 'copy';
	});

// Event listener for dropping the image inside the div
vars['image_drop_area'+i].addEventListener('drop', (event) => {
	var img_id = event.target.id;
	img_relN['img_relN'+i] = $('#'+img_id).attr('rel');
	
  event.stopPropagation();
  event.preventDefault();
  fileList = event.dataTransfer.files;

  //document.querySelector("#file_name").textContent = fileList[0].name;
  
  readImageN(fileList[0]);
});

// Converts the image into a data URI
readImageN = (file) => {
  const reader = new FileReader();
  reader.addEventListener('load', (event) => {
	 
    uploaded_imageN['uploaded_imageN'+i] = event.target.result;
    //document.querySelector(".customer-image").style.backgroundImage = `url(${uploaded_image})`;
	var image_url = `url(${uploaded_imageN['uploaded_imageN'+i]})`;
	
	$("#image_"+img_relN['img_relN'+i]).attr('src', uploaded_imageN['uploaded_imageN'+i]);
  });
  reader.readAsDataURL(file);
} */
</script>