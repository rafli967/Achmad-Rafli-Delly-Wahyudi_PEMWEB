@extends('layouts.seller')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Penarikan Dana</h1>
    <p class="text-gray-500">Cairkan pendapatan toko ke rekening bank Anda.</p>
</div>

@if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6">
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
        <ul class="list-disc list-inside text-sm text-red-600">
            @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
        </ul>
    </div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    <div class="lg:col-span-1">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sticky top-24">
            <h3 class="font-bold text-gray-800 mb-4">Ajukan Penarikan</h3>
            
            <div class="bg-indigo-50 p-4 rounded-lg mb-6">
                <p class="text-xs text-gray-500 uppercase font-semibold">Saldo Tersedia</p>
                <p class="text-2xl font-bold text-indigo-700">Rp {{ number_format($balance->balance, 0, ',', '.') }}</p>
            </div>

            <form action="{{ route('seller.withdrawals.store') }}" method="POST" class="space-y-4" 
                x-data="{ 
                    inputAmount: '', 
                    maxBalance: {{ $balance->balance }} 
                }">
                @csrf
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Bank</label>
                    <select name="bank_name" class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="BCA">BCA</option>
                        <option value="Mandiri">Mandiri</option>
                        <option value="BRI">BRI</option>
                        <option value="BNI">BNI</option>
                        <option value="Jago">Bank Jago</option>
                        <option value="SeaBank">SeaBank</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Rekening</label>
                    <input type="number" name="bank_account_number" class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Contoh: 1234567890" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Atas Nama (Pemilik)</label>
                    <input type="text" name="bank_account_name" class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Nama sesuai buku tabungan" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah Penarikan</label>
                    <div class="relative">
                        <span class="absolute left-3 top-2.5 text-gray-500 font-bold">Rp</span>
                        
                        <input type="number" name="amount" x-model="inputAmount" min="50000" class="w-full pl-10 rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Min. 50.000" required>
                    </div>
                    
                    <div x-show="parseInt(inputAmount) > maxBalance" class="mt-2 text-xs text-red-600 font-bold flex items-center animate-pulse">
                        <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                        Saldo tidak mencukupi! (Maks: Rp <span x-text="maxBalance"></span>)
                    </div>

                    <p class="text-xs text-gray-400 mt-1" x-show="parseInt(inputAmount) <= maxBalance || !inputAmount">Minimal penarikan Rp 50.000</p>
                </div>

                <button type="submit" 
                        :disabled="parseInt(inputAmount) > maxBalance"
                        :class="parseInt(inputAmount) > maxBalance ? 'bg-gray-400 cursor-not-allowed' : 'bg-indigo-600 hover:bg-indigo-700'"
                        class="w-full text-white font-bold py-3 rounded-lg transition shadow-lg mt-2 flex justify-center">
                    Ajukan Sekarang
                </button>
            </form>
        </div>
    </div>

    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                <h3 class="font-bold text-gray-800">Riwayat Penarikan</h3>
            </div>
            
            <table class="w-full text-left border-collapse">
                <thead class="bg-white text-gray-500 text-xs uppercase font-semibold">
                    <tr>
                        <th class="px-6 py-4">Tanggal</th>
                        <th class="px-6 py-4">Tujuan</th>
                        <th class="px-6 py-4">Jumlah</th>
                        <th class="px-6 py-4 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($withdrawals as $wd)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $wd->created_at->format('d M Y, H:i') }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-bold text-gray-800">{{ $wd->bank_name }}</span>
                            <br>
                            <span class="text-xs text-gray-500">{{ $wd->bank_account_number }} ({{ $wd->bank_account_name }})</span>
                        </td>
                        <td class="px-6 py-4 font-bold text-gray-800">
                            Rp {{ number_format($wd->amount, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($wd->status == 'pending')
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-700">
                                    Menunggu
                                </span>
                            @elseif($wd->status == 'approved')
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700">
                                    Berhasil
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700">
                                    Ditolak
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                            Belum ada riwayat penarikan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $withdrawals->links() }}
        </div>
    </div>
</div>
@endsection