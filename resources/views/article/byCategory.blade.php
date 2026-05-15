<x-layout>
    <section class="category-hero-shell">
        <div class="container">
            <div class="category-hero">
                <x-category-scene :category="$category" />

                <div class="category-hero-content text-center">
                    <p class="page-eyebrow mb-3">Categoria</p>
                    <h1>{{ $category->name }}</h1>
                    <p class="hero-subtitle mx-auto mb-0">
                        Articoli pubblicati in questa categoria, con una vetrina animata pensata per il tema.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="container section-shell article-section catalog-page">
        <div class="catalog-toolbar glass-panel">
            <div>
                <p class="page-eyebrow mb-2">Categoria selezionata</p>
                <h2>{{ $articles->total() }} articoli disponibili in {{ $category->name }}.</h2>
            </div>
            <div class="catalog-toolbar-actions">
                <a href="{{ route('article.index') }}" class="btn custom-btn-outline">
                    Tutte le categorie
                </a>
                <a href="{{ route('article.featured') }}" class="btn custom-btn-card">
                    <i class="fas fa-bolt me-2"></i>In evidenza
                </a>
            </div>
        </div>

        <div class="row g-4 justify-content-center">
            @forelse ($articles as $article )
                <div class="col-12 col-md-6 col-lg-4 col-xl-3 d-flex justify-content-center">
                    <x-card :article="$article" />
                </div>
            @empty
                <div class="col-12">
                    <x-empty-state
                        title="Non sono ancora stati creati articoli per questa categoria!"
                        :action-route="auth()->check() ? route('create.article') : null"
                        action-label="Pubblica un articolo"
                    />
                </div>

            @endforelse
        </div>

        <div class="d-flex justify-content-center mt-5 pagination-custom">
            {{ $articles->links() }}
        </div>
    </section>
</x-layout>
