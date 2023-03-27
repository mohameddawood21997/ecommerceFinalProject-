<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use  App\Http\Controllers\Api\User\AuthController;
use  App\Http\Controllers\Api\User\ResetPasswordController;
use  App\Http\Controllers\Api\User\ForgetPasswordController;
use  App\Http\Controllers\Api\Admin\AdminAuthController;
use  App\Http\Controllers\Api\OrderController;
use  App\Http\Controllers\Api\products\ProductController;
use  App\Http\Controllers\Api\products\UpdateProductController;
use  App\Http\Controllers\Api\UserCardController;
use  App\Http\Controllers\Api\FavoriteController;
use  App\Http\Controllers\Api\CategoryController;
use  App\Http\Controllers\Api\MessageController;
use  App\Http\Controllers\Api\StripePaymentController;



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
    return Auth::user();
});

Route::middleware('auth:admin-api')->get('/admin', function (Request $request) {
    return Auth::user('admin-api');
});
Route::get('test',function(){
    return 'test';
})->middleware('auth:admin-api');
//////////users/////////

Route::group(['prefix'=>'users'], function(){

       Route::get('show', [AuthController::class,'show']);
       Route::post('register',[AuthController::class,'register']);
       Route::post('logout',[AuthController::class,'userLogout'])->middleware('auth:api');


       ////////////////////////////////////////////////////////  //

       Route::post('resetPassword',[ResetPasswordController::class,'resetPassword']);
       Route::post('forgetPassword',[ForgetPasswordController::class,'forgetPassword']);

       ///////////////////////////////////////////
    //  Route::put('update/{id}',[AuthController::class,'update']);   //
       Route::delete('delete/{id}',[AuthController::class,'delete']);
       Route::post('login',[AuthController::class,'login']);         //
       Route::post('addToCart',[UserCardController::class,'addToCart'])->middleware('auth:api');   //
       Route::get('showUserCard',[UserCardController::class,'showUserCard'])->middleware('auth:api');  //
       Route::post('deleteFromCart/{productId}',[UserCardController::class,'deleteFromCart']);        //
       Route::post('addToFavorite',[FavoriteController::class,'addToFavorite'])->middleware('auth:api');  //
       Route::get('showFavorite',[FavoriteController::class,'showFavorite'])->middleware('auth:api');    //
       Route::post('deleteFromFavorite/{productId}',[FavoriteController::class,'deleteFromFavorite'])->middleware('auth:api');
       Route::post('update',[AuthController::class,'updateUser'])->middleware('auth:api');

       //stripement

       Route::post('stripe',[StripePaymentController::class,'stripePost']);

 ///// /////////////////////////order///////////////////
      Route::post('createorder',[OrderController::class,'store'])->middleware('auth:api');
      Route::post('userAddress',[OrderController::class,'addAddress']);


});



/////////////////////////////admin////////////////
Route::post('adminLogin',[AdminAuthController::class,'adminLogin']);
Route::post('adminLogout',[AdminAuthController::class,'adminLogout'])->middleware('auth:admin-api');

Route::get('showUser/{id}', [AdminAuthController::class,'showUser']);


///////////////////products/////////////////////////
// Route::apiResource('products',ProductController::class);
Route::apiResource('products',ProductController::class);

Route::post('searchByProductName',[ProductController::class,'searchByProductName']);
Route::post('searchByCatagoryName',[ProductController::class,'searchByCatagoryName']);
Route::post('product/update/{id}',[UpdateProductController::class,'updateProduct'])->middleware('auth:admin-api');//updateProduct



// Route::group(['prefix'=>'products','as'=>'account.'], function(){
//     Route::get('/', 'AccountController@index')->name('index');
//     Route::get('connect', 'AccountController@connect')->name('connect');
// });


////////////////////////////////////////////////////////
Route::apiResource('categories',CategoryController::class);
Route::apiResource('messages',MessageController::class);


// Route::get('stripe',[StripePaymentController::class,'stripe']);
Route::post('stripe',[StripePaymentController::class,'stripePost']);
