<?php

namespace App\Http\Controllers\ServiceProvider;

use Auth;
use Hash;
use App\Models\User;
use App\Models\Invoice;
use App\Models\Contactus;
use App\Models\Appointment;
use App\Models\InvoiceBill;
use App\Models\StoreProfile;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use App\Models\AppointmentData;
use App\Models\InvoiceReminder;
use App\Models\Contract\Hardware;
use App\Models\PaymentMethodInfo;
use App\Models\Contract\Marketing;
use App\Http\Controllers\Controller;
use App\Models\Contract\BankDetails;
use App\Models\Contract\Extraservice;
use App\Models\Contract\StoreDetails;
use Illuminate\Support\Facades\Session;

class SettingController extends Controller
{
    public function index(){
        $store_id = session('store_id');

        if(empty($store_id)){
            $getStore = StoreProfile::where('user_id', Auth::user()->id)->pluck('id')->all();
        } else{
            $getStore = StoreProfile::where('user_id', Auth::user()->id)->where('id',$store_id)->pluck('id')->all();
        }
        $plans = [];
        foreach ($getStore as $store) {

            $plans[] = StoreProfile::where('store_profiles.id', $store)
                ->leftjoin('plans', 'plans.slug_actual_plan', '=', 'store_profiles.store_active_actual_plan')
                ->select(['store_profiles.id', 'store_name', 'store_active_actual_plan', 'store_active_plan', 'plans.plan_name', 'plans.price'])
                ->first();
        }
        $allPaymentUsers = PaymentMethodInfo::whereIn('store_id', $getStore)->whereNotNull('user_id')->distinct()->pluck('user_id')->all();

        $paymentDetail = PaymentMethod::whereIn('user_id', $allPaymentUsers)
            ->whereNotNull('user_id')
            ->get();

        $extraService = [];
        $hardware = [];
        $marketing = [];
        $bankdetails = [];
        $invoice = [];
        $invoices = [];

        $stores = StoreProfile::whereIn('id', $getStore)->get();
        foreach ($stores as $key => $store) { 
            $contract = StoreDetails::where('cin', $store->contract_number)->first();
            if ($contract) {
                $extraService[$store->store_name] = Extraservice::where('store_id', $contract->id)->where('status', 'active')->get();
                $hardware[$store->store_name] = Hardware::where('store_id', $contract->id)->where('status', 'active')->get();
                $marketing[$store->store_name] = Marketing::where('store_id', $contract->id)->where('status', 'active')->get();
                $bankdetails[$store->store_name] = BankDetails::where('store_id', $contract->id)->first();
    
                $invoice = Invoice::where('contract_id', $contract->id)->first();

                $invoices[$store->store_name] = InvoiceBill::where('invoice_id', $invoice->id)->with('details', 'reminders')->orderBy('id','desc')->get()->groupBy('invoice_number');
                // $invoices[$store->store_name] = InvoiceBill::where('status', '!=', 'cancelled')->where('invoice_id', $invoice->id)->with('details')->get();
                // $invoice_numbers = InvoiceBill::where('invoice_id', $invoice->id)->pluck('invoice_number')->all();
                // $invoice_numbers = array_unique($invoice_numbers);
                // foreach ($invoice_numbers as $value) {
                //     $allInvoices = InvoiceBill::where('invoice_number', $value)->latest()->first();
                //     $invoices[$store->store_name][] = $allInvoices;
                // }
            }
        }

        
        return view('ServiceProvider.Setting.index', compact('plans', 'getStore', 'extraService', 'hardware', 'marketing', 'bankdetails', 'paymentDetail', 'invoices'));

        if(request('admin') != 'yes') {

            // return view('ServiceProvider.Setting.index-21-1-2022', compact('plans', 'getStore', 'extraService', 'paymentDetail', 'invoices'));
        }
        
    }

    public function changePassword(Request $request){
        $this->validate($request, [
            'old_password' => 'required',
            'new_password' => 'required',
            'confirm_password' => 'required|same:new_password',
        ]);

        $checkvalidation = User::where('id', Auth::user()->id)->first();
        if (Hash::check($request->get('old_password'), $checkvalidation->password)) {
            $data['password'] = Hash::make($request->get('new_password'));
            $update = User::where('id', Auth::user()->id)->update($data);
            if ($update) {
                Session::flash('message','<div class="alert alert-success">Password Changed Successfully.!! </div>');
                return redirect('dienstleister/einstellungen');
            }
        } else {
            return redirect()->back()
                ->withErrors(['old_password' => 'Password does not match. Please try again.']);
        }
    }

    public function contactUs(Request $request){
        $data = $request->all();
        $data['user_id'] = Auth::user()->id;

        $message = new Contactus();
        $message->fill($data);
        if($message->save()){
            Session::flash('message','<div class="alert alert-success">Message Sent Successfully.!! </div>');
            return redirect('dienstleister/einstellungen');
        }
    }

    public function downloadInvoice($id, $number, $viewtype = null) {
        // $items = InvoiceBill::where('status', '!=', 'cancelled')->where('invoice_number', $id)->with('details')->first();
        $items = InvoiceBill::where(['id'=>$id], ['invoice_number'=> $number])->with('details')->first();
        
        if (empty($items)) return redirect()->back();
        $reminders = InvoiceReminder::where('bill_id', $items->id)->get();
        $data = Invoice::where('id', $items->invoice_id)->with('contract')->first();
        $store = StoreProfile::where('contract_number', $data->contract->cin)->first();

        $bankdetails = BankDetails::where('store_id', $data->contract_id)->first();

        return view('ServiceProvider.pdf.invoice', compact('data', 'items', 'reminders', 'store', 'bankdetails', 'viewtype' ));
    }
    
    public function downloadPayout($id, $number, $viewtype = null) {

        $items = InvoiceBill::where('id', $id)->with('details')->first();
        if (empty($items)) return redirect()->back();

        $data = Invoice::where('id', $items->invoice_id)->with('contract')->first();
        $store = StoreProfile::where('contract_number', $data->contract->cin)->first();
        $bankdetails = BankDetails::where('store_id', $data->contract_id)->first();

        $allBookings = AppointmentData::whereIn('id', $items->booking_ids)->where('status', 'completed')->get();

        $i = 0;
        $j = 1;
        foreach ($allBookings as $key => $row) {
            if ($i == 22) {
                $j++;
                $i = 0;
            }
            $bookings[$j][] = $row;
            $i++;
        }
        
        $totalBooking = $allBookings->sum('price');

        return view('ServiceProvider.pdf.payout', compact('data', 'items', 'store', 'bankdetails', 'bookings', 'totalBooking' ));

    }
}
