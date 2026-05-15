<x-layout>
    <x-page-header eyebrow="Venditore" title="{{ trim($user->name . ' ' . ($user->surname ?? '')) }}"
        subtitle="{{ $user->bio ?: 'Profilo venditore su VendoHub AI' }}" />

    <section class="container section-shell seller-profile-page">
        <div class="dashboard-hero p-4 p-lg-5 mb-5">
            <div class="row g-4 align-items-center">
                <div class="col-12 col-lg-7">
                    <div class="d-flex align-items-center gap-3">
                        <div class="seller-avatar">
                            @if ($user->avatarUrl())
                                <img src="{{ $user->avatarUrl() }}" alt="{{ $user->name }}">
                            @else
                                {{ mb_strtoupper(mb_substr($user->name, 0, 1)) }}
                            @endif
                        </div>
                        <div>
                            <p class="page-eyebrow mb-1">Profilo pubblico</p>
                            <h2 class="fw-bold mb-2">{{ trim($user->name . ' ' . ($user->surname ?? '')) }}</h2>
                            <p class="text-secondary mb-0">{{ $user->city ?: 'Zona non impostata' }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-5">
                    <div class="seller-profile-grid">
                        <div>
                            <span>Annunci attivi</span>
                            <strong>{{ $articles->total() }}</strong>
                        </div>
                        <div>
                            <span>Media recensioni</span>
                            <strong>{{ $averageRating ?: 'N/D' }} <i class="fas fa-star text-warning"></i></strong>
                        </div>
                        <div>
                            <span>Feedback recenti</span>
                            <strong>{{ $reviews->count() }}</strong>
                        </div>
                        <div>
                            <span>Badge</span>
                            <strong>{{ $averageRating >= 4.5 ? 'Affidabile' : 'In crescita' }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="dashboard-section mb-5">
            <div class="dashboard-section-heading">
                <div>
                    <p class="page-eyebrow mb-1">Annunci</p>
                    <h3 class="fw-bold mb-0">Articoli pubblicati</h3>
                </div>
            </div>

            <div class="row g-4">
                @forelse ($articles as $article)
                    <div class="col-12 col-md-6 col-xl-4">
                        <x-card :article="$article" />
                    </div>
                @empty
                    <div class="col-12">
                        <div class="empty-card p-5 text-center">
                            <h3 class="fw-bold mb-2">Nessun annuncio attivo</h3>
                            <p class="text-secondary mb-0">Questo venditore non ha ancora articoli pubblicati.</p>
                        </div>
                    </div>
                @endforelse
            </div>

            <div class="mt-4">
                {{ $articles->links() }}
            </div>
        </div>

        <div class="dashboard-card">
            <p class="page-eyebrow mb-1">Reputazione</p>
            <h3 class="mb-4">Feedback recenti</h3>
            <div class="row g-3">
                @forelse ($reviews as $review)
                    <div class="col-12 col-md-6">
                        <div class="recent-review">
                            <div class="d-flex justify-content-between gap-3">
                                <strong>{{ $review->reviewer?->name ?? 'Utente' }}</strong>
                                <span>{{ $review->rating }} <i class="fas fa-star text-warning"></i></span>
                            </div>
                            <p>{{ $review->comment }}</p>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-secondary mb-0">Nessuna recensione ancora.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
</x-layout>
