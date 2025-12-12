<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class StoreController extends Controller
{
    // Menampilkan Form Pendaftaran Toko
    public function create()
    {
        // Cek apakah user sudah punya toko? Jika ya, lempar ke dashboard
        if (Auth::user()->store) {
            return redirect()->route('seller.dashboard');
        }

        return view('seller.register');
    }

    // Memproses Pendaftaran Toko
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:stores,name',
            'phone' => 'required|numeric',
            'city' => 'required|string',
            'address' => 'required|string',
            'postal_code' => 'required|numeric',
            'about' => 'required|string|max:1000',
            'logo' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Max 2MB
        ]);

        // Upload Logo
        $logoPath = null;
        if ($request->hasFile('logo')) {
            // Simpan ke storage/app/public/stores
            $logoPath = $request->file('logo')->store('stores', 'public');
        }

        // Buat Data Toko
        Store::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'logo' => $logoPath,
            'about' => $request->about,
            'phone' => $request->phone,
            'address_id' => '0', // Placeholder (jika pakai API RajaOngkir nanti)
            'city' => $request->city,
            'address' => $request->address,
            'postal_code' => $request->postal_code,
            'is_verified' => false, // Default belum verifikasi admin
        ]);

        return redirect()->route('seller.dashboard')->with('success', 'Toko berhasil dibuat!');
    }

    // Halaman Utama Dashboard Seller
    public function dashboard()
    {
        $store = Auth::user()->store;
        
        // Pastikan punya toko
        if (!$store) {
            return redirect()->route('store.register');
        }

        return view('seller.dashboard', compact('store'));
    }

    // Form Edit Profil Toko
    public function editProfile()
    {
        $store = Auth::user()->store;
        return view('seller.profile', compact('store'));
    }

    public function updateProfile(Request $request)
    {
        $store = Auth::user()->store;

        $request->validate([
            'name' => 'required|string|max:255|unique:stores,name,' . $store->id,
            'phone' => 'required|numeric',
            'city' => 'required|string',
            'address' => 'required|string',
            'postal_code' => 'required|numeric',
            'about' => 'required|string|max:1000',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->except('logo');

        // Handle Upload Logo Baru
        if ($request->hasFile('logo')) {
            // Hapus logo lama jika bukan default (opsional)
            // if ($store->logo && Storage::exists($store->logo)) Storage::delete($store->logo);
            
            $data['logo'] = $request->file('logo')->store('stores', 'public');
        }

        $store->update($data);

        return redirect()->route('seller.profile.edit')->with('success', 'Profil toko berhasil diperbarui!');
    }
}