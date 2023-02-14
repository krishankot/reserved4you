<?php

namespace App\Http\Controllers\Api\ServiceProvider\Setting;

use App\Models\User;
use App\Models\Invoice;
use App\Models\Contactus;
use App\Models\InvoiceBill;
use App\Models\Appointment;
use App\Models\StoreProfile;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use App\Models\InvoiceReminder;
use App\Models\Contract\Hardware;
use App\Models\PaymentMethodInfo;
use App\Models\Contract\Marketing;
use App\Http\Controllers\Controller;
use App\Models\Contract\BankDetails;
use App\Models\Contract\Extraservice;
use App\Models\Contract\StoreDetails;

use Illuminate\Support\Facades\Session;
use Auth;
use Hash;

class SettingController extends Controller
{
    public function contactInfo(Request $request){
		try{
			$data = array("phone" => "+49 30 1663969318", "email" => "b2b.support@reserved4you.de");
			return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Successful', 'ResponseData' => $data], 200);
		}catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
    }
	
	 public function keys(Request $request){
		$data = request()->all();
		
		try{
			//$stripekey  =  "pk_test_pyAji6er6sj1KeM06MlYOTsy00dkDuHTU2"; //env('STRIPE_PUB_KEY');
			$stripekey  =  env('STRIPE_PUB_KEY');
			$data = array("stripe_pk" => $stripekey);
			return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Successful', 'ResponseData' => $data], 200);
		}catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
    }

	
	 public function help(Request $request){
		try{
			$data = array();
			$data[0] = [
						    'title' => 'How to # 0 Login',
							'poster' =>  url('storage/app/public/Serviceassets/videos/banner.png'),
							'video' =>  url('storage/app/public/Serviceassets/videos/Login.mp4')
						];
			$data[1] = [
						    'title' => 'How to # 1 Dashboard',
							'poster' =>  url('storage/app/public/Serviceassets/videos/banner.png'),
							'video' =>  url('storage/app/public/Serviceassets/videos/Dashboard.mp4')
						];
			$data[2] = [
						    'title' => 'How to # 2 Kalender',
							'poster' =>  url('storage/app/public/Serviceassets/videos/banner.png'),
							'video' =>  url('storage/app/public/Serviceassets/videos/Kalender.mp4')
						];
			$data[3] = [
						    'title' => 'How to # 3 Buchungen',
							'poster' =>  url('storage/app/public/Serviceassets/videos/banner.png'),
							'video' =>  url('storage/app/public/Serviceassets/videos/Buchungen.mp4')
						];
						
			$data[4] = [
						    'title' => 'How to # 4 Kunden',
							'poster' =>  url('storage/app/public/Serviceassets/videos/banner.png'),
							'video' =>  url('storage/app/public/Serviceassets/videos/Kunden.mp4')
						];
			$data[5] = [
						    'title' => 'How to # 5 Mitarbeiter',
							'poster' =>  url('storage/app/public/Serviceassets/videos/banner.png'),
							'video' =>  url('storage/app/public/Serviceassets/videos/Mitarbeiter.mp4')
						];
			$data[6] = [
						    'title' => 'How to # 6 Betriebsprofil',
							'poster' =>  url('storage/app/public/Serviceassets/videos/banner.png'),
							'video' =>  url('storage/app/public/Serviceassets/videos/Betriebsprofil.mp4')
						];
			$data[7] = [
						    'title' => 'How to # 7 Statistiken',
							'poster' =>  url('storage/app/public/Serviceassets/videos/banner.png'),
							'video' =>  url('storage/app/public/Serviceassets/videos/Statistiken.mp4')
						];
			$data[8] = [
						    'title' => 'How to # 8 Finanzen',
							'poster' =>  url('storage/app/public/Serviceassets/videos/banner.png'),
							'video' =>  url('storage/app/public/Serviceassets/videos/Finanzen.mp4')
						];
			$data[9] = [
						    'title' => 'How to # 9 Einstellungen',
							'poster' =>  url('storage/app/public/Serviceassets/videos/banner.png'),
							'video' =>  url('storage/app/public/Serviceassets/videos/Einstellungen.mp4')
						];
			
			return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Successful', 'ResponseData' => $data], 200);
		}catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
    }
	
	
	public function staticContent(Request $request){
		try{
			$data = request()->all();
			if(empty($data['page'])){
				return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Page not found', 'ResponseData' => null], 499);
			}
			$page  = $data['page'];
			$html = "";
			if($page == 'agb'){
				$html = view('Api/serviceProvider/AGB')->render();
			}
			if($page == 'datenschutz'){
				$html = view('Api/serviceProvider/datenschutz')->render();
			}
			
			return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Success.', 'ResponseData' => $html], 200);
		}catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
	}
	
	
	public function plans(Request $request){
		try{
			$data = request()->all();
			$userId  = $data['user']['user_id'];
            // $storeId = \BaseFunction::getStoreDetails($userId);
			if(empty($data['store_id'])) {
				$getStore = StoreProfile::where('user_id',$userId)->pluck('id')->all();
			} else {
				$getStore = StoreProfile::where('user_id', $userId)->where('id', $data['store_id'])->pluck('id')->all();
			}
			
			$plans = [];
			foreach ($getStore as $store) {
				$plans[] = StoreProfile::where('store_profiles.id', $store)
					->leftjoin('plans', 'plans.slug_actual_plan', '=', 'store_profiles.store_active_actual_plan')
					->select(['store_profiles.id', 'store_name', 'store_active_actual_plan', 'store_active_plan', 'plans.plan_name', 'plans.price'])
					->first();
			}
			
			foreach($plans as $plan){
				$plan->plan_time = (str_contains($plan->store_active_actual_plan, 'monthly'))?'Monthly Payment':'Annual Payment';
				$plan->price_str = (str_contains($plan->store_active_actual_plan, 'monthly'))?$plan->price.' /mo':$plan->price.' /yr';
			}
			
			$allPaymentUsers 	= PaymentMethodInfo::whereIn('store_id', $getStore)->whereNotNull('user_id')->distinct()->pluck('user_id')->all();
			$paymentDetail 		= PaymentMethod::whereIn('user_id', $allPaymentUsers)->whereNotNull('user_id')->get();
				
			foreach($paymentDetail as $row){
				$row->card_number  = substr($row->card_number, 0, 4)."  . . . .   . . . .  ". substr($row->card_number, -4, 4);
			}
			//$extraService 		= StoreProfile::whereIn('id', $getStore)->get(['store_name', 'is_recommended', 'is_discount']);
			
			$stores = StoreProfile::whereIn('id', $getStore)->get();
			$invoiceIds = array();
			$invoices = [];
			foreach ($stores as $key => $store) {  
				$contract = StoreDetails::where('cin', $store->contract_number)->first();
				if ($contract) {
					$extraServiceArr = Extraservice::where('store_id', $contract->id)->where('status', 'active')->get();
					foreach($extraServiceArr as $service){
						$service->icon = str_contains($service->Service_plan, 'Rabatte für Kunden')?url('storage/app/public/Serviceassets/images/icon/discount.svg'):url('storage/app/public/Serviceassets/images/icon/card.svg');
						$service->Service_amount_show = $service->Service_amount.((str_contains($service->Service_amount, '%') != false) ?  '' : '€').($service->plan_type != "onetime"?' /mo':'');
					}
					$store['extraService']  = $extraServiceArr;
					$extraService[$store->store_name] = $extraServiceArr; //Extraservice::where('store_id', $contract->id)->where('status', 'active')->get();
					$hardwareArr  = Hardware::where('store_id', $contract->id)->where('status', 'active')->get();
					foreach($hardwareArr as $service){
						$service->icon = url('storage/app/public/Serviceassets/images/icon/hardware-phone.svg');
						$service->Service_amount_show = $service->Service_amount.((str_contains($service->Service_amount, '%') != false) ?  '' : '€').($service->plan_type != "onetime"?' /mo':'');
					}
					$store['hardware']  = $hardwareArr;
					$hardware[$store->store_name] = $hardwareArr; //Hardware::where('store_id', $contract->id)->where('status', 'active')->get();
					$marketingArr  = Marketing::where('store_id', $contract->id)->where('status', 'active')->get();
					foreach($marketingArr as $service){
						$service->icon = url('storage/app/public/Serviceassets/images/icon/card.svg');
						$service->Service_amount_show = $service->Service_amount.((str_contains($service->Service_amount, '%') != false) ?  '' : '€').($service->plan_type != "onetime"?' /mo':'');
					}
					$store['marketing']  = $marketingArr;
					$marketing[$store->store_name] = $marketingArr; //Marketing::where('store_id', $contract->id)->where('status', 'active')->get();
					$store['bankdetails']  = $bankdetails[$store->store_name] = BankDetails::where('store_id', $contract->id)->first();
		
					$invoiceIds[] = Invoice::where('contract_id', $contract->id)->value('id');
					
				}else{
					$extraService = [];
					$hardware = [];
					$marketing = [];
					$bankdetails = [];
					$invoice = [];
					
				}
			}
			if($invoiceIds){
				$invoicesArr  = InvoiceBill::whereIn('invoice_id', $invoiceIds)->with('details', 'reminders')->orderBy('id','desc')->get()->groupBy('invoice_number');
					
				foreach ($invoicesArr as $allInvoices){
					if (count($allInvoices) > 0){
						foreach ($allInvoices as $row){
							$row->title_pdf = $row->title .'.pdf';
							$row->icon = url('storage/app/public/Serviceassets/images/icon/pdf-icon.svg');
							$row->date_of_invoice = \Carbon\Carbon::parse($row->created_at)->format('M d, Y');
							if ($row->bill_type == 'payout'){
								$row->downloadlink = route('payout.download', ['id' => $row->id, 'number' => $row->invoice_number, 'viewtype' => 'webview']);
							}else{
								$row->downloadlink = route('invoice.download', ['id'=>$row->id, 'number'=>$row->invoice_number, 'viewtype' => 'webview']);
							}
							
							$row->status_opacity = ".65";
							$row->status_color = "#101928";
							if ($row->status=="open"){
								$row->status_color = "#17a2b8";
							}elseif ($row->status == "cancelled"){
								$row->status_color = "#dc3545";
							}elseif ($row->status == "due"){
								$row->status_color = "#ffc107";
							}elseif ($row->status == "paid") {
								$row->status_color = "#28a745";
							}elseif ($row->status == "in arrears"){
								$row->status_color = "#cf25e3";
							}
							$invoices[]  = $row;
						}
					}
				}
			}
			
			
			/* foreach($plans as $ext){
				$ext->show_icon = str_contains($service->Service_plan, 'Rabatte für Kunden')?url('storage/app/public/Serviceassets/images/icon/discount.svg'):url('storage/app/public/Serviceassets/images/icon/card.svg');
				$plan->plan_price_str = (str_contains($plan->store_active_actual_plan, 'monthly'))?$plan->plan_price.' /mo':$plan->plan_price.' /yr';
			} */
			//$invoices = [];
			$data = [
						'plans' => $plans, 
						'stores' => $stores, 
						/* 'getStore' => $getStore,
						'hardware' => $hardware,
						'marketing' => $marketing,
						'bankdetails' => $bankdetails, */
						'paymentDetail' => $paymentDetail,
						'invoices' => $invoices
					];
			return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Success.', 'ResponseData' => $data], 200);
		}catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
	}
   
}
