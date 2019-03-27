<?php

Route::get('/', 'Api\V1\Product\ProductController@index')
     ->name('api.products.index');

Route::get('/{product}', 'Api\V1\Product\ProductController@show')
     ->name('api.products.show');

Route::post('/', 'Api\V1\Product\ProductController@store')
     ->name('api.products.store');

Route::patch('/{product}/edit', 'Api\V1\Product\ProductController@update')
     ->name('api.products.patch');

Route::delete('/{product}/destroy', 'Api\V1\Product\ProductController@destroy')
     ->name('api.products.destroy');
