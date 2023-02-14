@extends('layouts.serviceProvider')
@section('service_title')
    Add Service
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
            <p><a href="{{URL::to('dienstleister/betriebsprofil')}}">Betriebsprofil</a> <i> / Service hinzufügen</i></p>
        </div>
        {{Form::open(array('url'=>'service-provider/add-service','method'=>'post','name'=>'create_service','files'=>'true','id'=>'create_service'))}}
        <div class="appointment-header customers-header">
            <h4>Neuen Service hinzufügen</h4>
            <!--<a href="#" class="btn btn-black-yellow">See Preview</a>-->
            <button type="submit" class="btn btn-yellow ml-2">Veröffentlichen</button>
        </div>

        <div class="service-body">
            <div class="store-service">
                <div class="store-main-service">
                    <div class="service-header-wrap">
                        <h5>Kategorien</h5>
                    </div>
                    <ul>
                        <div style="display: none">{{$i=1}}</div>
                        @foreach($storeCategory as $row)
                            <li>
                                <label for="hair-categories{{$row->id}}">
                                    <input type="radio" name="category_id" class="category_select"
                                           value="{{@$row['category_id']}}"
                                           id="hair-categories{{$row->id}}"
                                           data-id="{{@$row['category_id']}}" {{$i == 1 ? 'checked':''}}>
                                    <div class="categories-box">
                                        <span><?php echo file_get_contents(URL::to('storage/app/public/category/' . @$row['CategoryData']['image'])) ?></span>
                                        <h6>{{@$row['CategoryData']['name']}}</h6>
                                    </div>
                                </label>
                            </li>
                            <div style="display: none">{{$i++}}</div>
                        @endforeach
                    </ul>
                </div>
                <div class="store-sub-categories">
                    <div class="service-header-wrap">
                        <h5>Unterkategorien</h5>
                    </div>
                    {{Form::select('subcategory_id',$storeSubCategory,'',array('class'=>'select subcategories'))}}
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

                            <img id="output"
                                 src="{{URL::to('storage/app/public/Serviceassets/images/default-profile.jpg')}}"/>

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
                <input type="text" placeholder="Name des Service" class="consumer-input" name="service_name"
                       required>
                @error('service_name')
                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror
            </div>
            <div class="mb-30">
                <h6 class="new-service-title">Beschreibung </h6>
                <textarea placeholder="Beschreibung hinzufügen …..." name="description" required
                          class="consumer-input consumer-textarea mb-0"
                          rows="10"></textarea>
                @error('description')
                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror
            </div>
            @if($store_data['is_discount'] == 'yes')
            <div class="mb-30">
                <h6 class="new-service-title">Rabatt %</h6>
                {{Form::number('discount','',array('class'=>'consumer-input','id'=>'validationCustom03','step' =>0.01, "lang"=>"de", 'placeholder'=>'Rabatt(%)','min'=>0))}}
                {{Form::hidden('discount_type','percentage')}}
            </div>
            @endif
            <ul class="nav nav-pills eprofile-navs eprofile-navs2" id="pills-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active service-tab" id="pills-single-service-tab" data-id="pills-single-service">Einzelner Service</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link service-tab" id="pills-sub-services-tab" data-id="pills-sub-services">Service mit Unterservices</a>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-single-service" role="tabpanel"
                     aria-labelledby="pills-single-service-tab">
{{--                    <h4 class="yellow-title">Unterservices</h4>--}}
                    <div class="add_variant">
                        <div class="single-service">
                            <div class="position-relative  sservice">
{{--                                {{Form::text('description_variant[]','',array('class'=>'consumer-input','placeholder'=>'Sub-Service Description','required'))}}--}}
                                {{Form::hidden('description_variant[]','')}}
                                <label for="" style="pointer-events: none!important;">Preis €</label>
                                {{Form::number('price_variant[]','',array('class'=>'consumer-input','step' =>0.01, "lang"=>"de", 'placeholder'=>'Preis €','min'=>0.1,'required'))}}
                                <label class="d-block" for="" style="pointer-events: none!important;">Dauer (min)</label>
                                {{Form::number('duration_of_service_variant[]','',array('class'=>'consumer-input','placeholder'=>'Dauer (min)','min'=>5,'required'))}}
                            </div>
                        </div>
                    </div>

                </div>
                <div class="tab-pane fade" id="pills-sub-services" role="tabpanel"
                     aria-labelledby="pills-sub-services-tab" style="display: none;opacity: 1">
                    <h4 class="yellow-title">Unterservices</h4>
                    <div class="add_variant add_sub">
                        <div class="sub-services">

                        </div>
                    </div>
                    <div class="text-right">
                        <a href="javascript:void(0)" class="btn btn-black-yellow add_another">Weiteren Service hinzufügen</a>
                    </div>
                </div>
            </div>


            {{Form::close()}}

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

                $(document).on('click', '.add_another', function () {
                    var html = '<div class="sub-light-dark-bg position-relative">\n' +
                        '                    <label for="" style="pointer-events: none!important;">Name des Unterservice</label><input type="text" name="description_variant[]" class="consumer-input" placeholder="Name des Unterservice" required>\n' +
                        '                    <label for="" style="pointer-events: none!important;">Preis (€)</label><input type="number" name="price_variant[]" step = 0.01 lang="de" class="consumer-input" placeholder="Preis (€)" required min="0.1">\n' +
                        '                    <label for="" style="pointer-events: none!important;">Dauer (min)</label><input type="number" name="duration_of_service_variant[]" class="consumer-input" placeholder="Dauer (min)" required min="5">' +
                        '<span class="remove removeVariant" ></span>\n' +
                        '                 </div>';

                    $('.add_sub').append(html);
                })
                $(document).on('click', '.removeVariant', function () {
                    $(this).closest('.sub-light-dark-bg').remove();
                });

                $('#create_service').validate({ // initialize the plugin
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
                        var html = '<div class="sub-light-dark-bg position-relative  subservice"><label for="" style="pointer-events: none!important;">Name des Unterservice</label><input type="text" name="description_variant[]" class="consumer-input" placeholder="Name des Unterservice" required>\n' +
                            '<label for="" style="pointer-events: none!important;">Preis (€)</label>'+
                            '<input type="number" name="price_variant[]" class="consumer-input" step = 0.01 lang="de" placeholder="Preis (€)" min="0.1" required>\n' +
                            '<label for="" style="pointer-events: none!important;">Dauer (min)</label>'+
                            '<input type="number" name="duration_of_service_variant[]" class="consumer-input" placeholder="Dauer (min)" min="5" required></div>';

                        $('.sub-services').html(html);
                        $('.sservice').remove();
                        $('#pills-sub-services').css('display', 'block');
                        $('#pills-single-service').css('display', 'none');
                    } else {
                        var html = '<div class="position-relative  sservice">' +
                            '<input type="hidden" name="description_variant[]" value="">\n' +
                            '<label for="" style="pointer-events: none!important;">Preis (€)</label>'+
                            '<input type="number" name="price_variant[]" step = 0.01 lang="de" class="consumer-input" placeholder="Preis (€)" min="0.1" required>\n' +
                            '<label for="" style="pointer-events: none!important;">Dauer (min)</label>'+
                            '<input type="number" name="duration_of_service_variant[]" class="consumer-input" placeholder="Dauer (min)" min="5" required></div>';
                        $('.single-service').html(html);
                        $('.subservice').remove();
                        $('#pills-sub-services').css('display', 'none');
                        $('#pills-single-service').css('display', 'block');
                    }
                })

            </script>
@endsection
