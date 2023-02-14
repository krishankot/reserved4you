<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
/**
 * Customer route.
 */
Route::group(['namespace' => 'Api\User','prefix'=>'v1/user/'],function(){
    Route::group(['namespace' => 'Auth'], function () {
        Route::post('guest-user', 'AuthenticationController@guestUser');
        Route::post('login', 'AuthenticationController@authentication');
        Route::post('register', 'AuthenticationController@register');
        Route::post('forgot-password', 'AuthenticationController@forgotPassword');
        Route::POST('social-login', 'AuthenticationController@socialLogin');
		Route::post('verify-email', 'AuthenticationController@verifyEmail');
		Route::post('resend-email', 'AuthenticationController@resendEmail');
		Route::post('email-exist', 'AuthenticationController@email_exist');
		

        Route::group(['middleware' => 'ApiAuth'], function () {
            Route::get('logout', 'AuthenticationController@logout');
            Route::POST('change-password','AuthenticationController@changePassword');
            Route::get('delete-user-profile','AuthenticationController@deleteUserProfile');            
        });

    });

    Route::group(['namespace' => 'User','middleware' => 'ApiAuth'], function () {
        Route::get('get-user-profile', 'UserController@index');
		
        Route::post('update-user-profile', 'UserController@updateProfile');
		Route::post('update-profile-picture', 'UserController@updateProfilePicture');
        //add user address
        Route::get('address-list','UserController@list');
        Route::post('add-address','UserController@store');
        Route::post('update-address','UserController@update');
        Route::post('delete-address','UserController@destroy');
		Route::post('notifications', 'UserController@notification');
		Route::post('allow-notification', 'UserController@allowNotification');
        Route::post('delete-profile-picture', 'UserController@delete_profile_picture');
		Route::post('customer-profile', 'UserController@customerProfileRequest');
		Route::get('static-pages', 'UserController@staticPages');
    });
    Route::get('choose-service', 'User\UserController@selectService');
	
    //,'middleware' => 'ApiAuth'
    Route::group(['namespace' => 'ServiceProvider','middleware' => 'ApiAuth'], function () {
        Route::get('get-service-provider-list', 'ServiceProviderController@index');
        Route::post('get-service-provider-list', 'ServiceProviderController@serviceProviderView');        
        Route::post('store-wise-category','ServiceProviderController@storeCategory');
        Route::post('cate-wise-subcategory','ServiceProviderController@categoryWiseSubCategory');
        Route::post('store-category-services','ServiceProviderController@storeCategoryServices');
        Route::post('store-employee','ServiceProviderController@storeEmployee');
        Route::POST('filter','ServiceProviderController@filterService');
        //user for fileter screen
        Route::get('all-category','ServiceProviderController@allCategoryList');

        Route::post('all-service','ServiceProviderController@allService');
        Route::post('all-store','ServiceProviderController@allStore');
        Route::post('all-recommended-store','ServiceProviderController@allRecommendedStore');

        //store-suggestion
        Route::post('store-suggestion','ServiceProviderController@storeSuggetion');       

        //sorting
        Route::post('service-short-by', 'ServiceProviderController@shortBy');

        //view service details
        Route::post('show-service-details','ServiceProviderController@serviceView');
        Route::post('store-service-search','ServiceProviderController@storeServiceSearch');
        Route::post('cate-subcate-service','ServiceProviderController@categorySubcategoryWiseService');

        Route::post('view-all-emp-review','ServiceProviderController@viewAllReview');
        Route::post('view-review-by-emp-id','ServiceProviderController@viewReviewByEmpId');

        //subcategory wise services
        Route::post('get-subcate-service','ServiceProviderController@getSubcategoryWiseService');
        
    });
    Route::get('get-specifics','ServiceProvider\ServiceProviderController@getSpecifics');
    //conatact us 
    Route::group(['namespace' => 'Contactus','middleware' =>'ApiAuth'],function (){
        Route::post('contact-us','ContactUsController@store');
    });

    //Favourites 
    Route::group(['namespace' => 'Favourites','middleware' =>'ApiAuth'],function (){        
        Route::POST('favorites-list','FavouritesController@list');
        Route::POST('add-store-favorites','FavouritesController@store');
        Route::POST('remove-store-favorites','FavouritesController@removeFavourite');
    });

    //Booking
    //,'middleware' =>'ApiAuth'
    Route::group(['namespace' => 'Booking','middleware' =>'ApiAuth'],function (){                
        Route::POST('get-service-expert-details','BookingController@serviceExpertDetails');                             
        Route::POST('booking-time-available','BookingController@bookingTimeAvailable'); 
        Route::post('store-booking-available-time-direct', 'BookingController@getAvailableTimeDirect');     
        Route::post('get-available-emp-service', 'BookingController@getAvailableEmpService');      
    });

    //Payment
    Route::group(['namespace' => 'PaymentDetails','middleware' =>'ApiAuth'],function (){ 
        Route::POST('withdraw-payment','PaymentController@withdrawPayment');
		Route::POST('reschedule-appointment','PaymentController@rescheduleAppointment');  
    });
    Route::get('/paypal/cancel', 'PaymentDetails\PaymentController@cancel');
    Route::get('/paypal/payment/success', 'PaymentDetails\PaymentController@success');
    Route::get('karla-payment-success', 'PaymentDetails\PaymentController@klarnaSuccess');   
    
    //temporary select service route
    Route::post('store-select-service','PaymentDetails\PaymentController@selectService');
    Route::post('store-cancel-service','PaymentDetails\PaymentController@cancelService');
    Route::post('get-select-service','PaymentDetails\PaymentController@getSelectedServices');
    Route::post('update-checkout-data','PaymentDetails\PaymentController@updateCheckoutData');
    Route::post('clear-selection-store','PaymentDetails\PaymentController@clearSelectionItemStore');
    //My Order
    //, 'middleware' => 'ApiAuth'
    Route::group(['namespace' => 'MyOrder','middleware' =>'ApiAuth'],function (){
        Route::get('my-order-list','OrderController@orderList');
        Route::post('order-date-postponed','OrderController@orderDatePostPoned');
        Route::post('order-cancellation-reason','OrderController@orderCancellationReason');
        Route::post('get-user-appointment-day-month','OrderController@appointmentDayMonth');
        Route::post('get-booking-details','OrderController@getBookingDetails');
    });

    //customer review
    Route::group(['namespace' => 'CustomerReview','middleware' =>'ApiAuth'],function (){
        Route::post('store-feed-back','ReviewController@storeFeedBack'); 
        //user rating for store
        Route::post('user-store-rating','ReviewController@userRating');
        Route::post('feedback-store-details','ReviewController@getDetailsStore');
        Route::post('sort-by-review','ReviewController@sortByReview');
        Route::post('filter-by-review','ReviewController@filterByReview');
        Route::get('get-user-reviews','ReviewController@userReviews');        
    });

});

//Service provider route.
Route::group(['namespace' => 'Api\ServiceProvider','prefix'=>'v1/provider/'],function(){

    Route::group(['namespace' => 'Auth'], function () {
        Route::post('login', 'AuthController@login');        
        Route::post('forgot-password', 'AuthController@forgotPassword');
        

        Route::group(['middleware' => 'ProviderAuth'], function () {
            Route::get('all-stores','AuthController@providerAllStore');
            Route::get('logout', 'AuthController@logout');
        });

    });

    //dashbord
    Route::group(['namespace' => 'Dashboard','middleware' => 'ProviderAuth'], function () {
        Route::get('dashboard', 'DashboardController@dashboard');
		Route::get('notifications', 'DashboardController@notifications');
		Route::get('notifications-count', 'DashboardController@notification_count');
		Route::get('notifications-count-increase', 'DashboardController@notification_count_increase');
    });

    //service list
    Route::group(['namespace' => 'ServiceList','middleware' => 'ProviderAuth'], function () {
        Route::POST('service-list', 'ServiceListController@serviceList');
		Route::POST('service-detail', 'ServiceListController@serviceDetail');
        Route::GET('service-list-category', 'ServiceListController@serviceListCategory');
        Route::POST('service-add', 'ServiceListController@serviceStore');
		Route::GET('service-edit', 'ServiceListController@serviceEdit');
        Route::POST('service-edit', 'ServiceListController@serviceUpdate');
        Route::POST('service-delete', 'ServiceListController@serviceDelete');
        Route::POST('variant-delete', 'ServiceListController@serviceVariantDelete');
        Route::post('store-service-category','ServiceListController@storeCategory');
		Route::post('store-service-subcategory','ServiceListController@storeServiceSubCategory');
		Route::get('store-services', 'ServiceListController@storeServices');
		Route::post('cate-subcate-service','ServiceListController@categorySubcategoryWiseService');
		Route::post('store-select-service','ServiceListController@selectService');
		Route::post('store-cancel-service','ServiceListController@cancelService');
		Route::post('get-selected-service','ServiceListController@getSelectedServices');
		Route::post('update-checkout-data','ServiceListController@updateCheckoutData');
		Route::post('clear-selection-store','ServiceListController@clearSelectionItemStore');
    });

    //Employee list save and update 
    Route::group(['namespace' => 'Employee','middleware' => 'ProviderAuth'], function () {
        Route::POST('employee-list', 'EmployeeListController@employeeList');
        Route::POST('employee-add', 'EmployeeListController@employeeStore');        
        Route::POST('employee-view', 'EmployeeListController@employeeView');   
		Route::GET('employee-edit', 'EmployeeListController@employeeEdit');		
        Route::POST('employee-edit', 'EmployeeListController@employeeUpdate');
        Route::POST('employee-delete', 'EmployeeListController@employeeDelete');
		 Route::POST('add-break-hours', 'EmployeeListController@addBreakHours');
		Route::get('employee-dropdowns','EmployeeListController@empDropdowns');

        //store category and service route
        Route::post('store-category','EmployeeListController@storeCategory');
        Route::post('store-service','EmployeeListController@storeService');
    });

    //Appoinment list 
    Route::group(['namespace' => 'Appointment','middleware' => 'ProviderAuth'], function () {
        Route::POST('appointment-list', 'AppointmentController@appointmentList');        
        Route::POST('order-list', 'AppointmentController@orderList');        
        Route::POST('appointment-date-postponed', 'AppointmentController@appointmentDatePostponed');        
        Route::POST('appointment-cancel', 'AppointmentController@appointmentCancel');    
		Route::get('create-appointment', 'AppointmentController@createAppointment');    
       
        Route::post('add-new-appoinment','AppointmentController@providerAddNewAppoinment');
        Route::post('get-store-employee','AppointmentController@getEmployee');
     
		Route::post('review-request', 'AppointmentController@reviewRequest');
		
		Route::post('get-cate-time-slots', 'AppointmentController@getCategoryTimeslot');
		
    });
	
	 Route::group(['namespace' => 'Booking','middleware' => 'ProviderAuth'], function () {
		 Route::POST('booking-time-available-provider','BookingController@bookingTimeAvailable'); 
		 Route::post('store-booking-available-time-direct', 'BookingController@getAvailableTimeDirectStore'); 
	     Route::post('get-available-emp-service', 'BookingController@getAvailableEmpService');
		 Route::post('proceed-to-pay', 'BookingController@proceedToPay');
		 Route::post('checkout-payment', 'BookingController@checkoutPayment');
		 Route::post('order-confirmed', 'BookingController@orderConfirmation');
		 Route::post('book-again', 'BookingController@bookAgain');
	});

    //My Wallet route 
    Route::group(['namespace' => 'MyWallet','middleware' => 'ProviderAuth'], function () {
        Route::post('wallet-details','WalletController@walletDetails');
    });    

    //Store Profile Route
    Route::group(['namespace' => 'StoreProfile','middleware' =>'ProviderAuth'],function(){
        Route::get('get-store-detail','StoreProfileController@getStoreDetails');
		Route::get('get-store-gallery','StoreProfileController@getStoreGallery');
		Route::get('get-store-general-detail','StoreProfileController@getStoreDetailsGeneral');
        Route::POST('update-store-detail','StoreProfileController@updateStore');
        Route::POST('update-store-gallery','StoreProfileController@updateStoreGallery');        
        Route::POST('delete-store-gallery-image','StoreProfileController@deleteGalleryImage');
		Route::POST('add-advantages','StoreProfileController@addAdvantages');
		Route::POST('add-advantages','StoreProfileController@addAdvantages');
		Route::post('remove-advantages', 'StoreProfileController@removeAdvantages');
        Route::post('add-transportation', 'StoreProfileController@addTransporation');
        Route::post('remove-transportation', 'StoreProfileController@removeTransporation');
		Route::post('remove-store-feature', 'StoreProfileController@removeStoreFeature');
		Route::post('update-store-detail-general','StoreProfileController@updateOtherDetails');
		Route::get('get-store-overview','StoreProfileController@getStoreProfileOverview');
		Route::get('get-store-overview-about','StoreProfileController@getStoreProfileOverviewAbout');
    });

    //feedbak route
    Route::group(['namespace'=>'FeedBacks','middleware' =>'ProviderAuth'],function(){
        Route::get('store-rating','FeedBackController@storeRating'); 
		Route::post('store-review-detail','FeedBackController@getReviewDetails');
		Route::post('update-review-reply','FeedBackController@updatetReviewReply');
    });
	
	 //settings route
    Route::group(['namespace'=>'Setting','middleware' =>'ProviderAuth'],function(){
        Route::get('contact-info','SettingController@contactInfo'); 
		Route::get('help','SettingController@help');
		Route::get('static-content', 'SettingController@staticContent');
		Route::get('store-plans', 'SettingController@plans');
		Route::get('skeys', 'SettingController@keys');
    });
	
	 //customers route
    Route::group(['namespace' => 'Customer','middleware' => 'ProviderAuth'], function () {
        Route::GET('customer-list', 'CustomerController@customerList');
        Route::POST('customer-add', 'CustomerController@customerStore');        
        Route::POST('customer-view', 'CustomerController@customerView');   
		Route::GET('customer-edit', 'CustomerController@customerEdit');		
        Route::POST('customer-edit', 'CustomerController@customerUpdate');
        Route::POST('customer-delete', 'CustomerController@customerDelete');
		Route::POST('send-customer-request', 'CustomerController@sendRequest');
		Route::GET('customer-notes', 'CustomerController@customerNotesView');
		Route::GET('customer-notes-add', 'CustomerController@customerNotesAdd');
		Route::GET('customer-notes-edit', 'CustomerController@customerNotesEdit');
		Route::POST('customer-notes-store', 'CustomerController@customerNotesStore');
		Route::GET('customer-dropdownlist', 'CustomerController@customerDropdownList');
		Route::POST('customer-import', 'CustomerController@importCustomers');
    });
	
	 //statistic route
    Route::group(['namespace' => 'Statistics','middleware' => 'ProviderAuth'], function () {
        Route::GET('statistics', 'StatisticsController@index');
		Route::GET('statistics-day-data', 'StatisticsController@getDayData');
		Route::GET('statistics-week-data', 'StatisticsController@getWeekData');
		Route::GET('statistics-month-data', 'StatisticsController@getMonthData');
		Route::GET('statistics-year-data', 'StatisticsController@getYearData');
    });
	
	 //calendar route
    Route::group(['namespace' => 'Calendar','middleware' => 'ProviderAuth'], function () {
		 Route::GET('calendar', 'CalendarController@calendar');
		 Route::GET('calendar-month-view', 'CalendarController@calendarMonthView');
		 Route::GET('appointment-popup-detail', 'CalendarController@AppointmentDetail');
    });
	
});



