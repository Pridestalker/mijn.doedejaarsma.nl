<?php

namespace Tests\Feature\Products;

use App\Models\Product;
use App\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PatchTest extends ProductTestCase
{
    use RefreshDatabase,
        WithFaker;
    
    /**
     * @covers \App\Http\Controllers\Resources\ProductController::edit
     * @covers \App\Http\Controllers\Resources\ProductController::update
     */
    public function testUserCanModifyOwnProduct(): void
    {
        \Event::fake();
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create(
            [
                'user_id'   => $user->id,
            ]
        );
        
        $this->actingAs($user);
        
        $res = $this->from($this->editProductRoute($product))
            ->post(
                $this->updateProductRoute($product),
                [
                    '_method'   => 'put'
                ]
            );
        
        $res->assertRedirect($this->editProductRoute($product));
        $res->assertSessionHasNoErrors();
    }
    
    public function testUserCannotModifyOtherProduct(): void
    {
    	$this->doesNotPerformAssertions();
        $this->markTestIncomplete('Functionality not implemented');
        
        \Event::fake();
        
        $user1 = factory(User::class)->create();
        $user2 = factory(User::class)->create();
        
        $product = factory(Product::class)->create(
            [
                'user_id'   => $user1->id,
            ]
        );

        $this->actingAs($user2);

        $res = $this->from($this->editProductRoute($product))
            ->post(
                $this->updateProductRoute($product),
                [
                    '_method'   => 'put',
                    'name'      => 'andereNaam',
                ]
            );
    
        $res->assertRedirect($this->editProductRoute($product));
        $res->assertSessionHasErrors();
    }
    
    /**
     * @test
     */
    public function nameChangesCorrectly(): void
    {
        /* @var \App\Models\Product $product */
        $product = factory(Product::class)->create(
            [
                'name'      => $this->faker->name,
            ]
        );
        
        $oldname = $product->name;
        
        $this->runWithActor();
        
        $res = $this->from($this->editProductRoute($product))
            ->post(
                $this->updateProductRoute($product),
                [
                    '_method'   => 'put',
                    'name'      => $this->faker->name,
                ]
            );
     
        $res->assertRedirect($this->editProductRoute($product));
        $this->assertSame($product->name, $oldname);
    }
    
    /**
     * @test
     */
    public function descriptionChangesCorrectly(): void
    {
        /* @var \App\Models\Product $product */
        $product = factory(Product::class)->create(
            [
                'name'      => $this->faker->paragraph,
            ]
        );
    
        $old = $product->description;
    
        $this->runWithActor();
    
        $res = $this->from($this->editProductRoute($product))
                    ->post(
                        $this->updateProductRoute($product),
                        [
                            '_method'   => 'put',
                            'description'      => $this->faker->paragraph,
                        ]
                    );
    
        $res->assertRedirect($this->editProductRoute($product));
        $this->assertSame($product->description, $old);
    }
    
    public function testDeadlineDoesNotChangeWhenNotEdited(): void
    {
        /* @var \App\Models\Product $product */
        $product = factory(Product::class)->create(
            [
                'name'      => $this->faker->name,
            ]
        );
    
        $deadline = $product->deadline;
        $this->runWithActor();
    
        $res = $this->from($this->editProductRoute($product))
                    ->post(
                        $this->updateProductRoute($product),
                        [
                            '_method'   => 'put',
                            'name'      => $this->faker->name,
                        ]
                    );
    
        $res->assertRedirect($this->editProductRoute($product));
        $this->assertSame($product->deadline, $deadline);
    }
}
