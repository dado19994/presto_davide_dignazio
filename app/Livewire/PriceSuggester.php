<?php

namespace App\Livewire;

use App\Models\Article;
use Livewire\Component;

class PriceSuggester extends Component
{
    public $title;
    public $categoryId;
    public $suggestedPrice;
    public $isAnalyzing = false;

    protected $listeners = ['titleUpdated', 'categoryUpdated'];

    public function titleUpdated($title)
    {
        $this->title = $title;
        $this->calculateSuggestion();
    }

    public function categoryUpdated($categoryId)
    {
        $this->categoryId = $categoryId;
        $this->calculateSuggestion();
    }

    public function calculateSuggestion()
    {
        if (empty($this->title) || empty($this->categoryId)) {
            $this->suggestedPrice = null;
            return;
        }

        $this->isAnalyzing = true;

        // Simuliamo un'analisi AI basata sulla media dei prezzi per categoria e parole chiave nel titolo
        $basePrice = Article::where('category_id', $this->categoryId)->avg('price') ?: 50;

        // Fattore casuale "intelligente" basato sulla lunghezza del titolo
        $multiplier = (strlen($this->title) % 10) / 10 + 0.8;

        $this->suggestedPrice = round($basePrice * $multiplier, 2);
        $this->isAnalyzing = false;
    }

    public function render()
    {
        return view('livewire.price-suggester');
    }
}
