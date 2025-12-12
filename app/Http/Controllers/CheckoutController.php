<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    // Menampilkan Halaman Checkout
    public function show($slug)
    {
        $product = Product::where('slug', $slug)->with('store')->firstOrFail();
        $user = Auth::user();
        
        // Ambil saldo user (Pastikan relasi userBalance ada di model User)
        $userBalance = $user->userBalance->balance ?? 0;

        return view('frontend.checkout', compact('product', 'user', 'userBalance'));
    }

    // Memproses Checkout
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'postal_code' => 'required|string|max:10',
            'shipping_method' => 'required|in:reguler,express',
            'payment_method' => 'required|in:balance,va',
        ]);

        $user = Auth::user();
        $product = Product::findOrFail($request->product_id);
        
        // 1. Kalkulasi Biaya
        $qty = $request->quantity;
        
        // Cek Stok
        if ($qty > $product->stock) {
            return back()->withErrors(['quantity' => 'Stok tidak mencukupi.']);
        }

        $price = $product->price;
        $subtotal = $price * $qty;
        
        // Logika Ongkir Sederhana
        $shippingCost = $request->shipping_method === 'express' ? 50000 : 20000;
        $shippingType = $request->shipping_method === 'express' ? 'Express (Next Day)' : 'Reguler (JNE/J&T)';
        
        $tax = 0; // Pajak 0 dulu
        $grandTotal = $subtotal + $shippingCost + $tax;

        DB::beginTransaction();
        try {
            $paymentStatus = 'unpaid';
            $transactionCode = 'TRX-' . mt_rand(10000, 99999) . time(); 

            // 2. Logika Pembayaran
            if ($request->payment_method === 'balance') {
                $currentBalance = $user->userBalance->balance ?? 0;
                
                if ($currentBalance < $grandTotal) {
                    return back()->withInput()->withErrors(['payment_method' => 'Saldo dompet tidak mencukupi. Silakan Topup atau gunakan VA.']);
                }

                // Potong Saldo
                if ($user->userBalance) {
                    $user->userBalance()->decrement('balance', $grandTotal);
                }
                
                $paymentStatus = 'paid';
            } 
            
            // 3. Simpan ke Tabel Transactions
            $transaction = Transaction::create([
                'code' => $transactionCode,
                'buyer_id' => $user->id,           
                'store_id' => $product->store_id,
                'address' => $request->address,
                'address_id' => '0',               // Placeholder wajib
                'city' => $request->city,
                'postal_code' => $request->postal_code,
                'shipping' => 'JNE',               // Placeholder kurir
                'shipping_type' => $shippingType,
                'shipping_cost' => $shippingCost,
                'tracking_number' => null,
                'tax' => $tax,
                'grand_total' => $grandTotal,      
                'payment_status' => $paymentStatus,
            ]);

            // 4. Simpan ke Tabel TransactionDetails
            TransactionDetail::create([
                'transaction_id' => $transaction->id,
                'product_id' => $product->id,
                'qty' => $qty,
                'subtotal' => $subtotal,           
            ]);
            
            // 5. Kurangi Stok Produk
            $product->decrement('stock', $qty);

            DB::commit();


            if ($paymentStatus === 'paid') {
                // UBAH DARI: redirect()->route('home')
                // MENJADI:
                return redirect()->route('checkout.success', $transaction->id);
            } else {
                return redirect()->route('payment.show', $transaction->id);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => 'Terjadi kesalahan sistem: ' . $e->getMessage()]);
        }
    }
    
    // Halaman Pembayaran (Placeholder untuk langkah selanjutnya)
    public function payment($id)
    {
        $transaction = Transaction::with('transactionDetails.product')->findOrFail($id);
        
        if (Auth::id() !== $transaction->buyer_id) {
            abort(403);
        }
        
        return view('frontend.payment', compact('transaction'));
    }

    public function success($id)
    {
        // Ambil data transaksi beserta detail produknya
        $transaction = Transaction::with(['transactionDetails.product', 'store'])->findOrFail($id);

        // Pastikan yang akses adalah pemilik transaksi
        if (Auth::id() !== $transaction->buyer_id) {
            abort(403);
        }

        return view('frontend.success', compact('transaction'));
    }
}