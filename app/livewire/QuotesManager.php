<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Quotes - Solar ACE')]
class QuotesManager extends Component
{
    public function render()
    {
        return view('livewire.quotes-manager');
    }
}
