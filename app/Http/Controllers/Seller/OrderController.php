<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Transaction::where('store_id', Auth::user()->store->id)
                    ->where('payment_status', 'paid')
                    ->with(['buyer', 'transactionDetails.product']) 
                    ->latest()
                    ->paginate(10);

        return view('seller.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Transaction::where('store_id', Auth::user()->store->id)
            
                    ->with(['buyer', 'transactionDetails.product']) 
                    ->findOrFail($id);

        return view('seller.orders.show', compact('order'));
    }

    public function update(Request $request, $id)
    {
        $order = Transaction::where('store_id', Auth::user()->store->id)->findOrFail($id);

        $request->validate([
            'delivery_status' => 'required|in:pending,processing,shipped,completed,cancelled',
            'tracking_number' => 'nullable|string|max:255',
        ]);

        $order->update([
            'delivery_status' => $request->delivery_status,
            'tracking_number' => $request->tracking_number ?? $order->tracking_number,
        ]);

        return redirect()->route('seller.orders.show', $id)->with('success', 'Status pesanan berhasil diperbarui!');
    }
}