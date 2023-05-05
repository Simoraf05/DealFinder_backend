<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Listing;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{
    public function updateProfile(Request $request,$id)
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
    
    public function getMyProducts(Request $request)
    {
        $MyProducts = DB::table('listings')
        ->where('seller_id', '=', $request->seller_id)
        ->get();


        if($MyProducts){
            return response()->json([
                'status' => 'success',
                'Myproducts' => $MyProducts,
            ]);
        }else{
            return response()->json([
                'status' => 'success',
                'My products' => 'No products found',
            ]);
        }

    }


    public function deleteFromCart(Request $request)
    {
        $to_delete = Cart::findOrFail($request->id);

        if (!$to_delete) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        $to_delete->delete();
        return response()->json(['message' => 'Products deleted successfully from your cart'], 200);
    }
    
}
