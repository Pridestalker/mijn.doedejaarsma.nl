<?php

Route::post('login', 'Api\V1\Auth\LoginController@login')
    ->name('api.login');
