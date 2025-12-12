@extends('layouts.seller')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Dompet Toko</h1>
    <p class="text-gray-500">Pantau pemasukan dan riwayat transaksi toko Anda.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-gradient-to-br from-indigo-600 to-blue-700 rounded-2xl p-8 text-white shadow-xl md:col-span-2 relative overflow-hidden">
        <div class="absolute top-0 right-0 -mr-10 -mt-10 w-40 h-40 rounded-full bg-white opacity-10 blur-2xl"></div>
        
        <div class="relative z-10">
            <p class="text-indigo-100 text-sm font-medium mb-1 uppercase tracking-wider">Saldo Aktif</p>
            <h2 class="text-5xl font-extrabold mb-6">
                Rp {{ number_format($balance->balance, 0, ',', '.') }}
            </h2>
            
            <div class="flex gap-4">
                <a href="{{ route('seller.withdrawals.index') }}" class="bg-white text-indigo-700 font-bold py-2.5 px-6 rounded-lg hover:bg-indigo-50 transition shadow-lg flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" /></svg>
                    Tarik Dana
                </a>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-center">
        <div class="flex items-center gap-3 mb-2">
            <div class="p-2 bg-green-100 rounded-lg text-green-600">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
            </div>
            <span class="text-gray-500 text-sm font-medium">Total Transaksi</span>
        </div>
        <p class="text-3xl font-bold text-gray-800">{{ $histories->total() }}</p>
        <p class="text-xs text-gray-400 mt-1">Mutasi masuk & keluar</p>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
        <h3 class="font-bold text-gray-800">Riwayat Mutasi</h3>
    </div>
    
    <table class="w-full text-left border-collapse">
        <thead class="bg-white text-gray-500 text-xs uppercase font-semibold">
            <tr>
                <th class="px-6 py-4">Tanggal</th>
                <th class="px-6 py-4">Keterangan (Remarks)</th>
                <th class="px-6 py-4">Tipe</th>
                <th class="px-6 py-4 text-right">Jumlah</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($histories as $history)
            <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-4 text-sm text-gray-600 whitespace-nowrap">
                    {{ $history->created_at->format('d M Y, H:i') }}
                </td>
                <td class="px-6 py-4">
                    <span class="text-gray-900 font-medium block">{{ $history->remarks }}</span>
                    @if($history->reference_type)
                        <span class="text-xs text-gray-400">Ref: {{ class_basename($history->reference_type) }} #{{ $history->reference_id }}</span>
                    @endif
                </td>
                <td class="px-6 py-4">
                    @if($history->type == 'income')
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-700">
                            Pemasukan
                        </span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-red-100 text-red-700">
                            Penarikan
                        </span>
                    @endif
                </td>
                <td class="px-6 py-4 text-right font-mono font-bold {{ $history->type == 'income' ? 'text-green-600' : 'text-red-600' }}">
                    {{ $history->type == 'income' ? '+' : '-' }} Rp {{ number_format($history->amount, 0, ',', '.') }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                    <div class="flex flex-col items-center">
                        <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
                        <p>Belum ada riwayat mutasi.</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $histories->links() }}
</div>
@endsection