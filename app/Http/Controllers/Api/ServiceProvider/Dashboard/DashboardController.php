<?php

namespace App\Http\Controllers\Api\ServiceProvider\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\ApiSession;
use App\Models\ServiceAppoinment;
use App\Models\Service;
use App\Models\StoreProfile;
use App\Models\StoreEmp;
use App\Models\AppointmentData;
use App\Models\StoreRatingReview;
use App\Models\Customer;
use App\Models\StoreEmpTimeslot;
use App\Models\Notification;
use Validator;
use URL;
use Mail;
use File;
use Exception;
use Carbon\Carbon;


class DashboardController extends Controller
{
    public function dashboard(Request $request)
    {
        try {
                $data = request()->all();                
                // $store = StoreProfile::where('user_id',$request['user']['user_id'])->pluck('id');     
				
                $store_id = !empty($data['store_id'])?$data['store_id']:""; 
				
				if(empty($store_id)){
					$store = StoreProfile::where('user_id', $request['user']['user_id'])->pluck('id')->all();
				} else{
					$store = StoreProfile::where('user_id', $request['user']['user_id'])->where('id',$store_id)->pluck('id')->all();
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
				
				$activeAppointment = AppointmentData::whereIn('store_id',$store)->where('status','running')->count();
				$pendingAppointment = AppointmentData::whereIn('store_id',$store)->where('status','booked')->count();
				$completedAppointment = AppointmentData::whereIn('store_id',$store)->where('status','completed')->count();
				$canceledAppointment = AppointmentData::whereIn('store_id',$store)->where('status','cancel')->count();
				$totalService = Service::whereIn('store_id',$store)->count();
				$totalEmpR = StoreEmp::whereIn('store_id',$store)->get();
				$totalReview = StoreRatingReview::whereIn('store_id',$store)->count();
				$totalCustomer = Customer::whereIn('store_id',$store)->count();
		
                /* $ServiceAppoinment = ServiceAppoinment::where('store_id',$store)->get();
                // activeactive
                $activeAppoinment = $ServiceAppoinment->where('store_id',$store)->where('status','running')->count();        
                //get pending
                $pendingAppoinment = $ServiceAppoinment->where('store_id',$store)->where('status','booked')->count();
                
                //total service
                $totalService = Service::where('store_id',$store)->count();
                
                //today Service appoinment
                $todayDate = Carbon::now()->format('Y-m-d'); */
                
                /* $todayAppoinment = ServiceAppoinment::with('employeeDetails','serviceDetails','orderInfo')->where('store_id',$store)->where('appo_date',$todayDate)->get();             
                
                $todatEarning = 0;
                foreach ($todayAppoinment as $row) {
                    $row['emp_name']                = @$row['employeeDetails']['emp_name'];
                    $row['emp_image']               = @$row['employeeDetails']['emp_image_path'];
                    // $row['order_id']                = @$row['orderInfo']['order_id'];
                    $row['service_name']            = $row['serviceDetails']['service_name'];
                    $row['price']                   = $row['serviceDetails']['price'];
                    $row['service_image_path']      = $row['serviceDetails']['service_image_path'];
                    // $todatEarning                  += @$row['orderInfo']['total_amount'];
                    unset($row->employeeDetails,$row->serviceDetails,$row->orderInfo,$row->userDetails);
                }
                //get total stylish            
                $totalStylish = StoreEmp::where('store_id',$store)->get();
                $totalEmployee = $totalStylish->count(); */
				$totalEmp  = array();
				
				foreach ($totalEmpR as $k=>$item) {
					$item->time = StoreEmpTimeslot::where('day',\Carbon\Carbon::now()->format('l'))->where('store_emp_id',$item->id)->first();
					
					if(!empty($item->time->is_off) and $item->time->is_off == 'on'){
						unset($totalEmpR[$k]);
					}
					if(@$item->time->is_off == 'off'){
						$totalEmp[] = $item->toArray();
					}
					
				}
				

				$pendingAppointments = AppointmentData::leftjoin('appointments', 'appointments.id', '=', 'appointment_data.appointment_id')
					->leftjoin('payment_method_infos', 'payment_method_infos.appoinment_id', '=', 'appointments.id')
					->where(function ($query) {
						$query->Where('appointment_data.status', 'pending')
							->orWhere('appointment_data.status', 'booked')
							->orWhere('appointment_data.status', 'running')
							->orWhere('appointment_data.status', 'completed')
							->orWhere('appointment_data.status', 'reschedule')
							->orWhere('appointment_data.status', 'cancel');
					});
					
					if(!empty($request['page_status']) && $request['page_status'] != 'all'){
						$pendingAppointments = $pendingAppointments->where('appointment_data.status',$request['page_status']);
					}
					$pendingAppointments = $pendingAppointments->whereIn('appointment_data.store_id',$store)
					->whereDate('appointment_data.appo_date',$date)
					->select('appointment_data.*', 'payment_method_infos.status as payment_status','payment_method_infos.card_type as card_type','payment_method_infos.payment_method as payment_method',
						'appointments.user_id','appointments.order_id', 'appointments.first_name', 'appointments.last_name')->orderBy('appo_time', 'ASC')
					->get();


				$todayAppointment = [];
				foreach ($pendingAppointments as $row) {
					$storeData = StoreProfile::findorFail($row->store_id);
					$row->price = number_format($row->price,2,',','.');
					$row->storeData = $storeData;
					$row->appo_time = \Carbon\Carbon::parse($row->appo_time)->format('H:i');
					$row->app_end_time = \Carbon\Carbon::parse($row->app_end_time)->format('H:i');
					$row->category_name = @$row->categoryDetails->name;
					$row->customer_image = !empty($row->userDetails->profile_pic)?url('storage/app/public/user/'.$row->userDetails->profile_pic):NULL;
					$row->category_image_path = @$row->categoryDetails->category_image_path;
					$row->subcategory_name = @$row->subCategoryDetails->name;
					$row->emp_name               = @$row['employeeDetails']['emp_name'];
                    $row->emp_image               = @$row['employeeDetails']['emp_image_path'];
					$row->duration_of_serive               = @$row->variantData->duration_of_service;
					$row->variant_description               = @$row->variantData->description;
					$row->payment_method               = ucfirst($row->payment_method == 'cash' ? 'vor Ort' : ((strtolower($row->payment_method) == 'stripe' && !empty($row->card_type))?$row->card_type:$row->payment_method));
					unset($row->employeeDetails,$row->categoryDetails,$row->variantData,$row->subCategoryDetails,$row->serviceDetails,$row->orderInfo,$row->userDetails);
					$todayAppointment[] = $row;
				}

				//ksort($todayAppointment);

				$todayEarning = AppointmentData::whereIn('store_id',$store)->whereDate('appo_date',$date)->where('status','completed')->sum('price');
		
		
                //set data object
                $data = [
                    'activeAppointment'  => $activeAppointment,
                    'pendingAppointment' => $pendingAppointment,
                    'completedAppointment'      => $completedAppointment,
                    'canceledAppointment'     => $canceledAppointment,                
                     'totalCustomer'     => $totalCustomer,     
					 'totalService'     => $totalService,     
					'totalReview'     => $totalReview,
                     'todayEarning'     => number_format($todayEarning,2,',','.'),					 
                     'totalEmp'     => count($totalEmp),
					  'employees'     => $totalEmp,
                      'pageStatus'     => $appStatus,
                     'todayAppointment'     => $todayAppointment,
                    
                ];
                return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Successful', 'ResponseData' => $data], 200);
        } catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
        
    }
	
	public function notification_count(Request $request)
    {
		try {
			$userId  = $request['user']['user_id'];                     
			$store_id = !empty($request['store_id'])?$request['store_id']:""; 
			$user = User::where('id', $userId)->first(['notification_checked']);
			if(empty($store_id)){
				$getStore = StoreProfile::where('user_id', $userId)->pluck('id')->all();
			} else{
				$getStore = StoreProfile::where('user_id', $userId)->where('id',$store_id)->pluck('id')->all();
			}
			$dateUser  = !empty($user->notification_checked)?$user->notification_checked:date('Y-m-d H:i:s');
			$timeUser  = !empty($user->notification_checked)?date('H:i:s', strtotime($user->notification_checked)):date('H:i:s');
			$data = Notification::whereIn('store_id',$getStore)->whereNull('visible_for')->where('created_at', '>=', $dateUser)->whereTime('created_at', '>', $timeUser)->orderBy('created_at','DESC')->count();

			return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Successful', 'ResponseData' => $data], 200);
        } catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
    }
	
	public function notification_count_increase(Request $request)
    {
		try {
			$userId  = $request['user']['user_id'];          
			 $date = \Carbon\Carbon::now()->subDays(1)->format('Y-m-d H:i:s');
			User::where('id', $userId)->update(['notification_checked' =>  $date]);
			return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Successful', 'ResponseData' => NULL], 200);
        } catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
    }
	
	public function notifications(Request $request)
    {
		 try {
			$userId  = $request['user']['user_id'];                     
			$store_id = !empty($request['store_id'])?$request['store_id']:""; 
			if(empty($store_id)){
				$getStore = StoreProfile::where('user_id', $request['user']['user_id'])->pluck('id')->all();
			} else{
				$getStore = StoreProfile::where('user_id', $request['user']['user_id'])->where('id',$store_id)->pluck('id')->all();
			}
        
			User::where('id', $userId)->update(['notification_checked' => date('Y-m-d H:i:s')]);
       

			$data = Notification::whereIn('store_id',$getStore)->whereNull('visible_for')->orderBy('created_at','DESC')->get();
			$responseData = [];
			foreach($data as $row){
				if($row->type == 'appointment'){
					if(strpos($row->title, 'Neue Buchung') !== false){
						$appointmentDetails = \BaseFunction::getAppointmentData($row->appointment_id);
					}else{
						$appointmentDetails = \BaseFunction::getAppointmentDataByID($row->appointment_id);
					}
					
					foreach ($appointmentDetails as $appointmentDetail) {
						$notifications  = array();
						$notifications['id'] = $row->id;
						$notifications['appointment_id'] = $appointmentDetail->appointment_id;
						$notifications['title'] = $row->title;
						$notifications['type'] = $row->type;
						$notifications['description'] = $row->description;
						$notifications['notification_received'] = \Carbon\Carbon::parse($row->created_at)->diffForHumans();
						$notifications['get_detail_id'] = $appointmentDetail->id;
						$notifications['store_id'] = $row->store_id;
						$notifications['user_id'] = $row->user_id;
						$notifications['title_color'] = (strpos($row->title, 'Termin') === false)?((strpos(strtolower($row->title), 'verschoben') !== false)?'#ffc107':'#17a2b8'):'#DB8A8A';
						$notifications['button_textcolor'] = (strpos($row->title, 'Termin') === false)?((strpos(strtolower($row->title), 'verschoben') !== false)?'#212529':'#ffffff'):'#ffffff';
						$notifications['button_backgroundcolor'] = (strpos($row->title, 'Termin') === false)?((strpos(strtolower($row->title), 'verschoben') !== false)?'#ffc107':'#17a2b8'):'#DB8A8A';
						//$notifications['title_color'] = (strpos($row->title, 'Termin') === false)?((strpos(strtolower($row->title), 'verschoben') !== false)?($appointmentDetail->status == 'cancel'?'#DB8A8A':'#ffc107'):'#17a2b8'):'#DB8A8A';
						//$notifications['button_textcolor'] = (strpos($row->title, 'Termin') === false)?((strpos(strtolower($row->title), 'verschoben') !== false)?($appointmentDetail->status == 'cancel'?'#ffffff':'#212529'):'#ffffff'):'#ffffff';
						//$notifications['button_backgroundcolor'] = (strpos($row->title, 'Termin') === false)?((strpos(strtolower($row->title), 'verschoben') !== false)?($appointmentDetail->status == 'cancel'?'#DB8A8A':'#ffc107'):'#17a2b8'):'#DB8A8A';
						$responseData[] = $notifications;
					}
				}else{
					$notifications  = array();
						$notifications['id'] = $row->id;
						$notifications['title'] = $row->title;
						$notifications['type'] = $row->type;
						$notifications['description'] = $row->description;
						$notifications['notification_received'] = \Carbon\Carbon::parse($row->created_at)->diffForHumans();
						$notifications['get_detail_id'] = $row->store_id;
						$notifications['store_id'] = $row->store_id;
						$notifications['title_color'] = NULL;
						$notifications['button_backgroundcolor'] = "#FFF3F3";
						$notifications['button_textcolor'] = "#101928";
						if($row->type == 'rating'){
							$notifications['title_color'] = "#FABA5F";
							$notifications['button_backgroundcolor'] = "#FFF3F3";
							$notifications['button_textcolor'] = "#101928";
						}
						if($row->type == 'customer_accepted'){
							$notifications['title_color'] = "#FABA5F";
						}
						if($row->type == 'customer_rejected'){
							$notifications['title_color'] = "#DC3545";
						}
						$notifications['user_id'] = $row->user_id;
						
						$responseData[] = $notifications;
				}
				
			}
			return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Successful', 'ResponseData' => $responseData], 200);
        } catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
    }
}
