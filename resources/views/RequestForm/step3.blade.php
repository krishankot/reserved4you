@extends('layouts.request')

@section('request_content')
@php $filesize = 0; @endphp
<section class="contactdetail">
    <div class="progress">
        <div class="progress-bar progressbarr4u" role="progressbar" style="width: 60%;" aria-valuenow="25"
             aria-valuemin="0" aria-valuemax="100"></div>
    </div>
    <div class="container">
        <div class="contactheading">
            <h2>{{ __('Portfolio') }}</h2>
        </div>
		{{Form::model($dataRequest, array('url'=>'anforderungsformular/3','method'=>'post','name'=>'myform', 'files'=>'true', 'id' => "myform3"))}}
            @csrf
            <div class="filldetail">
				<div class="row">
					<div class="col-12">
						<div class="form-group">
							<label class="iconlabel">
								<div class="d-flex align-items-center">
									<img src="{{ asset('storage/app/public/asset_request/images/icons/SVG/open-person.svg') }}" alt="">
									<span>{{ __('Profile picture') }} <small class="text-right w-100">{{__('Max upload size 10mb')}}</small></span>
								</div>
							</label>
							<div class="image-box" id="image_drop_area">
								<div class="customer-image">
									<img id="image_imgUpload" src="{{ asset('storage/app/public/asset_request/images/icons/PNG/Group30.png') }}">
								</div>
								<label id="file_name" for="imgUpload" class="d-flex align-items-center" >
									<p class="ml-20 mr-5">{{-- Drag & Drop the image file or --}}</p>
									{{ Form::hidden('profile_picture_name', NULL, array("id" => "profile_picture_name")) }}
									<input id="imgUpload" type="file" name="profile_picture" accept=".jpg,.jpeg,.png,.gif, .bmp, .ico, .tiff, .svg,.webp" onchange="loadFile(event, 'imgUpload')">
									<span class="btn btn-pink btn-photo ml-5">{{ __('Upload file here') }}</span>
								</label>
							</div>
						</div>
					</div>
					
					<div class="col-12">
						<div class="form-group">
							<label class="iconlabel">
								<div class="d-flex align-items-center">
									<img src="{{ asset('storage/app/public/asset_request/images/icons/SVG/vac.svg') }}" alt="">
									<span>{{ __('Banner picture') }}</span>
									<small class="text-right">{{__('Max upload size 10mb')}}</small>
								</div>
							</label>
							<div class="image-box" id="banner_img_area">
								<div class="customer-image">
									<img id="image_imgBannerImage" src="{{ asset('storage/app/public/asset_request/images/icons/PNG/Group30.png') }}">
								</div>
								<label id="file_namebanner" for="imgBannerImage" class="d-flex align-items-center" >
									<p class="ml-20 mr-5">{{-- Drag & Drop the image file or --}}</p>
									{{ Form::hidden('banner_picture_name', NULL) }}
									<input id="imgBannerImage" type="file" name="banner_picture" accept=".jpg,.jpeg,.png,.gif, .bmp, .ico, .tiff, .svg,.webp" onchange="loadFile(event, 'imgBannerImage')">
									<span class="btn btn-pink btn-photo ml-5">{{ __('Upload file here') }}</span>
								</label>
							</div>
						</div>
					</div>
					
					<div class="col-12">
						<div class="form-group">
							<label class="iconlabel">
								<div class="d-flex align-items-center">
									<img src="{{ asset('storage/app/public/asset_request/images/icons/SVG/metro-profile.svg') }}" alt="">
									<span>{{ __('Porfolio picture') }} <small class="text-right">{{__('Max upload size 10mb')}}</small></span>
								</div>
							</label>
							<div class="store-service">
								<div class="field">
									<input type="file" id="files" accept=".jpg,.jpeg,.png,.gif, .bmp, .ico, .tiff, .svg,.webp" class="store_portfolio" name="portfolio_image[]" multiple />
									
									@foreach($portfolios as $row)
										@php
											$filesizeByte = filesize('storage/app/public/requestFormTemp/'.$row);
											$filesize += number_format($filesizeByte/(1024*1024), 2);
										@endphp
										<span class="pip" data-id="{{$row}}">
											<img class="imageThumb" src="{{asset('storage/app/public/requestFormTemp/'.$row)}}"><br>
											<span class="remove remove_image delete-link"  data-id="{{$row}}"></span>
										</span>
									@endforeach
									<div class="portfolio-upload-box">
										<img src="{{URL::to('storage/app/public/Serviceassets/images/icon/pulse.svg')}}" alt="">
										<h6>Neues Bild hinzufügen</h6>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<?php /* <div class="col-12">
						<div class="form-group">
							<label class="iconlabel w-100 mb-3">
								<div class="d-flex align-items-center position-relative">
									<div class="d-flex align-items-center">
										<img src="{{ asset('storage/app/public/asset_request/images/icons/SVG/metro-profile.svg') }}" alt="">
										<span>Porfolio picture</span>
									</div>
									<a class="btn btn-add-icon d-flex align-items-center text-right add_portfolio" rel="{{ !empty($dataRequest['portfolio_image'])?count($dataRequest['portfolio_image']):1 }}" href="javascript:void(0);"><span><i class="fa fa-plus"></span></i>&nbsp;&nbsp;Add</a>
								</div>
							</label>
							<div id="portimages">
								@if(!empty($dataRequest['portfolio_image']))
									@foreach($dataRequest['portfolio_image'] as $k=>$item)
										@include('RequestForm/portfolio_image', ['i' =>$k])
									@endforeach
								@else
									@include('RequestForm/portfolio_image', ['i' =>1])
								@endif
							</div>
						</div>
					</div> */ ?>
				</div>
            </div>
			
            <div class="nextprevious servicebtns letscountinuesbtn nextprevious"> 
				<a href="{{ url('anforderungsformular/2') }}" class="previous" type="btn">{{ __('Return') }}</a>
                <a href="javascript:void(0)" class="next" type="btn" onclick="plan_store()">{{ __('Continue') }}</a>
			</div>
		{{ Form::close() }}
    </div>
</section>
<script>
@if(!empty($dataRequest['profile_picture_name']))
	var imagename = "{{ $dataRequest['profile_picture_name'] }}";
	$('#image_imgUpload').attr('src', "{{ asset('storage/app/public/requestFormTemp') }}/"+imagename);
@endif
@if(!empty($dataRequest['banner_picture_name']))
	var imagename = "{{ $dataRequest['banner_picture_name'] }}";
	$('#image_imgBannerImage').attr('src', "{{ asset('storage/app/public/requestFormTemp') }}/"+imagename);
@endif

/* @if(!empty($dataRequest['portfolio_image']))
	@foreach($dataRequest['portfolio_image'] as $k=>$item)
		var id = "{{ $k }}";
		@if(!empty($item['imagename']))
			var imagename = "{{ $item['imagename'] }}";
			$('#image_imgUploadPortfolio'+id).attr('src', "{{ asset('storage/app/public/requestFormTemp') }}/"+imagename);
		@endif
	@endforeach
@endif */
var filesize = "{{ $filesize }}";
filesize  = parseFloat(filesize);
 $(document).on('change', '.store_portfolio', function (event) {
	 $form = $('#myform3');
	
	var $fileUpload = $(this);
	 //event.target.files[0].size;
	var total_files = parseInt($fileUpload.get(0).files.length);
	
	for (var i = 0; i < total_files; i++) {
         filesizeByte = event.target.files[i].size; // get file size
		 var newsize = (filesizeByte / (1024*1024)).toFixed(2);
		 filesize += parseFloat(newsize);
     }
	var sizeInMB = filesize;
	
	if(sizeInMB > 10){
		swal("Alert!", "{{__('Maximum allowed file size is 10 MB')}}", "error");
		$('store_portfolio').val('');
		return false;
	}
	
	$.ajax({  
        url: "{{ route('upload_request_portfolio') }}",
        type: "POST",  
        data: new FormData($form[0]),  
        contentType: false,  
        cache: false,  
        processData: false,  
		dataType:"json",
        success: function(data) { 
			var isallowed = 0;
			var asset_url = "{{URL::to('storage/app/public/requestFormTemp/')}}";
			$.each(data.ResponseData, function(key, value) {
				 var xhtml ='<span class="pip" data-id="'+value+'">';
					xhtml +='<input type="hidden" name="old_photo[]" value="'+value+'">';
					xhtml += '<img class="imageThumb" src="'+asset_url+'/'+value+'" /><br>';
					xhtml += '<span class="remove remove_image delete-link"  data-id="'+value+'"></span>';
					xhtml += '</span>';
					$('.field').append(xhtml);
			});
			
			//$form[0].reset();  
			$('store_portfolio').val('');
        },  
        error: function() {}
    }); 
 }); 
	
$('body').on('click', '.remove_image', function(){
	var image = $(this).data('id');
	
	$.ajax({
		type: 'POST',
		url: '{{ route("remove_req_portfolio") }}',
		data: {
			_token: token,
			image:image
		},
		success: function (response) {
			filesize -= parseFloat(response.ResponseData);
			$(".pip[data-id='"+image+"']").remove();
		}
	});
});
	
$('body').on('click', '.add_portfolio', function(){
	rel = $(this).attr('rel');
	rel++;
	$(this).attr('rel', rel);
	$.ajax({
		type: 'POST',
		url: '{{ route("add_req_portfolio") }}',
		data: {
			_token: token,
			rel:rel
		},
		success: function (response) {
			$("#portimages").append(response);
		}
	});
});

 var loadFile = function (event, id) {

	var reader = new FileReader();
	var filesize = event.target.files[0].size;
	var sizeInMB = (filesize / (1024*1024)).toFixed(2);
	if(sizeInMB > 10){
		swal("Alert!", "{{__('Maximum allowed file size is 10 MB')}}", "error");
		$('#'+id).val("");
		return false;
	}
	reader.onload = function () {
		var output = document.getElementById('image_'+id);
		output.src = reader.result;
	};
	reader.readAsDataURL(event.target.files[0]);
};
/* const image_drop_area = document.querySelector("#image_drop_area");
var uploaded_image;

// Event listener for dragging the image over the div
image_drop_area.addEventListener('dragover', (event) => {
  event.stopPropagation();
  event.preventDefault();
  // Style the drag-and-drop as a "copy file" operation.
  event.dataTransfer.dropEffect = 'copy';
});

// Event listener for dropping the image inside the div
image_drop_area.addEventListener('drop', (event) => {
  event.stopPropagation();
  event.preventDefault();
  fileList = event.dataTransfer.files;

  //document.querySelector("#file_name").textContent = fileList[0].name;
  
  readImage(fileList[0]);
});

// Converts the image into a data URI
readImage = (file) => {
  const reader = new FileReader();
  reader.addEventListener('load', (event) => {
    uploaded_image = event.target.result;
	//$('#profile_picture_name').val(file);
    //document.querySelector(".customer-image").style.backgroundImage = `url(${uploaded_image})`;
	var image_url = `url(${uploaded_image})`;
	$("#image_imgUpload").attr('src', uploaded_image);
  });
  reader.readAsDataURL(file);
}

const banner_img_area = document.querySelector("#banner_img_area");
var uploaded_imagebanner;

// Event listener for dragging the image over the div
banner_img_area.addEventListener('dragover', (event) => {
  event.stopPropagation();
  event.preventDefault();
  // Style the drag-and-drop as a "copy file" operation.
  event.dataTransfer.dropEffect = 'copy';
});

// Event listener for dropping the image inside the div
banner_img_area.addEventListener('drop', (event) => {
  event.stopPropagation();
  event.preventDefault();
  fileList = event.dataTransfer.files;

  //document.querySelector("#file_name").textContent = fileList[0].name;
  
  readImageBanner(fileList[0]);
});

// Converts the image into a data URI
readImageBanner = (file) => {
  const reader = new FileReader();
  reader.addEventListener('load', (event) => {
    uploaded_imagebanner = event.target.result;
    //document.querySelector(".customer-image").style.backgroundImage = `url(${uploaded_image})`;
	var image_url = `url(${uploaded_imagebanner})`;
	$("#image_imgBannerImage").attr('src', uploaded_imagebanner);
  });
  reader.readAsDataURL(file);
} */
function plan_store(){
	$('#myform3').submit();
}
</script>
@endsection
