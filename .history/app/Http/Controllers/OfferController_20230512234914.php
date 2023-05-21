<?php

namespace App\Http\Controllers;

use App\Models\Listing;
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

    public function updatingProductStatus(Request $request)
    {
            $product = Listing::findOrFail($request->id);
            $product->status = $request->status;
            $product->save();
            return response()->json(['message'=>'status updated successfully','product'=>$product]);  

    }

    public function getMyOffers(Request $request)
    {
        $offer = DB::table('offers as u')
        ->join('listings as l', 'u.id', '=', 'l.seller_id')
        ->leftJoin('offers as o', 'l.id', '=', 'o.listing_id')
        ->leftJoin('users as b', 'o.buyer_id', '=', 'b.id')
        ->where('u.id', '=', $request->seller_id)
        ->select('u.name as seller_name','l.id as idP', 'l.image as product_image','l.title', 'l.price', 'o.id as offer_id','o.price as offer_price', 'o.status as offer_status', 'b.name as buyer_name', 'b.email as buyer_email', 'b.profile_picture')
        ->get();

        return response()->json(['message'=>'successfully','offer'=>$offer]);
    }


    public function getStatusUpdated(Request $request)
    {
        $statusUpdate = DB::table('offers')
        ->where('offers.id','=',$request->id)
        ->select('offers.statusUpdated')
        ->get();
        return response()->json(['statusUpdated'=>$statusUpdate]);
    }

    public function offer_detail(Request $request)
    {
        $offer = DB::table('offers')
        ->join('listings','offers.listing_id','=','listings.id')
        ->join('users','offers.buyer_id','=','users.id')
        ->where('listings.id','=',$request->product_id)
        ->select('listings.id as product_id','offers.id','offers.price as offer_price','offers.status','users.name as buyer_name','users.email as buyer_email')
        ->get();
        return response()->json(['offer_detail'=>$offer]);
    }

    public function updateOffer(Request $request)
    {
        $to_update = Offer::findOrFail($request->id);
        if($request->has('price')){
            $to_update->price = $request->price;
        }
        if($request->has('status')){
            $to_update->status = $request->status;
        }
        $to_update->save();
        return response()->json(['message'=>'offer updated successfuly']);
    }

    public function deleteOffer(Request $request)
    {
        $to_delete = Offer::find($request->id);
        $to_delete->delete();
    
        return response()->json([
            'message'=>'Offer deleted successfully',
        ]);
    }
}
