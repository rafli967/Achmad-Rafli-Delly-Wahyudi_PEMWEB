<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    public function index()
    {
        
        $transactions = Transaction::where('buyer_id', Auth::id())
                        ->with(['store', 'transactionDetails.product']) 
                        ->latest()
                        ->get();

        return view('frontend.history', compact('transactions'));
    }
}