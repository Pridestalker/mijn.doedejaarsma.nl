<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('login', 'Api\V1\Auth\LoginController@login')->name('api.login');

Route::prefix('v1')->middleware('auth:api')->group(
    function () {
        Route::prefix('products')->group(
            function () {
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
            }
        );
    }
);
