<?php

namespace App\Http\Controllers;

use App\BankDetails;
use App\Extraservice;
use App\Hardware;
use App\Storedetails;
use App\Marketing;
use Illuminate\Http\Request;
use DB;

class ContactController extends Controller
{

    public function contact()
    {
        $id = session()->get('USER_ID');
        if($id == ''){
            return redirect('/');
        }
        $storedetails = Storedetails::where('id', $id)->first();
        $bankdetails = BankDetails::where('store_id', $id)->first();
        $extraservice = Extraservice::where('store_id', $id)->get();
        $marketing = Marketing::where('store_id', $id)->get();
        $hardware = Hardware::where('store_id', $id)->get();
//dd($extraservice);
        return view('contact', compact('storedetails', 'bankdetails', 'extraservice', 'marketing','hardware'));
    }

    public function contact_details()
    {
        return view('contact_details.contact_details');
    }

    public function store(Request $request)
    {
        $contact = new Storedetails();
        $contact->storename = $request->storename;
        $contact->firstname = $request->firstname;
        $contact->Lastname = $request->Lastname;
        $contact->Email = $request->Email;
        $contact->Phone = $request->Phone;
        $contact->Address = $request->Address;
        $contact->District = $request->District;
        $contact->Country = $request->Country;
        $contact->Zipcode = $request->Zipcode;
        $contact->Plan = $request->Plan;
        $contact->Actual_plan = $request->Actual_plan;
        $contact->Contract_Start_Date = $request->Contract_Start_Date;
        $contact->Contact_end_date = $request->Contact_end_date;
        $contact->Payment_terms = $request->Payment_terms;
        if ($contact->save()) {
            $request->session()->put('USER_ID', $contact->id);
            return redirect('/recom-plan');
        } else {
            $request->session()->flash('error', 'please enter all field');
            return redirect('/contactdetail');
        }

    }


    public function adduser(Request $request)
    {
        $request->all();
    }

    public function recom_plan_store(Request $request)
    {
        $id = session()->get('USER_ID');
        if($id == ''){
            return redirect('/');
        }
        $store = Storedetails::find($id);
        $store->plan = $request->plan_type;
        $store->Actual_plan = $request->plan;
        $store->plan_amount = $request->amount;
        $store->save();
        if ($store->save()) {

            return redirect('recom-plan');
        } else {
            $request->session()->flash('error', 'please enter all field');
            return redirect('services');
        }
    }

    public function paymentmethod(Request $request)
    {
        $id = session()->get('USER_ID');
        if($id == ''){
            return redirect('/');
        }
        $store = Storedetails::find($id);
        $store->Payment_terms = $request->Payment_terms;
        $store->save();
        if ($store->save()) {
            return redirect('finance');
        } else {
            $request->session()->flash('error', 'please enter all field');
            return redirect('payment');
        }
    }


    public function duration_contract_store(Request $request)
    {
        
        $id = session()->get('USER_ID');
        if($id == ''){
            return redirect('/');
        }
        $store = Storedetails::find($id);
        $store->Contract_Start_Date = $request->start_date;
        $store->Contact_end_date = $request->end_date;
        $store->save();
        if ($store->save()) {
            return ['status' => 'true', 'data' => ''];
        } else {
            $request->session()->flash('error', 'please enter all field');
            return ['status' => 'false', 'data' => ''];
        }

    }

    public function editcontactdetails()
    {
        $id = session()->get('USER_ID');
        if($id == ''){
            return redirect('/');
        }
        $contactdetails = Storedetails::where('id', $id)->first();
        return view('contact_details.contact_details_edit', compact('contactdetails'));
    }

    public function updatecontactdetails(Request $request, $id)
    {
        $user_id = session()->get('USER_ID');
        if($user_id == ''){
            return redirect('/');
        }
        $store = Storedetails::find($id);
        $store->storename = $request->storename;
        $store->firstname = $request->firstname;
        $store->Lastname = $request->Lastname;
        $store->Email = $request->Email;
        $store->Phone = $request->Phone;
        $store->Address = $request->Address;
        $store->District = $request->District;
        $store->Country = $request->Country;
        $store->Zipcode = $request->Zipcode;
        $store->save();
        if ($store->save()) {
            return redirect('contact');
        }

    }

    public function payment()
    {
        return view('payment.payment');
    }

    public function paymentedit()
    {
        $id = session()->get('USER_ID');
        if($id == ''){
            return redirect('/');
        }
        $contactdetails = Storedetails::where('id', $id)->first();
        $payment_data = DB::table('tbl_store_detail')->select('id', 'Payment_terms')->where('id', $id)->first();
        // dd($payment_data);
        return view('payment.payment_edit', compact('contactdetails', 'payment_data'));
    }

    public function paymentupdate(Request $request, $id)
    {
        $user_id = session()->get('USER_ID');
        if($user_id == ''){
            return redirect('/');
        }
        $store = Storedetails::find($id);
        $store->Payment_terms = $request->Payment_terms;
        if ($store->save()) {
            return ['status' => 'true', 'data' => ''];
        }

    }

    public function contract()
    {
        return view("contract.contract");
    }

    public function contractedit()
    {
        $id = session()->get('USER_ID');
        if($id == ''){
            return redirect('/');
        }
        $contactdetails = Storedetails::where('id', $id)->first();
        return view("contract.contract_edit", compact('contactdetails'));
    }

    public function contractupdate(Request $request, $id)
    {
        
        $user_id = session()->get('USER_ID');
        if($user_id == ''){
            return redirect('/');
        }
        $store = Storedetails::find($id);
        $store->Contract_Start_Date = $request->start_date;
        $store->Contact_end_date = $request->end_date;
        if ($store->save()) {
            return ['status' => 'true', 'data' => ''];
        }
    }

    public function plan()
    {
        return view("plan.plan");

    }

    public function planedit()
    {
        $id = session()->get('USER_ID');
        if($id == ''){
            return redirect('/');
        }
        $contactdetails = Storedetails::where('id', $id)->first();
        return view("plan.plan_edit", compact('contactdetails'));
    }

    public function planupdate(Request $request, $id)
    {
        $user_id = session()->get('USER_ID');
        if($user_id == ''){
            return redirect('/');
        }
        $store = Storedetails::find($user_id);
        $store->plan = $request->plan_type;
        $store->Actual_plan = $request->plan;
        $store->plan_amount = $request->amount;
        if ($store->save()) {
            return ['status' => 'true', 'data' => ''];
        }
    }

    public function salesadd(Request $request)
    {
        $user_id = session()->get('USER_ID');
        if($user_id == ''){
            return redirect('/');
        }
        $store = Storedetails::find($user_id);
        $store->b2bdate = \Carbon\Carbon::parse($request->b2bdate)->format('Y-m-d');
        $store->place = $request->place;
        $store->save();

    }
    public function done()
    {
        return view('done');
    }
}
