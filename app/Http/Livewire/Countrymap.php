<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class Countrymap extends Component
{
    public function render()
    {
        $response = Cache::remember('apiprovince', 3600, function () {
            $res = Http::get('https://api.kawalcorona.com/indonesia/provinsi');
            
            return $res->body();
        });

        $collection = collect(json_decode($response, true));

        
        $sum = $collection->sum(function ($item) {
            return $item['attributes']['Kasus_Posi'];    
        });
        $data = $collection->map(function($item, $key) use ($sum) {
            return [
                    'path' => "path".sprintf("%02d", $item['attributes']['FID']),
                    'provinsi' => $item['attributes']['Provinsi'],
                    'positif' => $item['attributes']['Kasus_Posi'],
                    'sembuh' => $item['attributes']['Kasus_Semb'],
                    'meninggal' => $item['attributes']['Kasus_Meni'],
                    'percentage' => ( $item['attributes']['Kasus_Posi'] / $sum ) * 100
            ];
        })->values()->all();

        return view('livewire.countrymap',[
            'data' => $data
        ]);
    }
}
