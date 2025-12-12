@extends('layouts.seller')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Dashboard Toko</h1>
    <p class="text-gray-500">Selamat datang kembali, {{ Auth::user()->name }}!</p>
</div>

@if(!$store->is_verified)
    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-8">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-yellow-700">
                    Toko Anda sedang dalam peninjauan Admin. Beberapa fitur mungkin dibatasi hingga status terverifikasi.
                </p>
            </div>
        </div>
    </div>
@endif

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <div class="text-gray-500 text-sm font-medium uppercase mb-1">Total Pendapatan</div>
        <div class="text-2xl font-bold text-gray-900">Rp 0</div>
    </div>
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <div class="text-gray-500 text-sm font-medium uppercase mb-1">Pesanan Baru</div>
        <div class="text-2xl font-bold text-indigo-600">0</div>
    </div>
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <div class="text-gray-500 text-sm font-medium uppercase mb-1">Total Produk</div>
        <div class="text-2xl font-bold text-gray-900">{{ $store->products->count() }}</div>
    </div>
</div>
@endsection