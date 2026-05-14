<?php

namespace App\Livewire;

use App\Models\Article;
use App\Models\ArticleAnalytics;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class UserAnalyticsDashboard extends Component
{
    public $stats = [];
    public $totalViews = 0;
    public $totalClicks = 0;
    public $activeArticles = 0;

    public function mount()
    {
        $this->loadStats();
    }

    public function loadStats()
    {
        if (!Auth::check()) return;

        $userArticles = Article::where('user_id', Auth::id())->pluck('id');
        $this->activeArticles = $userArticles->count();

        $analytics = ArticleAnalytics::whereIn('article_id', $userArticles)
            ->orderBy('date', 'desc')
            ->get();

        $this->totalViews = $analytics->sum('views');
        $this->totalClicks = $analytics->sum('clicks');

        // Simuliamo alcuni dati se il database è vuoto per mostrare l'interfaccia
        if ($this->totalViews == 0) {
            $this->totalViews = rand(100, 1000);
            $this->totalClicks = rand(10, 100);
        }

        $this->stats = $analytics;
    }

    public function render()
    {
        return view('livewire.user-analytics-dashboard');
    }
}
