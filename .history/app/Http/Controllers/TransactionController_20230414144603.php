<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function addTransaction(Request $request)
    {
        $request->validate([
            'seller_id'=>'required',
            'buyer_id'=>'required',
            'sale_price'=>'required',
        ]);
        $transactionFeePercentage = 10;
        $transaction = new Transaction();
        $transaction->seller_id = $request->seller_id;
        $transaction->buyer_id = $request->buyer_id;
        $transaction->sale_price = $request->sale_price;
        $transaction->product_id  = $request->product_id ;

        $transaction->transaction_fee = $transaction->sale_price * ($transactionFeePercentage / 100);
        $transaction->net_earnings = $transaction->sale_price - $transaction->transaction_fee;
        //$transaction->transaction_date = Carbon::now();

        $transaction->save();
        return response()->json(['message'=>'transaction added successfully','transaction'=>$transaction]);

    }
}
