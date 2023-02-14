<?php

namespace App\Http\Controllers\Api\User\CustomerReview;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StoreRatingReview;
use App\Models\StoreProfile;
use App\Models\AppointmentData;
use App\Models\Notification;
use App\Models\ApiSession;
use App\Models\User;
use URL;
use File;
use Validator;
use DB;


class ReviewController extends Controller
{
     /**
     * get feedbach store
     */
    public function storeFeedBack(Request $request)
    {
        try {
            $data = request()->all();
            
            $storeId = $data['store_id'];
            $searchText = $data['search_text'];            

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
            //type weise avarage
            $userRatingReview = StoreRatingReview::leftjoin('store_emps', 'store_emps.id', '=', 'store_rating_reviews.emp_id')
                                    ->leftjoin('services', 'services.id', '=','store_rating_reviews.service_id')
                                    ->leftjoin('users','users.id','=','store_rating_reviews.user_id')
                                    ->with('userDetails');            

            if (!empty($searchText)) {                                                
                $userRatingReview = $userRatingReview
                    ->where(function ($query) use ($searchText) {                        
                    $query->where('services.service_name', 'LIKE', "%{$searchText}%")                        
                        ->orWhere('store_emps.emp_name', 'LIKE', "%{$searchText}%")
                        ->orWhere('users.first_name', 'LIKE', "%{$searchText}%")
                        ->orWhere('users.last_name', 'LIKE', "%{$searchText}%");
                });                
            } 
                                    
            $userRatingReview = $userRatingReview->where('store_rating_reviews.store_id',$storeId)
                                ->orderBy('store_rating_reviews.created_at','desc')
                                ->select('store_rating_reviews.id','store_rating_reviews.user_id','store_rating_reviews.store_id',
                                'store_rating_reviews.service_rate','store_rating_reviews.ambiente','store_rating_reviews.preie_leistungs_rate','store_rating_reviews.wartezeit','store_rating_reviews.atmosphare',
                                'store_rating_reviews.write_comment','store_rating_reviews.total_avg_rating','store_rating_reviews.service_id','store_rating_reviews.emp_id','store_rating_reviews.store_replay',
                                'store_rating_reviews.created_at','store_rating_reviews.updated_at','store_emps.emp_name','services.service_name')
                                ->get();
                                
            foreach ($userRatingReview as $value) { 
                $value['service_rate'] = number_format($value['service_rate'],1);
                $value['ambiente']     = number_format($value['ambiente'],1);
                $value['preie_leistungs_rate'] = number_format($value['preie_leistungs_rate'],1);
                $value['wartezeit'] = number_format($value['wartezeit'],1);
                $value['atmosphare'] = number_format($value['atmosphare'],1);
                $value['total_avg_rating'] = number_format($value['total_avg_rating'],1);
                $value['user_name'] = @$value['userDetails']['first_name'].' '.@$value['userDetails']['last_name'];
                $value['user_image_path'] = @$value['userDetails']['user_image_path'];
                $value['dayAgo'] = \Carbon\Carbon::parse($value->created_at)->diffForHumans();                                 
                unset($value->userDetails);
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
        }catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
    }

     /**
     * user store rrating
     */
    public function userRating(Request $request)
    {
        // $rule = [
        //     'service_id' =>'required',
        //     'emp_id' =>'required',
        //     'write_comment' =>'required',    
        // ];

        // $message = [
        //     'service_id.required' => 'Plese Select Service',
        //     'emp_id.required' => 'Please Select Employee',
        //     'write_comment.required' => 'Please Write Comment'            
        // ];

        // $validate = Validator::make($request->all(), $rule, $message);

        // if($validate->fails()){
        //     return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Validation Fails', 'ResponseData' => $validate->errors()->all()], 422);
        // }
        try {
            $data = request()->all();            
            //calculate for avg rating
			/* $myfile = fopen("reviewtt.txt", "a") or die("Unable to open file!");
			$txt = json_encode($data);
			fwrite($myfile, $txt);
			fclose($myfile); */
            $total = $data['service_rate'] + $data['ambiente'] + $data['preie_leistungs_rate'] + $data['wartezeit'] + $data['atmosphare'];
            $avgRating = $total / 5;
            //store rating 
            $userRating = new StoreRatingReview;
			if(!empty($data['id'])){
				 $userRating->appointment_id =  $data['id']; //AppointmentData::where('id', $data['id'])->value('appointment_id');
			}
            $userRating->user_id              = $data['user']['user_id'];            
            $userRating->store_id             = $data['store_id'];            
            $userRating->category_id          = $data['category_id'];            
            $userRating->subcategory_id       = $data['subcategory_id'];            
            $userRating->service_id           = $data['service_id'];            
            $userRating->emp_id               = $data['emp_id'];            
            $userRating->service_rate         = $data['service_rate'];            
            $userRating->ambiente             = $data['ambiente'];            
            $userRating->preie_leistungs_rate = $data['preie_leistungs_rate'];            
            $userRating->wartezeit            = $data['wartezeit'];            
            $userRating->atmosphare           = $data['atmosphare'];         
            $userRating->total_avg_rating     = $avgRating;
            $userRating->write_comment        = $data['write_comment'];            
            $userRating->save();
			if(!empty($data['id'])){
				Notification::where('appointment_id', $data['id'])->where('user_id', $data['user']['user_id'])->where('type', 'review_request')->delete();
			}
           
		   /** push notification */
			$store_user_id  = StoreProfile::where('id', $data['store_id'])->value('user_id');
			$PUSer = User::find($store_user_id);
			if(!empty($PUSer->device_token)){
				$sessioncount = ApiSession::where('user_id', $PUSer->id)->count();
				if($sessioncount > 0){
					$registerarion_ids = ApiSession::where('user_id', $PUSer->id)->pluck('device_token')->toArray();    //array($PUSer->device_token);
					\BaseFunction::sendPushNotificationServiceProvider($registerarion_ids, 'Neue Bewertung !', 'Glückwunsch, Ihr Salon hat eine neue Bewertung erhalten. Jetzt ansehen!', NULL, $data['store_id'], $userRating->id, 4);
				}
			}
            \BaseFunction::notification('Neue Bewertung !',' Glückwunsch, Ihr Salon hat eine neue Bewertung erhalten. Jetzt ansehen!','rating','',$data['store_id'],$data['user']['user_id'],'');

            return response()->json(['ResponseCode' => 1, 'ReponseText' => 'Rating submit successfully.','ResponseData'=> $userRating],200);
        } catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
    }

    //Feedback screen get store details
    public function getDetailsStore(Request $request)
    {
        try {
            $data = request()->all();            
            $getStoreDetails = StoreProfile::with(['serviceDetails'=>function($query){
                $query->select('id','store_id','service_name');
            },'storeExpert'=>function($query){

                $query->select('id','store_id','emp_name');
            }])->where('id',$data['store_id'])->select('id','store_name','store_profile','store_banner')->first();
            if (empty($getStoreDetails)) {
                return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Wrong store id', 'ResponseData' => null], 400);
            }
            return response()->json(['ResponseCode' => 1, 'ReponseText' => 'Get details successfully.','ResponseData'=> $getStoreDetails],200);
        } catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
    }

    /**
     * sort by review
     */

    public function sortByReview(Request $request)
    {
        try {
            $data = request()->all();
            $sortBy = $data['sort_by'];
            $storeId = $data['store_id'];

            //type weise avarage
            $userRatingReview = StoreRatingReview::leftjoin('store_emps', 'store_emps.id', '=', 'store_rating_reviews.emp_id')
                                    ->leftjoin('services', 'services.id', '=','store_rating_reviews.service_id')
                                    ->with('userDetails')
                                    ->where('store_rating_reviews.store_id',$storeId);            
                                    
            if ($sortBy == 'newest') {                                                
                $userRatingReview = $userRatingReview->orderBy('store_rating_reviews.created_at','desc');                
            } 
            if ($sortBy == 'best_rating') {
                $userRatingReview = $userRatingReview->orderby('store_rating_reviews.total_avg_rating','desc');              
            }      
            if ($sortBy == 'worst_rating') {
                $userRatingReview = $userRatingReview->orderby('store_rating_reviews.total_avg_rating','asc');                
            }                      
            $userRatingReview = $userRatingReview
                                ->select('store_rating_reviews.id','store_rating_reviews.user_id','store_rating_reviews.store_id',
                                'store_rating_reviews.service_rate','store_rating_reviews.ambiente','store_rating_reviews.preie_leistungs_rate','store_rating_reviews.wartezeit','store_rating_reviews.atmosphare',
                                'store_rating_reviews.write_comment','store_rating_reviews.total_avg_rating','store_rating_reviews.service_id','store_rating_reviews.emp_id','store_rating_reviews.store_replay',
                                'store_rating_reviews.created_at','store_rating_reviews.updated_at','store_emps.emp_name','services.service_name')
                                ->get();
                                
            foreach ($userRatingReview as $value) { 
                $value['service_rate'] = number_format($value['service_rate'],1);
                $value['ambiente']     = number_format($value['ambiente'],1);
                $value['preie_leistungs_rate'] = number_format($value['preie_leistungs_rate'],1);
                $value['wartezeit'] = number_format($value['wartezeit'],1);
                $value['atmosphare'] = number_format($value['atmosphare'],1);
                $value['total_avg_rating'] = number_format($value['total_avg_rating'],1);
                $value['user_name'] = @$value['userDetails']['first_name'].' '.@$value['userDetails']['last_name'];
                $value['user_image_path'] = @$value['userDetails']['user_image_path'];
                $value['dayAgo'] = \Carbon\Carbon::parse($value->updated_at)->diffForHumans();;                                 
                unset($value->userDetails);
            }
            if (isset($data['sorting']) && $data['sorting'] != '') {                
                if ($data['sorting'] == 'asc') {
                    $userRatingReview = collect($userRatingReview->sortByDesc('total_avg_rating')->values()->all());    
                }else{                    
                    $userRatingReview = collect($userRatingReview->sortBy('total_avg_rating')->values()->all());
                }
            }  
            if (count($userRatingReview) > 0) {                
                return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Successful', 'ResponseData' => $userRatingReview], 200);
            }
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'no data found', 'ResponseData' => $userRatingReview], 200);
        } catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
    }

    //filter by review
    public function filterByReview(Request $request)
    {
        try {
            $data = request()->all();            
            $storeId = $data['store_id'];

            $filterReview=StoreRatingReview::leftjoin('store_emps', 'store_emps.id', '=', 'store_rating_reviews.emp_id')
                                    ->leftjoin('services', 'services.id', '=','store_rating_reviews.service_id')
                                    ->with('userDetails')
                                    ->where('store_rating_reviews.store_id',$storeId);            
            
            //category wise
            if (!empty($data['category_id'])) {                                                
                $filterReview = $filterReview->where('store_rating_reviews.category_id',$data['category_id']);                
            } 
            //service wise
            if (!empty($data['service_id'])) {
                $filterReview = $filterReview->where('store_rating_reviews.service_id',$data['service_id']);                
            }      
            if (!empty($data['rating'])) {
                $filterReview = $filterReview->where('store_rating_reviews.total_avg_rating','<=',$data['rating'])->orderBy('store_rating_reviews.total_avg_rating','desc');
            }
            
            $filterReview = $filterReview
                                ->select('store_rating_reviews.id','store_rating_reviews.user_id','store_rating_reviews.store_id',
                                'store_rating_reviews.service_rate','store_rating_reviews.ambiente','store_rating_reviews.preie_leistungs_rate','store_rating_reviews.wartezeit','store_rating_reviews.atmosphare',
                                'store_rating_reviews.write_comment','store_rating_reviews.total_avg_rating','store_rating_reviews.service_id','store_rating_reviews.emp_id','store_rating_reviews.store_replay',
                                'store_rating_reviews.created_at','store_rating_reviews.updated_at','store_emps.emp_name','services.service_name')
                                ->get();            
            foreach ($filterReview as $value) { 
                $value['service_rate'] = number_format($value['service_rate'],1);
                $value['ambiente']     = number_format($value['ambiente'],1);
                $value['preie_leistungs_rate'] = number_format($value['preie_leistungs_rate'],1);
                $value['wartezeit'] = number_format($value['wartezeit'],1);
                $value['atmosphare'] = number_format($value['atmosphare'],1);
                $value['total_avg_rating'] = number_format($value['total_avg_rating'],1);
                $value['user_name'] = @$value['userDetails']['first_name'].' '.@$value['userDetails']['last_name'];
                $value['user_image_path'] = @$value['userDetails']['user_image_path'];
                $value['dayAgo'] = \Carbon\Carbon::parse($value->updated_at)->diffForHumans();                                 
                unset($value->userDetails);
            }
            if (isset($data['sorting']) && $data['sorting'] != '') {                
                if ($data['sorting'] == 'desc') {
                    $filterReview = collect($filterReview->sortByDesc('total_avg_rating')->values()->all());    
                }else{                    
                    $filterReview = collect($filterReview->sortBy('total_avg_rating')->values()->all());
                }
            }  
            if (count($filterReview) > 0) {                
                return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Successful', 'ResponseData' => $filterReview], 200);
            }
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'no data found', 'ResponseData' => null], 200);
        } catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
    }
    /**
     * get user reviews
     */
    public function userReviews(Request $request)
    {
        try {            
            $userId = $request['user']['user_id'];
            $getUserReview = StoreRatingReview::leftjoin('store_emps', 'store_emps.id', '=', 'store_rating_reviews.emp_id')
                            ->leftjoin('services', 'services.id', '=','store_rating_reviews.service_id')->with('userDetails')
                            ->where('user_id',$userId)
                            ->select('store_rating_reviews.id','store_rating_reviews.user_id','store_rating_reviews.store_id',
                                'store_rating_reviews.service_rate','store_rating_reviews.ambiente','store_rating_reviews.preie_leistungs_rate','store_rating_reviews.wartezeit','store_rating_reviews.atmosphare',
                                'store_rating_reviews.write_comment','store_rating_reviews.total_avg_rating','store_rating_reviews.service_id','store_rating_reviews.emp_id','store_rating_reviews.store_replay'
                                ,'store_rating_reviews.category_id','store_rating_reviews.subcategory_id','store_rating_reviews.created_at','store_rating_reviews.updated_at','store_emps.emp_name','services.service_name')
                            ->get();

            foreach ($getUserReview as $value) { 
                $value['service_rate'] = number_format($value['service_rate'],1);
                $value['ambiente']     = number_format($value['ambiente'],1);
                $value['preie_leistungs_rate'] = number_format($value['preie_leistungs_rate'],1);
                $value['wartezeit'] = number_format($value['wartezeit'],1);
                $value['atmosphare'] = number_format($value['atmosphare'],1);
                $value['total_avg_rating'] = number_format($value['total_avg_rating'],1);
                $value['category_name'] = @$value['categoryDetails']['name'];
                $value['subcategory_name'] = @$value['subCategoryDetails']['name'];
                $value['user_name'] = @$value['userDetails']['first_name'].' '.@$value['userDetails']['last_name'];
                $value['user_image_path'] = @$value['userDetails']['user_image_path'];
                $value['store_name']= @$value['storeDetaials']['store_name'];
                $value['store_address']= @$value['storeDetaials']['store_address'];
                $value['store_image']= @$value['storeDetaials']['store_profile_image_path'];
                $value['dayAgo'] = \Carbon\Carbon::parse($value->updated_at)->diffForHumans();                                 
                unset($value->userDetails,$value->categoryDetails,$value->subCategoryDetails,$value->storeDetaials);
            }
            if (count($getUserReview) > 0) {                
                return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Successful', 'ResponseData' => $getUserReview], 200);
            }
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'no data found', 'ResponseData' => null], 200);
        } catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
    }
}
