<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Kasus extends JsonResource
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
            'total_case' => $this->total_case,
            'new_case' => $this->new_case,
            'total_death' => $this->total_death,
            'new_death' => $this->new_death,
            'total_recovered' => $this->total_recovered,
            'new_recovered' => $this->new_recovered,
            'active_case' => $this->active_case,
            'last_update' => $this->created_at->toRfc850String()
        ];
    }
}
