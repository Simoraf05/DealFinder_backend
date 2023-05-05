<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OfferController extends Controller
{
    public function addOffer(Request $request)
    {
        $existingInOffer = Offer::where('listing_id', $request->listing_id)
        ->where('buyer_id', $request->buyer_id )
        ->first();

        if ($existingInOffer) {
            return response()->json(['message' => 'this offer already send to the prdocuct owner', 'status' => 409]);
        }

        $offer = new Offer();
        $offer->buyer_id = $request->buyer_id;
        $offer->listing_id = $request->listing_id;
        if($request->price == 0.00){
            return response()->json(['message' => 'You should give higher price than the original price', 'status' => 410]);
        }
        $offer->price = $request->price;

        $offer->save();
        return response()->json(['message'=>'offer added successfully','offer'=>$offer]);
    }

    public function updatingOfferPrice(Request $request)
    {
        $to_update = Offer::findOrFail($request->id);
        $to_update->price = $request->price;
        $to_update->save();
        return response()->json(['message'=>'price updated successfully','offer'=>$to_update]);
    }

    public function updatingOfferStatus(Request $request)
    {
        $to_update = Offer::findOrFail($request->id);
        $to_update->status = $request->status;
        $to_update->statusUpdated = 1;
        $to_update->save();
        return response()->json(['message'=>'status updated successfully','offer'=>$to_update]);  
    }

    public function getMyOffers(Request $request)
    {
        $offer = DB::table('users as u')
        ->join('listings as l', 'u.id', '=', 'l.seller_id')
        ->leftJoin('offers as o', 'l.id', '=', 'o.listing_id')
        ->leftJoin('users as b', 'o.buyer_id', '=', 'b.id')
        ->where('u.id', '=', $request->seller_id)
        ->select('u.name as seller_name', 'l.image as product_image','l.title', 'l.price', 'o.id as offer_id','o.price as offer_price', 'o.status as offer_status', 'b.name as buyer_name', 'b.email as buyer_email', 'b.profile_picture')
        ->get();

        return response()->json(['message'=>'successfully','offer'=>$offer]);
    }
    public function getStatusUpdated(Request $request)
    {
        $statusUpdate = DB::table('offers')
        ->where('offers.id','=',$request->offers_id)
        ->select('offers.statusUpdated')
        ->get();
        return response()->json(['statusUpdated'=>$statusUpdate]);
    }
}
