<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Template;
use App\Models\TemplateCategory;

class TemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TemplateCategory::insert([
            ['name' => 'Landingspagina'],
            ['name' => 'Tekstveld'],
            ['name' => 'Media'],
            ['name' => 'Evenementen'],
            ['name' => 'Posts'],
            ['name' => 'Sponsoren'],
            ['name' => 'Geavanceerd']
        ]);

        $categoryIds = TemplateCategory::pluck('id', 'name')->toArray();

        // Tekstveld templates
        Template::factory()->create([
            'name' => 'TextField',
            'description' => 'Een template met een enkel tekstveld.',
            'template_category_id' => $categoryIds['Tekstveld'],
        ]);

        Template::factory()->create([
            'name' => 'TextLeftTextRight',
            'description' => 'Een template met een tekst links en een tekst rechts.',
            'template_category_id' => $categoryIds['Tekstveld'],
        ]);

        Template::factory()->create([
            'name' => 'TextLeftMediaRight',
            'description' => 'Een template met een tekst links en een media rechts.',
            'template_category_id' => $categoryIds['Tekstveld'],
        ]);

        Template::factory()->create([
            'name' => 'MediaLeftTextRight',
            'description' => 'Een template met een media links en een tekst rechts.',
            'template_category_id' => $categoryIds['Tekstveld'],
        ]);

        // Media templates
        Template::factory()->create([
            'name' => 'Media',
            'description' => 'Een template met een enkele media item.',
            'template_category_id' => $categoryIds['Media'],
        ]);

        Template::factory()->create([
            'name' => 'Albums',
            'description' => 'Een template met een weergave van meerdere albums',
            'template_category_id' => $categoryIds['Media'],
        ]);

        Template::factory()->create([
            'name' => 'SingleAlbum',
            'description' => 'Een template met een enkel album.',
            'template_category_id' => $categoryIds['Media'],
        ]);

        // Landingspagina templates
        Template::factory()->create([
            'name' => 'Hero',
            'description' => 'Een template met een hero afbeelding en tekst.',
            'template_category_id' => $categoryIds['Landingspagina'],
        ]);

        // Evenementen templates
        Template::factory()->create([
            'name' => 'RecentEvents',
            'description' => 'Een template met de 4 meest recente evenementen.',
            'template_category_id' => $categoryIds['Evenementen'],
        ]);

        Template::factory()->create([
            'name' => 'SingleEvent',
            'description' => 'Een template met een enkel evenement.',
            'template_category_id' => $categoryIds['Evenementen'],
        ]);

        // Posts templates
        Template::factory()->create([
            'name' => 'PostsFeed',
            'description' => 'Een template met een feed aan alle actieve posts.',
            'template_category_id' => $categoryIds['Posts'],
        ]);

        Template::factory()->create([
            'name' => 'SinglePost',
            'description' => 'Een template met een enkele post.',
            'template_category_id' => $categoryIds['Posts'],
        ]);

        // Sponsoren templates
        Template::factory()->create([
            'name' => 'SponsorOverview',
            'description' => 'Een template met een een overzicht van alle sponsoren.',
            'template_category_id' => $categoryIds['Sponsoren'],
        ]);

        Template::factory()->create([
            'name' => 'SponsorSlider',
            'description' => 'Een template met een afbeelding slider van alle sponsoren.',
            'template_category_id' => $categoryIds['Sponsoren'],
        ]);

        Template::factory()->create([
            'name' => 'SponsorOverviewAlternative',
            'description' => 'Een template met een een overzicht van alle sponsoren. Drie sponsoren per rij.',
            'template_category_id' => $categoryIds['Sponsoren'],
        ]);

        Template::factory()->create([
            'name' => 'AllEvents',
            'description' => 'Een template met een overzicht van alle evenementen.',
            'template_category_id' => $categoryIds['Evenementen'],
        ]);

        Template::factory()->create([
            'name' => 'CustomHTML',
            'description' => 'Plaats uw eigen HTML inhoud op de pagina voor bijvoorbeeld integraties met andere sites.',
            'template_category_id' => $categoryIds['Geavanceerd']
        ]);
    }
}
