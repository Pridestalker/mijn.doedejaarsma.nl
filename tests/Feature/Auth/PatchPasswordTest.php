<?php

namespace Tests\Feature\Auth;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class PatchPasswordTest
 * @package Tests\Feature\Auth
 */
class PatchPasswordTest extends TestCase
{
    /**
     * A user can edit his/her own password.
     *
     * @test
     *
     * @return void
     */
    public function userCanEditOwnPassword(): void
    {
        $user = factory(User::class)->create();
        
        $this->actingAs($user);
        
        $res = $this->from(route('users.edit', $user))
            ->post(
                route('user.edit.password', $user),
                [
                    '_method'               => 'patch',
                    'password'              => 'Secret123',
                    'password_confirmation' => 'Secret123'
                ]
            );
        
        $res->assertRedirect(route('users.edit', $user));
    }
}
