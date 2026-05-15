
<x-layout>

    <x-page-header
        eyebrow="Catalogo"
        title="Tutti gli articoli"
        subtitle="Esplora tutti gli articoli pubblicati dalla community"
    />

    <section class="container section-shell article-section catalog-page">
        <div class="catalog-toolbar glass-panel">
            <div>
                <p class="page-eyebrow mb-2">Scoperta guidata</p>
                <h2>Trova articoli validati, confronta categorie e salva ciò che ti interessa.</h2>
            </div>
            <div class="catalog-toolbar-actions">
                <a href="{{ route('article.featured') }}" class="btn custom-btn-card">
                    <i class="fas fa-bolt me-2"></i>In evidenza
                </a>
                @auth
                    <a href="{{ route('favorites.index') }}" class="btn custom-btn-outline">
                        <i class="far fa-heart me-2"></i>Preferiti
                    </a>
                @endauth
            </div>
        </div>

        @if (($categories ?? collect())->count())
            <div class="glass-panel category-filter d-flex justify-content-center gap-2 flex-wrap mb-5 p-3">
                <a href="{{ route('article.index') }}" class="btn custom-btn-card text-capitalize">
                    Tutte
                </a>
                @foreach ($categories as $category)
                    <a href="{{ route('byCategory', ['category' => $category]) }}" class="btn custom-btn-outline text-capitalize">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>
        @endif

        <x-article-filters :action="route('article.index')" />

        <div class="row g-4 justify-content-center">

            @forelse ($articles as $article)

                <div class="col-12 col-md-6 col-lg-4 col-xl-3 d-flex justify-content-center">

                    <x-card :article="$article" />

                </div>

            @empty

                <div class="col-12">
                    <x-empty-state
                        title="Nessun articolo disponibile"
                        message="Non sono ancora stati creati articoli."
                    />

                </div>

            @endforelse

        </div>

        <!-- PAGINAZIONE -->
        <div class="d-flex justify-content-center mt-5 pagination-custom">

            {{ $articles->links() }}

        </div>

    </section>

</x-layout>
