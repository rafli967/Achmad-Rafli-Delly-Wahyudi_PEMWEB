@extends('layouts.frontend')

@section('content')
<div class="min-h-[60vh] flex flex-col justify-center items-center px-4">
    
    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="bg-gray-900 px-6 py-4">
            <h2 class="text-white font-bold text-lg flex items-center gap-2">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                Payment Gateway Simulator
            </h2>
        </div>

        <div class="p-8">
            @if(session('success_code'))
                <div class="bg-green-50 border border-green-200 text-green-800 p-4 rounded-lg mb-6 text-center">
                    <p class="text-sm mb-1">Kode VA Berhasil Dibuat:</p>
                    <p class="text-3xl font-mono font-bold tracking-wider select-all">{{ session('success_code') }}</p>
                    <p class="text-xs text-green-600 mt-2">Silakan masukkan kode di bawah untuk simulasi bayar.</p>
                </div>
            @endif

            <form action="{{ route('payment.check') }}" method="POST">
                @csrf
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Masukkan Kode Virtual Account</label>
                    <input type="text" name="va_code" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 text-center text-lg font-mono uppercase" placeholder="Contoh: TRX-XXXXX atau TOP-XXXXX" required value="{{ session('success_code') }}">
                </div>

                @if($errors->any())
                    <div class="text-red-500 text-sm text-center mb-4">{{ $errors->first() }}</div>
                @endif

                <button type="submit" class="w-full bg-gray-900 text-white font-bold py-3 rounded-lg hover:bg-gray-800 transition">
                    Cek Tagihan
                </button>
            </form>
        </div>
    </div>
</div>
@endsection