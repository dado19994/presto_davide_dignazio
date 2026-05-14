<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Review;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class UserReviewComponent extends Component
{
    public $user;
    public $rating = 5;
    public $comment;
    public $reviews;

    public function mount(User $user)
    {
        $this->user = $user;
        $this->loadReviews();
    }

    public function loadReviews()
    {
        $this->reviews = Review::where('reviewed_id', $this->user->id)
            ->with('reviewer')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function submitReview()
    {
        if (!Auth::check() || Auth::id() === $this->user->id) {
            return;
        }

        $this->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|min:5',
        ]);

        Review::create([
            'reviewer_id' => Auth::id(),
            'reviewed_id' => $this->user->id,
            'rating' => $this->rating,
            'comment' => $this->comment,
        ]);

        $this->comment = '';
        $this->loadReviews();
        session()->flash('review_success', 'Recensione inviata con successo!');
    }

    public function render()
    {
        return view('livewire.user-review-component');
    }
}
