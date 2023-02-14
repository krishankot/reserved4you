<?php

namespace App\Http\Controllers\Api\User\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ApiSession;
use App\Models\Customer;
use App\Models\Appointment;
use App\Models\StoreProfile;
use App\Models\UserAddress;
use App\Models\Notification;
use App\Models\CustomerRequest;
use App\Models\AppointmentData;
use URL;
use File;
use Validator;

class UserController extends Controller
{
    public function index(Request $request){
        $user = $request['user'];
        $user_id = $user['user_id'];
        $user_data = User::where('id', $user_id)->first();

        // if (file_exists(storage_path('app/public/user/' . $user_data['profile_pic'])) && $user_data['profile_pic'] != '') {
        //     $user_data['profile_pic'] = URL::to('storage/app/public/user/' . $user_data['profile_pic']);
        // } else {
        //     $user_data['profile_pic'] = URL::to('storage/app/public/default/default_user.jpg');
        // }

        $data['user'] = $user_data;

        return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Success.', 'ResponseData' => $data], 200);
    }

	public function updateProfilePicture(Request $request){
		try{
			$user = $request['user'];
			$user_id = $user['user_id'];        
			$user_data = User::where('id', $user_id)->first();
			$rule = [
				'profile_pic'=>'required|mimes:jpeg,bmp,png,gif'
			];
			$message = [
				'profile_pic.required' 	=> __('Profile picture is required'),
				'profile_pic.mimes' 	=> __('Only jped,bmp,png,gif formats are allowed'),
			];
			$validate = Validator::make($request->all(), $rule, $message);

			if ($validate->fails()) {
				return response()->json(['ResponseCode' => 0, 'ResponseText' => __('Validation failed'), 'ResponseData' => $validate->errors()->all()], 422);
			}else{
				$data  = array();
				if ($request->file('profile_pic')) {
					$oldimage = User::where('id', $user_id)->value('profile_pic');
					if (!empty($oldimage)) {
						File::delete('storage/app/public/user/' . $oldimage);
					}

					$file = $request->file('profile_pic');
					$filename = 'user-' . uniqid() . '.' . $file->getClientOriginalExtension();
					$file->move('storage/app/public/user', $filename);
					$data['profile_pic'] = $filename;
				} 
				$update = User::where('id', $user_id)->update($data);
				if($update){
					$data  = User::where('id', $user_id)->first();
					return response()->json(['ResponseCode' => 1, 'ResponseText' => __('Updated Successfully'), 'ResponseData' => $data], 200);
				}else{
					return response()->json(['ResponseCode' => 0, 'ResponseText' => __('Something went wrong'), 'ResponseData' => null], 400);
				}
			}
		} catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => __('Something went wrong'), 'ResponseData' => null], 400);
        }
	}
	
	
    public function updateProfile(Request $request)
    {
        $user = $request['user'];
        $user_id = $user['user_id'];        
        $user_data = User::where('id', $user_id)->first();
        $rule = [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user_id,
            'profile_pic'=>'mimes:jpeg,bmp,png,gif'
        ];
        $message = [
            'first_name.required' => 'First Name is required',
            'last_name.required' => 'Last Name is required',
            'email.required' => 'email is required',
        ];
        $validate = Validator::make($request->all(), $rule, $message);

        if ($validate->fails()) {
            return response()->json(['ResponseCode' => 0, 'ResponseText' => __('Validation failed'), 'ResponseData' => $validate->errors()->all()], 422);
        }


        $data['first_name'] = $request['first_name'];
        $data['last_name'] = $request['last_name'];
        $data['email'] = $request['email'];
        $data['phone_number'] = $request['phone_number'];
        $data['address'] = $request['address'];
        $data['city'] = $request['city'];
        $data['state'] = $request['state'];
        $data['country'] = $request['country'];
        $data['zipcode'] = $request['zipcode'];


        if ($request->file('profile_pic')) {

            $oldimage = User::where('id', $user_id)->value('profile_pic');
            if (!empty($oldimage)) {
                File::delete('storage/app/public/user/' . $oldimage);
            }

            $file = $request->file('profile_pic');
            $filename = 'user-' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move('storage/app/public/user', $filename);
            $data['profile_pic'] = $filename;
        }       

		if($data['email'] != $user_data->email){
			//Customer::where('email', $user_data->email)->update(array('email' => $data['email']));
			Appointment::where('email', $user_data->email)->update(array('email' => $data['email']));
		}
		$customerData 			= array();
		$customerData['name'] 	= $data['first_name'].' '.$data['last_name'];
		$customerData['email'] 	= $data['email'];
		if(!empty($data['phone_number'])){
			$customerData['phone_number'] 	= $data['phone_number'];
		}
		Customer::where('email', $user_data->email)->update($customerData);
		
        $update = User::where('id', $user_id)->update($data);
        if ($update) {
            $data = User::where('id', $user_id)->first();

            // if (file_exists(storage_path('app/public/user/' . $data['profile_pic'])) && $data['profile_pic'] != '') {
            //     $data['profile_pic'] = URL::to('storage/app/public/user/' . $data['profile_pic']);
            // } else {
            //     $data['profile_pic'] = URL::to('storage/app/public/default/default_doctor.jpg');
            // }

            return response()->json(['ResponseCode' => 1, 'ResponseText' => __('Updated Successfully'), 'ResponseData' => $data], 200);
        }

    }
    //serives
    public function selectService()
    {
        $allService=  [
            
            '1' => 'Gastronomy',
            '2' => 'Cosmetics',
            '3' => 'Health',
            '4' => 'Law and Advice',
        ];
        return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Update Success.', 'ResponseData' => $allService], 200);
    }

    /**
     * User address list ,store ,update
     */
    public function list()
    {
        try {
            $data = request()->all();        
            $userId = $data['user']['user_id'];
            $addressList = UserAddress::where('user_id',$userId)->get();
            if ($addressList->count() > 0) {
                return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Success', 'ResponseData' => $addressList], 200);    
            }
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'No address found', 'ResponseData' => null], 400);
        } catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => __('Something went wrong'), 'ResponseData' => null], 400);
        }
    }

    /**
     * store address
     */
    public function store(Request $request)
    {
        
        $rule = [
            'address' =>'required',
            'type' =>'required',
            'latitude' =>'required',
            'longitude' =>'required',
        ];

        $message = [
            'address.required' => 'Address is required',
            'type.required' => 'Type is required',
            'latitude.required' => 'Latitude is required',
            'longitude.required' => 'Longitude is required',
        ];

        $validate = Validator::make($request->all(), $rule, $message);

        if($validate->fails()){
            return response()->json(['ResponseCode' => 0, 'ResponseText' => __('Validation failed'), 'ResponseData' => $validate->errors()->all()], 422);
        }
        try {
            $data = request()->all();
            
            $userId = $data['user']['user_id'];
            // $storeAdd = UserAddress::updateOrCreate([
            //                 'user_id' => $userId,
            //                 'type' => $data['type']
            //             ],
            //             [
            //                 'address' => $data['address'],
            //                 'type' => $data['type'],
            //                 'location' => $data['location'],
            //                 'latitude' => $data['latitude'],
            //                 'longitude' => $data['longitude'],
            //             ]);
            $storeAdd = new UserAddress();
            $storeAdd->user_id = $userId;
            $storeAdd->type = $data['type'];
            $storeAdd->address = $data['address'];
            $storeAdd->location = $data['location'];
            $storeAdd->latitude = $data['latitude'];
            $storeAdd->longitude = $data['longitude'];
            $storeAdd->save();
            return response()->json(['ResponseCode' => 1, 'ResponseText' =>'Address Add Successful', 'ResponseData' => $storeAdd], 200);
        } catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => __('Something went wrong'), 'ResponseData' => null], 400);
        }
    }

    /**
     * update address
     */

     public function update(Request $request)
     {
        $rule = [
            'address' =>'required',
            'type' =>'required',
            'latitude' =>'required',
            'longitude' =>'required',
        ];

        $message = [
            'address.required' => 'Address is required',
            'type.required' => 'Type is required',
            'latitude.required' => 'Latitude is required',
            'longitude.required' => 'Longitude is required',
        ];

        $validate = Validator::make($request->all(), $rule, $message);

        if($validate->fails()){
            return response()->json(['ResponseCode' => 0, 'ResponseText' => __('Validation failed'), 'ResponseData' => $validate->errors()->all()], 422);
        }
        try {
            $data = request()->all();            
            $userId = $data['user']['user_id'];
            $updateAdd = UserAddress::where('id' , $data['address_id'])->where('user_id',$userId)->update(
                        [
                            'address' => $data['address'],
                            'type' => $data['type'],
                            'location' => $data['location'],
                            'latitude' => $data['latitude'],
                            'longitude' => $data['longitude'],
                        ]);
            return response()->json(['ResponseCode' => 1, 'ResponseText' =>'Address update Successful', 'ResponseData' => $updateAdd], 200);
        } catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => __('Something went wrong'), 'ResponseData' => null], 400);
        }  
     }

     /**
      * destroy
      */
    public function destroy(Request $request)
    {
        try {
            $data = request()->all();
            $userId = $data['user']['user_id'];
            $deleteAdd = UserAddress::where('id',$data['add_id'])->where('user_id',$userId)->delete();
            return response()->json(['ResponseCode' => 1, 'ReponseText' => 'Address Delete Successfully.','ResponseData'=> null],200);
        } catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => __('Something went wrong'), 'ResponseData' => null], 400);
        }
    }
	
	
	public function notification()
    {
		try {
            $input = request()->all();
            $userId = $input['user']['user_id'];
			User::where('id', $userId)->update(['notification_checked' => date('Y-m-d H:i:s')]);
            $data = Notification::where('user_id', $userId)->where('visible_for', 'users')->orderBy('created_at','DESC')->get();
			$notifications = array();
			$i = 0;
			foreach($data as $row){
				if($row->type == 'appointment'){
					if(strpos($row->title, 'Neue Buchung') !== false){
						$appointmentDetails = \BaseFunction::getAppointmentData($row->appointment_id);
					}else{
						$appointmentDetails = \BaseFunction::getAppointmentDataByID($row->appointment_id);
					}
					foreach ($appointmentDetails as $appointmentDetail){
						$notifications[$i] = $row;
						$notifications[$i]['timeago'] = \Carbon\Carbon::parse($row['created_at'])->diffForHumans();
						$notifications[$i]['appointment_id'] = (String)$appointmentDetail->appointment_id;
						$i++;
					}
				}else{
					$notifications[$i] = $row;
					$notifications[$i]['timeago'] = \Carbon\Carbon::parse($row['created_at'])->diffForHumans();
					if($row->type == 'review_request'){
						$appointment = AppointmentData::where('id', $row->appointment_id)->first(['id', 'appointment_id',  'store_id', 'store_emp_id', 'service_id', 'service_name']);
						$appointment->emp_name = @$appointment->orderExpert->emp_name;
						$appointment->store_name = @$appointment->storeDetails->store_name;
						$appointment->store_profile_image_path = @$appointment->storeDetails->store_profile_image_path;
						unset($appointment->serviceDetails, $appointment->orderExpert, $appointment->storeDetails);
						$notifications[$i]['appointment'] = $appointment;
					}
					$i++;
				}
			}
            return response()->json(['ResponseCode' => 1, 'ReponseText' => 'Get notification Successful!','ResponseData'=> $notifications],200);
        } catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => __('Something went wrong'), 'ResponseData' => null], 400);
        }
    }
	
	
	public function allowNotification(Request $request)
    {
		try {
            $input = request()->all();
            $userId = $input['user']['user_id'];
			$allow_notifications  = 0;
			if(!empty($input['allow_notifications']) && ($input['allow_notifications'] == 1 OR $input['allow_notifications'] == '1')){
				$allow_notifications  = 1;
			}
			
			User::where('id', $userId)->update(['allow_notifications' => $allow_notifications]);
            return response()->json(['ResponseCode' => 1, 'ReponseText' => 'Notification are blocked successfully','ResponseData'=> NULL],200);
        } catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => __('Something went wrong'), 'ResponseData' => null], 400);
        }
    }
	
	public function delete_profile_picture(Request $request){
		 $user = $request['user'];
        $user_id = $user['user_id'];
        $user_data = User::where('id', $user_id)->first();

        if (file_exists(storage_path('app/public/user/' . $user_data['profile_pic'])) && $user_data['profile_pic'] != '') {
           File::delete('storage/app/public/user/' . $user_data['profile_pic']);
		   $user_data['profile_pic'] = NULL;
		   User::where('id', $user_id)->update(['profile_pic' => NULL]);
        }

        $data['user'] = $user_data;

        return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Success.', 'ResponseData' => $data], 200);
    }
	
	public function customerProfileRequest(Request $request)
    {
		 
		 try {
			$dataRequest = request()->all();
			$userId = $dataRequest['user_id'];
			$store_id = $dataRequest['store_id'];
			$action = $dataRequest['action'];
			$customerRequest  = CustomerRequest::where('user_id',$userId)->where('store_id', $store_id)->first();
			 if($action == 2){
				 CustomerRequest::where('user_id', $userId)->where('store_id', $store_id)->update(['status' => 2]);
				 Notification::where('user_id', $userId)->where('store_id', $store_id)->where('type', 'customer_request')->delete();
				 
				  /** push notification */
				$store_user_id  = StoreProfile::where('id',$store_id)->value('user_id');
				$PUSer = User::find($store_user_id);
				if(!empty($PUSer->device_token)){
					$sessioncount = ApiSession::where('user_id', $PUSer->id)->count();
					if($sessioncount > 0){
						//$registerarion_ids = array($PUSer->device_token);
						$registerarion_ids = ApiSession::where('user_id', $PUSer->id)->pluck('device_token')->toArray(); 
						\BaseFunction::sendPushNotificationServiceProvider($registerarion_ids, "Kundenprofil Anfrage !", "Ihr Kunde hat die Anfrage für das Erstellen eines Kundenprofils abgelehnt.", NULL, $store_id, $store_id, 5);
					}
				}
				
				 \BaseFunction::notification("Kundenprofil Anfrage !", "Ihr Kunde hat die Anfrage für das Erstellen eines Kundenprofils abgelehnt.", 'customer_rejected','',$store_id,$userId,'');
				 return response()->json(['ResponseCode' => 1, 'ReponseText' => 'Customer request declined.','ResponseData'=> null],200);
			 }elseif($action == 1){
				 $User  = User::find($userId);
				 $data   = array();
				 $data['store_id']   		= $store_id;
				 $data['email']   	 		= $User->email;
				 $data['name']   	 		= $User->first_name." ".$User->last_name; 
				 $data['phone_number']   	= $User->phone_number;
				 $data['address']   		= $User->address;
				 $data['state']   			= $User->city;
				 $data['zipcode']   		= $User->zipcode;
				 $Customer 					= Customer::create($data);
				 Notification::where('user_id', $userId)->where('store_id', $store_id)->where('type', 'customer_request')->delete();
				 CustomerRequest::where('user_id', $userId)->where('store_id',$store_id)->delete();
				   /** push notification */
				$store_user_id  = StoreProfile::where('id',$store_id)->value('user_id');
				$PUSer = User::find($store_user_id);
				if(!empty($PUSer->device_token)){
					$sessioncount = ApiSession::where('user_id', $PUSer->id)->count();
					if($sessioncount > 0){
						//$registerarion_ids = array($PUSer->device_token);
						$registerarion_ids = ApiSession::where('user_id', $PUSer->id)->pluck('device_token')->toArray(); 
						\BaseFunction::sendPushNotificationServiceProvider($registerarion_ids, "Kundenprofil Anfrage !", "Ihr Kunde hat die Anfrage für das Erstellen eines Kundenprofils bestätigt.", NULL, $store_id, $Customer->id, 6);
					}
				}
				 \BaseFunction::notification("Kundenprofil Anfrage !", "Ihr Kunde hat die Anfrage für das Erstellen eines Kundenprofils bestätigt.", 'customer_accepted',$Customer->id,$store_id,$userId,'');
				 return response()->json(['ResponseCode' => 1, 'ReponseText' => 'Customer request accepted.','ResponseData'=> null],200);
			 }
			
		} catch (\Swift_TransportException $e) {
			\Log::debug($e);
			return response()->json(['ResponseCode' => 0, 'ResponseText' => __('Something went wrong'), 'ResponseData' => null], 400);
		}
		 if(!empty($store->id)){
			
		 }
		 return redirect('notification');
    }

   public function staticPages(Request $request){
		$data = request()->all();
		$page  = $data['page'];
		if($page == 'agb'){
			$html = view('Includes/Front/AGB')->render();
		}
		if($page == 'datenschutz'){
			$html = view('Includes/Front/datenschutz')->render();
		}
		
		 return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Success.', 'ResponseData' => $html], 200);
	}
}
