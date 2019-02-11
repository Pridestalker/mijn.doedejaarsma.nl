<?php

namespace App\Listeners\Product;

use App\Events\Product\ProductCreatedEvent;
use App\Mail\Admin\NewProductMade;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class ProductCreatedListener
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
     * @param ProductCreatedEvent $event
     *
     * @return void
     */
    public function handle(ProductCreatedEvent $event): void
    {
        //
        \Mail::to('dtp@doedejaarsma.nl')
            ->send(new NewProductMade($event->product));
        
        \Mail::to($event->user->email)
            ->send(
                new \App\Mail\Customer\NewProductMade($event->user, $event->product)
            );

        \Mail::to($event->user->bedrijf()->first()->email)
            ->send(new \App\Mail\Team\NewProductMade($event->user, $event->product));
    }
}
