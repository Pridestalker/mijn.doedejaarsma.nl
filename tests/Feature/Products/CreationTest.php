<?php

namespace Tests\Feature\Products;

use App\Events\Product\ProductCreatedEvent;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\WithFaker;

class CreationTest extends ProductTestCase
{
    use WithFaker;
    
    public function testAuthenticatedUserCanSeeCreate(): void
    {
        $user = factory(User::class)
            ->create();
        
        $this->actingAs($user);
        $re = $this->get($this->createProductRoute());
        
        $re->assertSuccessful();
        $re->assertViewIs('products.create');
    }
    
    public function testUnauthenticatedUserCanNotSeeCreate(): void
    {
        $re = $this->get($this->createProductRoute());
        
        $re->assertRedirect('/login');
    }
    
    public function testDesignerCanNotSeeCreate()
    {
        $user = factory(User::class)
            ->create();
        
        \Bouncer::assign('designer')->to($user);
        $this->actingAs($user);
        
        $re = $this->get($this->createProductRoute());
        $re->assertRedirect('/');
    }
    
    public function testAdminCanSeeCreate()
    {
        $user = factory(User::class)
            ->create();
        
        \Bouncer::assign('admin')->to($user);
        $this->actingAs($user);
        
        $re = $this->get($this->createProductRoute());
        $re->assertSuccessful();
        $re->assertViewIs('products.create');
    }
    
    public function testCustomerCanSeeCreate()
    {
        $user = factory(User::class)
            ->create();
        
        \Bouncer::assign('customer')->to($user);
        $this->actingAs($user);
        
        $re = $this->get($this->createProductRoute());
        $re->assertSuccessful();
        $re->assertViewIs('products.create');
    }
    
    public function testCustomerCanCreateProduct(): void
    {
        \Event::fake();
        $this->runWithActor();
        
        $re = $this
            ->from($this->createProductRoute())
            ->post(
                $this->storeProductRoute(),
                [
                    'name'      => $this->faker->name,
                    'soort'     => 'drukwerk',
                    'deadline'  => Carbon::now(),
                ]
            );
        
        $re->assertStatus(302);
        $re->assertSessionHas('clearStorage');
        $re->assertSessionHasNoErrors();
        $re->assertRedirect('/products/1');
    }
    
    public function testProductCanNotBeSubmittedWithoutValues(): void
    {
        $this->runWithActor();
        
        $re = $this
            ->from($this->createProductRoute())
            ->post(
                $this->storeProductRoute(),
                []
            );
        
        $re->assertStatus(302);
        $re->assertSessionHasErrors();
        $re->assertRedirect($this->createProductRoute());
    }
    
    public function testProductCanBeSubmittedWithOnlyANameSoortAndDeadline(): void
    {
        \Event::fake();
        $this->runWithActor();
        
        $re = $this
            ->from($this->createProductRoute())
            ->post(
                $this->storeProductRoute(),
                [
                    'name'      => $this->faker->name,
                    'soort'     => 'drukwerk',
                    'deadline'  => Carbon::now(),
                ]
            );
        
        $re->assertStatus(302);
        $re->assertSessionHas('clearStorage');
        $re->assertSessionHasNoErrors();
        $re->assertRedirect('/products/1');
    }
    
    public function testCustomerReceivesMailAfterCreation(): void
    {
        \Event::fake();
        
        $user = $this->runWithActor();
        
        $re = $this
            ->post(
                $this->storeProductRoute(),
                [
                    'name'      => $this->faker->name,
                    'soort'     => 'drukwerk',
                    'deadline'  => Carbon::now(),
                ]
            );
        
        $re->assertSessionHas('clearStorage');
        $re->assertRedirect('/products/1');
        $re->assertSessionHasNoErrors();
        
        \Event::assertDispatched(ProductCreatedEvent::class, function ($e) use ($user) {
            return $e->product->user->id === $user->id;
        });
    }
}
