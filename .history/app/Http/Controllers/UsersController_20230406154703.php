<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{
    public function updateProfile(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|max:10',
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $to_update = User::findOrFail($id);
    
        // Update the user's fields
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
        if ($request->has('profile_picture')) {

            $path = $request->file('profile_picture')->store('public/images');
            $url = Storage::url($path);
    
            $to_update->profile_picture = $url;
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
    
}