@extends('layouts.frontend')

@section('content')

<div class="relative bg-cover bg-center text-white h-[400px]" style="background-image: url('{{ asset('assets/images/hero.jpg') }}');">
    
    <div class="absolute inset-0 bg-black/80 opacity-80"></div>

    <div class="relative max-w-7xl mx-auto px-4 py-16 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between">
        
        <div class="md:w-1/2 mb-8 md:mb-0">
            <h1 class="text-4xl md:text-5xl font-extrabold mb-4 leading-tight">
                Temukan Kostum <br> Impianmu Disini!
            </h1>
            <p class="text-indigo-100 text-lg mb-6">
                Dari anime, superhero, hingga pakaian adat. Ribuan koleksi kostum siap melengkapi acaramu.
            </p>
            <a href="#products" class="bg-white text-indigo-600 font-bold py-3 px-8 rounded-full shadow-lg hover:bg-gray-100 transition">
                Belanja Sekarang
            </a>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 py-10">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Kategori Populer</h2>
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
        @foreach($categories as $category)
        <a href="#" class="group block bg-white border rounded-xl p-4 shadow-sm hover:shadow-md transition text-center hover:border-indigo-500">
            <div class="w-16 h-16 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-3 group-hover:bg-indigo-50">
                 <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                </svg>
            </div>
            <span class="font-medium text-gray-700 group-hover:text-indigo-600">{{ $category->name }}</span>
        </a>
        @endforeach
    </div>
</div>

<div id="products" class="max-w-7xl mx-auto px-4 py-8 bg-white rounded-t-3xl shadow-sm min-h-screen">
    <div class="flex justify-between items-end mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Rekomendasi Untukmu</h2>
        <a href="#" class="text-indigo-600 font-semibold hover:underline text-sm">Lihat Semua</a>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
        @foreach($products as $product)
        <div class="bg-white border rounded-lg overflow-hidden hover:shadow-lg transition duration-300 relative group">
            <a href="{{ route('product.detail', $product->slug) }}">
                
                <div class="relative h-48 bg-gray-200 overflow-hidden">
                    @if($product->thumbnail)
                        <img src="{{ asset('storage/' . $product->thumbnail->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    @else
                        @php $firstImg = $product->productImages->first(); @endphp
                        @if($firstImg)
                            <img src="{{ asset('storage/' . $firstImg->image) }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        @else
                            <img src="https://via.placeholder.com/300x300?text={{ urlencode($product->name) }}" class="w-full h-full object-cover">
                        @endif
                    @endif
                    
                    @if($product->condition === 'second')
                        <span class="absolute top-2 right-2 bg-orange-500 text-white text-[10px] font-bold px-2 py-1 rounded">BEKAS</span>
                    @endif
                </div>

                <div class="p-3">
                    <div class="text-xs text-gray-500 mb-1">{{ $product->productCategory->name }}</div>
                    <h3 class="font-medium text-gray-800 text-sm line-clamp-2 h-10 mb-2 leading-snug">
                        {{ $product->name }}
                    </h3>
                    <div class="font-bold text-indigo-600 text-base">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </div>
                    
                    <div class="flex items-center gap-1 mt-3 text-xs text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        <span class="truncate max-w-[80px]">{{ $product->store->city }}</span>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>

    <div class="mt-10">
        {{ $products->links() }}
    </div>
</div>
@endsection