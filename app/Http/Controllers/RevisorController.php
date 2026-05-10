<?php

namespace App\Http\Controllers;

use App\Mail\BecomeRevisor;
use App\Models\Article;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class RevisorController extends Controller
{
    public function index()
    {
        $article_to_check = Article::whereNull('is_accepted')->first();

        return view('revisor.index', compact('article_to_check'));
    }

    public function accept(Article $article)
    {
        $article->setAccepted(true);
        return redirect()
            ->back()
            ->with('message', 'Articolo accettato con successo ' . $article->title);
    }

    public function reject(Article $article)
    {
        $article->setAccepted(false);
        return redirect()
            ->back()
            ->with('message', 'Articolo rifiutato con successo ' . $article->title);
    }

    public function becomeRevisor()
    {
        Mail::to('admin@example.com')->send(new BecomeRevisor(Auth::user()));
        return redirect()->route('homepage')->with('message', 'Richiesta inviata con successo');
    }

    public function makeRevisor(User $user)
    {
        Artisan::call('app:make-user-revisor', ['email' => $user->email]);
        return redirect()->route('homepage')
            ->with('message', 'Utente nominato revisore con successo');
    }
}
