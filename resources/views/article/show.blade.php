{{-- Opzione 2 --}}
<x-layout>
    <x-page-header eyebrow="Dettaglio articolo" title="{{ $article->title }}"
        subtitle="Tutte le informazioni dell'articolo selezionato" />

    @php
        $isFavorite = auth()->check() && auth()->user()->favoriteArticles()->where('articles.id', $article->id)->exists();
    @endphp

    <section class="container section-shell article-detail-section">
        @if (session('success'))
            <div class="alert alert-success border-0 rounded-4 shadow mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="article-detail-card shadow">
            <div class="row g-4 g-xl-5 align-items-start">

                {{-- CAROSELLO --}}
                <div class="col-12 col-lg-6">
                    @if ($article->images->count() > 0)
                        <div id="articleCarousel" class="carousel slide article-detail-carousel" data-bs-ride="carousel">

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
                    @else
                        <img src="https://picsum.photos/600" alt="Nessuna foto inserita"
                            class="img-fluid article-detail-image shadow">
                    @endif
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

                        <h2 class="fw-bold mb-3">
                            {{ $article->title }}
                        </h2>

                        <div class="article-detail-price mb-4">
                            <span>€ {{ number_format($article->price, 2, ',', '.') }}</span>
                        </div>

                        <div class="article-detail-description mb-4">
                            <h5 class="fw-bold mb-2">Descrizione</h5>
                            <p class="mb-0">{{ $article->description }}</p>
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

                        <div class="article-actions action-panel d-flex gap-2 gap-md-3 flex-wrap mb-4">
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

                        <div class="d-flex justify-content-center justify-content-lg-start gap-3 flex-wrap mb-4">
                            <a href="{{ route('article.index') }}" class="btn btn-dark custom-btn-card px-4">
                                Torna agli articoli
                            </a>

                            @if ($article->category)
                                <a href="{{ route('byCategory', ['category' => $article->category]) }}"
                                    class="btn btn-outline-dark custom-btn-outline px-4">
                                    Altri in {{ $article->category->name }}
                                </a>
                            @endif
                        </div>

                        {{-- CHAT INTEGRATION --}}
                        <div class="article-chat-shell mt-4">
                            <livewire:chat-component :article="$article" />
                        </div>

                    </div>
                </div>

            </div>
        </div>

        @if ($recommendedArticles->isNotEmpty())
            <section class="recommended-section w-100 mt-5">
                <div class="recommended-heading d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-3 mb-4">
                    <div>
                        <p class="page-eyebrow mb-2">Consigliati dall'AI</p>
                        <h2 class="fw-bold mb-0">Potrebbero interessarti</h2>
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
    </section>
</x-layout>
