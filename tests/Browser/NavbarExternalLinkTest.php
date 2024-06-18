<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;
use App\Models\Page;
use App\Models\NavItem;

class NavbarExternalLinkTest extends DuskTestCase
{
    private $adminUser, $page;

    /**
     * A Dusk test example.
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->adminUser = User::factory()->create();
        $this->adminUser->assignRole('administrator');

        $this->page = Page::factory()->create([
            'title' => 'Home',
            'slug' => 'home',
            'isActive' => true,
            'isHomepage' => true,
        ]);
    }

    public function testCreateNavItem(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUser)
                ->visit(route('nav.create'))
                ->type('input#name', 'google')
                ->click('label.isExternalCheckbox')
                ->waitFor('input#url')
                ->type('input#url', 'https://www.google.com/')
                ->press('Aanmaken')
                ->assertSeeIn('tr.parent-nav', 'https://www.google.com/')
                ->visit('/')
                ->assertAttribute('nav a:first-of-type', 'href', 'https://www.google.com/');
        });
    }

    public function testCreateSubNavItem(): void
    {
        $nav = NavItem::factory()->create([
            'name' => 'parentNav',
            'page_id' => $this->page->id,
            'order' => 1,
        ]);

        $this->browse(function (Browser $browser) use ($nav) {
            $browser->loginAs($this->adminUser)
                ->visit(route('nav.create', [$nav->id]))
                ->type('input#name', 'google')
                ->click('label.isExternalCheckbox')
                ->waitFor('input#url')
                ->type('input#url', 'https://www.google.com/')
                ->press('Aanmaken')
                ->assertSeeIn('tr.child-nav', 'https://www.google.com/')
                ->visit('/')
                ->assertAttribute('nav div.dropdown-content:first-of-type a:first-of-type', 'href', 'https://www.google.com/');
        });
    }

    public function testCreateWithInvalidUrl(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUser)
                ->visit(route('nav.create'))
                ->type('input#name', 'google')
                ->click('label.isExternalCheckbox')
                ->waitFor('input#url')
                ->type('input#url', 'not a valid url')
                ->press('Aanmaken')
                ->assertSee('Url moet een geldige URL zijn.');
        });
    }
}
