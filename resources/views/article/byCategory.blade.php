<x-layout>
    <section class="container py-5">
        <div class="row justify-content-center text-center">
            <div class="col-12">
                <h1 class="display-3 fw-bold text-white mb-3">
                    Articoli della categoria
                </h1>

                <p class="text-white fs-5 opacity-75 text-capitalize mb-0">
                    {{ $category->name }}
                </p>
            </div>
        </div>
    </section>

    <section class="container pb-5 article-section">
        <div class="row g-4 justify-content-center">
            @forelse ($articles as $article )
                <div class="col-12 col-md-6 col-lg-4 col-xl-3 d-flex justify-content-center">
                    <x-card :article="$article" />
                </div>
            @empty
                <div class="col-12">
                    <div class="card-custom empty-card text-center p-5">
                        <h3 class="fw-bold mb-3">
                            Non sono ancora stati creati articoli per questa categoria!
                        </h3>

                        @auth
                            <a href="{{ route('create.article') }}" class="btn btn-dark custom-btn-card mt-3">
                                Pubblica un articolo
                            </a>
                        @endauth
                    </div>
                </div>

            @endforelse
        </div>
    </section>
</x-layout>
