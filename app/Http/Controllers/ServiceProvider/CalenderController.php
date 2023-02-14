<?php

namespace App\Http\Controllers\ServiceProvider;

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

class CalenderController extends Controller
{
    public function calendar(){
        $store_id = session('store_id');

        if (empty($store_id)) {
            $getStore = StoreProfile::where('user_id', Auth::user()->id)->pluck('id')->all();
        } else {
            $getStore = StoreProfile::where('user_id', Auth::user()->id)->where('id', $store_id)->pluck('id')->all();
        }

        $appointments = AppointmentData::leftjoin('appointments', 'appointments.id', '=', 'appointment_data.appointment_id')
            ->leftjoin('payment_method_infos', 'payment_method_infos.appoinment_id', '=', 'appointments.id')
            ->whereIn('appointments.store_id',$getStore)
            ->select('appointment_data.*', 'payment_method_infos.status as payment_status','payment_method_infos.payment_method', 'appointments.order_id',
                'appointments.user_id','appointments.first_name','appointments.last_name','appointments.email')
            ->get();

        $calander = [];
        foreach ($appointments as $row) {
            $storeData = StoreProfile::findorFail($row->store_id);

            $row->storeData = $storeData;
            $image = Service::where('id', $row->service_id)->value('image');
            if(!empty($image)){
                $row->image = $image;
            } else {
                $row->image = '' ;
            }

            $row->variantData = ServiceVariant::where('id', $row->variant_id)->first();

            $row->empData = StoreEmp::where('id', $row->store_emp_id)->first();
            $row->userData = User::where('id',$row->user_id)->first();
            $row->is_login = 'no';
            if(!empty($row->userData)){
                $row->is_login = 'yes';
            }
            if($row->status == 'pending' || $row->status == 'booked' ||$row->status == 'reschedule'){

                $row->cancellation = \BaseFunction::checkCancelRatio($row->store_id,$row->appointment_id);
            } else {
                $row->cancellation = '';
            }
            if(!empty($row->variantData)){
                $des = view('ServiceProvider.Calender.calender_details', compact('row'))->render();
                $endtime = \Carbon\Carbon::parse($row->appo_time)->addMinutes($row->variantData['duration_of_service'])->format('H:i:s');
                $startDate = date('Y-m-d H:i:s', strtotime("$row->appo_date  $row->appo_time"));
                $endDate = date('Y-m-d H:i:s', strtotime("$row->appo_date  $endtime"));
                $row->der = $des;
                $calander[] = array('title'=>ucfirst($row->service_name),'start'=>$startDate,'end'=>$endDate,'description'=>$des,'app_id'=>$row->id);
            }

        }

        $employee = StoreEmp::whereIn('store_id',$getStore)->get();
		$employee_pluck = StoreEmp::whereIn('store_id',$getStore)->pluck('emp_name', 'id')->toArray();
		
        $day = \Carbon\Carbon::now()->format('l');
        foreach ($employee as $row){
            $row->time = StoreEmpTimeslot::where('day',\Carbon\Carbon::now()->format('l'))->where('store_emp_id',$row->id)->first();
        }

        return view('ServiceProvider.Calender.index',compact('calander','employee','employee_pluck'));
    }


    public function index(Request $request)
    {
		$store_id = session('store_id');
        $storeProfiles = StoreProfile::where('user_id', Auth::user()->id)->with('storeExpert')->get();

        if($store_id)
        {
            $getStore = StoreProfile::where('user_id', Auth::user()->id)->where('id',$store_id)->pluck('id')->all();
        }
        else{
            $getStore = StoreProfile::where('user_id', Auth::user()->id)->pluck('id')->all();
        }
        $appointments = Appointment::whereIn('store_id',$getStore)->get();
        
        $employees = StoreEmp::with('EmpBreakSlot')->whereIn('store_id',$getStore)->get();

        // foreach($appointments as $appointment):
        //     if($appointment->id === 210):
        //         echo "Two Appointment data in one appointment Case<br>";
        //         foreach($appointment->appointmentDetail as $ap):
        //             print_r('#ID: '.$ap->id);
        //             print_r('#Appoiintment Name: '.$appointment->first_name);
        //             echo "<br>";
        //         endforeach;
        //     endif;
        // endforeach;
        // die();
		$employee_pluck = StoreEmp::whereIn('store_id',$getStore)->pluck('emp_name', 'id')->toArray();
        return view('ServiceProvider.Calender.calendar',get_defined_vars());
    }

    public function findAppointments(Request $request)
    {
        $ids=explode(',',$request->ids);
		$date = $request->date;
        $getStore = StoreProfile::where('user_id', Auth::user()->id)->pluck('id')->all();

//        $apids = AppointmentData::wherein('store_emp_id', $ids)->where('store_id',$getStore)->orderByRaw(DB::raw("FIELD(store_emp_id,'".implode("','", $ids)."')"))->pluck('appointment_id')->toArray();

        /* $appointments = Appointment::where('store_id',$getStore)
            ->whereHas('appointmentDetail',function ($q) use ($ids){
                $q->whereIn('store_emp_id',$ids);
            })->with('appointmentDetail')->get(); */
			
		$appointments = AppointmentData::leftjoin('appointments', 'appointments.id', '=', 'appointment_data.appointment_id')->wherein('appointment_data.store_emp_id', $ids)->whereDate('appointment_data.appo_date', '=', $date)->whereIn('appointment_data.store_id',$getStore)->orderByRaw(DB::raw("FIELD(appointment_data.store_emp_id,'".implode("','", $ids)."')"))->select('appointment_data.*', 'appointments.first_name', 'appointments.last_name')->get();
		foreach($appointments as $row){
			$startTime = \Carbon\Carbon::parse($row->appo_time);
			$finishTime = \Carbon\Carbon::parse($row->app_end_time);
			$row->duration_of_service  = (String)$finishTime->diffInMinutes($startTime);
		}
        $employees = StoreEmp::whereIn('id',$ids)->orderByRaw(DB::raw("FIELD(id,'".implode("','", $ids)."')"))->get();
		$EmpBreakSlot  = StoreEmpBreakslot::wherein('store_emp_id', $ids)
							->where(function($query) use($date){
								$query->where('day', $date)->orWhere('everyday', 'on');
							})->orderByRaw(DB::raw("FIELD(store_emp_id,'".implode("','", $ids)."')"))->get();
		

        return response()->json(['success'=>true,'appointments'=>$appointments,'employees'=>$employees,'EmpBreakSlot'=>$EmpBreakSlot]);

    }

	function send_notification_android($image = null) {
		$title = 'Krishan Kothari';
		$detail = 'We are testing';
		$registatoin_ids = array("fZAExTkNSLy-EMcG3tUcoz:APA91bHSOZCoPxtXEbEkKfzcqUKPK44iEYDnXwU3VOqZNSrLlfGnwaUGCa5ogPKlDtNNrjS5h1uENqTc8_qkRQJTIFf4bAL5jRpnRnpQfouM8S9WsE2TJeQrKX82DBKKW60-tagc2Ocf");
	
		
		//$api_key  = "AAAAz_3Yhw8:APA91bG0Fyitm1oAYoDfPQT8ooEZl50B4avXZxYzP29nJ8RgbrMRebiDigyO4UxipWNW7vEbMaDZBq6GVyVZUQJVS44cYqmJNhQgGKNLLH5Xgf9lS0vqsBzctyijl3foNZj6Fd0C4nJk";
		$api_key  = "AAAAVE5r2FQ:APA91bHx9j0ShRBUtcmQksk1mXitT92oSA57dk0aQiQcHgAA-Jm-ynwSlSjlEKXOlH287sKZa9ijso37rkPh_zT3IDAG0gN_myCPQAJSHuUzKjgwrTYPnf0euaHMg--AYsep2V9lJN6x";
		$url    = 'https://fcm.googleapis.com/fcm/send';
		$data = array
		(
			'title' 	=> $title,
			'body' 	=> $detail,
			'message' 	=> $detail,
			'sound' => 'default',
			'image' => $image,
			 'activity' => 'MainActivity'
		); 
		
		$notification= array
		(
			'title' 	=> $title,
			'body' 	=> $detail,
			 'click_action' => '.MainActivity',
			'sound' => 'default',
			'image' => $image,
			 'badge' => '1'
		); 


		/*$fields = array(
			'registration_ids' => $registatoin_ids,
			 'priority'             => "high",
           		 'data'         => $data,
			'notification' => $notification
		); */
		$data = array
    (
                        'title' 	=> $title,
			'body' 	=> $detail,
			'message' 	=> $detail,
			'sound' => 'default',
			'image' => $image,
                        'activity' => 'MainActivity'
    );
   
   $fields = array(
			'registration_ids' => $registatoin_ids,
			 'priority'             => "high",
           		 'data'         => $data,
			 'click_action' => '.MainActivity',
                         'sound' => 'default', 
                         'badge' => '1'
		); 
		
		$headers = array(
			'Authorization: key = ' . $api_key,
			'Content-Type: application/json'
		);
		
		// Open connection
		$ch = curl_init();
		// Set the url, number of POST vars, POST data
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		// Disabling SSL Certificate support temporarly
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
		
		// Execute post
		$result = curl_exec($ch);
		if($result === FALSE) {
			die('Curl failed: ' . curl_error($ch));
		}
		// Close connection
		curl_close($ch);
	//	echo $result;
		return $result;
	}

    public function findAppointment($id)
    {
        //$appointmentDetail = AppointmentData::where('id',$id)->first();
        $appointmentDetail = AppointmentData::leftjoin('payment_method_infos', 'payment_method_infos.appoinment_id', '=', 'appointment_data.appointment_id')->where('appointment_data.id', $id)->first(['appointment_data.*', 'payment_method_infos.status as payment_status','payment_method_infos.card_type as card_type','payment_method_infos.payment_method as payment_method']);
        $row = $appointmentDetail->appointmentDetails;
        return view('ServiceProvider.Calender.modal_info',get_defined_vars());
    }

    public function appointmentForDetail($id)
    {
       $app = Appointment::where('id',$id)->first();
       $customer = Customer::where('email',$app->email)->first();
        
      $id = encrypt($customer->id);
      return redirect()->to('dienstleister/kunden-details/ansehen/'.$id);
    }
}
