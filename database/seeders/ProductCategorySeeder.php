<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Anime & Manga',
            'Superhero',
            'Video Games',
            'Pakaian Adat',
            'Horror & Halloween'
        ];

        foreach ($categories as $cat) {
            ProductCategory::create([
                'name' => $cat,
                'slug' => Str::slug($cat),
            ]);
        }
    }
}