<?php

Route::prefix('notifications')->group(
    function () {
        Route::get('/', 'Api\V1\User\NotificationsController@index')
             ->name('api.user.notifications.index');
        
        Route::get('/unread', 'Api\V1\User\NotificationsController@unread')
             ->name('api.user.notifications.unread');
        
        Route::get('/delete/{id}', 'Api\V1\User\NotificationsController@delete')
             ->name('api.user.notifications.delete');
    }
);
