<?php

namespace Tests\Unit;

use App\Services\GlobalUpdate as ServicesGlobalUpdate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GlobalUpdateTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic unit test example.
     *
     * @test
     * 
     * @return void
     */
    /** @test */
    public function availability_endpoint_global_api()
    {
        $url = 'https://covid19.mathdro.id/api/countries/Indonesia/confirmed';
        $result = Http::get($url);
        $this->assertJson($result);
    }

    public function test_something()
    {
        $global = new ServicesGlobalUpdate();
        if ($global->testing()) {
            $this->assertTrue(true);
        }
    }
}
