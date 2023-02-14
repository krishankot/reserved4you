<?php

namespace App\Http\Controllers\ServiceProvider;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Features;
use App\Models\Service;
use App\Models\ServiceVariant;
use App\Models\Store\Advantages;
use App\Models\Store\Parking;
use App\Models\Store\PublicTransportation;
use App\Models\StoreCategory;
use App\Models\StoreEmp;
use App\Models\StoreFeatures;
use App\Models\StoreGallery;
use App\Models\StoreProfile;
use App\Models\StoreRatingReview;
use App\Models\StoreTiming;
use App\Models\User;
use App\Models\ApiSession;
use Illuminate\Http\Request;
use Auth;
use File;
use URL;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		
        $store_id = session('store_id');
        if (empty($store_id)) {
            $store_id = StoreProfile::where('user_id', Auth::user()->id)->value('id');
        }

        $data = StoreProfile::where('id', $store_id)->first();
		
        $store_time = StoreTiming::where('store_id', $store_id)->get();
        $storeGallery = StoreGallery::where('store_id', $store_id)->orderBy('id', 'DESC')->get();
        $data['rating'] = \BaseFunction::finalRating($data['id']);
        $rating['service_rate'] = \BaseFunction::getSubRating('service_rate', $data['id']);
        $rating['ambiente'] = \BaseFunction::getSubRating('ambiente', $data['id']);
        $rating['preie_leistungs_rate'] = \BaseFunction::getSubRating('preie_leistungs_rate', $data['id']);
        $rating['wartezeit'] = \BaseFunction::getSubRating('wartezeit', $data['id']);
        $rating['atmosphare'] = \BaseFunction::getSubRating('atmosphare', $data['id']);
        $feedback = StoreRatingReview::where('store_id', $data['id'])->orderBy('created_at', 'desc')->get();
        $storeAdvantages = Advantages::where('store_id', $data['id'])->get();
        $storePublicTransport = PublicTransportation::where('store_id', $data['id'])->get();
        $storeFeatures = StoreFeatures::where('store_features.store_id', $data['id'])->pluck('store_features.feature_id')->all();
        $features = Features::where('status', 'active')->pluck('name', 'id')->all();

        $storeCategory = StoreCategory::join('services', 'services.category_id', '=', 'store_categories.category_id')
            ->where('services.store_id', $data['id'])
            ->select('store_categories.*')
            ->groupBy('store_categories.category_id')
            ->get();

        // dd($storeCategory);
        if(count($storeCategory) > 0){
            $storeSubCategory = Category::where('main_category', $storeCategory[0]['category_id'])
            ->join('services', 'services.subcategory_id', '=', 'categories.id')
            ->where('services.store_id', $data['id'])
            ->select('categories.*')
            ->groupBy('categories.id')
            ->get();

            $storeSubCategorys = $storeSubCategory->pluck('name', 'id')->all();
        } else {
            $storeSubCategory = '';

            $storeSubCategorys = ['' => 'Unterkategorie wählen'];
        }

        

        $service = Service::where('store_id', $data['id'])->where('category_id', @$storeCategory[0]['category_id'])
            ->where('subcategory_id', @$storeSubCategory[0]['id'])->where('status', 'active')->get();

        foreach ($service as $row) {
            $row->rating = \BaseFunction::finalRatingService($data['id'], $row->id);
            $row->variants = ServiceVariant::where('store_id', $data['id'])->where('service_id', $row->id)->get()->toArray();
        }
//        dd($service)

        return view('ServiceProvider.Store.index', compact('data', 'store_time', 'storeGallery', 'feedback', 'rating', 'storeAdvantages',
            'storePublicTransport', 'storeFeatures', 'features', 'storeCategory', 'storeSubCategory', 'service', 'storeSubCategorys'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'store_name' => 'required',
            'store_address' => 'required',
            'zipcode' => 'required',
            'store_district' => 'required'
        ]);

        $store_id = session('store_id');
        if (empty($store_id)) {
            $store_id = StoreProfile::where('user_id', Auth::user()->id)->value('id');
        }

        $data = $request->all();
        $data = $request->except('_token', '_method');

        if ($request->file('store_profile')) {

            $file = $request->file('store_profile');
            $filename = 'Store-' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(storage_path('app/public/store/'), $filename);
            $data['store_profile'] = $filename;
        }

        if ($request->file('store_banner')) {

            $file = $request->file('store_banner');
            $filename = 'Store-' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(storage_path('app/public/store/banner/'), $filename);
            $data['store_banner'] = $filename;
        }

        $update = StoreProfile::where('id', $store_id)->update($data);
        if ($update) {

            return redirect('dienstleister/betriebsprofil');
        }
    }

    public function changeBannerGallery(Request $request)
    {
        $gallery = $request['store_gallery'];

        $store_id = session('store_id');
        if (empty($store_id)) {
            $store_id = StoreProfile::where('user_id', Auth::user()->id)->value('id');
        }

        if (!empty($gallery)) {
            foreach ($gallery as $item) {
                if (!empty($item)) {
                    $extension = $item->getClientOriginalExtension();

                    $destinationpath = storage_path('app/public/store/gallery/');

                    $filename = 'Store-' . uniqid() . '-' . rand(1, 9999) . '.' . $extension;

                    $item->move($destinationpath, $filename);

                    $barImage['file'] = $filename;
                    $barImage['file_type'] = 'image';
                    $barImage['store_id'] = $store_id;

                    $product_img = new StoreGallery();
                    $product_img->fill($barImage);
                    $product_img->save();
                }

            }
            return redirect('dienstleister/betriebsprofil');
        }

    }

    public function removeImageGallery(Request $request)
    {

        $oldimage = StoreGallery::where('id', $request['id'])->value('file');

        if (!empty($oldimage)) {

            File::delete('storage/app/public/store/gallery/' . $oldimage);
        }

        $delete = StoreGallery::where('id', $request['id'])->delete();

        if ($delete) {
            return ['status' => 'true', 'data' => []];
        }
    }

    public function ratingShorting(Request $request)
    {
        $data = $request->all();


        $feedback = StoreRatingReview::where('store_id', $data['id']);
        if (isset($data['type']) && $data['type'] == 'newest') {
            $feedback = $feedback->orderBy('created_at', 'desc')->get();
        }
        if (isset($data['type']) && $data['type'] == 'worst_rated') {
            $feedback = $feedback->orderBy('total_avg_rating', 'asc')->get();
        }
        if (isset($data['type']) && $data['type'] == 'best_rated') {
            $feedback = $feedback->orderBy('total_avg_rating', 'desc')->get();

        }

        if (!isset($data['type'])) {
            $feedback = $feedback->orderBy('created_at', 'desc')->get();
        }
        return (view('ServiceProvider.Store.rating-review', compact('feedback'))->render());
    }

    public function addAdvantages(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'image' => 'required|mimes:svg',
        ]);

        $store_id = session('store_id');
        if (empty($store_id)) {
            $store_id = StoreProfile::where('user_id', Auth::user()->id)->value('id');
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

            return redirect('dienstleister/betriebsprofil');
        }
    }

    public function removeAdvantages(Request $request)
    {
        $store_id = session('store_id');
        $id = $request['id'];

        if (empty($store_id)) {
            $store_id = StoreProfile::where('user_id', Auth::user()->id)->value('id');
        }

        $oldimage = Advantages::where('store_id', $store_id)->where('id', $id)->value('image');

        if (!empty($oldimage)) {

            File::delete('storage/app/public/store/advantage/' . $oldimage);
        }

        $delete = Advantages::where('store_id', $store_id)->where('id', $id)->delete();

        if ($delete) {
            return ['status' => 'true', 'data' => []];
        }
    }

    public function addTransporation(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'transportation_no' => 'required',
//            'image' => 'required|mimes:svg',
        ]);

        $store_id = session('store_id');
        if (empty($store_id)) {
            $store_id = StoreProfile::where('user_id', Auth::user()->id)->value('id');
        }


        $data = $request->all();
        $data['store_id'] = $store_id;
//        if ($request->file('image')) {
//
//            $file = $request->file('image');
//            $filename = 'store-transportation-' . uniqid() . '.' . $file->getClientOriginalExtension();
//            $file->move(storage_path('app/public/store/transportation/'), $filename);
//            $data['image'] = $filename;
//        }

        $publicTransportation = new PublicTransportation();
        $publicTransportation->fill($data);
        if ($publicTransportation->save()) {
            return redirect('dienstleister/betriebsprofil');
        }
    }

    public function removeTransporation(Request $request)
    {
        $id = $request['id'];

        $store_id = session('store_id');
        if (empty($store_id)) {
            $store_id = StoreProfile::where('user_id', Auth::user()->id)->value('id');
        }

        $oldimage = PublicTransportation::where('store_id', $store_id)->where('id', $id)->value('image');

        if (!empty($oldimage)) {

            File::delete('storage/app/public/store/transportation/' . $oldimage);
        }

        $delete = PublicTransportation::where('store_id', $store_id)->where('id', $id)->delete();

        if ($delete) {
            return ['status' => 'true', 'data' => []];
        }
    }

    public function updateOtherDetails(Request $request)
    {

        $store_id = session('store_id');
        if (empty($store_id)) {
            $store_id = StoreProfile::where('user_id', Auth::user()->id)->value('id');
        }
        $specifics = $request['features'];

        $data['store_description'] = $request['store_description'];

        $updateStore = StoreProfile::where('id', $store_id)->update($data);

        if ($updateStore) {
            /**
             * Store Specifics
             */

            $deleteSpecifics = StoreFeatures::where('store_id', $store_id)->delete();

            if (!empty($specifics)) {
                foreach ($specifics as $row) {
                    $specificsData['store_id'] = $store_id;
                    $specificsData['feature_id'] = $row;

                    $specificsStore = new StoreFeatures();
                    $specificsStore->fill($specificsData);
                    $specificsStore->save();

                }
            }

            $day = $request['day'];
            $start_time = $request['start_time'];
            $end_time = $request['end_time'];
            $i = 0;

            $deleteDay = StoreTiming::where('store_id', $store_id)->delete();

            foreach ($day as $item) {

                $dayData['store_id'] = $store_id;
                $dayData['day'] = $item;
                if ($start_time[$i] == '' || $start_time[$i] == null && $end_time[$i] == '' || $end_time[$i] == null) {
                    $dayData['is_off'] = 'on';
                } else {
                    $dayData['is_off'] = null;
                }
                $dayData['start_time'] = $start_time[$i];
                $dayData['end_time'] = $end_time[$i];

                $dayStore = new StoreTiming();
                $dayStore->fill($dayData);
                $dayStore->save();
                $i++;
            }

            return redirect('dienstleister/betriebsprofil');
        }

    }

    public function getSubCategory(Request $request)
    {
        $id = $request['id'];

        $store_id = session('store_id');
        if (empty($store_id)) {
            $store_id = StoreProfile::where('user_id', Auth::user()->id)->value('id');
        }

        $storeSubCategory = Category::where('main_category', $id)
            ->join('services', 'services.subcategory_id', '=', 'categories.id')
            ->where('services.store_id', $store_id)
            ->select('categories.*')
            ->groupBy('categories.id')
            ->get();


        if (count($storeSubCategory) > 0) {
            return ['status' => 'true', 'data' => $storeSubCategory];
        } else {
            return ['status' => 'false', 'data' => []];

        }
    }

    public function getService(Request $request)
    {

        $category = $request['category'];
        $subCategory = $request['id'];

        $store = session('store_id');
        if (empty($store)) {
            $store = StoreProfile::where('user_id', Auth::user()->id)->value('id');
        }

        $service = Service::where('store_id', $store)->where('category_id', $category)
            ->where('subcategory_id', $subCategory)->where('status', 'active')->get();

        foreach ($service as $row) {
            $row->rating = \BaseFunction::finalRatingService($store, $row->id);
            $row->variants = ServiceVariant::where('store_id', $store)->where('service_id', $row->id)->get()->toArray();
        }

        return (view('ServiceProvider.Store.store_details', compact('service'))->render());

    }

    public function getReviewDetails(Request $request)
    {
        $id = $request['id'];

        $data = StoreRatingReview::where('id', $id)->first();

        if (file_exists(storage_path('app/public/user/' . @$data->userDetails->profile_pic)) &&
            @$data->userDetails->profile_pic != '') {
            $data->image = URL::to('storage/app/public/user/' . @$data->userDetails->profile_pic);
        } else {
            $data->image = 'https://via.placeholder.com/1080x1080/00000/FABA5F?text=' . strtoupper(substr(@$data->userDetails->first_name, 0, 1)) . ' ' . strtoupper(substr(@$data->userDetails->last_name, 0, 1));
        }

        $data->name = @$data->userDetails->first_name . ' ' . @$data->userDetails->last_name;
        $data->emp = @$data->empDetails->emp_name;
        $data->category = @$data->categoryDetails->name;
        $data->service_name = @$data->serviceDetails->service_name;
        $data->time = \Carbon\Carbon::parse($data->updated_at)->diffForHumans();


        return ['status' => 'true', 'data' => $data];
    }

    public function venueReplay(Request $request)
    {
        $data = $request->all();
        
        $vanue = StoreRatingReview::where('id', $data['id'])->update(['store_replay' => $data['store_replay']]);
		$reviewData = StoreRatingReview::find($data['id']);
        if ($vanue) {
			$store_name = StoreProfile::where('id', $reviewData['store_id'])->value('store_name');
			\BaseFunction::notification('Antwort auf dein Feedback!','Deine Bewertung wurde von '.$store_name.' beantwortet.','rating',$data['id'],$reviewData['store_id'],$reviewData['user_id'],'','users');
            //Push Notification for cancellations
			$PUSer = User::find($reviewData['user_id']);
			if(!empty($PUSer->device_token) && !empty($PUSer->allow_notifications) && $PUSer->allow_notifications == 1){
				$sessioncount = ApiSession::where('user_id', $PUSer->id)->count();
				if($sessioncount > 0){
					$registerarion_ids = array($PUSer->device_token);
					
					$Pdeatail = $store_name." hat gerade auf deine Bewertung geantwortet. Antwort anzeigen";
					\BaseFunction::sendPushNotification($registerarion_ids, 'Neue Antwort !', $Pdeatail, NULL, $reviewData['store_id'], $data['id']);
				}
			}
			//PUSH Notification code ends 
			return ['status' => 'true', 'data' => $data];
        }
    }

    public function venueReplayUpdate(Request $request)
    {
        $data = $request->all();

        $vanue = StoreRatingReview::where('id', $data['id'])->update(['store_replay' => $data['store_replay']]);

        if ($vanue) {
            return ['status' => 'true', 'data' => $data];
        }
    }

    public function view($id)
    {
        $store = StoreProfile::where('id', $id)->first();

        $storeTiming = StoreTiming::where('store_id', $store['id'])->get();
        $storeGallery = StoreGallery::where('store_id', $store['id'])->get();
        $storeCategory = StoreCategory::where('store_id', $store['id'])->get();
        $today = ucfirst(\Carbon\Carbon::now()->timezone('Europe/Berlin')->format('l'));
        $storeToday = StoreTiming::where('day', $today)->where('store_id', $store['id'])->first();
        $serviceList = ['' => 'Select Service'] + Service::where('store_id', $store['id'])->where('status', 'active')->pluck('service_name', 'id')->all();
        $advantages = Advantages::where('store_id', $store['id'])->where('status', 'active')->get();
        $transport = PublicTransportation::where('store_id', $store['id'])->where('status', 'active')->get();
        $parking = Parking::where('store_id', $store['id'])->where('status', 'active')->get();
        $expert = StoreEmp::where('store_id', $store['id'])->where('status', 'active')->distinct('id')->get();
        $feedback = StoreRatingReview::where('store_id', $store['id'])->orderBy('created_at', 'desc')->get();
        $store['rating'] = \BaseFunction::finalRating($store['id']);
        $rating['service_rate'] = \BaseFunction::getSubRating('service_rate', $store['id']);
        $rating['ambiente'] = \BaseFunction::getSubRating('ambiente', $store['id']);
        $rating['preie_leistungs_rate'] = \BaseFunction::getSubRating('preie_leistungs_rate', $store['id']);
        $rating['wartezeit'] = \BaseFunction::getSubRating('wartezeit', $store['id']);
        $rating['atmosphare'] = \BaseFunction::getSubRating('atmosphare', $store['id']);

        $time = \Carbon\Carbon::now()->timezone('Europe/Berlin')->toTimeString();

        foreach ($expert as $row) {
            $row->getReviews = StoreRatingReview::where('emp_id', $row->id)->where('store_id', $row->store_id)->get();
        }


        $sstatus = 'off';
        if (\Carbon\Carbon::parse($storeToday['start_time'])->toTimeString() <= $time && \Carbon\Carbon::parse($storeToday['end_time'])->toTimeString() >= $time) {
            $sstatus = 'on';
        }

        $storeSpecific = StoreFeatures::where('store_id', $store['id'])->get();

        $catlist = array();
        $categoryData = array();
        $cate_subcategoryData = array();

        foreach ($storeCategory as $row) {
            $row->categoryData = Category::where('id', $row->category_id)->first();
            $catlist[] = @$row->CategoryData->name;
            $subcategory = Category::where('main_category', $row->category_id)
                ->join('services', 'services.subcategory_id', '=', 'categories.id')
                ->where('services.store_id', $store['id'])
                ->select('categories.*')
                ->groupBy('categories.id')
                ->get();
            if (count($subcategory) > 0) {
                $categoryData[] = array(
                    'categorys' => $row->categoryData,
                    'subcategory' => $subcategory
                );

                $row->categoryData->sub_cate = $subcategory;

                $cate_subcategoryData[] = $row->categoryData;
            }


        }


        $service = Service::where('store_id', $store['id'])->where('category_id', @$categoryData[0]['categorys']['id'])
            ->where('subcategory_id', @$categoryData[0]['subcategory'][0]['id'])->where('status', 'active')->get();

        foreach ($service as $row) {
            $row->rating = \BaseFunction::finalRatingService($store['id'], $row->id);
            $row->variants = ServiceVariant::where('store_id', $store['id'])->where('service_id', $row->id)->get()->toArray();
        }

        return view('ServiceProvider.Store.view', compact('store', 'storeTiming', 'storeGallery', 'storeCategory', 'storeToday', 'serviceList', 'advantages', 'transport',
            'parking', 'expert', 'feedback', 'catlist', 'sstatus', 'categoryData', 'service', 'storeSpecific', 'rating'));
    }
}
