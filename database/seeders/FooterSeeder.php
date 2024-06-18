<?php

namespace Database\Seeders;

use App\Models\Footer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FooterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Footer::all()->count() == 0) {
            Footer::create([
                'title' => "WERKTUIGBOUWKUNDIGE STUDIEVERENIGING HET KOPPEL", 
                'content' => "Laten we in contact komen\ninfo@hetkoppel.nl\nevenementen@hetkoppel.nl\nInsta: @svhetkoppel",
                'enabled' => true,
                'image_id' => null
            ]);
        }
        
    }
}
