<?php

namespace App\Mail\Customer;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProductStarted extends Mailable
{
    use Queueable, SerializesModels;
    
    /**
     * Is the product that is edited.
     *
     * @var Product $product
     */
    public $product;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Product $product)
    {
        //
        $this->product = $product;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): self
    {
        return $this
            ->from('dtp@doedejaarsma.nl', 'DTP - Doede Jaarsma communicatie')
            ->subject("Onderwerp: Status update {$this->product->name}")
            ->markdown('Mail.Customer.ProductStarted');
    }
}
