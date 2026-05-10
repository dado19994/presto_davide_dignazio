
<x-layout>

    <x-page-header
        eyebrow="Catalogo"
        title="Tutti gli articoli"
        subtitle="Esplora tutti gli articoli pubblicati dalla community"
    />

    <!-- SEZIONE ARTICOLI -->
    <section class="container section-shell article-section">
        @if (($categories ?? collect())->count())
            <div class="glass-panel category-filter d-flex justify-content-center gap-2 flex-wrap mb-5 p-3">
                @foreach ($categories as $category)
                    <a href="{{ route('byCategory', ['category' => $category]) }}" class="btn btn-outline-dark custom-btn-outline text-capitalize">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>
        @endif

        <div class="row g-4 justify-content-center">

            @forelse ($articles as $article)

                <div class="col-12 col-md-6 col-lg-4 col-xl-3 d-flex justify-content-center">

                    <x-card :article="$article" />

                </div>

            @empty

                <div class="col-12">
                    <x-empty-state
                        title="Nessun articolo disponibile"
                        message="Non sono ancora stati creati articoli."
                    />

                </div>

            @endforelse

        </div>

        <!-- PAGINAZIONE -->
        <div class="d-flex justify-content-center mt-5 pagination-custom">

            {{ $articles->links() }}

        </div>

    </section>

</x-layout>
