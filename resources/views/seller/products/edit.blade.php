@extends('layouts.seller')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6 flex items-center gap-2">
        <a href="{{ route('seller.products.index') }}" class="text-gray-500 hover:text-indigo-600">Kembali</a>
        <h1 class="text-2xl font-bold text-gray-800">Edit Produk</h1>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
        <form action="{{ route('seller.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="flex items-center gap-4">
                @php $thumb = $product->productImages->first(); @endphp
                @if($thumb)
                    <img src="{{ asset('storage/'.$thumb->image) }}" class="w-20 h-20 rounded object-cover border">
                @endif
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Ganti Foto (Opsional)</label>
                    <input type="file" name="image" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Produk</label>
                    <input type="text" name="name" value="{{ $product->name }}" required class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                    <select name="product_category_id" class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ $product->product_category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Harga (Rp)</label>
                    <input type="number" name="price" value="{{ $product->price }}" required class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Stok</label>
                    <input type="number" name="stock" value="{{ $product->stock }}" required class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Berat (Gram)</label>
                    <input type="number" name="weight" value="{{ $product->weight }}" required class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Kondisi Barang</label>
                <div class="flex gap-4">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="condition" value="new" {{ $product->condition == 'new' ? 'checked' : '' }} class="text-indigo-600 focus:ring-indigo-500">
                        <span>Baru</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="condition" value="second" {{ $product->condition == 'second' ? 'checked' : '' }} class="text-indigo-600 focus:ring-indigo-500">
                        <span>Bekas</span>
                    </label>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Lengkap</label>
                <textarea name="description" rows="5" required class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">{{ $product->description }}</textarea>
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-3 rounded-lg hover:bg-indigo-700 transition">
                    Update Produk
                </button>
            </div>
        </form>
    </div>
</div>
@endsection