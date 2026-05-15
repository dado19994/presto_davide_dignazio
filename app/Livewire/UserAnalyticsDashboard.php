<?php

namespace App\Livewire;

use App\Models\Article;
use App\Models\ArticleAnalytics;
use App\Models\Message;
use App\Models\Review;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class UserAnalyticsDashboard extends Component
{
    use WithFileUploads;

    public array $profile = [];
    public array $articleStats = [];
    public array $salesCenter = [];
    public array $favoritesAndCart = [];
    public array $reputation = [];
    public array $ai = [];

    public Collection $myArticles;
    public Collection $recentTransactions;
    public Collection $recentMessages;
    public Collection $favoriteSuggestions;
    public Collection $recentReviews;

    public int $totalViews = 0;
    public int $totalClicks = 0;
    public string $bio = '';
    public string $city = '';
    public $avatar;

    public function mount(): void
    {
        $this->myArticles = collect();
        $this->recentTransactions = collect();
        $this->recentMessages = collect();
        $this->favoriteSuggestions = collect();
        $this->recentReviews = collect();

        $this->loadDashboard();
    }

    public function saveProfile(): void
    {
        $user = Auth::user();

        if (! $user) {
            return;
        }

        $this->validate([
            'bio' => ['nullable', 'string', 'max:500'],
            'city' => ['nullable', 'string', 'max:120'],
            'avatar' => ['nullable', 'image', 'max:1024'],
        ], [
            'bio.max' => 'La bio può contenere al massimo 500 caratteri.',
            'city.max' => 'La città/zona può contenere al massimo 120 caratteri.',
            'avatar.image' => 'Il file deve essere un’immagine.',
            'avatar.max' => 'L’avatar può pesare al massimo 1MB.',
        ]);

        $data = [
            'bio' => $this->bio ?: null,
            'city' => $this->city ?: null,
        ];

        if ($this->avatar) {
            if ($user->avatar_path) {
                Storage::disk('public')->delete($user->avatar_path);
            }

            $data['avatar_path'] = $this->avatar->store('avatars', 'public');
        }

        $user->update($data);

        $this->avatar = null;
        session()->flash('profile_success', 'Profilo aggiornato con successo.');
        $this->loadDashboard();
    }

    public function loadDashboard(): void
    {
        $user = Auth::user();

        if (! $user) {
            return;
        }

        $this->myArticles = Article::with(['images', 'category'])
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        $articleIds = $this->myArticles->pluck('id');
        $analytics = ArticleAnalytics::whereIn('article_id', $articleIds)->get();
        $soldArticleIds = Transaction::where('seller_id', $user->id)
            ->where('status', 'completed')
            ->pluck('article_id')
            ->unique();

        $receivedReviews = Review::with('reviewer')
            ->where('reviewed_id', $user->id)
            ->latest()
            ->get();

        $this->recentReviews = $receivedReviews->take(4);
        $this->totalViews = (int) $analytics->sum('views');
        $this->totalClicks = (int) $analytics->sum('clicks');

        $averageRating = round((float) $receivedReviews->avg('rating'), 1);
        $publishedCount = $this->myArticles->count();
        $completedSales = $soldArticleIds->count();

        $this->bio = (string) ($user->bio ?? '');
        $this->city = (string) ($user->city ?? '');

        $this->profile = [
            'initials' => $this->initials($user->name),
            'name' => trim($user->name . ' ' . ($user->surname ?? '')),
            'email' => $user->email,
            'bio' => $user->bio ?: 'Aggiungi una bio breve per aumentare la fiducia degli acquirenti.',
            'zone' => $user->city ?: 'Zona non impostata',
            'avatar_url' => $user->avatarUrl(),
            'badge' => $this->reliabilityBadge($averageRating, $completedSales, $publishedCount),
            'average_rating' => $averageRating,
            'reviews_count' => $receivedReviews->count(),
            'published_count' => $publishedCount,
            'response_time' => $this->estimateResponseTime($user->id),
        ];

        $this->articleStats = [
            'active' => $this->myArticles->where('is_accepted', true)->count(),
            'pending' => $this->myArticles->whereNull('is_accepted')->count(),
            'rejected' => $this->myArticles->where('is_accepted', false)->count(),
            'sold' => $completedSales,
            'drafts' => 0,
        ];

        $receivedTransactions = Transaction::with(['article', 'buyer'])
            ->where('seller_id', $user->id)
            ->latest()
            ->get();

        $purchases = Transaction::with(['article', 'seller'])
            ->where('buyer_id', $user->id)
            ->latest()
            ->get();

        $openMessages = Message::with(['sender', 'article'])
            ->where('receiver_id', $user->id)
            ->latest()
            ->get();

        $this->recentTransactions = $receivedTransactions->take(5);
        $this->recentMessages = $openMessages->take(5);

        $this->salesCenter = [
            'received_transactions' => $receivedTransactions->count(),
            'purchases' => $purchases->count(),
            'completed_orders' => $receivedTransactions->where('status', 'completed')->count(),
            'pending_orders' => $receivedTransactions->where('status', 'pending')->count(),
            'open_messages' => $openMessages->count(),
            'requests_to_answer' => $openMessages->where('read', false)->count(),
        ];

        $favoriteArticles = $user->favoriteArticles()->with(['images', 'category'])->get();
        $cartIds = collect(session('cart', []))->unique();
        $favoriteCategoryIds = $favoriteArticles->pluck('category_id')->filter()->unique();

        $this->favoriteSuggestions = Article::with(['images', 'category'])
            ->where('is_accepted', true)
            ->where('user_id', '!=', $user->id)
            ->when($favoriteCategoryIds->isNotEmpty(), fn ($query) => $query->whereIn('category_id', $favoriteCategoryIds))
            ->whereNotIn('id', $favoriteArticles->pluck('id'))
            ->latest()
            ->take(3)
            ->get();

        $this->favoritesAndCart = [
            'favorites_count' => $favoriteArticles->count(),
            'cart_count' => $cartIds->count(),
            'suggestions_count' => $this->favoriteSuggestions->count(),
        ];

        $ratingDistribution = [];
        for ($rating = 5; $rating >= 1; $rating--) {
            $ratingDistribution[$rating] = $receivedReviews->where('rating', $rating)->count();
        }

        $this->reputation = [
            'reviews_received' => $receivedReviews->count(),
            'average_rating' => $averageRating,
            'distribution' => $ratingDistribution,
            'profile_suggestions' => $this->profileSuggestions($receivedReviews, $publishedCount),
        ];

        $this->ai = [
            'listing_coach' => $this->listingCoach($analytics, $openMessages),
            'article_scores' => $this->articleScores($analytics),
            'dynamic_pricing' => $this->dynamicPricing($analytics, $openMessages),
            'reply_suggestions' => $this->replySuggestions($openMessages),
            'performance' => $this->performanceInsights($analytics, $openMessages),
            'cover_suggestions' => $this->coverSuggestions(),
            'risk_alerts' => $this->riskAlerts($openMessages),
            'weekly_summary' => $this->weeklySummary($analytics, $favoriteArticles, $openMessages),
        ];
    }

    private function initials(string $name): string
    {
        return collect(explode(' ', trim($name)))
            ->filter()
            ->take(2)
            ->map(fn (string $part) => mb_strtoupper(mb_substr($part, 0, 1)))
            ->implode('');
    }

    private function reliabilityBadge(float $averageRating, int $completedSales, int $publishedCount): string
    {
        if ($averageRating >= 4.5 && $completedSales >= 3) {
            return 'Venditore affidabile';
        }

        if ($publishedCount >= 3) {
            return 'Profilo in crescita';
        }

        return 'Nuovo venditore';
    }

    private function estimateResponseTime(int $userId): string
    {
        $incoming = Message::where('receiver_id', $userId)->latest()->take(20)->get();

        if ($incoming->isEmpty()) {
            return 'N/D';
        }

        $minutes = [];

        foreach ($incoming as $message) {
            $reply = Message::where('article_id', $message->article_id)
                ->where('sender_id', $userId)
                ->where('receiver_id', $message->sender_id)
                ->where('created_at', '>', $message->created_at)
                ->oldest()
                ->first();

            if ($reply) {
                $minutes[] = $message->created_at->diffInMinutes($reply->created_at);
            }
        }

        if (empty($minutes)) {
            return 'Da migliorare';
        }

        $average = (int) round(array_sum($minutes) / count($minutes));

        if ($average < 60) {
            return "{$average} min";
        }

        return round($average / 60, 1) . ' h';
    }

    private function listingCoach(Collection $analytics, Collection $openMessages): array
    {
        $tips = [];

        foreach ($this->myArticles->take(6) as $article) {
            $articleAnalytics = $analytics->where('article_id', $article->id);
            $views = (int) $articleAnalytics->sum('views');
            $contacts = $openMessages->where('article_id', $article->id)->count();

            if (mb_strlen($article->description) < 80) {
                $tips[] = [
                    'title' => $article->title,
                    'type' => 'Descrizione troppo corta',
                    'text' => 'Aggiungi condizioni, accessori inclusi, motivo della vendita e dettagli di consegna.',
                ];
            } elseif ($article->images->count() < 3) {
                $tips[] = [
                    'title' => $article->title,
                    'type' => 'Foto da potenziare',
                    'text' => 'Inserisci almeno 3 foto: copertina, dettaglio e prodotto in uso.',
                ];
            } elseif ($views > 40 && $contacts === 0) {
                $tips[] = [
                    'title' => $article->title,
                    'type' => 'Molte visite, pochi contatti',
                    'text' => 'Il prezzo o la prima immagine potrebbero non convincere. Prova un test prezzo.',
                ];
            }
        }

        return array_slice($tips ?: [[
            'title' => 'Annunci in buona forma',
            'type' => 'Nessuna urgenza',
            'text' => 'Continua a monitorare visite, preferiti e messaggi: l’AI ti avviserà quando nota un calo.',
        ]], 0, 4);
    }

    private function articleScores(Collection $analytics): array
    {
        return $this->myArticles->take(5)->map(function (Article $article) use ($analytics) {
            $score = 20;
            $score += min(25, mb_strlen($article->description) >= 160 ? 25 : (int) mb_strlen($article->description) / 7);
            $score += min(20, $article->images->count() * 7);
            $score += $article->category_id ? 15 : 0;
            $score += $article->price > 0 ? 10 : 0;
            $score += mb_strlen($article->title) >= 8 ? 10 : 0;

            $views = (int) $analytics->where('article_id', $article->id)->sum('views');

            return [
                'title' => $article->title,
                'score' => min(100, $score),
                'views' => $views,
                'status' => $score >= 75 ? 'Ottimo' : ($score >= 55 ? 'Da ottimizzare' : 'Critico'),
            ];
        })->values()->all();
    }

    private function dynamicPricing(Collection $analytics, Collection $openMessages): array
    {
        return $this->myArticles->take(4)->map(function (Article $article) use ($analytics, $openMessages) {
            $views = (int) $analytics->where('article_id', $article->id)->sum('views');
            $contacts = $openMessages->where('article_id', $article->id)->count();
            $daysOnline = max(1, (int) $article->created_at->diffInDays(now()));

            if ($views > 35 && $contacts === 0 && $daysOnline >= 3) {
                $suggested = max(1, $article->price * .93);
                $message = 'Molte visite ma nessuna richiesta: prova un prezzo leggermente più competitivo.';
            } elseif ($views < 10 && $daysOnline >= 5) {
                $suggested = $article->price;
                $message = 'Poche visite: prima migliora titolo e foto copertina, poi valuta il prezzo.';
            } else {
                $suggested = $article->price;
                $message = 'Prezzo coerente: continua a monitorare le interazioni.';
            }

            return [
                'title' => $article->title,
                'current' => $article->price,
                'suggested' => $suggested,
                'message' => $message,
            ];
        })->values()->all();
    }

    private function replySuggestions(Collection $openMessages): array
    {
        return $openMessages->take(3)->map(fn (Message $message) => [
            'article' => $message->article?->title ?? 'Annuncio',
            'from' => $message->sender?->name ?? 'Utente',
            'message' => $message->content,
            'suggestion' => 'Ciao! Grazie per il messaggio. L’articolo è disponibile: posso darti altri dettagli o concordare consegna e pagamento in sicurezza qui su VendoHub.',
        ])->values()->all();
    }

    private function performanceInsights(Collection $analytics, Collection $openMessages): array
    {
        $insights = [];
        $topArticle = $this->myArticles
            ->sortByDesc(fn (Article $article) => $analytics->where('article_id', $article->id)->sum('views'))
            ->first();

        if ($topArticle) {
            $views = (int) $analytics->where('article_id', $topArticle->id)->sum('views');
            $contacts = $openMessages->where('article_id', $topArticle->id)->count();

            $insights[] = [
                'title' => 'Analisi performance',
                'text' => "\"{$topArticle->title}\" ha {$views} visite e {$contacts} messaggi: " . ($contacts === 0 ? 'lavora su prezzo o foto copertina.' : 'mantieni alta la velocità di risposta.'),
            ];
        }

        $conversion = $this->totalViews > 0 ? round(($openMessages->count() / $this->totalViews) * 100, 1) : 0;
        $insights[] = [
            'title' => 'Conversione visite/chat',
            'text' => "Conversione stimata: {$conversion}%. Obiettivo consigliato: superare il 3% con descrizioni più complete.",
        ];

        return $insights;
    }

    private function coverSuggestions(): array
    {
        return $this->myArticles
            ->filter(fn (Article $article) => $article->images->count() > 1)
            ->take(3)
            ->map(fn (Article $article) => [
                'title' => $article->title,
                'text' => 'Usa come copertina la foto più luminosa, con prodotto centrato e sfondo pulito.',
            ])
            ->values()
            ->all();
    }

    private function riskAlerts(Collection $openMessages): array
    {
        $keywords = ['whatsapp', 'bonifico', 'fuori app', 'email', 'telefono', 'telegram'];

        $alerts = $openMessages->filter(function (Message $message) use ($keywords) {
            $content = mb_strtolower($message->content);

            foreach ($keywords as $keyword) {
                if (str_contains($content, $keyword)) {
                    return true;
                }
            }

            return false;
        })->take(3)->map(fn (Message $message) => [
            'article' => $message->article?->title ?? 'Annuncio',
            'text' => 'Possibile richiesta rischiosa: mantieni pagamento e comunicazioni sulla piattaforma.',
        ])->values()->all();

        return $alerts ?: [[
            'article' => 'AI Guard',
            'text' => 'Nessun comportamento sospetto rilevato nei messaggi recenti.',
        ]];
    }

    private function weeklySummary(Collection $analytics, Collection $favoriteArticles, Collection $openMessages): string
    {
        $weekViews = (int) $analytics
            ->filter(fn (ArticleAnalytics $row) => Carbon::parse($row->date)->greaterThanOrEqualTo(now()->subDays(7)))
            ->sum('views');

        $bestArticle = $this->myArticles
            ->sortByDesc(fn (Article $article) => $analytics->where('article_id', $article->id)->sum('views'))
            ->first();

        $bestTitle = $bestArticle?->title ?? 'nessun annuncio ancora';

        return "Questa settimana hai avuto {$weekViews} visite, {$favoriteArticles->count()} preferiti, {$openMessages->count()} chat aperte. Miglior annuncio: {$bestTitle}.";
    }

    private function profileSuggestions(Collection $reviews, int $publishedCount): array
    {
        $suggestions = [
            'Aggiungi bio e zona per rendere il profilo più affidabile.',
        ];

        if ($reviews->isEmpty()) {
            $suggestions[] = 'Chiedi feedback dopo ogni vendita completata: aumenta la fiducia sui prossimi annunci.';
        }

        if ($publishedCount < 3) {
            $suggestions[] = 'Pubblica almeno 3 annunci curati per far percepire il profilo come attivo.';
        }

        return $suggestions;
    }

    public function render()
    {
        return view('livewire.user-analytics-dashboard');
    }
}
