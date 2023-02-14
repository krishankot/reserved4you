<?php

namespace App\Http\Controllers\Api\ServiceProvider\Booking;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StoreEmp;
use App\Models\StoreEmpTimeslot;
use App\Models\AppointmentData;
use App\Models\Service;
use App\Models\Customer;
use App\Models\User;
use App\Models\StoreTiming;
use App\Models\StoreEmpService;
use App\Models\TempServiceStore;
use App\Models\Appointment;
use App\Models\BookingTemp;
use App\Models\ApiSession;
use App\Models\ServiceVariant;
use App\Models\PaymentMethodInfo;
use App\Models\StoreProfile;
use Validator;
use Carbon\Carbon;

class BookingController extends Controller
{
    
    //Appoinment book
    public function bookingTimeAvailable(Request $request)
    {	
        try {
            $data = request()->all();  
            $userId  = $request['user']['user_id'];
            if (empty($data['store_id'])){
				$request['store_id'] = $data['store_id'] = StoreProfile::where('user_id', $userId)->value('id');
			}
			
			
			if (isset($request['booking'])) {
				$booking = $request['booking'];
			} else {
				$booking = [];
			}
			   
			$request['time'] = TempServiceStore::leftjoin('service_variants', 'service_variants.id', '=', 'temp_service_stores.variant')->where('user_id', $userId)
                       ->where('category', $request['category_id'])->sum('duration_of_service');
			$getbookingData = TempServiceStore::where('user_id', $userId)->select('category','date','time')->get();
			if(count($getbookingData) > 0 ){
                foreach ($getbookingData as $value) {                    
                    $value['date'] = $value['date'] == null ? null: \Carbon\Carbon::parse($value['date'])->format('Y-m-d');                    
                    $value['timeslot'] = $value['time'] == null ? null:\Carbon\Carbon::parse($value['time'])->format("H:i");                                               
                }                
                $booking = $getbookingData;
            } else {
                $booking = [];
            }
			
			$time = \BaseFunction::bookingAvailableTimeEmp($request['date'], $request['store_id'], $request['time'], $request['category_id'], $request['emp_id'], $booking, 'mobileapp_service');
			$dowMap = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');

			$getdays = StoreEmpTimeslot::where('store_emp_id', $request['emp_id'])->get();
			$offday = [];
			if (count($getdays) > 0) {
				$getOffDays = StoreEmpTimeslot::where('store_emp_id', $request['emp_id'])->where('is_off', 'on')->get();
				foreach ($getOffDays as $row) {

					if (in_array($row->day, $dowMap)) {
						$offday[] = array_search($row->day, $dowMap);
					}
				}
			} else {
				$offday = [0, 1, 2, 3, 4, 5, 6];
			}

			if (count($time) > 0) {
				$responseData = array('timeslots' => $time, 'offdays' => $offday);
				 return response()->json(['ResponseCode' => 1, 'ResponseText' => "Successfully", 'ResponseData' => $responseData], 200);
			} else {
				return response()->json(['ResponseCode' => 0, 'ResponseText' => "NO Time Schedule Found. Please try another Date.", 'ResponseData' => NULL], 400);
			}
		} catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
    }
	
    //direct store booking time
    public function getAvailableTimeDirect(Request $request)
    {
        $data = $request->all();          
        $date = \Carbon\Carbon::parse($data['date'])->format('Y-m-d');
        $day = \Carbon\Carbon::parse($data['date'])->format('l');
        $av = $data['time'];
        $category = $data['category_id'];
       $getbookingData = TempServiceStore::where('user_id', $userId)
                        ->select('category','date','time')->get();
		if(count($getbookingData) > 0 ){
			foreach ($getbookingData as $value) {                    
				$value['date'] = $value['date'] == null ? null: \Carbon\Carbon::parse($value['date'])->format('Y-m-d');                    
				$value['timeslot'] = $value['time'] == null ? null:\Carbon\Carbon::parse($value['time'])->format("H:i");                                               
			}                
			$booking = $getbookingData;
		} else {
			$booking = [];
		}  
        $storeTime = StoreTiming::where('store_id', $data['store_id'])->where('day', $day)->first();

        if (empty($storeTime) || $storeTime['is_off'] == 'on') {
            return response()->json(['ResponseCode' => 0, 'ResponseText' => "NO Time Schedule Found. Please try another Date.", 'ResponseData' => NULL], 200);
        }
        $ReturnArray = array();// Define output
        $StartTime = strtotime($storeTime['start_time']); //Get Timestamp
        
        $EndTime = strtotime($storeTime['end_time']); //Get Timestamp
        
        $AddMins = 15 * 60;
        
        while ($StartTime <= $EndTime) //Run loop
        {
            $ReturnArray[] = date("H:i", $StartTime);
            $StartTime += $AddMins; //Endtime check            
        }
        $time = AppointmentData::where(['category_id' => $data['category_id']])
            ->where('store_id', $data['store_id'])
            ->where('appo_date', $date)
            ->whereIn('status',['booked','running','pending','','reschedule'])
            ->get();


        $countPartEmp = StoreEmp::join('store_emp_categories', 'store_emp_categories.store_emp_id', '=', 'store_emps.id')
            ->join('store_emp_timeslots', 'store_emp_timeslots.store_emp_id', '=', 'store_emps.id')
            ->where('store_emp_categories.category_id', $data['category_id'])
            ->where('store_emps.store_id', $data['store_id'])
            ->where('store_emps.worktype', 'Part-Time')
            ->where('store_emps.status', 'active')
            ->where('store_emp_timeslots.day', $day)
            ->select('store_emps.*', 'store_emp_timeslots.start_time', 'store_emp_timeslots.end_time', 'store_emp_timeslots.is_off')
            ->get();
        
            
        $currentTime = \Carbon\Carbon::now()->timezone('Europe/Berlin')->format("H:i");
        $availableTime = [];
        
            
        foreach ($ReturnArray as $value) {            
            if ($value == '0:00') {
                return response()->json(['ResponseCode' => 0, 'ResponseText' => "NO Time Schedule Found. Please try another Date.", 'ResponseData' => NULL], 200);
            }
            $i = 1;
            $flag = 'Available';

            $countEmp = StoreEmp::join('store_emp_categories', 'store_emp_categories.store_emp_id', '=', 'store_emps.id')
                        ->where('store_emp_categories.category_id', $data['category_id'])
                        ->where('store_emps.store_id', $data['store_id'])
                        ->where('store_emps.worktype', 'Full-Time')
                        ->where('store_emps.status', 'active')
                        ->count();

            foreach ($countPartEmp as $item) {
                if (\Carbon\Carbon::parse($value)->format("H:i:s") >= \Carbon\Carbon::parse($item['start_time'])->format("H:i:s") &&
                 \Carbon\Carbon::parse($value)->format("H:i:s") <= \Carbon\Carbon::parse($item['end_time'])->format("H:i:s") && $item['is_off'] == 'off') {
                    $countEmp = $countEmp + 1;
                }
            }

            foreach ($time as $row) {

                if (\Carbon\Carbon::parse($value)->format("H:i:s") >= \Carbon\Carbon::parse($row['appo_time'])->format("H:i:s") &&
                 \Carbon\Carbon::parse($value)->format("H:i:s") < \Carbon\Carbon::parse($row['app_end_time'])->format("H:i:s")) {
                    if ($i > $countEmp) {
                        $flag = 'Booked';
                        break;
                    } else {
                        $flag = 'Available';
                    }
                    $i++;

                } else {
                    $flag = 'Available';

                }

            }


            if (\Carbon\Carbon::parse($date)->toDateString() == \Carbon\Carbon::now()->timezone('Europe/Berlin')->toDateString()) {
                if (\Carbon\Carbon::parse($value)->format("H:i") > $currentTime) {
                    $availableTime [] = [
                        'time' => $value,
                        'flag' => $flag
                    ];
                }
            } else {
                $availableTime [] = [
                    'time' => $value,
                    'flag' => $flag
                ];
            }
        }    
        
        $up = [];
        $up1 = [];
        $times = 0;
        foreach ($availableTime as $item => $row) {            
            if ($row['flag'] == 'Available') {
                $times = $times + 15;
                $up[] = $row['time'];
                if ($times > $av) {
                    $up = array();
                    $times = 0;
                }
            } else {
                if ($times < $av) {
                    foreach ($up as $i) {
                        $key = array_search($i, array_column($availableTime, 'time'));
                        $up1[] = $key;
                    }
                    $up = array();
                    $times = 0;
                } else {
                    $times = 0;
                    $up = array();
                }

            }
        }
        foreach ($up1 as $i) {              
            $availableTime[$i]['flag'] = 'Booked';
        } 
        
        $ntimes = 0;
        $up12 = [];
        $up2 = [];

        foreach ($booking as $value) { 
                                  
            foreach ($availableTime as $item => $row) {

                if (\Carbon\Carbon::parse($value['appo_date'])->toDateString() == \Carbon\Carbon::parse($date)->toDateString() && (int)$value['category_id'] != $category) {
                    if ($value['appo_time'] <= $row['time']) {

                        $ntimes = $ntimes + 15;
                        
//                        dump($ntimes);
                        if ((int)$value['totalTime'] >= $ntimes) {

                            $up2[] = $row['time'];                            
                        }
                        
                        if ((int)$value['totalTime'] < $ntimes) {

                            $up2[] = $row['time'];
                            $ntimes = 0;
                            break;
                        }

                    }
                }
            }
        }

        foreach ($up2 as $i) {
            $key = array_search($i, array_column($availableTime, 'time'));
            $up12[] = $key;
        }

        foreach ($up12 as $i) {
            $availableTime[$i]['flag'] = 'Booked';
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
        $emplist = StoreEmp::leftjoin('store_emp_categories','store_emp_categories.store_emp_id','=','store_emps.id')
                    ->where('store_emp_categories.category_id',$request['category_id'])
                    ->where('store_emps.store_id',$request['store_id'])
                    ->select('store_emps.*')
                    ->get();
        // dd($emplist);
        // $getStoreEmp = StoreEmpService::where('service_id', $data['service_id'])->pluck('store_emp_id')->all();
        

        // $timeDuration = Service::where('id', $data['service_id'])->value('duration_of_service');
        
        // $getServiceEmp = array();
        // foreach ($getStoreEmp as $row){            
        //     $empTime = StoreEmpTimeslot::where('store_emp_id', $row)->first();            
        //     if(!empty($empTime)){             
        //         $employeeList = StoreEmp::where('id',$row)->first();
        //         $getServiceEmp[] = $employeeList;
        //     }
        // }          
        if (count($emplist) > 0) {
            return response()->json(['ResponseCode' => 1, 'ResponseText' => "Successfully", 'ResponseData' => $emplist], 200);
        } else {
            return response()->json(['ResponseCode' => 0, 'ResponseText' => "No Emp available for this service", 'ResponseData' => []], 200);  
        }
    }
	
	
	
	
	
	 public function proceedToPay(Request $request) {
		try {
			$data = request()->all();
			$userId = $data['user']['user_id'];
			
			if(empty($request['store_id'])) {
				$getStore = StoreProfile::where('user_id',$userId)->value('id');
			} else {
				$getStore = $request['store_id'];
			}
			
			$serviceData = TempServiceStore::where('user_id', $userId)->get()->toArray();
			$store = StoreProfile::where('id', $getStore)->first();
 
			$categoryData = [];
			$totaltime = 0;
			$totalamount = 0;
			foreach ($serviceData as $row) {
				$row['subcategory_name'] = \BaseFunction::getCategoryName($row['subcategory']);
				$variantData = \BaseFunction::variantData($row['variant']);
				$serviceData = \BaseFunction::serviceData($row['service']);
				$row['price_german'] = number_format($row['price'], 2, ',','.');
				$row['variant_data'] = $variantData;
				$row['service_data'] = $serviceData;
				$row['employee_name'] = \BaseFunction::getEmployeeDetails($row['employee'],'emp_name');
				$row['employee_image'] = \BaseFunction::getEmployeeDetails($row['employee'],'image');
				$row['employee_image'] = $row['employee_image'] != null?url('storage/app/public/store/employee/'.$row['employee_image']):NULL;
				$totaltime += @$variantData['duration_of_service'];
				$totalamount += $row['price'];
				$categoryData[$row['category']][] = $row;
			}

			$data = [];
			foreach ($categoryData as $key => $value) {
				$data[] = array(
					'category' => \BaseFunction::getCategoryDate($key),
					'employee_name' => !empty($value[0]['employee_name'])?$value[0]['employee_name']:NULL,
				    'employee_image' =>  !empty($value[0]['employee_image'])?$value[0]['employee_image']:NULL,
					'date' =>  !empty($value[0]['date'])?\Carbon\Carbon::parse($value[0]['date'])->translatedFormat('d-m-Y'):NULL,
					'time' =>  !empty($value[0]['time'])?\Carbon\Carbon::parse($value[0]['time'])->translatedFormat('H:i'):NULL,
					'selectedService' => $value,
					'totaltime' => $totaltime
				);
			}
			$customer  = Customer::where('store_id',$getStore)->get();
			$responseData  = [
								'data' => $data,
								'store' => $store,
								'totalamount' => $totalamount,
								 'totalamount_german' => number_format($totalamount, 2, ',', '.'),
								'customer' => $customer
							 ];
			return response()->json(['ResponseCode' => 1, 'ResponseText' => "Successfully", 'ResponseData' => $responseData], 200);
		} catch (\Throwable $e) {
           \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
    }
	
	
	
	public function checkoutPayment(Request $request)
    {
		try{
			$data = request()->all();
			$userId = $data['user']['user_id'];
			
			if(empty($request['store_id'])) {
				$store_id = StoreProfile::where('user_id',$userId)->value('id');
			} else {
				$store_id = $request['store_id'];
			}
			$rule = [
				'first_name' => 'required',
				'email' => 'required|email', 
				'phone_number' => 'nullable|min:11|max:13', 
			];

			$message = [
				'first_name.required' => 'Bitte den Vornamen eingeben',           
				'email.required' => 'Bitte die E-Mail Adresse eingeben',
				'email.email' => 'Bitte die E-Mail Adresse eingeben',
				'phone_number.min' => 'Bitte geben Sie eine gültige Telefonnummer ein',
				'phone_number.max' => 'Bitte geben Sie eine gültige Telefonnummer ein',
				'phone_number.numeric' => 'Bitte geben Sie eine gültige Telefonnummer ein',
			];

			$validate = Validator::make($request->all(), $rule, $message);

			if ($validate->fails()) {
				return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Validation Fails', 'ResponseData' => $validate->errors()->all()], 422);
			}
			
			
			$data = $request->all();
			
			 $checkval = $this->sameBookingChecking(json_decode($data['AppoData']), $store_id);
			
			if($checkval['status'] == 'false'){
				$remove = BookingTemp::whereIn('id',$checkval['id'])->delete();
				return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Timeslot is not availbale', 'ResponseData' => []]);
			}
			
			 $value = $this->checkBooking(json_decode($data['AppoData']), $store_id);

			if(count($value) > 0){
				$remove = BookingTemp::whereIn('id',$checkval['id'])->delete();
				return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Timeslot is not availbale', 'ResponseData' => []]);
			} 
			
			$amount = $request['totalAmount'];

			$charge_id = 'Cash';
			$payment_method = 'cash';
			$status = 'booked';


			$getEmail = User::where('email', $data['email'])->first();
			if (!empty($getEmail)) {
				$appointmentData['user_id'] = $getEmail['id'];
			}
			$appointmentData['first_name'] = $data['first_name'];
			$appointmentData['last_name'] = $data['last_name'];
			$appointmentData['email'] = $data['email'];
			$appointmentData['phone_number'] = $data['phone_number'];

			$appointmentData['store_id'] = $store_id;
			$appointmentData['order_id'] = \BaseFunction::orderNumber();
			$appointmentData['appointment_type'] = 'service-provider';
			$appointmentData['total_amount'] = $data['totalAmount'];

			$appointment = new Appointment();
			$appointment->fill($appointmentData);
			if ($appointment->save()) {
				 $appoData = json_decode($data['AppoData']); 
				 
				 $this->storeAppoData($appoData,$appointment['id'],$store_id, $status);
				
				$paymentinfo['store_id'] = $appointment['store_id'];
				$paymentinfo['order_id'] = $appointment['order_id'];
				$paymentinfo['payment_id'] = $charge_id;
				$paymentinfo['total_amount'] = $appointment['total_amount'];
				$paymentinfo['status'] = 'succeeded';
				$paymentinfo['appoinment_id'] = $appointment['id'];
				$paymentinfo['payment_method'] = $payment_method;
				$paymentinfo['payment_type'] = 'withdrawn';

				$paymentDatas = new PaymentMethodInfo();
				$paymentDatas->fill($paymentinfo);
				$paymentDatas->save();


				$paymentSuccess['price'] = $appointment['total_amount'];
				$paymentSuccess['order_id'] = $appointment['order_id'];
				$paymentSuccess['appoinment_id'] = $appointment['id'];
				$paymentSuccess['payment_type'] = $payment_method;

				$responseData  = array('payment_data' => $paymentSuccess, 'payment_status' => 'success', 'appointment_id' => $appointment['id']);
				//\BaseFunction::notification('Neue Buchung !','Sie haben eine neue Buchung erhalten','appointment',$appointment['id'],$appointment['store_id'],$appointment['user_id'],$appointment['user_id'] == ''? 'guest' : '','users');
			   \BaseFunction::notification('Neue Buchung !','Glückwunsch! Für dich wurde gerade ein Termin gebucht.','appointment',$appointment['id'],$appointment['store_id'],$appointment['user_id'],$appointment['user_id'] == ''? 'guest' : '','users');
				//send appointmentment confirmation email to user
				\BaseFunction::sendEmailNotificationAppointmentConfirmation($appointment['id']);
				$checkSameStore = TempServiceStore::where('user_id', $userId)->delete();
				if(!empty($checkval['id'])){
					BookingTemp::whereIn('id',$checkval['id'])->delete();
				}
				
				 return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Order Confirmed', 'ResponseData' => $responseData], 200);

			}
			 return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
		} catch (\Throwable $e) {
           \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
    }
	
	
	public function orderConfirmation(Request $request)
    {
		try{
			$data = request()->all();
			$userId = $data['user']['user_id'];
			
			$status = $request->payment_status;
			$appointment_id = $request->appointment_id;
			
			if(empty($request['store_id'])) {
				$store_id = StoreProfile::where('user_id',$userId)->value('id');
			} else {
				$store_id = $request['store_id'];
			}
			
			$appointment = Appointment::where('id', $appointment_id)->first(['order_id', 'first_name', 'last_name', 'email', 'phone_number', 'total_amount']);
			$appointment->total_amount = number_format($appointment->total_amount, 2, ',', '.');
		   // $store = StoreProfile::findorFail($store_id);
			$serviceData = AppointmentData::where('appointment_id', $appointment_id)->get();
		   // $paymentinfo = PaymentMethodInfo::where('appoinment_id', $appointment_id)->first();
			$appointmentData = [];

			foreach ($serviceData as $row) {

				$row['subcategory_name'] = \BaseFunction::getCategoryName($row['subcategory_id']);
				$row['appo_date'] =  \Carbon\Carbon::parse($row['appo_date'])->translatedFormat('d-m-Y');
				$row['appo_time'] =  \Carbon\Carbon::parse($row['appo_time'])->translatedFormat('H:i');
				$row['employee_name'] = \BaseFunction::getEmployeeDetails($row['store_emp_id'],'emp_name');
				$row['employee_image'] = \BaseFunction::getEmployeeDetails($row['store_emp_id'],'image');
				$row['employee_image'] = $row['employee_image'] != null?url('storage/app/public/store/employee/'.$row['employee_image']):NULL;
				$variantData = \BaseFunction::variantData($row['variant_id']);
				$serviceDatas = \BaseFunction::serviceData($row['service_id']);
			   // $row['variant_data'] = $variantData;
				$row['variant_description'] = !empty($variantData['description'])?$variantData['description']:NULL;
				$row['duration_of_service'] = !empty($variantData['duration_of_service'])?$variantData['duration_of_service']:NULL;
				$row['service_name'] = !empty($serviceDatas['service_name'])?$serviceDatas['service_name']:NULL;
				$row['price'] = number_format($row['price'], 2, ',', '.');
				$appointmentData[$row['category_id']][] = $row;
			}

			$data = [];
			foreach ($appointmentData as $key => $value) {
			   $data[] = array(
					'category' => \BaseFunction::getCategoryDate($key),
					'employee_name' => !empty($value[0]['employee_name'])?$value[0]['employee_name']:NULL,
				    'employee_image' =>  !empty($value[0]['employee_image'])?$value[0]['employee_image']:NULL,
					'appo_date' =>  !empty($value[0]['appo_date'])?\Carbon\Carbon::parse($value[0]['appo_date'])->translatedFormat('d-m-Y'):NULL,
					'appo_time' =>  !empty($value[0]['appo_time'])?\Carbon\Carbon::parse($value[0]['appo_time'])->translatedFormat('H:i'):NULL,
					'items' => $value,
				);
			
			}

			$responseData  = array('appointment' => $appointment,  'data' => $data);
			return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Order Confirmed', 'ResponseData' => $responseData], 200);
		} catch (\Throwable $e) {
           \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
    }
	
	public function storeAppoData($data, $appo_id, $store_id, $status)
    {
        $catvalue = [];
        foreach ($data as $value) {
            $catvalue[$value->category][] = $value;            
        }
        

        foreach ($catvalue as $key => $row) {
            $cate_id = '';
            $newTime = '';
            foreach ($row as $value) {  
                
                if(empty($newTime)){
                    $start_time = \Carbon\Carbon::parse($value->time)->format('H:i');
                }  else {
                    $start_time = \Carbon\Carbon::parse($newTime)->format('H:i');
                }
                
                $getTimeDuration = ServiceVariant::where('id',$value->variant)->value('duration_of_service');
                $endTime = \Carbon\Carbon::parse($start_time)->addMinutes($getTimeDuration)->format('H:i');
                $newTime = $endTime;
				
				$cur_date = \Carbon\Carbon::now()->timezone('Europe/Berlin')->format('Y-m-d');
				$cur_time = \Carbon\Carbon::now()->timezone('Europe/Berlin')->format('H:i');
				
				if(!empty($value->date) && $cur_date == $value->date){
					if($endTime <= $cur_time){
						$status = 'completed';
					}
					if($newTime <= $cur_time && $endTime > $cur_time){
						$status = 'running';
					}
				}
                
                $subData['appointment_id'] = $appo_id;
                $subData['store_id'] = $store_id;
                $subData['category_id'] = $value->category;
                $subData['subcategory_id'] = $value->subcategory;
                $subData['service_id'] = $value->service;
                $subData['service_name'] = $value->service_name;
                $subData['variant_id'] = $value->variant;
                $subData['price'] = $value->price;
                $subData['status'] = $status;
                $subData['store_emp_id'] = $value->employee;
                $subData['appo_date'] = $value->date;
                $subData['appo_time'] = $start_time;
                $subData['app_end_time'] = $endTime;
                $appData = new AppointmentData();
                $appData->fill($subData);
                $appData->save();
				$appointment  = Appointment::where('id', $appo_id)->first();
				if(!empty($appointment['user_id'])){
					//Push Notification for cancellations
					$PUSer = User::find($appointment['user_id']);
					if(!empty($PUSer->device_token) && !empty($PUSer->allow_notifications) && $PUSer->allow_notifications == 1){
						$sessioncount = ApiSession::where('user_id', $PUSer->id)->count();
						if($sessioncount > 0){
							$registerarion_ids = array($PUSer->device_token);
							$pdate  = \Carbon\Carbon::parse($subData['appo_date'])->format('d.m.Y');
							$ptime  = \Carbon\Carbon::parse($subData['appo_time'])->format('H:i');
							$store_name = StoreProfile::where('id', $subData['store_id'])->value('store_name');
							$Pdeatail = "Glückwunsch! Für dich wurde gerade ein Termin bei ". $store_name."  gebucht.";
							$icon  = asset('storage/app/public/notifications/Cancellation.png');
							\BaseFunction::sendPushNotification($registerarion_ids, 'Neue Buchung!', $Pdeatail, NULL, NULL, $appointment['id']);
						}
					}
					//PUSH Notification code ends 
				}
            }
        }
        
		return true;
    }
	
	
	/**same sameBookingChecking */
    public function sameBookingChecking($data,$store_id){        
        $store = $store_id;        
        $appoData = [];
        foreach($data as $value) {                
            $appoData['category'][] = $value->category;        
            $appoData['subcategory'][] = $value->subcategory;        
            $appoData['store'][] = $store;        
            $appoData['date'][] = $value->date;        
            $appoData['employee'][] = $value->employee;        
            $appoData['time'][] = $value->time;        
            $appoData['price'][] = $value->price;        
            $appoData['variant'][] = $value->variant;        
            $appoData['service'][] = $value->service;        
            $appoData['service_data'][] = $value->service_name;        
        }
		
        return $data = \BaseFunction::sameBookingCheckingApi($appoData, 'service');  
    }

    /**
     * check booking
     */
    public function checkBooking($data,$store_id)
    {
        $store = $store_id;        
        $appoData = [];
        foreach($data as $value) {                
            $appoData['category'][] = $value->category;        
            $appoData['subcategory'][] = $value->subcategory;        
            $appoData['store'][] = $store;        
            $appoData['date'][] = $value->date;        
            $appoData['employee'][] = $value->employee;        
            $appoData['time'][] = $value->time;        
            $appoData['price'][] = $value->price;        
            $appoData['variant'][] = $value->variant;        
            $appoData['service'][] = $value->service;        
            $appoData['service_data'][] = $value->service_name;          
        }
        
        // dd($appoData);
        return $data = \BaseFunction::checkBooking($appoData);  
    }
	
	
	
	public function bookAgain(Request $request)
    {
		try {
			$data = request()->all();
			$userId = $data['user']['user_id'];
			
			if(empty($request['store_id'])) {
				$getStore = StoreProfile::where('user_id',$userId)->value('id');
			} else {
				$getStore = $request['store_id'];
			}
			$getServiceData = AppointmentData::where('id', $request['id'])->first();

			$checkSameStore = TempServiceStore::where('user_id', $userId)->where('store_id', $getServiceData['store_id'])->get();
			$removeServices = TempServiceStore::where('user_id', $userId)->delete();

			$newData['user_id'] = $userId;
			$newData['service'] = $getServiceData['service_id'];
			$newData['category'] = $getServiceData['category_id'];
			$newData['subcategory'] = $getServiceData['subcategory_id'];
			$newData['variant'] = $getServiceData['variant_id'];
			$newData['price'] = $getServiceData['price'];
			$newData['store_id'] = $getServiceData['store_id'];

			$Bookingagain = new TempServiceStore();
			$Bookingagain->fill($newData);
			if ($Bookingagain->save()) {
				return response()->json(['ResponseCode' => 1, 'ResponseText' => 'success', 'ResponseData' => null], 200);
			} else {
				 return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
			}
		} catch (\Throwable $e) {
           \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
    }
	
}
