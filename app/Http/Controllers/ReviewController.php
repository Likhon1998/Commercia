<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\ReviewReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    // Store a new review
    public function storeReview(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'comment' => 'required|string|max:1000',
        ]);

        Review::create([
            'product_id' => $request->product_id,
            'user_id' => Auth::id(),
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Review added successfully!');
    }

    // Store a reply (to a review or another reply)
    public function storeReply(Request $request, Review $review)
    {
        $request->validate([
            'reply' => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:review_replies,id',
        ]);

        ReviewReply::create([
            'review_id' => $review->id,
            'user_id'   => Auth::id(),
            'reply'     => $request->reply,
            'parent_id' => $request->parent_id,
        ]);

        return back()->with('success', 'Reply added successfully!');
    }

    // Delete a review (user can delete own, admin can delete any)
    public function destroyReview(Review $review)
    {
        if (Auth::id() === $review->user_id || Auth::user()->hasRole('admin')) {
            $review->delete();
            return back()->with('success', 'Review deleted successfully.');
        }

        abort(403, 'Unauthorized');
    }

    // Delete a reply (user can delete own, admin can delete any)
    public function destroyReply(ReviewReply $reply)
    {
        if (Auth::id() === $reply->user_id || Auth::user()->hasRole('admin')) {
            $reply->delete();
            return back()->with('success', 'Reply deleted successfully.');
        }

        abort(403, 'Unauthorized');
    }

    // Show product reviews (optional)
    public function showProductReviews($productId)
    {
        $reviews = Review::with([
            'user',
            'replies' => function ($query) {
                $query->whereNull('parent_id')->with(['user', 'replies.user']);
            }
        ])
        ->where('product_id', $productId)
        ->latest()
        ->get();

        return view('products.show', compact('reviews'));
    }
}
