@foreach($todayAppointment as $item =>$row)
    <li class="">
        <i>{{\Carbon\Carbon::parse($item)->format('H:i')}}</i>
        @foreach($row as $value)
            <div class="timeline-li-wrap">
                <div class="timeline-profile-wrap">
                    <div class="timeline-profile-top-wrap">
                        <div class="timeline-profile">
                            @if(file_exists(storage_path('app/public/user/'.@$value->userDetails->profile_pic)) && @$value->userDetails->profile_pic != '')
                                <img src="{{URL::to('storage/app/public/user/'.@$value->userDetails->profile_pic)}}"
                                     class="rounded avatar-sm"
                                     alt="user">
                            @else
                                <img class="rounded avatar-sm"
                                    src="https://via.placeholder.com/150x150/00000/FABA5F?text={{strtoupper(substr(@$value->first_name, 0, 1))}}{{strtoupper(substr(@$value->last_name, 0, 1))}}"
                                    alt="user">
                            @endif
                        </div>
                        <div class="timeline-profile-info">
                                @if($value->status == 'booked' || $value->status == 'pending')
                                    <span class="new-appointment-label"> {{$value->status == 'booked' ? 'Neu' : 'Steht aus'}}</span>
                                @elseif($value->status == 'running' || $value->status == 'reschedule')
                                    <span class="running-label"> {{$value->status == 'running' ? 'Aktiv' : 'Verschoben'}}</span>
                                @elseif($value->status == 'completed')
                                    <span class="completed-label"> Erledigt </span>
                                @elseif($value->status == 'cancel')
                                    <span class="cancel-label"> Storniert </span>
                                @endif

                            <h6>{{@$value->first_name}} {{@$value->last_name}}</h6>
                        </div>
                        <div class="timeline-profile-price">
                            <h6>  <span>{{$value->price}}€</span></h6>
                            <!-- <p>{{ucfirst($value->payment_method)}}</p> -->
                            <p>{{ucfirst($value->payment_method == 'cash' ? 'Bar' : ((strtolower($value->payment_method) == 'stripe' && !empty($value->card_type))?$value->card_type:$value->payment_method))}}</p>
                        </div>
                    </div>
                    <div class="timeline-profile-bottom-wrap">
                        <div>
                            <p>Buchungs-ID: <span> #{{$value->order_id}}</span></p>
                            <p>Uhrzeit : <span> {{\Carbon\Carbon::parse($value->appo_time)->format('H:i')}} - {{\Carbon\Carbon::parse($value->appo_time)->addMinutes(@$value->variantData->duration_of_service)->format('H:i')}}</span></p>
                        </div>
{{--                        <a href="#" class="btn btn-complete">Complete?</a>--}}
                    </div>
                </div>
                <div class="accordion" id="accordionExample">
                    <div class="timeline-card">
                        <a class="timeline-link" type="button" data-toggle="collapse"
                           data-target="#collapse{{$value->id}}" aria-expanded="false" aria-controls="collapse{{$value->id}}">
                           Gebuchter Service
                            <span class="arrow"><img
                                    src="{{URL::to('storage/app/public/Serviceassets/images/icon/down-arrow.svg')}}"
                                    alt=""></span>
                        </a>
                        <div id="collapse{{$value->id}}" class="collapse" aria-labelledby="heading{{$value->id}}"
                             data-parent="#accordionExample">
                            <div class="timeline-body ">
                                <div class="timeline-heading-label">
                                            <span>

                                                <?php echo file_get_contents(URL::to('storage/app/public/category/'.@$value->categoryDetails->image)) ?>
                                            </span>
                                    <h6>{{$value->categoryDetails->name}}</h6>
                                    {{--                                                <span class="timeline-time-box">23:52 min</span>--}}
                                </div>
                                <div class="timeline-profile-label">
                                    <p>Mitarbeiter</p>
                                    <div>
                                        <h6>{{$value->store_emp_id == '' ? 'Any Employee' : @$value->employeeDetails->emp_name}}</h6>
                                        <span>
                                                          @if(file_exists(storage_path('app/public/store/employee/'.@$value->employeeDetails->image)) && @$value->employeeDetails->image != '')
                                                <img src="{{URL::to('storage/app/public/store/employee/'.@$value->employeeDetails->image)}}"
                                                     alt=""
                                                >
                                            @else
                                                <img src="{{URL::to('storage/app/public/default/default-user.png')}}"
                                                     alt=""
                                                >
                                            @endif
                                                    </span>
                                    </div>
                                </div>
                                <div class="timeline-body-info">
                                    <p>{{$value->subCategoryDetails->name}} - {{@$value->service_name}} - {{@$value->variantData->description}}</p>
                                </div>
                                <div class="timeline-footer-price">
                                    <p>{{@$value->variantData->duration_of_service}} {{__('Min') }}</p>
                                    <h6>{{$value->price}}€</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </li>
@endforeach
