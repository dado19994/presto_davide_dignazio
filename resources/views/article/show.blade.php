{{-- Opzione 2 --}}
<x-layout>
    <x-page-header eyebrow="Dettaglio articolo" title="{{ $article->title }}"
        subtitle="Tutte le informazioni dell'articolo selezionato" />

    @php
        $isFavorite = auth()->check() && auth()->user()->favoriteArticles()->where('articles.id', $article->id)->exists();
    @endphp

    <section class="container section-shell article-detail-section">
        @if (session('success'))
            <div class="alert alert-success border-0 rounded-4 shadow mb-4 article-detail-alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="article-detail-card product-detail-card shadow">
            <span class="product-particle particle-one"></span>
            <span class="product-particle particle-two"></span>
            <span class="product-particle particle-three"></span>

            <div class="row g-4 g-xl-5 align-items-stretch">

                {{-- CAROSELLO --}}
                <div class="col-12 col-lg-6">
                    <div class="product-gallery-column">
                        @if ($article->images->count() > 0)
                            <div id="articleCarousel" class="carousel slide article-detail-carousel product-gallery-main" data-bs-ride="carousel">

                                <div class="gallery-overlay-badges">
                                    <span class="article-ai-badge animated-ai-badge">
                                        <i class="fas fa-check-circle"></i> AI Verified
                                    </span>
                                    @if ($article->is_highlighted)
                                        <span class="detail-hot-badge">
                                            <i class="fas fa-bolt"></i> In evidenza
                                        </span>
                                    @endif
                                </div>

                                <div class="carousel-inner">
                                    @foreach ($article->images as $key => $image)
                                        <div class="carousel-item @if ($loop->first) active @endif">

                                            <img src="{{ $image->getUrl() }}"
                                                class="d-block w-100 article-detail-image shadow"
                                                alt="Immagine {{ $key + 1 }} dell'articolo {{ $article->title }}">

                                        </div>
                                    @endforeach
                                </div>

                                <button class="carousel-control-prev" type="button" data-bs-target="#articleCarousel"
                                    data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>

                                <button class="carousel-control-next" type="button" data-bs-target="#articleCarousel"
                                    data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>

                            </div>

                            @if ($article->images->count() > 1)
                                <div class="product-thumbnails">
                                    @foreach ($article->images as $key => $image)
                                        <button type="button" data-bs-target="#articleCarousel" data-bs-slide-to="{{ $key }}"
                                            class="@if ($loop->first) active @endif" aria-label="Mostra immagine {{ $key + 1 }}">
                                            <img src="{{ $image->getUrl() }}" alt="Miniatura {{ $key + 1 }}">
                                        </button>
                                    @endforeach
                                </div>
                            @endif
                        @else
                            <div class="product-gallery-main product-gallery-placeholder">
                                <img src="https://picsum.photos/800" alt="Nessuna foto inserita"
                                    class="img-fluid article-detail-image shadow">
                            </div>
                        @endif

                        <div class="gallery-trust-row">
                            <div><i class="fas fa-sparkles"></i><span>AI Verified</span></div>
                            <div><i class="fas fa-truck-fast"></i><span>Consegna rapida</span></div>
                            <div><i class="fas fa-heart"></i><span>{{ $productSignals['favorite_count'] }} preferiti</span></div>
                        </div>
                    </div>
                </div>

                {{-- CONTENUTO --}}
                <div class="col-12 col-lg-6">
                    <div class="article-detail-content">

                        <div class="article-detail-meta d-flex flex-wrap align-items-center gap-2 mb-3">
                            @if ($article->category)
                                <a href="{{ route('byCategory', ['category' => $article->category]) }}"
                                    class="article-detail-badge text-capitalize text-decoration-none">
                                    {{ $article->category->name }}
                                </a>
                            @endif

                            <span class="article-ai-badge" title="Questo articolo è stato validato dai nostri sistemi di AI">
                                <i class="fas fa-check-circle"></i> AI validated
                            </span>
                        </div>

                        <h2 class="product-title fw-bold mb-3">
                            {{ $article->title }}
                        </h2>

                        @if ($article->brand_model)
                            <p class="article-brand-model mb-3">
                                <i class="fas fa-certificate me-2"></i>{{ $article->brand_model }}
                            </p>
                        @endif

                        <div class="article-detail-price product-price mb-3">
                            <span>€ {{ number_format($article->price, 2, ',', '.') }}</span>
                        </div>

                        <div class="product-micro-info mb-4">
                            <span><i class="fas fa-check"></i> Disponibile</span>
                            <span><i class="fas fa-truck-fast"></i> Consegna 24/48h</span>
                            <span><i class="fas fa-star"></i> {{ $sellerTrust['rating'] ?? 'N/D' }} recensioni</span>
                            <span><i class="fas fa-fire"></i> {{ $productSignals['active_viewers'] }} utenti interessati</span>
                        </div>

                        <div class="ai-match-panel mb-4">
                            <div>
                                <span>AI Match Score</span>
                                <strong>Compatibilità con te: {{ $productSignals['match_score'] }}%</strong>
                            </div>
                            <i class="fas fa-microchip"></i>
                        </div>

                        <div class="article-signal-grid mb-4">
                            <div>
                                <i class="fas fa-camera"></i>
                                <span>{{ $article->images->count() }} foto</span>
                            </div>
                            <div>
                                <i class="fas fa-shield-halved"></i>
                                <span>AI Guard</span>
                            </div>
                            <div>
                                <i class="fas fa-comments"></i>
                                <span>Chat venditore</span>
                            </div>
                        </div>

                        @if ($article->user)
                            <a href="{{ route('seller.show', $article->user) }}"
                                class="seller-inline-link mb-4 text-decoration-none">
                                <span>Venditore</span>
                                <strong>{{ trim($article->user->name . ' ' . ($article->user->surname ?? '')) }}</strong>
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        @endif

                        <div class="article-actions action-panel d-flex align-items-center gap-3 flex-wrap mb-4">
                            <livewire:checkout-component :article="$article" />

                            <form action="{{ route('cart.store', $article) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn custom-btn-outline">
                                    <i class="fas fa-bag-shopping me-2"></i>Aggiungi al carrello
                                </button>
                            </form>

                            @auth
                                <form action="{{ route('favorites.toggle', $article) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn favorite-btn {{ $isFavorite ? 'is-favorite' : '' }}"
                                        aria-pressed="{{ $isFavorite ? 'true' : 'false' }}">
                                        <i class="{{ $isFavorite ? 'fas' : 'far' }} fa-heart me-2"></i>
                                        {{ $isFavorite ? 'Nei preferiti' : 'Aggiungi ai preferiti' }}
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="btn favorite-btn">
                                    <i class="far fa-heart me-2"></i>Aggiungi ai preferiti
                                </a>
                            @endauth
                        </div>

                        <div class="trust-panels mb-4">
                            <div class="trust-panel">
                                <h3><i class="fas fa-user-shield"></i> Fiducia venditore</h3>
                                <ul>
                                    <li><i class="fas fa-check"></i> Utente verificato</li>
                                    <li><i class="fas fa-star"></i> {{ $sellerTrust['rating'] ?? 'N/D' }} su {{ $sellerTrust['reviews'] }} recensioni</li>
                                    <li><i class="fas fa-box"></i> {{ $sellerTrust['sales'] }} vendite concluse</li>
                                    <li><i class="fas fa-clock"></i> Attivo da {{ $sellerTrust['member_since'] }}</li>
                                </ul>
                            </div>

                            <div class="trust-panel">
                                <h3><i class="fas fa-shield-halved"></i> Sicurezza acquisto</h3>
                                <ul>
                                    <li><i class="fas fa-lock"></i> Pagamento protetto</li>
                                    <li><i class="fas fa-shield-heart"></i> Protezione acquirente</li>
                                    <li><i class="fas fa-rotate-left"></i> Reso disponibile</li>
                                    <li><i class="fas fa-comments"></i> Trattativa privata</li>
                                </ul>
                            </div>
                        </div>

                        {{-- CHAT INTEGRATION --}}
                        <div class="article-chat-shell mt-4">
                            <livewire:chat-component :article="$article" />
                        </div>

                    </div>
                </div>

            </div>
        </div>

        <section class="product-description-section">
            <div class="product-description-card">
                <div>
                    <p class="page-eyebrow mb-2">Dettagli prodotto</p>
                    <h2>Descrizione prodotto</h2>
                    <p>{{ $article->description }}</p>
                </div>
                <div class="product-spec-list">
                    <div><i class="fas fa-tag"></i><span>Categoria</span><strong>{{ $article->category?->name ?? 'Non indicata' }}</strong></div>
                    <div><i class="fas fa-certificate"></i><span>Marca/modello</span><strong>{{ $article->brand_model ?: 'Non indicato' }}</strong></div>
                    <div><i class="fas fa-camera"></i><span>Foto disponibili</span><strong>{{ $article->images->count() }}</strong></div>
                    <div><i class="fas fa-heart"></i><span>Preferiti</span><strong>{{ $productSignals['favorite_count'] }}</strong></div>
                </div>

                @if ($article->tags)
                    <div class="detail-tags mt-4">
                        @foreach (collect(explode(' ', $article->tags))->filter()->take(8) as $tag)
                            <a href="{{ route('article.searched', ['query' => $tag, 'tag' => $tag]) }}">{{ $tag }}</a>
                        @endforeach
                    </div>
                @endif
            </div>
        </section>

        @if ($recommendedArticles->isNotEmpty())
            <section class="recommended-section w-100 mt-5">
                <div class="recommended-heading d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-3 mb-4">
                    <div>
                        <p class="page-eyebrow mb-2">Consigliati per te dall'AI</p>
                        <h2 class="fw-bold mb-0">Scelti perché simili a questo articolo</h2>
                    </div>

                    @if ($article->category)
                        <a href="{{ route('byCategory', ['category' => $article->category]) }}"
                            class="btn custom-btn-outline">
                            Vedi categoria
                        </a>
                    @endif
                </div>

                <div class="row g-4 recommended-grid">
                    @foreach ($recommendedArticles as $recommendedArticle)
                        <div class="col-12 col-md-6 col-xl-4">
                            <x-card :article="$recommendedArticle" />
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        {{-- USER REVIEWS INTEGRATION --}}
        <div class="row mt-5 justify-content-center w-100 article-reviews-row">
            <div class="col-12">
                {{-- @livewire('user-review-component', ['user' => $article->user]) --}}
                <livewire:user-review-component :user="$article->user" />
            </div>
        </div>

        <div class="mobile-product-cta">
            @auth
                <form action="{{ route('favorites.toggle', $article) }}" method="POST">
                    @csrf
                    <button type="submit" class="mobile-heart-btn {{ $isFavorite ? 'is-favorite' : '' }}" aria-label="Preferiti">
                        <i class="{{ $isFavorite ? 'fas' : 'far' }} fa-heart"></i>
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="mobile-heart-btn" aria-label="Preferiti">
                    <i class="far fa-heart"></i>
                </a>
            @endauth
            <form action="{{ route('cart.store', $article) }}" method="POST">
                @csrf
                <button type="submit" class="btn custom-btn-outline">Carrello</button>
            </form>
            <button type="button" class="btn custom-btn-card" data-bs-toggle="modal" data-bs-target="#checkoutModal-{{ $article->id }}">
                Acquista
            </button>
        </div>
    </section>
</x-layout>
