<?php

namespace Tests\Feature\Products;

use App\Models\Product;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteProductTest extends ProductTestCase
{
    use WithFaker;
    /**
     * A user can delete his/her own products.
     *
     * @test
     *
     * @return void
     */
    public function userCanDeleteOwnProduct(): void
    {
        /* @var \App\User $user */
        $user = $this->runWithActor('customer');
        
        $product = factory(Product::class)->create(
            [
                'user_id'   => $user->id
            ]
        );
        
        $res = $this->post(
            $this->deleteProductRoute($product),
            [
                '_method'   => 'DELETE'
            ]
        );
    
        $res->assertRedirect();
    
        $this->assertFalse($product->exists());
    }
    
    /**
     * Admin can delete any product.
     *
     * @test
     *
     * @return void
     */
    public function adminCanDeleteAnyProduct(): void
    {
        /* @var \App\User $customer */
        $customer = factory(User::class)->create();
        
        $admin = $this->runWithActor('admin');
    
        /* @var \App\Models\Product $product */
        $product = factory(Product::class)->create(
            [
                'user_id'   => $customer->id
            ]
        );
        
        $res = $this->post(
            $this->deleteProductRoute($product),
            [
                '_method'   => 'DELETE'
            ]
        );
    
        $res->assertRedirect();
        
        $this->assertFalse($product->exists());
    }
}
