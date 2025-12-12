<?php

namespace Database\Seeders;

use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Seeder;

class StoreSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil user yang akan jadi seller
        $seller = User::where('email', 'seller@example.com')->first();

        if ($seller) {
            Store::create([
                'user_id' => $seller->id,
                'name' => 'Cosplay Universe',
                
                'logo' => 'assets/images/placeholder.png', //nanti bisa diganti ygy
                
                'about' => 'Toko kostum terlengkap se-Indonesia. Menyediakan berbagai kostum anime dan superhero.',
                'phone' => '081234567890',
                'address_id' => '0',
                'city' => 'Jakarta Selatan',
                'address' => 'Jl. Fatmawati Raya No. 10',
                'postal_code' => '12430',
                'is_verified' => true,
            ]);
        }
    }
}