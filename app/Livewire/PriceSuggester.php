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
    public $marketRange;
    public $sampleSize = 0;
    public $confidence = 'Bassa';

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

        $words = collect(preg_split('/\s+/', mb_strtolower($this->title)))
            ->filter(fn ($word) => mb_strlen($word) >= 4)
            ->take(5);

        $similar = Article::where('is_accepted', true)
            ->where('category_id', $this->categoryId)
            ->where(function ($query) use ($words) {
                foreach ($words as $word) {
                    $query->orWhere('title', 'like', "%{$word}%")
                        ->orWhere('brand_model', 'like', "%{$word}%")
                        ->orWhere('description', 'like', "%{$word}%")
                        ->orWhere('tags', 'like', "%{$word}%");
                }
            })
            ->pluck('price');

        if ($similar->count() < 3) {
            $similar = Article::where('is_accepted', true)
                ->where('category_id', $this->categoryId)
                ->pluck('price');
        }

        $this->sampleSize = $similar->count();

        if ($similar->isEmpty()) {
            $this->suggestedPrice = 50;
            $this->marketRange = null;
            $this->confidence = 'Bassa';
            $this->isAnalyzing = false;
            return;
        }

        $sorted = $similar->sort()->values();
        $avg = (float) $sorted->avg();
        $median = (float) $sorted->get((int) floor(($sorted->count() - 1) / 2));
        $suggested = ($avg * .35) + ($median * .65);

        $this->suggestedPrice = round($suggested, 2);
        $this->marketRange = [
            'min' => round((float) $sorted->first(), 2),
            'max' => round((float) $sorted->last(), 2),
        ];
        $this->confidence = $this->sampleSize >= 6 ? 'Alta' : ($this->sampleSize >= 3 ? 'Media' : 'Bassa');
        $this->isAnalyzing = false;
    }

    public function render()
    {
        return view('livewire.price-suggester');
    }
}
