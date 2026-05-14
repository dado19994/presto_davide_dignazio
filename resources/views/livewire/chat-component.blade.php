<div class="chat-container glass-panel p-4 rounded-4 shadow-lg" wire:poll.5s="loadMessages">
    <div class="chat-header mb-3 pb-2 border-bottom border-secondary d-flex align-items-center">
        <div class="status-indicator me-2 bg-success rounded-circle" style="width: 10px; height: 10px;"></div>
        <h5 class="m-0 text-white fw-bold">Chat con il venditore</h5>
    </div>

    <div class="messages-list mb-3 overflow-auto" style="height: 300px; display: flex; flex-direction: column-reverse;">
        <div>
            @foreach($messages as $msg)
                <div class="message-wrapper mb-2 d-flex {{ $msg->sender_id === auth()->id() ? 'justify-content-end' : 'justify-content-start' }}">
                    <div class="message-bubble px-3 py-2 rounded-4 {{ $msg->sender_id === auth()->id() ? 'bg-primary text-white shadow-sm' : 'bg-dark-light text-light border border-secondary' }}" style="max-width: 80%;">
                        <p class="m-0 small">{{ $msg->content }}</p>
                        <span class="text-white-50" style="font-size: 0.7rem;">{{ $msg->created_at->format('H:i') }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    @auth
        <form wire:submit.prevent="sendMessage" class="chat-input d-flex gap-2">
            <input type="text" wire:model.defer="messageContent" class="form-control bg-dark border-secondary text-white rounded-pill" placeholder="Scrivi un messaggio...">
            <button type="submit" class="btn btn-primary rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                <i class="fas fa-paper-plane"></i>
            </button>
        </form>
    @else
        <div class="alert alert-info py-2 small m-0">
            <a href="{{ route('login') }}" class="fw-bold">Accedi</a> per inviare messaggi.
        </div>
    @endauth
    <style>
        .bg-dark-light {
            background-color: rgba(255, 255, 255, 0.05);
        }
        .messages-list::-webkit-scrollbar {
            width: 4px;
        }
        .messages-list::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
        }
    </style>
</div>
