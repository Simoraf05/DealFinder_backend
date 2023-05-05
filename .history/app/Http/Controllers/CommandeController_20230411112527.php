<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommandeController extends Controller
{
    public function getCommande(Request $request)
    {
        $commande = DB::table('users as u')
        ->join()
    }
}
