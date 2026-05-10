<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;

class ArticleController extends Controller
{
    public function create(){
        return view('article.create');
    }

    public function index(){
        $articles = Article::where('is_accepted', true)->orderBy('created_at', 'desc')->paginate(10);

        return view('article.index', compact('articles'));
    }

    public function show(Article $article){
        $article->loadMissing('category');

        return view('article.show', compact('article'));
    }

    public function byCategory(Category $category){
        $articles = $category->articles()->where('is_accepted', true)->orderBy('created_at', 'desc')->paginate(10);

        return view('article.byCategory', compact('articles', 'category'));
    }
}
