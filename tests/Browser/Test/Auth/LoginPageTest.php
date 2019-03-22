<?php

namespace Tests\Browser\Test\Auth;

use Laravel\Dusk\Browser;
use Tests\Browser\Pages\Auth\Login;
use Tests\DuskTestCase;

class LoginPageTest extends DuskTestCase
{
    
    /**
     * @test
     * @testdox Page has the login form
     */
    public function hasLoginForm(): void
    {
        $this->browse(
            function (Browser $browser) {
                $browser->visit(new Login());
                $this->assertNotNull($browser->element('form[method=POST]'));
            }
        );
    }
    
    /**
     * @test
     * @testdox Page has email input and label
     */
    public function hasEmailInput(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Login());
            $this->assertNotNull($browser->element('label[for=email]'));
            $this->assertNotNull($browser->element('input[name=email]'));
        });
    }
    
    /**
     * @test
     * @testdox Page has password input and label
     */
    public function hasPasswordInput(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Login());
            $this->assertNotNull($browser->element('label[for=password]'));
            $this->assertNotNull($browser->element('input[name=password]'));
        });
    }
    
    /**
     * @test
     * @testdox Page has remember me input and label
     */
    public function hasRememberMeInput(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Login());
            $this->assertNotNull($browser->element('label[for=remember]'));
            $this->assertNotNull($browser->element('#remember'));
        });
    }
    
    /**
     * @test
     * @testdox Page has submit button
     */
    public function hasSubmitButton(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Login());
            $this->assertNotNull($browser->element('button[type=submit]'));
        });
    }
    
    /**
     * @test
     * @testdox Page has remember me input and label
     */
    public function hasPasswordForgotLink(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Login())
	            ->assertSee('Forgot Your Password?');
        });
    }
}
