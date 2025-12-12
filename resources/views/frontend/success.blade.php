@extends('layouts.frontend')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center px-4 py-12">
    <div class="max-w-xl w-full bg-white rounded-2xl shadow-xl overflow-hidden text-center p-10 border border-gray-100">
        
        <div class="mb-6 flex justify-center">
            <div class="rounded-full bg-green-100 p-4">
                <svg class="w-16 h-16 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
        </div>

        <h1 class="text-3xl font-extrabold text-gray-900 mb-2">Pembayaran Berhasil!</h1>
        <p class="text-gray-500 mb-8">Terima kasih, pesanan Anda sedang kami proses.</p>

        <div class="bg-gray-50 rounded-xl p-6 mb-8 text-left space-y-3">
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Kode Transaksi</span>
                <span class="font-mono font-bold text-gray-800">{{ $transaction->code }}</span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Tanggal</span>
                <span class="font-medium text-gray-800">{{ $transaction->created_at->format('d M Y, H:i') }}</span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Metode Bayar</span>
                <span class="font-medium text-gray-800 capitalize">
                    {{ $transaction->payment_method == 'balance' ? 'Saldo Dompet' : 'Virtual Account' }}
                </span>
            </div>
            <hr class="border-gray-200 my-2">
            <div class="flex justify-between text-base font-bold text-gray-900">
                <span>Total Bayar</span>
                <span class="text-indigo-600">Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="flex flex-col gap-3">
            <a href="{{ route('home') }}" class="w-full bg-indigo-600 text-white font-bold py-3 rounded-xl hover:bg-indigo-700 transition shadow-lg">
                Belanja Lagi
            </a>
            
            {{-- 
            <a href="{{ route('history') }}" class="w-full bg-white text-indigo-600 font-bold py-3 rounded-xl border border-indigo-200 hover:bg-indigo-50 transition">
                Lihat Riwayat Pesanan
            </a>
            --}}
        </div>

    </div>
</div>
@endsection