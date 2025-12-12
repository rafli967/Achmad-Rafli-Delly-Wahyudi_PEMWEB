@extends('layouts.frontend')

@section('content')
<div class="min-h-[60vh] flex flex-col justify-center items-center px-4">
    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        
        <div class="bg-indigo-600 px-6 py-4 text-white text-center">
            <h2 class="font-bold text-lg">Konfirmasi Pembayaran</h2>
            <p class="text-indigo-100 text-sm opacity-80">{{ $type == 'topup' ? 'Isi Ulang Saldo' : 'Pembayaran Belanja' }}</p>
        </div>

        <div class="p-8">
            <div class="space-y-4 mb-8">
                <div class="flex justify-between border-b pb-2">
                    <span class="text-gray-500">Kode Transaksi</span>
                    <span class="font-mono font-bold text-gray-800">{{ $type == 'topup' ? $data->unique_code : $data->code }}</span>
                </div>
                <div class="flex justify-between border-b pb-2">
                    <span class="text-gray-500">Total Tagihan</span>
                    <span class="font-bold text-indigo-600 text-xl">Rp {{ number_format($amount, 0, ',', '.') }}</span>
                </div>
            </div>

            <form action="{{ route('payment.pay') }}" method="POST">
                @csrf
                <input type="hidden" name="code" value="{{ $type == 'topup' ? $data->unique_code : $data->code }}">
                <input type="hidden" name="type" value="{{ $type }}">

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Simulasi Nominal Transfer</label>
                    <input type="number" name="amount_input" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-indigo-500 text-center" placeholder="Masukkan jumlah uang" required>
                    <p class="text-xs text-gray-400 mt-1 text-center">*Masukkan nominal persis sesuai tagihan agar sukses.</p>
                </div>

                <button type="submit" class="w-full bg-green-600 text-white font-bold py-3 rounded-lg hover:bg-green-700 transition shadow-lg">
                    BAYAR SEKARANG
                </button>
                
                <a href="{{ route('payment.gate') }}" class="block text-center text-gray-500 text-sm mt-4 hover:underline">Batalkan</a>
            </form>
        </div>
    </div>
</div>
@endsection