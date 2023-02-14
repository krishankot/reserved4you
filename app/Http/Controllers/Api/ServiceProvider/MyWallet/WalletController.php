<?php

namespace App\Http\Controllers\Api\ServiceProvider\MyWallet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use URL;
use Mail;
use File;
use Exception;
use Carbon\Carbon;
use App\Models\PaymentMethodInfo;
use App\Models\Appointment;
use App\Models\AppointmentData;
use App\Models\ServiceAppoinment;
use App\Models\StoreProfile;
use App\Models\Withdrwal;
use DB;


class WalletController extends Controller
{
    public function walletDetails(Request $request)
    {
        try {
            $data = request()->all();
			DB::statement("SET lc_time_names = 'de_DE'");
			$userId = $data['user']['user_id'];
			$type  = !empty($data['type'])?$data['type']:"";
			$userId  = $data['user']['user_id'];
            // $storeId = \BaseFunction::getStoreDetails($userId);
			$userId  = $data['user']['user_id'];
			if(empty($data['store_id'])) {
				$getStore = StoreProfile::where('user_id',$userId)->pluck('id')->all();
			} else {
				$getStore = StoreProfile::where('user_id', $userId)->where('id', $data['store_id'])->pluck('id')->all();
			}
            
			$date = \Carbon\Carbon::now()->timezone('Europe/Berlin')->format('Y-m-d');
			$month = \Carbon\Carbon::now()->timezone('Europe/Berlin')->format('m');
			$year = \Carbon\Carbon::now()->timezone('Europe/Berlin')->format('Y');
            $commission = \Config::get('admin.commission');
            
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
			if ($period != 'today') {
				$netFunds           = AppointmentData::whereIn('appointment_id', $successfulPaymentID)->where('status', 'completed')->sum('price');
				$availableBalance   = $netFunds - $withdrwalBalance;
			} else {
				$netFunds           = AppointmentData::whereIn('appointment_id', $successfulPaymentID)->where('status', 'completed')->sum('price');
				$availableBalance   = $netFunds;
				// $withdrwalBalance   = $netEarning - $availableBalance;
			}

			$allTransaction 	= $allTransaction->orderBy('id', 'DESC')->get();
			$transactionArr = $refundArr = $withdrawlArr = [];
			$per_page = !empty($data['records_per_page'])?$data['records_per_page']:10;
			$total_records = 10;
			$total_pages = 0;
			$current_page = 1;
			$sortBy = !empty($data['sortBy'])?$data['sortBy']:null;
			$sortOrder = !empty($data['sortOrder'])?$data['sortOrder']:'desc';
			$search_term = !empty($data['search_term'])?trim($data['search_term']):Null;
			
			if($type == 'refund'){
				$refund 			= $refund->select('appointment_data.*','appointments.first_name','appointments.last_name','appointments.email');
				if(!empty($search_term)){
					$refund = $refund->where(function($query) use($search_term){
						$query->whereRaw('concat(appointments.first_name," ",appointments.last_name) like ?', "%{$search_term}%")
								->orWhere(DB::raw('CONVERT(appointments.order_id, SIGNED)'), 'like', "%".str_replace("#",'',$search_term).'%')
								->orWhere(DB::raw('DATE_FORMAT(appointment_data.created_at, "%d %b, %Y (%a.) %H:%i")'), 'like', "%".$search_term.'%')
								->orWhere(DB::raw('DATE_FORMAT(appointment_data.updated_at, "%d %b, %Y (%a.) %H:%i")'), 'like', "%".$search_term.'%')
								->orWhere('appointment_data.price', '=',$search_term)
								->orWhere('appointment_data.refund_id', 'like',"%".$search_term.'%');
					});
				}
				if($sortBy  && $sortBy == 'refund_id'){
					$refund             = $refund->orderBy('appointment_data.refund_id',  $sortOrder);
				}
				if($sortBy  && $sortBy == 'transaction_date'){
					$refund             = $refund->orderBy('appointment_data.created_at',  $sortOrder);
				}
				if($sortBy  && $sortBy == 'refund_date'){
					$refund             = $refund->orderBy('appointment_data.updated_at',  $sortOrder);
				}
				if($sortBy  && $sortBy == 'refunded_amount'){
					$refund             = $refund->orderBy('appointment_data.price',  $sortOrder);
				}
				if($sortBy  && in_array($sortBy, ['name', 'first_name', 'last_name'])){
					$refund             = $refund->orderBy('appointments.first_name',  $sortOrder);
				}
				if(empty($sortBy)){
					$refund             = $refund->orderBy('appointment_data.created_at',  'desc');
				}
				$refund             = $refund->paginate($per_page);
				foreach ($refund as $k=>$row) {
					$refundArr[$k]['id']    				= $row['id'];
					//$refundArr[$k]['order_id']    			= $row['order_id'];
					$refundArr[$k]['refund_id']    			= $row['refund_id'];
					$refundArr[$k]['appointment_id']    	= $row['appointment_id'];
					$refundArr[$k]['email']    				= $row['email'];
					$refundArr[$k]['first_name']    		= $row['first_name'];
					$refundArr[$k]['last_name']    			= $row['last_name'];
					$refundArr[$k]['user_name']    			= $row['first_name'].' '.$row['last_name'];
					$refundArr[$k]['transaction_date']     	= \Carbon\Carbon::parse($row['created_at'])->translatedFormat('d M, Y (D) H:i');
					$refundArr[$k]['refund_date']     		= \Carbon\Carbon::parse($row['updated_at'])->translatedFormat('d M, Y (D) H:i');
					$refundArr[$k]['refunded_amount']   	= number_format($row['price'],2);
					$refundArr[$k]['user_image']   			= NULL;
					if(file_exists(storage_path('app/public/user/'.\BaseFunction::getUserProfile($row['email']))) && \BaseFunction::getUserProfile($row['email']) != ''){
						$refundArr[$k]['user_image']   		= url('storage/app/public/user/'.\BaseFunction::getUserProfile($row['email']));
					}
				}
				$total_records 	= $refund->total();
				$current_page 	= $refund->currentPage();
				$total_pages 	= $refund->lastPage();
			}elseif($type == 'withdraw'){
				if(!empty($search_term)){
					$withdraw = $withdraw->where(function($query) use($search_term){
						$query->where('status', 'like', "%".$search_term.'%')
								->orWhere('amount', '=', $search_term);
					});
				}
				if($sortBy  && $sortBy == 'transaction_id'){
					$withdraw             = $withdraw->orderBy('transaction_id', $sortOrder);
				}
				
				if($sortBy  && $sortBy == 'transaction_date'){
					$withdraw             = $withdraw->orderBy('created_at',  $sortOrder);
				}
				if($sortBy  && $sortBy == 'status'){
					$withdraw             = $withdraw->orderBy('status',  $sortOrder);
				}
				if($sortBy  && $sortBy == 'amount'){
					$withdraw             = $withdraw->orderBy('amount',  $sortOrder);
				}
				if(empty($sortBy)){
					$withdraw             = $withdraw->orderBy('created_at',  'desc');
				}
				$withdraw 			= $withdraw->paginate($per_page);
				foreach ($withdraw as $k=>$row) {
					$withdrawlArr[$k]['transaction_id']    	= $row['transaction_id'];
					$withdrawlArr[$k]['status']    			= $row['status'];
					$withdrawlArr[$k]['transaction_date']   = \Carbon\Carbon::parse($row['created_at'])->translatedFormat('d M, Y (D) H:i');
					$withdrawlArr[$k]['amount']   			= number_format($row['amount'],2);
				}
				$total_records 	= $withdraw->total();
				$current_page 	= $withdraw->currentPage();
				$total_pages 	= $withdraw->lastPage();
			}else{
				$transaction 		= $transaction->select('appointment_data.*',DB::raw('DATE_FORMAT(appointment_data.created_at, "%d %b, %Y (%a.) %H:%i") as test_date'), 'payment_method_infos.status as payment_status','appointment_data.price as total_amount','appointments.first_name','appointments.last_name','appointments.email','appointments.order_id','payment_method_infos.payment_id');
				if(!empty($search_term)){
					if($search_term == 'erfolgreich'){
						$transaction = $transaction->where(function($query) use($search_term){
						$query->where('payment_method_infos.status', 'succeeded')->orWhereNotIn('appointment_data.status', ['cancel']); });
					}elseif($search_term == 'fehlgeschlagen'){
						$transaction = $transaction->where('payment_method_infos.status', 'failed');
					}elseif($search_term == 'rückerstattet'){
						$transaction = $transaction->where('appointment_data.status', 'cancel');
					}elseif(strpos(str_replace("#",'',strtolower($search_term)), 'vor') !== false){
						$transaction = $transaction->where('payment_method_infos.payment_id', 'Cash');
					}else{
						$transaction = $transaction->where(function($query) use($search_term){
							$query->where(DB::raw('CONVERT(appointments.order_id, SIGNED)'), 'like', "%".str_replace("#",'',$search_term).'%')
									->orWhere('payment_method_infos.payment_id', 'like', "%".str_replace("#",'',$search_term).'%')
									->orWhereRaw('concat(appointments.first_name," ",appointments.last_name) like ?', "%{$search_term}%")
									->orWhere(DB::raw('DATE_FORMAT(appointment_data.created_at, "%d %b, %Y (%a.) %H:%i")'), 'like', "%".$search_term.'%')
									->orWhere(DB::raw("REPLACE(REPLACE(REPLACE(FORMAT(appointment_data.price,2), ',', ':'), '.', ','), ':', '.')"), 'like', "%".str_replace("€",'',$search_term).'%')
									->orWhere('payment_method_infos.status', '=',"%".$search_term.'%');
						});
					}
				}
				if($sortBy  && $sortBy == 'order_id'){
					$transaction             = $transaction->orderByRaw('CONVERT(appointments.order_id, SIGNED) '.$sortOrder);
				}
				if($sortBy  && $sortBy == 'payment_status'){
					$transaction             = $transaction->orderBy('payment_method_infos.status',  $sortOrder);
				}
				if($sortBy  && $sortBy == 'transaction_date'){
					$transaction             = $transaction->orderBy('appointment_data.created_at',  $sortOrder);
				}
				
				if($sortBy  && $sortBy == 'total_amount'){
					$transaction             = $transaction->orderBy('appointment_data.price',  $sortOrder);
				}
				if($sortBy  && in_array($sortBy, ['name', 'first_name', 'last_name'])){
					$transaction             = $transaction->orderBy('appointments.first_name',  $sortOrder);
				}
				
				if(empty($sortBy)){
					$transaction             = $transaction->orderBy('appointment_data.created_at',  'desc');
				}
				
				$transaction 		= $transaction->paginate($per_page);
				foreach ($transaction as $k=>$row) {
					$transactionArr[$k]['id']    				= $row['id'];
					$transactionArr[$k]['order_id']    			= $row['order_id'];
					$transactionArr[$k]['appointment_id']    	= $row['appointment_id'];
					$transactionArr[$k]['email']    			= $row['email'];
					$transactionArr[$k]['first_name']    		= $row['first_name'];
					$transactionArr[$k]['payment_status']    		= $row['payment_status'];
					$transactionArr[$k]['last_name']    		= $row['last_name'];
					$transactionArr[$k]['user_name']    		= $row['first_name'].' '.$row['last_name'];
					$transactionArr[$k]['transaction_date']     = \Carbon\Carbon::parse($row['created_at'])->translatedFormat('d M, Y (D) H:i');
					$transactionArr[$k]['payment_status_german']    	= $row->payment_status == 'succeeded' ? 'erfolgreich' : ($row->payment_status == 'failed' ? 'fehlgeschlagen' :($row->status == 'cancel'?'rückerstattet ':'erfolgreich '));
					$transactionArr[$k]['payment_status_color']    	= $row->payment_status == 'succeeded' ? '#56C156' : ($row->payment_status == 'failed' ? '#ff3d3d' :($row->status == 'cancel'?'#FF8151':'#56C156'));
					$transactionArr[$k]['payment_id']   		= $row['payment_id'] == 'Cash' ? 'vor Ort' : $row->payment_id;
					$transactionArr[$k]['total_amount']   		= number_format(str_replace(",", '', $row['total_amount']),2);
					$transactionArr[$k]['user_image']   				= NULL;
					if(file_exists(storage_path('app/public/user/'.\BaseFunction::getUserProfile($row['email']))) && \BaseFunction::getUserProfile($row['email']) != ''){
						$transactionArr[$k]['user_image']   		= url('storage/app/public/user/'.\BaseFunction::getUserProfile($row['email']));
					}
				}
				$total_records 	= $transaction->total();
				$current_page 	= $transaction->currentPage();
				$total_pages 	= $transaction->lastPage();
			}
            
            $data = [
                'netEarning'       => number_format($netEarning,2, ',', '.'),
                'withdrawnBalance' => number_format($withdrwalBalance,2, ',', '.'),
                'availableBalance'  => number_format($availableBalance,2, ',', '.'),
                'refundedBalance'  => number_format($refundableBalance,2, ',', '.'),
				'totalEarning'     => number_format($todayEarning,2, ',', '.'),
                'statistics'       => NULL,
                'allTransaction'   => $transactionArr,
                'refunds'   	   => $refundArr,
                'withdrwals'   	   => $withdrawlArr,
                'totalRecords'     => $total_records,
				'currentPage'     => $current_page,
				'totalPages'     => $total_pages

            ];
            return response()->json(['ResponseCode' => 1, 'ResponseText' => "MyWallet Successfully", 'data' => $data], 200);
        } catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
    }
}
