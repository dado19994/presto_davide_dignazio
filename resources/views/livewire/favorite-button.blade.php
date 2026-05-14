<div>
    <button wire:click.stop="toggleFavorite" class="btn favorite-btn {{ $isFavorite ? 'active' : '' }}" title="{{ $isFavorite ? 'Rimuovi dai preferiti' : 'Aggiungi ai preferiti' }}">
        <i class="fa{{ $isFavorite ? 's' : 'r' }} fa-heart"></i>
    </button>
</div>
