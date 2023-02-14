@extends('layouts.adminrequest')

@section('request_content')
<style>

</style>
<section class="contactdetail">
    <div class="progress">
        <div class="progress-bar progressbarr4u" role="progressbar" style="width: 30%;" aria-valuenow="25"
             aria-valuemin="0" aria-valuemax="100"></div>
    </div>
    <div class="container">
        <div class="contactheading">
            <h2 class="position-relative">
				{{ __('Services') }}
			</h2>
        </div>
		{{Form::model($dataRequest, array('url'=>'request-form/s2','method'=>'post','name'=>'myform', 'files'=>'true', 'id' => "myform2", 'onsubmit' => "return validate();"))}}
            @csrf
			@if(!empty($dataRequest['service_data']))
				<div class="filldetail" >
					<div class="row">
						<div class="col-lg-12">
							<div class="form-group  mb-2">
								<label class="iconlabel">
									<div class="d-flex align-items-center">
										<img src="{{ asset('storage/app/public/asset_request/images/icons/SVG/simple-microsoftexcel.svg') }}" alt="">
										<span>{{ __('Upload a table from excel with services data') }}</span>
									</div>
								</label>
								
								 <div class="field">
									<input type="file" id="service_datafile" onchange="loadFileExcel(event, 'service_datafile')" class="store_profile files_xls" name="service_data_file" />
									<div class="files-upload-box">
										<a class="downloadlink" href="{{ route('admin_download', array($dataRequest['service_data'], 'req_cust_data')) }}">{{__('Download') }}</a>
									</div>
								</div>
								
								<span id="xlx_service_datafile">{{ !empty($dataRequest['service_data'])?$dataRequest['service_data']:NULL}}</span>
							</div>
						</div>
					</div>
				</div>
			@endif
			<div id="div_services">
				@if(!empty($dataRequest['service']))
					@foreach($dataRequest['service'] as $k=>$item)
						@include('Admin/RequestForm/services', ['i' =>$k])
					@endforeach
				@else
					@include('Admin/RequestForm/services', ['i' =>1])
				@endif
				
			</div>
            <div class="nextprevious servicebtns letscountinuesbtn nextprevious"> 
				<a href="{{ route('admin_request_step1', $slug) }}" class="previous">{{ __('Return') }}</a>
                <a href="{{ route('admin_request_step3', $slug) }}" class="next">{{ __('Continue') }}</a>
			</div>
        {{Form::close()}}
    </div>
</section>
<script>
@if(!empty($dataRequest['service']))
	@foreach($dataRequest['service'] as $k=>$item)
		var category_id = "{{ $item['category_id'] }}";
		var subcategory = "{{ $item['subcategory_id'] }}";
		var id = "{{ $k }}";
		@if(!empty($item['imagename']))
			var imagename = "{{ $item['imagename'] }}";
		
			$('#image_imgUpload'+id).attr('src', "{{ asset('storage/app/public/requestFormTemp') }}/"+imagename);
		@endif
		
		changeSubCategory(category_id, id, subcategory);
	@endforeach
@endif

function changeSubCategory(category_id, id, subcategory) {
	$.ajax({
		type: 'POST',
		url: "{{URL::to('service-provider/service/category')}}",
		data: {
			_token: '{{csrf_token()}}',
			id: category_id,
		},
		success: function (response) {
			var html = '<option value="">Unterkategorie wählen</option>';
			if (response.status == 'true') {
				$.each(response.data, function (i, row) {
					html += '<option value="' + row.id + '">' + row.name + '</option>';
				});
			}
			$('#subcategories'+id).html(html);
			$('#subcategories'+id).val(subcategory).niceSelect('update');
		},
		error: function (error) {
		}
	});
	return true;
}
</script>
@endsection
