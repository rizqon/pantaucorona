<?php

namespace App\Http\Livewire;

use App\Kasus;
use Livewire\Component;

class Counter extends Component
{
    public function render()
    {
        return view('livewire.counter', [
            'kasus' => Kasus::latest()->first()
        ]);
    }
}
