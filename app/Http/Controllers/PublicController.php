<?php

namespace App\Http\Controllers;

use App\Models\Article;

class PublicController extends Controller
{
    //  public function homepage() {
    //      $articles = Article::with('category')->take(6)->orderBy('created_at', 'desc')->get();

    //      return view('welcome', compact('articles'));
    //  }

    public function homepage(){
        $articles = Article::where('is_accepted', true)->orderBy('created_at', 'desc')->take(6)->get();
        return view('welcome', compact('articles'));
    }
}
