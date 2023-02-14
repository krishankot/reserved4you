<?php

namespace App\Http\Controllers\ServiceProvider;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\AppointmentData;
use App\Models\Category;
use App\Models\Customer;
use App\Models\PaymentMethodInfo;
use App\Models\Service;
use App\Models\ServiceAppoinment;
use App\Models\ServiceVariant;
use App\Models\StoreCategory;
use App\Models\StoreEmp;
use App\Models\StoreEmpTimeslot;
use App\Models\StoreProfile;
use App\Models\StoreRatingReview;
use App\Models\TempServiceStore;
use App\Models\User;
use App\Models\BookingTemp;
use App\Models\Notification;
use App\Models\ApiSession;
use Illuminate\Http\Request;
use Auth;
use Session;
use URL;
use DB;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		DB::beginTransaction();
        $store_id = session('store_id');
		
        if (empty($store_id)) {
            $getStore = StoreProfile::where('user_id', Auth::user()->id)->pluck('id')->all();
        } else {
            $getStore = StoreProfile::where('user_id', Auth::user()->id)->where('id', $store_id)->pluck('id')->all();
        }

        $date = \Carbon\Carbon::now()->format('Y-m-d');
		
        $appointment = AppointmentData::leftjoin('appointments', 'appointments.id', '=', 'appointment_data.appointment_id')
            ->leftjoin('payment_method_infos', 'payment_method_infos.appoinment_id', '=', 'appointments.id')
            ->whereIn('appointment_data.store_id', $getStore)
			->orderBy('appointment_data.appo_date', 'DESC')
            ->select('appointment_data.*', 'payment_method_infos.status as payment_status', 'payment_method_infos.card_type as card_type','payment_method_infos.payment_method as payment_method',
                'appointments.user_id', 'appointments.order_id', 'appointments.first_name', 'appointments.last_name', 'appointments.email')
            
            ->paginate(10);
			
			$total_pages =  $appointment->lastPage();

        foreach ($appointment as $row) {
            if ($row->status == 'completed') {
                $checkReview = StoreRatingReview::where('appointment_id', $row->id)->first();
                if (!empty($checkReview)) {
                    $row->is_reviewed = $checkReview;
                } else {
					$row->is_reviewed = '';
                }
				
            } else {
                $row->is_reviewed = '';
            }
			$rrcount = Notification::where('appointment_id', $row->id)->where('type', 'review_request')->count();
			if($rrcount > 0){
				$row->review_requested = 1;
			}else{
				$row->review_requested = 0;
			}
                    
            $row->image = Service::where('id', $row->service_id)->value('image');

        }

		DB::commit();
        $service = Service::whereIn('store_id', $getStore)->where('status', 'active')->get();
		if($request->ajax()){
			 return (view('ServiceProvider.Appointment.appointmentDetails', compact('appointment'))->render());
		}

        return view('ServiceProvider.Appointment.index', compact('service', 'appointment', 'total_pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
		
        $store_id = session('store_id');

        if (empty($store_id)) {
            $getStore = StoreProfile::where('user_id', Auth::user()->id)->value('id');
        } else {
            $getStore = StoreProfile::where('user_id', Auth::user()->id)->where('id', $store_id)->value('id');
        }

        $storeCategory = StoreCategory::where('store_id', $getStore)->get();
        $categoryData = [];
        $cate_subcategoryData = [];
		
        foreach ($storeCategory as $row) {
            $row->categoryData = Category::where('id', $row->category_id)->first();
            $catlist[] = @$row->CategoryData->name;
            $subcategory = Category::where('main_category', $row->category_id)
                ->join('services', 'services.subcategory_id', '=', 'categories.id')
                ->where('services.store_id', $getStore)
                ->select('categories.*')
                ->groupBy('categories.id')
                ->get();
            if (count($subcategory) > 0) {
                $categoryData[] = array(
                    'categorys' => $row->categoryData,
                    'subcategory' => $subcategory
                );

                $row->categoryData->sub_cate = $subcategory;

                $cate_subcategoryData[] = $row->categoryData;
            }
        }
        $service = Service::where('store_id', $getStore)->where('category_id', @$categoryData[0]['categorys']['id'])
            ->where('subcategory_id', @$categoryData[0]['subcategory'][0]['id'])->where('status', 'active')->get();

        foreach ($service as $row) {
            $row->rating = \BaseFunction::finalRatingService($getStore, $row->id);
            $row->variants = ServiceVariant::where('store_id', $getStore)->where('service_id', $row->id)->get()->toArray();
        }



        return view('ServiceProvider.Appointment.Create.index', compact('categoryData', 'service', 'cate_subcategoryData', 'getStore'));
	
    }


    public function createAppointment(Request $request)
    {

        $data = $request->all();
        $serviceDetails = Service::where('id', $data['choose_service'])->first();
        $amount = \BaseFunction::finalPrice($serviceDetails['id']);

        $appointmentData['store_id'] = $serviceDetails['store_id'];
        $appointmentData['store_emp_id'] = $data['choose_expert'];
        $appointmentData['service_id'] = $serviceDetails['id'];
        $appointmentData['service_name'] = $serviceDetails['service_name'];
        $appointmentData['appo_date'] = \Carbon\Carbon::parse($data['date']);
        $appointmentData['appo_time'] = \Carbon\Carbon::parse($data['service_time'])->format('H:i');
        $appointmentData['status'] = 'booked';
        $appointmentData['order_id'] = \BaseFunction::orderNumber();
        $appointmentData['price'] = $amount;
        $appointmentData['appointment_type'] = 'service provider';
        $appointmentData['first_name'] = $data['first_name'];
        $appointmentData['last_name'] = $data['last_name'];
        $appointmentData['email'] = $data['email'];
        $appointmentData['phone_number'] = $data['phone_number'];

        $appointment = new ServiceAppoinment();
        $appointment->fill($appointmentData);
        if ($appointment->save()) {
             return redirect('dienstleister/buchung');
        }
    }

    public function getAppointmentData(Request $request)
    {
        $data = $request->all();

        $appointment = ServiceAppoinment::where('id', $data['appointment_data'])->first();
        $appointment['emp_name'] = $appointment['employeeDetails']['emp_name'];
        if (!empty($appointment['user_id'])) {
            $appointment['user_name'] = @$appointment['userDetails']['first_name'] . ' ' . @$appointment['userDetails']['last_name'];
        } else {
            $appointment['user_name'] = @$appointment['first_name'] . ' ' . @$appointment['last_name'];
        }
        $appointment['service_image'] = URL::to('storage/app/public/service/' . $appointment['serviceDetails']['image']);

        if (!empty($appointment)) {
            return ['status' => 'true', 'data' => $appointment];
        } else {
            return ['status' => 'false', 'data' => []];
        }
    }

    /* public function postpondAppointment(Request $request)
    {
        $id = $request['appointment_id'];
        $date = $request['date'];
        $time = $request['time'];

        $appointmentData['appo_date'] = \Carbon\Carbon::parse($date);
        $appointmentData['appo_time'] = \Carbon\Carbon::parse($time)->format('H:i');
        $appointmentData['status'] = 'reschedule';

        $appointment = ServiceAppoinment::where('id', $id)->update($appointmentData);
        if ($appointment) {
            return ['status' => 'true', 'data' => null];
        } else {
            return ['status' => 'false', 'data' => null];
        }
    } */
	
	public function postpondAppointment(Request $request)
    {
        $id = $request['id'];

		
       /*  $appointmentData['appo_date'] = NULL;
        $appointmentData['appo_time'] = NULL;
		$appointmentData['app_end_time'] = NULL; */
        $appointmentData['status'] = 'reschedule';
		$appointmentData['is_postponed'] = 'Yes';

        $appointment = AppointmentData::where('id', $id)->update($appointmentData);
        if ($appointment) {
			$apData  = AppointmentData::find($id);
			$AppointmentAr = Appointment::where('id', $apData->appointment_id)->first();
			$pdate  = \Carbon\Carbon::parse($apData['appo_date'])->format('d.m.Y');
			$ptime  = \Carbon\Carbon::parse($apData['appo_time'])->format('H:i');
			$store_name = StoreProfile::where('id', $AppointmentAr['store_id'])->value('store_name');
			$Pdeatail = "Leider ist bei ". $store_name ." etwas dazwischen gekommen, weshalb dein Termin am ".$pdate." um ". $ptime." verschoben oder storniert werden muss.";
			 \BaseFunction::notification('Termin verschieben ?',$Pdeatail,'appointment',$id,$AppointmentAr['store_id'],$AppointmentAr['user_id'],$AppointmentAr['user_id'] == ''? 'guest' : '','users');
			
			//send postponed email to user
			 \BaseFunction::sendEmailNotificationAppointment($id, "reschedule");
			 
			 //Push Notification for postponed
				$PUSer = User::find($AppointmentAr['user_id']);
				if(!empty($PUSer->device_token) && !empty($PUSer->allow_notifications) && $PUSer->allow_notifications == 1){
					$sessioncount = ApiSession::where('user_id', $PUSer->id)->count();
					if($sessioncount > 0){
						$registerarion_ids = array($PUSer->device_token);
						\BaseFunction::sendPushNotification($registerarion_ids, 'Termin verschieben ?', $Pdeatail, NULL, NULL, $apData->appointment_id);
					}
				}
			  //PUSH Notification code ends 
				
			 return ['status' => 'true', 'data' => null];
        } else {
            return ['status' => 'false', 'data' => null];
        }
    }

    public function cancelAppointment(Request $request)
    {
		
        $variant_id = $request['variant_id'];
        $message = $request['cancel_reason'];
        $appointment = $request['appointment_id'];

        $serviceAppointment = AppointmentData::where('appointment_id', $appointment)->where('variant_id', $variant_id)->first();

        $updateAppointment = AppointmentData::where('appointment_id', $appointment)->where('variant_id', $variant_id)->update(['cancel_reason' => $message, 'status' => 'cancel', 'cancelled_by' => 'store']);

        if ($updateAppointment) {
			//send cancellation email to user
			\BaseFunction::sendEmailNotificationAppointment($serviceAppointment['id'], "cancelled");
			$AppointmentAr = Appointment::where('id', $appointment)->first();
			 \BaseFunction::notification('Termin storniert !','Buchung wurde storniert','appointment',$serviceAppointment['id'],$AppointmentAr['store_id'],$AppointmentAr['user_id'],$AppointmentAr['user_id'] == ''? 'guest' : '', 'users');
			//Push Notification for cancellations
				$PUSer = User::find($AppointmentAr['user_id']);
				if(!empty($PUSer->device_token) && !empty($PUSer->allow_notifications) && $PUSer->allow_notifications == 1){
					$sessioncount = ApiSession::where('user_id', $PUSer->id)->count();
					if($sessioncount > 0){
						$registerarion_ids = array($PUSer->device_token);
						$pdate  = \Carbon\Carbon::parse($serviceAppointment['appo_date'])->format('d.m.Y');
						$ptime  = \Carbon\Carbon::parse($serviceAppointment['appo_time'])->format('H:i');
						$store_name = StoreProfile::where('id', $AppointmentAr['store_id'])->value('store_name');
						$Pdeatail = "Dein Termin am ". $pdate ." um ".$ptime." bei ". $store_name." wurde leider storniert.";
						$icon  = asset('storage/app/public/notifications/Cancellation.png');
						\BaseFunction::sendPushNotification($registerarion_ids, 'Stornierung!', $Pdeatail, NULL, NULL, $AppointmentAr['id']);
					}
				}
			
			//PUSH Notification code ends 
            $payment = PaymentMethodInfo::where('appoinment_id', $serviceAppointment['appointment_id'])->first();
            if ($payment['payment_method'] == 'stripe' || $payment['payment_method'] == 'klarna' || $payment['payment_method'] == 'applepay' || $payment['payment_method'] == 'googlepay') {
                $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
                if ($payment['payment_method'] == 'stripe') {
                    $refund = $stripe->refunds->create([
                        'charge' => $payment['payment_id'],
                        'amount' => $serviceAppointment['price'] * 100,
                        'reason' => 'requested_by_customer'
                    ]);
                    $updatePayment = PaymentMethodInfo::where('id', $payment['id'])->update(['refund_id' => $refund['id'], 'status' => 'refund']);
                    $updateRefund = AppointmentData::where('appointment_id', $appointment)->where('variant_id', $variant_id)->update(['refund_id' => $refund['id']]);
                } elseif ($payment['payment_method'] == 'klarna' || $payment['payment_method'] == 'applepay' || $payment['payment_method'] == 'googlepay') {
                    $refund = $stripe->refunds->create([
                        'payment_intent' => $payment['payment_id'],
                        'amount' => $serviceAppointment['price'] * 100,
                        'reason' => 'requested_by_customer'
                    ]);
                    $updatePayment = PaymentMethodInfo::where('id', $payment['id'])->update(['refund_id' => $refund['id'], 'status' => 'refund']);
                    $updateRefund = AppointmentData::where('appointment_id', $appointment)->where('variant_id', $variant_id)->update(['refund_id' => $refund['id']]);
                }
            }
            if ($payment['payment_method'] == 'cash'){
                $updatePayment = PaymentMethodInfo::where('id', $payment['id'])->update(['refund_id' => 'cash', 'status' => 'refund']);
            }

			if(!empty($req['internal_call'])){
				return "success";
			}

            return redirect('dienstleister/buchung');
        }
    }

    public function shortingAppointment(Request $request)
    {


        $store_id = session('store_id');
        $status = $request['shorting'];

        if (empty($store_id)) {
            $getStore = StoreProfile::where('user_id', Auth::user()->id)->pluck('id')->all();
        } else {
            $getStore = StoreProfile::where('user_id', Auth::user()->id)->where('id', $store_id)->pluck('id')->all();
        }

        $appointment = AppointmentData::leftjoin('appointments', 'appointments.id', '=', 'appointment_data.appointment_id')
            ->leftjoin('payment_method_infos', 'payment_method_infos.appoinment_id', '=', 'appointments.id')
            ->whereIn('appointment_data.store_id', $getStore);
        if ($status == 'new') {
            $appointment = $appointment->where('appointment_data.status', 'booked');
        }
        if ($status == 'completed') {
            $appointment = $appointment->where('appointment_data.status', 'completed');
        }
        if ($status == 'running') {
            $appointment = $appointment->where('appointment_data.status', 'running');
        }
        if ($status == 'reschedule') {
            $appointment = $appointment->where('appointment_data.status', 'reschedule');
        }
        if ($status == 'cancel') {
            $appointment = $appointment->where('appointment_data.status', 'cancel');
        }

        $appointment = $appointment->select('appointment_data.*', 'payment_method_infos.status as payment_status', 'payment_method_infos.card_type as card_type','payment_method_infos.payment_method as payment_method',
            'appointments.user_id', 'appointments.order_id', 'appointments.first_name', 'appointments.last_name', 'appointments.email')
            ->orderBy('appointment_data.appo_date', 'DESC')
            ->paginate(10);
			
			
		$total_pages =  $appointment->lastPage();

        foreach ($appointment as $row) {
           /*  if ($row->status == 'completed') {
                $checkReview = StoreRatingReview::where('appointment_id', $row->appointment_id)->first();
                if (!empty($checkReview)) {
                    $row->is_reviewed = $checkReview;
                } else {
                    $row->is_reviewed = '';
                }
            } else {
                $row->is_reviewed = '';
            }
			$rrcount = Notification::where('appointment_id', $row->id)->where('type', 'review_request')->count();
			if($rrcount > 0){
				$row->review_requested = 1;
			}else{
				$row->review_requested = 0;
			} */
			
			 if ($row->status == 'completed') {
                $checkReview = StoreRatingReview::where('appointment_id', $row->id)->first();
                if (!empty($checkReview)) {
                    $row->is_reviewed = $checkReview;
                } else {
					$row->is_reviewed = '';
                }
				
            } else {
                $row->is_reviewed = '';
            }
			$rrcount = Notification::where('appointment_id', $row->id)->where('type', 'review_request')->count();
			if($rrcount > 0){
				$row->review_requested = 1;
			}else{
				$row->review_requested = 0;
			}
			
            $row->image = Service::where('id', $row->service_id)->value('image');
        }

        return response()->json(["html" => view('ServiceProvider.Appointment.appointmentDetails', compact('appointment'))->render(), 'total_pages' => $total_pages]);
    }

    public function checkout(Request $request)
    {
        $serviceData = $request['servicelist'];

        if (Auth::check()) {

            $checkData = TempServiceStore::where('user_id', Auth::user()->id)->get();
            if (count($checkData) > 0) {
                $deleteData = TempServiceStore::where('user_id', Auth::user()->id)->delete();
            }
        }


        foreach ($serviceData as $row) {


            $data['user_id'] = Auth::user()->id;
            $data['service'] = $row['service'];
            $data['category'] = $row['category'];
            $data['subcategory'] = $row['subcategory'];
            $data['variant'] = $row['variant'];
            $data['price'] = $row['price'];
            $data['store_id'] = $row['store'];

            $tempData = new TempServiceStore();
            $tempData->fill($data);
            $tempData->save();
        }

        return ['status' => 'true', 'data' => []];
    }

    public function checkoutData()
    {
        if (Auth::check()) {
            $getStore = TempServiceStore::where('user_id', Auth::user()->id)->value('store_id');
            $serviceData = TempServiceStore::where('user_id', Auth::user()->id)->get()->toArray();
        }

        $store = StoreProfile::where('id', $getStore)->first();

        $categoryData = [];
        $totaltime = 0;
        $totalamount = 0;

        foreach ($serviceData as $row) {
            $row['subcategory_name'] = \BaseFunction::getCategoryName($row['subcategory']);
            $variantData = \BaseFunction::variantData($row['variant']);
            $serviceData = \BaseFunction::serviceData($row['service']);
            $row['variant_data'] = $variantData;
            $row['service_data'] = $serviceData;
            $row['duration_of_service'] = @$variantData['duration_of_service'];
            $totaltime += @$variantData['duration_of_service'];
            $totalamount += $row['price'];
            $categoryData[(int)$row['category']][] = $row;
        }


        $data = [];

        foreach ($categoryData as $key => $value) {
            $data[] = array(
                'category' => \BaseFunction::getCategoryDate($key),
                'data' => $value,
                'totaltime' => array_sum(array_map(function ($item) {
                    return $item['duration_of_service'];
                }, $value)),
            );
        }


        return view('ServiceProvider.Appointment.Create.checkout', compact('data', 'store', 'totalamount'));
    }

    public function getCategoryTimeslot(Request $request)
    {

        $store = StoreProfile::findorFail($request['store']);
        if (file_exists('storage/app/public/store/' . $store['store_profile']) && $store['store_profile'] != '') {
            $store['store_profile'] = URL::to('storage/app/public/store/' . $store['store_profile']);
        } else {
            $store['store_profile'] = URL::to('storage/app/public/default/default_store.jpeg');
        }

        $category_name = Category::where('id', $request['category'])->first();
        if (file_exists('storage/app/public/category/' . $category_name['image']) && $category_name['image'] != '') {
            $category_name['image'] = URL::to('storage/app/public/category/' . $category_name['image']);
            $category_name['parse_image'] = file_get_contents($category_name['image']);
        } else {
            $category_name['image'] = URL::to('storage/app/public/default/default_store.jpeg');
        }

        $emplist = StoreEmp::leftjoin('store_emp_categories', 'store_emp_categories.store_emp_id', '=', 'store_emps.id')
//            ->join('store_emp_timeslots','store_emp_timeslots.store_emp_id','=','store_emps.id')
            ->where('store_emp_categories.category_id', $request['category'])
            ->where('store_emps.store_id', $request['store'])
            ->select('store_emps.*')
            ->get();

        foreach ($emplist as $row) {
            if (file_exists('storage/app/public/store/employee/' . $row->image) && $row->image != '') {
                $row->image = URL::to('storage/app/public/store/employee/' . $row->image);
            } else {
				$empnameArr = explode(" ", $row->emp_name);
				$empname = "";
				if(count($empnameArr) > 1){
					$empname = strtoupper(substr($empnameArr[0], 0, 1)).strtoupper(substr($empnameArr[1], 0, 1));
				}else{
					$empname = strtoupper(substr($row->emp_name, 0, 2));
				}
				$row->image = "https://via.placeholder.com/150x150/00000/FABA5F?text=".$empname;
                //$row->image = URL::to('storage/app/public/default/default-user.png');
            }
        }
        $date = \Carbon\Carbon::now()->format('Y-m-d');

        $data = array(
            'store' => $store,
            'category' => $category_name,
            'emp_list' => $emplist,
            'date' => $date,
            'totalTime' => $request['time'],
        );

        if (!empty($store)) {
            return ['status' => 'true', 'data' => $data];
        } else {
            return ['status' => 'false', 'data' => []];
        }
    }

    public function getNewTimeslot(Request $request)
    {
        if (isset($request['booking'])) {
            $booking = $request['booking'];
        } else {
            $booking = [];
        }
        $time = \BaseFunction::bookingAvailableTime($request['date'], $request['store'], $request['time'], $request['category'], $booking);

        if (count($time) > 0) {
            return ['status' => 'true', 'data' => $time];
        } else {
            return ['status' => 'false', 'data' => []];
        }
    }

    public function getNewTimeslotEmp(Request $request)
    {
        if (isset($request['booking'])) {
            $booking = $request['booking'];
        } else {
            $booking = [];
        }

        $time = \BaseFunction::bookingAvailableTimeEmp($request['date'], $request['store'], $request['time'], $request['category'], $request['emp'], $booking);
        $dowMap = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');

        $getdays = StoreEmpTimeslot::where('store_emp_id', $request['emp'])->get();
        $offday = [];
        if (count($getdays) > 0) {
            $getOffDays = StoreEmpTimeslot::where('store_emp_id', $request['emp'])->where('is_off', 'on')->get();
            foreach ($getOffDays as $row) {

                if (in_array($row->day, $dowMap)) {
                    $offday[] = array_search($row->day, $dowMap);
                }
            }
        } else {
            $offday = [0, 1, 2, 3, 4, 5, 6];
        }

        if (count($time) > 0) {
            return ['status' => 'true', 'data' => $time, 'day' => $offday];
        } else {
            return ['status' => 'false', 'data' => []];
        }
    }

    public function updateCheckoutData(Request $request)
    {

        $category = $request['category'];
        $store = $request['store'];
        $date = $request['date'];
        $employee = $request['employee'];
        $time = $request['time'];

        for ($i = 0; $i < count($category); $i++) {
            $updata['date'] = $date[$i];
            $updata['time'] = $time[$i];
            if (count($employee) > 0) {
                $updata['employee'] = $employee[$i];
            }

            $update = TempServiceStore::where('store_id', $store[$i]);
            if (Auth::check()) {
                $update = $update->where('user_id', Auth::user()->id);
            } else {
                $email = Session::get('guest_email');
                $update = $update->where('guest_email', $email);
            }
            $update = $update->where('category', $category[$i])->update($updata);
        }

        return redirect('dienstleister/zahlungsabschluss');
    }

    public function proceedToPay()
    {

        if (Auth::check()) {
            $getStore = TempServiceStore::where('user_id', Auth::user()->id)->value('store_id');
            $serviceData = TempServiceStore::where('user_id', Auth::user()->id)->get()->toArray();
        } else {
            $email = Session::get('guest_email');
            $getStore = TempServiceStore::where('guest_email', $email)->value('store_id');
            $serviceData = TempServiceStore::where('guest_email', $email)->get()->toArray();
        }
        $store = StoreProfile::where('id', $getStore)->first();

        $categoryData = [];
        $totaltime = 0;
        $totalamount = 0;
        foreach ($serviceData as $row) {
            $row['subcategory_name'] = \BaseFunction::getCategoryName($row['subcategory']);
            $variantData = \BaseFunction::variantData($row['variant']);
            $serviceData = \BaseFunction::serviceData($row['service']);
            $row['variant_data'] = $variantData;
            $row['service_data'] = $serviceData;
            $totaltime += @$variantData['duration_of_service'];
            $totalamount += $row['price'];
            $categoryData[$row['category']][] = $row;
        }

        $data = [];
        foreach ($categoryData as $key => $value) {
            $data[] = array(
                'category' => \BaseFunction::getCategoryDate($key),
                'data' => $value,
                'totaltime' => $totaltime
            );
        }
        $customer  = ['' => 'Kunde auswählen'] + Customer::where('store_id',$getStore)->pluck('name','id')->all();
//        dd($data);
        return view('ServiceProvider.Appointment.Create.billing', compact('data', 'store', 'totalamount','customer'));
    }

    public function checkoutPayment(Request $request)
    {
        $data = $request->all();
		$checkval = \BaseFunction::sameBookingChecking($data);
		//echo "<pre>"; print_r($checkval); die;
        if($checkval['status'] == 'false'){
            \Session::put('booking_error', 'yes');
            
            $remove = BookingTemp::whereIn('id',$checkval['id'])->delete();
            return redirect('dienstleister/checkout-prozess');
        }
        
        $value = \BaseFunction::checkBooking($data);

        if(count($value) > 0){
            \Session::put('booking_error', 'yes');
			$remove = BookingTemp::whereIn('id',$checkval['id'])->delete();
            return redirect('dienstleister/checkout-prozess');
        } 
		
        $category = $request['category'];
        $subcategory = $request['subcategory'];
        $store = $request['store'];
        $date = $request['date'];
        $employee = $request['employee'];
        $time = $request['time'];
        $price = $request['price'];
        $variant = $request['variant'];
        $service = $request['service'];
        $service_data = $request['service_data'];

        $amount = $request['totalAmount'];

        $charge_id = 'Cash';
        $payment_method = 'cash';
        $status = 'booked';


        $getEmail = User::where('email', $data['email'])->first();
        if (!empty($getEmail)) {
            $appointmentData['user_id'] = $getEmail['id'];
        }
        $appointmentData['first_name'] = $data['fname'];
        $appointmentData['last_name'] = $data['lname'];
        $appointmentData['email'] = $data['email'];
        $appointmentData['phone_number'] = $data['phone_number'];

        $appointmentData['store_id'] = $store[0];
        $appointmentData['order_id'] = \BaseFunction::orderNumber();
        $appointmentData['appointment_type'] = 'service-provider';
        $appointmentData['total_amount'] = $data['totalAmount'];

        $appointment = new Appointment();
        $appointment->fill($appointmentData);
        if ($appointment->save()) {
			$cat = '';
            for ($i = 0; $i < count($category); $i++) {
                //$newTime = $time[$i];
				if($cat == ''){
                    $cat = $category[$i];    
                    $newTime = $time[$i];
                } else if($cat != $category[$i]) {
                    $newTime = $time[$i];
                    $cat = '';
                }

                if($i != 0 && $cat != ''){
                    $getduration = ServiceVariant::where('id', $variant[$i - 1])->value('duration_of_service');
                    if($cat == $category[$i]){
					   $newTime = \Carbon\Carbon::parse( $newTime)->addMinutes($getduration)->format('H:i');
					}else{
					   $newTime = \Carbon\Carbon::parse($time[$i - 1])->addMinutes($getduration)->format('H:i');
					}
                }

                $getTimeDuration = ServiceVariant::where('id', $variant[$i])->value('duration_of_service');
                $endTime = \Carbon\Carbon::parse($newTime)->addMinutes($getTimeDuration)->format('H:i');
				$cat =  $category[$i];
				
				$cur_date = \Carbon\Carbon::now()->timezone('Europe/Berlin')->format('Y-m-d');
				$cur_time = \Carbon\Carbon::now()->timezone('Europe/Berlin')->format('H:i');
				$status = 'booked';
				if(!empty($date[$i]) && $cur_date == $date[$i]){
					if($endTime <= $cur_time){
						$status = 'completed';
					}
					if($newTime <= $cur_time && $endTime > $cur_time){
						$status = 'running';
					}
				}
                $subData['appointment_id'] = $appointment['id'];
                $subData['store_id'] = $store[$i];
                $subData['category_id'] = $category[$i];
                $subData['subcategory_id'] = $subcategory[$i];
                $subData['service_id'] = $service[$i];
                $subData['service_name'] = $service_data[$i];
                $subData['variant_id'] = $variant[$i];
                $subData['price'] = $price[$i];
                $subData['status'] = $status;
                $subData['store_emp_id'] = $employee[$i];
                $subData['appo_date'] = $date[$i];
                $subData['appo_time'] = $newTime;
                $subData['app_end_time'] = $endTime;

                $appData = new AppointmentData();
                $appData->fill($subData);
                $appData->save();
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

            \Session::put('payment_data', $paymentSuccess);
            \Session::put('payment_status', 'success');
            Session::put('appointment_id', $appointment['id']);
				
			//\BaseFunction::notification('Neue Buchung !','Sie haben eine neue Buchung erhalten','appointment',$appointment['id'],$appointment['store_id'],$appointment['user_id'],$appointment['user_id'] == ''? 'guest' : '','users');
           \BaseFunction::notification('Neue Buchung !','Glückwunsch! Für dich wurde gerade ein Termin gebucht.','appointment',$appointment['id'],$appointment['store_id'],$appointment['user_id'],$appointment['user_id'] == ''? 'guest' : '','users');
            //send appointmentment confirmation email to user
			\BaseFunction::sendEmailNotificationAppointmentConfirmation($appointment['id']);
			$checkSameStore = TempServiceStore::where('user_id', Auth::user())->delete();
			 $remove = BookingTemp::whereIn('id',$checkval['id'])->delete();
            return redirect('dienstleister/buchungsbestaetigung');

        }

    }

    public function orderConfirmation()
    {
        $status = Session::get('payment_status');
        $slug = Session::get('slug');
        $appointment_id = Session::get('appointment_id');

        $appointment = Appointment::where('id', $appointment_id)->first();
        $store = StoreProfile::find($appointment['store_id']);
        $serviceData = AppointmentData::where('appointment_id', $appointment_id)->get();
        $paymentinfo = PaymentMethodInfo::where('appoinment_id', $appointment_id)->first();
        $appointmentData = [];

        foreach ($serviceData as $row) {

            $row['subcategory_name'] = \BaseFunction::getCategoryName($row['subcategory_id']);
            $variantData = \BaseFunction::variantData($row['variant_id']);
            $serviceDatas = \BaseFunction::serviceData($row['service_id']);
            $row['variant_data'] = $variantData;
            $row['service_data'] = $serviceDatas;
            $appointmentData[$row['category_id']][] = $row;
        }

        $data = [];
        foreach ($appointmentData as $key => $value) {
            $data[] = array(
                'category' => \BaseFunction::getCategoryDate($key),
                'data' => $value,
            );
        }

        return view('ServiceProvider.Appointment.Create.confirmation', compact('appointment', 'status', 'slug', 'store', 'paymentinfo', 'data'));
    }

    public function bookAgain(Request $request)
    {
        $getServiceData = AppointmentData::where('id', $request['id'])->first();

        $checkSameStore = TempServiceStore::where('user_id', Auth::user()->id)->where('store_id', $getServiceData['store_id'])->get();
        if (count($checkSameStore) == 0) {

            $removeServices = TempServiceStore::where('user_id', Auth::user()->id)->delete();
        } else {
            $removeServices = TempServiceStore::where('user_id', Auth::user()->id)->delete();
        }

        $newData['user_id'] = Auth::user()->id;
        $newData['service'] = $getServiceData['service_id'];
        $newData['category'] = $getServiceData['category_id'];
        $newData['subcategory'] = $getServiceData['subcategory_id'];
        $newData['variant'] = $getServiceData['variant_id'];
        $newData['price'] = $getServiceData['price'];
        $newData['store_id'] = $getServiceData['store_id'];

        $Bookingagain = new TempServiceStore();
        $Bookingagain->fill($newData);
        if ($Bookingagain->save()) {
            return ['status' => 'true', 'data' => []];
        } else {
            return ['status' => 'false', 'data' => []];
        }
    }

    public function removeService(Request $request)
    {
        $id = $request['id'];
        if(empty($request['email'])){
            $user_id = Auth::user()->id;
        } else {
            $user_id = $request['email'];
        }
        if(Auth::check()){
            $getData = TempServiceStore::where('user_id',$user_id)->where('variant', $id)->first();

        } else {
            $getData = TempServiceStore::where('email',$user_id)->where('variant', $id)->first();

        }
        $getStore = $getData['store_id'];
        $getPrice = $getData['price'];

        if(Auth::check()){
            $remove = TempServiceStore::where('user_id',$user_id)->where('variant', $id)->delete();
            $availableService = TempServiceStore::where('user_id',$user_id)->where('store_id', $getStore)->get();
            $totalAmount = TempServiceStore::where('user_id',$user_id)->where('store_id', $getStore)->sum('price');
            $totalservice = TempServiceStore::where('user_id',$user_id)->where('store_id',$getData['store_id'])->where('category',$getData['category'])->count();
        } else {

            $remove = TempServiceStore::where('email',$user_id)->where('variant', $id)->delete();
            $availableService = TempServiceStore::where('email',$user_id)->where('store_id', $getStore)->get();
            $totalAmount = TempServiceStore::where('email',$user_id)->where('store_id', $getStore)->sum('price');
            $totalservice = TempServiceStore::where('email',$user_id)->where('store_id',$getData['store_id'])->where('category',$getData['category'])->count();
        }



        if ($remove) {
            $data = array(
                'availableService' => $availableService,
                'totalamount' => $totalAmount,
                'totalservice'=>$totalservice
            );
            return ['status' => 'true', 'data' => $data];
        } else {
            return ['status' => 'false', 'data' => []];
        }

    }
	
	
	public function reviewRequest(Request $request)
    {
        $id = $request['id'];
        if ($id) {
			$apData  = AppointmentData::find($id);
			if(!empty($apData->appointment_id)){
				$AppointmentAr = Appointment::where('id', $apData->appointment_id)->first();
				$store_name = StoreProfile::where('id', $AppointmentAr['store_id'])->value('store_name');
				$message = "Hast du gerade einen Moment, um deinen Termin bei ".$store_name." zu bewerten ? ";
				 \BaseFunction::notification('Bewertungsanfrage !',$message,'review_request',$apData['id'],$AppointmentAr['store_id'],$AppointmentAr['user_id'],$AppointmentAr['user_id'] == ''? 'guest' : '','users');
				//Push Notification for cancellations
				$PUSer = User::find($AppointmentAr['user_id']);
				if(!empty($PUSer->device_token) && !empty($PUSer->allow_notifications) && $PUSer->allow_notifications == 1){
					$sessioncount = ApiSession::where('user_id', $PUSer->id)->count();
					if($sessioncount > 0){
						$registerarion_ids = array($PUSer->device_token);
						\BaseFunction::sendPushNotification($registerarion_ids, 'Bewertungsanfrage !', $message, NULL, NULL, $apData->appointment_id);
					}
				}
			  //PUSH Notification code ends 
				
				return ['status' => 'true', 'data' => null];
			}else{
				return ['status' => 'false', 'data' => null];
			}
        } else {
            return ['status' => 'false', 'data' => null];
        }
    }

}
