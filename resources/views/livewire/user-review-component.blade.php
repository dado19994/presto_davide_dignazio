<div class="user-reviews-section mt-5 glass-panel p-4 rounded-4 shadow-lg border border-white border-opacity-10 w-100 overflow-hidden">
    <h4 class="text-white fw-bold mb-4 d-flex align-items-center">
        <i class="fas fa-star text-warning me-2"></i> Feedback e Valutazioni
    </h4>

    @auth
        @if(auth()->id() !== $user->id)
            <div class="review-form mb-5 p-3 rounded-4 bg-white bg-opacity-5 border border-white border-opacity-5">
                <h6 class="text-white mb-3">Lascia una recensione per {{ $user->name }}</h6>

                @if(session()->has('review_success'))
                    <div class="alert alert-success py-2 small mb-3">{{ session('review_success') }}</div>
                @endif

                <form wire:submit.prevent="submitReview">
                    <div class="mb-3">
                        <label class="form-label small text-white-50">Valutazione</label>
                        <div class="d-flex gap-2">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star cursor-pointer {{ $rating >= $i ? 'text-warning' : 'text-white-50' }}"
                                   wire:click="$set('rating', {{ $i }})" style="font-size: 1.2rem;"></i>
                            @endfor
                        </div>
                    </div>

                    <div class="mb-3">
                        <textarea wire:model.defer="comment" class="form-control bg-dark border-secondary text-white rounded-3"
                                  placeholder="Scrivi il tuo feedback..." rows="3"></textarea>
                        @error('comment') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="btn btn-primary btn-sm px-4 rounded-pill">Invia Recensione</button>
                </form>
            </div>
        @endif
    @else
        <div class="alert alert-info py-2 small mb-5">
            <a href="{{ route('login') }}" class="fw-bold">Accedi</a> per lasciare una recensione.
        </div>
    @endauth

    <div class="reviews-list">
        @forelse($reviews as $review)
            <div class="review-item mb-3 p-3 rounded-4 bg-white bg-opacity-5 border border-white border-opacity-5 animate__animated animate__fadeIn">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-white fw-bold small">{{ $review->reviewer->name }}</span>
                    <div class="rating-stars">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star {{ $review->rating >= $i ? 'text-warning' : 'text-white-50' }}" style="font-size: 0.7rem;"></i>
                        @endfor
                    </div>
                </div>
                <p class="text-white-50 small m-0">{{ $review->comment }}</p>
                <span class="text-white-50" style="font-size: 0.6rem;">{{ $review->created_at->format('d/m/Y') }}</span>
            </div>
        @empty
            <div class="text-center py-4">
                <p class="text-white-50 m-0 italic">Nessuna recensione ancora.</p>
            </div>
        @endforelse
    </div>
</div>
