<?php

namespace App\Http\Controllers\Api\ServiceProvider\Customer;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\AppointmentData;
use App\Models\Customer;
use App\Models\Service;
use App\Models\CustomerRequest;
use App\Models\StoreProfile;
use App\Models\StoreRatingReview;
use App\Models\User;
use App\Models\ApiSession;
use Validator;
use File;
use Exception;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CustomersImport;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CustomerController extends Controller
{
    public function customerList(Request $request){
		try {
            $userId  = $request['user']['user_id'];
            // $storeId = \BaseFunction::getStoreDetails($userId);
			if(empty($request['store_id'])) {
				$getStore = StoreProfile::where('user_id',$userId)->pluck('id')->all();
			} else {
				$getStore = StoreProfile::where('user_id', $userId)->where('id', $request['store_id'])->pluck('id')->all();
			}
		
            
            $customers = Customer::whereIn('customers.store_id',$getStore)
				->orderBy('customers.id','DESC')
				->select('customers.id', 'customers.name','customers.email','customers.phone_number','customers.address','customers.image')
				->paginate(10);
			
			foreach ($customers as $row){
				$appointments  = Appointment::leftjoin('appointment_data', 'appointment_data.appointment_id', '=', 'appointments.id')
						->where('appointments.email', $row['email'])->whereIn('appointments.store_id',$getStore)->whereNotIn('appointment_data.status', ['cancel'])->orderBy('appointment_data.created_at', 'DESC')->select('appointments.*', 'appointment_data.appo_date', 'appointment_data.appo_time', 'appointment_data.price')->get()->toArray();
				if(count($appointments) == 1){
					if(!empty($appointments[0]['id'])){
						$booking = count($appointments);
					} else {
						$booking = 0;
					}
				} else {
					$booking = count($appointments);
				}
				$row['total_booking'] = $booking;
				$row['total_payment'] = array_sum(array_column($appointments,'price'));
				$row['total_payment'] = number_format($row['total_payment'], 2, ',', '.');
				$last_appointment = Null;
				if(!empty($appointments[0]['appo_date'])){
					$last_appointment = \Carbon\Carbon::parse($appointments[0]['appo_date'])->translatedFormat('d M, Y')." (".\Carbon\Carbon::parse($appointments[0]['appo_date'])->translatedFormat('D').") ".\Carbon\Carbon::parse($appointments[0]['appo_time'])->format('H:i');
				}
				$row['last_appointment'] = $last_appointment; // !empty($appointments[0]['created_at'])?\Carbon\Carbon::parse($appointments[0]['created_at'])->translatedFormat('d M, Y')." ".\Carbon\Carbon::parse($appointments[0]['created_at'])->translatedFormat('D')." ".\Carbon\Carbon::parse($appointments[0]['created_at'])->format('H:i'):Null;
			}
			
			$responseData = array('customers' => $customers, 'totalCount' => count($customers), 'sample_excel' => asset('public/sample_customers.xlsx'));
			
            return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Successful', 'ResponseData' => $responseData], 200);
            
        } catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
	}
	
	/* Customer dropdown list for checkout */
	public function customerDropdownList(Request $request){
		try {
            $userId  = $request['user']['user_id'];
			if(empty($request['store_id'])) {
				$getStore = StoreProfile::where('user_id',$userId)->pluck('id')->all();
			} else {
				$getStore = StoreProfile::where('user_id', $userId)->where('id', $request['store_id'])->pluck('id')->all();
			}
			
            $customers = Customer::whereIn('customers.store_id',$getStore)->orderBy('customers.id','DESC')
						->select('customers.id', 'customers.name','customers.email','customers.phone_number','customers.address','customers.image')
						->get();
			
			foreach ($customers as $row){
				$name = explode(' ',$row['name']);
				$row['first_name'] = $name[0];
				$row['last_name'] = @$name[1];
			}
			
			
            return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Successful', 'ResponseData' => $customers], 200);
            
        } catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
	}
	
	
	 //add customer in store
    public function customerStore(Request $request)
    {               
        $rule = [
           'name' => 'required',
           'email' => 'required',    
        ];

        $message = [
            'name.required' => 'Customer name is required',           
            'email.required' => 'Email is required'
        ];

        $validate = Validator::make($request->all(), $rule, $message);

        if ($validate->fails()) {
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Validation Fails', 'ResponseData' => $validate->errors()->all()], 422);
        }
        try {
            $data = request()->all();         
			$userId  = $data['user']['user_id'];
			if(empty($data['store_id'])) {
				$store_id = StoreProfile::where('user_id', $userId)->value('id');
			} else {
				$store_id = $data['store_id'];
			}
			$data['store_id'] = $store_id;
			
            if ($request->file('image')) {
                $file = $request->file('image');
                $filename = 'customer-' . uniqid() . '.' . $file->getClientOriginalExtension();
				$file->move(storage_path('app/public/store/customer/'), $filename);
                $data['image'] = $filename;
            }
           
            $customer = new Customer();
			$customer->fill($data);
            if($customer->save()){  
                return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Customer added successfully.', 'ResponseData' => null], 200);
            }
            
        } catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
    }
	
	
	public function customerEdit(Request $request)
    {
        try {
            $data = request()->all();
            $id   = $data['id'];
            $customer = Customer::where('id', $id)->first();
            if (!empty($customer)) { 
                return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Success.', 'ResponseData' => $customer], 200);
            }
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'wrong customer id.', 'ResponseData' => null], 400);
        } catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
    }
	
	
	public function customerUpdate(Request $request)
    {               
        $rule = [
           'name' => 'required',
           'email' => 'required',    
        ];

        $message = [
            'name.required' => 'Customer name is required',           
            'email.required' => 'Email is required'
        ];

        $validate = Validator::make($request->all(), $rule, $message);

        if ($validate->fails()) {
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Validation Fails', 'ResponseData' => $validate->errors()->all()], 422);
        }
        try {
            $data = request()->all();         
			$userId  = $data['user']['user_id'];
			$id    = $data['id'];
			if(empty($data['store_id'])) {
				$store_id = StoreProfile::where('user_id', $userId)->value('id');
			} else {
				$store_id = $data['store_id'];
			}
			$data['store_id'] = $store_id;
			unset($data['user']);
			
            if ($request->file('image')) {
				$oldimage = Customer::where('id', $id)->value('image');

				if (!empty($oldimage)) {
					File::delete('storage/app/public/store/customer/' . $oldimage);
				}
                $file = $request->file('image');
                $filename = 'customer-' . uniqid() . '.' . $file->getClientOriginalExtension();
				$file->move(storage_path('app/public/store/customer/'), $filename);
                $data['image'] = $filename;
            }
           
            $update = Customer::where('id',$id)->update($data);
            if($update){  
                return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Customer updated successfully.', 'ResponseData' => null], 200);
            }
            
        } catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
    }
	
	
	public function customerDelete(Request $request)
    {
        try {
            $data = request()->all();
			$userId  = $data['user']['user_id'];
            // $storeId = \BaseFunction::getStoreDetails($userId);
			if(empty($data['store_id'])) {
				$getStore = StoreProfile::where('user_id',$userId)->pluck('id')->all();
			} else {
				$getStore = StoreProfile::where('user_id', $userId)->where('id', $data['store_id'])->pluck('id')->all();
			}
			$dataCustomer = $data['id'];

			$dataCustomer = explode(',', $dataCustomer);
			if($dataCustomer){
				foreach ($dataCustomer as $key) {
				   $oldimage = Customer::where('id', $key)->value('image');
					if (!empty($oldimage)) {
						File::delete('storage/app/public/store/customer/' . $oldimage);
					}
				}
			}else{
				return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Not found customer id.', 'ResponseData' => ''], 400);
			}
			
			$deleteCustomer = Customer::whereIn('id',$dataCustomer)->delete();
           /*  $deleteCustomer = Customer::where('id',$data['id'])->whereIn('store_id', $getStore)->first();
            if (empty($deleteCustomer)) {
                return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Not found customer id.', 'ResponseData' => ''], 400);
            }
            $oldimage = Customer::where('id',$data['id'])->whereIn('store_id',$getStore)->value('image');
            if (!empty($oldimage)) {
               File::delete('storage/app/public/store/customer/' . $oldimage);
            }
            $deleteCustomer = $deleteCustomer->delete(); */
			if($deleteCustomer){
				return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Customer deleted successfully.', 'ResponseData' => NULL], 200);
			}else{
				return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
			}
            
        } catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
    }
	
	public function customerView(Request $request)
    {
        try {
            $data = request()->all();
			$userId  = $request['user']['user_id'];
            // $storeId = \BaseFunction::getStoreDetails($userId);
			if(empty($request['store_id'])) {
				$getStore = StoreProfile::where('user_id',$userId)->pluck('id')->all();
			} else {
				$getStore = StoreProfile::where('user_id', $userId)->where('id', $request['store_id'])->pluck('id')->all();
			}
			
			$customerData = array();
			if(!empty($data['appointment_id'])){
				$customer = Appointment::where('id', $data['appointment_id'])->first();
				 if(!empty($customer)){
					$customerData = Customer::where('email',$customer['email'])->first();
				}
			}elseif(!empty($data['id'])){
				$customerData = Customer::where('id', $data['id'])->first();
			}
            
			if(!empty($customerData)){
				$customerAppointments = Appointment::leftjoin('appointment_data', 'appointment_data.appointment_id', '=', 'appointments.id')
					->where('appointments.email', $customerData['email'])->whereIn('appointments.store_id',$getStore)->whereNotIn('appointment_data.status', ['cancel'])->get()->toArray();
				$customerData['total_booking'] = count($customerAppointments);
				$customerData['total_payment'] = number_format(array_sum(array_column($customerAppointments,'total_amount')), 2, ',', '.');
				
				$appointments =  AppointmentData::leftjoin('appointments', 'appointments.id', '=', 'appointment_data.appointment_id')
						->leftjoin('payment_method_infos', 'payment_method_infos.appoinment_id', '=', 'appointments.id')
						->whereIn('appointment_data.store_id',$getStore)
						->where('appointments.email',$customerData['email'])
						->select('appointment_data.*', 'payment_method_infos.status as payment_status','payment_method_infos.card_type as card_type','payment_method_infos.payment_method as payment_method',
							'appointments.user_id','appointments.order_id','appointments.first_name','appointments.last_name')
						->orderBy('appointment_data.appointment_id','DESC')
						->get();
						
					 foreach ($appointments as $row) {
						if ($row->status == 'completed') {
							$checkReview = StoreRatingReview::where('appointment_id', $row->appointment_id)->first();
							if (!empty($checkReview)) {
								$row['is_reviewed'] = $checkReview;
							} else {
								$row['is_reviewed'] = '';
							}
						} else {
							$row['is_reviewed'] = '';
						}
						//$row['image'] = Service::where('id', $row->service_id)->value('image');
						$row->employee_name = @$row->employeeDetails->emp_name;	
						$row->emp_image_path = @$row->employeeDetails->emp_image_path;	
						$row->image = Service::where('id', $row->service_id)->value('image');
						$row->appo_date = \Carbon\Carbon::parse($row['appo_date'])->translatedFormat('d F, Y').' ('. \Carbon\Carbon::parse($row['appo_date'])->translatedFormat('D').')';  
						$row->appo_time = \Carbon\Carbon::parse($row['appo_time'])->translatedFormat('H:i');
						$row->price = number_format($row->price, 2, ',', '.');
						$row->user_image_path = !empty($row->userDetails->profile_pic)?url('storage/app/public/user/'.$row->userDetails->profile_pic):NULL; //@$row->userDetails->user_image_path;
						$row->category_name = @$row->categoryDetails->name;
						$row->subcategory_name = @$row->subCategoryDetails->name;
						$row->service_image_path = @$row->serviceDetails->service_image_path;
						$row->variant_description = @$row->variantData->description;
						$row->variant_duration_of_service = @$row->variantData->duration_of_service;
						$row->store_name  = @$row->storeDetails->store_name;
						$row->store_address  = @$row->storeDetails->store_address;
						$row->payment_method = ucfirst($row->payment_method == 'cash' ? 'vor Ort' : ((strtolower($row->payment_method) == 'stripe' && !empty($row->card_type))?$row->card_type:$row->payment_method));
						$row->store_profile_image_path  = @$row->storeDetails->store_profile_image_path;
						unset($row->storeDetails,$row->userDetails,$row->employeeDetails,$row->serviceDetails,$row->orderInfo,$row->categoryDetails,$row->subCategoryDetails,$row->variantData);
					}
					$customerData['appointments']  = $appointments;
				
				return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Success.', 'ResponseData' => $customerData], 200);
			}elseif(!empty($data['appointment_id'])){
				
				$customerData = Appointment::where('id',$data['appointment_id'])->first(['email', 'first_name', 'phone_number', 'last_name', 'store_id', 'user_id']);
				$user		 = User::where('email', $customerData->email)->first();
				$customerData->id = "";
				$customerData->name = $customerData->first_name." ".$customerData->last_name;
				$customerData->phone_number = !empty($user->phone_number)?$user->phone_number:$customerData->phone_number;
				$customerData->customer_image_path = !empty($user->user_image_path)?$user->user_image_path:"";
				$customerData->address = !empty($user->address)?$user->address:"";
				$customerData->state = !empty($user->state)?$user->state:"";
				$customerData->zipcode = !empty($user->zipcode)?$user->zipcode:"";
				
				
				$customerAppointments = Appointment::leftjoin('appointment_data', 'appointment_data.appointment_id', '=', 'appointments.id')
					->where('appointments.email', $customerData['email'])->whereIn('appointments.store_id',$getStore)->whereNotIn('appointment_data.status', ['cancel'])->get()->toArray();
				$customerData['total_booking'] = count($customerAppointments);
				$customerData['total_payment'] = number_format(array_sum(array_column($customerAppointments,'total_amount')), 2, ',', '.');
				
				 $appointments =  AppointmentData::leftjoin('appointments', 'appointments.id', '=', 'appointment_data.appointment_id')
						->leftjoin('payment_method_infos', 'payment_method_infos.appoinment_id', '=', 'appointments.id')
						->whereIn('appointment_data.store_id',$getStore)
						->where('appointments.email',$customerData['email'])
						->select('appointment_data.*', 'payment_method_infos.status as payment_status','payment_method_infos.card_type as card_type','payment_method_infos.payment_method as payment_method',
							'appointments.user_id','appointments.order_id','appointments.first_name','appointments.last_name')
						->orderBy('appointment_data.appointment_id','DESC')
						->get();
						
					 foreach ($appointments as $row) {
						if ($row->status == 'completed') {
							$checkReview = StoreRatingReview::where('appointment_id', $row->appointment_id)->first();
							if (!empty($checkReview)) {
								$row['is_reviewed'] = $checkReview;
							} else {
								$row['is_reviewed'] = '';
							}
						} else {
							$row['is_reviewed'] = '';
						}
						//$row['image'] = Service::where('id', $row->service_id)->value('image');
						$row->employee_name = @$row->employeeDetails->emp_name;	
						$row->emp_image_path = @$row->employeeDetails->emp_image_path;	
						$row->image = Service::where('id', $row->service_id)->value('image');
						$row->appo_date = \Carbon\Carbon::parse($row['appo_date'])->translatedFormat('M d, Y').' ('. \Carbon\Carbon::parse($row['appo_date'])->translatedFormat('D').')';  
						$row->user_image_path = !empty($row->userDetails->profile_pic)?url('storage/app/public/user/'.$row->userDetails->profile_pic):NULL; //@$row->userDetails->user_image_path;
						//$row->user_image_path = @$row->userDetails->user_image_path;	
						$row->category_name = @$row->categoryDetails->name;
						$row->price = number_format($row->price, 2, ',', '.');
						$row->subcategory_name = @$row->subCategoryDetails->name;
						$row->service_image_path = @$row->serviceDetails->service_image_path;
						$row->variant_description = @$row->variantData->description;
						$row->variant_duration_of_service = @$row->variantData->duration_of_service;
						$row->store_name  = @$row->storeDetails->store_name;
						$row->store_address  = @$row->storeDetails->store_address;
						$row->store_profile_image_path  = @$row->storeDetails->store_profile_image_path;
						unset($row->storeDetails,$row->userDetails,$row->employeeDetails,$row->serviceDetails,$row->orderInfo,$row->categoryDetails,$row->subCategoryDetails,$row->variantData);
					}
					$customerData['appointments']  = $appointments;
					return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Success.', 'ResponseData' => $customerData], 200);
			}else{
				 return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Incorrect customer id.', 'ResponseData' => null], 400);
			}
        } catch (\Throwable $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
    }
	public function customerNotesView(Request $request)
    {
		 try {
            $data = request()->all();
			$userId  = $request['user']['user_id'];
			$id  = $request['id'];
			if(empty($request['store_id'])) {
				$getStore = StoreProfile::where('user_id',$userId)->pluck('id')->all();
			} else {
				$getStore = StoreProfile::where('user_id', $userId)->where('id', $request['store_id'])->pluck('id')->all();
			}
			$AppointmentData  = AppointmentData::where('appointment_data.id', $id)->first();
			if(!empty($AppointmentData->note) OR !empty($AppointmentData->note_image)){
				$note_images = array();
				if(!empty($AppointmentData->note_image)){
					$noteimages = explode(",", $AppointmentData->note_image);
					
					foreach($noteimages as $noteimage){
						if(!empty( $noteimage) && file_exists('storage/app/public/store/customernotes/'. $noteimage)){
							$note_images[] = array('image_path' => url('storage/app/public/store/customernotes/'. $noteimage));
						}
					}
				}
				$responseData = ['note' => $AppointmentData->note, 'note_images' => $note_images];
				return response()->json(['ResponseCode' => 1, 'ResponseText' => 'success', 'ResponseData' => $responseData], 200);
			}else{
				 return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Invalid request', 'ResponseData' => null], 400);
			}
				
		 } catch (\Throwable $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
	}
	
	
	
	public function customerNotesAdd(Request $request)
    {
        try {
            $data = request()->all();
			$userId  = $request['user']['user_id'];
			$id  = $request['id'];
			if(empty($request['store_id'])) {
				$getStore = StoreProfile::where('user_id',$userId)->pluck('id')->all();
			} else {
				$getStore = StoreProfile::where('user_id', $userId)->where('id', $request['store_id'])->pluck('id')->all();
			}
			$AppointmentData  = AppointmentData::leftjoin('appointments', 'appointment_data.appointment_id', '=', 'appointments.id')
						->where('appointment_data.id', $id)->whereIn('appointments.store_id',$getStore)->select('appointments.*','appointment_data.appo_date','appointment_data.appo_time','appointment_data.service_name','appointment_data.note','appointment_data.store_emp_id','appointment_data.price','appointment_data.status','appointment_data.note_image', 'appointment_data.category_id', 'appointment_data.subcategory_id', 'appointment_data.variant_id')->first();
			if(!empty($AppointmentData->id)){
				$responseData = array();
				$responseData['user_image_path'] = @$AppointmentData->userDetails->user_image_path;	
				$responseData['first_name'] = $AppointmentData->first_name;	
				$responseData['last_name'] = $AppointmentData->last_name;	
				$responseData['order_id'] = $AppointmentData->order_id;	
				$responseData['status'] = $AppointmentData->status;
				$responseData['price'] = number_format($AppointmentData->price, 2, ',', '.');
				
				if(!empty($AppointmentData->orderInfo->payment_method)){
					$row = $AppointmentData->orderInfo;
					$responseData['payment_method'] = ucfirst($row->payment_method == 'cash' ? 'vor Ort' : ((strtolower($row->payment_method) == 'stripe' && !empty($row->card_type))?$row->card_type:$row->payment_method));
				}
				//$responseData['payment_method'] = strtolower($AppointmentData->orderInfo->payment_method) == 'stripe' && !empty($AppointmentData->orderInfo->card_type)?$AppointmentData->orderInfo->card_type:ucfirst($AppointmentData->orderInfo->payment_method);
				$responseData['category_name'] = @$AppointmentData->categoryDetails->name;
				$responseData['category_image_path'] = @$AppointmentData->categoryDetails->category_image_path;
				$responseData['appo_date'] = \Carbon\Carbon::parse($AppointmentData->appo_date)->translatedFormat('d F, Y');
				$responseData['appo_day'] = \Carbon\Carbon::parse($AppointmentData->appo_date)->translatedFormat('D');
				$responseData['appo_time'] = \Carbon\Carbon::parse($AppointmentData->appo_time)->format('H:i');
				$responseData['emp_name'] = @$AppointmentData->employeeDetails->emp_name;
				$responseData['emp_image_path'] = @$AppointmentData->employeeDetails->emp_image_path;
				$responseData['subcategory_name'] = @$AppointmentData->subCategoryDetails->name;
				$responseData['service_name'] = @$AppointmentData->service_name;
				$responseData['variant_description'] = @$AppointmentData->variantData->description;
				return response()->json(['ResponseCode' => 1, 'ResponseText' => 'success', 'ResponseData' => $responseData], 200);
			}else{
				 return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Invalid request', 'ResponseData' => null], 400);
			}
		} catch (\Throwable $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
	}
	
	 public function customerNotesStore(Request $request){

		 try {
            $data = request()->all();
			$userId  = $request['user']['user_id'];
			$id  = $request['id'];
			if(empty($request['store_id'])) {
				$getStore = StoreProfile::where('user_id',$userId)->pluck('id')->all();
			} else {
				$getStore = StoreProfile::where('user_id', $userId)->where('id', $request['store_id'])->pluck('id')->all();
			}
			$dataStore['note'] = $request['note'];
			
			$noteimage = array();
			$files = $request->file('images');
			
			 if(!empty($files)){
				 $note_image = AppointmentData::where('id',$request['id'])->value('note_image');
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
				$dataStore['note_image'] = implode(",", $noteimage);
				
			}
			$appointment = AppointmentData::where('id',$request['id'])->update($dataStore);

			if($appointment){
				 return response()->json(['ResponseCode' => 1, 'ResponseText' => 'success', 'ResponseData' => null], 200);
			}else{
				return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
			}
		} catch (\Throwable $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
    }

    
	public function customerNotesEdit(Request $request)
    {
        try {
            $data = request()->all();
			$userId  = $request['user']['user_id'];
			$id  = $request['id'];
			if(empty($request['store_id'])) {
				$getStore = StoreProfile::where('user_id',$userId)->pluck('id')->all();
			} else {
				$getStore = StoreProfile::where('user_id', $userId)->where('id', $request['store_id'])->pluck('id')->all();
			}
			$AppointmentData  = AppointmentData::leftjoin('appointments', 'appointment_data.appointment_id', '=', 'appointments.id')
						->where('appointment_data.id', $id)->whereIn('appointments.store_id',$getStore)->select('appointments.*','appointment_data.appo_date','appointment_data.appo_time','appointment_data.service_name','appointment_data.note','appointment_data.store_emp_id','appointment_data.price','appointment_data.status','appointment_data.note_image', 'appointment_data.category_id', 'appointment_data.subcategory_id', 'appointment_data.variant_id')->first();
				
			if(!empty($AppointmentData->note) OR !empty($AppointmentData->note_image)){
				$responseData = array();
				$responseData['user_image_path'] = @$AppointmentData->userDetails->user_image_path;	
				$responseData['first_name'] = $AppointmentData->first_name;	
				$responseData['last_name'] = $AppointmentData->last_name;	
				$responseData['order_id'] = $AppointmentData->order_id;	
				$responseData['status'] = $AppointmentData->status;
				$responseData['price'] = number_format($AppointmentData->price, 2, ',', '.');
				if(!empty($AppointmentData->orderInfo->payment_method)){
					$row = $AppointmentData->orderInfo;
					$responseData['payment_method'] = ucfirst($row->payment_method == 'cash' ? 'vor Ort' : ((strtolower($row->payment_method) == 'stripe' && !empty($row->card_type))?$row->card_type:$row->payment_method));
				}
				//$responseData['payment_method'] = strtolower($AppointmentData->orderInfo->payment_method) == 'stripe' && !empty($AppointmentData->orderInfo->card_type)?$AppointmentData->orderInfo->card_type:ucfirst($AppointmentData->orderInfo->payment_method);
				$responseData['category_name'] = @$AppointmentData->categoryDetails->name;
				$responseData['category_image_path'] = @$AppointmentData->categoryDetails->category_image_path;
				$responseData['appo_date'] = \Carbon\Carbon::parse($AppointmentData->appo_date)->translatedFormat('d F, Y');
				$responseData['appo_day'] = \Carbon\Carbon::parse($AppointmentData->appo_date)->translatedFormat('D');
				$responseData['appo_time'] = \Carbon\Carbon::parse($AppointmentData->appo_time)->format('H:i');
				$responseData['emp_name'] = @$AppointmentData->employeeDetails->emp_name;
				$responseData['emp_image_path'] = @$AppointmentData->employeeDetails->emp_image_path;
				$responseData['subcategory_name'] = @$AppointmentData->subCategoryDetails->name;
				$responseData['service_name'] = @$AppointmentData->service_name;
				$responseData['variant_description'] = @$AppointmentData->variantData->description;
				$responseData['note'] = $AppointmentData->note;
				$responseData['note_iamges'] = NULL;
				
				if(!empty($AppointmentData->note_image)){
					$noteimages = explode(",", $AppointmentData->note_image);
					
					foreach($noteimages as $noteimage){
						if(!empty( $noteimage) && file_exists('storage/app/public/store/customernotes/'. $noteimage)){
							$responseData['note_iamges'][] = array('image_path' => url('storage/app/public/store/customernotes/'. $noteimage));
						}
					}
				}
				return response()->json(['ResponseCode' => 1, 'ResponseText' => 'success', 'ResponseData' => $responseData], 200);
				
			}else{
				 return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Invalid request', 'ResponseData' => null], 400);
			}
		} catch (\Throwable $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
	}
	
	
	 public function sendRequest(Request $request){
		 try{
			$data = request()->all();         
			$userId  = $data['user']['user_id'];
			if(empty($data['store_id'])) {
				$id = StoreProfile::where('user_id', $userId)->value('id');
			} else {
				$id = $data['store_id'];
			}
			
			$user_id = $request['user_id'];
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
				return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Customer request sent', 'ResponseData' => NULL], 200);
			}else{
				return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
			}
		} catch (\Throwable $e) {
           \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
    }
	
	
	public function importCustomers(Request $request)
    {
		try{
			$data = request()->all();         
			$userId  = $data['user']['user_id'];
			if(empty($data['store_id'])) {
				$store_id = StoreProfile::where('user_id', $userId)->value('id');
			} else {
				$store_id = $data['store_id'];
			}
			if ($request->file('customerlist')) {
				$getData = Excel::toArray(new CustomersImport(),request()->file('customerlist'));
				if(count($getData[0]) > 0){
					$imported = false;
					foreach($getData[0] as $val){
						
						$data['store_id'] 		= $store_id;
						$data['name'] 			= trim($val['vor_nachname']);
						$data['phone_number'] 	= trim($val['telefonnummer']);
						$data['email'] 			= trim($val['e_mail_adresse']);
						if(!empty($data['email'] )){
							$isexist = Customer::where('email', $data['email'])->where('store_id', $store_id)->first();
							if(!empty($isexist->id)){
								$isexist->update($data);
								$imported  = true;
							}else{
								Customer::create($data);
								$imported  = true;
							}
						}
					}
					if($imported){
						return response()->json(['ResponseCode' => 1, 'ResponseText' => __('Customer imported successfully'), 'ResponseData' => $getData], 200);
					}else{
						return response()->json(['ResponseCode' => 0, 'ResponseText' => __('Nothing imported'), 'ResponseData' => $getData], 400);
					}
				}else{
					return response()->json(['ResponseCode' => 0, 'ResponseText' => __('Empty file or wrong format'), 'ResponseData' => $getData], 400);
				}
			}
			return response()->json(['ResponseCode' => 0, 'ResponseText' => __('Something went wrong'), 'ResponseData' => $getData], 400);
			
		} catch (\Throwable $e) {
           \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => __('Something went wrong'), 'ResponseData' => null], 400);
        }
    }
   
}
