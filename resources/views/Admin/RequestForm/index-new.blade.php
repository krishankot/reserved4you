@extends('layouts.request')

@section('request_content')

<section class="contactdetail">
    <div class="progress">
        <div class="progress-bar progressbarr4u" role="progressbar" style="width: 10%;" aria-valuenow="25"
             aria-valuemin="0" aria-valuemax="100"></div>
    </div>
    <div class="container">
        <div class="contactheading">
            <h2>About</h2>
        </div>
       
		{{Form::model($dataRequest, array('url'=>'request-form/s1','method'=>'post','name'=>'myform', 'files'=>'true', 'onsubmit' => "return validate();"))}}
            @csrf
            <div class="filldetail">
               <div class="form-group">
							<label class="iconlabel">
								<div class="d-flex align-items-center">
									<img src="{{ asset('storage/app/public/asset_request/images/icons/SVG/metro-shop.svg') }}" alt="">
									<span>Shop name*</span>
								</div>
							</label>
							{{Form::text('store_name',NULL,array('class'=>'start_time contact','autocomplete'=>'off','placeholder'=>'Shop name'))}}
							<span id="storename"  class="text-danger"></span>
						</div>
                    
            <div class="letscountinuesbtn">
                <button class="letscontinues" type="submit">Continue</button>
            </div></div>
		{{Form::close()}}
    </div>
</section>
<!---*** End: Bootstrap 3.3.7 version files. ***--->


<script>

  $('.start_time').datetimepicker({
			format: 'HH:mm', 
			
			icons: {up: 'fa fa-angle-up', down: 'fa fa-angle-down'},
			}).on('dp.change',function(e){
				/* var id = $(this).data('id');
				alert(id); */
				 var formatedValue = e.date.format('HH:mm');
				 console.log(formatedValue);
				 
				//startTime(formatedValue,id);
		});
</script>
@endsection
