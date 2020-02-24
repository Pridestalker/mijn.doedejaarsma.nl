<?php

namespace Tests\Feature\Products;

use App\User;
use Tests\TestCase;
use Laravel\Passport\Passport;
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
        return route('api.products.store');
    }

    protected function showProductRoute()
    {
        return route('products.index');
    }

    protected function readProductRoute($product)
    {
        return route("/products#/single/$product->id");
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
        $this->seed('BouncerSeeder');
        $user = factory(User::class)
            ->create();

        \Bouncer::assign($role)->to($user);
        $this->actingAs($user);
        Passport::actingAs($user);

        return $user;
    }
}
