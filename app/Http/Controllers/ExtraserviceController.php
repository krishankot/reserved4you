<?php

namespace App\Http\Controllers;

use App\Extraservice;
use App\Hardware;
use App\Marketing;
use Illuminate\Http\Request;

class ExtraserviceController extends Controller
{
    public function extra_service_store(Request $request)
    {

        $id = session()->get('USER_ID');
        if($id == ''){
            return redirect('/');
        }

        
        $f_service = $request['feature_plan'];
        $f_plantype = $request['feature_plan_type'];
        $f_amount = $request['feature_amount'];

        $m_service = $request['marketing_plan'];
        $m_plantype = $request['marketing_plan_type'];
        $m_amount = $request['marketing_amount'];

        $h_service = $request['hardware_plan'];
        $h_plantype = $request['hardware_plan_type'];
        $h_amount = $request['hardware_amount'];


        if(isset($request['feature_plan']) && count($f_service)>0){
            $extraservice = Extraservice::where('store_id', $id)->delete();

            for($i=0;$i<count($f_service);$i++){
                $fdata['store_id'] = $id;
                $fdata['Service_name'] = 'Features';
                $fdata['Service_plan'] = $f_service[$i];
                $fdata['plan_type'] = $f_plantype[$i];
                $fdata['Service_amount'] = $f_amount[$i];

                $featureData = new Extraservice();
                $featureData->fill($fdata);
                $featureData->save();
            }
        }

        if(isset($request['marketing_plan']) && count($m_service)>0){
            $marketingservice = Marketing::where('store_id', $id)->delete();

            for($i=0;$i<count($m_service);$i++){
                $mdata['store_id'] = $id;
                $mdata['Service_name'] = 'Marketing';
                $mdata['Service_plan'] = $m_service[$i];
                $mdata['plan_type'] = $m_plantype[$i];
                $mdata['Service_amount'] = $m_amount[$i];

                $marketingData = new Marketing();
                $marketingData->fill($mdata);
                $marketingData->save();
            }
        }

        if(isset($request['hardware_plan']) && count($h_service)>0){
            $hardwareservice = Hardware::where('store_id', $id)->delete();

            for($i=0;$i<count($h_service);$i++){
                $hdata['store_id'] = $id;
                $hdata['Service_name'] = 'Hardware';
                $hdata['Service_plan'] = $h_service[$i];
                $hdata['plan_type'] = $h_plantype[$i];
                $hdata['Service_amount'] = $h_amount[$i];

                $HardwareData = new Hardware();
                $HardwareData->fill($hdata);
                $HardwareData->save();
            }
        }

        return ['status' => 'true', 'data' => ''];


    }

    public function services()
    {
        return view('services.services');
    }

    public function extraservices()
    {
        $id = session()->get('USER_ID');
        if($id == ''){
            return redirect('/');
        }
        $extraservice = Extraservice::where('store_id', $id)->get();
        $marketing = Marketing::where('store_id', $id)->get();
        $hardware = Hardware::where('store_id', $id)->get();

        return view("services.services_edit", compact('extraservice', 'marketing','id','hardware'));

    }

    public function servicesupdate(Request $request, $id)
    {


        $id = session()->get('USER_ID');
        if($id == ''){
            return redirect('/');
        }

        if(empty($request->all())){
           $extraservice = Extraservice::where('store_id', $id)->delete();
           $marketingservice = Marketing::where('store_id', $id)->delete();
            $hardwareservice = Hardware::where('store_id', $id)->delete();
        }


        $extraservice = Extraservice::where('store_id', $id)->first();
        $marketingservice = Marketing::where('store_id', $id)->first();

        $f_service = $request['feature_plan'];
        $f_plantype = $request['feature_plan_type'];
        $f_amount = $request['feature_amount'];

        $m_service = $request['marketing_plan'];
        $m_plantype = $request['marketing_plan_type'];
        $m_amount = $request['marketing_amount'];

        $h_service = $request['hardware_plan'];
        $h_plantype = $request['hardware_plan_type'];
        $h_amount = $request['hardware_amount'];

        if(!isset($request['feature_plan']) && empty($f_service)){
            $extraservice = Extraservice::where('store_id', $id)->delete();
        }

        if(isset($request['feature_plan']) && count($f_service)>0){
            $extraservice = Extraservice::where('store_id', $id)->delete();

            for($i=0;$i<count($f_service);$i++){
                $fdata['store_id'] = $id;
                $fdata['Service_name'] = 'Features';
                $fdata['Service_plan'] = $f_service[$i];
                $fdata['plan_type'] = $f_plantype[$i];
                $fdata['Service_amount'] = $f_amount[$i];

                $featureData = new Extraservice();
                $featureData->fill($fdata);
                $featureData->save();
            }
        }


        if(!isset($request['marketing_plan']) && empty($marketing_plan)){
            $marketingservice = Marketing::where('store_id', $id)->delete();
        }


        if(isset($request['marketing_plan']) && count($marketing_plan)>0){
            $marketingservice = Marketing::where('store_id', $id)->delete();

            for($i=0;$i<count($m_service);$i++){
                $mdata['store_id'] = $id;
                $mdata['Service_name'] = 'Marketing';
                $mdata['Service_plan'] = $m_service[$i];
                $mdata['plan_type'] = $m_plantype[$i];
                $mdata['Service_amount'] = $m_amount[$i];

                $marketingData = new Marketing();
                $marketingData->fill($mdata);
                $marketingData->save();
            }
        }

        if(!isset($request['hardware_plan']) && empty($h_service)){
            $hardwareservice = Hardware::where('store_id', $id)->delete();
        }
        

        if(isset($request['hardware_plan']) && count($h_service)>0){
            $hardwareservice = Hardware::where('store_id', $id)->delete();

            for($i=0;$i<count($h_service);$i++){
                $hdata['store_id'] = $id;
                $hdata['Service_name'] = 'Hardware';
                $hdata['Service_plan'] = $h_service[$i];
                $hdata['plan_type'] = $h_plantype[$i];
                $hdata['Service_amount'] = $h_amount[$i];

                $HardwareData = new Hardware();
                $HardwareData->fill($hdata);
                $HardwareData->save();
            }
        }

        return ['status' => 'true', 'data' => ''];
    }

    public function removeService(Request $request){
        $value = $request['name'];
        $id = $request['id'];
        if($value == 'feature'){
            $remove = Extraservice::where('id',$id)->delete();
        }

        if($value == 'marketing'){
            $remove = Marketing::where('id',$id)->delete();
        }

        if($value == 'hardware'){
            $remove = Hardware::where('id',$id)->delete();
        }
        return ['status' => 'true', 'data' => ''];
    }
}
