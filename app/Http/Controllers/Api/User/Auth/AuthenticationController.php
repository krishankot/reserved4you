<?php

namespace App\Http\Controllers\Api\User\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\AppleUser;
use App\Models\Role;
use App\Models\Customer;
use App\Models\Appointment;
use App\Models\ApiSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;
use URL;
use Mail;
use File;

class AuthenticationController extends Controller
{
    
    /**
     * Authentication APi
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function authentication(Request $request)
    {
        $rule = [
            'email' => 'required',
            'password' => 'required'
        ];

        $message = [
            'email.required' => 'E-Mail erforderlich',
            'password.required' => 'Passwort erforderlich'
        ];

        $validate = Validator::make($request->all(), $rule, $message);

        if ($validate->fails()) {
            return response()->json(['ResponseCode' => 0, 'ResponseText' => __('Validation failed'), 'ResponseData' => $validate->errors()->all()], 422);
        }

        $user = User::where('email', $request['email'])->where('status','active')->first();

        if (!empty($user)) {

            if (Hash::check($request['password'], $user->password)) {
                $token = \BaseFunction::setSessionData($user->id);
				$dataUpdate = array();
				if(!empty($request['device_token'])){
					$dataUpdate['device_token'] = $request['device_token'];
				}
				if(!empty($request['device_id'])){
					$dataUpdate['device_id'] = $request['device_id'];
				}
				if(!empty($request['device_type'])){
					$dataUpdate['device_type'] = $request['device_type'];
				}
				if($dataUpdate){
					if(!empty($request['device_token'])){
						User::where('device_token', $request['device_token'])->update(['device_token' => NULL, 'device_id' => NULL, 'device_type' => NULL]);
					}
					User::where('id', $user->id)->update($dataUpdate);
				}
				
				
                // if (file_exists(storage_path('app/public/user/' . $user['profile_pic'])) && $user['profile_pic'] != '') {
                //     $user['profile_pic'] = URL::to('storage/app/public/user/' . $user['profile_pic']);
                // } else {
                //     $user['profile_pic'] = URL::to('storage/app/public/default/default_user.jpg');
                // }

                $data = ['token' => $token, 'user' => $user];

                unset($user['roles']);
                return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Login erfolgreich', 'ResponseData' => $data], 200);

            } else {
                return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Ungültiges Passwort', 'ResponseData' => null], 200);
            }

        } else {
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'E-Mail noch nicht registriert', 'ResponseData' => null], 200);
        }

    }

	
	
    /**
     * Check email exist User APi
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
	 
	 public function email_exist(Request $request){
		  $rule = [
            'email' => 'required|email|unique:users',
			'phone_number' => 'required|unique:users'
        ];
        $message = [
			'email.required' => __('Email/username is required'),
			'phone_number.required' => __('Phone number is required'),
			'email.email' => __('Invalid Email'),
			'email.unique' => __('Email is already registered'),
			'phone_number.unique' => __('Phone is already registered'),
        ];
        $validate = Validator::make($request->all(), $rule, $message);

        if ($validate->fails()) {
            return response()->json(['ResponseCode' => 0, 'ResponseText' => __('Validation failed'), 'ResponseData' => $validate->errors()->all()], 422);
        }else{
			 return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Email not registered yet', 'ResponseData' => 1], 200);
		}
	 }
	
    /**
     * Register User APi
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $rule = [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users',            
            'password' => ['required','min:8','regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x]).*$/']
        ];
        $message = [
            'first_name.required' => __('First Name is required'),
            'last_name.required' => __('Last Name is required'),
            'email.required' => __('Email/username is required'),
			'email.email' => __('Invalid Email'),
			'email.unique' => __('Email is already registered'),
            'password.required' => __('Passwort erforderlich'),
            'password.min' => __('password Must be 8 Characters'),
        ];
        $validate = Validator::make($request->all(), $rule, $message);

        if ($validate->fails()) {
            return response()->json(['ResponseCode' => 0, 'ResponseText' => __('Validation failed'), 'ResponseData' => $validate->errors()->all()], 422);
        }
        $otp		= rand(100000, 999999);
        $data['first_name'] = $request['first_name'];
        $data['last_name'] = $request['last_name'];
        $data['email'] = $request['email'];
		$data['phone_number'] = $request['phone_number'];
        $data['password'] = Hash::make($request['password']);
        $data['device_token'] = $request['device_token'];
        $data['device_id'] = $request['device_id'];
        $data['device_type'] = $request['device_type'];
		$data['status'] = 'active';
		//$data['otp'] = $otp;
		$data['join_newsletter'] = !empty($request['join_newsletter'])?$request['join_newsletter']:0;
        if(!empty($request['device_token'])){
			User::where('device_token', $request['device_token'])->update(['device_token' => NULL, 'device_id' => NULL, 'device_type' => NULL]);
		}
        $user = new User();
        $user->fill($data);

        if($user->save()){

            $clientrole = Role::where('id', 2)->first();
            $user->attachRole($clientrole);

            if (file_exists(storage_path('app/public/user/' . $user['profile_pic'])) && $user['profile_pic'] != '') {
                $user['profile_pic'] = URL::to('storage/app/public/user/' . $user['profile_pic']);
            } else {
                $user['profile_pic'] = URL::to('storage/app/public/default/default_user.jpg');
            }
			
		/* 	$title = __('Welcome to Reserved4You, Verify your email');
            $data = ['title' => $title, 'email' => $request['email'], 'name' => $request['first_name'].' '.$request['last_name'], 'otp' => $otp]; */
			
			$title = __('Welcome to Reserved4You, Your account has been activated');
							
			$data = ['title' => $title, 'email' =>  $request['email'], 'name' => $request['first_name'].' '.$request['last_name']];
			
			try {
				Mail::send('email.welcome', $data, function ($message) use ($data) {
					$message->from(env('MAIL_FROM_ADDRESS',"no-reply@reserved4you.de"), env('MAIL_FROM_NAME',"Reserved4you"))->subject($data['title']);
					$message->to($data['email']);
				});
			} catch (\Swift_TransportException $e) {
				\Log::debug($e);
			}
					
            /* try {
                Mail::send('email.activation_mob', $data, function ($message) use ($data) {
                    $message->from(env('MAIL_FROM_ADDRESS',"no-reply@reserved4you.de"), env('MAIL_FROM_NAME',"Reserved4you"))->subject($data['title']);
                    $message->to($data['email']);
                });
				
            } catch (\Swift_TransportException $e) {
                \Log::debug($e);
            } */
			
			
            $token = \BaseFunction::setSessionData($user->id);
			//$token = NULL;
            $createdUser = User::where('email', $user['email'])->where('status','active')->first();
            $datas = ['token' => $token, 'user' => $createdUser];
            return response()->json(['ResponseCode' => 1, 'ResponseText' => __("Registered Successfully, Please check you email for OTP."), 'ResponseData' => $datas], 200);
        }
    }
	
	
	/**verify email api
	@param Request $request
	 * @return \Illuminate\Http\JsonResponse
     */
	 
	 public function verifyEmail(Request $request)
    {
        try {
            $data  = request()->all();
            
            $otp = $data['otp'];
            $email = $data['email'];
            $user = User::where('email',$email)->first();
            if(!empty($user->otp) and $otp == $user->otp) {
				User::where('id', $user->id)->update(['status' => 'active', 'email_verified_at' => date('Y-m-d H:i:s'), 'otp' => NULL]);
				$user = User::where('email',$email)->first();
				$customercount = Customer::where('email', $email)->count();
				if($customercount > 0){
					$customerData 				= array();
					$customerData['name'] 		= $user->first_name.' '.$user->last_name;
					$customerData['user_id'] 	= $user->id;
					if(!empty($user->phone_number)){
						$customerData['phone_number'] 	= $user->phone_number;
					}
					Customer::where('email', $email)->update($customerData);
				}
				
				$token = \BaseFunction::setSessionData($user->id);
				$datas = ['token' => $token, 'user' => $user];
				
				$title = __('Welcome to Reserved4You, Your account has been activated');
							
				$data = ['title' => $title, 'email' =>  $email, 'name' => $user['first_name'].' '.$user['last_name']];
				
				try {
					Mail::send('email.welcome', $data, function ($message) use ($data) {
						$message->from(env('MAIL_FROM_ADDRESS',"no-reply@reserved4you.de"), env('MAIL_FROM_NAME',"Reserved4you"))->subject($data['title']);
						$message->to($data['email']);
					});
				} catch (\Swift_TransportException $e) {
					\Log::debug($e);
				}
								
				
                return response()->json(['ResponseCode' => 1, 'ResponseText' => __('Email verified successfully'), 'ResponseData' => $datas], 200);
            }
            return response()->json(['ResponseCode' => 0, 'ResponseText' => __('Wrong OTP Provided'), 'ResponseData' => null], 400);
        } catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => __('Something went wrong'), 'ResponseData' => null], 400);
        }
    }

	/**resend email api
	@param Request $request
	 * @return \Illuminate\Http\JsonResponse
     */
	 
	 public function resendEmail(Request $request)
    {
        try {
            $data  = request()->all();
            
            $email = $data['email'];
            $user = User::where('email',$email)->first();
            if(!empty($user->otp)) {
				$title = __('Welcome to Reserved4You, Verify your email');
				$data = ['title' => $title, 'email' => $user->email, 'name' => $user->first_name.' '.$user->last_name, 'otp' => $user->otp];
						
				try {
					Mail::send('email.welcome_mob', $data, function ($message) use ($data) {
						$message->from(env('MAIL_FROM_ADDRESS',"no-reply@reserved4you.de"), env('MAIL_FROM_NAME',"Reserved4you"))->subject($data['title']);
						$message->to($data['email']);
					});
					
				} catch (\Swift_TransportException $e) {
					\Log::debug($e);
				}
                return response()->json(['ResponseCode' => 1, 'ResponseText' => __('Email resend successfully'), 'ResponseData' => Null], 200);
            }
            return response()->json(['ResponseCode' => 0, 'ResponseText' => __('Something went wrong'), 'ResponseData' => null], 400);
        } catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => __('Something went wrong'), 'ResponseData' => null], 400);
        }
    }

    /**
     * Forgot Password
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function forgotPassword(Request $request){
        $rule = [
            'email' => 'required',
        ];
        $message = [
            'email.required' => 'E-Mail erforderlich',
        ];
        $validate = Validator::make($request->all(), $rule, $message);

        if ($validate->fails()) {
            return response()->json(['ResponseCode' => 0, 'ResponseText' => __('Validation failed'), 'ResponseData' => $validate->errors()->all()], 422);
        }
        $email = $request['email'];
        
        $check_user = User::where('email', $email)->first();
        
        if (empty($check_user)) {
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'E-Mail noch nicht registriert', 'ResponseData' => null], 422);
        } else {
            $password = \BaseFunction::random_code(8);
            $newpassword['password'] = Hash::make($password);

           // $update = User::where('email', $email)->update($newpassword);

            $title = __('Password reset');
            $name = $check_user['first_name'];
            $data = ['title' => $title, 'email' => $email, 'name' => $name, 'password' => $password];
			
			 $name = $check_user['first_name'];
			$click_key		= $check_user->id ."###". $check_user->email;
			$key	= base64_encode($click_key);
			$link	= route("resetPassword", $key);
			
			
            $data = ['title' => $title, 'email' => $email, 'name' => $name, 'link' => $link];
			
            try {
                Mail::send('email.pass_reset', $data, function ($message) use ($data) {
                    $message->from(env('MAIL_FROM_ADDRESS',"no-reply@reserved4you.de"), env('MAIL_FROM_NAME',"Reserved4you"))->subject($data['title']);
                    $message->to($data['email']);
                });

                return response()->json(['ResponseCode' => 1, 'ResponseText' => __('New Password Sent to Email Address'), 'ResponseData' => null], 200);
            } catch (\Swift_TransportException $e) {
                \Log::debug($e);
                return response()->json(['ResponseCode' => 0, 'ResponseText' => __('Something went wrong'), 'ResponseData' => null], 400);
            }
        }

    }
	
	

    /**
     * Logout API
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $user = $request['user'];
        $user_id = $user['user_id'];
        ApiSession::where('user_id', $user_id)->delete();
        return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Successfully logout', 'ResponseData' => null]);
    }

    //user change password
    public function changePassword(Request $request)
    {
        
        $rule = [
            'current_password' => 'required',
            // 'new_password' => 'required|min:8',                        
            'new_password' => ['required','min:8','regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x]).*$/'],                    
            'confirm_password' => 'required|same:new_password'
        ];
        $message = [
            'current_password.required' => 'current Passwort erforderlich',
            'new_password.required' => 'Passwort erforderlich',
            'new_password.min' => 'password Must be 8 Characters',
            'confirm_password.required' => 'confirm Passwort erforderlich',           

        ];
        $validate = Validator::make($request->all(), $rule, $message);

        if ($validate->fails()) {
            return response()->json(['ResponseCode' => 0, 'ResponseText' => __('Validation failed'), 'ResponseData' => $validate->errors()->all()], 422);
        }
        try {
            $data  = request()->all();
            
            $newPassword = Hash::make($data['new_password']);
            $userId = $data['user']['user_id'];
            $updatePassword = User::where('id',$userId)->update(['password' => $newPassword]);
            if ($updatePassword) {
                return response()->json(['ResponseCode' => 1, 'ResponseText' => __('Password Changed Successfully'), 'ResponseData' => null], 200);
            }
            return response()->json(['ResponseCode' => 0, 'ResponseText' => __('Something went wrong'), 'ResponseData' => null], 400);
        } catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => __('Something went wrong'), 'ResponseData' => null], 400);
        }
    }

    //user social login
     /*social login*/
     public function socialLogin(Request $request)
     {
         $rule = [
           // 'user_name' => 'required',
            'device_id' => 'required',
            'device_type' => 'required',
            'social_id' => 'required',
            'social_type' => 'required',
        ];
        $message = [
            'user_name.required' => 'user_name is required',
            'device_id.required' => 'device_id is required',
            'device_type.required' => 'device_type is required',
            'social_id.required' => 'social_id is required',
            'social_type.required' => 'social_type is required',

        ];
        $validate = Validator::make($request->all(), $rule, $message);

        if ($validate->fails()) {
            return response()->json(['ResponseCode' => 0, 'ResponseText' => __('Validation failed'), 'ResponseData' => $validate->errors()->all()], 422);
        }
         try
         {
             $data = request()->all();  
                        
             $user = User::orderBy('id', 'DESC');
			  if(!empty($data['email'])){
				   $user = $user->where('email', $data['email']);
			  } 
			
			 if(empty($data['email']) and !empty($data['social_id']) and $data['social_type'] != 'apple'){
				 $user = $user->orWhere('google_id' , $data['social_id'])->orWhere('facebook_id' , $data['social_id']);
			 }
			 if(empty($data['email']) and !empty($data['user_id']) and $data['social_type'] == 'apple'){
				  $user = $user->orWhere('apple_user_id' , $data['user_id']);
			 }
             
			 $user = $user->first();
             
			 if(!empty($user->id) && empty($data['email']) and $data['social_type'] == 'apple'){
				  /* $datas = ['isavailableemail' =>false, 'attempt' => 'second','user' => $user];
				  return response()->json(['ResponseCode' => 0, 'ResponseText' => "Successfully", 'ResponseData' => $datas], 400); */
			 }elseif(empty($user->id) && empty($data['email']) and $data['social_type'] == 'apple'){
				 $AppleUser  = AppleUser::where('apple_user_id', $data['user_id'])->first();
				 if(!empty($AppleUser->id)){
					 $user = new User();
					 $user->first_name   = $AppleUser->first_name;
					 $user->last_name    = $AppleUser->last_name;
					 $user->email        = $AppleUser->email;
					 $user->apple_id        = $AppleUser->apple_id;
					 $user->apple_user_id        = $AppleUser->apple_user_id;
					 $user->social_type  = $data['social_type'];                                                 
					 $user->device_id    = $data['device_id'];                 
					 $user->device_type  = $data['device_type'];                 
					 $user->device_token = $data['device_token']; 
					 $user->save();
					 if ($user) {
						/*assign role*/
						$userRole = Role::where('id', 2)->first();
						$user->attachRole($userRole);                    
						$token = \BaseFunction::setSessionData($user->id);
			
						$datas = ['token' => $token, 'user' => $user];
						return response()->json(['ResponseCode' => 1, 'ResponseText' => "Successfully", 'ResponseData' => $datas], 200);
					}
				 }else{
					$datas = ['isavailableemail' =>false, 'attempt' => 'first','user' => NULL];
					return response()->json(['ResponseCode' => 0, 'ResponseText' => "Successfully", 'ResponseData' => $datas], 400);
				 }
			 }
             $names = explode(" ", $data['user_name']);
			 $first_name = !empty($data['first_name'])?$data['first_name']:(!empty($names[0])?$names[0]:'');
			 $last_name = !empty($data['last_name'])?$data['last_name']:(!empty($names[1])?$names[1]:'');
             
             if ($user == null) {
                 $user = new User();
                 $user->first_name   = $first_name;
                 $user->last_name    =  $last_name;
                 $user->email        = isset($data['email']) == false ? null : $data['email'];
				  if(!empty($data['profile_pic']) && strpos($data['profile_pic'], 'http') !== false){
					$url = $data['profile_pic'];
					$file_name = 'user-' . uniqid() . '.jpeg';
					$contents = file_get_contents($url);
					$uploadfile = 'storage/app/public/user/'.$file_name; 
					$upload =file_put_contents($uploadfile, $contents);
					$user->profile_pic  = $file_name;   
				 }
                 //$user->profile_pic  = $data['profile_pic'];                 
                 $user->social_type  = $data['social_type'];                                                 
                 $user->device_id    = $data['device_id'];                 
                 $user->device_type  = $data['device_type'];                 
                 $user->device_token = $data['device_token']; 
				 if($data['user_id']){
					  $user->apple_user_id = $data['user_id']; 
				 }
				 if(!empty($data['device_token'])){
					User::where('device_token', $data['device_token'])->update(['device_token' => NULL, 'device_id' => NULL, 'device_type' => NULL]);
				}

                if($data['social_type'] == 'facebook'){
                    $user->facebook_id = $data['social_id'];
                }elseif($data['social_type'] == 'apple'){
                    $user->apple_id = $data['social_id'];
                }else{
                    $user->google_id = $data['social_id'];
                }                                 
                $user->save();
				
                if ($user) {
                    /*assign role*/
					if($data['social_type'] == 'apple'){
						$AppleUser  = AppleUser::where('apple_user_id', $data['user_id'])->first();
						if(!empty($AppleUser->id)){
							AppleUser::where('id', $AppleUser->id)->update(['email' => $user->email, 'first_name' => $user->first_name, 'last_name' => $user->last_name, 'apple_id' => $user->apple_id, 'apple_user_id' => $user->apple_user_id, 'social_type' => $user->social_type]);
						}else{
							AppleUser::create(['email' => $user->email, 'first_name' => $user->first_name, 'last_name' => $user->last_name, 'apple_id' => $user->apple_id, 'apple_user_id' => $user->apple_user_id, 'social_type' => $user->social_type]);
						}
					}
					$userRole = Role::where('id', 2)->first();
					$user->attachRole($userRole);                    
					$token = \BaseFunction::setSessionData($user->id);
		
					$datas = ['token' => $token, 'user' => $user];
					return response()->json(['ResponseCode' => 1, 'ResponseText' => "Successfully", 'ResponseData' => $datas], 200);
                }                 
                 
             }  else {                  
                $userdata = [];
				if(!empty($first_name)){
					$userdata['first_name']  = $first_name;
					$userdata['last_name']   = $last_name;
				}
				if(!empty($data['email'])){
					$userdata['email']       = isset($data['email']) == false ? null : $data['email'];
				}
               // $userdata['profile_pic'] = $data['profile_pic'];    
				if(!empty($data['profile_pic']) && strpos($data['profile_pic'], 'http') !== false){
					$url = $data['profile_pic'];
					$file_name = 'user-' . uniqid() . '.jpeg';
					$contents = file_get_contents($url);
					$uploadfile = 'storage/app/public/user/'.$file_name; 
					$upload =file_put_contents($uploadfile, $contents);
					$oldimage = User::where('id', $user->id)->value('profile_pic');
					if (!empty($oldimage)) {
						File::delete('storage/app/public/user/' . $oldimage);
					}
					$userdata['profile_pic']  = $file_name;   
				}			   
                $userdata['social_type'] = $data['social_type'];
                // $userdata['social_id']   = $data['social_id'];
                $userdata['device_id']   = $data['device_id'];                 
                $userdata['device_type'] = $data['device_type'];                 
                $userdata['device_token']= $data['device_token']; 
                if(!empty($data['device_token'])){
					User::where('device_token', $data['device_token'])->update(['device_token' => NULL, 'device_id' => NULL, 'device_type' => NULL]);
				}
                if($data['social_type'] == 'facebook'){
                    $userdata['facebook_id'] = $data['social_id'];
                }elseif ($data['social_type'] == 'apple') {
                    $userdata['apple_id'] = $data['social_id'];
                }else{
                    $userdata['google_id'] = $data['social_id'];
                }
                $updateUser = User::where('id',$user->id)->update($userdata);                 
 
                $user =User::where('id',$user->id)->first();
                
                $token = \BaseFunction::setSessionData($user->id);                
                $datas = ['token' => $token, 'user' => $user];
                return response()->json(['ResponseCode' => 1, 'ResponseText' => "Successfully", 'ResponseData' => $datas], 200);
             }
 
         } catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => __('Something went wrong'), 'ResponseData' => null], 400);
        }
     }
 
    /**
     * guest user
     */
    public function guestUser(Request $request)
    {
        // $rule = [
        //     'first_name' => 'required',
        //     'last_name' => 'required',
        //     'email' => 'required',
        //     'phone_number' => 'required',            
        // ];
        // $message = [
        //     'first_nmae.required' => 'first name is required',
        //     'last_name.required' => 'last name is required',
        //     'email.required' => 'E-Mail erforderlich',
        //     'phone_number.required' => 'phone number is required',

        // ];
        // $validate = Validator::make($request->all(), $rule, $message);

        // if ($validate->fails()) {
        //     return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Validation Fails', 'ResponseData' => $validate->errors()->all()], 422);
        // }
        try {
            $data = request()->all();                    
            $checkGuestUser = User::where('device_id',$data['device_id'])->first();                        
            if (empty($checkGuestUser)) {
                $user = new User();
                $user->device_id = $data['device_id'];
                $user->device_token = $data['device_token'];
                $user->device_type = $data['device_type'];
				if(!empty($data['device_token'])){
					User::where('device_token', $data['device_token'])->update(['device_token' => NULL, 'device_id' => NULL, 'device_type' => NULL]);
				}
                $user->save();
                $datas = ['token' => false,'user' => NULL];
                return response()->json(['ResponseCode' => 1, 'ResponseText' => "Registration Successfully", 'ResponseData' => $datas], 200);
            }else{                  
                if (isset($data['email']) && isset($data['first_name']) && isset($data['last_name']) && isset($data['phone_number'])) {
                    $checkEmail = User::where('email',$data['email'])->first();
                    if(empty($checkEmail['email'])){
                        $checkGuestUserUpdate = User::updateOrCreate(
                            [
                                'id' =>$checkGuestUser->id
                            ],
                            [
                                'first_name' => $data['first_name'],
                                'last_name' => $data['last_name'],
                                'email' => $data['email'],
                                'phone_number' => $data['phone_number'],
                                'user_type' => $data['user_type']
                            ]);                    
                        if($checkGuestUserUpdate){
                            /**assign roles */
                            $userRole = Role::where('id', 2)->first();
                            $checkGuestUserUpdate->attachRole($userRole);
                
                            $token = \BaseFunction::setSessionData($checkGuestUserUpdate->id);
                            $createdUser = User::where('email', $checkGuestUserUpdate['email'])->where('status','active')->first();
                            $datas = ['token' => $token, 'user' => $createdUser];
                            return response()->json(['ResponseCode' => 1, 'ResponseText' => "Registration Successfully", 'ResponseData' => $datas], 200);
                        }
                    }else{                        
                        $token = \BaseFunction::setSessionData($checkEmail->id);
                        $data = ['token' => $token, 'user' => $checkEmail];            
                        return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Login erfolgreich', 'ResponseData' => $data], 200);            
                    }
    
                }else{  
                    if(empty($checkGuestUser['email'])){
                        $token = \BaseFunction::setSessionData($checkGuestUser->id);
                        $data = ['token' => false, 'user' => $checkGuestUser];            
                        return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Login erfolgreich', 'ResponseData' => $data], 200);            
                    }                     
                        $token = \BaseFunction::setSessionData($checkGuestUser->id);
                        $data = ['token' => $token, 'user' => $checkGuestUser];            
                        return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Login erfolgreich', 'ResponseData' => $data], 200);            
                }
            }
        } catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => __('Something went wrong'), 'ResponseData' => null], 400);
        }
    }

    /**
     * delete user profile
     */
    public function deleteUserProfile(Request $request)
    {
        try {
            $userId = $request['user']['user_id'];
            $user  = User::where('id', $userId)->first();
			/* if(!empty($user->apple_user_id)){
				$AppleUser  = AppleUser::where('apple_user_id', $user->apple_user_id)->first();
				if(!empty($AppleUser->id)){
					$AppleUser->update(['email' => $user->email, 'first_name' => $user->first_name, 'first_name' => $user->last_name, 'apple_id' => $user->apple_id, 'apple_id' => $user->apple_user_id, 'social_type' => $user->social_type]);
				}else{
					AppleUser::create(['email' => $user->email, 'first_name' => $user->first_name, 'first_name' => $user->last_name, 'apple_id' => $user->apple_id, 'apple_id' => $user->apple_user_id, 'social_type' => $user->social_type]);
				}
			} */
			if (file_exists(storage_path('app/public/user/' . $user->profile_pic)) && $user->profile_pic != '') {
			    File::delete('storage/app/public/user/' . $user->profile_pic);
			}
			$newemail = "gelöschter.kunde@".md5($user->email.'#'.$user->id).'.de';
			$first_name = "gelöschter";
			$last_name  = "Kunde";
			Appointment::where('email', $user->email)->update(['email' => $newemail, 'first_name' => $first_name, 'last_name' => $last_name]);
			Customer::where('email', $user->email)->update(['email' => $newemail, 'name' => $first_name.' '.$last_name]);
            User::where('id', $user->id)->update(['status' => 'inactive', 'profile_pic' => NULL, 'phone_number' => NULL, 'apple_user_id' => NULL,  'apple_id' => NULL, 'email' => $newemail, 'first_name' => $first_name, 'last_name' => $last_name]);
            ApiSession::where('user_id', $user->id)->delete();
			
            //$deleteUser = User::where('id',$userId)->delete();
            return response()->json(['ResponseCode' => 1, 'ResponseText' => __('User Profile Deleted Successfully'), 'ResponseData' => []], 200);            
        } catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => __('Something went wrong'), 'ResponseData' => null], 400);
        }
    }
    
}
