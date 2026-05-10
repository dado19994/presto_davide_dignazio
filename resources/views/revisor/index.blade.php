{{-- <x-layout>
    <x-page-header eyebrow="Area revisore" title="Dashboard revisione"
        subtitle="Controlla gli articoli in attesa prima della pubblicazione" />

    <section class="container section-shell revisor-section">
        @if (session('message'))
            <div class="alert alert-success revisor-alert shadow mb-4" role="alert">
                {{ session('message') }}
            </div>
        @endif

        @if ($article_to_check->images->count())
            @foreach ($article_to_check->images as $key => $image)
                <div class="article-detail-card revisor-card shadow">
                    <div class="row g-4 align-items-stretch">
                        <div class="col-12 col-lg-7">
                            <div class="revisor-gallery">
                                <div class="revisor-gallery-main">
                                    <img src="{{ Storage::url($image->path) }}" class="img-fluid revisor-main-image"
                                        alt="Immagine {{ $key +1 }} dell'articolo {{ $article_to_check->title }}">
                                </div>
            @endforeach
        @else
            <div class="row g-3 mt-1">
                @for ($i = 0; $i < 4; $i++)
                    <div class="col-6 col-md-3">
                        <img src="https://picsum.photos/30{{ $i }}/220" class="img-fluid revisor-thumb-image"
                            alt="Anteprima articolo {{ $article_to_check->title }}">
                    </div>
                @endfor
        @endif
        </div>
        </div>
        </div>

        <div class="col-12 col-lg-5">
            <div class="article-detail-content revisor-content h-100 d-flex flex-column">
                <div>
                    @if ($article_to_check->category)
                        <a href="{{ route('byCategory', ['category' => $article_to_check->category]) }}"
                            class="article-detail-badge text-capitalize text-decoration-none">
                            {{ $article_to_check->category->name }}
                        </a>
                    @else
                        <span class="article-detail-badge">
                            Senza categoria
                        </span>
                    @endif

                    <h2 class="fw-bold mt-3 mb-3">
                        {{ $article_to_check->title }}
                    </h2>

                    <div class="article-detail-price mb-3">
                        € {{ $article_to_check->price }}
                    </div>

                    <div class="revisor-meta glass-panel p-3 mb-4">
                        <div>
                            <span class="revisor-meta-label">Autore</span>
                            <strong>{{ optional($article_to_check->user)->name ?? 'Autore non disponibile' }}</strong>
                        </div>

                        <div>
                            <span class="revisor-meta-label">Stato</span>
                            <strong>In attesa</strong>
                        </div>
                    </div>

                    <div class="article-detail-description mb-4">
                        <h5 class="fw-bold mb-2">Descrizione</h5>
                        <p class="mb-0">{{ $article_to_check->description }}</p>
                    </div>
                </div>

                <div class="revisor-actions d-flex gap-3 flex-wrap mt-auto">
                    <form action="{{ route('revisor.reject', ['article' => $article_to_check]) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-outline-danger custom-btn-outline px-4">
                            Rifiuta
                        </button>
                    </form>
                    <form action="{{ route('revisor.accept', ['article' => $article_to_check]) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-dark custom-btn-card px-4">
                            Accetta
                        </button>
                    </form>
                </div>
            </div>
        </div>
        </div>
        </div>
    @else
        <x-empty-state title="Nessun articolo da revisionare" message="Tutti gli articoli sono già stati controllati."
            :actionRoute="route('homepage')" actionLabel="Torna all'homepage" />
        @endif
    </section>
</x-layout> --}}


<x-layout>
    <x-page-header eyebrow="Area revisore" title="Dashboard revisione"
        subtitle="Controlla gli articoli in attesa prima della pubblicazione" />

    <section class="container section-shell revisor-section">

        @if (session('message'))
            <div class="alert alert-success revisor-alert shadow mb-4" role="alert">
                {{ session('message') }}
            </div>
        @endif

        @if ($article_to_check)

            <div class="article-detail-card revisor-card shadow">

                <div class="row g-4 align-items-stretch">

                    {{-- GALLERY --}}
                    <div class="col-12 col-lg-7">

                        <div class="revisor-gallery">

                            @if ($article_to_check->images->count())

                                <div class="revisor-gallery-main">

                                    <img src="{{ Storage::url($article_to_check->images->first()->path) }}"
                                        class="img-fluid revisor-main-image"
                                        alt="Immagine articolo {{ $article_to_check->title }}">

                                </div>

                                <div class="row g-3 mt-1">

                                    @foreach ($article_to_check->images as $key => $image)

                                        <div class="col-6 col-md-3">

                                            <img src="{{ Storage::url($image->path) }}"
                                                class="img-fluid revisor-thumb-image"
                                                alt="Immagine {{ $key + 1 }} dell'articolo {{ $article_to_check->title }}">

                                        </div>

                                    @endforeach

                                </div>

                            @else

                                <div class="row g-3 mt-1">

                                    @for ($i = 0; $i < 4; $i++)

                                        <div class="col-6 col-md-3">

                                            <img src="https://picsum.photos/30{{ $i }}/220"
                                                class="img-fluid revisor-thumb-image"
                                                alt="Anteprima articolo {{ $article_to_check->title }}">

                                        </div>

                                    @endfor

                                </div>

                            @endif

                        </div>

                    </div>

                    {{-- CONTENT --}}
                    <div class="col-12 col-lg-5">

                        <div class="article-detail-content revisor-content h-100 d-flex flex-column">

                            <div>

                                @if ($article_to_check->category)

                                    <a href="{{ route('byCategory', ['category' => $article_to_check->category]) }}"
                                        class="article-detail-badge text-capitalize text-decoration-none">

                                        {{ $article_to_check->category->name }}

                                    </a>

                                @else

                                    <span class="article-detail-badge">
                                        Senza categoria
                                    </span>

                                @endif

                                <h2 class="fw-bold mt-3 mb-3">
                                    {{ $article_to_check->title }}
                                </h2>

                                <div class="article-detail-price mb-3">
                                    € {{ $article_to_check->price }}
                                </div>

                                <div class="revisor-meta glass-panel p-3 mb-4">

                                    <div>
                                        <span class="revisor-meta-label">Autore</span>

                                        <strong>
                                            {{ optional($article_to_check->user)->name ?? 'Autore non disponibile' }}
                                        </strong>
                                    </div>

                                    <div>
                                        <span class="revisor-meta-label">Stato</span>
                                        <strong>In attesa</strong>
                                    </div>

                                </div>

                                <div class="article-detail-description mb-4">

                                    <h5 class="fw-bold mb-2">
                                        Descrizione
                                    </h5>

                                    <p class="mb-0">
                                        {{ $article_to_check->description }}
                                    </p>

                                </div>

                            </div>

                            {{-- ACTIONS --}}
                            <div class="revisor-actions d-flex gap-3 flex-wrap mt-auto">

                                <form action="{{ route('revisor.reject', ['article' => $article_to_check]) }}"
                                    method="POST">

                                    @csrf
                                    @method('PATCH')

                                    <button type="submit"
                                        class="btn btn-outline-danger custom-btn-outline px-4">

                                        Rifiuta

                                    </button>

                                </form>

                                <form action="{{ route('revisor.accept', ['article' => $article_to_check]) }}"
                                    method="POST">

                                    @csrf
                                    @method('PATCH')

                                    <button type="submit"
                                        class="btn btn-dark custom-btn-card px-4">

                                        Accetta

                                    </button>

                                </form>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        @else

            <x-empty-state
                title="Nessun articolo da revisionare"
                message="Tutti gli articoli sono già stati controllati."
                :actionRoute="route('homepage')"
                actionLabel="Torna all'homepage" />

        @endif

    </section>
</x-layout>
