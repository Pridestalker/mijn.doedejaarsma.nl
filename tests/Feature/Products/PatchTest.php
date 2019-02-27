<?php

namespace Tests\Feature\Products;

use App\Models\Product;
use App\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PatchTest extends ProductTestCase
{
    use RefreshDatabase;
    
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
	    $this->markTestIncomplete('Test not implemented');
	    
	    \Event::fake();
        
        $user1 = factory(User::class)->create();
        $user2 = factory(User::class)->create();
        
        $product = factory(Product::class)->create(
            [
                'user_id'   => $user1->id,
            ]
        );
    
        $res = $this->from($this->editProductRoute($product))
            ->post(
                $this->updateProductRoute($product),
                [
                    '_method'   => 'put'
                ]
            );
    }
    
    public function testOnlyNameChangesWhenEdited(): void
    {
    	$this->doesNotPerformAssertions();
        $this->markTestIncomplete('Test not implemented');
    }
	
	public function testOnlyDescriptionChangesWhenEdited(): void
	{
		$this->doesNotPerformAssertions();
		$this->markTestIncomplete('Test not implemented');
    }
	
	public function testDeadlineDoesNotChangeWhenNotEdited(): void
	{
		$this->doesNotPerformAssertions();
		$this->markTestIncomplete('Test not implemented');
    }
}
