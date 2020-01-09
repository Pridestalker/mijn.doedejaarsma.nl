<?php

Route::get('/', 'HomeController@index')->name('begin');

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')
    ->name('home');

Route::get('/downloads/products', 'Resources\ProductController@download')
     ->middleware('auth')
     ->name('download.product.all');

Route::get('/customers/app/{any}', 'HomeController@customerApp')
	->middleware('auth')
	->where(['any' => '.*']);

Route::impersonate();
