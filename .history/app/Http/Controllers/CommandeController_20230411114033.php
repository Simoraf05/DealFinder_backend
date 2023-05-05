<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommandeController extends Controller
{
    public function getCommande(Request $request)
    {
        $commande = DB::table('users as u')
        ->join('listings as l', 'u.id', '=', 'l.seller_id')
        ->leftJoin('offers as o', 'l.id', '=', 'o.listing_id')
        ->leftJoin('users as b', 'o.buyer_id', '=', 'b.id')
        ->where('o.buyer_id', '=', $request->buyer_id)
        ->select('u.name as seller_name','l.id as idP', 'l.image as product_image','l.title', 'l.price', 'o.id as offer_id','o.price as offer_price', 'o.status as offer_status', 'b.name as buyer_name', 'b.email as buyer_email', 'b.profile_picture')
        ->get();

        return response()
    }
}
