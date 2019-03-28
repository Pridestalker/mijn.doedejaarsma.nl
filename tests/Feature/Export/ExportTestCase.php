<?php
namespace Tests\Feature\Export;


use App\User;
use Tests\TestCase;

class ExportTestCase extends TestCase
{
    protected function runWithActor($role = 'customer')
    {
        $this->seed('BouncerSeeder');
        $user = factory(User::class)->create();
        
        \Bouncer::assign($role)->to($user);
        $this->actingAs($user);
        
        return $user;
    }
}
