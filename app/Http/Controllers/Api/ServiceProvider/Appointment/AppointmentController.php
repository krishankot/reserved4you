<?php

namespace App\Http\Controllers\Api\ServiceProvider\Appointment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use URL;
use Mail;
use File;
use Exception;
use Carbon\Carbon;
use App\Models\Appointment;
use App\Models\AppointmentData;
use App\Models\Category;
use App\Models\Customer;
use App\Models\PaymentMethodInfo;
use App\Models\Service;
use App\Models\ServiceAppoinment;
use App\Models\ServiceVariant;
use App\Models\StoreCategory;
use App\Models\StoreEmp;
use App\Models\StoreEmpTimeslot;
use App\Models\StoreProfile;
use App\Models\StoreRatingReview;
use App\Models\TempServiceStore;
use App\Models\User;
use App\Models\BookingTemp;
use App\Models\Notification;
use App\Models\ApiSession;
use DB;


class AppointmentController extends Controller
{
    //appoinmentList
    public function appointmentList(Request $request)
    {
        try {
            $data = request()->all();
			 $userId  = $request['user']['user_id'];
            if (empty($data['store_id'])){
				$getStore = StoreProfile::where('user_id', $userId)->pluck('id')->all();
			}else{
				 $getStore = StoreProfile::where('user_id',  $userId)->where('id', $data['store_id'])->pluck('id')->all();
			}
            $date = \Carbon\Carbon::now()->format('Y-m-d');
            $appStatus = array(
					['id' => 'all', 'value' => 'Alle'],
					['id' => 'booked', 'value' => 'Neu'],
					['id' => 'running', 'value' => 'Aktiv'],
					['id' => 'reschedule', 'value' => 'Verschoben'],
					['id' => 'completed', 'value' => 'Erledigt'],
					['id' => 'cancel', 'value' => 'Storniert'],
				);
			$records_per_page = 10;
			setlocale(LC_ALL, 'de_DE@euro', 'de_DE', 'de', 'ge');
			if(!empty($request['id'])){
				$appointmentPro = AppointmentData::whereIn('appointment_data.store_id', $getStore)->where('id', $request['id'])->first();
				$newDate  = $appointmentPro->appo_date." ".$appointmentPro->appo_time;
				$appointmentCount = AppointmentData::whereIn('appointment_data.store_id', $getStore)->whereRaw('concat(appo_date," ",appo_time) >= ?', "{$newDate}")->count();
				return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Successful', 'ResponseData' => ceil($appointmentCount/$records_per_page)], 200);
			}
			DB::statement("SET lc_time_names = 'de_DE'");
            $appointment = AppointmentData::leftjoin('appointments', 'appointments.id', '=', 'appointment_data.appointment_id')
					->leftjoin('payment_method_infos', 'payment_method_infos.appoinment_id', '=', 'appointments.id')
					->whereIn('appointment_data.store_id', $getStore)
					->select('appointment_data.*', 'payment_method_infos.status as payment_status', 'payment_method_infos.card_type as card_type','payment_method_infos.payment_method as payment_method',
						'appointments.user_id', 'appointments.order_id', 'appointments.first_name', 'appointments.last_name', 'appointments.email')
					->orderBy('appointment_data.appo_date', 'DESC')->orderBy('appointment_data.appo_time', 'DESC');
			
			if(!empty($request['page_status']) && $request['page_status'] != 'all'){
				$appointment = $appointment->where('appointment_data.status',$request['page_status']);
			}
			
			$search_term = !empty($request['search_term'])?trim($request['search_term']):Null;
				setlocale(LC_TIME, "de_DE");
			if(!empty($request['search_term'])){
				$appointment = $appointment->where(function($query) use($search_term){
					$query->whereRaw('concat(appointments.first_name," ",appointments.last_name) like ?', "%{$search_term}%")
							->orWhere('appointments.order_id', 'like', "%".str_replace("#",'',$search_term).'%')
							->orWhere('appointment_data.service_name', 'like', "%".$search_term.'%')
							->orWhere(DB::raw('DATE_FORMAT(appointment_data.appo_date, "%d %M, %Y (%a.)")'), 'like', "%".$search_term.'%')
							->orwhereHas('employeeDetails', function($q)  use($search_term){
								$q->where('emp_name', 'like',  "%".$search_term.'%');
							});
				});
			}
			$appointment =  $appointment->paginate($records_per_page);
            
			 foreach ($appointment as $row) {
				if ($row->status == 'completed') {
					$checkReview = StoreRatingReview::where('appointment_id', $row->id)->first();
					if (!empty($checkReview)) {
						//$row->is_reviewed = $checkReview;
						$row->is_reviewed = $checkReview->id;
						$row->total_avg_rating = $checkReview->total_avg_rating;
					} else {
						$row->is_reviewed = '';
						$row->total_avg_rating = '';
					}
					
				} else {
					$row->is_reviewed = '';
					$row->total_avg_rating = '';
				}
				$rrcount = Notification::where('appointment_id', $row->id)->where('type', 'review_request')->count();
				if($rrcount > 0){
					$row->review_requested = 1;
				}else{
					$row->review_requested = 0;
				}
				$row->employee_name = @$row->employeeDetails->emp_name;	
				$row->emp_image_path = @$row->employeeDetails->emp_image_path;	
				$row->image = Service::where('id', $row->service_id)->value('image');
				$row->appo_date = \Carbon\Carbon::parse($row['appo_date'])->translatedFormat('d F, Y').' ('. \Carbon\Carbon::parse($row['appo_date'])->translatedFormat('D').')';  
				$row->appo_time = \Carbon\Carbon::parse($row['appo_time'])->translatedFormat('H:i');
				$row->appo_end_time = \Carbon\Carbon::parse($row['appo_end_time'])->translatedFormat('H:i');
				$row->user_image_path = @$row->userDetails->user_image_path;	
				$row->category_name = @$row->categoryDetails->name;
				$row->subcategory_name = @$row->subCategoryDetails->name;
				$row->service_image_path = @$row->serviceDetails->service_image_path;
				$row->variant_description = @$row->variantData->description;
				$row->variant_duration_of_service = @$row->variantData->duration_of_service;
				$row->store_name  = @$row->storeDetails->store_name;
				$row->store_address  = @$row->storeDetails->store_address;
				$row->status_german = $row->status;
				$row->price = number_format($row->price, 2, ',', '.');
				if($row->status == 'booked' || $row->status == 'pending'){
					$row->status_german = $row->status == 'booked' ? 'Neu' : 'Steht aus';
				}elseif($row->status == 'running' || $row->status == 'reschedule'){
                      $row->status_german = $row->status == 'running' ? 'Aktiv' : 'Verschoben';
				}elseif($row->status == 'completed'){
                      $row->status_german = 'Erledigt';
                }elseif($row->status == 'cancel'){
					 $row->status_german = 'Storniert';
				}
				$row->payment_method = ucfirst($row->payment_method == 'cash' ? 'vor Ort' : ((strtolower($row->payment_method) == 'stripe' && !empty($row->card_type))?$row->card_type:$row->payment_method));
				$row->store_profile_image_path  = @$row->storeDetails->store_profile_image_path;
				$row->is_customer_exist  = \BaseFunction::checkCustomerExists($row->email, $row->store_id);
				$row->customer_request_status  = $requestStatus = \BaseFunction::isCustomerRequested(@$row['store_id'], @$row['user_id']);
				    
				unset($row->storeDetails,$row->userDetails,$row->employeeDetails,$row->serviceDetails,$row->orderInfo,$row->categoryDetails,$row->subCategoryDetails,$row->variantData);
			}
			 
			$service = Service::whereIn('store_id', $getStore)->where('status', 'active')->get();
			
           
            $data = [
                 'pageStatus'     => $appStatus,
                'appoinments' => $appointment,
                'service' => $service

            ];
            return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Successful', 'ResponseData' => $data], 200);
        } catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
    }
    //order history
    public function orderList(Request $request)
    {
        try {
            $data = request()->all();
            
            $userId  = $request['user']['user_id'];
            // $storeId = \BaseFunction::getStoreDetails($userId); 
            $storeId = $data['store_id'];
            $date = \Carbon\Carbon::now()->format('Y-m-d');
            $orderHistoryList = ServiceAppoinment::with('userDetails','employeeDetails','serviceDetails','orderInfo')->where('store_id',$storeId)
                                ->where(function ($query) use ($date) {
                                    $query->wheredate('appo_date', '<', $date)
                                        ->orWhereIn('status', ['cancel', 'completed']);
                                })->orderBy('appo_date', 'DESC');
            if (isset($data['date']) && $data['date'] != '') {
                $orderHistoryList = $orderHistoryList->whereDate('appo_date',$data['date']);
            }
            $orderHistoryList= $orderHistoryList->orderBy('id','DESC')->get();
            foreach ($orderHistoryList as $value) {  
                
                $value['user_name']         = $value['userDetails'] == null ? null : $value['userDetails']['first_name'].' '.$value['userDetails']['last_name'];
                $value['user_image_ path']  = $value['userDetails'] == null ? null : $value['userDetails']['user_image_path'];
                $value['service_name']      = $value['serviceDetails']['service_name'];
                $value['service_image']     = $value['serviceDetails']['service_image_path'];
                $value['service_price']     = $value['serviceDetails']['price'];
                $value['service_descount_type']  = $value['serviceDetails']['discount_type'];
                $value['service_final_price'] = number_format(\BaseFunction::finalPrice($value['serviceDetails']['id']),2);
                $value['service_descount']  = $value['serviceDetails']['discount'];
                $value['expert_id']         = @$value['employeeDetails'] == null ? null :$value['employeeDetails']['id'];
                $value['expert_name']       = @$value['employeeDetails'] == null ? null :$value['employeeDetails']['emp_name'];
                $value['expert_image']      = @$value['employeeDetails'] == null ? null :$value['employeeDetails']['emp_image_Path'];
                // $value['order_id']          = @$value['orderInfo']['order_id'];
                $value['total_paid']        = @$value['orderInfo']['total_amount'];
                $value['appo_date']         = date('M j, Y', strtotime($value['appo_date']));   
                $value['appo_time']         = date('h:i:s A', strtotime($value['appo_time']));   
                
                unset($value->userDetails,$value->employeeDetails,$value->serviceDetails,$value->orderInfo);
            }
            if ($orderHistoryList->isEmpty()) {
                return response()->json(['ResponseCode' => 0, 'ResponseText' => 'No data found', 'ResponseData' => NULL], 200);

            }
            $data = [
                'total_apppinment' => $orderHistoryList->count(),
                'orderHistoryList' => $orderHistoryList

            ];
            return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Successful', 'ResponseData' => $data], 200);
        }catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
    }

	public function appointmentDatePostponed(Request $request)
    {
		try {
            $data = request()->all();
            $userId = $data['user']['user_id'];
            $id = $request['id'];
			$appointmentData = array();
			$appointmentData['status'] = 'reschedule';
			$appointmentData['is_postponed'] = 'Yes';
			$apData  = AppointmentData::find($id);
			if($apData->status != 'booked'){
				return response()->json(['ResponseCode' => 0, 'ResponseText' => 'This appointment counld not be rescheduled', 'ResponseData' => null], 400);
			}
			
			$appointment = AppointmentData::where('id', $id)->update($appointmentData);
			if ($appointment) {
				$apData  = AppointmentData::find($id);
				$AppointmentAr = Appointment::where('id', $apData->appointment_id)->first();
				$pdate  = \Carbon\Carbon::parse($apData['appo_date'])->format('d.m.Y');
				$ptime  = \Carbon\Carbon::parse($apData['appo_time'])->format('H:i');
				$store_name = StoreProfile::where('id', $AppointmentAr['store_id'])->value('store_name');
				$Pdeatail = "Leider ist bei ". $store_name ." etwas dazwischen gekommen, weshalb dein Termin am ".$pdate." um ". $ptime." verschoben oder storniert werden muss.";
				 \BaseFunction::notification('Termin verschieben ?',$Pdeatail,'appointment',$id,$AppointmentAr['store_id'],$AppointmentAr['user_id'],$AppointmentAr['user_id'] == ''? 'guest' : '','users');
				
				//send postponed email to user
				 \BaseFunction::sendEmailNotificationAppointment($id, "reschedule");
				 
				 //Push Notification for postponed
					$PUSer = User::find($AppointmentAr['user_id']);
					if(!empty($PUSer->device_token) && !empty($PUSer->allow_notifications) && $PUSer->allow_notifications == 1){
						$sessioncount = ApiSession::where('user_id', $PUSer->id)->count();
						if($sessioncount > 0){
							$registerarion_ids = array($PUSer->device_token);
							\BaseFunction::sendPushNotification($registerarion_ids, 'Termin verschieben ?', $Pdeatail, NULL, NULL, $apData->appointment_id);
						}
					}
				  //PUSH Notification code ends 
					
				  return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Postponed successfully.', 'ResponseData' => null], 200);
			} else {
				return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
			}
		} catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
    }
	

    //apponment cancel
    public function appointmentCancel(Request $request)
    {
        try {
            $data = request()->all();
            $userId = $data['user']['user_id'];
            $appointment_id = $request['id'];
            $message = $request['cancel_reason'];  
			$serviceAppointment = AppointmentData::where('id', $appointment_id)->first();
			             
            $updateStatus = AppointmentData::where('id',$appointment_id)->update(['status' => 'cancel', 'cancelled_by' => 'store','cancel_reason' => $message]);            
            if ($updateStatus) {
				$variant_id  = $serviceAppointment['variant_id'];
				\BaseFunction::sendEmailNotificationAppointment($serviceAppointment['id'], "cancelled");
				$AppointmentAr = Appointment::where('id', $serviceAppointment['appointment_id'])->first();
				\BaseFunction::notification('Termin storniert !','Buchung wurde storniert','appointment',$serviceAppointment['id'],$AppointmentAr['store_id'],$AppointmentAr['user_id'],$AppointmentAr['user_id'] == ''? 'guest' : '', 'users');
				
				//Push Notification for cancellations
				$PUSer = User::find($AppointmentAr['user_id']);
				if(!empty($PUSer->device_token) && !empty($PUSer->allow_notifications) && $PUSer->allow_notifications == 1){
					$sessioncount = ApiSession::where('user_id', $PUSer->id)->count();
					if($sessioncount > 0){
						$registerarion_ids = array($PUSer->device_token);
						$pdate  = \Carbon\Carbon::parse($serviceAppointment['appo_date'])->format('d.m.Y');
						$ptime  = \Carbon\Carbon::parse($serviceAppointment['appo_time'])->format('H:i');
						$store_name = StoreProfile::where('id', $AppointmentAr['store_id'])->value('store_name');
						$Pdeatail = "Dein Termin am ". $pdate ." um ".$ptime." bei ". $store_name." wurde leider storniert.";
						$icon  = asset('storage/app/public/notifications/Cancellation.png');
						\BaseFunction::sendPushNotification($registerarion_ids, 'Stornierung!', $Pdeatail, NULL, NULL, $AppointmentAr['id']);
					}
				}
				
                $payment = PaymentMethodInfo::where('appoinment_id', $serviceAppointment['appointment_id'])->first();
				if (!empty($payment)) {
					if ($payment['payment_method'] == 'stripe' || $payment['payment_method'] == 'klarna' || $payment['payment_method'] == 'applepay' || $payment['payment_method'] == 'googlepay') {
						$stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
						if ($payment['payment_method'] == 'stripe') {
							$refund = $stripe->refunds->create([
								'charge' => $payment['payment_id'],
								'amount' => $serviceAppointment['price'] * 100,
								'reason' => 'requested_by_customer'
							]);
							$updatePayment = PaymentMethodInfo::where('id', $payment['id'])->update(['refund_id' => $refund['id'], 'status' => 'refund']);
							$updateRefund = AppointmentData::where('appointment_id', $appointment_id)->where('variant_id', $variant_id)->update(['refund_id' => $refund['id']]);
						} elseif ($payment['payment_method'] == 'klarna' || $payment['payment_method'] == 'applepay' || $payment['payment_method'] == 'googlepay') {
							$refund = $stripe->refunds->create([
								'payment_intent' => $payment['payment_id'],
								'amount' => $serviceAppointment['price'] * 100,
								'reason' => 'requested_by_customer'
							]);
							$updatePayment = PaymentMethodInfo::where('id', $payment['id'])->update(['refund_id' => $refund['id'], 'status' => 'refund']);
							$updateRefund = AppointmentData::where('appointment_id', $appointment_id)->where('variant_id', $variant_id)->update(['refund_id' => $refund['id']]);
						}
					}
					if ($payment['payment_method'] == 'cash'){
						$updatePayment = PaymentMethodInfo::where('id', $payment['id'])->update(['refund_id' => 'cash', 'status' => 'refund']);
					}
				}
				 return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Appoinment cancelled successfully.', 'ResponseData' => null], 200);
            }
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        } catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
    }
	
	
	  /**
      * check booking time available
      */
	public function createAppointment(Request $request)
    {
		try {
            $data = request()->all();
            $userId = $data['user']['user_id'];
			
			if(empty($request['store_id'])) {
				$getStore = StoreProfile::where('user_id',$userId)->value('id');
			} else {
				$getStore = StoreProfile::where('user_id', $userId)->where('id', $request['store_id'])->pluck('id')->all();
			}

			$storeCategory = StoreCategory::where('store_id', $getStore)->get();
			$categoryData = [];
			$cate_subcategoryData = [];
			foreach ($storeCategory as $row) {
				$row->categoryData = Category::where('id', $row->category_id)->first();
				$catlist[] = @$row->CategoryData->name;
				$subcategory = Category::where('main_category', $row->category_id)
					->join('services', 'services.subcategory_id', '=', 'categories.id')
					->where('services.store_id', $getStore)
					->select('categories.*')
					->groupBy('categories.id')
					->get();
				if (count($subcategory) > 0) {
					$categoryData[] = array(
						'categorys' => $row->categoryData,
						'subcategory' => $subcategory
					);

					$row->categoryData->sub_cate = $subcategory;

					$cate_subcategoryData[] = $row->categoryData;
				}
			}
			$service = Service::where('store_id', $getStore)->where('category_id', @$categoryData[0]['categorys']['id'])
				->where('subcategory_id', @$categoryData[0]['subcategory'][0]['id'])->where('status', 'active')->get();

			foreach ($service as $row) {
				$row->rating = \BaseFunction::finalRatingService($getStore, $row->id);
				$row->variants = ServiceVariant::where('store_id', $getStore)->where('service_id', $row->id)->get()->toArray();
			}
			$responseData = array('categoryData' => $categoryData, 'service' => $service, 'cate_subcategoryData' => $cate_subcategoryData);
			return response()->json(['ResponseCode' => 1, 'ResponseText' => 'success', 'ResponseData' => $responseData], 200);
		 } catch (\Swift_TransportException $e) {
             \Log::debug($e);
             return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
         }

    }

     /**
      * check booking time available
      */
     public function bookingTimeAvailable(Request $request)
     {
         try {
             $data = request()->all();                        
             
            $day = \Carbon\Carbon::parse($data['date'])->format('l');                        
                
             // $expertTimeDetail = StoreEmp::with(['EmpTimeSlot' =>function($query) use($day){
             //                     $query->where('day',$day);
             //                     }])->where('id',$data['emp_id'])->first();            
             $empTime = StoreEmpTimeslot::where('store_emp_id',$data['emp_id'])->where('day',$day)->first();             
             if(empty($empTime)){
                return response()->json(['ResponseCode' => 0, 'ResponseText' => "Worng emp id", 'ResponseData' => NULL], 400);
             }
            if ($empTime['is_off'] == 'on') {
                 return response()->json(['ResponseCode' => 0, 'ResponseText' => "this day holiday", 'ResponseData' => NULL], 200);
             }
            $timeDuration = $request['time'];
            if (empty($timeDuration)) {
                return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Worng service id.', 'ResponseData' => ''], 200);
            } 
             
             $ReturnArray = array ();// Define output            
             $StartTime    = strtotime ($empTime['start_time']); //Get Timestamp
             
             $EndTime      = strtotime ($empTime['end_time']); //Get Timestamp
             $AddMins  =  $timeDuration * 60;
             
             while ($StartTime <= $EndTime) //Run loop
             {
                 $ReturnArray[] = date ("H:i", $StartTime);
                 $StartTime += $AddMins; //Endtime check
             }
             
             $availableTime = [];
             //time slot
             foreach ($ReturnArray as $value) {                                                   
                 if ($value == '0:00') {
                     return response()->json(['ResponseCode' => 0, 'ResponseText' => "store is closed now.", 'ResponseData' => NULL], 200);
                 }
                 $time = ServiceAppoinment::where(['store_emp_id' => $data['emp_id'],'service_id' => $data['service_id']])
                         ->where('appo_date',$data['date'])->where('appo_time',$value)                        
                         ->first();                   
                 $time = $time == null ? '' : $time['appo_time'];            
                 $flag = '';
                 if (Carbon::parse($value) == Carbon::parse($time)) {                    
                     $flag = 'Booked';                    
                 }else{     
                     $flag = 'Available';
                 }
                 $availableTime [] = [
                     'time' => $value,
                     'flag' => $flag
                 ];
             }
             return response()->json(['ResponseCode' => 1, 'ResponseText' => "Successfully", 'ResponseData' => $availableTime], 200);
         } catch (\Swift_TransportException $e) {
             \Log::debug($e);
             return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
         }
     }

     /**
      * direct booking time available for store
      */

    public function getAvailableTimeDirectStore(Request $request)
    {
        $data = $request->all();               
        $date = $data['date'];
        $service_id = $data['service_id'];
        // $time = \BaseFunction::bookingAvailableTime($data['date'], $data['service_id']);
        $day = \Carbon\Carbon::parse($date)->format('l');
        
        $getStoreId = Service::where('id', $service_id)->first(); 
        
        if (empty($getStoreId)) {
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Worng service id.', 'ResponseData' => ''], 200);
        }       
        
        $storeTime = StoreTiming::where('store_id', $getStoreId['store_id'])->where('day', $day)->first();
        
        if (empty($storeTime) || $storeTime['is_off'] == 'on') {
            return response()->json(['ResponseCode' => 0, 'ResponseText' => "this day holiday", 'ResponseData' => NULL], 200);
        }
        $ReturnArray = array();// Define output
        $StartTime = strtotime($storeTime['start_time']); //Get Timestamp
        
        $EndTime = strtotime($storeTime['end_time']); //Get Timestamp
        
        $AddMins = $getStoreId['duration_of_service'] * 60;
        
        while ($StartTime <= $EndTime) //Run loop
        {
            $ReturnArray[] = date("H:i:s", $StartTime);
            $StartTime += $AddMins; //Endtime check            
        }
        
        $availableTime = [];
            
        foreach ($ReturnArray as $value) {            
            if ($value == '00:00') {
                return response()->json(['ResponseCode' => 0, 'ResponseText' => "store is closed now.", 'ResponseData' => NULL], 200);
            }
            $time = ServiceAppoinment::where(['service_id' => $service_id])
                ->where('appo_date', $date)->where('appo_time', $value)
                ->first();

            $time = $time == null ? '' : $time['appo_time'];
            $flag = '';
            if (Carbon::parse($value) == Carbon::parse($time)) {
                $flag = 'Booked';
            } else {
                $flag = 'Available';
            }
            $availableTime [] = [
                'time' => $value,
                'flag' => $flag
            ];
        }        
        // return $availableTime;
        if (count($availableTime) > 0) {
            return response()->json(['ResponseCode' => 1, 'ResponseText' => "Successfully", 'ResponseData' => $availableTime], 200);            
        } else {
            return response()->json(['ResponseCode' => 0, 'ResponseText' => "No time available", 'ResponseData' => []], 200);            
        }
    }

    //get available employeee
    public function getAvailableEmpService(Request $request)
    {
        $data = $request->all();        
        // $day = \Carbon\Carbon::parse($date)->format('l');

        $getStoreEmp = StoreEmpService::where('service_id', $data['service_id'])->pluck('store_emp_id')->all();
        
        $timeDuration = Service::where('id', $data['service_id'])->value('duration_of_service');
        $getServiceEmp = array();
        foreach ($getStoreEmp as $row){
            $empTime = StoreEmpTimeslot::where('store_emp_id', $row)->first();
            if(!empty($empTime)){             
                $employeeList = StoreEmp::where('id',$row)->first();
                $getServiceEmp[] = $employeeList;
            }

        }        
        if (count($getServiceEmp) > 0) {
            return response()->json(['ResponseCode' => 1, 'ResponseText' => "Successfully", 'ResponseData' => $getServiceEmp], 200);
        } else {
            return response()->json(['ResponseCode' => 0, 'ResponseText' => "No Emp available for this service", 'ResponseData' => []], 200);  
        }
    }

    /**
     * Add new appoinment for service provider
    */
    public function providerAddNewAppoinment(Request $request)
    {
        $rule = [
            'customer_name' => 'required',
            'customer_email' =>'required'                       
        ];

        $message = [
            'customer_name.required' => 'customer_name is required',            
            'customer_email.required' => 'customer_email is required',            
        ];

        $validate = Validator::make($request->all(), $rule, $message);

        if ($validate->fails()) {
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Validation Fails', 'ResponseData' => $validate->errors()->all()], 422);
        }
        try {
            $data = request()->all();
            $names = explode(" ", $data['customer_name']);
            
            $serviceDetails = Service::where('id', $data['service_id'])->first();
            if (empty($serviceDetails) && !empty($data['service_id'])) {
                return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Worng service id.', 'ResponseData' => ''], 200);
            }            
            
            $amount = \BaseFunction::finalPrice($serviceDetails['id']);
            
            $userDetails = User::with('userAddress')->where('id',$data['user']['user_id'])->first();
            
            $checkEmpId =StoreEmp::where('id',$data['emp_id'])->first();
            if (empty($checkEmpId) && !empty($data['emp_id'])) {
                return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Worng emp id.', 'ResponseData' => ''], 200);
            }            
            $newAppointmentData['user_id'] = $data['user']['user_id'];
            $newAppointmentData['store_id'] = $data['store_id'];
            $newAppointmentData['store_emp_id'] = $data['emp_id'];
            $newAppointmentData['service_id'] = $data['service_id'];
            $newAppointmentData['service_name'] = $serviceDetails['service_name'];
            $newAppointmentData['appo_date'] = \Carbon\Carbon::parse($data['app_date']);
            $newAppointmentData['appo_time'] = \Carbon\Carbon::parse($data['app_time'])->format('H:i:s');
            $newAppointmentData['status'] = 'booked';
            $newAppointmentData['order_id'] = \BaseFunction::orderNumber();
            $newAppointmentData['price'] = $amount;            
            $newAppointmentData['first_name'] = isset($names[0]) == false ? '' : $names[0];
            $newAppointmentData['last_name'] = isset($names[1]) == false ? '' : $names[1];
            $newAppointmentData['email'] = $data['customer_email']; 
            $newAppointmentData['phone_number'] = NULL;
            $newAppointmentData['appointment_type'] = 'service provider';

            $newAppointment = new ServiceAppoinment();
            $newAppointment->fill($newAppointmentData);
            if ($newAppointment->save()) {                            
                // $paymentinfo['user_id'] = $data['user']['user_id'];
                // $paymentinfo['store_id'] = $newAppointment['store_id'];
                // $paymentinfo['service_id'] = $newAppointment['service_id'];
                // $paymentinfo['order_id'] = $newAppointment['order_id'];
                // $paymentinfo['payment_id'] = NULL;
                // $paymentinfo['total_amount'] = $newAppointment['price'];                
                // $paymentinfo['status'] = 'pending';                

                // $paymentinfo['appoinment_id'] = $newAppointment['id'];
                // $paymentinfo['payment_method'] = 'cash';
                // $paymentinfo['payment_type'] = NULL;

                // $paymentDatas = new PaymentMethodInfo();
                // $paymentDatas->fill($paymentinfo);
                // $paymentDatas->save();
                return response()->json(['ResponseCode' => 1, 'ResponseText' => 'New Appoinment Added Successful!', 'ResponseData' => true], 200);
            }else{
                return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong.', 'ResponseData' => ''], 200);
            }
        } catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
    }

    /**
     * get store employee
     */

    public function getEmployee(Request $request)
    {
        try {
            $data = request()->all();
            $employeeList = StoreEmp::where('store_id',$data['store_id'])->select('id','emp_name','image')->get();
            if ($employeeList->count() <= 0) {
                return response()->json(['ResponseCode' => 0, 'ResponseText' => 'No data found', 'ResponseData' => NULL], 200);
            }
            return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Successful', 'ResponseData' => $employeeList], 200);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
	
	
	public function reviewRequest(Request $request)
    {
		try {
			$id = $request['id'];
			if ($id) {
				$apData  = AppointmentData::where('id', $id)->where('status', 'completed')->first();
				if(!empty($apData->appointment_id)){
					$AppointmentAr = Appointment::where('id', $apData->appointment_id)->first();
					$store_name = StoreProfile::where('id', $AppointmentAr['store_id'])->value('store_name');
					$message = "Hast du gerade einen Moment, um deinen Termin bei ".$store_name." zu bewerten ? ";
					 \BaseFunction::notification('Bewertungsanfrage !',$message,'review_request',$apData['id'],$AppointmentAr['store_id'],$AppointmentAr['user_id'],$AppointmentAr['user_id'] == ''? 'guest' : '','users');
					//Push Notification for cancellations
					$PUSer = User::find($AppointmentAr['user_id']);
					if(!empty($PUSer->device_token) && !empty($PUSer->allow_notifications) && $PUSer->allow_notifications == 1){
						$sessioncount = ApiSession::where('user_id', $PUSer->id)->count();
						if($sessioncount > 0){
							$registerarion_ids = array($PUSer->device_token);
							\BaseFunction::sendPushNotification($registerarion_ids, 'Bewertungsanfrage !', $message, NULL, NULL, $apData->appointment_id);
						}
					}
				  //PUSH Notification code ends 
					
					return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Requested', 'ResponseData' => NULL], 200);
				}else{
					return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Appointment not found', 'ResponseData' => NULL], 400);
				}
			} else {
				return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Appointment not found', 'ResponseData' => NULL], 400);
			}
		} catch (\Throwable $e) {
           \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
    }
	
	
	/***********************************************************************Create Appointment**********************************************************/
	
	public function getCategoryTimeslot(Request $request)
    {
		 try {
			 $data = request()->all();
			$userId = $data['user']['user_id'];
			
			if(empty($request['store_id'])) {
				$request['store'] = StoreProfile::where('user_id',$userId)->value('id');
			} else {
				$request['store'] = $request['store_id'];
			}
            
			$store = StoreProfile::findorFail($request['store']);
			if (file_exists('storage/app/public/store/' . $store['store_profile']) && $store['store_profile'] != '') {
				$store['store_profile'] = URL::to('storage/app/public/store/' . $store['store_profile']);
			} else {
				$store['store_profile'] = URL::to('storage/app/public/default/default_store.jpeg');
			}

			$category_name = Category::where('id', $request['category'])->first();
			if (file_exists('storage/app/public/category/' . $category_name['image']) && $category_name['image'] != '') {
				$category_name['image'] = URL::to('storage/app/public/category/' . $category_name['image']);
				$category_name['parse_image'] = file_get_contents($category_name['image']);
			} else {
				$category_name['image'] = URL::to('storage/app/public/default/default_store.jpeg');
			}

			$emplist = StoreEmp::leftjoin('store_emp_categories', 'store_emp_categories.store_emp_id', '=', 'store_emps.id')
				->where('store_emp_categories.category_id', $request['category'])
				->where('store_emps.store_id', $request['store'])
				->select('store_emps.*')
				->get();

			foreach ($emplist as $row) {
				if (file_exists('storage/app/public/store/employee/' . $row->image) && $row->image != '') {
					$row->image = URL::to('storage/app/public/store/employee/' . $row->image);
				} else {
					$row->image = NULL;
				}
			}
			$date = \Carbon\Carbon::now()->format('Y-m-d');

			$data = array(
				'store' => $store,
				'category' => $category_name,
				'emp_list' => $emplist,
				'date' => $date,
				'totalTime' => $request['time'],
			);

			if (!empty($store)) {
				 return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Successful', 'ResponseData' =>  $data], 200);
			} else {
				 return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
			}
		 } catch (\Throwable $e) {
           \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
    }
	

    
}
