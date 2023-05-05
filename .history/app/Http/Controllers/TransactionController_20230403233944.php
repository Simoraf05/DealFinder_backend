<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function addTransaction(Request $request)
    {
        $request->validate([
            'seller_id'=>'required',
            'buyer_id'=>'required',
            'sale_price'=>'required',
            'transaction_fee'=>'required',
            'net_earnings'=>'required',
        ]);

        $transaction = new Transaction();
        $transaction->seller_id = $request->seller_id;
        $transaction->buyer_id = $request->buyer_id;
        transaction_fee        $transaction->net_earnings = $request->net_earnings;
        $transaction->seller_id = $request->seller_id;

    }
}
