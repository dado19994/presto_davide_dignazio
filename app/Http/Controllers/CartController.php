<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Transaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
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

    public function checkout(Request $request): RedirectResponse
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        $cartIds = collect($request->session()->get('cart', []))->unique()->values();
        $articles = Article::whereIn('id', $cartIds)->where('is_accepted', true)->get();

        if ($articles->isEmpty()) {
            return back()->with('success', 'Il carrello è vuoto.');
        }

        foreach ($articles as $article) {
            Transaction::create([
                'buyer_id' => Auth::id(),
                'seller_id' => $article->user_id,
                'article_id' => $article->id,
                'amount' => $article->price,
                'status' => 'completed',
                'payment_method' => $request->input('payment_method', 'card'),
                'transaction_id' => 'CART-' . strtoupper(Str::random(10)),
            ]);
        }

        $request->session()->forget('cart');

        return redirect()
            ->route('cart.index')
            ->with('success', 'Acquisto completato. Gli ordini sono stati registrati nel centro vendite.');
    }
}
