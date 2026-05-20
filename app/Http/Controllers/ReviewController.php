<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Animal;
use App\Http\Requests\StoreReviewRequest;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(StoreReviewRequest $request)
    {
        Review::create([
            'user_id'   => Auth::id(),
            'animal_id' => $request->animal_id,
            'rating'    => $request->rating,
            'title'     => $request->title,
            'body'      => $request->body,
            'is_approved' => false,
        ]);

        return back()->with('success', 'Your review has been submitted and is awaiting approval. Thank you!');
    }
}
