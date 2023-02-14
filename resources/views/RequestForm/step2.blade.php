@extends('layouts.request')

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
				<a class="btn btn-add-icon d-flex align-items-center text-right add_services" rel="{{ !empty($dataRequest['service'])?max(array_keys($dataRequest['service'])):1 }}" href="javascript:void(0);"><span><i class="fa fa-plus"></span></i>&nbsp;&nbsp;{{ __('Add Service') }}</a>
			</h2>
        </div>
		<div class="text-right mt-2">*mind. einen Service hinzufügen</div>
		{{Form::model($dataRequest, array('url'=>'anforderungsformular/2','method'=>'post','name'=>'myform', 'files'=>'true', 'id' => "myform2", 'onsubmit' => "return validate();"))}}
            @csrf
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
							<small class="text-right w-100">{{ __('Allowed file formats are doc, excel, text, pdf, images') }}</small>
							 <div class="field">
								<small class="text-right w-100">{{__('Max upload size 10mb')}}</small>
								<input type="file" id="service_datafile" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint,text/plain, application/pdf, .jpg,.jpeg,.png,.gif, .bmp, .ico, .tiff, .svg,.webp" onchange="loadFileExcel(event, 'service_datafile')" class="store_profile files_xls" name="service_data_file" />
								<div class="files-upload-box">
									<img src="{{ asset('storage/app/public/asset_request/images/icons/SVG/upload_icon.svg') }}" alt="">
									<small class="text-webcolor"><i>Bitte fügen Sie Kategorien, Unterkategorien, Name des Services, Beschreibung, Preis und Dauer ein.</i></small>
								</div>
							</div>
							<span class="position-relative" id="xlx_service_datafile">
								{{ !empty($dataRequest['service_data'])?$dataRequest['service_data']:NULL}}
								@if(!empty($dataRequest['service_data']))
									<a href="javascript:void(0);" class="remove_xlx ml-2 " id="remove_xlx_service_datafile" rel="service_datafile"><i class="fa fa-times-circle"></i></a>
								@endif
							</span>
						</div>
					</div>
				</div>
			</div>
			
			<div id="div_services">
				@if(!empty($dataRequest['service']))
					@foreach($dataRequest['service'] as $k=>$item)
						@include('RequestForm/services', ['i' =>$k])
					@endforeach
				@else
					@include('RequestForm/services', ['i' =>1])
				@endif
				
			</div>
            <div class="nextprevious servicebtns letscountinuesbtn nextprevious"> 
				<a href="{{ url('anforderungsformular/1') }}" class="previous" type="btn">{{ __('Return') }}</a>
                <a href="javascript:void(0)" class="next" type="btn" onclick="plan_store();">{{ __('Continue') }}</a>
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
function validate() {
	 var isvalid = true;
	 
	 var lengthfile = $('#xlx_service_datafile').text();
	  lengthfile = $.trim(lengthfile);
	if(lengthfile.length > 3){
		return isvalid;
	}
	  
	 $("select.category_select").each(function(){
			var rele = $(this).data('id');
			if($(this).val() == ""){
				document.getElementById("errorcat"+rele).innerHTML = "{{ __('Please select category') }}";
				isvalid = false;
			}else{
				$(this).next('span.text-danger').html("");
			}
	  });
	  $("select.subcategory_select").each(function(){
			var rele = $(this).data('id');
			if($(this).val() == ""){
				document.getElementById("errorsub"+rele).innerHTML = "{{ __('Please select sub category') }}";
				isvalid = false;
			}else{
				$(this).next('span.text-danger').html("");
			}
	  });
	  $(".mainservice").each(function(){
			if($(this).val() == ""){
				$(this).next('span.text-danger').html("{{ __('Please enter main service name') }}");
				isvalid = false;
			}else{
				$(this).next('span.text-danger').html("");
			}
	  });
	  
	   $(".description").each(function(){
			if($(this).val() == ""){
				$(this).next('span.text-danger').html("{{ __('Please enter description') }}");
				isvalid = false;
			}else{
				$(this).next('span.text-danger').html("");
			}
	  });
	  
	  var subservice_count = 0;
	  var price_subservice = 0;
	  var duration_subservice = 0;
	  $(".subservice").each(function(){
		  if($(this).val() != ""){
			  subservice_count++;
		  }
	  });
	  
	  $(".price_subservice").each(function(){
		  if($(this).val() != ""){
			  price_subservice++;
		  }
	  });
	  
	  $(".duration_subservice").each(function(){
		  if($(this).val() != ""){
			  duration_subservice++;
		  }
	  });
	  
	 
	 if(subservice_count == 0 && price_subservice == 0 && duration_subservice == 0){
		 $(".price").each(function(){
				if($(this).val() == ""){
					$(this).next('span.text-danger').html("{{ __('Please enter Price') }}");
					isvalid = false;
				}else{
					$(this).next('span.text-danger').html("");
				}
		  });
		  
		  $(".duration_of_service").each(function(){
				if($(this).val() == ""){
					$(this).next('span.text-danger').html("{{ __('Please enter duration') }}");
					isvalid = false;
				}else{
					$(this).next('span.text-danger').html("");
				}
		  });
	 }else if(subservice_count ==  price_subservice && price_subservice == duration_subservice){
	  }else{
		   $(".subservice").each(function(){
				if($(this).val() == ""){
					$(this).next('span.text-danger').html("Please enter subservice name.");
					isvalid = false;
				}else{
					$(this).next('span.text-danger').html("");
				}
		  });
		  
		   $(".price_subservice").each(function(){
				if($(this).val() == ""){
					$(this).next('span.text-danger').html("Please enter subservice price.");
					isvalid = false;
				}else{
					$(this).next('span.text-danger').html("");
				}
		  });
		  
		   $(".duration_subservice").each(function(){
				if($(this).val() == ""){
					$(this).next('span.text-danger').html("Please enter subservice duration.");
					isvalid = false;
				}else{
					$(this).next('span.text-danger').html("");
				}
		  }); 
	   }
	if(!isvalid){
			swal("{{ __('Alert') }}!", "{{__('Please provide all the required information')}}", "error");
		}
	return isvalid;
}
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
$('body').on('click', '.add_services', function(){
	rel = $(this).attr('rel');
	rel++;
	$(this).attr('rel', rel);
	$.ajax({
		type: 'POST',
		url: '{{ route("add_req_services") }}',
		data: {
			_token: token,
			rel: rel
		},
		success: function (response) {
			$("#div_services").append(response);
		}
	});
});
$('body').on('click', '.remove_service', function(){
	rel = $(this).attr('rel');
	$("#service_div"+rel).remove();
});
$('body').on('click', '.add_subservices', function(){
	var service_id = $(this).data('id');
	var rel = $(this).attr('rel');
	rel++;
	$(this).attr('rel', rel);
	$.ajax({
		type: 'POST',
		url: '{{ route("add_req_subservices") }}',
		data: {
			_token: token,
			service_id:service_id,
			rel: rel
		},
		success: function (response) {
			$("#div_subservices"+service_id).append(response);
		}
	});
});
$('body').on('click', '.remove_subservice', function(){
	rel = $(this).attr('rel');
	$(this).parent('.subservice-box').remove();
});
function plan_store(){
	$('#myform2').submit();
}
</script>
@endsection
