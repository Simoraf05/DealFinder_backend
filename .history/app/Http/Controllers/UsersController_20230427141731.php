<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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

    public function updatePwd(Request $request)
    {
        $validate = $request->validate([
            'old_pwd'=>'required',
            'pwd' => 'required',
            'Cpwd' => 'required'
        ]);

        if(!$validate){
            return response()->json([
                'message' => 'validation fails'
            ],422);
        }
        $user = Auth::user();
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['error' => 'Current password is incorrect'], 422);
        }
    
        $user->password = Hash::make($request->new_password);
        //$user->save();
    
        return response()->json(['message' => 'Password updated successfully'], 200);
    }

    public function profile(Request $request)
    {
        $profile = Listing::select('users.*', 'listings.title as product')
        ->join('users', 'listings.seller_id', '=', 'users.id')
        ->where('users.id', $request->id)
        ->get();

        return response()->json([
            'message'=>'success',
            'profile'=>$profile
        ]);
    }
    
}
