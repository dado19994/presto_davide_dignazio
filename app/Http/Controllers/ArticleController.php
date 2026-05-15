<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Review;
use App\Models\Transaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ArticleController extends Controller
{
    public function create(){
        return view('article.create');
    }

    public function index(Request $request){
        $articles = Article::where('is_accepted', true)
            ->when($request->filled('min_price'), fn ($query) => $query->where('price', '>=', (float) $request->input('min_price')))
            ->when($request->filled('max_price'), fn ($query) => $query->where('price', '<=', (float) $request->input('max_price')))
            ->when($request->boolean('highlighted'), fn ($query) => $query->where('is_highlighted', true))
            ->when($request->filled('tag'), fn ($query) => $query->where('tags', 'like', '%' . $request->input('tag') . '%'));

        $this->applyArticleSort($articles, $request->input('sort', 'recent'));

        $articles = $articles
            ->paginate(10)
            ->withQueryString();

        return view('article.index', compact('articles'));
    }

    public function featured(): View
    {
        $articles = Article::with(['images', 'category', 'user'])
            ->where('is_accepted', true)
            ->where('is_highlighted', true)
            ->latest()
            ->paginate(12);

        return view('article.featured', compact('articles'));
    }

    public function show(Article $article){
        $article->loadMissing(['category', 'images', 'user']);

        $sellerReviewCount = Review::where('reviewed_id', $article->user_id)->count();
        $sellerAverageRating = round((float) Review::where('reviewed_id', $article->user_id)->avg('rating'), 1);
        $sellerCompletedSales = Transaction::where('seller_id', $article->user_id)
            ->where('status', 'completed')
            ->count();
        $favoriteCount = $article->favorites()->count();
        $matchScore = min(98, 72 + ($article->images->count() * 4) + ($article->is_highlighted ? 8 : 0) + ($article->tags ? 5 : 0));
        $activeViewers = max(4, ($article->id % 11) + $favoriteCount + 5);

        $sellerTrust = [
            'rating' => $sellerAverageRating ?: null,
            'reviews' => $sellerReviewCount,
            'sales' => $sellerCompletedSales,
            'member_since' => $article->user?->created_at?->diffForHumans(null, true) ?? 'poco',
            'response_time' => $sellerReviewCount > 3 ? 'pochi minuti' : 'entro la giornata',
        ];

        $productSignals = [
            'favorite_count' => $favoriteCount,
            'match_score' => $matchScore,
            'active_viewers' => $activeViewers,
        ];

        $recommendedArticles = Article::with(['images', 'category'])
            ->where('is_accepted', true)
            ->whereKeyNot($article->id)
            ->when($article->category_id, fn ($query) => $query->where('category_id', $article->category_id))
            ->latest()
            ->take(3)
            ->get();

        if ($recommendedArticles->count() < 3) {
            $fallbackArticles = Article::with(['images', 'category'])
                ->where('is_accepted', true)
                ->whereKeyNot($article->id)
                ->whereNotIn('id', $recommendedArticles->pluck('id'))
                ->latest()
                ->take(3 - $recommendedArticles->count())
                ->get();

            $recommendedArticles = $recommendedArticles->merge($fallbackArticles);
        }

        return view('article.show', compact('article', 'recommendedArticles', 'sellerTrust', 'productSignals'));
    }

    public function byCategory(Request $request, Category $category){
        $articles = $category->articles()
            ->where('is_accepted', true)
            ->when($request->filled('min_price'), fn ($query) => $query->where('price', '>=', (float) $request->input('min_price')))
            ->when($request->filled('max_price'), fn ($query) => $query->where('price', '<=', (float) $request->input('max_price')))
            ->when($request->boolean('highlighted'), fn ($query) => $query->where('is_highlighted', true))
            ->when($request->filled('tag'), fn ($query) => $query->where('tags', 'like', '%' . $request->input('tag') . '%'));

        $this->applyArticleSort($articles, $request->input('sort', 'recent'));

        $articles = $articles
            ->paginate(10)
            ->withQueryString();

        return view('article.byCategory', compact('articles', 'category'));
    }

    public function edit(Article $article): View
    {
        $this->authorizeOwner($article);

        return view('article.edit', compact('article'));
    }

    public function update(Request $request, Article $article): RedirectResponse
    {
        $this->authorizeOwner($article);

        $validated = $request->validate([
            'title' => ['required', 'string', 'min:5', 'max:255'],
            'brand_model' => ['nullable', 'string', 'max:120'],
            'description' => ['required', 'string', 'min:10'],
            'tags' => ['nullable', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0.01'],
            'category_id' => ['required', 'exists:categories,id'],
        ]);

        $article->update([
            ...$validated,
            'is_accepted' => null,
        ]);

        return redirect()
            ->route('user.dashboard')
            ->with('success', 'Annuncio aggiornato e rimesso in revisione.');
    }

    public function destroy(Article $article): RedirectResponse
    {
        $this->authorizeOwner($article);

        foreach ($article->images as $image) {
            Storage::disk('public')->delete($image->path);
            $image->delete();
        }

        $article->delete();

        return redirect()
            ->route('user.dashboard')
            ->with('success', 'Annuncio eliminato.');
    }

    public function republish(Article $article): RedirectResponse
    {
        $this->authorizeOwner($article);

        $article->update([
            'is_accepted' => null,
        ]);

        return back()->with('success', 'Annuncio rimandato in revisione.');
    }

    public function highlight(Article $article): RedirectResponse
    {
        $this->authorizeOwner($article);

        $article->update([
            'is_highlighted' => ! $article->is_highlighted,
        ]);

        return back()->with('success', $article->is_highlighted ? 'Annuncio evidenziato.' : 'Annuncio non più evidenziato.');
    }

    private function authorizeOwner(Article $article): void
    {
        abort_unless(Auth::id() === $article->user_id, 403);
    }

    private function applyArticleSort($query, ?string $sort): void
    {
        $query->orderByDesc('is_highlighted');

        match ($sort) {
            'oldest' => $query->orderBy('created_at'),
            'price_asc' => $query->orderBy('price'),
            'price_desc' => $query->orderByDesc('price'),
            default => $query->orderByDesc('created_at'),
        };
    }
}
