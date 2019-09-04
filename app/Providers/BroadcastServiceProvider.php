<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Broadcast;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        Broadcast::routes();
    
        /** @noinspection PhpIncludeInspection */
        require base_path('routes/channels.php');
    }
}
