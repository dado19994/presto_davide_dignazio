<?php

namespace App\Livewire;

use Livewire\Component;

class NavbarCartCounter extends Component
{
    public $count = 0;

    protected $listeners = ['cartUpdated' => 'updateCount'];

    public function mount()
    {
        $this->updateCount();
    }

    public function updateCount()
    {
        $this->count = count(session()->get('cart', []));
    }

    public function render()
    {
        return view('livewire.navbar-cart-counter');
    }
}
