<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class HistoryProdukResource extends JsonResource
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
            'harga_modal_before' => formatRupiah($this->harga_modal_before),
            'harga_modal_after' => formatRupiah($this->harga_modal_after),
            'harga_jual_before' => formatRupiah($this->harga_jual_before),
            'harga_jual_after' => formatRupiah($this->harga_jual_after),
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d H:i:s')
        ];
    }
}
