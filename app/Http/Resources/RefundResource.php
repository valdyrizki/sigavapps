<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class RefundResource extends JsonResource
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
            'nama_produk' => $this->nama_produk,
            'jumlah' => $this->jumlah,
            'deskripsi_refund' => $this->deskripsi_refund,
            'created_at' => Carbon::parse($this->created_at)->diffForHumans()
        ];
    }
}
