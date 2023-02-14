<?php

namespace App\Http\Controllers\Api\ServiceProvider\ServiceList;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\StoreProfile;
use App\Models\StoreEmp;
use App\Models\Category;
use App\Models\StoreCategory;
use App\Models\ServiceVariant;
use App\Models\TemporarySelectService;
use App\Models\TempServiceStore;
use App\Models\User;
use Validator;
use URL;
use Mail;
use File;
use Exception;
use Carbon\Carbon;


class ServiceListController extends Controller
{
    public function serviceList(Request $request)
    {
        try {
            
            $userId = $request['user']['user_id'];              
            $category_id = request('category_id') == null ? Null :request('category_id');
            $subcategory_id = request('subcategory_id') == null ? Null :request('subcategory_id');
            
			if (empty($request->store_id)) {
				$store_id = StoreProfile::where('user_id', $userId)->value('id');
			}else{
				 $store_id = $request->store_id;
			}
            $serviceList = Service::where('store_id',$store_id);            
            
            //check condition sorting
            if (isset($request->category_id)) {                                
                $serviceList = $serviceList->where('category_id',$category_id);                  
            }
			
			if (isset($request->subcategory_id)) {                                
                $serviceList = $serviceList->where('subcategory_id',$subcategory_id);                  
            }
			
            $count = $serviceList->count();            
            $serviceList = $serviceList->get();
            foreach ($serviceList as $value) {
                $value['finalPrice'] = \BaseFunction::finalPrice($value['id']);
				$value['rating'] = \BaseFunction::finalRatingService($store_id, $value['id']);
				//$value['variants'] = ServiceVariant::where('store_id', $store_id)->where('service_id', $value['id'])->get()->toArray();
				$variants  = ServiceVariant::where('store_id', $store_id)->where('service_id', $value['id'])->get()->toArray();
				$variantsData = array();
				foreach($variants as $val){
					$val['price'] = number_format($val['price'], 2, ',', '.');
					$val['discounted_price'] = number_format(\BaseFunction::finalPriceVariant($value->id,$val['id']),2,',','.');
					$variantsData[] = $val;
				}
				$value['variants'] = $variantsData;
            }
            if (count($serviceList) <= 0) {
                return response()->json(['ResponseCode' => 0, 'ResponseText' => 'No data found', 'ResponseData' => NULL], 200);
            }
            $data = [
                'service_list' => $serviceList,
                'totalService' => $count
            ];
            return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Successful', 'ResponseData' => $data], 200);
        } catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
    }

	
	public function serviceDetail(Request $request)
    {
        try {
            
            $userId = $request['user']['user_id'];              
           
			if (empty($request->store_id)) {
				$store_id = StoreProfile::where('user_id', $userId)->value('id');
			}else{
				 $store_id = $request->store_id;
			}
			$id  = $request['service_id'];
			
			$service = Service::where('id', $id)->where('store_id', $store_id)->first(['service_name', 'description', 'image', 'store_id']);
            $service['rating'] = \BaseFunction::finalRatingService($store_id, $id);
            return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Successful', 'ResponseData' => $service], 200);
        } catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
    }
	
	
    //add service
    public function serviceStore(Request $request)
    {
       
        $rule = [
			'service_name' => 'required',
            'description' => 'required',
			'subcategory_id' => 'required',
			'category_id' => 'required',
			'image' => 'required',
        ];

        $message = [
            'service_name.required' => 'service_name is required',
            'price.required' => 'price is required',
            'discount.required' => 'discount is required',
            'discount_type.required' => 'discount_type is required',
            'duration_of_service.required' => 'duration of service is required',            
            'image.required' => 'image is required',
			'description.required' => 'Description is required',
			'subcategory_id.required' => 'Sub category is required',
			'category_id.required' => 'Category is required'
        ];

		
        $validate = Validator::make($request->all(), $rule, $message);

        if ($validate->fails()) {
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Validation Fails', 'ResponseData' => $validate->errors()->all()], 422);
        }
		$variants = json_decode($request['variants'], true);
		if(empty($request['price']) and empty($variants)){
			return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Validation Fails', 'ResponseData' => 'Provide service variants'], 422);
		}
        try {
            $data = request()->all();
			$userId = $data['user']['user_id'];
			
			if (empty($data['store_id'])) {
				$store_id = StoreProfile::where('user_id', $userId)->value('id');
			}else{
				 $store_id = $data['store_id'];
			}
			$data['store_id']  = $store_id;
			$data['status'] = 'active';
			if(!empty($data['discount']) && empty($data['discount_type'])){
				$data['discount_type']  = 'percentage';
			}
            if ($request->file('image')) {

                $file = $request->file('image');                
                $filename = 'Service-' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(storage_path('app/public/service/'), $filename);
                $data['image'] = $filename;
            }
            
            $service = new Service();
            $service->fill($data);
            if($service->save()){
				$variants = json_decode($request['variants'], true);
				
				if($request['price']){
					$variantData['store_id'] = $store_id;
					$variantData['service_id'] = $service->id;
					$variantData['duration_of_service'] = $request['duration_of_service'];
					$variantData['price'] = $request['price'];
					$variant = new ServiceVariant();
					$variant->fill($variantData);
					$variant->save();
				}
				
				if(!empty($variants)){
					foreach($variants as $val){
						$description_variant = $val['description'];
						$price_variant = $val['price'];
						$duration_of_service_variant = $val['duration_of_service'];
						if(!empty($duration_of_service_variant) && !empty($price_variant) && !empty($description_variant)){
							$variantData['store_id'] = $store_id;
							$variantData['service_id'] = $service->id;
							$variantData['description'] = $description_variant;
							$variantData['duration_of_service'] = $duration_of_service_variant;
							$variantData['price'] = $price_variant;
							$variant = new ServiceVariant();
							$variant->fill($variantData);
							$variant->save();
						}
					}
				}
				return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Service added successfully.', 'ResponseData' => null], 200);
			}else{
				return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
			}
            
        } catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
    }

    //update service
	public function serviceEdit(Request $request)
    {
		 try {
            $data = request()->all();
			$userId = $data['user']['user_id'];
			
			if (empty($data['store_id'])) {
				$store_id = StoreProfile::where('user_id', $userId)->value('id');
			}else{
				 $store_id = $data['store_id'];
			}
			if(!empty($data['service_id'])){
				$id  = $data['service_id'];
				$service = Service::findorFail($id);

				$category_id = StoreCategory::where('store_id', $store_id)->pluck('category_id');
				$storeCategory =  Category::whereIn('id',$category_id)->select('id','name','image')->get();

				$storeSubCategory = ['' => 'Unterkategorie wählen'] + Category::where('main_category', $service['category_id'])
						->select('categories.*')
						->groupBy('categories.id')
						->pluck('name','id')
						->all();

				$serviceVariantMain = ServiceVariant::where('service_id',$id)->whereNull('description')->first();
				$serviceVariant = ServiceVariant::where('service_id',$id)->whereNotNull('description')->get();
				//$serviceVariant = ServiceVariant::where('service_id',$id)->get();
				if(!empty($serviceVariantMain->price)){
					$service['price'] 				= $serviceVariantMain->price;
					$service['duration_of_service'] = $serviceVariantMain->duration_of_service;
				}
				$response  = array(
					'service' => $service,
					'store_categories' => $storeCategory,
					'store_subcategories' => $storeSubCategory,
					'service_variants' => $serviceVariant,
				);
				return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Successful', 'ResponseData' => $response], 200);
			}else{
				return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Invalid request', 'ResponseData' => null], 400);
			}
		} catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
        return view('ServiceProvider.Service.edit_service',compact('storeCategory','storeSubCategory','data','serviceVariant','store_data'));

    }
	
	
    public function serviceUpdate(Request $request)
    {
        $rule = [
			'service_name' => 'required',
            'description' => 'required',
			'subcategory_id' => 'required',
			'category_id' => 'required'
        ];

        $message = [
            'service_name.required' => 'service_name is required',
            'description.required' => 'Description is required',
			'subcategory_id.required' => 'Sub category is required',
			'category_id.required' => 'Category is required'
        ];

        $validate = Validator::make($request->all(), $rule, $message);

        if ($validate->fails()) {
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Validation Fails', 'ResponseData' => $validate->errors()->all()], 422);
        }
		$variants = json_decode($request['variants'], true);
		if(empty($request['price']) and empty($variants)){
			return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Validation Fails', 'ResponseData' => 'Provide service variants'], 422);
		}
        try {
            $data = request()->all();
            $id = $data['service_id'];
            $checkServiceId = Service::where('id',$id)->first();
            if (empty($checkServiceId)) {
                return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Worng Service id.', 'ResponseData' => ''], 400);
            }
            if ($request->file('image')) {

                $oldimage = Service::where('id', $id)->value('image');
    
                if (!empty($oldimage)) {
    
                    File::delete('storage/app/public/service/' . $oldimage);
                }
    
                $file = $request->file('image');                
                $filename = 'Service-' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(storage_path('app/public/service/'), $filename);
                $data['image'] = $filename;
            }    
			if(!empty($data['discount']) && empty($data['discount_type'])){
				$data['discount_type']  = 'percentage';
			}
            unset($data['service_id'],$data['user'],$data['variants']);
            $update = Service::where('id',$id)->update($data);
			if ($update) {
				$variantArr = array();
				if($request['price']){
					$isexist = ServiceVariant::where('service_id',$id)->whereNull('description')->first();
					$variantData['store_id'] = $checkServiceId->store_id;
					$variantData['service_id'] = $checkServiceId->id;
					$variantData['duration_of_service'] = $request['duration_of_service'];
					$variantData['price'] = $request['price'];
					if(!empty($isexist->id)){
						$variant = ServiceVariant::where('id', $isexist->id)->update($variantData);
						$variantArr[] = $isexist->id;
					}else{
						$variant = new ServiceVariant();
						$variant->fill($variantData);
						$variant->save();
						$variantArr[] = $variant->id;
					}
				}
				
				$variants = json_decode($request['variants'], true);
				
				if(!empty($variants)){
					foreach($variants as $val){
						$description_variant = $val['description'];
						$variant_id 		 = !empty($val['id'])?$val['id']:NULL;
						$price_variant       = $val['price'];
						$duration_of_service_variant = $val['duration_of_service'];
						if(!empty($duration_of_service_variant) && !empty($price_variant) && !empty($description_variant)){
							$variantData['store_id'] = $checkServiceId->store_id;
							$variantData['service_id'] = $checkServiceId->id;
							$variantData['description'] = $description_variant;
							$variantData['duration_of_service'] = $duration_of_service_variant;
							$variantData['price'] = $price_variant;
							if(!empty($variant_id)){
								$variant = ServiceVariant::where('id', $variant_id)->update($variantData);
								$variantArr[] = $variant_id;
							}else{
								$variant = new ServiceVariant();
								$variant->fill($variantData);
								$variant->save();
								$variantArr[] = $variant->id;
							}
						}
					}
				}
				ServiceVariant::whereNotIn('id', $variantArr)->where('service_id', $id)->delete();
			}

            return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Service updated successfully.', 'ResponseData' => $update], 200);
        } catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
    }

    //Service delete
    public function serviceDelete(Request $request)
    {
        try {
            $data = request()->all();
			$userId = $data['user']['user_id'];
			
			if (empty($data['store_id'])) {
				$store_id = StoreProfile::where('user_id', $userId)->value('id');
			}else{
				 $store_id = $data['store_id'];
			}
			$data['store_id']  = $store_id;
			
            $deleteService = Service::where('id', $data['service_id'])->where('store_id',$data['store_id'])->first();
            if (empty($deleteService)) {
                return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Not found service id.', 'ResponseData' => ''], 400);
            }
            $oldimage = Service::where('id', $data['service_id'])->where('store_id',$data['store_id'])->value('image');

            if (!empty($oldimage)) {
    
                File::delete('storage/app/public/service/' . $oldimage);
            }
    
            $deletedService = $deleteService->delete();
			if($deletedService){
				$serviceVariant = ServiceVariant::where('service_id',$data['service_id'])->delete();
				return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Service delete successfully.', 'ResponseData' => NULL], 200);
			}else{
				return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
			}
            
        } catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
    }
	
	
	 //Service variant delete
    public function serviceVariantDelete(Request $request)
    {
        try {
            $data = request()->all();
			$userId = $data['user']['user_id'];
			
			if (empty($data['store_id'])) {
				$store_id = StoreProfile::where('user_id', $userId)->value('id');
			}else{
				 $store_id = $data['store_id'];
			}
			$data['store_id']  = $store_id;
			
            $deleteVariant = ServiceVariant::where('service_id', $data['service_id'])->where('id',$data['id'])->where('store_id',$data['store_id'])->first();
            if (empty($deleteVariant)) {
                return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Not found variant id.', 'ResponseData' => ''], 400);
            }
           
            $deleteVariant = $deleteVariant->delete();
			if($deleteVariant){
				return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Variant delete successfully.', 'ResponseData' => NULL], 200);
			}else{
				return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
			}
            
        } catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
    }

    /**
     * service category
     */

    public function serviceListCategory()
    {
        try {
            $category = Category::where('category_type','Cosmetics')->select('id','name','image')->get();
            if ($category->count() <= 0) {
                return response()->json(['ResponseCode' => 0, 'ResponseText' => 'No category found.', 'ResponseData' => null], 200);    
            }
            return response()->json(['ResponseCode' => 1, 'ResponseText' => 'category list.', 'ResponseData' => $category], 200);    
        } catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
    }

    /**
     * store service category list
     */
    public function storeCategory(Request $request)
    {
        try {
            $data = request()->all();
			$userId = $data['user']['user_id'];
			TempServiceStore::where('user_id',$userId)->delete();
			$type  = !empty($data['type'])?$data['type']:"";
			if (empty($data['store_id'])) {
				$store_id = StoreProfile::where('user_id', $userId)->value('id');
			}else{
				 $store_id = $data['store_id'];
			}
           
		   if($type == 'all'){
			    $storeAllCate = StoreCategory::leftjoin('categories', 'store_categories.category_id', '=', 'categories.id')
								->where('store_id',$store_id)->groupBy('store_categories.category_id')->select('categories.*', 'store_categories.category_id')->get();
		   }else{
			   $storeAllCate = StoreCategory::join('services', 'services.category_id', '=', 'store_categories.category_id')
					->leftjoin('categories', 'store_categories.category_id', '=', 'categories.id')
					->where('services.store_id', $store_id)->groupBy('store_categories.category_id')->select('categories.id', 'categories.name', 'categories.image', 'store_categories.category_id')->get();
			}
			
           // $storeAllCate = Category::whereIn('id',$category_id)->select('id','name','image')->get();
            if ($storeAllCate->count() <= 0) {
                return response()->json(['ResponseCode' => 0, 'ResponseText' => 'No category found.', 'ResponseData' => null], 200);
            }
			foreach($storeAllCate as $val){
				$val->image_path = !empty($val->image)?url('storage/app/public/category/'.$val->image):NULL;
				unset($val->category_id);
			}
			
            return response()->json(['ResponseCode' => 1, 'ResponseText' => 'category list.', 'ResponseData' => $storeAllCate], 200);    
        } catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
    }
	
	
	public function storeServiceSubCategory(Request $request)
    {
        try {
            $data = request()->all(); 
			$userId = $data['user']['user_id'];
			$type  = !empty($data['type'])?$data['type']:"";
			if (empty($data['store_id'])) {
				$store_id = StoreProfile::where('user_id', $userId)->value('id');
			}else{
				 $store_id = $data['store_id'];
			}
			
			if($type == 'all'){
				$subcategoryData = Category::where('main_category', $data['category_id'])->where('status', 'active')->get();
			}else{
				$subcategoryData = Category::where('main_category', $data['category_id'])
										->join('services','services.subcategory_id','=','categories.id')
										->where('services.store_id',$store_id)
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
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
    }
	
	public function storeServices(){
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
			;
           
			$storeCategory = StoreCategory::join('services', 'services.category_id', '=', 'store_categories.category_id')
				->where('services.store_id', $store_id)
				->pluck('store_categories.category_id')
				->toArray();

			// dd($storeCategory);
			if(count($storeCategory) > 0){
				$storeSubCategory = Category::where('main_category', $storeCategory[0]['category_id'])
				->join('services', 'services.subcategory_id', '=', 'categories.id')
				->where('services.store_id', $store_id)
				->select('categories.*')
				->groupBy('categories.id')
				->get();
				
				$storeSubCategorys = Category::where('main_category', $storeCategory[0]['category_id'])
				->join('services', 'services.subcategory_id', '=', 'categories.id')
				->where('services.store_id', $store_id)
				->select('categories.name', 'categories.id')
				->groupBy('categories.id')
				->get();
				
			} else {
				$storeSubCategory = '';

				$storeSubCategorys = ['' => 'Unterkategorie wählen'];
			}

			

			$service = Service::where('store_id', $store_id)->where('category_id', @$storeCategory[0]['category_id'])
				->where('subcategory_id', @$storeSubCategory[0]['id'])->where('status', 'active')->get();

			foreach ($service as $row) {
				$row->rating = \BaseFunction::finalRatingService($store_id, $row->id);
				$row->variants = ServiceVariant::where('store_id', $store_id)->where('service_id', $row->id)->get()->toArray();
			}
			$storeDetail['storeCategory']  = $storeCategory;
			$storeDetail['storeSubCategory']  = $storeSubCategory;
			$storeDetail['storeSubCategories']  = $storeSubCategorys;
			$storeDetail['services']  = $service;
			return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Successfull', 'ResponseData' => $storeDetail], 200);
			
		} catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
	}
	
	
	
	 //category and subcategory wise service
    public function categorySubcategoryWiseService(Request $request)
    {
        try {
			
            $data  = request()->all();  
            $userId = $data['user']['user_id'];
			if (empty($data['store_id'])) {
				$data['store_id'] = $store_id = StoreProfile::where('user_id', $userId)->value('id');
			}else{
				 $store_id = $data['store_id'];
			}
			if(!empty($data['device_id'])){
				$device_id  = $data['device_id'];
			}else{
				$device_id  = User::where('id', $userId)->value('device_id');
			}
			
            $serviceData = Service::with(['SubCategoryData'=>function($query){
                $query->select('id','main_category','name','image');
            },'serviceVariant'])->where('store_id',$data['store_id']);  
            
            $serviceData = $serviceData->where('category_id',$data['category_id'])->where('subcategory_id',$data['subcategory_id'])->select('id','store_id','category_id','subcategory_id','service_name','price','start_time',
                            'end_time','start_date','end_date','discount_type','duration_of_service'
                            ,'discount','image','is_popular')->get();
			$totalamount  = 0; $total_services = 0;
            foreach ($serviceData as $value) {   
                //$value['finalPrice'] = number_format(\BaseFunction::finalPrice($value['id']),2);
				$variants  = $value['serviceVariant'];
				$variants  = $variants->toArray();
				if(count($variants) > 0){
					$origional = number_format(min(array_map(function($a) { return $a['price']; }, $variants)), 2);
					$discounted = number_format(min(array_map(function($a) { return \BaseFunction::finalPriceVariant($a['service_id'],$a['id']); }, $variants)), 2);
				}else{
					$origional =  number_format(0, 2);
					$discounted =  number_format(0, 2);
				}
				/* $value['finalPrice'] = min(array_map(function($a) { return number_format($a['price'], 2); }, $variants));				
                $value['price']		 = min(array_map(function($a) { return number_format($a['price'], 2); }, $variants));    */ 
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
                    $tempSelectFlag = TempServiceStore::where('user_id',$userId)->where('variant',$row['id'])->first();
                    $row['price'] = number_format($row['price'],2);
					$row['price_german'] = number_format($row['price'],2, ',', '.');
                    $row['finalPriceVariant'] = number_format(\BaseFunction::finalPriceVariant($row['service_id'],$row->id),2);
					$row['finalPriceVariant_german'] = number_format($row['finalPriceVariant'],2, ',', '.');
					$row['temp_select_flag'] = false;
                    if (!empty($tempSelectFlag->id)) {
                        $row['temp_select_flag'] = true;
						$totalamount += $tempSelectFlag->price;
						$total_services++;
                    }else{
                        $row['temp_select_flag'] = false;
                    }
                }                
            }
			$responseData  = [
								'serviceData' => $serviceData,
								'totalamount' => number_format($totalamount, 2, ',', '.'),
								'total_services' =>$total_services
							];
            if (count($serviceData) > 0) {
                return response()->json(['ResponseCode' => 1, 'ResponseText' => "Successfully", 'ResponseData' => $responseData], 200);
            }
            return response()->json(['ResponseCode' => 0, 'ResponseText' => "No data found", 'ResponseData' =>null], 200);
        }catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
    }
	
	
	
	
	
    //store selected services 
    public function selectService(Request $request)
    {
        try {
            $data = request()->all();             
            $userId = $data['user']['user_id'];
			
			/* if ($userId) {
				$checkData = TempServiceStore::where('user_id', $userId)->get();
				if (count($checkData) > 0) {
					$deleteData = TempServiceStore::where('user_id', $userId)->delete();
				}
			} */
		
			if (empty($data['store_id'])) {
				$data['store_id'] = $store_id = StoreProfile::where('user_id', $userId)->value('id');
			}else{
				 $store_id = $data['store_id'];
			}	
			
			$serviceData = json_decode($request['servicelist'], true);
			
			foreach ($serviceData as $row) {
				$data['user_id'] = $userId;
				$data['service'] = $row['service'];
				$data['category'] = $row['category'];
				$data['subcategory'] = $row['subcategory'];
				$data['variant'] = $row['variant'];
				$data['price'] = $row['price'];
				$data['store_id'] = $store_id;

				$tempData = new TempServiceStore();
				$tempData->fill($data);
				$tempData->save();
			}
            return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Select Service Successful!', 'ResponseData' => NULL], 200);
        } catch (\Swift_TransportException $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
    }

    //get the selected services
    public function getSelectedServices(Request $request)
    {
        try {
            $data = request()->all();
			$userId = $data['user']['user_id'];
		   
			if(empty($data['store_id'])) {
				$data['store_id'] = $store_id = StoreProfile::where('user_id', $userId)->value('id');
			}else{
				 $store_id = $data['store_id'];
			}
		   
			$store = StoreProfile::where('id', $store_id)->first();
			$serviceData = TempServiceStore::where('user_id', $userId)->get()->toArray();
			
             $categoryData = [];
			$totaltime = 0;
			$totalamount = 0;
			$total_services = 0;
			foreach ($serviceData as $row) {
				$row['subcategory_name'] = \BaseFunction::getCategoryName($row['subcategory']);
				$variantData = \BaseFunction::variantData($row['variant']);
				$serviceData = \BaseFunction::serviceData($row['service']);
				$row['variant_data'] = $variantData;
				$row['service_data'] = $serviceData;
				$row['duration_of_service'] = @$variantData['duration_of_service'];
				$totaltime += @$variantData['duration_of_service'];
				$totalamount += $row['price'];
				$total_services++;
				$row['price_german'] = number_format($row['price'], 2, ',', '.');
				$categoryData[(int)$row['category']][] = $row;
			}


			$data = [];

			foreach ($categoryData as $key => $value) {
				$data[] = array(
					'category' => \BaseFunction::getCategoryDate($key),
					'data' => $value,
					'totaltime' => array_sum(array_map(function ($item) {
						return $item['duration_of_service'];
					}, $value)),
				);
			}
			
			$ResponseData = [
								'data' => $data,
								'store' => $store,
								'totalamount' =>$totalamount,
								'total_services' =>$total_services,
								 'totalamount_german' => number_format($totalamount, 2, ',', '.')
							];
            if (count($categoryData) > 0) {
                return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Buchung war erfolgreich', 'ResponseData' => $ResponseData], 200);
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
			$id = $request['variant'];
			$userId = $data['user']['user_id'];
			
			if($userId){
				$getData = TempServiceStore::where('user_id',$userId)->where('variant', $id)->first();
			} 
			
			$getStore = $getData['store_id'];
			$getPrice = $getData['price'];
			
			$remove = TempServiceStore::where('user_id',$userId)->where('variant', $id)->delete();
            $availableService = TempServiceStore::where('user_id',$userId)->where('store_id', $getStore)->get();
            $totalAmount = TempServiceStore::where('user_id',$userId)->where('store_id', $getStore)->sum('price');
            $totalservice = TempServiceStore::where('user_id',$userId)->where('store_id',$getData['store_id'])->where('category',$getData['category'])->count();
			
			if ($remove) {
				$data = array(
					'availableService' => $availableService,
					'totalamount' => $totalAmount,
					'totalservice'=>$totalservice
				);
				 return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Service Cancel Successful!', 'ResponseData' => $data], 200);   
			} else {
				 return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
			}
           
        } catch (\Throwable $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
    }

    /**
     * update check out data
     */
    public function updateCheckoutData(Request $request)
    {
        try {
            $data = request()->all();
			$userId = $data['user']['user_id'];
			$checkout_data = json_decode($request['checkoutData'], true);
			
			if(empty($data['store_id'])) {
				$store_id = StoreProfile::where('user_id', $userId)->value('id');
			}else{
				 $store_id = $data['store_id'];
			}
			$is_updated = false;
			foreach($checkout_data as $val){ 
				if(!empty($val['date'])){
					$category 	= $val['category'];
					$date 		= date('Y-m-d', strtotime($val['date']));
					$employee 	= $val['employee'];
					$time 		= date('H:i', strtotime($val['time']));
					$updata    = array('date' => $date, 'time' => $time, 'employee' => $employee);
				
					$update = TempServiceStore::where('store_id', $store_id)->where('user_id', $userId)->where('category', $category)->update($updata);
					if($update){
						$is_updated = true;
					}
				}else{
					return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Appointment date is not correct', 'ResponseData' => null], 400);
				}
			}
			
            if ($is_updated) {
                return response()->json(['ResponseCode' => 1, 'ResponseText' => 'updated successfull', 'ResponseData' => []], 200);
            }
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        } catch (\Throwable $e) {
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
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
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        } catch (\Throwable $e) {
            dd($e);
            \Log::debug($e);
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong', 'ResponseData' => null], 400);
        }
    }

}
