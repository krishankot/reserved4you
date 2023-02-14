@extends('layouts.request')

@section('request_content')
<style>

</style>
<section class="contactdetail">
    <div class="progress">
        <div class="progress-bar progressbarr4u" role="progressbar" style="width: 85%;" aria-valuenow="25"
             aria-valuemin="0" aria-valuemax="100"></div>
    </div>
    <div class="container">
        <div class="contactheading">
            <h2>{{ __('Feedback') }}</h2>
        </div>
		{{Form::open(array('url'=>'anforderungsformular/4','method'=>'post','name'=>'myform', 'files'=>'true', 'id' => "myform4"))}}
            @csrf
            <div class="filldetail">
				<div class="row">
					<div class="col-12">
						<div class="form-group mb-0 mt-3">
							<div class="gbox">
								<h4><span>{{ __('Google Ratings') }}</span>*</h4>
								<h4>{{ __('Do you want us to implement some of your google ratings into our system to make your profile more attractive for your customers') }} ?</h4>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-12">
						<div class="form-group">
							<ul class="gbox-btns">
								<li>
									<input type="radio" value="yes" id="yes" name="google_ratings" />
									<label for="yes">{{ __('Yes, Please') }}!</label>
								</li>
								<li>
									<input type="radio" value="no" id="no" name="google_ratings" />
									<label for="no">{{ __('No, Thanks') }}!</label>
								</li>
							 </ul>
						</div>
					</div>
				</div>
				
				<div class="form-group mt-3">
					<div class="custom-control custom-checkbox checkbox_agree">
						<input type="checkbox" name="agree_terms_conditions" value="1" class="custom-control-input checkmark" id="agree_terms_conditions">
						<label class="custom-control-label" for="agree_terms_conditions">
							<span>
								*{{ __('I agreed that all the submit information is correct and I agree to the') }} <a target="_blank" href="{{ route('agb') }}">{{ __('term & condition') }}</a> {{ __('and') }} <a target="_blank" href="{{ route('datenschutz') }}">{{ __('privacy policy') }}</a> {{ __('of') }}
							</span>
						</label>
					</div>
					<span class="text-danger" id="errorterm"></span>
				</div>
            </div>
			
            <div class="nextprevious servicebtns letscountinuesbtn nextprevious"> 
				<a href="{{ url('anforderungsformular/3') }}" class="previous" type="btn">{{ __('Return') }}</a>
                <a href="javascript:void(0)" class="next" type="btn" onclick="plan_store()">{{ __('Submit') }}</a>
			</div>
		{{ Form::close() }}
    </div>
</section>
<script type="text/javascript">
	var google_ratings = localStorage.getItem('google_ratings');
	
	if(typeof google_ratings  !== "undefined"){
		 $("#"+google_ratings).prop("checked", true);
	}
	var agree_terms_conditions = localStorage.getItem('agree_terms_conditions');
	
	if(typeof agree_terms_conditions  !== "undefined" && agree_terms_conditions == "1"){
		 $("#agree_terms_conditions").prop("checked", true);
	}
	$('input:radio[name="google_ratings"]').change(function(){
        if ($(this).is(':checked')) {
            var selected = $(this).val();
			localStorage.setItem('google_ratings', selected);
        }
    });
	$('input:checkbox[name="agree_terms_conditions"]').change(function(){
        if ($(this).is(':checked')) {
            var selected = $(this).val();
			localStorage.setItem('agree_terms_conditions', selected);
        }else{
			localStorage.setItem('agree_terms_conditions', 0);
		}
    });
	function plan_store(){
		var agree_terms_conditions = localStorage. getItem('agree_terms_conditions');
		if(typeof agree_terms_conditions  !== "undefined" && agree_terms_conditions == "1"){
			 localStorage.removeItem('agree_terms_conditions');
			 localStorage.removeItem('google_ratings');
			 $('#myform4').submit();
		}else{
			$('#errorterm').html('{{ __("Please accept terms and conditions") }}');
		}
	}
</script>
@endsection
