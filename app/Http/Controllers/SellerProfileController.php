<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\User;
use Illuminate\View\View;

class SellerProfileController extends Controller
{
    public function show(User $user): View
    {
        $user->load(['articles.images', 'articles.category']);

        $articles = $user->articles()
            ->with(['images', 'category'])
            ->where('is_accepted', true)
            ->latest()
            ->paginate(9);

        $reviews = Review::with('reviewer')
            ->where('reviewed_id', $user->id)
            ->latest()
            ->take(6)
            ->get();

        $averageRating = round((float) $reviews->avg('rating'), 1);

        return view('seller.show', compact('user', 'articles', 'reviews', 'averageRating'));
    }
}
