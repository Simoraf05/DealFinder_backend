<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;

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
    public function getRating(Request $request)
    {
        $rating = Feed
    }
}
