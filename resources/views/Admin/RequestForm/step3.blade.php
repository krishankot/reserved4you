@extends('layouts.adminrequest')

@section('request_content')
<style>

</style>
<section class="contactdetail">
    <div class="progress">
        <div class="progress-bar progressbarr4u" role="progressbar" style="width: 60%;" aria-valuenow="25"
             aria-valuemin="0" aria-valuemax="100"></div>
    </div>
    <div class="container">
        <div class="contactheading">
            <h2>{{ __('Portfolio') }}</h2>
        </div>
		{{Form::model($dataRequest, array('url'=>'request-form/s3','method'=>'post','name'=>'myform', 'files'=>'true', 'id' => "myform3"))}}
            @csrf
            <div class="filldetail">
				<div class="row">
					<div class="col-12">
						<div class="form-group">
							<label class="iconlabel">
								<div class="d-flex align-items-center">
									<img src="{{ asset('storage/app/public/asset_request/images/icons/SVG/open-person.svg') }}" alt="">
									<span>{{ __('Profile picture') }}</span>
								</div>
							</label>
							<div class="image-box" id="image_drop_area">
								<div class="customer-image">
									<img id="image_imgUpload" src="{{ asset('storage/app/public/asset_request/images/icons/PNG/Group30.png') }}">
								</div>
								<label id="file_name" for="imgUpload" class="d-flex align-items-center" >
									<p class="ml-20 mr-5">{{-- Drag & Drop the image file or --}}</p>
									@if(!empty($dataRequest['profile_picture_name']))
										<a  href="{{ route('admin_download', array($dataRequest['profile_picture_name'], 'requestFormTemp')) }}" class="btn btn-pink btn-photo ml-5">
											{{__('Download') }}
										</a>
									@endif
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
								</div>
							</label>
							<div class="image-box" id="banner_img_area">
								<div class="customer-image">
									<img id="image_imgBannerImage" src="{{ asset('storage/app/public/asset_request/images/icons/PNG/Group30.png') }}">
								</div>
								<label id="file_namebanner" for="imgBannerImage" class="d-flex align-items-center" >
									<p class="ml-20 mr-5">{{-- Drag & Drop the image file or --}}</p>
									@if(!empty($dataRequest['banner_picture_name']))
										<a  href="{{ route('admin_download', array($dataRequest['banner_picture_name'], 'requestFormTemp')) }}" class="btn btn-pink btn-photo ml-5">
											{{__('Download') }}
										</a>
									@endif
								</label>
							</div>
						</div>
					</div>
					
					<div class="col-12">
						<div class="form-group">
							<label class="iconlabel">
								<div class="d-flex align-items-center">
									<img src="{{ asset('storage/app/public/asset_request/images/icons/SVG/metro-profile.svg') }}" alt="">
									<span>{{ __('Porfolio picture') }}</span>
								</div>
							</label>
							<div class="store-service">
								<div class="field">
									@foreach($dataRequest['portfolios'] as $row)
										@if(!empty($row['image_name']))
											<span class="pip" data-id="{{$row['id']}}">
												<a  href="{{ route('admin_download', array($row['image_name'], 'requestFormTemp')) }}">
													<img class="imageThumb" src="{{asset('storage/app/public/requestFormTemp/'.$row['image_name'])}}">
												</a>
											</span>
										@endif
									</span>
									@endforeach
								</div>
							</div>
						</div>
					</div>
					
				</div>
            </div>
			
            <div class="nextprevious servicebtns letscountinuesbtn nextprevious"> 
				<a href="{{ route('admin_request_step2', $slug) }}" class="previous">{{ __('Return') }}</a>
                <a href="{{ route('admin_request_step4', $slug) }}" class="next">{{ __('Continue') }}</a>
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
</script>
@endsection
