@extends('layouts.admin')
@section('title')
    Calendar
@endsection
@section('css')
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar-scheduler@5.9.0/main.min.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar-scheduler@5.9.0/main.min.js'></script>
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>

    {{--    <link rel="stylesheet" type="text/css" href="{{asset('calendar/fullcalendar.bundle.css')}}"/>--}}
    <style>
        .f11{
            font-size: 11px;
        }
        .fc-today {
            background: #FFF !important;
            border: none !important;
            border-top: 1px solid #ddd !important;
            font-weight: bold;
        }
        .fc-myCustomButton-button.fc-button{
            background: #FABA5F!important;
            color: white!important;
        }
        .prev.slick-arrow{
            z-index: 9;
        }
        .slick-arrow .fc-icon{
            margin-top: 4px!important;
        }
        .slick-arrow{
            position: absolute;
            top: 30px;
            border: 1px solid transparent;
            padding: .4em .65em;
            font-size: 1em;
            line-height: 1.5;
            border-radius: 50%!important;
            background: white!important;
            box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
        }
        .next.slick-arrow{
            right: 0px;
        }
        .fc-button-primary{
            color:black!important;
            background: white!important;
            border: white!important;
            padding-left: 16px!important;
            padding-right: 16px!important;
        }
        .fc-button-primary.fc-button-active{
            color: #fff!important;
            background-color: black!important;
            background-image: none;
            border-radius: 8px!important;
            box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;

        }
        .fc .fc-toolbar.fc-header-toolbar{
            margin-bottom: 85px!important;
        }
        .border-warning .fc-event-main{
            border-left: 2px solid yellow;
        }
        .border-primary .fc-event-main{
            border-left: 2px solid blue;
        }
        .fc-event-main{
            text-align: justify!important;
            padding: 4px 0px 4px 6px!important;

            white-space: unset!important;
        }
        .fc-toolbar.fc-header-toolbar{
            background-color: #FFF4EE!important;
            padding: 11px 4px!important;
            border-radius: 5px;
        }
        .canceled{
            background-color: #FFD8E5!important;
            border: #FFD8E5!important;;
        }
        .canceled .fc-event-main{
            border-left: 2px solid #F685AA;
        }
        .canceled .bg-white.text-dark{
            background: #FF4646!important;
            color: white!important;
        }

        .working-time{
            color: #DB8B8B!important;
        }


        .completed{
            background-color: #D6F6D6!important;
            border: #D6F6D6!important;;
        }
        .completed .fc-event-main{
            border-left: 2px solid #56C156;
        }
        .completed .bg-white.text-dark{
            background: white!important;
            color: #56C156!important;
        }

        .pending{
            background-color: #CEEFFF!important;
            border: #CEEFFF!important;;
        }
        .pending .fc-event-main{
            border-left: 2px solid #5BC9FF;
        }
        .pending .bg-white.text-dark{
            background: white!important;
            color: #5BC9FF!important;
        }

        .running{
            background-color: #FDE3BF!important;
            border: #D6F6D6!important;;
        }
        .running .fc-event-main{
            border-left: 2px solid #FABA5F;
        }
        .running .bg-white.text-dark{
            background: white!important;
            color: #FABA5F!important;
        }


        /*.popper,
        .tooltip {
            position: absolute;
            z-index: 9999;
            background: #FFC107;
            color: black;
            width: 150px;
            border-radius: 3px;
            box-shadow: 0 0 2px rgba(0,0,0,0.5);
            padding: 10px;
            text-align: center;
        }
        .style5 .tooltip {
            background: #1E252B;
            color: #FFFFFF;
            max-width: 200px;
            width: auto;
            font-size: .8rem;
            padding: .5em 1em;
        }
        .popper .popper__arrow,
        .tooltip .tooltip-arrow {
            width: 0;
            height: 0;
            border-style: solid;
            position: absolute;
            margin: 5px;
        }

        .tooltip .tooltip-arrow,
        .popper .popper__arrow {
            border-color: #FFC107;
        }
        .style5 .tooltip .tooltip-arrow {
            border-color: #1E252B;
        }
        .popper[x-placement^="top"],
        .tooltip[x-placement^="top"] {
            margin-bottom: 5px;
        }
        .popper[x-placement^="top"] .popper__arrow,
        .tooltip[x-placement^="top"] .tooltip-arrow {
            border-width: 5px 5px 0 5px;
            border-left-color: transparent;
            border-right-color: transparent;
            border-bottom-color: transparent;
            bottom: -5px;
            left: calc(50% - 5px);
            margin-top: 0;
            margin-bottom: 0;
        }
        .popper[x-placement^="bottom"],
        .tooltip[x-placement^="bottom"] {
            margin-top: 5px;
        }
        .tooltip[x-placement^="bottom"] .tooltip-arrow,
        .popper[x-placement^="bottom"] .popper__arrow {
            border-width: 0 5px 5px 5px;
            border-left-color: transparent;
            border-right-color: transparent;
            border-top-color: transparent;
            top: -5px;
            left: calc(50% - 5px);
            margin-top: 0;
            margin-bottom: 0;
        }
        .tooltip[x-placement^="right"],
        .popper[x-placement^="right"] {
            margin-left: 5px;
        }
        .popper[x-placement^="right"] .popper__arrow,
        .tooltip[x-placement^="right"] .tooltip-arrow {
            border-width: 5px 5px 5px 0;
            border-left-color: transparent;
            border-top-color: transparent;
            border-bottom-color: transparent;
            left: -5px;
            top: calc(50% - 5px);
            margin-left: 0;
            margin-right: 0;
        }
        .popper[x-placement^="left"],
        .tooltip[x-placement^="left"] {
            margin-right: 5px;
        }
        .popper[x-placement^="left"] .popper__arrow,
        .tooltip[x-placement^="left"] .tooltip-arrow {
            border-width: 5px 0 5px 5px;
            border-top-color: transparent;
            border-right-color: transparent;
            border-bottom-color: transparent;
            right: -5px;
            top: calc(50% - 5px);
            margin-left: 0;
            margin-right: 0;
        }
        .badge.badge-outlined {
            background-color: transparent!important;
        }*/

    </style>




@endsection
@section('content')
    <div class="row page-title">
        <div class="col-md-12">
            <h4 class="mb-1 mt-1">Calendar</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="col-3" style="position:absolute;top: 40px">
                        <select class="form-control" style="width: 90%;height: 35px">
                            <option >Koaly Sala beauty</option>
                            <option >Alina Hair Style</option>
                            <option >Koaly Sala beauty</option>
                        </select>
                    </div>

                    <div class="col-12 py-2" style="top:84px;background: #F9F9FB;position: absolute;left: 19px;width: 96%;" >
                            <div class="center" >
                                <div>
                                    <img style="height: 60px;width: 60px!important;" class="rounded-circle m-auto" src="{{asset('image/employee-60ed78203fc97.jpg')}}" >
                                    <p class="mb-0 font-weight-bold text-dark  text-center" >Rabecca Sharon</p>
                                    <p class="mb-0 font-weight-bold text-center f11 working-time" >Working from 12:00-20:00</p>
                                </div>
                                <div>
                                    <img style="height: 60px;width: 60px!important;" class="rounded-circle m-auto" src="{{asset('image/employee-60f432b033183.jpg')}}" >
                                    <p class="mb-0 font-weight-bold text-center text-dark " >Elizabeth Lisa</p>
                                    <p class="mb-0 font-weight-bold text-center f11 working-time" >Working from 12:00-20:00</p>
                                </div>
                                <div>
                                    <img style="height: 60px;width: 60px!important;" class="rounded-circle m-auto" src="{{asset('image/employee-60f432fa67c9a.jpg')}}" >
                                    <p class="mb-0 font-weight-bold text-center text-dark " >Mighal Morn</p>
                                    <p class="mb-0 font-weight-bold text-center f11 working-time" >Working from 12:00-20:00</p>
                                </div>
                                <div>
                                    <img style="height: 60px;width: 60px!important;" class="rounded-circle m-auto" src="{{asset('image/employee-60f4327da5abc.jpg')}}" >
                                    <p class="mb-0 font-weight-bold text-dark  text-center" >Mishal</p>
                                    <p class="mb-0 font-weight-bold text-center f11 working-time" >Working from 12:00-20:00</p>
                                </div>
                                <div>
                                    <img style="height: 60px;width: 60px!important;" class="rounded-circle m-auto" src="{{asset('image/employee-60f432b033183.jpg')}}" >
                                    <p class="mb-0 text-dark  font-weight-bold text-center" >Michel Doe</p>
                                    <p class="mb-0 font-weight-bold text-center f11 working-time" >Working from 12:00-20:00</p>
                                </div>
                                <div>
                                    <img style="height: 60px;width: 60px!important;" class="rounded-circle m-auto" src="{{asset('image/employee-60ed78203fc97.jpg')}}" >
                                    <p class="mb-0 text-dark font-weight-bold text-center" >Michel Doe</p>
                                    <p class="mb-0 font-weight-bold text-center f11 working-time" >Working from 12:00-20:00</p>
                                </div>
                            </div>
                        </div>

                    <div id="kt_calendar"></div>
                </div>
            </div>
        </div>
    </div>







    @endsection
@section('js')
{{--    <script src='https://unpkg.com/popper.js/dist/umd/popper.min.js'></script>--}}
{{--    <script src='https://unpkg.com/tooltip.js/dist/umd/tooltip.min.js'></script>--}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
{{--    <script src="{{asset('calendar/fullcalendar.bundle.js')}}"></script>--}}
<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>




    <script>
        $(document).ready(function () {

            var KTCalendarBasic = function() {

                return {
                    //main function to initiate the module
                    init: function() {

                        var calendarEl = document.getElementById('kt_calendar');
                        var calendar = new FullCalendar.Calendar(calendarEl, {
                            // plugins: [ 'interaction', 'timeGrid', 'timeGrid', 'list', 'googleCalendar' ],
                            customButtons: {
                                myCustomButton: {
                                    text: 'Add New Appointment',
                                    click: function() {
                                        alert('clicked the custom button!');
                                    }
                                },
                                dropDown:{

                                }
                            },
                            headerToolbar: {
                                left: '',
                                center: 'prev,next',
                                right: 'myCustomButton resourceTimeGridDay,timeGridWeek,dayGridMonth'
                            },
                            views: {
                                resourceTimeGridTwoDay: {
                                    type: 'resourceTimeGrid',
                                    duration: { days: 2 },
                                    buttonText: '2 days',
                                }
                            },
                            initialView: 'resourceTimeGridDay',
                            resources: [
                                { id: 'a', title: ' ' },
                                { id: 'b', title: ' '},
                                { id: 'c', title: ' ' },
                                { id: 'd', title: ' ' }
                            ],

                            displayEventTime: false, // don't show the time column in list view

                            height: 900,
                            contentHeight: 880,
                            aspectRatio: 3,  // see: https://fullcalendar.io/docs/aspectRatio

                            // defaultView: 'timeGridDay',
                            editable: false,

                            navLinks: false,

                            // THIS KEY WON'T WORK IN PRODUCTION!!!
                            // To make your own Google API key, follow the directions here:
                            // http://fullcalendar.io/docs/google_calendar/
                            googleCalendarApiKey: 'AIzaSyDcnW6WejpTOCffshGDDb4neIrXVUA1EAE',

                            // eventRender: function(info) {
                            //     var tooltip = new Tooltip(info.el, {
                            //         title: info.event.extendedProps.description,
                            //         placement: 'top',
                            //         trigger: 'hover',
                            //         container: 'body'
                            //     });
                            // },

                            eventDidMount: function(info) {
                               info.el.querySelector('.fc-event-title').innerHTML =
                                   '<div class="row">' +
                                   '<div class="col-12">' +
                                   '<span class="float-left text-dark pt-1" style="font-size: 9px">'+info.event.extendedProps.duration+'' +
                                   '</span><span class="mr-1 float-right badge badge-outline badge-pill bg-white text-dark">'+info.event.extendedProps.status+'</span></div></div>'+
                                   '<span class="font-weight-bold text-dark">'+ info.event.title+'</span></br>'+
                                    '<span class="text-dark" style="font-size: 11px;">'+info.event.extendedProps.description+'</span>';
                            },
                            events: [

                                {
                                    resourceId:'d',
                                    title:'Celigo Johnson',
                                    start :'2021-08-26T11:00:00',
                                    end:'2021-08-26 14:45',

                                    className: " text-dark pending",
                                    description: 'Ladies - Hairline & Parting Heighlights/ Lowlights with haircuts & Style',
                                    extendedProps: {
                                        status: 'Pending',
                                        duration:'13:00-16:45',
                                        description: 'Ladies - Hairline & Parting Heighlights/ Lowlights with haircuts & Style',
                                    },
                                },
                                {
                                    resourceId:'a',
                                    title:'Celigo Johnson',
                                    start :'2021-08-19T11:00:00',
                                    end:'2021-08-19 14:45',

                                    className: " text-dark canceled",
                                    description: 'Ladies - Hairline & Parting Heighlights/ Lowlights with haircuts & Style',
                                    extendedProps: {
                                        status: 'Canceled',
                                        duration:'13:00-16:45',
                                        description: 'Ladies - Hairline & Parting Heighlights/ Lowlights with haircuts & Style',
                                    },
                                },

                                {
                                    resourceId:'a',
                                    title:'Celigo Johnson',
                                    start :'2021-08-23T13:00:00',
                                    end:'2021-08-23 15:45',

                                    className: " text-dark completed",
                                    description: 'Ladies - Hairline & Parting Heighlights/ Lowlights with haircuts & Style',
                                    extendedProps: {
                                        status: 'Completed',
                                        duration:'13:00-15:45',
                                        description: 'Ladies - Hairline & Parting Heighlights/ Lowlights with haircuts & Style',
                                    },
                                },
                                {
                                    resourceId:'b',
                                    title:'Celigo Johnson',
                                    start :'2021-08-23T13:00:00',
                                    end:'2021-08-23 16:45',

                                    className: " text-dark pending",
                                    description: 'Ladies - Hairline & Parting Heighlights/ Lowlights with haircuts & Style',
                                    extendedProps: {
                                        status: 'Pending',
                                        duration:'13:00-16:45',
                                        description: 'Ladies - Hairline & Parting Heighlights/ Lowlights with haircuts & Style',
                                    },
                                },
                                {
                                    resourceId:'b',
                                    title:'Celigo Johnson',
                                    start :'2021-08-23T09:00:00',
                                    end:'2021-08-23 10:45',

                                    className: "text-dark canceled",
                                    description: 'Ladies - Hairline & Parting Heighlights/ Lowlights with haircuts & Style',

                                    extendedProps: {
                                        status: 'Canceled',
                                        duration:'9:00-10:45',
                                        description: 'Ladies - Hairline & Parting Heighlights/ Lowlights with haircuts & Style',
                                    },
                                },
                                {
                                    resourceId:'c',
                                    title:'Celigo Johnson',
                                    start :'2021-08-23T16:00:00',
                                    end:'2021-08-23 17:45',

                                    className: " text-dark running",
                                    description: 'Ladies - Hairline & Parting Heighlights/ Lowlights with haircuts & Style',

                                    extendedProps: {
                                        status: 'Running',
                                        duration:'16:00-17:45',
                                        description: 'Ladies - Hairline & Parting Heighlights/ Lowlights with haircuts & Style',
                                    },
                                },


                                {
                                    resourceId:'d',
                                    title:'Celigo Johnson',
                                    start :'2021-08-24T18:00:00',
                                    end:'2021-08-24 11:45',

                                    className: " text-dark completed",
                                    description: 'Ladies - Hairline & Parting Heighlights/ Lowlights with haircuts & Style',
                                    extendedProps: {
                                        status: 'Completed',
                                        duration:'13:00-15:45',
                                        description: 'Ladies - Hairline & Parting Heighlights/ Lowlights with haircuts & Style',
                                    },
                                },

                                {
                                    resourceId:'a',
                                    title:'Celigo Johnson',
                                    start :'2021-08-24T11:00:00',
                                    end:'2021-08-24 14:45',

                                    className: " text-dark pending",
                                    description: 'Ladies - Hairline & Parting Heighlights/ Lowlights with haircuts & Style',
                                    extendedProps: {
                                        status: 'Pending',
                                        duration:'13:00-16:45',
                                        description: 'Ladies - Hairline & Parting Heighlights/ Lowlights with haircuts & Style',
                                    },
                                },
                                {
                                    resourceId:'c',
                                    title:'Celigo Johnson',
                                    start :'2021-08-24T06:00:00',
                                    end:'2021-08-24 09:45',

                                    className: "text-dark canceled",
                                    description: 'Ladies - Hairline & Parting Heighlights/ Lowlights with haircuts & Style',

                                    extendedProps: {
                                        status: 'Canceled',
                                        duration:'9:00-10:45',
                                        description: 'Ladies - Hairline & Parting Heighlights/ Lowlights with haircuts & Style',
                                    },
                                },

                                {
                                    resourceId:'d',
                                    title:'Celigo Johnson',
                                    start :'2021-08-29T11:00:00',
                                    end:'2021-08-29 14:45',

                                    className: " text-dark pending",
                                    description: 'Ladies - Hairline & Parting Heighlights/ Lowlights with haircuts & Style',
                                    extendedProps: {
                                        status: 'Pending',
                                        duration:'13:00-16:45',
                                        description: 'Ladies - Hairline & Parting Heighlights/ Lowlights with haircuts & Style',
                                    },
                                },

                                {
                                    resourceId:'c',
                                    title:'Celigo Johnson',
                                    start :'2021-08-01T06:00:00',
                                    end:'2021-08-01 09:45',

                                    className: "text-dark canceled",
                                    description: 'Ladies - Hairline & Parting Heighlights/ Lowlights with haircuts & Style',

                                    extendedProps: {
                                        status: 'Canceled',
                                        duration:'9:00-10:45',
                                        description: 'Ladies - Hairline & Parting Heighlights/ Lowlights with haircuts & Style',
                                    },
                                },
                            ],


                        });



                        calendar.render();
                    }
                };
            }();

            jQuery(document).ready(function() {
                KTCalendarBasic.init();
                // $('.fc-content').addClass('fc-event-title py-1');
                // $('.fc-event-title').removeClass('fc-content');
            });

        });
    </script>
    <script>
        $(document).ready(function () {
        $('.center').slick({

            slidesToShow: 4,
            prevArrow:'<button class="prev"><i class="fc-icon fc-icon-chevron-left"></i></button>',
            nextArrow: '<button class="next"><i class="fc-icon fc-icon-chevron-right"></i></button>',
            responsive: [
                {
                    breakpoint: 768,
                    settings: {
                        arrows: false,
                        centerMode: true,

                        slidesToShow: 1
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        arrows: false,
                        centerMode: true,

                        slidesToShow: 1
                    }
                }
            ]
        });
        });
    </script>

    @endsection
