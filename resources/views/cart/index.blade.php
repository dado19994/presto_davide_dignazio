<x-layout>
    <x-page-header eyebrow="Carrello" title="Riepilogo carrello"
        subtitle="Controlla gli articoli selezionati prima di procedere con l'acquisto" />

    <section class="container section-shell cart-page">
        @if (session('success'))
            <div class="alert alert-success border-0 rounded-4 shadow mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if ($articles->isEmpty())
            <div class="empty-card p-5 text-center">
                <i class="fas fa-bag-shopping fa-3x text-primary mb-3"></i>
                <h2 class="fw-bold mb-3">Il carrello è vuoto</h2>
                <p class="text-secondary mb-4">Aggiungi un articolo dal dettaglio per vederlo qui.</p>
                <a href="{{ route('article.index') }}" class="btn custom-btn-card">Sfoglia articoli</a>
            </div>
        @else
            <div class="cart-overview glass-panel">
                <div>
                    <p class="page-eyebrow mb-2">Riepilogo intelligente</p>
                    <h2>{{ $articles->count() }} articoli pronti nel carrello</h2>
                    <p>Controlla venditori, categorie e totale prima di aprire il checkout dal dettaglio articolo.</p>
                </div>
                <a href="{{ route('article.index') }}" class="btn custom-btn-outline">
                    Continua a esplorare
                </a>
            </div>

            <div class="row g-4 align-items-start">
                <div class="col-12 col-lg-8">
                    <div class="cart-list d-flex flex-column gap-3">
                        @foreach ($articles as $article)
                            <article class="cart-item glass-panel p-3">
                                <div class="cart-item-media">
                                    <img src="{{ $article->images->first() ? $article->images->first()->getUrl() : 'https://picsum.photos/300' }}"
                                        alt="{{ $article->title }}">
                                </div>

                                <div class="cart-item-body">
                                    <div>
                                        @if ($article->category)
                                            <span class="article-detail-badge mb-2 text-capitalize">
                                                {{ $article->category->name }}
                                            </span>
                                        @endif
                                        <h3 class="h5 fw-bold mb-2">{{ $article->title }}</h3>
                                        <p class="text-secondary small mb-0">
                                            Venditore: {{ $article->user?->name ?? 'Non disponibile' }}
                                        </p>
                                    </div>

                                    <div class="cart-item-actions">
                                        <p class="cart-item-price mb-0">
                                            € {{ number_format($article->price, 2, ',', '.') }}
                                        </p>
                                        <div class="d-flex gap-2 flex-wrap">
                                            <a href="{{ route('article.show', $article) }}" class="btn custom-btn-outline btn-sm">
                                                Dettaglio
                                            </a>
                                            <form action="{{ route('cart.destroy', $article) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-light btn-sm">
                                                    Rimuovi
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>

                <div class="col-12 col-lg-4">
                    <aside class="cart-summary glass-panel p-4">
                        <h2 class="h4 fw-bold mb-4">Totale</h2>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-secondary">Articoli</span>
                            <span>{{ $articles->count() }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center cart-total pt-3 mt-3">
                            <span class="fw-bold">Totale ordine</span>
                            <span class="fw-bold">€ {{ number_format($total, 2, ',', '.') }}</span>
                        </div>
                        @auth
                            <form action="{{ route('cart.checkout') }}" method="POST" class="mt-4">
                                @csrf
                                <label for="payment_method" class="form-label small text-secondary">Metodo pagamento</label>
                                <select id="payment_method" name="payment_method" class="form-select custom-input mb-3">
                                    <option value="card">Carta</option>
                                    <option value="paypal">PayPal</option>
                                </select>
                                <button type="submit" class="btn custom-btn-card w-100">
                                    <i class="fas fa-lock me-2"></i>Acquista tutto
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="btn custom-btn-card w-100 mt-4">
                                Accedi per acquistare
                            </a>
                        @endauth
                        <div class="cart-ai-note mt-3">
                            <i class="fas fa-shield-halved"></i>
                            <span>AI Guard monitora segnali sospetti durante chat e pagamento.</span>
                        </div>
                        <form action="{{ route('cart.clear') }}" method="POST" class="mt-3">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-light w-100">Svuota carrello</button>
                        </form>
                    </aside>
                </div>
            </div>
        @endif
    </section>
</x-layout>
