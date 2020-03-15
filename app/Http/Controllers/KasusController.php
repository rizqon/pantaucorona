<?php

namespace App\Http\Controllers;

use App\Kasus;
use GuzzleHttp\Client;
use App\Charts\LineChart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class KasusController extends Controller
{
    public function index()
    {
        // Pick Data
        $kasus = Kasus::latest()->first();

        $news = $this->news();

        $chart = $this->lineChart();

        $donat = $this->donatChart($kasus);

        return view('dashboard', compact('kasus', 'chart', 'donat'));
    }

    protected function news()
    {
        $collection = Cache::remember('news-api', 3600, function () {
            $client = new Client();

            $response = $client->request('GET', config('corona.news_url'));

            $data = json_decode($response->getBody()->getContents());

            return collect($data->articles);
        });

        $collection = $collection->take(5);

        return $collection->all();
    }

    protected function lineChart()
    {
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
        $active_case = $data->values()->map(function($item, $key){
                            return $item[0]->active_case;
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
        $chart->dataset('Kasus Aktive', 'line', $active_case)
                ->color("#605ca8")
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

        return $chart;
    }

    protected function donatChart($kasus)
    {
        $donat = new LineChart;
        $donat->options([
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

        return $donat;
    }
}
