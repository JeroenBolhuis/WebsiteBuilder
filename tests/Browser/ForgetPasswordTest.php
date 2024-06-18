<?php

namespace Tests\Browser;

use App\Models\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class ForgetPasswordTest extends DuskTestCase
{
    /*
    * Test, Kijk of er een bevestiging is dat de reset email is verstuurd
    */
    public function testForgotPasswordSucces(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(route('admin.index'))
                ->waitForText('Wachtwoord vergeten?')
                ->clickLink('Wachtwoord vergeten?')
                ->waitForText('Wachtwoord resetten')
                ->type('email', User::all()->random()?->email)
                ->press('Wachtwoord resetten')
                ->waitForText('We hebben een e-mail verstuurd met instructies om een nieuw wachtwoord in te stellen.')
                ->assertsee('We hebben een e-mail verstuurd met instructies om een nieuw wachtwoord in te stellen.');
        });
    }

    /*
    * Test, Kijk of er een foutmelding verschijnd wanneer je een email invult die niet bestaat in het database
    */
    public function testForgotPasswordFail(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(route('admin.index'))
                ->waitForText('Wachtwoord vergeten?')
                ->clickLink('Wachtwoord vergeten?')
                ->waitForText('Wachtwoord resetten')
                ->type('email', 'test@gmail.com')
                ->press('Wachtwoord resetten')
                ->waitForText('Email bestaat niet.')
                ->assertSee('Email bestaat niet.');
        });
    }
}
