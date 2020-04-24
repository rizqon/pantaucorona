<?php

namespace App\Http\Livewire;

use App\Kasus;
use Livewire\Component;
use Illuminate\Support\Carbon;
use App\Charts\LineChart as lineDiagram;

class Linechart extends Component
{
    public function render()
    {
        $sub = Kasus::selectRaw('MAX(created_at)');
        $data = Kasus::whereRaw("created_at IN ({$sub->toSql()} GROUP BY Date(created_at) )")
                        ->orderBy('created_at')
                        ->get()
                        ->groupBy(function($item){
                            return $item->created_at->format('Y-m-d');
                        })
                        ->map(function($item){
                            return $item[0];
                        });

        return view('livewire.linechart', [
            'label' => $data->keys(),
            'confirmed' => $data->values()->pluck('total_case'),
            'active' => $data->values()->pluck('active_case'),
            'newCase' => $data->values()->pluck('new_case'),
            'recovered' => $data->values()->pluck('total_recovered'),
            'death' => $data->values()->pluck('total_death')
        ]);
    }
}
