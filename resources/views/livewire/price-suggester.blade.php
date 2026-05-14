<div class="price-suggester mt-2">
    @if($suggestedPrice)
        <div class="ai-suggestion-box glass-panel p-3 rounded-4 border border-primary border-opacity-25 animate__animated animate__fadeIn">
            <div class="d-flex align-items-center mb-2">
                <div class="ai-icon me-2">
                    <i class="fas fa-robot text-primary"></i>
                </div>
                <span class="text-white small fw-bold">AI Price Suggestion</span>
            </div>
            <p class="text-white-50 small m-0">
                Basandoci sugli annunci simili, ti suggeriamo un prezzo di:
                <span class="text-primary fw-bold">€ {{ number_format($suggestedPrice, 2, ',', '.') }}</span>
            </p>
            <button type="button" class="btn btn-sm btn-link text-primary p-0 mt-1 small text-decoration-none"
                    onclick="document.getElementById('price').value = '{{ $suggestedPrice }}'; document.getElementById('price').dispatchEvent(new Event('input'));">
                Applica suggerimento
            </button>
        </div>
    @elseif($isAnalyzing)
        <div class="text-white-50 small animate__animated animate__pulse animate__infinite">
            <i class="fas fa-spinner fa-spin me-1"></i> Analisi di mercato in corso...
        </div>
    @endif

</div>

    <style>
    .ai-suggestion-box {
        background: rgba(99, 102, 241, 0.05);
    }
</style>
</div>



