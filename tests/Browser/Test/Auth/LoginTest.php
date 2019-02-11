<?php

namespace Tests\Browser\Test\Auth;

use App\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LoginTest extends DuskTestCase
{
    use DatabaseMigrations;
    
    /**
     * Test if a user can login with his own credentials.
     *
     * @return void
     *
     * @throws \Throwable
     */
    public function testUserCanLoginWithCredentials(): void
    {
        $user = factory(User::class)->create(
            [
                'password'  => bcrypt($password = 'secret'),
            ]
        );
        
        $this->browse(
            function (Browser $browser) use ($user, $password) {
                $browser->visit(route('login'))
                    ->type('username', $user->username)
                    ->type('password', $password)
                    ->press('Login')
                    ->assertPathIs('/home');
            }
        );
    }
    
    /**
     * Test if a user cannot login with incorrect details.
     *
     * @return void
     *
     * @throws \Throwable
     */
    public function testUserCannotLoginWithIllegalCredentials(): void
    {
        $user = factory(User::class)->create(
            [
                'password'  => bcrypt($password = 'secret')
            ]
        );
        
        $this->browse(
            function (Browser $browser) use ($user, $password) {
                $browser->logout();
                
                $browser->visitRoute('login')
                    ->type('username', $user->email)
                    ->type('password', $password)
                    ->press('Login')
                    ->assertPathIs('/login');
            }
        );
    }
}
