<?php

namespace App\Listeners\Product;

use App;
use App\Mail\Customer\ProductFinished;
use \App\Events\Product\ProductFinished as Event;

/**
 * Class SendProductFinishedNotification
 *
 * @category Listeners
 * @package  App\Listeners\Product
 * @author   Mitch Hijlkema <mail@mitchhijlkema.nl>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://laravel.com/docs/5.8/events
 */
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
