<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class JasaTFResource extends JsonResource
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
            'created_at' => Carbon::parse($this->created_at)->diffForHumans(),
            'id' => $this->id,
            'norek' => $this->norek." (".$this->bank.")",
            'an' => $this->an,
            'jumlah' => formatRupiah($this->jumlah),
            'biaya' => formatRupiah($this->biaya)
        ];
    }
}
