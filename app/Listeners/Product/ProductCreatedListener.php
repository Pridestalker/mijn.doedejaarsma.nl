<?php

namespace App\Listeners\Product;

use App;
use App\Events\Product\ProductCreatedEvent;
use App\Mail\Admin\NewProductMade;
use App\Notifications\NewProduct;
use App\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use Notification;

/**
 * Class ProductCreatedListener
 *
 * @category Listeners
 * @package  App\Listeners\Product
 * @author   Mitch Hijlkema <mail@mitchhijlkema.nl>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://laravel.com/docs/5.8/events
 */
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
        $admins_developers = User::whereIsNot('customer')->get();
        Notification::send($admins_developers, new NewProduct($event->product));
        
        if (App::environment('local')) {
            return;
        }
        
        $this->emails($event);
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
    
    
    /**
     * Sends the mails when a product is made.
     *
     * @param ProductCreatedEvent $event the current event
     *
     * @return void
     */
    public function emails(ProductCreatedEvent $event): void
    {
        \Mail::to($this->_email())
            ->send(new NewProductMade($event->product));
    
        \Mail::to($event->user->email)
            ->send(
                new \App\Mail\Customer\NewProductMade($event->user, $event->product)
            );
    
        \Mail::to($event->user->bedrijf()->first()->email)
            ->send(
                new \App\Mail\Team\NewProductMade($event->user, $event->product)
            );
    }
}
