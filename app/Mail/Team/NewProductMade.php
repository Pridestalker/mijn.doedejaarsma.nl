<?php

namespace App\Mail\Team;

use App\Models\Product;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewProductMade extends Mailable
{
    use Queueable, SerializesModels;
    
    public $user;
    
    public $product;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, Product $product)
    {
        //
        $this->product = $product;
        $this->user =  $user;
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
            ->subject('Nieuwe productaanvraag bij Doede Jaarsma communicatie')
            ->markdown('Mail.Team.NewProductMade');
    }
}
