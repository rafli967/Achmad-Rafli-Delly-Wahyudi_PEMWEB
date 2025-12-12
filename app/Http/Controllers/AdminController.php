<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Withdrawal;
use App\Models\StoreBalanceHistory;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_stores' => Store::count(),
            'pending_stores' => Store::where('is_verified', false)->count(),
            'total_transactions' => Transaction::where('payment_status', 'paid')->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    
    public function verification()
    {
        
        $pendingStores = Store::where('is_verified', false)->latest()->get();
        
        return view('admin.verification', compact('pendingStores'));
    }

    
    public function approveStore($id)
    {
        $store = Store::findOrFail($id);
        $store->update(['is_verified' => true]);

        return redirect()->back()->with('success', 'Toko berhasil diverifikasi! Penjual kini bisa berjualan.');
    }

    
    
    
    public function rejectStore($id)
    {
        $store = Store::findOrFail($id);
        
        
        
        
        $store->delete();

        return redirect()->back()->with('success', 'Pengajuan toko ditolak dan dihapus.');
    }



    public function users()
    {
        
        $users = User::where('role', '!=', 'admin')
                     ->with('store')
                     ->latest()
                     ->paginate(10);

        return view('admin.users.index', compact('users'));
    }



    public function destroyUser($id)
    {
        $user = User::findOrFail($id);
        
        
        if ($user->role === 'admin') {
            return back()->with('error', 'Tidak dapat menghapus akun Admin.');
        }

        $user->delete();

        return back()->with('success', 'User berhasil dihapus.');
    }

    public function withdrawals()
    {
        
        $withdrawals = Withdrawal::with('storeBalance.store')
                                 ->latest()
                                 ->paginate(10);

        return view('admin.withdrawals.index', compact('withdrawals'));
    }

    public function approveWithdrawal($id)
    {
        $withdrawal = Withdrawal::findOrFail($id);

        if ($withdrawal->status != 'pending') {
            return back()->with('error', 'Status penarikan tidak valid.');
        }

        
        $withdrawal->update(['status' => 'approved']);

        return back()->with('success', 'Penarikan disetujui. Dana dianggap telah ditransfer.');
    }

    public function rejectWithdrawal($id)
    {
        $withdrawal = Withdrawal::with('storeBalance')->findOrFail($id);

        if ($withdrawal->status != 'pending') {
            return back()->with('error', 'Status penarikan tidak valid.');
        }

        DB::beginTransaction();
        try {
            
            $withdrawal->update(['status' => 'rejected']);

            
            $withdrawal->storeBalance->increment('balance', $withdrawal->amount);

            
            StoreBalanceHistory::create([
                'store_balance_id' => $withdrawal->store_balance_id,
                'type' => 'income', 
                'amount' => $withdrawal->amount,
                'reference_id' => $withdrawal->id,
                'reference_type' => Withdrawal::class,
                'remarks' => 'Refund Penarikan Ditolak'
            ]);

            DB::commit();
            return back()->with('success', 'Penarikan ditolak. Dana dikembalikan ke saldo toko.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}