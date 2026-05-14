<div>
    <button wire:click.stop="toggleFavorite" class="btn favorite-btn {{ $isFavorite ? 'active' : '' }}" title="{{ $isFavorite ? 'Rimuovi dai preferiti' : 'Aggiungi ai preferiti' }}">
        <i class="fa{{ $isFavorite ? 's' : 'r' }} fa-heart"></i>
    </button>
    <style>
        .favorite-btn {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            backdrop-filter: blur(5px);
        }
        .favorite-btn:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: scale(1.1);
            color: #fb7185;
        }
        .favorite-btn.active {
            color: #fb7185;
            background: rgba(251, 113, 133, 0.1);
            border-color: rgba(251, 113, 133, 0.3);
        }
    </style>
</div>
