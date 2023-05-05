<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Http\Request;

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

    public function getMyOffers(Request $req)
}
