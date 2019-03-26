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

Route::get('/downloads/products', 'Resources\ProductController@download')
    ->middleware('auth')
    ->name('download.product.all');

Route::get(
    'users/{user}/notifications/{notification}/delete',
    'HomeController@removeNotification'
)
->name('user.remove.notification');

Route::post('user/{user}/permissions/patch', 'Resources\PermissionController@patchUser')
    ->name('admin.user.patch.permissions');

Route::patch('users/{user}/edit/password', 'Auth\ModifyPasswordController@patch')
    ->name('user.edit.password');

Route::get('products/{product}/image', 'Resources\ProductController@showImage')
    ->name('products.image');

Route::get('permissions', 'Resources\PermissionController@index')
    ->name('permissions.index');

Route::get('permissions/create', 'Resources\PermissionController@create')
    ->name('permissions.create');

Route::post('permissions/store', 'Resources\PermissionController@store')
    ->name('permissions.store');


/*
 * Resources
 */
Route::resource('products', 'Resources\ProductController');

Route::resource('teams', 'Resources\TeamController');

Route::resource('users', 'Resources\UserController');
