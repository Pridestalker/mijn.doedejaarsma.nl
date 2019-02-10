<?php

namespace Tests\Feature\Auth;

use App\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class LoginTest
 *
 * @category TestCase
 * @package  Tests\Feature\Auth
 * @author   Mitch Hijlkema <mitchhijlkema@hotmail.com>
 * @license  http://opensource.org/licenses/MIT MIT
 * @version  Release: 1.0.0
 * @link     https://phpunit.de/
 */
class LoginTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * Return the route for a successful login.
     *
     * @return string
     */
    protected function successfulLoginRoute(): string
    {
        return route('home');
    }
    
    /**
     * Return the get route for a login.
     *
     * @return string
     */
    protected function loginGetRoute(): string
    {
        return route('login');
    }
    
    /**
     * Return the post route for a login.
     *
     * @return string
     */
    protected function loginPostRoute(): string
    {
        return route('login');
    }
    
    /**
     * Return the route to logout.
     *
     * @return string
     */
    protected function logoutRoute(): string
    {
        return route('logout');
    }
    
    /**
     * Return the route for a successful logout;
     *
     * @return string
     */
    protected function successfulLogoutRoute(): string
    {
        return route('begin');
    }
    
    /**
     * Return the route when a guest tries to do logged in stuff.
     *
     * @return string
     */
    protected function guestMiddlewareRoute(): string
    {
        return route('login');
    }
    
    /**
     * Test if user can see login form.
     *
     * @return void
     */
    public function testUsersCanSeeLoginForm(): void
    {
        /** @var User $user */
        $res = $this->get($this->loginGetRoute());
        $res->assertSuccessful();
        $res->assertViewIs('auth.login');
    }
    
    /**
     * Test if user cannot see login form while logged in.
     *
     * @return void
     */
    public function testUserCannotSeeLoginFormWhenAuthenticated(): void
    {
        /** @var User $user */
        $user = factory(User::class)->make();
        $res = $this->actingAs($user)->get($this->loginGetRoute());
        $res->assertRedirect($this->successfulLoginRoute());
    }
    
    /**
     * Test if a user can login with the correct credentials.
     *
     * @return void
     */
    public function testUserCanLoginWithCorrectCredentials(): void
    {
        /** @var User $user */
        $user = factory(User::class)
            ->create(
                [
                'password' => bcrypt($password = 'secret'),
                ]
            );
        
        $response = $this->post(
            $this->loginPostRoute(),
            [
                'username' => $user->username,
                'password' => $password,
            ]
        );
        
        $response->assertRedirect($this->successfulLoginRoute());
        $this->assertAuthenticatedAs($user);
    }
    
    /**
     * Test if a user can be remembered.
     *
     * @return void
     * @throws \Exception
     */
    public function testRememberMeFunction(): void
    {
        /** @var User $user */
        $user = factory(User::class)
            ->create(
                [
                    'id'        => random_int(1, 100),
                    'password'  => bcrypt($password = 'secret')
                ]
            );
        
        $response = $this->post(
            '/login',
            [
                'username'  => $user->username,
                'password'  => $password,
                'remember'  => 'on',
            ]
        );
        
        $response->assertRedirect('home');
        // Check for remember me token.
        $value = vsprintf(
            '%s|%s|%s',
            [
                $user->id,
                $user->getRememberToken(),
                $user->password,
            ]
        );
        
        $response->assertCookie(
            \Auth::guard()->getRecallerName(),
            $value
        );
        
        $this->assertAuthenticatedAs($user);
    }
    
    /**
     * Test if a user cannot login with the incorrect credentials.
     *
     * @return void
     */
    public function testUserCannotLoginWithIncorrectPassword(): void
    {
        /** @var User $user */
        $user = factory(User::class)
            ->create(
                [
                    'password'  => bcrypt($password = 'secret'),
                ]
            );
        
        $response = $this->from($this->loginGetRoute())->post(
            $this->loginPostRoute(),
            [
                'username' => $user->username,
                'password' => '1234',
            ]
        );
        
        $response->assertRedirect($this->loginGetRoute());
        $response->assertSessionHasErrors('username');
        $this->assertTrue(session()->hasOldInput('username'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest();
    }
    
    /**
     * Test if a user can not login with an unknown username
     *
     * @return void
     */
    public function testUserCannotLoginWithUnknownUsername(): void
    {
        $response = $this->from($this->loginGetRoute())->post(
            $this->loginPostRoute(),
            [
                'username'  => 'Anonymouse',
                'password'  => 'Secret',
            ]
        );
        
        $response->assertRedirect($this->loginGetRoute());
        $response->assertSessionHasErrors('username');
        $this->assertTrue(session()->hasOldInput('username'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest();
    }
    
    /**
     * Test if a user receives an email with a password reset link.
     *
     * @return void
     */
    public function testUserReceivesAnEmailWithAPAsswordResetLink(): void
    {
        \Notification::fake();
        /** @var User $user */
        $user = factory(User::class)->create();
        
        $response = $this->post(
            '/password/email',
            [
                'email' => $user->email
            ]
        );
    
        $token = \DB::table('password_resets')->first();
        $this->assertNotNull($token);
        
        \Notification::assertSentTo(
            $user,
            ResetPassword::class,
            function ($notification, $channel) use ($token) {
                return \Hash::check($notification->token, $token->token) === true;
            }
        );
    }
    
    /**
     * Test if user cannot log out when not logged in.
     *
     * @return void
     */
    public function testUserCannotLogoutWhenNotAuthenticated(): void
    {
        $response = $this->post($this->logoutRoute());
        $response->assertRedirect($this->successfulLogoutRoute());
        $this->assertGuest();
    }
    
    /**
     * Test if a user can logout.
     *
     * @return void
     */
    public function testUserCanLogout(): void
    {
        $this->be(factory(User::class)->create());
        $response = $this->post($this->logoutRoute());
        $response->assertRedirect($this->successfulLogoutRoute());
        $this->assertGuest();
    }
    
    /**
     * Test if user auth is throttled.
     *
     * @return void
     */
    public function testUserCannotMakeMoreThanFiveAttemptsInOneMinute(): void
    {
        $user = factory(User::class)->create(
            [
                'password' => bcrypt($password = 'secret'),
            ]
        );
        
        foreach (range(0, 5) as $_) {
            $response = $this->from($this->loginGetRoute())->post(
                $this->loginPostRoute(),
                [
                    'username'  => $user->username,
                    'password'  => 'invalid-password',
                ]
            );
        }
        
        $response->assertRedirect($this->loginGetRoute());
        $response->assertSessionHasErrors('username');
        $this->assertContains(
            'Too many login attempts.',
            collect(
                $response
                    ->baseResponse
                    ->getSession()
                    ->get('errors')
                    ->getBag('default')
                    ->get('username')
            )->first()
        );
        $this->assertTrue(session()->hasOldInput('username'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest();
    }
}
