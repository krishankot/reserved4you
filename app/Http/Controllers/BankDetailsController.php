<?php

namespace App\Http\Controllers;

use App\BankDetails;
use Illuminate\Http\Request;

class BankDetailsController extends Controller
{

    public function finance()
    {
        return view('finance.finance');
    }

    public function Bankadd(Request $request)
    {
        $id = session()->get('USER_ID');
        if ($id == '') {
            return redirect('/');
        }
        $store = BankDetails::where('store_id', $id)->first();
        if ($id == '') {
            return redirect('/');
        }
        if (empty($store)) {
            $store = new BankDetails();
        } else {
            $store = BankDetails::where('store_id', $id)->first();
        }
        $store->store_id = $id;
        $store->Account_holder = $request->Account_holder;
        $store->Bank_code = $request->Bank_code;
        $store->Iban = $request->Iban;
        $store->Invoice_method = $request->Invoice_method;
        $store->save();
        if ($store->save()) {
            return redirect('sales/staff');
        } else {

        }


    }

    public function edit(Request $request, $id)
    {
        $id = session()->get('USER_ID');
        if ($id == '') {
            return redirect('/');
        }
        $bankdetails = BankDetails::where('store_id', $id)->first();
        return view('finance.finance_edit', compact('bankdetails'));

    }

    public function update(Request $request, $id)
    {

        $user_id = session()->get('USER_ID');
        if ($user_id == '') {
            return redirect('/');
        }
        $store = BankDetails::find($id);
        $store->store_id = $user_id;
        $store->Account_holder = $request->Account_holder;
        $store->Bank_code = $request->Bank_code;
        $store->Iban = $request->Iban;
        $store->Invoice_method = $request->Invoice_method;
        if ($store->save()) {
            return ['status' => 'true', 'data' => ''];
        }

    }


}
