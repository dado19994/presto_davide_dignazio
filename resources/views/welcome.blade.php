<x-layout>

    <!-- HERO SECTION -->
    <section class="container py-5">

        <div class="row justify-content-center">

            <div class="col-12 text-center">

                <h1 class="display-3 fw-bold text-white mb-3">
                    Homepage
                </h1>

                <p class="text-white fs-5">
                    Scopri gli ultimi articoli pubblicati
                </p>

            </div>

        </div>

    </section>

    <!-- SEZIONE ARTICOLI -->
    <section class="container pb-5">

        <div class="row g-4 justify-content-center">

            @forelse ($articles as $article)

                <div class="col-12 col-md-6 col-lg-4 col-xl-3">

                    <x-card :article="$article" />

                </div>

            @empty

                <div class="col-12">

                    <div class="card-custom p-5 text-center">

                        <h3>
                            Non ci sono articoli creati
                        </h3>

                    </div>

                </div>

            @endforelse

        </div>

    </section>

</x-layout>
