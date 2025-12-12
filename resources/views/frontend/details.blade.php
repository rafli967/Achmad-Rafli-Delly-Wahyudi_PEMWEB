@extends('layouts.frontend')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    
    <nav class="flex mb-6 text-sm text-gray-500" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li><a href="{{ route('home') }}" class="hover:text-indigo-600">Home</a></li>
            <li>/</li>
            <li><a href="#" class="hover:text-indigo-600">{{ $product->productCategory->name }}</a></li>
            <li>/</li>
            <li class="text-gray-800 font-medium truncate max-w-xs">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="bg-white rounded-xl shadow-sm p-6 grid grid-cols-1 md:grid-cols-12 gap-8">
        
        <div class="md:col-span-5" x-data="{ activeImage: '{{ $product->productImages->first() ? asset('storage/'.$product->productImages->first()->image) : 'https://via.placeholder.com/600' }}' }">
    
            <div class="aspect-square rounded-xl overflow-hidden border bg-gray-100 mb-4 relative group">
                <img :src="activeImage" class="w-full h-full object-cover transition duration-300">
            </div>

            <div class="grid grid-cols-5 gap-2">
                @foreach($product->productImages as $image)
                <div @click="activeImage = '{{ asset('storage/'.$image->image) }}'" 
                    class="aspect-square rounded-lg border-2 cursor-pointer overflow-hidden hover:border-indigo-600 transition"
                    :class="activeImage === '{{ asset('storage/'.$image->image) }}' ? 'border-indigo-600 ring-2 ring-indigo-100' : 'border-transparent'">
                    <img src="{{ asset('storage/'.$image->image) }}" class="w-full h-full object-cover">
                </div>
                @endforeach
            </div>
        </div>

        <div class="md:col-span-7 flex flex-col">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $product->name }}</h1>
            
            <div class="flex items-center gap-4 mb-4 text-sm">
                <div class="text-gray-500">Terjual <span class="text-gray-900 font-medium">0</span></div>
                <div class="flex items-center text-yellow-400">
                    ★ <span class="text-gray-900 font-medium ml-1">5.0 (0 Ulasan)</span>
                </div>
            </div>

            <div class="text-4xl font-bold text-indigo-600 mb-6">
                Rp {{ number_format($product->price, 0, ',', '.') }}
            </div>

            <hr class="border-gray-100 mb-6">

            <div class="mb-6">
                <h3 class="font-semibold text-gray-900 mb-3">Detail Produk</h3>
                <div class="grid grid-cols-2 gap-y-2 text-sm">
                    <div class="text-gray-500">Kondisi</div>
                    <div class="capitalize {{ $product->condition == 'new' ? 'text-green-600' : 'text-orange-600' }} font-medium">
                        {{ $product->condition == 'new' ? 'Baru' : 'Bekas' }}
                    </div>
                    
                    <div class="text-gray-500">Berat</div>
                    <div>{{ $product->weight }} Gram</div>
                    
                    <div class="text-gray-500">Kategori</div>
                    <div class="text-indigo-600">{{ $product->productCategory->name }}</div>
                </div>
            </div>

            <div class="mb-8">
                <h3 class="font-semibold text-gray-900 mb-2">Deskripsi</h3>
                <p class="text-gray-600 text-sm leading-relaxed whitespace-pre-line">
                    {{ $product->description }}
                </p>
            </div>

            <div class="flex items-center gap-4 border p-4 rounded-lg mb-8 bg-gray-50">
                    <div class="w-12 h-12 rounded-full flex-shrink-0 overflow-hidden border border-gray-200">
                        @if($product->store->logo)
                            <img src="{{ asset('storage/' . $product->store->logo) }}" alt="{{ $product->store->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-gray-100 flex items-center justify-center text-gray-400">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                        @endif
                    </div>                
                    <div>
                    <div class="font-bold text-gray-900 flex items-center gap-1">
                        {{ $product->store->name }}
                        @if($product->store->is_verified)
                            <svg class="w-4 h-4 text-blue-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        @endif
                    </div>
                    <div class="text-xs text-gray-500">{{ $product->store->city }}</div>
                </div>
            </div>

            <div class="mt-auto bg-white border-t md:border-t-0 p-4 md:p-0 flex gap-3 sticky bottom-0 md:relative z-10">
                <button type="button" onclick="alert('Fitur Keranjang akan segera hadir!')" 
                        class="flex-1 border border-indigo-600 text-indigo-600 font-bold py-3 rounded-lg hover:bg-indigo-50 transition">
                    + Keranjang
                </button>

                <a href="{{ route('checkout.show', $product->slug) }}" 
                class="flex-1 bg-indigo-600 text-white font-bold py-3 rounded-lg hover:bg-indigo-700 transition shadow-lg text-center flex items-center justify-center">
                    Beli Sekarang
                </a>
            </div>
        </div>
    </div>
</div>
@endsection