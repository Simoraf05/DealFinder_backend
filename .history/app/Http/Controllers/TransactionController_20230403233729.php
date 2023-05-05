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
            'seller_id'=>'required',
            'seller_id'=>'required',

        ]);
    }
}
