<?php

namespace App\Http\Controllers\Api\ServiceProvider\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StoreEmp;
use App\Models\StoreEmpCategory;
use App\Models\StoreEmpService;
use App\Models\StoreEmpTimeslot;
use App\Models\StoreCategory;
use App\Models\Service;
use App\Models\StoreProfile;
use App\Models\StoreEmpLanguages;
use App\Models\StoreTiming;
use App\Models\Category;
use App\Models\StoreEmpBreakslot;
use App\Models\AppointmentData;
use App\Http\Controllers\Api\ServiceProvider\Appointment\AppointmentController;
use Validator;
use URL;
use Mail;
use File;
use Exception;
use Carbon\Carbon;
use DB;

class EmployeeListController extends Controller
{
    public function employeeList(Request $request)
    {
        try {
            $userId  = $request['user']['user_id'];
            // $storeId = \BaseFunction::getStoreDetails($userId);
			if(empty($request['store_id'])) {
				$getStore = StoreProfile::where('user_id',$userId)->pluck('id')->all();
			} else {
				$getStore = StoreProfile::where('user_id', $userId)->where('id', $request['store_id'])->pluck('id')->all();
			}
		
            
            $data = StoreEmp::whereIn('store_id', $getStore)->get();
			foreach ($data as $row) {
				$day = \Carbon\Carbon::now()->format('l');
				$row->time = StoreEmpTimeslot::where('store_emp_id', $row->id)->where('day', $day)->first();
				$category = StoreEmpCategory::leftjoin('categories', 'categories.id', '=', 'store_emp_categories.category_id')
					->where('store_emp_categories.store_emp_id', $row->id)
					->pluck('categories.name')->all();
				$row->category = $category;
				$row->day = $day;
			}
			
			$responseData = array('data' => $data, 'totalCount' => count($data));
            
            return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Successful', 'ResponseData' => $responseData], 200);
            
        } catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
    }

    //add employee in store
    public function employeeStore(Request $request)
    {               
        $rule = [
           'emp_name' => 'required',
           'email' => 'required',
           //'phone_number' => 'required',    
        ];

        $message = [
            'emp_name.required' => 'Employee name is required',           
            'email.required' => 'Email is required',            
            'phone_number.required' => 'Phone number is required'
        ];

        $validate = Validator::make($request->all(), $rule, $message);

        if ($validate->fails()) {
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Validation Fails', 'ResponseData' => $validate->errors()->all()], 422);
        }
        try {
            $data = request()->all();         
			$userId  = $data['user']['user_id'];
			if(empty($data['store_id'])) {
				$store_id = StoreProfile::where('user_id', $userId)->value('id');
			} else {
				$store_id = $data['store_id'];
			}
			$data['store_id'] = $store_id;
            $categoryType = !empty($data['category_type'])?$data['category_type']:'Cosmetics';           
            $category = isset($data["categories"])?json_decode($data["categories"], true):array();
            $languages = isset($data["languages"])?json_decode($data["languages"], true):array();
            $empTimeSlote = isset($data["emp_time_slots"])?json_decode($data['emp_time_slots']):array();
			$breaks = isset($data["breaks"])?json_decode($data['breaks'], true):array();

            if ($request->file('image')) {

                $file = $request->file('image');
                $filename = 'StoreEmp-' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(storage_path('app/public/store/employee/'), $filename);
                $data['image'] = $filename;
            }
            unset($data['categories'],$data['languages'],$data['breaks'],$data['emp_time_slots'],$data['user'],$data['category_type']);
            $storeEmp = new StoreEmp();
            $storeEmp->fill($data);
            if ($storeEmp->save()) {    
                if ($category) {
                    foreach ($category as  $value) {                                                                  ;
                        $category_add = new StoreEmpCategory();
                        $category_add->store_emp_id = $storeEmp->id;
                        $category_add->category_type = $categoryType;
                        $category_add->category_id = $value;
                        $category_add->save();
                    }
                }
                if ($empTimeSlote) {
                    foreach ($empTimeSlote as $row) {
                        $storeTimeSlote = new StoreEmpTimeslot();
                        $storeTimeSlote->store_emp_id = $storeEmp->id;
                        $storeTimeSlote->day = $row->day;
                        $storeTimeSlote->start_time = $row->start_time;
                        $storeTimeSlote->end_time = $row->end_time;
                        $storeTimeSlote->is_off = (!empty($row->is_off) && $row->is_off == 'on')?'on':'off';
                        $storeTimeSlote->save();
                    }
                }  
                if($languages) {
                    foreach ($languages as  $value) {                                                                  ;
                        $lang_add = new StoreEmpLanguages();
                        $lang_add->emp_id = $storeEmp->id;                                                
                        $lang_add->store_id = $store_id;
                        $lang_add->languages = $value;
                        $lang_add->save();
                    }
                }
				
				if($breaks) {
					foreach ($breaks as $item) {
						if(!empty($item['start_time']) && !empty($item['end_time'])){
							$breakData = $item;
							if(!empty($item['day'])){
								$breakData['day']  = \Carbon\Carbon::createFromFormat('d/m/Y', $item['day'])->format('Y-m-d');
							}
							$breakData['start_time'] = \Carbon\Carbon::parse($item['start_time'])->format('H:i');
							$breakData['end_time'] = \Carbon\Carbon::parse($item['end_time'])->format('H:i');
							$breakData['store_emp_id'] = $storeEmp->id;
							$breakData['store_id'] = $store_id;
							$StoreEmpBreakslot = StoreEmpBreakslot::create($breakData);
						}
					}
				}				
                return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Employee added successfully.', 'ResponseData' => null], 200);
            }
            
        } catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
    }

    public function employeeView(Request $request)
    {
        try {
            $data = request()->all();
            
            $viewEmp = StoreEmp::with('EmpCategory','EmpService','EmpTimeSlot')->where('id',$data['emp_id'])->first();
            if (!empty($viewEmp)) { 
				$languages = StoreEmpLanguages::where('emp_id', $data['emp_id'])->pluck('languages')->all();
                //category
                $category = array();
                foreach ($viewEmp->EmpCategory as $key) {
                    $category[] = $key['EmpCategoryDetails']['name'];
                }         
                //service
                $service = array();
                foreach ($viewEmp->EmpService as $key) {
                    $service [] = $key['EmpServiceDetails']['service_name'];
                }
				//service
                $timeslots = array();
                foreach ($viewEmp->EmpTimeSlot as $key) {
                    $key->day = \Carbon\Carbon::create($key->day)->dayName;
                }
                $viewEmp['category_name'] = $category;
                $viewEmp['service_name'] = $service;
				$viewEmp['payout'] = number_format($viewEmp['payout'], 2, ',', '.');
				$viewEmp['dob'] = !empty($viewEmp['dob'])?\Carbon\Carbon::parse($viewEmp['dob'])->translatedFormat('d M Y')." (".\Carbon\Carbon::parse($viewEmp['dob'])->age." Jahre)":"";
                $viewEmp['joinning_date'] = !empty($viewEmp['joinning_date'])?\Carbon\Carbon::parse($viewEmp['joinning_date'])->translatedFormat('d M Y')." (".\Carbon\Carbon::parse($viewEmp['joinning_date'])->age." Jahre)":"";
                $viewEmp['languages'] = $languages;
				$today  = \Carbon\Carbon::now()->format('Y-m-d');
				$viewEmp['breaks'] = StoreEmpBreakslot::where('store_emp_id', $data['emp_id'])->where(function($query) use($today){ $query->whereDate('day', '>=', $today)->orWhere('everyday', 'on');})
								->orderBy('day', 'asc')->orderBy('start_time', 'desc')->select('*', DB::raw('DATE_FORMAT(day, "%d/%m/%Y") as day_german'))->paginate(5);
		
                unset($viewEmp->EmpCategory,$viewEmp->EmpService);
                return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Success.', 'ResponseData' => $viewEmp], 200);
            }
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'wrong employee id.', 'ResponseData' => null], 400);
        } catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
    }

	
	public function employeeEdit(Request $request)
    {
        try {
            $data = request()->all();
            
            $viewEmp = StoreEmp::with('EmpCategory','EmpService','EmpTimeSlot')->where('id',$data['emp_id'])->first();
            if (!empty($viewEmp)) { 
				$languages = StoreEmpLanguages::where('emp_id', $data['emp_id'])->pluck('languages')->all();
                //category
                $category = array();
                foreach ($viewEmp->EmpCategory as $key) {
                    $category[] = $key['EmpCategoryDetails'];
                }         
               
                $viewEmp['category_name'] = $category;
                $viewEmp['languages'] = $languages;
				$today  = \Carbon\Carbon::now()->format('Y-m-d');
				$viewEmp['breaks'] = StoreEmpBreakslot::where('store_emp_id', $data['emp_id'])->where(function($query) use($today){ $query->whereDate('day', '>=', $today)->orWhere('everyday', 'on');})
								->orderBy('day', 'asc')->orderBy('start_time', 'desc')->select('*', DB::raw('DATE_FORMAT(day, "%d/%m/%Y") as day_german'))->get();
                unset($viewEmp->EmpCategory,$viewEmp->EmpService);
                return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Success.', 'ResponseData' => $viewEmp], 200);
            }
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'wrong employee id.', 'ResponseData' => null], 400);
        } catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
    }
    //update employee
    public function employeeUpdate(Request $request)
    {
        $rule = [
           'emp_name' => 'required',
           'email' => 'required',
           //'phone_number' => 'required',    
        ];

        $message = [
            'emp_name.required' => 'Employee name is required',           
            'email.required' => 'Email is required',            
            'phone_number.required' => 'Phone number is required'
        ];

        $validate = Validator::make($request->all(), $rule, $message);

       
        if ($validate->fails()) {
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Validation Fails', 'ResponseData' => $validate->errors()->all()], 422);
        }
        try {
            $data = request()->all();                        
            $userId  = $data['user']['user_id'];
            // $storeId = \BaseFunction::getStoreDetails($userId);
			if (empty($data['store_id'])) {
				$store_id = StoreProfile::where('user_id', $userId)->value('id');
			}else{
				 $store_id = $data['store_id'];
			}
			$data['store_id'] = $store_id;
            $categoryType = !empty($data['category_type'])?$data['category_type']:'Cosmetics';           
            $category = isset($data["categories"])?json_decode($data["categories"], true):array();
            $languages = isset($data["languages"])?json_decode($data["languages"], true):array();
            $empTimeSlote = isset($data["emp_time_slots"])?json_decode($data['emp_time_slots']):array();
			$breaks = isset($data["breaks"])?json_decode($data['breaks'], true):array();
			$emp_id = $data['emp_id'];
			
            $checkEmpId =StoreEmp::where('id',$emp_id)->first();
			 unset($data['categories'],$data['languages'],$data['breaks'],$data['emp_time_slots'],$data['user'],$data['category_type'],$data['emp_id']);
            if (empty($checkEmpId)) {
                return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Worng emp id.', 'ResponseData' => ''], 400);
            }
			if ($request->file('image')) {
				$file = $request->file('image');
				$filename = 'StoreEmp-' . uniqid() . '.' . $file->getClientOriginalExtension();
				$file->move(storage_path('app/public/store/employee/'), $filename);
				$data['image'] = $filename;
				
				$oldimage = StoreEmp::where('id', $emp_id)->value('image');
				if (!empty($oldimage) && !empty($data['image'])) {    
					File::delete('app/public/store/employee/' . $oldimage);
				}
			}
            $updateEmp = StoreEmp::where('id',$emp_id)->where('store_id',$data['store_id'])->update($data);
			$data['emp_id'] = $emp_id;
            if ($updateEmp) { 
				/**
				 * update category emp
				 */
				if($category) {
					StoreEmpCategory::whereNotIn('category_id', $category)->where('store_emp_id', $data['emp_id'])->delete();
					foreach ($category as  $value) {  
						$isexist  = StoreEmpCategory::where('category_id', $value)->where('store_emp_id', $data['emp_id'])->count();
						if($isexist == 0){
							$category_add = new StoreEmpCategory();
							$category_add->store_emp_id = $data['emp_id'];
							$category_add->category_type = $categoryType;
							$category_add->category_id = $value;                            
							$category_add->save();
						}
					}
				}else{
					StoreEmpCategory::where('store_emp_id', $data['emp_id'])->delete();
				}
				
				 if($languages) {
					StoreEmpLanguages::whereNotIn('languages', $languages)->where('emp_id', $data['emp_id'])->delete();
                    foreach ($languages as  $value) {
						$isexist  = StoreEmpLanguages::where('languages', $value)->where('emp_id', $data['emp_id'])->count();
						if($isexist == 0){
							$lang_add = new StoreEmpLanguages();
							$lang_add->emp_id = $data['emp_id'];                                                
							$lang_add->store_id = $store_id;
							$lang_add->languages = $value;
							$lang_add->save();
						}
                    }
                }else{
					StoreEmpLanguages::where('emp_id', $data['emp_id'])->where('store_id', $data['store_id'])->delete();
				}       
				
				if ($empTimeSlote) {
					foreach ($empTimeSlote as $row) {
						//return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Employee update successfully.', 'ResponseData' => $empTimeSlote], 200);
						$isexist  = StoreEmpTimeslot::where('day', $row->day)->where('store_emp_id', $data['emp_id'])->first();
						if(!empty($isexist->day)){
							$storeTimeSlote = StoreEmpTimeslot::find($isexist->id);
						}else{
							$storeTimeSlote = new StoreEmpTimeslot();
						}
						$storeTimeSlote->store_emp_id = $data['emp_id'];
						$storeTimeSlote->day = $row->day;
						$storeTimeSlote->start_time = $row->start_time;
						$storeTimeSlote->end_time = $row->end_time;
						$storeTimeSlote->is_off = !empty($row->is_off)?$row->is_off:'off';
						$storeTimeSlote->save();
                    }
                }else{
					StoreEmpTimeslot::where('store_emp_id', $data['emp_id'])->delete();
				}  
				
				
				$breaksID = array();
				foreach ($breaks as $item) {
					if(!empty($item['start_time']) && !empty($item['end_time'])){
						$breakData = [];
						$breakData = $item;
						if(!empty($item['day'])){
							$breakData['day']  = \Carbon\Carbon::createFromFormat('d/m/Y', $item['day'])->format('Y-m-d');
						}
						$breakData['start_time'] = \Carbon\Carbon::parse($item['start_time'])->format('H:i');
						$breakData['end_time'] = \Carbon\Carbon::parse($item['end_time'])->format('H:i');
						$breakData['store_emp_id'] =  $data['emp_id'];
						$breakData['store_id'] 		= $store_id;
						$breakData['everyday'] 		= !empty($item['everyday']) && $item['everyday'] == 'on'?'on':'off';
						
						if(!empty($item['id'])){
							$breaksID[] = $item['id'];
							$breakStore = StoreEmpBreakslot::find($item['id']);
							$breakStore->update($breakData);
						}else{
							$StoreEmpBreakslot = StoreEmpBreakslot::create($breakData);
							$breaksID[] = $StoreEmpBreakslot->id;
						}
						
						if($breakData['everyday'] == 'on' OR !empty($breakData['day'])){
							$start_time  	= $breakData['start_time'];
							$end_time  		= $breakData['end_time'];
							$appointment_data = AppointmentData::where('store_emp_id', $breakData['store_emp_id']);
							if(!empty($item['everyday']) && $item['everyday'] == 'on'){
								$appointment_data = $appointment_data->where('appo_date', '>=', \Carbon\Carbon::now()->format('Y-m-d'));
							}else{
								$appointment_data = $appointment_data->where('appo_date', '=', $breakData['day']);
							}
							
							$appointment_data = $appointment_data->where(function($query) use($start_time, $end_time){
														$query->where(function($query1) use($start_time, $end_time){
																	$query1->where('appo_time', '<=', $start_time)->where('app_end_time', '>', $start_time);
																})->orWhere(function($query2) use($start_time, $end_time){
																	$query2->where('appo_time', '>=', $start_time)->where('appo_time', '<', $end_time);
																});
													})->where('status', 'booked')->get();
												
							if(count($appointment_data) > 0 && !empty($item['break_action']) && $item['break_action'] == "2"){
								$appo_controller = new AppointmentController();
								foreach($appointment_data as $val){
									$req  = new Request();
									$req['user'] = $request['user'];
									$req['id'] 	 = $val->id;
									$req['cancel_reason'] = 'leider etwas dazwischen gekommen ist';
									$req['internal_call'] =  true;
									$appo_controller->appointmentCancel($req);
								}
							}
							
							if(count($appointment_data) > 0 && !empty($item['break_action']) && $item['break_action'] == "1"){
								$appo_controller = new AppointmentController();
								foreach($appointment_data as $val){
									$req  = new Request();
									$req['user'] = $request['user'];
									$req['id'] = $val->id;
									$appo_controller->appointmentDatePostponed($req);
								}
							}
							
						}
					}
				}
				StoreEmpBreakslot::where('store_emp_id', $data['emp_id'])->whereNotIn('id', $breaksID)->delete();
                        
				return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Employee updated successfully.', 'ResponseData' => null], 200);
            }
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
            
        } catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
    }

    //delete store employee
    public function employeeDelete(Request $request)
    {
        try {
            $data = request()->all();
			 $userId  = $data['user']['user_id'];
            // $storeId = \BaseFunction::getStoreDetails($userId);
			if(empty($data['store_id'])) {
				$getStore = StoreProfile::where('user_id',$userId)->pluck('id')->all();
			} else {
				$getStore = StoreProfile::where('user_id', $userId)->where('id', $data['store_id'])->pluck('id')->all();
			}
            $deleteEmp = StoreEmp::where('id',$data['emp_id'])->whereIn('store_id', $getStore)->first();
            if (empty($deleteEmp)) {
                return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Not found emp id.', 'ResponseData' => ''], 400);
            }
            $oldimage = StoreEmp::where('id',$data['emp_id'])->whereIn('store_id',$getStore)->value('image');
            if (!empty($oldimage)) {
                File::delete('app/public/store/employee/' . $oldimage);
            }
            $deleteEmp = $deleteEmp->delete();
            return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Employee delete successfully.', 'ResponseData' => NULL], 200);
        } catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
    }
	
	
	 /**
     * get employee dropdowns
     */
    public function empDropdowns(Request $request)
    {
        try {
            $data = request()->all ();
			 $userId  = $data['user']['user_id'];
            // $storeId = \BaseFunction::getStoreDetails($userId);
			if(empty($data['store_id'])) {
				$getStore = StoreProfile::where('user_id',$userId)->pluck('id')->all();
				 $store_id = StoreProfile::where('user_id', $userId)->value('id');
			} else {
				$getStore = StoreProfile::where('user_id', $userId)->where('id', $data['store_id'])->pluck('id')->all();
				$store_id = $data['store_id'];
			}
			
			$languages =  array("Arabic","English", "French", "German", "Russian", "Spanish","Turkish");
			$work_timing =  array(['key' => 'Full-Time', 'value' => 'Vollzeit'], ['key' => 'Part-Time', 'value' => 'Teilzeit']);
			if (!empty($store_id)) {
				$store_time = StoreTiming::where('store_id', $store_id)->get();
			} else {
				$store_time = [];
			}
			$categoryList = Category::leftjoin('store_categories', 'store_categories.category_id', '=', 'categories.id')
				->whereIn('store_categories.store_id', $getStore)
				->select('categories.id', 'categories.name', 'categories.image')
				->get();
			
			$response = array(
							'store_time' => $store_time,
							'categories' => $categoryList,
							'work_timing' => $work_timing,
							'languages'  => $languages
						);
			
           
          /*   if (count($categoryList) == 0) {
                return response()->json(['ResponseCode' => 0, 'ResponseText' => 'No List', 'ResponseData' =>NULL], 200);
            } */
            return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Category list.', 'ResponseData' => $response], 200);
        } catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
    }

    /**
     * get store all category
     */
    public function storeCategory(Request $request)
    {
        try {
            $data = request()->all ();
            $storeCategory = StoreCategory::with('CategoryData')->where('store_id',$data['store_id'])->get();
            
            $categoryList = [];
            foreach ($storeCategory as $value) {
                $categoryList [] = [
                    'category_id' => $value['category_id'],
                    'category_name' => $value['CategoryData']['name'],
                    'category_image' => $value['CategoryData']['category_image_path'],
                ];
            }

            if (count($categoryList) == 0) {
                return response()->json(['ResponseCode' => 0, 'ResponseText' => 'No List', 'ResponseData' =>NULL], 200);
            }
            return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Category list.', 'ResponseData' => $categoryList], 200);
        } catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
    }

    /**
     * get store all service
     */
    public function storeService(Request $request)
    {
        try {
            $data = request()->all();
            if (isset($data['category_id']) && isset($data['store_id'])) {                
                $storeService = Service::where('store_id',$data['store_id'])->where('category_id',$data['category_id'])->select('id','service_name','image')->get();    
            }else{                                                
                $storeService = Service::where('store_id',$data['store_id'])->select('id','service_name','image')->get();
            }
            if (count($storeService) == 0) {
                return response()->json(['ResponseCode' => 0, 'ResponseText' => 'No List', 'ResponseData' =>NULL], 200);
            }
            return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Service list.', 'ResponseData' => $storeService], 200);
        } catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
    }
	
	
	
	
	public function addBreakHours(Request $request){
		try {
			if(!empty($request['start_time']) && !empty($request['end_time']) && !empty($request['store_emp_id'])){
				$breakData = [];
				if(!empty($request['day'])){
					$breakData['day']  = \Carbon\Carbon::createFromFormat('d/m/Y', $request['day'])->format('Y-m-d');
				}
				$store_id = StoreEmp::where('id', $request['store_emp_id'])->value('store_id');
				
				$breakData['store_emp_id'] 		= $request['store_emp_id'];
				$start_time = $breakData['start_time'] 		= \Carbon\Carbon::parse($request['start_time'])->format('H:i');
				$end_time = $breakData['end_time'] 			= \Carbon\Carbon::parse($request['end_time'])->format('H:i');
				$breakData['everyday'] 			= !empty($request['everyday']) && $request['everyday'] == 'on'?'on':'off';
				$breakData['store_id'] 			= $store_id;
				$StoreEmpBreakslot 				= StoreEmpBreakslot::create($breakData);
				if($StoreEmpBreakslot){
					if($breakData['everyday'] == 'on' OR !empty($breakData['day'])){
						$appointment_data = AppointmentData::where('store_emp_id', $breakData['store_emp_id']);
						if(!empty($request['everyday']) && $request['everyday'] == 'on'){
							$appointment_data = $appointment_data->where('appo_date', '>=', \Carbon\Carbon::now()->format('Y-m-d'));
						}else{
							$appointment_data = $appointment_data->where('appo_date', '=', $breakData['day']);
						}
						
						$appointment_data = $appointment_data->where(function($query) use($start_time, $end_time){
													$query->where(function($query1) use($start_time, $end_time){
																$query1->where('appo_time', '<=', $start_time)->where('app_end_time', '>', $start_time);
															})->orWhere(function($query2) use($start_time, $end_time){
																$query2->where('appo_time', '>=', $start_time)->where('appo_time', '<', $end_time);
															});
												})->where('status', 'booked')->get();
												
					
											
						if(count($appointment_data) > 0 && !empty($request['break_action']) && $request['break_action'] == "2"){
							$appo_controller = new AppointmentController();
							foreach($appointment_data as $val){
								$req  = new Request();
								$req['user'] = $request['user'];
								$req['id'] 	 = $val->id;
								$req['cancel_reason'] = 'leider etwas dazwischen gekommen ist';
								$req['internal_call'] =  true;
								$appo_controller->appointmentCancel($req);
							}
						}
						
						if(count($appointment_data) > 0 && !empty($request['break_action']) && $request['break_action'] == "1"){
							$appo_controller = new AppointmentController();
							foreach($appointment_data as $val){
								$req  = new Request();
								$req['user'] = $request['user'];
								$req['id'] = $val->id;
								$appo_controller->appointmentDatePostponed($req);
							}
						}
						
					}
					
					 return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Break Hours saved successfully.', 'ResponseData' => NULL], 200);
				}
			}
			 return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
		} catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
	}
}
