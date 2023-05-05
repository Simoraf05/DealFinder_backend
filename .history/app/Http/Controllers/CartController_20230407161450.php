<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $existingInCart = Cart::where('product_id', $request->product_id)
        ->where('user_id', $request->user_id)
        ->first();

        if ($existingInCart) {
        return response()->json(['message' => 'this product already exists in your cart', 'status' => 409]);
        }
        $cart = new Cart();
        $cart->product_id = $request->product_id;
        $cart->user_id = $request->user_id;
        $cart->save();
        return response()->json(['message' => 'product created successfully in your cart','order'=>$cart,'status'=>201]);
    }
}
