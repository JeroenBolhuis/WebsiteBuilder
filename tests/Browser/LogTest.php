<?php

namespace Tests\Browser;

use App\Models\Log;
use App\Models\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class LogTest extends DuskTestCase
{
    private $adminUser;

    public function setUp(): void
    {
        parent::setUp();

        $this->adminUser = User::factory()->create();
        $this->adminUser->assignRole('administrator');
    }

    /**
     * Test, kijk of er een log wordt gemaakt bij het aanmaken van een nieuwe post.
     */
    public function testLogOnNewPost(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUser)
                ->visit(route('post.create'))
                ->type('title', 'Test Post')
                ->press('Aanmaken')
                ->visit(route('admin.logbook'))
                ->assertSee('created post')
                ->click('@bekijk')
                ->assertSee('Test Post');
        });
    }

    /**
     * Test, kijk of er een log wordt gemaakt bij het aanmaken van een nieuwe pagina.
     */
    public function testLogOnUpdateFooter(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUser)
                ->visit(route('footer.index'))
                ->type('title', 'Test Page')
                ->type('content', 'Test Content')
                ->press('Opslaan')
                ->visit(route('admin.logbook'))
                ->assertSee('created footers')
                ->click('@bekijk')
                ->assertSee('Test Content');
        });
    }

    /**
     * Test, De beheerder met benodigde rechten navigeert naar de logboek pagina
     */
    public function testLogPermissionAllowedUser(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUser)
                ->visit(route('admin.logbook'))
                ->assertSee('Logboek');
        });
    }

    /**
     * Test, De beheerder zonder de benodigde rechten navigeert naar de logboek pagina
     */
    public function testLogPermissionDisallowedUser(): void
    {
        $this->adminUser->removeRole('administrator');
        $this->adminUser->revokePermissionTo('see log');
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUser)
                ->visit(route('admin.logbook'))
                ->assertSee('403');
        });
    }

    /**
     * Test, kijk of de beheerder een log kan favoriten in het logboek.
     */
    public function testSetLogFavorite(): void
    {
        $log = Log::first();
        $formSelector = 'form[action="' . route('admin.logbook.favorite', ['log' => $log->id]) . '"]';

        $this->browse(function (Browser $browser) use ($log, $formSelector) {
            $browser->loginAs($this->adminUser)
                ->visit(route('admin.logbook'))
                ->assertPresent("$formSelector i.fa-regular")
                ->press("$formSelector button")
                ->assertPresent("$formSelector i.fa-solid");

            $this->assertTrue($this->adminUser->favoriteLogs->contains($log));
        });
    }

    /**
     * Test, kijk of de beheerder een favoriete log kan unfavoriten in het logboek.
     */
    public function testDeselectLogFavorite(): void
    {
        $log = Log::first();
        $formSelector = 'form[action="' . route('admin.logbook.favorite', ['log' => $log->id]) . '"]';

        $this->adminUser->favoriteLogs()->attach($log);

        $this->browse(function (Browser $browser) use ($log, $formSelector) {
            $browser->loginAs($this->adminUser)
                ->visit(route('admin.logbook'))
                ->assertPresent("$formSelector i.fa-solid")
                ->press("$formSelector button")
                ->assertMissing("$formSelector i.fa-solid");

            $this->assertFalse($this->adminUser->favoriteLogs->contains($log));
        });
    }
}
