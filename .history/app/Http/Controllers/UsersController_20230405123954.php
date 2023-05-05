<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function updateProfile($id, Request $request)
    {
        $to_update = User::findOrFail($id);
        
        if ($request->has('name')) {
            $to_update->name = $request->name;
        } elseif ($request->has('email')) {
            $to_update->email = $request->email;
        } elseif ($request->has('phone')) {
            $to_update->phone = $request->phone;
        } elseif ($request->has('location')) {
            $to_update->location = $request->location;
        } elseif ($request->has('profile_picture')) {
            $to_update->profile_picture = $request->profile_picture;
        } elseif($request->has('password')){
            $to_update->password = bcrypt($request->password);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'no valid update field provided',
            ], 400);
        }
        
        $to_update->save();
    
        return response()->json([
            'status' => 'success',
            'message' => 'profile updated successfully',
            'user' => $to_update,
        ]);
    }
    
}
