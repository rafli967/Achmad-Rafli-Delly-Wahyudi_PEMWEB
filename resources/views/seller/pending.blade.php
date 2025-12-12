@extends('layouts.frontend')

@section('content')
<div class="min-h-[80vh] flex flex-col justify-center items-center px-4 bg-gray-50">
    <div class="max-w-lg w-full bg-white rounded-2xl shadow-xl p-8 text-center border border-gray-100">
        
        <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-yellow-100 mb-6 animate-pulse">
            <svg class="w-12 h-12 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>

        <h2 class="text-3xl font-extrabold text-gray-900 mb-2">Toko Sedang Ditinjau</h2>
        <p class="text-gray-500 mb-8 leading-relaxed">
            Terima kasih telah mendaftar! Permintaan pembukaan toko Anda sedang kami proses. 
            Mohon tunggu persetujuan dari Admin sebelum Anda dapat mengakses <strong>Seller Center</strong>.
        </p>

        <div class="bg-gray-50 rounded-xl p-4 text-left mb-8 border border-gray-200">
            <h4 class="text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">Detail Toko:</h4>
            <div class="flex items-center gap-3 mb-2">
                @if(Auth::user()->store->logo)
                    <img src="{{ asset('storage/' . Auth::user()->store->logo) }}" class="w-10 h-10 rounded-full object-cover border">
                @endif
                <div>
                    <p class="font-bold text-gray-900">{{ Auth::user()->store->name }}</p>
                    <p class="text-xs text-gray-500">Status: <span class="text-yellow-600 font-bold">Menunggu Verifikasi</span></p>
                </div>
            </div>
        </div>

        <a href="{{ route('home') }}" class="block w-full bg-indigo-600 text-white font-bold py-3 rounded-xl hover:bg-indigo-700 transition shadow-lg">
            Kembali ke Beranda
        </a>
    </div>
</div>
@endsection