@extends('layouts.seller')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="flex items-center gap-2 mb-6">
        <a href="{{ route('seller.orders.index') }}" class="text-gray-500 hover:text-indigo-600">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </a>
        <h1 class="text-2xl font-bold text-gray-800">Detail Pesanan #{{ $order->code }}</h1>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <div class="md:col-span-2 space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-gray-800 mb-4 border-b pb-2">Barang Pesanan</h3>
                @foreach($order->transactionDetails as $detail)
                <div class="flex gap-4 mb-4 last:mb-0">
                    @php $img = $detail->product->productImages->first(); @endphp
                    <img src="{{ $img ? asset('storage/'.$img->image) : 'https://via.placeholder.com/100' }}" class="w-16 h-16 rounded object-cover bg-gray-100">
                    <div class="flex-1">
                        <h4 class="font-bold text-gray-900">{{ $detail->product->name }}</h4>
                        <p class="text-sm text-gray-500">{{ $detail->qty }} x Rp {{ number_format($detail->price, 0, ',', '.') }}</p>
                    </div>
                    <div class="font-bold text-gray-700">
                        Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                    </div>
                </div>
                @endforeach
                
                <div class="border-t pt-4 mt-4 flex justify-between items-center">
                    <span class="text-gray-600">Ongkos Kirim ({{ $order->shipping_type }})</span>
                    <span class="font-bold text-gray-800">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between items-center mt-2 text-lg">
                    <span class="font-bold text-indigo-600">Total Pendapatan</span>
                    <span class="font-bold text-indigo-600">Rp {{ number_format($order->grand_total, 0, ',', '.') }}</span>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-gray-800 mb-4 border-b pb-2">Informasi Pengiriman</h3>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="block text-gray-500 mb-1">Nama Penerima</span>
                        <span class="font-medium text-gray-900">{{ $order->buyer->name }}</span>
                    </div>
                    <div>
                        <span class="block text-gray-500 mb-1">No. Telepon</span>
                        <span class="font-medium text-gray-900">{{ $order->buyer->phone_number ?? '-' }}</span>
                    </div>
                    <div class="col-span-2">
                        <span class="block text-gray-500 mb-1">Alamat Lengkap</span>
                        <span class="font-medium text-gray-900 leading-relaxed">
                            {{ $order->address }}, {{ $order->city }} {{ $order->postal_code }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="md:col-span-1">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sticky top-24">
                <h3 class="font-bold text-gray-800 mb-4">Update Status</h3>
                
                <form action="{{ route('seller.orders.update', $order->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status Pesanan</label>
                        <select name="delivery_status" class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="pending" {{ $order->delivery_status == 'pending' ? 'selected' : '' }}>Menunggu (Baru)</option>
                            <option value="processing" {{ $order->delivery_status == 'processing' ? 'selected' : '' }}>Diproses (Packing)</option>
                            <option value="shipped" {{ $order->delivery_status == 'shipped' ? 'selected' : '' }}>Dikirim (Kurir)</option>
                            <option value="completed" {{ $order->delivery_status == 'completed' ? 'selected' : '' }}>Selesai</option>
                            <option value="cancelled" {{ $order->delivery_status == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Resi (Tracking)</label>
                        <input type="text" name="tracking_number" value="{{ $order->tracking_number }}" class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Contoh: JP12345678">
                        <p class="text-xs text-gray-500 mt-1">Isi jika status sudah "Dikirim"</p>
                    </div>

                    <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-3 rounded-lg hover:bg-indigo-700 transition">
                        Simpan Perubahan
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection