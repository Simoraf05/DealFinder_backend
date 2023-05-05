<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ListingController extends Controller
{
    public function AddProduct(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'price' => 'required',
            'shipping_options' => 'required',
            'image' => 'required|file|mimes:jpeg,png,jpg,gif|max:7048',
            'category' => 'required',
            'seller_id' => 'required',
        ]);

        
        $product = new Listing();
        $product->title = $request->title;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->shipping_options = $request->shipping_options;
        $product->image = $request->file('image')->store('products');
        $product->category = $request->category;
        $product->seller_id = $request->seller_id;

    
        $product->save();
        return response()->json(['message' => 'product added successfully','order'=>$product,'status'=>201]);
    }

    public function getCategories()
    {
        $result = DB::select("
        SELECT COLUMN_TYPE AS column_type
        FROM INFORMATION_SCHEMA.COLUMNS
        WHERE TABLE_SCHEMA = 'dealfinder' AND TABLE_NAME = 'listings' AND COLUMN_NAME = 'category'
    ");
    
    $columnType = $result[0]->column_type;
    preg_match_all("/'(.*?)'/", $columnType, $enumValues);
    $categories = $enumValues[1];
    
    return response()->json(['categories' => $categories]);
    
    }


    public function getProducts(Request $request)
    {
        $products = DB::table('listings')
        ->join('users', 'listings.seller_id', '=', 'users.id')
        ->select('listings.*', 'users.name', 'users.email', 'users.location', 'users.profile_picture')
        ->get();
        $filtringByTitle = $request->title;
        $res = DB::table('listings')
            ->where('title','like','%'.$filtringByTitle.'%')
            ->get();
        /*$offersprice = DB::table('offers')
        ->join('listings','listing.id','=','offers.listing_id')
        ->where('offers.listing_id ','=',$request->id)
        ->orderBy('offers.price','DESC')
        ->get();
         */

         /*
         SELECT offers.price as priceOffer, listings.title as productTitle
        FROM offers
        JOIN listings on listings.id = offers.listing_id
        WHERE offers.listing_id = 31
        ORDER BY offers.price DESC
         */
        return response()->json([
            'products' => $products,
            //'offersprice'=>$offersprice
            'search'
        ]);
    }

    public function deleteProduct(Request $request)
    {
        $to_delete = Listing::find($request->id);
        $to_delete->delete();

        return response()->json([
            'message'=>'product deleted successfully',
            'products_deleted'=>$to_delete
        ]);

    }


    public function editeProduct(Request $request ,$id)
    {
        $to_update = Listing::findOrFail($id);
    
        if ($request->has('title')) {
            $to_update->title = $request->title;
        } 
        if ($request->has('description')) {
            $to_update->description = $request->description;
        } 
        if ($request->has('price')) {
            $to_update->price = $request->price;
        } 
        if ($request->has('shipping_options')) {
            $to_update->shipping_options = $request->shipping_options;
        } 
        if ($request->has('category')) {
            $to_update->category = $request->category;
        } 
        if ($request->hasFile('image')) {
            $request->validate([
                'image' => 'required|file|mimes:jpeg,png,jpg,gif|max:7048',
            ]);
            $to_update->image = $request->file('image')->store('products');
        }

        $to_update->save();
    
        return response()->json([
            'status' => 'success',
            'message' => 'Product updated successfully',
            'Product' => $to_update,
        ]);
    }
}