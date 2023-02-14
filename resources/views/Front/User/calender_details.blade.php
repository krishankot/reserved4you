<div class="modal-body modal-body22">
    <div class="modals-profile-wrap">
        <div class="modals-modals-profile">
            @if(file_exists(storage_path('app/public/store/'.$row['storeData']['store_profile'])) && $row['storeData']['store_profile'] != '')
                <img src="{{URL::to('storage/app/public/store/'.$row['storeData']['store_profile'])}}" alt="">

            @else
                <img src="{{URL::to('storage/app/public/default/store_default.png')}}" alt="">
            @endif
        </div>
        <div class="modals-modals-info">
            <h6>Salon</h6>
            <h5>{{@$row['storeData']['store_name']}}</h5>
        </div>
    </div>
    <div class="modal-profile-address">
        <span><?php echo file_get_contents(URL::to('storage/app/public/Frontassets/images/profile/location.svg')) ?></span>
        <p>{{$row['storeData']['store_address']}}</p>
    </div>
    <div class="accordion" id="accordionExample">
        <div class="paymentaccordion">
            <a href="javascript:void(0)" class="payment-box-link" data-toggle="collapse"
               data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    <span
                                        class="payment-box-icon"><?php echo file_get_contents(URL::to('storage/app/public/category/' . @$row['categoryDetails']['image'])) ?></span>
                <h6>{{$row['categoryDetails']['name']}}</h6>
                <span class="downn-arroww"><i class="far fa-chevron-down"></i></span>
            </a>
            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                 data-parent="#accordionExample">
                <div class="payment-body-box">
                    <div class="payment-box-profile-wrap">
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
                    <div class="payment-item-infos">
                        <h5>{{@$row['subCategoryDetails']['name']}} - {{$row['service_name']}}</h5>
                        <h6>{{@$row['variantData']['description']}}</h6>
                        <div class="payment-item-infos-wrap">
                            <span>{{@$row['variantData']['duration_of_service']}} min</span>
                            <p>{{number_format($row['price'],2,',','.')}}€</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="modal-items-pricing">
        <h4>Gesamtbetrag <i> {{number_format($row['price'],2, ',', '.')}}€</i></h4>
        <h6>bezahlt mit {{strtolower($row['payment_method'] == 'cash'?'Vor Ort':$row['payment_method'])}}</h6>
    </div>
    @if(file_exists(storage_path('app/public/service/'.$row->image)) && $row->image != '')

        <div
            style="display: none">{{$imge = URL::to('storage/app/public/service/'.$row->image)}}</div>
    @else
        <div
            style="display: none">{{$imge = URL::to('storage/app/public/default/default-user.png')}}</div>
    @endif
    @if($row['cancellation'] == 'yes')
        <a href="#" class="btn btn-black btn-block btn-modal-cancel ask_cancel"
           data-id="{{@$row['variantData']['id']}}"
           data-order="{{$row['order_id']}}"
           data-appointment="{{$row['appointment_id']}}"
           data-image="{{$imge}}"
           data-service="{{$row['service_name']}}"
           data-description="{{@$row['variantData']['description']}}"
        >Cancel Booking</a>
        <a href="#" class="cancelation-policy">Read Cancelation Policy</a>
    @endif
</div>

