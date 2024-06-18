<?php

namespace Tests\Browser;

use App\Models\Page;
use App\Models\Template;
use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class CustomHtmlTest extends DuskTestCase
{
    private $adminUser, $page;

    public function setUp(): void
    {
        parent::setUp();

        $this->adminUser = User::factory()->create();
        $this->adminUser->assignRole('administrator');

        $this->page = Page::factory()->create([
            'title' => 'Ticket shop',
            'slug' => 'tickets',
            'isActive' => true,
        ]);

        $this->page->templates()->attach(
            Template::where('name', 'CustomHTML')->first(),
            [
                'data' => json_encode(['html' => '<h1>HELLO WORLD</h1>']),
                'order' => 1
            ]
        );
    }

    /**
     * test, klant verifieerd dat de custom html op de pagina te zien is, waar deze is toegevoegd.
     */
    public function testCustomHtmlVisible(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUser->id)
                ->visitRoute('page.show', ['slug' => $this->page->slug])
                ->assertSee('HELLO WORLD');
        });
    }

    /**
     * test, beheerder past de custom html aan en verifieerd dat de nieuwe html op de pagina te zien is.
     */
    public function testEditCustomHtml(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUser->id)
                ->visitRoute('page.edit', ['page' => $this->page])
                ->assertSee('HELLO WORLD')
                ->type('html', '<h1 id="testing-target">Edit Test</h1>')
                ->press('.mt-5, button[type="submit"]')
                ->waitFor('.alert')

                ->visitRoute('page.show', ['slug' => $this->page->slug])
                ->assertPresent('#testing-target');
        });
    }
}
