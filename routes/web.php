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

Route::group(['middleware' => ['adminrole']], function () {
    Route::get('/admin/home', 'AdminController@index');
});

Route::group(['middleware' => ['buyerrole']], function () {
    Route::get('/buyer/home', 'BuyerController@index');
});

Route::group(['middleware' => ['sellerrole']], function () {
    Route::get('/seller/home', 'SellerController@index');
});

