<?php

namespace App\Listeners\Product;

use App\Events\Product\ProductStarted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendProductProgressingNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    
    /**
     * Handle the event.
     *
     * @param ProductStarted $event The event firing this
     *
     * @return void
     */
    public function handle(ProductStarted $event): void
    {
        //
        \Mail::to($event->product->user->email)
            ->send(new \App\Mail\Customer\ProductStarted($event->product));
    }
}
