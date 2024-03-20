<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/sellerLogin', '\App\Http\Controllers\AuthController@sellerLogin');
Route::post('/buyerLogin', '\App\Http\Controllers\AuthController@buyerLogin');
Route::post('/forgot', '\App\Http\Controllers\AuthController@forgetpassword');
Route::get('/verifyemail/{token}', '\App\Http\Controllers\AuthController@token_check');
Route::get('signup/verifyemail', '\App\Http\Controllers\AuthController@verifyToken');
Route::post('/reset', '\App\Http\Controllers\AuthController@reset_password');
Route::post('/adminLogin', '\App\Http\Controllers\AuthController@adminLogin');
Route::post('/sellerRegister', 'App\Http\Controllers\AuthController@sellerRegister');
Route::post('/buyerRegister', 'App\Http\Controllers\AuthController@buyerRegister');


Route::group(['middleware' => ['auth:sanctum']], function(){ 
    Route::group(['prefix' => 'admin', 'middleware' => 'api.admin'], function () {
        Route::apiResource('/profile', 'App\Http\Controllers\Admin\ProfileController');
        Route::post('/changePassword', 'App\Http\Controllers\Admin\ProfileController@passwordChange');
        Route::apiResource('/buyerBrokerPlans', 'App\Http\Controllers\Admin\BuyerBrokerPlanController');
        Route::apiResource('/sellerBrokerPlans', 'App\Http\Controllers\Admin\SellerBrokerPlanController');
        Route::apiResource('/paymentMethods', 'App\Http\Controllers\Admin\PaymentMethodController');
        Route::apiResource('/buyers', 'App\Http\Controllers\Admin\BuyerController');
        Route::post('buyers/changeStatus', 'App\Http\Controllers\Admin\BuyerController@changeStatus');
        Route::apiResource('/sellers', 'App\Http\Controllers\Admin\SellerController');
        Route::post('sellers/changeStatus', 'App\Http\Controllers\Admin\SellerController@changeStatus');
        Route::apiResource('/properties', 'App\Http\Controllers\Admin\PropertyController');
        Route::post('properties/changeStatus', 'App\Http\Controllers\Admin\PropertyController@changeStatus');
        Route::apiResource('/exposedRequest', 'App\Http\Controllers\Admin\ExposeRequestController');
        Route::apiResource('/investorProfile', 'App\Http\Controllers\Admin\InvestorProfileController');
    });
    Route::group(['prefix' => 'seller', 'middleware' => 'api.seller'], function () {
        Route::apiResource('/profile', 'App\Http\Controllers\Seller\ProfileController');
        Route::post('/changePassword', 'App\Http\Controllers\Seller\ProfileController@passwordChange');
        Route::apiResource('/plans', 'App\Http\Controllers\Seller\PlanController');
        Route::apiResource('/paymentMethods', 'App\Http\Controllers\Seller\PaymentMethodController');
        Route::apiResource('/subscriptions', 'App\Http\Controllers\Seller\SubscriptionController');
        Route::apiResource('/properties', 'App\Http\Controllers\Seller\PropertyController');
        Route::post('properties/changeStatus', 'App\Http\Controllers\Seller\PropertyController@changeStatus');
        Route::apiResource('/exposedRequest', 'App\Http\Controllers\Seller\ExposeRequestController');
    });
    Route::group(['prefix' => 'buyer', 'middleware' => 'api.buyer'], function () {
        Route::apiResource('/profile', 'App\Http\Controllers\Buyer\ProfileController');
        Route::post('/changePassword', 'App\Http\Controllers\Buyer\ProfileController@passwordChange');
        Route::apiResource('/plans', 'App\Http\Controllers\Buyer\PlanController');
        Route::apiResource('/paymentMethods', 'App\Http\Controllers\Buyer\PaymentMethodController');
        Route::apiResource('/subscriptions', 'App\Http\Controllers\Buyer\SubscriptionController');
        Route::apiResource('/properties', 'App\Http\Controllers\Buyer\PropertyController');
        Route::apiResource('/exposedRequest', 'App\Http\Controllers\Buyer\ExposeRequestController');
        Route::apiResource('/investorProfile', 'App\Http\Controllers\Buyer\InvestorProfileController');
        Route::apiResource('/wishList', 'App\Http\Controllers\Buyer\WishListController');
    });
});
