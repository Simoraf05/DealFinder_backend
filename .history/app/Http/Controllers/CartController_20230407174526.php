<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        ->join('listings as p', 'c.product', '=', 'p.id')
        ->select('c.id as cart_id', 'p.*')
        ->where('c.buyer', $request->buyer)
        ->get();

    return response()->json(['message' => 'successfully','cart'=>$cart], 201);
    }

    public function deleteFromCart(Request $request)
    {
        $to_delete = DB::table('carts')
        ->where('id', $request->id)->delete();

        if (!$to_delete) {
            return response()->json(['error' => 'Product not found'], 404);
        };
        
        $to_delete->delete();
        return response()->json(['message' => 'Products deleted successfully from your cart'], 200);
    }
}
