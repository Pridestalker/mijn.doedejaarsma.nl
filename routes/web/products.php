<?php

Route::get('products/{product}/image', 'Resources\ProductController@showImage')
     ->name('products.image');

Route::resource('products', 'Resources\ProductController');
