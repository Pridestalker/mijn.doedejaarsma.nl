<?php

Route::get('/', 'Api\V2\StandardProduct\AllStdProductsController')
    ->name('api.v2.standard_products.index');

Route::post('/', 'Api\V2\StandardProduct\CreateStdProductController')
    ->name('api.v2.standard_products.store');
