<?php

namespace App\Http\Livewire;

use App\Kasus;
use Livewire\Component;

class BarChart extends Component
{
    public function render()
    {
        return view('livewire.bar-chart', [
            'kasus' => Kasus::latest()->first()
        ]);
    }
}
