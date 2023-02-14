<?php

namespace App\Http\Controllers\ServiceProvider;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\AppointmentData;
use App\Models\Customer;
use App\Models\CustomerRequest;
use App\Models\Service;
use App\Models\StoreProfile;
use App\Models\StoreRatingReview;
use App\Models\ApiSession;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CustomersImport;
use Auth;
use URL;
use File;


class CustomerController extends Controller
{
    public function index(){
        $store_id = session('store_id');

        if (empty($store_id)) {
            $getStore = StoreProfile::where('user_id', Auth::user()->id)->pluck('id')->all();
        } else {
            $getStore = StoreProfile::where('user_id', Auth::user()->id)->where('id', $store_id)->pluck('id')->all();
        }
		
		
        $getCustomers = Customer::whereIn('customers.store_id',$getStore)
            ->orderBy('customers.id','DESC')
            ->select('customers.name','customers.email','customers.phone_number','customers.address','customers.image','customers.id as c_id')
            ->get();
			
			//echo "<pre>"; print_r($getCustomers); die;
//        $getCustomers = Appointment::whereIn('store_id',$getStore)->orderBy('id','DESC')->get();

        $customersData = [];

        foreach ($getCustomers as $row){
            $customersData[$row->email][] = $row;
        }

        $customerData = [];

        foreach ($customersData as $item =>$row){
			$appointments  = Appointment::leftjoin('appointment_data', 'appointment_data.appointment_id', '=', 'appointments.id')
					->where('appointments.email', $item)->whereIn('appointments.store_id',$getStore)->whereNotIn('appointment_data.status', ['cancel'])->orderBy('appointment_data.created_at', 'DESC')->select('appointment_data.appo_date', 'appointment_data.appo_time','appointment_data.price','appointments.*')->get()->toArray();
            if(count($appointments) == 1){
                if(!empty($appointments[0]['id'])){
                    $booking = count($appointments);
                } else {
                    $booking = 0;
                }
            } else {
                $booking = count($appointments);
            }
			
			$last_appointment = !empty($appointments[0]['appo_date'])?$appointments[0]['appo_date']." ".date('H:i', strtotime($appointments[0]['appo_time'])):Null;
            $customerData[] = array(
                'name' => $row[0]['name'],
                'c_id' => $row[0]['c_id'],
                'email' => $item,
                'image' => $row[0]['image'],
                'phone_number' => $row[0]['phone_number'],
                'created_at' => $last_appointment,
                'total_booking'=>$booking,
                'total_payment'=>array_sum(array_column($appointments,'price')),
                'appointment_id'=>!empty($appointments[0]['id'])?$appointments[0]['id']:NULL
            );
        }

        return view('ServiceProvider.Customer.index',compact('customerData'));
    }

    public function view($id){
        $id = decrypt($id);


        $store_id = session('store_id');

        if (empty($store_id)) {
            $getStore = StoreProfile::where('user_id', Auth::user()->id)->pluck('id')->all();
        } else {
            $getStore = StoreProfile::where('user_id', Auth::user()->id)->where('id', $store_id)->pluck('id')->all();
        }

      
        $customerData = Appointment::where('id',$id)->first();


        if(!empty($customerData)){
           $customer = Customer::where('email',$customerData['email'])->first();
        } else {
            $customer = '';
        }


        if(!empty($customer)){
           // $getCustomers = Appointment::whereIn('store_id',$getStore)->where('email',$customer['email'])->orderBy('id','DESC')->get()->toArray();
            $getCustomers = Appointment::leftjoin('appointment_data', 'appointment_data.appointment_id', '=', 'appointments.id')
					->where('appointments.email', $customer['email'])->whereIn('appointments.store_id',$getStore)->whereNotIn('appointment_data.status', ['cancel'])->get()->toArray();
			
			
            $customerData['total_booking'] = count($getCustomers);
            $customerData['total_payment'] = array_sum(array_column($getCustomers,'price'));

            $appointment =  AppointmentData::leftjoin('appointments', 'appointments.id', '=', 'appointment_data.appointment_id')
                ->leftjoin('payment_method_infos', 'payment_method_infos.appoinment_id', '=', 'appointments.id')
                ->whereIn('appointment_data.store_id',$getStore)
                ->where('appointments.email',$customer['email'])
                ->select('appointment_data.*', 'payment_method_infos.status as payment_status','payment_method_infos.card_type as card_type','payment_method_infos.payment_method as payment_method',
                    'appointments.user_id','appointments.order_id','appointments.first_name','appointments.last_name')
                ->orderBy('appointment_data.appointment_id','DESC')
                ->get();
            foreach ($appointment as $row) {
                if ($row->status == 'completed') {
                    $checkReview = StoreRatingReview::where('appointment_id', $row->appointment_id)->first();
                    if (!empty($checkReview)) {
                        $row->is_reviewed = $checkReview;
                    } else {
                        $row->is_reviewed = '';
                    }
                } else {
                    $row->is_reviewed = '';
                }

                $row->image = Service::where('id', $row->service_id)->value('image');

            }
        } else {
            $customerData = Appointment::where('id',$id)->first();
            //$getCustomers = Appointment::whereIn('store_id',$getStore)->where('email',$customerData['email'])->orderBy('id','DESC')->get()->toArray();
			$getCustomers = Appointment::leftjoin('appointment_data', 'appointment_data.appointment_id', '=', 'appointments.id')
					->where('appointments.email', $customerData['email'])->whereIn('appointments.store_id',$getStore)->whereNotIn('appointment_data.status', ['cancel'])->get()->toArray();
			
			$customerData['total_booking'] = count($getCustomers);
            $customerData['total_payment'] = array_sum(array_column($getCustomers,'price'));

            $appointment =  AppointmentData::leftjoin('appointments', 'appointments.id', '=', 'appointment_data.appointment_id')
                ->leftjoin('payment_method_infos', 'payment_method_infos.appoinment_id', '=', 'appointments.id')
                ->whereIn('appointment_data.store_id',$getStore)
                ->where('appointments.email',$customerData['email'])
                ->select('appointment_data.*', 'payment_method_infos.status as payment_status','payment_method_infos.card_type as card_type','payment_method_infos.payment_method as payment_method',
                    'appointments.user_id','appointments.order_id','appointments.first_name','appointments.last_name')
                ->orderBy('appointment_data.appointment_id','DESC')
                ->get();

                $customer = $customerData;
                $customer['is_appo'] = 'yes';

        }


        return view('ServiceProvider.Customer.view',compact('customerData','appointment','customer'));

    }

    public function viewCustomer($id){
        $id = decrypt($id);


        $store_id = session('store_id');

        if (empty($store_id)) {
            $getStore = StoreProfile::where('user_id', Auth::user()->id)->pluck('id')->all();
        } else {
            $getStore = StoreProfile::where('user_id', Auth::user()->id)->where('id', $store_id)->pluck('id')->all();
        }

      
        

        $customer = Customer::where('id',$id)->first();
        if(!empty($customer)){
           
           $customerData = Appointment::where('email',$customer['email'])->first();
        } else {
            $customerData = '';
        }


        if(!empty($customer)){
           // $getCustomers = Appointment::whereIn('store_id',$getStore)->where('email',$customer['email'])->orderBy('id','DESC')->get()->toArray();
		   $getCustomers = Appointment::leftjoin('appointment_data', 'appointment_data.appointment_id', '=', 'appointments.id')
					->where('appointments.email', $customer['email'])->whereIn('appointments.store_id',$getStore)->whereNotIn('appointment_data.status', ['cancel'])->get()->toArray();
			
            $customerData['total_booking'] = count($getCustomers);
            $customerData['total_payment'] = array_sum(array_column($getCustomers,'price'));

            $appointment =  AppointmentData::leftjoin('appointments', 'appointments.id', '=', 'appointment_data.appointment_id')
                ->leftjoin('payment_method_infos', 'payment_method_infos.appoinment_id', '=', 'appointments.id')
                ->whereIn('appointment_data.store_id',$getStore)
                ->where('appointments.email',$customer['email'])
                ->select('appointment_data.*', 'payment_method_infos.status as payment_status','payment_method_infos.card_type as card_type','payment_method_infos.payment_method as payment_method',
                    'appointments.user_id','appointments.order_id','appointments.first_name','appointments.last_name')
                ->orderBy('appointment_data.appointment_id','DESC')
                ->get();
            foreach ($appointment as $row) {
                if ($row->status == 'completed') {
                    $checkReview = StoreRatingReview::where('appointment_id', $row->appointment_id)->first();
                    if (!empty($checkReview)) {
                        $row->is_reviewed = $checkReview;
                    } else {
                        $row->is_reviewed = '';
                    }
                } else {
                    $row->is_reviewed = '';
                }

                $row->image = Service::where('id', $row->service_id)->value('image');

            }
        } else {
            $customerData = Appointment::where('id',$id)->first();
            //$getCustomers = Appointment::whereIn('store_id',$getStore)->where('email',$customerData['email'])->orderBy('id','DESC')->get()->toArray();
			 $getCustomers = Appointment::leftjoin('appointment_data', 'appointment_data.appointment_id', '=', 'appointments.id')
					->where('appointments.email', $customerData['email'])->whereIn('appointments.store_id',$getStore)->whereNotIn('appointment_data.status', ['cancel'])->get()->toArray();
			
            $customerData['total_booking'] = count($getCustomers);
            $customerData['total_payment'] = array_sum(array_column($getCustomers,'price'));

            $appointment =  AppointmentData::leftjoin('appointments', 'appointments.id', '=', 'appointment_data.appointment_id')
                ->leftjoin('payment_method_infos', 'payment_method_infos.appoinment_id', '=', 'appointments.id')
                ->whereIn('appointment_data.store_id',$getStore)
                ->where('appointments.email',$customerData['email'])
                ->select('appointment_data.*', 'payment_method_infos.status as payment_status','payment_method_infos.card_type as card_type','payment_method_infos.payment_method as payment_method',
                    'appointments.user_id','appointments.order_id','appointments.first_name','appointments.last_name')
                ->orderBy('appointment_data.appointment_id','DESC')
                ->get();

                $customer = $customerData;
                $customer['is_appo'] = 'yes';

        }


        return view('ServiceProvider.Customer.view',compact('customerData','appointment','customer'));

    }

    public function addNote(Request $request){

        $data['note'] = $request['note'];
		$noteimage = array();
		if ($request->file('image')) {
			$files = $request->file('image');
			foreach($files as $file){
				$filename = 'cust_note-' . uniqid() . '.' . $file->getClientOriginalExtension();
				$file->move(storage_path('app/public/store/customernotes/'), $filename);
				$noteimage[] = $filename;
			}
			$data['note_image'] = implode(",", $noteimage);
        }
        $id = AppointmentData::where('id',$request['app_id'])->value('appointment_id');
        $appointment = AppointmentData::where('id',$request['app_id'])->update($data);

        if($appointment){
            return redirect('dienstleister/kunden-details/'.encrypt($id));
        }
    }

    public function updateNote(Request $request){

        $data['note'] = $request['note'];
		$noteimage = array();
		if ($request->file('image')) {
			$files = $request->file('image');
			$note_image = AppointmentData::where('id',$request['app_id'])->value('note_image');
			if($note_image){
				$oldimages = explode(",", $note_image);
				foreach($oldimages as $oldimage){
					if (!empty($oldimage) && file_exists('storage/app/public/store/customernotes/'.$oldimage)) {
						File::delete('storage/app/public/store/customernotes/' . $oldimage);
					}
				}
			}
			
			foreach($files as $file){
				$filename = 'cust_note-' . uniqid() . '.' . $file->getClientOriginalExtension();
				$file->move(storage_path('app/public/store/customernotes/'), $filename);
				$noteimage[] = $filename;
			}
			$data['note_image'] = implode(",", $noteimage);
        }
		/* if ($request->file('image')) {
			$note_image = AppointmentData::where('id',$request['app_id'])->value('note_image');
			if (!empty($note_image) && file_exists('storage/app/public/store/customernotes/'.$note_image)) {
                File::delete('storage/app/public/store/customernotes/' . $note_image);
            }
            $file = $request->file('image');
            $filename = 'cust_note-' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(storage_path('app/public/store/customernotes/'), $filename);
            $data['note_image'] = $filename;
        } */
        $id = AppointmentData::where('id',$request['app_id'])->value('appointment_id');
        $appointment = AppointmentData::where('id',$request['app_id'])->update($data);

        if($appointment){
            return redirect('dienstleister/kunden-details/'.encrypt($id));
        }
    }

    public function create(){
        return view('ServiceProvider.Customer.add');
    }

    public function store(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'email'=>'required|email|unique:customers',
            //'phone_number' => 'required'
        ]);
        $data = $request->all();
        if ($request->file('image')) {
            $file = $request->file('image');
            $filename = 'customer-' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(storage_path('app/public/store/customer/'), $filename);
            $data['image'] = $filename;
        }

        $store_id = session('store_id');

        if (empty($store_id)) {
            $store_id = StoreProfile::where('user_id', Auth::user()->id)->value('id');
        }
        $data['store_id'] = $store_id;
		$isuser  = User::where('email', $data['email'])->first();
		if(!empty($isuser->id)){
			$data['user_id'] = $isuser->id;
		}
        $customer = new Customer();
        $customer->fill($data);
        if($customer->save()){
            return redirect('dienstleister/kunden');
        }

    }

    public function edit($id){
        $id = decrypt($id);

        $store_id = session('store_id');

        if (empty($store_id)) {
            $getStore = StoreProfile::where('user_id', Auth::user()->id)->pluck('id')->all();
        } else {
            $getStore = StoreProfile::where('user_id', Auth::user()->id)->where('id', $store_id)->pluck('id')->all();
        }

        $customer = Customer::where('id',$id)->first();

        return view('ServiceProvider.Customer.edit',compact('customer'));
    }

    public function update(Request $request,$id){
        $id = decrypt($id);

        $store_id = session('store_id');

        $data = $request->all();
        $data= $request->except('_token','_method');

        if ($request->file('image')) {

            $oldimage = Customer::where('id', $id)->value('image');

            if (!empty($oldimage)) {

                File::delete('storage/app/public/store/customer/' . $oldimage);
            }

            $file = $request->file('image');
            $filename = 'employee-' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(storage_path('app/public/store/customer/'), $filename);
            $data['image'] = $filename;
        }

        $update = Customer::where('id',$id)->update($data);

        if($update){
            return redirect('dienstleister/kunden');
        }

    }

    public function delete(Request $request){
        $data = $request['id'];

        $data = explode(',', $data);
        
       
        foreach ($data as $key) {
           $oldimage = Customer::where('id', $key)->value('image');

            if (!empty($oldimage)) {

                File::delete('storage/app/public/store/customer/' . $oldimage);
            }
        }
        


        $deleteCustomer = Customer::whereIn('id',$data)->delete();

        if($deleteCustomer){
            return redirect('dienstleister/kunden');
        }
    }

    public function getDetails(Request $request){
        $id = $request['id'];
        if(isset($request['id']) && $request['id'] != null){
            $getCustomer = Customer::where('id',$id)->first();
            $name = explode(' ',$getCustomer['name']);
            $getCustomer['first_name'] = $name[0];
            $getCustomer['last_name'] = @$name[1];

        }else {
            $getCustomer = '';
        }
        if(!empty($getCustomer)){
            return ['status' => 'true', 'data' => $getCustomer];
        } else {
            return ['status' => 'false', 'data' => []];
        }
    }
	
	 public function addRequest(Request $request){
        $id = $request['id'];
		$user_id = $request['customer'];
		$is_added = false;
        if($id && $user_id){
            $getCustomer = CustomerRequest::where('store_id',$id)->where('user_id',$user_id)->count();
			if($getCustomer == 0){
				$CustomerRequest  = CustomerRequest::create(['store_id' => $id, 'user_id' => $user_id]);
				$store_name = StoreProfile::where('id', $id)->value('store_name');
				if($CustomerRequest){
					$message = $store_name." möchte deine Kundendaten für deinen nächsten Termin im System speichern.";
					\BaseFunction::notification('Kundenprofil - Anfrage !',$message,'customer_request',$CustomerRequest->id, $id, $user_id,$user_id == ''? 'guest' : '','users');
					//Push Notification for cancellations
					$PUSer = User::find($user_id);
					if(!empty($PUSer->device_token) && !empty($PUSer->allow_notifications) && $PUSer->allow_notifications == 1){
						$sessioncount = ApiSession::where('user_id', $PUSer->id)->count();
						if($sessioncount > 0){
							$registerarion_ids = array($PUSer->device_token);
							\BaseFunction::sendPushNotification($registerarion_ids, 'Kundenprofil - Anfrage !', $message, NULL, NULL);
						}
					}
				  //PUSH Notification code ends 
					$is_added = true;
				}
			}
        }
		if($is_added){
			return ['status' => 'true', 'data' => $is_added];
		}else{
			 return ['status' => 'false', 'data' => []];
		}
    }
	
	
	
	/*  public function importCustomers(Request $request)
    {
		$store_id = session('store_id');

        if (empty($store_id)) {
            $store_id = StoreProfile::where('user_id', Auth::user()->id)->value('id');
        }
       
		if ($request->hasFile('customerlist')) {
            $filename = $_FILES['customerlist']['tmp_name'];
			 if($_FILES["customerlist"]["size"] > 0){
				$file = fopen($filename, "r");
				while (($getData = fgetcsv($file, 10000, ",")) !== FALSE){
					if(!isset($getData[1])){
						$getData  = explode(";", $getData[0]);
					}
					$data = array();
					$data['store_id'] = $store_id;
					$data['name'] =  $getData[0];
					$data['phone_number'] =  $getData[1];
					$data['email'] =  $getData[2];
					if(!empty($getData[2]) && $getData[2] !== 'E-Mail Adresse'){
						$isexist = Customer::where('email', $getData[2])->where('store_id', $store_id)->first();
						if(!empty($isexist->id)){
							$isexist->update($data);
						}else{
							Customer::create($data);
						}
					}
				}
			 }
			 return response()->json(['ResponseCode' => 1, 'ResponseText' => __('Customer imported successfully'), 'ResponseData' => null], 200);
        }else{
           return response()->json(['ResponseCode' => 0, 'ResponseText' => __('Something went wrong'), 'ResponseData' => null], 400);
        }
    } */
	
	public function importCustomers(Request $request)
    {
		
		$store_id = session('store_id');

        if (empty($store_id)) {
            $store_id = StoreProfile::where('user_id', Auth::user()->id)->value('id');
        }
        if ($request->file('customerlist')) {
			$getData = Excel::toArray(new CustomersImport(),request()->file('customerlist'));
			foreach($getData[0] as $val){
				
				$data['store_id'] 		= $store_id;
				$data['name'] 			= trim($val['vor_nachname']);
				$data['phone_number'] 	= trim($val['telefonnummer']);
				$data['email'] 			= trim($val['e_mail_adresse']);
				if(!empty($data['email'] )){
					$isexist = Customer::where('email', $data['email'])->where('store_id', $store_id)->first();
					if(!empty($isexist->id)){
						$isexist->update($data);
					}else{
						Customer::create($data);
					}
				}
			}
            return response()->json(['ResponseCode' => 1, 'ResponseText' => __('Customer imported successfully'), 'ResponseData' => null], 200);
        }else{
           return response()->json(['ResponseCode' => 0, 'ResponseText' => __('Something went wrong'), 'ResponseData' => null], 400);
        }
		
    }
	
	
	public function downloadSample(){
		
		$file = "public/sample_customers.xlsx";
		if (file_exists($file)) {				
			header('Content-type: application/octet-stream');
			header('Content-Disposition: attachment; filename="sample_customers.xlsx"');
			readfile($file);
			exit;				
		}
		return redirect('dienstleister/kunden');
		
	}
}
