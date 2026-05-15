<x-layout>
    <x-page-header
        eyebrow="Ricerca"
        title="Risultati per “{{ $query }}”"
        subtitle="Abbiamo cercato titolo e descrizione per aiutarti a trovare più velocemente l'articolo giusto."
    />

    <section class="container section-shell catalog-page">
        <div class="catalog-toolbar glass-panel">
            <div>
                <p class="page-eyebrow mb-2">Risultati trovati</p>
                <h2>{{ $articles->total() }} articoli corrispondono alla tua ricerca.</h2>
            </div>
            <div class="catalog-toolbar-actions">
                <a href="{{ route('article.index') }}" class="btn custom-btn-outline">
                    Torna al catalogo
                </a>
                <a href="{{ route('article.featured') }}" class="btn custom-btn-card">
                    <i class="fas fa-bolt me-2"></i>Vedi evidenza
                </a>
            </div>
        </div>

        <x-article-filters :action="route('article.searched')" />

        <div class="row g-4 justify-content-center">
            @forelse ($articles as $article)
                <div class="col-12 col-md-6 col-lg-4 col-xl-3 d-flex justify-content-center">
                    <x-card :article="$article" />
                </div>
            @empty
                <div class="col-12">
                    <x-empty-state
                        title="Nessun articolo trovato"
                        message="Prova con parole più semplici o sfoglia il catalogo completo."
                        :action-route="route('article.index')"
                        action-label="Sfoglia articoli"
                    />
                </div>
            @endforelse
        </div>

        <div class="d-flex justify-content-center mt-5 pagination-custom">
            {{ $articles->links() }}
        </div>
    </section>
</x-layout>
