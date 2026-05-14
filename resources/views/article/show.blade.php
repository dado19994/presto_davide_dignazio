{{-- Opzione 2 --}}
<x-layout>
    <x-page-header eyebrow="Dettaglio articolo" title="{{ $article->title }}"
        subtitle="Tutte le informazioni dell'articolo selezionato" />

    <section class="container section-shell article-detail-section">
        <div class="article-detail-card shadow">
            <div class="row g-4 align-items-center">

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

                        @if ($article->category)
                            <a href="{{ route('byCategory', ['category' => $article->category]) }}"
                                class="article-detail-badge text-capitalize text-decoration-none">
                                {{ $article->category->name }}
                            </a>
                        @endif

                        <h2 class="fw-bold mt-3 mb-4 d-flex align-items-center gap-2">
                            {{ $article->title }}
                            <span class="badge bg-primary-subtle text-primary border border-primary border-opacity-25 rounded-pill px-3 py-2" style="font-size: 0.7rem;" title="Questo articolo è stato validato dai nostri sistemi di AI">
                                <i class="fas fa-check-circle me-1"></i> AI VALIDATED
                            </span>
                        </h2>

                        <div class="article-detail-price mb-4 d-flex align-items-center justify-content-between">
                            <span class="fs-2 fw-bold">€ {{ number_format($article->price, 2, ',', '.') }}</span>
                            {{-- @livewire('checkout-component', ['article' => $article]) --}}
                            <livewire:checkout-component :article="$article" />
                        </div>

                        <div class="article-detail-description mb-4">
                            <h5 class="fw-bold mb-2">Descrizione</h5>
                            <p class="mb-0">{{ $article->description }}</p>
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
                        <div class="mt-4">
                            {{-- @livewire('chat-component', ['article' => $article]) --}}
                            <livewire:chat-component :article="$article" />
                        </div>

                    </div>
                </div>

            </div>
        </div>

        {{-- USER REVIEWS INTEGRATION --}}
        <div class="row mt-5 justify-content-center">
            <div class="col-12 col-lg-10">
                @livewire('user-review-component', ['user' => $article->user])
            </div>
        </div>
    </section>
</x-layout>
