<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        
        
        
        User::factory()->create([
            'name' => 'Admin Kostum',
            'email' => 'admin@example.com',
            'role' => 'admin',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        
        
        
        
        $member1 = User::factory()->create([
            'name' => 'Sultan Cosplay',
            'email' => 'seller@example.com',
            'role' => 'member',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        
        User::factory()->create([
            'name' => 'Wibu Lovers',
            'email' => 'buyer@example.com',
            'role' => 'member',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        
        
        
        $store = Store::create([
            'user_id' => $member1->id,
            'name' => 'Fantasy Costume Warehouse',
            'logo' => 'stores/costume-logo.png',
            'about' => 'Penyedia kostum terlengkap untuk Cosplay, Halloween, dan Pentas Seni. Kualitas import harga lokal.',
            'phone' => '081299887766',
            'address_id' => '153', 
            'city' => 'Jakarta Selatan',
            'address' => 'Jl. Fatmawati Raya No. 10, Cilandak',
            'postal_code' => '12430',
            'is_verified' => true,
        ]);

        
        
        
        $categories = [];
        $categoryData = [
            'Anime & Cosplay' => 'Karakter anime populer Jepang.',
            'Superhero' => 'Pahlawan super Marvel & DC.',
            'Halloween & Horror' => 'Kostum seram untuk pesta Halloween.',
            'Pakaian Adat' => 'Busana tradisional dari berbagai daerah.',
            'Profesi & Seragam' => 'Kostum polisi, dokter, pilot, dll.'
        ];

        foreach ($categoryData as $name => $desc) {
            $categories[] = ProductCategory::create([
                'name' => $name,
                'slug' => Str::slug($name),
                'image' => 'categories/' . Str::slug($name) . '.jpg',
                'tagline' => 'Tampil beda dengan ' . $name,
                'description' => $desc,
            ]);
        }

        
        
        
        
        $costumeNames = [
            'Kostum Spider-Man Homecoming (Full Set)',
            'Seragam Attack on Titan Survey Corps',
            'Kostum Maid French Style Lucu',
            'Jubah Harry Potter Gryffindor Original',
            'Kostum Dinosaurus T-Rex Inflatable',
            'Baju Adat Bali Pria Lengkap',
            'Kostum Iron Man Mark 50 (Anak)',
            'Wig Naruto Uzumaki Blonde Spiky',
            'Topeng Money Heist Salvador Dali',
            'Kostum Elsa Frozen Premium'
        ];

        foreach ($costumeNames as $index => $productName) {
            
            $categoryIndex = $index % count($categories); 
            $selectedCategory = $categories[$categoryIndex];

            Product::create([
                'store_id' => $store->id,
                'product_category_id' => $selectedCategory->id,
                'name' => $productName,
                'slug' => Str::slug($productName) . '-' . Str::random(5),
                'description' => "Deskripsi lengkap untuk {$productName}. Bahan berkualitas, nyaman dipakai, dan detail sangat mirip dengan aslinya. Cocok untuk event, pesta, atau koleksi pribadi.",
                'condition' => $index > 7 ? 'second' : 'new', 
                'price' => rand(150000, 3500000), 
                'weight' => rand(500, 2000), 
                'stock' => rand(1, 20),
            ]);
        }
    }
}