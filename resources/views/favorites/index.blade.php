<x-layout>
    <x-page-header eyebrow="Preferiti" title="I tuoi preferiti"
        subtitle="Ritrova velocemente gli articoli che vuoi tenere d'occhio" />

    <section class="container section-shell">
        @if (session('success'))
            <div class="alert alert-success border-0 rounded-4 shadow mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if ($favorites->isEmpty())
            <div class="empty-card p-5 text-center">
                <i class="far fa-heart fa-3x text-primary mb-3"></i>
                <h2 class="fw-bold mb-3">Nessun preferito ancora</h2>
                <p class="text-secondary mb-4">Salva gli articoli interessanti dalla pagina dettaglio.</p>
                <a href="{{ route('article.index') }}" class="btn custom-btn-card">Scopri articoli</a>
            </div>
        @else
            <div class="favorites-overview glass-panel">
                <div>
                    <p class="page-eyebrow mb-2">Lista salvata</p>
                    <h2>{{ $favorites->count() }} articoli da tenere d'occhio</h2>
                    <p>L’AI userà questi segnali per proporti articoli simili nella dashboard.</p>
                </div>
                <a href="{{ route('article.index') }}" class="btn custom-btn-outline">
                    Scopri altro
                </a>
            </div>

            <div class="row g-4">
                @foreach ($favorites as $favorite)
                    @if ($favorite->article)
                        <div class="col-12 col-md-6 col-xl-4 favorite-card-col">
                            <x-card :article="$favorite->article" />
                            <form action="{{ route('favorites.toggle', $favorite->article) }}" method="POST" class="favorite-remove-form">
                                @csrf
                                <button type="submit" class="btn favorite-btn is-favorite w-100">
                                    <i class="fas fa-heart me-2"></i>Rimuovi dai preferiti
                                </button>
                            </form>
                        </div>
                    @endif
                @endforeach
            </div>
        @endif
    </section>
</x-layout>
