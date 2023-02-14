<?php

namespace App\Http\Controllers\ServiceProvider;

use Auth;
use App\Models\Withdrwal;
use App\Models\Appointment;
use App\Models\StoreProfile;
use Illuminate\Http\Request;
use App\Models\AppointmentData;
use App\Models\PaymentMethodInfo;
use App\Models\ServiceAppoinment;
use App\Http\Controllers\Controller;

class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $store_id = session('store_id');
		$now = \Carbon\Carbon::now()->timezone('Europe/Berlin');
        if (empty($store_id)) {
            $getStore = StoreProfile::where('user_id', Auth::user()->id)->pluck('id')->all();
        } else {
            $getStore = StoreProfile::where('user_id', Auth::user()->id)->where('id', $store_id)->pluck('id')->all();
        }

        $date = \Carbon\Carbon::now()->timezone('Europe/Berlin')->format('Y-m-d');
        $month = \Carbon\Carbon::now()->timezone('Europe/Berlin')->format('m');
        $year = \Carbon\Carbon::now()->timezone('Europe/Berlin')->format('Y');
      
        $netEarning 		= AppointmentData::whereIn('store_id', $getStore)->where('status', 'completed');
        $refundableBalance 	= AppointmentData::whereIn('store_id', $getStore)->where('status', 'cancel');

        $withdrwalBalance 	= Withdrwal::whereIn('store_id', $getStore)->where('status', 'complete');
		
        $todayEarning 		= AppointmentData::whereIn('store_id', $getStore)->whereDate('appo_date', $date)->where('status', 'completed')->sum('price');

        $allTransaction 	= AppointmentData::whereIn('store_id', $getStore);
		
		 $transaction = AppointmentData::leftjoin('appointments','appointments.id','=','appointment_data.appointment_id')
			->leftjoin('payment_method_infos','payment_method_infos.appoinment_id','=','appointment_data.appointment_id')
            ->whereIn('appointments.store_id',$getStore);
            // ->where('appointment_data.refund_id','!=','')
            
		
        $refund = AppointmentData::leftjoin('appointments','appointments.id','=','appointment_data.appointment_id')
            ->whereIn('appointments.store_id',$getStore)
            ->where('appointment_data.status','cancel');
            // ->where('appointment_data.refund_id','!=','')

        $netAppoId = AppointmentData::whereIn('store_id', $getStore)->where('status', 'completed')->distinct()->pluck('appointment_id')->all();
        $orderId = Appointment::whereIn('id', $netAppoId)->pluck('order_id')->all();
        $netFunds = PaymentMethodInfo::whereIn('appoinment_id', $netAppoId)->where('status', 'succeeded')->where('payment_method', '!=', 'cash');
        
        $withdraw = Withdrwal::whereIn('store_id', $getStore);
		$period  = !empty($request['period'])?$request['period']:"";
		$startdate  = !empty($request['start_date'])?$request['start_date']:"";
		$enddate  = !empty($request['end_date'])?$request['end_date']:"";
		if($period  == "today") {
			$netEarning  		= $netEarning->whereDate('appointment_data.created_at',$date);
			$refundableBalance  = $refundableBalance->whereDate('appointment_data.created_at',$date);
			$withdrwalBalance 	= $withdrwalBalance->whereDate('withdrwals.created_at',$date);
			$allTransaction  	= $allTransaction->whereDate('appointment_data.created_at',$date);
			$transaction 		= $transaction->whereDate('appointment_data.created_at',$date);
			$refund 			= $refund->whereDate('appointment_data.created_at',$date);
			$withdraw 			= $withdraw->whereDate('created_at',$date);
			// $netFunds 			= $netFunds->whereDate('created_at',$date);

            $lastWithdrawDate   = !empty($withdraw->latest()->first()) ? $withdraw->latest()->first()->created_at : '';
            $isWithdrawToday    = \Carbon\Carbon::parse($lastWithdrawDate)->isToday();

            $netFunds           = $netFunds->where('created_at', '>', $lastWithdrawDate);
            
            // dd($isWithdrawToday);

		}else if($period == "year") {
			$netEarning  		= $netEarning->whereYear('appointment_data.created_at',$year);
			$refundableBalance  =  $refundableBalance->whereYear('appointment_data.created_at',$year);
			$withdrwalBalance 	= $withdrwalBalance->whereYear('withdrwals.created_at',$year);
			$allTransaction  	= $allTransaction->whereYear('appointment_data.created_at',$year);
			$transaction 		= $transaction->whereYear('appointment_data.created_at',$year);
			$refund 			= $refund->whereYear('appointment_data.created_at',$year);
			$withdraw 			= $withdraw->whereYear('created_at',$year);
			$netFunds 			= $netFunds->whereYear('created_at',$year);
		}else if($period == "custom") {
			$netEarning  		= $netEarning->whereBetween('appointment_data.created_at', [$startdate, $enddate]);
			$refundableBalance  =  $refundableBalance->whereBetween('appointment_data.created_at', [$startdate, $enddate]);
			$withdrwalBalance 	= $withdrwalBalance->whereBetween('withdrwals.created_at', [$startdate, $enddate]);
			$allTransaction  	= $allTransaction->whereBetween('appointment_data.created_at', [$startdate, $enddate]);
			$transaction 		= $transaction->whereBetween('appointment_data.created_at', [$startdate, $enddate]);
			$refund 			= $refund->whereBetween('appointment_data.created_at', [$startdate, $enddate]);
			$withdraw 			= $withdraw->whereBetween('withdrwals.created_at', [$startdate, $enddate]);

			$netFunds 			= $netFunds->whereBetween('created_at', [$startdate, $enddate]);

            $lastWithdrawDate   = !empty($withdraw->latest()->first()) ? $withdraw->latest()->first()->created_at : '';
            $isWithdrawToday    = \Carbon\Carbon::parse($lastWithdrawDate)->isToday();

            $netFunds           = $netFunds->where('created_at', '>', $lastWithdrawDate);

		}else{
			$netEarning  		= $netEarning->whereMonth('appointment_data.created_at',$month)->whereYear('appointment_data.created_at',$year);
			$refundableBalance  =  $refundableBalance->whereMonth('appointment_data.created_at',$month)->whereYear('appointment_data.created_at',$year);
			$withdrwalBalance 	= $withdrwalBalance->whereMonth('withdrwals.created_at',$month)->whereYear('withdrwals.created_at',$year);
			$allTransaction  	= $allTransaction->whereMonth('appointment_data.created_at',$month)->whereYear('appointment_data.created_at',$year);
			$transaction 		= $transaction->whereMonth('appointment_data.created_at',$month)->whereYear('appointment_data.created_at',$year);
			$refund 			= $refund->whereMonth('appointment_data.created_at',$month)->whereYear('appointment_data.created_at',$year);
			$withdraw 			= $withdraw->whereMonth('created_at',$month)->whereYear('created_at',$year);
			$netFunds 			= $netFunds->whereMonth('created_at',$month)->whereYear('created_at',$year);
		}

        // General conditions applied
		$netEarning  		= $netEarning->sum('price');
		$refundableBalance  = $refundableBalance->sum('price');
        $withdrwalBalance  	= $withdrwalBalance->sum('amount');
        
        $successfulPaymentID = $netFunds->pluck('appoinment_id')->all();

        // Specific conditions based on periods
        if ($period != 'today' && $period != 'custom') {
            $netFunds           = AppointmentData::whereIn('appointment_id', $successfulPaymentID)->where('status', 'completed')->sum('price');
            $availableBalance   = $netFunds - $withdrwalBalance;
        } else {
            $netFunds           = AppointmentData::whereIn('appointment_id', $successfulPaymentID)->where('status', 'completed')->sum('price');
            $availableBalance   = $netFunds;
            // $withdrwalBalance   = $netEarning - $availableBalance;
        }
        // dd($netFunds);
		$allTransaction 	= $allTransaction->orderBy('id', 'DESC')->get();
		$transaction 		= $transaction->select('appointment_data.*','payment_method_infos.status as payment_status','appointment_data.price as total_amount','appointments.first_name','appointments.last_name','appointments.email','appointments.order_id','payment_method_infos.payment_id')->get();
		$refund 			= $refund->select('appointment_data.*','appointments.first_name','appointments.last_name','appointments.email')->get();
		$withdraw 			= $withdraw->get();
		
		
        return view('ServiceProvider.Wallet.index', compact('enddate', 'startdate', 'period', 'netEarning', 'netFunds', 'refundableBalance', 'availableBalance', 'withdrwalBalance', 'todayEarning', 'allTransaction','transaction','refund','withdraw'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}


///**
// * Day Chart Data
// */
//$appointmentDay = ServiceAppoinment::whereIn('store_id', $getStore)->where('status', 'completed')->where('appointment_type','system')->whereDate('appo_date', $date)->get();
//$dayas = [];
//foreach ($appointmentDay as $row) {
//    $row->time = \Carbon\Carbon::parse($row->appo_time)->format('H');
//    $dayas[$row->time][] = $row;
//}
//ksort($dayas);
//$dayData = [];
//for($i = 1;$i<=24;$i++){
//    if(array_key_exists(date('H', mktime($i, 0, 0, 0, 0)),$dayas)){
//        $dayData[] = array('time'=>$i,'count'=>
//            array_sum(array_map(function ($item) {
//                return $item['price'];
//            }, $dayas[date('H', mktime($i, 0, 0, 0, 0))]))
//        ,'month'=>$i);
//    } else {
//        $dayData[] = array('time'=>$i,'count'=>0,'month'=>$i );
//    }
//}
//
//
///**
// * Month Chart Data
// */
//$appointmentMonth = ServiceAppoinment::whereIn('store_id', $getStore)->where('status', 'completed')->where('appointment_type','system')->whereMonth('appo_date', '=', $month)->get();
//$monthas = [];
//foreach ($appointmentMonth as $row) {
//    $row->days = \Carbon\Carbon::parse($row->appo_date)->format('d');
//    $monthas[$row->days][] = $row;
//}
//ksort($monthas);
//$monthData = [];
//for($i = 1;$i<=31;$i++){
//    if(array_key_exists(date('d', mktime(0, 0, 0, 0, $i)),$monthas)){
//        $monthData[] = array('time'=>$i,'count'=>
//            array_sum(array_map(function ($item) {
//                return $item['price'];
//            }, $monthas[date('d', mktime(0, 0, 0, 0, $i))]))
//        ,'month'=>$i.'-'.$month);
//    } else {
//        $monthData[] = array('time'=>$i,'count'=>0,'month'=>$i.'-'.$month );
//    }
//}
//
///**
// * Year Chart Data
// */
//$appointmentMonth = ServiceAppoinment::whereIn('store_id', $getStore)->where('status', 'completed')->where('appointment_type','system')->whereYear('appo_date', '=', $year)->get();
//$yearas = [];
//foreach ($appointmentMonth as $row) {
//    $row->month = \Carbon\Carbon::parse($row->appo_date)->format('m');
//    $yearas[$row->month][] = $row;
//}
//ksort($yearas);
//$yearData = [];
//
//for($i=1;$i<=12;$i++){
//    if(array_key_exists(date('m', mktime(0, 0, 0, $i, 10)),$yearas)){
//        $yearData[] = array('time'=>$i,'count'=>
//            array_sum(array_map(function ($item) {
//                return $item['price'];
//            }, $yearas[date('m', mktime(0, 0, 0, $i, 10))]))
//        ,'month'=>date('F', mktime(0, 0, 0, $i, 10)) );
//    } else {
//        $yearData[] = array('time'=>$i,'count'=>0,'month'=>date('F', mktime(0, 0, 0, $i, 10)) );
//    }
