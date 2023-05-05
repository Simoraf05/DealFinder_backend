<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{
    public function updateProfile(Request $request, $id)
    {
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
            $to_update->profile_picture = $request->profile_picture;
        }
    
        // Save the changes to the database
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
        ->select('listings.*')
        ->where('seller_id','='.$request->seller_id)
        ->get();
        if($MyProducts){
            return response()->json([
                'status' => 'success',
                'My products' => $MyProducts,
            ]);
        }else(
            return response()->json([
                'status' => 'success',
                'My products' => '',
            ]);
        )

    }
    
}
