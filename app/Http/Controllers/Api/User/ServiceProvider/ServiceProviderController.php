<?php

namespace App\Http\Controllers\Api\User\ServiceProvider;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\StoreCategory;
use App\Models\StoreGallery;
use App\Models\StoreProfile;
use App\Models\StoreTiming;
use App\Models\StoreRatingReview;
use App\Models\Service;
use App\Models\StoreEmp;
use App\Models\Features;
use App\Models\Store\Advantages;
use App\Models\Store\Parking;
use App\Models\Store\PublicTransportation;
use App\Models\TemporarySelectService;
use Illuminate\Http\Request;
use URL;
use DB;


class ServiceProviderController extends Controller
{
    public function index(Request $request){                     
        $user = $request['user'];          
        $user_id = $user == null ? null:$user['user_id'];        
        $searchText = $request['search_text'];                
        $pincode = $request['pincode'];
        $category_id = $request['category_id'];
        $subcategory_id = $request['subcategory_id'];
        $date = $request['date'];
        $booking = $request['booking_system'];
        $discount = $request['discount'];
                                              
        $day = \Carbon\Carbon::parse($date)->format('l');        
        $data = StoreProfile::leftjoin('store_categories', 'store_categories.store_id', '=', 'store_profiles.id')
                         ->leftjoin('services', 'services.store_id', '=', 'store_profiles.id')
                        ->with(['storeCategory','storeGallery','storeCategory.CategoryData','storeFavourite' =>function($query) use($user_id){
                            $query->where('user_id',$user_id);
                        },'storeRated']);      
            if (!empty($category_id)) {                                
                $data = $data->where('store_categories.category_id', $category_id);                
            }
            if (!empty($subcategory_id)) {
                $data = $data->where('services.subcategory_id',$subcategory_id);
            }
            // dd($data->orderBy('store_profiles.id','DESC')
            // ->groupBy('store_profiles.id')->get()->toArray());
            if (!empty($date)) {
                $data = $data->leftjoin('store_timings', 'store_timings.store_id', '=', 'store_profiles.id');
            }
            if (!empty($date)) {
                $data = $data->where('store_timings.day', $day)->where('store_timings.is_off', null);
            }
            if (!empty($pincode)) {
                $data = $data->where('store_profiles.zipcode', 'LIKE', "%{$pincode}%");
            }  
            if (!empty($booking)) {                                
                $data = $data->where('store_profiles.store_active_plan', 'business');                
            }
    
            if (!empty($discount)) {
                $data = $data->where('services.discount_type', '!=', '');                
            } 
            if (!empty($searchText)) {                
              $data = $data->where(function($query) use( $searchText){
							$query->where('store_profiles.store_name', 'LIKE', '%' . $searchText . '%')->orwhere('services.service_name', 'LIKE', '%' . $searchText . '%');
			});				
            }
            // $searchCategory = Category::where('name', 'LIKE', "%{$searchText}%")->pluck('id')->all();                                                   
            
            // if (!empty($searchText)) {                                                
            //     $data = $data
            //         ->where(function ($query) use ($searchText, $searchCategory) {
            //         $query->where('services.service_name', 'LIKE', "%{$searchText}%")
            //             ->orWhereIn('services.subcategory_id',$searchCategory)
            //             ->orWhere('store_profiles.store_name', 'LIKE', "%{$searchText}%")
            //             ->orWhereIn('store_categories.category_id', $searchCategory);
            //     });                
            // dd($data->get()->toArray());    
            // }                  
            $data = $data->where('store_profiles.store_status','active')    
                    // ->where('store_profiles.category_id',$request->main_category)                    
                    ->select('store_profiles.id','store_profiles.user_id','store_profiles.store_name','store_profiles.store_description','store_profiles.store_profile',
                    'store_profiles.store_banner','store_profiles.store_status','store_profiles.store_address','store_profiles.category_id','store_profiles.store_active_plan','store_profiles.is_value','store_profiles.latitude','store_profiles.longitude')
                    ->orderBy('store_profiles.id','DESC')
                    ->groupBy('store_profiles.id')                       
                    // ->distinct()                 
                   ->get();               
            

        //store list
        $storeId = [];
        foreach ($data as $row){                
            $storeId[] = $row['id'];
            foreach ($row->storeCategory as $category) {                    
                $category['name'] = $category['CategoryData']['name'];
                unset($category->CategoryData);
            }             
            //favourite or note            
            $row['favourite'] =!empty($row->storeFavourite) == true ? true : false;                        
            $row['category_name'] = 'Kosmetik';
            //store rating  
            $row['avg_rating'] = \BaseFunction::finalRating($row->id);
            $row['total_feedback'] = \BaseFunction::finalCount($row->id);
            $row['discountFlage']=\BaseFunction::checkDiscountForStore($row->id);            
            $row['discount']=number_format(\BaseFunction::findStoreDiscount($row->id),0);   
            // $row['category_id'] = $row['category_id'] == 'Cosmetics' ? 'Kosmetik' :$row['Cosmetics'];         
            $row['category_id'] = 'Kosmetik'; 
            // $sum = 0;         
            // foreach ($row->storeRated as $rating) {                      
            //     $sum += $rating['total_avg_rating'];                                            
            // }     
            // $row['avg_rating'] = number_format($sum == 0 ? 0 : ($sum / $row->storeRated->count()),2);  
            // $row['total_feedback']  =  $row->storeRated->count();
            unset($row->storeFavourite,$row->storeRated);
        }
		if (isset($discount)) {
            $finalData = [];
            $finalData1 = [];
            foreach ($data as $row) {
                if ($row['discount'] > 0 && $discount == 'yes') {
                    $finalData[] = $row;
                } else {
                    $finalData1[] = $row;
                }
            }
            if ($discount == 'yes') {
				$data = $finalData;
            } else {

                $data = $finalData1;
            }

        }
        if (isset($request['sorting']) && $request['sorting'] != '') {
            if ($request['sorting'] == 'desc') {                    
                $data = collect($data->sortByDesc('id')->values()->all());    
            }else{                    
                $data = collect($data->sortBy('id')->values()->all());
            }
        }
        // }else{
        //     $data = collect($data->sortByDesc('avg_rating')->values()->all());
        // }        
        //all services
        // $serviceList = Service::where('category_id',$category_id)
        //                ->orWhere('service_name','like','%'.$searchText.'%')
        //                ->select('id','store_id','category_id','subcategory_id','service_name','image')
        //                ->get();
        
        // $serviceList = Service::where('category_id',$category_id);

        // if (!empty($searchText)) {
        //     $serviceList = $serviceList->where('service_name','like','%'.$searchText.'%');
        // }
        // if (!empty($date) || !empty($pincode)) {
        //     $serviceList = $serviceList->whereIn('store_id',$storeId);
        // }

        // $serviceList = $serviceList->select('id','store_id','category_id','subcategory_id','service_name','image')
        //                 ->orderBy('id','DESC')
        //                 ->take(10)
        //                 ->get();

        //get store for new,recommenden and best rated
        
        $getStore = StoreProfile::leftjoin('store_categories', 'store_categories.store_id', '=', 'store_profiles.id')                    
                    ->where('store_profiles.category_id',$request->main_category)
                    // ->where('store_categories.category_id',$request->category_id)
                    ->select('store_categories.category_id as cat_id','store_profiles.id','store_profiles.store_name'
                    ,'store_profiles.store_profile','store_profiles.store_banner','store_profiles.store_status'
                    ,'store_profiles.category_id'); 

        // if (!empty($request->category_id)) {            
        //     $getStore = $getStore->where('store_categories.category_id',$request->category_id);
        // }
        
        $homeType = null;
        if ($request['home_type'] == 'recommended') {                        
            $homeType = $getStore
                                ->groupBy('store_profiles.id')
                                ->where('store_profiles.store_status','active')
                                ->where('store_profiles.is_recommended', 'yes')  
                                ->where('store_profiles.store_active_plan', 'business') 
                                ->distinct()->inRandomOrder()                             
                                ->get();            
            foreach ($homeType as $value) {
                $value['avg_rating'] = \BaseFunction::finalRating($value->id);
                $value['avg_rating_count'] = \BaseFunction::finalCount($value->id);                
                // $sum = 0;    
                // foreach ($value->storeRated as $row) {                                          
                //     $value['avg_rating'] = number_format($row['total_avg_rating'],2);            
                // }                           
                // unset($value->storeRated,$value->userDetails,$value->storeOpeningHours);
            }
        }elseif ($request['home_type'] == 'new') {            
            $homeType = $getStore->orderBy('store_profiles.created_at','DESC')
                                ->groupBy('store_profiles.id')
                                ->where('store_profiles.store_status','active')    
                                ->where('store_profiles.is_recommended', 'yes')                         
                                ->where('store_profiles.store_active_plan', 'business')    
                                ->distinct()->inRandomOrder()
								->take(30)
                                ->get();
            foreach ($homeType as $value) {
                $value['avg_rating'] = \BaseFunction::finalRating($value->id);
                $value['avg_rating_count'] = \BaseFunction::finalCount($value->id);
                // $sum = 0;    
                // foreach ($value->storeRated as $row) {                                          
                //     $value['avg_rating'] = number_format($row['total_avg_rating'],2);            
                // }                           
                // unset($value->storeRated,$value->userDetails,$value->storeOpeningHours);
            }
        }elseif ($request['home_type'] == 'best_rating') {
            $homeType = $getStore->leftjoin('store_rating_reviews', 'store_rating_reviews.store_id', '=', 'store_profiles.id')
                        ->orderBy('store_rating_reviews.total_avg_rating', 'desc')
                        ->groupBy('store_profiles.id')
                        ->where('store_profiles.store_status','active')  
                        ->where('store_profiles.is_recommended', 'yes')                  
                        ->where('store_profiles.store_active_plan', 'business')    
                        ->distinct()->inRandomOrder()
                        ->get();
            foreach ($homeType as $k=>$value) {
                $value['avg_rating'] = \BaseFunction::finalRating($value->id);
                $value['avg_rating_count'] = \BaseFunction::finalCount($value->id);
				if(  $value['avg_rating'] < 4){
					unset($homeType[$k]);
				}
            }
            $homeType = collect($homeType->sortByDesc('avg_rating')->values()->all());            
        }        

        $dataList=[
            // 'service_list'    => $serviceList,            
            'top_rated_store' => $homeType,
            'storeList'       => $data
        ];  
        
        // if(count($dataList['top_rated_store']) == 0 && count($dataList['storeList']) == 0){
        //     return response()->json(['ResponseCode' => 0, 'ResponseText' => "No Record Found", 'ResponseData' => null], 200);
        // }
        return response()->json(['ResponseCode' => 1, 'ResponseText' => "Service Provider List get Successfully", 'ResponseData' => $dataList], 200);
        
    }

    

    public function serviceProviderView(Request $request)
    {
        try {
            
            $user = $request['user'];            
            $user_id = $user == null ? null :$user['user_id'];
            $searchText = $request['emp_name_search'];
            $storeDetails  = StoreProfile::with(['storeFavourite','storeGallery','serviceDetails' => function($q){                
                              $q->with('serviceVariant')->select('id','store_id','category_id','subcategory_id','service_name','price','start_time','end_time','start_date','end_date','discount_type'
                              ,'discount','image','is_popular')->orderBy('id','DESC')->groupBy('id');
                            },
                            'serviceDetails.SubCategoryData' => function($que){
                                $que->select('id','main_category','name','image')
                               ->where('status','active');
                            },'storeExpert' => function($query) use($searchText){
                                if (!empty($searchText)) {
                                    $query->where('emp_name','LIKE',"%{$searchText}%");
                                }  
                            },'storeExpert.EmpCategory','storeOpeningHours' =>function($query){
                                $query->select('id','store_id','day','start_time','end_time','is_off');
                            },'storeFavourite' => function ($q) use($user_id){
                                $q->where('user_id',$user_id);
                            },'userDara','userStoreRatedFlag'=>function($qu)use($user_id,$request){
                                $qu->where('user_id',$user_id)->where('store_id',$request['provider_id']);
                            },'storeSpecifics' => function($q){
                                $q->select('id','store_id','feature_id');
                            }])
                            ->where('store_status','active')
                            ->where('id',$request['provider_id'])
                            ->select('id','user_id','store_name','store_description','store_profile','store_contact_number','store_banner','store_status','store_address','store_start_time','store_end_time','latitude','longitude','payment_method','store_active_plan','store_link_id','store_district')
                            ->first();
            
                            
            if (empty($storeDetails)) {
                return response()->json(['ResponseCode' => 0, 'ResponseText' => __('Something went wrong'), 'ResponseData' => null], 400);
            }

            // $sum = 0;         
            // foreach ($storeDetails->storeRated as $rating) {                      
            //     $sum += $rating['total_avg_rating'];                                            
            // }     
            // $storeDetails['avg_rating'] = number_format($sum == 0 ? 0 : ($sum / $storeDetails->storeRated->count()),2); 
            // $storeDetails['total_feedback']  =  $storeDetails->storeRated->count();
            $storeDetails['avg_rating'] = \BaseFunction::finalRating($storeDetails->id);
            $storeDetails['total_feedback'] = \BaseFunction::finalCount($storeDetails->id);
            //service name 
            $serviceName = [];
            foreach ($storeDetails['serviceDetails'] as $service) {                 
                $serviceName [] = $service['service_name'];
            }
            $storeDetails['serviceName'] = $serviceName;

            //Store category Name
            $categoryName = [];
            foreach ($storeDetails['storeCategory'] as $category) {                  
                $categoryName [] = $category['CategoryData']['name'];
            }
            $storeDetails['categoryName'] = implode(', ', $categoryName);
            //store specifics
            foreach ($storeDetails['storeSpecifics'] as $specifics) {                  
                $specifics['name'] = $specifics['featureData']['name'];
                $specifics['image'] = $specifics['featureData']['image'];
                $specifics['specifics_image_path'] = $specifics['featureData']['specifics_image_path'];
                unset($specifics->featureData);
            }            
            //favouritse flage 
            $storeDetails['favourite'] = !empty($storeDetails['storeFavourite']) == true ? true : false;            
            $storeDetails['feedback_flag'] = !empty($storeDetails['userStoreRatedFlag']) == true ? true : false;

            //about emp expert            
            foreach ($storeDetails->storeExpert as $row) {
                $row['avg_rating'] = "0.0";
                $row['avg_rating_count'] = "0";
                foreach ($row['employeeRated'] as $key ) {                                    
                    // $empService [] = $key['EmpServiceDetails']['service_name'];      
                    // $row ['empCate'] = $empService;  
                    $row['avg_rating'] = \BaseFunction::finalRatingEmployee($key->emp_id);
                    $row['avg_rating_count'] = \BaseFunction::finalCountEmployee($key->emp_id);                         
                    unset($key->employeeRated);
                }                   
                unset($row->EmpCategory,$row->employeeRated);

            }             
            $cityName = \BaseFunction::getCityName($storeDetails['latitude'],$storeDetails['longitude']);            
            // google map image
            $map = new \Mastani\GoogleStaticMap\GoogleStaticMap('AIzaSyBSItHxCbk9qBcXp1XTysVLYcJick5K8mU');                            
            $url = $map->setCenter($cityName)
                    ->setMapType(\Mastani\GoogleStaticMap\MapType::RoadMap)
                    ->setZoom(15)
                    ->setSize(1024, 1024)
                    ->setFormat(\Mastani\GoogleStaticMap\Format::JPG)
                    ->addMarker('Europe/Berlin', '1', 'red', \Mastani\GoogleStaticMap\Size::Large)
                    ->addMarkerLatLng($storeDetails['latitude'], $storeDetails['longitude'], '1', 'red', \Mastani\GoogleStaticMap\Size::Large)
                    ->make(); // Return url contain map address.                // or
                    // ->download(); // Download map image            
            //store abount
            $storeDetails['About'] = [
                    'Specifics' =>$storeDetails['storeSpecifics'],                    
                    'Small Discribe' =>strip_tags(htmlspecialchars_decode($storeDetails['store_description'])),                    
                    'advantages' =>Advantages::where('store_id', $request['provider_id'])->where('status', 'active')->get(),                                                           
                    'our_service_expert' => $storeDetails['storeExpert'],
                    'latitude' => $storeDetails['latitude'],
                    'longitude' => $storeDetails['longitude'],
                    'district' => $storeDetails['store_district'],
                    'public_transportation' =>PublicTransportation::where('store_id', $request['provider_id'])->where('status', 'active')->get(),
                    'location_by_map' => $url == null ? null : $url, 
                    'opening_hours' => $storeDetails['storeOpeningHours'],
                    'home_url' => $storeDetails['store_link_id'],
                    'diraction'=>Parking::where('store_id', $request['provider_id'])->where('status', 'active')->get(),
					'phone_number' => !empty($storeDetails['store_contact_number']) == true ? $storeDetails['store_contact_number'] : NULL
                    //'phone_number' => !empty($storeDetails['userDara']) == true ? $storeDetails['userDara']['phone_number'] : NULL
                    
            ];
            //check for price amount or persentage
            foreach ($storeDetails->serviceDetails as $value) {
                $value['finalPrice'] = number_format(\BaseFunction::finalPrice($value['id']),0);
            }   

            unset($storeDetails->storeRated,$storeDetails->storeFavourite,$storeDetails->storeExpert,$storeDetails->storeOpeningHours,$storeDetails->userDara,$storeDetails->userStoreRatedFlag,$storeDetails->storeCategory,$storeDetails['storeSpecifics']);
            return response()->json(['ResponseCode' => 1, 'ResponseText' => "Service Provider Get Successfully", 'ResponseData' => $storeDetails], 200);
        }catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => __('Something went wrong'), 'ResponseData' => null], 400);
        }
    }
    /**
     * Add to favourits
     */
    
    /**
     * get store wise categery
     */
    public function storeCategory(Request $request)
    {
        try {
            $data = request()->all();            
            $categoryData = StoreCategory::with('CategoryData')->withCount('CategoryWiseService')->where('store_id',$data['store_id'])->get();
            
            if ($categoryData->count() < 0) {
                return response()->json(['ResponseCode' => 1, 'ResponseText' => 'No Data Found', 'ResponseData' => NULL], 200);                
            }
            
            $categoryDataStore = array();
            $cate_subcategoryData = array();

            foreach ($categoryData as $row) {                
                $row->categoryData = Category::where('id', $row->category_id)->first();                
                $catlist[] = @$row->CategoryData->name;
                $subcategory = Category::where('main_category', $row->category_id)
                    ->join('services','services.subcategory_id','=','categories.id')
                    ->where('services.store_id',$data['store_id'])
                    ->select('categories.*')
                    ->groupBy('categories.id')
                    ->get();
                if(count($subcategory)>0){
                    $categoryDataStore[] = [
                        'id' => $row['id'],
                        'storeId' => $row['store_id'],
                        'category_id' => @$row->categoryData['id'],
                        'created_at' => $row['created_at'],
                        'updated_at' => $row['updated_at'],
                        'category_wise_service_count' => $row['category_wise_service_count'],
                        'category_name' => @$row->categoryData['name'],
                        'category_image_path' => @$row->categoryData['category_image_path']
                    ];                 
                    
                    $cate_subcategoryData[] = $row->categoryData;
                }
            }            
            // foreach ($categoryData as $value) {
            //     $value['category_name'] = $value['CategoryData']['name'];
            //     $value['category_image_path'] = $value['CategoryData']['category_image_path'];
            //     unset($value->CategoryData);
            // }
            
            return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Successful', 'ResponseData' => $categoryDataStore], 200);
        }catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => __('Something went wrong'), 'ResponseData' => null], 400);
        }
    }

    /**
     * store category wise service
     */
    public function storeCategoryServices(Request $request)
    {
        try {
            $data = request()->all();
            $categoryWiseServices = Service::where('store_id',$data['store_id']);
            if ($data['category_id']) {
                $categoryWiseServices = $categoryWiseServices->where('category_id',$data['category_id']);
            }
            $categoryWiseServices = $categoryWiseServices->get();
            /**
             * check for price amount and persentage wise
             */
            foreach ($categoryWiseServices as $value) {
                $value['finalPrice'] = \BaseFunction::finalPrice($value['id']);
            }
            if ($categoryWiseServices->isEmpty()) {
                return response()->json(['ResponseCode' => 1, 'ResponseText' => 'No Data Found', 'ResponseData' => NULL], 200); 
            }
            return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Successful', 'ResponseData' => $categoryWiseServices], 200);
        }catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => __('Something went wrong'), 'ResponseData' => null], 400);
        }
    }

    /**
     * service filter
     */

    public function filterService(Request $request)
    {
        try {
            $data = request()->all();   
            $rating = $data['rating'];        
            $expensive = $data['expensive'];   
            $discount = $request['discount'];            
            $booking = $request['booking_system'];   

            if (isset($data['user']) == true && !empty($data['user'])) {
                $userId = $data['user']['user_id'];                
            }else{
                $userId = '';
            }
            $getStore = StoreProfile::leftjoin('store_categories', 'store_categories.store_id', '=', 'store_profiles.id')
                ->leftjoin('services', 'services.store_id', '=', 'store_profiles.id')
                ->leftjoin('store_rating_reviews', 'store_rating_reviews.store_id', '=', 'store_profiles.id')
                ->leftjoin('store_features', 'store_features.store_id', '=', 'store_profiles.id')
                ->with(['storeFavourite' => function($query)use($userId){
                    $query->where('user_id',$userId);
                },'storeGallery'=>function($q){
                    $q->select('id','store_id','file');
                }]);
                /**
                 * filter by zipcode
                 */
                if (!empty($data['pincode'])) {
                    $zipcode = $data['pincode']; 
                    $getStore = $getStore->where('store_profiles.zipcode','=',$zipcode);
                }
                /**
                 * filter by category
                 */
                // if (!empty($data['category'])) {
                //     $cat_id = [];
                //     foreach (json_decode($data['category']) as $value) {                
                //         $cat_id[] = $value->cat_id;
                //     }
                //     $getStore = $getStore->whereIn('store_categories.category_id',$cat_id);                
                    
                // }
                /**
                 * filter by specifics
                 */                
                if (!empty($data['filter_by_specifics']) && $data['filter_by_specifics'] != "[]") {   
                    $feature_id = json_decode($data['filter_by_specifics']);                    
                    $getStore = $getStore->whereIn('store_features.feature_id',$feature_id);                
                }
                
                /**
                 * filter by price and disount promotions
                 */
                $range ='';
                // if(!empty($data['price'])){                            
                //     $range = $data['price'];                
                //     $getStore = $getStore->where('services.price','<=',$range);                                        
                // }
                
                // if (!empty($data['discount_promotions'])) {
                //     $discount_promotions = $data['discount_promotions'];
                //     $getStore = $getStore->where('services.discount_type',$discount_promotions);
                // }
                /**
                 * filter rating
                 */
                
                // if (!empty($data['rating'])) {
                //     $rating = $data['rating'];                    
                //     $getStore = $getStore->where('store_rating_reviews.total_avg_rating','=',$rating);                    
                // }

                if (!empty($booking)) {
                    $getStore = $getStore->where('store_profiles.store_active_plan', 'business');                    
                }
        
                if (!empty($discount)) {
                    $getStore = $getStore->where('services.discount_type', '!=', '');
                }
                
                $getStore = $getStore->orderBy('store_profiles.id', 'DESC')            
                        ->select('store_profiles.id','store_profiles.user_id','store_profiles.store_name','store_profiles.store_description',
                        'store_profiles.store_profile','store_profiles.store_banner','store_profiles.store_status','store_profiles.store_address',
                        'store_profiles.category_id','store_profiles.store_active_plan','store_profiles.is_value')
                        ->groupBy('store_profiles.id')
                        ->where('store_status', 'active')
                        ->distinct()
                        ->get();
            
            $store_id = array();
            foreach ($getStore as $row) {
                $categories = StoreCategory::where('store_id', $row->id)->get();

                $c = array();
                foreach ($categories as $item) {
                    $c[] = [
                        'id'=>@$item->id,
                        'store_id'=>@$item->store_id,
                        'category_id'=>@$item->category_id,
                        'name'=>@$item->CategoryData->name,

                    ];
                }
                $row->store_category = $c;   
                $row->expensive = count(explode("€", $row->is_value)) - 1;     
                           
                $store_id[] = @$row->id;
                $row['favourite'] =!empty($row->storeFavourite) == true ? true : false;
                $row['category_name'] = 'Kosmetik';//$row['category_id'];
                $row['total_avg_rating'] = number_format($row['total_avg_rating'],2);
                $row['avg_rating'] = \BaseFunction::finalRating($row->id);
                $row['total_feedback'] = \BaseFunction::finalCount($row->id);                
                $row['discountFlage']=\BaseFunction::checkDiscountForStore($row->id);            
                $row['discount']=number_format(\BaseFunction::findStoreDiscount($row->id),0);
                // $row['category_id'] = $row['category_id'] == 'Cosmetics' ? 'Kosmetik' :$row['Cosmetics'];            
                $row['category_id'] = 'Kosmetik';            
                unset($row->storeFavourite);
            }    
            
            if (!empty($expensive)) {                                         
                $finalData = [];                
                foreach ($getStore as $row) {                    
                    if ($expensive == $row->expensive) {
                        $finalData[] = $row;
                    }
                }
                $getStore = $finalData;
            }  

            if (!empty($rating)) {
                
                $finalData = [];
                foreach ($getStore as $row) {
                    if ($row->avg_rating <= $rating) {
                        $finalData[] = $row;
                    }
                }
                $keys = array_column($finalData, 'avg_rating');                                
                array_multisort($keys, SORT_DESC, $finalData);
                $getStore = $finalData;
    //            $getStore = $getStore->where('store_rating_reviews.total_avg_rating', '<=', $rating);
            }
            /**
             * check for service price
             */
            // $getService = Service::whereIn('store_id',$store_id);
            // if (!empty($data['price'])) {
            //     $range = $data['price'];
            //     $getService = $getService->where('price','<=',$range);
            // }
            // $getService = $getService->select('id','store_id','category_id','service_name','image','price')->get();

            // $recommendedStore = StoreProfile::join('store_categories','store_categories.store_id','=','store_profiles.id')
            //                 // ->where('store_profiles.category_id',$request->main_category)
            //                 // ->where('store_categories.category_id',$request->category_id)
            //                 ->select('store_categories.category_id as cat_id','store_profiles.id','store_profiles.store_name'
            //                 ,'store_profiles.store_profile','store_profiles.store_banner','store_profiles.store_status'
            //                 ,'store_profiles.category_id','store_profiles.is_recommended')
            //                 ->where('store_profiles.store_status','active')
            //                 ->where('store_profiles.is_recommended', 'yes')
            //                 ->orderBy('store_profiles.id','DESC')
            //                 ->groupBy('store_profiles.id')
            //                 // ->where('store_profiles.store_name','like','%'.$searchText.'%')                                             
            //                 // ->where('store_profiles.zipcode', 'LIKE', "%{$pincode}%")
            //                 ->take(10)
            //                 ->get();
            $getStoreType = StoreProfile::leftjoin('store_categories', 'store_categories.store_id', '=', 'store_profiles.id')
                ->join('services', 'services.store_id', '=', 'store_profiles.id')
                // ->where('store_profiles.category_id',$request->main_category)
                // ->where('store_categories.category_id',$request->category_id)
                ->select('store_categories.category_id as cat_id','store_profiles.id','store_profiles.store_name'
                        ,'store_profiles.store_profile','store_profiles.store_banner','store_profiles.store_status'
                        ,'store_profiles.category_id');
            $homeType = null;            

            if ($request['home_type'] == 'recommended') {                        
                $homeType = $getStoreType->orderBy('store_profiles.id','DESC')
                                    ->groupBy('store_profiles.id')
                                    ->where('store_profiles.store_status','active')
                                    ->where('store_profiles.is_recommended', 'yes')  
                                    ->where('store_profiles.store_active_plan', 'business')                         
                                    ->get();                         
                foreach ($homeType as $value) {
                    $value['avg_rating'] = \BaseFunction::finalRating($value->id);
                    $value['avg_rating_count'] = \BaseFunction::finalCount($value->id);                                    
                }
            }elseif ($request['home_type'] == 'new') {
                $homeType = $getStoreType->orderBy('store_profiles.created_at','DESC')
                            ->groupBy('store_profiles.id')
                            ->where('store_profiles.store_status','active') 
                            ->where('store_profiles.is_recommended', 'yes')   
                            ->where('store_profiles.store_active_plan', 'business')                             
                            ->distinct()->inRandomOrder()
                            ->get();
                foreach ($homeType as $value) {
                    $value['avg_rating'] = \BaseFunction::finalRating($value->id);
                    $value['avg_rating_count'] = \BaseFunction::finalCount($value->id);                    
                }
            }elseif ($request['home_type'] == 'best_rating') {
                $homeType = $getStoreType
                            // ->leftjoin('store_rating_reviews', 'store_rating_reviews.store_id', '=', 'store_profiles.id')
                            // ->where('store_profiles.store_active_plan', 'business')
                            // ->orderBy('store_rating_reviews.total_avg_rating', 'desc')
                            // ->groupBy('store_profiles.id')
                            // ->get();
                            ->leftjoin('store_rating_reviews', 'store_rating_reviews.store_id', '=', 'store_profiles.id')
                            ->orderBy('store_rating_reviews.total_avg_rating', 'desc')
                            ->groupBy('store_profiles.id')
                            ->where('store_profiles.store_status','active') 
                            ->where('store_profiles.is_recommended', 'yes') 
                            ->where('store_profiles.store_active_plan', 'business')                      
                            ->distinct()->inRandomOrder()
                            ->get();
                foreach ($homeType as $value) {
                    $value['avg_rating'] = \BaseFunction::finalRating($value->id);
                    $value['avg_rating_count'] = \BaseFunction::finalCount($value->id);
                }
                $homeType = collect($homeType->sortByDesc('avg_rating')->values()->all());            
            }  
            
            
            /**check data null or not */
            if(count($getStore) > 0 || count($homeType) > 0){                                 
                $dataList = [                    
                        // 'service_list'    => $getService,            
                        'top_rated_store' => $homeType,
                        'storeList'       => $getStore                    
                ];
                return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Successful', 'ResponseData' => $dataList], 200);
            } else {
                return response()->json(['ResponseCode' => 0, 'ResponseText' => 'No Data Found', 'ResponseData' => NULL], 200);
            }
        } catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => __('Something went wrong'), 'ResponseData' => null], 400);
        }
    }

    /**
     * get all category
     */

    public function allCategoryList(Request $request)
    {
        try {
            $categoryList = Category::where('category_type','Cosmetics')->where('main_category','=',NULL)->select('id','name','image')->get();
            
            if (count($categoryList) > 0) {
                return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Successful', 'ResponseData' => $categoryList], 200);
            }else{
                return response()->json(['ResponseCode' => 0, 'ResponseText' => 'No Data Found', 'ResponseData' => NULL], 200);
            }
        } catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => __('Something went wrong'), 'ResponseData' => null], 400);
        }
    }

    /**
     * store all employee
     */
    public function storeEmployee(Request $request)
    {
        try {
            $data = request()->all();
            $searchText = $data['search_by_name'];
            $storeEmp = StoreProfile::with(['storeExpert' =>function($query) use($searchText)
                        {
                            if (!empty($searchText)) {
                                $query->where('emp_name','LIKE',"%{$searchText}%");
                            }
                            $query->select('id','store_id','emp_name','image');
                        }]
                        )->where('id',$data['store_id'])->first();
            // dd($storeEmp);
            if (!empty($storeEmp)) {
                $EmpName = [];
                foreach ($storeEmp->storeExpert as $value) {                    
                    $EmpName [] = $value;                    
                }  
                
                if (empty($EmpName)) {                   
                    return response()->json(['ResponseCode' => 0, 'ResponseText' => 'No data found.', 'ResponseData' => null], 200);
                }else{
                    return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Successful', 'ResponseData' => $EmpName], 200); 
                }              
                
            }
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'No Data Found', 'ResponseData' => NULL], 200);
        } catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => __('Something went wrong'), 'ResponseData' => null], 400);
        }
    }

    /**
     * get all service
     */
    public function allService(Request $request)
    {
        try {
            $data = request()->all();
            $category_id = $data['category_id'];            
            $category_type = $data['category_type'];            
            $allStore =  StoreProfile::join('store_categories','store_categories.store_id','=','store_profiles.id')
                        ->where('store_profiles.category_id',$category_type)
                        ->where('store_categories.category_id',$category_id)
                        ->select('store_categories.category_id as cat_id','store_profiles.id')
                        ->get();            
            
            if ($allStore->count() <= 0) {
                return response()->json(['ResponseCode' => 0, 'ResponseText' => 'No data found', 'ResponseData' => Null], 200);
            }            
            $store_id = array();
            foreach ($allStore as $value) {
                $store_id [] =$value['id'];
            }
            
            $all_service = Service::whereIn('store_id',$store_id)->select('id','store_id','service_name','image')->orderBy('id','DESC')->paginate(10);            
            if ($all_service->count() <= 0) {
                return response()->json(['ResponseCode' => 0, 'ResponseText' => 'No more data found', 'ResponseData' => Null], 200);
            }
            return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Success', 'ResponseData' => $all_service], 200);          
            
        } catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => __('Something went wrong'), 'ResponseData' => null], 400);
        }
    }

    /**
     * all store
     */

    public function allStore(Request $request)
    {
        try {
            $data = request()->all();                                    
            $userId = $data['user'] == null ? '':$data['user']['user_id'];                                        
            $category_id = $data['category_id'];
            $category_type = $data['category_type'];
            $booking = $request['booking_system'];
            $discount = $request['discount'];
            $allStore =  StoreProfile::join('store_categories','store_categories.store_id','=','store_profiles.id')
                        ->leftjoin('services', 'services.store_id', '=', 'store_profiles.id')                        
                        ->with(['storeFavourite' => function($query)use($userId){
                            $query->where('user_id',$userId);
                        }]);
            if (!empty($booking)) {                
                $allStore = $allStore->where('store_profiles.store_active_plan', 'business');
            }
    
            if (!empty($discount)) {
                $allStore = $allStore->where('services.discount_type', '!=', 'null');                
            }
            $allStore=$allStore->where('store_profiles.category_id',$category_type)
                        ->where('store_categories.category_id',$category_id)
                        ->select('store_profiles.id','store_profiles.user_id','store_profiles.store_name','store_profiles.store_description','store_profiles.store_profile',
                        'store_profiles.store_banner','store_profiles.store_status','store_profiles.store_address','store_profiles.category_id','store_profiles.store_active_plan','store_profiles.is_value')
                        ->orderBy('store_profiles.id','DESC')
                        ->groupBy('store_profiles.id')                        
                        ->paginate(10); 

            foreach ($allStore as $row){                            
                foreach ($row->storeCategory as $category) {                    
                    $category['name'] = $category['CategoryData']['name'];
                    unset($category->CategoryData);
                }             
                //favourite or note
                $row['favourite'] =!empty($row->storeFavourite) == true ? true : false;
                $row['category_name'] = $row['category_id'];
                //store rating   
                $sum = 0;         
                foreach ($row->storeRated as $rating) {                      
                    $sum += $rating['total_avg_rating'];                                            
                }     
                $row['avg_rating'] = number_format($sum == 0 ? 0 : ($sum / $row->storeRated->count()),2);        
                unset($row->storeFavourite,$row->storeRated);
            }
            if ($allStore->isEmpty()) {
                return response()->json(['ResponseCode' => 0, 'ResponseText' => 'No more data found', 'ResponseData' => null], 200);                      
            }
            return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Success', 'ResponseData' => $allStore], 200);                      
        }catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => __('Something went wrong'), 'ResponseData' => null], 400);
        }
    }

    /**
     * get all-recommended-store
     */
    public function allRecommendedStore(Request $request)
    {
        try {
            $data = request()->all();
            
            $category_id = $data['category_id'];
            $category_type = $data['category_type'];
            $allRecommendedStore =  StoreProfile::join('store_categories','store_categories.store_id','=','store_profiles.id')
                        ->where('store_profiles.category_id',$category_type)
                        ->where('store_categories.category_id',$category_id)
                        ->where('store_profiles.is_recommended', 'yes')
                        ->select('store_categories.category_id as cat_id','store_profiles.id','store_profiles.store_name'
                        ,'store_profiles.store_profile','store_profiles.store_banner','store_profiles.store_status'
                        ,'store_profiles.category_id')
                        ->orderBy('store_profiles.id','DESC')
                        ->paginate(10); 

            foreach ($allRecommendedStore as $row){                                            
                $sum = 0;         
                foreach ($row->storeRated as $rating) {                      
                    $sum += $rating['total_avg_rating'];                                            
                }     
                $row['avg_rating'] = number_format($sum == 0 ? 0 : ($sum / $row->storeRated->count()),2);        
                unset($row->storeFavourite,$row->storeRated);
            }
            // $allRecommendedStore = collect($allRecommendedStore->sortByDesc('avg_rating')->values() ->all());
            if ($allRecommendedStore->isEmpty()) {
                return response()->json(['ResponseCode' => 0, 'ResponseText' => 'No more data found', 'ResponseData' => null], 200);                      
            }
            return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Success', 'ResponseData' => $allRecommendedStore], 200);
        } catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => __('Something went wrong'), 'ResponseData' => null], 400);
        }
    }

    /**
     * store-storeSuggetion
     */
    public function storeSuggetion(Request $request)
    {
        try {
            $search = $request['search_text'];
            
            $getStores = StoreProfile::where('store_name', 'LIKE', "%{$search}%")
                ->orderBy('id', 'DESC')
                ->where('store_status', 'active')
                ->distinct()
                ->get();

            $getService = Service::where('service_name', 'LIKE', "%{$search}%")
                ->orderBy('id', 'DESC')
                ->where('status', 'active')
                ->distinct()
                ->get();

            $getCategory = Category::where('name', 'LIKE', "%{$search}%")
                ->orderBy('id', 'DESC')
                ->where('status', 'active')
                ->where('category_type', 'Cosmetics')
                ->distinct()
                ->get();

            $getStore = [];
            foreach ($getStores as $row) {
                $row->url = 'store';
                $row->search_name = $row->store_name;
                $getStore[] = $row;
            }


            foreach ($getService as $row) {
                $row->url = 'service';
                $row->search_name = $row->service_name;
                $getStore[] = $row;
            }
            foreach ($getCategory as $row) {
                $row->url = 'category';
                $row->search_name = $row->name;
                $getStore[] = $row;
            }
            $response = array();
            foreach($getStore as $name){
                $response[] = array("id"=>$name->id,"name"=>$name->search_name, "url"=>$name->url);
            }
            if (!empty($response)) {
                return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Success', 'ResponseData' => $response], 200);
            } else {
                return response()->json(['ResponseCode' => 0, 'ResponseText' => 'no name found', 'ResponseData' => null], 200);
            }
        } catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => __('Something went wrong'), 'ResponseData' => null], 400);
        }
    }    

    /**
     * sorting for store
     */

    public function shortBy(Request $request)
    {
        try {
            $short = $request['sort_by'];  
            $discount = $request['discount'];
            $booking = $request['booking_value'];   
            if (isset($data['user']) == true && !empty($data['user'])) {
                $userId = $data['user']['user_id'];                
            }else{
                $userId = '';  
            }
            $getStore = StoreProfile::leftjoin('store_categories', 'store_categories.store_id', '=', 'store_profiles.id')
                ->leftjoin('services', 'services.store_id', '=', 'store_profiles.id')
                ->with(['storeFavourite' => function($query)use($userId){
                    $query->where('user_id',$userId);
                },'storeGallery'=>function($q){
                    $q->select('id','store_id','file');
                }])->select('store_profiles.id','store_profiles.user_id','store_profiles.store_name','store_profiles.store_description',
                'store_profiles.store_profile','store_profiles.store_banner','store_profiles.store_status','store_profiles.store_address',
                'store_profiles.category_id','store_profiles.store_active_plan','store_profiles.is_recommended','store_profiles.is_value','services.discount_type');
            
            if ($short == 'recommanded') {
                $getStore = $getStore->where('store_profiles.is_recommended', 'yes');
            }

            if ($short == 'A-Z') {
                $getStore = $getStore->orderBy('store_profiles.store_name','ASC');                
            }

            if($short == 'Z-A'){
                $getStore = $getStore->orderBy('store_profiles.store_name','DESC');
            }
            if ($short == 'nearest') {
                $lat = $request['lat'];
                $long = $request['long'];                             
                // $getStore = `SELECT * FROM ( SELECT *, ( ( ( acos( sin(( 51.2212104 * pi() / 180)) * sin(( latitude * pi() / 180)) 
                //             + cos(( 51.2212104 * pi() /180 )) * cos(( latitude * pi() / 180)) * cos((( 6.7919785 - longitude) * pi()/180))) ) 
                //             * 180/pi() ) * 60 * 1.1515 * 1.609344 ) as distance FROM store_profiles ) store_profiles WHERE distance <= 150 LIMIT 150`               

                $getStore = $getStore->select(DB::raw('store_profiles.id,store_profiles.user_id,store_profiles.store_name,
                                        store_profiles.store_description,
                                        store_profiles.store_profile,store_profiles.store_banner,
                                        store_profiles.store_status,store_profiles.store_address,
                                        store_profiles.category_id,store_profiles.store_active_plan,
                                        store_profiles.is_recommended,store_profiles.is_value,services.discount_type,                                         
                                        ( 6367 * acos( cos( radians('.$lat.') ) * cos( radians( store_profiles.latitude ) ) 
                                        * cos( radians( store_profiles.longitude )- radians('.$long.') ) + sin( radians('.$lat.') )
                                        * sin( radians( store_profiles.latitude ) ) ) ) AS distance'))->having('distance','<=', 1500);                
            }           


            if ($short == 'new') {
                $getStore = $getStore->orderBy('store_profiles.id', 'DESC');
            }
            if (!empty($booking)) {
                $getStore = $getStore->where('store_profiles.store_active_plan', 'business');
            }
    
            if (!empty($discount)) {
                $getStore = $getStore->where('services.discount_type', '!=', 'null');                
            }            

            $getStore = $getStore->where('store_profiles.store_status', 'active')                                                                                                                
                            ->orderBy('store_profiles.id','DESC')
                            ->groupBy('store_profiles.id')
                            ->distinct()
                            ->get();
            

            $shorting = [];        
            $ratingNew = [];  
            foreach ($getStore as $row){                                                    
                foreach ($row->storeCategory as $category) {                    
                    $category['name'] = $category['CategoryData']['name'];
                    unset($category->CategoryData);
                }             
                //favourite or note
                $row['favourite'] =!empty($row->storeFavourite) == true ? true : false;
                $row['category_name'] = 'Kosmetik';//$row['category_id'];                
                $row['discountFlage']=\BaseFunction::checkDiscountForStore($row->id);            
                $row['discount']= number_format(\BaseFunction::findStoreDiscount($row->id),0);    
                $row['category_id'] = 'Kosmetik';       
                //store rating 
                // $sum = 0;         
                // foreach ($row->storeRated as $rating) {                      
                //     $sum += $rating['total_avg_rating'];                                            
                // }     
                // $row['avg_rating'] = number_format($sum == 0 ? 0 : ($sum / $row->storeRated->count()),2);  
                // $row['total_feedback']  =  $row->storeRated->count();
                $row['avg_rating'] = \BaseFunction::finalRating($row->id);
                $row['total_feedback'] = \BaseFunction::finalCount($row->id);

                if ($short == 'low_price') {
                    $row->price = Service::where('store_id', $row->id)->min('price');

                }
                if ($short == 'high_price') {
                    $row->price = Service::where('store_id', $row->id)->max('price');
                }

                if ($short == 'low_price' || $short == 'high_price') {
                    if ($row->price != null) {
                        $shorting[] = $row;
                    }
                }                
                
                if ($short == 'best_rating') {                    
                    if ($row->avg_rating != null) {                        
                        $ratingNew[] = $row;                
                    }                
                }                
                unset($row->storeFavourite,$row->storeRated);
            }
            

            if ($short == 'low_price') {
                $keys = array_column($shorting, 'price');

                array_multisort($keys, SORT_ASC, $shorting);
                $getStore = $shorting;
            }
            
            if ($short == 'high_price') {
                $keys = array_column($shorting, 'price');

                array_multisort($keys, SORT_DESC, $shorting);
                $getStore = $shorting;
            }

            if ($short == 'best_rating') {
                $keys = array_column($ratingNew, 'avg_rating');
    
                array_multisort($keys, SORT_DESC, $ratingNew);
                $getStore = $ratingNew;
            }            

            if (count($getStore) > 0) {
                return response()->json(['ResponseCode' => 1, 'ResponseText' => "Service Provider List get Successfully", 'ResponseData' => $getStore], 200);
            } else {
                return response()->json(['ResponseCode' => 0, 'ResponseText' => "No data found", 'ResponseData' => $getStore], 200);           
            }
        } catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => __('Something went wrong'), 'ResponseData' => null], 400);
        }
        
    }

    /**
     * category wise sub category
     */
    public function categoryWiseSubCategory(Request $request)
    {
        try {
            $data = request()->all();     
            if (empty($data['store_id'])) {                
                $subcategoryData  = Category::where('main_category', $data['category_id'])->where('status', 'active')->get();                  
            }else{
                                
                $subcategoryData = Category::where('main_category', $data['category_id'])
                                    ->join('services','services.subcategory_id','=','categories.id')
                                    ->where('services.store_id',$data['store_id'])
                                    ->select('categories.*')
                                    ->groupBy('categories.id')
                                    ->get();        
                
            }
            if (count($subcategoryData) == 0) {
                return response()->json(['ResponseCode' => 0, 'ResponseText' => "No data found", 'ResponseData' =>null], 200);           
            }
            return response()->json(['ResponseCode' => 1, 'ResponseText' => "Successfully", 'ResponseData' => $subcategoryData], 200);
        } catch (\Swift_TransportException $e) {
            dd($e);
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => __('Something went wrong'), 'ResponseData' => null], 400);
        }
    }

    //get festures
    public function getSpecifics(Request $request)
    {
        try {
            $data = request()->all();
            $getSpecifics = Features::where('status','active')->select('id','name','image','status')->get();


            if (count($getSpecifics) > 0) {

                return response()->json(['ResponseCode' => 1, 'ResponseText' => "Successfully", 'ResponseData' => $getSpecifics], 200);

            }
            return response()->json(['ResponseCode' => 0, 'ResponseText' => "No data found", 'ResponseData' =>null], 200);
        }catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => __('Something went wrong'), 'ResponseData' => null], 400);
        }
    }

    //view service details
    public function serviceView(Request $request)
    {
        try {
            $data = request()->all();                                    
            $viewService = Service::with('serviceRated')->where('id',$data['service_id'])->select('id','service_name','description','image')->first();
            if (empty($viewService)) {
                return response()->json(['ResponseCode' => 0, 'ResponseText' => __('Something went wrong'), 'ResponseData' => null], 400);
            }
            $viewService['avg_rating'] = "0.0";
            $viewService['avg_rating_count'] = "0";
            foreach ($viewService['serviceRated'] as $value) {                                              
                $viewService['avg_rating'] = \BaseFunction::finalRatingServices($data['store_id'],$value->service_id);
                $viewService['avg_rating_count'] = number_format(\BaseFunction::finalCountService($value->service_id),0);                
            }
            unset($viewService->serviceRated);
                        
            return response()->json(['ResponseCode' => 1, 'ResponseText' => "Successfully", 'ResponseData' => $viewService], 200);
        } catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => __('Something went wrong'), 'ResponseData' => null], 400);
        }
    }

    //category and subcategory wise service
    public function categorySubcategoryWiseService(Request $request)
    {
        try {
            $data  = request()->all();                
            $serviceData = Service::with(['SubCategoryData'=>function($query){
                $query->select('id','main_category','name','image');
            },'serviceVariant'])->where('store_id',$data['store_id']);           

            // if (!empty($data['category_id'])) {
            //     $serviceData = $serviceData->where('category_id',$data['category_id']);
            // }
            // if (!empty($data['category_id']) && !empty($data['subcategory_id'])) {                
            //     $serviceData = $serviceData->where('category_id',$data['category_id'])->where('subcategory_id',$data['subcategory_id']);
            // }
            
            $serviceData = $serviceData->where('category_id',$data['category_id'])->where('subcategory_id',$data['subcategory_id'])->select('id','store_id','category_id','subcategory_id','service_name','price','start_time',
                            'end_time','start_date','end_date','discount_type','duration_of_service'
                            ,'discount','image','is_popular')->get();

            foreach ($serviceData as $value) {   
				$variants  = $value['serviceVariant'];
				$variants  = $variants->toArray();
				if(count($variants) > 0){
					$origional = number_format(min(array_map(function($a) { return $a['price']; }, $variants)), 2);
					$discounted = number_format(min(array_map(function($a) { return \BaseFunction::finalPriceVariant($a['service_id'],$a['id']); }, $variants)), 2);
				}else{
					$origional =  number_format(0, 2);
					$discounted =  number_format(0, 2);
				}
				$value['finalPrice'] = $discounted;
				$value['price'] = $origional;
				$value['finalPrice_german'] = number_format($discounted, 2, ',', '.');
				$value['price_german'] = number_format($origional, 2, ',', '.');
				if($discounted == $origional){
					$value['discount'] = 0;
				}else{
					$value['discount'] = number_format($value['discount'],0); 
				}
				
                if(count($variants) > 0){
					$value['min_duration']  = min(array_map(function($a) { return $a['duration_of_service']; }, $variants));
					$value['max_duration']  = max(array_map(function($a) { return $a['duration_of_service']; }, $variants));
				}else{
					$value['min_duration']  = 0;
					$value['max_duration']  = 0;
				}
				
                foreach ($value['serviceVariant'] as $row) {                    
                    $tempSelectFlag = TemporarySelectService::where('device_token',$data['device_id'])->where('service_variant_id',$row['id'])->first();
                    $row['price'] = number_format($row['price'],2);
					$row['price_german'] = number_format($row['price'],2, ',', ',');
                    $row['finalPriceVariant'] = number_format(\BaseFunction::finalPriceVariant($row['service_id'],$row->id),2);
					$row['finalPriceVariant_german'] = number_format($row['finalPriceVariant'],2, ',', ',');
                    if (!empty($tempSelectFlag)) {
                        $row['temp_select_flag'] = true;
                    }else{
                        $row['temp_select_flag'] = false;
                    }
                }                
            }
            if (count($serviceData) > 0) {
                return response()->json(['ResponseCode' => 1, 'ResponseText' => "Successfully", 'ResponseData' => $serviceData], 200);
            }
            return response()->json(['ResponseCode' => 0, 'ResponseText' => "No data found", 'ResponseData' =>null], 200);
        }catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => __('Something went wrong'), 'ResponseData' => null], 400);
        }
    }

    // view all review for employee
    public function viewAllReview(Request $request)
    {
        try {
            $data = request()->all();
            $storeEmp = StoreEmp::with('employeeRated')->where('store_id',$data['store_id'])->get();
            foreach ($storeEmp as $row) {
                $row['avg_rating'] = "0.0";
                $row['avg_rating_count'] = "0";    
                foreach ($row['employeeRated'] as $key ) {                                                        
                    $row['avg_rating'] = \BaseFunction::finalRatingEmployee($key->emp_id);
                    $row['avg_rating_count'] = \BaseFunction::finalCountEmployee($key->emp_id);                         
                    unset($key->employeeRated);
                }                   
                unset($row->EmpCategory,$row->employeeRated);
            }
            if ($storeEmp->count() > 0) {
                return response()->json(['ResponseCode' => 1, 'ResponseText' => "Successfully", 'ResponseData' => $storeEmp], 200);
            }
            return response()->json(['ResponseCode' => 0, 'ResponseText' => "No data found", 'ResponseData' =>null], 200);
        } catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => __('Something went wrong'), 'ResponseData' => null], 400);
        }
    }
    //view particular by employee id
    public function viewReviewByEmpId(Request $request)
    {
        try {
            $data = request()->all();
            $customerReview = StoreRatingReview::with(['userDetails','serviceDetails','empDetails'])->where('store_id',$data['store_id'])->where('emp_id',$data['emp_id'])->get();
            foreach ($customerReview as $value) {
                $value['total_avg_rating'] = number_format($value['total_avg_rating'],1);
                $value['service_rate'] = number_format($value['service_rate'],1);
                $value['ambiente']     = number_format($value['ambiente'],1);
                $value['preie_leistungs_rate'] = number_format($value['preie_leistungs_rate'],1);
                $value['wartezeit'] = number_format($value['wartezeit'],1);
                $value['atmosphare'] = number_format($value['atmosphare'],1);
                $value['user_image'] = @$value['userDetails']['user_image_path'];
                $value['user_name'] = @$value['userDetails']['first_name'].' '.@$value['userDetails']['last_name'];
                $value['emp_name'] = @$value['empDetails']['emp_name'];                
                $value['dayAgo'] = \Carbon\Carbon::parse($value->created_at)->diffForHumans(); //@$value->created_at->diffInDays(\Carbon\Carbon::now()->toDateString());
                $value['service_name'] = @$value['serviceDetails']['service_name'];
                unset($value->userDetails,$value->serviceDetails,$value->empDetails);
            }            

            if (count($customerReview) > 0 ) {
                return response()->json(['ResponseCode' => 1, 'ResponseText' => "Successfully", 'ResponseData' => $customerReview], 200);
            }
            return response()->json(['ResponseCode' => 0, 'ResponseText' => "No data found", 'ResponseData' =>null], 200);
        } catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => __('Something went wrong'), 'ResponseData' => null], 400);
        }
    }

    //search service store
    public function storeServiceSearch(Request $request)
    {
        try {
            $data = request()->all();            
            $searchText = $data['search_by_name'];
            $storeService = StoreProfile::with(['serviceDetails' =>function($query) use($searchText)
                        {
                            if (!empty($searchText)) {
                                $query->where('service_name','LIKE',"%{$searchText}%");
                            }
                            $query->select('id','store_id','category_id','subcategory_id','service_name');
                        }]
                        )->where('id',$data['store_id'])->first();
            // dd($storeService);
            if (!empty($storeService)) {
                $ServiceName = [];
                foreach ($storeService->serviceDetails as $value) {                    
                    $ServiceName [] = $value;                    
                }  
                
                if (empty($ServiceName)) {                   
                    return response()->json(['ResponseCode' => 0, 'ResponseText' => 'No data found.', 'ResponseData' => null], 200);
                }else{
                    return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Successful', 'ResponseData' => $ServiceName], 200); 
                }              
                
            }
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'No Data Found', 'ResponseData' => NULL], 200);
        } catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => __('Something went wrong'), 'ResponseData' => null], 400);
        }
    }

    //get subcategory service
    public function getSubcategoryWiseService(Request $request)
    {
        try {
            $data = request()->all();
            
            $store_id = $data['store_id'];
            $subcategoryData = Category::with(['serviceSubcategory' => function($query) use($store_id){                   
                                        $query->where('store_id',$store_id)->select('id','store_id','category_id','subcategory_id','service_name');
                                    }])->where('main_category', $data['category_id'])
                                    ->join('services','services.subcategory_id','=','categories.id')
                                    ->where('services.store_id',$data['store_id'])
                                    ->select('categories.*')
                                    ->groupBy('categories.id')
                                    ->get();  
            // $subcategoryData  = Category::with(['serviceSubcategory' => function($query) use($store_id){                   
            //             $query->where('store_id',$store_id)->select('id','store_id','category_id','subcategory_id','service_name');
            //         }])->where('main_category', $data['category_id'])->where('status', 'active')->get();            
            if (count($subcategoryData) == 0) {
                return response()->json(['ResponseCode' => 0, 'ResponseText' => "No data found", 'ResponseData' =>null], 200);           
            }
            return response()->json(['ResponseCode' => 1, 'ResponseText' => "Successfully", 'ResponseData' => $subcategoryData], 200);
        } catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => __('Something went wrong'), 'ResponseData' => null], 400);
        }
    }
}

