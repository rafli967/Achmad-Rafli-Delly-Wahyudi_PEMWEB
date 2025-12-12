@extends('layouts.admin')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">Dashboard Admin</h1>
    <p class="text-gray-600">Selamat datang, Administrator.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
        <div class="text-gray-500 text-sm font-bold uppercase mb-1">Total User</div>
        <div class="text-3xl font-extrabold text-gray-800">{{ $stats['total_users'] }}</div>
    </div>
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
        <div class="text-gray-500 text-sm font-bold uppercase mb-1">Total Toko</div>
        <div class="text-3xl font-extrabold text-gray-800">{{ $stats['total_stores'] }}</div>
    </div>
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
        <div class="text-gray-500 text-sm font-bold uppercase mb-1">Toko Pending</div>
        <div class="text-3xl font-extrabold text-red-600">{{ $stats['pending_stores'] }}</div>
    </div>
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
        <div class="text-gray-500 text-sm font-bold uppercase mb-1">Transaksi Sukses</div>
        <div class="text-3xl font-extrabold text-green-600">{{ $stats['total_transactions'] }}</div>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 text-center">
    <h3 class="text-lg font-bold text-gray-800 mb-2">Aktivitas Sistem</h3>
    <p class="text-gray-500">Sistem berjalan dengan baik.</p>
</div>
@endsection