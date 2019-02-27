<?php

namespace App\Listeners\Product;

use App;
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
     * @param ProductCreatedEvent $event The event firing this listener
     *
     * @return void
     */
    public function handle(ProductCreatedEvent $event): void
    {
        //
        /* @noinspection PhpMethodParametersCountMismatchInspection */
        if (App::environment('local')) {
            return;
        }
        
        \Mail::to($this->_email())
            ->send(new NewProductMade($event->product));
        
        \Mail::to($event->user->email)
            ->send(
                new \App\Mail\Customer\NewProductMade($event->user, $event->product)
            );

        \Mail::to($event->user->bedrijf()->first()->email)
            ->send(new \App\Mail\Team\NewProductMade($event->user, $event->product));
    }
    
    /**
     * Changes the email based on env.
     *
     * @noinspection PhpMethodMayBeStaticInspection
     *
     * @return string email address
     */
    private function _email(): string
    {
        /* @noinspection PhpMethodParametersCountMismatchInspection */
        return App::environment('local')?
            'mitch@doedejaarsma.nl' : 'dtp@doedejaarsma.nl';
    }
}
