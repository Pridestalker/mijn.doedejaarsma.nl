<?php

namespace Tests\Feature\Auth;

use App\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class EmailVerificationTest
 *
 * @category TestCase
 * @package  Tests\Feature\Auth
 * @author   Mitch Hijlkema <mitchhijlkema@hotmail.com>
 * @license  http://opensource.org/licenses/MIT MIT
 * @link     https://phpunit.de/
 */
class EmailVerificationTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * The verification route.
     *
     * @var string
     */
    protected $verificationVerifyRouteName = 'verification.verify';
    
    /**
     * The route after successful verification.
     *
     * @return string
     */
    protected function successfulVerificationRoute(): string
    {
        return route('home');
    }
    
    /**
     * The route to get your notice.
     *
     * @return string
     */
    protected function verificationNoticeRoute(): string
    {
        return route('verification.notice');
    }
    
    /**
     * The check for a verification route.
     *
     * @param int $id The id.
     *
     * @return mixed
     */
    protected function validVerificationVerifyRoute($id): string
    {
        return \URL::signedRoute($this->verificationVerifyRouteName, ['id' => $id]);
    }
    
    /**
     * A false verification route
     *
     * @param int $id The id.
     *
     * @return string
     */
    protected function invalidVerificationVerifyRoute($id): string
    {
        return route(
            $this->verificationVerifyRouteName,
            [
                'id' => $id
            ]
        ) . '?signature=invalid-signature';
    }
    
    /**
     * The route to resend your verification email.
     *
     * @return string
     */
    protected function verificationResendRoute(): string
    {
        return route('verification.resend');
    }
    
    /**
     * The login route helper.
     *
     * @return string
     */
    protected function loginRoute(): string
    {
        return route('login');
    }
    
    /**
     * Test if guest cannot get verification notice.
     *
     * @return void
     */
    public function testGuestCannotSeeTheVerificationNotice(): void
    {
        $response = $this->get($this->verificationNoticeRoute());
        
        $response->assertRedirect($this->loginRoute());
    }
    
    /**
     * Test if the user gets the notice when not verified.
     *
     * @return void
     */
    public function testUserSeesTheVerificationNoticeWhenNotVerified(): void
    {
        $user = factory(User::class)->create(
            [
                'email_verified_at' => null,
            ]
        );
        
        $response = $this->actingAs($user)->get($this->verificationNoticeRoute());
        
        $response->assertStatus(200);
        $response->assertViewIs('auth.verify');
    }
    
    /**
     * Test if the user can not see the notification when verified.
     *
     * @return void
     */
    public function testVerifiedUserIsRedirectedHomeWhenVisitingVerificationNoticeRoute(): void
    {
        $user = factory(User::class)->create(
            [
                'email_verified_at' => now(),
            ]
        );
        
        $response = $this->actingAs($user)->get($this->verificationNoticeRoute());
        
        $response->assertRedirect($this->successfulVerificationRoute());
    }
    
    /**
     * Test if guest user cannot see the verificiation route.
     *
     * @return void
     */
    public function testGuestCannotSeeTheVerificationVerifyRoute(): void
    {
        factory(User::class)->create(
            [
                'id' => 1,
                'email_verified_at' => null,
            ]
        );
        
        $response = $this->get($this->validVerificationVerifyRoute(1));
        $response->assertRedirect($this->loginRoute());
    }
    
    /**
     * Test if a user cannot verify other user.
     *
     * @return void
     */
    public function testUserCannotVerifyOthers(): void
    {
        $user = factory(User::class)->create(
            [
                'id' => 1,
                'email_verified_at' => null,
            ]
        );
        
        $user2 = factory(User::class)->create(
            [
                'id' => 2,
                'email_verified_at' => null
            ]
        );
        
        $response = $this
            ->actingAs($user)
            ->get($this->validVerificationVerifyRoute(2));
        
        $response->assertForbidden();
        $this->assertFalse($user2->fresh()->hasVerifiedEmail());
    }
    
    /**
     * Test if user is redirected to the correct route after verification.
     *
     * @return void
     */
    public function testUserIsRedirectedToCorrectRouteWhenAlreadyVerified(): void
    {
        $user = factory(User::class)->create(
            [
                'email_verified_at' => now(),
            ]
        );
        
        $response = $this
            ->actingAs($user)
            ->get($this->validVerificationVerifyRoute($user->id));
        
        $response->assertRedirect($this->successfulVerificationRoute());
    }
    
    /**
     * Test if a route is forbidden when verification signature is incorrect.
     *
     * @return void
     */
    public function testForbiddenIsReturnedWhenSignatureIsInvalidInVerificationVerfyRoute(): void
    {
        $user = factory(User::class)->create(
            [
                'email_verified_at' => now(),
            ]
        );
        
        $response = $this->actingAs($user)->get($this->invalidVerificationVerifyRoute($user->id));
        
        $response->assertStatus(403);
    }
    
    /**
     * Test users can verify self.
     *
     * @return void
     */
    public function testUserCanVerifyThemselves(): void
    {
        $user = factory(User::class)->create(
            [
                'email_verified_at' => null,
            ]
        );
        
        $response = $this
            ->actingAs($user)
            ->get(
                $this->validVerificationVerifyRoute(
                    $user->id
                )
            );
        
        $response->assertRedirect($this->successfulVerificationRoute());
        $this->assertNotNull($user->fresh()->email_verified_at);
    }
    
    /**
     * Test if guest cannot resend a verification email.
     *
     * @return void
     */
    public function testGuestCannotResendAVerificationEmail(): void
    {
        $response = $this->get($this->verificationResendRoute());
        $response->assertRedirect($this->loginRoute());
    }
    
    /**
     * Test if user gets correctly redirected when verified.
     *
     * @return void
     */
    public function testUserIsRedirectedToCorrectRouteIfAlreadyVerified(): void
    {
        $user = factory(User::class)->create(
            [
                'email_verified_at' => now(),
            ]
        );
        
        $response = $this->actingAs($user)->get($this->verificationResendRoute());
        $response->assertRedirect($this->successfulVerificationRoute());
    }
    
    /**
     * Test if a user can resend the verification email.
     *
     * @return void
     */
    public function testUserCanResendAVerificationEmail(): void
    {
        Notification::fake();
        $user = factory(User::class)->create(
            [
                'email_verified_at' => null,
            ]
        );
        
        $response = $this
            ->actingAs($user)
            ->from($this->verificationNoticeRoute())
            ->get($this->verificationResendRoute());
        
        Notification::assertSentTo($user, VerifyEmail::class);
        $response->assertRedirect($this->verificationNoticeRoute());
    }
}
