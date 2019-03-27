<?php

Route::get('permissions', 'Resources\PermissionController@index')
     ->name('permissions.index');

Route::get('permissions/create', 'Resources\PermissionController@create')
     ->name('permissions.create');

Route::post('permissions/store', 'Resources\PermissionController@store')
     ->name('permissions.store');
