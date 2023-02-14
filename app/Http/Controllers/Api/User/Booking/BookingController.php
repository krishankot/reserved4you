<?php

namespace App\Http\Controllers\Api\User\Booking;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StoreEmp;
use App\Models\StoreEmpTimeslot;
use App\Models\AppointmentData;
use App\Models\Service;
use App\Models\StoreTiming;
use App\Models\StoreEmpService;
use App\Models\TemporarySelectService;
use Carbon\Carbon;

class BookingController extends Controller
{
    //get service expert details    
    public function serviceExpertDetails(Request $request)
    {
        try {
            $data = request()->all();
            $expertDetail = StoreEmp::with('EmpTimeSlot','EmpCategory','EmpService')->where('id',$data['service_expert_id'])->first();
            $availableTime = [];
            //time slot
            foreach ($expertDetail->EmpTimeSlot as $value) { 
                $time = ServiceAppoinment::where('store_emp_id',$value['store_emp_id'])->where('store_id',$data['store_id'])->where('appo_time',$value['start_time'])->first();                             
                $time = $time == null ? '' : $time['appo_time'];            
                
                if (Carbon::parse($value['start_time']) == Carbon::parse($time)) {                    
                    $value['flag'] = 'Booked';
                }else{                    
                    $value['flag'] = 'Available';
                }
                $availableTime[] = $value;
            }
            //emp services            
            foreach ($expertDetail->EmpService as $row) {   

                $row['store_emp_id'] = $row['store_emp_id'];
                $row['service_id'] = @$row['EmpServiceDetails']['id'];
                $row['service_name'] = @$row['EmpServiceDetails']['service_name'];
                $row['price'] = @$row['EmpServiceDetails']['price'];
                $row['image'] = @$row['EmpServiceDetails']['image'];
                $row['service_image_path'] = @$row['EmpServiceDetails']['service_image_path'];                                
                unset($row->EmpServiceDetails);
                
            }   
            unset($expertDetail->EmpCategory);
            $data = [
                'serviceExpertDetail' => $expertDetail,                            
            ];
            return response()->json(['ResponseCode' => 1, 'ResponseText' => "Service Expert Details Get Successfully", 'ResponseData' => $data], 200);
        } catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
    }
    //Appoinment book
    public function bookingTimeAvailable(Request $request)
    {
        try {
            $data = request()->all();  
            
            $date = \Carbon\Carbon::parse($data['date'])->format('Y-m-d');                                          
            $day = \Carbon\Carbon::parse($data['date'])->format('l');                        
            $av = $data['time'];
            $store_id = $data['store_id'];
            $category = $data['category_id'];            
            $emp_id = isset($data['emp_id']) == true ? $data['emp_id'] : null;
            $getbookingData = TemporarySelectService::where('device_token',$data['device_token'])
                        ->select('category_id','appo_date','appo_time','totalTime')->get();
            if(count($getbookingData) > 0 ){
                foreach ($getbookingData as $value) {                    
                    $value['date'] = $value['appo_date'] == null ? null: \Carbon\Carbon::parse($value['appo_date'])->format('Y-m-d');                    
                    $value['timeslot'] = $value['appo_time'] == null ? null:\Carbon\Carbon::parse($value['appo_time'])->format("H:i");                                               
                }                
                $booking = $getbookingData;
            } else {
                $booking = [];
            }  
            // dd($booking);
            if (isset($data['emp_id']) && !empty($data['emp_id'])) {                            
                $timeSlot = \BaseFunction::bookingAvailableTimeEmp($request['date'], $store_id, $av, $category, $emp_id,$booking, 'mobileapp');
            }else{                
                $timeSlot = \BaseFunction::bookingAvailableTime($request['date'], $store_id, $av, $category,$booking);
            }
            if (count($timeSlot) > 0 ) {
                return response()->json(['ResponseCode' => 1, 'ResponseText' => "Successfully", 'ResponseData' => $timeSlot], 200);
            }
            return response()->json(['ResponseCode' => 0, 'ResponseText' => __("No Time Schedule Found. Please try another Date"), 'ResponseData' => NULL], 200);
    //         $empTime = StoreEmpTimeslot::where('store_emp_id',$data['emp_id'])->where('day',$day)->first();    
                     
    //         if (empty($empTime) || $empTime['is_off'] == 'on') {
    //             return response()->json(['ResponseCode' => 0, 'ResponseText' => "NO Time Schedule Found. Please try another Date.", 'ResponseData' => NULL], 200);
    //         }            
            
    //         $ReturnArray = array ();// Define output            
    //         $StartTime   = strtotime ($empTime['start_time']); //Get Timestamp
            
    //         $EndTime  = strtotime ($empTime['end_time']); //Get Timestamp
    //         $AddMins  = 15 * 60;
            
    //         while ($StartTime <= $EndTime) //Run loop
    //         {
    //             $ReturnArray[] = date ("H:i", $StartTime);
    //             $StartTime += $AddMins; //Endtime check
    //         }

    //         $time = AppointmentData::where(['category_id' => $data['category_id']])
    //                 ->where('store_id', $data['store_id'])
    //                 ->where('store_emp_id', $data['emp_id'])
    //                 ->where('appo_date', $date)
    //                 ->whereIn('status',['booked','running','pending','','reschedule'])
    //                 ->get();
            
    //         $currentTime = \Carbon\Carbon::now()->timezone('Europe/Berlin')->format("H:i");
    //         $availableTime = [];
    //         //time slot
    //         foreach ($ReturnArray as $value) {                                                   
    //             if ($value == '0:00') {
    //                 return response()->json(['ResponseCode' => 0, 'ResponseText' => "NO Time Schedule Found. Please try another Date.", 'ResponseData' => NULL], 200);
    //             }
    //             $flag = 'Available';
                
    //             foreach ($time as $row) {                      
    //                     if (\Carbon\Carbon::parse($value)->format("H:i:s") >= \Carbon\Carbon::parse($row['appo_time'])->format("H:i:s") 
    //                         && \Carbon\Carbon::parse($value)->format("H:i:s") < \Carbon\Carbon::parse($row['app_end_time'])->format("H:i:s")) {

    //                         $flag = 'Booked';
    //                         break;
    //                     } else {
    //                         $flag = 'Available';

    //                     }

    //             }


    //             if (\Carbon\Carbon::parse($date)->toDateString() == \Carbon\Carbon::now()->timezone('Europe/Berlin')->toDateString()) {
    //                 if (\Carbon\Carbon::parse($value)->format("H:i") > $currentTime) {
    //                     $availableTime [] = [
    //                         'time' => $value,
    //                         'flag' => $flag
    //                     ];
    //                 }
    //             } else {
    //                 $availableTime [] = [
    //                     'time' => $value,
    //                     'flag' => $flag
    //                 ];
    //             }
    //         }
    //         $up = [];
    //         $up1 = [];
    //         $times = 0;
    //         foreach ($availableTime as $item => $row) {
    //             if ($row['flag'] == 'Available') {
    //                 $times = $times + 15;
    //                 $up[] = $row['time'];
    //                 if ($times > $av) {
    //                     $up = array();
    //                     $times = 0;
    //                 }
    //             } else {
    //                 if ($times < $av) {

    //                     foreach ($up as $i) {
    //                         $key = array_search($i, array_column($availableTime, 'time'));
    //                         $up1[] = $key;
    //                     }
    //                     $up = array();
    //                     $times = 0;
    //                 } else {
    //                     $times = 0;
    //                     $up = array();
    //                 }

    //             }
    //         }
    //         foreach ($up1 as $i) {
    //             $availableTime[$i]['flag'] = 'Booked';
    //         }

    //         $ntimes = 0;
    //         $up12 = [];
    //         $up2 = [];

    //         foreach ($booking as $value) {
    //             foreach ($availableTime as $item => $row) {

    //                 if (\Carbon\Carbon::parse($value['appo_date'])->toDateString() == \Carbon\Carbon::parse($date)->toDateString() && (int)$value['category_id'] != $category) {
    //                     if ($value['appo_time'] <= $row['time']) {

    //                         $ntimes = $ntimes + 15;
    // //                        dump($ntimes);
    //                         if ((int)$value['totalTime'] >= $ntimes) {

    //                             $up2[] = $row['time'];

    //                         }
    //                         if ((int)$value['totalTime'] < $ntimes) {

    //                             $up2[] = $row['time'];
    //                             $ntimes = 0;
    //                             break;
    //                         }

    //                     }
    //                 }
    //             }
    //         }

    //         foreach ($up2 as $i) {
    //             $key = array_search($i, array_column($availableTime, 'time'));
    //             $up12[] = $key;
    //         }

    //         foreach ($up12 as $i) {
    //             $availableTime[$i]['flag'] = 'Booked';
    //         }



    //         return response()->json(['ResponseCode' => 1, 'ResponseText' => "Successfully", 'ResponseData' => $availableTime], 200);
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
        $getbookingData = TemporarySelectService::where('device_token',$data['device_token'])
                        ->select('category_id','appo_date','appo_time','totalTime')->get();
        if(count($getbookingData) > 0 ){
            foreach ($getbookingData as $value) {
                $value['appo_date'] = \Carbon\Carbon::parse($value['appo_date'])->format('Y-m-d');
                $value['appo_time'] = \Carbon\Carbon::parse($value['appo_time'])->format("H:i");                
            }
            $booking = $getbookingData;
        } else {
            $booking = [];
        }        
        $storeTime = StoreTiming::where('store_id', $data['store_id'])->where('day', $day)->first();

        if (empty($storeTime) || $storeTime['is_off'] == 'on') {
            return response()->json(['ResponseCode' => 0, 'ResponseText' => __("No Time Schedule Found. Please try another Date"), 'ResponseData' => NULL], 200);
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
                return response()->json(['ResponseCode' => 0, 'ResponseText' => __("No Time Schedule Found. Please try another Date"), 'ResponseData' => NULL], 200);
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
            return response()->json(['ResponseCode' => 0, 'ResponseText' => __("No Emp available for this service"), 'ResponseData' => []], 200);  
        }
    }
}
