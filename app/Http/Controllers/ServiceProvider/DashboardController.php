<?php

namespace App\Http\Controllers\ServiceProvider;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\AppointmentData;
use App\Models\PaymentMethodInfo;
use App\Models\Service;
use App\Models\ServiceAppoinment;
use App\Models\ServiceVariant;
use App\Models\StoreEmp;
use App\Models\StoreEmpTimeslot;
use App\Models\StoreProfile;
use App\Models\StoreRatingReview;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\User;
use Auth;
use URL;

class DashboardController extends Controller
{
    public function index(){
        $store_id = session('store_id');

        if(empty($store_id)){
            $getStore = StoreProfile::where('user_id', Auth::user()->id)->pluck('id')->all();
        } else{
            $getStore = StoreProfile::where('user_id', Auth::user()->id)->where('id',$store_id)->pluck('id')->all();
        }

        $date = \Carbon\Carbon::now()->format('Y-m-d');


        $activeAppointment = AppointmentData::whereIn('store_id',$getStore)->where('status','running')->count();
        $pendingAppointment = AppointmentData::whereIn('store_id',$getStore)->where('status','booked')->count();
        $completedAppointment = AppointmentData::whereIn('store_id',$getStore)->where('status','completed')->count();
        $canceledAppointment = AppointmentData::whereIn('store_id',$getStore)->where('status','cancel')->count();
        $totalService = Service::whereIn('store_id',$getStore)->count();
        $totalEmp = StoreEmp::whereIn('store_id',$getStore)->get();
        $totalReview = StoreRatingReview::whereIn('store_id',$getStore)->count();
        $totalCustomer = Customer::whereIn('store_id',$getStore)->count();
         

        foreach ($totalEmp as $k=>$item) {
            $item->time = StoreEmpTimeslot::where('day',\Carbon\Carbon::now()->format('l'))->where('store_emp_id',$item->id)->first();
			if(!empty($item->time->is_off) and $item->time->is_off == 'on'){
				unset($totalEmp[$k]);
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
            })
            ->whereIn('appointment_data.store_id',$getStore)
            ->whereDate('appointment_data.appo_date',$date)
            ->select('appointment_data.*', 'payment_method_infos.status as payment_status','payment_method_infos.card_type as card_type','payment_method_infos.payment_method as payment_method',
                'appointments.user_id','appointments.order_id', 'appointments.first_name', 'appointments.last_name')
            ->get();


        $todayAppointment = [];
        foreach ($pendingAppointments as $row) {
            $storeData = StoreProfile::findorFail($row->store_id);
            $row->storeData = $storeData;
            $todayAppointment[$row->appo_time][] = $row;
        }

        ksort($todayAppointment);

        $todayEarning = AppointmentData::whereIn('store_id',$getStore)->whereDate('appo_date',$date)->where('status','completed')->sum('price');

        return view('ServiceProvider.dashboard',compact('activeAppointment','pendingAppointment','completedAppointment','canceledAppointment',
            'totalCustomer','totalCustomer','totalEmp','totalService','totalReview','todayEarning','todayAppointment'));
    }

    public function setSession(Request $request){

        $id = $request['id'];
        if($id != ''){
            $address = StoreProfile::where('id',$id)->first();

            $request->session()->put('store_id',$id);
            $request->session()->put('store_name',$address['store_name']);
            $request->session()->put('address',$address['store_address']);

            if (file_exists('storage/app/public/store/' . $address['store_profile']) && $address['store_profile'] != '') {
                $address['store_profile'] = URL::to('storage/app/public/store/' . $address['store_profile']);
            } else {
                $address['store_profile'] = URL::to('storage/app/public/default/default_store.jpeg');
            }

            $request->session()->put('store_profile',$address['store_profile']);
        } else {
            $request->session()->put('store_id','');
            $request->session()->put('store_name','');
            $request->session()->put('address','');
            $request->session()->put('store_profile','');
        }


        return true;
    }

    public function dashboardAppointment(Request $request){

        $store_id = session('store_id');

        $shorting = $request['shorting'];

        if(empty($store_id)){
            $getStore = StoreProfile::where('user_id', Auth::user()->id)->pluck('id')->all();
        } else{
            $getStore = StoreProfile::where('user_id', Auth::user()->id)->where('id',$store_id)->pluck('id')->all();
        }

        $date = \Carbon\Carbon::now()->format('Y-m-d');

        $pendingAppointments = AppointmentData::leftjoin('appointments', 'appointments.id', '=', 'appointment_data.appointment_id')
            ->leftjoin('payment_method_infos', 'payment_method_infos.appoinment_id', '=', 'appointments.id');

        if($request['shorting'] == null){
            $pendingAppointments = $pendingAppointments->where(function ($query) {
                $query->Where('appointment_data.status', 'pending')
                    ->orWhere('appointment_data.status', 'booked')
                    ->orWhere('appointment_data.status', 'running')
                    ->orWhere('appointment_data.status', 'reschedule');
            });
        }

        if($request['shorting'] == 'all'){
            $pendingAppointments = $pendingAppointments->where(function ($query) {
                $query->Where('appointment_data.status', 'pending')
                    ->orWhere('appointment_data.status', 'booked')
                    ->orWhere('appointment_data.status', 'running')
                    ->orWhere('appointment_data.status', 'completed')
					->orWhere('appointment_data.status', 'reschedule')
                    ->orWhere('appointment_data.status', 'cancel');
            });
        }

        if(isset($request['shorting']) &&  $request['shorting'] != null &&  $request['shorting'] != 'all'){
            $pendingAppointments = $pendingAppointments->where('appointment_data.status',$shorting);
        }

        $pendingAppointments = $pendingAppointments->whereIn('appointment_data.store_id',$getStore)
            ->whereDate('appointment_data.appo_date',$date)
            ->select('appointment_data.*', 'payment_method_infos.status as payment_status','payment_method_infos.card_type as card_type','payment_method_infos.payment_method as payment_method',
                'appointments.user_id','appointments.order_id', 'appointments.first_name', 'appointments.last_name')
            ->get();


        $todayAppointment = [];
        foreach ($pendingAppointments as $row) {
            $storeData = StoreProfile::findorFail($row->store_id);
            $row->storeData = $storeData;
            $todayAppointment[$row->appo_time][] = $row;
        }

        ksort($todayAppointment);

        return (view('ServiceProvider.appointmentDetails', compact('todayAppointment'))->render());
    }
    public function notification()
    {
         $store_id = session('store_id');
		User::where('id', Auth::id())->update(['notification_checked' => date('Y-m-d H:i:s')]);
        if(empty($store_id)){
            $getStore = StoreProfile::where('user_id', Auth::user()->id)->pluck('id')->all();
        } else{
            $getStore = StoreProfile::where('user_id', Auth::user()->id)->where('id',$store_id)->pluck('id')->all();
        }

        $data = Notification::whereIn('store_id',$getStore)->whereNull('visible_for')->orderBy('created_at','DESC')->get();
		
        return view('ServiceProvider.notification',compact('data'));
    }
	
	public function ajaxnotificationsread()
    {
        User::where('id', Auth::id())->update(['notification_checked' => date('Y-m-d H:i:s')]);
		return true;
    }
	
	public function notification_count()
    {
         $store_id = session('store_id');
		$user = User::where('id', Auth::id())->first(['notification_checked']);
        if(empty($store_id)){
            $getStore = StoreProfile::where('user_id', Auth::user()->id)->pluck('id')->all();
        } else{
            $getStore = StoreProfile::where('user_id', Auth::user()->id)->where('id',$store_id)->pluck('id')->all();
        }
		$dateUser  = !empty($user->notification_checked)?$user->notification_checked:date('Y-m-d H:i:s');
		$timeUser  = !empty($user->notification_checked)?date('H:i:s', strtotime($user->notification_checked)):date('H:i:s');
        $data = Notification::whereIn('store_id',$getStore)->whereNull('visible_for')->where('created_at', '>=', $dateUser)->whereTime('created_at', '>', $timeUser)->orderBy('created_at','DESC')->count();

       $notifications = Notification::whereIn('store_id',$getStore)->whereNull('visible_for')->orderBy('created_at','DESC')->paginate(5);
		$view =  view('Includes.Service.notificationinner',compact('notifications'))->render();
        return response()->json(['count' => $data, 'notifications' => $view, 'total_pages' => $notifications->lastPage()], 200);  
    }
}


