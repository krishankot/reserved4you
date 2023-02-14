<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Auth;
use Hash;
use Redirect;
use Socialite;
use Exception;
use Session;
use Mail;

class AuthController extends Controller
{
    public function doLogin(Request $request){

        $this->validate($request,[
            'email'=>'required|email',
            'password'=>'required'
        ]);

        $checkLogin = User::where('email', $request['email'])->first();
        if (empty($checkLogin)) {
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Kundenprofil mit den angegebenen Daten nicht gefunden.', 'ResponseData' => null]);
        }
        $checkloginStatus = User::where('email', $request['email'])->where('status', 'active')->first();
        if (empty($checkloginStatus)) {

            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Kundenprofil mit den angegebenen Daten nicht gefunden.', 'ResponseData' => null]);
        }

        $logindetails = array(
            'email' => $request['email'],
            'password' => $request['password']
        );

        if (Auth::attempt($logindetails)) {
            if (Auth::user()->hasRole('user')) {
                return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Login erfolgreich', 'ResponseData' => null], 200);
            }
            Auth::logout();

            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Anmeldung nur für registrierte Kunden möglich.', 'ResponseData' => null]);

        } else {
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Ungültige Zugangsdaten.', 'ResponseData' => null]);
        }
    }

    public function doRegister(Request $request){
        $this->validate($request,[
            'first_name'=>'required',
            'last_name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required',
        ]);

        $data = $request->all();

        $data['password'] = Hash::make($request['password']);
		$data['status'] = 'inactive';
        $user = new User();
        $user->fill($data);
        if($user->save()){

            $clientrole = Role::where('id',2)->first();
            $user->attachRole($clientrole);

            event(new Registered($user));
            $logindetails = array(
                'email' => $request['email'],
                'password' => $request['password']
            );

            $title =  __('Welcome to Reserved4You, Verify your email');
			$click_key		= $user->id ."###". $user->email;
			$activation_key	= base64_encode($click_key);
			$link		= url("aktiviere-deinen-account/". $activation_key);
							
            $data = ['title' => $title, 'email' => $request['email'], 'name' => $request['first_name'].' '.$request['last_name'], 'link' => $link];
				
					
            try {
                Mail::send('email.activation', $data, function ($message) use ($data) {
                    $message->from(env('MAIL_FROM_ADDRESS',"no-reply@reserved4you.de"), env('MAIL_FROM_NAME',"Reserved4you"))->subject($data['title']);
                    $message->to($data['email']);
                });
				return response()->json(['ResponseCode' => 2, 'ResponseText' => 'Wir haben dir eine E-Mail mit einem Link geschickt. Bitte verifiziere dich damit.'], 200);
            } catch (\Swift_TransportException $e) {
                \Log::debug($e);
            }
			
			
			return response()->json(['ResponseCode' => 3, 'ResponseText' => 'Their is some problem in sending email, please contact to site admin'], 200);
//
           /*  if (Auth::attempt($logindetails)) {
                if (Auth::user()->hasRole('user')) {
                    $va = [
                        'status'=>'2',
                        'data'=>'okay'
                    ];
                    return $va;
                }
            } */


        }else{
			return response()->json(['ResponseCode' => 3, 'ResponseText' => 'Something went wrong, please try again.'], 200);
		}
    }

	public function activate_account($slug = null){
		$data		= base64_decode($slug);
		$userArr 	= explode('###', $data);
		$id   		= (isset($userArr[0]) and $userArr[0])?$userArr[0]:"";
		$email   = (isset($userArr[1]) and $userArr[1])?$userArr[1]:"";
		$user       = User::where('id', $id)->where('email', $email)->first();
			
		if($user){
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
			User::where('id', $id)->update(['status' => 'active', 'email_verified_at' => date('Y-m-d H:i:s')]);
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
			
			if (Auth::loginUsingId($id)) {
                if (Auth::user()->hasRole('user')) {
                  return redirect('/');
                }
            }
			
		}
		return back();
		
	}
		
    public function logout(){
        Auth::logout();
        return Redirect::to('/');
    }

    public function redirectToGoogle(){
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(Request $request){
        try {

            $user = Socialite::driver('google')->user();

            $finduser = User::where('social_type','google')->where('google_id', $user->id)->first();

            if($finduser){

                Auth::login($finduser);

                return redirect('/');

            }else{
                $getEmail = User::where('email',$user->email)->first();
                if(empty($getEmail)){
                    $newUser = User::create([
                        'first_name' => $user->user['given_name'],
                        'last_name' => $user->user['family_name'],
                        'email' => $user->email,
                        'google_id'=> $user->id,
                        'social_type'=> 'google',
                        'password' => encrypt('123456789'),
                        'email_verified_at'=>\Carbon\Carbon::now()->format('Y-m-d h:i:s')
                    ]);

                    $clientrole = Role::where('id',2)->first();
                    $newUser->attachRole($clientrole);
                    Auth::login($newUser);
                } else {
                    $update['first_name'] = $user->user['given_name'];
                    $update['last_name'] = $user->user['family_name'];
                    $update['email'] = $user->email;
                    $update['google_id'] = $user->id;
                    $update['social_type'] = 'google';
                    $update['email_verified_at']= \Carbon\Carbon::now()->format('Y-m-d h:i:s');


                    $userUPdate = User::where('email',$user->email)->update($update);
                    Auth::login($getEmail);
                }



                return redirect('/');
            }

        } catch (Exception $e) {
            //dd($e->getMessage());
			return redirect('/')->with('error', $e->getMessage());
        }
    }

    public function redirectToFacebook(){

        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback(Request $request){
        try {

            $user = Socialite::driver('facebook')->user();

            $finduser = User::where('social_type','facebook')->where('facebook_id', $user->id)->first();

            if($finduser){

                Auth::login($finduser);

                return redirect('/');

            }else{
                $getEmail = User::where('email',$user->email)->first();
                $name = explode(' ',$user->name);

                if(empty($getEmail)){

                    $newUser = User::create([
                        'first_name' => $name[0],
                        'last_name' => $name[1],
                        'email' => $user->email,
                        'facebook_id'=> $user->id,
                        'social_type'=> 'facebook',
                        'password' => encrypt('123456789'),
                        'email_verified_at'=>\Carbon\Carbon::now()->format('Y-m-d h:i:s')
                    ]);

                    $clientrole = Role::where('id',2)->first();
                    $newUser->attachRole($clientrole);

                    Auth::login($newUser);
                } else {
                    $update['first_name'] = $name[0];
                    $update['last_name'] = $name[1];
                    $update['email'] = $user->email;
                    $update['facebook_id'] = $user->id;
                    $update['social_type'] = 'facebook';
                    $update['email_verified_at']= \Carbon\Carbon::now()->format('Y-m-d h:i:s');
                    $userUPdate = User::where('email',$user->email)->update($update);
                    Auth::login($getEmail);
                }


                return redirect('/');
            }

        } catch (Exception $e) {
            //dd($e->getMessage());
			return redirect('/')->with('error', $e->getMessage());
        }
    }
	
	public function resetPassword(Request $request, $slug = null){
		if($slug){
			$request->session()->put('resetPassword', $slug);
			return redirect('reset-passwort');
		}elseif($request->session()->has('resetPassword')){
			$slug = $request->session()->get('resetPassword');
		}else{
			return redirect('/');
		}
		$data		= base64_decode($slug);
		$userArr 	= explode('###', $data);
		$id   		= (isset($userArr[0]) and $userArr[0])?$userArr[0]:"";
		$email   	= (isset($userArr[1]) and $userArr[1])?$userArr[1]:"";
		$user       = User::where('id', $id)->where('email', $email)->first();
			
		if($user){
			if($request->isMethod('post')){
				 $this->validate($request,[
					'new_password'=>'required|min:5'
				]);
				
				$newpassword['password'] = Hash::make($request->new_password);

				$update = User::where('email', $email)->update($newpassword);
			
				$isactive  = User::where('id', $id)->where('email', $email)->where('status', 'active')->first();
				if($isactive){
					 $request->session()->forget('resetPassword');
					if (Auth::loginUsingId($id)) {
						if (Auth::user()->hasRole('user')) {
						  return redirect('/');
						}
					}
				}
				return redirect('/');
				
			}
			return view('Front/Auth/resetPassword');
		}
		return back();
		
	}
	
    public function forgotPassword(Request $request){
        $this->validate($request,[
            'email'=>'required|email',
        ]);
        $email = $request['email'];

        $check_user = User::where('email', $email)->first();

        if (empty($check_user)) {
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Email not registered', 'ResponseData' => null], 200);
        } else {
            /* $password = \BaseFunction::random_code(8);
            $newpassword['password'] = Hash::make($password);

            $update = User::where('email', $email)->update($newpassword); */

            $title = __('Password reset');
            $name = $check_user['first_name'];
			$click_key		= $check_user->id ."###". $check_user->email;
			$key	= base64_encode($click_key);
			$link	= route("resetPassword", $key);
			
			
            $data = ['title' => $title, 'email' => $email, 'name' => $name, 'link' => $link];
			//return view('email.pass_reset', $data);
            try {
                Mail::send('email.pass_reset', $data, function ($message) use ($data) {
                    $message->from(env('MAIL_FROM_ADDRESS',"no-reply@reserved4you.de"), env('MAIL_FROM_NAME',"Reserved4you"))->subject($data['title']);
                    $message->to($data['email']);
                });

                return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Wir haben Ihnen eine E-Mail mit einem Link gesendet. Bitte setzen Sie damit Ihr Passwort zurück.', 'ResponseData' => null], 200);
            } catch (\Swift_TransportException $e) {
                \Log::debug($e);
                return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 200);
            }
        }
    }
}
