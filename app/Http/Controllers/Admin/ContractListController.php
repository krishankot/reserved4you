<?php

namespace App\Http\Controllers\Admin;

use App\Models\Contract\Hardware;
use App\Models\BecomePartner;
use App\Models\Contract\Extraservice;
use App\Models\Contract\Marketing;
use App\Models\Contract\BankDetails;
use App\Http\Controllers\Controller;
use App\Models\Contract\StoreDetails;
use App\Models\Contract\SelesStaffDetails;
use Illuminate\Http\Request;

class ContractListController extends Controller
{
    public function index()
    {
        $storedetails = StoreDetails::orderBy('id', 'desc')->get();
        foreach ($storedetails as $key) {
            $key->salesStaff = SelesStaffDetails::where('store_id', $key->id)->first();
        }

        return view('Admin.Contract.index', compact('storedetails'));
    }

    public function show($id)
    {

        $storedetails = StoreDetails::where('id', $id)->first();

        $extraservice = Extraservice::where('store_id', $id)->get();
        $marketing = Marketing::where('store_id', $id)->get();
        $hardware = Hardware::where('store_id', $id)->get();
        $bankdetails = BankDetails::where('store_id', $id)->first();
        $salesStaff = SelesStaffDetails::where('store_id', $id)->first();


        return view('Admin.Contract.view', compact('storedetails', 'extraservice', 'marketing', 'bankdetails','hardware','salesStaff'));
    }

    public function partnerList()
    {
        $data = BecomePartner::orderBy('id','desc')->get();
        return view ('Admin.BusinessPartner.index',compact('data'));
    }
}
