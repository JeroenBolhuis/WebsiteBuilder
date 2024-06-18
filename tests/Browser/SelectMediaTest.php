<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Media;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class SelectMediaTest extends DuskTestCase
{
    private $adminUser;

    public function setUp(): void
    {
        parent::setUp();

        $this->adminUser = User::factory()->create();
        $this->adminUser->assignRole('administrator');
    }

    /**
     * Test to check if media can be selected with quotes in the alt text.
     */
    public function testMediaSelectWithApostrophe(): void
    {
        $media = Media::create([
            'filename' => 'test.jpg',
            'alt_text' => "This is a 'test' alt text",
        ]);

        $media->css_selector = 'img[alt="' . $media->alt_text . '"]';

        $this->browse(function (Browser $browser) use ($media) {
            $browser->loginAs($this->adminUser)
                ->visit(route('footer.index'))
                ->click('form.footer-form .open-library-modal')
                ->waitForText($media->alt_text)
                ->click('img[alt="' . $media->alt_text . '"]')
                ->click('form.footer-form button:not([type="button"])');

            $browser->visit('/')
                ->assertSourceHas($media->alt_text);
        });
    }
}
