<?php

namespace App\Http\Controllers\Api\ServiceProvider\FeedBacks;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StoreRatingReview;
use App\Models\StoreProfile;
use App\Models\User;
use App\Models\ApiSession;
use Validator;
use URL;
use Mail;
use File;
use Exception;
use Carbon\Carbon;
use DB;

class FeedBackController extends Controller
{
    public function storeRating(Request $request)
    {
        try {
            $data = request()->all();   
                
            $userId = $data['user']['user_id'];
           
			if (empty($data['store_id'])) {
				$storeId = StoreProfile::where('user_id', $userId)->value('id');
			}else{
				 $storeId = $data['store_id'];
			}
            $storeDetail = StoreProfile::where('user_id',$userId)->where('id',$storeId)->first();            
            if (empty($storeDetail)) {
                return response()->json(['ResponseCode' => 0, 'ResponseText' => 'No store details Found.', 'ResponseData' => NULL], 200);
            }
			
             $storeRating = StoreRatingReview:: where('store_id',$storeId);
            //type wise get avarage
            $totalAvgRating   =  $storeRating
                                ->select(DB::raw('ROUND(AVG(service_rate) ,2) AS service_rate, ROUND(AVG(ambiente),2) AS ambiente, 
                                ROUND(AVG(preie_leistungs_rate),2) AS preie_leistungs_rate, ROUND(AVG(wartezeit),2) AS wartezeit, 
                                ROUND(AVG(atmosphare),2) AS atmosphare'))
                                ->get();                   
           foreach ($totalAvgRating as $value) {
                $value['service_rate'] = number_format($value['service_rate'],1);
                $value['ambiente']     = number_format($value['ambiente'],1);
                $value['preie_leistungs_rate'] = number_format($value['preie_leistungs_rate'],1);
                $value['wartezeit'] = number_format($value['wartezeit'],1);
                $value['atmosphare'] = number_format($value['atmosphare'],1);
            }
            
            //total feed back count
            $totalFeedBack    =  $storeRating->count();
			 $userRatingReview = StoreRatingReview::leftjoin('store_emps', 'store_emps.id', '=', 'store_rating_reviews.emp_id')
                                    ->leftjoin('services', 'services.id', '=','store_rating_reviews.service_id')
                                    ->leftjoin('users','users.id','=','store_rating_reviews.user_id')
                                    ->with('userDetails'); 
            //type weise avarage
            $userRatingReview = $userRatingReview->where('store_rating_reviews.store_id',$storeId)
                                ->select('store_rating_reviews.id','store_rating_reviews.category_id','store_rating_reviews.user_id','store_rating_reviews.store_id',
                                'store_rating_reviews.service_rate','store_rating_reviews.ambiente','store_rating_reviews.preie_leistungs_rate','store_rating_reviews.wartezeit','store_rating_reviews.atmosphare',
                                'store_rating_reviews.write_comment','store_rating_reviews.total_avg_rating','store_rating_reviews.service_id','store_rating_reviews.emp_id','store_rating_reviews.store_replay',
                                'store_rating_reviews.created_at','store_rating_reviews.updated_at','store_emps.emp_name','services.service_name');
			
			if(!empty($data['rate_sorting']) && $data['rate_sorting'] == 'newest') {
				$userRatingReview = $userRatingReview->orderBy('store_rating_reviews.created_at', 'desc');
			}elseif(!empty($data['rate_sorting']) && $data['rate_sorting'] == 'worst_rated') {
				$userRatingReview = $userRatingReview->orderBy('store_rating_reviews.total_avg_rating', 'asc');
			}elseif(!empty($data['rate_sorting']) && $data['rate_sorting'] == 'best_rated') {
				$userRatingReview = $userRatingReview->orderBy('store_rating_reviews.total_avg_rating', 'desc');
			}else{
				$userRatingReview = $userRatingReview->orderBy('store_rating_reviews.created_at', 'desc');
			}
			
			$userRatingReview = $userRatingReview->get();

             // all avarage
            foreach ($userRatingReview as $value) { 
                $value['service_rate'] = number_format($value['service_rate'],1);
                $value['ambiente']     = number_format($value['ambiente'],1);
                $value['preie_leistungs_rate'] = number_format($value['preie_leistungs_rate'],1);
                $value['wartezeit'] = number_format($value['wartezeit'],1);
                $value['atmosphare'] = number_format($value['atmosphare'],1);
                $value['total_avg_rating'] = number_format($value['total_avg_rating'],1);
                $value['user_name'] = @$value['userDetails']['first_name'].' '.@$value['userDetails']['last_name'];
                $value['category_name'] = @$value['categoryDetails']['name'];
                $value['user_image_path'] = @$value['userDetails']['user_image_path'];
                $value['dayAgo'] = \Carbon\Carbon::parse($value->created_at)->diffForHumans();                                 
                unset($value->userDetails, $value->categoryDetails);
            }
			 if (isset($data['sorting']) && $data['sorting'] != '') {                
                if ($data['sorting'] == 'desc') {
                    $userRatingReview = collect($userRatingReview->sortByDesc('total_avg_rating')->values()->all());    
                }else{                    
                    $userRatingReview = collect($userRatingReview->sortBy('total_avg_rating')->values()->all());
                }
            }                    
            // all avarage
            $rating_sum = 0;
                 
            foreach ($totalAvgRating->toArray() as  $value) {                
                $rating_sum += $value['service_rate'] + $value['ambiente'] + $value['preie_leistungs_rate'] + $value['wartezeit'] + $value['atmosphare'];                                             
                $rating_sum = number_format($rating_sum == 0 ? 0 : ($rating_sum / 5),2);                
            }
            
            $data = [
                'allOverAvg' => number_format($rating_sum,1),
                'totalFeedBack'=>$totalFeedBack,
                'totalAvgRating' => $totalAvgRating,
                'customerReview' =>$userRatingReview
            ];
            return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Successful', 'ResponseData' => $data], 200);
        } catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
    }
	
	
	 public function getReviewDetails(Request $request)
    {
		try{
			$id = $request['id'];

			$data = StoreRatingReview::where('id', $id)->first();

			if (file_exists(storage_path('app/public/user/' . @$data->userDetails->profile_pic)) &&
				@$data->userDetails->profile_pic != '') {
				$data->image = URL::to('storage/app/public/user/' . @$data->userDetails->profile_pic);
			} else {
				$data->image = 'https://via.placeholder.com/1080x1080/00000/FABA5F?text=' . strtoupper(substr(@$data->userDetails->first_name, 0, 1)) . ' ' . strtoupper(substr(@$data->userDetails->last_name, 0, 1));
			}

			$data->name = @$data->userDetails->first_name . ' ' . @$data->userDetails->last_name;
			$data->employee = @$data->empDetails->emp_name;
			$data->category = @$data->categoryDetails->name;
			$data->service_name = @$data->serviceDetails->service_name;
			$data->time = \Carbon\Carbon::parse($data->updated_at)->diffForHumans();
			unset($data->empDetails);
			unset($data->serviceDetails);
			unset($data->userDetails);
			unset($data->categoryDetails);


			return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Successful', 'ResponseData' => $data], 200);
		} catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
    }
	
	
	 public function updatetReviewReply(Request $request){
		try{
			$data = request()->all();
			$userId = $data['user']['user_id'];
           
			if (empty($data['store_id'])) {
				$storeId = StoreProfile::where('user_id', $userId)->value('id');
			}else{
				 $storeId = $data['store_id'];
			}
            $storeDetail = StoreProfile::where('user_id',$userId)->where('id',$storeId)->first();            
            if (empty($storeDetail)) {
                return response()->json(['ResponseCode' => 0, 'ResponseText' => 'No store details Found.', 'ResponseData' => NULL], 200);
            }
			
			$id = $request['id'];
			
			$reviewData = StoreRatingReview::find($data['id']);
			if(!empty($reviewData->store_replay)){
				 $vanue = StoreRatingReview::where('id', $id)->update(['store_replay' => $data['store_reply']]);
			}else{
				 $vanue = StoreRatingReview::where('id', $id)->update(['store_replay' => $data['store_reply']]);
				 $store_name = StoreProfile::where('id', $reviewData['store_id'])->value('store_name');
				 \BaseFunction::notification('Antwort auf dein Feedback!','Deine Bewertung wurde von '.$store_name.' beantwortet.','rating',$id,$reviewData['store_id'],$reviewData['user_id'],'','users');
				//Push Notification for cancellations
				$PUSer = User::find($reviewData['user_id']);
				if(!empty($PUSer->device_token) && !empty($PUSer->allow_notifications) && $PUSer->allow_notifications == 1){
					$sessioncount = ApiSession::where('user_id', $PUSer->id)->count();
					if($sessioncount > 0){
						$registerarion_ids = array($PUSer->device_token);
						
						$Pdeatail = $store_name." hat gerade auf deine Bewertung geantwortet. Antwort anzeigen";
						\BaseFunction::sendPushNotification($registerarion_ids, 'Neue Antwort !', $Pdeatail, NULL, $reviewData['store_id'], $id);
					}
				}
				//PUSH Notification code ends 
			}

			if($vanue){
				return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Successful', 'ResponseData' => NULL], 200);
			}else{
				return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
			}
			
		} catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
    }
}
