<?php

namespace App\Livewire;

use App\Models\Message;
use App\Models\Article;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ChatComponent extends Component
{
    public $article;
    public $receiverId;
    public $messageContent;
    public $messages;

    public function mount(Article $article)
    {
        $this->article = $article;
        $this->receiverId = $article->user_id;
        $this->loadMessages();
    }

    public function loadMessages()
    {
        if (!Auth::check()) {
            $this->messages = collect();
            return;
        }

        $this->messages = Message::where('article_id', $this->article->id)
            ->where(function ($query) {
                $query->where('sender_id', Auth::id())
                    ->orWhere('receiver_id', Auth::id());
            })
            ->orderBy('created_at', 'asc')
            ->get();
    }

    public function sendMessage()
    {
        if (!Auth::check() || empty($this->messageContent)) {
            return;
        }

        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $this->receiverId,
            'article_id' => $this->article->id,
            'content' => $this->messageContent,
        ]);

        $this->messageContent = '';
        $this->loadMessages();
    }

    public function render()
    {
        return view('livewire.chat-component');
    }
}
