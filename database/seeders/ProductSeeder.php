<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use App\Models\Store;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $store = Store::first(); 
        $categories = ProductCategory::all();

        if (!$store || $categories->isEmpty()) {
            return;
        }

        $productNames = [
            'Kostum Naruto Sage Mode',
            'Armor Iron Man MK-50',
            'Gaun Elsa Frozen',
            'Seragam Attack on Titan',
            'Kostum Spider-Man No Way Home',
            'Kebaya Modern Merah',
            'Jubah Harry Potter Gryffindor',
            'Kostum Valak The Nun',
            'Genshin Impact Raiden Shogun',
            'Topeng Squid Game Soldier'
        ];

        foreach ($productNames as $index => $name) {
            $product = Product::create([
                'store_id' => $store->id,
                'product_category_id' => $categories->random()->id,
                'name' => $name,
                'slug' => Str::slug($name) . '-' . Str::random(5),
                'price' => rand(150000, 1500000),
                'stock' => rand(5, 50),
                'weight' => rand(500, 2000),
                'condition' => $index % 2 == 0 ? 'new' : 'second',
                'description' => "Ini adalah deskripsi lengkap untuk produk {$name}. Bahan berkualitas tinggi.",
            ]);

            ProductImage::create([
                'product_id' => $product->id,
                
                'image' => 'assets/images/placeholder.png', //nanti bisa diganti ygy
                
                'is_thumbnail' => true,
            ]);
        }
    }
}