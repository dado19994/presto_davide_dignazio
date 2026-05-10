
<div class="card-custom article-card mx-auto shadow p-4 h-100">

    <!-- Immagine -->
    <div class="text-center mb-4">
        <img
            src="{{ $article->images->isNotEmpty() ? Storage::url($article->images->first()->path) : 'https://picsum.photos/220' }}"
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

</div>
