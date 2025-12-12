@extends('layouts.seller')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Daftar Produk</h1>
    <a href="{{ route('seller.products.create') }}" class="bg-indigo-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-indigo-700 shadow-md transition flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Tambah Produk
    </a>
</div>

@if(session('success'))
    <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 mb-6">
        {{ session('success') }}
    </div>
@endif

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full text-left border-collapse">
        <thead class="bg-gray-50 text-gray-600 uppercase text-xs font-semibold">
            <tr>
                <th class="px-6 py-4">Produk</th>
                <th class="px-6 py-4">Harga</th>
                <th class="px-6 py-4">Stok</th>
                <th class="px-6 py-4">Kategori</th>
                <th class="px-6 py-4 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($products as $product)
            <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        @if($product->thumbnail)
                            <img src="{{ asset('storage/' . $product->thumbnail->image) }}" class="w-12 h-12 rounded bg-gray-100 object-cover border">
                        @else
                            <div class="w-12 h-12 rounded bg-gray-100 border flex items-center justify-center text-xs text-gray-400">No img</div>
                        @endif
                        
                        <span class="font-medium text-gray-800">{{ $product->name }}</span>
                    </div>
                </td>
                <td class="px-6 py-4 font-semibold text-gray-700">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                <td class="px-6 py-4">
                    <span class="px-2 py-1 rounded text-xs font-bold {{ $product->stock > 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        {{ $product->stock }}
                    </span>
                </td>
                <td class="px-6 py-4 text-sm text-gray-500">{{ $product->productCategory->name }}</td>
                <td class="px-6 py-4 flex justify-center gap-2">
                    <a href="{{ route('seller.products.edit', $product->id) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded">
                        Edit
                    </a>
                    <form action="{{ route('seller.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Hapus produk ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                    Belum ada produk. Silakan tambah produk baru.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">
    {{ $products->links() }}
</div>
@endsection