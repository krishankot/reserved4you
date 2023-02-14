<?php

namespace App\Http\Controllers\Api\User\PaymentDetails;

use App\Http\Controllers\Controller;
use App\Models\Payment as Payments;
use App\Models\PaymentMethodInfo;
use App\Models\Service;
use App\Models\ServiceAppoinment;
use App\Models\Appointment;
use App\Models\AppointmentData;
use App\Models\User;
use App\Models\ApiSession;
use App\Models\StoreProfile;
use App\Models\BookingTemp;
use App\Models\TemporarySelectService;
use App\Models\TempServiceStore;
use App\Models\ServiceVariant;
use App\Models\Category;
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
use Validator;
use Exception;

class PaymentController extends Controller
{
    public function withdrawPayment(Request $request)
    {

		 $data = $request->all();
        // dd($data);
        $checkval = $this->sameBookingChecking(json_decode($data['AppoData']),$data['store_id']);
        // dd($checkval);
        if($checkval['status'] == 'false'){
            // \Session::put('booking_error', 'yes');
            // return redirect('checkout-data');
			$remove = BookingTemp::whereIn('id',$checkval['id'])->delete();
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Tut uns Leid! Dieser Termin ist mit den angegebenen Daten nicht buchbar. Bitte wähle eine andere Uhrzeit.', 'ResponseData' => []]);
            
        }
        $value = $this->checkBooking(json_decode($data['AppoData']),$data['store_id']);
        
        if(count($value) > 0){
            // \Session::put('booking_error', 'yes');
            // return redirect('checkout-data');
			$remove = BookingTemp::whereIn('id',$checkval['id'])->delete();
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Tut uns Leid! Dieser Termin ist mit den angegebenen Daten nicht buchbar. Bitte wähle eine andere Uhrzeit.', 'ResponseData' => []]);
        } 
		
        // $stripe = new \Stripe\StripeClient(
        //         env('STRIPE_SECRET_KEY')
        //       );
        

        //     $token = $stripe->tokens->create([
        //         'card' => [
        //             'number' => $data['card_number'],
        //             'exp_month' => $data['ex_month'],
        //             'exp_year' => $data['ex_year'],
        //             'cvc' => $data['cvv']
        //         ],
        //     ]);
        //     if (!isset($token['id'])) {
        //         return response()->json(['ResponseCode' => 0, 'ResponseText' => __('Something went wrong'), 'ResponseData' => null], 400);
        //     }
        //     $token = $token['id'];
        //     dd($token);
        $card_type  = NULL;
        if ($data['payment_method'] == 'stripe') {
            $rule = [
                'payment_method' => 'required',
                'card_number' => 'required|min:16',
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required',
                'phone_number' => 'required',
                'cvv' => 'required',
                // 'postal_code' => 'required',
                'ex_month' => 'required',
                'ex_year' => 'required',
                //'stripeToken'=>'required'
            ];
            $message = [
                'payment_method.required' => 'payment_method is required',
                'card_number.required' => 'Card Number is required',
                'card_number.min' => 'card number Must be 16 Characters',
                'first_name.required' => 'first name is required',
                'last_name.required' => 'last name is required',
                'email.required' => 'email name is required',
                'phone_number.required' => 'phone number is required',
                'cvv.required' => 'cvv is required',
                'postal_code.required' => 'postal code is required',
                'ex_month.required' => 'ex date is required',
                'ex_year.required' => 'ex year is required',
                'stripeToken.required' => 'stripe token is required',
            ];
            $validate = Validator::make($request->all(), $rule, $message);

            if ($validate->fails()) {
				BookingTemp::whereIn('id',$checkval['id'])->delete();
                return response()->json(['ResponseCode' => 0, 'ResponseText' => __('Validation failed'), 'ResponseData' => $validate->errors()->all()], 422);
            }
        }
        // $serviceDetails = Service::where('id', $data['service_id'])->first();

        // $amount = \BaseFunction::finalPrice($serviceDetails['id']);
        $amount = $data['amount'];
        $userDetails = User::with('userAddress')->where('id',$data['user']['user_id'])->first();
        if ($data['payment_method'] == 'stripe') {            
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
			try{
				 $token = $stripe->tokens->create([
					'card' => [
					 'number' => $data['card_number'],
					 'exp_month' => $data['ex_month'],
					  'exp_year' => $data['ex_year'],
					  'cvc' => $data['cvv']
					 ],
				]);
				
			}catch (\Stripe\Exception\CardException $e) {
				BookingTemp::whereIn('id',$checkval['id'])->delete();
				 return response()->json(['ResponseCode' => 0, 'ResponseText' => $e->getError()->message, 'ResponseData' => ''], 400);
			}
			
            if (!isset($token['id'])) {
				BookingTemp::whereIn('id',$checkval['id'])->delete();
                return response()->json(['ResponseCode' => 0, 'ResponseText' => __('Please check card details'), 'ResponseData' => null], 400);
            }else{
				$data['stripeToken']  = $token['id'];
			}
			
            if ($userDetails) {
                if ($userDetails->customer_id == '') {
                    $customer = $stripe->customers->create([
                        'name' => $data['first_name'].' '.$data['last_name'],
                        'email' => $data['email'],
                        'address' => [
                            'line1' => $userDetails['userAddress'] == null ? null :$userDetails['userAddress']['address']
                        ]
                    ]);
                    $update = User::where('id', $userDetails->id)->update(['customer_id' => $customer['id']]);
                    $c_id = $customer['id'];
                } else {
                    $c_id = $userDetails->customer_id;
                }
            } else {
                $customer = $stripe->customers->create([
                    'name' => $data['first_name'].' '.$data['last_name'],
                    'email' => $data['email']
                ]);
                $c_id = $customer['id'];
            }


           
			try{
				$c_id  = trim($c_id);
				 $card = $stripe->customers->createSource(
					$c_id,
					['source' => $data['stripeToken']]
				);
				
				if(!empty($card['id'])){
					$customer = $stripe->customers->update(
						 $c_id,
						 ['default_source' => $card['id']]
					);
				}
			
				$charge = $stripe->charges->create([
					'amount' => $amount * 100,
					'currency' => 'eur',
					'customer' => $c_id,
					'description' => 'R4U Service',
				]);
			}catch (\Stripe\Exception\ApiErrorException  $e) {
				BookingTemp::whereIn('id',$checkval['id'])->delete();
				 return response()->json(['ResponseCode' => 0, 'ResponseText' => $e->getError()->message, 'ResponseData' => ''], 400);
			}

            $charge_id = $charge['id'];
            $payment_method = 'stripe';
            $status = 'booked';
			$card_type = !empty($charge->source->brand)?$charge->source->brand:NULL;

		}elseif ($data['payment_method'] == 'applepay' OR $data['payment_method'] == 'googlepay') {  
			/* if(!empty($data['testmode']) && $data['testmode'] == 1){
				$stripe = new \Stripe\StripeClient('sk_test_hHiwaXoEWblwzGpUgMsR9W0M00GwOAS2NB');
			}else{
				$stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
			} */ 
			$stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
			//$stripe = new \Stripe\StripeClient('sk_test_hHiwaXoEWblwzGpUgMsR9W0M00GwOAS2NB');
            try{
				if ($userDetails) {
					if ($userDetails->customer_id == '') {
						$customer = $stripe->customers->create([
							'name' => $data['first_name'].' '.$data['last_name'],
							'email' => $data['email'],
							'address' => [
								'line1' => $userDetails['userAddress'] == null ? null :$userDetails['userAddress']['address']
							]
						]);
						$update = User::where('id', $userDetails->id)->update(['customer_id' => $customer['id']]);
						$c_id = $customer['id'];
					} else {
						$c_id = $userDetails->customer_id;
					}
				} else {
					$customer = $stripe->customers->create([
						'name' => $data['first_name'].' '.$data['last_name'],
						'email' => $data['email']
					]);
					$c_id = $customer['id'];
				}


				/* $card = $stripe->customers->createSource(
					$c_id,
					['source' => $data['stripeToken']]
				);
				
				if(!empty($card['id'])){
					$customer = $stripe->customers->update(
						 $c_id,
						 ['default_source' => $card['id']]
					);
				} */
				

			
			 $paymetnmethod = $stripe->paymentMethods->create([
				'type' => 'card',
				'card' =>  ['token' => $data['stripeToken']],
			]);

				
				$redirectUrl = URL::to('karla-payment-success');
				$intent = $stripe->paymentIntents->create([
					'confirm' => true,
					'customer' => $c_id,
					'amount' =>  $amount * 100,
					'description' => 'R4U Service',
					'currency' => 'eur',
					'payment_method' => $paymetnmethod,
					'payment_method_types' =>  ['card'],
					'return_url' => $redirectUrl,
				]);
				
				
					$charge_id = $intent['id'];
					$payment_method = $data['payment_method'];
					$status = 'booked';
			}catch (\Stripe\Exception\ApiErrorException  $e) {
				BookingTemp::whereIn('id',$checkval['id'])->delete();
				 return response()->json(['ResponseCode' => 0, 'ResponseText' => $e->getError()->message, 'ResponseData' => ''], 400);
			}

           /*  $charge = $stripe->charges->create([
                'amount' => $amount * 100,
                'currency' => 'eur',
                'customer' => $c_id,
                'description' => 'R4U Service',
            ]); */
		}
        elseif ($data['payment_method'] == 'paypal') {
            $charge_id = '';
            $payment_method = 'paypal';  
            $status = 'pending';          
        }
        elseif ($data['payment_method'] == 'cash') {

            $charge_id = 'Cash';
            $payment_method = 'cash';
            $status = 'booked';
        }
        // elseif ($data['payment_method'] == 'applepay') {
        //     $charge_id = '';
        //     $payment_method = 'applepay';

        // }
        elseif ($data['payment_method'] == 'klarna') {
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));             
            if ($userDetails) {
                if ($userDetails->customer_id == '') {
                    $customer = $stripe->customers->create([
                        'name' => $data['first_name'].''.$data['last_name'],
                        'email' => $data['email'],                        
                    ]);
                    $update = User::where('id', $userDetails->id)->update(['customer_id' => $customer['id']]);
                    $c_id = $customer['id'];
                } else {
                    $c_id = $userDetails->customer_id;

                }
            } else {
                $$customer = $stripe->customers->create([
                    'name' => $data['first_name'].''.$data['last_name'],
                    'email' => $data['email'],
                ]);
                $c_id = $customer['id'];
            }            
            $redirectUrl = URL::to('api/v1/user/karla-payment-success');
			try{
				$intent = $stripe->paymentIntents->create([
					'confirm' => true,
					'amount' => $amount * 100,
					'customer' =>  $c_id,
					'currency' => 'eur',
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
				 BookingTemp::whereIn('id',$checkval['id'])->delete();
				 return response()->json(['ResponseCode' => 0, 'ResponseText' => $e->getError()->message, 'ResponseData' => ''], 400);
			}
            $charge_id = $intent['id'];
            $payment_method = 'klarna';
            $status = 'pending';
        }


        $appointmentData['store_id'] = $data['store_id'];
        // $appointmentData['store_emp_id'] = $data['emp_id'];
        // $appointmentData['service_id'] = $serviceDetails['id'];
        // $appointmentData['service_name'] = $serviceDetails['service_name'];
        // $appointmentData['appo_date'] = \Carbon\Carbon::parse($data['date']);
        // $appointmentData['appo_time'] = \Carbon\Carbon::parse($data['time'])->format('H:i:s');
        // $appointmentData['status'] = 'booked';
        $appointmentData['order_id'] = \BaseFunction::orderNumber();
        $appointmentData['total_amount'] = $amount;
        
        if ($userDetails['user_type'] == 'guest') {
            $getEmail = User::where('email',$userDetails['email'])->first();            
            if(!empty($getEmail)){
                $appointmentData['user_id'] = $getEmail['id'];
            }            
            $appointmentData['first_name'] = $data['first_name'];
            $appointmentData['last_name'] = $data['last_name'];
            $appointmentData['email'] = $data['email'];
            $appointmentData['phone_number'] = $data['phone_number'];
        } else {
            $appointmentData['user_id'] = $data['user']['user_id'];
            $appointmentData['first_name'] = $data['first_name'];
            $appointmentData['last_name'] = $data['last_name'];
            $appointmentData['email'] = $data['email'];
            $appointmentData['phone_number'] = $data['phone_number'];
        }        
        $appointmentData['appointment_type'] = 'system';

        $appointment = new Appointment();
        $appointment->fill($appointmentData);
        if ($appointment->save()) { 
            $appoData = json_decode($data['AppoData']); 
            $this->storeAppoData($appoData,$appointment['id'],$data['store_id'],$status);         
            // if ($userDetails['user_type'] != 'guest') {
            $paymentinfo['user_id'] = $data['user']['user_id'];
            // }
            $paymentinfo['store_id'] = $appointment['store_id'];
            // $paymentinfo['service_id'] = $appointment['service_id'];
            $paymentinfo['order_id'] = $appointment['order_id'];
            $paymentinfo['payment_id'] = $charge_id;
            $paymentinfo['total_amount'] = $appointment['total_amount'];
            if ($data['payment_method'] == 'stripe') {
                $paymentinfo['status'] = 'succeeded'; 
				$paymentinfo['card_type']  = $card_type;
            } elseif ($data['payment_method'] == 'paypal') {
                $paymentinfo['status'] = 'pending';
            } elseif ($data['payment_method'] == 'cash') {
                $paymentinfo['status'] = 'succeeded';
            } elseif ($data['payment_method'] == 'klarna') {
                $paymentinfo['status'] = 'pending';
            } elseif ($data['payment_method'] == 'applepay' OR $data['payment_method'] == 'googlepay') {
                $paymentinfo['status'] = !empty($intent->status)?$intent->status:'pending';
            }

            $paymentinfo['appoinment_id'] = $appointment['id'];
            $paymentinfo['payment_method'] = $payment_method;
            $paymentinfo['payment_type'] = 'withdrawn';

            $paymentDatas = new PaymentMethodInfo();
            $paymentDatas->fill($paymentinfo);
            $paymentDatas->save();

            $orderConformData = \BaseFunction::orderConformData($appointment['id']);
            if ($data['payment_method'] == 'klarna') {

                if ($intent->status == 'requires_action' && $intent->next_action->type == 'redirect_to_url') {

                    if ($userDetails['usertype'] == 'guest') {
                        $mailName = $userDetails['first_name'] . ' ' . $userDetails['last_name'];
                        $mailemail = $userDetails['email'];
                    } else {
                        $mailName = $userDetails['first_name'] . ' ' . $userDetails['last_name'];
                        $mailemail = $userDetails['email'];
                    }
                    $message = 'Your Appointment has been booked';
                    $url = $intent->next_action->redirect_to_url->url;
                    $data = [
                        'redirect_to_url' =>$url,
                        'payment_intent'=>$intent['id'],
                        'appoinment_id'=>$appointment['id'],
                        'store_id' => $appointment['store_id'],
                        'booking'=> implode(',',$checkval['id'])
                    ];
                    return response()->json(['ResponseCode' => 1, 'ResponseText' => $message, 'ResponseData' => $data], 200);

                } else {                    
                    $message = 'Your Appointment has been failed';
                    $remove = BookingTemp::whereIn('id',$checkval['id'])->delete();
                    return response()->json(['ResponseCode' => 0, 'ResponseText' => $message, 'ResponseData' => $orderConformData], 200);
                }
            }
            if ($data['payment_method'] == 'paypal') {                
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
                $redirectUrls->setReturnUrl(URL::to('api/v1/user/paypal/payment/success'))
                    ->setCancelUrl(URL::to('api/v1/user/paypal/cancel'));
                
                $payment = new Payment();
                $payment->setIntent('sale')
                    ->setPayer($payer)
                    ->setTransactions(array($transaction))
                    ->setRedirectUrls($redirectUrls);
                
                if ($userDetails['user_type'] == 'guest') {
                    $mailName = $userDetails['first_name'] . ' ' . $userDetails['last_name'];
                    $mailemail = $userDetails['email'];
                } else {
                    $mailName = $userDetails['first_name'] . ' ' . $userDetails['last_name'];
                    $mailemail = $userDetails['email'];
                }
                try {
                    
                    $title = 'New Appointment Booked';
                    $title1 = 'Your Appointment has been booked';
                    $data_mail = ['title' => $title, 'title1' => $title1, 'email' => $mailemail, 'name' => $mailName];                    
                   //$payment->create($apiContext);
                    $payment->create($this->_api_context);                   
                    PaymentMethodInfo::where('id', $paymentDatas->id)->update(['payment_id' => $payment->getId()]);
                    $message = 'Your Appointment has been booked';
                    $data = [
                        'redirect_to_url' =>$payment->getApprovalLink(),                        
                        'paypal_payment_id'=> $payment->getId(),
                        'appoinment_id'=>$appointment['id'],
                        'datamail'=>$data_mail,
                        'store_id'=>$appointment['store_id'],
                        'booking' => implode(',',$checkval['id']),
                    ];
                    // dd($data);
                    // return redirect($url);
                    return response()->json(['ResponseCode' => 1, 'ResponseText' => $message, 'ResponseData' => $data], 200);

                    
                } catch (PayPalConnectionException $ex) {
                    
                    TemporarySelectService::where('device_token',$data['device_token'])->delete();  
                    $remove = BookingTemp::whereIn('id',$checkval['id'])->delete();                  
                    $message = 'Your Appointment has been failed';
                    return response()->json(['ResponseCode' => 0, 'ResponseText' => $message, 'ResponseData' => $orderConformData], 200);                    
                }

            } 
            if ($data['payment_method'] == 'cash') {
                $orderConformData = \BaseFunction::orderConformData($appointment['id']);
                TemporarySelectService::where('device_token',$data['device_token'])->delete();
                BookingTemp::whereIn('id',$checkval['id'])->delete();
                // add by punit
				//send appointmentment confirmation email to user
				\BaseFunction::sendEmailNotificationAppointmentConfirmation($appointment['id']);
				
				/** push notification */
				$store_user_id  = StoreProfile::where('id', $appointment['store_id'])->value('user_id');
				$PUSer = User::find($store_user_id);
				if(!empty($PUSer->device_token)){
					$sessioncount = ApiSession::where('user_id', $PUSer->id)->count();
					if($sessioncount > 0){
						//$registerarion_ids = array($PUSer->device_token);
						$registerarion_ids = ApiSession::where('user_id', $PUSer->id)->pluck('device_token')->toArray(); 
						$appointmentArr = AppointmentData::where('appointment_id', $appointment['id'])->get();
						foreach($appointmentArr as $val){
							\BaseFunction::sendPushNotificationServiceProvider($registerarion_ids, 'Neue Buchung !', 'Sie haben eine neue Buchung erhalten', NULL, $appointment['store_id'], $val['id'], 1);
						}
					}
				}
				
                \BaseFunction::notification('Neue Buchung !','Sie haben eine neue Buchung erhalten','appointment',$appointment['id'],$appointment['store_id'],$appointment['user_id'],$appointment['user_id'] == ''? 'guest' : '');


                return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Zahlung erfolgreich', 'ResponseData' => $orderConformData], 200);
            }
            if ($data['payment_method'] == 'stripe') {
                $orderConformData = \BaseFunction::orderConformData($appointment['id']);
                if ($charge['status'] == 'succeeded') {
                    BookingTemp::whereIn('id',$checkval['id'])->delete();
                    TemporarySelectService::where('device_token',$data['device_token'])->delete();

					//send appointmentment confirmation email to user
					\BaseFunction::sendEmailNotificationAppointmentConfirmation($appointment['id']);
                    
					/** push notification */
					$store_user_id  = StoreProfile::where('id', $appointment['store_id'])->value('user_id');
					$PUSer = User::find($store_user_id);
					if(!empty($PUSer->device_token)){
						$sessioncount = ApiSession::where('user_id', $PUSer->id)->count();
						if($sessioncount > 0){
							//$registerarion_ids = array($PUSer->device_token);
							$registerarion_ids = ApiSession::where('user_id', $PUSer->id)->pluck('device_token')->toArray(); 
							$appointmentArr = AppointmentData::where('appointment_id', $appointment['id'])->get();
							foreach($appointmentArr as $val){
								\BaseFunction::sendPushNotificationServiceProvider($registerarion_ids, 'Neue Buchung !', 'Sie haben eine neue Buchung erhalten', NULL, $appointment['store_id'], $val['id'], 1);
							}
						}
					}
				
                    \BaseFunction::notification('Neue Buchung !','Sie haben eine neue Buchung erhalten','appointment',$appointment['id'],$appointment['store_id'],$appointment['user_id'],$appointment['user_id'] == ''? 'guest' : '');

                    return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Zahlung erfolgreich', 'ResponseData' => $orderConformData], 200);
                }
                BookingTemp::whereIn('id',$checkval['id'])->delete();
                return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Zahlung leider nicht möglich', 'ResponseData' => $orderConformData], 200);
            }else if($data['payment_method'] == 'applepay' || $data['payment_method'] == 'googlepay'){
                $orderConformData = \BaseFunction::orderConformData($appointment['id']);
                if ($intent['status'] == 'succeeded') {
                    BookingTemp::whereIn('id',$checkval['id'])->delete();
                    TemporarySelectService::where('device_token',$data['device_token'])->delete();

					//send appointmentment confirmation email to user
					\BaseFunction::sendEmailNotificationAppointmentConfirmation($appointment['id']);
                    
					/** push notification */
					$store_user_id  = StoreProfile::where('id', $appointment['store_id'])->value('user_id');
					$PUSer = User::find($store_user_id);
					if(!empty($PUSer->device_token)){
						$sessioncount = ApiSession::where('user_id', $PUSer->id)->count();
						if($sessioncount > 0){
							//$registerarion_ids = array($PUSer->device_token);
							$registerarion_ids = ApiSession::where('user_id', $PUSer->id)->pluck('device_token')->toArray(); 
							$appointmentArr = AppointmentData::where('appointment_id', $appointment['id'])->get();
							foreach($appointmentArr as $val){
								\BaseFunction::sendPushNotificationServiceProvider($registerarion_ids, 'Neue Buchung !', 'Sie haben eine neue Buchung erhalten', NULL, $appointment['store_id'], $val['id'], 1);
							}
						}
					}
				
                    \BaseFunction::notification('Neue Buchung !','Sie haben eine neue Buchung erhalten','appointment',$appointment['id'],$appointment['store_id'],$appointment['user_id'],$appointment['user_id'] == ''? 'guest' : '');

                    return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Zahlung erfolgreich', 'ResponseData' => $orderConformData], 200);
                }
                BookingTemp::whereIn('id',$checkval['id'])->delete();
                return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Zahlung leider nicht möglich', 'ResponseData' => $orderConformData], 200);
           
			}
            else {                
                return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Zahlung erfolgreich', 'ResponseData' => true], 200);
                // if ($charge['status'] == 'succeeded') {
                // }
                // return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Zahlung leider nicht möglich', 'ResponseData' => false], 200);                              
            }


        }


    }

    public function success(Request $request)
    {     
           
        $this->_api_context = new ApiContext(new OAuthTokenCredential(
            'AVW3rqhQztKPMYoPPY6FlbN94RC9jT7_9qyOKD5_EZ0vxccekchb-SAm-3EsEJDYrwIbTOu9OzRTNraz',
            'ECcTdZ_KybPvviJL9GJjEBFW7ixio2MhV-eKZuUkssk3Zf0u-bbNfJ6j6Qk8YvNqgn0TK4G3of6yNZpC'));
            
            $payment_id = request('paymentId');
            $oredr_number = request('appoinment_id');
            $data_mail = request('datamail');
            $store = request('store_id');    
            $booking = request('booking');        
        
         $appointment = Appointment::where('id',$oredr_number)->first();

        $slug = \BaseFunction::getSlug($store);

        if (empty($request->PayerID) || empty($request->token) || empty($payment_id) || empty($oredr_number)) {
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Invalid request.!', 'ResponseData' => null], 400);
            // return back()->with('errors', ['Invalid request.']);
        }

        $payment = Payment::get($payment_id, $this->_api_context);

        $execution = new PaymentExecution();
        $execution->setPayerId($request->PayerID);

        $result = $payment->execute($execution, $this->_api_context);

        if ($result->getState() == 'approved') {
            PaymentMethodInfo::where('appoinment_id', $oredr_number)->where('payment_id', $payment_id)->update(['status' => 'succeeded']);
            AppointmentData::where('appointment_id',$oredr_number)->where('store_id',$store)->update(['status' => 'booked']);
            $remove = BookingTemp::whereIn('id',explode(',',$booking))->delete();

             // add by punit
			 
			 /** push notification */
			$store_user_id  = StoreProfile::where('id', $appointment['store_id'])->value('user_id');
			$PUSer = User::find($store_user_id);
			if(!empty($PUSer->device_token)){
				$sessioncount = ApiSession::where('user_id', $PUSer->id)->count();
				if($sessioncount > 0){
					//$registerarion_ids = array($PUSer->device_token);
					$registerarion_ids = ApiSession::where('user_id', $PUSer->id)->pluck('device_token')->toArray(); 
					$appointmentArr = AppointmentData::where('appointment_id', $appointment['id'])->get();
					foreach($appointmentArr as $val){
						\BaseFunction::sendPushNotificationServiceProvider($registerarion_ids, 'Neue Buchung !', 'Sie haben eine neue Buchung erhalten', NULL, $appointment['store_id'], $val['id'], 1);
					}
				}
			}
			 
              \BaseFunction::notification('Neue Buchung !','Sie haben eine neue Buchung erhalten','appointment',$appointment['id'],$appointment['store_id'],$appointment['user_id'],$appointment['user_id'] == ''? 'guest' : '');
            // Session::put('payment_status', 'success');
            $status = "succeeded";
        } else {
            PaymentMethodInfo::where('appoinment_id', $oredr_number)->where('payment_id', $payment_id)->update(['status' => 'failed']);
            $remove = BookingTemp::whereIn('id',explode(',',$booking))->delete();
            $status = "failed";
            // Session::put('payment_status', 'failed');
        }

        // try {
            //            Mail::send('email.report_user', $data_mail, function ($message) use ($data_mail) {
            //                $message->from('info@burrardpharma.com', "Burrard Pharma")->subject($data_mail['title1']);
            //                $message->to($data_mail['email']);
            //            });
            TemporarySelectService::where('device_token',$request['device_token'])->delete();
            $orderConformData = \BaseFunction::orderConformData($oredr_number);
            return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Zahlung erfolgreich', 'ResponseData' => $orderConformData], 200);
        // } catch (\Swift_TransportException $e) {
        //     \Log::debug($e);
        //     return response()->json(['ResponseCode' => 0, 'ResponseText' => __('Something went wrong'), 'ResponseData' => null], 400);
        // }
    }

    public function cancel()
    {
        $payment_id = request('paymentId');
        $appointmentId = request('appoinment_id');            
        $store = request('store_id'); 
        TemporarySelectService::where('device_token',$request['device_token'])->delete();
        $orderConformData = \BaseFunction::orderConformData($appointmentId);
        return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Your Payment has been Cancled!', 'ResponseData' => ''], 200);
        // $store = Session::get('store_id');

        // Session::forget('paypal_payment_id');
        // Session::forget('orderNumber');
        // Session::forget('datamail');
        // Session::forget('store_id');

        // $slug = \BaseFunction::getSlug($store);

        // Session::put('payment_status', 'failed');
        // return redirect('cosmetic/' . $slug);
    }

    public function klarnaSuccess(Request $request)
    {

        $data = $request->all();     
        // dd($data);        
        $booking = $data['booking'];

         $appointment = Appointment::where('id',$data['appoinment_id'])->first();
        // dd(explode(',',$booking));      
        if ($data['redirect_status'] == 'succeeded') {
            PaymentMethodInfo::where('appoinment_id',$data['appoinment_id'])->where('payment_id', $data['payment_intent'])->update(['status' => 'succeeded']);
            AppointmentData::where('appointment_id',$data['appoinment_id'])->where('store_id',$data['store_id'])->update(['status' => 'booked']);
            $remove = BookingTemp::whereIn('id',explode(',',$booking))->delete();
			
			 /** push notification */
			$store_user_id  = StoreProfile::where('id', $appointment['store_id'])->value('user_id');
			$PUSer = User::find($store_user_id);
			if(!empty($PUSer->device_token)){
				$sessioncount = ApiSession::where('user_id', $PUSer->id)->count();
				if($sessioncount > 0){
					//$registerarion_ids = array($PUSer->device_token);
					$registerarion_ids = ApiSession::where('user_id', $PUSer->id)->pluck('device_token')->toArray(); 
					$appointmentArr = AppointmentData::where('appointment_id', $appointment['id'])->get();
					foreach($appointmentArr as $val){
						\BaseFunction::sendPushNotificationServiceProvider($registerarion_ids, 'Neue Buchung !', 'Sie haben eine neue Buchung erhalten', NULL, $appointment['store_id'], $val['id'], 1);
					}
				}
			}
			
            \BaseFunction::notification('Neue Buchung !','Sie haben eine neue Buchung erhalten','appointment',$appointment['id'],$appointment['store_id'],$appointment['user_id'],$appointment['user_id'] == ''? 'guest' : '');

            $status = $data['redirect_status'];
        } else {
            PaymentMethodInfo::where('appoinment_id',$data['appoinment_id'])->where('payment_id', $data['payment_intent'])->update(['status' => 'failed']);
            $remove = BookingTemp::whereIn('id',explode(',',$booking))->delete();
            $status = $data['redirect_status'];
        }

        try {
            if (!empty($data['device_token'])) {
                $deviceToken = $data['device_token'];
            }else{
                $deviceToken = '';
            }
            TemporarySelectService::where('device_token',$deviceToken)->delete();
            //Mail::send('email.report_user', $data_mail, function ($message) use ($data_mail) {
            //   $message->from('info@burrardpharma.com', "Burrard Pharma")->subject($data_mail['title1']);
            //   $message->to($data_mail['email']);
            // });
            // \Log::debug($data['appoinment_id']);
            $orderConformData = \BaseFunction::orderConformData($data['appoinment_id']);
            // \Log::debug($orderConformData);
            if ($status == 'succeeded') {
                return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Zahlung erfolgreich', 'ResponseData' => $orderConformData], 200);
            }
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Zahlung leider nicht möglich', 'ResponseData' => $orderConformData], 200);

        } catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => __('Something went wrong'), 'ResponseData' => null], 400);
        }

    }

    public function applePay(){
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));

        $intent = $stripe->paymentIntents->create([
            'amount' => 1099,
            'currency' => 'eur',
            // Verify your integration in this guide by including this parameter
            'metadata' => ['integration_check' => 'accept_a_payment'],
        ]);
        dd($intent);

    }   


    //store selected services 
    public function selectService(Request $request)
    {
        try {
            $data = request()->all();             
                        
            $newSelection = TemporarySelectService::updateOrCreate([                                
                'store_id'   => $data['store_id'],                
                'service_id'   => $data['service_id'],
                'category_id'   => $data['category_id'],                
                'subcategory_id'   => $data['subcategory_id'],                
                // 'service_variant_id' =>$data['service_variant_id'],
                'device_token' => $data['device_token']
            ],[
                'store_id'   => $data['store_id'],                
                'service_id'   => $data['service_id'],
                'category_id'   => $data['category_id'],                
                'subcategory_id'   => $data['subcategory_id'],                
                'service_variant_id' =>$data['service_variant_id'],
                'device_token' => $data['device_token']
            ]);
            return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Select Service Successful!', 'ResponseData' => $newSelection], 200);
        } catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => __('Something went wrong'), 'ResponseData' => null], 400);
        }
    }

    //get the selected services
    public function getSelectedServices(Request $request)
    {
        try {
            $data = request()->all();
            $deviceToken = $data['device_token'];
            $getData = TemporarySelectService::where('device_token',$data['device_token'])->get();                                                
            $serviceId = array();
            $categoryId = array();
            foreach ($getData as $value) {
                $serviceId[] = $value['service_id'];
                $categoryId[] = $value['category_id'];                
            }                          
            $data = Category::with(['servicecategory' =>function($query)use($serviceId){                                                                                    
                $query->whereIn('id',$serviceId)
                ->select('id','store_id','category_id','subcategory_id','service_name','price','start_time','end_time','start_date','end_date','discount','image');
            }])->whereIn('id',$categoryId)->select('id','name','image')->get();                     
            foreach ($data as $row) {                                                
                foreach($row['servicecategory'] as $value){                                            
                    $value['discount'] = number_format($value['discount'],0);
                    $value['price'] = number_format($value['price'],2);
                    $value['service_variant'] = TemporarySelectService::with('serviceVeriant')->where('service_id',$value['id'])->where('device_token',$deviceToken)->get();                        
                    foreach ($value['service_variant'] as $key) {                                                                                              
                        $key['description'] = $key['serviceVeriant']['description'];
                        $key['duration_of_service'] = $key['serviceVeriant']['duration_of_service'];
                        $key['v_price'] = number_format($key['serviceVeriant']['price'],2);  
                        $key['v_price_final'] = number_format(\BaseFunction::finalPriceVariant($key['serviceVeriant']['service_id'],$key['serviceVeriant']['id']),2);                       
                        $row['emp_ids'] = @$key['emp_id'];
                        $row['emp_name'] = @$key['serviceEmp']['emp_name'];
                        $row['emp_image'] = @$key['serviceEmp']['emp_image_path'];
                        $row['store_name'] = @$key['StoreDetails']['store_name'];
                        $row['appo_date'] =  $key['appo_date'];
                        $row['appo_date_temp'] = $key['appo_date_temp'];
                        $row['appo_time'] = date('H:i', strtotime($key['appo_time'])); ;
                        unset($key->serviceVeriant,$key->serviceEmp,$key->StoreDetails);                        
                    }
                    
                }
            }            
            if (count($data) > 0) {
                return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Buchung war erfolgreich', 'ResponseData' => $data], 200);
            }
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Leider bisher keine Einträge.', 'ResponseData' => NULL], 400);
        } catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'SUps! Da ist ein Fehler aufgetreten.', 'ResponseData' => null], 400);
        }

    }  
    //cancelation service
    public function cancelService(Request $request)
    {
        try {
            $data = request()->all();
            $deleteService = TemporarySelectService::where(['device_token'=>$data['device_token'],'store_id'=>$data['store_id'],'service_id'=>$data['service_id'],'service_variant_id'=>$data['service_variant_id']])->delete();
            if($deleteService){
                return response()->json(['ResponseCode' => 1, 'ResponseText' => __('Service Cancelled Successfully'), 'ResponseData' => true], 200);                
            }
            return response()->json(['ResponseCode' => 0, 'ResponseText' => __('Something went wrong'), 'ResponseData' => null], 400);
        } catch (\Throwable $th) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => __('Something went wrong'), 'ResponseData' => null], 400);
        }
    }

    /**
     * update check out data
     */
    public function updateCheckoutData(Request $request)
    {
        try {
            $data = request()->all();
            $checkoutData = [
                'emp_id'    => $data['emp_id'],
                'appo_date' => $data['appo_date'],
                'appo_date_temp' => $data['appo_date_temp'],
                'appo_time' => $data['appo_time'],
                'totalTime'=>$data['totalTime']
            ];            
            $updateData = TemporarySelectService::where(
                            [
                                'store_id'=>$data['store_id'],
                                'category_id'=>$data['category_id'],
                                'device_token'=>$data['device_token']
                            ]
                        )->update($checkoutData);
                        
            if ($updateData) {
                return response()->json(['ResponseCode' => 1, 'ResponseText' => 'updated successfull', 'ResponseData' => []], 200);
            }
            return response()->json(['ResponseCode' => 0, 'ResponseText' => __('Something went wrong'), 'ResponseData' => null], 400);
        } catch (\Throwable $e) {
            dd($e);
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => __('Something went wrong'), 'ResponseData' => null], 400);
        }
    }

    /**
     * remove item selections
     */
    public function clearSelectionItemStore(Request $request)
    {
        try {
            $data = request()->all();
            $updateItem = '';
            if (isset($data['store_id']) && !empty($data['store_id'])) {                
                $clearItem = TemporarySelectService::where('store_id',$data['store_id'])->where('device_token',$data['device_token'])->delete();
            }elseif(isset($data['flag']) && !empty($data['flag'])){
                $updateItem = TemporarySelectService::where('device_token',$data['device_token'])->update([
                                    'appo_date' => '',
                                    'appo_time' => '',
                                    'appo_date_temp' => ''
                                ]);                
            }
            else{
                $clearItem = TemporarySelectService::where('device_token',$data['device_token'])->delete();
            }
            if($updateItem && $updateItem != ''){
                return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Item updated successfull', 'ResponseData' => []], 200);
            }

            if ($clearItem) {
                return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Item clear successfull', 'ResponseData' => []], 200);
            }
            return response()->json(['ResponseCode' => 0, 'ResponseText' => __('Something went wrong'), 'ResponseData' => null], 400);
        } catch (\Throwable $e) {
            dd($e);
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => __('Something went wrong'), 'ResponseData' => null], 400);
        }
    }


    public function storeAppoData($data, $appo_id, $store_id, $status)
    {
        $catvalue = [];
        foreach ($data as $value) {
            $catvalue[$value->category_id][] = $value;            
        }
        
        

        foreach ($catvalue as $key => $row) {
            
            $cate_id = '';
            $newTime = '';
            foreach ($row as $value) {  
                
                if(empty($newTime)){
                    $start_time = \Carbon\Carbon::parse($value->appo_time)->format('H:i');
                }  else {
                    $start_time = \Carbon\Carbon::parse($newTime)->format('H:i');
                }
                
                $getTimeDuration = ServiceVariant::where('id',$value->variant_id)->value('duration_of_service');
                $endTime = \Carbon\Carbon::parse($start_time)->addMinutes($getTimeDuration)->format('H:i');
                $newTime = $endTime;
                
                $subData['appointment_id'] = $appo_id;
                $subData['store_id'] = $store_id;
                $subData['category_id'] = $value->category_id;
                $subData['subcategory_id'] = $value->subcategory_id;
                $subData['service_id'] = $value->service_id;
                $subData['service_name'] = $value->service_name;
                $subData['variant_id'] = $value->variant_id;
                $subData['price'] = $value->price;
                $subData['status'] = $status;
                $subData['store_emp_id'] = $value->store_emp_id;
                $subData['appo_date'] = $value->appo_date;
                $subData['appo_time'] = $start_time;
                $subData['app_end_time'] = $endTime;
                $appData = new AppointmentData();
                $appData->fill($subData);
                $appData->save();
            }
        }
        

    }

    /**same sameBookingChecking */
    public function sameBookingChecking($data,$store_id){        
        $store = $store_id;        
        $appoData = [];
        foreach($data as $value) {                
            $appoData['category'][] = $value->category_id;        
            $appoData['subcategory'][] = $value->subcategory_id;        
            $appoData['store'][] = $store;        
            $appoData['date'][] = $value->appo_date;        
            $appoData['employee'][] = $value->store_emp_id;        
            $appoData['time'][] = $value->appo_time;        
            $appoData['price'][] = $value->price;        
            $appoData['variant'][] = $value->variant_id;        
            $appoData['service'][] = $value->service_id;        
            $appoData['service_data'][] = $value->service_name;        
        }
        return $data = \BaseFunction::sameBookingCheckingApi($appoData);  

    }

    /**
     * check booking
     */
    public function checkBooking($data,$store_id)
    {
        $store = $store_id;        
        $appoData = [];
        foreach($data as $value) {                
            $appoData['category'][] = $value->category_id;        
            $appoData['subcategory'][] = $value->subcategory_id;        
            $appoData['store'][] = $store;        
            $appoData['date'][] = $value->appo_date;        
            $appoData['employee'][] = $value->store_emp_id;        
            $appoData['time'][] = $value->appo_time;        
            $appoData['price'][] = $value->price;        
            $appoData['variant'][] = $value->variant_id;        
            $appoData['service'][] = $value->service_id;        
            $appoData['service_data'][] = $value->service_name;        
        }
        
        // dd($appoData);
        return $data = \BaseFunction::checkBooking($appoData);  
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
           $orderConformData = \BaseFunction::orderConformData($appointment['id']);
          
		   return response()->json(['ResponseCode' => 1, 'ResponseText' => __('Rescheduled Successfully'), 'ResponseData' => $orderConformData], 200);
        } else {
            return response()->json(['ResponseCode' => 0, 'ResponseText' => __('Something went wrong'), 'ResponseData' => null], 400);
        }
    }

}
