<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', 'Frontend\Cosmetic\IndexController@index');

/* Route::get('/', function () {
    return view('Front.Cosmetic.becomePartner');
}); */
Route::get('/', 'Frontend\Cosmetic\IndexController@index')->middleware('HtmlMinifier');
Route::get('cosmetic', 'Frontend\Cosmetic\IndexController@index');

Route::get('geschaeftspartner', function () {
    return view('Front.Cosmetic.becomePartner');
});

Route::post('submit-partner','Frontend\Cosmetic\IndexController@submitPartner');

Route::get('get_sub_cat', 'Frontend\Cosmetic\IndexController@getSubCat');
Route::get('get_stores', 'Frontend\Cosmetic\IndexController@getStores');

Route::get('get-rates', 'Frontend\Cosmetic\IndexController@getRates');
Route::get('rate-shorting', 'Frontend\Cosmetic\IndexController@ratesShortig');

Route::get('kosmetik-bereiche/{slug}', 'Frontend\Cosmetic\IndexController@cosmeticArea')->name('cosmeticArea');
Route::post('kosmetik-bereiche', 'Frontend\Cosmetic\IndexController@search')->name('kosmetic.search');
Route::get('kosmetik-bereiche', 'Frontend\Cosmetic\IndexController@search')->name('kosmetic.search');
Route::post('sort-data', 'Frontend\Cosmetic\IndexController@sortData');
Route::post('filter-data', 'Frontend\Cosmetic\IndexController@filterData');
Route::get('kosmetik/{slug}', 'Frontend\Cosmetic\IndexController@cosmeticView');
Route::post('service-filter', 'Frontend\Cosmetic\IndexController@filter');
Route::post('service-short-by', 'Frontend\Cosmetic\IndexController@shortBy');
Route::post('get-employee', 'Frontend\Cosmetic\IndexController@getEmployee');
Route::post('get-employee-list', 'Frontend\Cosmetic\IndexController@getEmployeeList');
Route::post('get-datepicker', 'Frontend\Cosmetic\IndexController@getDatepicker');
Route::post('get-timeslot', 'Frontend\Cosmetic\IndexController@getTimeslot');
Route::post('get-available-time', 'Frontend\Cosmetic\IndexController@getAvailableTime');
Route::post('get-available-time-direct', 'Frontend\Cosmetic\IndexController@getAvailableTimeDirect');
Route::post('get-available-emp', 'Frontend\Cosmetic\IndexController@getAvailableEmp');
Route::post('get-service-details', 'Frontend\Cosmetic\IndexController@getServiceDetails');
Route::post('get-booking-data', 'Frontend\Cosmetic\IndexController@getBookingData');
Route::post('get-service-data', 'Frontend\Cosmetic\IndexController@getServiceData');
Route::post('get-search-data', 'Frontend\Cosmetic\IndexController@searchBar');
Route::post('get-search-service', 'Frontend\Cosmetic\IndexController@searchBarSearvice');
Route::post('get-sub-category', 'Frontend\Cosmetic\IndexController@getSubCategory');
Route::get('recommended-for-you', 'Frontend\Cosmetic\IndexController@recommendedYou');
Route::post('get-service-list', 'Frontend\Cosmetic\IndexController@getServiceList');

/**
 * new urls STart
 */
Route::post('checkout', 'Frontend\Payment\PaymentController@processToPay');
Route::get('checkout-prozess', 'Frontend\Payment\PaymentController@letCheckOut');
Route::post('get-category-timeslot', 'Frontend\Cosmetic\IndexController@getCategoryTimeslot');
Route::post('get-new-timeslot', 'Frontend\Cosmetic\IndexController@getNewTimeslot');
Route::post('get-new-timeslot-emp', 'Frontend\Cosmetic\IndexController@getNewTimeslotEmp');
Route::post('update-checkout-data', 'Frontend\Payment\PaymentController@updateCheckoutData');
Route::get('zahlungsabschluss', 'Frontend\Payment\PaymentController@proceedToPay');
Route::get('buchungsbestaetigung', 'Frontend\Payment\PaymentController@orderConfirmation');
Route::post('remove-service', 'Frontend\Payment\PaymentController@removeService');
Route::post('get-rating-star', 'Frontend\Cosmetic\IndexController@getRatingStar');
Route::post('reschedule-appointment', 'Frontend\Payment\PaymentController@rescheduleAppointment');

/**
 * New Urls End
 */

Route::post('get-employee-data', 'Frontend\Cosmetic\IndexController@getEmployeeData');
Route::post('get-service-value-data', 'Frontend\Cosmetic\IndexController@getServiceValueData');
Route::post('rating-filter', 'Frontend\Cosmetic\IndexController@ratingFilter');


Route::get('kosmetik-deine-vorteile', function () {
    return view('Front.Cosmetic.cosmeticAdvantages');
});

Route::get('auth/google', 'Frontend\AuthController@redirectToGoogle');
Route::get('auth/google/callback', 'Frontend\AuthController@handleGoogleCallback');

Route::get('auth/facebook', 'Frontend\AuthController@redirectToFacebook');
Route::get('auth/facebook/callback', 'Frontend\AuthController@handleFacebookCallback');


Route::post('user-login', 'Frontend\AuthController@doLogin');
Route::post('user-register', 'Frontend\AuthController@doRegister');
Route::post('user-forgot', 'Frontend\AuthController@forgotPassword');
Route::get('aktiviere-deinen-account/{slug}', 'Frontend\AuthController@activate_account');
Route::any('reset-passwort/{slug?}', 'Frontend\AuthController@resetPassword')->name('resetPassword');

Route::group(['as' => 'users.', 'middleware' => 'UserAuth'], function () {
    Route::get('kundenprofil', 'Frontend\User\UserController@index')->name('profile');
    Route::get('kunden-logout', 'Frontend\AuthController@logout')->name('logout');
    Route::post('update-profile', 'Frontend\User\UserController@updateProfile');
    Route::post('favorite-store', 'Frontend\User\UserController@favoriteStore');
    Route::post('change-profile', 'Frontend\User\UserController@changeProfile');
    Route::post('get-appointment-data', 'Frontend\User\UserController@getAppointmentData');
    Route::post('cancel-appointment', 'Frontend\User\UserController@cancelAppontment');
    Route::post('book-again', 'Frontend\User\UserController@bookAgain');
	Route::get('delete-profile-picture', 'Frontend\User\UserController@delete_profile_picture');

    Route::get('benachrichtigungen', 'Frontend\User\UserController@notification')->name('notifications');
    Route::get('einstellungen', 'Frontend\User\UserController@setting')->name('settings');
    Route::post('change-password', 'Frontend\User\UserController@changePassword');
    Route::post('contact-us', 'Frontend\User\UserController@contactUs');
    Route::get('bewertungen/{slug}', 'Frontend\User\UserController@feedback')->name('feedback');
    Route::post('feedback/get-subcategory', 'Frontend\User\UserController@getSubcategory');
    Route::get('kundenprofil-loeschen', 'Frontend\User\UserController@deleteProfile')->name('deleteProfile');
	Route::get('appointment-detail/find/{id}','Frontend\User\UserController@findAppointment');
	Route::get('kundenprofil/{slug}/{action}', 'Frontend\User\UserController@customerProfile');
	Route::post('allow-notification', 'Frontend\User\UserController@allowNotification')->name('allowNotification');
});

Route::post('submit-rating', 'Frontend\User\UserController@submitRating');

Route::post('submit-payment-booking', 'Frontend\Payment\PaymentController@checkout');

Route::get('/cancel', 'Frontend\Payment\PaymentController@cancel')->name('payment.cancel');
Route::get('/payment/success', 'Frontend\Payment\PaymentController@success')->name('payment.success');
Route::get('/karla-payment-success', 'Frontend\Payment\PaymentController@Karlasuccess')->name('karla.success');

Route::get('apple-pay', 'Frontend\Payment\PaymentController@applePay');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'master-admin', 'namespace' => 'Admin'], function () {
    Route::get('login', 'AuthenticationController@login');
    Route::post('login', 'AuthenticationController@doLogin');
    Route::group(['middleware' => 'AdminAuth'], function () {
        Route::get('/', 'DashboardController@index');

        Route::get('logout', 'AuthenticationController@logout');

        Route::resource('users', 'UserController');
        Route::get('users/{id}/destroy', 'UserController@destroy');
        Route::get('users/{id}/status', 'UserController@statusChange');

        Route::resource('service-provider', 'ServiceProviderController');
        Route::get('service-provider/{id}/destroy', 'ServiceProviderController@destroy');
        Route::get('service-provider/{id}/status', 'ServiceProviderController@statusChange');

        Route::resource('admin', 'AdminController');
        Route::get('admin/{id}/destroy', 'AdminController@destroy');
        Route::get('admin/{id}/status', 'AdminController@statusChange');

        Route::resource('category', 'CategoryController');
        Route::get('category/{id}/destroy', 'CategoryController@destroy');
        Route::get('category/{id}/status', 'CategoryController@statusChange');

        Route::resource('cosmetics-category', 'CosmeticsCategoryController');
        Route::get('cosmetics-category/{id}/destroy', 'CosmeticsCategoryController@destroy');
        Route::get('cosmetics-category/{id}/status', 'CosmeticsCategoryController@statusChange');

        Route::resource('store-profile', 'StoreProfileController');
        Route::get('store-profile/{id}/destroy', 'StoreProfileController@destroy');
        Route::post('store-profile/category', 'StoreProfileController@changeCategory');


        Route::resource('features', 'FeaturesController');
        Route::get('features/{id}/destroy', 'FeaturesController@destroy');

        Route::resource('store-profile/{id}/service', 'ServiceController');
        Route::get('store-profile/{store_id}/service/{id}/destroy', 'ServiceController@destroy');
        Route::post('service/category', 'ServiceController@changeCategory');

        Route::resource('store-profile/{id}/advantages', 'Store\AdvantagesController');
        Route::get('store-profile/{store_id}/advantages/{id}/destroy', 'Store\AdvantagesController@destroy');

        Route::resource('store-profile/{id}/public-transportation', 'Store\PublicTransportationController');
        Route::get('store-profile/{store_id}/public-transportation/{id}/destroy', 'Store\PublicTransportationController@destroy');

        Route::resource('store-profile/{id}/parking', 'Store\ParkingController');
        Route::get('store-profile/{store_id}/parking/{id}/destroy', 'Store\ParkingController@destroy');

        Route::resource('plans', 'PlanController');
        Route::get('plans/{id}/destroy', 'PlanController@destroy');
        Route::get('plans/{id}/status', 'PlanController@statusChange');

        Route::resource('payment-info', 'PaymentController');
        Route::resource('appointment-list', 'AppointmentController');

        Route::resource('features', 'FeaturesController');
        Route::get('features/{id}/destroy', 'FeaturesController@destroy');
        Route::get('features/{id}/status', 'FeaturesController@statusChange');

        Route::resource('contract-list', 'ContractListController');
        Route::get('become-partner', 'ContractListController@partnerList');


        Route::get('calendar','CalendarController@index');
    });

});

Route::get('service-provider/payout/bill/{id}/download/{number}', 'ServiceProvider\SettingController@downloadPayout');
Route::get('service-provider/invoice/{id}/download/{number}/{viewtype?}', 'ServiceProvider\SettingController@downloadInvoice');

Route::group(['prefix' => 'dienstleister', 'namespace' => 'ServiceProvider'], function () {
    Route::get('login', 'AuthenticationController@login');
    Route::get('rechnung/{id}/download/{number}/{viewtype?}', 'SettingController@downloadInvoice')->name('invoice.download');
    Route::get('auszahlung/beleg/{id}/download/{number}/{viewtype?}', 'SettingController@downloadPayout')->name('payout.download');

    Route::group(['middleware' => 'ServiceAuth'], function () {
        Route::get('/', 'DashboardController@index');
        Route::get('logout', 'AuthenticationController@logout');
        Route::get('benachrichtigungen', 'DashboardController@notification');
		
        Route::get('mitarbeiter', 'EmployeeController@index');
        Route::get('mitarbeiter-details/{id}', 'EmployeeController@view');
        Route::get('mitarbeiter-hinzufuegen', 'EmployeeController@add');
        Route::get('mitarbeiter-bearbeiten/{id}', 'EmployeeController@edit');

        Route::get('buchung', 'AppointmentController@index');
        Route::get('buchung-erstellen', 'AppointmentController@create');
        Route::get('checkout-prozess', 'AppointmentController@checkoutData');
        Route::get('zahlungsabschluss', 'AppointmentController@proceedToPay');
        Route::get('buchungsbestaetigung', 'AppointmentController@orderConfirmation');

        Route::get('finanzen', 'WalletController@index');

        Route::get('statistiken', 'StatisticsController@index');

        Route::get('kalender', 'CalenderController@index');

        Route::get('betriebsprofil', 'StoreController@index');
        Route::get('betriebsprofil/ansehen/{id}', 'StoreController@view');

        Route::get('service-hinzufuegen', 'ServiceListController@create');
        Route::get('service-bearbeiten/{id}', 'ServiceListController@editService');

        Route::get('einstellungen', 'SettingController@index');

        Route::get('kunden', 'CustomerController@index');
        Route::get('kunden-hinzufuegen', 'CustomerController@create');
        Route::get('kunden-bearbeiten/{id}', 'CustomerController@edit');
        Route::get('kunden-details/{id}', 'CustomerController@view');
        Route::get('kunden-details/ansehen/{id}', 'CustomerController@viewCustomer');
		Route::post('kunden-import', 'CustomerController@importCustomers')->name('importCustomers');
		Route::get('kunden-download', 'CustomerController@downloadSample')->name('downloadSample');
    });
});

Route::group(['prefix' => 'service-provider', 'namespace' => 'ServiceProvider'], function () {
    Route::post('login', 'AuthenticationController@doLogin');
    Route::post('register', 'AuthenticationController@doRegister');
	 Route::post('service/category', 'ServiceListController@changeCategory');

    Route::group(['middleware' => 'ServiceAuth'], function () {
		Route::post('dashboard-appointment', 'DashboardController@dashboardAppointment');
		Route::post('notification_count', 'DashboardController@notification_count');
		Route::get('ajaxnotificationsread', 'DashboardController@ajaxnotificationsread');

        Route::post('employee/category', 'EmployeeController@getService');
        Route::post('add-employee', 'EmployeeController@addEmployee');
        Route::post('update-employee/{id}', 'EmployeeController@updateEmployee');
        Route::post('remove-employee', 'EmployeeController@removeEmployee');

        Route::post('get-appointment-data', 'AppointmentController@getAppointmentData');
        Route::post('postpond-appointment', 'AppointmentController@postpondAppointment');
        Route::post('cancel-appointment', 'AppointmentController@cancelAppointment');
        Route::post('shorting-appointment', 'AppointmentController@shortingAppointment');

        Route::post('checkout', 'AppointmentController@checkout');
       
        Route::POST('get-category-timeslot', 'AppointmentController@getCategoryTimeslot');
        Route::post('get-new-timeslot', 'AppointmentController@getNewTimeslot');
        Route::post('get-new-timeslot-emp', 'AppointmentController@getNewTimeslotEmp');
        Route::post('update-checkout-data', 'AppointmentController@updateCheckoutData');
        Route::post('submit-payment-booking', 'AppointmentController@checkoutPayment');
      
        Route::post('create-appointment', 'AppointmentController@createAppointment');
        Route::post('book-again', 'AppointmentController@bookAgain');
        Route::post('remove-service', 'AppointmentController@removeService');
		Route::post('review-request', 'AppointmentController@reviewRequest');

        Route::post('statistics/get-day-data', 'StatisticsController@getDayData');
        Route::post('statistics/get-week-data', 'StatisticsController@getWeekData');
        Route::post('statistics/get-month-data', 'StatisticsController@getMonthData');
        Route::post('statistics/get-year-data', 'StatisticsController@getYearData');
		
		Route::post('add-break-hours', 'EmployeeController@add_break_hours');

        Route::post('update-store', 'StoreController@store');
        Route::post('update-other-details', 'StoreController@updateOtherDetails');
        Route::post('update-store-banner', 'StoreController@changeBannerProfile');
        Route::post('update-store-gallery', 'StoreController@changeBannerGallery');
        Route::get('rate-shorting', 'StoreController@ratingShorting');
        Route::post('add-advantages', 'StoreController@addAdvantages');
        Route::post('remove-advantages', 'StoreController@removeAdvantages');
        Route::post('add-transportation', 'StoreController@addTransporation');
        Route::post('remove-transportation', 'StoreController@removeTransporation');
        Route::post('remove-portfolio', 'StoreController@removeImageGallery');
        Route::post('get-subcategory', 'StoreController@getSubCategory');
        Route::post('get-services', 'StoreController@getService');
        Route::post('get-review-details', 'StoreController@getReviewDetails');
        Route::post('venue-replay', 'StoreController@venueReplay');
        Route::post('venue-replay/update', 'StoreController@venueReplayUpdate');

      
        Route::post('/get-service', 'ServiceListController@getService');
       
        Route::post('add-service', 'ServiceListController@addService');
      
        Route::post('update-service', 'ServiceListController@updateService');
        Route::get('remove-service/{id}', 'ServiceListController@removeService');

        Route::post('set-store', 'DashboardController@setSession');
     
        Route::post('change-password', 'SettingController@changePassword');
        Route::post('contact-us', 'SettingController@contactUs');

       
        Route::post('add-customer', 'CustomerController@store');
       
        Route::post('update-customer/{id}', 'CustomerController@update');
        Route::post('delete-customer', 'CustomerController@delete');
      
        Route::post('customer/add-note', 'CustomerController@addNote');
         Route::post('customer/update-note', 'CustomerController@updateNote');
        Route::post('get-customer-details', 'CustomerController@getDetails');
		 Route::post('add-customer-request', 'CustomerController@addRequest');
    });
});

/**
 * Cron Job Urls
 */
Route::get('current-appointment', 'Cron\CronController@activeAppointment');
Route::get('complete-appointment', 'Cron\CronController@completeAppointment');
Route::get('time-slot', 'Cron\CronController@timeSlot');
Route::get('cancel-appointment', 'Cron\CronController@CancelAppointment');
//Route::get('cancel-appointment-testing', 'Cron\CronController@CancelAppointmentTesting');
Route::get('reminder-appointment', 'Cron\CronController@reminderNotification');
Route::get('release-bookingslots', 'Cron\CronController@releaseBookingSlot');

Route::get('find-appointments','ServiceProvider\CalenderController@findAppointments');

Route::get('service-provider/appointment-detail/find/{id}','ServiceProvider\CalenderController@findAppointment');
Route::get('service-provider/appointment/detail/{id?}','ServiceProvider\CalenderController@appointmentForDetail');

/**
 Static Footer Pages
**/

Route::get('impressum', 'PageController@imprint')->name('imprint');
Route::get('datenschutz', 'PageController@datenschutz')->name('datenschutz');
Route::get('allgemeinegeschaeftsbedingungen', 'PageController@terms_and_conditions')->name('agb');
Route::get('test-notification', 'PageController@testnotifications')->name('testnotifications');


/**
	Request Form
**/

Route::any('anforderungsformular/1', 'RequestForm\RequestFormController@index');
Route::any('anforderungsformular/2', 'RequestForm\RequestFormController@step2');
Route::any('anforderungsformular/3', 'RequestForm\RequestFormController@step3');
Route::any('anforderungsformular/4', 'RequestForm\RequestFormController@step4');
Route::any('anforderungsformular/abschluss', 'RequestForm\RequestFormController@success');
Route::any('add-req-employee', 'RequestForm\RequestFormController@add_req_employee')->name('add_req_employee');
Route::any('add-req-advantages', 'RequestForm\RequestFormController@add_req_advantages')->name('add_req_advantages');
Route::any('add-req-portfolio', 'RequestForm\RequestFormController@add_req_portfolio')->name('add_req_portfolio');
Route::any('remove-req-portfolio', 'RequestForm\RequestFormController@remove_req_portfolio')->name('remove_req_portfolio');
Route::any('add-req-services', 'RequestForm\RequestFormController@add_req_services')->name('add_req_services');
Route::any('add-req-subservices', 'RequestForm\RequestFormController@add_req_subservices')->name('add_req_subservices');
Route::any('upload-req-portfolio', 'RequestForm\RequestFormController@upload_request_portfolio')->name('upload_request_portfolio');
Route::any('add-req-transportations', 'RequestForm\RequestFormController@add_req_transportations')->name('add_req_transportations');


Route::get('admin/request-form/s1/{id}', 'RequestForm\RequestFormController@admin_index');
Route::get('admin/request-form/s2', 'RequestForm\RequestFormController@admin_step2');
Route::get('admin/request-form/s3', 'RequestForm\RequestFormController@admin_step3');
Route::get('admin/request-form/s4', 'RequestForm\RequestFormController@admin_step4');

Route::get('admin/request-form/s1/{id}', 'RequestForm\RequestFormController@admin_index')->name('admin_request_step1');
Route::get('admin/request-form/s2/{id}', 'RequestForm\RequestFormController@admin_step2')->name('admin_request_step2');
Route::get('admin/request-form/s3/{id}', 'RequestForm\RequestFormController@admin_step3')->name('admin_request_step3');
Route::get('admin/request-form/s4/{id}', 'RequestForm\RequestFormController@admin_step4')->name('admin_request_step4');
Route::get('admin/download/{filename}/{file}', 'RequestForm\RequestFormController@download')->name('admin_download');