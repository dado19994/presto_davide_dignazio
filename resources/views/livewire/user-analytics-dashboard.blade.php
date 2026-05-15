<div class="user-command-center">
    <div class="dashboard-hero glass-panel p-4 p-lg-5">
        <div class="row g-4 align-items-center">
            <div class="col-12 col-lg-7">
                <div class="d-flex align-items-center gap-3">
                    <div class="seller-avatar">
                        @if (!empty($profile['avatar_url']))
                            <img src="{{ $profile['avatar_url'] }}" alt="{{ $profile['name'] ?? 'Avatar' }}">
                        @else
                            {{ $profile['initials'] ?? 'U' }}
                        @endif
                    </div>
                    <div>
                        <p class="page-eyebrow mb-1">Profilo venditore</p>
                        <h2 class="fw-bold mb-1">{{ $profile['name'] ?? auth()->user()->name }}</h2>
                        <p class="text-secondary mb-0">{{ $profile['bio'] ?? '' }}</p>
                    </div>
                </div>

                <form wire:submit.prevent="saveProfile" class="profile-bio-editor mt-4">
                    @if (session()->has('profile_success'))
                        <div class="alert alert-success py-2 mb-3">
                            {{ session('profile_success') }}
                        </div>
                    @endif

                    <div class="row g-3">
                        <div class="col-12">
                            <label for="profile-bio" class="form-label fw-bold">Bio breve</label>
                            <textarea id="profile-bio" wire:model.defer="bio" class="form-control custom-input rounded-4"
                                rows="3" maxlength="500"
                                placeholder="Racconta chi sei, che tipo di prodotti vendi e cosa possono aspettarsi gli acquirenti."></textarea>
                            @error('bio')
                                <p class="text-danger small mt-2 mb-0">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="profile-city" class="form-label fw-bold">Città/Zona</label>
                            <input type="text" id="profile-city" wire:model.defer="city"
                                class="form-control custom-input rounded-4" placeholder="Es: Bari, Milano, Roma Nord">
                            @error('city')
                                <p class="text-danger small mt-2 mb-0">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="profile-avatar" class="form-label fw-bold">Avatar</label>
                            <div class="dashboard-upload @error('avatar') is-invalid @enderror">
                                <input type="file" id="profile-avatar" wire:model="avatar"
                                    class="dashboard-upload-input" accept="image/*">
                                <label for="profile-avatar" class="dashboard-upload-trigger">
                                    <span class="dashboard-upload-icon">
                                        <i class="fas fa-camera"></i>
                                    </span>
                                    <span>
                                        <strong>Scegli avatar</strong>
                                        <small>JPG, PNG o WEBP fino a 1MB</small>
                                    </span>
                                </label>
                                <div wire:loading wire:target="avatar" class="dashboard-upload-loading">
                                    Caricamento avatar...
                                </div>
                            </div>
                            @error('avatar')
                                <p class="text-danger small mt-2 mb-0">{{ $message }}</p>
                            @enderror
                            @if ($avatar)
                                <p class="text-secondary small mt-2 mb-0">Nuovo avatar pronto per il salvataggio.</p>
                            @endif
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center gap-3 mt-3 flex-wrap">
                        <span class="text-secondary small">Massimo 500 caratteri.</span>
                        <button type="submit" class="btn custom-btn-card">
                            Salva profilo
                        </button>
                    </div>
                </form>
            </div>

            <div class="col-12 col-lg-5">
                <div class="seller-profile-grid">
                    <div>
                        <span>Città/Zona</span>
                        <strong>{{ $profile['zone'] ?? 'N/D' }}</strong>
                    </div>
                    <div>
                        <span>Badge</span>
                        <strong>{{ $profile['badge'] ?? 'Nuovo venditore' }}</strong>
                    </div>
                    <div>
                        <span>Media recensioni</span>
                        <strong>{{ $profile['average_rating'] ?: 'N/D' }} <i class="fas fa-star text-warning"></i></strong>
                    </div>
                    <div>
                        <span>Articoli pubblicati</span>
                        <strong>{{ $profile['published_count'] ?? 0 }}</strong>
                    </div>
                    <div>
                        <span>Tempo risposta</span>
                        <strong>{{ $profile['response_time'] ?? 'N/D' }}</strong>
                    </div>
                    <div>
                        <span>Recensioni</span>
                        <strong>{{ $profile['reviews_count'] ?? 0 }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="dashboard-section">
        <div class="dashboard-section-heading">
            <div>
                <p class="page-eyebrow mb-1">Da fare ora</p>
                <h3 class="fw-bold mb-0">AI action center</h3>
            </div>
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <a href="{{ route('ai.coach') }}" class="btn custom-btn-outline btn-sm">Apri AI Coach</a>
                <div class="ai-badge">
                    <i class="fas fa-microchip"></i>
                    AI attiva
                </div>
            </div>
        </div>

        <div class="row g-4">
            @foreach ($ai['listing_coach'] ?? [] as $tip)
                <div class="col-12 col-lg-6">
                    <div class="dashboard-card ai-card h-100">
                        <span class="dashboard-kicker">{{ $tip['type'] }}</span>
                        <h4>{{ $tip['title'] }}</h4>
                        <p>{{ $tip['text'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="row g-4 dashboard-section">
        <div class="col-12 col-xl-7">
            <div class="dashboard-card h-100">
                <div class="dashboard-card-header">
                    <div>
                        <p class="page-eyebrow mb-1">I miei annunci</p>
                        <h3>Stato pubblicazioni</h3>
                    </div>
                    <a href="{{ route('create.article') }}" class="btn custom-btn-card btn-sm">Nuovo annuncio</a>
                </div>

                <div class="status-grid mb-4">
                    <div><span>Attivi</span><strong>{{ $articleStats['active'] }}</strong></div>
                    <div><span>In revisione</span><strong>{{ $articleStats['pending'] }}</strong></div>
                    <div><span>Rifiutati</span><strong>{{ $articleStats['rejected'] }}</strong></div>
                    <div><span>Venduti</span><strong>{{ $articleStats['sold'] }}</strong></div>
                    <div><span>Bozze</span><strong>{{ $articleStats['drafts'] }}</strong></div>
                </div>

                <div class="dashboard-list">
                    @forelse ($myArticles->take(5) as $article)
                        <div class="dashboard-list-item">
                            <div class="mini-thumb">
                                <img src="{{ $article->images->first() ? $article->images->first()->getUrl() : 'https://picsum.photos/160' }}"
                                    alt="{{ $article->title }}">
                            </div>
                            <div class="dashboard-list-main">
                                <strong>{{ $article->title }}</strong>
                                <span>
                                    {{ $article->category?->name ?? 'Senza categoria' }} ·
                                    € {{ number_format($article->price, 2, ',', '.') }}
                                </span>
                            </div>
                            <div class="quick-actions">
                                <a href="{{ route('article.show', $article) }}" class="btn btn-sm custom-btn-outline">Apri</a>
                                <a href="{{ route('article.edit', $article) }}" class="btn btn-sm dashboard-ghost-btn">Modifica</a>
                                <form action="{{ route('article.destroy', $article) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm dashboard-ghost-btn" type="submit">Elimina</button>
                                </form>
                                <form action="{{ route('article.republish', $article) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button class="btn btn-sm dashboard-ghost-btn" type="submit">Ripubblica</button>
                                </form>
                                <form action="{{ route('article.highlight', $article) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button class="btn btn-sm dashboard-ghost-btn" type="submit">
                                        {{ $article->is_highlighted ? 'Non evidenziare' : 'Evidenzia' }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="dashboard-empty">
                            <p class="mb-3">Non hai ancora pubblicato annunci.</p>
                            <a href="{{ route('create.article') }}" class="btn custom-btn-card">Crea il primo</a>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-5">
            <div class="dashboard-card h-100">
                <div class="dashboard-card-header">
                    <div>
                        <p class="page-eyebrow mb-1">Score annuncio</p>
                        <h3>Qualità stimata dall'AI</h3>
                    </div>
                </div>

                <div class="score-list">
                    @forelse ($ai['article_scores'] ?? [] as $score)
                        <div class="score-row">
                            <div>
                                <strong>{{ $score['title'] }}</strong>
                                <span>{{ $score['status'] }} · {{ $score['views'] }} visite</span>
                            </div>
                            <div class="score-meter" style="--score: {{ $score['score'] }}%">
                                <span></span>
                            </div>
                            <b>{{ $score['score'] }}</b>
                        </div>
                    @empty
                        <p class="text-secondary mb-0">Crea annunci per ricevere lo score AI.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 dashboard-section">
        <div class="col-12 col-xl-4">
            <div class="dashboard-card h-100">
                <p class="page-eyebrow mb-1">Centro vendite</p>
                <h3 class="mb-4">Ordini e richieste</h3>
                <div class="metric-grid">
                    <div><span>Transazioni ricevute</span><strong>{{ $salesCenter['received_transactions'] }}</strong></div>
                    <div><span>Acquisti fatti</span><strong>{{ $salesCenter['purchases'] }}</strong></div>
                    <div><span>Ordini completati</span><strong>{{ $salesCenter['completed_orders'] }}</strong></div>
                    <div><span>Ordini in corso</span><strong>{{ $salesCenter['pending_orders'] }}</strong></div>
                    <div><span>Messaggi aperti</span><strong>{{ $salesCenter['open_messages'] }}</strong></div>
                    <div><span>Da rispondere</span><strong>{{ $salesCenter['requests_to_answer'] }}</strong></div>
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-4">
            <div class="dashboard-card h-100">
                <p class="page-eyebrow mb-1">Preferiti e carrello</p>
                <h3 class="mb-4">Interessi salvati</h3>
                <div class="metric-grid two">
                    <div><span>Preferiti salvati</span><strong>{{ $favoritesAndCart['favorites_count'] }}</strong></div>
                    <div><span>Articoli nel carrello</span><strong>{{ $favoritesAndCart['cart_count'] }}</strong></div>
                </div>
                <div class="suggestion-stack mt-4">
                    @forelse ($favoriteSuggestions as $suggestion)
                        <a href="{{ route('article.show', $suggestion) }}" class="suggestion-link">
                            <span>{{ $suggestion->title }}</span>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    @empty
                        <p class="text-secondary small mb-0">Salva preferiti per ricevere suggerimenti simili.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-4">
            <div class="dashboard-card h-100">
                <p class="page-eyebrow mb-1">Reputazione</p>
                <h3 class="mb-4">Fiducia e recensioni</h3>
                <div class="rating-summary">
                    <strong>{{ $reputation['average_rating'] ?: 'N/D' }}</strong>
                    <span>{{ $reputation['reviews_received'] }} recensioni ricevute</span>
                </div>
                <div class="rating-bars">
                    @foreach (($reputation['distribution'] ?? []) as $rating => $count)
                        <div>
                            <span>{{ $rating }} <i class="fas fa-star text-warning"></i></span>
                            <div><b style="width: {{ $reputation['reviews_received'] ? ($count / $reputation['reviews_received']) * 100 : 0 }}%"></b></div>
                            <small>{{ $count }}</small>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="dashboard-section">
        <div class="dashboard-section-heading">
            <div>
                <p class="page-eyebrow mb-1">AI intelligence</p>
                <h3 class="fw-bold mb-0">Suggerimenti concreti</h3>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-12 col-lg-6 col-xl-3">
                <div class="dashboard-card h-100">
                    <h4>Prezzo dinamico</h4>
                    @foreach (($ai['dynamic_pricing'] ?? []) as $item)
                        <div class="mini-insight">
                            <strong>{{ $item['title'] }}</strong>
                            <span>€ {{ number_format($item['current'], 2, ',', '.') }} → € {{ number_format($item['suggested'], 2, ',', '.') }}</span>
                            <p>{{ $item['message'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="col-12 col-lg-6 col-xl-3">
                <div class="dashboard-card h-100">
                    <h4>Risposte suggerite</h4>
                    @forelse (($ai['reply_suggestions'] ?? []) as $reply)
                        <div class="mini-insight">
                            <strong>{{ $reply['from'] }} · {{ $reply['article'] }}</strong>
                            <p>{{ $reply['suggestion'] }}</p>
                        </div>
                    @empty
                        <p class="text-secondary small mb-0">Nessun messaggio aperto da gestire.</p>
                    @endforelse
                </div>
            </div>

            <div class="col-12 col-lg-6 col-xl-3">
                <div class="dashboard-card h-100">
                    <h4>Foto copertina</h4>
                    @forelse (($ai['cover_suggestions'] ?? []) as $cover)
                        <div class="mini-insight">
                            <strong>{{ $cover['title'] }}</strong>
                            <p>{{ $cover['text'] }}</p>
                        </div>
                    @empty
                        <p class="text-secondary small mb-0">Aggiungi più foto agli annunci per ricevere consigli sulla copertina.</p>
                    @endforelse
                </div>
            </div>

            <div class="col-12 col-lg-6 col-xl-3">
                <div class="dashboard-card h-100">
                    <h4>AI Guard</h4>
                    @foreach (($ai['risk_alerts'] ?? []) as $alert)
                        <div class="mini-insight">
                            <strong>{{ $alert['article'] }}</strong>
                            <p>{{ $alert['text'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 dashboard-section">
        <div class="col-12 col-xl-8">
            <div class="dashboard-card">
                <div class="dashboard-card-header">
                    <div>
                        <p class="page-eyebrow mb-1">Analisi performance</p>
                        <h3>Andamento e conversione</h3>
                    </div>
                    <div class="dashboard-total">
                        {{ number_format($totalViews) }} visite · {{ number_format($totalClicks) }} click
                    </div>
                </div>

                <div class="performance-chart">
                    @for ($i = 0; $i < 12; $i++)
                        <span style="height: {{ 28 + (($i * 17) % 62) }}%"></span>
                    @endfor
                </div>

                <div class="insight-grid mt-4">
                    @foreach (($ai['performance'] ?? []) as $insight)
                        <div>
                            <strong>{{ $insight['title'] }}</strong>
                            <p>{{ $insight['text'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-4">
            <div class="dashboard-card h-100">
                <p class="page-eyebrow mb-1">Riassunto settimanale</p>
                <h3 class="mb-3">Report AI</h3>
                <p class="weekly-summary">{{ $ai['weekly_summary'] ?? '' }}</p>

                <div class="profile-ai-list mt-4">
                    <h4>Migliora profilo</h4>
                    @foreach (($reputation['profile_suggestions'] ?? []) as $suggestion)
                        <div>
                            <i class="fas fa-wand-magic-sparkles"></i>
                            <span>{{ $suggestion }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="dashboard-section">
        <div class="dashboard-card">
            <div class="dashboard-card-header">
                <div>
                    <p class="page-eyebrow mb-1">Feedback recenti</p>
                    <h3>Ultime recensioni ricevute</h3>
                </div>
            </div>

            <div class="row g-3">
                @forelse ($recentReviews as $review)
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
                        <p class="text-secondary mb-0">Non hai ancora ricevuto recensioni.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
