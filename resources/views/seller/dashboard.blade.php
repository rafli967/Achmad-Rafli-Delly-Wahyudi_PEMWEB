@extends('layouts.seller')

@section('title', 'Dashboard Ringkasan')

@section('content')

@if(!$store->is_verified)
    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-8 rounded-r-lg flex items-start gap-3">
        <svg class="h-5 w-5 text-yellow-400 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
        </svg>
        <div>
            <h3 class="text-sm font-bold text-yellow-800">Menunggu Verifikasi</h3>
            <p class="text-sm text-yellow-700 mt-1">
                Toko Anda sedang ditinjau oleh Admin. Produk Anda mungkin belum tampil di pencarian utama hingga status terverifikasi.
            </p>
        </div>
    </div>
@endif

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between h-32 relative overflow-hidden group hover:shadow-md transition">
        <div class="relative z-10">
            <p class="text-gray-500 text-xs font-bold uppercase tracking-wider">Saldo Aktif</p>
            <h3 class="text-2xl font-extrabold text-gray-900 mt-1">
                Rp {{ number_format($store->storeBallance->balance ?? 0, 0, ',', '.') }}
            </h3>
        </div>
        <div class="absolute right-0 bottom-0 p-4 opacity-10 group-hover:opacity-20 transition transform group-hover:scale-110">
            <svg class="w-16 h-16 text-indigo-600" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z" /><path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd" /></svg>
        </div>
        <a href="{{ route('seller.balance.index') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 flex items-center gap-1 mt-auto relative z-10">
            Lihat Detail <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </a>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between h-32 relative overflow-hidden group hover:shadow-md transition">
        <div class="relative z-10">
            <p class="text-gray-500 text-xs font-bold uppercase tracking-wider">Pesanan Baru (Paid)</p>
            <h3 class="text-2xl font-extrabold text-gray-900 mt-1">
                {{ $store->transactions()->where('payment_status', 'paid')->where('delivery_status', 'pending')->count() }}
            </h3>
        </div>
        <div class="absolute right-0 bottom-0 p-4 opacity-10 group-hover:opacity-20 transition transform group-hover:scale-110">
            <svg class="w-16 h-16 text-orange-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" /><path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd" /></svg>
        </div>
        <a href="{{ route('seller.orders.index') }}" class="text-xs font-semibold text-orange-600 hover:text-orange-800 flex items-center gap-1 mt-auto relative z-10">
            Kelola Pesanan <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </a>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between h-32 relative overflow-hidden group hover:shadow-md transition">
        <div class="relative z-10">
            <p class="text-gray-500 text-xs font-bold uppercase tracking-wider">Total Produk</p>
            <h3 class="text-2xl font-extrabold text-gray-900 mt-1">
                {{ $store->products->count() }}
            </h3>
        </div>
        <div class="absolute right-0 bottom-0 p-4 opacity-10 group-hover:opacity-20 transition transform group-hover:scale-110">
            <svg class="w-16 h-16 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z" /></svg>
        </div>
        <a href="{{ route('seller.products.index') }}" class="text-xs font-semibold text-green-600 hover:text-green-800 flex items-center gap-1 mt-auto relative z-10">
            Lihat Produk <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h4 class="font-bold text-gray-800 mb-4">Tips Penjualan</h4>
        <div class="space-y-4">
            <div class="flex gap-4">
                <div class="bg-indigo-100 p-3 rounded-lg text-indigo-600">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                </div>
                <div>
                    <h5 class="font-semibold text-sm">Foto Produk Menarik</h5>
                    <p class="text-xs text-gray-500 mt-1">Gunakan pencahayaan yang terang dan latar belakang bersih untuk menarik pembeli.</p>
                </div>
            </div>
            <div class="flex gap-4">
                <div class="bg-green-100 p-3 rounded-lg text-green-600">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <div>
                    <h5 class="font-semibold text-sm">Respon Cepat</h5>
                    <p class="text-xs text-gray-500 mt-1">Kirim pesanan sebelum batas waktu untuk mendapatkan rating tinggi.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-indigo-600 rounded-xl shadow-lg p-6 text-white relative overflow-hidden">
        <div class="relative z-10">
            <h4 class="font-bold text-lg mb-2">Butuh Bantuan?</h4>
            <p class="text-indigo-100 text-sm mb-6 max-w-xs">Hubungi tim support kami jika Anda mengalami kendala dalam berjualan.</p>
            <button class="bg-white text-indigo-700 font-bold py-2 px-4 rounded-lg text-sm hover:bg-gray-100 transition">
                Hubungi Support
            </button>
        </div>
        <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-indigo-500 rounded-full opacity-50"></div>
    </div>
</div>

@endsection