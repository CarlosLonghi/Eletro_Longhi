<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Brand::factory()
            ->createMany([
                ['name' => 'Toshiba'],
                ['name' => 'LG'],
                ['name' => 'Panasonic'],
                ['name' => 'Sony'],
                ['name' => 'Hitachi'],
                ['name' => 'Philips'],
                ['name' => 'Samsung'],
            ]);
    }
}
