<?php

namespace Tests\Feature\Teams;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

abstract class TeamTestCase extends TestCase
{
    protected function createTeamRoute(): string
    {
        return route('teams.create');
    }
    
    protected function storeTeamRoute(): string
    {
        return route('teams.store');
    }
    
    protected function showTeamRoute(): string
    {
        return route('teams.index');
    }
    
    protected function readTeamRoute(): string
    {
        return route('teams.show');
    }
    
    protected function editTeamRoute(): string
    {
        return route('teams.edit');
    }
    
    protected function updateTeamRoute(): string
    {
        return route('teams.update');
    }
    
    protected function deleteTeamRoute(): string
    {
        return route('teams.destroy');
    }
}
