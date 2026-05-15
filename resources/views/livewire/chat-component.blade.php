<div class="chat-container glass-panel p-3 rounded-4 shadow-lg" wire:poll.5s="loadMessages">
    <div class="chat-header mb-3 pb-2 d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center">
            <div class="status-indicator me-2 rounded-circle"></div>
            <h5 class="m-0 text-white fw-bold">Chat venditore</h5>
        </div>
        <span class="small text-secondary">Risposte private</span>
    </div>

    <div class="messages-list mb-3 overflow-auto">
        <div>
            @forelse($messages as $msg)
                <div class="message-wrapper mb-2 d-flex {{ $msg->sender_id === auth()->id() ? 'justify-content-end' : 'justify-content-start' }}">
                    <div class="message-bubble px-3 py-2 rounded-4 {{ $msg->sender_id === auth()->id() ? 'message-bubble-own' : 'message-bubble-other' }}">
                        <p class="m-0 small">{{ $msg->content }}</p>
                        <span>{{ $msg->created_at->format('H:i') }}</span>
                    </div>
                </div>
            @empty
                <div class="chat-empty text-center py-3">
                    <p class="small text-secondary mb-0">Nessun messaggio. Scrivi al venditore per informazioni.</p>
                </div>
            @endforelse
        </div>
    </div>

    @auth
        <form wire:submit.prevent="sendMessage" class="chat-input d-flex gap-2 align-items-stretch">
            <textarea wire:model.defer="messageContent" class="form-control custom-input rounded-4" placeholder="Scrivi un messaggio..." rows="1"></textarea>
            <button type="submit" class="btn custom-btn-card rounded-4 p-2 d-flex align-items-center justify-content-center" aria-label="Invia messaggio">
                <i class="fas fa-paper-plane"></i>
            </button>
        </form>
    @else
        <div class="alert alert-info py-2 small m-0">
            <a href="{{ route('login') }}" class="fw-bold">Accedi</a> per inviare messaggi.
        </div>
    @endauth
</div>
