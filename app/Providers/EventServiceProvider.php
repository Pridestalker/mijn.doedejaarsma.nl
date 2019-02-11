<?php

namespace App\Providers;

use App\Events\Product\ProductCreatedEvent;
use App\Events\Product\ProductFinished;
use App\Events\Product\ProductStarted;
use App\Listeners\Product\ProductCreatedListener;
use App\Listeners\Product\SendProductFinishedNotification;
use App\Listeners\Product\SendProductProgressingNotification;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        ProductCreatedEvent::class => [
            ProductCreatedListener::class,
        ],
        ProductStarted::class => [
            SendProductProgressingNotification::class,
        ],
        ProductFinished::class => [
            SendProductFinishedNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
