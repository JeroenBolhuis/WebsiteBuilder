<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\Album;
use App\Models\User;

class MediaAlbumTest extends DuskTestCase
{
    private $adminUser, $album;

    public function setUp(): void
    {
        parent::setUp();

        $this->adminUser = User::factory()->create();
        $this->adminUser->assignRole('administrator');

        $this->album = Album::factory()->create([
            'name' => 'First album',
            'album_date' => '2024-05-22',
            'slug' => 'first-album',
            'isActive' => true,
        ]);
    }

    private function addImageToAlbum(Browser $browser, $altText = 'firstImage'): void
    {
        $browser->click('#add-media')
            ->assertVisible('.parent.media-chooser:last-of-type')
            ->click('.parent.media-chooser:last-of-type button.open-library-modal')
            ->waitForLivewire()
            ->click('#medialib div.modal-box > div:first-of-type > a')
            ->waitForLivewire()
            ->attach('#medialib input#uploadMedia', storage_path('app/testing/medialibrary/ace.png'))
            ->waitForLivewire()
            ->type('#medialib input#alt', $altText)
            ->waitFor('#medialib button#upload')
            ->press('#medialib button#upload')
            ->waitFor('img[alt="firstImage"]');
    }

    /**
     * Test, De beheerder voegt een foto toe aan het archief.
     */
    public function testAddPictureToAlbum(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUser)
                ->visit(route('album.edit', [$this->album->id]));

            $this->addImageToAlbum($browser);

            $browser->press('form[action="' . route('album.update', ['album' => $this->album]) . '"] button[type="submit"]')
                ->visit(route('album.edit', [$this->album->id]))
                ->assertVisible('img[alt="firstImage"]');
        });
    }

    /**
     * Test, De beheerder verwijderd een foto uit het archief.
     */
    public function testRemoveAddedPictureFromAlbum(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUser)
                ->visit(route('album.edit', [$this->album->id]));

            $this->addImageToAlbum($browser);

            $browser->press('form[action="' . route('album.update', ['album' => $this->album]) . '"] button[type="submit"]')
                ->visit(route('album.edit', [$this->album->id]))
                ->assertVisible('img[alt="firstImage"]')
                ->click('button.remove-button')
                ->waitUntilMissing('img[alt="firstImage"]')
                ->press('form[action="' . route('album.update', ['album' => $this->album]) . '"] button[type="submit"]')
                ->visit(route('album.edit', [$this->album->id]))
                ->assertDontSee('img[alt="firstImage"]');
        });
    }

    /**
     * Test, Gebruiker navigeert naar de archiefpagina.
     */
    public function testAlbumPage(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUser)
                ->visit(route('album.edit', [$this->album->id]));

            $this->addImageToAlbum($browser);

            $browser->press('form[action="' . route('album.update', ['album' => $this->album]) . '"] button[type="submit"]')
                ->visit(route('album.show', [$this->album->slug]))
                ->assertVisible('img[alt="firstImage"]');
        });
    }

    public function testAlbumPageSlideshow(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUser)
                ->visit(route('album.edit', [$this->album->id]));

            $this->addImageToAlbum($browser);
            $browser->press('form[action="' . route('album.update', ['album' => $this->album]) . '"] button[type="submit"]')
                ->visit(route('album.edit', [$this->album->id]));
            $this->addImageToAlbum($browser, 'secondImage');

            $browser->press('form[action="' . route('album.update', ['album' => $this->album]) . '"] button[type="submit"]')
                ->visit(route('album.show', [$this->album->slug]))
                ->assertVisible('img[alt="firstImage"]')
                ->assertVisible('img[alt="secondImage"]')
                ->click('#my-gallery > a:first-of-type')
                ->waitFor('.pswp__scroll-wrap button.pswp__button--arrow--next')
                ->assertSee('1 / 2')
                ->press('.pswp__scroll-wrap button.pswp__button--arrow--next')
                ->waitFor('.pswp__scroll-wrap button.pswp__button--arrow--prev')
                ->assertSee('2 / 2');
        });
    }

    /**
     * Test, De beheerder probeert een bestand toe te voegen aan het archief dat geen foto is (bijvoorbeeld een tekstbestand of een uitvoerbaar bestand).
     */
    public function testWrongFileType(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUser)
                ->visit(route('album.edit', [$this->album->id]))
                ->click('#add-media')
                ->assertVisible('.media-chooser')
                ->click('button.open-library-modal')
                ->waitForLivewire()
                ->click('#medialib div.modal-box > div:first-of-type > a')
                ->waitForLivewire()
                ->attach('#medialib input#uploadMedia', storage_path('app/testing/medialibrary/test_file.txt'))
                ->waitFor('#medialib button#upload')
                ->press('#medialib button#upload')
                ->waitFor('.text-red-500')
                ->assertSee('Upload media moet een bestand zijn van het bestandstype jpeg, jpg, png, gif, svg, mp4.');
        });
    }
}
