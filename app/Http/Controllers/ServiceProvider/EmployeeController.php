<?php

namespace App\Http\Controllers\ServiceProvider;

use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\StoreCategory;
use App\Models\StoreEmpCategory;
use App\Models\StoreEmpLanguages;
use App\Models\StoreEmpService;
use App\Models\StoreEmpTimeslot;
use App\Models\StoreEmpBreakslot;
use App\Models\StoreGallery;
use App\Models\StoreProfile;
use App\Models\StoreTiming;
use App\Models\AppointmentData;
use Illuminate\Http\Request;
use App\Models\StoreEmp;
use App\Http\Controllers\ServiceProvider\AppointmentController;
use Auth;
use URL;
use Session;
use File;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $store_id = session('store_id');

        if (empty($store_id)) {
            $getStore = StoreProfile::where('user_id', Auth::user()->id)->pluck('id')->all();
        } else {
            $getStore = StoreProfile::where('user_id', Auth::user()->id)->where('id', $store_id)->pluck('id')->all();
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

        $category = ['' => 'Select Category'] + Category::leftjoin('store_categories', 'store_categories.category_id', '=', 'categories.id')
                ->whereIn('store_categories.store_id', $getStore)->pluck('categories.name', 'categories.id')->all();
        return view('ServiceProvider.Employee.index', compact('data', 'category'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function view($id)
    {
		 $id = decrypt($id);

        $store_id = session('store_id');

        if (empty($store_id)) {
            $getStore = StoreProfile::where('user_id', Auth::user()->id)->pluck('id')->all();
        } else {
            $getStore = StoreProfile::where('user_id', Auth::user()->id)->where('id', $store_id)->pluck('id')->all();
        }

        $employee = StoreEmp::findorFail($id);
        $languages = StoreEmpLanguages::where('emp_id', $id)->pluck('languages')->all();
        $category = StoreEmpCategory::leftjoin('categories', 'categories.id', '=', 'store_emp_categories.category_id')
            ->where('store_emp_categories.store_emp_id', $id)
            ->pluck('categories.name')->all();
        $time = StoreEmpTimeslot::where('store_emp_id', $id)->get();
		$today  = \Carbon\Carbon::now()->format('Y-m-d');
		$breaks = StoreEmpBreakslot::where('store_emp_id', $id)->where(function($query) use($today){ $query->whereDate('day', '>=', $today)->orWhere('everyday', 'on');})->orderBy('day', 'asc')->orderBy('start_time', 'desc')->get();
		
		
        return view('ServiceProvider.Employee.view', compact('employee', 'category', 'time', 'languages', 'breaks'));

    }

    public function add()
    {
        $store_id = session('store_id');

        if (empty($store_id)) {
            $getStore = StoreProfile::where('user_id', Auth::user()->id)->pluck('id')->all();
            $store_id = StoreProfile::where('user_id', Auth::user()->id)->value('id');
        } else {
            $getStore = StoreProfile::where('user_id', Auth::user()->id)->where('id', $store_id)->pluck('id')->all();
        }

        if (!empty($store_id)) {
            $store_time = StoreTiming::where('store_id', $store_id)->get();
        } else {
            $store_time = [];
        }
        $category = Category::join('store_categories', 'store_categories.category_id', '=', 'categories.id')
            ->whereIn('store_categories.store_id', $getStore)
            ->select('categories.*')
			->groupBy('categories.id')
            ->get();


        return view('ServiceProvider.Employee.add', compact('store_time', 'category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function addEmployee(Request $request)
    {

        $this->validate($request, [
            'emp_name' => 'required',
            'email' => 'required',
            //'phone_number' => 'required',
        ]);

        $data = $request->all();

        if ($request->file('image')) {
            $file = $request->file('image');
            $filename = 'employee-' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(storage_path('app/public/store/employee/'), $filename);
            $data['image'] = $filename;
        }

        $store_id = session('store_id');

        if (empty($store_id)) {
            $store_id = StoreProfile::where('user_id', Auth::user()->id)->value('id');
        }

        $data['store_id'] = $store_id;
        if (isset($request['dob']) && $request['dob'] != null) {

            $data['dob'] = \Carbon\Carbon::createFromFormat('d/m/Y', $request['dob'])->format('Y-m-d');
        }
        if (isset($request['joinning_date']) && $request['joinning_date'] != null) {
            $data['joinning_date'] = \Carbon\Carbon::createFromFormat('d/m/Y', $request['joinning_date'])->format('Y-m-d');
        }

        $employee = new StoreEmp();
        $employee->fill($data);
        if ($employee->save()) {
            /**
             * Store Category
             */
            if (isset($request['categories'])) {
                foreach ($request['categories'] as $row) {
                    $stcat['category_type'] = 'Cosmetics';
                    $stcat['category_id'] = $row;
                    $stcat['store_emp_id'] = $employee->id;

                    $storeCategory = new StoreEmpCategory();
                    $storeCategory->fill($stcat);
                    $storeCategory->save();
                }
            }

            /**
             * Languages
             */

            if (isset($request['languages'])) {
                foreach ($request['languages'] as $row) {
                    $stcat['store_id'] = $store_id;
                    $stcat['languages'] = $row;
                    $stcat['emp_id'] = $employee->id;

                    $storeCategory = new StoreEmpLanguages();
                    $storeCategory->fill($stcat);
                    $storeCategory->save();
                }
            }

            /**
             * Time Count
             */

            $day = $request['day'];
            $start_time = $request['start_time'];
            $end_time = $request['end_time'];
            $i = 0;
            foreach ($day as $item) {
                $dayData['store_emp_id'] = $employee->id;
                $dayData['day'] = $item;
                if ($start_time[$i] == '' || $start_time[$i] == null && $end_time[$i] == '' || $end_time[$i] == null) {
                    $dayData['is_off'] = 'on';
                } else {
                    $dayData['is_off'] = 'off';
                }
                $dayData['start_time'] = $start_time[$i];
                $dayData['end_time'] = $end_time[$i];

                $dayStore = new StoreEmpTimeslot();
                $dayStore->fill($dayData);
                $dayStore->save();
                $i++;
            }
			
			 $breaks = $request['breaks'];
			 
			 
			foreach ($breaks as $item) {
				//echo "<pre>"; print_r($breaks); die;
				
				if(!empty($item['start_time']) && !empty($item['end_time'])){
					$breakData = $item;
					if(!empty($item['day'])){
						$breakData['day']  = \Carbon\Carbon::createFromFormat('d/m/Y', $item['day'])->format('Y-m-d');
					}
					$breakData['store_emp_id'] = $employee->id;
					$breakData['store_id'] = $store_id;
					if(!empty($item['id'])){
						$breakStore = StoreEmpBreakslot::find($item['id']);
						$breakStore->update($breakData);
					}else{
						$StoreEmpBreakslot = StoreEmpBreakslot::create($breakData);
						$breaksID[] = $StoreEmpBreakslot->id;
					}
				}
			}

            return redirect('dienstleister/mitarbeiter');
        }


    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {
        $id = decrypt($id);

        $store_id = session('store_id');

        if (empty($store_id)) {
            $getStore = StoreProfile::where('user_id', Auth::user()->id)->pluck('id')->all();
        } else {
            $getStore = StoreProfile::where('user_id', Auth::user()->id)->where('id', $store_id)->pluck('id')->all();
        }

        $category = Category::join('store_categories', 'store_categories.category_id', '=', 'categories.id')
            ->whereIn('store_categories.store_id', $getStore)
            ->select('categories.*')
            ->pluck('name', 'id')
            ->all();
		$today  = \Carbon\Carbon::now()->format('Y-m-d');
        $store_time = StoreEmpTimeslot::where('store_emp_id', $id)->get();
        $emp_breaks = StoreEmpBreakslot::where('store_emp_id', $id)->where(function($query) use($today){ $query->whereDate('day', '>=', $today)->orWhere('everyday', 'on');})->orderBy('day', 'asc')->orderBy('start_time', 'asc')->get();
        $store_category = StoreEmpCategory::where('store_emp_id', $id)->pluck('category_id')->all();
        $employee = StoreEmp::findorFail($id);
        $languages = StoreEmpLanguages::where('emp_id', $id)->pluck('languages')->all();

        return view('ServiceProvider.Employee.edit', compact('store_time', 'category', 'employee', 'emp_breaks', 'languages', 'store_category'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function updateEmployee(Request $request, $id)
    {

        $data = $request->all();

        $category_name = $request['categories'];
        $day = $request['day'];
        $start_time = $request['start_time'];
        $end_time = $request['end_time'];
        $languages = $request['languages'];
        $store_emp_id = decrypt($id);
		
		 $breaks = $request['breaks'];

        $data = $request->except('_token', 'breaks', '_method', 'day', 'start_time', 'end_time', 'weekDays', 'languages', 'categories');

        if ($request->file('image')) {

            $oldimage = StoreEmp::where('id', $store_emp_id)->value('image');

            if (!empty($oldimage)) {

                File::delete('storage/app/public/store/employee/' . $oldimage);
            }

            $file = $request->file('image');
            $filename = 'employee-' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(storage_path('app/public/store/employee/'), $filename);
            $data['image'] = $filename;
        }

        if (isset($request['dob']) && $request['dob'] != null) {

            $data['dob'] = \Carbon\Carbon::createFromFormat('d/m/Y', $request['dob'])->format('Y-m-d');
        }
		
        if (isset($request['joinning_date']) && $request['joinning_date'] != null) {
            $data['joinning_date'] = \Carbon\Carbon::createFromFormat('d/m/Y', $request['joinning_date'])->format('Y-m-d');
        }
        $getEmp = StoreEmp::findorFail($store_emp_id);
        $updateEmp = StoreEmp::where('id', $store_emp_id)->update($data);

        if ($updateEmp) {

            /**
             * Store Category
             */
            if (isset($category_name)) {
                $categoryDelete = StoreEmpCategory::where('store_emp_id', $store_emp_id)->delete();

                foreach ($category_name as $row) {
                    $stcat['category_type'] = 'Cosmetics';
                    $stcat['category_id'] = $row;
                    $stcat['store_emp_id'] = $store_emp_id;

                    $storeCategory = new StoreEmpCategory();
                    $storeCategory->fill($stcat);
                    $storeCategory->save();
                }
            }

            /**
             * Languages
             */

            if (isset($languages)) {
                $languagesDelete = StoreEmpLanguages::where('emp_id', $store_emp_id)->delete();
                foreach ($languages as $row) {
                    $stcat['store_id'] = $getEmp['store_id'];
                    $stcat['languages'] = $row;
                    $stcat['emp_id'] = $store_emp_id;

                    $storeCategory = new StoreEmpLanguages();
                    $storeCategory->fill($stcat);
                    $storeCategory->save();
                }
            }

            /**
             * Time Count
             */
            $i = 0;
            $serviceDelete = StoreEmpTimeslot::where('store_emp_id', $store_emp_id)->delete();

            foreach ($day as $item) {
                $dayData['store_emp_id'] = $store_emp_id;
                $dayData['day'] = $item;
                if ($start_time[$i] == '' || $start_time[$i] == null && $end_time[$i] == '' || $end_time[$i] == null) {
                    $dayData['is_off'] = 'on';
                } else {
                    $dayData['is_off'] = 'off';
                }

                $dayData['start_time'] = $start_time[$i];
                $dayData['end_time'] = $end_time[$i];

                $dayStore = new StoreEmpTimeslot();
                $dayStore->fill($dayData);
                $dayStore->save();
                $i++;
            }
			
			$breaksID = array();
			foreach ($breaks as $item) {
				//echo "<pre>"; print_r($breaks); die;
				
				if(!empty($item['start_time']) && !empty($item['end_time'])){
					$breakData = [];
					$breakData = $item;
					if(!empty($item['day'])){
						
						$breakData['day']  = \Carbon\Carbon::createFromFormat('d/m/Y', $item['day'])->format('Y-m-d');
					}
					$breakData['store_emp_id'] = $store_emp_id;
					$breakData['store_id'] = $getEmp['store_id'];
					$breakData['everyday'] 			= !empty($item['everyday']) && $item['everyday'] == 'on'?'on':'off';
					
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
								$req['variant_id'] = $val->variant_id;
								$req['appointment_id'] = $val->appointment_id;
								$req['cancel_reason'] = 'leider etwas dazwischen gekommen ist';
								$req['internal_call'] =  true;
								$appo_controller->cancelAppointment($req);
							}
						}
						
						if(count($appointment_data) > 0 && !empty($item['break_action']) && $item['break_action'] == "1"){
							$appo_controller = new AppointmentController();
							foreach($appointment_data as $val){
								$req  = new Request();
								$req['id'] = $val->id;
								$appo_controller->postpondAppointment($req);
							}
						}
						
					}
				}
			}
			StoreEmpBreakslot::where('store_emp_id', $store_emp_id)->whereNotIn('id', $breaksID)->delete();

            return redirect('dienstleister/mitarbeiter');
        }

    }
	
	
	public function add_break_hours(Request $request){
		$item  = $request;
		
		if(!empty($item['breaks_start_time']) && !empty($item['breaks_end_time']) && !empty($item['break_store_emp_id'])){
			$breakData = [];
			if(!empty($item['breaks_day'])){
				$breakData['day']  = \Carbon\Carbon::createFromFormat('d/m/Y', $item['breaks_day'])->format('Y-m-d');
			}
			$store_id = StoreEmp::where('id', $item['break_store_emp_id'])->value('store_id');
			
			$breakData['store_emp_id'] 		= $item['break_store_emp_id'];
			$start_time = $breakData['start_time'] 		= \Carbon\Carbon::parse($item['breaks_start_time'])->format('H:i');
			$end_time = $breakData['end_time'] 			= \Carbon\Carbon::parse($item['breaks_end_time'])->format('H:i');
			$breakData['everyday'] 			= !empty($item['breaks_everyday']) && $item['breaks_everyday'] == 'on'?'on':'off';
			$breakData['store_id'] 			= $store_id;
			$StoreEmpBreakslot 				= StoreEmpBreakslot::create($breakData);
			if($StoreEmpBreakslot){
				if($breakData['everyday'] == 'on' OR !empty($breakData['day'])){
					$appointment_data = AppointmentData::where('store_emp_id', $breakData['store_emp_id']);
					if(!empty($item['breaks_everyday']) && $item['breaks_everyday'] == 'on'){
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
							$req['variant_id'] = $val->variant_id;
							$req['appointment_id'] = $val->appointment_id;
							$req['cancel_reason'] = 'leider etwas dazwischen gekommen ist';
							$req['internal_call'] =  true;
							$appo_controller->cancelAppointment($req);
						}
					}
					
					if(count($appointment_data) > 0 && !empty($item['break_action']) && $item['break_action'] == "1"){
						$appo_controller = new AppointmentController();
						foreach($appointment_data as $val){
							$req  = new Request();
							$req['id'] = $val->id;
							$appo_controller->postpondAppointment($req);
						}
					}
					
				}
				
				 return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Successful', 'ResponseData' => NULL], 200);
			}
		}
		  return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
	}

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function removeEmployee(Request $request)
    {
        $id = $request['id'];
        $oldimage = StoreEmp::where('id', $id)->value('image');

        if (!empty($oldimage)) {
            File::delete('storage/app/public/store/employee/' . $oldimage);
        }

        $delete = StoreEmp::where('id', $id)->delete();
        $deleteTime = StoreEmpTimeslot::where('store_emp_id', $id)->delete();

        if ($delete) {

            return redirect('dienstleister/mitarbeiter');
        } else {
            return redirect('dienstleister/mitarbeiter');
        }

    }

    public function getService(Request $request)
    {

        $store_id = session('store_id');

        if (empty($store_id)) {
            $getStore = StoreProfile::where('user_id', Auth::user()->id)->pluck('id')->all();
        } else {
            $getStore = StoreProfile::where('user_id', Auth::user()->id)->where('id', $store_id)->pluck('id')->all();
        }

        $data = Service::whereIn('store_id', $getStore)->where('category_id', $request['category_id'])->where('status', 'active')->get();

        return ['status' => '1', 'data' => $data];

    }
}
