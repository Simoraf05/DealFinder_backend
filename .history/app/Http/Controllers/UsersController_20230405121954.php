<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function updateProfile($id,Request $request)
    {
        $to_update = User::findOrFail($id);
        $to_update -> name = $request->name;
        $to_update -> email = $request->email;
        $to_update -> phone = $request->phone;
        $to_update -> location = $request->location;
        $to_update -> location = $request->location;

    }
}
