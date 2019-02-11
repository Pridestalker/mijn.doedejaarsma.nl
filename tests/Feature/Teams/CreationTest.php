<?php

namespace Tests\Feature\Teams;

use App\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreationTest extends TeamTestCase
{
    public function testAuthenticatedUsersCanNotSeeCreate(): void
    {
        $user = factory(User::class)
            ->create();
        
        $this->actingAs($user);
        $re = $this->get($this->createTeamRoute());
	
	    $re->assertRedirect('home');
	    $this->assertAuthenticated();
    }
    
    public function testUnauthenticatedUsersCanSeeCreate(): void
    {
        $re = $this->get($this->createTeamRoute());
        
        $re->assertRedirect('/login');
        $this->assertGuest();
    }
    
    public function testAuthenticatedAdminCanSeeCreate(): void
    {
        $user = factory(User::class)
            ->create();
        
        \Bouncer::assign('admin')->to($user);
        
        $this->actingAs($user);
        $re = $this->get($this->createTeamRoute());
        
        $re->assertSuccessful();
        $re->assertViewIs('teams.create');
        $this->assertAuthenticated();
    }
    
    public function testAuthenticatedCustomerCanSeeCreate(): void
    {
        $user = factory(User::class)
            ->create();
        
        \Bouncer::assign('customer')->to($user);
        
        $this->actingAs($user);
        $re = $this->get($this->createTeamRoute());
        
        $re->assertSuccessful();
        $re->assertViewIs('teams.create');
        $this->assertAuthenticated();
    }
    
    public function testAuthenticatedDesignerCanNotSeeCreate(): void
    {
        $user = factory(User::class)
            ->create();
        
        \Bouncer::assign('designer')->to($user);
        
        $this->actingAs($user);
        $re = $this->get($this->createTeamRoute());
        
        $re->assertRedirect('home');
        $this->assertAuthenticated();
    }
}
