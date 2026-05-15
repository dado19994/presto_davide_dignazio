<div class="price-suggester mt-2">
    @if($suggestedPrice)
        <div class="ai-suggestion-box glass-panel p-3 rounded-4 border border-primary border-opacity-25 animate__animated animate__fadeIn">
            <div class="d-flex align-items-center mb-2">
                <div class="ai-icon me-2">
                    <i class="fas fa-robot text-primary"></i>
                </div>
                <span class="text-white small fw-bold">Suggerimento prezzo reale</span>
            </div>
            <p class="text-white-50 small m-0">
                Basato su {{ $sampleSize }} annunci {{ $sampleSize >= 3 ? 'simili' : 'della categoria' }} nel catalogo:
                <span class="text-primary fw-bold">€ {{ number_format($suggestedPrice, 2, ',', '.') }}</span>
            </p>
            @if($marketRange)
                <p class="text-white-50 small mt-1 mb-0">
                    Range rilevato: € {{ number_format($marketRange['min'], 2, ',', '.') }} -
                    € {{ number_format($marketRange['max'], 2, ',', '.') }} · Affidabilità {{ $confidence }}
                </p>
            @endif
            <button type="button" class="btn btn-sm btn-link text-primary p-0 mt-1 small text-decoration-none"
                    onclick="const input = document.getElementById('price'); input.value = '{{ $suggestedPrice }}'; input.dispatchEvent(new Event('input', { bubbles: true })); input.dispatchEvent(new Event('change', { bubbles: true }));">
                Applica suggerimento
            </button>
        </div>
    @elseif($isAnalyzing)
        <div class="text-white-50 small animate__animated animate__pulse animate__infinite">
            <i class="fas fa-spinner fa-spin me-1"></i> Analisi di mercato in corso...
        </div>
    @endif
    <style>
    .ai-suggestion-box {
        background: rgba(99, 102, 241, 0.05);
    }
</style>
</div>
