<?php

namespace Tests\Browser;

use App\Models\Page;
use App\Models\Post;
use App\Models\User;
use App\Models\Sponsor;
use Tests\DuskTestCase;
use App\Models\Template;
use Laravel\Dusk\Browser;

class PostFeedTest extends DuskTestCase
{
    private $adminUser, $page, $template;

    public function setUp(): void
    {
        parent::setUp();

        $this->adminUser = User::factory()->create();
        $this->adminUser->assignRole('administrator');

        $this->page = Page::factory()->create([
            'title' => 'Het Koppel',
            'slug' => 'het-koppel',
            'isActive' => true,
        ]);

        $this->template = Template::where('name', 'PostsFeed')->first();
    }

    private function attachTemplateToPage(): void
    {
        $this->page->templates()->attach($this->template, ['data' => json_encode([]), 'order' => 1]);
    }

    /**
     * Test, klant verifieerd dat de posts feed op de pagina te zien is, waar deze is toegevoegd.
     */
    public function testAddPostFeedTemplateToPage(): void
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
                ->assertSee('Bericht inzenden');

            $this->assertTrue($this->template->fresh()->pages()->where('pages.id', $this->page->id)->exists());
        });
    }

    /**
     * Test, klant verifieerd dat de sponsors te zien zijn in hoeverre dat kan met max 2 sponsors per 3 posts.
     */
    public function testSponsorsInPostsFeed(): void
    {
        $this->attachTemplateToPage();

        for ($i = 0; $i < 5; $i++) {
            Sponsor::factory()->create([
                'name' => 'Sponsor ' . $i,
                'page_id' => $this->page->id,
                'image_id' => null,
            ]);
        }

        for ($i = 0; $i < 15; $i++) {
            Post::factory()->create([
                'title' => 'Post ' . $i,
                'slug' => 'post-' . $i,
                'isActive' => true,
                'description' => 'Post ' . $i . ' description',
            ]);
        }

        $this->browse(function (Browser $browser) {
            $browser->visit(route('page.show', [$this->page->slug]))
                ->assertSee('Bericht inzenden')
                ->assertSee('Sponsors');

            foreach (Sponsor::active()->get() as $sponsor) {
                $browser->assertPresent(".sponsor-slider .slide.post-sponsor[title=\"$sponsor->name\"]");
            }
        });
    }

    /**
     * Test, klant verifieerd dat de sponsors te zien zijn en niet dubbel erin staan tenzij er te weinig sponsors zijn.
     */
    public function testUniqueSponsorsInPostsFeed(): void
    {
        $this->attachTemplateToPage();

        for ($i = 0; $i < 5; $i++) {
            Sponsor::factory()->create([
                'name' => 'Sponsor ' . $i,
                'page_id' => $this->page->id,
                'image_id' => null,
            ]);
        }

        for ($i = 0; $i < 15; $i++) {
            Post::factory()->create([
                'title' => 'Post ' . $i,
                'slug' => 'post-' . $i,
                'isActive' => true,
                'description' => 'Post ' . $i . ' description',
            ]);
        }

        $this->browse(function (Browser $browser) {
            $browser->visit(route('page.show', [$this->page->slug]))
                ->assertSee('Bericht inzenden')
                ->assertSee('Sponsors');

            $browser->assertPresent('.sponsor-slider .slide.post-sponsor', 2);

            $maxOccurances = ceil(
                Post::active()->count() / 4 // Sponsors per 4 posts
                    * 2 // Max 2 sponsors per 3 posts
                    / Sponsor::active()->count() // Amount of sponsors
            );

            foreach (Sponsor::active()->get() as $sponsor) {
                $browser->assertPresent(".sponsor-slider .slide.post-sponsor[title=\"$sponsor->name\"]");

                $sponsorCount = count($browser->elements(".sponsor-slider .slide.post-sponsor[title=\"$sponsor->name\"]"));
                $this->assertLessThanOrEqual($maxOccurances, $sponsorCount, "Sponsor $sponsor->name occurs more than $maxOccurances times.");
            }
        });
    }

    /**
     * Test, klant verifieerd dat er geen sponsors te zien zijn als deze niet in de database zitten.
     */
    public function testnonExistentSponsorsPostFeedTemplate(): void
    {
        $this->attachTemplateToPage();

        for ($i = 0; $i < 15; $i++) {
            Post::factory()->create([
                'title' => 'Post ' . $i,
                'slug' => 'post-' . $i,
                'isActive' => true,
                'description' => 'Post ' . $i . ' description',
            ]);
        }

        $this->browse(function (Browser $browser) {
            $browser->visit(route('page.show', [$this->page->slug]))
                ->assertSee('Bericht inzenden')
                ->assertDontSee('Sponsors');
        });
    }
}
