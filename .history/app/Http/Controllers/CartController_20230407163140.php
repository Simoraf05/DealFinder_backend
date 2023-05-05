<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $existingInCart = Cart::where('product', $request->product)
        ->where('buyer', $request->buyer)
        ->first();

        if ($existingInCart) {
        return response()->json(['message' => 'this product already exists in your cart', 'status' => 409]);
        }


        $cart = new Cart();
        $cart->product = $request->product;
        $cart->buyer = $request->buyer;
        $cart->save();
        return response()->json(['message' => 'product created successfully in your cart','order'=>$cart,'status'=>201]);
    }

    public function getCart(Request $request)
    {
        $cart = DB::table('carts as c')
        ->join('products as p', 'c.product_id', '=', 'p.id')
        ->select('c.id as cart_id', 'p.*')
        ->where('c.user_id', $request->user_id)
        ->get();
    return response()->json(['message' => 'successfully','cart'=>$cart], 201);
    }
}
