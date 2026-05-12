{{-- <x-layout>

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

</x-layout> --}}


{{-- Opzione 2 --}}

<x-layout>
<section class="hero-startup">
 <div class="container">
 <div class="row align-items-center min-vh-100">
 <div class="col-12 col-lg-6">
 <span class="hero-badge">
 AI Marketplace Platform
 </span>
 <h1 class="hero-title mt-4">
 Compra e vendi in modo intelligente.

 </h1>
 <p class="hero-subtitle mt-4">
 Una piattaforma moderna che unisce AI, moderazione
intelligente e UX avanzata per creare un marketplace innovativo.
 </p>
 <div class="d-flex gap-3 mt-5 flex-wrap text-center text-lg-start justify-content-center justify-content-lg-start">
 <a href="{{ route('article.index') }}" class="btn hero-btn-primary">
 Esplora marketplace
 </a>
 <a href="{{ route('create.article') }}" class="btn hero-btn-secondary">
 Pubblica articolo
 </a>
 </div>
 </div>
 <div class="col-12 col-lg-6 position-relative d-none d-lg-block">
 <div class="floating-card floating-1"></div>
 <div class="floating-card floating-2"></div>
 <div class="floating-card floating-3"></div>
 </div>
 </div>
 </div>
</section>
<section class="container section-shell">
 <div class="row g-4 justify-content-center">
 @forelse ($articles as $article)
 <div class="col-12 col-md-6 col-lg-4 col-xl-3">
 <x-card :article="$article" />
 </div>
 @empty
 <div class="col-12">
 <x-empty-state

 title="Nessun articolo disponibile"
 message="La community non ha ancora pubblicato articoli."
 />
 </div>
 @endforelse
 </div>
</section>
</x-layout>
