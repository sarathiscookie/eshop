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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['middleware' => ['auth','role'], 'role' => 'admin'],  function () {
    Route::get('/admin/home', 'AdminController@index');
    Route::get('/admin/users', ['as' => 'listUsers', 'uses' => 'AdminController@showUsers']);
    Route::get('/admin/users/create', 'AdminController@createUsers');
    Route::post('/admin/users/store', ['as' => 'storeUsers', 'uses' => 'AdminController@storeUser']);
    Route::delete('/admin/users/destroy/{id}', ['as' => 'destroyUsers', 'uses' => 'AdminController@destroyUser']);
    Route::get('/admin/products', 'AdminController@showProducts');

});

Route::group(['middleware' => ['auth','role'], 'role' => 'buyer'],  function () {
    Route::get('/buyer/home', 'BuyerController@index');
});
Route::group(['middleware' => ['auth','role'], 'role' => 'seller'],  function () {
    Route::get('/seller/home', 'SellerController@index');
});


