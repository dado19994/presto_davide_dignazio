<?php

namespace App\Livewire;

use App\Jobs\GoogleVisionLabelImage;
use App\Jobs\GoogleVisionSafeSearch;
use App\Jobs\RemoveFaces;
use App\Jobs\ResizeImage;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateArticleForm extends Component
{

    use WithFileUploads;

    #[Validate('required|min:5')]
    public $title;
    #[Validate('nullable|string|max:120')]
    public $brand_model;
    #[Validate('required|min:10')]
    public $description;
    #[Validate('nullable|string|max:255')]
    public $tags;
    #[Validate('required|numeric')]
    public $price;
    #[Validate('required')]
    public $category;
    public $article;
    public $images = [];
    public $temporary_images;
    public array $aiSuggestions = [];

    public function save()
    {
        $this->validate();
        $this->article = Article::create([
            'title' => $this->title,
            'brand_model' => $this->brand_model,
            'description' => $this->description,
            'tags' => $this->tags,
            'price' => $this->price,
            'category_id' => $this->category,
            'user_id' => Auth::id(),
        ]);
        if (count($this->images) > 0){
            foreach ($this->images as $image){
                $newFileName = "articles/{$this->article->id}";
                $newImage = $this->article->images()->create([
                    'path' => $image->store($newFileName, 'public')
                ]);
                // dispatch(new ResizeImage($newImage->path, 300, 300));
                // dispatch(new GoogleVisionSafeSearch($newImage->id));
                // dispatch(new GoogleVisionLabelImage($newImage->id));

                RemoveFaces::withChain([
                    new ResizeImage($newImage->path, 300, 300),
                    new GoogleVisionSafeSearch($newImage->id),
                    new GoogleVisionLabelImage($newImage->id)
                ])->dispatch($newImage->id);
            }
            File::deleteDirectory(storage_path('/app/livewire-tmp'));
        }



        session()->flash('success', 'Articolo creato con successo!');

        $this->cleanForm();
    }

    protected function cleanForm()
    {
        $this->title = '';
        $this->brand_model = '';
        $this->description = '';
        $this->tags = '';
        $this->price = '';
        $this->category = '';
        $this->images = [];
        $this->temporary_images = null;
        $this->aiSuggestions = [];
    }

    public function updatedTitle($value)
    {
        $this->dispatch('titleUpdated', $value)->to(PriceSuggester::class);
        $this->refreshAiSuggestions();
    }

    public function updatedCategory($value)
    {
        $this->dispatch('categoryUpdated', $value)->to(PriceSuggester::class);
        $this->refreshAiSuggestions();
    }

    public function updatedBrandModel(): void
    {
        $this->refreshAiSuggestions();
    }

    public function applySuggestedTitle(): void
    {
        if (! empty($this->aiSuggestions['title'])) {
            $this->title = $this->aiSuggestions['title'];
            $this->dispatch('titleUpdated', $this->title)->to(PriceSuggester::class);
        }
    }

    public function applySuggestedDescription(): void
    {
        if (! empty($this->aiSuggestions['description'])) {
            $this->description = $this->aiSuggestions['description'];
        }
    }

    public function applySuggestedCategory(): void
    {
        if (! empty($this->aiSuggestions['category_id'])) {
            $this->category = $this->aiSuggestions['category_id'];
            $this->dispatch('categoryUpdated', $this->category)->to(PriceSuggester::class);
        }
    }

    public function applySuggestedBrandModel(): void
    {
        if (! empty($this->aiSuggestions['brand_model'])) {
            $this->brand_model = $this->aiSuggestions['brand_model'];
            $this->refreshAiSuggestions();
        }
    }

    public function applySuggestedTags(): void
    {
        if (! empty($this->aiSuggestions['tags'])) {
            $this->tags = $this->aiSuggestions['tags'];
        }
    }

    public function updatedTemporaryImages()
    {
        if ($this->validate([
            'temporary_images.*' => 'image|max:1024', // 1MB Max per immagine
            'temporary_images' => 'max:6'
        ])){
            foreach ($this->temporary_images as $image){
                $this->images[] = $image;
            }
        }
    }

    public function removeImage($key)
    {
        if (in_array($key, array_keys($this->images))){
            unset($this->images[$key]);
            $this->images = array_values($this->images);
        }
    }

    private function refreshAiSuggestions(): void
    {
        $title = trim((string) $this->title);
        $brandModel = trim((string) $this->brand_model);

        if (mb_strlen($title) < 3) {
            $this->aiSuggestions = [];
            return;
        }

        $category = $this->suggestCategory($title . ' ' . $brandModel);
        $categoryName = $category?->name ?? 'categoria';
        $cleanBrand = $brandModel ?: $this->extractBrandModel($title);
        $baseTitle = $cleanBrand ? "{$cleanBrand} - {$title}" : $title;

        $this->aiSuggestions = [
            'category_id' => $category?->id,
            'category_name' => $categoryName,
            'brand_model' => $cleanBrand,
            'title' => str($baseTitle)->squish()->title()->limit(75, '')->toString(),
            'description' => $this->buildSuggestedDescription($title, $cleanBrand, $categoryName),
            'tags' => $this->buildSuggestedTags($title, $cleanBrand, $categoryName),
        ];
    }

    private function suggestCategory(string $text): ?Category
    {
        $normalized = str($text)->lower()->ascii()->toString();
        $rules = [
            'Elettronica' => ['iphone', 'samsung', 'macbook', 'pc', 'computer', 'tablet', 'console', 'playstation', 'xbox', 'camera', 'fotocamera', 'smartwatch', 'airpods'],
            'Abbigliamento' => ['giacca', 'maglia', 'scarpe', 'sneakers', 'vestito', 'pantaloni', 'felpa', 'cappotto', 'tshirt', 'borsa'],
            'Salute e Bellezza' => ['crema', 'makeup', 'trucco', 'profumo', 'phon', 'piastra', 'beauty', 'skincare'],
            'Casa e Giardino' => ['divano', 'sedia', 'tavolo', 'lampada', 'mobile', 'tagliaerba', 'giardino', 'cucina'],
            'Giocattoli' => ['lego', 'bambola', 'gioco', 'puzzle', 'peluche', 'modellino'],
            'Sport' => ['bici', 'palestra', 'racchetta', 'pallone', 'sci', 'tapis', 'fitness'],
            'Animali Domestici' => ['cane', 'gatto', 'cuccia', 'guinzaglio', 'acquario', 'trasportino'],
            'Libri e Riviste' => ['libro', 'romanzo', 'fumetto', 'rivista', 'manuale', 'enciclopedia'],
            'Accessori' => ['occhiali', 'collana', 'orologio', 'bracciale', 'anello', 'cintura', 'zaino'],
            'Motori' => ['auto', 'moto', 'casco', 'gomme', 'cerchi', 'ricambi', 'scooter'],
        ];

        $scores = [];

        foreach ($rules as $categoryName => $keywords) {
            foreach ($keywords as $keyword) {
                if (str_contains($normalized, $keyword)) {
                    $scores[$categoryName] = ($scores[$categoryName] ?? 0) + 1;
                }
            }
        }

        arsort($scores);
        $name = array_key_first($scores);

        return $name ? Category::where('name', $name)->first() : null;
    }

    private function extractBrandModel(string $title): string
    {
        preg_match('/\b([A-Z][A-Za-z0-9]+(?:\s+[A-Z0-9][A-Za-z0-9]+){0,2})\b/', $title, $matches);

        return $matches[1] ?? '';
    }

    private function buildSuggestedDescription(string $title, string $brandModel, string $categoryName): string
    {
        $subject = trim($brandModel . ' ' . $title);

        return "Vendo {$subject} in buone condizioni. L'articolo appartiene alla categoria {$categoryName} ed e pronto per essere visionato. Includo eventuali accessori disponibili e posso fornire altre foto o dettagli su richiesta. Ideale per chi cerca un prodotto curato, con descrizione chiara e trattativa sicura su VendoHub AI.";
    }

    private function buildSuggestedTags(string $title, string $brandModel, string $categoryName): string
    {
        return collect(explode(' ', "{$title} {$brandModel} {$categoryName}"))
            ->map(fn ($word) => str($word)->lower()->ascii()->replaceMatches('/[^a-z0-9]/', '')->toString())
            ->filter(fn ($word) => mb_strlen($word) >= 4)
            ->unique()
            ->take(6)
            ->map(fn ($word) => "#{$word}")
            ->implode(' ');
    }



    public function render()
    {
        return view('livewire.create-article-form');
    }
}
