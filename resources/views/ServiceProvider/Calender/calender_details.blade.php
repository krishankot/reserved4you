<div class="modal-body modal-body22">
    <div class="appointment-profile-wrap {{$row['status'] == 'completed' ?'green-bg' :($row['status'] == 'cancel' ? 'red-bg':'orange-bg')}}">
        <div class="appointment-profile-left">
            <div class="appointment-profile-img">
                @if($row['is_login'] == 'yes')
                    @if(file_exists(storage_path('app/public/user/'.$row['userData']['profile_pic'])) && $row['userData']['profile_pic']!= '')
                        <img
                            src="{{URL::to('storage/app/public/user/'.$row['userData']['profile_pic'])}}"
                            alt="user">
                    @else
                        <img
                            src="https://via.placeholder.com/150x150/00000/FABA5F?text={{strtoupper(substr($row['first_name'], 0, 1))}}{{strtoupper(substr($row['last_name'], 0, 1))}}"
                            alt="user">
                    @endif
                @else
                    <img
                        src="https://via.placeholder.com/150x150/00000/FABA5F?text={{strtoupper(substr($row['first_name'], 0, 1))}}{{strtoupper(substr($row['last_name'], 0, 1))}}"
                        alt="user">
                @endif
            </div>
            <div class="appointment-profile-info">
                <h5>{{$row['first_name']}} {{$row['last_name']}} <a href="{{URL::to('dienstleister/kunden-details/'.encrypt($row['appointment_id']))}}">View Profile</a></h5>
                <ul class="appointment-d-block">
                    <li>
                        <p>Booking ID: <span> {{$row['order_id']}}</span></p>
                    </li>
                    <li>
                        <p>Service time: <span> {{\Carbon\Carbon::parse($row['appo_time'])->format('H:i')}} - {{\Carbon\Carbon::parse($row['app_end_time'])->format('H:i')}}</span></p>
                    </li>
                </ul>
            </div>
        </div>
        <div class="appointment-profile-right">
            <div class="app-payment-info-type mr-0">
                <p>Paid via {{ucfirst($row['payment_method'])}}</p>
                <h6 class="calender-price">Total Paid <span>{{number_format($row['price'],2,',','.')}}€</span></h6>
                <span class="{{$row['status'] == 'completed' ?'completed-label2' :($row['status'] == 'cancel' ? 'cancel-label2':'pending-label2')}}">
                    {{$row['status'] == 'booked' ? 'Neu' : ($row['status'] == 'pending' ? 'Steht aus' : ($row['status'] == 'running' ? 'Aktiv' : ($row['status'] == 'reschedule' ? 'Verschoben': ($row['status'] == 'completed' ? 'Erledigt': 'Storniert'))))}}
                </span>
            </div>
        </div>
    </div>
    <div class="appointment-div-bg">
        <div class="appointment-cato-wrap">
            <div class="appointment-cato-item">
                <span><?php echo file_get_contents(URL::to('storage/app/public/category/' . @$row['categoryDetails']['image'])) ?></span>
                <h6>{{$row['categoryDetails']['name']}}</h6>
            </div>
            <div class="appointment-cato-date">
                <h6>{{\Carbon\Carbon::parse($row['appo_date'])->translatedFormat('M d, Y (D)')}}</h6>
                <span>{{\Carbon\Carbon::parse($row['appo_time'])->format('H:i')}}</span>
            </div>
        </div>
        <div class="appointment-info-profile">
            @if($row['store_emp_id'] != '')
                <span><img
                        src="{{URL::to('storage/app/public/store/employee/'.\BaseFunction::getEmployeeDetails($row['store_emp_id'],'image'))}}"
                        alt=""></span>
                <div>
                    <p>Retained Stylist</p>
                    <h6>{{\BaseFunction::getEmployeeDetails($row['store_emp_id'],'emp_name')}}</h6>
                </div>
            @else
                <span><img
                        src="{{URL::to('storage/app/public/default/default-user.png')}}"
                        alt=""></span>
                <div>
                    <p>Retained Stylist</p>
                    <h6>Any Person</h6>
                </div>
            @endif
        </div>
        <div class="appointment-item-info">
            <h5>{{$row['subCategoryDetails']['name']}} - {{$row['service_name']}}</h5>
            <h6>{{$row['variantData']['description']}}</h6>
            <p>{{$row['variantData']['duration_of_service']}} {{__('Min') }} <strong>{{number_format($row['price'],2,',','.')}}€</strong></p>
        </div>
    </div>
</div>
