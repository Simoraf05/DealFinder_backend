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
        $product->status = 0;
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


    public function getProducts()
    {
        $products =     "products": [
            {
                "id": 31,
                "title": "white t-shirt",
                "description": "new white  t-shirt and good quality",
                "price": "90.00",
                "shipping_options": "Multiple addresses",
                "image": "products/G7cEOktrf3jpIUtR4fOlOB9xgSjPVxGlJ37vNBdg.jpg",
                "category": "",
                "status": 1,
                "seller_id": 25,
                "created_at": "2023-04-06 23:38:24",
                "updated_at": "2023-04-10 13:21:09",
                "name": "salma",
                "email": "simorafsi309@gmail.com",
                "location": "sbata",
                "profile_picture": "products/or5nxUtkNxLg7qsUdoMggByx3y87zJ7AyucF5E4B.jpg",
                "offer_prices": "[{\"offers_price\": 100.00}]"
            },
        ->groupBy('listings.id', 'listings.title', 'users.name', 'users.email',
        'users.location','listings.description','listings.price','listings.shipping_options','listings.image','listings.category','listings.status','listings.seller_id','listings.created_at','listings.updated_at', 'users.profile_picture')
        ->get();



        return response()->json([
            'products' => $products,
        ]);
    }

    public function filtring(Request $request)
    {
        $res = DB::table('listings')
            ->where('title','LIKE','%'.$request->title.'%')
            ->get();

            return response()->json([
                'searchByTitle'=>$res
            ]);
    }
     public function getOfferPrices(Request $request)
     {
        $offersprices = DB::table('offers')
        ->join('listings as l', 'offers.listing_id', '=', 'l.id')
        ->select('offers.price as offer_price')
        ->where('l.id', '=', $request->id)
        ->get();
      
        return response()->json([
            'offersprices'=>$offersprices
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
