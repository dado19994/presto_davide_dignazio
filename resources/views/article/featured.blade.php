<x-layout>
    <x-page-header
        eyebrow="Vetrina"
        title="Annunci in evidenza"
        subtitle="Una selezione di articoli messi in risalto dai venditori e ordinati per scoperta rapida."
    />

    <section class="container section-shell article-section featured-page">
        <div class="featured-intro glass-panel">
            <div>
                <p class="page-eyebrow mb-2">Più visibilità</p>
                <h2>Gli annunci più curati hanno una corsia preferenziale</h2>
                <p>
                    Quando un venditore evidenzia un annuncio, il prodotto viene mostrato in questa vetrina e riceve
                    più priorità nel catalogo. L’AI Listing Coach aiuta a capire quando vale la pena farlo.
                </p>
            </div>
            <div class="featured-intro-actions">
                <a href="{{ route('article.index') }}" class="btn custom-btn-outline">Catalogo completo</a>
                @auth
                    <a href="{{ route('ai.coach') }}" class="btn custom-btn-card">Apri AI Coach</a>
                @else
                    <a href="{{ route('register') }}" class="btn custom-btn-card">Diventa venditore</a>
                @endauth
            </div>
        </div>

        <div class="row g-4 justify-content-center mt-2">
            @forelse ($articles as $article)
                <div class="col-12 col-md-6 col-lg-4 col-xl-3 d-flex justify-content-center">
                    <x-card :article="$article" />
                </div>
            @empty
                <div class="col-12">
                    <x-empty-state
                        title="Nessun annuncio in evidenza"
                        message="Gli articoli evidenziati compariranno qui appena i venditori li attiveranno dalla dashboard."
                        :action-route="auth()->check() ? route('user.dashboard') : route('article.index')"
                        :action-label="auth()->check() ? 'Vai alla dashboard' : 'Esplora il catalogo'"
                    />
                </div>
            @endforelse
        </div>

        <div class="d-flex justify-content-center mt-5 pagination-custom">
            {{ $articles->links() }}
        </div>
    </section>
</x-layout>
