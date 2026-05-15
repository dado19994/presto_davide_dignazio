<x-layout>
    <section class="hero-startup home-hero">
        <div class="container">
            <div class="row align-items-center min-vh-100 g-5">
                <div class="col-12 col-lg-6">
                    <span class="hero-badge">
                        <i class="fas fa-microchip me-2"></i>
                        AI Marketplace Platform
                    </span>

                    <h1 class="hero-title mt-4">
                        Compra e vendi in modo intelligente. </h1>

                    <p class="hero-subtitle mt-4">
                        VendoHub AI analizza annunci, immagini, prezzi e conversazioni per rendere ogni compravendita
                        più chiara, sicura e veloce.
                    </p>

                    <div class="hero-actions d-flex gap-3 mt-5 flex-wrap">
                        <a href="{{ route('article.index') }}" class="btn hero-btn-primary">
                            Esplora marketplace
                        </a>
                        <a href="{{ route('create.article') }}" class="btn hero-btn-secondary">
                            Pubblica articolo
                        </a>
                    </div>

                    <div class="hero-trust-row">
                        <div>
                            <strong>AI Validated</strong>
                            <span>controlli intelligenti sugli annunci</span>
                        </div>
                        <div>
                            <strong>Prezzo smart</strong>
                            <span>suggerimenti per vendere prima</span>
                        </div>
                        <div>
                            <strong>AI Guard</strong>
                            <span>alert su messaggi sospetti</span>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-6">
                    <div class="ai-hero-stage" aria-label="Assistente AI che genera card prodotto">
                        <div class="ai-orbit-line"></div>

                        <div class="ai-robot">
                            <div class="ai-robot-head">
                                <span></span>
                                <span></span>
                            </div>
                            <div class="ai-robot-body">
                                <i class="fas fa-bolt"></i>
                            </div>
                            <div class="ai-robot-shadow"></div>
                        </div>

                        <div class="generated-card generated-card-1">
                            <span class="mini-badge">Prezzo OK</span>
                            <strong>{{ $articles->get(0)?->title ?? 'MacBook Air M3' }}</strong>
                            <small>Score annuncio 92/100</small>
                        </div>

                        <div class="generated-card generated-card-2">
                            <span class="mini-badge cyan">AI Validated</span>
                            <strong>{{ $articles->get(1)?->title ?? 'Fotocamera vintage' }}</strong>
                            <small>Foto copertina consigliata</small>
                        </div>

                        <div class="generated-card generated-card-3">
                            <span class="mini-badge rose">Venditore top</span>
                            <strong>{{ $articles->get(2)?->title ?? 'Sneakers limited' }}</strong>
                            <small>Risposta stimata rapida</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="home-band home-market-band">
        <div class="container">
            <div class="section-heading-row">
                <div>
                    <p class="page-eyebrow mb-2">Marketplace in evidenza</p>
                    <h2 class="home-section-title">Card generate dall’AI, pronte da esplorare</h2>
                </div>
                <a href="{{ route('article.index') }}" class="btn custom-btn-outline">Vedi tutti</a>
            </div>

            <div class="row g-4 home-card-grid">
                @forelse ($articles as $article)
                    <div class="col-12 col-md-6 col-xl-4 home-card-col">
                        <x-card :article="$article" />
                    </div>
                @empty
                    <div class="col-12">
                        <x-empty-state title="Nessun articolo disponibile"
                            message="La community non ha ancora pubblicato articoli." />
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <section class="home-band home-ai-band">
        <div class="container">
            <div class="text-center mx-auto home-section-intro">
                <p class="page-eyebrow mb-2">Perché VendoHub AI</p>
                <h2 class="home-section-title">L’AI non è decorazione: lavora sui tuoi annunci</h2>
                <p class="text-secondary mb-0">
                    Ogni funzione è pensata per aiutare chi vende a migliorare qualità, fiducia e velocità di risposta.
                </p>
            </div>

            <div class="row g-4 mt-4">
                <div class="col-12 col-md-4">
                    <div class="home-feature-card">
                        <i class="fas fa-tags"></i>
                        <h3>Prezzo suggerito</h3>
                        <p>L’AI legge categoria, testo e performance per suggerire quando mantenere o ritoccare il
                            prezzo.</p>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="home-feature-card">
                        <i class="fas fa-image"></i>
                        <h3>Immagini validate</h3>
                        <p>Controlli automatici sulle immagini e consigli per scegliere una copertina più efficace.</p>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="home-feature-card">
                        <i class="fas fa-shield-halved"></i>
                        <h3>Vendite più sicure</h3>
                        <p>AI Guard intercetta richieste sospette e ti aiuta a mantenere la trattativa sulla
                            piattaforma.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="home-band home-dashboard-band">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-12 col-lg-5">
                    <p class="page-eyebrow mb-2">Dashboard venditore</p>
                    <h2 class="home-section-title">Una cabina di regia per vendere con più controllo</h2>
                    <p class="text-secondary mt-3">
                        Monitora visite, messaggi, reputazione e suggerimenti AI. Ogni annuncio ha uno score e azioni
                        rapide.
                    </p>
                    <a href="{{ route('user.dashboard') }}" class="btn custom-btn-card mt-3">Apri dashboard</a>
                </div>

                <div class="col-12 col-lg-7">
                    <div class="dashboard-preview">
                        <div class="preview-toolbar">
                            <span></span><span></span><span></span>
                            <strong>AI Seller Console</strong>
                        </div>
                        <div class="preview-grid">
                            <div class="preview-panel large">
                                <span>Score annuncio</span>
                                <strong>92</strong>
                                <div class="preview-meter"><b style="width: 92%"></b></div>
                            </div>
                            <div class="preview-panel">
                                <span>Visite</span>
                                <strong>1.248</strong>
                            </div>
                            <div class="preview-panel">
                                <span>Chat aperte</span>
                                <strong>18</strong>
                            </div>
                            <div class="preview-panel wide">
                                <span>AI insight</span>
                                <p>Molte visite ma pochi contatti: prova a cambiare prima immagine o prezzo.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="home-final-cta">
        <div class="container">
            <div class="home-final-inner">
                <p class="page-eyebrow mb-2">Inizia ora</p>
                <h2>Pubblica un annuncio migliore, non solo un annuncio in più.</h2>
                <div class="d-flex justify-content-center gap-3 flex-wrap mt-4">
                    <a href="{{ route('create.article') }}" class="btn hero-btn-primary">Pubblica articolo</a>
                    <a href="{{ route('article.index') }}" class="btn hero-btn-secondary">Esplora marketplace</a>
                </div>
            </div>
        </div>
    </section>
</x-layout>
