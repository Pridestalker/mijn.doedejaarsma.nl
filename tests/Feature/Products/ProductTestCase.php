<?php


namespace Tests\Feature\Products;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

abstract class ProductTestCase extends TestCase
{
    use RefreshDatabase;
    
    protected function createProductRoute(): string
    {
        return route('products.create');
    }
    
    protected function storeProductRoute(): string
    {
        return route('products.store');
    }
    
    protected function showProductRoute()
    {
        return route('products.index');
    }
    
    protected function readProductRoute()
    {
        return route('products.show');
    }
    
    protected function editProductRoute()
    {
        return route('products.edit');
    }
    
    protected function updateProductRoute()
    {
        return route('products.update');
    }
    
    protected function deleteProductRoute()
    {
        return route('products.destroy');
    }
    
    protected function runWithActor($role = 'customer')
    {
        $user = factory(User::class)
            ->create();
        
        \Bouncer::assign($role)->to($user);
        $this->actingAs($user);
        
        return $user;
    }
}
