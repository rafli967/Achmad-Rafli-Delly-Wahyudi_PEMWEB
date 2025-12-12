@extends('layouts.admin')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Manajemen Penarikan</h1>
    <p class="text-gray-600">Validasi permintaan pencairan dana dari penjual.</p>
</div>

@if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6">
        {{ session('error') }}
    </div>
@endif

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <table class="w-full text-left border-collapse">
        <thead class="bg-gray-50 text-gray-600 uppercase text-xs font-bold">
            <tr>
                <th class="px-6 py-4">Tanggal</th>
                <th class="px-6 py-4">Toko</th>
                <th class="px-6 py-4">Info Bank</th>
                <th class="px-6 py-4">Jumlah</th>
                <th class="px-6 py-4 text-center">Status</th>
                <th class="px-6 py-4 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($withdrawals as $wd)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 text-sm text-gray-600">
                    {{ $wd->created_at->format('d M Y, H:i') }}
                </td>
                <td class="px-6 py-4">
                    <span class="font-bold text-gray-900">{{ $wd->storeBalance->store->name ?? 'Unknown' }}</span>
                </td>
                <td class="px-6 py-4 text-sm">
                    <div class="font-bold text-gray-800">{{ $wd->bank_name }}</div>
                    <div class="text-gray-500">{{ $wd->bank_account_number }}</div>
                    <div class="text-gray-500 text-xs">a.n {{ $wd->bank_account_name }}</div>
                </td>
                <td class="px-6 py-4 font-bold text-indigo-600">
                    Rp {{ number_format($wd->amount, 0, ',', '.') }}
                </td>
                <td class="px-6 py-4 text-center">
                    @if($wd->status == 'pending')
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                            Menunggu
                        </span>
                    @elseif($wd->status == 'approved')
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            Disetujui
                        </span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                            Ditolak
                        </span>
                    @endif
                </td>
                <td class="px-6 py-4 text-center">
                    @if($wd->status == 'pending')
                        <div class="flex justify-center gap-2">
                            <form action="{{ route('admin.withdrawals.approve', $wd->id) }}" method="POST" onsubmit="return confirm('Pastikan Anda SUDAH mentransfer dana manual ke rekening tersebut. Lanjutkan?')">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="bg-green-600 text-white px-3 py-1.5 rounded text-xs font-bold hover:bg-green-700 transition" title="Tandai Sudah Transfer">
                                    Transfer
                                </button>
                            </form>

                            <form action="{{ route('admin.withdrawals.reject', $wd->id) }}" method="POST" onsubmit="return confirm('Tolak permintaan ini? Saldo akan dikembalikan ke penjual.')">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="bg-red-600 text-white px-3 py-1.5 rounded text-xs font-bold hover:bg-red-700 transition" title="Tolak & Refund">
                                    Tolak
                                </button>
                            </form>
                        </div>
                    @else
                        <span class="text-xs text-gray-400 italic">Selesai</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                    Belum ada permintaan penarikan.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $withdrawals->links() }}
</div>
@endsection