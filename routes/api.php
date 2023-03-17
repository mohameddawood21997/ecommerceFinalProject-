<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use  App\Http\Controllers\Api\User\AuthController;
use  App\Http\Controllers\Api\Admin\AdminAuthController;
use  App\Http\Controllers\Api\OrderController;
use  App\Http\Controllers\Api\products\ProductController;
use  App\Http\Controllers\Api\UserCardController;
use  App\Http\Controllers\Api\FavoriteController;
use  App\Http\Controllers\Api\CategoryController;






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

       Route::post('register',[AuthController::class,'register']);   //
       Route::put('update/{id}',[AuthController::class,'update']);   //
       Route::delete('delete/{id}',[AuthController::class,'delete']);
       Route::post('upload',[AuthController::class,'upload']);    
       Route::post('login',[AuthController::class,'login']);         //
       Route::post('addToCart',[UserCardController::class,'addToCart'])->middleware('auth:api');   //
       Route::get('showUserCard',[UserCardController::class,'showUserCard'])->middleware('auth:api');  //
       Route::post('deleteFromCart/{productId}',[UserCardController::class,'deleteFromCart']);        //
       Route::post('addToFavorite',[FavoriteController::class,'addToFavorite'])->middleware('auth:api');  //
       Route::get('showFavorite',[FavoriteController::class,'showFavorite'])->middleware('auth:api');    //
       Route::post('deleteFromFavorite/{productId}',[FavoriteController::class,'deleteFromFavorite'])->middleware('auth:api');




 ///// /////////////////////////order///////////////////
Route::post('createorder',[OrderController::class,'store'])->middleware('auth:api');

       
});


/////////////////////////////admin////////////////
Route::post('adminLogin',[AdminAuthController::class,'adminLogin']);


///////////////////products/////////////////////////
Route::apiResource('products',ProductController::class);

Route::get('searchByProductName/{name}',[ProductController::class,'searchByProductName']);
Route::get('searchByCatagoryName/{catName}',[ProductController::class,'searchByCatagoryName']);



// Route::group(['prefix'=>'products','as'=>'account.'], function(){
//     Route::get('/', 'AccountController@index')->name('index');
//     Route::get('connect', 'AccountController@connect')->name('connect');
// });


////////////////////////////////////////////////////////
Route::apiResource('categories',CategoryController::class);
