<?php

namespace App\Http\Controllers\Frontend\Cosmetic;

use App\Http\Controllers\Controller;
use App\Models\BecomePartner;
use App\Models\Category;
use App\Models\Favourite;
use App\Models\Service;
use App\Models\ServiceVariant;
use App\Models\Store\Advantages;
use App\Models\Store\Parking;
use App\Models\Store\PublicTransportation;
use App\Models\StoreCategory;
use App\Models\StoreEmp;
use App\Models\StoreEmpService;
use App\Models\StoreEmpTimeslot;
use App\Models\StoreGallery;
use App\Models\StoreProfile;
use App\Models\StoreRatingReview;
use App\Models\Features;
use App\Models\StoreTiming;
use App\Models\StoreFeatures;
use Illuminate\Http\Request;
use URL;
use Auth;
use DB;
use Mail;

class IndexController extends Controller
{
    /**
     * Main Page
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
	
    public function index()
    {
		$data = Category::where('category_type', 'Cosmetics')->where('status', 'active')->where('main_category', null)->get();
			$Catering = Category::where('category_type', 'Catering')->where('status', 'active')->where('main_category', null)->get();
			$cities = StoreProfile::distinct('store_district')->pluck('store_district')->toArray();
			// dd($cities);
			$cities = implode(',', $cities);

			return view('Front.Cosmetic.index', compact('data', 'Catering', 'cities'));
    }

    public function getSubCat(Request $request)
    {
        $data = $request->all();
        if($data['cat'] != ''){
            $category = Category::where('main_category', $data['cat'])->pluck('name', 'id');
        } else {
            $category = [];
        }
         
        // $stores = StoreProfile::join('store_categories','store_categories.store_id','store_profiles.store_id')->where('category_id',$id)->pluck('store_name','id');
        return $category;
        

    }

    public function getStores(Request $request)
    {
        $data = $request->all();
        $stores = StoreProfile::join('store_categories', 'store_categories.store_id', 'store_profiles.id')
            ->where('store_categories.category_id', $data['cat'])
            ->orWhere('store_categories.category_id', $data['sub_cat'])
            ->pluck('store_profiles.store_name', 'store_profiles.id');
        return $stores;

    }

    public function sortData(Request $request)
    {
        $ids = explode(',', $request->ids);
        if(isset($request->ord) && $request->ord != 'Sort by'){
            $getStore = StoreProfile::whereIn('id', $ids)->orderBy('store_name', $request->ord)->get();
        }else {
            $getStore = StoreProfile::whereIn('id', $ids)->orderBy('id', 'DESC')->get();
        }


        foreach ($getStore as $row) {
            $row->categories = StoreCategory::where('store_id', $row->id)->get();
            $categories = StoreCategory::where('store_id', $row->id)->groupBy('category_id')->pluck('category_id')->all();
            $row->rating = \BaseFunction::finalRating($row->id);
            $row->ratingCount = \BaseFunction::finalCount($row->id);
            $row->discount = \BaseFunction::findStoreDiscount($row->id);
            foreach (@$row->storeCategory as $key => $cat) {
                @$cat->CategoryData;
            }

            $row->storeGallery = StoreGallery::where('store_id', $row->id)->get();
            $row->isFavorite = 'false';
            if (Auth::check()) {
                $favor = Favourite::where('user_id', Auth::user()->id)->where('store_id', $row->id)->first();
                if (!empty($favor)) {
                    $row->isFavorite = 'true';
                } else {
                    $row->isFavorite = 'false';
                }
            }
        }

        return $getStore;
    }


    public function filterData(Request $request)
    {
        $data = $request->all();

        $getStore = StoreProfile::leftjoin('store_categories', 'store_categories.store_id', '=', 'store_profiles.id');
        $getStore = $getStore->leftjoin('services', 'services.store_id', '=', 'store_profiles.id');

        if ($data['ids'] != "") {
            $data['ids'] = explode(',', $data['ids']);
            $getStore = $getStore->whereIn('store_profiles.id', $data['ids']);
        }

//        if (isset($data['price']) && $data['price'] != "") {
//            $getStore = $getStore->where('is_value', $data['price']);
//        }

        if (isset($data['advat']) && $data['advat'] != "") {
            $getStore = @$getStore->leftjoin('store_features', 'store_features.store_id', '=', 'store_profiles.id')
                ->whereIn('store_features.feature_id', $data['advat']);
        }

        $getStore = $getStore->orderBy('store_profiles.id', 'DESC')
            ->select('store_profiles.*')
            ->where('store_profiles.store_status', 'active')
            ->distinct()
            ->get();

        foreach ($getStore as $key => $row) {
            $row->categories = StoreCategory::where('store_id', $row->id)->get();
            $categories = StoreCategory::where('store_id', $row->id)->groupBy('category_id')->pluck('category_id')->all();
            $row->rating = \BaseFunction::finalRating($row->id);
            $row->ratingCount = \BaseFunction::finalCount($row->id);
            $row->expensive = count(explode("€", $row->is_value)) - 1;
            foreach (@$row->storeCategory as $key => $cat) {
                @$cat->CategoryData;
            }
            $row->discount = \BaseFunction::findStoreDiscount($row->id);
            $row->rating = \BaseFunction::finalRating($row->id);
            $row->rating_count = @$row->storeRated->count();
            $row->isFavorite = 'false';
            $row->storeGallery = StoreGallery::where('store_id', $row->id)->get();
            if (Auth::check()) {
                $favor = Favourite::where('user_id', Auth::user()->id)->where('store_id', $row->id)->first();
                if (!empty($favor)) {
                    $row->isFavorite = 'true';
                } else {
                    $row->isFavorite = 'false';
                }
            }
        }


        if (isset($data['price'])) {
            $finalData = [];
            foreach ($getStore as $row) {
                if ($data['price'] == $row->expensive) {
                    $finalData[] = $row;
                }
            }
            $getStore = $finalData;

        }


        if (isset($data['rating'])) {
            $finalData = [];
            foreach ($getStore as $row) {
                if ($row->rating <= $data['rating']) {
                    $finalData[] = $row;
                }
            }
            $keys = array_column($finalData, 'rating');
            array_multisort($keys, SORT_DESC, $finalData);
            $getStore = $finalData;
//            $getStore = $getStore->where('store_rating_reviews.total_avg_rating', '<=', $rating);
        }

        return $getStore;
    }

    /**
     * Costmetic Area
     * @param Request $request
     * @param null $slug
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function search(Request $request, $slug = null)
    {

        $category = Category::where('category_type', 'Cosmetics')->where('status', 'active')->where('main_category', null)->get();
        $features = Features::all();
        $getCategory_id = '';
        $categories = $request['categories'];
        $categorieData = $request['categories'];
        $sub_cat = $request['sub_cat'];
        $pincode = $request['postal_code'];
        $date = $request['date'];
        $stores = $request['stores'];
        $discount = $request['discount'];
		$location = $request['location'];
		$search_type = $request['search_type'];
		$search_el = $request['search_el'];
		
		
		$distric   = $request['distric'];
        $distric  = str_replace("Bezirk"," ",$distric);
		$distric  = str_replace("bezirk"," ",$distric);
		$distric  = str_replace("Bezírk"," ",$distric);
		$distric  = str_replace("bezírk"," ",$distric);
		$distric  = trim($distric);
		
			
        $maxprice = Service::where('status', 'active')->max('price');


        if (isset($date)) {

            $date = explode('-', $date);
            $date = date('Y-m-d', strtotime($date[1] . '-' . $date[0] . '-' . $date[2]));
        }

        $day = \Carbon\Carbon::parse($date)->format('l');


        //$subCategory = Category::where('category_type', 'Cosmetics')->where('status', 'active')->where('main_category', '!=', null)->get();


        $searchCategory = Category::where('name', 'LIKE', "%{$category}%")->pluck('id')->all();

        $getStore = StoreProfile::leftjoin('store_categories', 'store_categories.store_id', '=', 'store_profiles.id');

        $getStore = $getStore->leftjoin('services', 'services.store_id', '=', 'store_profiles.id');

        if (!empty($date)) {
            $getStore = $getStore->leftjoin('store_timings', 'store_timings.store_id', '=', 'store_profiles.id');
        }

        if (!empty($stores)) {
			if($search_type == 'store' && $search_el != ""){
				$getStore = $getStore->where('store_profiles.store_name', $stores);
			}elseif($search_type == 'service' && $search_el != ""){
				$getStore = $getStore->where('services.service_name', $stores);
			}else{
				$getStore = $getStore->where(function($query) use( $stores){
								$query->where('store_profiles.store_name', 'LIKE', '%' . $stores . '%')->orwhere('services.service_name', 'LIKE', '%' . $stores . '%');
				});
			}
        }

        if (!empty($categories)) {
            $getStore = $getStore->where('store_categories.category_id', $categories);
        }

        if (!empty($sub_cat)) {

            $getStore = $getStore->where('services.subcategory_id', $sub_cat);
        }

        if (!empty($date)) {
            $getStore = $getStore->where('store_timings.day', $day)->where('store_timings.is_off', null);
        }
		
        if (!empty($pincode)) {
            $getStore = $getStore->where('store_profiles.zipcode', $pincode);
        }elseif(!empty($distric)){
			 $getStore = $getStore->where(function($query) use( $distric){
							$query->where('store_profiles.store_district', 'LIKE', '%' . $distric . '%')->orwhere('store_profiles.store_address', 'LIKE', '%' . $distric . '%');
			});
			//$getStore = $getStore->where('store_profiles.store_district', 'like', '%'.$distric.'%');
		}

        if (!empty($discount) && $discount =='yes') {
            $getStore = $getStore->where('services.discount_type','!=','');
        }

        if (!isset($request['plan'])) {
            $getStore = $getStore->where('store_profiles.store_active_plan', 'business');
        }

        $getStore = $getStore->where('store_profiles.store_status', 'active')
            ->select('store_profiles.*','services.subcategory_id')
            ->orderBy('store_profiles.id', 'DESC')
            ->groupBy('store_profiles.id')
            ->get();


        if (isset($request['plan']) && $request['plan'] == 'business') {
            $finalDatas = [];
            foreach ($getStore as $row) {
                if ($row->store_active_plan == 'business') {
                    $finalDatas[] = $row;
                }
            }
            $getStore = $finalDatas;

        }
// dd($getStore);

        foreach ($getStore as $row) {
            $row->categories = StoreCategory::where('store_id', $row->id)->get();
            $categories = StoreCategory::where('store_id', $row->id)->groupBy('category_id')->pluck('category_id')->all();
            $row->rating = \BaseFunction::finalRating($row->id);
            $row->ratingCount = \BaseFunction::finalCount($row->id);
            foreach (@$row->storeCategory as $key => $cat) {
                @$cat->CategoryData;
            }

            $row->discount = \BaseFunction::findStoreDiscount($row->id);

            $row->rating = \BaseFunction::finalRating($row->id);
            $row->rating_count = @$row->storeRated->count();
            $row->isFavorite = 'false';
            $row->storeGallery = StoreGallery::where('store_id', $row->id)->get();
            if (Auth::check()) {
                $favor = Favourite::where('user_id', Auth::user()->id)->where('store_id', $row->id)->first();
                if (!empty($favor)) {
                    $row->isFavorite = 'true';
                } else {
                    $row->isFavorite = 'false';
                }
            }
        }


        if (isset($discount)) {
            $finalData = [];
            $finalData1 = [];
            foreach ($getStore as $row) {
                if ($row->discount != '' && $discount == 'yes') {
                    $finalData[] = $row;
                } else {
                    $finalData1[] = $row;
                }
            }
            if ($discount == 'yes') {

                $getStore = $finalData;
            } else {

                $getStore = $finalData1;
            }

        }

        if ($request->is_ajax) {
            return $getStore;
        }

        $recommandedforyou = StoreProfile::leftjoin('store_categories', 'store_categories.store_id', '=', 'store_profiles.id');
        if (!empty($categories)) {
            $recommandedforyou = $recommandedforyou->where('store_categories.category_id', $categories);
        }

        $recommandedforyou = $recommandedforyou->where('store_profiles.store_active_plan', 'business')->where('store_profiles.store_status', 'active')->where('store_profiles.is_recommended', 'yes')->select('store_profiles.*')->distinct()->inRandomOrder()->get();

        foreach ($recommandedforyou as $row) {
            $row->rating = \BaseFunction::finalRating($row->id);
            $row->ratingCount = \BaseFunction::finalCount($row->id);
        }

        // $new_store = StoreProfile::where('store_profiles.store_status', 'active')->where('store_profiles.created_at','>=' ,\Carbon\Carbon::now()->subDays('-15'))->select('store_profiles.*')->distinct()->inRandomOrder()->get();
        $new_store = StoreProfile::where('store_profiles.store_status', 'active')
            ->where('store_profiles.store_active_plan', 'business')
            ->where('store_profiles.is_recommended', 'yes')
            ->orderBy('store_profiles.created_at', 'desc')
            ->select('store_profiles.*')
            ->distinct()
			->take(30)
			//->inRandomOrder()
			->get();

        foreach ($new_store as $row) {
            $row->rating = \BaseFunction::finalRating($row->id);
            $row->ratingCount = \BaseFunction::finalCount($row->id);
        }

        $high_rate = StoreProfile::where('store_active_plan', 'business')
            ->where('store_status', 'active')
			->inRandomOrder()
           // ->where('store_profiles.is_recommended', 'yes')
            ->get();

        foreach ($high_rate as $k=>$row) {
            $row->rating = \BaseFunction::finalRating($row->id);
            $row->ratingValue = (float)\BaseFunction::finalRating($row->id);
			if( $row->rating < 4){
				unset($high_rate[$k]);
			}
            $row->ratingCount = \BaseFunction::finalCount($row->id);
        }
		
        
        // $keys = array_column($high_rate->toArray(), 'ratingValue');
        // dd($keys);
        //     array_multisort($keys, SORT_DESC, $high_rate->toArray());

        array_multisort(array_map(function($element) {
            return $element['ratingValue'];
        }, $high_rate->toArray()), SORT_DESC, $high_rate->toArray());


        foreach ($new_store as $row) {
            $row->rating = \BaseFunction::finalRating($row->id);
            $row->ratingCount = \BaseFunction::finalCount($row->id);
        }

        $category = ['' => 'Kategorien'] + Category::where('status', 'active')->where('main_category', null)->pluck('name', 'id')->all();
        $categorysub = Category::where('status', 'active')->where('main_category', null)->first();
		
		if($categories != null && isset($request['categories'])){
			
        $subCategory = ['' => 'Unterkategorien'] + Category::where('category_type', 'Cosmetics')->where('status', 'active')->where('main_category', $categorysub->id)->pluck('name', 'id')->all();
		} else {
			$subCategory = ['' => 'Unterkategorien'];
		}
		
        return view('Front.Cosmetic.cosmeticArea', compact('search_type', 'search_el', 'location', 'distric', 'category', 'getCategory_id', 'getStore', 'slug', 'recommandedforyou', 'new_store',
            'subCategory', 'maxprice', 'high_rate', 'features', 'categorieData', 'sub_cat', 'pincode', 'date', 'stores'));
    }

    /**
     * Costmetic View
     * @param null $slug
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function cosmeticView($slug = null)
    {
        if (empty($slug)) {
            return redirect()->route('kosmetic.search');
        }
        $store = StoreProfile::where('slug', $slug)->first();
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
        $feedback = StoreRatingReview::where('store_id', $store['id'])->orderBy('created_at','DESC')->get();
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
                ->join('services','services.subcategory_id','=','categories.id')
                ->where('services.store_id',$store['id'])
                ->select('categories.*')
                ->groupBy('categories.id')
                ->get();
            if(count($subcategory)>0){
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
        $store['isFavorite'] = 'false';

        if (Auth::check()) {
            $favor = Favourite::where('user_id', Auth::user()->id)->where('store_id', $store['id'])->first();
            if (!empty($favor)) {
                $store['isFavorite'] = 'true';
            } else {
                $store['isFavorite'] = 'false';
            }
        }


        return view('Front.Cosmetic.about', compact('store', 'storeTiming', 'storeCategory', 'storeGallery', 'slug', 'today', 'storeToday', 'serviceList',
            'catlist', 'advantages', 'transport', 'parking', 'expert', 'feedback', 'rating', 'sstatus', 'storeSpecific', 'categoryData', 'service', 'cate_subcategoryData'));
    }

    public function getRates(Request $request)
    {
        $data = $request->all();

        $feedback = StoreRatingReview::where('store_id', $data['id']);

        if (isset($data['cate'])) {
            $feedback->where('category_id', $data['cate']);
        }

        if (isset($data['sub_cate'])) {
            $feedback->where('subcategory_id', $data['sub_cate']);
        }

        if (isset($data['rate'])) {
            $feedback->where('total_avg_rating', '<=',number_format($data['rate'], 2));
        }

        $feedback = $feedback->orderBy('id','DESC')->get();

        

        return (view('Front.Cosmetic.rating-review', compact('feedback'))->render());
    }

    public function ratesShortig(Request $request)
    {
        $data = $request->all();


        $feedback = StoreRatingReview::where('store_id', $data['id']);
        if (isset($data['type']) && $data['type'] == 'newest') {
            $feedback = $feedback->orderBy('created_at', 'DESC')->get();
        }
        if (isset($data['type']) && $data['type'] == 'worst_rated') {
            $feedback = $feedback->orderBy('total_avg_rating', 'asc')->get();
        }
        if (isset($data['type']) && $data['type'] == 'best_rated') {
            $feedback = $feedback->orderBy('total_avg_rating', 'desc')->get();

        }

        if (!isset($data['type'])) {
            $feedback = $feedback->orderBy('created_at', 'DESC')->get();
        }


        return (view('Front.Cosmetic.rating-review', compact('feedback'))->render());

    }


    /**
     * Filter
     * @param Request $request
     * @return array
     */
    public function filter(Request $request)
    {

        $range = $request['range'];
        $category = $request['category'];
        $zipcode = $request['zipcode'];
        $discount = $request['discount'];
        $booking = $request['booking'];
        $rating = $request['rating'];
        $expensive = $request['expensive'];
        $slug = $request['slug'];

        if (empty($category) && !empty($slug)) {
            $category = Category::where('slug', $slug)->pluck('id')->all();
        }

        $getStore = StoreProfile::leftjoin('store_categories', 'store_categories.store_id', '=', 'store_profiles.id')
            ->leftjoin('services', 'services.store_id', '=', 'store_profiles.id')
            ->leftjoin('store_rating_reviews', 'store_rating_reviews.store_id', '=', 'store_profiles.id');

        if (!empty($zipcode)) {
            $getStore = $getStore->where('store_profiles.zipcode', $zipcode);
        }

        if (!empty($booking)) {
            $getStore = $getStore->where('store_profiles.store_active_plan', 'business');
        }

        if (!empty($discount)) {
            $getStore = $getStore->where('services.discount_type', '!=', 'null');
        }

        if (!empty($category)) {
            $getStore = $getStore->whereIn('store_categories.category_id', $category);
        }

        if (!empty($range)) {
            $getStore = $getStore->where('services.price', '<=', $range);
        }

        $getStore = $getStore->orderBy('store_profiles.id', 'DESC')
            ->select('store_profiles.*')
            ->where('store_profiles.store_status', 'active')
            ->distinct()
            ->get();

        foreach ($getStore as $row) {
            $categories = StoreCategory::where('store_id', $row->id)->get();

            $c = array();
            foreach ($categories as $item) {
                $c[] = @$item->CategoryData->name;
            }

            $row->categories = $c;
            $row->expensive = count(explode("€", $row->is_value)) - 1;

            if (file_exists('storage/app/public/store/' . $row->store_profile) && $row->store_profile != '') {
                $row->store_profile = URL::to('storage/app/public/store/' . $row->store_profile);
            } else {
                $row->store_profile = URL::to('storage/app/public/default/default_store.jpeg');
            }

            $row->discount = \BaseFunction::findStoreDiscount($row->id);
            $row->rating = \BaseFunction::finalRating($row->id);
            $row->ratingCount = \BaseFunction::finalCount($row->id);
            $row->isFavorite = 'false';
            if (Auth::check()) {
                $favor = Favourite::where('user_id', Auth::user()->id)->where('store_id', $row->id)->first();
                if (!empty($favor)) {
                    $row->isFavorite = 'true';
                } else {
                    $row->isFavorite = 'false';
                }
            }
        }

        if ($expensive != 5 && !empty($expensive)) {
            $finalData = [];
            foreach ($getStore as $row) {
                if ($expensive >= $row->expensive) {
                    $finalData[] = $row;
                }
            }
            $getStore = $finalData;

        }

        if (!empty($rating)) {
            $finalData = [];
            foreach ($getStore as $row) {
                if ($row->rating == $rating) {
                    $finalData[] = $row;
                }
            }
            $getStore = $finalData;
            //            $getStore = $getStore->where('store_rating_reviews.total_avg_rating', '<=', $rating);
        }

        if (count($getStore) > 0) {
            return ['status' => 'true', 'data' => $getStore];
        } else {
            return ['status' => 'false', 'data' => []];
        }

    }

    /**
     * Shotby Dropdown
     * @param Request $request
     * @return array
     */
    public function shortBy(Request $request)
    {
        $short = $request['value'];
        $discount = $request['discount'];
        $booking = $request['booking'];
        $category = '';
        $slug = $request['slug'];

        if (empty($category) && !empty($slug)) {
            $category = Category::where('slug', $slug)->pluck('id')->all();
        }

        $getStore = StoreProfile::leftjoin('store_categories', 'store_categories.store_id', '=', 'store_profiles.id')
            ->leftjoin('services', 'services.store_id', '=', 'store_profiles.id');

        if ($short == 'recommanded') {
            $getStore = $getStore->where('store_profiles.is_recommended', 'yes');
        }


        if (!empty($category)) {
            $getStore = $getStore->whereIn('store_categories.category_id', $category);
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


        $getStore = $getStore->select('store_profiles.*')
            ->where('store_profiles.store_status', 'active')
            ->distinct()
            ->get();
        $shorting = [];
        $rating = [];
        foreach ($getStore as $row) {
            $categories = StoreCategory::where('store_id', $row->id)->get();

            $c = array();
            foreach ($categories as $item) {
                $c[] = @$item->CategoryData->name;
            }
            $row->categories = $c;

            if (file_exists('storage/app/public/store/' . $row->store_profile) && $row->store_profile != '') {
                $row->store_profile = URL::to('storage/app/public/store/' . $row->store_profile);
            } else {
                $row->store_profile = URL::to('storage/app/public/default/default_store.jpeg');
            }

            $row->discount = \BaseFunction::findStoreDiscount($row->id);
            $row->rating = \BaseFunction::finalRating($row->id);
            $row->ratingCount = \BaseFunction::finalCount($row->id);
            $row->isFavorite = 'false';
            if (Auth::check()) {
                $favor = Favourite::where('user_id', Auth::user()->id)->where('store_id', $row->id)->first();
                if (!empty($favor)) {
                    $row->isFavorite = 'true';
                } else {
                    $row->isFavorite = 'false';
                }
            }

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
                if ($row->rating != null) {
                    $rating[] = $row;
                }
            }


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
            $keys = array_column($rating, 'rating');

            array_multisort($keys, SORT_DESC, $rating);
            $getStore = $rating;
        }


        if (count($getStore) > 0) {
            return ['status' => 'true', 'data' => $getStore];
        } else {
            return ['status' => 'false', 'data' => []];
        }
    }

    /**
     * Get Employee
     * @param Request $request
     * @return array
     */
    public function getEmployee(Request $request)
    {
        $service = $request['service'];
        $date = $request['date'];
        $time = $request['time'];

        $day = \Carbon\Carbon::parse($date)->format('l');

        $employeeList = StoreEmp::leftjoin('store_emp_categories', 'store_emp_categories.store_emp_id', '=', 'store_emps.id')
            ->leftjoin('store_emp_timeslots', 'store_emp_timeslots.store_emp_id', '=', 'store_emps.id')
            ->leftjoin('store_emp_services', 'store_emp_services.store_emp_id', '=', 'store_emps.id')
            ->where('store_emp_services.service_id', $service)
            ->where('store_emp_timeslots.day', $day)
            ->where('store_emp_timeslots.is_off', '!=', 'on')
        //            ->where('store_emp_timeslots.start_time', '>=', $time)
        //            ->where('store_emp_timeslots.end_time', '<=', $time)
            ->select('store_emps.*')
            ->distinct('store_emps.id')
            ->get();

        foreach ($employeeList as $row) {

            if (file_exists('storage/app/public/store/employee/' . $row->image) && $row->image != '') {
                $row->image = URL::to('storage/app/public/store/employee/' . $row->image);
            } else {
                $row->image = URL::to('storage/app/public/default/default-user.png');
            }

        }

        if (count($employeeList) > 0) {
            return ['status' => 'true', 'data' => $employeeList];
        } else {
            return ['status' => 'false', 'data' => []];
        }

    }

    /**
     * Get Employee List
     * @param Request $request
     * @return array
     */
    public function getEmployeeList(Request $request)
    {
        $service = $request['service'];

        $employeeList = StoreEmp::leftjoin('store_emp_categories', 'store_emp_categories.store_emp_id', '=', 'store_emps.id')
            ->leftjoin('store_emp_timeslots', 'store_emp_timeslots.store_emp_id', '=', 'store_emps.id')
            ->leftjoin('store_emp_services', 'store_emp_services.store_emp_id', '=', 'store_emps.id')
            ->where('store_emp_services.service_id', $service)
            ->select('store_emps.*')
            ->distinct('store_emps.id')
            ->get();

        foreach ($employeeList as $row) {
            if (file_exists('storage/app/public/store/employee/' . $row->image) && $row->image != '') {
                $row->image = URL::to('storage/app/public/store/employee/' . $row->image);
            } else {
                $row->image = URL::to('storage/app/public/default/default-user.png');
            }
        }

        if (count($employeeList) > 0) {
            return ['status' => 'true', 'data' => $employeeList];
        } else {
            return ['status' => 'false', 'data' => []];
        }
    }

    /**
     * Get Datepicker time
     * @param Request $request
     * @return array
     */
    public function getDatepicker(Request $request)
    {
        $emp = $request['emp'];

        $timeSlot = StoreEmpTimeslot::where('store_emp_id', $emp)->get();
        $offDay = [];
        $i = 0;
        foreach ($timeSlot as $row) {
            if ($row->is_off == 'on') {
                $offDay[] = $i;
            }
            $i++;
        }

        return ['status' => 'true', 'data' => $offDay];

    }

    /**
     * Get service Details
     * @param Request $request
     * @return array
     */
    public function getServiceDetails(Request $request)
    {
        $id = $request['service'];

        $data = Service::where('id', $id)->first();
        $data['price'] = \BaseFunction::finalPrice($data['id']);

        if (file_exists('storage/app/public/service/' . $data['image']) && $data['image'] != '') {
            $data['image'] = URL::to('storage/app/public/service/' . $data['image']);
        } else {
            $data['image'] = URL::to('storage/app/public/default/store_default.png');
        }

        if (!empty($data)) {
            return ['status' => 'true', 'data' => $data];
        } else {
            return ['status' => 'false', 'data' => []];
        }


    }

    /**
     * Get Time Slot
     * @param Request $request
     * @return array
     */
    public function getTimeslot(Request $request)
    {
        $data = $request->all();

        $time = \BaseFunction::bookingTimeAvailable(\Carbon\Carbon::parse($data['date'])->format('Y-m-d'), $data['emp'], $data['service']);

        if (count($time) > 0) {
            return ['status' => 'true', 'data' => $time];
        } else {
            return ['status' => 'false', 'data' => []];
        }

    }

//    /**
//     * Get Available Time
//     * @param Request $request
//     * @return array
//     */
//    public function getAvailableTime(Request $request)
//    {
//        $data = $request->all();
//
//        $time = \BaseFunction::bookingAvailableTime($data['date'], $data['service']);
//
//        if (count($time) > 0) {
//            return ['status' => 'true', 'data' => $time];
//        } else {
//            return ['status' => 'false', 'data' => []];
//        }
//    }

    /**
     * Get Available Time Direct
     * @param Request $request
     * @return array
     */
    public function getAvailableTimeDirect(Request $request)
    {
        $data = $request->all();
        $time = \BaseFunction::bookingAvailableTime(\Carbon\Carbon::parse($data['date'])->format('Y-m-d'), $data['service']);

        if (count($time) > 0) {
            return ['status' => 'true', 'data' => $time];
        } else {
            return ['status' => 'false', 'data' => []];
        }
    }

    /**
     * Get Available Employee
     * @param Request $request
     * @return array
     */
    public function getAvailableEmp(Request $request)
    {
        $data = $request->all();

        $emp = \BaseFunction::getEmpFromTime(\Carbon\Carbon::createFromFormat('d-m-Y', $data['date'])->format('Y-m-d'), $data['service'], $data['time']);
        if (count($emp) > 0) {
            return ['status' => 'true', 'data' => $emp];
        } else {
            return ['status' => 'false', 'data' => []];
        }
    }

    /**
     * Get Booking Data
     * @param Request $request
     * @return array
     */
    public function getBookingData(Request $request)
    {

        $value = $request['value'];
        $discount = $request['discount'];
        $slug = $request['slug'];

        if (empty($category) && !empty($slug)) {
            $category = Category::where('slug', $slug)->pluck('id')->all();
        }

        $getStore = StoreProfile::leftjoin('store_categories', 'store_categories.store_id', '=', 'store_profiles.id')
            ->leftjoin('services', 'services.store_id', '=', 'store_profiles.id')
            ->leftjoin('store_rating_reviews', 'store_rating_reviews.store_id', '=', 'store_profiles.id');


        if (!empty($value) && $value == 'yes') {
            $getStore = $getStore->where('store_profiles.store_active_plan', 'business');
        }

        if (!empty($category)) {
            $getStore = $getStore->whereIn('store_categories.category_id', $category);
        }


        if (!empty($discount)) {
            $getStore = $getStore->where('services.discount_type', '!=', 'null');
        }


        $getStore = $getStore->orderBy('store_profiles.id', 'DESC')
            ->select('store_profiles.*')
            ->where('store_profiles.store_status', 'active')
            ->distinct()
            ->get();

        foreach ($getStore as $row) {
            $categories = StoreCategory::where('store_id', $row->id)->get();

            $c = array();
            foreach ($categories as $item) {
                $c[] = @$item->CategoryData->name;
            }
            $row->categories = $c;

            if (file_exists('storage/app/public/store/' . $row->store_profile) && $row->store_profile != '') {
                $row->store_profile = URL::to('storage/app/public/store/' . $row->store_profile);
            } else {
                $row->store_profile = URL::to('storage/app/public/default/default_store.jpeg');
            }


            $row->rating = \BaseFunction::finalRating($row->id);
            $row->ratingCount = \BaseFunction::finalCount($row->id);
            $row->isFavorite = 'false';
            if (Auth::check()) {
                $favor = Favourite::where('user_id', Auth::user()->id)->where('store_id', $row->id)->first();
                if (!empty($favor)) {
                    $row->isFavorite = 'true';
                } else {
                    $row->isFavorite = 'false';
                }
            }
        }

        if (count($getStore) > 0) {
            return ['status' => 'true', 'data' => $getStore];
        } else {
            return ['status' => 'false', 'data' => []];
        }
    }

    /**
     * get Service Data
     * @param Request $request
     * @return array
     */
    public function getServiceData(Request $request)
    {
        $service = $request['service'];
        $emp = $request['employee_list'];

        $serviceData = Service::where('id', $service)->first();

        if (file_exists('storage/app/public/service/' . $serviceData['image']) && $serviceData['image'] != '') {
            $serviceData['image'] = URL::to('storage/app/public/service/' . $serviceData['image']);
        } else {
            $serviceData['image'] = URL::to('storage/app/public/default/store_default.png');
        }

        $serviceData['emp_name'] = StoreEmp::where('id', $emp)->value('emp_name');
        $serviceData['discount_price'] = \BaseFunction::finalPrice($serviceData['id']);

        if (!empty($serviceData)) {
            return ['status' => 'true', 'data' => $serviceData];
        } else {
            return ['status' => 'false', 'data' => []];
        }
    }

    /**
     * Main page search bar
     * @param Request $request
     * @return array
     */
    public function searchBar(Request $request)
    {

        $search = urldecode($request['search']);
		if($search != trim($search)){
			 $getStores = StoreProfile::where('store_name', trim($search))
				->orderBy('id', 'DESC')
				->where('store_status', 'active')
				->distinct()
				->get();

			$getService = Service::where('service_name', trim($search))
				->orderBy('id', 'DESC')
				->where('status', 'active')
				->distinct()
				->get();

			$getCategory = Category::where('name', trim($search))
				->orderBy('id', 'DESC')
				->where('status', 'active')
				->where('category_type', 'Cosmetics')
				->distinct()
				->get();
		}else{
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

		}
       
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


        if (!empty($getStore)) {
            return ['status' => 'true', 'data' => $getStore];
        } else {
            return ['status' => 'false', 'data' => []];
        }
    }

    /**
     * Costmatic area search bar
     * @param Request $request
     * @return array
     */
    public function searchBarSearvice(Request $request)
    {
        $search = $request['search'];
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

        if (!empty($getStore)) {
            return ['status' => 'true', 'data' => $getStore];
        } else {
            return ['status' => 'false', 'data' => []];
        }
    }

    /**
     * Recommandation View
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function recommendedYou()
    {
        $getStore = StoreProfile::leftjoin('store_categories', 'store_categories.store_id', '=', 'store_profiles.id');

        $getStore = $getStore->join('services', 'services.store_id', '=', 'store_profiles.id');

        $getStore = $getStore->where('store_profiles.store_active_plan', 'business')
            ->orderBy('store_profiles.id', 'DESC')
            ->select('store_profiles.*')
            ->where('store_profiles.store_status', 'active')
            ->where('is_recommended', 'yes')
            ->distinct()
            ->get();

        foreach ($getStore as $row) {
            $row->categories = StoreCategory::where('store_id', $row->id)->get();
            $categories = StoreCategory::where('store_id', $row->id)->groupBy('category_id')->pluck('category_id')->all();
            $row->rating = \BaseFunction::finalRating($row->id);
            $row->ratingCount = \BaseFunction::finalCount($row->id);
            $row->isFavorite = 'false';
            if (Auth::check()) {
                $favor = Favourite::where('user_id', Auth::user()->id)->where('store_id', $row->id)->first();
                if (!empty($favor)) {
                    $row->isFavorite = 'true';
                } else {
                    $row->isFavorite = 'false';
                }
            }
        }
        return view('Front.Cosmetic.recommended', compact('getStore'));

    }

    /**
     * Get EMp Data
     * @param Request $request
     * @return array
     */
    public function getEmployeeData(Request $request)
    {
        $id = $request['emp'];
        $data = StoreEmp::where('id', $id)->first();

        if (file_exists('storage/app/public/store/employee/' . $data['image']) && $data['image'] != '') {
            $data['image'] = URL::to('storage/app/public/store/employee/' . $data['image']);
        } else {
            $data['image'] = URL::to('storage/app/public/default/default-user.png');
        }

        if (!empty($data)) {
            return ['status' => 'true', 'data' => $data];
        } else {
            return ['status' => 'false', 'data' => []];
        }
    }

    /**
     * Get service value data
     * @param Request $request
     * @return array
     */
    public function getServiceValueData(Request $request)
    {
        $id = $request['emp'];


        $service = Service::leftjoin('store_emp_services', 'store_emp_services.service_id', '=', 'services.id')
            ->where('store_emp_services.store_emp_id', $id)
            ->select('services.*')->get();
        foreach ($service as $row) {
            if (file_exists('storage/app/public/service/' . $row->image) && $row->image != '') {
                $row->image = URL::to('storage/app/public/service/' . $row->image);
            } else {
                $row->image = URL::to('storage/app/public/default/store_default.png');
            }

        }

        if (!empty($service)) {
            return ['status' => 'true', 'data' => $service];
        } else {
            return ['status' => 'false', 'data' => []];
        }
    }

    /**
     * Rating Filter
     * @param Request $request
     * @return array
     */
    public function ratingFilter(Request $request)
    {
        $filter = $request['value'];
        $store = $request['store_id'];

        $feedback = StoreRatingReview::where('store_id', $store);

        if (!empty($filter)) {
            $feedback = $feedback->where('total_avg_rating', '<=', $filter);
        }

        $feedback = $feedback->get();

        foreach ($feedback as $row) {
            if (file_exists(storage_path('app/public/user/' . @$row->userDetails->profile_pic)) && @$row->userDetails->profile_pic != '') {
                $row->profile_pic = URL::to('storage/app/public/user/' . @$row->userDetails->profile_pic);
            } else {
                $row->profile_pic = URL::to('storage/app/public/default/default-user.png');
            }

            $row->user_name = $row->userDetails->first_name . ' ' . $row->userDetails->last_name;
            $row->time = \Carbon\Carbon::parse($row->updated_at)->diffForHumans();
        }

        $keys = array_column($feedback, 'total_avg_rating');
            array_multisort($keys, SORT_DESC, $feedback);

        if (count($feedback) > 0) {
            return ['status' => 'true', 'data' => $feedback];
        } else {
            return ['status' => 'false', 'data' => []];
        }
    }

    /**
     * Get Subcategory
     * @param Request $request
     * @return array
     */
    public function getSubCategory(Request $request)
    {
        $value = $request['value'];

        $category = Category::where('main_category', $value)->where('status', 'active')->get();
        foreach ($category as $row) {

            if (file_exists('storage/app/public/category/' . $row->image) && $row->image != '') {
                $row->images = URL::to('storage/app/public/category/' . $row->image);
                $row->imageFile = file_get_contents(URL::to('storage/app/public/category/' . $row->image));
            } else {
                $row->images = URL::to('storage/app/public/default/store_default.png');
                $row->imageFile = json_decode(file_get_contents(URL::to('storage/app/public/default/store_default.png')));
            }
        }

        if (!empty($category)) {
            return ['status' => 'true', 'data' => $category];
        } else {
            return ['status' => 'false', 'data' => []];
        }
    }

    public function getServiceList(Request $request)
    {
        $category = $request['category'];
        $subCategory = $request['subCategory'];
        $store = $request['store'];


        $service = Service::where('store_id', $store)->where('category_id', $category)
            ->where('subcategory_id', $subCategory)->where('status', 'active')->get();

        foreach ($service as $row) {
            $row->rating = \BaseFunction::finalRatingService($store, $row->id);
            $row->variants = ServiceVariant::where('store_id', $store)->where('service_id', $row->id)->get()->toArray();
        }

        $phtml = '';
        $html = '';

        foreach ($service as $row) {
            $row->minduration = min(array_map(function ($a) {
                return $a["duration_of_service"];
            }, $row->variants));

            $row->maxduration = max(array_map(function ($a) {
                return $a["duration_of_service"];
            }, $row->variants));

            $row->minprice = min(array_map(function ($a) {
                return $a["price"];
            }, $row->variants));
			
			 $row->finalPrice = min(array_map(function ($a) {
                return \BaseFunction::finalPriceVariant($a['service_id'],$a['id']); 
			}, $row->variants));

            $row->image = URL::to("storage/app/public/service/" . $row->image);
            $row->serrating = \BaseFunction::getRatingStar(ceil($row->rating));
            //$row->finalPrice = \BaseFunction::finalPrice($row->id);
            $varint = [];
            foreach ($row->variants as $item) {
                $item['finalPrice'] = \BaseFunction::finalPriceVariant($row->id, $item["id"]);
                $item['price'] = $item['price'];
                $varint[] = $item;
            }
            $row->variants = $varint;
        }

        if (count($service) > 0) {
            return ['status' => 'true', 'data' => $service];
        } else {
            return ['status' => 'false', 'data' => []];
        }
    }

    public function getCategoryTimeslot(Request $request)
    {

        $store = StoreProfile::findorFail($request['store']);
        if (file_exists('storage/app/public/store/' . $store['store_profile']) && $store['store_profile'] != '') {
            $store['store_profile'] = URL::to('storage/app/public/store/' . $store['store_profile']);
        } else {
            $store['store_profile'] = URL::to('storage/app/public/default/default_store.jpeg');
        }

        $category_name = Category::where('id', $request['category'])->first();
        if (file_exists('storage/app/public/category/' . $category_name['image']) && $category_name['image'] != '') {
            $category_name['image'] = URL::to('storage/app/public/category/' . $category_name['image']);
            $category_name['parse_image'] = file_get_contents($category_name['image']);
        } else {
            $category_name['image'] = URL::to('storage/app/public/default/default_store.jpeg');
        }

        $emplist = StoreEmp::leftjoin('store_emp_categories', 'store_emp_categories.store_emp_id', '=', 'store_emps.id')
//            ->join('store_emp_timeslots','store_emp_timeslots.store_emp_id','=','store_emps.id')
            ->where('store_emp_categories.category_id', $request['category'])
            ->where('store_emps.store_id', $request['store'])
            ->select('store_emps.*')
            ->get();

        foreach ($emplist as $row) {
            if (file_exists('storage/app/public/store/employee/' . $row->image) && $row->image != '') {
                $row->image = URL::to('storage/app/public/store/employee/' . $row->image);
            } else {
				$empnameArr = explode(" ", $row->emp_name);
				$empname = "";
				if(count($empnameArr) > 1){
					$empname = strtoupper(substr($empnameArr[0], 0, 1)).strtoupper(substr($empnameArr[1], 0, 1));
				}else{
					$empname = strtoupper(substr($row->emp_name, 0, 2));
				}
				$row->image = "https://via.placeholder.com/150x150/00000/FABA5F?text=".$empname;
                //$row->image = URL::to('storage/app/public/default/default-user.png');
            }
        }
        $date = \Carbon\Carbon::now()->format('Y-m-d');

        $data = array(
            'store' => $store,
            'category' => $category_name,
            'emp_list' => $emplist,
            'date' => $date,
            'totalTime' => $request['time'],
        );

        if (!empty($store)) {
            return ['status' => 'true', 'data' => $data];
        } else {
            return ['status' => 'false', 'data' => []];
        }
    }

    public function getNewTimeslot(Request $request)
    {
        if(isset($request['booking'])){
            $booking = $request['booking'];
        } else {
            $booking = [];
        }
        $time = \BaseFunction::bookingAvailableTime($request['date'], $request['store'], $request['time'], $request['category'],$booking);

        if (count($time) > 0) {
            return ['status' => 'true', 'data' => $time];
        } else {
            return ['status' => 'false', 'data' => []];
        }
    }

    public function getNewTimeslotEmp(Request $request)
    {
        if(isset($request['booking'])){
            $booking = $request['booking'];
        } else {
            $booking = [];
        }

        $time = \BaseFunction::bookingAvailableTimeEmp($request['date'], $request['store'], $request['time'], $request['category'], $request['emp'],$booking);
        $dowMap = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');

        $getdays = StoreEmpTimeslot::where('store_emp_id', $request['emp'])->get();
        $offday = [];
        if (count($getdays) > 0) {
            $getOffDays = StoreEmpTimeslot::where('store_emp_id', $request['emp'])->where('is_off', 'on')->get();
            foreach ($getOffDays as $row) {

                if (in_array($row->day, $dowMap))
                {
                        $offday[] = array_search($row->day, $dowMap);
                }
            }
        } else {
            $offday = [0, 1, 2, 3, 4, 5, 6];
        }

        if (count($time) > 0) {
            return ['status' => 'true', 'data' => $time,'day'=>$offday];
        } else {
            return ['status' => 'false', 'data' => []];
        }
    }

    public function getRatingStar(Request $request)
    {
        $rating = $request['rating'];
        $html = html_entity_decode(\BaseFunction::getRatingStar(ceil($rating)));

        return ['status' => 'true', 'data' => $html];

    }

    public function submitPartner(Request $request){
        $data = $request->all();
		
		$date = \DateTime::createFromFormat('m-d-Y', $data['app_date']);
		$data['app_date']  = $date->format('Y-m-d');;
		
        $partner  = new BecomePartner();
		$partner->fill($data);
		
        if($partner->save()){
			
			 $data = [
				'store_name' => $data['store_name'], 
				'email' => $data['email'], 
				'postal_code' => $data['postal_code'], 
				'phone' => $data['phone_number'], 
				'app_date' => date('m-d-Y', strtotime($data['app_date'])), 
				'app_time' => date('H:i', strtotime($data['app_time'])), 
				'first_name' => $data['first_name'], 
				'last_name' => $data['last_name'], 
				'howtomeet' => $data['howtomeet']
			];
			 try {
                Mail::send('email.become_partner', $data, function ($message) use ($data) {
                    $message->from(env('MAIL_FROM_ADDRESS',"no-reply@reserved4you.de"), env('MAIL_FROM_NAME',"Reserved4you"))->subject('Request to become business partner');
                    $message->to('vertrieb@reserved4you.de');
                });

                return redirect('become-partner');
            } catch (\Swift_TransportException $e) {
                \Log::debug($e);
                 return redirect('become-partner');
            }
            return redirect('become-partner');
        }
    }
}
