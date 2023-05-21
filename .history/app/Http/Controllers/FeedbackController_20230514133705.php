<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FeedbackController extends Controller
{
    public function addFeedback(Request $request)
    {
        $request->validate([
            'author_id'=>'required',
            'recipient_id'=>'required',
            'listings_id'=>'required',
            'rating'=>'required',
            'comment'=>'required',
        ]);

        $feedback = new Feedback();
        $feedback->author_id = $request->author_id;
        $feedback->recipient_id = $request->recipient_id;
        $feedback->listings_id = $request->listings_id;
        $feedback->rating = $request->rating;
        $feedback->comment = $request->comment;

        $feedback->save();
        return response()->json(['message'=>'feedback added successfully','feedback'=>$feedback]);
    }
    public function getRating()
    {
        $rating = Feedback::all();
        return response()->json(['rating'=>$rating]);
    }
    public function getComments (Request $request)
    {
        $comment = DB::table('feedback')
        ->join('users','on','users.id','=','feedback.author_id')
        ->where('listings_id',$request->id)
        ->select('')
        ->get();
        return response()->json(['comments'=>$comment]);

    }
}
