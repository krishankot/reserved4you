@extends('layouts.request')

@section('request_content')
<section class="contactdetail">
    <div class="progress">
        <div class="progress-bar progressbarr4u" role="progressbar" style="width: 100%;" aria-valuenow="25"
             aria-valuemin="0" aria-valuemax="100"></div>
    </div>
    <div class="container">
        <div class="contactheading">
            <h2>{{__('Thank You so much') }}</h2>
        </div>
		
            <div class="filldetail">
				
				<div class="row">
					<div class="col-12">
						<h4 class="text-center" style="font-weight:400">{{__('Your request for store has been submitted, Business Executive will reach to you soon') }}</h4>
					</div>
				</div>
            </div>
			
           <?php /* <div class="nextprevious servicebtns letscountinuesbtn nextprevious"> 
				<a href="{{ url('anforderungsformular/1') }}" class="previous" type="btn">Back to Home</a>
			</div> */ ?>
		
    </div>
</section>
@endsection
