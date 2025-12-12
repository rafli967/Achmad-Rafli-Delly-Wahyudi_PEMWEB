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
        // ==========================================
        // 1. Buat 1 User dengan role 'admin'
        // ==========================================
        User::factory()->create([
            'name' => 'Admin Kostum',
            'email' => 'admin@example.com',
            'role' => 'admin',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // ==========================================
        // 2. Buat 2 User dengan role 'member'
        // ==========================================
        // Member 1 (Pemilik Toko Kostum)
        $member1 = User::factory()->create([
            'name' => 'Sultan Cosplay',
            'email' => 'seller@example.com',
            'role' => 'member',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // Member 2 (Pembeli)
        User::factory()->create([
            'name' => 'Wibu Lovers',
            'email' => 'buyer@example.com',
            'role' => 'member',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // ==========================================
        // 3. Buat 1 Toko (Store) Spesialis Kostum
        // ==========================================
        $store = Store::create([
            'user_id' => $member1->id,
            'name' => 'Fantasy Costume Warehouse',
            'logo' => 'stores/costume-logo.png',
            'about' => 'Penyedia kostum terlengkap untuk Cosplay, Halloween, dan Pentas Seni. Kualitas import harga lokal.',
            'phone' => '081299887766',
            'address_id' => '153', // ID Kota Dummy
            'city' => 'Jakarta Selatan',
            'address' => 'Jl. Fatmawati Raya No. 10, Cilandak',
            'postal_code' => '12430',
            'is_verified' => true,
        ]);

        // ==========================================
        // 4. Buat 5 Kategori Produk Kostum
        // ==========================================
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

        // ==========================================
        // 5. Buat 10 Produk Kostum
        // ==========================================
        // Daftar nama produk yang spesifik agar terlihat real
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
            // Kita rotasi kategori agar tersebar merata
            $categoryIndex = $index % count($categories); 
            $selectedCategory = $categories[$categoryIndex];

            Product::create([
                'store_id' => $store->id,
                'product_category_id' => $selectedCategory->id,
                'name' => $productName,
                'slug' => Str::slug($productName) . '-' . Str::random(5),
                'description' => "Deskripsi lengkap untuk {$productName}. Bahan berkualitas, nyaman dipakai, dan detail sangat mirip dengan aslinya. Cocok untuk event, pesta, atau koleksi pribadi.",
                'condition' => $index > 7 ? 'second' : 'new', // Produk ke 8-10 bekas (preloved)
                'price' => rand(150000, 3500000), // Harga 150rb - 3.5jt
                'weight' => rand(500, 2000), // Berat 500gr - 2kg
                'stock' => rand(1, 20),
            ]);
        }
    }
}