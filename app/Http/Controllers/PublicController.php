<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class PublicController extends Controller
{


    public function homepage(){
        $articles = Article::where('is_accepted', true)
            ->orderByDesc('is_highlighted')
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();
        return view('welcome', compact('articles'));
    }

    // public function searchArticles(Request $request){
    //     $query = $request->input('query');
    //     $articles = Article::search($query)->where('is_accepted', true)->paginate(10);
    //     return view('article.searched', ['articles' => $articles, 'query' => $query]);
    // }

    public function searchArticles(Request $request)
    {
        $query = trim((string) $request->input('query'));

        $articles = Article::with(['images', 'category', 'user'])
            ->where('is_accepted', true)
            ->when($query !== '', function ($articleQuery) use ($query) {
                $words = collect(preg_split('/\s+/', $query))->filter()->take(6);

                $articleQuery->where(function ($q) use ($query, $words) {
                    $q->where('title', 'like', "%{$query}%")
                        ->orWhere('brand_model', 'like', "%{$query}%")
                        ->orWhere('description', 'like', "%{$query}%")
                        ->orWhere('tags', 'like', "%{$query}%")
                        ->orWhereHas('category', fn ($categoryQuery) => $categoryQuery->where('name', 'like', "%{$query}%"));

                    foreach ($words as $word) {
                        $q->orWhere('title', 'like', "%{$word}%")
                            ->orWhere('brand_model', 'like', "%{$word}%")
                            ->orWhere('tags', 'like', "%{$word}%");
                    }
                });
            })
            ->when($request->filled('min_price'), fn ($q) => $q->where('price', '>=', (float) $request->input('min_price')))
            ->when($request->filled('max_price'), fn ($q) => $q->where('price', '<=', (float) $request->input('max_price')))
            ->when($request->filled('tag'), fn ($q) => $q->where('tags', 'like', '%' . $request->input('tag') . '%'))
            ->when($request->boolean('highlighted'), fn ($q) => $q->where('is_highlighted', true));

        $articles->orderByDesc('is_highlighted');

        match ($request->input('sort', 'recent')) {
            'oldest' => $articles->orderBy('created_at'),
            'price_asc' => $articles->orderBy('price'),
            'price_desc' => $articles->orderByDesc('price'),
            default => $articles->orderByDesc('created_at'),
        };

        $articles = $articles->paginate(10)->withQueryString();

        return view('article.searched', [
            'articles' => $articles,
            'query' => $query
        ]);
    }

    public function setLanguage($lang){
        session()->put('locale', $lang);
        return redirect()->back();
    }

    public function dashboard()
    {
        return view('user.dashboard');
    }
}
