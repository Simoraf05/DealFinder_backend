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
         
        return response()->json([
            'products' => $products
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


    public function editeProduct(Request $request)
    {
        $to_update = User::findOrFail($id);
    
        if ($request->has('name')) {
            $to_update->name = $request->name;
        } 
        if ($request->has('email')) {
            $to_update->email = $request->email;
        } 
        if ($request->has('phone')) {
            $to_update->phone = $request->phone;
        } 
        if ($request->has('location')) {
            $to_update->location = $request->location;
        } 
        if ($request->hasFile('profile_picture')) {
            $request->validate([
                'profile_picture' => 'required|file|mimes:jpeg,png,jpg,gif|max:7048',
            ]);
            $to_update->profile_picture = $request->file('profile_picture')->store('products');
        }

        $to_update->save();
    
        return response()->json([
            'status' => 'success',
            'message' => 'profile updated successfully',
            'user' => $to_update,
        ]);
    }
}
