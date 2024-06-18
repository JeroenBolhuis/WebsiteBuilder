<?php

namespace Tests\Browser;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Event;
use App\Models\Media;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class EventPreviewTest extends DuskTestCase
{
    private $adminUser, $test_event;

    public function setUp(): void
    {
        parent::setUp();

        $this->adminUser = User::factory()->create();
        $this->adminUser->assignRole('administrator');

        $this->test_event = new Event([
            'id' => 1,
            'title' => 'Test Event',
            'slug' => 'test-event',
            'media' => new Media([
                'id' => 1,
                'path' => storage_path('app/testing/medialibrary/ace.png'),
                'alt' => 'Logo'
            ]),
            'date' => Carbon::now()->format('Y-m-d'),
            'start_time' => Carbon::now()->addHour(),
            'end_time' => Carbon::now()->addHour(2)
        ]);
    }

    /**
     * Test, beheerder maakt een evenement aan en bekijkt de preview daarvan.
     */
    public function testPreviewEvent(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUser)
                ->visit(route('event.create'))
                ->type('input[name=title]', $this->test_event->title)
                ->script('document.querySelector(\'input[name=image_id]\').value = ' . $this->test_event->media->id . ';');

            $browser->type('input[name=date]', $this->test_event->date)
                ->keys('input[name=start_time]', $this->test_event->start_time->format('h'), $this->test_event->start_time->format('i'), $this->test_event->start_time->format('A'))
                ->keys('input[name=end_time]', $this->test_event->start_time->format('h'), $this->test_event->start_time->format('i'), $this->test_event->start_time->format('A'))
                ->click('button.preview-button')
                ->pause(1000)
                ->driver->switchTo()->window(collect($browser->driver->getWindowHandles())->last());

            $browser->assertSee($this->test_event->title);
        });
    }

    /**
     * Test, gebruiker bekijkt de evenement pagina.
     */
    public function testPreviewNotSavedEvent(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUser)
                ->visit(route('event.create'))
                ->type('input[name=title]', $this->test_event->title)
                ->script('document.querySelector(\'input[name=image_id]\').value = ' . $this->test_event->media->id . ';');

            $browser->type('input[name=date]', $this->test_event->date)
                ->keys('input[name=start_time]', $this->test_event->start_time->format('h'), $this->test_event->start_time->format('i'), $this->test_event->start_time->format('A'))
                ->keys('input[name=end_time]', $this->test_event->start_time->format('h'), $this->test_event->start_time->format('i'), $this->test_event->start_time->format('A'))
                ->click('button.preview-button')
                ->pause(1000)
                ->driver->switchTo()->window(collect($browser->driver->getWindowHandles())->last());

            $browser->assertSee($this->test_event->title);

            $browser->visit(route('event.index'))
                ->assertDontSee($this->test_event->title);

            $browser->visit(route('event.show', $this->test_event->slug))
                ->assertSee('404');

            $this->assertTrue(Event::all()->count() == 0);
        });
    }
}
