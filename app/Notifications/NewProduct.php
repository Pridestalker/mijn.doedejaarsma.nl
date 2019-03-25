<?php

namespace App\Notifications;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewProduct extends Notification
{
    use Queueable;
    
    /**
     * Holds the product which is created.
     *
     * @var Product $product the created product.
     */
    public $product;
    
    /**
     * Create a new notification instance.
     *
     * @param Product $product the created product.
     *
     * @return void
     */
    public function __construct(Product $product)
    {
        //
        $this->product = $product;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable the notification
     *
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }
    
    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable the notification
     *
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'id'    => $this->product->id,
            'user'  => $this->product->user,
        ];
    }
}
