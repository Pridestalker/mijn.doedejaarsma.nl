<?php

Route::get('/', 'Api\V1\Product\HoursController@index');

Route::post('/', 'Api\V1\Product\HoursController@store');

Route::get('/{hour}', 'Api\V1\Product\HoursController@show');
