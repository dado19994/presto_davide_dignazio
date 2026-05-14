<div>
<button wire:click.stop="toggleCart" class="btn cart-action-btn {{ $isInCart ? 'btn-success' : 'btn-primary' }} rounded-pill px-4 fw-bold">
    <i class="fas {{ $isInCart ? 'fa-check' : 'fa-cart-plus' }} me-2"></i>
    {{ $isInCart ? 'Nel carrello' : 'Aggiungi al carrello' }}
</button>
</div>
