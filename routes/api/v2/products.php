<?php

Route::get('/', 'Api\V2\Product\AllProductsController')
    ->name('api.v2.products.index');

Route::post('/', 'Api\V2\Product\CreateProductController')
    ->name('api.v2.products.store');

Route::get('/{product}', 'Api\V2\Product\ReadProductController')
    ->name('api.v2.product.read');

Route::patch('/{product}', 'Api\V2\Product\UpdateProductController')
    ->name('api.v2.product.patch');

Route::delete('/{product}', 'Api\V2\Product\DeleteProductController')
    ->name('api.v2.product.delete');
