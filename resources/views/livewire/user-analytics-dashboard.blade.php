<div class="analytics-dashboard glass-panel p-4 rounded-4 shadow-lg border border-white border-opacity-10">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="text-white fw-bold mb-0">AI Performance Dashboard</h4>
            <p class="text-white-50 small mb-0">Monitora l'andamento dei tuoi annunci in tempo reale</p>
        </div>
        <div class="ai-badge p-2 px-3 rounded-pill bg-primary bg-opacity-10 border border-primary border-opacity-20">
            <i class="fas fa-microchip text-primary me-2"></i>
            <span class="text-primary small fw-bold">AI ANALYTICS ACTIVE</span>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-12 col-md-4">
            <div class="stat-card p-3 rounded-4 bg-white bg-opacity-5 border border-white border-opacity-10">
                <p class="text-white-50 small mb-1">Visualizzazioni Totali</p>
                <h3 class="text-white fw-bold mb-0">{{ number_format($totalViews) }}</h3>
                <div class="text-success small mt-2">
                    <i class="fas fa-arrow-up me-1"></i> +12% questo mese
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="stat-card p-3 rounded-4 bg-white bg-opacity-5 border border-white border-opacity-10">
                <p class="text-white-50 small mb-1">Click Ricevuti</p>
                <h3 class="text-white fw-bold mb-0">{{ number_format($totalClicks) }}</h3>
                <div class="text-success small mt-2">
                    <i class="fas fa-arrow-up me-1"></i> +5% questa settimana
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="stat-card p-3 rounded-4 bg-white bg-opacity-5 border border-white border-opacity-10">
                <p class="text-white-50 small mb-1">Annunci Attivi</p>
                <h3 class="text-white fw-bold mb-0">{{ $activeArticles }}</h3>
                <div class="text-primary small mt-2">
                    <i class="fas fa-info-circle me-1"></i> Tutti approvati dall'AI
                </div>
            </div>
        </div>
    </div>

    <div class="ai-insights p-3 rounded-4 bg-primary bg-opacity-10 border border-primary border-opacity-20 mb-4">
        <h6 class="text-primary fw-bold mb-2"><i class="fas fa-lightbulb me-2"></i> AI Insight</h6>
        <p class="text-white-50 small m-0">Abbiamo notato che i tuoi annunci nella categoria "Elettronica" performano meglio il Martedì pomeriggio. Prova a pubblicare nuovi prodotti in quella fascia oraria!</p>
    </div>

    <div class="performance-chart h-100 rounded-4 bg-black bg-opacity-20 p-3 border border-white border-opacity-5" style="min-height: 200px; position: relative;">
        <!-- Rappresentazione grafica semplificata -->
        <div class="d-flex align-items-end justify-content-between h-100 px-2 pt-4" style="height: 150px !important;">
            @for($i = 0; $i < 12; $i++)
                <div class="bar bg-primary bg-opacity-50 rounded-top"
                     style="width: 6%; height: {{ rand(30, 90) }}%; transition: height 1s ease-in-out;">
                </div>
            @endfor
        </div>
        <div class="d-flex justify-content-between mt-2 px-1">
            <span class="text-white-50" style="font-size: 0.6rem;">01 Mag</span>
            <span class="text-white-50" style="font-size: 0.6rem;">15 Mag</span>
            <span class="text-white-50" style="font-size: 0.6rem;">31 Mag</span>
        </div>
    </div>
</div>
