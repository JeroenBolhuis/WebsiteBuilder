<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Settings;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Default color values
        Settings::factory()->create([
            'primary_color' => '#232744',
            'secondary_color' => '#ffffff',
            'favicon' => 'favicons/default.ico',
        ]);
    }
}
