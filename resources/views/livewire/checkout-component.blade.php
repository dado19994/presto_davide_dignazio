<div class="checkout-wrapper">
    <!-- Button to trigger modal -->
    <button type="button" class="btn checkout-trigger custom-btn-card"
        data-bs-toggle="modal" data-bs-target="#checkoutModal-{{ $article->id }}">
        <i class="fas fa-shopping-cart me-2"></i> Acquista ora
    </button>

    @teleport('body')
        <div class="modal fade checkout-modal" id="checkoutModal-{{ $article->id }}" tabindex="-1"
            aria-labelledby="checkoutModalLabel-{{ $article->id }}" aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content border-0 overflow-hidden shadow-2xl">
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold" id="checkoutModalLabel-{{ $article->id }}">Checkout sicuro</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>

                    <div class="modal-body p-4">
                        @guest
                            <div class="text-center py-4">
                                <i class="fas fa-lock fa-3x text-primary mb-3"></i>
                                <h6 class="fw-bold mb-2">Accedi per acquistare</h6>
                                <p class="text-secondary mb-4">Serve un account per completare il checkout in sicurezza.</p>
                                <a href="{{ route('login') }}" class="btn custom-btn-card w-100">Accedi</a>
                            </div>
                        @else
                        @if ($step == 1)
                            <div class="step-1 animate__animated animate__fadeIn">
                                <div
                                    class="checkout-product d-flex align-items-center mb-4 p-3 rounded-3">
                                    <img src="{{ $article->images->first() ? $article->images->first()->getUrl() : 'https://picsum.photos/100' }}"
                                        class="rounded-3 me-3" alt="{{ $article->title }}">
                                    <div>
                                        <h6 class="m-0 fw-bold">{{ $article->title }}</h6>
                                        <p class="m-0 text-primary fw-bold">€
                                            {{ number_format($article->price, 2, ',', '.') }}</p>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label small text-secondary">Indirizzo di spedizione</label>
                                    <div class="checkout-note p-3 rounded-3">
                                        <p class="m-0 small"><i class="fas fa-map-marker-alt me-2 text-primary"></i>
                                            Utilizza indirizzo predefinito</p>
                                    </div>
                                </div>



                                <button wire:click="nextStep" type="button"
                                    class="btn custom-btn-card w-100 py-3">Continua al pagamento</button>
                            </div>
                        @elseif($step == 2)
                            <div class="step-2 animate__animated animate__fadeIn">
                                <h6 class="mb-3">Metodo di pagamento</h6>
                                <div class="payment-options d-flex flex-column gap-3 mb-4">
                                    <div class="payment-option p-3 rounded-3 border {{ $paymentMethod == 'card' ? 'border-primary is-selected' : '' }} cursor-pointer"
                                        wire:click="$set('paymentMethod', 'card')">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span><i class="fas fa-credit-card me-2"></i> Carta di Credito</span>
                                            <i
                                                class="fas {{ $paymentMethod == 'card' ? 'fa-dot-circle text-primary' : 'fa-circle text-secondary' }}"></i>
                                        </div>
                                    </div>
                                    <div class="payment-option p-3 rounded-3 border {{ $paymentMethod == 'paypal' ? 'border-primary is-selected' : '' }} cursor-pointer"
                                        wire:click="$set('paymentMethod', 'paypal')">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span><i class="fab fa-paypal me-2"></i> PayPal</span>
                                            <i
                                                class="fas {{ $paymentMethod == 'paypal' ? 'fa-dot-circle text-primary' : 'fa-circle text-secondary' }}"></i>
                                        </div>
                                    </div>
                                </div>

                                <div
                                    class="ai-protection mb-4 p-3 rounded-3 d-flex align-items-start">
                                    <i class="fas fa-shield-alt text-primary mt-1 me-3"></i>
                                    <p class="m-0 small text-secondary">Transazione protetta da <span
                                            class="text-primary fw-bold">VendoHub AI Guard</span>. Il venditore riceverà il
                                        pagamento solo dopo la tua conferma di ricezione.</p>
                                </div>

                                <button wire:click="processPayment" type="button" class="btn custom-btn-card w-100 py-3">
                                    <i class="fas fa-lock me-2"></i> Paga Ora €
                                    {{ number_format($article->price, 2, ',', '.') }}
                                </button>
                            </div>
                        @else
                            <div class="step-3 text-center py-4 animate__animated animate__zoomIn">
                                <div class="success-icon mb-4">
                                    <i class="fas fa-check-circle text-success fa-5x"></i>
                                </div>
                                <h4 class="fw-bold mb-2">Ordine Completato!</h4>
                                <p class="text-secondary mb-4">Il tuo ordine è stato elaborato con successo. Riceverai una
                                    mail di conferma a breve.</p>
                                <button type="button" class="btn custom-btn-outline px-4"
                                    data-bs-dismiss="modal">Chiudi</button>
                            </div>
                        @endif
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    @endteleport
</div>
