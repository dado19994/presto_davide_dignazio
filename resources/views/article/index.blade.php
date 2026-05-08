
<x-layout>

    <!-- HERO SECTION -->
    <section class="container py-5">

        <div class="row justify-content-center text-center">

            <div class="col-12">

                <h1 class="display-3 fw-bold text-white mb-3">
                    Tutti gli articoli
                </h1>

                <p class="text-white fs-5 opacity-75">
                    Esplora tutti gli articoli pubblicati dalla community
                </p>

            </div>

        </div>

    </section>

    <!-- SEZIONE ARTICOLI -->
    <section class="container pb-5 article-section">

        <div class="row g-4 justify-content-center">

            @forelse ($articles as $article)

                <div class="col-12 col-md-6 col-lg-4 col-xl-3 d-flex justify-content-center">

                    <x-card :article="$article" />

                </div>

            @empty

                <div class="col-12">

                    <div class="card-custom empty-card text-center p-5">

                        <h3 class="fw-bold mb-3">
                            Nessun articolo disponibile
                        </h3>

                        <p class="text-secondary mb-0">
                            Non sono ancora stati creati articoli.
                        </p>

                    </div>

                </div>

            @endforelse

        </div>

        <!-- PAGINAZIONE -->
        <div class="d-flex justify-content-center mt-5 pagination-custom">

            {{ $articles->links() }}

        </div>

    </section>

</x-layout>


