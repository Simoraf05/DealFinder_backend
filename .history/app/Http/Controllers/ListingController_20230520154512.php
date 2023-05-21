<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\Product_images;
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
            'image_path' => 'required|mimes:jpeg,png,jpg',
            'category' => 'required',
            'seller_id' => 'required',
        ]);

        $product = new Listing();
        $product_image = new Product_images();
        $product->title = $request->title;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->shipping_options = $request->shipping_options;
        $product_image->product_id = $request->product_id;
        $product_image->image_path = $request->file('image_path')->store('products');
        $product->category = $request->category;
        $product->status = 0;
        $product->seller_id = $request->seller_id;
        
        $product->save();
        $pr
        return response()->json(['message' => 'product added successfully', 'order' => $product, 'status' => 201]);
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

        $products = DB::table('listings')
            ->selectRaw('listings.*, users.name, users.email, users.location, users.profile_picture, CONCAT("[", GROUP_CONCAT(JSON_OBJECT(offers.buyer_id, offers.price)), "]") AS offer_prices')
            ->join('users', 'listings.seller_id', '=', 'users.id')
            ->leftJoin('offers', 'offers.listing_id', '=', 'listings.id')
            ->groupBy(
                'listings.id',
                'listings.title',
                'users.name',
                'users.email',
                'users.location',
                'listings.description',
                'listings.price',
                'listings.shipping_options',
                'listings.image',
                'listings.category',
                'listings.status',
                'listings.seller_id',
                'listings.created_at',
                'listings.updated_at',
                'users.profile_picture'
            )
            ->get();


        DB::raw('JSON_ARRAYAGG(JSON_OBJECT("offers_price", offers.price)) as offer_prices');
        $response = array(
            'products' => $products
        );

        foreach ($response['products'] as $product) {
            $product->offer_prices = json_decode($product->offer_prices);
        }

        return response()->json([
            'products' => $response,
        ]);
    }

    public function filtring(Request $request)
    {
        $res = DB::table('listings')
            ->where('title', 'LIKE', '%' . $request->title . '%')
            ->get();

        return response()->json([
            'searchByTitle' => $res
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
            'offersprices' => $offersprices
        ]);
    }

    public function deleteProduct(Request $request)
    {
        $to_delete = Listing::find($request->id);
        $to_delete->delete();

        return response()->json([
            'message' => 'product deleted successfully',
            'products_deleted' => $to_delete
        ]);
    }


    public function editeProduct(Request $request, $id)
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

    public function checkStock()
    {
        $check = DB::table('transactions')
            ->select('transactions.*')
            ->get();

        return response()->json([
            'Product' => $check,
        ]);
    }

    public function filtringData(Request $request)
    {
        $res = DB::table('Listings')
            ->where('category', $request->category)
            ->selectRaw('listings.*, users.name, users.email, users.location, users.profile_picture, CONCAT("[", GROUP_CONCAT(JSON_OBJECT(offers.buyer_id, offers.price)), "]") AS offer_prices')
            ->join('users', 'listings.seller_id', '=', 'users.id')
            ->leftJoin('offers', 'offers.listing_id', '=', 'listings.id')
            ->groupBy(
                'listings.id',
                'listings.title',
                'users.name',
                'users.email',
                'users.location',
                'listings.description',
                'listings.price',
                'listings.shipping_options',
                'listings.image',
                'listings.category',
                'listings.status',
                'listings.seller_id',
                'listings.created_at',
                'listings.updated_at',
                'users.profile_picture'
            )
            ->get();

        return response()->json([
            'products' => $res
        ]);
    }
    public function searchForProductByName(Request $request)
    {
        $resultat = DB::table('listings')
            ->where('listings.title', 'like',$request->title.'%')
            ->get();
        return response()->json($resultat);
    }
}
