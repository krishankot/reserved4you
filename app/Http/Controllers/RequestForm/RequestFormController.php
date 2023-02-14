<?php

namespace App\Http\Controllers\RequestForm;

use App\Http\Controllers\Controller;
use App\Models\Features;
use App\Models\StoreFeatures;
use App\Models\Request\RequestStoreProfile;
use App\Models\Request\RequestStoreTiming;
use App\Models\Request\RequestCustomer;
use App\Models\Request\RequestPaymentMethod;
use App\Models\Request\RequestAdvantage;
use App\Models\Request\RequestStoreCategory;
use App\Models\Request\RequestStoreFeature;
use App\Models\Request\RequestStoreEmp;
use App\Models\Request\RequestStoreEmpLanguages;
use App\Models\Request\RequestStoreEmpCategory;
use App\Models\Request\RequestStoreEmpTimeslot;
use App\Models\Request\RequestStoreService;
use App\Models\Request\RequestStoreSubservice;
use App\Models\Request\RequestStorePortfolioImage;
use App\Models\Request\RequestPublicTransportation;
use App\Models\Category;
use File;
use Auth;

use Illuminate\Http\Request;

class RequestFormController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

	
	public function admin_index(Request $request, $slug){
		$id  = base64_decode($slug);
		
		$RequestStoreProfile  = RequestStoreProfile::with(['storeFeature', 'requestPaymentMethod', 'advantages', 'transportations', 'requestCustomer', 'requestStoreTiming', 'employees'])->where('id', $id)->first();
		$RequestStoreProfile  = json_encode($RequestStoreProfile);
		$dataRequest  = json_decode($RequestStoreProfile, true);
		/* echo "<pre>"; print_r($dataRequest); die; */
		
		$store_categories  = RequestStoreCategory::where('request_store_id', $id)->pluck('category_id')->toArray();
		$feature_of_the_store  = RequestStoreFeature::where('request_store_id', $id)->pluck('feature_id')->toArray();
		$payment_method  = RequestPaymentMethod::where('request_store_id', $id)->pluck('payment_method')->toArray();
		
		$dataRequest['store_category']  =  $store_categories;
		$dataRequest['feature_of_the_store']  =  $feature_of_the_store;
		$dataRequest['payment_method']  =  $payment_method;
		$dataRequest   = array_merge($dataRequest, $dataRequest['request_customer']);
		
		$features = Features::where('status','active')->pluck('name','id')->all();
		$countries = array('Germany' => 'Germany');
		
		$languages = array("Arabisch" => "Arabisch", "Englisch" => "Englisch", "Französisch" => "Französisch", "Deutsch" => "Deutsch", "Russisch" => "Russisch", "Spanisch" => "Spanisch", "Türkisch" => "Türkisch", "Vietnamesisch" => "Vietnamesisch", "Chinesisch" => "Chinesisch", "Japanisch" => "Japanisch", "Italienisch" => "Italienisch");
		$category = Category::where('status', 'active')->orderBy('name', 'ASC')->whereNull('main_category')->pluck('name', 'id')->toArray();
		$categoriesArr = Category::whereNull('main_category')->where('status', 'active')->get();
		return view('Admin.RequestForm.index', compact('dataRequest', 'features', 'countries', 'languages', 'category', 'categoriesArr', 'slug'));
	}
	
	
	
	
	public function admin_step2(Request $request, $slug){
		$id  = base64_decode($slug);
		
		$RequestStoreProfile  = RequestStoreProfile::with(['service'])->where('id', $id)->first();
		$RequestStoreProfile  = json_encode($RequestStoreProfile);
		$dataRequest  = json_decode($RequestStoreProfile, true);
		//echo "<pre>"; print_r($dataRequest); die; 
		$store_categories  = RequestStoreCategory::where('request_store_id', $id)->pluck('category_id')->toArray();
		$categories = Category::whereNull('main_category')->whereIn('id', $store_categories)->where('status', 'active')->pluck('name', 'id')->toArray();
		
		$subcategories =  ['' => 'Unterkategorie wählen'];
		
		return view('Admin.RequestForm.step2', compact('categories', 'subcategories', 'dataRequest', 'slug'));
	}
	
	public function admin_step3(Request $request, $slug){
		$id  = base64_decode($slug);
		
		$RequestStoreProfile  = RequestStoreProfile::with(['portfolios'])->where('id', $id)->select('*', 'store_profile as profile_picture_name', 'store_banner as banner_picture_name')->first();
		$RequestStoreProfile  = json_encode($RequestStoreProfile);
		$dataRequest  = json_decode($RequestStoreProfile, true);
		//echo "<pre>"; print_r($dataRequest); die; 
		
		return view('Admin.RequestForm.step3', compact('dataRequest', 'slug'));
	}
	
	public function download($filename, $folder = null){
		$file = storage_path('app/public/'.$folder.'/'.$filename);
		if($file and file_exists($file)){
			header('Content-type: application/octet-stream');
			header('Content-Disposition: attachment; filename="' . $filename . '"');
			readfile($file);
			exit;		
		}else{
			return back();
		}
	}
	
	
	public function admin_step4(Request $request, $slug){
		$id  = base64_decode($slug);
		
		$RequestStoreProfile  = RequestStoreProfile::where('id', $id)->first();
		$RequestStoreProfile  = json_encode($RequestStoreProfile);
		$dataRequest  = json_decode($RequestStoreProfile, true);
		
		return view('Admin.RequestForm.step4', compact('dataRequest', 'slug'));
	}
	
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    { 
		$dataRequest = array();
		if($request->isMethod('post')){
			$dataRequest = $request->all();
			
			if ($request->file('customer_image')) {
				
				if(!empty($dataRequest['customer_image_name']) && file_exists('storage/app/public/requestFormTemp/'.$dataRequest['customer_image_name'])){
					unlink(storage_path('app/public/requestFormTemp/'.$dataRequest['customer_image_name']));
				}
				$file = $request->file('customer_image');
				$filename = 'reqcust' . uniqid() . '.' . $file->getClientOriginalExtension();
				$file->move(storage_path('app/public/requestFormTemp/'), $filename);
				$dataRequest['customer_image_name'] = $filename;
				unset($dataRequest['customer_image']);
			}
			
			if ($request->file('customer_data_file')) {
				if(!empty($dataRequest['customer_data']) && file_exists('storage/app/public/req_cust_data/'.$dataRequest['customer_data'])){
					unlink(storage_path('app/public/req_cust_data/'.$dataRequest['customer_data']));
				}
				$file = $request->file('customer_data_file');
				$filename = 'reqcust' . uniqid() . '.' . $file->getClientOriginalExtension();
				$file->move(storage_path('app/public/req_cust_data/'), $filename);
				$dataRequest['customer_data'] = $filename;
				unset($dataRequest['customer_data_file']);
			}
			
			if ($request->file('employee_data_file')) {
				if(!empty($dataRequest['employee_data']) && file_exists('storage/app/public/req_cust_data/'.$dataRequest['employee_data'])){
					unlink(storage_path('app/public/req_cust_data/'.$dataRequest['employee_data']));
				}
				$file = $request->file('employee_data_file');
				$filename = 'reqemp' . uniqid() . '.' . $file->getClientOriginalExtension();
				$file->move(storage_path('app/public/req_cust_data/'), $filename);
				$dataRequest['employee_data'] = $filename;
				unset($dataRequest['employee_data_file']);
			}
			
			if ($request->file('advantage_data_file')) {
				if(!empty($dataRequest['advantage_data']) && file_exists('storage/app/public/req_cust_data/'.$dataRequest['advantage_data'])){
					unlink(storage_path('app/public/req_cust_data/'.$dataRequest['advantage_data']));
				}
				$file = $request->file('advantage_data_file');
				$filename = 'reqadv' . uniqid() . '.' . $file->getClientOriginalExtension();
				$file->move(storage_path('app/public/req_cust_data/'), $filename);
				$dataRequest['advantage_data'] = $filename;
				unset($dataRequest['advantage_data_file']);
			}
			
			foreach($dataRequest['employees'] as $k=>$employees){
				if(!empty($employees['profile_image'])){
					
					if ($request->file('employees.'.$k.'.profile_image')) {
						
						if(!empty($dataRequest['employees'][$k]['imagename']) && file_exists('storage/app/public/requestFormTemp/'.$dataRequest['employees'][$k]['imagename'])){
							unlink(storage_path('app/public/requestFormTemp/'.$dataRequest['employees'][$k]['imagename']));
						}
						$file = $request->file('employees.'.$k.'.profile_image');
						$filename = 'req-emp' . uniqid() . '.' . $file->getClientOriginalExtension();
						$file->move(storage_path('app/public/requestFormTemp/'), $filename);
						$dataRequest['employees'][$k]['imagename'] = $filename;
						unset($dataRequest['employees'][$k]['profile_image']);
					}
				}
			}
			$request->session()->put('STEP1', $dataRequest);
			
			
			/* $RequestStoreProfile = RequestStoreProfile::create($dataRequest);
			if($RequestStoreProfile){
				$request_store_id = $RequestStoreProfile->id;
				$dataRequest['request_store_id'] = $request_store_id;
				$RequestCustomer = RequestCustomer::create($dataRequest);
				$paymentmethods = !empty($dataRequest['payment_method'])?$dataRequest['payment_method']:[];
				foreach($paymentmethods as $val){
					$pdata = array('request_store_id' => $request_store_id, 'payment_method' => $val);
					RequestPaymentMethod::create($pdata);
				}
				
				$i=0;
				$day = $dataRequest['day'];
				$start_time = $dataRequest['start_time'];
				$end_time = $dataRequest['end_time'];
				foreach ($day as $item) {

					$dayData['request_store_id'] = $request_store_id;
					$dayData['day'] = $item;
					if ($start_time[$i] == '' || $start_time[$i] == null && $end_time[$i] == '' ||  $end_time[$i] == null) {
						$dayData['is_off'] = 'on';
					} else {
						$dayData['is_off'] = null;
					}
					$dayData['start_time'] = $start_time[$i];
					$dayData['end_time'] = $end_time[$i];

					$dayStore = new RequestStoreTiming();
					$dayStore->fill($dayData);
					$dayStore->save();
					$i++;
				}
				if(!empty($dataRequest['feature_of_the_store'])){
					$features = $dataRequest['feature_of_the_store'];
					foreach($features as $val){
						$fdata = array('request_store_id' => $request_store_id, 'feature_id' => $val);
						RequestStoreFeature::create($fdata);
					}
				}
				$advantages = !empty($dataRequest['advantages'])?$dataRequest['advantages']:[];
				foreach($advantages as $val){
					if(!empty($val['title'])){
						$fdata = array('request_store_id' => $request_store_id, 'title' =>$val['title'], 'description' =>$val['description']);
						RequestAdvantage::create($fdata);
					}
				}
				
				$store_category = !empty($dataRequest['store_category'])?$dataRequest['store_category']:[];
				foreach($store_category as $val){
					$fdata = array('request_store_id' => $request_store_id, 'category_name' => $val);
					RequestStoreCategory::create($fdata);
				}
				
				$employees = $dataRequest['employees'];
				foreach($employees as $key=>$val){
					$emp_data = $val;
					
					$emp_data['request_store_id'] = $request_store_id;
					$RequestStoreEmp = RequestStoreEmp::create($emp_data);
					if($RequestStoreEmp){
						$emp_id = $RequestStoreEmp->id;
						$emplanguages = !empty($val['languages'])?$val['languages']:[];
						foreach($emplanguages as $lang){
							$langdata = ['request_store_id' => $request_store_id, 'emp_id' => $emp_id, 'languages' => $lang];
							RequestStoreEmpLanguages::create($langdata);
						}
						
						$empcategories = !empty($val['categories'])?$val['categories']:[];
						foreach($empcategories as $cat){
							$catdata = ['store_emp_id' => $emp_id, 'category_id' => $cat];
							RequestStoreEmpCategory::create($catdata);
						}
						
						$i=0;
						$day = $val['day'];
						$start_time = $val['start_time'];
						$end_time = $val['end_time'];
						foreach ($day as $item) {

							$dayData['store_emp_id'] = $emp_id;
							$dayData['day'] = $item;
							if ($start_time[$i] == '' || $start_time[$i] == null && $end_time[$i] == '' ||  $end_time[$i] == null) {
								$dayData['is_off'] = 'on';
							} else {
								$dayData['is_off'] = null;
							}
							$dayData['start_time'] = $start_time[$i];
							$dayData['end_time'] = $end_time[$i];

							$dayStore = new RequestStoreEmpTimeslot();
							$dayStore->fill($dayData);
							$dayStore->save();
							$i++;
						}
					}
				}
			} */
			
			return redirect('anforderungsformular/2');
		}
		
		if($request->session()->has('STEP1')){
			$dataRequest = $request->session()->get('STEP1');
		}
		//echo "<pre>"; print_r($dataRequest); die;
		
		$features = Features::where('status','active')->pluck('name','id')->all();
		$countries = array('Germany' => 'Germany');
		$languages = array("Arabisch" => "Arabisch", "Englisch" => "Englisch", "Französisch" => "Französisch", "Deutsch" => "Deutsch", "Russisch" => "Russisch", "Spanisch" => "Spanisch", "Türkisch" => "Türkisch", "Vietnamesisch" => "Vietnamesisch", "Chinesisch" => "Chinesisch", "Japanisch" => "Japanisch", "Italienisch" => "Italienisch");
		$category = Category::where('status', 'active')->orderBy('name', 'ASC')->whereNull('main_category')->pluck('name', 'id')->toArray();
		$categoriesArr = Category::whereNull('main_category')->where('status', 'active')->get();
		
		return view('RequestForm.index', compact('dataRequest', 'features', 'countries', 'languages', 'category', 'categoriesArr'));
    }

	public function step2(Request $request)
    {
		if(!$request->session()->has('STEP1')){
			return redirect('anforderungsformular/1');
		}
		$step1 = $request->session()->get('STEP1');
		$store_category = !empty($step1['store_category'])?$step1['store_category']:[];
		$dataRequest = array();
		if($request->isMethod('post')){
			$dataRequest = $request->all();
			foreach($dataRequest['service'] as $k=>$service){
				if(!empty($service['image'])){
					if ($request->file('service.'.$k.'.image')) {
						if(!empty($dataRequest['service'][$k]['imagename']) && file_exists('storage/app/public/requestFormTemp/'.$dataRequest['service'][$k]['imagename'])){
							unlink(storage_path('app/public/requestFormTemp/'.$dataRequest['service'][$k]['imagename']));
						}
						$file = $request->file('service.'.$k.'.image');
						$filename = 'req-service' . uniqid() . '.' . $file->getClientOriginalExtension();
						$file->move(storage_path('app/public/requestFormTemp/'), $filename);
						$dataRequest['service'][$k]['imagename'] = $filename;
						unset($dataRequest['service'][$k]['image']);
					}
				}
			}
			if ($request->file('service_data_file')) {
				if(!empty($dataRequest['service_data']) && file_exists('storage/app/public/req_cust_data/'.$dataRequest['service_data'])){
					unlink(storage_path('app/public/req_cust_data/'.$dataRequest['service_data']));
				}
				$file = $request->file('service_data_file');
				$filename = 'reqservice' . uniqid() . '.' . $file->getClientOriginalExtension();
				$file->move(storage_path('app/public/req_cust_data/'), $filename);
				$dataRequest['service_data'] = $filename;
				unset($dataRequest['service_data_file']);
			}
			$request->session()->put('STEP2', $dataRequest);
			return redirect('anforderungsformular/3');
		}
		if($request->session()->has('STEP2')){
			$dataRequest = $request->session()->get('STEP2');
		}
		
		$categories = Category::whereNull('main_category')->whereIn('id', $store_category)->where('status', 'active')->pluck('name', 'id')->toArray();
		
		$subcategories =  ['' => 'Unterkategorie wählen'];
		return view('RequestForm.step2', compact('categories', 'subcategories', 'dataRequest'));
    }
	
	public function step3(Request $request)
    {
		if(!($request->session()->has('STEP1') and $request->session()->has('STEP2'))){
			return redirect('anforderungsformular/2');
		} 
		$dataRequest = array();
		if($request->isMethod('post')){
			
			$dataRequest = $request->all();
			
			if ($request->file('profile_picture')) {
				if(!empty($dataRequest['profile_picture_name']) && file_exists('storage/app/public/requestFormTemp/'.$dataRequest['profile_picture_name'])){
					unlink(storage_path('app/public/requestFormTemp/'.$dataRequest['profile_picture_name']));
				}
				$file = $request->file('profile_picture');
				$filename = 'req-portfolio' . uniqid() . '.' . $file->getClientOriginalExtension();
				$file->move(storage_path('app/public/requestFormTemp/'), $filename);
				$dataRequest['profile_picture_name'] = $filename;
				unset($dataRequest['profile_picture']);
			}
			/* elseif(!empty($dataRequest['profile_picture_drag'])){
				define('UPLOAD_DIR', 'images/');
					$img = $dataRequest['profile_picture_drag'];
					$img = str_replace('data:image/png;base64,', '', $img);
					$img = str_replace(' ', '+', $img);
					$data = base64_decode($img);
					$file = 'req-portfolio' . uniqid() .'.png';
					$success = file_put_contents(storage_path('app/public/requestFormTemp/'.$file , $data);
					$dataRequest['profile_picture_name'] = $filename;
					unset($dataRequest['profile_picture_drag']);
			} */
			
			if ($request->file('banner_picture')) {
				if(!empty($dataRequest['banner_picture_name']) && file_exists('storage/app/public/requestFormTemp/'.$dataRequest['banner_picture_name'])){
					unlink(storage_path('app/public/requestFormTemp/'.$dataRequest['banner_picture_name']));
				}
				$file = $request->file('banner_picture');
				$filename = 'req-portfolio' . uniqid() . '.' . $file->getClientOriginalExtension();
				$file->move(storage_path('app/public/requestFormTemp/'), $filename);
				$dataRequest['banner_picture_name'] = $filename;
				unset($dataRequest['banner_picture']);
			}
			
			if ($request->file('portfolio_image')) {
				unset($dataRequest['portfolio_image']);
			}
			if ($request->old_photo) {
				unset($dataRequest['old_photo']);
			}
			/* foreach($dataRequest['portfolio_image'] as $k=>$portfolio_image){
				if(!empty($portfolio_image['image'])){
					
					if ($request->file('portfolio_image.'.$k.'.image')) {
						if(!empty($dataRequest['portfolio_image'][$k]['imagename']) && file_exists('storage/app/public/requestFormTemp/'.$dataRequest['portfolio_image'][$k]['imagename'])){
							unlink(storage_path('app/public/requestFormTemp/'.$dataRequest['portfolio_image'][$k]['imagename']));
						}
						$file = $request->file('portfolio_image.'.$k.'.image');
						$filename = 'req-portfolio' . uniqid() . '.' . $file->getClientOriginalExtension();
						$file->move(storage_path('app/public/requestFormTemp/'), $filename);
						$dataRequest['portfolio_image'][$k]['imagename'] = $filename;
						unset($dataRequest['portfolio_image'][$k]['image']);
					}
				}
			} */
			$request->session()->put('STEP3', $dataRequest);
			return redirect('anforderungsformular/4');
		}
		if($request->session()->has('STEP3')){
			$dataRequest = $request->session()->get('STEP3');
		}
		$portfolios = array();
		if($request->session()->has('PORTFOLIO')){
			$portfolios = $request->session()->get('PORTFOLIO');
		}
		//echo "<pre>"; print_r($dataRequest); die;
		return view('RequestForm.step3',  compact('dataRequest', 'portfolios'));
    }
	
	
	
	public function upload_request_portfolio(Request $request){
		$uploadedfiles = array(); $addedFiles = array();
		if($request->session()->has('PORTFOLIO')){
			$uploadedfiles = $request->session()->get('PORTFOLIO');
		}
		if($request->isMethod('post')){
			$dataRequest = $request->all();
			
			$files  = $request->file('portfolio_image');
			
			foreach($files as $k=>$file){
				if(!empty($file)){
					$filename = 'req-portfolio' . uniqid() . '.' . $file->getClientOriginalExtension();
					$file->move(storage_path('app/public/requestFormTemp/'), $filename);
					/* $dataRequest['portfolio_image'][$k]['imagename'] = $filename;
					unset($dataRequest['portfolio_image'][$k]['image']); */
					$uploadedfiles[] = $filename;
					$addedFiles[] = $filename;
				}
			}
			$request->session()->put('PORTFOLIO', $uploadedfiles);
		}
		
		 return response()->json(['ResponseCode' => 1, 'ResponseData' => $addedFiles], 200);
	}
	
	
	public function remove_req_portfolio(Request $request){
		$image = $request->get('image');
		$filesize = 0;
		if($request->session()->has('PORTFOLIO')){
			$uploadedfiles = $request->session()->get('PORTFOLIO');
			if (($key = array_search($image, $uploadedfiles)) !== false) {
				unset($uploadedfiles[$key]);
			}
			if(!empty($image) && file_exists('storage/app/public/requestFormTemp/'.$image)){
				$filesizeByte = filesize('storage/app/public/requestFormTemp/'.$image);
				$filesize = number_format($filesizeByte/(1024*1024), 2);
				unlink(storage_path('app/public/requestFormTemp/'.$image));
			}
			$request->session()->put('PORTFOLIO', $uploadedfiles);
		}
		
		return response()->json(['ResponseCode' => 1, 'ResponseData' => $filesize], 200);
	}
	
	public function step4(Request $request)
    {
		if(!($request->session()->has('STEP1') and $request->session()->has('STEP2') and $request->session()->has('STEP3'))){
			return redirect('anforderungsformular/3');
		}
		if($request->isMethod('post')){
			$dataRequest = $request->all();
			$request->session()->put('STEP4', $dataRequest);
			
			$request_store_id = "";
			if($request->session()->has('STEP1')){
				$stepData1 = $request->session()->get('STEP1');
				$request_store_id = $this->saveValueStep1($stepData1);
			}
			
			if($request_store_id && $request->session()->has('STEP2')){
				$stepData2 = $request->session()->get('STEP2');
				$this->saveValueStep2($stepData2, $request_store_id);
			}
			
			if($request_store_id && $request->session()->has('STEP3')){
				$stepData3 = $request->session()->get('STEP3');
				$portfolio_image = array();
				if($request->session()->has('PORTFOLIO')){
					$portfolio_image = $request->session()->get('PORTFOLIO');
				}
				$this->saveValueStep3($stepData3, $request_store_id, $portfolio_image);
			}
			if($request_store_id && $request->session()->has('STEP4')){
				$RequestStoreProfile  = RequestStoreProfile::find($request_store_id);
				$accepted_terms      = !empty($dataRequest['agree_terms_conditions'])?$dataRequest['agree_terms_conditions']:0;
				$google_ratings      = !empty($dataRequest['google_ratings'])?$dataRequest['google_ratings']:'no';
				$RequestStoreProfile->update(['accepted_terms' => $accepted_terms, 'google_ratings' => $google_ratings]);
			}
			$request->session()->forget(['STEP1', 'STEP2', 'STEP3', 'STEP4', 'PORTFOLIO']);
			return redirect('anforderungsformular/abschluss')->with('message', 'Your request for store has been submitted, Business Executive will reach to you soon.');
		}
		return view('RequestForm.step4');
    }
	
	
	public function success(){
		return view('RequestForm.thanks');
	}
	
	public function add_req_employee(Request $request){
		$i = $request->get('rel');
		$countries = array('Germany' => 'Germany');
		$languages = array("Arabisch" => "Arabisch", "Englisch" => "Englisch", "Französisch" => "Französisch", "Deutsch" => "Deutsch", "Russisch" => "Russisch", "Spanisch" => "Spanisch", "Türkisch" => "Türkisch", "Vietnamesisch" => "Vietnamesisch", "Chinesisch" => "Chinesisch", "Japanisch" => "Japanisch", "Italienisch" => "Italienisch");
		$category = Category::where('status', 'active')->whereNull('main_category')->orderBy('name', 'ASC')->pluck('name', 'id')->toArray();
		
		return view('RequestForm/employees', ['i' => $i, 'category' => $category, 'languages' => $languages, 'countries' => $countries])->render();
	}
	
	public function add_req_advantages(Request $request){
		$i = $request->get('rel');
		return view('RequestForm/advantages', ['i' => $i])->render();
	}
	
	public function add_req_transportations(Request $request){
		$i = $request->get('rel');
		return view('RequestForm/transportations', ['i' => $i])->render();
	}
	
	public function add_req_portfolio(Request $request){
		$i = $request->get('rel');
		
		return view('RequestForm/portfolio_image', ['i' => $i])->render();
	}
	
	
	
	public function add_req_services(Request $request){
		$i = $request->get('rel');
		$step1 = $request->session()->get('STEP1');
		$store_category = !empty($step1['store_category'])?$step1['store_category']:[];
		$categories = Category::whereNull('main_category')->whereIn('id', $store_category)->where('status', 'active')->pluck('name', 'id')->toArray();
		$subcategories =  ['' => 'Unterkategorie wählen'];
		$dataRequest = array();
		if($request->session()->has('STEP2')){
			$dataRequest = $request->session()->get('STEP2');
		}
		return view('RequestForm/services', ['i' => $i, 'categories' => $categories, 'subcategories' => $subcategories, 'dataRequest' => $dataRequest])->render();
	}
	
	public function add_req_subservices(Request $request){
		$s = $request->get('rel');
		$i = $request->get('service_id');
		$dataRequest = array();
		if($request->session()->has('STEP2')){
			$dataRequest = $request->session()->get('STEP2');
		}
		return view('RequestForm/subservices', ['i' => $i, 's' => $s, 'dataRequest' => $dataRequest])->render();
	}
	
	
	function saveValueStep1($dataRequest){
		
		$request_store_id = "";
		$RequestStoreProfile = RequestStoreProfile::create($dataRequest);
		if($RequestStoreProfile){
			$request_store_id = $RequestStoreProfile->id;
			$dataRequest['request_store_id'] = $request_store_id;
			$customerData  = $dataRequest;
			$customerData['image'] = !empty($dataRequest['customer_image_name'])?$dataRequest['customer_image_name']:NULL;
			$RequestCustomer = RequestCustomer::create($customerData);
			$paymentmethods = !empty($dataRequest['payment_method'])?$dataRequest['payment_method']:[];
			foreach($paymentmethods as $val){
				$pdata = array('request_store_id' => $request_store_id, 'payment_method' => $val);
				RequestPaymentMethod::create($pdata);
			}
			
			$i=0;
			$day = $dataRequest['day'];
			$start_time = $dataRequest['start_time'];
			$end_time = $dataRequest['end_time'];
			foreach ($day as $item) {

				$dayData['request_store_id'] = $request_store_id;
				$dayData['day'] = $item;
				if ($start_time[$i] == '' || $start_time[$i] == null && $end_time[$i] == '' ||  $end_time[$i] == null) {
					$dayData['is_off'] = 'on';
				} else {
					$dayData['is_off'] = null;
				}
				$dayData['start_time'] = $start_time[$i];
				$dayData['end_time'] = $end_time[$i];

				$dayStore = new RequestStoreTiming();
				$dayStore->fill($dayData);
				$dayStore->save();
				$i++;
			}
			if(!empty($dataRequest['feature_of_the_store'])){
				$features = $dataRequest['feature_of_the_store'];
				foreach($features as $val){
					$fdata = array('request_store_id' => $request_store_id, 'feature_id' => $val);
					RequestStoreFeature::create($fdata);
				}
			}
			$advantages = !empty($dataRequest['advantages'])?$dataRequest['advantages']:[];
			foreach($advantages as $val){
				if(!empty($val['title'])){
					$fdata = array('request_store_id' => $request_store_id, 'title' =>$val['title'], 'description' =>$val['description']);
					RequestAdvantage::create($fdata);
				}
			}
			
			$transportations = !empty($dataRequest['transportations'])?$dataRequest['transportations']:[];
			foreach($transportations as $val){
				if(!empty($val['title'])){
					$fdata = array('request_store_id' => $request_store_id, 'title' =>$val['title'], 'transportation_no' =>$val['transportation_no']);
					RequestPublicTransportation::create($fdata);
				}
			}
			
			$store_category = !empty($dataRequest['store_category'])?$dataRequest['store_category']:[];
			$categoriesArr = Category::whereNull('main_category')->where('status', 'active')->pluck('name', 'id')->toArray();
			foreach($store_category as $val){
				$catname  = !empty($categoriesArr[$val])?$categoriesArr[$val]:NULL;
				$fdata = array('request_store_id' => $request_store_id, 'category_id' => $val, 'category_name' => $catname);
				RequestStoreCategory::create($fdata);
			}
			
			$employees = $dataRequest['employees'];
			foreach($employees as $key=>$val){
				$emp_data = $val;
				
				$emp_data['request_store_id'] = $request_store_id;
				$emp_data['image']  = !empty($val['imagename'])?$val['imagename']:NULL;
				$RequestStoreEmp = RequestStoreEmp::create($emp_data);
				if($RequestStoreEmp){
					$emp_id = $RequestStoreEmp->id;
					$emplanguages = !empty($val['languages'])?$val['languages']:[];
					foreach($emplanguages as $lang){
						$langdata = ['request_store_id' => $request_store_id, 'emp_id' => $emp_id, 'languages' => $lang];
						RequestStoreEmpLanguages::create($langdata);
					}
					
					$empcategories = !empty($val['categories'])?$val['categories']:[];
					foreach($empcategories as $cat){
						$catdata = ['store_emp_id' => $emp_id, 'category_id' => $cat];
						RequestStoreEmpCategory::create($catdata);
					}
					
					$i=0;
					$day = $val['day'];
					$start_time = $val['start_time'];
					$end_time = $val['end_time'];
					foreach ($day as $item) {

						$dayData['store_emp_id'] = $emp_id;
						$dayData['day'] = $item;
						if ($start_time[$i] == '' || $start_time[$i] == null && $end_time[$i] == '' ||  $end_time[$i] == null) {
							$dayData['is_off'] = 'on';
						} else {
							$dayData['is_off'] = null;
						}
						$dayData['start_time'] = $start_time[$i];
						$dayData['end_time'] = $end_time[$i];

						$dayStore = new RequestStoreEmpTimeslot();
						$dayStore->fill($dayData);
						$dayStore->save();
						$i++;
					}
				}
			}
		}
		return $request_store_id;
	}
	
	
	
	function saveValueStep2($dataRequest, $request_store_id){
		if($dataRequest &&  $request_store_id){
			$services = !empty($dataRequest['service'])?$dataRequest['service']:[];
			if(!empty($dataRequest['service_data'])){
				$service_data = $dataRequest['service_data'];
				RequestStoreProfile::where('id', $request_store_id)->update(['service_data' => $service_data]);
			}
			foreach($services as $val){
				if(!empty($val['service_name'])){
					
					$Sdata						 = $val;
					$Sdata['request_store_id'] 	 = $request_store_id;
					$Sdata['image'] 	         = !empty($val['imagename'])?$val['imagename']:NULL;
					$RequestStoreService = RequestStoreService::create($Sdata);
					if($RequestStoreService){
						if(!empty($val['sub_service'])){
							$subservices = $val['sub_service'];
							
							foreach($subservices as $row){
								
								if(!empty($row['subservice'])){
									$SSdata						 = $row;
									$SSdata['request_store_id'] 	 = $request_store_id;
									$SSdata['request_store_service_id'] 	 = $RequestStoreService->id;
									
									RequestStoreSubservice::create($SSdata);
								}
							}
							
						}
						
					}
				}
			}
		}
		return true;
	}
	
	function saveValueStep3($dataRequest, $request_store_id, $portfolio_image){
		if($dataRequest &&  $request_store_id){
			$RequestStoreProfile  = RequestStoreProfile::find($request_store_id);
			if(!empty($dataRequest['profile_picture_name']) OR !empty($dataRequest['banner_picture_name'])){
				$store_profile  = !empty($dataRequest['profile_picture_name'])?$dataRequest['profile_picture_name']:NULL;
				$store_banner  = !empty($dataRequest['banner_picture_name'])?$dataRequest['banner_picture_name']:NULL;
				$RequestStoreProfile->update(['store_profile' => $store_profile, 'store_banner' => $store_banner]);
			}
			
			if($portfolio_image){
				foreach($portfolio_image as $val){
					if(!empty($val)){
						$Sdata						 = array();
						$Sdata['request_store_id'] 	 = $request_store_id;
						$Sdata['image_name'] 	     = $val;
						RequestStorePortfolioImage::create($Sdata);
					}
				}
			}
		}
		return true;
	}

}
