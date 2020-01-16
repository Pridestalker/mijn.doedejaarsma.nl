<?php

Route::get('products-standard/{product}/image', 'Resources\StandardProductController@downloadImage');

Route::resource('products-standard', 'Resources\StandardProductController');

Route::get('products/{product}/image', 'Resources\ProductController@showImage')
     ->name('products.image');

Route::resource('products', 'Resources\ProductController');
