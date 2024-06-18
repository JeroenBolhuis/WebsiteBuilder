<?php

namespace Tests\Browser;

use App\Models\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class LinkPageTest extends DuskTestCase
{
    private $adminUser;

    public function setUp(): void
    {
        parent::setUp();

        $this->adminUser = User::factory()->create();
        $this->adminUser->assignRole('administrator');
    }

    private function AddPage(Browser $browser): void
    {
        $browser->loginAs($this->adminUser)
            ->visit(route('page.index'))
            ->clickLink('Nieuwe pagina')
            ->type('title', 'test')
            ->type('slug', 'test')
            ->press('Aanmaken')
            ->press('Tekstveld')
            ->waitFor('.accordion-2 button[onclick="addTemplateToPage(1)"]')
            ->click('.accordion-2 button[onclick="addTemplateToPage(1)"]')
            ->waitFor('.ql-link')
            ->click('.ql-link')
            ->waitForText('Maak een link')
            ->type('customlink-text', 'Google')
            ->type('customlink-url', 'https://www.google.com')
            ->type('customlink-title', 'Test')
            ->click('button.bg-indigo-600')
            ->waitFor('button.bg-blue-500')
            ->click('button.bg-blue-500');
    }

    /*
    * Test, Kijk of er een tab voor Gerefereerde pagina's is
    */
    public function testSeeLink(): void
    {
        $this->browse(function (Browser $browser) {
            $this->AddPage($browser);

            $browser->assertSee('Gerefereerde pagina\'s');
        });
    }

    /*
    * Test, Kijk of er een link in de tab voor Gerefereerde pagina's is
    */
    public function testSeeAddedPage(): void
    {
        $this->browse(function (Browser $browser) {
            $this->AddPage($browser);

            $browser->waitForText('https://www.google.com')
                ->assertSee('https://www.google.com');
        });
    }

    /*
    * Test, Kijk of de link uit de tab voor Gerefereerde pagina's verwdijnd
    */
    public function testSeeDeletedPage(): void
    {
        $this->browse(function (Browser $browser) {
            $this->AddPage($browser);

            $browser->waitForText('https://www.google.com')
                ->assertSee('https://www.google.com')
                ->waitFor('button.remove-button')
                ->click('button.remove-button')
                ->waitUntilMissingText('https://www.google.com')
                ->assertDontSee('https://www.google.com');
        });
    }
}
