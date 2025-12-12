@extends('layouts.seller')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Pesanan Masuk</h1>
    <p class="text-gray-500">Kelola pesanan yang sudah dibayar oleh pembeli.</p>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full text-left border-collapse">
        <thead class="bg-gray-50 text-gray-600 uppercase text-xs font-semibold">
            <tr>
                <th class="px-6 py-4">Kode TRX</th>
                <th class="px-6 py-4">Pembeli</th>
                <th class="px-6 py-4">Total</th>
                <th class="px-6 py-4">Status Pengiriman</th>
                <th class="px-6 py-4 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($orders as $order)
            <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-4 font-mono text-sm font-bold text-indigo-600">
                    {{ $order->code }}
                    <br>
                    <span class="text-xs text-gray-400 font-sans font-normal">{{ $order->created_at->format('d M Y') }}</span>
                </td>
                <td class="px-6 py-4">
                    <div class="font-medium text-gray-800">{{ $order->buyer->name }}</div>
                    <div class="text-xs text-gray-500">{{ $order->city }}</div>
                </td>
                <td class="px-6 py-4 font-bold text-gray-700">
                    Rp {{ number_format($order->grand_total, 0, ',', '.') }}
                </td>
                <td class="px-6 py-4">
                    @php
                        $colors = [
                            'pending' => 'bg-gray-100 text-gray-600',
                            'processing' => 'bg-blue-100 text-blue-600',
                            'shipped' => 'bg-yellow-100 text-yellow-600',
                            'completed' => 'bg-green-100 text-green-600',
                            'cancelled' => 'bg-red-100 text-red-600',
                        ];
                        $statusLabels = [
                            'pending' => 'Menunggu',
                            'processing' => 'Diproses',
                            'shipped' => 'Dikirim',
                            'completed' => 'Selesai',
                            'cancelled' => 'Dibatalkan',
                        ];
                    @endphp
                    <span class="px-3 py-1 rounded-full text-xs font-bold {{ $colors[$order->delivery_status] ?? 'bg-gray-100' }}">
                        {{ $statusLabels[$order->delivery_status] ?? $order->delivery_status }}
                    </span>
                </td>
                <td class="px-6 py-4 text-center">
                    <a href="{{ route('seller.orders.show', $order->id) }}" class="inline-block bg-indigo-50 text-indigo-600 font-bold py-2 px-4 rounded-lg hover:bg-indigo-100 transition text-sm">
                        Kelola
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                    Belum ada pesanan baru.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">
    {{ $orders->links() }}
</div>
@endsection