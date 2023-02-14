<?php

namespace App\Http\Controllers;

use App\SelesStaffDetails;
use Illuminate\Http\Request;

class SelesStaffDetailsController extends Controller
{
    public function salesadd(Request $request)
    {

        $id = session()->get('USER_ID');
        if ($id == '') {
            return redirect('/');
        }
        $store = SelesStaffDetails::where('store_id', $id)->first();

        if (empty($store)) {
            $store = new SelesStaffDetails();
        } else {
            $store = SelesStaffDetails::where('store_id', $id)->first();
        }
        $store->store_id = $id;
        $store->firstname = $request->firstname;
        $store->lastname = $request->lastname;
        $store->Staff_id_no = $request->Staff_id_no;
        $store->save();

    }
}
