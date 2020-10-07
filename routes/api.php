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

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth',
    'namespace' => 'UserAuth'

], function ($router) {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
    Route::post('updatePassword', 'AuthController@updatePassword');
});

// Categories Controller
Route::get('categories','CategoryController@index');
Route::get('/categories/{category}','CategoryController@show');
Route::post('/categories','CategoryController@store');
Route::post('/categories/{category}', 'CategoryController@update');
Route::delete('/categories/{category}','CategoryController@destroy');

// Product Controller
Route::get('/products','ProductController@index');
Route::get('/products/{product}','ProductController@show');
Route::post('/products', 'ProductController@store');
Route::get('/products/{product}/delete-product', 'ProductController@destroy');
Route::post('/toggle-featured','ProductController@featuredProduct');
Route::post('/products/{product}','ProductController@update');
Route::post('/products/{product}/delete-image','ProductController@destroyproductimages');


// Order Controller
Route::get('orders','OrderController@index');
Route::post('orders', 'OrderController@store');
Route::post('orders/{order}/update', 'OrderController@update');
Route::post('orders/{order}/delete', 'OrderController@destroy');

//OrderedProducts Controller
Route::get('orderedproduct', 'OrderedProductController@index');

// Favourite Controller
Route::get('favourites','FavouritesController@index');
Route::post('favourites','FavouritesController@store');
Route::post('delete-favourite','FavouritesController@destroy');
Route::post('update-profile', 'UpdateUserController@update');