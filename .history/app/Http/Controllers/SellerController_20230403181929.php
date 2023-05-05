<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    public function updatingStatus(Request $request)
    {
        $users = DB::table('users')
            ->join('offers', 'offers.buyer_id', '=', 'users.id')
            ->select('users.*')
            ->distinct()
            ->get();

        $to_update = Offer::findOrFail($request->id);
        $to_update->status = $request->status;
        
        $to_update->save();
        return response()->json(['message'=>'offer modified successfully','offer'=>$to_update]);
    }
}
