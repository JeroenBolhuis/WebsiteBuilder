<?php

namespace Tests\Browser;

use App\Models\Media;
use App\Models\Page;
use App\Models\Settings;
use App\Models\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class NavbarLogoSettingTest extends DuskTestCase
{
    private $adminUser, $page;

    public function setUp(): void
    {
        parent::setUp();

        $this->adminUser = User::factory()->create();
        $this->adminUser->assignRole('administrator');

        $this->page = Page::factory()->create([
            'title' => 'Home',
            'slug' => 'home',
            'isActive' => true,
        ]);
    }

    /**
     * Test, beheerder wijzigt de navigatiebalk logo met een geldige logo bestand.
     * Test, klant ziet het juiste logo op zijn navigatiebalk.
     */
    public function testLogoSettingWithvalidExtensionAndShowLogo(): void
    {
        $settings = Settings::first();

        $this->browse(function (Browser $browser) use ($settings) {
            $this->assertTrue($settings->image_id === null);

            $browser->visit(route('page.show', [$this->page->slug]))
                ->assertSee('WTB SV HET KOPPEL')
                ->assertNotPresent('img[alt="Logo"]');

            $browser->loginAs($this->adminUser)
                ->visit(route('admin.settings'))
                ->press('form[action="' . route('update-logo') . '"] button.open-library-modal')
                ->waitForLivewire()
                ->click('#medialib div.modal-box > div:first-of-type > a')
                ->waitForLivewire()
                ->attach('#medialib input#uploadMedia', storage_path('app/testing/medialibrary/ace.png'))
                ->waitForLivewire()
                ->type('#medialib input#alt', 'Logo')
                ->waitFor('#medialib button#upload')
                ->press('#medialib button#upload')
                ->waitFor('form[action="' . route('update-logo') . '"] img[alt="Logo"]')
                ->check('form[action="' . route('update-logo') . '"] input#use_logo')
                ->press('form[action="' . route('update-logo') . '"] button[type="submit"]');

            $browser->visit(route('page.show', [$this->page->slug]))
                ->assertPresent('img[alt="Logo"]')
                ->assertDontSee('WTB SV HET KOPPEL');

            $settings = $settings->fresh();
            $this->assertTrue($settings->use_logo && $settings->image_id !== null);
        });
    }

    /**
     * Test, beheerder zet het logo 'uit' en ziet de tekst “WTB SV Het Koppel“ in de navigatiebalk.
     */
    public function testLogoSettingOffReplacementTextInNavbar(): void
    {
        $settings = Settings::first();

        $this->browse(function (Browser $browser) use ($settings) {
            $browser->loginAs($this->adminUser)
                ->visit(route('admin.settings'))
                ->press('form[action="' . route('update-logo') . '"] button.open-library-modal')
                ->waitForLivewire()
                ->click('#medialib div.modal-box > div:first-of-type > a')
                ->waitForLivewire()
                ->attach('#medialib input#uploadMedia', storage_path('app/testing/medialibrary/ace.png'))
                ->waitForLivewire()
                ->type('#medialib input#alt', 'Logo')
                ->waitFor('#medialib button#upload')
                ->press('#medialib button#upload')
                ->waitFor('form[action="' . route('update-logo') . '"] img[alt="Logo"]')
                ->uncheck('form[action="' . route('update-logo') . '"] input#use_logo')
                ->press('form[action="' . route('update-logo') . '"] button[type="submit"]');

            $browser->visit(route('page.show', [$this->page->slug]))
                ->assertSee('WTB SV HET KOPPEL')
                ->assertNotPresent('img[alt="Logo"]');

            $this->assertTrue(!$settings->fresh()->use_logo);
        });
    }

    /**
     * Test, beheerder wijzigt de navigatiebalk logo met een ongeldige logo bestand
     */
    public function testLogoSettingWithInvalidExtension(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUser)
                ->visit(route('admin.settings'))
                ->press('form[action="' . route('update-logo') . '"] button.open-library-modal')
                ->waitForLivewire()
                ->click('#medialib div.modal-box > div:first-of-type > a')
                ->waitForLivewire()
                ->attach('#medialib input#uploadMedia', storage_path('app/testing/medialibrary/Unity.gitignore.example'))
                ->waitForLivewire()
                ->type('#medialib input#alt', 'Logo')
                ->waitFor('#medialib button#upload')
                ->press('#medialib button#upload')
                ->waitFor('p.text-red-500.text-sm')
                ->assertSee('Upload media moet een bestand zijn van het bestandstype jpeg, jpg, png, gif, svg, mp4.');

            $this->assertTrue(Media::where('filename', 'Unity.gitignore.example')->doesntExist());
        });
    }
}
