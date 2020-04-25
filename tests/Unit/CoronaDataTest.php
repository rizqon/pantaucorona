<?php

namespace Tests\Unit;

use App\Http\Resources\ProvinceCollection;
use App\Kasus;
use Tests\TestCase;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CoronaDataTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     *
     * @return void
     */
    public function it_can_load_keyword()
    {
        $file = file_get_contents(base_path('keyword.txt'));
        $keywords = explode("\n", $file);
        $keyword = collect($keywords)->random();
        
        $this->assertNotEmpty($keyword);
    }

    /**
     * @test
     * return void;
     */
    public function it_can_load_data()
    {
        factory(Kasus::class, 100)->create();

        $sub = Kasus::selectRaw('MAX(created_at)');

        $data = Kasus::whereRaw("created_at IN ({$sub->toSql()} GROUP BY Date(created_at) )")->orderBy('created_at', 'desc');

        $this->assertNotEmpty($data);
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_can_load_data_province()
    {
        $response = Http::get('https://api.kawalcorona.com/indonesia/provinsi');

        $this->assertNotEmpty($response);
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_can_load_data_nasional()
    {
        $response = Http::get('https://api.kawalcovid19.id/v1/api/case/summary');

        $decode = json_decode($response->body(), true);

        $this->assertNotEmpty($decode);
    }
}
