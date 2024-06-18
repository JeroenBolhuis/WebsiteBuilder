<?php

namespace Tests\Browser;

use App\Models\Page;
use App\Models\Media;
use App\Models\Template;
use App\Models\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class MediaUrlTest extends DuskTestCase
{
    private $adminUser, $page, $template, $media;

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

        $this->template = Template::where('name', 'Media')->first();

        $this->media = new Media([
            'filename' => 'ace.png',
            'alt_text' => 'Media image alt text',
            'file_path' => storage_path('app/testing/medialibrary/ace.png'),
        ]);

        $this->media->css_selector = 'img[alt="' . $this->media->alt_text . '"]';
    }

    private function attachTemplateToPage(string $mediaUrl = ''): void
    {
        $this->page->templates()->attach($this->template, ['data' => json_encode(['afbeelding' => '1', 'media_url' => $mediaUrl, 'media_title' => $mediaUrl, 'width' => '100']), 'order' => 1]);
    }

    private function addImage(Browser $browser): void
    {
        $browser->loginAs($this->adminUser)
            ->visit(route('media.create'))
            ->attach('input#media', $this->media->file_path)
            ->type('input#alt', $this->media->alt_text)
            ->press('button#upload')
            ->waitFor('img[alt="' . $this->media->alt_text . '"]');
    }

    public function testAddNoUrlToImage(): void
    {
        $this->attachTemplateToPage();

        $this->browse(function (Browser $browser) {
            $this->addImage($browser);

            $browser->visit(route('page.show', [$this->page->slug]))
                ->assertPresent($this->media->css_selector)
                ->click($this->media->css_selector)
                ->driver->switchTo()->window(collect($browser->driver->getWindowHandles())->last());

            $browser->assertUrlIs(route('page.show', [$this->page->slug]))
                ->assertPresent($this->media->css_selector);
        });
    }

    public function testAddUrlToImage(): void
    {
        $this->attachTemplateToPage('youtube.com');

        $this->browse(function (Browser $browser) {
            $this->addImage($browser);

            $browser->visit(route('page.show', [$this->page->slug]))
                ->assertPresent($this->media->css_selector)
                ->click($this->media->css_selector)
                ->driver->switchTo()->window(collect($browser->driver->getWindowHandles())->last());

            $browser->assertUrlIs('https://www.youtube.com/')
                ->assertMissing($this->media->css_selector);
        });
    }
}
