<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class FavoriteController extends Controller
{
    public function index(): View
    {
        $favorites = Auth::user()
            ->favorites()
            ->with(['article.images', 'article.category'])
            ->latest()
            ->get();

        return view('favorites.index', compact('favorites'));
    }

    public function toggle(Request $request, Article $article): RedirectResponse
    {
        $favorite = Auth::user()
            ->favorites()
            ->where('article_id', $article->id)
            ->first();

        if ($favorite) {
            $favorite->delete();
            $message = __('ui.favorites_page.removed');
        } else {
            Auth::user()->favorites()->create([
                'article_id' => $article->id,
            ]);
            $message = __('ui.favorites_page.added');
        }

        return back()->with('success', $message);
    }
}
