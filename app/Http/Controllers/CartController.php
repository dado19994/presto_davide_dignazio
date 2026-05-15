<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(Request $request): View
    {
        $cartIds = collect($request->session()->get('cart', []))->unique()->values();

        $articles = Article::with(['images', 'category', 'user'])
            ->whereIn('id', $cartIds)
            ->get()
            ->sortBy(fn (Article $article) => $cartIds->search($article->id))
            ->values();

        $total = $articles->sum('price');

        return view('cart.index', compact('articles', 'total'));
    }

    public function store(Request $request, Article $article): RedirectResponse
    {
        $cart = collect($request->session()->get('cart', []))
            ->push($article->id)
            ->unique()
            ->values()
            ->all();

        $request->session()->put('cart', $cart);

        return back()
            ->with('success', __('ui.cart_page.added'));
    }

    public function destroy(Request $request, Article $article): RedirectResponse
    {
        $cart = collect($request->session()->get('cart', []))
            ->reject(fn ($id) => (int) $id === $article->id)
            ->values()
            ->all();

        $request->session()->put('cart', $cart);

        return redirect()
            ->route('cart.index')
            ->with('success', __('ui.cart_page.removed'));
    }

    public function clear(Request $request): RedirectResponse
    {
        $request->session()->forget('cart');

        return redirect()
            ->route('cart.index')
            ->with('success', __('ui.cart_page.cleared'));
    }
}
