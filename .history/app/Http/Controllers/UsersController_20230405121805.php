<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function updateProfile($id,Request $request)
    {
        $to_update = User::findOrFail($id);
        $to_update -> nom ;
        $to_update -> id_filier = strip_tags($request->input('filier-id'));
    }
}
