<?php

use Dingo\Api\Routing\Router;
use Illuminate\Http\Request;
use App\Http\Requests;
//use Illuminate\Routing\Router;

/** @var Router $api */
$api = app(Router::class);
//

$api->version('v1', function (Router $api) {
  $api->group(['prefix' => 'auth'], function(Router $api) {
    $api->post('signup', 'App\\Api\\V1\\Controllers\\SignUpController@signUp');
    $api->post('login', 'App\\Api\\V1\\Controllers\\LoginController@login');

    $api->post('recovery', 'App\\Api\\V1\\Controllers\\ForgotPasswordController@sendResetEmail');
    $api->post('reset', 'App\\Api\\V1\\Controllers\\ResetPasswordController@resetPassword');

    Route::get("fetchCities","CityManagementController@getCities");

		Route::get("fetchStores","StoresManagementController@getStores");
		Route::post("addEditStore","StoresManagementController@addEditStore");
		Route::post("deleteStore","StoresManagementController@deleteStore");

		$api->get("fetchbrands","App\\Http\\Controllers\\BrandsManagementController@getBrands");
		Route::post("addEditBrand","BrandsManagementController@addEditBrand");
		Route::post("deleteBrand","BrandsManagementController@deleteBrand");

		Route::get("fetchoffers","OffersManagementController@getoffers");
		Route::post("addEditOffer","OffersManagementController@addEditOffer");
		Route::post("deleteOffer","OffersManagementController@deleteOffer");
		Route::post("searchOffer","OffersManagementController@searchOfferByFields");
		Route::post("fetchSearchSuggestions","OffersManagementController@searchSuggestion");

		Route::get("fetchAds","AdsManagementController@getAds");
		Route::post("addEditAd","AdsManagementController@addEditAd");
		Route::post("deleteAd","AdsManagementController@deleteAd");
  });

  $api->group(['middleware' => 'jwt.auth'], function(Router $api) {
    $api->get('protected', function() {
      return response()->json([
                  'message' => 'Access to protected resources granted! You are seeing this text as you provided the token correctly.'
      ]);
    });

    $api->resource('books', 'App\Api\V1\Controllers\BookController');

  });

  $api->get('refresh', function(Request $Request) {
    $input=$Request->all();
        $token = $input['Token'];

   if(!$token){
    $Err['status']='error';
    $Err['msg']='There is no token';
    return response()
    ->json($Err, 200, ['Content-type'=> 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE| JSON_PRETTY_PRINT);

    }

    try{
        $token = JWTAuth::refresh($token);

  }catch (JWTException $e) {
    $ERR['status']='error';
    $ERR['MSG']= "the was erorr on you token ";
    return response()
    ->json($ERR, 200, ['Content-type'=> 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE| JSON_PRETTY_PRINT);

            }

     $Sucss['status']='success';
     $Sucss['token']= $token;
     return response()
    ->json($Sucss, 200, ['Content-type'=> 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE| JSON_PRETTY_PRINT);

      });

  $api->get('hello', function() {
    return response()->json([
                'message' => 'This is a simple example of item returned by your APIs. Everyone can see it.'
    ]);
  });
});
