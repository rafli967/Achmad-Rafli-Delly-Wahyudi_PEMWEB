<?php

namespace App\Http\Controllers;

use App\Models\Topup;
use App\Models\Transaction;
use App\Models\UserBalance;
use App\Models\StoreBalance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    
    public function index()
    {
        return view('payment.index');
    }

    
    public function check(Request $request)
    {
        $request->validate(['va_code' => 'required|string']);
        $code = $request->va_code;

        
        $topup = Topup::where('unique_code', $code)->where('status', 'pending')->first();
        if ($topup) {
            return view('payment.confirm', [
                'type' => 'topup',
                'data' => $topup,
                'amount' => $topup->amount
            ]);
        }

        
        $trx = Transaction::where('code', $code)->where('payment_status', 'unpaid')->first();
        if ($trx) {
            return view('payment.confirm', [
                'type' => 'transaction',
                'data' => $trx,
                'amount' => $trx->grand_total
            ]);
        }

        return back()->withErrors(['va_code' => 'Kode VA tidak ditemukan atau sudah dibayar.']);
    }

    
    public function pay(Request $request)
    {
        $request->validate([
            'code' => 'required',
            'type' => 'required|in:topup,transaction',
            'amount_input' => 'required|numeric'
        ]);

        DB::beginTransaction();
        try {
            if ($request->type === 'topup') {
                
                $topup = Topup::where('unique_code', $request->code)->where('status', 'pending')->firstOrFail();
                
                if ($request->amount_input < $topup->amount) {
                    return back()->withErrors(['amount_input' => 'Nominal kurang.']);
                }

                $topup->update(['status' => 'success']);
                
                UserBalance::updateOrCreate(
                    ['user_id' => $topup->user_id],
                    ['balance' => DB::raw("balance + $topup->amount")] 
                );

                DB::commit();
                return redirect()->route('home')->with('success', 'Topup Berhasil!');

            } else {
                
                $trx = Transaction::where('code', $request->code)->where('payment_status', 'unpaid')->firstOrFail();

                if ($request->amount_input < $trx->grand_total) {
                    return back()->withErrors(['amount_input' => 'Nominal kurang.']);
                }

                $trx->update(['payment_status' => 'paid']);

                $storeBalance = StoreBalance::firstOrCreate(
                    ['store_id' => $trx->store_id],
                    ['balance' => 0]
                );
                $storeBalance->increment('balance', $trx->grand_total);

                \App\Models\StoreBalanceHistory::create([
                    'store_balance_id' => $storeBalance->id,
                    'type' => 'income',
                    'amount' => $trx->grand_total,
                    'reference_id' => $trx->id,
                    'reference_type' => Transaction::class,
                    'remarks' => 'Penjualan #' . $trx->code
                ]);

                DB::commit();
                
                
                return redirect()->route('checkout.success', $trx->id);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal: ' . $e->getMessage()]);
        }
    }
}