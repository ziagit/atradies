<?php
use App\PrivacyPage;
use Illuminate\Support\Facades\Auth;
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
Route::get('test','TestController@index');
Route::resource("services", "Admin\Jobs\ServiceController");
Route::get('get-services','Admin\Jobs\ServiceController@getService');
Route::resource("types", "Admin\Jobs\TypeController");
Route::resource("steps", "Admin\Jobs\StepController");
Route::get("search-step", "Admin\Jobs\StepController@search");

Route::get("steps-services", "Admin\Jobs\StepController@services");
Route::resource("options", "Admin\Jobs\OptionController");
Route::get("search-option", "Admin\Jobs\OptionController@search");

Route::get("options-steps/{service_id}", "Admin\Jobs\OptionController@steps");

Route::post('forgot-password', 'Auth\ResetPasswordController@forgot');
Route::post('reset-password', 'Auth\ResetPasswordController@reset');
Route::get("unauthorized", function () {
  return response()->json(['message' => 'You are unauthorized!'], 401);
})->name('unauthorized');

Route::group(['prefix' => 'auth', 'namespace' => 'Auth'], function () {
  Route::post('signin', 'SignInController')->name('signin');
  Route::post('signup', 'SignUpController');
});
Route::get('about-us', 'AboutController@aboutUs');

Route::group(['middleware' => 'auth:api'], function () {
  Route::group(['namespace' => 'Auth', 'prefix' => 'auth'], function () {
    Route::get('me', 'MeController');
    Route::post('signout', 'SignOutController');
    Route::get('read-notification/{id}', 'NotificationController@show');
  });
  Route::group(['namespace' => 'Carrier', 'prefix' => 'carrier'], function () {
    Route::resource('details', 'CarrierDetailsController');
    Route::resource('accessories', 'AccessoryController');
    Route::get('accessories-lookup', 'AccessoryController@accessories');
    Route::resource('rates', 'RateController');
    Route::get('search-rate', 'RateController@search');
    Route::resource('account', 'CarrierAccountController');
    Route::get('card', 'CarrierCardController@index');

    Route::resource('jobs', 'JobController');
    Route::get('job-status', 'JobController@jobStatus');

    Route::post('rate-carrier','CarrierDetailsController@rate');

  });
  Route::group(['namespace' => 'Shipper', 'prefix' => 'shipper'], function () {
    Route::resource('details', 'ShipperDetailsController');
    Route::resource('account', 'ShipperAccountController');
    Route::resource('orders', 'ShipperOrderController');
    Route::get('order-status', 'ShipperOrderController@status');
    Route::get("card-details", 'CardController@getCustomer');
    Route::get('shipper-address', "ShipperAccountController@shipperAddress");
  });

  Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => 'role'], function () {
    Route::resource('about', 'Company\AdminAboutController');
    Route::resource('terms', 'Company\AdminTermsController');
    Route::resource('privacy', 'Company\AdminPrivacyController');
    Route::resource('carrier-faq', 'Company\AdminCarrierFAQController');
    Route::resource('shipper-faq', 'Company\AdminShipperFAQController');
    Route::resource('countries', 'AdminCountryController');
    Route::get('search-country', 'AdminCountryController@search');
    Route::resource('states', 'AdminStateController');
    Route::get('search-state', 'AdminStateController@search');
    Route::resource('cities', 'AdminCityController');
    Route::get('search-city', 'AdminCityController@search');
    Route::resource('zips', 'AdminZipController');
    Route::get('search-zip', 'AdminZipController@search');
    Route::resource('addresses','AdminAddressController');
    Route::get('search-address','AdminAddressController@search');

    Route::resource('users', 'AdminUserController');
    Route::get('search-user', 'AdminUserController@search');
    Route::resource('carriers', 'AdminCarrierController');
    Route::get('search-carrier', 'AdminCarrierController@search');
    Route::resource('accessories', 'AdminAccessoryController');
    Route::get('search-accessory', 'AdminAccessoryController@search');
    Route::resource('rates', 'AdminRateController');
    Route::get('search-rates', 'AdminRateController@search');
    Route::resource('shippers', 'AdminShipperController');
    Route::get('search-shipper', 'AdminShipperController@search');
    Route::resource('orders', 'AdminOrderController');
    Route::get('search-order', 'AdminOrderController@search');
    Route::resource('contact', 'Company\AdminContactController');
    Route::resource('services', 'Company\AdminServiceController');
    Route::get('search-service', 'Company\AdminServiceController@search');

    Route::resource('carrier/accessories', 'AdminCarrierAccessoryController');
    Route::delete('carrier/accessories/{cId}/{aId}', 'AdminCarrierAccessoryController@destroy');
    Route::get('carrier/search-accessory', 'AdminCarrierAccessoryController@search');
    Route::resource('carrier/rates', 'AdminCarrierRateController');
    Route::resource('customer/addresses','AdminCustomerAddressController');

    Route::resource('rate-ranges','AdminRaterangeController');
    Route::get('search-rate-range','AdminRaterangeController@search');

    Route::post('upload-cities', 'AdminImportFileController@uploadCities')->name('uploadCities');
    Route::post('upload-addresses', 'AdminImportFileController@uploadAddresses')->name('uploadAddresses');
    Route::post('upload-zips', 'AdminImportFileController@uploadZips')->name('uploadZips');
  });
  Route::group(['namespace' => 'Order'], function () {
    Route::post('charge-customer', 'CheckoutController@chargeCustomer');
  });
});

Route::group(['namespace' => 'Order'], function () {
  
  Route::post('charge', 'CheckoutController@store');
  Route::get('payment-status/{orderId}', 'CheckoutController@checkPayment');
  Route::get("check-payment/{id}", 'CheckoutController@checkPayment');
  
  Route::get('get-not-selected-services', 'OrderController@getNotSelectedService');
  Route::post('set-selected-services', 'OrderController@setSelectedService');
  Route::delete("shipper/service/delete/{id}","OrderController@destroyService");


  Route::get('get-services', 'OrderController@services');
  Route::post('filter-services','OrderController@filterService');
  Route::get('get-options/{id}', 'OrderController@options');
  Route::get('delivery-services', 'OrderController@deliveryServices');
  Route::get('pick-date', 'OrderController@pickDate');
  Route::get('item-type', 'OrderController@itemType');
  Route::get('item-condition', 'OrderController@itemCondition');

  Route::post('carriers-rate', 'CalculatorController@calculator')->name('carriers-rate');

  Route::post('confirm', 'ShipmentController@store')->name('confirm');
  Route::get('shipment-details/{id}', 'ShipmentController@show');
  Route::get('carrier-contacts/{id}', 'ShipmentController@carrierContacts');
  Route::get('step-option/{step_id}','OrderController@stepOption');
});
Route::group(['namespace' => 'Location'], function () {
  Route::resource('countries', 'CountryController');
  Route::get('addresses', 'AddressController@index');
  Route::get('search-state/{country}','AddressController@searchState');
  Route::get('search-city/{state}','AddressController@searchCity');
});
Route::resource('rating', 'Carrier\RatingController');
Route::resource('review', 'Carrier\ReviewController');








