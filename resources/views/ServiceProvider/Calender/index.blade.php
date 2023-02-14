@extends('layouts.serviceProvider')
@section('service_title')
    Calender
@endsection
@section('service_css')
    <?php
    use App\Models\StoreProfile;
    $getStore = StoreProfile::where('user_id', Auth::user()->id)->get();
    ?>

    <link type="text/css" rel="stylesheet" href="{{URL::to('storage/app/public/Serviceassets/css/FullCalendar.css')}}">
    <style>
        .red-bg{
            background:#FFD2D2
        }
        .orange-bg{
            background:#FDE3BF
        }

        span.cancel-label2 {
            border: 2px solid #ef4343;
            border-radius: 4rem;
            background: #fff;
            font-size: 14px;
            color: #ef4343;
            font-weight: 400;
            padding: 4px 12px;
            display: inline-block;
        }

        span.pending-label2 {
            border: 2px solid #f19f2d;
            border-radius: 4rem;
            background: #fff;
            font-size: 14px;
            color: #f19f2d;
            font-weight: 400;
            padding: 4px 12px;
            display: inline-block;
        }

    </style>
@endsection
@section('service_content')
    <div class="main-content">
        <div class="page-title-div">
            <h2 class="page-title">Calendar</h2>
        </div>

        <div class="appointment-header calander-header customers-header">
            <div class="sortby sortby2 mr-auto">
                <select class="select store_category">
                    <option value=""
                            data-value="">Alle Stores
                    </option>
                    @foreach($getStore as $row)
                        @if(session('store_id') == $row->id)

                            <option value="{{$row->id}}"
                                    data-value="{{$row->store_address}}" selected>{{$row->store_name}}</option>
                        @else
                            <option value="{{$row->id}}"
                                    data-value="{{$row->store_address}}">{{$row->store_name}}</option>
                        @endif
                    @endforeach
                </select>
                <p class="str_address select-p-text">{{session('address')}}</p>
            </div>
            <a href="{{URL::to('dienstleister/buchung-erstellen')}}" class="appointment-btn btn-yellow mr-0">Neuen Mitarbeiter hinzufügen</a>
        </div>
        <div class="owl-carousel owl-theme" id="calender-owl">
            @foreach($employee as $row)
            <div class="item">
                <div class="calander-profile">
                    <span>
                        @if(file_exists(storage_path('app/public/store/employee/'.$row->image)) && $row->image != '')
                            <img src="{{URL::to('storage/app/public/store/employee/'.$row->image)}}"
                                 alt=""
                            >
                        @else
                            <img src="{{URL::to('storage/app/public/default/default-user.png')}}"
                                 alt=""
                            >
                        @endif
                    </span>
                    <h6>{{$row->emp_name}}</h6>
                    @if(@$row->time->is_off == 'off')
                    <p>Working from {{@\Carbon\Carbon::parse($row->time->start_time)->format('H:i')}} - {{@\Carbon\Carbon::parse($row->time->end_time)->format('H:i')}}</p>
                    @else
                        <p>On Leave</p>
                    @endif
                </div>
            </div>
            @endforeach

        </div>
        <div id="calendar"></div>
    </div>

    <!-- calendar modal -->
    <div id="modal-view-event" class="modal modal-top fade calendar-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <h4 class="modal-title"><span class="event-icon"></span><span class="event-title"></span></h4>
                    <div class="event-body"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div id="modal-view-event-add" class="modal modal-top fade calendar-modal calendar-modal2">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="add-event">
                    <div class="modal-body modal-body22">
                        <div class="appointment-profile-wrap green-bg">
                            <div class="appointment-profile-left">
                                <div class="appointment-profile-img">
                                    <img src="{{URL::to('storage/app/public/Serviceassets/images/profile-1.jpg')}}" alt="">
                                </div>
                                <div class="appointment-profile-info">
                                    <h5>Celigo Johnson <a href="#">View Profile</a></h5>
                                    <ul class="appointment-d-block">
                                        <li>
                                            <p>Booking ID: <span> R4U4575</span></p>
                                        </li>
                                        <li>
                                            <p>Service time: <span> 12:00 - 13:00</span></p>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="appointment-profile-right">
                                <div class="app-payment-info-type mr-0">
                                    <p>Paid via    <i><img src="{{URL::to('storage/app/public/Serviceassets/images/master.svg')}}" alt=""></i>    <span>Master card</span></p>
                                    <h6 class="calender-price">Total Paid <span>40€</span></h6>
                                    <span class="completed-label2">Completed</span>
                                </div>
                            </div>
                        </div>
                        <div class="appointment-div-bg">
                            <div class="appointment-cato-wrap">
                                <div class="appointment-cato-item">
                                    <span>
                                        <img src="{{URL::to('storage/app/public/Serviceassets/images/icon/hair.svg')}}"></span>
                                    <h6>Hair</h6>
                                </div>
                                <div class="appointment-cato-date">
                                    <h6>September 15, 2021 (Tue)</h6>
                                    <span>16:00</span>
                                </div>
                            </div>
                            <div class="appointment-info-profile">
                        <span>
                            <img src="{{URL::to('storage/app/public/Serviceassets/images/profile-1.jpg')}}" alt="">
                        </span>
                                <div>
                                    <p>Retained Stylist</p>
                                    <h6>Oben Decson</h6>
                                </div>
                            </div>
                            <div class="appointment-item-info">
                                <h5>Ladies - Balayage &amp; Blow Dry</h5>
                                <h6>Balayage</h6>
                                <p>30 {{__('Min') }} <strong>40€</strong></p>
                            </div>
                            <div class="appointment-item-info border-0 mb-0">
                                <h5>Ladies - Balayage &amp; Blow Dry</h5>
                                <p>30 {{__('Min') }} <strong>40€</strong></p>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('service_js')
    <script src="{{URL::to('storage/app/public/Serviceassets/js/popper.min.js')}}"></script>
    <script src="{{URL::to('storage/app/public/Serviceassets/js/moment.js')}}"></script>
    <script src="{{URL::to('storage/app/public/Serviceassets/js/fullcalendar.min.js')}}"></script>
    <script src="{{URL::to('storage/app/public/Serviceassets/js/datepicker.js')}}"></script>
    <script src="{{URL::to('storage/app/public/Serviceassets/js/datepicker.en.js')}}"></script>
    <script src="{{URL::to('storage/app/public/Serviceassets/js/bootstrap-datepicker.js')}}"></script>
    <script src="{{URL::to('storage/app/public/Serviceassets/js/FullCalendar.js')}}"></script>
    <script>
        $('#calender-owl').owlCarousel({
            loop:true,
            margin:10,
            dots:false,
            nav:true,
            navText : ['<i class="fas fa-chevron-left"></i>', '<i class="fas fa-chevron-right"></i>'],
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:3
                },
                1000:{
                    items:5
                }
            }
        });

        (function () {
            'use strict';
            // ------------------------------------------------------- //
            // Calendar
            // ------------------------------------------------------ //
            var calData = <?php echo json_encode($calander); ?>;

            jQuery(function () {
                // page is ready
                jQuery('#calendar').fullCalendar({
                    themeSystem: 'bootstrap4',
                    // emphasizes business hours
                    businessHours: false,
                    defaultView: 'month',
                    // event dragging & resizing
                    editable: true,
                    // header
                    header: {
                        left: 'title',
                        center: 'month,agendaWeek,agendaDay',
                        right: 'today prev,next'
                    },
                    events: calData,
                    eventClick: function (event, jsEvent, view) {
                        opencanlenderModal(event);
                    },

                })
            });

        })(jQuery);

        function opencanlenderModal(event){

            $('#add-event').html(event.description);
            $('#modal-view-event-add').modal('toggle');
        }
    </script>
@endsection

