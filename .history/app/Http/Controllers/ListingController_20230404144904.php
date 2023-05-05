<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ListingController extends Controller
{
    public function AddProduct(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'price' => 'required',
            'shipping_options' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // validate that image is present and is of a supported type and size
            'category' => 'required',
            'seller_id' => 'required',
        ]);

        $product = new Listing();
        $product->title = $request->title;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->shipping_options = $request->shipping_options;
        $product->category = $request->category;
        $product->seller_id = $request->seller_id;
        // handle uploaded image
        $imageName = time().'.'.$request->image->extension();
        $request->image->move(public_path('images'), $imageName);
        $product->image = $imageName;
        $product->save();
        return response()->json(['message' => 'product added successfully','order'=>$product,'status'=>201]);
    }

    public function getProducts(Request $request)
    {
        $products = DB::table('listings')
        ->join('users', 'listings.seller_id', '=', 'users.id')
        ->select('listings.*', 'users.name', 'users.email', 'users.location', 'users.profile_picture')
        ->get();
         
        return response()->json([
            'products' => $products
        ]);
    }
}
