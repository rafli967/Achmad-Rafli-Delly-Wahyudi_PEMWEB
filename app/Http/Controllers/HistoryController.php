<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    public function index()
    {
        // Ambil transaksi milik user yang sedang login (sebagai buyer)
        $transactions = Transaction::where('buyer_id', Auth::id())
                        ->with(['store', 'transactionDetails.product']) // Eager load relasi
                        ->latest()
                        ->get();

        return view('frontend.history', compact('transactions'));
    }
}