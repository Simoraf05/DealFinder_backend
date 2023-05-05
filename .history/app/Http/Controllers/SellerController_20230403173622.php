<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    public function updatingStatus()
    {
        $to_update = Offer::findOrFail($offerId, Request $request);
        $to_update->price = $request->price;

        $to_update->save();
        return response()->json(['message'=>'offer modified successfully','offer'=>$to_update]);
    }
}
