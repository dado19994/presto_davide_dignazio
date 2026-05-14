<?php

namespace App\Livewire;

use Livewire\Component;

class CartSummary extends Component
{
    public $cartItems = [];
    public $total = 0;

    protected $listeners = ['cartUpdated' => 'loadCart'];

    public function mount()
    {
        $this->loadCart();
    }

    public function loadCart()
    {
        $this->cartItems = session()->get('cart', []);
        $this->calculateTotal();
    }

    public function calculateTotal()
    {
        $this->total = array_reduce($this->cartItems, function ($carry, $item) {
            return $carry + $item['price'];
        }, 0);
    }

    public function removeItem($id)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
        }
        session()->put('cart', $cart);
        $this->loadCart();
        $this->dispatch('cartUpdated');
    }

    public function render()
    {
        return view('livewire.cart-summary');
    }
}
