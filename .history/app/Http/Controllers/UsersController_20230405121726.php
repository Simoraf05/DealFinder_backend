<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function updateProfile(Request $request)
    {
        $to_update = User::findOrFail($id);
        $to_update -> nom = strip_tags($request->input('stagiaire-name'));
        $to_update -> id_filier = strip_tags($request->input('filier-id'));
    }
}
