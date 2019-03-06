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
    
    protected function readProductRoute($product)
    {
        return route('products.show', $product);
    }
    
    protected function editProductRoute($product)
    {
        return route('products.edit', $product);
    }
    
    protected function updateProductRoute($product)
    {
        return route('products.update', $product);
    }
    
    protected function deleteProductRoute($product)
    {
        return route('products.destroy', $product);
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
