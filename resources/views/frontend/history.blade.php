@extends('layouts.frontend')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-12">
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Riwayat Belanja</h1>
            <p class="text-gray-500">Daftar semua transaksi yang pernah Anda lakukan.</p>
        </div>
        <div class="text-right">
            <span class="text-sm text-gray-500">Saldo Wallet:</span>
            <div class="font-bold text-indigo-600 text-lg">Rp {{ number_format(Auth::user()->userBalance->balance ?? 0, 0, ',', '.') }}</div>
        </div>
    </div>

    @if($transactions->isEmpty())
        <div class="bg-white rounded-xl p-12 text-center border border-dashed border-gray-300">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900">Belum ada transaksi</h3>
            <p class="text-gray-500 mb-6">Yuk mulai belanja kostum impianmu sekarang!</p>
            <a href="{{ route('home') }}" class="inline-block bg-indigo-600 text-white font-bold py-2 px-6 rounded-lg hover:bg-indigo-700 transition">
                Mulai Belanja
            </a>
        </div>
    @else
        <div class="space-y-6">
            @foreach($transactions as $trx)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex flex-wrap items-center justify-between gap-4">
                    <div class="flex items-center gap-4 text-sm">
                        <span class="font-bold text-gray-900">{{ $trx->created_at->format('d M Y') }}</span>
                        <span class="text-gray-400">|</span>
                        <span class="text-gray-500 font-mono">{{ $trx->code }}</span>
                        <span class="text-gray-400">|</span>
                        <span class="text-gray-700 font-medium">{{ $trx->store->name }}</span>
                    </div>
                    
                    <div>
                        @if($trx->payment_status == 'paid')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800">
                                Selesai / Lunas
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-orange-100 text-orange-800 animate-pulse">
                                Menunggu Pembayaran
                            </span>
                        @endif
                    </div>
                </div>

                <div class="p-6">
                    @foreach($trx->transactionDetails as $detail)
                    <div class="flex gap-4 mb-4 last:mb-0">
                        
                        <div class="w-16 h-16 bg-gray-100 rounded-md overflow-hidden flex-shrink-0 border border-gray-200">
                             @php
                                // Coba ambil thumbnail, jika tidak ada ambil gambar pertama
                                $image = $detail->product->thumbnail ?? $detail->product->productImages->first();
                             @endphp

                             @if($image)
                                <img src="{{ asset('storage/' . $image->image) }}" alt="{{ $detail->product->name }}" class="w-full h-full object-cover">
                             @else
                                <img src="https://via.placeholder.com/150?text={{ urlencode(substr($detail->product->name, 0, 3)) }}" class="w-full h-full object-cover opacity-50">
                             @endif
                        </div>
                        
                        <div class="flex-1">
                            <h4 class="font-bold text-gray-900 text-sm line-clamp-1">{{ $detail->product->name }}</h4>
                            <p class="text-xs text-gray-500">
                                {{ $detail->qty }} barang x Rp {{ number_format($detail->subtotal / $detail->qty, 0, ',', '.') }}
                            </p>
                        </div>
                        <div class="text-right">
                            <div class="font-medium text-gray-900 text-sm">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex items-center justify-between">
                    <div>
                        <span class="text-xs text-gray-500 block">Total Belanja</span>
                        <span class="font-bold text-lg text-indigo-600">Rp {{ number_format($trx->grand_total, 0, ',', '.') }}</span>
                    </div>
                    
                    <div>
                        @if($trx->payment_status == 'unpaid')
                            <a href="{{ route('payment.show', $trx->id) }}" class="inline-block bg-orange-500 text-white font-bold py-2 px-6 rounded-lg hover:bg-orange-600 transition text-sm shadow-sm">
                                Bayar Sekarang
                            </a>
                        @else
                            <a href="{{ route('checkout.success', $trx->id) }}" class="inline-block border border-gray-300 text-gray-700 font-bold py-2 px-6 rounded-lg hover:bg-gray-100 transition text-sm bg-white">
                                Lihat Invoice
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>
@endsection