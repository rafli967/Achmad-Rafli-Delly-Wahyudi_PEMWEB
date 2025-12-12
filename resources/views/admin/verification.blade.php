@extends('layouts.admin')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Verifikasi Toko</h1>
    <p class="text-gray-600">Daftar toko baru yang menunggu persetujuan.</p>
</div>

@if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6">
        {{ session('success') }}
    </div>
@endif

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <table class="w-full text-left border-collapse">
        <thead class="bg-gray-50 text-gray-600 uppercase text-xs font-bold">
            <tr>
                <th class="px-6 py-4">Nama Toko</th>
                <th class="px-6 py-4">Pemilik</th>
                <th class="px-6 py-4">Dokumen/Info</th>
                <th class="px-6 py-4">Tanggal Daftar</th>
                <th class="px-6 py-4 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($pendingStores as $store)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        @if($store->logo)
                            <img src="{{ asset('storage/' . $store->logo) }}" class="w-10 h-10 rounded-full object-cover border">
                        @else
                            <div class="w-10 h-10 rounded-full bg-gray-200"></div>
                        @endif
                        <div>
                            <div class="font-bold text-gray-900">{{ $store->name }}</div>
                            <div class="text-xs text-gray-500">{{ $store->city }}</div>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <div class="text-sm font-medium text-gray-900">{{ $store->user->name }}</div>
                    <div class="text-xs text-gray-500">{{ $store->user->email }}</div>
                </td>
                <td class="px-6 py-4 text-sm text-gray-600 max-w-xs truncate">
                    {{ $store->about }}
                </td>
                <td class="px-6 py-4 text-sm text-gray-600">
                    {{ $store->created_at->format('d M Y') }}
                </td>
                <td class="px-6 py-4 text-center">
                    <div class="flex justify-center gap-2">
                        <form action="{{ route('admin.verification.approve', $store->id) }}" method="POST" onsubmit="return confirm('Verifikasi toko ini?')">
                            @csrf
                            <button type="submit" class="bg-green-600 text-white px-3 py-1.5 rounded text-xs font-bold hover:bg-green-700 transition">
                                Terima
                            </button>
                        </form>
                        <form action="{{ route('admin.verification.reject', $store->id) }}" method="POST" onsubmit="return confirm('Tolak dan Hapus pengajuan toko ini?')">
                            @csrf
                            <button type="submit" class="bg-red-600 text-white px-3 py-1.5 rounded text-xs font-bold hover:bg-red-700 transition">
                                Tolak
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                    Tidak ada pengajuan toko baru saat ini.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection