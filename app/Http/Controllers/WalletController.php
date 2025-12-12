<?php

namespace App\Http\Controllers;

use App\Models\Topup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    // Tampilkan Form Topup
    public function showTopup()
    {
        return view('wallet.topup', ['user' => Auth::user()]);
    }

    // Proses Request Topup -> Generate VA
    public function processTopup(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10000',
        ]);

        // Generate Kode VA Unik (Contoh: TOP-123456)
        $vaCode = 'TOP-' . mt_rand(100000, 999999);

        Topup::create([
            'user_id' => Auth::id(),
            'unique_code' => $vaCode,
            'amount' => $request->amount,
            'status' => 'pending',
        ]);

        // Redirect ke halaman Payment Gate dengan membawa Kode VA agar user mudah copy-paste
        return redirect()->route('payment.gate')->with('success_code', $vaCode);
    }
}