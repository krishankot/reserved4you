<?php

namespace App\Http\Controllers\Api\ServiceProvider\StoreProfile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StoreProfile;
use App\Models\StoreCategory;
use App\Models\Store\Advantages;
use App\Models\Features;
use App\Models\StoreFeatures;
use App\Models\Store\PublicTransportation;
use App\Models\StoreTiming;
use App\Models\StoreGallery;
use App\Models\StoreRatingReview;
use App\Models\StoreEmp;
use Validator;
use URL;
use Mail;
use File;
use Exception;
use Carbon\Carbon;


class StoreProfileController extends Controller
{
    public function getStoreDetails(Request $request)
    {
        try {
            $data = request()->all();
            $userId = $data['user']['user_id'];
           
			if (empty($data['store_id'])) {
				$store_id = StoreProfile::where('user_id', $userId)->value('id');
			}else{
				 $store_id = $data['store_id'];
			}
            $storeDetail = StoreProfile::with('storeCategory','storeCategory.CategoryData','storeGallery')->where('user_id',$userId)->where('id',$store_id)->first();            
            if (empty($storeDetail)) {
                return response()->json(['ResponseCode' => 0, 'ResponseText' => 'No store details Found.', 'ResponseData' => NULL], 200);
            }
            $category = [];
            foreach ($storeDetail->storeCategory as  $value) {
                $category[] = $value['CategoryData']['name'];   
                unset($value->CategoryData);
            }            
            $storeDetail['category_name'] = $category;
            unset($storeDetail->storeCategory);
            return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Successfull', 'ResponseData' => $storeDetail], 200);
        } catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
    }
	
	
	public function getStoreGallery(Request $request){
		try {
            $data = request()->all();
            $userId = $data['user']['user_id'];
           
			if (empty($data['store_id'])) {
				$store_id = StoreProfile::where('user_id', $userId)->value('id');
			}else{
				 $store_id = $data['store_id'];
			}
            $storeDetail = StoreProfile::where('user_id',$userId)->where('id',$store_id)->first();            
            if (empty($storeDetail)) {
                return response()->json(['ResponseCode' => 0, 'ResponseText' => 'No store details Found.', 'ResponseData' => NULL], 200);
            }
			$storeGallery  = StoreGallery::where('store_id', $store_id)->get();
			return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Successfull', 'ResponseData' => $storeGallery], 200);
        } catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
	}
	
	 public function getStoreDetailsGeneral(Request $request)
    {
		try {
            $data = request()->all();
            $userId = $data['user']['user_id'];
           
			if (empty($data['store_id'])) {
				$store_id = StoreProfile::where('user_id', $userId)->value('id');
			}else{
				 $store_id = $data['store_id'];
			}
            $storeDetail = StoreProfile::where('user_id',$userId)->where('id',$store_id)->first();            
            if (empty($storeDetail)) {
                return response()->json(['ResponseCode' => 0, 'ResponseText' => 'No store details Found.', 'ResponseData' => NULL], 200);
            }
            $storeFeatures = StoreFeatures::leftjoin('features', 'features.id', '=', 'store_features.feature_id')->where('store_features.store_id', $store_id)->groupBy('store_features.feature_id')->select('features.name', 'store_features.feature_id', 'store_features.store_id')->get();
			$features = Features::where('status', 'active')->select('name', 'id')->get();
			$storeDetail['storeFeatures']  = $storeFeatures;
			$storeDetail['featuresList']  = $features;
			$storeDetail['publicTransport']  = PublicTransportation::where('store_id', $store_id)->get();
			$storeDetail['store_time'] = StoreTiming::where('store_id', $store_id)->get();
			$storeDetail['storeAdvantages'] = Advantages::where('store_id',  $store_id)->get();
            return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Successfull', 'ResponseData' => $storeDetail], 200);
        } catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
		
	}
	
	
	
	 public function getStoreProfileOverview(Request $request)
    {
		try {
            $data = request()->all();
            $userId = $data['user']['user_id'];
           
			if (empty($data['store_id'])) {
				$store_id = StoreProfile::where('user_id', $userId)->value('id');
			}else{
				 $store_id = $data['store_id'];
			}
            $storeDetail = StoreProfile::with(['StoreGallery'])->where('user_id',$userId)->where('id',$store_id)->first();            
            if (empty($storeDetail)) {
                return response()->json(['ResponseCode' => 0, 'ResponseText' => 'No store details Found.', 'ResponseData' => NULL], 200);
            }
			//$storeGallery = StoreGallery::where('store_id', $store_id)->get();
			$storeDetail['rating'] = \BaseFunction::finalRating($store_id);
			$storeDetail['total_reviews'] = StoreRatingReview::where('store_id', $store_id)->count();
			$storeCategory = StoreCategory::leftjoin('categories', 'categories.id','=', 'store_categories.category_id')->where('store_id', $store_id)->pluck('categories.name')->toArray();
			$storeDetail['store_categories'] = implode(", ", $storeCategory);
			
			$today = ucfirst(\Carbon\Carbon::now()->timezone('Europe/Berlin')->format('l'));
			$storeToday = StoreTiming::where('day', $today)->where('store_id', $store_id)->first();
			$storeDetail['store_timing'] = \Carbon\Carbon::now()->translatedFormat('D')." (".@$storeToday['start_time']." - ".@$storeToday['end_time'].")";
			
			$time = \Carbon\Carbon::now()->timezone('Europe/Berlin')->toTimeString();
			$sstatus = 'off';
			if (\Carbon\Carbon::parse(@$storeToday['start_time'])->toTimeString() <= $time && \Carbon\Carbon::parse(@$storeToday['end_time'])->toTimeString() >= $time) {
				$sstatus = 'on';
			}
			
			if($sstatus == 'off' || @$storeToday['is_off'] == 'on'){
				$storeDetail['store_open_status'] = "Geschlossen";
			}else{
				$storeDetail['store_open_status'] = "Geöffnet";
			}
			
            return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Successfull', 'ResponseData' => $storeDetail], 200);
        } catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
		
	}
	
	
	 public function getStoreProfileOverviewAbout(Request $request)
    {
		try {
            $data = request()->all();
            $userId = $data['user']['user_id'];
           
			if (empty($data['store_id'])) {
				$store_id = StoreProfile::where('user_id', $userId)->value('id');
			}else{
				 $store_id = $data['store_id'];
			}
            $storeDetail = StoreProfile::where('user_id',$userId)->where('id',$store_id)->first();
			
            if (empty($storeDetail)) {
                return response()->json(['ResponseCode' => 0, 'ResponseText' => 'No store details Found.', 'ResponseData' => NULL], 200);
            }
			$storeTiming = StoreTiming::where('store_id', $store_id)->get();
			foreach($storeTiming as $value){
				$value->day = \Carbon\Carbon::create($value->day)->locale('de_DE')->dayName;
			}
			$storeDetail['storeTiming'] = $storeTiming;
			
			$storeSpecificIDS = StoreFeatures::where('store_id', $store_id)->pluck('feature_id')->toArray();
			$storeSpecific = Features::whereIn('id', $storeSpecificIDS)->where('status', 'active')->get();
			
			$storeDetail['storeSpecific']  = $storeSpecific;
			$storeDetail['advantages']     = Advantages::where('store_id', $store_id)->where('status', 'active')->get();
			$storeDetail['transports']     = PublicTransportation::where('store_id', $store_id)->where('status', 'active')->get();
			$experts = StoreEmp::where('store_id', $store_id)->where('status', 'active')->distinct('id')->get();
			foreach($experts as $expert){
				$expert->finalRating  = \BaseFunction::finalRatingEmp($expert->store_id,$expert->id);
				$expertReviews = StoreRatingReview::where('emp_id', $expert->id)->where('store_id', $expert->store_id)->get();
				foreach($expertReviews as $item){
					$item->user_image_path  = @$item->userDetails->user_image_path;
					$item->first_name  = @$item->userDetails->first_name;
					$item->last_name  = @$item->userDetails->last_name;
					$item->category_name  = @$item->categoryDetails->name;
					$item->service_name  = @$item->serviceDetails->service_name;
					$item->total_avg_rating  = number_format($item->total_avg_rating,1);
					$item->created_timeago  = \Carbon\Carbon::parse($item->created_at)->diffForHumans();
					unset($item->userDetails, $item->categoryDetails, $item->serviceDetails);
				}
				$expert->expertReviews  = $expertReviews;
			}
			$storeDetail['employees']     = $experts;
            return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Successfull', 'ResponseData' => $storeDetail], 200);
        } catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
		
	}

    //update store details
    public function updateStore(Request $request)
    {       
        $rule = [
            'store_name' => 'required',
            'store_address' => 'required',
            'zipcode' => 'required',
            'store_district' => 'required' 
        ];

        $message = [
            'store_name.required' => 'Store name is required',
            'store_address.required' => 'Store address is required',
            'zipcode.required' => 'Zipcode is required',            
            'store_district.required' => 'Store destrict is required'                                           
        ];

        $validate = Validator::make($request->all(), $rule, $message);

        if ($validate->fails()) {
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Validation Fails', 'ResponseData' => $validate->errors()->all()], 422);
        }
        try {
            $data = request()->all();  
             //$data['zipcode'] = !empty($data['store_zipcode'])?$data['store_zipcode']:NULL;  
            //$category = json_decode($data['storecategory']);   
                        
            
            $userId = $data['user']['user_id'];
			if (empty($data['store_id'])) {
				$storeId = StoreProfile::where('user_id', $userId)->value('id');
			}else{
				 $storeId = $data['store_id'];
			}
			$data['store_id'] =  $storeId;
            $checkStoreId = StoreProfile::where('id',$storeId)->where('user_id',$userId)->first();            
            if (empty($checkStoreId)) {
                return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Not found store id.', 'ResponseData' => ''], 400);
            }
            if ($request->file('store_profile')) {

                $oldimage = StoreProfile::where('id', $storeId)->value('store_profile');
                
                if (!empty($oldimage)) {
    
                    File::delete('storage/app/public/store/' . $oldimage);
                }
    
                $file = $request->file('store_profile');
                $filename = 'Store-' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(storage_path('app/public/store/'), $filename);
                $data['store_profile'] = $filename;
            }
    
            if ($request->file('store_banner')) {
    
                $oldimage = StoreProfile::where('id', $storeId)->value('store_banner');
    
                if (!empty($oldimage)) {
    
                    File::delete('storage/app/public/store/banner/' . $oldimage);
                }
    
                $file = $request->file('store_banner');
                $filename = 'Store-' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(storage_path('app/public/store/banner/'), $filename);
                $data['store_banner'] = $filename;
            }    
            unset($data['user'], $data['store_id']);            
            $update = StoreProfile::where('id', $storeId)->where('user_id',$userId)->update($data);            
            if ($update) {
                /* $deleteCategory = StoreCategory::where('store_id', $storeId)->delete();
                    foreach ($category as $row) {
                        $storeCategory = new StoreCategory();
                        $storeCategory->store_id =  $storeId;
                        $storeCategory->category_id = $row ;                       
                        $storeCategory->save();
                    } */
 
                return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Store Profile Update Successful', 'ResponseData' =>null], 200);                

            }
        } catch (\Swift_TransportException $e) {
           
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
    }

    //update store gallery
    public function updateStoreGallery(Request $request)
    {
        $rule = [
            'store_gallery_image' => 'required',
        ];

        $message = [
            'store_gallery_image.required' => 'image is required',
        ];

        $validate = Validator::make($request->all(), $rule, $message);

        if ($validate->fails()) {
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Validation Fails', 'ResponseData' => $validate->errors()->all()], 422);
        }

        try {
            $data = request()->all();   
            $userId = $data['user']['user_id'];    
              
			if (empty($data['store_id'])) {
				$store_id = StoreProfile::where('user_id', $userId)->value('id');
			}else{
				 $store_id = $data['store_id'];
			}
			$data['store_id'] =  $store_id;
			$checkStoreId = StoreProfile::where('id',$store_id)->where('user_id',$userId)->first(); 
            if (empty($checkStoreId)) {
                return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Not found store id.', 'ResponseData' => ''], 400);
            }                 
            $storeGallery = $request->file('store_gallery_image');
				$uploaded = 0;
            if(!empty($storeGallery)){
                foreach ($storeGallery as $item) {                    
                    if (!empty($item)) {
                        $extension = $item->getClientOriginalExtension();

                        $destinationpath = storage_path('app/public/store/gallery/');

                        $filename = 'Store-' . uniqid() . '-' . rand(1, 9999) . '.' . $extension;

                        $item->move($destinationpath, $filename);

                        $galleryImage['file'] = $filename;
                        $galleryImage['file_type'] = 'image';
                        $galleryImage['store_id'] = $data['store_id'];

                        $product_img = new StoreGallery();
                        $product_img->fill($galleryImage);
                        $product_img->save();
						$uploaded = 1;
                    }
                }
				if($uploaded == 1){
					$storeGallery  = StoreGallery::where('store_id', $store_id)->get();
					return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Add Image in Gallary Successful', 'ResponseData' =>$storeGallery], 200);
				}else{
					 return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
				}
            }
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        } catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
    }

    /**
     * delete gallery image
     */
    public function deleteGalleryImage(Request $request)
    {
        try {
            $data = request()->all();
            $userId = $data['user']['user_id'];
			if (empty($data['store_id'])) {
				$data['store_id'] = StoreProfile::where('user_id', $userId)->value('id');
			}
           
            $checkStoreId = StoreProfile::where('id',$data['store_id'])->where('user_id',$userId)->first();
            if (empty($checkStoreId)) {
                return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Not found store id.', 'ResponseData' => ''], 400);
            }
			
			
            if(!empty($data["store_gallery_id"])){
                $oldimage = StoreGallery::where('id', $data["store_gallery_id"])->value('file');                        
				if (!empty($oldimage)) {
					File::delete('storage/app/public/store/gallery/' . $oldimage);
				}
				$delete = StoreGallery::where('id', $data["store_gallery_id"])->delete();  
				$storeGallery  = StoreGallery::where('store_id', $data['store_id'])->get();
                return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Delete Image Successful', 'ResponseData' =>$storeGallery], 200);
            }
			
            /* $storeGallery = json_decode($data["store_gallery_image"]);  
				
            if(!empty($storeGallery)){
                foreach ($storeGallery as $item) {                                        
                    if (!empty($item)) { 
						  return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Delete Image Successful', 'ResponseData' =>$item], 200);
                        $oldimage = StoreGallery::where('id', $item->g_id)->value('file');                        
                        if (!empty($oldimage)) {
                            File::delete('storage/app/public/store/gallery/' . $oldimage);
                        }
                        $delete = StoreGallery::where('id', $item->g_id)->delete();                        
                    }

                }                
                return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Delete Image Successful', 'ResponseData' =>null], 200);
            } */
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        } catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
    }
	
	
	
	public function addAdvantages(Request $request)
    {
		try {
            $data = request()->all();
			$rule = [
				'title' => 'required',
				'description' => 'required',
				'image' => 'required|mimes:svg',
			];
			
			$message = [
				'title.required' => 'Title is required',
				 'description.required' => 'Description is required',
				  'image.required' => 'Image is required',
				   'image.mimes' => 'Only svg image is accepted',
			];

			$validate = Validator::make($request->all(), $rule, $message);

			if ($validate->fails()) {
				return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Validation Fails', 'ResponseData' => $validate->errors()->all()], 422);
			}
		
			 $userId = $data['user']['user_id'];    
				  
			if (empty($data['store_id'])) {
				$store_id = StoreProfile::where('user_id', $userId)->value('id');
			}else{
				 $store_id = $data['store_id'];
			}
			
			$checkStoreId = StoreProfile::where('id',$store_id)->where('user_id',$userId)->first(); 
			if (empty($checkStoreId)) {
				return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Store id is not found.', 'ResponseData' => ''], 400);
			} 
			$data = $request->all();
			$data['store_id'] = $store_id;

			if ($request->file('image')) {
				$file = $request->file('image');
				$filename = 'store-advantage-' . uniqid() . '.' . $file->getClientOriginalExtension();
				$file->move(storage_path('app/public/store/advantage/'), $filename);
				$data['image'] = $filename;
			}

			$advantages = new Advantages();
			$advantages->fill($data);

			if ($advantages->save()) {
				$advantage = Advantages::where('store_id',  $store_id)->get();
				return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Advantages has been added successfully.', 'ResponseData' => $advantage], 200);
			}else{
				 return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
			}
		}catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
    }

    public function removeAdvantages(Request $request)
    {
		try {
            $data = request()->all();
			$userId = $data['user']['user_id'];    
				  
			if (empty($data['store_id'])) {
				$store_id = StoreProfile::where('user_id', $userId)->value('id');
			}else{
				 $store_id = $data['store_id'];
			}
			$id = $data['id'];


			$oldimage = Advantages::where('store_id', $store_id)->where('id', $id)->value('image');
			if (!empty($oldimage)) {
				File::delete('storage/app/public/store/advantage/' . $oldimage);
			}

			$delete = Advantages::where('store_id', $store_id)->where('id', $id)->delete();

			if ($delete) {
				$advantage = Advantages::where('store_id',  $store_id)->get();
				return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Advantages has been removed successfully.', 'ResponseData' => $advantage], 200);
			}else{
				 return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
			}
		}catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
    }

    public function addTransporation(Request $request)
    {
		try {
            $data = request()->all();
			$rule = [
				'title' => 'required',
				'transportation_no' => 'required',
			];
			
			$message = [
				'title.required' => 'Title is required',
				'transportation_no.required' => 'Transportation number is required'
			];
			
			
			$validate = Validator::make($request->all(), $rule, $message);

			if ($validate->fails()) {
				return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Validation Fails', 'ResponseData' => $validate->errors()->all()], 422);
			}
		
			$userId = $data['user']['user_id'];    
				  
			if (empty($data['store_id'])) {
				$store_id = StoreProfile::where('user_id', $userId)->value('id');
			}else{
				 $store_id = $data['store_id'];
			}
			
			$checkStoreId = StoreProfile::where('id',$store_id)->where('user_id',$userId)->first(); 
			if (empty($checkStoreId)) {
				return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Store id is not found.', 'ResponseData' => ''], 400);
			} 
			$data['store_id'] = $store_id;
			$publicTransportation = new PublicTransportation();
			$publicTransportation->fill($data);
			if ($publicTransportation->save()) {
				$Transportation = PublicTransportation::where('store_id', $store_id)->get();
				return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Public Transportation has been added successfully.', 'ResponseData' => $Transportation], 200);
			}else{
				 return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
			}
		}catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
    }

    public function removeTransporation(Request $request)
    {
		try {
            $data = request()->all();
			$userId = $data['user']['user_id'];    
				  
			if (empty($data['store_id'])) {
				$store_id = StoreProfile::where('user_id', $userId)->value('id');
			}else{
				 $store_id = $data['store_id'];
			}
			$id = $data['id'];
			$delete = PublicTransportation::where('store_id', $store_id)->where('id', $id)->delete();

			if ($delete) {
				$Transportation = PublicTransportation::where('store_id', $store_id)->get();
				return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Transportation has been removed successfully.', 'ResponseData' => $Transportation], 200);
			}else{
				 return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
			}
		}catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
    }
	
	public function removeStoreFeature(Request $request)
    {
		try {
			$data = request()->all();
			$userId = $data['user']['user_id'];    
					  
			if (empty($data['store_id'])) {
				$store_id = StoreProfile::where('user_id', $userId)->value('id');
			}else{
				 $store_id = $data['store_id'];
			}
			
			$checkStoreId = StoreProfile::where('id',$store_id)->where('user_id',$userId)->first(); 
			if (empty($checkStoreId)) {
				return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Store id is not found.', 'ResponseData' => ''], 400);
			}
			$deleteSpecifics = StoreFeatures::where('store_id', $store_id)->where('feature_id', $data['feature_id'])->delete();
			if($deleteSpecifics){
				$storeFeatures = StoreFeatures::leftjoin('features', 'features.id', '=', 'store_features.feature_id')->where('store_features.store_id', $store_id)->select('features.name', 'store_features.feature_id')->get();
				return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Store features has been deleted.', 'ResponseData' => $storeFeatures], 200);
			}else{
				return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong.', 'ResponseData' => ''], 400);
			}
		}catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
	}
	
	
	public function updateOtherDetails(Request $request)
    {

		try {
			$data = request()->all();
			$userId = $data['user']['user_id'];    
					  
			if (empty($data['store_id'])) {
				$store_id = StoreProfile::where('user_id', $userId)->value('id');
			}else{
				 $store_id = $data['store_id'];
			}
			
			$checkStoreId = StoreProfile::where('id',$store_id)->where('user_id',$userId)->first(); 
			if (empty($checkStoreId)) {
				return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Store id is not found.', 'ResponseData' => ''], 400);
			}
			
			$specifics = json_decode($request['features'], true);
			
			$updateStore = true;
			if(!empty($request['store_description'])){
				$storeData = [];
				$storeData['store_description'] = $request['store_description'];
				$updateStore = StoreProfile::where('id', $store_id)->update($storeData);
			}
			

			if ($updateStore) {
				/**
				 * Store Specifics
				 */

				$deleteSpecifics = StoreFeatures::where('store_id', $store_id)->delete();

				if (!empty($specifics)) {
					foreach ($specifics as $row) {
						$specificsData = array();
						$specificsData['store_id'] = $store_id;
						$specificsData['feature_id'] = $row;

						$specificsStore = new StoreFeatures();
						$specificsStore->fill($specificsData);
						$specificsStore->save();

					}
				}

				$storeTimings = json_decode($request['storeTiming'], true);
				//echo "<pre>"; print_r($storeTimings); die;
				if (!empty($storeTimings)) {
					foreach ($storeTimings as $item) {
						$storeTimingArr = StoreTiming::where('store_id', $store_id)->where('day', $item['day'])->first();
						if(!empty($storeTimingArr->id)){
							if(!empty($item['start_time']) and !empty($item['end_time'])){
								$storeTimingArr->update(['start_time' => $item['start_time'], 'end_time' => $item['end_time'], "is_off" => NULL]);
							}elseif(!empty($item['is_off']) and $item['is_off'] == 'on'){
								$storeTimingArr->update(['start_time' => NULL, 'end_time' => NULL, "is_off" => "on"]);
							}
						}else{
							$newitem = array();
							$newitem['store_id']   = $store_id;
							$newitem['is_off'] 	   = $item['is_off'];
							$newitem['start_time'] = $item['start_time'];
							$newitem['end_time']   = $item['end_time'];
							$dayStore = new StoreTiming();
							$dayStore->fill($newitem);
							$dayStore->save();
						}
					}
				}
				return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Store detail has been updated successfully.', 'ResponseData' => null], 200);
			}else{
				 return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
			}
		}catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }

    }

}
