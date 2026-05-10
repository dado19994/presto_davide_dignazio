<x-layout>
    <x-page-header
        eyebrow="Dettaglio articolo"
        title="{{ $article->title }}"
        subtitle="Tutte le informazioni dell'articolo selezionato"
    />

    <section class="container section-shell article-detail-section">
        <div class="article-detail-card shadow">
            <div class="row g-4 align-items-center">
                <div class="col-12 col-lg-6">
                    <div id="carouselExample" class="carousel slide article-detail-carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="https://picsum.photos/700/520" class="d-block w-100 article-detail-image" alt="Immagine articolo">
                            </div>
                            <div class="carousel-item">
                                <img src="https://picsum.photos/701/520" class="d-block w-100 article-detail-image" alt="Immagine articolo">
                            </div>
                            <div class="carousel-item">
                                <img src="https://picsum.photos/702/520" class="d-block w-100 article-detail-image" alt="Immagine articolo">
                            </div>
                        </div>

                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>

                <div class="col-12 col-lg-6">
                    <div class="article-detail-content">
                        @if ($article->category)
                            <a href="{{ route('byCategory', ['category' => $article->category]) }}" class="article-detail-badge text-capitalize text-decoration-none">
                                {{ $article->category->name }}
                            </a>
                        @endif

                        <h2 class="fw-bold mt-3 mb-4">
                            {{ $article->title }}
                        </h2>

                        <div class="article-detail-price mb-4">
                            € {{ $article->price }}
                        </div>

                        <div class="article-detail-description mb-4">
                            <h5 class="fw-bold mb-2">Descrizione</h5>
                            <p class="mb-0">{{ $article->description }}</p>
                        </div>

                        <div class="d-flex justify-content-center justify-content-lg-start gap-3 flex-wrap">
                            <a href="{{ route('article.index') }}" class="btn btn-dark custom-btn-card px-4">
                                Torna agli articoli
                            </a>
                            @if ($article->category)
                                <a href="{{ route('byCategory', ['category' => $article->category]) }}" class="btn btn-outline-dark custom-btn-outline px-4">
                                    Altri in {{ $article->category->name }}
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layout>
