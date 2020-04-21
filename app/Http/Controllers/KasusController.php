<?php

namespace App\Http\Controllers;

use App\Kasus;
use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Charts\LineChart;
use Illuminate\Support\Facades\Cache;

class KasusController extends Controller
{
    /**
     * Dashboard Controller
     *
     * @return View
     */
    public function index()
    {
        // Pick latest Data
        $kasus = Kasus::latest()->first();

        // Pick news
        $news = $this->news();

        // Pick Line Chart
        $chart = $this->lineChart();

        // Pick Doughnout diagram
        $donat = $this->donatChart($kasus);

        return view('dashboard', compact('kasus', 'chart', 'donat', 'news'));
    }

    /**
     * fetch news
     *
     * @return Collection
     */
    protected function news()
    {
        // Get data news from cache
        $collection = Cache::remember('news-api', config('corona.cache_time'), function () {
            $client = new Client([
                'timeout' => 30.0
            ]);
    
            // fetch current news data
            $response = $client->request('GET', config('corona.news_url'));
    
            // decode data
            $data = json_decode($response->getBody()->getContents());
    
            // return data as collection
            return collect($data->articles);
        });

        // Pick 5 current data
        $collection = $collection->take(5);

        return $collection->all();
    }

    /**
     * line chart data
     *
     * @return LineChart
     */
    protected function lineChart()
    {
        // Query to fetch latest daily data
        $sub = Kasus::selectRaw('MAX(created_at)');
        $data = Kasus::whereRaw("created_at IN ({$sub->toSql()} GROUP BY Date(created_at) )")
                        ->orderBy('created_at')
                        ->whereDate('created_at', '>', Carbon::now()->subDays(30))
                        ->get()
                        ->groupBy(function($item){
                            return $item->created_at->format('Y-m-d');
                        })
                        ->map(function($item){
                            return $item[0];
                        });
        
        // initialize chart
        $chart = new LineChart;
        $chart->options([
            'tooltip' => [
                'show' => true // or false, depending on what you want.
            ]
        ]);
        // Render line chart
        $chart->labels($data->keys());
        $chart->dataset('Jumlah Kasus', 'line', $data->values()->pluck('total_case'))
                ->color("#17a2b8")
                ->backgroundcolor("rgba(201, 76, 76, 0.0)");
        $chart->dataset('Dalam Perawatan', 'line', $data->values()->pluck('active_case'))
                ->color("#605ca8")
                ->backgroundcolor("rgba(201, 76, 76, 0.0)");
        $chart->dataset('Kasus Baru', 'line', $data->values()->pluck('new_case'))
                ->color("#007bff")
                ->backgroundcolor("rgba(201, 76, 76, 0.0)");
        $chart->dataset('Pasien Sembuh ', 'line', $data->values()->pluck('total_recovered'))
                ->color("#28a745")
                ->backgroundcolor("rgba(201, 76, 76, 0.0)");
        $chart->dataset('Pasien Meninggal', 'line', $data->values()->pluck('total_death'))
                ->color("#dc3545")
                ->backgroundcolor("rgba(201, 76, 76, 0.0)");

        return $chart;
    }

    /**
     * Doughnout diagram
     *
     * @param Kasus $kasus
     * @return void
     */
    protected function donatChart($kasus)
    {
        // initialize doughnout diagram
        $donat = new LineChart;
        $donat->options([
            'tooltip' => [
                'show' => true // or false, depending on what you want.
            ]
        ]);

        // Render doughnout diagram
        $donat->displayAxes(true, false);
        $donat->labels(['Pasien Sembuh %', 'Pasien Meninggal %', 'Dalam Perawatan %']);
        $donat->dataset('Kasus', 'pie', [
            $kasus->total_recovered / $kasus->total_case * 100,
            $kasus->total_death / $kasus->total_case * 100,
            $kasus->active_case / $kasus->total_case * 100,
        ])
        ->color([
            '#28a745',
            '#dc3545',
            '#605ca8'
        ])
        ->backgroundcolor([
            '#28a745',
            '#dc3545',
            '#605ca8'
        ]);

        return $donat;
    }
}
