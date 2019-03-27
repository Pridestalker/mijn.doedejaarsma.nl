<?php

Route::get('users/{user}/notifications/{notification}/delete','HomeController@removeNotification')
     ->name('user.remove.notification');

Route::post('user/{user}/permissions/patch', 'Resources\PermissionController@patchUser')
     ->name('admin.user.patch.permissions');

Route::patch('users/{user}/edit/password', 'Auth\ModifyPasswordController@patch')
     ->name('user.edit.password');

Route::resource('users', 'Resources\UserController');
