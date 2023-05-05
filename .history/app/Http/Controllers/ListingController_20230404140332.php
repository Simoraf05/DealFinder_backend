<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;

class ListingController extends Controller
{
    public function AddProduct(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'price' => 'required',
            'shipping_options' => 'required',
            'image' => 'required',
            'category' => 'required',
            'seller_id' => 'required',
        ]);

        $product = new Listing();
        $product->title = $request->title;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->shipping_options = $request->shipping_options;
        $product->image = $request->image;
        $product->category = $request->category;
        $product->seller_id = $request->seller_id;

        $product->save();
        return response()->json(['message' => 'product added successfully','order'=>$product,'status'=>201]);
    }

    public function getProducts()
    {
        $products = DB
        return response()->json([
            'products' => $products
        ]);
    }
}
