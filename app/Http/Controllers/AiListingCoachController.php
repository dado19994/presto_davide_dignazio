<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleAnalytics;
use App\Models\Message;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AiListingCoachController extends Controller
{
    public function index(): View
    {
        $articles = Article::with(['images', 'category'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        $articleIds = $articles->pluck('id');
        $analytics = ArticleAnalytics::whereIn('article_id', $articleIds)->get();
        $messages = Message::whereIn('article_id', $articleIds)->get();

        $coachCards = $articles
            ->map(fn (Article $article) => $this->analyseArticle($article, $analytics, $messages))
            ->sortBy('score')
            ->values();

        $summary = [
            'total' => $articles->count(),
            'critical' => $coachCards->where('score', '<', 55)->count(),
            'to_improve' => $coachCards->filter(fn (array $card) => $card['score'] >= 55 && $card['score'] < 75)->count(),
            'excellent' => $coachCards->where('score', '>=', 75)->count(),
            'highlighted' => $articles->where('is_highlighted', true)->count(),
        ];

        return view('article.ai-coach', compact('coachCards', 'summary'));
    }

    private function analyseArticle(Article $article, Collection $analytics, Collection $messages): array
    {
        $descriptionLength = mb_strlen((string) $article->description);
        $imageCount = $article->images->count();
        $views = (int) $analytics->where('article_id', $article->id)->sum('views');
        $clicks = (int) $analytics->where('article_id', $article->id)->sum('clicks');
        $favorites = (int) $analytics->where('article_id', $article->id)->sum('favorites');
        $contacts = $messages->where('article_id', $article->id)->count();
        $daysOnline = max(1, (int) $article->created_at->diffInDays(now()));

        $score = 15;
        $score += min(24, (int) floor($descriptionLength / 7));
        $score += min(21, $imageCount * 7);
        $score += $article->category_id ? 12 : 0;
        $score += $article->price > 0 ? 10 : 0;
        $score += mb_strlen($article->title) >= 12 ? 8 : 3;
        $score += $article->is_highlighted ? 10 : 0;

        $issues = [];
        $actions = [];

        if ($descriptionLength < 120) {
            $issues[] = 'Descrizione breve';
            $actions[] = 'Aggiungi condizioni, misure, accessori, difetti e modalità di consegna.';
        }

        if ($imageCount < 3) {
            $issues[] = 'Poche foto';
            $actions[] = 'Carica almeno 3 immagini: copertina luminosa, dettaglio e prodotto in contesto.';
        }

        if ($views > 35 && $contacts === 0) {
            $issues[] = 'Visite senza contatti';
            $actions[] = 'Rivedi prezzo e immagine principale: l’interesse c’è, manca la spinta alla chat.';
        }

        if ($views < 10 && $daysOnline >= 5) {
            $issues[] = 'Poca visibilità';
            $actions[] = 'Migliora titolo e categoria, poi valuta l’evidenza se l’annuncio è pronto.';
        }

        if (! $article->is_highlighted && $score >= 72) {
            $actions[] = 'Annuncio pronto: puoi metterlo in evidenza per dargli più priorità nel catalogo.';
        }

        if (empty($actions)) {
            $actions[] = 'Annuncio solido: monitora visite, preferiti e messaggi nei prossimi giorni.';
        }

        $suggestedPrice = $article->price;
        $priceNote = 'Prezzo coerente: continua a osservare conversioni e preferiti.';

        if ($views > 35 && $contacts === 0 && $daysOnline >= 3) {
            $suggestedPrice = round(max(1, $article->price * .93), 2);
            $priceNote = 'Prova un ribasso leggero: molte visite non stanno diventando richieste.';
        } elseif ($favorites >= 3 && $contacts === 0) {
            $suggestedPrice = round(max(1, $article->price * .96), 2);
            $priceNote = 'Diversi utenti hanno salvato l’articolo: un piccolo incentivo può sbloccare contatti.';
        }

        return [
            'article' => $article,
            'score' => min(100, $score),
            'status' => $score >= 75 ? 'Ottimo' : ($score >= 55 ? 'Da migliorare' : 'Critico'),
            'issues' => $issues ?: ['Nessun blocco evidente'],
            'actions' => array_slice($actions, 0, 4),
            'views' => $views,
            'clicks' => $clicks,
            'favorites' => $favorites,
            'contacts' => $contacts,
            'days_online' => $daysOnline,
            'suggested_price' => $suggestedPrice,
            'price_note' => $priceNote,
        ];
    }
}
