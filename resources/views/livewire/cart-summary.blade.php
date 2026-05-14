<div class="cart-summary-page py-5">
    <div class="container">
        <h2 class="text-white fw-bold mb-5 d-flex align-items-center">
            <i class="fas fa-shopping-cart text-primary me-3"></i> Riepilogo Carrello
        </h2>

        @if(count($cartItems) > 0)
            <div class="row g-4">
                <div class="col-12 col-lg-8">
                    <div class="cart-items-list d-flex flex-column gap-3">
                        @foreach($cartItems as $item)
                            <div class="cart-item-card glass-panel p-3 rounded-4 d-flex align-items-center animate__animated animate__fadeIn">
                                <img src="{{ $item['image'] }}" class="rounded-3 me-3 shadow-sm" style="width: 80px; height: 80px; object-fit: cover;">
                                <div class="flex-grow-1">
                                    <h6 class="text-white m-0 fw-bold">{{ $item['title'] }}</h6>
                                    <p class="text-primary m-0 small fw-bold">€ {{ number_format($item['price'], 2, ',', '.') }}</p>
                                </div>
                                <button wire:click="removeItem({{ $item['id'] }})" class="btn btn-outline-danger border-0 rounded-circle p-2">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-12 col-lg-4">
                    <div class="cart-total-card glass-panel p-4 rounded-4 shadow-lg sticky-top" style="top: 100px;">
                        <h5 class="text-white fw-bold mb-4">Totale Ordine</h5>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-white-50">Sottototale</span>
                            <span class="text-white">€ {{ number_format($total, 2, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-4 pb-4 border-bottom border-white border-opacity-10">
                            <span class="text-white-50">Spedizione AI</span>
                            <span class="text-success fw-bold">GRATIS</span>
                        </div>
                        <div class="d-flex justify-content-between mb-5">
                            <h4 class="text-white fw-bold">Totale</h4>
                            <h4 class="text-primary fw-bold">€ {{ number_format($total, 2, ',', '.') }}</h4>
                        </div>
                        <button class="btn btn-primary w-100 py-3 rounded-pill fw-bold shadow-lg">
                            Procedi al Pagamento
                        </button>
                    </div>
                </div>
            </div>
        @else
            <div class="empty-cart-state text-center py-5 glass-panel rounded-5">
                <div class="mb-4">
                    <i class="fas fa-cart-arrow-down fa-5x text-white-50 opacity-20"></i>
                </div>
                <h3 class="text-white fw-bold">Il tuo carrello è vuoto</h3>
                <p class="text-white-50 mb-5">Non hai ancora aggiunto alcun prodotto intelligente al tuo carrello.</p>
                <a href="{{ route('article.index') }}" class="btn btn-primary px-5 py-3 rounded-pill fw-bold">
                    Inizia lo shopping
                </a>
            </div>
        @endif
    </div>
</div>
