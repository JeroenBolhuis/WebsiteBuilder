<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;
use App\Models\Page;
use App\Models\Template;
use App\Models\TemplateCategory;

class TemplateCategoryAccordionTest extends DuskTestCase
{
    private $adminUser, $page, $templates, $categories;

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

        $this->templates = Template::All();
        $this->categories = TemplateCategory::all();
    }

    /**
     * Test, beheerder ziet geen templates in de accordions.
     */
    public function testSeeNoTemplatesAtFirst(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUser)
                ->visit(route('page.edit', [$this->page]));

            foreach ($this->templates as $template) {
                $browser->assertDontSeeIn("#template-{$template->id}", __($template->name));
            }
        });
    }

    /**
     * Test, beheerder ziet alle templates in de accordions na het openen van alle accordions.
     */
    public function testSeeAllTemplatesAfterOpeningAllAccordions(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUser)
                ->visit(route('page.edit', [$this->page]));

            foreach ($this->categories as $category) {
                $categoryId = $category->id;
                $categorizedTemplates = $this->templates->where('template_category_id', $category->id);

                $browser->assertSee($category->name)
                    ->click("[data-accordion-target='.accordion-$categoryId']")
                    ->waitFor("#template-" . $categorizedTemplates->first()->id, 1); // Wait for the first template to appear

                foreach ($categorizedTemplates as $categorizedTemplate) {
                    $browser->assertSeeIn("#template-{$categorizedTemplate->id}", __($categorizedTemplate->name));
                }
            }
        });
    }
}
