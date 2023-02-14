
@extends('layouts.serviceProvider')
@section('service_title')
    New Appointment
@endsection
@section('service_css')
<style type="text/css">
    .btn-book-block.disabled{
        pointer-events: none !important;
    }

    li.disabled{
        pointer-events: none !important;
    }
</style>
@endsection
@section('service_content')
    <div class="main-content">
        <h2 class="page-title static-page-title">Buchungen</h2>
        <div class="setting-title">
            <h3>Termin hinzufügen</h3>
        </div>
        <section class="secbookinfo pt-3">

            <h4 class="checkout-title">Checkout</h4>
            <div class="row">
                <div class="col-lg-6">
                    <div class="checkout-header-profile">
                    <span>
                        @if(file_exists(storage_path('app/public/store/'.@$store['store_profile'])) && @$store['store_profile'] != '')
                            <img src="{{URL::to('storage/app/public/store/'.@$store['store_profile'])}}" alt="">

                        @else
                            <img src="{{URL::to('storage/app/public/default/store_default.png')}}" alt="">
                        @endif
                    </span>
                        <h6>{{@$store['store_name']}}</h6>
                    </div>
                </div>
                <div class="col-lg-6">
{{--                    <a href="{{URL::to('kosmetik/'.@$store['slug'])}}" class="add-checkout-booking">--}}
{{--                    <span>--}}
{{--                        <img src="{{URL::to('storage/app/public/Frontassets/images/icon/plus.svg')}}" alt=""></span> Add--}}
{{--                        another service from {{@$store['store_name']}}</a>--}}
                </div>
            </div>
            {{Form::open(array('url'=>'service-provider/update-checkout-data','method'=>'post','name'=>'update_checkout_data'))}}
            <div style="display: none">{{$i = 0}}{{$j = 1}}</div>
            @foreach($data as $row)
                <div class="accordion pb-3" id="accordionExample-{{$row['category']['id']}}">
                
                    <div class="paymentaccordion paymentaccordion2" data-id="{{$row['category']['id']}}">
                        <a href="javascript:void(0)" class="payment-box-link" data-toggle="collapse" data-target="#collapse{{$row['category']['id']}}"
                           aria-expanded="true" aria-controls="collapse{{$row['category']['id']}}">
                    <span
                        class="payment-box-icon"><?php echo file_get_contents(URL::to('storage/app/public/category/' . @$row['category']['image'])) ?></span>
                            <h6>{{$row['category']['name']}}</h6>
                            <span class="downn-arroww"><i class="far fa-chevron-down"></i></span>
                        </a>
                        <div id="collapse{{$row['category']['id']}}" class="collapse show" aria-labelledby="heading{{$row['category']['id']}}"
                             data-parent="#accordionExample-{{$row['category']['id']}}">
                            <div class="worning-message" data-id="{{$row['category']['id']}}">
                                <h5>Bitte wähle einen Mitarbeiter, Datum und Uhrzeit aus</h5>
                                <h6><img src="{{URL::to('storage/app/public/Frontassets/images/icon/warning.svg')}}" alt="">
                                Bitte wähle einen Mitarbeiter, Datum und Uhrzeit aus</h6>
                                <a href="javascript:void(0)" class="btn btn-choose chooseDate"  data-id="{{$row['category']['id']}}" data-store="{{$store['id']}}" data-time="{{$row['totaltime']}}" data-change="0">Wählen</a>
                            </div>
                            <div class="payment-body-box">
                                <div class="payment-box-profile-wrap emplistdata" data-id="{{$row['category']['id']}}" style="display: none">
                                    <span class="empname" data-id="{{$row['category']['id']}}"><img src="{{URL::to('storage/app/public/default/default-user.png')}}" alt=""></span>
                                    <div class="empname" data-id="{{$row['category']['id']}}">
                                        <p>Mitarbeiter</p>
                                        <h6>Beliebige Person</h6>
                                    </div>
                                    <div class="datetimeslot" data-id="{{$row['category']['id']}}">
                                        <p></p>
                                        <h6></h6>
                                    </div>
                                    <a href="#" class="btn btn-choose change_again chooseDate ml-3" data-id="{{$row['category']['id']}}" data-store="{{$store['id']}}" data-time="{{$row['totaltime']}}" data-change="1" style="display:none">Ändern</a>
                                </div>
                                @foreach($row['data'] as $item)
                                    <div class="payment-item-infos booking-infor-wrap">
                                        <div class="booking-infor-left">
                                            <h5>{{@$item['service_data']['service_name']}}</h5>
                                            <h6>{{@$item['variant_data']['description']}}</h6>
                                            <span>{{@$item['variant_data']['duration_of_service']}} min</span>
                                        </div>
                                        <div class="booking-infor-right">
                                            <p>{{number_format($item['price'],2,',','.')}}€</p>
                                             <a href="#" class="btn btn-black mt-0 cancelService" data-time="{{@$item['variant_data']['duration_of_service']}}" data-id="{{@$item['variant_data']['id']}}" data-cateogry="{{$row['category']['id']}}">Löschen</a>
                                        </div>
                                    </div>
                                @endforeach
                                <input type="hidden" name="category[]" class="category_id" data-id="{{$row['category']['id']}}" value="{{$row['category']['id']}}">
                                <input type="hidden" name="store[]" class="store_id" data-id="{{$row['category']['id']}}" value="{{$store['id']}}">
                                <input type="hidden" name="date[]" class="date_id" data-id="{{$row['category']['id']}}" value="">
                                <input type="hidden" name="employee[]" class="emp_id" data-id="{{$row['category']['id']}}" value="">
                                <input type="hidden" name="totalTime[]" class="totalTime" data-id="{{$row['category']['id']}}" value="{{$row['totaltime']}}">
                                <input type="hidden" name="time[]" class="timeslot" data-id="{{$row['category']['id']}}" value="">
                            </div>
                        </div>
                    </div>
                    <div style="display: none">{{$i++}}{{$j++}}</div>
                </div>
                @endforeach
            <input type="hidden" name="totalamount" class="totalamount" data-id="" value="{{$totalamount}}">
            <input type="hidden" name="totalcategory" class="totalcategory" data-id="" value="{{$i}}">
            <button type="submit"  class="btn btn-book-block mt-5 disabled checkout-move">
                <p>Weiter</p>
                <div>
                    <span>Gesamt</span>
                    <h6 class="tamount">{{number_format($totalamount,2,',','.')}}€</h6>
                </div>
            </button>
            {{Form::close()}}

        </section>
    </div>

    <!-- modal -->
    <div class="modal fade" id="chooseNowModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body choose-modal-body">
                    <button type="button" class="close"  aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button>
                    <div class="hairchoosbox">
                        <span class="categoryImage"></span>
                        <h5 class="categoryName">Hair</h5>
                        <h6>Bitte wähle einen Mitarbeiter, Datum und Uhrzeit aus</h6>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="hairchoosbox-left">
                                <div class="hairchoosbox-profile">
                                <span><img class="storeimage" src="{{URL::to('storage/app/public/Frontassets/images/profile1.png')}}"
                                           alt=""></span>
                                    <h6 class="storename">Lounge Hair & Care</h6>
                                </div>
                                <div class="hairchoosbox-select-box">
                                    <select class="vodiapicker emplist">
                                        <option value="en" class="test"
                                                data-thumbnail="{{URL::to('storage/app/public/Frontassets/images/icon/profile-icon.svg')}}">
                                            Profile
                                        </option>
                                        <option value="au"
                                                data-thumbnail="{{URL::to('storage/app/public/Frontassets/images/profile1.png')}}">
                                            Profile 2
                                        </option>
                                        <option value="uk"
                                                data-thumbnail="{{URL::to('storage/app/public/Frontassets/images/profile.jpg')}}">
                                            Profile 3
                                        </option>
                                        <option value="cn"
                                                data-thumbnail="{{URL::to('storage/app/public/Frontassets/images/profile-img.jpg')}}">
                                            Profile 4
                                        </option>
                                    </select>
                                    <div class="lang-select">
                                        <button class="btn-select" value=""></button>
                                        <div class="b">
                                            <ul id="a" class="lang_ul"></ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="hairchoosbox-date">
                                    <h6>Datum wählen</h6>
                                    <div id="calendar2"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="set-time-head">
                                <h6>Uhrzeit wählen</h6>
                                <ul class="scheduletime scheduletime2">

                                </ul>
                            </div>
                        </div>
                    </div>
                    <a href="#" class="btn btn-book-block mt-5 disabled" id="booking">
                        <p>Weiter</p>
                        <div>
                            <span class="dateshow">16 May 2021</span>
                            <h6 class="timeshow">-</h6>
                        </div>
                    </a>
                    <input type="hidden" name="category" class="category_ids">
                    <input type="hidden" name="store" class="store_ids">
                    <input type="hidden" name="date" class="date_ids">
                    <input type="hidden" name="employee" class="emp_ids">
                    <input type="hidden" name="totalTime" class="totalTimes">
                    <input type="hidden" name="time" class="timeslotsa">
                </div>
            </div>
        </div>
    </div>
<!-- deleteProfilemodal -->
	<div class="modal fade" id="deleteProfilemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-body">
					<div class="delete-profile-box">
						<h4>Fehlgeschlagen</h4>
						<p>Tut uns Leid! Dieser Termin ist mit den angegebenen Daten nicht buchbar. Bitte wähle eine andere Uhrzeit.</p>
					</div>
					<div class="notes-btn-wrap">
						
						<a href="#" class="btn btn-gray" data-dismiss="modal" >Close</a>
					   
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
@section('service_js')
    <script>
        var authCheck = '{{Auth::check()}}';
        var baseurl = '{{URL::to('/')}}';
        var token = '{{ csrf_token() }}';
        var loginUser = localStorage.getItem('loginuser');
        localStorage.removeItem('getBookingData');
        $(document).ready(function () {
			var berror = '{{\Session::get("booking_error")}}';
			if(berror == 'yes'){
				$('#deleteProfilemodal').modal('toggle');
				var value = '{{\Session::forget("booking_error")}}'
			}
            localStorage.removeItem('lastValue');
            $(document).on('click','.scheduletime li',function (){
                $('li').removeClass("activetime");
                $(this).addClass("activetime");
                $('.timeslotsa').val($(this).data('id'));
                $('.timeshow').text($(this).data('id'));
                $('#booking').removeClass('disabled');
            });
        });


        var langArray = [];
        $('.vodiapicker option').each(function () {
            var img = $(this).attr("data-thumbnail");
            var text = this.innerText;
            var value = $(this).val();
            var item = '<li><img src="' + img + '" alt="" value="' + value + '"/><span>' + text + '</span></li>';
            langArray.push(item);
        })
        $('#a').html(langArray);

        //change button stuff on click
        $('#a li').click(function () {
            var img = $(this).find('img').attr("src");
            var value = $(this).find('img').attr('value');
            var text = this.innerText;
            var item = '<li><img src="' + img + '" alt="" /><span>' + text + '</span></li>';
            $('.btn-select').html(item);
            $('.btn-select').attr('value', value);


            $(".b").toggle();
            // console.log(value);
        });

        $(".btn-select").click(function () {
            // console.log('value');
            $(".b").toggle();
        });

        //check local storage for the lang
        var sessionLang = localStorage.getItem('lang');
        if (sessionLang) {
            //find an item with value of sessionLang
            var langIndex = langArray.indexOf(sessionLang);
            $('.btn-select').html(langArray[langIndex]);
            $('.btn-select').attr('value', sessionLang);
        } else {
            var langIndex = langArray.indexOf('ch');
            $('.btn-select').html(langArray[langIndex]);
            //$('.btn-select').attr('value', 'en');
        }



        $(document).on('click', '.chooseDate', function () {
            var category = $(this).data('id');
            var store = $(this).data('store');
            var time = $(this).data('time');
            var change = $(this).data('change');

            $.ajax({
                type: 'POST',
                async: true,
                dataType: "json",
                url: baseurl + '/service-provider/get-category-timeslot',
                data: {
                    _token: token,
                    category: category,
                    store: store,
                    time: time,
                },
                beforesend: $('#loading').css('display', 'block'),
                success: function (response) {
                    var status = response.status;
                    var data = response.data;
                        if (status == 'true') {
                                $('.storeimage').attr('src', data.store.store_profile);
                                $('.storename').text(data.store.store_name);
                                $('.categoryName').text(data.category.name);
                                $('.categoryImage').html(data.category.parse_image);
                               
                                    var option ='';
                                    var empval = '';
                                if(data.emp_list.length != 0){
                                       $.each(data.emp_list, function (index, value) {
                                            if(index == 0){
                                                empval = value.id;
                                            }
                                            option += '<option value="' + value.id + '" class="test"' +
                                                'data-thumbnail="' + value.image + '">' + value.emp_name + '' +
                                                '</option>';
                                        });

                                }
                             

                                $('.emplist').html(option);

                    
                                //test for iterating over child elements
                                var langArray = [];
                                $('.vodiapicker option').each(function () {
                                    var img = $(this).attr("data-thumbnail");
                                    var text = this.innerText;
                                    var value = $(this).val();
                                    var item = '<li><img src="' + img + '" alt="" value="' + value + '"/><span>' + text + '</span></li>';
                                    langArray.push(item);
                                })

                                if(langArray.length == 0){
                                    var item = '<li><img src="https://delemontstudio.com/reserved4younew/storage/app/public/default/default-user.png" alt="" value=""/><span>No Employee </span></li>';
                                    langArray.push(item);
                                }
                                // console.log(langArray.length);
                                $('#a').html(langArray);

                                //Set the button value to the first el of the array
                                $('.btn-select').html(langArray[0]);
                                $('.btn-select').attr('value', empval);

                                //change button stuff on click
                                $('#a li').click(function () {
                                    var img = $(this).find('img').attr("src");
                                    var value = $(this).find('img').attr('value');
                                    var text = this.innerText;
                                    var item = '<li><img src="' + img + '" alt="" /><span>' + text + '</span></li>';
                                    $('.btn-select').html(item);
                                    $('.btn-select').attr('value', value);
                                    $('.emp_ids').val(value);
                                    $(".b").toggle();
                                    changeEmployee();
                                    //console.log(value);
                                });

                                $('.category_ids').val(data.category.id);
                                $('.store_ids').val(data.store.id);
                                $('.totalTimes').val(data.totalTime);

                                if(change != '1') {
                                    $('.date_ids').val(data.date);
                                    $('.emp_ids').val('');
                                    $('.timeslotsa').val('');
                                }
                                
                                $('.emp_ids').val(empval);
                                $("#calendar2").datepicker("setDate", new Date());

                                if(change == '1'){
                                    var value = $('.totalcategory').val();
                                    $('.totalcategory').val(parseInt(value) + 1);
                                }

                                $('#chooseNowModal').modal('toggle');
                                $('#loading').css('display', 'none')
                    } else {
                        $('#loading').css('display', 'none')
                    }
                },
                error: function (e) {

                }
            });
        });

        function changeDate() {
            var store = $('.store_ids').val();
            var category = $('.category_ids').val();
            var date = $('.date_ids').val();
            var totalTime = $('.totalTimes').val();
            var emp = $('.emp_ids').val();
            var getBookingData = localStorage.getItem('getBookingData');

            if ((getBookingData == undefined) || (getBookingData == '')) {
                var BookingData = [];
            } else {
                var BookingData = jQuery.parseJSON(getBookingData);
            }

            var booking = BookingData;

            if (store != null && category != null && date != null && totalTime != null && emp == '') {
                // $.ajax({
                //     type: 'POST',
                //     async: true,
                //     dataType: "json",
                //     url: baseurl + '/service-provider/get-new-timeslot',
                //     data: {
                //         _token: token,
                //         category: category,
                //         store: store,
                //         time: totalTime,
                //         date: date,
                //         booking: booking,
                //     },
                //     beforesend: $('#loading').css('display', 'block'),
                //     success: function (response) {
                //         var status = response.status;
                //         var data = response.data;
                //         var timeHtml = '';
                //         if (status == 'true') {

                //             $.each(data, function (index, value) {
                //                 if (value.flag == 'Available') {
                //                     timeHtml += '<li data-id="' + value.time + '"><a href="javascript:void(0)" data-id="' + value.time + '" class="selectedDate">' + value.time + '</a></li>';
                //                 } else {
                //                     timeHtml += '<li class="light-li disabled"><a href="javascript:void(0)">' + value.time + '</a></li>';
                //                 }
                //             });

                //             $('.scheduletime').html(timeHtml);
                //         } else {
                //             timeHtml += '<div class="text-center">NO Time Schedule Found. Please try another Date.</div>';
                //             $('#booking').addClass('disabled');
                //             $('.scheduletime').html(timeHtml);
                //         }
                //     },
                //     error: function (e) {

                //     }
                // });
            }
            else if (store != null && category != null && date != null && totalTime != null && emp != '') {
                changeEmployee();
            }
        }

        function changeEmployee() {
            var store = $('.store_ids').val();
            var category = $('.category_ids').val();
            var date = $('.date_ids').val();
            var totalTime = $('.totalTimes').val();
            var emp = $('.emp_ids').val();

            var getBookingData = localStorage.getItem('getBookingData');

            if ((getBookingData == undefined) || (getBookingData == '')) {
                var BookingData = [];
            } else {
                var BookingData = jQuery.parseJSON(getBookingData);
            }

            var booking = BookingData;

            if (store != null && category != null && date != null && totalTime != null && emp != '') {
                $.ajax({
                    type: 'POST',
                    async: true,
                    dataType: "json",
                    url: baseurl + '/service-provider/get-new-timeslot-emp',
                    data: {
                        _token: token,
                        category: category,
                        store: store,
                        time: totalTime,
                        date: date,
                        emp: emp,
                        booking: booking,
                    },
                    beforesend: $('#loading').css('display', 'block'),
                    success: function (response) {
                        // console.log(response);
                        var status = response.status;
                        var data = response.data;
                        var day = response.day;
                        var timeHtml = '';

                        if (status == 'true') {

                            $.each(data, function (index, value) {
                                if (value.flag == 'Available') {
                                    timeHtml += '<li data-id="' + value.time + '" ><a href="javascript:void(0)" class="selectedDate">' + value.time + '</a></li>';
                                } else {
                                    timeHtml += '<li class="light-li disabled"><a href="javascript:void(0)">' + value.time + '</a></li>';
                                }
                            });


                            $('#calendar2').datepicker({daysOfWeekDisabled:day});
                            $("#calendar2").datepicker("refresh");
                            $('.scheduletime').html(timeHtml);
                        } else {
                            timeHtml += '<div class="text-center">NO Time Schedule Found. Please try another Date.</div>';
                            $('#booking').addClass('disabled');
                            $('.scheduletime').html(timeHtml);
                        }

                        $('#loading').css('display', 'none')


                    },
                    error: function (e) {

                    }
                });
            } else if (store != null && category != null && date != null && totalTime != null) {
                changeDate();
            }
        }

        $('#calendar2').datepicker({
            language: "de",
            todayHighlight : true,
            format: 'yyyy-mm-dd',
            min: 0,
            startDate: new Date(),
        }).on('changeDate', function(e) {
            $('.date_ids').val(e.format());
            $('.dateshow').text(e.format('dd-mm-yyyy'));
            $('.timeshow').text('-');
            $('#booking').addClass('disabled');
            changeDate();
        });

        $(document).on('click','.close',function (){
            $('#chooseNowModal').modal('toggle');
        })

        $(document).on('click', '#booking', function () {
            var category = $('.category_ids').val();
            var date = $('.date_ids').val();
            var emp_id = $('.emp_ids').val();
            var timeslot = $('.timeslotsa').val();

            $('.date_id[data-id="' + category + '"]').val(date);
            $('.timeslot[data-id="' + category + '"]').val(timeslot);

            $('.worning-message[data-id="' + category + '"]').css('display', 'none');
            $('.emplistdata[data-id="' + category + '"]').css('display', 'block');
            if (emp_id != '') {
                var empImage = $('.lang-select .btn-select img').attr('src');
                var empName = $('.lang-select .btn-select span').text();
                $('.empname[data-id="' + category + '"] ').css('display', 'block');
                $('.empname[data-id="' + category + '"] h6').text(empName);
                $('.empname[data-id="' + category + '"] img').attr('src',empImage);
                $('.emp_id[data-id="' + category + '"]').val(emp_id);
            } else {
                $('.empname[data-id="' + category + '"] ').css('display', 'block');
                $('.empname[data-id="' + category + '"] h6').text('Beliebige Person');
                var image = baseurl + '/storage/app/public/default/default-user.png';
                $('.empname[data-id="' + category + '"] img').attr('src',image);
            }
			var date_format = new Date(date);
			var show_date = String(date_format.getDate()).padStart(2, '0')+'-'+ String(date_format.getMonth() + 1).padStart(2, '0')+'-'+date_format.getFullYear();
            $('.datetimeslot[data-id="' + category + '"] p').text(show_date);
            $('.datetimeslot[data-id="' + category + '"] h6').text(timeslot);
            var totalcategory = $('.totalcategory').val();
            var newDatacategory = totalcategory - 1;
            $('.totalcategory').val(newDatacategory);
            if (newDatacategory == 0) {
                $('.checkout-move').removeClass('disabled');
            }


            var getBookingData = localStorage.getItem('getBookingData');
            if ((getBookingData == undefined) || (getBookingData == '')) {
                var BookingData = [];
            } else {
                var BookingData = jQuery.parseJSON(getBookingData);
            }

            BookingData = BookingData.filter(function (elem) {
                return elem.category !== category;
            });

            var totalTime = $('.chooseDate[data-id='+ category +']').data('time');
            var SelectedServiceData = {};
            SelectedServiceData['category'] = parseInt(category);
            SelectedServiceData['date'] = date;
            SelectedServiceData['timeslot'] = timeslot;
            SelectedServiceData['totalTime'] = totalTime;

            BookingData.push(SelectedServiceData);
            localStorage.setItem('getBookingData', JSON.stringify(BookingData));

            $('#chooseNowModal').modal('toggle');

            $('.change_again[data-id='+category+']').css('display','block')
        });

$(document).on('click', '.cancelService', function () {
    var id = $(this).data('id');
    var cateogry = $(this).data('cateogry');
    var time = $(this).data('time');
    var totalTime = $('.chooseDate[data-id='+cateogry+']').data('time');


        $.ajax({
            type: 'POST',
            async: true,
            dataType: "json",
            url: baseurl + '/remove-service',
            data: {
                _token: token,
                id: id
            },
            beforesend: $('#loading').css('display', 'block'),
            success: function (response) {
                var status = response.status;
                var data = response.data;
                if (status == 'true') {

                    if (data.totalservice == 0) {
                        $('.checkout-move').addClass('disabled');
                        $('.emplistdata').css('display','none !important');
                        $('.paymentaccordion[data-id="' + cateogry + '"]').addClass('text-center');

                        if(data.availableService.length == 0){

                            $('.paymentaccordion[data-id="' + cateogry + '"]').html('NO SERVICE FOUND PLEASE SELECT ANY SERVICE');
                        } else {
                            $('.paymentaccordion[data-id="' + cateogry + '"]').remove();
                        }

                        var value = $('.totalcategory').val();
                        $('.totalcategory').val(parseInt(value) - 1);

                        var getBookingData = localStorage.getItem('getBookingData');
                        if ((getBookingData == undefined) || (getBookingData == '')) {
                            var BookingData = [];
                        } else {
                            var BookingData = jQuery.parseJSON(getBookingData);
                        }

                        BookingData = BookingData.filter(function (elem) {
                            return elem.category !== cateogry;
                        });


                        localStorage.setItem('getBookingData', JSON.stringify(BookingData));

                        var getServiceData = localStorage.getItem('selectedService');

                        if ((getServiceData == undefined) || (getServiceData == '')) {
                            var SelectedService = [];
                        } else {
                            var SelectedService = jQuery.parseJSON(getServiceData);
                        }

                        SelectedService = SelectedService.filter(function (elem) {
                            return elem.category !== cateogry;
                        });
                        localStorage.setItem('selectedService', JSON.stringify(SelectedService));



                    } else {

                        $('.cancelService[data-id="' + id + '"]').closest('.booking-infor-wrap').remove();
                        var newTime = totalTime - time;
                        $('.chooseDate[data-id='+cateogry+']').attr('data-time',newTime);

                        var getBookingData = localStorage.getItem('getBookingData');
                        if ((getBookingData == undefined) || (getBookingData == '')) {
                            var BookingData = [];
                        } else {
                            var BookingData = jQuery.parseJSON(getBookingData);
                        }
                        var newKey = '';
                        $.map(BookingData, function(elementOfArray, indexInArray) {

                            if (elementOfArray.category == cateogry) {
                                newKey = indexInArray;
                                return true;
                            }
                        });

                        if(newKey != ''){
                            BookingData[newKey]['totalTime'] = newTime;

                            localStorage.setItem('getBookingData', JSON.stringify(BookingData));
                        }
                    }


                    $('.tamount').text(data.totalamount.toFixed(2));
                    $('.totalamount').val(data.totalamount);

                    var getServiceData = localStorage.getItem('selectedService');
                    if ((getServiceData == undefined) || (getServiceData == '')) {
                        var SelectedService = [];
                    } else {
                        var SelectedService = jQuery.parseJSON(getServiceData);
                    }

                    SelectedService = SelectedService.filter(function (elem) {
                        return elem.variant !== id;
                    });
                    localStorage.setItem('selectedService', JSON.stringify(SelectedService));


                } else {

                }
                $('#loading').css('display', 'none');
            },
            error: function (e) {

            }
        });
   

});



    </script>
@endsection
