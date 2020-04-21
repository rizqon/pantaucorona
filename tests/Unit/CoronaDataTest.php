<?php

namespace Tests\Unit;

use App\Kasus;
use Tests\TestCase;
use GuzzleHttp\Client;
use League\Csv\Reader;
use League\Csv\Statement;
use App\Imports\CoronaCsv;
use Illuminate\Support\Facades\DB;
use KubAT\PhpSimple\HtmlDomParser;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CoronaDataTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     * 
     * @return void
     */
    public function test_it_can_scrape_and_extract_data()
    {
        $url = config('corona.source_url');
        
        $client = new Client([
            // You can set any number of default request options.
            'timeout'  => 10.0,
        ]);

        $response = $client->request('GET', $url);

        $html = $response->getBody()->getContents();

        $dom = HtmlDomParser::str_get_html($html);

        $data = [
            'country' => 'indonesia'
        ];
        foreach($dom->find('table.table-bordered tbody tr') as $row)
        {
            if( strpos(strtolower($row->find('td', 0)->plaintext), 'indonesia'))
            {
                // dd($row->find('td', 1)->plaintext);
                $data['total_case'] = (int) $row->find('td', 1)->plaintext;
                $data['new_case'] = (int) $row->find('td', 2)->plaintext;
                $data['total_death'] = (int) $row->find('td', 3)->plaintext;
                $data['new_death'] = (int) $row->find('td', 4)->plaintext;
                $data['total_recovered'] = (int) $row->find('td', 5)->plaintext;
                $data['active_case'] = (int) $row->find('td', 6)->plaintext;
                $data['critical_case'] = (int) $row->find('td', 7)->plaintext;
            }
        }

        $this->assertTrue(true);
    }

    /**
     * 
     * return void;
     */
    public function test_it_can_load_data()
    {
        $kasus = factory(Kasus::class, 100)->create();

        $sub = Kasus::selectRaw('MAX(created_at)');

        $data = Kasus::whereRaw("created_at IN ({$sub->toSql()} GROUP BY Date(created_at) )")->orderBy('created_at', 'desc');

        dd($data->get()->groupBy(function($item){
            return $item->created_at->format('Y-m-d');
        }));
    }
}
