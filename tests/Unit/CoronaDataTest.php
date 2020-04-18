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
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CoronaDataTest extends TestCase
{
    public function test_load_keyword()
    {
        $file = file_get_contents(base_path('keyword.txt'));
        $keywords = explode("\n", $file);
        $keyword = collect($keywords)->random();
        dd($keyword);
        
    }
}
