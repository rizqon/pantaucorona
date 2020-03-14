<?php

namespace App\Http\Controllers;

use App\Kasus;
use App\Charts\LineChart;
use Illuminate\Http\Request;

class KasusController extends Controller
{
    public function index()
    {
        // Pick Data
        $kasus = Kasus::latest()->first();

        // chart
        $sub = Kasus::selectRaw('MAX(created_at)');
        $data = Kasus::whereRaw("created_at IN ({$sub->toSql()} GROUP BY Date(created_at) )")
                        ->orderBy('created_at', 'asc')
                        ->get()
                        ->groupBy(function($item){
                            return $item->created_at->format('Y-m-d');
                        });
        
        $total_case = $data->values()->map(function($item, $key){
                            return $item[0]->total_case;
                        });
        $total_recovered = $data->values()->map(function($item, $key){
                                return $item[0]->total_recovered;
                            });
        $critical_case = $data->values()->map(function($item, $key){
            return $item[0]->critical_case;
        });

        $total_death = $data->values()->map(function($item, $key){
            return $item[0]->total_death;
        });
        
        $chart = new LineChart;
        $chart->options([
            'tooltip' => [
                'show' => true // or false, depending on what you want.
            ]
        ]);
        $chart->labels($data->keys());
        $chart->dataset('Jumlah Kasus', 'line', $total_case)
                ->color("#17a2b8")
                ->backgroundcolor("rgba(201, 76, 76, 0.0)");
        $chart->dataset('Pasien Sembuh ', 'line', $total_recovered)
                ->color("#28a745")
                ->backgroundcolor("rgba(201, 76, 76, 0.0)");
        $chart->dataset('Pasien Kritis ', 'line', $critical_case)
                ->color("#ffc107")
                ->backgroundcolor("rgba(201, 76, 76, 0.0)");
        $chart->dataset('Pasien Meninggal', 'line', $total_death)
                ->color("#dc3545")
                ->backgroundcolor("rgba(201, 76, 76, 0.0)");

        $donat = new LineChart;
        $chart->options([
            'tooltip' => [
                'show' => true // or false, depending on what you want.
            ]
        ]);
        $donat->displayAxes(true, false);
        $donat->labels(['Pasien Sembuh %', 'Pasien Kritis %', 'Pasien Meninggal %', 'Kasus Aktiv %']);
        $donat->dataset('Kasus', 'pie', [
            $kasus->total_recovered / $kasus->total_case * 100,
            $kasus->total_critical / $kasus->total_case * 100,
            $kasus->total_death / $kasus->total_case * 100,
            $kasus->active_case / $kasus->total_case * 100,
        ])
        ->color([
            '#28a745',
            '#ffc107',
            '#dc3545',
            '#17a2b8'
        ])
        ->backgroundcolor([
            '#28a745',
            '#ffc107',
            '#dc3545',
            '#17a2b8'
        ]);

        return view('dashboard', compact('kasus', 'chart', 'donat'));
    }
}
