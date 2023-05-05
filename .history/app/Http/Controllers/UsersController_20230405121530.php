<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' =>'required',
            'phone' => 'required',
            'profile_picture' => 'required',
            'email' => 'required'
        ]);
    }
}
