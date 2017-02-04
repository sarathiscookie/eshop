<?php

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

Route::get('/', ['as' => 'listDataDefaultUsers', 'uses' => 'WelcomeController@index']);
Route::get('/product/avatar/{id}', ['as' => 'productAvatar', 'uses' => 'WelcomeController@show']);

Auth::routes();

Route::group(['middleware' => ['auth','role'], 'role' => 'admin'],  function () {
    /*
    |--------------------------------------------------------------------------
    | Admin: Dashboard
    |--------------------------------------------------------------------------
    |
    | Listing for latest 5 products and new 5 users
    */
    Route::get('/admin/home', 'AdminController@index');

    /*
    |--------------------------------------------------------------------------
    | Admin: users functionality
    |--------------------------------------------------------------------------
    |
    | Add, delete, view users
    */
    Route::get('/admin/users', ['as' => 'listUsers', 'uses' => 'AdminController@showUsers']);
    Route::get('/admin/users/create', 'AdminController@createUsers');
    Route::post('/admin/users/store', ['as' => 'storeUsers', 'uses' => 'AdminController@storeUser']);
    Route::delete('/admin/users/destroy/{id}', ['as' => 'destroyUsers', 'uses' => 'AdminController@destroyUser']);

    /*
    |--------------------------------------------------------------------------
    | Admin: Products functionality
    |--------------------------------------------------------------------------
    |
    | Add, delete, listing products
    */
    Route::get('/admin/products', ['as' => 'listUsers', 'uses' => 'AdminController@showProducts']);
    Route::get('/admin/products/create', 'AdminController@createProducts');
    Route::post('/admin/products/store', ['as' => 'storeProducts', 'uses' => 'AdminController@storeProduct']);
    Route::delete('/admin/products/destroy/{id}', ['as' => 'destroyProducts', 'uses' => 'AdminController@destroyProduct']);


});

Route::group(['middleware' => ['auth','role'], 'role' => 'buyer'],  function () {
    Route::get('/buyer/home', 'BuyerController@index');
});
Route::group(['middleware' => ['auth','role'], 'role' => 'seller'],  function () {
    Route::get('/seller/home', 'SellerController@index');
});


