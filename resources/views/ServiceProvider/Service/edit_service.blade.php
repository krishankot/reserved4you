@extends('layouts.serviceProvider')
@section('service_title')
    Edit Service
@endsection
@section('service_css')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <style>
        .discountType {
            width: 100%;
            border: 2px solid hsl(216deg 5% 64% / 20%);
            margin-bottom: 20px;
            border-radius: 20px;
            height: 60px;
            padding: 0 15px 0 30px;
            font-size: 17px;
            font-weight: 400;
            line-height: 53px;
        }

        .removeVariant {
            top: 20px;
            right: -10px;
        }
    </style>
@endsection
@section('service_content')
    <div class="main-content">
        <div class="page-title-div">
            <h2 class="page-title">Betriebsprofil</h2>
            <p><a href="{{URL::to('dienstleister/betriebsprofil')}}">Betriebsprofil</a> <i> / Edit Services </i></p>
        </div>
        {{Form::open(array('url'=>'service-provider/update-service','method'=>'post','name'=>'update-service','files'=>'true','id'=>'update-service'))}}
        <div class="appointment-header customers-header">
            <h4>Neuen Service hinzufügen</h4>
            <!--<a href="#" class="btn btn-black-yellow">See Preview</a>-->
            <button type="button" id="update_service_btn" class="btn btn-yellow ml-2">Veröffentlichen</button>
        </div>
		 @if(count($serviceVariant) > 1 OR (count($serviceVariant) == 1 && !empty($serviceVariant[0]) && !empty($serviceVariant[0]['description'])))
			  {{Form::hidden('selection_type_tab','subservice', array('id' => 'selection_type_tab'))}}
		 @else
			  {{Form::hidden('selection_type_tab','service', array('id' => 'selection_type_tab'))}}
		 @endif
        <div class="service-body">
            <div class="store-service">
                <div class="store-main-service">
                    <div class="service-header-wrap">
                        <h5>Kategorien</h5>
                    </div>
                    <ul>
                        @foreach($storeCategory as $row)
                            <li>
                                <label for="hair-categories{{$row->id}}">
                                    <input type="radio" name="category_id" class="category_select"
                                           value="{{@$row['category_id']}}"
                                           id="hair-categories{{$row->id}}"
                                           data-id="{{@$row['category_id']}}" {{$data['category_id'] == $row['category_id'] ? 'checked':''}}>
                                    <div class="categories-box">
                                        <span><?php echo file_get_contents(URL::to('storage/app/public/category/' . @$row['CategoryData']['image'])) ?></span>
                                        <h6>{{@$row['CategoryData']['name']}}</h6>
                                    </div>
                                </label>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="store-sub-categories">
                    <div class="service-header-wrap">
                        <h5>Unterkategorien</h5>
                    </div>
                    {{Form::select('subcategory_id',$storeSubCategory,$data['subcategory_id'],array('class'=>'select subcategories'))}}
                    @error('subcategory_id')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
            </div>
        </div>
        <hr class="store-service-hr">
        <div class="service-body">

            <div class="thumbnail-div mb-30">
                <h6 class="new-service-title">Bilddatei hochladen</h6>
                <div class="col-6">
                    <div class="image-box">
                        <div class="customer-image">


                            @if(file_exists(storage_path('app/public/service/'.$data->image)) && $data->image != '')
                                <img  id="output" src="{{URL::to('storage/app/public/service/'.$data->image)}}"
                                     class="rounded avatar-sm"
                                     alt="user">
                                <?php /* <img id="output"
                                     src="{{URL::to('storage/app/public/service/'.$data->image)}}"/> */ ?>
                            @else
                                <img id="output"
                                     src="{{URL::to('storage/app/public/Serviceassets/images/default-profile.jpg')}}"/>
                            @endif

                        </div>
                        <label for="imgUpload">
                            <p>Service Bild </p>
                            <input id="imgUpload" type="file" accept="image/*" name="image"
                                   onchange="loadFile(event)">
                            <span class="btn btn-yellow btn-photo">Ändern</span>
                        </label>
                    </div>
                    @error('image')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
            </div>
            <div class="mb-30">
                <div class="title-btn-wrap">
                    <h6 class="new-service-title">Hauptservice</h6>
                </div>
                <input type="text" placeholder="Name des Service" value="{{$data['service_name']}}" class="consumer-input"
                       name="service_name" required>
                <input type="hidden" name="service_id" value="{{$data['id']}}">
                @error('service_name')
                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror
            </div>
            <div class="mb-30">
                <h6 class="new-service-title">Beschreibung </h6>
                <textarea placeholder="Beschreibung hinzufügen …" name="description" required
                          class="consumer-input consumer-textarea mb-0"
                          rows="10">{{$data['description']}}</textarea>
                @error('description')
                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror
            </div>
            @if($store_data['is_discount'] == 'yes')
            <div class="mb-30">
                <h6 class="new-service-title">Rabatt %</h6>
                {{Form::number('discount',$data['discount'],array('class'=>'consumer-input', 'step' =>0.01, "lang"=>"de", 'id'=>'validationCustom03','placeholder'=>'Rabatt %','min'=>0))}}
                {{Form::hidden('discount_type','percentage')}}
            </div>
            @endif
            <ul class="nav nav-pills eprofile-navs" id="pills-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link @if(count($serviceVariant) == 1 && !empty($serviceVariant[0]) && empty($serviceVariant[0]['description'])) active @endif service-tab"
                       id="pills-single-service-tab" data-id="pills-single-service">Einzelner Service</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link service-tab @if(count($serviceVariant) > 1 OR (count($serviceVariant) == 1 && !empty($serviceVariant[0]) && !empty($serviceVariant[0]['description']))) active @endif"
                       id="pills-sub-services-tab" data-id="pills-sub-services">Service mit Unterservices</a>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-single-service" role="tabpanel"
                     aria-labelledby="pills-single-service-tab"
                     style="{{ (count($serviceVariant) > 1 OR (count($serviceVariant) == 1 && !empty($serviceVariant[0]) && !empty($serviceVariant[0]['description'])))?'display: none;opacity: 1':'' }}">
                    <div class="add_variant">

                        <div class="single-service">
                            @if(count($serviceVariant) == 1 && !empty($serviceVariant[0]) && empty($serviceVariant[0]['description']))
                                @foreach ($serviceVariant as $row)

                                    <div class="position-relative  sservice">
                                        {{Form::hidden('description_variant[]','')}}
										 <label for="" style="pointer-events: none!important;">Preis €</label>
                                        {{Form::number('price_variant[]',$row->price,array('class'=>'consumer-input','step' =>0.01, "lang"=>"de", 'placeholder'=>'Preis (€)','min'=>1,'required'))}}
										 <label class="d-block" for="" style="pointer-events: none!important;">Dauer (min)</label>
									   {{Form::number('duration_of_service_variant[]',$row->duration_of_service,array('class'=>'consumer-input','placeholder'=>'Dauer (min)','min'=>1,'required'))}}
                                        {{Form::hidden('variant_id[]',$row->id)}}
                                    </div>

                                @endforeach
                            @endif
                        </div>

                    </div>

                </div>
                <div class="tab-pane fade show active" id="pills-sub-services" role="tabpanel"
                     aria-labelledby="pills-sub-services-tab" style=
                    "{{(count($serviceVariant) == 1 && !empty($serviceVariant[0]) && empty($serviceVariant[0]['description']))?'display: none;opacity: 1':'' }}">
                    <h4 class="yellow-title">Unterservices</h4>
                    <div class="add_variant ">

                        <div class="sub-services add_sub">
                            @if(count($serviceVariant) > 1 OR (count($serviceVariant) == 1 && !empty($serviceVariant[0]) && !empty($serviceVariant[0]['description'])))
                                <div style="display: none">{{$i = 1}} </div>
                                @foreach ($serviceVariant as $row)

                                    <div class="sub-light-dark-bg position-relative  subservice">
										<label for="" style="pointer-events: none!important;">Name des Unterservice</label>
                                        {{Form::text('description_variant[]',$row->description,array('class'=>'consumer-input','placeholder'=>'Name des Unterservice','required'))}}
                                        <label for="" style="pointer-events: none!important;">Preis €</label>
										{{Form::number('price_variant[]',$row->price,array('class'=>'consumer-input','step' =>0.01, "lang"=>"de", 'placeholder'=>'Preis (€)','min'=>0.1,'required'))}}
                                         <label class="d-block" for="" style="pointer-events: none!important;">Dauer (min)</label>
										{{Form::number('duration_of_service_variant[]',$row->duration_of_service,array('class'=>'consumer-input','placeholder'=>'Dauer (min)','min'=>5,'required'))}}
                                        {{Form::hidden('variant_id[]',$row->id)}}
                                        @if($i != 1)
                                            <span class="remove removeVariant"></span>
                                        @endif
                                    </div>

                                    <div style="display: none">{{$i++}} </div>
                                @endforeach
                            @endif
                        </div>

                    </div>
                    <div class="text-right">
                        <a href="javascript:void(0)" class="btn btn-black-yellow add_another">Weiteren Service hinzufügen</a>
                    </div>
                </div>
            </div>
        </div>
        {{Form::close()}}
    </div>
    </div>
@endsection
@section('service_js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
    <script>
        $(document).on('click', '.category_select', function () {
            var id = $(this).data('id');
            changeSubCategory(id);
        });
        var loadFile = function (event) {
            var reader = new FileReader();
            reader.onload = function () {
                var output = document.getElementById('output');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        };

        function changeSubCategory(id) {
            $.ajax({
                type: 'POST',
                url: "{{URL::to('service-provider/service/category')}}",
                data: {
                    _token: '{{csrf_token()}}',
                    id: id,
                },
                success: function (response) {
                    var html = '<option value="">Unterkategorie wählen</option>';
                    if (response.status == 'true') {
                        $.each(response.data, function (i, row) {
                            html += '<option value="' + row.id + '">' + row.name + '</option>';
                        });
                    }
                    $('.subcategories').html(html);
                    $('.subcategories').niceSelect('update');
                },
                error: function (error) {


                }
            });
        }
		
		$(document).on('click', '#update_service_btn', function (e) {
			e.preventDefault();
			var selectedTab  = $('#selection_type_tab').val();
			if(selectedTab == 'subservice'){
				$('.sservice').remove();
			}else{
				$('.subservice').remove();
			}
			$('#selection_type_tab').remove();
			$('#update-service').submit();
		});
		

        $(document).on('click', '.add_another', function () {
            var html = '<div class="sub-light-dark-bg position-relative">\n' +
                '                    <label for="" style="pointer-events: none!important;">Name des Unterservice</label><input type="text" name="description_variant[]" class="consumer-input" placeholder="Name des Unterservice" required>\n' +
                '                    <label for="" style="pointer-events: none!important;">Preis (€)</label><input type="number" name="price_variant[]" step =0.01 lang="de"  class="consumer-input" placeholder="Preis (€)" required min="0.1">\n' +
                '                    <label for="" style="pointer-events: none!important;">Dauer (min)</label><input type="number" name="duration_of_service_variant[]" class="consumer-input" placeholder="Dauer (min)" required min="5">' +
                '<span class="remove removeVariant" ></span>\n' +
                '                 </div>';

            $('.add_sub').append(html);
        })
        $(document).on('click', '.removeVariant', function () {
            $(this).closest('.sub-light-dark-bg').remove();
        });

        $('#update-service').validate({ // initialize the plugin
             rules: {
				category_id: {
					required: true,
				},
				subcategory_id: {
					required: true,
				},
				service_name: {
					required: true,
				},
				description: {
					required: true,
				},
				discount: {
					number: true
				},
				 "price_variant[]": {
					required: true,
					min:0.1,
					max:999,
				},
				"duration_of_service_variant[]": {
					required: true,
					min:5,
				}
			},
			messages: {
				category_id: {
					required: "{{ __('Please select category') }}",
				},
				subcategory_id: {
					required: "{{ __('Please select sub category') }}",
				},
				service_name: {
					required: "{{ __('Please enter main service name') }}",
				},
				description: {
					required: "{{ __('Please enter description') }}",
				},
				discount: {
					number: "{{ __('Please enter description') }}",
				},
				"price_variant[]": {
					required: "{{ __('Please enter Price') }}",
					min: "{{ __('Please enter a value greater than or equal to 1') }}",
					max: "{{ __('Please enter a value less than or equal to 999') }}",
				},
				"duration_of_service_variant[]": {
					required: "{{ __('Please enter duration') }}",
					min: "{{ __('Please enter a value greater than or equal to 5') }}",
				},
			},
});

        $(document).on('click', '.service-tab', function () {
            var id = $(this).data('id');

            $('.service-tab').removeClass('active');
            $(this).addClass('active');

            if (id == 'pills-sub-services') {
                var html = '<div class="sub-light-dark-bg position-relative subservice"><label for="" style="pointer-events: none!important;">Name des Unterservice</label><input type="text" name="description_variant[]" class="consumer-input" placeholder="Sub-Service Description" required>\n' +
                    '<label for="" style="pointer-events: none!important;">Preis (€)</label><input type="number" name="price_variant[]" step =0.01 lang="de"  class="consumer-input" placeholder="Preis (€)" min="0.1" required>\n' +
                    '<label for="" style="pointer-events: none!important;">Dauer (min)</label><input type="number" name="duration_of_service_variant[]" class="consumer-input" placeholder="Dauer (min)" min="5" required></div>';
					var htmledit = $('.sub-services').text();
					if(htmledit.trim() == ""){
						$('.sub-services').html(html);
					}
				$('#selection_type_tab').val('subservice');
                $('#pills-sub-services').css('display', 'block');
                $('#pills-single-service').css('display', 'none');
            } else {
                var html = '<div class=" position-relative sservice">' +
                    '<input type="hidden" name="description_variant[]" value="">\n' +
                    '<label for="" style="pointer-events: none!important;">Preis (€)</label><input type="number" name="price_variant[]" step =0.01 lang="de"  class="consumer-input" placeholder="Preis (€)" min="0.1" required>\n' +
                    '<label for="" style="pointer-events: none!important;">Dauer (min)</label><input type="number" name="duration_of_service_variant[]" class="consumer-input" placeholder="Dauer (min)" min="5" required></div>';
					var htmledit = $('.single-service').text();
					if(htmledit.trim() == ""){
						$('.single-service').html(html);
					}
					$('#selection_type_tab').val('service');
                $('#pills-sub-services').css('display', 'none');
                $('#pills-single-service').css('display', 'block');
            }
        })
    </script>
@endsection
