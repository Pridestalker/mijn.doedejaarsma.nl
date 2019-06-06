<?php

namespace App\Listeners\Product;

use App;
use App\Events\Product\ProductStarted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class SendProductProgressingNotification
 *
 * @category Listeners
 * @package  App\Listeners\Product
 * @author   Mitch Hijlkema <mail@mitchhijlkema.nl>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://laravel.com/docs/5.8/events
 */
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
        /* @noinspection PhpMethodParametersCountMismatchInspection */
        if (App::environment('local')) {
            return;
        }
        \Mail::to($event->product->user->email)
            ->send(new \App\Mail\Customer\ProductStarted($event->product));
    }
}
