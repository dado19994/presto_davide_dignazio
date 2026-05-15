<x-layout>
    <x-page-header
        eyebrow="AI Listing Coach"
        title="Ottimizza i tuoi annunci"
        subtitle="Analisi concreta su qualità annuncio, foto, prezzo, performance e possibilità di evidenziarlo."
    />

    <section class="container ai-coach-page">
        <div class="coach-summary-grid">
            <div class="coach-summary-card">
                <span>Annunci analizzati</span>
                <strong>{{ $summary['total'] }}</strong>
            </div>
            <div class="coach-summary-card warning">
                <span>Da sistemare</span>
                <strong>{{ $summary['critical'] + $summary['to_improve'] }}</strong>
            </div>
            <div class="coach-summary-card success">
                <span>Pronti</span>
                <strong>{{ $summary['excellent'] }}</strong>
            </div>
            <div class="coach-summary-card highlight">
                <span>In evidenza</span>
                <strong>{{ $summary['highlighted'] }}</strong>
            </div>
        </div>

        <div class="coach-toolbar glass-panel">
            <div>
                <p class="page-eyebrow mb-2">Metodo AI</p>
                <h2>Score 0-100 basato su testo, foto, prezzo, categoria e segnali di interesse.</h2>
            </div>
            <div class="d-flex gap-3 flex-wrap">
                <a href="{{ route('create.article') }}" class="btn custom-btn-card">Nuovo annuncio</a>
                <a href="{{ route('article.featured') }}" class="btn custom-btn-outline">Vedi evidenza</a>
            </div>
        </div>

        <div class="coach-list">
            @forelse ($coachCards as $card)
                @php($article = $card['article'])
                <article class="coach-card">
                    <div class="coach-card-media">
                        <img src="{{ $article->images->first() ? $article->images->first()->getUrl(420, 320) : 'https://picsum.photos/500' }}"
                            alt="{{ $article->title }}">
                        @if ($article->is_highlighted)
                            <span><i class="fas fa-bolt"></i> In evidenza</span>
                        @endif
                    </div>

                    <div class="coach-card-body">
                        <div class="coach-card-header">
                            <div>
                                <p class="page-eyebrow mb-1">{{ $article->category?->name ?? 'Senza categoria' }}</p>
                                <h2>{{ $article->title }}</h2>
                            </div>
                            <div class="coach-score {{ $card['score'] >= 75 ? 'good' : ($card['score'] >= 55 ? 'medium' : 'low') }}">
                                <strong>{{ $card['score'] }}</strong>
                                <span>{{ $card['status'] }}</span>
                            </div>
                        </div>

                        <div class="coach-metrics">
                            <div><span>Visite</span><strong>{{ $card['views'] }}</strong></div>
                            <div><span>Click</span><strong>{{ $card['clicks'] }}</strong></div>
                            <div><span>Preferiti</span><strong>{{ $card['favorites'] }}</strong></div>
                            <div><span>Chat</span><strong>{{ $card['contacts'] }}</strong></div>
                        </div>

                        <div class="coach-insight-grid">
                            <div>
                                <h3>Diagnosi</h3>
                                <ul>
                                    @foreach ($card['issues'] as $issue)
                                        <li>{{ $issue }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            <div>
                                <h3>Azioni consigliate</h3>
                                <ul>
                                    @foreach ($card['actions'] as $action)
                                        <li>{{ $action }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <div class="coach-price-box">
                            <div>
                                <span>Prezzo attuale</span>
                                <strong>€ {{ number_format($article->price, 2, ',', '.') }}</strong>
                            </div>
                            <div>
                                <span>Prezzo AI</span>
                                <strong>€ {{ number_format($card['suggested_price'], 2, ',', '.') }}</strong>
                            </div>
                            <p>{{ $card['price_note'] }}</p>
                        </div>

                        <div class="coach-actions">
                            <a href="{{ route('article.edit', $article) }}" class="btn custom-btn-outline">Modifica</a>
                            <a href="{{ route('article.show', $article) }}" class="btn dashboard-ghost-btn">Apri</a>
                            <form action="{{ route('article.highlight', $article) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button class="btn custom-btn-card" type="submit">
                                    {{ $article->is_highlighted ? 'Rimuovi evidenza' : 'Metti in evidenza' }}
                                </button>
                            </form>
                        </div>
                    </div>
                </article>
            @empty
                <x-empty-state
                    title="Nessun annuncio da analizzare"
                    message="Crea il tuo primo annuncio: l’AI Coach ti aiuterà a migliorarlo prima della pubblicazione."
                    :action-route="route('create.article')"
                    action-label="Crea annuncio"
                />
            @endforelse
        </div>
    </section>
</x-layout>
