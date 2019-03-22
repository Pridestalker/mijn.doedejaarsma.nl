<?php

namespace Tests\Browser\Test\Auth;

use App\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Browser\Pages\Auth\Login;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LoginTest extends DuskTestCase
{
    use DatabaseMigrations,
        WithFaker;
    
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
                $browser->visit(new Login())
                    ->type('email', $user->email)
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
                
                $browser->visit(new Login())
                    ->type('email', $user->username)
                    ->type('password', $password)
                    ->press('Login')
                    ->assertPathIs('/login');
            }
        );
    }
    
    /**
     * @test
     * @throws \Throwable
     */
    public function userCanNotLoginWithIncorrectEmail()
    {
        $user = factory(User::class)->create(
            [
                'password'  => bcrypt($password = 'secret')
            ]
        );
        
        $this->browse(
            function (Browser $browser) use ($user, $password) {
                $browser->logout();
                
                $browser->visit(new Login())
                    ->type('email', $email = $this->faker->safeEmail)
                    ->type('password', $password)
                    ->press('Login')
                    ->assertPathIs('/login');
            }
        );
    }
    
    /**
     * @test
     *
     * @throws \Throwable
     */
    public function userSeesErrorOnWrongCredentials()
    {
        $user = factory(User::class)->create(
            [
                'password'      => bcrypt($password = 'secret')
            ]
        );
        
        $this->browse(
            function (Browser $browser) use ($password) {
                $browser->logout();
                
                $browser->visit(new Login())
                    ->type('email', $email = $this->faker->safeEmail)
                    ->type('password', $password)
                    ->press('Login')
                    ->assertPathIs('/login')
                    ->assertSee('These credentials do not match our records.')
                    ->assertInputValue('email', $email)
                    ->assertInputValue('password', '');
            }
        );
    }
}
