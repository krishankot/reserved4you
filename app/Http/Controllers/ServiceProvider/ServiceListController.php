<?php

namespace App\Http\Controllers\ServiceProvider;


use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceVariant;
use App\Models\StoreCategory;
use App\Models\Category;
use App\Models\StoreProfile;
use Illuminate\Http\Request;
use Auth;
use URL;
use Session;
use File;

class ServiceListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $store_id = session('store_id');
        if (empty($store_id)) {
            $store_id = StoreProfile::where('user_id', Auth::user()->id)->value('id');
        }

        $storeCategory = StoreCategory::where('store_id', $store_id)->get();

        $store_data = StoreProfile::where('id',$store_id)->first();
        
        if(count($storeCategory) == 0) {
            $storeSubCategory = [];
        } else {
            $storeSubCategory = ['' => 'Unterkategorie wählen'] + Category::where('main_category', $storeCategory[0]['category_id'])
            ->select('categories.*')
            ->groupBy('categories.id')
            ->pluck('name','id')
            ->all();
        }
        return view('ServiceProvider.Service.add_service',compact('storeCategory','storeSubCategory','store_data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function addService(Request $request)
    {
        $data = $request->all();

        $this->validate($request, [
            'service_name' => 'required',
            'description' => 'required',
            'subcategory_id' => 'required',
            'category_id' => 'required',
            'image' => 'required',
        ]);



        if ($request->file('image')) {
            $file = $request->file('image');
            $filename = 'Service-' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(storage_path('app/public/service/'), $filename);
            $data['image'] = $filename;
        }
        $store_id = session('store_id');

        if(empty($store_id)){
            $store_id = StoreProfile::where('user_id', Auth::user()->id)->value('id');
        }

        $data['store_id'] = $store_id;
        $data['status'] = 'active';

        $service = new Service();
        $service->fill($data);
        if ($service->save()) {
            $description_variant = $request['description_variant'];
            $price_variant = $request['price_variant'];
            $duration_of_service_variant = $request['duration_of_service_variant'];
            if(!empty($duration_of_service_variant) && !empty($price_variant) && !empty($description_variant)){
                for($i=0;$i<count($description_variant);$i++){
                    $variantData['store_id'] = $store_id;
                    $variantData['service_id'] = $service->id;
                    $variantData['description'] = $description_variant[$i];
                    $variantData['duration_of_service'] = $duration_of_service_variant[$i];
                    $variantData['price'] = $price_variant[$i];
                    $variant = new ServiceVariant();
                    $variant->fill($variantData);
                    $variant->save();
                }
            }
            Session::flash('message', '<div class="alert alert-success">Service Created Successfully.!! </div>');
            return redirect('dienstleister/betriebsprofil');
        }


    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function editService($id)
    {
        $id = decrypt($id);
        $store_id = session('store_id');
        if (empty($store_id)) {
            $store_id = StoreProfile::where('user_id', Auth::user()->id)->value('id');
        }

        $data = Service::findorFail($id);

        $storeCategory = StoreCategory::where('store_id', $store_id)->get();

        $storeSubCategory = ['' => 'Unterkategorie wählen'] + Category::where('main_category', $data['category_id'])
                ->select('categories.*')
                ->groupBy('categories.id')
                ->pluck('name','id')
                ->all();

        
        $serviceVariant = ServiceVariant::where('service_id',$id)->get();

        $store_data = StoreProfile::where('id',$store_id)->first();

        return view('ServiceProvider.Service.edit_service',compact('storeCategory','storeSubCategory','data','serviceVariant','store_data'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function updateService(Request $request)
    {
        $this->validate($request, [
            'service_name' => 'required',
            'description' => 'required',
            'subcategory_id' => 'required',
            'category_id' => 'required',
        ]);

        $data = $request->all();

        $description_variant = $request['description_variant'];
        $price_variant = $request['price_variant'];
        $duration_of_service_variant = $request['duration_of_service_variant'];
        $variant_id = $request['variant_id'];


        $id = $request['service_id'];
        $serviceData = Service::where('id',$id)->first();

        $data = $request->except('_token', '_method','description_variant','price_variant','duration_of_service_variant','service_id','variant_id');

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

        $update = Service::where('id', $id)->update($data);

        if ($update) {

            $description_variant = $request['description_variant'];
            $price_variant = $request['price_variant'];
            $duration_of_service_variant = $request['duration_of_service_variant'];
            if(!empty($duration_of_service_variant) && !empty($price_variant) && !empty($description_variant)){
				$variant_id  = !empty($variant_id)?$variant_id:array();
                $removeVariant = ServiceVariant::where('service_id',$id)->whereNotIn('id',$variant_id)->delete();

                 for($i=0;$i<count($variant_id);$i++){
                    $variantData['store_id'] = $serviceData['store_id'];
                    $variantData['service_id'] = $id;
                    $variantData['description'] = $description_variant[$i];
                    $variantData['duration_of_service'] = $duration_of_service_variant[$i];
                    $variantData['price'] = $price_variant[$i];
                    $variant = ServiceVariant::where('id',$variant_id[$i])->update($variantData);
                }

                if(count($variant_id) == 0){
                    $removeVariant = ServiceVariant::where('service_id',$id)->delete();
                }
                

                for($i=count($variant_id);$i<count($description_variant);$i++){
                    $variantData['store_id'] = $serviceData['store_id'];
                    $variantData['service_id'] = $id;
                    $variantData['description'] = $description_variant[$i];
                    $variantData['duration_of_service'] = $duration_of_service_variant[$i];
                    $variantData['price'] = $price_variant[$i];
                    $variant = new ServiceVariant();
                    $variant->fill($variantData);
                    $variant->save();
                }
            }

            Session::flash('message', '<div class="alert alert-success">Service Created Successfully.!! </div>');
            return redirect('dienstleister/betriebsprofil');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function removeService($id)
    {
        $id = decrypt($id);
        $oldimage = Service::where('id', $id)->value('image');

        if (!empty($oldimage)) {

            File::delete('storage/app/public/service/' . $oldimage);
        }

        $delete = Service::where('id', $id)->delete();

        if ($delete) {
            return redirect('dienstleister/betriebsprofil');
        } else {
            return redirect('dienstleister/betriebsprofil');
        }

    }

    public function getService(Request $request)
    {
        $id = $request['id'];
        $store_id = session('store_id');

        if(empty($store_id)){
            $getStore = StoreProfile::where('user_id', Auth::user()->id)->pluck('id')->all();
        } else{
            $getStore = StoreProfile::where('user_id', Auth::user()->id)->where('id',$store_id)->pluck('id')->all();
        }


        $service = Service::where('category_id', $id)->whereIn('store_id', $getStore)->get();

        foreach ($service as $row) {
            if(file_exists(storage_path('app/public/service/'.$row['image'])) && $row['image'] != ''){
                $row->image = URL::to('storage/app/public/service/' . $row['image']);
            } else {
                $row->image = URL::to('storage/app/public/default/store_default.png');
            }

            $row->discountedPrice = \BaseFunction::finalPrice($row->id);

        }

        if (count($service) > 0) {
            return ['status' => 'true', 'data' => $service];
        } else {
            return ['status' => 'false', 'data' => []];
        }
    }

    public function changeCategory(Request $request)
    {
        $category_id = $request['id'];

        $data = Category::where('main_category', $category_id)->where('status', 'active')->get();

        return ['status' => 'true', 'data' => $data];

    }

}
