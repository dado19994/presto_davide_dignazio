{{-- <div class="card-custom article-card mx-auto shadow p-4 h-100">

    <!-- Immagine -->
    <div class="text-center mb-4">
        <img
            src="{{ $article->images->isNotEmpty() ? $article->images->first()->getUrl(300, 300) : 'https://picsum.photos/220' }}"
            class="img-fluid article-image"
            alt="Immagine dell'articolo {{ $article->title }}"
        >
    </div>

    <!-- Corpo card -->
    <div class="text-center">

        <h3 class="fw-bold mb-3">
            {{ $article->title }}
        </h3>

        <h5 class="text-secondary mb-4">
            € {{ $article->price }}
        </h5>

        <div class="d-flex justify-content-center gap-3 flex-wrap">

            <a href="{{ route('article.show', compact('article')) }}" class="btn btn-dark custom-btn-card px-4">
                Dettaglio
            </a>

            @if ($article->category)
                <a href="{{ route('byCategory', ['category' => $article->category]) }}" class="btn btn-outline-dark custom-btn-outline px-4">
                    {{ $article->category->name }}
                </a>
            @endif

        </div>

    </div>

</div> --}}


{{-- Opzione 2 --}}
<div class="article-card p-4 h-100">
    <div class="text-center mb-4 overflow-hidden rounded-4">
        <img src="{{ $article->images->isNotEmpty() ? $article->images->first()->getUrl(300, 300) : 'https://picsum.photos/500' }}"
            class="img-fluid article-image" alt="{{ $article->title }}">
    </div>
    <div class="text-center">
        @if ($article->category)
            <span class="article-detail-badge mb-3 text-capitalize">
                {{ $article->category->name }}
            </span>
        @endif
        <h3 class="fw-bold mb-3 mt-3">
            {{ $article->title }}
        </h3>
        <h5 class="mb-4">
            € {{ $article->price }}
        </h5>
        <div class="d-flex justify-content-center gap-3 flex-wrap">
            <a href="{{ route('article.show', compact('article')) }}" class="btn custom-btn-card">

                Dettaglio
            </a>
            @if ($article->category)
                <a href="{{ route('byCategory', ['category' => $article->category]) }}" class="btn custom-btn-outline">
                    Categoria
                </a>
            @endif
        </div>
    </div>
</div>
