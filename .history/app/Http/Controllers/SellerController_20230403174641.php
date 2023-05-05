<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    public function updatingStatus(Offer $offer, Request $request)
    {
        $seller = $offer->listing->user;
        if ($request->status === 'accepted') {
            // Update the offer status to "accepted"
            $offer->status = 'accepted';
            $offer->save();
            // Notify the buyer that their offer was accepted
            Mail::to($offer->user->email)->send(new OfferAccepted($offer));
            // Notify the seller that the offer was accepted
            Mail::to($seller->email)->send(new OfferAccepted($offer));
        } elseif ($request->status === 'rejected') {
            // Update the offer status to "rejected"
            $offer->status = 'rejected';
            $offer->save();
            // Notify the buyer that their offer was rejected
            Mail::to($offer->user->email)->send(new OfferRejected($offer));
            // Notify the seller that the offer was rejected
            Mail::to($seller->email)->send(new OfferRejected($offer));
        }
        /*$to_update = Offer::findOrFail($request->id);
        $to_update->status = $request->status;

        $to_update->save();*/
        return response()->json(['message'=>'offer modified successfully','offer'=>$to_update]);
    }
}
