<?php

namespace App\Http\Controllers\Cron;

use App\Http\Controllers\Controller;
use App\Models\AppointmentData;
use App\Models\ServiceAppoinment;
use App\Models\ServiceVariant;
use App\Models\User;
use App\Models\StoreProfile;
use App\Models\StoreEmp;
use App\Models\StoreEmpTimeslot;
use App\Models\StoreTiming;
use App\Models\PaymentMethodInfo;
use App\Models\Appointment;
use App\Models\BookingTemp;
use App\Models\ApiSession;
use Illuminate\Http\Request;

class CronController extends Controller
{
    public function activeAppointment()
    {
        $date = \Carbon\Carbon::now()->timezone('Europe/Berlin')->format('Y-m-d');
        $time = \Carbon\Carbon::now()->timezone('Europe/Berlin')->format('H:i:s');
//        $lastHourtime = \Carbon\Carbon::now()->timezone('+1')->subHour('1')->format('H:i:s');

        $StartTime = strtotime($time);
        $finalTime = date("H:i:s", $StartTime - 600);

        $getTodayUpdate = AppointmentData::whereDate('appo_date', $date)
            ->whereBetween('appo_time', [$finalTime, $time])
            ->whereIn('status', ['booked'])->update(['status' => 'running']);

        if ($getTodayUpdate) {
            \Log::debug('Running Appointment Running complete');
        }
        \Log::debug('Running Appointment Running');
	
    }

	
	public function cancelAppointment()
    {
		
		$date = \Carbon\Carbon::now()->timezone('Europe/Berlin')->format('Y-m-d');
		$time = \Carbon\Carbon::now()->timezone('Europe/Berlin')->format('H:i:s');
		
		$canceled = AppointmentData::whereDate('appo_date', $date)
            ->where('appo_time', "<=", $time)
            ->whereIn('status', ['reschedule'])->get();
			foreach($canceled as $val){
				$AppointmentAr = Appointment::where('id', $val->appointment_id)->first();
				\BaseFunction::notification('Verschoben !','Buchung wurde storniert','appointment',$val['id'],$AppointmentAr['store_id'],$AppointmentAr['user_id'],$AppointmentAr['user_id'] == ''? 'guest' : '', 'users');
				
				//send cancellation email to user
				\BaseFunction::sendEmailNotificationAppointment($val->id, "cancelled");
			 
				//Push Notification for cancellations
				$PUSer = User::find($AppointmentAr['user_id']);
				if(!empty($PUSer->device_token) && !empty($PUSer->allow_notifications) && $PUSer->allow_notifications == 1){
					$sessioncount = ApiSession::where('user_id', $PUSer->id)->count();
					if($sessioncount > 0){
						$registerarion_ids = array($PUSer->device_token);
						$pdate  = \Carbon\Carbon::parse($val['appo_date'])->format('d.m.Y');
						$ptime  = \Carbon\Carbon::parse($val['appo_time'])->format('H:i');
						$store_name = StoreProfile::where('id', $AppointmentAr['store_id'])->value('store_name');
						$Pdeatail = "Dein Termin am ". $pdate ." um ".$ptime." bei ". $store_name." wurde leider storniert.";
						$icon  = asset('storage/app/public/notifications/Cancellation.png');
						\BaseFunction::sendPushNotification($registerarion_ids, 'Stornierung!', $Pdeatail, NULL, NULL, $val->appointment_id);
					}
				}
				//PUSH Notification code ends 
				
				$this->refundPayment($val->appointment_id, $val->id);
			}	
		
		$cancelRescheduleUpdate = AppointmentData::whereDate('appo_date', $date)
            ->where('appo_time', "<=", $time)
            ->whereIn('status', ['reschedule'])->update(['status' => 'cancel', 'cancel_reason' => 'automatisch storniert', 'cancelled_by' => 'store']);
		
		if ($cancelRescheduleUpdate) {
			
            \Log::debug('Cancel Appointment Running complete');
        }
        \Log::debug('Cancel Appointment Running');
		
		
	}

	public function reminderNotification(){
		$date = \Carbon\Carbon::now()->timezone('Europe/Berlin')->format('Y-m-d');
        $time = \Carbon\Carbon::now()->timezone('Europe/Berlin')->format('H:i:s');
		$before24Hourtime = \Carbon\Carbon::now()->addHour('24')->format('Y-m-d H:i:s');
		$before24Hourtimeminute = \Carbon\Carbon::parse($before24Hourtime)->subMinutes('1')->format('Y-m-d H:i:s');
		
		$before24hourdate = \Carbon\Carbon::parse($before24Hourtime)->format('Y-m-d');
		$before24hourtime = \Carbon\Carbon::parse($before24Hourtime)->format('H:i');
		
		$before24Hourtimeminutedate = \Carbon\Carbon::parse($before24Hourtimeminute)->format('Y-m-d');
		$before24Hourtimeminutetime = \Carbon\Carbon::parse($before24Hourtimeminute)->format('H:i');
		
		$before1Hourtime = \Carbon\Carbon::now()->addHour('1')->format('Y-m-d H:i:s');
		$before1Hourtimeminute = \Carbon\Carbon::parse($before1Hourtime)->subMinutes('1')->format('Y-m-d H:i:s');
		
		$before1hourdate = \Carbon\Carbon::parse($before1Hourtime)->format('Y-m-d');
		$before1hourtime = \Carbon\Carbon::parse($before1Hourtime)->format('H:i');
		
		$before1Hourtimeminutedate = \Carbon\Carbon::parse($before1Hourtimeminute)->format('Y-m-d');
		$before1Hourtimeminutetime = \Carbon\Carbon::parse($before1Hourtimeminute)->format('H:i');
		
        $appointment_data = AppointmentData::whereBetween('appo_date', [$before24Hourtimeminutedate, $before24hourdate])
            ->whereBetween('appo_time', [$before24Hourtimeminutetime, $before24hourtime])
            ->whereIn('status', ['booked'])->where('is_notified', '!=', 1)->get();
		
		foreach($appointment_data as $val){
			$AppointmentAr  = Appointment::find($val['appointment_id']);
			//Push Notification for cancellations
			$PUSer = User::find($AppointmentAr['user_id']);
			if(!empty($PUSer->device_token) && !empty($PUSer->allow_notifications) && $PUSer->allow_notifications == 1){
				$sessioncount = ApiSession::where('user_id', $PUSer->id)->count();
				if($sessioncount > 0){
					$registerarion_ids = array($PUSer->device_token);
					$pdate  = \Carbon\Carbon::parse($val['appo_date'])->format('d.m.Y');
					$ptime  = \Carbon\Carbon::parse($val['appo_time'])->format('H:i');
					$store_name = StoreProfile::where('id', $AppointmentAr['store_id'])->value('store_name');
					$Pdeatail = "Nicht vergessen, dass dein gebuchter Termin bei ". $store_name ." bald ansteht. Am ".$pdate." um ". $ptime.".";
					\BaseFunction::sendPushNotification($registerarion_ids, 'Dein Termin ist bald !', $Pdeatail, NULL, NULL, $val['appointment_id']);
					AppointmentData::where('id', $val['id'])->update(['is_notified' => 1]);
				}
			}
			//PUSH Notification code ends 
		}
		
		
		 $appointment_data = AppointmentData::whereBetween('appo_date', [$before1Hourtimeminutedate, $before1hourdate])
            ->whereBetween('appo_time', [$before1Hourtimeminutetime, $before1hourtime])
            ->whereIn('status', ['booked'])->where('is_notified', '!=', 1)->get();
		
		foreach($appointment_data as $val){
			$AppointmentAr  = Appointment::find($val['appointment_id']);
			//Push Notification for cancellations
			$PUSer = User::find($AppointmentAr['user_id']);
			if(!empty($PUSer->device_token) && !empty($PUSer->allow_notifications) && $PUSer->allow_notifications == 1){
				$sessioncount = ApiSession::where('user_id', $PUSer->id)->count();
				if($sessioncount > 0){
					$registerarion_ids = array($PUSer->device_token);
					$pdate  = \Carbon\Carbon::parse($val['appo_date'])->format('d.m.Y');
					$ptime  = \Carbon\Carbon::parse($val['appo_time'])->format('H:i');
					$store_name = StoreProfile::where('id', $AppointmentAr['store_id'])->value('store_name');
					$Pdeatail = "Nicht vergessen, dass dein gebuchter Termin bei ". $store_name ." bald ansteht. Am ".$pdate." um ". $ptime.".";
					\BaseFunction::sendPushNotification($registerarion_ids, 'Dein Termin ist bald !', $Pdeatail, NULL, NULL, $val['appointment_id']);
					AppointmentData::where('id', $val['id'])->update(['is_notified' => 1]);
				}
			}
			//PUSH Notification code ends 
		}
		
        \Log::debug('Running Appointment Running complete');
		
	}

	public function releaseBookingSlot(){
		$date = \Carbon\Carbon::now()->timezone('Europe/Berlin')->format('Y-m-d H:i:s');
		$blockedTime = \Carbon\Carbon::now()->subMinutes(5)->format('Y-m-d H:i:s');
		
        $PaymentMethodInfo = PaymentMethodInfo::where('created_at', '<=', $blockedTime)->whereIn('status', ['pending','failed'])->get();
		
		foreach($PaymentMethodInfo as $val){
			Appointment::where('id', $val->appoinment_id)->delete();
			AppointmentData::where('appointment_id', $val->appoinment_id)->delete();
			PaymentMethodInfo::where('id', $val->id)->whereIn('status', ['pending','failed'])->delete();
		}
		 BookingTemp::where('created_at', '<=', $blockedTime)->delete();
        \Log::debug('Release booking slot complete');
	}
	
	
	function refundPayment($appointment, $appointmentdata_id)
    {
        $message = 'automatisch storniert';

        $serviceAppointment = AppointmentData::where('id', $appointmentdata_id)->first();
        $appointmentData = Appointment::where('id', $appointment)->first();


		$payment = PaymentMethodInfo::where('appoinment_id', $appointment)->first();
		if ($payment['payment_method'] == 'stripe' || $payment['payment_method'] == 'klarna') {
			$stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
			if ($payment['payment_method'] == 'stripe') {
				try {
					$refund = $stripe->refunds->create([
						'charge' => $payment['payment_id'],
						'amount' => $serviceAppointment['price'] * 100,
						'reason' => 'requested_by_customer'
					]);
					$updatePayment = PaymentMethodInfo::where('id', $payment['id'])->update(['refund_id' => $refund['id'], 'status' => 'refund']);
					$updateRefund = AppointmentData::where('id', $appointmentdata_id)->update(['refund_id' => $refund['id']]);
				} catch (\Stripe\Exception\InvalidRequestException $e) {

				}catch (Exception $e) {

				}

			} elseif ($payment['payment_method'] == 'klarna') {
				try {
					$refund = $stripe->refunds->create([
						'payment_intent' => $payment['payment_id'],
						'amount' => $serviceAppointment['price'] * 100,
						'reason' => 'requested_by_customer'
					]);
					$updatePayment = PaymentMethodInfo::where('id', $payment['id'])->update(['refund_id' => $refund['id'], 'status' => 'refund']);
					$updateRefund = AppointmentData::where('id', $appointmentdata_id)->update(['refund_id' => $refund['id']]);
				} catch (\Stripe\Exception\InvalidRequestException $e) {

				}catch (Exception $e) {

				}

			}


		}

		if ($payment['payment_method'] == 'cash'){
			$updatePayment = PaymentMethodInfo::where('id', $payment['id'])->update(['refund_id' => 'cash', 'status' => 'refund']);
		}
		\BaseFunction::notification('Termin storniert !','Buchung wurde storniert','appointment',$serviceAppointment['id'],$serviceAppointment['store_id'],$appointmentData['user_id'],$appointmentData['user_id'] == ''? 'guest' : '');
		 return true;

       
    }
	
    public function completeAppointment()
    {
		
        $date = \Carbon\Carbon::now()->timezone('Europe/Berlin')->format('Y-m-d');
        $time = \Carbon\Carbon::now()->timezone('Europe/Berlin')->format('H:i:s');

        $StartTime = strtotime($time);
        //$finalTime = date("H:i:s", $StartTime - 600);
		$finalTime = date("H:i:s", $StartTime);


        $getTodayAppointment = AppointmentData::whereDate('appo_date', $date)
            ->whereTime('appo_time', '<=', $finalTime)
            ->where('status', 'running')
            ->get();

        foreach ($getTodayAppointment as $row) {
            $service_min = @$row->variantData->duration_of_service;
            $diff_time = (strtotime($time) - strtotime($row->appo_time)) / 60;
            // \Log::debug($row->id);
            // \Log::debug((int)$diff_time);
            // \Log::debug((int)$service_min);
            if ((int)$diff_time >= ((int)$service_min + 3)) {

                $updateApoo = AppointmentData::where('id', $row->id)->update(['status' => 'completed']);
            }
        }
        \Log::debug('completed Appointment Running complete');
		

    }

    public function timeSlot()
    {
        $date = '2021-06-21';
        $store = 278;
        $category = 1;
        $av = 60    ;
        // $emp_id = 7;

        $date = \Carbon\Carbon::parse($date)->format('Y-m-d');
        $day = \Carbon\Carbon::parse($date)->format('l');

        $storeTime = StoreTiming::where('store_id', $store)->where('day', $day)->first();

        if (empty($storeTime)) {
            return array();
        }

        if ($storeTime['is_off'] == 'on') {
            return array();
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

        $time = AppointmentData::where(['category_id' => $category])
            ->where('store_id', $store)
            ->where('appo_date', $date)
            ->get();


        $countPartEmp = StoreEmp::join('store_emp_categories', 'store_emp_categories.store_emp_id', '=', 'store_emps.id')
            ->join('store_emp_timeslots', 'store_emp_timeslots.store_emp_id', '=', 'store_emps.id')
            ->where('store_emp_categories.category_id', $category)
            ->where('store_emps.store_id', $store)
            ->where('store_emps.worktype', 'Part-Time')
            ->where('store_emps.status', 'active')
            ->where('store_emp_timeslots.day', $day)
            ->select('store_emps.*', 'store_emp_timeslots.start_time', 'store_emp_timeslots.end_time', 'store_emp_timeslots.is_off')
            ->get();

          

        $currentTime = \Carbon\Carbon::now()->timezone('Europe/Berlin')->format("H:i");
        $availableTime = [];

        foreach ($ReturnArray as $value) {
            if ($value == '0:00') {
                return array();
            }
            $i = 1;
            $flag = 'Available';

            $countEmp = StoreEmp::join('store_emp_categories', 'store_emp_categories.store_emp_id', '=', 'store_emps.id')
                ->where('store_emp_categories.category_id', $category)
                ->where('store_emps.store_id', $store)
                ->where('store_emps.worktype', 'Full-Time')
                ->where('store_emps.status', 'active')
                ->count();
                
            foreach ($countPartEmp as $item) {
                if (\Carbon\Carbon::parse($value)->format("H:i:s") >= \Carbon\Carbon::parse($item['start_time'])->format("H:i:s") && \Carbon\Carbon::parse($value)->format("H:i:s") <= \Carbon\Carbon::parse($item['end_time'])->format("H:i:s") && $item['is_off'] == 'off') {
                    $countEmp = $countEmp + 1;
                }
            }
          
            foreach ($time as $row) {

                if (\Carbon\Carbon::parse($value)->format("H:i:s") >= \Carbon\Carbon::parse($row['appo_time'])->format("H:i:s") && \Carbon\Carbon::parse($value)->format("H:i:s") < \Carbon\Carbon::parse($row['app_end_time'])->format("H:i:s")) {
                   
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
                    if ($times == $av) {
                        unset($up[0]);
                        foreach ($up as $i) {
                            $key = array_search($i, array_column($availableTime, 'time'));
                            $up1[] = $key;
                        }
                    }
                    $times = 0;
                    $up = array();
                }

            }
        }
        foreach ($up1 as $i) {
            $availableTime[$i]['flag'] = 'Booked';
        }

        // dd($availableTime)
        return $availableTime;
    }

   
}
