<?php

namespace Tests\Browser;

use App\Models\Page;
use App\Models\Sponsor;
use App\Models\Template;
use App\Models\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class SponsorSliderTest extends DuskTestCase
{
    private $adminUser, $page, $template;

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

        $this->template = Template::where('name', 'SponsorSlider')->first();
    }

    private function attachTemplateToPage(): void
    {
        $this->page->templates()->attach($this->template, ['data' => json_encode([]), 'order' => 1]);
    }

    /**
     * Test, klant verifieerd dat de sponsors slider op de pagina te zien is, waar deze is toegevoegd.
     */
    public function testAddSponsorTemplateToPage(): void
    {
        $this->browse(function (Browser $browser) {
            $this->assertFalse($this->template->fresh()->pages()->where('pages.id', $this->page->id)->exists());

            $browser->loginAs($this->adminUser)
                ->visit(route('page.edit', [$this->page]))
                ->assertPresent('div[data-template-id="' . $this->template->id . '"]')
                ->assertPresent('div.active-templates')
                ->script('addTemplateToPage(' . $this->template->id . ')');

            $browser->waitForReload()
                ->assertPresent('div.active-templates div[data-pivot-id="1"]')
                ->assertUrlIs(route('page.edit', [$this->page]));

            $browser->visit(route('page.show', [$this->page->slug]))
                ->assertPresent('div.sponsor-slider');

            $this->assertTrue($this->template->fresh()->pages()->where('pages.id', $this->page->id)->exists());
        });
    }

    /**
     * Test, klant verifieerd dat alle sponsors loge te zien zijn in de loop.
     */
    public function testAllSponsorsInSlider(): void
    {
        $this->attachTemplateToPage();

        for ($i = 0; $i < 5; $i++) {
            Sponsor::factory()->create([
                'name' => 'Sponsor ' . $i,
                'page_id' => $this->page->id,
                'image_id' => null,
            ]);
        }

        $this->browse(function (Browser $browser) {
            $browser->visit(route('page.show', [$this->page->slug]))
                ->assertPresent('div.sponsor-slider');

            foreach (Sponsor::active()->get() as $sponsor) {
                $browser->assertPresent(".sponsor-slider .slide[title=\"$sponsor->name\"]");
            }
        });
    }

    /**
     * Test, klant wordt naar de juiste sponsorpagina gestuurd na het klikken op een sponsor logo.
     */
    public function testSponsorLinkRedirect(): void
    {
        $this->attachTemplateToPage();

        for ($i = 0; $i < 5; $i++) {
            $page = Page::factory()->create([
                'title' => 'Sponsor ' . $i,
                'slug' => 'sponsor-' . $i,
                'isActive' => true,
            ]);

            Sponsor::factory()->create([
                'name' => $page->title,
                'page_id' => $page->id,
                'image_id' => null,
            ]);
        }

        $testSponsor = Sponsor::active()->first();

        $this->browse(function (Browser $browser) use ($testSponsor) {
            $browser->visit(route('page.show', [$this->page->slug]))
                ->assertPresent('div.sponsor-slider')
                ->press(".sponsor-slider .slide[title=\"$testSponsor->name\"]")
                ->assertUrlIs(route('page.show', [$testSponsor->page->slug]));
        });
    }

    /**
     * Test, beheerder maakt een loop aan en vervolgens wordt er een sponsor toegevoegd/verwijderd waar na de loop geüpdatet is met een nieuwe sponsor.
     */
    public function testSponsorsSliderAfterActions(): void
    {
        $this->attachTemplateToPage();

        for ($i = 0; $i < 5; $i++) {
            Sponsor::factory()->create([
                'name' => 'Sponsor ' . $i,
                'page_id' => $this->page->id,
                'image_id' => null,
            ]);
        }

        $this->browse(function (Browser $browser) {
            $browser->visit(route('page.show', [$this->page->slug]))
                ->assertPresent('div.sponsor-slider');

            foreach (Sponsor::active()->get() as $sponsor) {
                $browser->assertPresent(".sponsor-slider .slide[title=\"$sponsor->name\"]");
            }

            $sponsor = Sponsor::active()->first();
            $sponsor->delete();

            $browser->visit(route('page.show', [$this->page->slug]))
                ->assertPresent('div.sponsor-slider')
                ->assertMissing(".sponsor-slider .slide[title=\"$sponsor->name\"]");

            $newSponsor = Sponsor::factory()->create([
                'name' => 'New Sponsor',
                'page_id' => $this->page->id,
                'image_id' => null,
            ]);

            $browser->visit(route('page.show', [$this->page->slug]))
                ->assertPresent('div.sponsor-slider')
                ->assertPresent(".sponsor-slider .slide[title=\"$newSponsor->name\"]")
                ->assertMissing(".sponsor-slider .slide[title=\"$sponsor->name\"]");
        });
    }

    /**
     * Test, Beheerder probeert een loop toe te voegen terwijl er geen sponsors zijn
     */
    public function testAddSponsorTemplateToPageWithoutSponsors(): void
    {
        $this->browse(function (Browser $browser) {
            $this->assertFalse($this->template->fresh()->pages()->where('pages.id', $this->page->id)->exists());

            $browser->loginAs($this->adminUser)
                ->visit(route('page.edit', [$this->page]))
                ->assertPresent('div[data-template-id="' . $this->template->id . '"]')
                ->assertPresent('div.active-templates')
                ->script('addTemplateToPage(' . $this->template->id . ')');

            $browser->waitForReload()
                ->assertPresent('div.active-templates div[data-pivot-id="1"]')
                ->assertUrlIs(route('page.edit', [$this->page]));

            $browser->visit(route('page.show', [$this->page->slug]))
                ->assertPresent('div.sponsor-slider')
                ->assertSee('Er zijn nog geen sponsors.')
                ->assertMissing('.sponsor-slider .slide')
                ->assertMissing('.sponsor-slider .controls');

            $this->assertTrue($this->template->fresh()->pages()->where('pages.id', $this->page->id)->exists());
        });
    }
}
