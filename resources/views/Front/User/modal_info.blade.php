<div class="row">
    <div class="col-12 p-0">
        <div class="appointment-item completed-item mb-0 p-0">
            <div class="appointment-profile-wrap py-4 px-3 mb-0 {{$appointmentDetail->status}}">
                <div class="appointment-profile-left mb-0">
                    <div class="appointment-profile-img">
                        @if(file_exists(storage_path('app/public/user/'.@$row->userDetails->profile_pic)) && @$row->userDetails->profile_pic != '')
                            <img src="{{URL::to('storage/app/public/user/'.@$row->userDetails->profile_pic)}}"
                                 class="rounded avatar-sm"
                                 alt="user">
                        @else
                            <img
                                src="https://via.placeholder.com/1080x1080/00000/FABA5F?text={{strtoupper(substr($row['first_name'], 0, 1))}}{{strtoupper(substr($row['last_name'], 0, 1))}}"
                                alt="user">
                        @endif
                    </div>
                    <div class="appointment-profile-info " style="width: 60%">
                        <h5 class="mb-1" >{{@$row->first_name}} {{@$row->last_name}}</h5>
                        <p  class="mb-1" >Buchungs-ID: <span> #{{$row->order_id}}</span></p>
                        <p  class="mb-1" >Uhrzeit: <span>{{date(Carbon\Carbon::parse($appointmentDetail->appo_time)->format('H:i'))}}-{{date(Carbon\Carbon::parse($appointmentDetail->app_end_time)->format('H:i'))}}</span>  </p>

                    </div>
                    <div class="text-right" style="width: 30%">
                        <p class="mb-1" >Zahlungsmethode vor Ort</p>
                        <h5 class="mb-1" >Gesamtbetrag {{number_format($appointmentDetail->price,2,',','.')}}€</h5>
                        <span class="{{$appointmentDetail->status}} mb-1">
                            <span class="badge badge-outline badge-pill bg-white text-dark py-1 text-capitalize {{$appointmentDetail->status}}-border">
                                @if($appointmentDetail->status=='running') aktiv
                                @elseif($appointmentDetail->status=='cancel') Storniert
                                @elseif($appointmentDetail->status=='completed') Erledigt
                                @elseif($appointmentDetail->status=='booked') Neu
								@elseif($appointmentDetail->status=='reschedule') Verschoben
                                @else {{$appointmentDetail->status}} @endif
                            </span>
                        </span>
                    </div>
                </div>

            </div>
            <div class="appointment-cato-wrap mt-2">
                <div class="appointment-cato-item">
                    <span>
                        <img src="{{asset(URL::to('storage/app/public/category/' . @$appointmentDetail->categoryDetails->image))}}"></span>
                    <h6>{{$appointmentDetail->categoryDetails->name}}</h6>
                </div>
                <div class="appointment-cato-date " style="background: none!important;">
                    <h6>{{\Carbon\Carbon::parse($appointmentDetail->appo_date)->translatedFormat('d F, Y')}}
                        ({{\Carbon\Carbon::parse($appointmentDetail->appo_date)->translatedFormat('D')}})</h6>
                    <span class="bg-white text-dark">{{\Carbon\Carbon::parse($appointmentDetail->appo_time)->format('H:i')}} </span>
                </div>
            </div>

            <div class="appointment-info-profile">
                    <span>
                         @if(file_exists(storage_path('app/public/store/employee/'.@$appointmentDetail->employeeDetails->image)) && @$appointmentDetail->employeeDetails->image != '')
                            <img src="{{URL::to('storage/app/public/store/employee/'.@$appointmentDetail->employeeDetails->image)}}"
                                 alt=""
                            >
                        @else
                            <img src="{{URL::to('storage/app/public/default/default-user.png')}}"
                                 alt=""
                            >
                        @endif
                    </span>
                <div>
                    <p>Mitarbeiter</p>
                    <h6>{{$appointmentDetail->store_emp_id == '' ? 'Any Employee' : @$appointmentDetail->employeeDetails->emp_name}}</h6>
                </div>
            </div>
            <div class="appointment-item-price-info">
                <h5>{{$appointmentDetail->subCategoryDetails->name}} - {{@$appointmentDetail->service_name}}</h5>
                <h6>{{@$appointmentDetail->variantData->description}} </h6>
                <p>{{@$appointmentDetail->variantData->duration_of_service}} min <strong>{{number_format($appointmentDetail->price, 2, ',', '.')}}€</strong></p>
            </div>
        </div>
    </div>
</div>
