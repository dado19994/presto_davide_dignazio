<?php

namespace App\Livewire;

use App\Models\Article;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class FavoriteButton extends Component
{
    public $articleId;
    public $isFavorite;

    public function mount($articleId)
    {
        $this->articleId = $articleId;
        $this->checkIfFavorite();
    }

    public function checkIfFavorite()
    {
        if (Auth::check()) {
            $this->isFavorite = Auth::user()->favorites()->where('article_id', $this->articleId)->exists();
        } else {
            $this->isFavorite = false;
        }
    }

    public function toggleFavorite()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        if ($this->isFavorite) {
            $user->favorites()->detach($this->articleId);
            $this->isFavorite = false;
        } else {
            $user->favorites()->attach($this->articleId);
            $this->isFavorite = true;
        }
    }

    public function render()
    {
        return view('livewire.favorite-button');
    }
}
