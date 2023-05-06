<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		Page::truncate();
		Page::factory()->create(['type' => 'home', 'meta_title' => 'Inicio']);
		Page::factory()->create(['type' => 'offers', 'meta_title' => 'Ofetas']);
		Page::factory()->create(['type' => 'combos', 'meta_title' => 'Combos']);
		Page::factory()->create(['type' => 'assemblies', 'meta_title' => 'Ensambles']);
		Page::factory()->create(['type' => 'contact', 'meta_title' => 'Contáctenos']);
		Page::factory()->create(['type' => 'search',]);
	}
}
