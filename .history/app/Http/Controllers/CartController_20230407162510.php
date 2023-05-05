<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {

        $cart = new Cart();
        $cart->product = $request->product;
        $cart->buyer = $request->buyer;
        $cart->save();
        return response()->json(['message' => 'product created successfully in your cart','order'=>$cart,'status'=>201]);
    }
}
