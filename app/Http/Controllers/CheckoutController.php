<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Cart;
use App\Transactions;
use App\TransactionDetail;

use Exception; //dipakai di midtrans

use Midtrans\Snap; // library midtrans
use Midtrans\Config; // configurasi midtrans

class CheckoutController extends Controller
{
    public function process(Request $request)
    {
        // save users data

        // membuat variable untuk memanggil user sedang login
        $user = Auth::user();
        // update si data dan ambil data kecuali total_price0
        $user->update($request->except('total_price')); 

        // proses checkout
        $code = 'STORE-' . mt_rand(00000,999999);
        // memanggil table cart
        $carts = Cart::with('product', 'user')
                        ->where('users_id', Auth::user()->id)
                        ->get();

        // Trasaction create
        $transaction = Transactions::create([
            'users_id'          => Auth::user()->id, 
            'insurance_id'      => 0, 
            'shipping_price'    => 0,
            'total_price'       => $request->total_price,
            'transaction_status'=> 'PENDING',
            'code'              => $code,
        ]);

        // save transaction details
        foreach ($carts as $cart) {
            $trx = 'TRX-' . mt_rand(00000,999999);

            TransactionDetail::create([
                'transaction_id'    => $transaction->id, 
                'products_id'       => $cart->product->id, 
                'price'             => $cart->product->price,
                'shipping_status'   => 'PENDING',
                'resi'              => '',
                'code'              => $trx
            ]);
        }

        // Delete Cart Data
        Cart::where('users_id', Auth::user()->id)->delete();

        // konfigurasi midtrans

        // Set your Merchant Server Key
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');

        // buat array untuk di kirim ke midtrans
        $midtrans = [
            'transaction_details' => [
                'order_id' => $code,
                'gross_amount' => (int) $request->total_price,
            ],
            
            'customer_details' => [
                'first_name'    => Auth::user()->name,
                'email'         => Auth::user()->email,
            ],

            'enabled_payments' => [
                'gopay',
                'permata_va',
                'bank_transfer'
            ],

            'vtweb' => []
            ];

        // transaksi
        try {
            // Get Snap Payment Page URL
            $paymentUrl = Snap::createTransaction($midtrans)->redirect_url;
            
            // Redirect to Snap Payment Page
            return redirect($paymentUrl);
          }
          catch (Exception $e) {
            echo $e->getMessage();
          }
    }

    protected $hidden = [
    
    ];
}
