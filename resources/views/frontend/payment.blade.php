@extends('layouts.frontend')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center px-4 py-12 bg-gray-50">
    <div class="max-w-lg w-full bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100 p-8">
        
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-orange-100 mb-4 animate-pulse">
                <svg class="w-10 h-10 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-900">Menunggu Pembayaran</h1>
            <p class="text-gray-500 mt-2">Selesaikan pembayaran Anda sebelum batas waktu berakhir.</p>
        </div>

        <div class="bg-gray-50 rounded-xl p-6 mb-8 border border-gray-200">
            <div class="flex justify-between items-center mb-4 pb-4 border-b border-gray-200">
                <span class="text-gray-600 text-sm">Kode Virtual Account</span>
                <span class="font-mono font-bold text-xl text-gray-900 tracking-wider select-all">{{ $transaction->code }}</span>
            </div>
            
            <div class="flex justify-between items-center mb-2">
                <span class="text-gray-600 text-sm">Total Tagihan</span>
                <span class="font-bold text-xl text-indigo-600">Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</span>
            </div>
            
            <div class="flex justify-between items-center">
                <span class="text-gray-600 text-sm">Batas Waktu</span>
                <span class="text-red-500 font-medium text-sm">{{ $transaction->created_at->addDay()->format('d M Y, H:i') }} WIB</span>
            </div>
        </div>

        <div class="space-y-4">
            <div class="bg-blue-50 text-blue-800 text-xs p-4 rounded-lg mb-6 leading-relaxed">
                <span class="font-bold">Instruksi:</span> Salin <strong>Kode Virtual Account</strong> di atas, lalu lakukan pembayaran melalui ATM, Mobile Banking, atau gunakan <strong>Simulator Pembayaran</strong> di bawah ini (Khusus Testing).
            </div>

            <a href="{{ route('payment.gate') }}" onclick="copyToClipboard('{{ $transaction->code }}')" class=" w-full bg-indigo-600 text-white text-center font-bold py-3.5 rounded-xl hover:bg-indigo-700 transition shadow-lg flex items-center justify-center gap-2">
                <span>Bayar Sekarang (Simulator)</span>
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
            </a>
            
            <a href="{{ route('home') }}" class="block w-full text-indigo-600 text-center font-semibold py-3 hover:bg-indigo-50 rounded-xl transition">
                Cek Riwayat Pesanan
            </a>
        </div>
    </div>
</div>

<script>
    
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text);
        
    }
</script>
@endsection