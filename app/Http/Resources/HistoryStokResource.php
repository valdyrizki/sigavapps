<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class HistoryStokResource extends JsonResource
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
            'nama_produk' => $this->nama_produk,
            'add_stok' => $this->add_stok,
            'before' => $this->before,
            'after' => $this->after,
            'description' => $this->description
        ];
    }
}
