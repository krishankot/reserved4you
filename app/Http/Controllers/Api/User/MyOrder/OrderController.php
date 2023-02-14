<?php

namespace App\Http\Controllers\Api\User\MyOrder;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use URL;
use Mail;
use Exception;
use Carbon\Carbon;
use App\Models\Appointment;
use App\Models\PaymentMethodInfo;
use App\Models\AppointmentData;
use App\Models\ServiceVariant;
use App\Models\StoreProfile;
use App\Models\Service;
use App\Models\StoreEmp;
use App\Models\Notification;
use App\Models\User;
use App\Models\ApiSession;
use App\Models\StoreRatingReview;

class OrderController extends Controller
{
    /**
     * order  list
     *  */    

    public function orderList(Request $request)
    {
        try {
            $data = request()->all();            
	   $userId = $data['user_id'];
//            $userId = $data['user']['user_id'];            
            $date = \Carbon\Carbon::now()->format('Y-m-d');
            // $orderList = Appointment::with('orderInfo','orderExpert','orderExpert.EmpCategory','orderServiceDetails','storeDetails')->where('user_id',$userId)->pluck('id');            
            $orderList =Appointment::leftjoin('appointment_data','appointment_data.appointment_id','=','appointments.id')
                        ->leftjoin('payment_method_infos','payment_method_infos.appoinment_id','=','appointments.id')
                        ->select('appointment_data.*','payment_method_infos.status as payment_status','appointments.order_id')
                        ->where('appointments.user_id',$userId);            
            
            // dd($bookingserviceList);            
    		// $date = \Carbon\Carbon::now()->format('Y-m-d');
            // $orderList = ServiceAppoinment::with('orderInfo','orderExpert','orderExpert.EmpCategory','orderServiceDetails')->where('user_id',$userId);            
            // // dd($bookingserviceList);            
    		// if (request('status') == 'upcoming') {    			
            //     $orderList = $orderList->whereDate('appo_date', '>=', $date)->WhereNotIn('status',['cancel','completed'])
            //                 ->orderBy('appo_date','DESC');
            // }

            // if (request('status') == 'recent') {                   
            //     $orderList = $orderList->where(function ($query) use ($date) {
            //         $query->wheredate('appo_date', '<', $date)
            //             ->orWhereIn('status',['cancel','completed']);
            //     })
            //     ->orderBy('appo_date','DESC');
            // }
            //pending status
            if (request('status') == 'pending') {
                $orderList  = $orderList->where(function ($query)  {
                    $query->Where('appointment_data.status','pending')
                        ->orWhere('appointment_data.status','booked')
                        ->orWhere('appointment_data.status','reschedule')
                        ->orderBy('appointment_data.appo_date','Desc');
                });
                
            }

            // running status
            if (request('status') == 'running') {
                $orderList  = $orderList->Where('appointment_data.status','running')                
                                    ->orderBy('appointment_data.appo_date','Desc');
            }
            // completed status
            if (request('status') == 'completed') {                
                $orderList  = $orderList->Where('appointment_data.status','completed')                
                                        ->orderBy('appointment_data.appo_date','Desc');                
            }
            //cancel
            if (request('status') == 'cancel') {
                $orderList  = $orderList->Where('appointment_data.status','cancel')                
                                        ->orderBy('appointment_data.appo_date','Desc');
            }
    		$orderList = $orderList->get();
            
    		if (count($orderList) <= 0 ) {
                return response()->json(['ResponseCode' => 0, 'ResponseText' => 'No data found', 'ResponseData' => null], 200);
            }
			
            foreach ($orderList as  $value) {   
                // dump($value['variant_id']);                            
                $appo_data = $value['appo_date'].' '.$value['appo_time']; 
                // date('M d,Y',strtotime($appo_date)).' ('. date('D', strtotime($value['appo_date'])).')' 
				
				// $value['appo_date'] = \Carbon\Carbon::parse($value['appo_date'])->translatedFormat('M d, Y').' ('. \Carbon\Carbon::parse($value['appo_date'])->translatedFormat('D').')';  
				 $value['appo_date'] = \Carbon\Carbon::parse($value['appo_date'])->translatedFormat('d.m.Y');  
               // $value['appo_date'] = date('M d,Y',strtotime($value['appo_date'])).' ('. date('D', strtotime($value['appo_date'])).')';                                                   
                $value['appo_time'] = date('H:i', strtotime($value['appo_time']));   
               // $value['price'] = number_format(str_replace(",", '', $value['price']),2);    
				$value['price'] = number_format($value['price'],2);    			   
                $value['service_image'] = @$value['orderServiceDetails']['service_image_path'];
                $value['service_name']  = @$value['orderServiceDetails']['service_name'];
                $value->variantData = ServiceVariant::select('id','store_id','service_id','description','duration_of_service','price')->where('id',$value['variant_id'])->first();
                $value['service_price'] = @$value['orderServiceDetails']['price'];
                // $value['order_ids']      = @$value['orderInfo']['order_id'];
                $value['service_expert']= @$value['orderExpert']['emp_name'];
                $value['service_expert_imgae']= @$value['orderExpert']['emp_image_path'];
                $value['store_name'] = $value['storeDetails']['store_name'];
                $value['store_address'] = $value['storeDetails']['store_address'];
                $value['store_image'] = $value['storeDetails']['store_profile_image_path'];                                
                // $time = strtotime($appo_data);
                if (request('status') == 'running') {                                        
                    $value['remaining_time'] = \Carbon\Carbon::parse($appo_data)->diffForHumans(); //\BaseFunction::humanTiming($appo_data);                
                }
                
                if($value['status'] == 'pending' || $value['status'] == 'booked' ||$value['status'] == 'reschedule'){
                    $value['is_cancellation'] = \BaseFunction::checkCancelRatio($value->store_id,$value->appointment_id);                    
                } else {                    
                    $value['is_cancellation'] = '';
                }        

				if ($value->status == 'completed') {
					$checkReview = StoreRatingReview::where('appointment_id', $value->id)->first();
					if (!empty($checkReview)) {
						$value['is_reviewed'] = $checkReview;
					} else {
						$value['is_reviewed'] = '';
					}
					
				} else {
					$value['is_reviewed'] = '';
				}
				
                // dd('event happened '.\BaseFunction::humanTiming($time).' ago');
                /**
                 * expert category
                 */                
                // $category = array();
                // if(!empty($value->orderExpert->EmpCategory)){
                //     foreach ($value->orderExpert->EmpCategory as $key) {                         
                //         $category [] = @$key['EmpCategoryDetails']['name'];
                //     }                
                // }else{
                //     $category= [];
                // }                
                // $value->expert_category = $category;
                unset($value->orderInfo,$value->orderExpert,$value->orderServiceDetails,$value->storeDetails);

            }
            return response()->json(['ResponseCode' => 1, 'ResponseText' => 'sucessfull', 'ResponseData' => $orderList], 200);
        } catch (\Swift_TransportException $e) {
            dd($e);
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => __('Something went wrong'), 'ResponseData' => null], 400);
        }
    }    

    /**
     * order date postponed
     */
    public function orderDatePostPoned(Request $request)
    {
        $rule = [
            'date' => 'required',                       
        ];

        $message = [
            'date.required' => 'date is required',            
        ];

        $validate = Validator::make($request->all(), $rule, $message);

        if ($validate->fails()) {
            return response()->json(['ResponseCode' => 0, 'ResponseText' => __('Validation failed'), 'ResponseData' => $validate->errors()->all()], 422);
        }
        try {
            $data = request()->all();
            $userId = $data['user']['user_id'];
            $updateOrderDate = ServiceAppoinment::where('id',$data['appoinment_id'])->where('user_id',$userId)->update(['is_postponed'=>$data['date']]);
            if ($updateOrderDate) {
                return response()->json(['ResponseCode' => 1, 'ResponseText' => __('Appointment Postponed successfully'), 'ResponseData' => null], 200);
            }
            return response()->json(['ResponseCode' => 0, 'ResponseText' => __('Something went wrong'), 'ResponseData' => null], 400);
        } catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => __('Something went wrong'), 'ResponseData' => null], 400);
        }
    }

    /**
     * order cancellation
     */
    public function orderCancellationReason(Request $request)
    {
        $rule = [
            'cancel_reson_text' => 'required',                       
        ];

        $message = [
            'cancel_reson_text.required' => 'This field is requerid',            
        ];

        $validate = Validator::make($request->all(), $rule, $message);

        if ($validate->fails()) {
            return response()->json(['ResponseCode' => 0, 'ResponseText' => __('Validation failed'), 'ResponseData' => $validate->errors()->all()], 422);
        }
        try {

            $data = request()->all(); 
            $userId = $data['user']['user_id'];
            $appointment = $data['appoinment_id'];
            $variant_id = $data['variant_id'];
            $message = $data['cancel_reson_text']; 

            $serviceAppointment = AppointmentData::where('appointment_id', $appointment)->where('variant_id', $variant_id)->first();
            $appointmentData = Appointment::where('id', $appointment)->first();
            $updateAppointment = AppointmentData::where('appointment_id', $appointment)->where('variant_id', $variant_id)->update(['cancel_reason' => $message, 'status' => 'cancel', 'cancelled_by' => 'user']);
            
            if ($updateAppointment) {
				//send cancellation email to user
				\BaseFunction::sendEmailNotificationAppointment($serviceAppointment['id'], "cancelled");
				
                $payment = PaymentMethodInfo::where('appoinment_id',$serviceAppointment['appointment_id'])->first();                
                if($payment['payment_method'] == 'stripe' || $payment['payment_method'] == 'klarna' || $payment['payment_method'] == 'applepay' || $payment['payment_method'] == 'googlepay'){
                    $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));                    
                    if($payment['payment_method'] == 'stripe') {
                        $refund = $stripe->refunds->create([
                            'charge' => $payment['payment_id'],
                            'amount' => $serviceAppointment['price'] * 100,
                            'reason' => 'requested_by_customer'
                        ]);
                        $updatePayment = PaymentMethodInfo::where('id', $payment['id'])->update(['refund_id' => $refund['id'], 'status' => 'refund']);
                        $updateRefund = AppointmentData::where('appointment_id', $appointment)->where('variant_id', $variant_id)->update(['refund_id' => $refund['id']]);
                    } elseif ($payment['payment_method'] == 'klarna'  || $payment['payment_method'] == 'applepay' || $payment['payment_method'] == 'googlepay'){
                        $refund = $stripe->refunds->create([
                            'payment_intent' => $payment['payment_id'],                            
                            'amount' => $serviceAppointment['price'] * 100,
                            'reason' => 'requested_by_customer'
                        ]);
                        $updatePayment = PaymentMethodInfo::where('id', $payment['id'])->update(['refund_id' => $refund['id'], 'status' => 'refund']);
                        $updateRefund = AppointmentData::where('appointment_id', $appointment)->where('variant_id', $variant_id)->update(['refund_id' => $refund['id']]);
                    }
                }
				 if ($payment['payment_method'] == 'cash'){
					$updatePayment = PaymentMethodInfo::where('id', $payment['id'])->update(['refund_id' => 'cash', 'status' => 'refund']);
				}
				if($serviceAppointment['status'] == 'reschedule'){
					 /** push notification */
					$store_user_id  = StoreProfile::where('id',$serviceAppointment['store_id'])->value('user_id');
					$PUSer = User::find($store_user_id);
					if(!empty($PUSer->device_token)){
						$sessioncount = ApiSession::where('user_id', $PUSer->id)->count();
						if($sessioncount > 0){
							//$registerarion_ids = array($PUSer->device_token);
							$registerarion_ids = ApiSession::where('user_id', $PUSer->id)->pluck('device_token')->toArray(); 
							\BaseFunction::sendPushNotificationServiceProvider($registerarion_ids, 'Verschoben !',  'Buchung wurde storniert', NULL, $serviceAppointment['store_id'], $serviceAppointment['id'], 3);
						}
					}
					\BaseFunction::notification('verschoben !','Buchung wurde storniert','appointment',$serviceAppointment['id'],$serviceAppointment['store_id'],$appointmentData['user_id'],$appointmentData['user_id'] == ''? 'guest' : '');
				}else{
					  /** push notification */
					$store_user_id  = StoreProfile::where('id',$serviceAppointment['store_id'])->value('user_id');
					$PUSer = User::find($store_user_id);
					if(!empty($PUSer->device_token)){
						$sessioncount = ApiSession::where('user_id', $PUSer->id)->count();
						if($sessioncount > 0){
							//$registerarion_ids = array($PUSer->device_token);
							$registerarion_ids = ApiSession::where('user_id', $PUSer->id)->pluck('device_token')->toArray(); 
							\BaseFunction::sendPushNotificationServiceProvider($registerarion_ids, 'Termin storniert !',  'Buchung wurde storniert', NULL, $serviceAppointment['store_id'], $serviceAppointment['id'], 2);
						}
					}
					\BaseFunction::notification('Termin storniert !','Buchung wurde storniert','appointment',$serviceAppointment['id'],$serviceAppointment['store_id'],$appointmentData['user_id'],$appointmentData['user_id'] == ''? 'guest' : '');
				}
				//\BaseFunction::notification('Termin storniert !','Buchung wurde storniert','appointment',$appointment,$serviceAppointment['store_id'],$appointmentData['user_id'],$appointmentData['user_id'] == ''? 'guest' : '');
                return response()->json(['ResponseCode' => 1, 'ResponseText' =>  __('Order Cancelled successfully'), 'ResponseData' => null], 200);
            }
            return response()->json(['ResponseCode' => 0, 'ResponseText' => __('Something went wrong'), 'ResponseData' => null], 400);
        } catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => __('Something went wrong'), 'ResponseData' => null], 400);
        }
    }

    /**
     * get user appointment data day and month wise 
     */
    public function appointmentDayMonth(Request $request)
    {
        try {
            $date = $request['date'];                        
            $month = date("m",strtotime($date));
            $userId = $request['user']['user_id'];
            
            $appointmentsDay = AppointmentData::leftjoin('appointments', 'appointments.id', '=', 'appointment_data.appointment_id')
                            ->leftjoin('payment_method_infos', 'payment_method_infos.appoinment_id', '=', 'appointments.id')
                            ->where('appointments.user_id',$userId)
							 ->where('appointment_data.status', '!=', 'cancel')
                            ->where('appointment_data.appo_date','=',$date)
                            ->select('appointment_data.*', 'payment_method_infos.status as payment_status','payment_method_infos.payment_method', 'appointments.order_id')
                            ->get();                            
            $dateData = [];
            foreach ($appointmentsDay as $row) {               
                $endtime = \Carbon\Carbon::parse($row->appo_time)->addMinutes($row->variantData['duration_of_service'])->format('H:i:s');
                $startDate = date('H:i', strtotime("$row->appo_time"));
                $endDate = date('H:i', strtotime("$endtime"));
                if($row['status'] == 'pending' || $row['status'] == 'booked' ||$row['status'] == 'reschedule'){
                    $is_cancellation = \BaseFunction::checkCancelRatio($row->store_id,$row->appointment_id);                    
                } else {                    
                    $is_cancellation = '';
                } 

                // $row->der = $des;
                $dateData[] = array(
                    'app_id'=>$row->appointment_id,
                    'store_id'=>$row->store_id,
                    'category_id'=>$row->category_id,
                    'subcategory_id'=>$row->sub_category_id,
                    'service_id'=>$row->service_id,
                    'variant_id'=>$row->variant_id,
                    'emp_id'=>$row->emp_id,
                    'apoo_date'=>$row->appo_date,
                    'apoo_time'=>$row->appo_time,
					'status'=>$row->status,
                    'is_cancellation' => $is_cancellation,
                    'start'=>$startDate,
                    'end'=>$endDate,
                    'store_name'=>$row->storeDetails['store_name'],
                    'service_name'=>$row->serviceDetails['service_name'],
                    'service_variant_desc'=>!empty($row->variantData['description'])?$row->variantData['description']:NULL,
                );
            }
            /**
             * month wise data
             */                        
            $appointmentsMonth = AppointmentData::leftjoin('appointments', 'appointments.id', '=', 'appointment_data.appointment_id')
                            ->leftjoin('payment_method_infos', 'payment_method_infos.appoinment_id', '=', 'appointments.id')
                            ->where('appointments.user_id',$userId)
							 ->where('appointment_data.status', '!=', 'cancel')
                            // ->whereMonth('appointment_data.appo_date',$month)
                            ->orderBy('appointments.id','asc')
                            ->select('appointment_data.*', 'payment_method_infos.status as payment_status','payment_method_infos.payment_method', 'appointments.order_id')
                            ->get();    
                                  
            $monthData = [];
            foreach ($appointmentsMonth as $row) {               
                $endtime = !empty($row->variantData['duration_of_service'])?\Carbon\Carbon::parse($row->appo_time)->addMinutes($row->variantData['duration_of_service'])->format('H:i:s'):NULL;
                $startDate = date('H:i', strtotime("$row->appo_time"));
                $endDate = date('H:i', strtotime("$endtime"));
                if($row['status'] == 'pending' || $row['status'] == 'booked' ||$row['status'] == 'reschedule'){
                    $is_cancellation = \BaseFunction::checkCancelRatio($row->store_id,$row->appointment_id);                    
                } else {                    
                    $is_cancellation = '';
                }
                // $row->der = $des;
                $monthData[] = array(
                    'app_id'=>$row->appointment_id,
                    'store_id'=>$row->store_id,
                    'category_id'=>$row->category_id,
                    'subcategory_id'=>$row->sub_category_id,
                    'service_id'=>$row->service_id,
                    'variant_id'=>$row->variant_id,
                    'emp_id'=>$row->emp_id,
                    'apoo_date'=>$row->appo_date,
                    'apoo_time'=>$row->appo_time,
					'status'=>$row->status,
                    'is_cancellation'=>$is_cancellation,
                    'start'=>$startDate,
                    'end'=>$endDate,
                    'store_name'=>$row->storeDetails['store_name'],
                    'service_name'=>!empty($row->serviceDetails['service_name'])?$row->serviceDetails['service_name']:NULL,
                    'service_variant_desc'=>@$row->variantData['description'],
                );
            }
            $data = [
                'dateData'=>$dateData,
                'MonthData' =>$monthData
            ];
            return response()->json(['ResponseCode' => 1, 'ResponseText' => 'sucessfull', 'ResponseData' => $data], 200);
            
        } catch (\Swift_TransportException $e) {
            dd($e);
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => __('Something went wrong'), 'ResponseData' => null], 400);
        }
    }

    /**
     * get appointment details
     */
    public function getBookingDetails(Request $request)
    {
        try {
            $data = request()->all();
            $appoData = \BaseFunction::orderConformData($data['appointment_id']);
            $serviceData = '';
            foreach ($appoData['bookingData'] as $value) {                
                // if($data['service_id'] == $value['servicecategory'][0]['id']){                                        
                //     $serviceData = [
                //         'paymentInfo' => $appoData['paymentInfo'],
                //         'bookingData' => array($value)
                //     ];
                // }
                
                foreach ($value['servicecategory'] as $key) {
                    
                    if($data['service_id'] == $key['id']){                                        
                        $serviceData = [
                            'paymentInfo' => $appoData['paymentInfo'],
                            'bookingData' => [array(
                                    'id'=>$value->id,
                                    'name'=>$value->name,
                                    'image'=>$value->image,
                                    'emp_name'=>$value->emp_name,
                                    'emp_image'=>$value->emp_image,
                                    'appo_date'=>$value->appo_date,
                                    'appo_time'=>$value->appo_time,
                                    'category_image_path'=>$value->category_image_path,
                                    'servicecategory'=>array($key)
                            )]
                        ];
                    }
                }
            }
            if (empty($serviceData)) {
                return response()->json(['ResponseCode' => 0, 'ResponseText' => 'No data found', 'ResponseData' => []], 200);
            }            
            return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Success', 'ResponseData' => $serviceData], 200);
        } catch (\Swift_TransportException $e) {            
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => __('Something went wrong'), 'ResponseData' => null], 400);
        }
    }
}
