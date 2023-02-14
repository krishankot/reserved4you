<?php

namespace App\Http\Controllers\Frontend\Payment;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\AppointmentData;
use App\Models\Payment as Payments;
use App\Models\PaymentMethodInfo;
use App\Models\Service;
use App\Models\ServiceAppoinment;
use App\Models\ServiceVariant;
use App\Models\StoreEmp;
use App\Models\StoreProfile;
use App\Models\ApiSession;
use App\Models\BookingTemp;
use App\Models\TempServiceStore;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Auth;
use Session;
use Redirect;
use PayPal\Api\Amount;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use PayPal\Exception\PayPalConnectionException;
use PayPal\Api\Refund;
use URL;
use Mail;
use Stripe;
use Exception;


class PaymentController extends Controller
{
    public function checkout(Request $request)
    {

        $data = $request->all();
       
        $checkval = \BaseFunction::sameBookingChecking($data);

        if($checkval['status'] == 'false'){
            \Session::put('booking_error', 'yes');
            
            $remove = BookingTemp::whereIn('id',$checkval['id'])->delete();
            return redirect('checkout-prozess');
        }
        
        $value = \BaseFunction::checkBooking($data);

        if(count($value) > 0){
            \Session::put('booking_error', 'yes');
			$remove = BookingTemp::whereIn('id',$checkval['id'])->delete();
            return redirect('checkout-prozess');
        } 
        
      
        $category = $request['category'];        
        $subcategory = $request['subcategory'];
        $store = $request['store'];
        $date = $request['date'];
        $employee = $request['employee'];
        $time = $request['time'];
        $price = $request['price'];
        $variant = $request['variant'];
        $service = $request['service'];
        $service_data = $request['service_data'];
		$card_type  = NULL;

        $amount = $request['totalAmount'];

        if ($data['choosepayment'] == 'stripe') {
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));

            if (Auth::check()) {
                if (Auth::user()->customer_id == '') {
                    $customer = $stripe->customers->create([
                        'name' => $request['fname'] . ' ' . $request['lname'],
                        'email' => Auth::user()->email,
                        'address' => [
                            'line1' => $request['address']
                        ]
                    ]);
                    $update = User::where('id', Auth::user()->id)->update(['customer_id' => $customer['id']]);
                    $c_id = $customer['id'];
                } else {
                    $c_id = Auth::user()->customer_id;
                }
            } else {
                $customer = $stripe->customers->create([
                    'name' => $request['fname'] . ' ' . $request['lname'],
                    'email' => $request['email']
                ]);
                $c_id = $customer['id'];
            }

			
			try{
				$c_id  = trim($c_id);
				$card = $stripe->customers->createSource(
					$c_id,
					['source' => $request['stripeToken']]
				);
				if(!empty($card['id'])){
					$customer = $stripe->customers->update(
						 $c_id,
						 ['default_source' => $card['id']]
					);
				}
			}catch (\Stripe\Exception\ApiErrorException  $e) {
				 \Session::put('payment_error', $e->getError()->message);
				  $remove = BookingTemp::whereIn('id',$checkval['id'])->delete();
				  return redirect('zahlungsabschluss');
			}
			
			
			try{
				$charge = $stripe->charges->create([
					'amount' => $amount * 100,
					'currency' => 'eur',
					'customer' => $c_id,
					'description' => 'R4U Service',
				]);
			}catch (\Stripe\Exception\ApiErrorException  $e) {
				 \Session::put('payment_error', $e->getError()->message);
				  $remove = BookingTemp::whereIn('id',$checkval['id'])->delete();
				  return redirect('zahlungsabschluss');
				 //return response()->json(['ResponseCode' => 0, 'ResponseText' => $e->getError()->message, 'ResponseData' => ''], 400);
			}

            $charge_id = $charge['id'];
            $payment_method = 'stripe';
            $status = 'booked';
			$card_type = !empty($charge->source->brand)?$charge->source->brand:NULL;
        }
        elseif ($data['choosepayment'] == 'paypal') {
            $charge_id = '';
            $payment_method = 'paypal';
            $status = 'pending';

        }
        elseif ($data['choosepayment'] == 'cash') {

            $charge_id = 'Cash';
            $payment_method = 'cash';
            $status = 'booked';
        }
        elseif ($data['choosepayment'] == 'klarna') {
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));

            if (Auth::check()) {
                if (Auth::user()->customer_id == '') {
                    $customer = $stripe->customers->create([
                        'name' => $request['fname'] . ' ' . $request['lname'],
                        'email' => $request['email'],
                    ]);
                    $update = User::where('id', Auth::user()->id)->update(['customer_id' => $customer['id']]);
                    $c_id = $customer['id'];
                } else {
                    $c_id = Auth::user()->customer_id;
                }
            } else {
                $customer = $stripe->customers->create([
                    'name' => $request['fname'] . ' ' . $request['lname'],
                    'email' => $request['email']
                ]);
                $c_id = $customer['id'];
            }
            $redirectUrl = URL::to('karla-payment-success');
			try{
				 $intent = $stripe->paymentIntents->create([
					'confirm' => true,
					'amount' => $amount * 100,
					'currency' => 'eur',
					'customer' =>  $c_id,
					'payment_method_types' => ['sofort'],
					'payment_method_data' => [
						'type' => 'sofort',
						'sofort' => [
							'country' => 'DE',
						],
					],
					'return_url' => $redirectUrl,
				]);
			}catch (\Stripe\Exception\ApiErrorException  $e) {
				\Session::put('payment_error', $e->getError()->message);
				  $remove = BookingTemp::whereIn('id',$checkval['id'])->delete();
				  return redirect('zahlungsabschluss');
			}


            $charge_id = $intent['id'];
            $payment_method = 'klarna';
            $status = 'pending';
        }

        if ($data['usertype'] == 'guest') {
            $getEmail = User::where('email', $data['email'])->first();
            if (!empty($getEmail)) {
                $appointmentData['user_id'] = $getEmail['id'];
            }
            $appointmentData['first_name'] = $data['fname'];
            $appointmentData['last_name'] = $data['lname'];
            $appointmentData['email'] = $data['email'];
            $appointmentData['phone_number'] = $data['phone_number'];
        } else {
            $appointmentData['user_id'] = Auth::user()->id;
            $appointmentData['first_name'] = $data['fname'];
            $appointmentData['last_name'] = $data['lname'];
            $appointmentData['email'] = $data['email'];
            $appointmentData['phone_number'] = $data['phone_number'];
        }
        $appointmentData['store_id'] = $store[0];
        $appointmentData['order_id'] = \BaseFunction::orderNumber();
        $appointmentData['appointment_type'] = 'system';
        $appointmentData['total_amount'] = $data['totalAmount'];

        $appointment = new Appointment();
        $appointment->fill($appointmentData);
        if ($appointment->save()) {
            $cat = '';
            for ($i = 0; $i < count($category); $i++) {
                if($cat == ''){
                    $cat = $category[$i];    
                    $newTime = $time[$i];
                } else if($cat != $category[$i]) {
                    $newTime = $time[$i];
                    $cat = '';
                }

                if($i != 0 && $cat != ''){
                    $getduration = ServiceVariant::where('id',$variant[$i - 1])->value('duration_of_service');
                   
                    if($cat == $category[$i]){
					   $newTime = \Carbon\Carbon::parse( $newTime)->addMinutes($getduration)->format('H:i');
					}else{
					   $newTime = \Carbon\Carbon::parse($time[$i - 1])->addMinutes($getduration)->format('H:i');
					}
                }
                $cat =  $category[$i];
                $getTimeDuration = ServiceVariant::where('id',$variant[$i])->value('duration_of_service');
                $endTime = \Carbon\Carbon::parse($newTime)->addMinutes($getTimeDuration)->format('H:i');

                $subData['appointment_id'] = $appointment['id'];
                $subData['store_id'] = $store[$i];
                $subData['category_id'] = $category[$i];
                $subData['subcategory_id'] = $subcategory[$i];
                $subData['service_id'] = $service[$i];
                $subData['service_name'] = $service_data[$i];
                $subData['variant_id'] = $variant[$i];
                $subData['price'] = $price[$i];
                $subData['status'] = $status;
                $subData['store_emp_id'] = $employee[$i];
                $subData['appo_date'] = $date[$i];
                $subData['appo_time'] = $newTime;
                $subData['app_end_time'] = $endTime;
               
                $appData = new AppointmentData();
                $appData->fill($subData);
                $appData->save();
            }
            
            if ($data['usertype'] != 'guest') {
                $paymentinfo['user_id'] = Auth::user()->id;
            }
            $paymentinfo['store_id'] = $appointment['store_id'];
            //            $paymentinfo['service_id'] = $appointment['service_id'];
            $paymentinfo['order_id'] = $appointment['order_id'];
            $paymentinfo['payment_id'] = $charge_id;
            $paymentinfo['total_amount'] = $appointment['total_amount'];

            if ($data['choosepayment'] == 'stripe') {
                $paymentinfo['status'] = 'succeeded';
				$paymentinfo['card_type']  = $card_type;
            } elseif ($data['choosepayment'] == 'paypal') {
                $paymentinfo['status'] = 'pending';
            } elseif ($data['choosepayment'] == 'cash') {
                $paymentinfo['status'] = 'succeeded';
            } elseif ($data['choosepayment'] == 'klarna') {
                $paymentinfo['status'] = 'pending';
            }

            $paymentinfo['appoinment_id'] = $appointment['id'];
            $paymentinfo['payment_method'] = $payment_method;
            $paymentinfo['payment_type'] = 'withdrawn';

            $paymentDatas = new PaymentMethodInfo();
            $paymentDatas->fill($paymentinfo);
            $paymentDatas->save();


            $paymentSuccess['price'] = $appointment['total_amount'];
            $paymentSuccess['order_id'] = $appointment['order_id'];
            $paymentSuccess['appoinment_id'] = $appointment['id'];
            $paymentSuccess['payment_type'] = $payment_method;

            \Session::put('payment_data', $paymentSuccess);

            if ($data['usertype'] == 'guest') {
                $mailName = $data['fname'] . ' ' . $data['lname'];
                $mailemail = $data['email'];
            } else {
                $mailName = Auth::user()->first_name . ' ' . Auth::user()->last_name;
                $mailemail = Auth::user()->email;
            }

            if ($data['choosepayment'] == 'klarna') {
                if ($intent->status == 'requires_action' && $intent->next_action->type == 'redirect_to_url') {

//                    if ($data['usertype'] == 'guest') {
//                        $mailName = $data['fname'] . ' ' . $data['lname'];
//                        $mailemail = $data['email'];
//                    } else {
//                        $mailName = Auth::user()->first_name . ' ' . Auth::user()->last_name;
//                        $mailemail = Auth::user()->email;
//                    }

//                    $title = 'New Appointment Booked';
//                    $title1 = 'Your Appointment has been booked';
//
//                    $store = @$appointment['storeDetaials']['store_name'];
//                    $expert = StoreEmp::where('id', $appointment['store_emp_id'])->value('emp_name');
//
//                    $price = $appointment['total_amount'];
//                    $payment_type = $payment_method;
//                    $order_id = $appointment['order_id'];
//                    $payment_Id = $charge_id;
//                    $status = $paymentDatas['status'];
//
//                    $data_mail = ['title' => $title, 'title1' => $title1, 'email' => $mailemail, 'name' => $mailName, 'image' => $image, 'service' => $service, 'store' => $store, 'expert' => $expert,
//                        'date' => $date, 'time' => $time, 'price' => $price, 'payment_type' => $payment_type, 'order_id' => $order_id, 'payment_id' => $payment_Id, 'status' => $status];

                    Session::put('payment_id', $intent['id']);
                    Session::put('appointmentId', $appointment['id']);
//                    Session::put('datamail', $data_mail);
                    Session::put('store_id', $appointment['store_id']);
                    Session::put('booking', implode(',',$checkval['id']));

                    $url = $intent->next_action->redirect_to_url->url;
                    return redirect($url);
                } else {
                    $slug = \BaseFunction::getSlug($appointment['store_id']);
                    Session::put('payment_status', 'failed');
                    $remove = BookingTemp::whereIn('id',$checkval['id'])->delete();
                    return redirect('kosmetik/' . $slug);
                }
            }
            if ($data['choosepayment'] == 'paypal') {
                $pdata = new Item();
                $pdata->setName('Reserved4you cosmetic Reservation')/** item name **/
                ->setCurrency('EUR')
                    ->setQuantity(1)
                    ->setPrice($appointment['total_amount']);

                $this->_api_context = new ApiContext(new OAuthTokenCredential(
                    'AVW3rqhQztKPMYoPPY6FlbN94RC9jT7_9qyOKD5_EZ0vxccekchb-SAm-3EsEJDYrwIbTOu9OzRTNraz',
                    'ECcTdZ_KybPvviJL9GJjEBFW7ixio2MhV-eKZuUkssk3Zf0u-bbNfJ6j6Qk8YvNqgn0TK4G3of6yNZpC'));

                $this->_api_context->setConfig(
                    array(
                        'log.LogEnabled' => true,
                        'log.FileName' => 'PayPal.log',
                        'log.LogLevel' => 'DEBUG',
                        'mode' => 'sandbox'
                    )
                );
                $item_list = new ItemList();
                $item_list->setItems(array($pdata));

                $payer = new Payer();
                $payer->setPaymentMethod('paypal');

                $amount = new Amount();
                $amount->setTotal($appointment['total_amount']);
                $amount->setCurrency('EUR');

                $transaction = new Transaction();
                $transaction->setAmount($amount)
                    ->setItemList($item_list)
                    ->setDescription('Item Description');

                $redirectUrls = new RedirectUrls();
                $redirectUrls->setReturnUrl(route('payment.success'))
                    ->setCancelUrl(route('payment.cancel'));

                $payment = new Payment();
                $payment->setIntent('sale')
                    ->setPayer($payer)
                    ->setTransactions(array($transaction))
                    ->setRedirectUrls($redirectUrls);


                try {
//                    $title = 'New Appointment Booked';
//                    $title1 = 'Your Appointment has been booked';
////                    $image = URL::to('storage/app/public/service/' . $serviceDetails['image']);
////                    $service = $serviceDetails['service_name'];
//                    $store = @$appointment['storeDetaials']['store_name'];
//                    $expert = StoreEmp::where('id', $appointment['store_emp_id'])->value('emp_name');
//                    $date = \Carbon\Carbon::parse($appointment['appo_date'])->format('d M,Y');
//                    $time = $appointment['appo_time'];
//                    $price = $appointment['price'];
//                    $payment_type = $payment_method;
//                    $order_id = $appointment['order_id'];
//                    $payment_Id = $charge_id;
//                    $status = $paymentDatas['status'];
//
//                    $data_mail = ['title' => $title, 'title1' => $title1, 'email' => $mailemail, 'name' => $mailName, 'image' => $image, 'service' => $service, 'store' => $store, 'expert' => $expert,
//                        'date' => $date, 'time' => $time, 'price' => $price, 'payment_type' => $payment_type, 'order_id' => $order_id, 'payment_id' => $payment_Id, 'status' => $status];
                    //                     $payment->create($apiContext);
                    $payment->create($this->_api_context);
                    Session::put('paypal_payment_id', $payment->getId());
                    Session::put('appointmentId', $appointment['id']);
//                    Session::put('datamail', $data_mail);
                    Session::put('booking', implode(',',$checkval['id']));
                    Session::put('store_id', $appointment['store_id']);
                    PaymentMethodInfo::where('id', $paymentDatas->id)->update(['payment_id' => $payment->getId()]);

                    return redirect($payment->getApprovalLink());
                } catch (PayPalConnectionException $ex) {
                    if ($data['usertype'] == 'guest') {
                        $emails = Session::get('guest_email');
                        TempServiceStore::where('guest_email', $emails)->delete();
                    } else {
                        TempServiceStore::where('user_id', Auth::user()->id)->delete();
                    }
                    $slug = \BaseFunction::getSlug($appointment['store_id']);
                    Session::put('payment_status', 'failed');
                    Session::put('slug', $slug);
                    Session::put('appointment_id', $appointment['id']);

                    $remove = BookingTemp::whereIn('id',$checkval['id'])->delete();
                    return redirect('/buchungsbestaetigung');
                }

            } else {
                if ($data['usertype'] == 'guest') {
                    $emails = Session::get('guest_email');
                    TempServiceStore::where('guest_email', $emails)->delete();
                } else {
                    TempServiceStore::where('user_id', Auth::user()->id)->delete();
                }

                $slug = \BaseFunction::getSlug($appointment['store_id']);
                \Session::put('payment_status', 'success');
                Session::put('slug', $slug);
                Session::put('appointment_id', $appointment['id']);
                BookingTemp::whereIn('id',$checkval['id'])->update(['status' => 'paid']);

//                $title = 'New Appointment Booked';
//                $title1 = 'Your Appointment has been booked';
//
//                $store = @$appointment['storeDetaials']['store_name'];
//                $expert = StoreEmp::where('id', $appointment['store_emp_id'])->value('emp_name');
//                $price = $appointment['total_amount'];
//                $payment_type = $payment_method;
//                $order_id = $appointment['order_id'];
//                $payment_Id = $charge_id;
//                $status = $paymentDatas['status'];
//
//                $data_mail = ['title' => $title, 'email' => $mailemail, 'name' => $mailName, 'image' => $image, 'service' => $service, 'store' => $store, 'expert' => $expert,
//                    'date' => $date, 'time' => $time, 'price' => $price, 'payment_type' => $payment_type, 'order_id' => $order_id, 'payment_id' => $payment_Id, 'status' => $status];
//                if (!empty($data_mail['email'])) {
//                    try {
//                        Mail::send('email.booking', $data_mail, function ($message) use ($data_mail) {
//                            $message->from('punit.radhe@gmail.com', env('MAIL_FROM_NAME', "Reserved4you"))->subject($data_mail['title']);
//                            $message->to($data_mail['email']);
//                        });
//                    } catch (\Swift_TransportException $e) {
//                        \Log::debug($e);
//                    }
//                }
				
				//send appointmentment confirmation email to user
				\BaseFunction::sendEmailNotificationAppointmentConfirmation($appointment['id']);
				
				/** push notification */
				$store_user_id  = StoreProfile::where('id', $appointment['store_id'])->value('user_id');
				$PUSer = User::find($store_user_id);
				
				
				if(!empty($PUSer->device_token)){
					$sessioncount = ApiSession::where('user_id', $PUSer->id)->count();
					if($sessioncount > 0){
						$appointmentArr = AppointmentData::where('appointment_id', $appointment['id'])->get();
						foreach($appointmentArr as $val){
							//$registerarion_ids = array($PUSer->device_token);
							$registerarion_ids = ApiSession::where('user_id', $PUSer->id)->pluck('device_token')->toArray(); 
							\BaseFunction::sendPushNotificationServiceProvider($registerarion_ids, 'Neue Buchung !', 'Sie haben eine neue Buchung erhalten', NULL, $appointment->store_id, $val->id, 1);
							
						}
					}
				}
				
                \BaseFunction::notification('Neue Buchung !','Sie haben eine neue Buchung erhalten','appointment',$appointment['id'],$appointment['store_id'],$appointment['user_id'],$appointment['user_id'] == ''? 'guest' : '');

                $remove = BookingTemp::whereIn('id',$checkval['id'])->delete();

                return redirect('/buchungsbestaetigung');

            }


        }


    }

    public function success(Request $request)
    {
        $this->_api_context = new ApiContext(new OAuthTokenCredential(
            'AVW3rqhQztKPMYoPPY6FlbN94RC9jT7_9qyOKD5_EZ0vxccekchb-SAm-3EsEJDYrwIbTOu9OzRTNraz',
            'ECcTdZ_KybPvviJL9GJjEBFW7ixio2MhV-eKZuUkssk3Zf0u-bbNfJ6j6Qk8YvNqgn0TK4G3of6yNZpC'));

        $payment_id = Session::get('paypal_payment_id');
        $oredr_number = Session::get('appointmentId');
        $booking = Session::get('booking');
        $appointment = Appointment::where('id',$oredr_number)->first();
//        $data_mail = Session::get('datamail');
        $store = Session::get('store_id');

        Session::forget('paypal_payment_id');
        Session::forget('orderNumber');
//        Session::forget('datamail');
        Session::forget('store_id');
        Session::forget('booking');

        $slug = \BaseFunction::getSlug($store);

        if (empty($request->PayerID) || empty($request->token) || empty($payment_id) || empty($oredr_number)) {
            return back()->with('errors', ['Invalid request.']);
        }

        $payment = Payment::get($payment_id, $this->_api_context);

        $execution = new PaymentExecution();
        $execution->setPayerId($request->PayerID);

        $result = $payment->execute($execution, $this->_api_context);
        
        if ($result->getState() == 'approved') {
            PaymentMethodInfo::where('appoinment_id', $oredr_number)->where('payment_id', $payment_id)->update(['status' => 'succeeded']);
            AppointmentData::where('appointment_id', $oredr_number)->where('store_id', $store)->update(['status' => 'booked']);
            Session::put('slug', $slug);
            Session::put('appointment_id', $oredr_number);
            Session::put('payment_status', 'success');
            $remove = BookingTemp::whereIn('id',explode(',',$booking))->delete();
			
			/** push notification */
			$store_user_id  = StoreProfile::where('id', $appointment['store_id'])->value('user_id');
			$PUSer = User::find($store_user_id);
			if(!empty($PUSer->device_token)){
				$sessioncount = ApiSession::where('user_id', $PUSer->id)->count();
				if($sessioncount > 0){
					//$registerarion_ids = array($PUSer->device_token);
					$appoArr = AppointmentData::where('appointment_id', $oredr_number)->where('store_id', $store)->get();
					$registerarion_ids = ApiSession::where('user_id', $PUSer->id)->pluck('device_token')->toArray(); 
					foreach($appoArr as $val){
						\BaseFunction::sendPushNotificationServiceProvider($registerarion_ids, 'Neue Buchung !', 'Sie haben eine neue Buchung erhalten', NULL, $appointment->store_id, $val->id, 1);
					}
				}
			}
            \BaseFunction::notification('Neue Buchung !','Sie haben eine neue Buchung erhalten','appointment',$appointment['id'],$appointment['store_id'],$appointment['user_id'],$appointment['user_id'] == ''? 'guest' : '');
        } else {
            PaymentMethodInfo::where('appoinment_id', $oredr_number)->where('payment_id', $payment_id)->update(['status' => 'failed']);
            Session::put('payment_status', 'failed');
            Session::put('slug', $slug);
            Session::put('appointment_id', $oredr_number);
            $remove = BookingTemp::whereIn('id',explode(',',$booking))->delete();
        }
        if (Auth::check()) {
            TempServiceStore::where('user_id', Auth::user()->id)->delete();
        } else {
            $emails = Session::get('guest_email');
            TempServiceStore::where('guest_email', $emails)->delete();
        }
//        try {

//            if (!empty($data_mail['email'])) {
//                $data_mail['status'] = 'succeeded';
//                Mail::send('email.booking', $data_mail, function ($message) use ($data_mail) {
//                    $message->from('punit.radhe@gmail.com', env('MAIL_FROM_NAME', "Reserved4you"))->subject($data_mail['title']);
//                    $message->to($data_mail['email']);
//                });
//            }

        return redirect('/buchungsbestaetigung');
//        } catch (\Swift_TransportException $e) {
//            \Log::debug($e);
//            return redirect('payment-sucess')->with('success', ['Payment Successful.']);
        // return redirect('/buchungsbestaetigung');
//        }
    }

    public function cancel()
    {
        $store = Session::get('store_id');
        $oredr_number = Session::get('appointmentId');
        $booking = Session::get('booking');
        Session::forget('paypal_payment_id');
        Session::forget('orderNumber');
        Session::forget('datamail');
        Session::forget('store_id');
         Session::forget('booking');
        if (Auth::check()) {
            TempServiceStore::where('user_id', Auth::user()->id)->delete();
        } else {
            $emails = Session::get('guest_email');
            TempServiceStore::where('guest_email', $emails)->delete();
        }

        $slug = \BaseFunction::getSlug($store);
        $remove = BookingTemp::whereIn('id',explode(',',$booking))->delete();
        Session::put('payment_status', 'failed');
        Session::put('slug', $slug);
        Session::put('appointment_id', $oredr_number);
        return redirect('buchungsbestaetigung');
    }

    public function Karlasuccess(Request $request)
    {

        $data = $request->all();

        $payment_id = Session::get('payment_id');
        $oredr_number = Session::get('appointmentId');
//        $data_mail = Session::get('datamail');

        $appointment = Appointment::where('id',$oredr_number)->first();
        $store = Session::get('store_id');
        $booking = Session::get('booking');

        Session::forget('payment_id');
        Session::forget('orderNumber');
//        Session::forget('datamail');
        Session::forget('store_id');
        Session::forget('booking');
        

        $slug = \BaseFunction::getSlug($store);

        if ($data['redirect_status'] == 'succeeded') {
            PaymentMethodInfo::where('appoinment_id', $oredr_number)->where('payment_id', $payment_id)->update(['status' => 'succeeded']);
            AppointmentData::where('appointment_id', $oredr_number)->where('store_id', $store)->update(['status' => 'booked']);
            Session::put('payment_status', 'success');
            Session::put('slug', $slug);
            Session::put('appointment_id', $oredr_number);
            $remove = BookingTemp::whereIn('id',explode(',',$booking))->delete();
			/** push notification */
			$store_user_id  = StoreProfile::where('id', $appointment['store_id'])->value('user_id');
			$PUSer = User::find($store_user_id);
			if(!empty($PUSer->device_token)){
				$sessioncount = ApiSession::where('user_id', $PUSer->id)->count();
				if($sessioncount > 0){
					//$registerarion_ids = array($PUSer->device_token);
					$registerarion_ids = ApiSession::where('user_id', $PUSer->id)->pluck('device_token')->toArray(); 
					$appoArr = AppointmentData::where('appointment_id', $oredr_number)->where('store_id', $store)->get();
					foreach($appoArr as $val){
						\BaseFunction::sendPushNotificationServiceProvider($registerarion_ids, 'Neue Buchung !', 'Sie haben eine neue Buchung erhalten', NULL, $appointment->store_id, $val->id, 1);
					}
				}
			}
             \BaseFunction::notification('Neue Buchung !','Sie haben eine neue Buchung erhalten','appointment',$appointment['id'],$appointment['store_id'],$appointment['user_id'],$appointment['user_id'] == ''? 'guest' : '');
        } else {
            PaymentMethodInfo::where('appoinment_id', $oredr_number)->where('payment_id', $payment_id)->update(['status' => 'failed']);
            Session::put('payment_status', 'failed');
            Session::put('slug', $slug);
            Session::put('appointment_id', $oredr_number);
            $remove = BookingTemp::whereIn('id',explode(',',$booking))->delete();
        }

        if (Auth::check()) {
            TempServiceStore::where('user_id', Auth::user()->id)->delete();
        } else {
            $emails = Session::get('guest_email');
            TempServiceStore::where('guest_email', $emails)->delete();
        }

//        try {
//
//            if (!empty($data_mail['email'])) {
//                $data_mail['status'] = 'succeeded';
//                Mail::send('email.booking', $data_mail, function ($message) use ($data_mail) {
//                    $message->from('punit.radhe@gmail.com', env('MAIL_FROM_NAME', "Reserved4you"))->subject($data_mail['title']);
//                    $message->to($data_mail['email']);
//                });
//            }
        return redirect('/buchungsbestaetigung');
//        } catch (\Swift_TransportException $e) {
//            \Log::debug($e);
////            return redirect('payment-sucess')->with('success', ['Payment Successful.']);
        return redirect('/buchungsbestaetigung');
//        }

    }

    public function applePay()
    {
		\Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
try{
\Stripe\ApplePayDomain::create([
  'domain_name' => 'https://www.reserved4you.de',
]);
}catch (\Stripe\Exception\ApiErrorException  $e) {
				echo $e->getError()->message; die;
			}

die;
			return redirect()->route('users.profile');
		
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));

        $intent = $stripe->paymentIntents->create([
            'amount' => 1099,
            'currency' => 'eur',
            // Verify your integration in this guide by including this parameter
            'metadata' => ['integration_check' => 'accept_a_payment'],
        ]);
        dd($intent);

    }

    public function processToPay(Request $request)
    {

        $serviceData = $request['servicelist'];
        $id = $request['store_id'];
        $email = $request['email'];

        if (Auth::check()) {

            $checkData = TempServiceStore::where('user_id', Auth::user()->id)->get();
            if (count($checkData) > 0) {
                $deleteData = TempServiceStore::where('user_id', Auth::user()->id)->delete();
            }
        } else {
            $checkData = TempServiceStore::where('guest_email', $email)->get();
            if (count($checkData) > 0) {
                $deleteData = TempServiceStore::where('guest_email', $email)->delete();
            }
        }


        foreach ($serviceData as $row) {
            if (Auth::check()) {

                $data['user_id'] = Auth::user()->id;
            } else {
                $data['guest_email'] = $email;
                Session::put('guest_email', $email);
            }
            $data['service'] = $row['service'];
            $data['category'] = $row['category'];
            $data['subcategory'] = $row['subcategory'];
            $data['variant'] = $row['variant'];
            $data['price'] = $row['price'];
            $data['store_id'] = $id;

            $tempData = new TempServiceStore();
            $tempData->fill($data);
            $tempData->save();
        }

        return ['status' => 'true', 'data' => []];

    }

    public function letCheckOut()
    {
        if (Auth::check()) {
            $getStore = TempServiceStore::where('user_id', Auth::user()->id)->value('store_id');
            $serviceData = TempServiceStore::where('user_id', Auth::user()->id)->get()->toArray();
        } else {
            $email = Session::get('guest_email');
            $getStore = TempServiceStore::where('guest_email', $email)->value('store_id');
            $serviceData = TempServiceStore::where('guest_email', $email)->get()->toArray();
        }

        $store = StoreProfile::where('id', $getStore)->first();

        $categoryData = [];
        $totaltime = 0;
        $totalamount = 0;

        foreach ($serviceData as $row) {
            $row['subcategory_name'] = \BaseFunction::getCategoryName($row['subcategory']);
            $variantData = \BaseFunction::variantData($row['variant']);
            $serviceData = \BaseFunction::serviceData($row['service']);
            $row['variant_data'] = $variantData;
            $row['service_data'] = $serviceData;
			if(!empty($variantData['duration_of_service'])){
				$row['duration_of_service'] = $variantData['duration_of_service'];
				$totaltime += $variantData['duration_of_service'];
			}else{
				$row['duration_of_service'] = 0;
			}
            $totalamount += $row['price'];
            $categoryData[(int)$row['category']][] = $row;
        }


        $data = [];

        foreach ($categoryData as $key => $value) {
            $data[] = array(
                'category' => \BaseFunction::getCategoryDate($key),
                'data' => $value,
                'totaltime' => array_sum(array_map(function($item) {
                    return $item['duration_of_service'];
                }, $value)),
            );
        }


        return view('Front.Cosmetic.booking.checkout', compact('data', 'store', 'totalamount'));
    }

    public function updateCheckoutData(Request $request)
    {

        $category = $request['category'];
        $store = $request['store'];
        $date = $request['date'];
        $employee = $request['employee'];
        $time = $request['time'];

        for ($i = 0; $i < count($category); $i++) {
            $updata['date'] = $date[$i];
            $updata['time'] = $time[$i];
            if (count($employee) > 0) {
                $updata['employee'] = $employee[$i];
            }

            $update = TempServiceStore::where('store_id', $store[$i]);
            if (Auth::check()) {
                $update = $update->where('user_id', Auth::user()->id);
            } else {
                $email = Session::get('guest_email');
                $update = $update->where('guest_email', $email);
            }
            $update = $update->where('category', $category[$i])->update($updata);
        }

        return redirect('zahlungsabschluss');
    }

    public function proceedToPay()
    {

        if (Auth::check()) {
            $getStore = TempServiceStore::where('user_id', Auth::user()->id)->value('store_id');
            $serviceData = TempServiceStore::where('user_id', Auth::user()->id)->get()->toArray();
        } else {
            $email = Session::get('guest_email');
            $getStore = TempServiceStore::where('guest_email', $email)->value('store_id');
            $serviceData = TempServiceStore::where('guest_email', $email)->get()->toArray();
        }
        $store = StoreProfile::where('id', $getStore)->first();

        $categoryData = [];
        $totaltime = 0;
        $totalamount = 0;
        foreach ($serviceData as $row) {
            $row['subcategory_name'] = \BaseFunction::getCategoryName($row['subcategory']);
            $variantData = \BaseFunction::variantData($row['variant']);
            $serviceData = \BaseFunction::serviceData($row['service']);
            $row['variant_data'] = $variantData;
            $row['service_data'] = $serviceData;
            $totaltime += $variantData['duration_of_service'];
            $totalamount += $row['price'];
            $categoryData[$row['category']][] = $row;
        }

        $data = [];
        foreach ($categoryData as $key => $value) {
            $data[] = array(
                'category' => \BaseFunction::getCategoryDate($key),
                'data' => $value,
                'totaltime' => $totaltime
            );
        }
//        dd($data);
        return view('Front.Cosmetic.booking.proccedToPay', compact('data', 'store', 'totalamount'));
    }

    public function orderConfirmation()
    {
        $status = Session::get('payment_status');
        $slug = Session::get('slug');
        $appointment_id = Session::get('appointment_id');

        $appointment = Appointment::where('id', $appointment_id)->first();
        $store = StoreProfile::findorFail($appointment['store_id']);
        $serviceData = AppointmentData::where('appointment_id', $appointment_id)->get();
        $paymentinfo = PaymentMethodInfo::where('appoinment_id', $appointment_id)->first();
        $appointmentData = [];

        foreach ($serviceData as $row) {

            $row['subcategory_name'] = \BaseFunction::getCategoryName($row['subcategory_id']);
            $variantData = \BaseFunction::variantData($row['variant_id']);
            $serviceDatas = \BaseFunction::serviceData($row['service_id']);
            $row['variant_data'] = $variantData;
            $row['service_data'] = $serviceDatas;
            $appointmentData[$row['category_id']][] = $row;
        }
        
        $data = [];
        foreach ($appointmentData as $key => $value) {
            $data[] = array(
                'category' => \BaseFunction::getCategoryDate($key),
                'data' => $value,
            );
        }
		
		if(!empty($paymentinfo->status) && $paymentinfo->status == 'failed'){
			Appointment::where('id', $appointment_id)->delete();
			 AppointmentData::where('appointment_id', $appointment_id)->delete();
			 PaymentMethodInfo::where('appoinment_id', $appointment_id)->delete();
		}

//dd($data);
        return view('Front.Cosmetic.booking.confirmation', compact('appointment', 'status', 'slug', 'store', 'paymentinfo', 'data'));
    }

    public function removeService(Request $request)
    {
        $id = $request['id'];
        if(empty($request['email'])){
            $user_id = Auth::user()->id;
        } else {
            $user_id = $request['email'];
        }
        if(Auth::check()){
            $getData = TempServiceStore::where('user_id',$user_id)->where('variant', $id)->first();

        } else {
            $getData = TempServiceStore::where('guest_email',$user_id)->where('variant', $id)->first();
            
        }
        
        $getStore = $getData['store_id'];
        $getPrice = $getData['price'];

        if(Auth::check()){
            $remove = TempServiceStore::where('user_id',$user_id)->where('variant', $id)->delete();
            $availableService = TempServiceStore::where('user_id',$user_id)->where('store_id', $getStore)->get();
            $totalAmount = TempServiceStore::where('user_id',$user_id)->where('store_id', $getStore)->sum('price');
            $totalservice = TempServiceStore::where('user_id',$user_id)->where('store_id',$getData['store_id'])->where('category',$getData['category'])->count();
        } else {

            $remove = TempServiceStore::where('guest_email',$user_id)->where('variant', $id)->delete();
            $availableService = TempServiceStore::where('guest_email',$user_id)->where('store_id', $getStore)->get();
            $totalAmount = TempServiceStore::where('guest_email',$user_id)->where('store_id', $getStore)->sum('price');
            $totalservice = TempServiceStore::where('guest_email',$user_id)->where('store_id',$getData['store_id'])->where('category',$getData['category'])->count();
        }



        if ($remove) {
            $data = array(
                'availableService' => $availableService,
                'totalamount' => $totalAmount,
                'totalservice'=>$totalservice
            );
            return ['status' => 'true', 'data' => $data];
        } else {
            return ['status' => 'false', 'data' => []];
        }

    }
	
	
	public function rescheduleAppointment(Request $request)
    {
        $id 			= $request['id'];
        $date 			= $request['date'];
        $time 			= $request['time'];
		$totalTime 		= $request['totalTime'];
		
		
        $appointmentData['appo_date'] = \Carbon\Carbon::parse($date);
        $appointmentData['appo_time'] = \Carbon\Carbon::parse($time)->format('H:i');
		$appointmentData['app_end_time'] = \Carbon\Carbon::parse($appointmentData['appo_time'])->addMinutes($totalTime)->format('H:i');
        $appointmentData['status'] 	  = 'booked';

        $appointmentUpdated = AppointmentData::where('id', $id)->update($appointmentData);
		
        if ($appointmentUpdated) {
			$appointmentData 	= AppointmentData::find($id);
			$appointment 		= Appointment::find($appointmentData['appointment_id']);
			/** push notification */
			$store_user_id  = StoreProfile::where('id', $appointment['store_id'])->value('user_id');
			$PUSer = User::find($store_user_id);
			if(!empty($PUSer->device_token)){
				$sessioncount = ApiSession::where('user_id', $PUSer->id)->count();
				if($sessioncount > 0){
					//$registerarion_ids = array($PUSer->device_token);
					$registerarion_ids = ApiSession::where('user_id', $PUSer->id)->pluck('device_token')->toArray(); 
					\BaseFunction::sendPushNotificationServiceProvider($registerarion_ids, 'Verschoben !', 'Sie haben eine neue Buchung erhalten', NULL, $appointment['store_id'], $id, 3);
				}
			}
			\BaseFunction::notification('Verschoben !','Sie haben eine neue Buchung erhalten','appointment', $id, $appointment['store_id'], $appointment['user_id'], $appointment['user_id'] == ''? 'guest' : '');
			$slug = \BaseFunction::getSlug($appointment['store_id']);
			Session::put('payment_status', 'success');
			Session::put('slug', $slug);
			Session::put('appointment_id', $appointment['id']);
			return response()->json(['ResponseCode' => "success", 'ResponseText' => 'Successful', 'ResponseData' => NULL], 200);
        } else {
            return response()->json(['ResponseCode' => "failed", 'ResponseText' => 'failed', 'ResponseData' => NULL], 400);
        }
    } 


}
