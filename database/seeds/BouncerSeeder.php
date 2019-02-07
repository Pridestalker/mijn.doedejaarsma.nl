<?php

use Illuminate\Database\Seeder;
use \App\Models\Product;

class BouncerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Bouncer::allow('admin')->everything();
        Bouncer::allow('admin')->to('create', \App\User::class);
        Bouncer::allow('admin')->to('create', \App\Models\Team);
        
        Bouncer::allow('customer')->to('create', Product::class);
        Bouncer::allow('customer')->to('read', Product::class);
        Bouncer::allow('customer')->to('update', Product::class);
        Bouncer::allow('customer')->to('delete', Product::class);
        Bouncer::allow('customer')->toOwn(Product::class);
        
        Bouncer::allow('designer')->to('read', Product::class);
        Bouncer::allow('designer')->to('update', Product::class);
    
        Bouncer::forbid('banned')->everything();
    }
}
