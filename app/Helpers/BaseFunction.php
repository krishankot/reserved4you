<?php

namespace App\Helpers;

use App\Models\Appointment;
use App\Models\AppointmentData;
use App\Models\Category;
use App\Models\ApiSession;
use App\Models\Product;
use App\Models\Service;
use App\Models\ServiceAppoinment;
use App\Models\ServiceVariant;
use App\Models\StoreEmp;
use App\Models\StoreEmpService;
use App\Models\StoreEmpTimeslot;
use App\Models\StoreEmpBreakslot;
use App\Models\StoreTiming;
use App\Models\User;
use App\Models\Role;
use App\Models\Customer;
use App\Models\StoreProfile;
use App\Models\BookingTemp;
use App\Models\Notification;
use App\Models\PaymentMethodInfo;
use App\Models\StoreRatingReview;
use App\Models\CustomerRequest;
use Auth;
use URL;
use Mail;
use File;
use Carbon\Carbon;
use Session;
use DB;
use Illuminate\Support\Facades\Redirect;

class BaseFunction
{
    /**
     * Get all notifications
     * @param none
     * @return object
     */
	public static function getNotifications(){
		$store_id = session('store_id');
        if(empty($store_id)){
            $getStore = StoreProfile::where('user_id', Auth::user()->id)->pluck('id')->all();
        } else{
            $getStore = StoreProfile::where('user_id', Auth::user()->id)->where('id',$store_id)->pluck('id')->all();
        }

        $data = Notification::whereIn('store_id',$getStore)->orderBy('created_at','DESC')->paginate(5);
		return $data;
	}
	
	
	
	
	/**
     * Generate Api Token
     * @param $userId
     * @return bool|mixed|string
     */
    public static function setSessionData($userId, $device_id = null, $device_token = null, $device_type = null)
    {
        if (empty($userId)) {
            return "User id is empty.";
        } else {
            /*  FIND USER ID IN API SESSION AVAILABE OR NOT  */
			if(!empty($device_id)){
				$getApiSessionData = ApiSession::where('user_id', $userId)->where('device_id',  $device_id)->first();
			}else{
				$getApiSessionData = ApiSession::where('user_id', $userId)->first();
			}
            if ($getApiSessionData) {
                if ($getApiSessionData->delete()) {
                    $apiSession = new ApiSession();
                    /*  SET SESSION DATA  */
                    $sessionData = [];
                    $sessionData['session_id'] = encrypt(rand(1000, 999999999));
                    $sessionData['user_id'] = $userId;
                    $sessionData['login_time'] = \Carbon\Carbon::now();
                    $sessionData['active'] = 1;
					$sessionData['device_id'] = $device_id;
                    $sessionData['device_token'] = $device_token;
                    $sessionData['device_type'] = $device_type;
                    $apiSession->fill($sessionData);
                    if ($apiSession->save()) {
                        return $apiSession->session_id;
                    } else {
                        return FALSE;
                    }
                } else {
                    return FALSE;
                }
            } else {
                $apiSession = new ApiSession();
                /*  SET SESSION DATA  */
                $sessionData = [];
                $sessionData['session_id'] = encrypt(rand(1000, 999999999));
                $sessionData['user_id'] = $userId;
                $sessionData['login_time'] = \Carbon\Carbon::now();
                $sessionData['active'] = 1;
				$sessionData['device_id'] = $device_id;
				$sessionData['device_token'] = $device_token;
				$sessionData['device_type'] = $device_type;
                $apiSession->fill($sessionData);
                if ($apiSession->save()) {
                    return $apiSession->session_id;
                } else {
                    return FALSE;
                }
            }
        }
    }

    /**
     * Check token is valid or not
     * @param $sessionId
     * @return array
     */
    public static function checkApisSession($sessionId)
    {
        $checkSessionExist = ApiSession::where('session_id', $sessionId)->first();
        if ($checkSessionExist) {
            $sGetUserDataessionData = [];
            $sessionData['id'] = ($checkSessionExist->id) ? $checkSessionExist->id : '';
            $sessionData['session_id'] = ($checkSessionExist->session_id) ? $checkSessionExist->session_id : '';
            $sessionData['user_id'] = ($checkSessionExist->user_id) ? $checkSessionExist->user_id : '';
            $sessionData['active'] = ($checkSessionExist->active) ? $checkSessionExist->active : '';
            $sessionData['login_time'] = ($checkSessionExist->login_time) ? $checkSessionExist->login_time : '';
            return $sessionData;
        } else {
            return array();
        }
    }

    /**
     * Get Random Code
     * @param $limit
     * @return false|string
     */
    public static function random_code($limit)
    {
        return substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $limit);
    }
	
	/**
     * Get User Details
     * @param $id
     * @return mixed
     */
    public static function checkCustomerExists($email, $store_id)
    {
		$user  = User::where('email', $email)->where('status', 'active')->count();
		if($user <= 0){
			return true;
		}
        $data = Customer::where('email',$email)->where('store_id', $store_id)->count();
		if($data > 0){
			return true;
		}
        return false;
    }
	
	
	/**
     * Get User Details
     * @param $id
     * @return mixed
     */
    public static function isCustomerRequested($store_id, $user_id)
    {
        $data = CustomerRequest::where('store_id',$store_id)->where('user_id',$user_id)->first();
		if(!empty($data->id)){
			return ($data->status == 0)?'Requested':'Rejected';
		}
        return false;
    }

    /**
     * Get User Details
     * @param $id
     * @return mixed
     */
    public static function getUserDetails($id)
    {
        $data = User::where('id',$id)->first();

        return $data;
    }
	
	
	 /**
     * Get User Details
     * @param $id
     * @return mixed
     */
    public static function getUserDetailsByEmail($email, $field_name = null)
    {
        $data = User::where('email',$email)->first();
		if($field_name){
			if($field_name == 'user_image_path' && empty($data['profile_pic'])){
				return false;
			}
			return !empty($data[$field_name])?$data[$field_name]:NULL;
		}

        return $data;
    }
	

    public static function getCategoryDate($id)
    {
        $data = Category::where('id',$id)->first();
        return $data;
    }

    public static function getStoreDetails($userId)
    {
        $id = StoreProfile::where('user_id', $userId)->pluck('id');
        return $id;
    }

    public static function getCategoryType($id)
    {
        $data = Category::where('id', $id)->value('category_type');
        return $data;
    }

    public static function getserviceName($id)
    {
        $data = Service::where('id', $id)->value('service_name');
        return $data;
    }

    public static function getCategoryName($id)
    {
        $data = Category::where('id', $id)->value('name');
        return $data;
    }

    //user avg rating
    public static function userRating($data)
    {
        $rating = $data['service_rate'] + $data['ambiente'] + $data['preie_leistungs_rate'] + $data['wartezeit'] + $data['atmosphare'];
        return number_format($rating / 5, 2);
    }

    public static function orderNumber()
    {
        $getAppointment = Appointment::orderBy('id', 'DESC')->value('order_id');

        if (empty($getAppointment)) {
            $orderId = 0001;
        } else {
            $orderId = $getAppointment + 1;
        }

        return $orderId;

    }

    public static function finalPrice($id)
    {
        $getService = Service::where('id', $id)->first();

        $price = $getService['price'];

        $discountType = $getService['discount_type'];

        if ($discountType == 'amount') {
            $finalPrice = $price - $getService['discount'];
        } elseif ($discountType == 'percentage') {
            $discount = ($price * $getService['discount']) / 100;
            $finalPrice = $price - $discount;
        } else {
            $finalPrice = $price;
        }
       return number_format($finalPrice, 2, '.', '');

    }

    public static function finalPriceVariant($id, $variantId)
    {

        $getService = Service::where('id', $id)->first();
        $getServiceVariant = ServiceVariant::where('id', $variantId)->first();

        $price = $getServiceVariant['price'];

        $discountType = $getService['discount_type'];

        if ($discountType == 'amount') {
            $finalPrice = $price - $getService['discount'];
        } elseif ($discountType == 'percentage') {
            $discount = ($price * $getService['discount']) / 100;
            $finalPrice = $price - $discount;
        } else {
            $finalPrice = $price;
        }
        return number_format($finalPrice, 2, '.', '');

    }

    public static function getSlug($id)
    {
        $slug = StoreProfile::where('id', $id)->value('slug');

        return $slug;
    }


    public static function getEmpFromTime($date, $service_id, $time)
    {
        $day = \Carbon\Carbon::parse($date)->format('l');

        $getStoreEmp = StoreEmpService::where('service_id', $service_id)->pluck('store_emp_id')->all();


        $timeDuration = Service::where('id', $service_id)->value('duration_of_service');
        $getFinalEmp = array();
        foreach ($getStoreEmp as $row) {
            $empTime = StoreEmpTimeslot::where('store_emp_id', $row)->where('day', $day)->where('is_off', '!=', 'on')->first();
            if (!empty($empTime)) {
                $time = ServiceAppoinment::where(['store_emp_id' => $row, 'service_id' => $service_id])
                    ->where('appo_date', $date)->where('appo_time', $time)
                    ->first();
                $employeeList = StoreEmp::where('id', $row)->first();

                $employeeList['image'] = URL::to('storage/app/public/store/employee/' . $employeeList['image']);


                $getFinalEmp[] = $employeeList;
            }

        }
        return $getFinalEmp;
    }

    public static function finalRating($id)
    {
        $getratingCount = StoreRatingReview::where('store_id', $id)->count();
        $getratingData = StoreRatingReview::where('store_id', $id)->sum('total_avg_rating');
        $totalRating = 0;
        if ($getratingCount != 0) {

            $totalRating = $getratingData / $getratingCount;
        }

        return number_format($totalRating, 1);
    }

    public static function finalCount($id)
    {
        $getratingCount = StoreRatingReview::where('store_id', $id)->count();

        return $getratingCount;
    }

    public static function finalRatingService($id, $service_id)
    {
        $getratingCount = StoreRatingReview::where('store_id', $id)->where('service_id',$service_id)->count();
        $getratingData = StoreRatingReview::where('store_id', $id)->where('service_id',$service_id)->sum('total_avg_rating');
        $totalRating = 0;
        if ($getratingCount != 0) {

            $totalRating = $getratingData / $getratingCount;
        }

        return number_format($totalRating, 1);
    }

    public static function getRatingStar($id)
    {
        $id = (string)$id;


        $html = '';
        if ($id >= '1.0' && $id < '1.5') {
            
            $html = '<li class="active"><i class="fas fa-star"></i></li><li class=""><i class="fas fa-star"></i></li><li class=""><i class="fas fa-star"></i></li><li class=""><i class="fas fa-star"></i></li><li class=""><i class="fas fa-star"></i></li>';
        } elseif ($id >= '1.5' && $id < '2.0') {
            $html = '<li class="active"><i class="fas fa-star"></i></li><li class="active"><i class="fas fa-star-half-alt"></i></li><li class=""><i class="fas fa-star"></i></li><li class=""><i class="fas fa-star"></i></li><li class=""><i class="fas fa-star"></i></li>';
        } elseif ($id >= '2.0' && $id < '2.5') {
            $html = '<li class="active"><i class="fas fa-star"></i></li><li class="active"><i class="fas fa-star"></i></li><li class=""><i class="fas fa-star"></i></li><li class=""><i class="fas fa-star"></i></li><li class=""><i class="fas fa-star"></i></li>';
        } elseif ($id >= '2.5' && $id < '3.0') {
            $html = '<li class="active"><i class="fas fa-star"></i></li><li class="active"><i class="fas fa-star"></i></li><li class="active"><i class="fas fa-star-half-alt"></i></li><li class=""><i class="fas fa-star"></i></li><li class=""><i class="fas fa-star"></i></li>';
        } elseif ($id >= '3.0' && $id < '3.5') {
            $html = '<li class="active"><i class="fas fa-star"></i></li><li class="active"><i class="fas fa-star"></i></li><li class="active"><i class="fas fa-star"></i></li><li class=""><i class="fas fa-star"></i></li><li class=""><i class="fas fa-star"></i></li>';
        } elseif ($id >= '3.5' && $id < '4.0') {
            $html = '<li class="active"><i class="fas fa-star"></i></li><li class="active"><i class="fas fa-star"></i></li><li class="active"><i class="fas fa-star"></i></li><li class="active"><i class="fas fa-star-half-alt"></i></li><li class=""><i class="fas fa-star"></i></li>';
        } elseif ($id >= '4.0' && $id < '4.5') {
            $html = '<li class="active"><i class="fas fa-star"></i></li><li class="active"><i class="fas fa-star"></i></li><li class="active"><i class="fas fa-star"></i></li><li class="active"><i class="fas fa-star"></i></li><li class=""><i class="fas fa-star"></i></li>';
        } elseif ($id >= '4.5' && $id < '5.0') {
            $html = '<li class="active"><i class="fas fa-star"></i></li><li class="active"><i class="fas fa-star"></i></li><li class="active"><i class="fas fa-star"></i></li><li class="active"><i class="fas fa-star"></i></li><li class="active"><i class="fas fa-star-half-alt"></i></li>';
        } elseif ($id == '5.0') {
            $html = '<li class="active"><i class="fas fa-star"></i></li><li class="active"><i class="fas fa-star"></i></li><li class="active"><i class="fas fa-star"></i></li><li class="active"><i class="fas fa-star"></i></li><li class="active"><i class="fas fa-star"></i></li>';
        } elseif ($id == '0.5' && $id < '1.0') {
            $html = '<li class=""><i class="fas fa-star-half-alt"></i></li><li class=""><i class="fas fa-star"></i></li><li class=""><i class="fas fa-star"></i></li><li class=""><i class="fas fa-star"></i></li><li class=""><i class="fas fa-star"></i></li>';
        } elseif ($id == '0.0') {
            $html = '<li class=""><i class="fas fa-star"></i></li><li class=""><i class="fas fa-star"></i></li><li class=""><i class="fas fa-star"></i></li><li class=""><i class="fas fa-star"></i></li><li class=""><i class="fas fa-star"></i></li>';
        }
      

        return $html;
    }

    public static function getSubRating($type, $id)
    {
        $getratingCount = StoreRatingReview::where('store_id', $id)->count();
        $getratingData = StoreRatingReview::where('store_id', $id)->sum($type);
        $totalRating = 0;
        if ($getratingCount != 0) {
            $totalRating = $getratingData / $getratingCount;
        }
        return number_format($totalRating, 1);
    }

    public static function checkCancelRatio($id, $appointment)
    {
        $data = StoreProfile::where('id', $id)->first();
        $appo = AppointmentData::where('appointment_id', $appointment)->first();
        $today = \Carbon\Carbon::now()->timezone('Europe/Berlin')->format('Y-m-d H:i');
        $cDay = '';

        if ($data['cancellation_day'] == 'day') {
            $cDay = \Carbon\Carbon::parse($appo['appo_date'])->subDays($data['cancellation_deadline'])->format('Y-m-d');
        } elseif ($data['cancellation_day'] == 'hours') {
            $cDay = \Carbon\Carbon::parse($appo['appo_date'].' '.$appo['appo_time'])->subHour($data['cancellation_deadline'])->format('Y-m-d H:i');
        }
		
        if ($today < $cDay OR empty($cDay)) {
            return 'yes';
        } else {
            return 'no';
        }


    }

    public static function checkDiscountForStore($store_id)
    {
        $getService = Service::where('store_id', $store_id)->get();
        $flag = array();
        foreach ($getService as $value) {
            if ($value['discount_type'] == 'percentage' && $value['discount'] != null) {
                $flag[] = $value['store_id'];
            }
        }
        if (!empty($flag)) {
            $disFlag = true;
        } else {
            $disFlag = false;
        }
        return $disFlag;
    }

    //only service rating
    public static function finalRatingServices($id, $service_id)
    {
        $getratingCount = StoreRatingReview::where('store_id', $id)->where('service_id', $service_id)->count();
        $getratingData = StoreRatingReview::where('store_id', $id)->where('service_id', $service_id)->sum('total_avg_rating');
        $totalRating = 0;
        if ($getratingCount != 0) {
            $totalRating = $getratingData / $getratingCount;
        }

        return number_format($totalRating, 1);
    }

    //service rating count
    public static function finalCountService($id)
    {
        $getratingCount = StoreRatingReview::where('service_id', $id)->count();

        return $getratingCount;
    }

    //only service rating
    public static function finalRatingEmployee($id)
    {
        $getratingCount = StoreRatingReview::where('emp_id', $id)->count();
        $getratingData = StoreRatingReview::where('emp_id', $id)->sum('total_avg_rating');
        $totalRating = 0;
        if ($getratingCount != 0) {
            $totalRating = $getratingData / $getratingCount;
        }

        return number_format($totalRating, 1);
    }

    //service rating count
    public static function finalCountEmployee($id)
    {
        $getratingCount = StoreRatingReview::where('emp_id', $id)->count();

        return number_format($getratingCount, 0);
    }

   

    public static function variantData($id)
    {
        $data = ServiceVariant::where('id',$id)->first();
        return $data;
    }

    public static function serviceData($id)
    {
        $data = Service::where('id',$id)->first();
        return $data;
    }

    public static function bookingAvailableTime($date, $store, $av, $category, $booking)
    {

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

        $time = AppointmentData::where('category_id', $category)
            ->where('store_id', $store)
            ->where('appo_date', $date)
            ->whereIn('status', ['booked', 'running', 'pending', '', 'reschedule'])
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
                if (\Carbon\Carbon::parse($value)->format("H:i:s") >= \Carbon\Carbon::parse($item['start_time'])->format("H:i:s") &&
                    \Carbon\Carbon::parse($value)->format("H:i:s") <= \Carbon\Carbon::parse($item['end_time'])->format("H:i:s") && $item['is_off'] == 'off') {
                    $countEmp = $countEmp + 1;
                }
            }

            foreach ($time as $row) {
                // dump(\Carbon\Carbon::parse($row['app_end_time'])->addMinutes(15)->format("H:i:s"));
                if (\Carbon\Carbon::parse($value)->format("H:i:s") >= \Carbon\Carbon::parse($row['appo_time'])->format("H:i:s") &&
                    \Carbon\Carbon::parse($value)->format("H:i:s") <= \Carbon\Carbon::parse($row['app_end_time'])->addMinutes(15)->format("H:i:s")) {
                //                    dump($i);
                    if ($i >= $countEmp) {
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


        $ntimes = 0;
        $up12 = [];
        $up2 = [];

        foreach ($booking as $value) {
            foreach ($availableTime as $item => $row) {

                if (\Carbon\Carbon::parse($value['date'])->toDateString() == \Carbon\Carbon::parse($date)->toDateString() && (int)$value['category'] != $category) {
                    if ($value['timeslot'] <= $row['time']) {

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
                //        dd($up2);


        $up = [];
        $up1 = [];
        $times = 0;
        $av = $av;

        foreach ($availableTime as $item => $row) {
            if ($row['flag'] == 'Available') {
                $times = $times + 15;
                $up[] = $row['time'];


            } else {
                if ($times < $av) {

                    foreach ($up as $i) {
                        $key = array_search($i, array_column($availableTime, 'time'));
                        $up1[] = $key;
                    }

                    $up = array();
                    $times = 0;
                } 
                else if ($times > $av) {
                    // unset($up[0]);
                    // foreach ($up as $i) {
                    //     $key = array_search($i, array_column($availableTime, 'time'));
                    //     $up1[] = $key;
                    // }
                    $up = array();
                    $times = 0;
                } 
                else {

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

        // dd($availableTime);

        $mincount = ($av-15) / 15;
        $totalavTime = count($availableTime);
        for ($j = 1; $j < $mincount; $j++) {
            $availableTime[$totalavTime - $j]['flag'] = 'Booked';
        }

        return $availableTime;
    }

    public static function bookingAvailableTimeEmp($date, $store, $av, $category, $emp_id, $booking, $is_mobileapp = null)
    {
        
        $date = \Carbon\Carbon::parse($date)->format('Y-m-d');
        $day = \Carbon\Carbon::parse($date)->format('l');

        $storeEmpTime = StoreEmpTimeslot::where('store_emp_id', $emp_id)->where('day', $day)->first();

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


        $countEmp = StoreEmp::join('store_emp_categories', 'store_emp_categories.store_emp_id', '=', 'store_emps.id')
            ->where('store_emp_categories.category_id', $category)
            ->where('store_emps.store_id', $store)
            ->where('store_emps.status', 'active')
            ->count();

        //if ($countEmp == 1) {
          //  $time = AppointmentData::where('store_id', $store)
            //    ->where(['category_id' => $category])
              //  ->where('appo_date', $date)
                //->whereIn('status', ['booked', 'running', 'pending', '', 'reschedule'])
                //->get();
        //} else {
            $time = AppointmentData::where('store_id', $store)
                //->where(['category_id' => $category])
                ->where('store_emp_id', $emp_id)
                ->where('appo_date', $date)
                ->whereIn('status', ['booked', 'running', 'pending', '', 'reschedule','completed'])
                ->get();
        //}

		$breaktime = StoreEmpBreakslot::where('store_emp_id', $emp_id)
					->where(function($query) use($date){ $query->whereDate('day', $date)->orWhere('everyday', 'on');})
                ->get();
				
        //$currentTime = \Carbon\Carbon::now()->addMinutes(5)->timezone('Europe/Berlin')->format("H:i");
		if($is_mobileapp == 'mobileapp'){
			$currentTime = \Carbon\Carbon::now()->addMinutes(5)->timezone('Europe/Berlin')->format("H:i");
		}elseif($is_mobileapp == 'mobileapp_service'){
			$seconds  = 11*60 - 1;
			$currentTime = \Carbon\Carbon::now()->subSeconds($seconds)->timezone('Europe/Berlin')->format("H:i");
		}else{
			if(Auth::check() && Auth::User()->user_role == 'service'){
				 $seconds  = 11*60 - 1;
				 $currentTime = \Carbon\Carbon::now()->subSeconds($seconds)->timezone('Europe/Berlin')->format("H:i");
			}else{
				 $currentTime = \Carbon\Carbon::now()->addMinutes(5)->timezone('Europe/Berlin')->format("H:i");
			}
		}
        $availableTime = [];

        foreach ($ReturnArray as $value) {
            if ($value == '0:00') {
                return array();
            }

            $flag = 'Available';

           
                if(!empty($storeEmpTime)) {
                    if (\Carbon\Carbon::parse($value)->format("H:i:s") >= \Carbon\Carbon::parse($storeEmpTime['start_time'])->format("H:i:s") &&
                    \Carbon\Carbon::parse($value)->format("H:i:s") <= \Carbon\Carbon::parse($storeEmpTime['end_time'])->format("H:i:s") && $storeEmpTime['is_off'] == 'off') {
          
                        foreach ($time as $row) {

                            if (\Carbon\Carbon::parse($value)->format("H:i:s") >= \Carbon\Carbon::parse($row['appo_time'])->format("H:i:s")
                                && \Carbon\Carbon::parse($value)->format("H:i:s") < \Carbon\Carbon::parse($row['app_end_time'])->addMinutes(15)->format("H:i:s")) {
            
                                $flag = 'Booked';
                                break;
                            } else {
                                $flag = 'Available';
            
                            }
                        }
						
						foreach ($breaktime as $row) {
							
                            if (\Carbon\Carbon::parse($value)->format("H:i:s") >= \Carbon\Carbon::parse($row['start_time'])->format("H:i:s")
                                && \Carbon\Carbon::parse($value)->format("H:i:s") < \Carbon\Carbon::parse($row['end_time'])->format("H:i:s")) {
            
                                $flag = 'Booked';
                                break;
                            }
                        }
                    } else {
                        $flag = 'Booked';
                    }
                } else {
                    $flag = 'Booked';
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

        $ntimes = 0;
        $up12 = [];
        $up2 = [];
        $av = $av + 15;
        foreach ($booking as $value) {            
            foreach ($availableTime as $item => $row) {
                
                if ($value['date'] != null && \Carbon\Carbon::parse($value['date'])->toDateString() == \Carbon\Carbon::parse($date)->toDateString() && (int)$value['category'] != $category) {
                    if ($value['timeslot'] <= $row['time']) {

                        $ntimes = $ntimes + 15;
                      
                        if ((int)$value['totalTime'] +15  > $ntimes) {

                            $up2[] = $row['time'];

                        }
                        if ((int)$value['totalTime'] + 15 <= $ntimes) {

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

        $up = [];
        $up1 = [];
        $times = 0;
        $mincount = ceil(($av) / 15);
        
        foreach ($availableTime as $item => $row) {
            if ($row['flag'] == 'Available') {
                $times = $times + 15;
                $up[] = $row['time'];
               
         
            } else {

                if ($times < $av) {

                    foreach ($up as $i) {
                        $key = array_search($i, array_column($availableTime, 'time'));
                        $up1[] = $key;
                    }
                    $up = array();
                    $times = 0;
                }
                else if ($times > $av) {
                    $newup = [];
                    $cup = count($up) - 1;
                    
                    for($p=0;$p<$mincount-1;$p++){
                        $newup[] = $up[$cup - $p];
                    }
                    
                    foreach ($newup as $i) {
                        $key = array_search($i, array_column($availableTime, 'time'));
                        $up1[] = $key;
                    }
                    $up = array();
                    $times = 0;
                } 
                 else {
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
       


        
        $totalavTime = count($availableTime) - 1;
        
        for ($j = 0; $j < $mincount; $j++) {
            $availableTime[$totalavTime - $j]['flag'] = 'Booked';
        }
        return $availableTime;
    }

    public static function getEmployeeDetails($id, $value)
    {
        $data = StoreEmp::where('id', $id)->value($value);

        return $data;
    }

    public static function orderConformData($appointment_id)
    {
        $appointment = Appointment::where('id', $appointment_id)->first();
        if (empty($appointment)) {
            return null;
        }
        $store = StoreProfile::findorFail($appointment['store_id']);
        $serviceData = AppointmentData::where('appointment_id', $appointment_id)->get();

        $serviceData = AppointmentData::where('appointment_id', $appointment_id)->get();

        $paymentinfo = PaymentMethodInfo::with(['storeData' => function ($query) {
            $query->select('id', 'store_name', 'store_address', 'store_profile');
        }])->where('appoinment_id', $appointment_id)->first();
        $paymentinfo['total_amount'] = number_format($paymentinfo['total_amount'], 2);
        $paymentinfo['store_name'] = $paymentinfo['storeData']['store_name'];
        $paymentinfo['store_address'] = $paymentinfo['storeData']['store_address'];
        $paymentinfo['store_image'] = $paymentinfo['storeData']['store_profile_image_path'];
        unset($paymentinfo->storeData);
        $serviceId = array();
        $variantId = array();
        $categoryId = array();
        foreach ($serviceData as $value) {
            $serviceId[] = $value['service_id'];
            $variantId[] = $value['variant_id'];
            $categoryId[] = $value['category_id'];
        }
        $data = Category::with(['servicecategory' => function ($query) use ($serviceId, $variantId) {
            $query->with(['serviceVariant' => function ($q) use ($variantId) {
                $q->whereIn('id', $variantId);
            }])->whereIn('id', $serviceId)
                ->select('id', 'store_id', 'category_id', 'subcategory_id', 'service_name', 'price', 'image', 'discount_type', 'discount');
        }, 'appoData' => function ($q) use ($appointment_id) {
            $q->where('appointment_id', $appointment_id);
        }])->whereIn('id', $categoryId)->select('id', 'name', 'image')->get();
        // dd($data
        foreach ($data as $row) {
            $e_id = array();
            foreach ($row->appoData as $value) {
                $e_id[] = $value['store_emp_id'];
                $appo_date = $value['appo_date'];
                $appo_time = $value['appo_time'];
            }
            // dd($row);
            foreach ($row->servicecategory as $value) {
                $value['price'] = number_format($value['price'], 2);
                $value['finalPrice'] = number_format(\BaseFunction::finalPrice($value['id']), 2);
                foreach ($value->serviceVariant as $variant) {
                    $variant['price'] = number_format($variant['price'], 2);
                    $variant['finalPrice'] = number_format(\BaseFunction::finalPriceVariant($variant['service_id'], $variant['id']), 2);
                }
            }

            $empDetails = StoreEmp::whereIn('id', $e_id)->first();
            $row['emp_name'] = @$empDetails['emp_name'];
            $row['emp_image'] = @$empDetails['emp_image_path'];
            //$row['appo_date'] = date('M d,Y', strtotime($appo_date)) . ' (' . date('D', strtotime($value['appo_date'])) . ')';
            $row['appo_date'] = \Carbon\Carbon::parse($appo_date)->translatedFormat('d F, Y') . ' (' . \Carbon\Carbon::parse($appo_date)->translatedFormat('D') . ')';
            $row['appo_time'] = date('H:i', strtotime($appo_time));
            unset($row->appoData);
        }

        $orderConformData = array(
            'paymentInfo' => $paymentinfo,
            'bookingData' => $data
        );
		
		$paymentinfoArr = PaymentMethodInfo::where('appoinment_id', $appointment_id)->first();
		if(!empty($paymentinfoArr->status) && $paymentinfoArr->status == 'failed'){
			Appointment::where('id', $appointment_id)->delete();
			 AppointmentData::where('appointment_id', $appointment_id)->delete();
			 PaymentMethodInfo::where('appoinment_id', $appointment_id)->delete();
		}
		
        return $orderConformData;
    }

	public static function findStoreDiscount($id)
    {
		$store  = StoreProfile::find($id);
		if(!empty($store->is_discount) && $store->is_discount == 'yes'){
			 $getDiscountData = Service::where('store_id', $id)->where('status', 'active')->max('discount');
		}else{
			$getDiscountData = 0;
		}
        return $getDiscountData;
    }
	
    public static function finalRatingEmp($id, $emp_id)
    {
        $getratingCount = StoreRatingReview::where('store_id', $id)->where('emp_id', $emp_id)->count();
        $getratingData = StoreRatingReview::where('store_id', $id)->where('emp_id', $emp_id)->sum('total_avg_rating');
        $totalRating = 0;
        if ($getratingCount != 0) {
            $totalRating = $getratingData / $getratingCount;
        }

        return number_format($totalRating, 1);
    }

    public static function getUserProfile($email)
    {
        $data = User::where('email', $email)->value('profile_pic');

        return $data;
    }


    /**
     * GET city name by lat && long
     */

    public static function getCityName($lat, $long)
    {
        // https://maps.googleapis.com/maps/api/geocode/json?latlng=52.5155098,13.3847539&sensor=true&key=AIzaSyBSItHxCbk9qBcXp1XTysVLYcJick5K8mU
        $url = 'https://maps.googleapis.com/maps/api/geocode/json?latlng=' . $lat . ',' . $long . '&sensor=true&key=AIzaSyBSItHxCbk9qBcXp1XTysVLYcJick5K8mU';
        $json = @file_get_contents($url);
        $data = json_decode($json);
        $status = $data->status;
        if ($status == "OK") {
            //Get address from json data
            for ($j = 0; $j < count($data->results[0]->address_components); $j++) {
                $cn = array($data->results[0]->address_components[$j]->types[0]);
                if (in_array("locality", $cn)) {
                    $city = $data->results[0]->address_components[$j]->long_name;
                }
            }
        } else {
            echo 'Location Not Found';
        }
        //Print city
        return $city;
    }

    public static function checkBooking($data){
        // dd($data);

        $category = $data['category'];        
        $subcategory = $data['subcategory'];
        $store = $data['store'];
        $date = $data['date'];
        $employee = $data['employee'];
        $time = $data['time'];
        $price = $data['price'];
        $variant = $data['variant'];
        $service = $data['service'];
        $service_data = $data['service_data'];

        $bookedValue = [];
        $cat = '';
            for ($i = 0; $i < count($category); $i++) {
                if($cat == ''){
                    $cat = $category[$i];    
                    $newTime = $time[$i];
                } else if($cat != $category[$i]) {
                    $newTime = $time[$i];
                    $cat = '';
                }

                if($i != 0 && $cat != ''){
                    $getduration = ServiceVariant::where('id',$variant[$i - 1])->value('duration_of_service');
                   
                    if($cat == $category[$i]){
					   $newTime = \Carbon\Carbon::parse( $newTime)->addMinutes($getduration)->format('H:i');
					}else{
					   $newTime = \Carbon\Carbon::parse($time[$i - 1])->addMinutes($getduration)->format('H:i');
					}
                }
                
                $getTimeDuration = ServiceVariant::where('id',$variant[$i])->value('duration_of_service');
                $endTime = \Carbon\Carbon::parse($newTime)->addMinutes($getTimeDuration)->format('H:i');
                $endTime = \Carbon\Carbon::parse($endTime)->addMinutes(15)->format('H:i');

            
                $subData['store_id'] = $store[$i];
                $subData['category_id'] = $category[$i];
                $subData['subcategory_id'] = $subcategory[$i];
                $subData['service_id'] = $service[$i];
                $subData['service_name'] = $service_data[$i];
                $subData['variant_id'] = $variant[$i];
                $subData['price'] = $price[$i];
                $subData['store_emp_id'] = $employee[$i];
                $subData['appo_date'] = $date[$i];
                $subData['appo_time'] = \Carbon\Carbon::parse($newTime)->format('H:i');
                $subData['app_end_time'] = $endTime;

                 $times = AppointmentData::where('store_id', $store[$i])
                    // ->where(['category_id' => $category])
                    ->where('store_emp_id', $employee[$i])
                    ->where('appo_date', $date[$i])
                    ->whereIn('status', ['booked', 'running', 'pending', '', 'reschedule'])
                    ->get();

                    foreach ($times as $key) {
                        // dump($key['appo_time']);
                        // dump(\Carbon\Carbon::parse($key['appo_time'])->subMinute(15)->format('H:i'));
                        // dump(\Carbon\Carbon::parse($newTime)->format('H:i'));
                        // dump(\Carbon\Carbon::parse($key['app_end_time'])->addMinute(15)->format('H:i'));
                        // dump(\Carbon\Carbon::parse($endTime)->format('H:i'));
                        if((\Carbon\Carbon::parse($key['appo_time'])->format('H:i') <= \Carbon\Carbon::parse($newTime)->format('H:i') && 
                            \Carbon\Carbon::parse($key['app_end_time'])->addMinute(15)->format('H:i') > \Carbon\Carbon::parse($newTime)->format('H:i')) OR
                            (\Carbon\Carbon::parse($key['appo_time'])->format('H:i') < \Carbon\Carbon::parse($endTime)->format('H:i') && 
                            \Carbon\Carbon::parse($key['app_end_time'])->addMinute(15)->format('H:i') >= \Carbon\Carbon::parse($endTime)->format('H:i'))){
                             $bookedValue[] = $variant[$i];
                        } 
                        # code...
                    }
                   
                // dump($subData);
               
            }
            // dd($bookedValue);
            return $bookedValue;
        
    }

    public static function sameBookingChecking($data){
        $category = $data['category'];        
        $subcategory = $data['subcategory'];
        $store = $data['store'];
        $date = $data['date'];
        $employee = $data['employee'];
        $time = $data['time'];
        $price = $data['price'];
        $variant = $data['variant'];
        $service = $data['service'];
        $service_data = $data['service_data'];

		//$currentTime = \Carbon\Carbon::now()->addMinutes(5)->timezone('Europe/Berlin')->format("H:i");
		if(Auth::check() and  Auth::User()->user_role == 'service'){
			$seconds  = 11*60 - 1;
			$currentTime = \Carbon\Carbon::now()->subSeconds($seconds)->timezone('Europe/Berlin')->format("H:i");
		}else{
			 $currentTime = \Carbon\Carbon::now()->addMinutes(5)->timezone('Europe/Berlin')->format("H:i");
		}

        $bookedValue = [];
        $cat = '';
        $request_id = [];
        $status = 'true';
        for ($i = 0; $i < count($category); $i++) {
            if($cat == ''){
                $cat = $category[$i];    
                $newTime = $time[$i];
            } else if($cat != $category[$i]) {
                $newTime = $time[$i];
                $cat = '';
            }

            if($i != 0 && $cat != ''){
                $getduration = ServiceVariant::where('id',$variant[$i - 1])->value('duration_of_service');
               
                if($cat == $category[$i]){
				   $newTime = \Carbon\Carbon::parse( $newTime)->addMinutes($getduration)->format('H:i');
				}else{
				   $newTime = \Carbon\Carbon::parse($time[$i - 1])->addMinutes($getduration)->format('H:i');
				}
            }
            
            $getTimeDuration = ServiceVariant::where('id',$variant[$i])->value('duration_of_service');
            $endTime = \Carbon\Carbon::parse($newTime)->addMinutes($getTimeDuration)->format('H:i');
            $j = $i + 1; 
			$cat = $category[$i];
            if($j < count($category)){
                if($cat != $category[$j]){
                    $endTime = \Carbon\Carbon::parse($endTime)->addMinute(15)->format('H:i');
                } else {
                    $endTime = \Carbon\Carbon::parse($endTime)->format('H:i');
                }
            } elseif ($j == count($category)) {
                $endTime = \Carbon\Carbon::parse($endTime)->addMinute(15)->format('H:i');
            }
          

          	if (\Carbon\Carbon::parse($date[$i])->toDateString() == \Carbon\Carbon::now()->timezone('Europe/Berlin')->toDateString()) {
                if (\Carbon\Carbon::parse($newTime)->format("H:i") <= $currentTime) {
                  	 $status = 'false';
                	return $data = array('id'=>$request_id,'status'=>$status);
                }
            } 



            $times = BookingTemp::where('store_id', $store[$i])
                ->where('store_emp_id', $employee[$i])
                ->where('appo_date', $date[$i])
                // ->where('status','unpaid')
                ->orderBy('timestemps','asc')
                ->get();

                foreach ($times as $key) {
                  
                    if(!(\Carbon\Carbon::parse($newTime)->format('H:i') <= \Carbon\Carbon::parse($key['appo_time'])->format('H:i') && 
                    \Carbon\Carbon::parse($newTime)->format('H:i') >= \Carbon\Carbon::parse($key['app_end_time'])->format('H:i') &&
                    \Carbon\Carbon::parse($endTime)->format('H:i') >= \Carbon\Carbon::parse($key['app_end_time'])->format('H:i') || 
                    \Carbon\Carbon::parse($endTime)->format('H:i') >= \Carbon\Carbon::parse($key['app_end_time'])->format('H:i') && 
                    \Carbon\Carbon::parse($endTime)->format('H:i') <= \Carbon\Carbon::parse($key['appo_time'])->format('H:i')) && 
                    !(\Carbon\Carbon::parse($newTime)->format('H:i') >= \Carbon\Carbon::parse($key['app_end_time'])->format('H:i') && 
                    \Carbon\Carbon::parse($endTime)->format('H:i') >= \Carbon\Carbon::parse($key['app_end_time'])->format('H:i')) && 
                    !(\Carbon\Carbon::parse($endTime)->format('H:i') <= \Carbon\Carbon::parse($key['appo_time'])->format('H:i') &&
                    \Carbon\Carbon::parse($newTime)->format('H:i') <= \Carbon\Carbon::parse($key['appo_time'])->format('H:i'))) {
                          
                            $bookedValue[] = $variant[$i];
                    } 
                    # code...
                }
                // dump($times);


            if(count($bookedValue) == 0){
                $subData['store_id'] = $store[$i];
                $subData['category_id'] = $category[$i];
                $subData['subcategory_id'] = $subcategory[$i];
                $subData['service_id'] = $service[$i];
                $subData['service_name'] = $service_data[$i];
                $subData['variant_id'] = $variant[$i];
                $subData['price'] = $price[$i];
                $subData['store_emp_id'] = $employee[$i];
                $subData['appo_date'] = $date[$i];
                $subData['appo_time'] = \Carbon\Carbon::parse($newTime)->format('H:i');
                $subData['app_end_time'] = $endTime;
                $subData['created_at'] = \Carbon\Carbon::now()->format('Y-m-d H:i:s.u');
                $now = \Carbon\Carbon::now()->format('Y-m-d H:i:s.u');
                // $x = $now->timestamp . $now->milli;
               
                $subData['timestemps'] = $now;
    
                $saveData = new BookingTemp();
                $saveData->fill($subData);
                $saveData->save();

                $request_id[] = $saveData['id'];
            } else {
                $status = 'false';
                return $data = array('id'=>$request_id,'status'=>$status);
            }
        
        }
        return $data = array('id'=>$request_id,'status'=>$status);  

    }
	
	
	public static function sameBookingCheckingApi($data, $apptype = "user"){
        $category = $data['category'];        
        $subcategory = $data['subcategory'];
        $store = $data['store'];
        $date = $data['date'];
        $employee = $data['employee'];
        $time = $data['time'];
        $price = $data['price'];
        $variant = $data['variant'];
        $service = $data['service'];
        $service_data = $data['service_data'];

		if($apptype = "service"){
			$seconds  = 11*60 - 1;
			$currentTime = \Carbon\Carbon::now()->subSeconds($seconds)->timezone('Europe/Berlin')->format("H:i");
		}else{
			 $currentTime = \Carbon\Carbon::now()->addMinutes(5)->timezone('Europe/Berlin')->format("H:i");
		}

        $bookedValue = [];
        $cat = '';
        $request_id = [];
        $status = 'true';
        for ($i = 0; $i < count($category); $i++) {
            if($cat == ''){
                $cat = $category[$i];    
                $newTime = $time[$i];
            } else if($cat != $category[$i]) {
                $newTime = $time[$i];
                $cat = '';
            }

            if($i != 0 && $cat != ''){
                $getduration = ServiceVariant::where('id',$variant[$i - 1])->value('duration_of_service');
               
                if($cat == $category[$i]){
				   $newTime = \Carbon\Carbon::parse( $newTime)->addMinutes($getduration)->format('H:i');
				}else{
				   $newTime = \Carbon\Carbon::parse($time[$i - 1])->addMinutes($getduration)->format('H:i');
				}
            }
            
            $getTimeDuration = ServiceVariant::where('id',$variant[$i])->value('duration_of_service');
            $endTime = \Carbon\Carbon::parse($newTime)->addMinutes($getTimeDuration)->format('H:i');
            $j = $i + 1; 
			$cat = $category[$i];
            if($j < count($category)){
                if($cat != $category[$j]){
                    $endTime = \Carbon\Carbon::parse($endTime)->addMinute(15)->format('H:i');
                } else {
                    $endTime = \Carbon\Carbon::parse($endTime)->format('H:i');
                }
            } elseif ($j == count($category)) {
                $endTime = \Carbon\Carbon::parse($endTime)->addMinute(15)->format('H:i');
            }
          

          	if (\Carbon\Carbon::parse($date[$i])->toDateString() == \Carbon\Carbon::now()->timezone('Europe/Berlin')->toDateString()) {
                if (\Carbon\Carbon::parse($newTime)->format("H:i") <= $currentTime) {
                  	 $status = 'false';
                	return $data = array('id'=>$request_id,'status'=>$status);
                }
            } 


			DB::beginTransaction();
            $times = BookingTemp::where('store_id', $store[$i])
                ->where('store_emp_id', $employee[$i])
                ->where('appo_date', $date[$i])
                // ->where('status','unpaid')
                ->orderBy('timestemps','asc')->lockForUpdate()
                ->get();

                foreach ($times as $key) {
                  
                    if(!(\Carbon\Carbon::parse($newTime)->format('H:i') <= \Carbon\Carbon::parse($key['appo_time'])->format('H:i') && 
                    \Carbon\Carbon::parse($newTime)->format('H:i') >= \Carbon\Carbon::parse($key['app_end_time'])->format('H:i') &&
                    \Carbon\Carbon::parse($endTime)->format('H:i') >= \Carbon\Carbon::parse($key['app_end_time'])->format('H:i') || 
                    \Carbon\Carbon::parse($endTime)->format('H:i') >= \Carbon\Carbon::parse($key['app_end_time'])->format('H:i') && 
                    \Carbon\Carbon::parse($endTime)->format('H:i') <= \Carbon\Carbon::parse($key['appo_time'])->format('H:i')) && 
                    !(\Carbon\Carbon::parse($newTime)->format('H:i') >= \Carbon\Carbon::parse($key['app_end_time'])->format('H:i') && 
                    \Carbon\Carbon::parse($endTime)->format('H:i') >= \Carbon\Carbon::parse($key['app_end_time'])->format('H:i')) && 
                    !(\Carbon\Carbon::parse($endTime)->format('H:i') <= \Carbon\Carbon::parse($key['appo_time'])->format('H:i') &&
                    \Carbon\Carbon::parse($newTime)->format('H:i') <= \Carbon\Carbon::parse($key['appo_time'])->format('H:i'))) {
                          
                            $bookedValue[] = $variant[$i];
                    } 
                    # code...
                }
                // dump($times);


            if(count($bookedValue) == 0){
                $subData['store_id'] = $store[$i];
                $subData['category_id'] = $category[$i];
                $subData['subcategory_id'] = $subcategory[$i];
                $subData['service_id'] = $service[$i];
                $subData['service_name'] = $service_data[$i];
                $subData['variant_id'] = $variant[$i];
                $subData['price'] = $price[$i];
                $subData['store_emp_id'] = $employee[$i];
                $subData['appo_date'] = $date[$i];
                $subData['appo_time'] = \Carbon\Carbon::parse($newTime)->format('H:i');
                $subData['app_end_time'] = $endTime;
                $subData['created_at'] = \Carbon\Carbon::now()->format('Y-m-d H:i:s.u');
                $now = \Carbon\Carbon::now()->format('Y-m-d H:i:s.u');
                // $x = $now->timestamp . $now->milli;
               
                $subData['timestemps'] = $now;
    
                $saveData = new BookingTemp();
                $saveData->fill($subData);
                $saveData->save();

                $request_id[] = $saveData['id'];
            } else {
                $status = 'false';
                return $data = array('id'=>$request_id,'status'=>$status);
            }
			DB::commit();
        
        }
        return $data = array('id'=>$request_id,'status'=>$status);  

    }

    public static function notification($title,$description,$type,$appointment_id,$store_id,$user_id,$other, $visible_for = NULL){
        // Notification
        $data['title'] = $title;
        $data['description'] = $description;
        $data['type'] = $type;
        $data['appointment_id'] = $appointment_id;
        $data['store_id'] = $store_id;
        $data['user_id'] = $user_id;
        $data['other'] = $other;
		$data['visible_for'] = $visible_for;

        $notification = new Notification();
        $notification->fill($data);
        if($notification->save()){
            return true;
        }
    }

    public static function getAppointmentData($appointment_id) {
        $data = AppointmentData::where('appointment_id', $appointment_id)->get();
        
        return $data;
    }
	
	public static function getAppointmentDataByID($id) {
        $data = AppointmentData::where('id', $id)->get();
        return $data;
    }
	
	public static function sendEmailNotificationAppointment($id = null, $type) {
		$appointment  = AppointmentData::with(['employeeDetails','appointmentDetails','appointmentDetails.paymentData','categoryDetails','subCategoryDetails','variantData','userDetails','storeDetails'])->where('id', $id)->first();
		
		if(!empty($appointment->id)){
			$email = $appointment->appointmentDetails->email;
			$data  = array('data' => $appointment);
			try {
				if($type == 'reschedule'){
					Mail::send('email.appointment_postponed', $data, function ($message) use ($data, $email) {
						$message->from(env('MAIL_FROM_ADDRESS',"no-reply@reserved4you.de"), env('MAIL_FROM_NAME',"Reserved4you"))->subject(' Termin Verschieben !');
						$message->to($email);
					});
				}elseif($type == 'cancelled'){
					Mail::send('email.appointment_cancelled', $data, function ($message) use ($data, $email) {
						$message->from(env('MAIL_FROM_ADDRESS',"no-reply@reserved4you.de"), env('MAIL_FROM_NAME',"Reserved4you"))->subject(' Stornierung!');
						$message->to($email);
					});
				}
				

				return true;
			} catch (\Swift_TransportException $e) {
				\Log::debug($e);
				return false;
			}
		}
		return false;
	}
	
	
	public static function sendEmailNotificationAppointmentConfirmation($id = null) {
		$categories  = AppointmentData::where('appointment_id', $id)->pluck('category_id', 'category_id');
		$appointments  = array();
		foreach($categories as $category){
			$category_name  = Category::where('id', $category)->value('name');
			$appointments[$category_name] = AppointmentData::with(['employeeDetails','appointmentDetails','categoryDetails','subCategoryDetails','variantData','userDetails','storeDetails'])->where('appointment_id', $id)->where('category_id', $category)->get();
		}
		
		$appointment  = Appointment::with('orderInfo', 'storeDetails')->where('id', $id)->first();
		
		if(!empty($appointment->id)){
			$email = $appointment->email;
			$data  = array('data' => $appointments, 'appointment' => $appointment);
			try {
				Mail::send('email.appointment_confirmation', $data, function ($message) use ($data, $email) {
					$message->from(env('MAIL_FROM_ADDRESS',"no-reply@reserved4you.de"), env('MAIL_FROM_NAME',"Reserved4you"))->subject('Neue Buchung !');
					$message->to($email);
				});
				return true;
			} catch (\Swift_TransportException $e) {
				\Log::debug($e);
				return false;
			}
		}
		return false;
	}
	
	public static function sendPushNotification($registatoin_ids, $title = null, $detail = null, $image = null, $storeid = null, $appointment_id = null) {
		//$api_key  = "AAAAVE5r2FQ:APA91bHx9j0ShRBUtcmQksk1mXitT92oSA57dk0aQiQcHgAA-Jm-ynwSlSjlEKXOlH287sKZa9ijso37rkPh_zT3IDAG0gN_myCPQAJSHuUzKjgwrTYPnf0euaHMg--AYsep2V9lJN6x";
		$api_key  = "AAAAHALj24k:APA91bH1mptrGOWftLl1x8BPNrJYJ-J0-FspMJul8tHLfZ6fRrve9jzS42IKiPuYZAawejbZvgmWxvol5r5O_ccB3b-nQd4SjJ-dLkGOYQQVtrmY0Qzl7jJlNEsRB_X6gRYg5hx4aZrd";
		$url    = 'https://fcm.googleapis.com/fcm/send';
		$data = array
		(
			'title' 	=> $title,
			'body' 		=> $detail,
			'message' 	=> $detail,
			'storeid' 	=> $storeid,
			'appointment_id' 	=> $appointment_id,
			'sound' 	=> 'default',
			'image' 	=> $image,
			'icon' 		=> $image,
			'activity' 	=> 'MainActivity'
		); 
		
		$notification= array
		(
			'title' 		=> $title,
			'body' 			=> $detail,
			'click_action' 	=> '.MainActivity',
			'sound' 		=> 'default',
			'image' 		=> $image,
			'icon' 			=> $image,
			'badge' 		=> '1'
		); 
   
		$fields = array(
			'registration_ids' 	=> $registatoin_ids,
			'priority'          => "high",
            'data'         		=> $data,
			'notification'      => $data,
			'click_action' 		=> '.MainActivity',
            'sound' 			=> 'default', 
            'badge' 			=> '1'
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
		
		return $result;
	}

	public static function sendPushNotificationServiceProvider($registatoin_ids, $title = null, $detail = null, $image = null, $storeid = null, $appointment_id = null, $type = null) {
		$api_key  = "AAAAhci9fPE:APA91bEJSOxNzytw4GNlqREiTflYfNNuIfU7VLwNF58ctvx6rlzPvvFJAOdBirQJFrRbTetaru0d_MFns1aru3TMmdLhXCRQngm8oot63DPe5m5k00CciNPQkjfhSR0WW8jw7SzlAETr";
		$url    = 'https://fcm.googleapis.com/fcm/send';
		$data = array
		(
			'title' 	=> $title,
			'body' 		=> $detail,
			'message' 	=> $detail,
			'storeid' 	=> $storeid,
			'appointment_id' 	=> $appointment_id,
			'type' 	=> $type,
			'sound' 	=> 'default',
			'image' 	=> $image,
			'icon' 		=> $image,
			'activity' 	=> 'MainActivity'
		); 
		
		$notification= array
		(
			'title' 		=> $title,
			'body' 			=> $detail,
			'click_action' 	=> '.MainActivity',
			'sound' 		=> 'default',
			'image' 		=> $image,
			'icon' 			=> $image,
			'badge' 		=> '1'
		); 
   
		$fields = array(
			'registration_ids' 	=> $registatoin_ids,
			'priority'          => "high",
            'data'         		=> $data,
			'notification'      => $data,
			'click_action' 		=> '.MainActivity',
            'sound' 			=> 'default', 
            'badge' 			=> '1'
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
		
		return $result;
	}
	
	
	/**
     * Get all notifications
     * @param none
     * @return object
     */
	public static function getStatisticWebsite($type = null){
		
        $data  = 0;
		if($type == 'customer'){
			$data  = 50;
			$role  = Role::where('name', 'user')->value('id');
			$data  += User::join('role_user', 'role_user.user_id', '=', 'users.id')->where('users.status', 'active')->where('role_user.role_id', $role)->count();
		}elseif($type == 'provider'){
			$data  = 20;
			$data  += StoreProfile::count();
		}elseif($type == 'appointments'){
			$data  = 100;
			$data  += AppointmentData::count();
		}
		return $data;
	}
}
