<?php

namespace App\Http\Controllers\Api;

use App\Kasus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\KasusCollection;
use App\Http\Resources\Kasus as KasusResource;

class KasusController extends Controller
{
    public function daily()
    {
        $kasus = Kasus::latest()->first();
        
        return new KasusResource($kasus);
    }

    public function stream()
    {
        $sub = Kasus::selectRaw('MAX(created_at)');
        $kasus = Kasus::whereRaw("created_at IN ({$sub->toSql()} GROUP BY Date(created_at) )")
                        ->orderBy('created_at', 'desc')
                        ->whereDate('created_at', '>', Carbon::now()->subDays(30))
                        ->get();

        return new KasusCollection($kasus);
    }
}
