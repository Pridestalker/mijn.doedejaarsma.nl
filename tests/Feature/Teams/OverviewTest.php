<?php

namespace Tests\Feature\Teams;

use App\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OverviewTest extends TeamTestCase
{
    public function testAuthenticatedUsersCanSeeShow(): void
    {
        $user = factory(User::class)
            ->create();
        
        $re = $this->actingAs($user)->get($this->showTeamRoute());
        $re->assertSuccessful();
        $re->assertViewIs('teams.index');
        $this->assertAuthenticated();
    }
    
    public function testUnauthenticatedUsersCanNotSeeShow(): void
    {
        $re = $this->get($this->showTeamRoute());
        
        $re->assertRedirect('/login');
        $this->assertGuest();
    }
    
    public function testAdminUserCanSeeShow(): void
    {
        $user = factory(User::class)
            ->create();
        \Bouncer::assign('admin')->to($user);
        
        $this->actingAs($user);
        $this->assertAuthenticated();
        
        $re = $this->get($this->showTeamRoute());
        $re->assertSuccessful();
        $re->assertViewIs('teams.index');
        $this->assertAuthenticatedAs($user);
    }
}
