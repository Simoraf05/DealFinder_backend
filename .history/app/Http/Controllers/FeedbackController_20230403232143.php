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
        $feedback->
    }
}
