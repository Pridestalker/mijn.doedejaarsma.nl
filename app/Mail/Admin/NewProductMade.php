<?php

namespace App\Mail\Admin;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewProductMade extends Mailable
{
    use Queueable, SerializesModels;

    public $product;
    
    /**
     * Create a new message instance.
     *
     * @param Product $product The newly made product
     *
     * @return void
     */
    public function __construct(Product $product)
    {
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
            ->subject('Er is een nieuw product aangevraagd op mijn.doedejaarsma.nl')
            ->markdown('Mail.Admin.NewProduct');
    }
}
