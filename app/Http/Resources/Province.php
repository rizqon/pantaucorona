<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Province extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            $this->resource['fid'] => [
                'province' => $this->resource['provinsi'],
                'confirmed' => $this->resource['positif'],
                'recovered' => $this->resource['sembuh'],
                'death' => $this->resource['meninggal']
            ]
        ];
    }
}
