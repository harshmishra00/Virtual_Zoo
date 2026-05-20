<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with(['user', 'animal'])->orderByDesc('created_at')->paginate(20);
        return view('admin.reviews.index', compact('reviews'));
    }

    public function approve(Review $review)
    {
        $review->update(['is_approved' => true]);
        return back()->with('success', 'Review approved and published.');
    }

    public function reject(Review $review)
    {
        $review->delete();
        return back()->with('success', 'Review rejected and removed.');
    }
}
