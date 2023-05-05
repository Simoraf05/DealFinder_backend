<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\User;
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

    public function deleteProduct($id)
    {
        $to_delete = Listing::findOrFail($id);
        $to_delete->delete();
        return response()->json([
            'message'=>'product deleted successfully',
            'products_deleted'
        ]);

    }
}
