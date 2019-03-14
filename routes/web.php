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

Route::get('/', 'HomeController@index')->name('begin');

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');



Route::get(
    'users/{user}/notifications/{notification}/delete',
    'HomeController@removeNotification'
)
->name('user.remove.notification');


Route::patch('users/{user}/edit/password', 'Auth\ModifyPasswordController@patch')
    ->name('user.edit.password');

Route::get('products/{product}/image', 'Resources\ProductController@showImage')
    ->name('products.image');
Route::resource('products', 'Resources\ProductController');

Route::resource('teams', 'Resources\TeamController');

Route::resource('users', 'Resources\UserController');
