<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class StoreController extends Controller
{
    
    public function create()
    {
        
        if (Auth::user()->store) {
            return redirect()->route('seller.dashboard');
        }

        return view('seller.register');
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:stores,name',
            'phone' => 'required|numeric',
            'city' => 'required|string',
            'address' => 'required|string',
            'postal_code' => 'required|numeric',
            'about' => 'required|string|max:1000',
            'logo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('stores', 'public');
        }

        Store::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'logo' => $logoPath,
            'about' => $request->about,
            'phone' => $request->phone,
            'address_id' => '0',
            'city' => $request->city,
            'address' => $request->address,
            'postal_code' => $request->postal_code,
            'is_verified' => false, 
        ]);

        
        return redirect()->route('store.pending');
    }

    public function pending()
    {
        $store = Auth::user()->store;

        
        if (!$store) {
            return redirect()->route('store.register');
        }

        
        if ($store->is_verified) {
            return redirect()->route('seller.dashboard');
        }

        return view('seller.pending');
    }

    
    public function dashboard()
    {
        $store = Auth::user()->store;
        
        
        if (!$store) {
            return redirect()->route('store.register');
        }

        
        if (!$store->is_verified) {
            return redirect()->route('store.pending');
        }

        
        return view('seller.dashboard', compact('store'));
    }

    
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

        
        if ($request->hasFile('logo')) {
            
            
            
            $data['logo'] = $request->file('logo')->store('stores', 'public');
        }

        $store->update($data);

        return redirect()->route('seller.profile.edit')->with('success', 'Profil toko berhasil diperbarui!');
    }
}