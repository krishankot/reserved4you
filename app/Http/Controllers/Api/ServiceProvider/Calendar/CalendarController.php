<?php

namespace App\Http\Controllers\Api\ServiceProvider\Calendar;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\AppointmentData;
use App\Models\Customer;
use App\Models\Service;
use App\Models\ServiceVariant;
use App\Models\StoreEmp;
use App\Models\StoreEmpTimeslot;
use App\Models\StoreEmpBreakslot;
use App\Models\StoreProfile;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Auth;
use DB;

class CalendarController extends Controller
{
    public function calendar(Request $request){
		try{
			$userId  = $request['user']['user_id'];
			$store_id = !empty($request['store_id'])?$request['store_id']:NULL;
            if (empty($request['store_id'])){
				$getStore = StoreProfile::where('user_id', $userId)->pluck('id')->all();
			}else{
				 $getStore = StoreProfile::where('user_id',  $userId)->where('id', $request['store_id'])->pluck('id')->all();
			}
			$employee = StoreEmp::whereIn('store_id',$getStore)->get();
			
			$date  = $request['date']?$request['date']: \Carbon\Carbon::now()->timezone('Europe/Berlin')->format('Y-m-d');
			$day = \Carbon\Carbon::parse($date)->timezone('Europe/Berlin')->format('l');
			foreach ($employee as $val){
				$val->time = StoreEmpTimeslot::where('day',$day)->where('store_emp_id',$val->id)->first();
				$breaks = StoreEmpBreakslot::where('store_emp_id',$val->id)->where(function($query) use($date){ $query->whereDate('day', '=', $date)->orWhere('everyday', 'on');})->orderBy('day', 'asc')->orderBy('start_time', 'desc')->get();
				$appointmentsArr = [];
				foreach($breaks as $break){
					$results['id'] = $break['id'];
					$results['appo_time'] = $break['start_time'];
					$results['app_end_time'] = $break['end_time'];
					$results['status'] = 'break';
					$results['everyday'] = $break['everyday'];
					$results['app_date'] = $break['day'];
					$startTime = \Carbon\Carbon::parse($break->start_time);
					$finishTime = \Carbon\Carbon::parse($break->end_time);
					$break->duration_of_break  = (String)$finishTime->diffInMinutes($startTime);
					$results['duration_of_service'] = $break->duration_of_break;
					$results['store_emp_id'] = $break['store_emp_id'];
					$appointmentsArr[] = $results;
				}
				//$val->breaks = $breaks;
				$appointments = AppointmentData::leftjoin('appointments', 'appointments.id', '=', 'appointment_data.appointment_id')
					->leftjoin('payment_method_infos', 'payment_method_infos.appoinment_id', '=', 'appointments.id')
					->leftjoin('service_variants', 'service_variants.id', '=', 'appointment_data.variant_id')
					->whereIn('appointments.store_id',$getStore)->where('appointment_data.store_emp_id',$val->id)
					->where('appointment_data.appo_date', $date)
					->select('appointment_data.*', DB::raw('DATE_FORMAT(appointment_data.appo_time, "%H:%i") as appo_time'), DB::raw('DATE_FORMAT(appointment_data.app_end_time, "%H:%i") as app_end_time'), 'payment_method_infos.status as payment_status','payment_method_infos.payment_method', 'appointments.order_id',
						'appointments.user_id','appointments.first_name','appointments.last_name','appointments.email','service_variants.duration_of_service')
					->orderBy('appointment_data.appo_time', 'ASC')->get();
				
				foreach($appointments as $appointment){
					$results = array();
					$results['id'] = $appointment['id'];
					$results['appo_time'] = $appointment['appo_time'];
					$results['app_end_time'] = $appointment['app_end_time'];
					$results['store_emp_id'] = $appointment['store_emp_id'];
					$results['status'] = $appointment['status'];
					$startTime = \Carbon\Carbon::parse($appointment->appo_time);
					$finishTime = \Carbon\Carbon::parse($appointment->app_end_time);
					$appointment->duration_of_service  = (String)$finishTime->diffInMinutes($startTime);
					$results['duration_of_service'] = $appointment->duration_of_service;
					$results['appointment_id'] = $appointment->appointment_id;
					$results['price'] = $appointment->price;
					$results['first_name'] = $appointment->first_name;
					$results['last_name'] = $appointment->last_name;
					$results['order_id'] = $appointment->order_id;
					$results['appo_date'] = $appointment->appo_date;
					$results['service_name'] = $appointment->service_name;
					$appointmentsArr[] = $results;
				}
				
				$calander = [];
				//array_multisort( array_column($appointmentsArr, "appo_time"), SORT_ASC, $appointmentsArr );
				array_multisort(array_column($appointmentsArr, "appo_time"), SORT_ASC, array_column($appointmentsArr, "app_end_time"), SORT_ASC, $appointmentsArr);
				$val->appointments = $appointmentsArr; //$appointmentsArr; //array_merge((array)$appointments, (array)$breaks);
			}
			return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Successful', 'ResponseData' => $employee], 200);
        }catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
    }
	
	
	
	 public function calendarMonthViewOLD(Request $request){
		try{
			$userId  = $request['user']['user_id'];
			$store_id = !empty($request['store_id'])?$request['store_id']:NULL;
            if (empty($request['store_id'])){
				$getStore = StoreProfile::where('user_id', $userId)->pluck('id')->all();
			}else{
				 $getStore = StoreProfile::where('user_id',  $userId)->where('id', $request['store_id'])->pluck('id')->all();
			}
			$employee = StoreEmp::where('store_id',$getStore)->get();
			
			$start_date  = $request['start_date']?$request['start_date']: \Carbon\Carbon::now()->startOfMonth()->timezone('Europe/Berlin')->format('Y-m-d');
			$end_date  = $request['end_date']?$request['end_date']: \Carbon\Carbon::now()->endOfMonth()->timezone('Europe/Berlin')->format('Y-m-d');
			
			$date = \Carbon\Carbon::now()->timezone('Europe/Berlin')->format('Y-m-d');
			$day = \Carbon\Carbon::parse($date)->timezone('Europe/Berlin')->format('l');
			foreach ($employee as $val){
				$val->time = StoreEmpTimeslot::where('day',$day)->where('store_emp_id',$val->id)->first();
			}
			
			$all_employees  = StoreEmp::where('store_id',$getStore)->pluck('id')->toArray();
			
			$appointments = AppointmentData::leftjoin('appointments', 'appointments.id', '=', 'appointment_data.appointment_id')
					->leftjoin('payment_method_infos', 'payment_method_infos.appoinment_id', '=', 'appointments.id')
					->whereIn('appointments.store_id',$getStore);
			if(!empty($request['emp_id'])){
				$appointments = $appointments->where('appointment_data.store_emp_id',$request['emp_id']);
			}else{
				$appointments = $appointments->whereIn('appointment_data.store_id', $getStore);
				//$appointments = $appointments->whereIn('appointment_data.store_emp_id',$all_employees);
			}
					
					
			$appointments = $appointments->whereBetween('appointment_data.appo_date', [$start_date, $end_date])
					->select('appointment_data.*', DB::raw('DATE_FORMAT(appointment_data.appo_time, "%H:%i") as appo_time'), DB::raw('DATE_FORMAT(appointment_data.app_end_time, "%H:%i") as app_end_time'),  'payment_method_infos.status as payment_status','payment_method_infos.payment_method', 'appointments.order_id',
						'appointments.user_id','appointments.first_name','appointments.last_name','appointments.email')
					->get();
			
			$responseData  = array('employees' => $employee, 'appointments' => $appointments);
			return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Successful', 'ResponseData' => $responseData], 200);
        }catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
    }
	
	
	public function calendarMonthView(Request $request){
		try{
			$userId  = $request['user']['user_id'];
			$store_id = !empty($request['store_id'])?$request['store_id']:NULL;
            if (empty($request['store_id'])){
				$getStore = StoreProfile::where('user_id', $userId)->pluck('id')->all();
			}else{
				 $getStore = StoreProfile::where('user_id',  $userId)->where('id', $request['store_id'])->pluck('id')->all();
			}
			$employee = StoreEmp::whereIn('store_id',$getStore)->get();
			
			$start_date  = $request['start_date']?$request['start_date']: \Carbon\Carbon::now()->startOfMonth()->timezone('Europe/Berlin')->format('Y-m-d');
			$end_date  = $request['end_date']?$request['end_date']: \Carbon\Carbon::now()->endOfMonth()->timezone('Europe/Berlin')->format('Y-m-d');
			
			$date = \Carbon\Carbon::now()->timezone('Europe/Berlin')->format('Y-m-d');
			$day = \Carbon\Carbon::parse($date)->timezone('Europe/Berlin')->format('l');
			foreach ($employee as $val){
				$val->time = StoreEmpTimeslot::where('day',$day)->where('store_emp_id',$val->id)->first();
			}
			
			$all_employees  = StoreEmp::whereIn('store_id',$getStore)->pluck('id')->toArray();
			
			$sdate  = $request['start_date']? \Carbon\Carbon::parse($request['start_date'])->startOfMonth()->timezone('Europe/Berlin')->format('d'): \Carbon\Carbon::now()->startOfMonth()->timezone('Europe/Berlin')->format('d');
			
			$start_dateAr = \Carbon\Carbon::createFromFormat('Y-m-d', $start_date);

			$end_dateAr = \Carbon\Carbon::createFromFormat('Y-m-d', $end_date);

			$edate  = $start_dateAr->diffInDays($end_dateAr);
			
			$apData = array();
			
			$breakData = array();
			
			for($di = 0; $di <= $edate; $di++){
				$newDatae  = \Carbon\Carbon::parse($start_date)->addDays($di)->format('Y-m-d');
				
				$appointments = AppointmentData::leftjoin('appointments', 'appointments.id', '=', 'appointment_data.appointment_id')
						->leftjoin('payment_method_infos', 'payment_method_infos.appoinment_id', '=', 'appointments.id')
						->whereIn('appointments.store_id',$getStore);
				if(!empty($request['emp_id'])){
					$appointments = $appointments->where('appointment_data.store_emp_id',$request['emp_id']);
				}else{
					$appointments = $appointments->whereIn('appointment_data.store_id', $getStore);
					//$appointments = $appointments->whereIn('appointment_data.store_emp_id',$all_employees);
				}
				
				if(!empty($request['emp_id'])){
					$breaks = StoreEmpBreakslot::where('store_emp_id',$request['emp_id'])->where(function($query) use($newDatae){ $query->whereDate('day', '=', $newDatae)->orWhere('everyday', 'on');})->orderBy('day', 'asc')->orderBy('start_time', 'desc')->get();
				}else{
					$breaks = StoreEmpBreakslot::whereIn('store_id', $getStore)->where(function($query) use($newDatae){ $query->whereDate('day', '=', $newDatae)->orWhere('everyday', 'on');})->orderBy('day', 'asc')->orderBy('start_time', 'desc')->get();
				}
				$appointmentsArr = [];
				foreach($breaks as $break){
					$results['id'] = $break['id'];
					$results['appo_time'] = $break['start_time'];
					$results['app_end_time'] = $break['end_time'];
					$results['status'] = 'break';
					$results['everyday'] = $break['everyday'];
					$results['app_date'] = $break['day'];
					$startTime = \Carbon\Carbon::parse($break->start_time);
					$finishTime = \Carbon\Carbon::parse($break->end_time);
					$break->duration_of_break  = (String)$finishTime->diffInMinutes($startTime);
					$results['duration_of_service'] = $break->duration_of_break;
					$results['store_emp_id'] = $break['store_emp_id'];
					$appointmentsArr[] = $results;
				}
				
				//$breakData[$newDatae] = $breaks; 
						
						
				$appointments = $appointments->where('appointment_data.appo_date', '=', $newDatae)
						->select('appointment_data.*', DB::raw('DATE_FORMAT(appointment_data.appo_time, "%H:%i") as appo_time'), DB::raw('DATE_FORMAT(appointment_data.app_end_time, "%H:%i") as app_end_time'),  'payment_method_infos.status as payment_status','payment_method_infos.payment_method', 'appointments.order_id',
							'appointments.user_id','appointments.first_name','appointments.last_name','appointments.email')
						->get();
				foreach($appointments as $appointment){
					$results = array();
					$results['id'] = $appointment['id'];
					$results['appo_time'] = $appointment['appo_time'];
					$results['app_end_time'] = $appointment['app_end_time'];
					$results['store_emp_id'] = $appointment['store_emp_id'];
					$results['status'] = $appointment['status'];
					$startTime = \Carbon\Carbon::parse($appointment->appo_time);
					$finishTime = \Carbon\Carbon::parse($appointment->app_end_time);
					/* if(empty($appointment->duration_of_service)){
						$appointment->duration_of_service  = (String)$finishTime->diffInMinutes($startTime);
					} */
					$appointment->duration_of_service  = (String)$finishTime->diffInMinutes($startTime);
					$results['duration_of_service'] = $appointment->duration_of_service;
					$results['appointment_id'] = $appointment->appointment_id;
					$results['price'] = $appointment->price;
					$results['first_name'] = $appointment->first_name;
					$results['last_name'] = $appointment->last_name;
					$results['order_id'] = $appointment->order_id;
					$results['appo_date'] = $appointment->appo_date;
					$results['service_name'] = $appointment->service_name;
					$appointmentsArr[] = $results;
				}
				array_multisort(array_column($appointmentsArr, "appo_time"), SORT_ASC, array_column($appointmentsArr, "app_end_time"), SORT_ASC, $appointmentsArr);	
				
				
				$apData[$newDatae]['total_breaks'] = count($breaks);
				$apData[$newDatae]['total_appointments'] = count($appointments);
				$apData[$newDatae]['appointments'] = $appointmentsArr; 
			}
			
			$responseData  = array('employees' => $employee, 'appointments' => $apData);
			return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Successful', 'ResponseData' => $responseData], 200);
        }catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
    }
	
	public function AppointmentDetail(Request $request)
    {
		try{
			$userId  = $request['user']['user_id'];
			if(!empty($request['id'])){
				$id = $request['id'];
				$appointmentDetail = AppointmentData::leftjoin('payment_method_infos', 'payment_method_infos.appoinment_id', '=', 'appointment_data.appointment_id')->where('appointment_data.id', $id)->first(['appointment_data.*', 'payment_method_infos.status as payment_status','payment_method_infos.card_type as card_type','payment_method_infos.payment_method as payment_method']);
				$appointmentDetail->first_name = @$appointmentDetail->appointmentDetails->first_name;
				$appointmentDetail->last_name = @$appointmentDetail->appointmentDetails->last_name;
				$appointmentDetail->order_id = @$appointmentDetail->appointmentDetails->order_id;
				if(!empty($appointmentDetail->payment_method) && strtolower($appointmentDetail->payment_method) == 'cash'){
					$appointmentDetail->payment_method = "Zahlungsmethode: vor Ort";
				}elseif(!empty($appointmentDetail->payment_method) && strtolower($appointmentDetail->payment_method) == 'stripe' && !empty($appointmentDetail->card_type)){
					$appointmentDetail->payment_method = "Zahlungsmethode: ". $appointmentDetail->card_type;
				}elseif(!empty($appointmentDetail->payment_method)){
					$appointmentDetail->payment_method = "Zahlungsmethode: ". ucfirst($appointmentDetail->payment_method);
				}else{
					$appointmentDetail->payment_method = "Zahlungsmethode vor Ort";
				}
				$appointmentDetail->category_name  = @$appointmentDetail->categoryDetails->name;
				$appointmentDetail->category_image_path  = @$appointmentDetail->categoryDetails->category_image_path;
				
				$appointmentDetail->subcategory_name  = @$appointmentDetail->subCategoryDetails->name;
				$appointmentDetail->price  = number_format($appointmentDetail->price, 2, ',', '.');
				
				$appointmentDetail->appointment_date  = \Carbon\Carbon::parse($appointmentDetail->appo_date)->translatedFormat('d F, Y')." (".\Carbon\Carbon::parse($appointmentDetail->appo_date)->translatedFormat('D').")";
				$appointmentDetail->appo_time  = \Carbon\Carbon::parse($appointmentDetail->appo_time)->format('H:i');
				$appointmentDetail->is_customer_exist = !empty($appointmentDetail->appointmentDetails->email)?\BaseFunction::checkCustomerExists($appointmentDetail->appointmentDetails->email, @$appointmentDetail->appointmentDetails->store_id):false;
				$appointmentDetail->user_image_path = !empty($appointmentDetail->appointmentDetails->userDetails->user_image_path)?$appointmentDetail->appointmentDetails->userDetails->user_image_path:NULL;
				$appointmentDetail->emp_name = !empty($appointmentDetail->employeeDetails->emp_name)?$appointmentDetail->employeeDetails->emp_name:NULL;
				$appointmentDetail->emp_image_path = !empty($appointmentDetail->employeeDetails->emp_image_path)?$appointmentDetail->employeeDetails->emp_image_path:NULL;
				$appointmentDetail->variant_description = @$appointmentDetail->variantData->description;
				$appointmentDetail->duration_of_service = @$appointmentDetail->variantData->duration_of_service;
				$startTime = \Carbon\Carbon::parse($appointmentDetail->appo_time);
				$finishTime = \Carbon\Carbon::parse($appointmentDetail->app_end_time);
				if(empty($appointmentDetail->duration_of_service)){
					$appointmentDetail->duration_of_service  = (String)$finishTime->diffInMinutes($startTime);
				}
				unset($appointmentDetail->appointmentDetails, $appointmentDetail->variantData, $appointmentDetail->employeeDetails, $appointmentDetail->subCategoryDetails, $appointmentDetail->categoryDetails);
				return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Successful', 'ResponseData' => $appointmentDetail], 200);
			}else{
				return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Please provide a valid appointment', 'ResponseData' => NULL], 499);
			}
        }catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
    }
}
