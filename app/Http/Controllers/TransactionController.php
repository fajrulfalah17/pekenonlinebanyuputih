<?php

namespace App\Http\Controllers;

use App\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $sellTransactions = TransactionDetail::with(['transaction.user', 'product.galleries'])
                                    ->whereHas('product', function($product){
                                    // pengecekan apakah produk milik penjual itu yg sedang login atau tidak
                                    $product->where('users_id', Auth::user()->id);
                                    })->get();
        $buyTransactions = TransactionDetail::with(['transaction.user', 'product.galleries'])
                                    ->whereHas('transaction', function($transaction){
                                    // pengecekan apakah produk milik penjual itu yg sedang login atau tidak
                                    $transaction->where('users_id', Auth::user()->id);
                                    })->get();

        return view('pages.dashboard-transactions', [
            'sellTransactions' => $sellTransactions,
            'buyTransactions' => $buyTransactions,
        ]);
    }
    public function details(Request $request, $id)
    {
        $transaction = TransactionDetail::with(['transaction.user', 'product.galleries'])
                                        ->findOrFail($id);

        return view('pages.dashboard-transactions-details', [
            'transaction' => $transaction
        ]);
    }
 
    public function update(Request $request, $id) //panggil request
    {
        $data = $request->all(); //untuk mengambil semua request

        $item = TransactionDetail::findOrFail($id); //memanggil transactiondetail

        $item->update($data); //update datanya

        return redirect()->route('dashboard-transactions-details', $id); //jika berhasil akan di redirect ke route tsb

    }
}