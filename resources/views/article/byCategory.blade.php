<x-layout>
    <x-page-header
        eyebrow="Categoria"
        title="{{ $category->name }}"
        subtitle="Articoli pubblicati in questa categoria"
    />

    <section class="container section-shell article-section">
        <div class="row g-4 justify-content-center">
            @forelse ($articles as $article )
                <div class="col-12 col-md-6 col-lg-4 col-xl-3 d-flex justify-content-center">
                    <x-card :article="$article" />
                </div>
            @empty
                <div class="col-12">
                    <x-empty-state
                        title="Non sono ancora stati creati articoli per questa categoria!"
                        :action-route="auth()->check() ? route('create.article') : null"
                        action-label="Pubblica un articolo"
                    />
                </div>

            @endforelse
        </div>

        <div class="d-flex justify-content-center mt-5 pagination-custom">
            {{ $articles->links() }}
        </div>
    </section>
</x-layout>
