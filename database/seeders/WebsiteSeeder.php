<?php

namespace Database\Seeders;

use App\Models\Website;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WebsiteSeeder extends Seeder
{

    public function run(): void
    {
        Website::create([
            'name' => 'Tech News',
            'url' => 'https://technews.com',
        ]);

        Website::create([
            'name' => 'Fashion Blog',
            'url' => 'https://fashionblog.com',
        ]);

        Website::create([
            'name' => 'Science Hub',
            'url' => 'https://sciencehub.com',
        ]);
    }
}
