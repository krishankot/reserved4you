<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use App\Models\AppointmentData;
use App\Models\Appointment;
use App\Models\Customer;
use App\Models\ApiSession;
use App\Models\CustomerRequest;
use App\Models\Category;
use App\Models\Contactus;
use App\Models\Favourite;
use App\Models\PaymentMethodInfo;
use App\Models\Service;
use App\Models\ServiceAppoinment;
use App\Models\ServiceVariant;
use App\Models\StoreCategory;
use App\Models\StoreEmp;
use App\Models\StoreGallery;
use App\Models\StoreProfile;
use App\Models\StoreRatingReview;
use App\Models\TempServiceStore;
use App\Models\Notification;
use Illuminate\Http\Request;
use Auth;
use File;
use Illuminate\Support\Facades\Session;
use URL;
use Hash;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $date = \Carbon\Carbon::now()->format('Y-m-d');

        $pendingAppointments = AppointmentData::leftjoin('appointments', 'appointments.id', '=', 'appointment_data.appointment_id')
            ->leftjoin('payment_method_infos', 'payment_method_infos.appoinment_id', '=', 'appointments.id')
            ->where(function ($query) {
                $query->Where('appointment_data.status', 'pending')
                    ->orWhere('appointment_data.status', 'booked')
                    ->orWhere('appointment_data.status', 'reschedule');
            })
            ->where('appointments.user_id', Auth::user()->id)
            ->select('appointment_data.*', 'payment_method_infos.status as payment_status', 'appointments.order_id')
            ->get();
        $pendingAppointment = [];
        foreach ($pendingAppointments as $row) {
            $storeData = StoreProfile::findorFail($row->store_id);
            $row->storeData = $storeData;
            $row->image = Service::where('id', $row->service_id)->value('image');
            @$row->variantData = ServiceVariant::where('id', $row->variant_id)->first();
            $row->empData = StoreEmp::where('id', $row->store_emp_id)->first();
            $row->cancellation = \BaseFunction::checkCancelRatio($row->store_id, $row->appointment_id);
            $pendingAppointment[$row->appo_date][] = $row;
        }

        ksort($pendingAppointment);

        $runningAppointments = AppointmentData::leftjoin('appointments', 'appointments.id', '=', 'appointment_data.appointment_id')
            ->leftjoin('payment_method_infos', 'payment_method_infos.appoinment_id', '=', 'appointments.id')
            ->Where('appointment_data.status', 'running')
            ->where('appointments.user_id', Auth::user()->id)
            ->select('appointment_data.*', 'payment_method_infos.status as payment_status', 'appointments.order_id')
            ->orderBy('appointment_data.appo_date', 'Desc')
            ->get();

        foreach ($runningAppointments as $row) {
            $storeData = StoreProfile::findorFail($row->store_id);
            $row->storeData = $storeData;
            $row->variantData = ServiceVariant::where('id', $row->variant_id)->first();
            $row->empData = StoreEmp::where('id', $row->store_emp_id)->first();
            $row->image = Service::where('id', $row->service_id)->value('image');
        }

        $completeAppointments = AppointmentData::leftjoin('appointments', 'appointments.id', '=', 'appointment_data.appointment_id')
            ->leftjoin('payment_method_infos', 'payment_method_infos.appoinment_id', '=', 'appointments.id')
            ->Where('appointment_data.status', 'completed')
            ->where('appointments.user_id', Auth::user()->id)
            ->select('appointment_data.*', 'payment_method_infos.status as payment_status', 'appointments.order_id')
            ->orderBy('appointment_data.appo_date', 'Desc')
            ->get();

        foreach ($completeAppointments as $row) {
            $storeData = StoreProfile::findorFail($row->store_id);
            $row->storeData = $storeData;
            $row->variantData = ServiceVariant::where('id', $row->variant_id)->first();
            $row->empData = StoreEmp::where('id', $row->store_emp_id)->first();
            $row->image = Service::where('id', $row->service_id)->value('image');
			
			if ($row->status == 'completed') {
                $checkReview = StoreRatingReview::where('appointment_id', $row->id)->first();
                if (!empty($checkReview)) {
                    $row->is_reviewed = $checkReview;
                } else {
                    $row->is_reviewed = '';
                }
            } else {
                $row->is_reviewed = '';
            }
        }

        $cancelAppointments = AppointmentData::leftjoin('appointments', 'appointments.id', '=', 'appointment_data.appointment_id')
            ->leftjoin('payment_method_infos', 'payment_method_infos.appoinment_id', '=', 'appointments.id')
            ->Where('appointment_data.status', 'cancel')
            ->where('appointments.user_id', Auth::user()->id)
            ->select('appointment_data.*', 'payment_method_infos.status as payment_status', 'appointments.order_id')
            ->orderBy('appointment_data.appo_date', 'Desc')
            ->get();

        foreach ($cancelAppointments as $row) {
            $storeData = StoreProfile::findorFail($row->store_id);
            $row->storeData = $storeData;
            $row->variantData = ServiceVariant::where('id', $row->variant_id)->first();
            $row->empData = StoreEmp::where('id', $row->store_emp_id)->first();
            $row->image = Service::where('id', $row->service_id)->value('image');
        }


        $favorites = Favourite::leftjoin('store_profiles', 'store_profiles.id', '=', 'favourites.store_id')
            ->leftjoin('store_categories', 'store_categories.store_id', '=', 'store_profiles.id')
            ->where('favourites.user_id', Auth::user()->id)
            ->select('store_profiles.*')
            ->where('store_profiles.store_status', 'active')
            ->distinct('store_profiles.id')
            ->get();

        foreach ($favorites as $row) {
            $row->categories = StoreCategory::where('store_id', $row->id)->get();
            $row->rating = \BaseFunction::finalRating($row->id);
            $row->ratingCount = \BaseFunction::finalCount($row->id);
            $row->storeGallery = StoreGallery::where('store_id', $row->id)->get();
            $categories = StoreCategory::where('store_id', $row->id)->groupBy('category_id')->pluck('category_id')->all();
            $row->storeCategory = $categories;
            foreach (@$row->storeCategory as $key => $cat) {
                @$cat->CategoryData;
            }
            if (Auth::check()) {
                $favor = Favourite::where('user_id', Auth::user()->id)->where('store_id', $row->id)->first();
                if (!empty($favor)) {
                    $row->isFavorite = 'true';
                } else {
                    $row->isFavorite = 'false';
                }
            }
        }

        $appointments = AppointmentData::leftjoin('appointments', 'appointments.id', '=', 'appointment_data.appointment_id')
            ->leftjoin('payment_method_infos', 'payment_method_infos.appoinment_id', '=', 'appointments.id')
            ->where('appointments.user_id', Auth::user()->id)
            ->select('appointment_data.*', 'payment_method_infos.status as payment_status', 'payment_method_infos.payment_method', 'appointments.order_id')
            ->get();
        $calander = [];
        foreach ($appointments as $row) {
            $storeData = StoreProfile::findorFail($row->store_id);
            $row->storeData = $storeData;
            $row->image = Service::where('id', $row->service_id)->value('image');
            $row->variantData = ServiceVariant::where('id', $row->variant_id)->first();
            $row->empData = StoreEmp::where('id', $row->store_emp_id)->first();
            if ($row->status == 'pending' || $row->status == 'booked' || $row->status == 'reschedule') {

                $row->cancellation = \BaseFunction::checkCancelRatio($row->store_id, $row->appointment_id);
            } else {
                $row->cancellation = '';
            }
            $des = view('Front.User.calender_details', compact('row'))->render();
            $endtime = \Carbon\Carbon::parse($row->appo_time)->addMinutes(@$row->variantData['duration_of_service'])->format('H:i:s');
            $startDate = date('Y-m-d H:i:s', strtotime("$row->appo_date  $row->appo_time"));
            $endDate = date('Y-m-d H:i:s', strtotime("$row->appo_date  $endtime"));
            $row->der = $des;
			if($row->status != 'cancel'){
				$calander[] = array('title' => ucfirst($row->service_name), 'start' => $startDate, 'end' => $endDate, 'description' => $des, 'app_id' => $row->id);
			}
		}


        return view('Front.User.index', compact('favorites', 'pendingAppointment', 'runningAppointments', 'completeAppointments', 'cancelAppointments', 'calander'));
    }

    public function updateProfile(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email,' . Auth::user()->id,
        ]);

        $data = $request->all();

        $data = $request->except('_token');
		if($data['email'] != Auth::User()->email){
			//Customer::where('email', Auth::User()->email)->update(array('email' => $data['email']));
			Appointment::where('email', Auth::User()->email)->update(array('email' => $data['email']));
		}
		
		$customerData 			= array();
		$customerData['name'] 	= $data['first_name'].' '.$data['last_name'];
		$customerData['email'] 	= $data['email'];
		if(!empty($data['phone_number'])){
			$customerData['phone_number'] 	= $data['phone_number'];
		}
		
		Customer::where('email', Auth::User()->email)->update($customerData);
		
        $update = User::where('id', Auth::user()->id)->update($data);

        if ($update) {
            return ['status' => 'true', 'data' => []];
        } else {
            return ['status' => 'false', 'data' => []];
        }
    }

    public function favoriteStore(Request $request)
    {
        $id = $request['id'];

        $checkFavorite = Favourite::where('user_id', Auth::user()->id)->where('store_id', $id)->first();

        if (!empty($checkFavorite)) {
            $remove = Favourite::where('user_id', Auth::user()->id)->where('store_id', $id)->delete();

            if ($remove) {
                return ['status' => 'true', 'data' => 'remove'];
            }
        } else {
            $data['user_id'] = Auth::user()->id;
            $data['store_id'] = $request['id'];
            $favStore = new Favourite();
            $favStore->fill($data);
            if ($favStore->save()) {
                return ['status' => 'true', 'data' => 'add'];
            }
        }

        return ['status' => 'false', 'data' => 'add'];
    }

    public function changeProfile(Request $request)
    {
        $data = $request->all();
        $data = $request->except('_token', '_method');

        if ($request->file('profile_pic')) {

            $oldimage = User::where('id', Auth::user()->id)->value('profile_pic');

            if (!empty($oldimage)) {

                File::delete('storage/app/public/user/' . $oldimage);
            }

            $file = $request->file('profile_pic');
            $filename = 'user-' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(storage_path('app/public/user/'), $filename);
            $data['profile_pic'] = $filename;
        }
		if($data['email'] != Auth::User()->email){
			//Customer::where('email', Auth::User()->email)->update(array('email' => $data['email']));
			Appointment::where('email', Auth::User()->email)->update(array('email' => $data['email']));
		}
		$customerData 			= array();
		$customerData['name'] 	= $data['first_name'].' '.$data['last_name'];
		$customerData['email'] 	= $data['email'];
		if(!empty($data['phone_number'])){
			$customerData['phone_number'] 	= $data['phone_number'];
		}
		Customer::where('email', Auth::User()->email)->update($customerData);
		
        $update = User::where('id', Auth::user()->id)->update($data);

        if ($update) {
			return redirect()->route('users.profile');
        }
    }

    public function getAppointmentData(Request $request)
    {
        $getAppointment = ServiceAppoinment::where('id', $request['id'])->first();
        if (!empty($getAppointment)) {

            $getAppointment['service_image'] = URL::to('storage/app/public/service/' . @$getAppointment['serviceDetails']['image']);
        }

        if (!empty($getAppointment) > 0) {
            return ['status' => 'true', 'data' => $getAppointment];
        } else {
            return ['status' => 'false', 'data' => []];
        }
    }

    public function cancelAppontment(Request $request)
    {
        $data = $request->all();

        $variant_id = $request['variant_id'];
        $message = $request['cancel_reason'];
        $appointment = $request['appointment_id'];

        $serviceAppointment = AppointmentData::where('appointment_id', $appointment)->where('variant_id', $variant_id)->first();
        $appointmentData = Appointment::where('id', $appointment)->first();

        $updateAppointment = AppointmentData::where('appointment_id', $appointment)->where('variant_id', $variant_id)->update(['cancel_reason' => $message, 'status' => 'cancel', 'cancelled_by' => 'user']);

        if ($updateAppointment) {
			//send cancellation email to user
			\BaseFunction::sendEmailNotificationAppointment($serviceAppointment['id'], "cancelled");
			$payment = PaymentMethodInfo::where('appoinment_id', $serviceAppointment['appointment_id'])->first();
            if ($payment['payment_method'] == 'stripe' || $payment['payment_method'] == 'klarna'  || $payment['payment_method'] == 'applepay' || $payment['payment_method'] == 'googlepay') {
                $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
                if ($payment['payment_method'] == 'stripe') {
                    try {
                        $refund = $stripe->refunds->create([
                            'charge' => $payment['payment_id'],
                            'amount' => $serviceAppointment['price'] * 100,
                            'reason' => 'requested_by_customer'
                        ]);
                        $updatePayment = PaymentMethodInfo::where('id', $payment['id'])->update(['refund_id' => $refund['id'], 'status' => 'refund']);
                        $updateRefund = AppointmentData::where('appointment_id', $appointment)->where('variant_id', $variant_id)->update(['refund_id' => $refund['id']]);
                    } catch (\Stripe\Exception\InvalidRequestException $e) {

                    }catch (Exception $e) {

                    }

                } elseif ($payment['payment_method'] == 'klarna' || $payment['payment_method'] == 'applepay' || $payment['payment_method'] == 'googlepay') {
                    try {
                        $refund = $stripe->refunds->create([
                            'payment_intent' => $payment['payment_id'],
                            'amount' => $serviceAppointment['price'] * 100,
                            'reason' => 'requested_by_customer'
                        ]);
                        $updatePayment = PaymentMethodInfo::where('id', $payment['id'])->update(['refund_id' => $refund['id'], 'status' => 'refund']);
                        $updateRefund = AppointmentData::where('appointment_id', $appointment)->where('variant_id', $variant_id)->update(['refund_id' => $refund['id']]);
                    } catch (\Stripe\Exception\InvalidRequestException $e) {

                    }catch (Exception $e) {

                    }

                }


            }

            if ($payment['payment_method'] == 'cash'){
                $updatePayment = PaymentMethodInfo::where('id', $payment['id'])->update(['refund_id' => 'cash', 'status' => 'refund']);
            }
			if($serviceAppointment['status'] == 'reschedule'){
				  /** push notification */
				$store_user_id  = StoreProfile::where('id',$serviceAppointment['store_id'])->value('user_id');
				$PUSer = User::find($store_user_id);
				if(!empty($PUSer->device_token)){
					$sessioncount = ApiSession::where('user_id', $PUSer->id)->count();
					if($sessioncount > 0){
						//$registerarion_ids = array($PUSer->device_token);
						$registerarion_ids = ApiSession::where('user_id', $PUSer->id)->pluck('device_token')->toArray(); 
						\BaseFunction::sendPushNotificationServiceProvider($registerarion_ids, 'Verschoben !',  'Buchung wurde storniert', NULL, $serviceAppointment['store_id'], $serviceAppointment['id'], 3);
					}
				}
				\BaseFunction::notification('Verschoben !','Buchung wurde storniert','appointment', $serviceAppointment['id'],$serviceAppointment['store_id'],$appointmentData['user_id'],$appointmentData['user_id'] == ''? 'guest' : '');
			}else{
				  /** push notification */
				$store_user_id  = StoreProfile::where('id',$serviceAppointment['store_id'])->value('user_id');
				$PUSer = User::find($store_user_id);
				if(!empty($PUSer->device_token)){
					$sessioncount = ApiSession::where('user_id', $PUSer->id)->count();
					if($sessioncount > 0){
						//$registerarion_ids = array($PUSer->device_token);
						$registerarion_ids = ApiSession::where('user_id', $PUSer->id)->pluck('device_token')->toArray(); 
						\BaseFunction::sendPushNotificationServiceProvider($registerarion_ids, 'Termin storniert !',  'Buchung wurde storniert', NULL, $serviceAppointment['store_id'], $serviceAppointment['id'], 2);
					}
				}
				\BaseFunction::notification('Termin storniert !','Buchung wurde storniert','appointment',$serviceAppointment['id'],$serviceAppointment['store_id'],$appointmentData['user_id'],$appointmentData['user_id'] == ''? 'guest' : '');
			}
			// \BaseFunction::notification('Termin storniert !','Buchung wurde storniert','appointment',$appointmentData['id'],$appointmentData['store_id'],$appointmentData['user_id'],$appointmentData['user_id'] == ''? 'guest' : '');
            // \BaseFunction::notification('Stornierung','Ein Termin wurde storniert !','Appointment',$appointment,$serviceAppointment['store_id'],$appointmentData['user_id'],$appointmentData['user_id'] == ''? 'guest' : '');
            return redirect()->route('users.profile');

        }
    }

    public function submitRating(Request $request)
    {
        $data = $request->all();
		
        if ($request['service_id'] != '') {
            $service = Service::where('id', $request['service_id'])->first();
            $data['category_id'] = $service['category_id'];
            $data['subcategory_id'] = $service['subcategory_id'];
        }
        $rating = $data['service_rate'] + $data['ambiente'] + $data['preie_leistungs_rate'] + $data['wartezeit'] + $data['atmosphare'];
        $data['total_avg_rating'] = number_format($rating / 5, 1);
        $data['user_id'] = Auth::user()->id;
		if(!empty($data['ap_dataid'])){
			$data['appointment_id'] = $data['ap_dataid']; //AppointmentData::where('id', $data['ap_dataid'])->value('appointment_id');
		}
        $finalRating = new StoreRatingReview();
        $finalRating->fill($data);
        if ($finalRating->save()) {
            $store = StoreProfile::where('id', $data['store_id'])->first();
			
			if(!empty($data['ap_dataid'])){
				Notification::where('appointment_id', $data['ap_dataid'])->where('user_id', $data['user_id'])->where('type', 'review_request')->delete();
			}
			/** push notification */
				$store_user_id  = StoreProfile::where('id', $data['store_id'])->value('user_id');
				$PUSer = User::find($store_user_id);
				if(!empty($PUSer->device_token)){
					$sessioncount = ApiSession::where('user_id', $PUSer->id)->count();
					if($sessioncount > 0){
						//$registerarion_ids = array($PUSer->device_token);
						$registerarion_ids = ApiSession::where('user_id', $PUSer->id)->pluck('device_token')->toArray(); 
						\BaseFunction::sendPushNotificationServiceProvider($registerarion_ids, 'Neue Bewertung !', 'Glückwunsch, Ihr Salon hat eine neue Bewertung erhalten. Jetzt ansehen!', NULL, $data['store_id'], $finalRating->id, 4);
					}
				}
            \BaseFunction::notification('Neue Bewertung !',' Glückwunsch, Ihr Salon hat eine neue Bewertung erhalten. Jetzt ansehen!','rating','',$data['store_id'],Auth::user()->id,'');

            return redirect('kosmetik/' . $store['slug']);
        }

    }

   public function notification()
    {
		User::where('id', Auth::id())->update(['notification_checked' => date('Y-m-d H:i:s')]);
        
        $data = Notification::where('user_id', Auth::id())->where('visible_for', 'users')->orderBy('created_at','DESC')->get();
        return view('Front.User.notification', compact('data'));
    }

    public function setting()
    {
        $getReview = StoreRatingReview::where('user_id', Auth::user()->id)->get();
        return view('Front.User.setting', compact('getReview'));
    }

    public function bookAgain(Request $request)
    {
        $getServiceData = AppointmentData::where('id', $request['id'])->first();

        $checkSameStore = TempServiceStore::where('user_id', Auth::user()->id)->where('store_id', $getServiceData['store_id'])->get();
        if (count($checkSameStore) == 0) {

            $removeServices = TempServiceStore::where('user_id', Auth::user()->id)->delete();
        } else {
            $removeServices = TempServiceStore::where('user_id', Auth::user()->id)->delete();
        }

        $newData['user_id'] = Auth::user()->id;
        $newData['service'] = $getServiceData['service_id'];
        $newData['category'] = $getServiceData['category_id'];
        $newData['subcategory'] = $getServiceData['subcategory_id'];
        $newData['variant'] = $getServiceData['variant_id'];
        $newData['price'] = $getServiceData['price'];
        $newData['store_id'] = $getServiceData['store_id'];

        $Bookingagain = new TempServiceStore();
        $Bookingagain->fill($newData);
        if ($Bookingagain->save()) {
            return ['status' => 'true', 'data' => []];
        } else {
            return ['status' => 'false', 'data' => []];
        }
    }

    public function changePassword(Request $request)
    {
        $this->validate($request, [
            'old_password' => 'required',
            'new_password' => 'required',
            'confirm_password' => 'required|same:new_password',
        ]);

        $checkvalidation = User::where('id', Auth::user()->id)->first();
        if (Hash::check($request->get('old_password'), $checkvalidation->password)) {
            $data['password'] = Hash::make($request->get('new_password'));
            $update = User::where('id', Auth::user()->id)->update($data);
            if ($update) {
                Session::flash('message', '<div class="alert alert-success">Password Changed Successfully.!! </div>');
                return redirect()->route('users.settings');
            }
        } else {
            return redirect()->back()
                ->withErrors(['old_password' => 'Password does not match. Please try again.']);
        }
    }

     public function deleteProfile()
    {
        if (Auth::check()) {
            $temp = TempServiceStore::where('user_id', Auth::user()->id)->delete();
			$user  = User::where('id', Auth::user()->id)->first();
			if (file_exists(storage_path('app/public/user/' . $user->profile_pic)) && $user->profile_pic != '') {
			    File::delete('storage/app/public/user/' . $user->profile_pic);
			}
			$newemail = "gelöschter.kunde@".md5($user->email.'#'.$user->id).'.de';
			$first_name = "gelöschter";
			$last_name  = "Kunde";
			Appointment::where('email', $user->email)->update(['email' => $newemail, 'first_name' => $first_name, 'last_name' => $last_name]);
			Customer::where('email', $user->email)->update(['email' => $newemail, 'name' => $first_name.' '.$last_name]);
            User::where('id', $user->id)->update(['status' => 'inactive', 'profile_pic' => NULL, 'apple_user_id' => NULL,  'apple_id' => NULL, 'phone_number' => NULL, 'email' => $newemail, 'first_name' => $first_name, 'last_name' => $last_name]);
            ApiSession::where('user_id', $user->id)->delete();
			//$delete = User::where('id', Auth::user()->id)->delete();
			Auth::logout();
            return redirect('/');
        }
		
        return redirect('/');
    }

    public function feedback(Request $request,$slug)
    {
        $store = StoreProfile::where('slug', $slug)->first();
        $storeEmp = StoreEmp::where('store_id', $store['id'])->get();
        $category = Category::leftjoin('store_categories', 'store_categories.category_id', '=', 'categories.id')
            ->where('store_categories.store_id', $store['id'])
            ->select('categories.*')
            ->get();
        $getService = Service::where('category_id', $category[0]['id'])->where('store_id', $store['id'])->where('status', 'active')->get();

        $subcategoryData = [];

        $service_id = $request['service_id'];
        $emp = $request['emp'];
		 $ap_id = !empty($request['ap'])?$request['ap']:"";
		 if($ap_id){
			 $rcount = StoreRatingReview::where('user_id', Auth::id())->where('appointment_id', $ap_id)->count();
			 if( $rcount > 0){
				 return back();
			 }
		 }

        if(isset($request['service_id']) && $request['service_id'] != null){
            $getservice_names = Service::where('store_id', $store['id'])->where('id',$service_id)->first();
            $serviceName = $getservice_names['service_name'];
        } else {
            $serviceName = '';
        }

        if(isset($request['emp']) && $request['emp'] != null){
            $empData = StoreEmp::where('store_id', $store['id'])->where('id',$emp)->first();
            $empname = $empData['emp_name'];
            if(file_exists(storage_path('app/public/store/employee/'.$empData['image'])) && @$empData['image'] != ''){
                $empimage = URL::to('storage/app/public/store/employee/'.$empData['image']);
            } else {
                $empimage = URL::to('storage/app/public/default/default-user.png');
            }
        } else {
            $empname = '';
             $empimage = '';
        }
        
    

        foreach ($getService as $row) {
            $row->subcategory = @$row->SubCategoryData->name;
            $subcategoryData[$row->subcategory][] = $row;
        }
//        dd($subcategoryData);
        return view('Front.User.feedback', compact('store', 'ap_id', 'storeEmp', 'category', 'subcategoryData','empname','serviceName','empimage','service_id','emp'));
    }

    public function getSubcategory(Request $request)
    {
        $store = $request['store'];
        $category = $request['category'];

        $getService = Service::where('category_id', $category)->where('store_id', $store)->where('status', 'active')->get();

        $subcategoryData = [];

        foreach ($getService as $row) {
            $row->subcategory = @$row->SubCategoryData->name;
            $subcategoryData[$row->subcategory][] = $row;
        }

        if (count($subcategoryData) > 0) {
            return ['status' => 'true', 'data' => $subcategoryData];
        } else {
            return ['status' => 'false', 'data' => []];
        }
    }

    public function contactUs(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = Auth::user()->id;

        $message = new Contactus();
        $message->fill($data);
        if ($message->save()) {
            Session::flash('message', '<div class="alert alert-success">Message Sent Successfully.!! </div>');
            return redirect()->route('users.settings');
        }
    }
	
	public function findAppointment($id)
    {
        /* $appointmentDetail = AppointmentData::where('id',$id)->first();
        $row = $appointmentDetail->appointmentDetails; */
		$appointmentDetail = AppointmentData::leftjoin('payment_method_infos', 'payment_method_infos.appoinment_id', '=', 'appointment_data.appointment_id')->where('appointment_data.id', $id)->first(['appointment_data.*', 'payment_method_infos.status as payment_status','payment_method_infos.card_type as card_type','payment_method_infos.payment_method as payment_method']);
        $row = $appointmentDetail->appointmentDetails;
        return view('Front.User.modal_info',get_defined_vars());
    }
	
	
	public function customerProfile($slug, $action)
    {
		 $store = StoreProfile::where('slug', $slug)->first();
		 if(!empty($store->id)){
			 $customerRequest  = CustomerRequest::where('user_id', Auth::id())->where('store_id', $store->id)->first();
			 $customerName = Auth::User()->first_name." ".Auth::User()->last_name;
			 if($action == 2){
				 CustomerRequest::where('user_id', Auth::id())->where('store_id', $store->id)->update(['status' => 2]);
				 Notification::where('user_id', Auth::id())->where('store_id', $store->id)->where('type', 'customer_request')->delete();
				 $notification_title = "Kundenprofil Anfrage !";
				 $notification_message = "Ihr Kunde hat die Anfrage für das Erstellen eines Kundenprofils abgelehnt.";
				 $customer_action   = "customer_rejected";
				 /** push notification */
				$store_user_id  = StoreProfile::where('id',$store->id)->value('user_id');
				$PUSer = User::find($store_user_id);
				if(!empty($PUSer->device_token)){
					$sessioncount = ApiSession::where('user_id', $PUSer->id)->count();
					if($sessioncount > 0){
						//$registerarion_ids = array($PUSer->device_token);
						$registerarion_ids = ApiSession::where('user_id', $PUSer->id)->pluck('device_token')->toArray(); 
						\BaseFunction::sendPushNotificationServiceProvider($registerarion_ids, $notification_title,  $notification_message, NULL, $store->id, $store->id, 5);
					}
				}
				 \BaseFunction::notification($notification_title, $notification_message, $customer_action,'',$store->id,Auth::user()->id,'');
			}elseif($action == 1){
				 $data   = array();
				 $data['store_id']   		= $store->id;
				 $data['email']   	 		= Auth::User()->email;
				 $data['name']   	 		= Auth::User()->first_name." ".Auth::User()->last_name; 
				 $data['phone_number']   	= Auth::User()->phone_number;
				 $data['address']   		= Auth::User()->address;
				 $data['state']   			= Auth::User()->city;
				 $data['zipcode']   		= Auth::User()->zipcode;
				 $Customer 					= Customer::create($data);
				 Notification::where('user_id', Auth::id())->where('store_id', $store->id)->where('type', 'customer_request')->delete();
				 CustomerRequest::where('user_id', Auth::id())->where('store_id', $store->id)->delete();
				 $notification_title = "Kundenprofil Anfrage !";
				 $notification_message = "Ihr Kunde hat die Anfrage für das Erstellen eines Kundenprofils bestätigt.";
				 $customer_action   = "customer_accepted";
				  /** push notification */
				$store_user_id  = StoreProfile::where('id',$store->id)->value('user_id');
				$PUSer = User::find($store_user_id);
				if(!empty($PUSer->device_token)){
					$sessioncount = ApiSession::where('user_id', $PUSer->id)->count();
					if($sessioncount > 0){
						//$registerarion_ids = array($PUSer->device_token);
						$registerarion_ids = ApiSession::where('user_id', $PUSer->id)->pluck('device_token')->toArray(); 
						\BaseFunction::sendPushNotificationServiceProvider($registerarion_ids, $notification_title,  $notification_message, NULL, $store->id, $Customer->id, 6);
					}
				}
				 \BaseFunction::notification($notification_title, $notification_message, $customer_action,$Customer->id,$store->id,Auth::user()->id,'');
			 }
			
			 
		 }
		 return redirect('notification');
    }
	
	
	public function delete_profile_picture(){
		
        $user_id = Auth::id();
        $user_data = User::where('id', $user_id)->first();

        if (file_exists(storage_path('app/public/user/' . $user_data['profile_pic'])) && $user_data['profile_pic'] != '') {
           File::delete('storage/app/public/user/' . $user_data['profile_pic']);
		  User::where('id', $user_id)->update(['profile_pic' => NULL]);
        }

		$image = "https://via.placeholder.com/1080x1080/00000/FABA5F?text=".strtoupper(substr(Auth::user()->first_name, 0, 1)).strtoupper(substr(Auth::user()->last_name, 0, 1));
        return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Success.', 'ResponseData' => $image], 200);
    }
	
	
	public function allowNotification()
    {
		try {
            $input = request()->all();
            $userId = Auth::id();
			$allow_notifications  = !empty($input['allow_notifications'])?$input['allow_notifications']:0;
			User::where('id', $userId)->update(['allow_notifications' => $allow_notifications]);
            return response()->json(['ResponseCode' => 1, 'ReponseText' => 'Notification are blocked successfully','ResponseData'=> NULL],200);
        } catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
    }


}
