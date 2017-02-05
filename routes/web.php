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

/* Default welcome page */
Route::get('/', ['as' => 'listDataDefaultUsers', 'uses' => 'WelcomeController@index']);

/* Show image */
Route::get('/product/avatar/{id}', ['as' => 'productAvatar', 'uses' => 'WelcomeController@show']);

/*Live Search*/
Route::post('/livesearch',  [
    'as' => 'livesearchdata', 'uses' => 'WelcomeController@livesearch'
]);


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
    /*
    |--------------------------------------------------------------------------
    | Buyer: Home page
    |--------------------------------------------------------------------------
    |
    | Listing products and filtering functionality
    */
    Route::get('/buyer/home', 'BuyerController@index');

    /*
    |--------------------------------------------------------------------------
    | Buyer: profile page
    |--------------------------------------------------------------------------
    |
    | Functionality for view and update profile
    */
    Route::get('/buyer/profile', 'BuyerController@edit');
    Route::post('/buyer/profile/edit', ['as' => 'updateBuyerProfile', 'uses' => 'BuyerController@update']);


});
Route::group(['middleware' => ['auth','role'], 'role' => 'seller'],  function () {
    /*
    |--------------------------------------------------------------------------
    | Buyer: Home page
    |--------------------------------------------------------------------------
    |
    | Listing products and filtering functionality
    */
    Route::get('/seller/home', 'SellerController@index');

    /*
    |--------------------------------------------------------------------------
    | Seller: profile page
    |--------------------------------------------------------------------------
    |
    | Functionality for view and update profile
    */
    Route::get('/seller/profile', 'SellerController@edit');
    Route::post('/seller/profile/edit', ['as' => 'updateSellerProfile', 'uses' => 'SellerController@update']);
    Route::get('/seller/product', ['as' => 'sellerProduct', 'uses' => 'SellerController@create']);
});


