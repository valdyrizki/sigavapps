<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class RekeningResource extends JsonResource
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
            'id' => $this->id,
            'an' => $this->an,
            'norek' => $this->norek,
            'bank' => $this->bank,
            'created_at' => Carbon::parse($this->created_at)->diffForHumans()
        ];
    }
}
