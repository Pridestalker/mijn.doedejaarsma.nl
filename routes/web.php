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

Route::get('/', 'HomeController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('products/{product}/image', 'Resources\ProductController@showImage')->name( 'products.image');
Route::resource('products', 'Resources\ProductController');

Route::resource('teams', 'Resources\TeamController');

Route::resource('users', 'Resources\UserController');
