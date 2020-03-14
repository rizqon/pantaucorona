<?php

namespace App\Console\Commands;

use App\Kasus;
use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Events\CaseUpdated;
use Illuminate\Console\Command;
use KubAT\PhpSimple\HtmlDomParser;

class CoronaGrabber extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'corona:grab';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Grab Info Corona';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->info('Picking info Corona');
        
        $data = $this->getData();
        
        $data['total_case'] = 100;
        $data['total_recovered'] = 9;
        $old_kasus = Kasus::latest()->first();

        $kasus = Kasus::create($data);
        $this->info('Info virus corona');
        $this->line('Total Kasus: '. $kasus->total_case);
        $this->line('Kasus Baru: '. $kasus->new_case);
        $this->line('Total Kematian: '. $kasus->total_death);
        $this->line('Kematian Baru: '. $kasus->new_death);
        $this->line('Total Sembuh: '. $kasus->total_recovered);
        $this->line('Kasus Aktif: '. $kasus->active_case);
        $this->line('Kasus Kritis: '. $kasus->critical_case);

        event(new CaseUpdated($old_kasus, $kasus));
    }

    protected function getData() : array
    {
        $html = $this->getHtml();

        return $this->getArray($html);
    }

    protected function getArray(string $html) : array
    {
        $dom = HtmlDomParser::str_get_html($html);

        $data = [];
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

        return $data;
    }

    protected function getHtml() : string
    {
        $url = 'https://www.worldometers.info/coronavirus/';
        
        $client = new Client([
            // You can set any number of default request options.
            'timeout'  => 30.0,
        ]);

        $response = $client->request('GET', $url);

        return $response->getBody()->getContents();
    }
}
