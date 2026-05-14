<?php

namespace App\Livewire;

use App\Models\Article;
use Livewire\Component;

class CartButton extends Component
{
    public $articleId;
    public $isInCart = false;

    public function mount($articleId)
    {
        $this->articleId = $articleId;
        $this->checkIfInCart();
    }

    public function checkIfInCart()
    {
        $cart = session()->get('cart', []);
        $this->isInCart = isset($cart[$this->articleId]);
    }

    public function toggleCart()
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$this->articleId])) {
            unset($cart[$this->articleId]);
            $this->isInCart = false;
        } else {
            $article = Article::find($this->articleId);
            $cart[$this->articleId] = [
                'id' => $article->id,
                'title' => $article->title,
                'price' => $article->price,
                'image' => $article->images->first() ? $article->images->first()->getUrl() : 'https://picsum.photos/100'
            ];
            $this->isInCart = true;
        }

        session()->put('cart', $cart);
        $this->dispatch('cartUpdated');
    }

    public function render()
    {
        return view('livewire.cart-button');
    }
}
