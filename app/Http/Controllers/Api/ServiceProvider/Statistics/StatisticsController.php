<?php

namespace App\Http\Controllers\Api\ServiceProvider\Statistics;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Models\AppointmentData;
use App\Models\Service;
use App\Models\StoreProfile;
use App\Models\StoreEmp;
use Validator;
use URL;
use Mail;
use File;
use Exception;
use Carbon\Carbon;
use Auth;

class StatisticsController extends Controller
{
    public function index(Request $request)
    {
		try{
			$userId  = $request['user']['user_id'];
            if (empty($request['store_id'])){
				$getStore = StoreProfile::where('user_id', $userId)->pluck('id')->all();
			}else{
				 $getStore = StoreProfile::where('user_id',  $userId)->where('id', $request['store_id'])->pluck('id')->all();
			}

			/**Most Booked Service Start */
			$bookedService = AppointmentData::whereIn('store_id', $getStore)->get();

			$countService = [];
			foreach ($bookedService as $row) {
				$countService[$row->service_id][] = $row;
			}
			$mservice = [];

			foreach ($countService as $item => $row) {

				$getService = Service::where('id', $item)->first();
				if (!empty($getService)) {
					if (file_exists(storage_path('app/public/service/' . $getService['image'])) && $getService['image'] != '') {

						$image = URL::to('storage/app/public/service/' . $getService['image']);
					} else {
						$image = URL::to('storage/app/public/default/default-user.png');
					}

					$mservice[] = array(
						'service_name' => $getService['service_name'],
						'count' => count($row),
						'image' => $image,
						'category' => @$getService['CategoryData']['name']
					);

				}

			}

			$array_column = array_column($mservice, 'count');
			array_multisort($array_column, SORT_DESC, $mservice);
			$mservice = array_slice($mservice, 0, 4);
			/**Most Booked Service End */

			/** Earning By Employee Start */
			$bookedServices = AppointmentData::whereIn('store_id', $getStore)
				->where('status', 'completed')
				->get();

			$eardata = [];
			foreach ($bookedServices as $row) {
				if ($row->store_emp_id != '' && $row->store_emp_id != 0) {
					$eardata[$row->store_emp_id][] = $row;
				}
			}
			$employeeData = [];
			foreach ($eardata as $key => $row) {
				$empData = StoreEmp::find($key);
				if(!empty($empData->id)){
					if (file_exists(storage_path('app/public/store/employee/' . $empData->image)) && $empData->image != '') {

						$image = URL::to('storage/app/public/store/employee/' . $empData->image);
					} else {
						$empnameArr = explode(" ", $empData->emp_name);
						$empname = "";
						if(count($empnameArr) > 1){
							$empname = strtoupper(substr($empnameArr[0], 0, 1)).strtoupper(substr($empnameArr[1], 0, 1));
						}else{
							$empname = strtoupper(substr( $empData->emp_name, 0, 2));
						}
						$image = "https://via.placeholder.com/150x150/00000/FABA5F?text=".$empname;
					}
					$amount = array_sum(array_map(function ($item) {
							return $item['price'];
						}, $row));
					$employeeData[] = array(
						'id' => $key,
						'name' => $empData['emp_name'],
						'employee_id' => $empData['employee_id'],
						'image' => $image,
						'booking' => count($row),
						'amount' => number_format($amount, 2, ',', '.')
					);
				}
			}

			/** Earning By Employee End */

			$now = \Carbon\Carbon::now()->timezone('Europe/Berlin');
			$weekStartDate = $now->startOfWeek()->translatedFormat('Y-m-d');
			$weekEndDate = $now->endOfWeek()->translatedFormat('Y-m-d');

			/*
			 * Completed Booking Weekly data
			 */
			$getCompletedBooking = AppointmentData::whereDate('appo_date', '>=', $weekStartDate)
				->whereDate('appo_date', '<=', $weekEndDate)
				->whereIn('store_id', $getStore)
				->where('status', 'completed')
				->get();
			$datefilter = [];
			foreach ($getCompletedBooking as $row) {
				$datefilter[$row->appo_date][] = $row;
			}
			
			$weekDates = '';
			$period = \Carbon\CarbonPeriod::create($weekStartDate, $weekEndDate);
			
			$completedBooking = [];
			
			foreach ($period as $date) {
				$weekDates = $date->translatedFormat('Y-m-d');
				$available_dates = array_keys($datefilter);
				if(in_array($weekDates, $available_dates)){
					$count = !empty($datefilter[$weekDates])?count($datefilter[$weekDates]):0;
					 $completedBooking[] = array(
						'date' => \Carbon\Carbon::parse($weekDates)->translatedFormat('d M'),
						'count' => $count,
					);
				}else{
					 $completedBooking[] = array(
						'date' => \Carbon\Carbon::parse($weekDates)->translatedFormat('d M'),
						'count' => 0,
					);
				}
			} 

			/*
			* Completed Booking Monthly data
			*/
			$startDate = \Carbon\Carbon::now()->startOfMonth()->translatedFormat('Y-m-d');
			$endDate = \Carbon\Carbon::now()->endOfMonth()->translatedFormat('Y-m-d');
			$getCompletedBookingMonthly = AppointmentData::whereDate('appo_date', '>=', $startDate)
				->whereDate('appo_date', '<=', $endDate)
				->whereIn('store_id', $getStore)
				->where('status', 'completed')
				->get();

			$monthFilter = [];

			foreach ($getCompletedBookingMonthly as $row) {
				$row->month = \Carbon\Carbon::parse($row->appo_date)->translatedFormat('d');
				$monthFilter[$row->month][] = $row;
			}

			$completedBookingMonth = [];
			$day = array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10',
				'11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31'
			);
			foreach ($day as $date) {
				$j = 0;
				foreach ($monthFilter as $i => $row) {

					if ($i == (int)$date) {
						$completedBookingMonth[] = array(
							'date' => $date,
							'count' => count($row),
						);
						$j += 1;
					}
				}
				if ($j == 0) {
					$completedBookingMonth[] = array(
						'date' => $date,
						'count' => 0,
					);
				}

			}

			/*
		  * Completed Booking Yearly data
		  */

			$getCompletedBookingYearly = AppointmentData::whereDate('appo_date', '>=', \Carbon\Carbon::now()->startOfYear()->translatedFormat('Y-m-d'))
				->whereDate('appo_date', '<=', \Carbon\Carbon::now()->endOfYear()->translatedFormat('Y-m-d'))
				->whereIn('store_id', $getStore)
				->where('status', 'completed')
				->get();
				
				

			$yearFilter = [];
			foreach ($getCompletedBookingYearly as $row) {
				$row->month = \Carbon\Carbon::parse($row->appo_date)->translatedFormat('M');
				$yearFilter[$row->month][] = $row->toArray();
			}
			
			$completedBookingYear = [];
			/* $months = array(
				'Januar',
				'Februar',
				'März',
				'April',
				'Mai',
				'Juni',
				'Juli',
				'August',
				'September',
				'Oktober',
				'November',
				'Dezember',
			); */
			
			$months = array(
				'Jän',
				'Feb',
				'März',
				'Apr',
				'Mai',
				'Juni',
				'Juli',
				'Aug',
				'Sept',
				'Okt',
				'Nov',
				'Dez'
			);
			
			//echo "<pre>"; print_r($yearFilter); die;
			foreach ($months as $date) {
				$available_months = array_keys($yearFilter);
				if(in_array($date, $available_months)){
					$count = !empty($yearFilter[$date])?count($yearFilter[$date]):0;
					 $completedBookingYear[] = array(
						'date' => $date,
						'count' => $count,
					);
				}else{
					 $completedBookingYear[] = array(
						'date' => $date,
						'count' => 0,
					);
				}
			}

			/**
			 * Get Earning Day Data
			 */

			$getEarningDay = AppointmentData::whereDate('appo_date', \Carbon\Carbon::now()->timezone('Europe/Berlin')->translatedFormat('Y-m-d'))
				->whereIn('store_id', $getStore)
				->where('status', 'completed')
				->get();
			$dayEarning = [];
			foreach ($getEarningDay as $row) {
				$row->Hours = \Carbon\Carbon::parse($row->appo_time)->translatedFormat('H');
				$dayEarning[$row->Hours][] = $row;
			}
			$earningDay = [];

			$hours = array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10',
				'11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24');

			foreach ($hours as $date) {
				$j = 0;
				foreach ($dayEarning as $i => $row) {

					if ($i == (int)$date) {
						$earningDay[] = array(
							'date' => $date,
							'count' => array_sum(array_column($row, 'price')),
						);
						$j += 1;
					}
				}
				if ($j == 0) {
					$earningDay[] = array(
						'date' => $date,
						'count' => 0,
					);
				}

			}

			/**
			 * Get Earning Week Data
			 */

			$weekEarning = [];
			foreach ($getCompletedBooking as $row) {
				$weekEarning[$row->appo_date][] = $row;
			}

			$weekDates = '';
			$period = \Carbon\CarbonPeriod::create($weekStartDate, $weekEndDate);
			$earningWeek = [];
			foreach ($period as $date) {
				$weekDates = $date->translatedFormat('Y-m-d');
				$available_dates = array_keys($weekEarning);
				if(in_array($weekDates, $available_dates)){
					$row = !empty($weekEarning[$weekDates])?$weekEarning[$weekDates]:array();
					 $earningWeek[] = array(
						'date' => \Carbon\Carbon::parse($weekDates)->translatedFormat('d M'),
						'count' => array_sum(array_column($row, 'price')),
					);
				}else{
					 $earningWeek[] = array(
						'date' => \Carbon\Carbon::parse($weekDates)->translatedFormat('d M'),
						'count' => 0,
					);
				}
			}

			/**
			 * Get Earning Month Data
			 */
			$monthEarning = [];
			foreach ($getCompletedBookingMonthly as $row) {
				$row->month = \Carbon\Carbon::parse($row->appo_date)->translatedFormat('d');
				$monthEarning[$row->month][] = $row;
			}
			$earningMonth = [];
			foreach ($day as $date) {
				$j = 0;
				foreach ($monthEarning as $i => $row) {

					if ($i == (int)$date) {
						$earningMonth[] = array(
							'date' => $date,
							'count' => array_sum(array_column($row, 'price')),
						);
						$j += 1;
					}
				}
				if ($j == 0) {
					$earningMonth[] = array(
						'date' => $date,
						'count' => 0,
					);
				}

			}

			/**
			 * Get Earning Year Data
			 */
			$yearEarning = [];
			foreach ($getCompletedBookingYearly as $row) {
				$row->month = \Carbon\Carbon::parse($row->appo_date)->translatedFormat('M');
				$yearEarning[$row->month][] = $row;
			}
			$earningYear = [];
			foreach ($months as $date) {
				$available_months = array_keys($yearEarning);
				if(in_array($date, $available_months)){
					$count = !empty($yearEarning[$date])?array_sum(array_column($yearEarning[$date], 'price')):0;
					 $earningYear[] = array(
						'date' => $date,
						'count' => $count,
					);
				}else{
					 $earningYear[] = array(
						'date' => $date,
						'count' => 0,
					);
				}
			}

			/**
			 * get Customer Day
			 */
			$getCustomerDay = Appointment::leftjoin('appointment_data', 'appointment_data.appointment_id', '=', 'appointments.id')
				->select('appointments.*', 'appointment_data.appo_date', 'appointment_data.appo_time')
				->whereDate('appointment_data.appo_date', \Carbon\Carbon::now()->timezone('Europe/Berlin')->translatedFormat('Y-m-d'))
				->whereIn('appointments.store_id', $getStore)
				->groupBy('appointments.email')
				->get();
			$dayCustomer = [];

			foreach ($getCustomerDay as $row) {
				$row->Hours = \Carbon\Carbon::parse($row->appo_time)->translatedFormat('H');
				$dayCustomer[$row->Hours][] = $row;
			}
			$customerDay = [];
			foreach ($hours as $date) {
				$j = 0;
				foreach ($dayCustomer as $i => $row) {

					if ($i == (int)$date) {
						$customerDay[] = array(
							'date' => $date,
							'count' => count($row),
						);
						$j += 1;
					}
				}
				if ($j == 0) {
					$customerDay[] = array(
						'date' => $date,
						'count' => 0,
					);
				}

			}

			$getCustomerWeek = Appointment::leftjoin('appointment_data', 'appointment_data.appointment_id', '=', 'appointments.id')
				->select('appointments.*', 'appointment_data.appo_date', 'appointment_data.appo_time')
				->whereDate('appointment_data.appo_date', '>=', $weekStartDate)
				->whereDate('appointment_data.appo_date', '<=', $weekEndDate)
				->whereIn('appointments.store_id', $getStore)
				->groupBy('appointments.email')
				->get();

			$weekCustomer = [];
			foreach ($getCustomerWeek as $row) {
				$weekCustomer[$row->appo_date][] = $row;
			}
			$customerWeek = [];
			foreach ($period as $date) {
				$weekDates = $date->translatedFormat('Y-m-d');
				$available_dates = array_keys($weekCustomer);
				if(in_array($weekDates, $available_dates)){
					$count = !empty($weekCustomer[$weekDates])?count($weekCustomer[$weekDates]):0;
					 $customerWeek[] = array(
						'date' => \Carbon\Carbon::parse($weekDates)->translatedFormat('d M'),
						'count' => $count,
					);
				}else{
					 $customerWeek[] = array(
						'date' => \Carbon\Carbon::parse($weekDates)->translatedFormat('d M'),
						'count' => 0,
					);
				}
			}

			$getCustomerMonth = Appointment::leftjoin('appointment_data', 'appointment_data.appointment_id', '=', 'appointments.id')
				->select('appointments.*', 'appointment_data.appo_date', 'appointment_data.appo_time')
				->whereDate('appo_date', '>=', $startDate)
				->whereDate('appo_date', '<=', $endDate)
				->whereIn('appointments.store_id', $getStore)
				->groupBy('appointments.email')
				->get();

			$monthCustomer = [];
			foreach ($getCustomerMonth as $row) {
				$row->month = \Carbon\Carbon::parse($row->appo_date)->translatedFormat('d');
				$monthCustomer[$row->month][] = $row;
			}

			$customerMonth = [];
			foreach ($day as $date) {
				$j = 0;
				foreach ($monthCustomer as $i => $row) {

					if ($i == (int)$date) {
						$customerMonth[] = array(
							'date' => $date,
							'count' => count($row),
						);
						$j += 1;
					}
				}
				if ($j == 0) {
					$customerMonth[] = array(
						'date' => $date,
						'count' => 0,
					);
				}

			}

			$getCustomerYear = Appointment::leftjoin('appointment_data', 'appointment_data.appointment_id', '=', 'appointments.id')
				->select('appointments.*', 'appointment_data.appo_date', 'appointment_data.appo_time')
				->whereDate('appo_date', '>=', \Carbon\Carbon::now()->startOfYear()->translatedFormat('Y-m-d'))
				->whereDate('appo_date', '<=', \Carbon\Carbon::now()->endOfYear()->translatedFormat('Y-m-d'))
				->whereIn('appointments.store_id', $getStore)
				->groupBy('appointments.email')
				->get();

			$yearCustomer = [];
			foreach ($getCustomerYear as $row) {
				$row->month = \Carbon\Carbon::parse($row->appo_date)->translatedFormat('M');
				$yearCustomer[$row->month][] = $row;
			}

			$customerYear = [];

			foreach ($months as $date) {
				$available_months = array_keys($yearCustomer);
				if(in_array($date, $available_months)){
					$count = !empty($yearCustomer[$date])?count($yearCustomer[$date]):0;
					 $customerYear[] = array(
						'date' => $date,
						'count' => $count,
					);
				}else{
					 $customerYear[] = array(
						'date' => $date,
						'count' => 0,
					);
				}
			}

			$now = \Carbon\Carbon::now()->timezone('Europe/Berlin');
			$weekData = array(
				['id' => 0, 'value' => $now->startOfWeek()->translatedFormat('d ') . '-' . $now->endOfWeek()->translatedFormat(' d M, Y')],
				['id' => 1, 'value' => $now->startOfWeek()->subWeek(1)->translatedFormat('d ') . '-' . $now->endOfWeek()->translatedFormat(' d M, Y')],
				['id' => 2, 'value' => $now->startOfWeek()->subWeek(1)->translatedFormat('d ') . '-' . $now->endOfWeek()->subWeek(0)->translatedFormat(' d M, Y')],
				['id' => 3, 'value' => $now->startOfWeek()->subWeek(1)->translatedFormat('d ') . '-' . $now->endOfWeek()->subWeek(0)->translatedFormat(' d M, Y')],
				['id' => 4, 'value' => $now->startOfWeek()->subWeek(1)->translatedFormat('d ') . '-' . $now->endOfWeek()->subWeek(0)->translatedFormat(' d M, Y')],
			);
			$now = \Carbon\Carbon::now()->timezone('Europe/Berlin');
			$monthData = array(
				['id' => 0, 'value' => $now->translatedFormat('M')],
				['id' => 1, 'value' => $now->subMonth(1)->translatedFormat('M')],
				['id' => 2, 'value' => $now->subMonth(1)->translatedFormat('M')],
				['id' => 3, 'value' => $now->subMonth(1)->translatedFormat('M')],
				['id' => 4, 'value' => $now->subMonth(1)->translatedFormat('M')],
			);

			$now = \Carbon\Carbon::now()->timezone('Europe/Berlin');
			$yearData = array(
				['id' => 0, 'value' => $now->translatedFormat('Y')],
				['id' => 1, 'value' => $now->subYear(1)->translatedFormat('Y')],
				['id' => 2, 'value' => $now->subYear(1)->translatedFormat('Y')],
				['id' => 3, 'value' => $now->subYear(1)->translatedFormat('Y')],
				['id' => 4, 'value' => $now->subYear(1)->translatedFormat('Y')],
			);

			$now = \Carbon\Carbon::now()->timezone('Europe/Berlin');
			$dayData = array(
				['id' => 0, 'value' => $now->translatedFormat('d,M')],
				['id' => 1, 'value' => $now->subDay(1)->translatedFormat('d,M')],
				['id' => 2, 'value' => $now->subDay(1)->translatedFormat('d,M')],
				['id' => 3, 'value' => $now->subDay(1)->translatedFormat('d,M')],
				['id' => 4, 'value' => $now->subDay(1)->translatedFormat('d,M')],
			);

			$responseData = [
								'employeeData' 			=> $employeeData, 
								'mservice' 				=> $mservice, 
								'completedBooking' 		=> $completedBooking, 
								//'completedBookingMonth' => $completedBookingMonth, 
								//'completedBookingYear' 	=> $completedBookingYear,
								'earningDay' 			=> $earningDay, 
								//'earningWeek' 			=> $earningWeek, 
								//'earningMonth' 			=> $earningMonth, 
								//'earningYear' 			=> $earningYear, 
								//'customerDay' 			=> $customerDay, 
								//'customerWeek' 			=> $customerWeek, 
								'customerMonth' 		=> $customerMonth, 
								'customerYear' 			=> $customerYear, 
								'dayData' 				=> $dayData, 
								'yearData' 				=> $yearData, 
								'monthData' 			=> $monthData, 
								'weekData' 				=> $weekData
							];
			return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Successful', 'ResponseData' => $responseData], 200);
        }catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
    }

    public function getDayData(Request $request)
    {
		try{
			$userId  = $request['user']['user_id'];
			$store_id = !empty($request['store_id'])?$request['store_id']:NULL;
            if (empty($request['store_id'])){
				$getStore = StoreProfile::where('user_id', $userId)->pluck('id')->all();
			}else{
				 $getStore = StoreProfile::where('user_id',  $userId)->where('id', $request['store_id'])->pluck('id')->all();
			}
			$id = $request['id'];
			$value = $request['value'];

			$now = \Carbon\Carbon::now()->timezone('Europe/Berlin');
			$now->subDay($id)->translatedFormat('Y-m-d');

			$hours = array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10',
				'11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24');

			
			$customerDay = [];

			if ($value == 'customer') {
				$getCustomerDay = Appointment::leftjoin('appointment_data', 'appointment_data.appointment_id', '=', 'appointments.id')
					->select('appointments.*', 'appointment_data.appo_date', 'appointment_data.appo_time')
					->whereDate('appointment_data.appo_date', $now)
					->whereIn('appointments.store_id', $getStore)
					->groupBy('appointments.email')
					->get();
				$dayCustomer = [];

				foreach ($getCustomerDay as $row) {
					$row->Hours = \Carbon\Carbon::parse($row->appo_time)->translatedFormat('H');
					$dayCustomer[$row->Hours][] = $row;
				}

				foreach ($hours as $date) {
					$j = 0;
					foreach ($dayCustomer as $i => $row) {

						if ($i == (int)$date) {
							$customerDay[] = array(
								'date' => $date,
								'count' => count($row),
							);
							$j += 1;
						}
					}
					if ($j == 0) {
						$customerDay[] = array(
							'date' => $date,
							'count' => 0,
						);
					}

				}
			}

			if ($value == 'earning') {
				$getEarningDay = AppointmentData::whereDate('appo_date', $now)
					->whereIn('store_id', $getStore)
					->where('status', 'completed')
					->get();

				$dayEarning = [];
				foreach ($getEarningDay as $row) {
					$row->Hours = \Carbon\Carbon::parse($row->appo_time)->translatedFormat('H');
					$dayEarning[$row->Hours][] = $row;
				}

				foreach ($hours as $date) {
					$j = 0;
					foreach ($dayEarning as $i => $row) {

						if ($i == (int)$date) {
							$customerDay[] = array(
								'date' => $date,
								'count' => array_sum(array_column($row, 'price')),
							);
							$j += 1;
						}
					}
					if ($j == 0) {
						$customerDay[] = array(
							'date' => $date,
							'count' => 0,
						);
					}

				}
			}
			$max_number = max(array_column($customerDay, 'count'));
			$dataResponse = ['data' => $customerDay, 'maxCount' => $max_number];
			return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Successful', 'ResponseData' => $dataResponse], 200);
			//return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Successful', 'ResponseData' => $customerDay], 200);
        }catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
    }

    public function getWeekData(Request $request)
    {
		try{
			$userId  = $request['user']['user_id'];
			$store_id = !empty($request['store_id'])?$request['store_id']:NULL;
            if (empty($request['store_id'])){
				$getStore = StoreProfile::where('user_id', $userId)->pluck('id')->all();
			}else{
				 $getStore = StoreProfile::where('user_id',  $userId)->where('id', $request['store_id'])->pluck('id')->all();
			}
			$id = $request['id'];
			$value = $request['value'];

			
			$now = \Carbon\Carbon::now()->timezone('Europe/Berlin');

			$weekStartDate = $now->startOfWeek()->subWeek($id)->translatedFormat('Y-m-d');
			$weekEndDate = $now->endOfWeek()->subWeek(0)->translatedFormat('Y-m-d');

			$customerWeek = [];

			$period = \Carbon\CarbonPeriod::create($weekStartDate, $weekEndDate);

			if ($value == 'customer') {
				$getCustomerWeek = Appointment::leftjoin('appointment_data', 'appointment_data.appointment_id', '=', 'appointments.id')
					->select('appointments.*', 'appointment_data.appo_date', 'appointment_data.appo_time')
					->whereDate('appointment_data.appo_date', '>=', $weekStartDate)
					->whereDate('appointment_data.appo_date', '<=', $weekEndDate)
					->whereIn('appointments.store_id', $getStore)
					->groupBy('appointments.email')
					->get();

				$weekCustomer = [];
				foreach ($getCustomerWeek as $row) {
					$weekCustomer[$row->appo_date][] = $row;
				}
				$customerWeek = [];
				foreach ($period as $date) {
					$weekDates = $date->translatedFormat('Y-m-d');
					$available_dates = array_keys($weekCustomer);
					if(in_array($weekDates, $available_dates)){
						$count = !empty($weekCustomer[$weekDates])?count($weekCustomer[$weekDates]):0;
						 $customerWeek[] = array(
							'date' => \Carbon\Carbon::parse($weekDates)->translatedFormat('d M'),
							'count' => $count,
						);
					}else{
						 $customerWeek[] = array(
							'date' => \Carbon\Carbon::parse($weekDates)->translatedFormat('d M'),
							'count' => 0,
						);
					}
				}
			}

			$getCompletedBooking = AppointmentData::whereDate('appo_date', '>=', $weekStartDate)
				->whereDate('appo_date', '<=', $weekEndDate)
				->whereIn('store_id', $getStore)
				->where('status', 'completed')
				->get();

			if ($value == 'complete') {

				$datefilter = [];
				foreach ($getCompletedBooking as $row) {
					$datefilter[$row->appo_date][] = $row;
				}

				foreach ($period as $date) {
					$weekDates = $date->translatedFormat('Y-m-d');
					$available_dates = array_keys($datefilter);
					if(in_array($weekDates, $available_dates)){
						$count = !empty($datefilter[$weekDates])?count($datefilter[$weekDates]):0;
						 $customerWeek[] = array(
							'date' => \Carbon\Carbon::parse($weekDates)->translatedFormat('d M'),
							'count' => $count,
						);
					}else{
						 $customerWeek[] = array(
							'date' => \Carbon\Carbon::parse($weekDates)->translatedFormat('d M'),
							'count' => 0,
						);
					}
				}

			}

			if ($value == 'earning') {
				$weekEarning = [];
				foreach ($getCompletedBooking as $row) {
					$weekEarning[$row->appo_date][] = $row;
				}

				foreach ($period as $date) {
					$weekDates = $date->translatedFormat('Y-m-d');
					$available_dates = array_keys($weekEarning);
					if(in_array($weekDates, $available_dates)){
						$row = !empty($weekEarning[$weekDates])?$weekEarning[$weekDates]:array();
						$customerWeek[] = array(
							'date' => \Carbon\Carbon::parse($weekDates)->translatedFormat('d M'),
							'count' => array_sum(array_column($row, 'price')),
						);
					}else{
						 $customerWeek[] = array(
							'date' => \Carbon\Carbon::parse($weekDates)->translatedFormat('d M'),
							'count' => 0,
						);
					}
				}
			}
			$max_number = max(array_column($customerWeek, 'count'));
			$dataResponse = ['data' => $customerWeek, 'maxCount' => $max_number];
			return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Successful', 'ResponseData' => $dataResponse], 200);
			//return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Successful', 'ResponseData' => $customerWeek], 200);
        }catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
    }

    public function getMonthData(Request $request)
    {
		try{
			$userId  = $request['user']['user_id'];
			$store_id = !empty($request['store_id'])?$request['store_id']:NULL;
            if (empty($request['store_id'])){
				$getStore = StoreProfile::where('user_id', $userId)->pluck('id')->all();
			}else{
				 $getStore = StoreProfile::where('user_id',  $userId)->where('id', $request['store_id'])->pluck('id')->all();
			}
			$id = $request['id'];
			$value = $request['value'];

			

			$now = \Carbon\Carbon::now()->timezone('Europe/Berlin');

			$startDate = $now->subMonth((int)$id)->startOfMonth()->translatedFormat('Y-m-d');
			$endDate =  \Carbon\Carbon::parse($startDate)->endOfMonth()->translatedFormat('Y-m-d');
			
			$day = array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10',
				'11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31'
			);
			$customerMonth = [];

			if ($value == 'customer') {
				$getCustomerMonth = Appointment::leftjoin('appointment_data', 'appointment_data.appointment_id', '=', 'appointments.id')
					->select('appointments.*', 'appointment_data.appo_date', 'appointment_data.appo_time')
					->whereDate('appo_date', '>=', $startDate)
					->whereDate('appo_date', '<=', $endDate)
					->whereIn('appointments.store_id', $getStore)
					->groupBy('appointments.email')
					->get();

				$monthCustomer = [];
				foreach ($getCustomerMonth as $row) {
					$row->month = \Carbon\Carbon::parse($row->appo_date)->translatedFormat('d');
					$monthCustomer[$row->month][] = $row;
				}

				foreach ($day as $date) {
					$j = 0;
					foreach ($monthCustomer as $i => $row) {

						if ($i == (int)$date) {
							$customerMonth[] = array(
								'date' => $date,
								'count' => count($row),
							);
							$j += 1;
						}
					}
					if ($j == 0) {
						$customerMonth[] = array(
							'date' => $date,
							'count' => 0,
						);
					}

				}
			}

			$getCompletedBookingMonthly = AppointmentData::whereDate('appo_date', '>=', $startDate)
				->whereDate('appo_date', '<=', $endDate)
				->whereIn('store_id', $getStore)
				->where('status', 'completed')
				->get();

			if ($value == 'complete') {
				$monthFilter = [];
				foreach ($getCompletedBookingMonthly as $row) {
					$row->month = \Carbon\Carbon::parse($row->appo_date)->translatedFormat('d');
					$monthFilter[$row->month][] = $row;
				}

				foreach ($day as $date) {
					$j = 0;
					foreach ($monthFilter as $i => $row) {

						if ($i == (int)$date) {
							$customerMonth[] = array(
								'date' => $date,
								'count' => count($row),
							);
							$j += 1;
						}
					}
					if ($j == 0) {
						$customerMonth[] = array(
							'date' => $date,
							'count' => 0,
						);
					}

				}
			}

			if ($value == 'earning') {
				$monthEarning = [];
				foreach ($getCompletedBookingMonthly as $row) {
					$row->month = \Carbon\Carbon::parse($row->appo_date)->translatedFormat('d');
					$monthEarning[$row->month][] = $row;
				}
				$earningMonth = [];
				foreach ($day as $date) {
					$j = 0;
					foreach ($monthEarning as $i => $row) {

						if ($i == (int)$date) {
							$customerMonth[] = array(
								'date' => $date,
								'count' => array_sum(array_column($row, 'price')),
							);
							$j += 1;
						}
					}
					if ($j == 0) {
						$customerMonth[] = array(
							'date' => $date,
							'count' => 0,
						);
					}

				}
			}
			$max_number = max(array_column($customerMonth, 'count'));
			$dataResponse = ['data' => $customerMonth, 'maxCount' => $max_number];
			return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Successful', 'ResponseData' => $dataResponse], 200);
			//return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Successful', 'ResponseData' => $customerMonth], 200);
        }catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
    }

    public function getYearData(Request $request)
    {
		try{
			$userId  = $request['user']['user_id'];
			$store_id = !empty($request['store_id'])?$request['store_id']:NULL;
            if (empty($request['store_id'])){
				$getStore = StoreProfile::where('user_id', $userId)->pluck('id')->all();
			}else{
				 $getStore = StoreProfile::where('user_id',  $userId)->where('id', $request['store_id'])->pluck('id')->all();
			}
			$id = $request['id'];
			$value = $request['value'];

			$now = \Carbon\Carbon::now()->timezone('Europe/Berlin');
			$now = $now->subYear($id)->translatedFormat('Y');

			$startDate = date('Y-m-d', strtotime('01/01/' . $now));
			$endDate = date('Y-m-d', strtotime('12/31/' . $now));

			$months = array(
				'Jän',
				'Feb',
				'März',
				'Apr',
				'Mai',
				'Juni',
				'Juli',
				'Aug',
				'Sept',
				'Okt',
				'Nov',
				'Dez'
			);


			$customerYear = [];

			if ($value == 'customer') {
				$getCustomerYear = Appointment::leftjoin('appointment_data', 'appointment_data.appointment_id', '=', 'appointments.id')
					->select('appointments.*', 'appointment_data.appo_date', 'appointment_data.appo_time')
					->whereDate('appo_date', '>=', $startDate)
					->whereDate('appo_date', '<=', $endDate)
					->whereIn('appointments.store_id', $getStore)
					->groupBy('appointments.email')
					->get();

				$yearCustomer = [];
				foreach ($getCustomerYear as $row) {
					$row->month = \Carbon\Carbon::parse($row->appo_date)->translatedFormat('M');
					$yearCustomer[$row->month][] = $row;
				}


				foreach ($months as $date) {
					$j = 0;
					foreach ($yearCustomer as $i => $row) {
						if ($i == $date) {
							$customerYear[] = array(
								'date' => $date,
								'count' => count($row),
							);
							$j += 1;
						}
					}
					if ($j == 0) {
						$customerYear[] = array(
							'date' => $date,
							'count' => 0,
						);
					}
				}
			}

			$getCompletedBookingYearly = AppointmentData::whereDate('appo_date', '>=', $startDate)
				->whereDate('appo_date', '<=', $endDate)
				->whereIn('store_id', $getStore)
				->where('status', 'completed')
				->get();

			if ($value == 'complete') {
				$yearFilter = [];
				foreach ($getCompletedBookingYearly as $row) {
					$row->month = \Carbon\Carbon::parse($row->appo_date)->translatedFormat('M');
					$yearFilter[$row->month][] = $row;
				}

				foreach ($months as $date) {
					$j = 0;
					foreach ($yearFilter as $i => $row) {
						if ($i == $date) {
							$customerYear[] = array(
								'date' => $date,
								'count' => count($row),
							);
							$j += 1;
						}
					}
					if ($j == 0) {
						$customerYear[] = array(
							'date' => $date,
							'count' => 0,
						);
					}
				}
			}

			if ($value == 'earning') {
				$yearEarning = [];
				foreach ($getCompletedBookingYearly as $row) {
					$row->month = \Carbon\Carbon::parse($row->appo_date)->translatedFormat('M');
					$yearEarning[$row->month][] = $row;
				}

				foreach ($months as $date) {
					$j = 0; 
					foreach ($yearEarning as $i => $row) {
						if ($i == $date) {
							$customerYear[] = array(
								'date' => $date,
								'count' => array_sum(array_column($row, 'price')),
							);
							$j += 1;
						}
					}
					if ($j == 0) {
						$customerYear[] = array(
							'date' => $date,
							'count' => 0,
						);
					}
				}
			}
			$max_number = max(array_column($customerYear, 'count'));
			$dataResponse = ['data' => $customerYear, 'maxCount' => $max_number];
			return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Successful', 'ResponseData' => $dataResponse], 200);
        }catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
    }
}
