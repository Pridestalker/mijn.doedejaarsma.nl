<?php

namespace App\Events\Product;

use App\Models\Product;
use App\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ProductCreatedEvent
{
    use Dispatchable;
    use SerializesModels;

    public $product;
    
    public $user;
    
    /**
     * Create a new event instance.
     *
     * @param Product $product The created product.
     * @param User    $user    The owning user.
     */
    public function __construct(Product $product, User $user)
    {
        $this->product = $product;
        $this->user = $user;
    }
}
