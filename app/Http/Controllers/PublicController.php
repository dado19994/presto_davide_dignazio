<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class PublicController extends Controller
{


    public function homepage(){
        $articles = Article::where('is_accepted', true)->orderBy('created_at', 'desc')->take(6)->get();
        return view('welcome', compact('articles'));
    }

    // public function searchArticles(Request $request){
    //     $query = $request->input('query');
    //     $articles = Article::search($query)->where('is_accepted', true)->paginate(10);
    //     return view('article.searched', ['articles' => $articles, 'query' => $query]);
    // }

    public function searchArticles(Request $request)
    {
        $query = $request->input('query');

        $articles = Article::where('is_accepted', true)
            ->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('article.searched', [
            'articles' => $articles,
            'query' => $query
        ]);
    }

    public function setLanguage($lang){
        session()->put('locale', $lang);
        return redirect()->back();
    }
}
