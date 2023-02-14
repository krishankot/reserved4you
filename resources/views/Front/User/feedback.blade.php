<!doctype html>
<html dir="ltr" lang="en-US">

<head>
    <title>Feedback</title>
    <link type="image/x-icon" rel="shortcut icon"
          href="{{URL::to('storage/app/public/Frontassets/images/favicon.jpg')}}"/>
    <!-- Required meta tags -->
    <meta charset="UTF-8"/>
    <meta name="HandheldFriendly" content="true">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link type="text/css" rel="stylesheet" href="{{URL::to('storage/app/public/Frontassets/font/stylesheet.css')}}"/>
    <link type="text/css" rel="stylesheet" href="{{URL::to('storage/app/public/Frontassets/css/all.min.css')}}"/>
    <link type="text/css" rel="stylesheet" href="{{URL::to('storage/app/public/Frontassets/css/bootstrap.min.css')}}"/>
    <link type="text/css" rel="stylesheet"
          href="{{URL::to('storage/app/public/Frontassets/css/jquery.fancybox.min.css')}}"/>
    <link type="text/css" rel="stylesheet"
          href="{{URL::to('storage/app/public/Frontassets/css/owl.carousel.min.css')}}"/>
    <link type="text/css" rel="stylesheet" href="{{URL::to('storage/app/public/Frontassets/css/nice-select.css')}}"/>
    <link type="text/css" rel="stylesheet"
          href="{{URL::to('storage/app/public/Frontassets/css/bootstrap-datepicker.css')}}"/>
    <link type="text/css" rel="stylesheet" href="{{URL::to('storage/app/public/Frontassets/css/styles.css')}}"/>
    <link type="text/css" rel="stylesheet" href="{{URL::to('storage/app/public/Frontassets/css/styles-2.css')}}"/>
    <link type="text/css" rel="stylesheet" href="{{URL::to('storage/app/public/Frontassets/css/responsive.css')}}"/>
	<link type="text/css" rel="stylesheet" href="{{URL::to('storage/app/public/rateit/rateit.css')}}"/>
	<style>
	.conntainer-section .container {
    max-width: 800px;
}
	</style>
</head>
<body>
<!--Heading-->
<div>
    <nav class="navbar navbar-expand-lg processtopay-header">
        <div class="container">
            <div class="heading d-flex justify-content-between flex-wrap">
                <a class="navbar-brand logo" href="{{URL::to('/')}}">
                    <img src="{{URL::to('storage/app/public/Frontassets/images/logo.svg')}}" alt="logo">
                </a>
                <nav aria-label="breadcrumb" class="breadcrumb-ol">
                    <ol class="breadcrumb">
                        <li onclick="window.location.href='{{URL::to('/')}}'">
                            <img src="{{URL::to('storage/app/public/Frontassets/images/home.svg')}}" alt="">
                        </li>
                        <li class="breadcrumb-item"><a href="#">- Feeback</a>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </nav>
</div>

{{Form::open(array('url'=>'submit-rating','name'=>'submit-rating','id'=>'submit_rating','method'=>'post'))}}
<section class="conntainer-section">
    <div class="container">
        <div class="feedback-profile">
                <span>
                     @if(file_exists(storage_path('app/public/store/'.$store['store_profile'])) && $store['store_profile'] != '')
                        <img src="{{URL::to('storage/app/public/store/'.$store['store_profile'])}}" alt="">

                    @else
                        <img src="{{URL::to('storage/app/public/store/Store-6058bde8bf5a8.JPEG')}}" alt="">
                    @endif
                </span>
            <h6>Teile deine Erfahrungen mit anderen Nutzern</h6>
            <p>{{$store['store_name']}}</p>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="feedback-select">
					@if(!empty($ap_id))
						 <input type="hidden" name="ap_dataid" value="{{$ap_id}}">
						@endif
                     @if($service_id != '' && $service_id != null)
                    <a href="javascript:void(0)" class="feedback-select-link">
                        <span><img src="{{URL::to('storage/app/public/Frontassets/images/icon/chair.svg')}}"
                                   alt="" class="str_image"></span>
                       
                            <p class="str_name">{{$serviceName}}</p>
                            <input type="hidden" name="service_id" value="{{$service_id}}" class="service_names">
                        
                        <input type="hidden" name="store_id" value="{{$store['id']}}" class="store_id">
                    </a>
                    @else 
                    <a href="javascript:void(0)" class="feedback-select-link" data-toggle="modal"
                       data-target="#selectServiceModal">
                        <span><img src="{{URL::to('storage/app/public/Frontassets/images/icon/chair.svg')}}"
                                   alt="" class="str_image"></span>
                        
                            <p class="str_name">Service wählen</p>
                            <input type="hidden" name="service_id" class="service_names">
                       
                        <input type="hidden" name="store_id" value="{{$store['id']}}" class="store_id">
                    </a>
                     @endif
                    <!-- Modal -->
                    <div class="modal fade" id="selectServiceModal" tabindex="-1" role="dialog"
                         aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <a href="javascript:void(0)" data-dismiss="modal" class="close-modal-btn"><i
                                        class="far fa-times"></i></a>
                                <div class="feedback-modal-header">
                                    <h4>Service wählen</h4>
                                </div>
                                <div class="servic-modal-body feedback-modal-body">
                                    <div class="feedback-search-search review-info-search">
                                        <input type="text" placeholder="Suche nach Service .." id="myInput1">
                                        <a href="javascript:void(0)"><i class="far fa-search"></i></a>
                                    </div>
                                    <div class="card-body store-body store-body2">
                                        <div class="owl-carousel owl-theme" id="service-item-owl2">
                                            @foreach($category as $row)
                                                <div class="item">
                                                    <label class="service-labels-2 " for="service-item-{{$row->id}}" >
                                                        <input type="radio" name="service-item-span" class="service_lbl"
                                                               id="service-item-{{$row->id}}" value="{{$row->id}}" data-id="{{$row->id}}" data-image="{{URL::to('storage/app/public/category/' . $row->image)}}">
                                                        <div href="javascript:void(0)" class="service-item-icon">
                                                            <span><?php echo file_get_contents(URL::to('storage/app/public/category/' . $row->image)) ?></span>
                                                            <h6>{{$row->name}}</h6>
                                                        </div>
                                                    </label>
                                                </div>
                                            @endforeach

                                        </div>
                                        <div class="specifics-body specifics-body1">

                                        </div>
                                    </div>
                                </div>
                                <div class="servic-modal-footer">
                                    <a href="javascript:void(0)" class="btn main-btn btn-donee service_done">Weiter</a>
                                    <a href="javascript:void(0)" class="clear_service filter-clear-link">Löschen</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="feedback-select">
                     @if($emp != '' && $emp != null)
                    <a href="javascript:void(0)" class="feedback-select-link">
                        <span><img src="{{$empimage}}"
                                   alt="" class="emp_image"></span>
                        <p class="emp_name">{{$empname}}</p>
                        <input type="hidden" name="emp_id" value="{{$emp}}" class="emp_names">
                    </a>
                    @else 
                     <a href="javascript:void(0)" class="feedback-select-link" data-toggle="modal"
                       data-target="#selectEmployeeModal">
                        <span><img src="{{URL::to('storage/app/public/Frontassets/images/icon/outstanding.svg')}}"
                                   alt="" class="emp_image"></span>
                        <p class="emp_name">Mitarbeiter wählen</p>
                        <input type="hidden" name="emp_id" class="emp_names">
                    </a>
                    @endif
                    <!-- Modal -->
                    <div class="modal fade" id="selectEmployeeModal" tabindex="-1" role="dialog"
                         aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <a href="javascript:void(0)" data-dismiss="modal" class="close-modal-btn"><i
                                        class="far fa-times"></i></a>
                                <div class="feedback-modal-header">
                                    <h4>Mitarbeiter wählen</h4>
                                </div>
                                <div class="servic-modal-body feedback-modal-body">
                                    <div class="feedback-search-search review-info-search">
                                        <input type="text" placeholder="Suche nach Mitarbeitern" id="myInput">
                                        <a href="javascript:void(0)"><i class="far fa-search"></i></a>
                                    </div>
                                    <ul class="employee-profile-ul">
                                        <li>
                                            @foreach($storeEmp as $row)
                                                <label class="employee_profiles" for="employee-profiles-{{$row->id}}"
                                                       data-name="{{$row->emp_name}}"
                                                       data-image="{{URL::to('storage/app/public/store/employee/'.$row->image)}}">
                                                    <input type="radio" name="employee-profile" value="{{$row->id}}"
                                                           id="employee-profiles-{{$row->id}}">
                                                    <div>
                                                        <span class="profile-spann">
                                                            <img
                                                                src="{{URL::to('storage/app/public/store/employee/'.$row->image)}}"
                                                                alt="">
                                                        </span>
                                                        <p>{{$row->emp_name}}</p>
                                                        <span class="round"><i class="fas fa-check"></i></span>
                                                    </div>
                                                </label>
                                            @endforeach

                                        </li>
                                    </ul>
                                </div>
                                <div class="servic-modal-footer">
                                    <a href="javascript:void(0)" class="btn main-btn btn-donee">Weiter</a>
                                    <a href="javascript:void(0)" class="clear_emp filter-clear-link" >Löschen</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row ratings-items-rows">
            <div class="col col-sm-6 col-md-4">
                <div class="ratings-items-box ratings-items-box2">
                    <div id="half-stars-example">
                        <div class="rating-group">
							<input type="hidden" name="service_rate" id="service_rate_input">
                            <div class="rateit" data-rateit-backingfld="#service_rate_input" data-rateit-mode="font" data-rateit-resetable="false" style="font-size:45px"></div>
                        </div>

                        <p>Service &amp; Mitarbeiter</p>
                    </div>
                </div>
            </div>
            <div class="col col-sm-6 col-md-4">
                <div class="ratings-items-box ratings-items-box2">
                    <div id="half-stars-example">
                        <div class="rating-group">
							<input type="hidden" name="ambiente" id="ambiente_input">
                            <div class="rateit" data-rateit-backingfld="#ambiente_input" data-rateit-mode="font" data-rateit-resetable="false" style="font-size:45px"></div>
                        </div>
                        <p>Ambiente</p>
                    </div>
                </div>
            </div>
            <div class="col col-sm-6 col-md-4">
                <div class="ratings-items-box ratings-items-box2">
                    <div id="half-stars-example">
                        <div class="rating-group">
							<input type="hidden" name="preie_leistungs_rate" id="preie_leistungs_rate_input">
                            <div class="rateit" data-rateit-backingfld="#preie_leistungs_rate_input" data-rateit-mode="font" data-rateit-resetable="false" style="font-size:45px"></div>
                        </div>
                        <p>Preis - Leistung</p>
                    </div>
                </div>
            </div>
            <div class="col col-sm-6 col-md-4">
                <div class="ratings-items-box ratings-items-box2">
                    <div id="half-stars-example">
                        <div class="rating-group">
							<input type="hidden" name="wartezeit" id="wartezeit_input">
                            <div class="rateit" data-rateit-backingfld="#wartezeit_input" data-rateit-mode="font" data-rateit-resetable="false" style="font-size:45px"></div>
                        </div>
                        <p>Wartezeit</p>
                    </div>
                </div>
            </div>
            <div class="col col-sm-6 col-md-4">
                <div class="ratings-items-box ratings-items-box2">
                    <div id="half-stars-example">
                        <div class="rating-group">
							<input type="hidden" name="atmosphare" id="atmosphare_input">
                            <div class="rateit" data-rateit-backingfld="#atmosphare_input" data-rateit-mode="font" data-rateit-resetable="false" style="font-size:45px"></div>
                        </div>
                        <p>Atmosphäre</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-area-box">
            <textarea rows="10" placeholder="Teile deine Erfahrungen hier .." name="write_comment" required></textarea>
        </div>
    </div>
</section>

<button type="button" class="btn main-btn btn-feedback-block send_feedback">Feedback senden <i
        class="far fa-long-arrow-right"></i></button>
{{Form::close()}}
<!-- Optional JavaScript -->
<script src="{{URL::to('storage/app/public/Frontassets/js/jquery.min.js')}}"></script>
<script src="{{URL::to('storage/app/public/Frontassets/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{URL::to('storage/app/public/Frontassets/js/jquery.fancybox.min.js')}}"></script>
<script src="{{URL::to('storage/app/public/Frontassets/js/jquery.nice-select.min.js')}}"></script>
<script src="{{URL::to('storage/app/public/Frontassets/js/owl.carousel.min.js')}}"></script>
<script src="{{URL::to('storage/app/public/Frontassets/js/bootstrap-datepicker.js')}}"></script>
<script src="{{URL::to('storage/app/public/Frontassets/js/custom.js')}}"></script>
<script src="{{URL::to('storage/app/public/rateit/jquery.rateit.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
<script>
	 $(".rateit").bind('over', function (event,value) { $(this).attr('title', value); });

    // service-item-owl //
    $('#service-item-owl2').owlCarousel({
        loop: false,
        margin: 10,
        nav: true,
        dots: false,
        navText: ["<i class='fas fa-chevron-left'></i>", "<i class='fas fa-chevron-right'></i>"],
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 3
            },
            1000: {
                items: 4
            }
        }
    })

    var baseurl = '{{URL::to('/')}}';
    var token = '{{ csrf_token() }}';

    $(document).ready(function () {
        $(document).on("keyup",'#myInput', function () {
            var value = $(this).val().toLowerCase();
            $(".employee-profile-ul li label").filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });

    $(document).on('click', '.employee_profiles', function () {
        var value = $('input[name="employee-profile"]:checked').val();
        var name = $(this).data('name');
        var image = $(this).data('image');

        $('.emp_image').attr('src', image);
        $('.emp_name').text(name);
        $('.emp_names').val(value);

        $('#selectEmployeeModal').modal('toggle');
    })

    $(document).on('click','.service_lbl',function (){
        var id = $(this).data('id');
        var store = $('.store_id').val();

        $.ajax({
            type: 'POST',
            async: true,
            dataType: "json",
            url: baseurl + '/feedback/get-subcategory',
            data: {
                _token: token,
                category: id,
                store: store,
            },
            beforesend: $('#loading').css('display', 'block'),
            success: function (response) {
                var status = response.status;
                var data = response.data;
                var html = '';
                var j = 1;
                if (status == 'true') {

                    $.each(data, function (i, value) {
                        html += '<div class="accordion service_accordion-box" id="accordionExample'+j+'">' +
                            '                                                    <div class="service_accordion">\n' +
                            '                                                        <a href="javascript:void(0)" class="service_link"\n' +
                            '                                                           data-toggle="collapse" data-target="#collapse'+j+'"\n' +
                            '                                                           aria-expanded="true" aria-controls="collapse'+j+'">\n' +
                            '                                                            <h6>'+i+'</h6>\n' +
                            '                                                            <span class="downn-arroww"><i\n' +
                            '                                                                    class="far fa-chevron-down"></i></span>\n' +
                            '                                                        </a>\n' +
                            '                                                        <div id="collapse'+j+'" class="collapse"\n' +
                            '                                                             aria-labelledby="heading'+j+'"\n' +
                            '                                                             data-parent="#accordionExample'+j+'">\n' +
                            '                                                            <div class="payment-body-box">\n' +
                            '                                                                <ul>';
                        $.each(value, function (p, pvalue) {
                            html += ' <li>\n' +
                                '<div\n' +
                                'class="custom-control custom-checkbox area-checkbox">\n' +
                                '<input type="radio" class="custom-control-input" id="areacustomCheck'+pvalue.id+'" name="service_id" value="'+pvalue.id+'" data-name="'+pvalue.service_name+'">' +
                                ' <label class="custom-control-label"  for="areacustomCheck'+pvalue.id+'">'+pvalue.service_name+'</label>\n' +
                                '  </div>\n' +
                                '</li>'
                        });
                        html += ' </ul>\n' +
                            '</div>\n' +
                            '</div>\n' +
                            ' </div>\n' +
                            '</div>';
                        j++;
                    });

                    $('.specifics-body').html(html);
                } else {
                    html += '<div class="text-center">Kein Service gefunden.</div>'
                    $('.specifics-body').html(html);
                }
                $('#loading').css('display', 'none');
            },
            error: function (e) {

            }
        });

    });

    $(document).on('click', '.service_done', function () {
        var value = $('input[name="service_id"]:checked').val();
        var name = $('input[name="service_id"]:checked').data('name');
        // var image = $('input[name="service-item-span"]:checked').data('image');

        // $('.str_image').attr('src', image);
        $('.str_name').text(name);
        $('.service_names').val(value);

        $('#selectServiceModal').modal('toggle');
    })

    $(document).on('click','.clear_service',function (){
        $('.specifics-body').html('');
        $("input:radio[name=service-item-span]:checked")[0].checked = false;
        $('.service_id').val('');
        $('.str_name').text('Select Services');
        // $('#selectServiceModal').modal('toggle');
    });

    $(document).on('click','.clear_emp',function (){
        $("input:radio[name=employee-profile]:checked")[0].checked = false;
        $('.emp_names').val('');
        var image = "{{URL::to('storage/app/public/Frontassets/images/icon/outstanding.svg')}}";
        $('.emp_name').text('Select Employee');
        $('.emp_image').attr('src',image);
        // $('#selectEmployeeModal').modal('toggle');
    });

    $('#submit_rating').validate({ // initialize the plugin
        rules: {
            write_comment: {
                required: true,
            },
        },
        // Specify validation error messages
        messages: {
            write_comment: {
                required: "Please provide a some Comments"
            },
           
        },
    });

    $(document).on('click','.send_feedback',function(){
        if($('#submit_rating').valid()){
            $('.send_feedback').attr('disabled', true);
            // alert('hi');
            $('#submit_rating').submit();
        }
    });
</script>
</body>

</html>
