<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OfferController extends Controller
{
    public function addOffer(Request $request)
    {
        $request->validate([
            'buyer_id'=>'required',
            'listing_id'=>'required',
            'price'=>'required',
        ]);

        $offer = new Offer();
        $offer->buyer_id = $request->buyer_id;
        $offer->listing_id = $request->listing_id;
        $offer->price = $request->price;

        $offer->save();
        return response()->json(['message'=>'offer added successfully','offer'=>$offer]);
    }

    public function updatingOffer(Request $request)
    {
        $to_update = Offer::findOrFail($request->id);
        $to_update->price = $request->price;
        $to_update->save();
        return response()->json(['message'=>'price updated successfully','offer'=>$to_update]);
    }

    public function getMyOffers(Request $request)
    {
        $offer = DB::table('users as u')
        ->join('listings as l', 'u.id', '=', 'l.seller_id')
        ->leftJoin('offers as o', 'l.id', '=', 'o.listing_id')
        ->leftJoin('users as b', 'o.buyer_id', '=', 'b.id')
        ->where('u.id', '=', $request->seller_id)
        ->select('u.name as seller_name', 'l.title', 'l.price', 'o.price as offer_price', 'o.status as offer_status', 'b.name as buyer_name', 'b.email as buyer_email', 'b.profile_picture')
        ->get();

        return response()->json(['message'=>'successfully','offer'=>$offer]);
    }
}
