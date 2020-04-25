<?php

namespace App\Console\Commands;

use App\Kasus;
use App\Events\CaseUpdated;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

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
        // get latest data
        $data = Kasus::latest()->first();
        
        // get data
        $result = $this->getDataV3();

        // compare data
        $is_updated = !$this->compareData($data, $result);

        // if updated data
        if($is_updated)
        {
            // parsing data
            $parsedData = $this->parseData($data, $result);

            $kasus = Kasus::create($parsedData);
            $this->info('Info virus corona');
            $this->line('Total Kasus: '. $kasus->total_case);
            $this->line('Kasus Baru: '. $kasus->new_case);
            $this->line('Total Kematian: '. $kasus->total_death);
            $this->line('Kematian Baru: '. $kasus->new_death);
            $this->line('Total Sembuh: '. $kasus->total_recovered);
            $this->line('Kasus Aktif: '. $kasus->active_case);
            $this->line('Kasus Kritis: '. $kasus->critical_case);

            event(new CaseUpdated($kasus));
        }else{
            $this->info('No update data');
        }
    }

    protected function parseData($data, array $result)
    {
        $parsed = [
            'total_case' => $result['confirmed'],
            'new_case' => $result['confirmed'] - $data->total_case,
            'total_death' => $result['deceased'],
            'new_death' => $result['deceased'] - $data->total_death,
            'total_recovered' => $result['recovered'],
            'new_recovered' => $result['recovered'] - $data->total_recovered,
            'active_case' => $result['activeCare'],
            'critical_case' => 0
        ];

        return $parsed;
    }

    protected function compareData($data, array $result)
    {
        $val_1 = [
            'confirmed' => $data->total_case,
            'deaths' => $data->total_death,
            'recovered' => $data->total_recovered,
            'activeCare' => $data->active_case
        ];

        $val_2 = [
            'confirmed' => $result['confirmed'],
            'deaths' => $result['deceased'],
            'recovered' => $result['recovered'],
            'activeCare' => $result['activeCare']
        ];

        return $val_1 === $val_2;
    }

    protected function getDataV3()
    {
        $response = Http::get('https://api.kawalcovid19.id/v1/api/case/summary');

        $result = json_decode($response->body(), true);

        return $result;
    }
}
