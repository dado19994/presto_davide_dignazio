<x-layout>

    <x-page-header
        eyebrow="Marketplace community"
        title="Story1"
        subtitle="Scopri gli ultimi articoli pubblicati dalla community"
    />

    @if (session()->has('errorMessage'))
        <div class="alert alert-danger" role="alert">
            {{ session('errorMessage') }}
        </div>

    @endif

    @if (session()->has('message'))
        <div class="alert alert-success" role="alert">
            {{ session('message') }}
        </div>

    @endif

    <!-- SEZIONE ARTICOLI -->
    <section class="container section-shell">

        <div class="row g-4 justify-content-center">

            @forelse ($articles as $article)

                <div class="col-12 col-md-6 col-lg-4 col-xl-3">

                    <x-card :article="$article" />

                </div>

            @empty

                <div class="col-12">
                    <x-empty-state
                        title="Non ci sono articoli creati"
                        message="Appena qualcuno pubblica qualcosa, lo vedrai qui."
                    />

                </div>

            @endforelse

        </div>

    </section>

</x-layout>
