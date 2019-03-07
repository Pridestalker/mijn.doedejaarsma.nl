<?php

namespace App\Listeners\Product;

use App;
use App\Mail\Customer\ProductFinished;
use \App\Events\Product\ProductFinished as Event;

class SendProductFinishedNotification
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
	 * @param Event $event The event that fired this
	 *
	 * @return void
	 */
    public function handle(Event $event)
    {
	    /* @noinspection PhpMethodParametersCountMismatchInspection */
	    if (App::environment('local')) {
		    return;
	    }
        \Mail::to($event->product->user->email)
            ->send(new ProductFinished($event->product));
    }
}
