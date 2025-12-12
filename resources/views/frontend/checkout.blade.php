@extends('layouts.frontend')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-12">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Checkout Pesanan</h1>
        <p class="text-gray-500">Lengkapi data pengiriman dan pembayaran Anda.</p>
    </div>

    @if($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r">
            <p class="font-bold text-red-700">Gagal Memproses:</p>
            <ul class="list-disc list-inside text-sm text-red-600">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('checkout.store') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-12 gap-8" id="checkoutForm">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        
        <div class="lg:col-span-7 space-y-6">
            
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <h2 class="text-lg font-semibold mb-4 text-gray-800">Barang yang dibeli</h2>
                <div class="flex gap-4">
                    <img src="https://via.placeholder.com/150" class="w-24 h-24 object-cover rounded-md bg-gray-100">
                    <div class="flex-1">
                        <h3 class="font-bold text-gray-900 text-lg">{{ $product->name }}</h3>
                        <p class="text-gray-500 text-sm">Toko: {{ $product->store->name }}</p>
                        <div class="flex items-center justify-between mt-3">
                            <div class="text-indigo-600 font-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                            <div class="flex items-center border rounded-lg">
                                <button type="button" onclick="updateQty(-1)" class="px-3 py-1 hover:bg-gray-100 text-gray-600 font-bold">-</button>
                                <input type="number" name="quantity" id="qtyInput" value="1" min="1" max="{{ $product->stock }}" class="w-12 text-center border-none p-1 text-sm font-bold focus:ring-0" readonly>
                                <button type="button" onclick="updateQty(1)" class="px-3 py-1 hover:bg-gray-100 text-gray-600 font-bold">+</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <h2 class="text-lg font-semibold mb-4 text-gray-800">Alamat Pengiriman</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap <span class="text-red-500">*</span></label>
                        <textarea name="address" rows="2" class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500" required placeholder="Jalan, No Rumah, RT/RW">{{ old('address') }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kota <span class="text-red-500">*</span></label>
                        <input type="text" name="city" class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500" required placeholder="Jakarta Selatan" value="{{ old('city') }}">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kode Pos <span class="text-red-500">*</span></label>
                        <input type="text" name="postal_code" class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500" required placeholder="12345" value="{{ old('postal_code') }}">
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <h2 class="text-lg font-semibold mb-4 text-gray-800">Pilih Pengiriman</h2>
                <div class="space-y-3">
                    <label class="flex items-center justify-between p-4 border rounded-xl cursor-pointer hover:border-indigo-500 has-[:checked]:border-indigo-600 has-[:checked]:bg-indigo-50 transition-all">
                        <div class="flex items-center gap-3">
                            <input type="radio" name="shipping_method" value="reguler" checked class="text-indigo-600 focus:ring-indigo-500" onchange="updateShipping(20000)">
                            <div>
                                <div class="font-medium text-gray-900">Reguler (JNE/J&T)</div>
                                <div class="text-xs text-gray-500">Estimasi 2-4 Hari</div>
                            </div>
                        </div>
                        <div class="font-bold text-gray-700">Rp 20.000</div>
                    </label>
                    <label class="flex items-center justify-between p-4 border rounded-xl cursor-pointer hover:border-indigo-500 has-[:checked]:border-indigo-600 has-[:checked]:bg-indigo-50 transition-all">
                        <div class="flex items-center gap-3">
                            <input type="radio" name="shipping_method" value="express" class="text-indigo-600 focus:ring-indigo-500" onchange="updateShipping(50000)">
                            <div>
                                <div class="font-medium text-gray-900">Express (Next Day)</div>
                                <div class="text-xs text-gray-500">Estimasi 1 Hari</div>
                            </div>
                        </div>
                        <div class="font-bold text-gray-700">Rp 50.000</div>
                    </label>
                </div>
            </div>
        </div>

        <div class="lg:col-span-5">
            <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-200 sticky top-24">
                <h2 class="text-lg font-semibold mb-4 text-gray-800">Ringkasan Pembayaran</h2>
                
                <div class="space-y-3 text-sm border-b border-gray-100 pb-4 mb-4">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Total Harga (<span id="qtyLabel">1</span> barang)</span>
                        <span class="font-medium text-gray-900" id="subtotalLabel">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Biaya Pengiriman</span>
                        <span class="font-medium text-gray-900" id="shippingLabel">Rp 20.000</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Biaya Layanan</span>
                        <span class="font-medium text-gray-900">Rp 0</span>
                    </div>
                </div>

                <div class="flex justify-between items-center mb-6">
                    <span class="font-bold text-lg text-gray-900">Total Tagihan</span>
                    <span class="font-bold text-xl text-indigo-600" id="grandTotalLabel">Rp {{ number_format($product->price + 20000, 0, ',', '.') }}</span>
                </div>

                <h3 class="font-semibold text-gray-800 mb-3">Metode Pembayaran <span class="text-red-500">*</span></h3>
                <div class="space-y-3 mb-6">
                    <label class="block relative">
                        <input type="radio" name="payment_method" value="balance" required class="peer sr-only">
                        <div class="p-4 border rounded-xl cursor-pointer hover:border-indigo-500 peer-checked:border-indigo-600 peer-checked:bg-indigo-50 peer-checked:ring-2 peer-checked:ring-indigo-500 transition-all">
                            <div class="flex justify-between items-center">
                                <span class="font-bold text-gray-800 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" /></svg>
                                    Saldo Akun
                                </span>
                                <span id="balanceStatus" class="text-[10px] font-bold px-2 py-1 rounded bg-gray-100 text-gray-500">CEK...</span>
                            </div>
                            <div class="text-sm text-gray-500 mt-1">Sisa saldo: Rp {{ number_format($userBalance, 0, ',', '.') }}</div>
                        </div>
                    </label>

                    <label class="block relative">
                        <input type="radio" name="payment_method" value="va" required class="peer sr-only">
                        <div class="p-4 border rounded-xl cursor-pointer hover:border-indigo-500 peer-checked:border-indigo-600 peer-checked:bg-indigo-50 peer-checked:ring-2 peer-checked:ring-indigo-500 transition-all">
                            <div class="flex justify-between items-center">
                                <span class="font-bold text-gray-800 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" /></svg>
                                    Virtual Account
                                </span>
                            </div>
                            <div class="text-sm text-gray-500 mt-1">Transfer Bank (BCA, Mandiri, BRI)</div>
                        </div>
                    </label>
                </div>

                <button type="submit" id="payButton" class="w-full bg-indigo-600 text-white font-bold py-4 rounded-xl shadow-lg hover:bg-indigo-700 hover:shadow-xl transition-all transform hover:-translate-y-1 disabled:opacity-50 disabled:cursor-not-allowed">
                    Bayar Sekarang
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    const productPrice = {{ $product->price }};
    const maxStock = {{ $product->stock }};
    const userBalance = {{ $userBalance }};
    
    let quantity = 1;
    let shippingCost = 20000; // Default Reguler

    function formatRupiah(num) {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(num);
    }

    function updateQty(change) {
        let newQty = quantity + change;
        if (newQty >= 1 && newQty <= maxStock) {
            quantity = newQty;
            document.getElementById('qtyInput').value = quantity;
            recalculate();
        }
    }

    function updateShipping(cost) {
        shippingCost = cost;
        recalculate();
    }

    function recalculate() {
        let subtotal = productPrice * quantity;
        let grandTotal = subtotal + shippingCost;

        document.getElementById('qtyLabel').innerText = quantity;
        document.getElementById('subtotalLabel').innerText = formatRupiah(subtotal);
        document.getElementById('shippingLabel').innerText = formatRupiah(shippingCost);
        document.getElementById('grandTotalLabel').innerText = formatRupiah(grandTotal);

        const balanceBadge = document.getElementById('balanceStatus');
        if (userBalance >= grandTotal) {
            balanceBadge.innerText = "SALDO CUKUP";
            balanceBadge.className = "text-[10px] font-bold px-2 py-1 rounded bg-green-100 text-green-700";
        } else {
            balanceBadge.innerText = "SALDO KURANG";
            balanceBadge.className = "text-[10px] font-bold px-2 py-1 rounded bg-red-100 text-red-700";
        }
    }

    // Tambahan: Logika Submit agar user tahu proses sedang berjalan
    const form = document.getElementById('checkoutForm');
    const btn = document.getElementById('payButton');

    form.addEventListener('submit', function(e) {
        // Cek validasi HTML5 manual jika perlu, tapi 'required' di input sudah cukup
        // Ubah teks tombol
        btn.innerHTML = `
            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Memproses...
        `;
        btn.disabled = true; // Cegah double submit
    });

    document.addEventListener('DOMContentLoaded', () => recalculate());
</script>
@endsection