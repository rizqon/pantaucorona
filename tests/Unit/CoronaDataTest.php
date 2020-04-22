<?php

namespace Tests\Unit;

use App\Kasus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

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
}
