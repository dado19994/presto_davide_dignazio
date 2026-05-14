<div class="checkout-wrapper">
    <!-- Button to trigger modal -->
    <button type="button" class="btn btn-primary custom-btn-card px-5 py-3 rounded-pill fw-bold shadow-lg" data-bs-toggle="modal" data-bs-target="#checkoutModal">
        <i class="fas fa-shopping-cart me-2"></i> Acquista ora
    </button>

    <!-- Modal -->
    <div class="modal fade" id="checkoutModal" tabindex="-1" aria-labelledby="checkoutModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 overflow-hidden shadow-2xl" style="background: rgba(15, 23, 42, 0.98); backdrop-filter: blur(20px);">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title text-white fw-bold" id="checkoutModalLabel">Checkout Sicuro</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-4 text-white">
                    @if($step == 1)
                        <div class="step-1 animate__animated animate__fadeIn">
                            <div class="d-flex align-items-center mb-4 p-3 rounded-3 bg-white bg-opacity-5 border border-white border-opacity-10">
                                <img src="{{ $article->images->first() ? $article->images->first()->getUrl() : 'https://picsum.photos/100' }}"
                                     class="rounded-3 me-3" style="width: 80px; height: 80px; object-fit: cover;">
                                <div>
                                    <h6 class="m-0 fw-bold">{{ $article->title }}</h6>
                                    <p class="m-0 text-primary fw-bold">€ {{ number_format($article->price, 2, ',', '.') }}</p>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label small text-white-50">Indirizzo di spedizione</label>
                                <div class="p-3 rounded-3 bg-white bg-opacity-5 border border-white border-opacity-10">
                                    <p class="m-0 small"><i class="fas fa-map-marker-alt me-2 text-primary"></i> Utilizza indirizzo predefinito</p>
                                </div>
                            </div>

                            <button wire:click="nextStep" class="btn btn-primary w-100 py-3 rounded-pill fw-bold">Continua al pagamento</button>
                        </div>
                    @elseif($step == 2)
                        <div class="step-2 animate__animated animate__fadeIn">
                            <h6 class="mb-3">Metodo di pagamento</h6>
                            <div class="payment-options d-flex flex-column gap-3 mb-4">
                                <div class="payment-option p-3 rounded-3 bg-white bg-opacity-5 border {{ $paymentMethod == 'card' ? 'border-primary' : 'border-white border-opacity-10' }} cursor-pointer"
                                     wire:click="$set('paymentMethod', 'card')">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span><i class="fas fa-credit-card me-2"></i> Carta di Credito</span>
                                        <i class="fas {{ $paymentMethod == 'card' ? 'fa-dot-circle text-primary' : 'fa-circle text-white-50' }}"></i>
                                    </div>
                                </div>
                                <div class="payment-option p-3 rounded-3 bg-white bg-opacity-5 border {{ $paymentMethod == 'paypal' ? 'border-primary' : 'border-white border-opacity-10' }} cursor-pointer"
                                     wire:click="$set('paymentMethod', 'paypal')">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span><i class="fab fa-paypal me-2"></i> PayPal</span>
                                        <i class="fas {{ $paymentMethod == 'paypal' ? 'fa-dot-circle text-primary' : 'fa-circle text-white-50' }}"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="ai-protection mb-4 p-3 rounded-3 bg-primary bg-opacity-10 border border-primary border-opacity-20 d-flex align-items-start">
                                <i class="fas fa-shield-alt text-primary mt-1 me-3"></i>
                                <p class="m-0 small text-white-50">Transazione protetta da <span class="text-primary fw-bold">VendoHub AI Guard</span>. Il venditore riceverà il pagamento solo dopo la tua conferma di ricezione.</p>
                            </div>

                            <button wire:click="processPayment" class="btn btn-primary w-100 py-3 rounded-pill fw-bold">
                                <i class="fas fa-lock me-2"></i> Paga Ora € {{ number_format($article->price, 2, ',', '.') }}
                            </button>
                        </div>
                    @else
                        <div class="step-3 text-center py-4 animate__animated animate__zoomIn">
                            <div class="success-icon mb-4">
                                <i class="fas fa-check-circle text-success fa-5x"></i>
                            </div>
                            <h4 class="fw-bold mb-2">Ordine Completato!</h4>
                            <p class="text-white-50 mb-4">Il tuo ordine è stato elaborato con successo. Riceverai una mail di conferma a breve.</p>
                            <button type="button" class="btn btn-outline-light rounded-pill px-4" data-bs-dismiss="modal">Chiudi</button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .cursor-pointer { cursor: pointer; }
    .shadow-2xl { box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5); }
</style>
