<?php

namespace App\Livewire;

use App\Models\Article;
use App\Models\Transaction;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CheckoutComponent extends Component
{
    public $article;
    public $step = 1; // 1: Info, 2: Payment, 3: Success
    public $paymentMethod = 'card';

    public function mount(Article $article)
    {
        $this->article = $article;
    }

    public function nextStep()
    {
        $this->step++;
    }

    public function processPayment()
    {
        if (!Auth::check()) return;

        Transaction::create([
            'buyer_id' => Auth::id(),
            'seller_id' => $this->article->user_id,
            'article_id' => $this->article->id,
            'amount' => $this->article->price,
            'status' => 'completed',
            'payment_method' => $this->paymentMethod,
            'transaction_id' => 'TXN-' . strtoupper(Str::random(10)),
        ]);

        $this->step = 3;
    }

    public function render()
    {
        return view('livewire.checkout-component');
    }
}
