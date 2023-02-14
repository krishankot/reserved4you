<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\StoreProfile;
use App\Models\AppointmentData;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Models\ApiSession;

class PageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function imprint()
    {
        return view('Front.imprint');
    }

	public function datenschutz()
    {
        return view('Front.datenschutz');
    }
	
	public function terms_and_conditions()
    {
        return view('Front.conditions');
    }
	
	public function testnotifications(){
		$this->send_notification_android();
	}
	
	function send_notification_android($image = null) {
		$title = 'Notification for reserved4you';
		$detail = 'Willkommen zu den Allgemeinen Geschäftsbedingungen von reserved4you! TLTR: Im Folgenden sind die Nutzungsbedingungen aufgeführt';
		$registatoin_ids  = ApiSession::where('user_id', 2)->pluck('device_token')->toArray();
		//$registatoin_ids = array("cbYlhb3o0Ul3iKQjCQQbjD:APA91bHp9lUwRdqxX34KQJhsMACaLQwE-nIBzemxQb7zt2lWr-s-rTSKVovTcFcYFQ-jBRngQhZXkmy8KulhhaTOci7rUA9PQlz_AYUQLgwAjiG8_pQScsxgQyZJnaaHXZmYhiZvK1JB");
		$image  = "https://www.reserved4you.de/storage/app/public/Frontassets/images/business-banner.jpg";
		$icon  = asset('storage/app/public/notifications/Cancellation.png');
		//$api_key  = "AAAAhci9fPE:APA91bEJSOxNzytw4GNlqREiTflYfNNuIfU7VLwNF58ctvx6rlzPvvFJAOdBirQJFrRbTetaru0d_MFns1aru3TMmdLhXCRQngm8oot63DPe5m5k00CciNPQkjfhSR0WW8jw7SzlAETr";
		$api_key  = "AAAAhci9fPE:APA91bEJSOxNzytw4GNlqREiTflYfNNuIfU7VLwNF58ctvx6rlzPvvFJAOdBirQJFrRbTetaru0d_MFns1aru3TMmdLhXCRQngm8oot63DPe5m5k00CciNPQkjfhSR0WW8jw7SzlAETr";
		$url    = 'https://fcm.googleapis.com/fcm/send';
		
		$data = array
		(
			'title' 	=> $title,
			'body' 		=> $detail,
			'message' 	=> $detail,
			'storeid' 	=> 1,
			'appointment_id' 	=> 1,
			'sound' 	=> 'default',
			'image' 	=> $image,
			'icon' 		=> $image,
			'activity' 	=> 'MainActivity'
		); 
		foreach($registatoin_ids as $registatoin_id){
			$registatoin_data =array();
			$registatoin_data[] = $registatoin_id;
		$notification= array
		(
			'title' 		=> $title,
			'body' 			=> $detail,
			'click_action' 	=> '.MainActivity',
			'sound' 		=> 'default',
			'image' 		=> $image,
			'icon' 			=> $image,
			'badge' 		=> '1'
		); 
   
		$fields = array(
			'registration_ids' 	=> $registatoin_data,
			'priority'          => "high",
            'data'         		=> $data,
			'notification'      => $data,
			'click_action' 		=> '.MainActivity',
            'sound' 			=> 'default', 
            'badge' 			=> '1'
		); 
		
		$headers = array(
			'Authorization: key = ' . $api_key,
			'Content-Type: application/json'
		);
		
		// Open connection
		$ch = curl_init();
		// Set the url, number of POST vars, POST data
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		// Disabling SSL Certificate support temporarly
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
		
		// Execute post
		$result = curl_exec($ch);
		if($result === FALSE) {
			die('Curl failed: ' . curl_error($ch));
		}
		// Close connection
		curl_close($ch);
		echo "<p>".$registatoin_id."</p>";
		echo "<pre>"; print_r($result);
		}
		//return $result;
		
		die;
		//$registatoin_ids = array("41E83BCE4940759D79EE001FA1CA21825BDF9003A58ECE468CBC7FBA425BAEA7", "c9yfICVwRL-DCs9teYHRWC:APA91bEHpKu1OkPMILsY2aGtq4SVvgVyMEqWBxIwQgJFaupJBV-z2_aYD0926qApjIyFCWjljZUBkyaHIpp4crowamOEqEWq0rVK2hD8e7sWfwE2JQ0_AoDfTcOSU2w7tx5z8CIzMq0D",'dpZkfP6QQoSBcMVQvBnjdR:APA91bHnMYOGeugWoknFWdZ-w0RubyRu1j-Hq9syE9m-yNymszKB3zFiXdYh5L1kd7SPw7_M-b_XonWFgxuCkoP2jDh6oIBEni_K-rvm-Xlp1HkSfL9NiI6P726jSLHPTmGf_Uet3f0u');
		 $appointment_data = AppointmentData::inRandomOrder()->take(1)->get();
			
		$registatoin_ids = array("fJlj35x7SlesKOHnUyB5JQ:APA91bGhCZ3JmAFJMgCH-Z4otFkcxIf5fVl5CmSvtLjqnrCkULuP4sh0CeXWZrIfKOYT0wvAA544nnB7lYx90cB_2yxj0ZQVQCeakbK0OwY2exsCIG37zOYiCnHdcNnGetnc1HqWyRL2");
		$image  = "https://www.reserved4you.de/storage/app/public/Frontassets/images/business-banner.jpg";
		//$icon  = "https://www.reserved4you.de/storage/app/public/Frontassets/images/service-heading-icon.svg";
		$icon  = asset('storage/app/public/notifications/Cancellation.png');
		//$api_key  = "AAAAz_3Yhw8:APA91bG0Fyitm1oAYoDfPQT8ooEZl50B4avXZxYzP29nJ8RgbrMRebiDigyO4UxipWNW7vEbMaDZBq6GVyVZUQJVS44cYqmJNhQgGKNLLH5Xgf9lS0vqsBzctyijl3foNZj6Fd0C4nJk";
		$api_key  = "AAAAVE5r2FQ:APA91bHx9j0ShRBUtcmQksk1mXitT92oSA57dk0aQiQcHgAA-Jm-ynwSlSjlEKXOlH287sKZa9ijso37rkPh_zT3IDAG0gN_myCPQAJSHuUzKjgwrTYPnf0euaHMg--AYsep2V9lJN6x";
		$url    = 'https://fcm.googleapis.com/fcm/send';
		foreach($appointment_data as $val){
			$AppointmentAr  = Appointment::find($val['appointment_id']);
			//Push Notification for cancellations
			$PUSer = User::find($AppointmentAr['user_id']);
			$pdate  = \Carbon\Carbon::parse($val['appo_date'])->format('d.m.Y');
			$ptime  = \Carbon\Carbon::parse($val['appo_time'])->format('H:i');
			$store_name = StoreProfile::where('id', $AppointmentAr['store_id'])->value('store_name');
			$Pdeatail = "Nicht vergessen, dass dein gebuchter Termin bei ". $store_name ." bald ansteht. Am ".$pdate." um ". $ptime.".";
			\BaseFunction::sendPushNotification($registatoin_ids, 'Dein Termin ist bald !', $Pdeatail);
		}
		die;
		$data = array
		(
			'title' 	=> $title,
			'body' 	=> $detail,
			'message' 	=> $detail,
			'sound' => 'default',
			'image' => $image,
			'icon' => $icon,
			 'activity' => 'MainActivity'
		); 
		
		$notification= array
		(
			'title' 	=> $title,
			'body' 	=> $detail,
			 'click_action' => '.MainActivity',
			'sound' => 'default',
			'image' => $image,
			'icon' => $icon,
			 'badge' => '1'
		); 


		/*$fields = array(
			'registration_ids' => $registatoin_ids,
			 'priority'             => "high",
           		 'data'         => $data,
			'notification' => $notification
		); */
		$data = array
    (
                        'title' 	=> $title,
			'body' 	=> $detail,
			'message' 	=> $detail,
			'sound' => 'default',
			'image' => $image,
			'icon' => $icon,
                        'activity' => 'MainActivity'
    );
   
   $fields = array(
			'registration_ids' => $registatoin_ids,
			 'priority'             => "high",
           		 'notification'         => $data,
				 'data'         => $data,
			 'click_action' => '.MainActivity',
                         'sound' => 'default', 
                         'badge' => '1'
		); 
		
		$headers = array(
			'Authorization: key = ' . $api_key,
			'Content-Type: application/json'
		);
		
		// Open connection
		$ch = curl_init();
		// Set the url, number of POST vars, POST data
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		// Disabling SSL Certificate support temporarly
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
		
		// Execute post
		$result = curl_exec($ch);
		if($result === FALSE) {
			die('Curl failed: ' . curl_error($ch));
		}
		// Close connection
		curl_close($ch);
		
		echo "<pre>"; print_r($result); die;
	//	echo $result;
		return $result;
	}
}
