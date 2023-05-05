<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{
    public function updateProfile(Request $request, $id)
    {


        $validator = $request->validate([
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($id),
            ]
        ]);
    
        if (!$validator) {
            return response()->json(['errors' => 'email already used'], 400);
        }
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
    
    
}
