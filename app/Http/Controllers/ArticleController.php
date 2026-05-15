<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
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

    public function index(){
        $articles = Article::where('is_accepted', true)
            ->orderByDesc('is_highlighted')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

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

        return view('article.show', compact('article', 'recommendedArticles'));
    }

    public function byCategory(Category $category){
        $articles = $category->articles()
            ->where('is_accepted', true)
            ->orderByDesc('is_highlighted')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

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
            'description' => ['required', 'string', 'min:10'],
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
}
