<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\StoreBalance;
use App\Models\StoreBalanceHistory;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WithdrawalController extends Controller
{
    public function index()
    {
        $store = Auth::user()->store;
        
        
        $balance = StoreBalance::firstOrCreate(
            ['store_id' => $store->id],
            ['balance' => 0]
        );

        
        $withdrawals = Withdrawal::where('store_balance_id', $balance->id)
                                 ->latest()
                                 ->paginate(10);

        return view('seller.withdrawals.index', compact('balance', 'withdrawals'));
    }

    public function store(Request $request)
    {
        
        $request->validate([
            
            'amount' => 'required|numeric|min:50000', 
            'bank_name' => 'required|string',
            'bank_account_number' => 'required|numeric',
            'bank_account_name' => 'required|string',
        ]);

        $store = Auth::user()->store;
        
        DB::beginTransaction();
        try {
            
            $storeBalance = StoreBalance::where('store_id', $store->id)->lockForUpdate()->first();

            
            if (!$storeBalance || $storeBalance->balance < $request->amount) {
                return back()->withInput()->withErrors(['amount' => 'Saldo tidak mencukupi untuk melakukan penarikan ini.']);
            }

            
            $withdrawal = Withdrawal::create([
                'store_balance_id' => $storeBalance->id,
                'amount' => $request->amount,
                'bank_name' => $request->bank_name,
                'bank_account_number' => $request->bank_account_number,
                'bank_account_name' => $request->bank_account_name,
                'status' => 'pending',
            ]);

            
            $storeBalance->decrement('balance', $request->amount);

            
            StoreBalanceHistory::create([
                'store_balance_id' => $storeBalance->id,
                'type' => 'withdraw', 
                'amount' => $request->amount,
                'reference_id' => $withdrawal->id,
                'reference_type' => Withdrawal::class,
                'remarks' => 'Penarikan Dana ke ' . $request->bank_name
            ]);

            DB::commit();
            return redirect()->route('seller.withdrawals.index')->with('success', 'Permintaan penarikan berhasil dikirim!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => 'Gagal memproses: ' . $e->getMessage()]);
        }
    }
}