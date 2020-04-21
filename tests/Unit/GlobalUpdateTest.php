<?php

namespace Tests\Unit;

use App\Services\GlobalUpdate as ServicesGlobalUpdate;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GlobalUpdateTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    /** @test */
    public function test_availability_endpoint_global_api()
    {
        // $global = new ServicesGlobalUpdate();
        $url = config('corona.global_api_url');
        // $url = config('corona.source_url');
        $get = Http::get($url);
        if ($get->ok()) {
            $this->assertTrue(true);
        } else {
            $this->assertTrue(false);
        }
    }

    public function test_something()
    {
        $global = new ServicesGlobalUpdate();
        if ($global->testing()) {
            $this->assertTrue(true);
        }
    }
}
