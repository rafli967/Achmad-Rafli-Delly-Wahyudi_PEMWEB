@extends('layouts.frontend')

@section('content')
<div class="max-w-md mx-auto px-4 py-12">
    <div class="bg-white rounded-xl shadow-lg p-8">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Isi Saldo Wallet</h1>
            <p class="text-gray-500">Saldo saat ini: <span class="font-bold text-indigo-600">Rp {{ number_format(Auth::user()->userBalance->balance ?? 0, 0, ',', '.') }}</span></p>
        </div>

        <form action="{{ route('wallet.topup.process') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nominal Topup</label>
                <div class="relative">
                    <span class="absolute left-3 top-3 text-gray-500 font-bold">Rp</span>
                    <input type="number" name="amount" min="10000" class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" placeholder="Min. 10.000" required>
                </div>
            </div>

            <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-3 rounded-lg hover:bg-indigo-700 transition">
                Buat Kode Pembayaran
            </button>
        </form>
    </div>
</div>
@endsection