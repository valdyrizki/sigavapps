<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class PengeluaranResource extends JsonResource
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
            'created_at' => $this->created_at->format('d-m-Y - H:i:s'),
            'deskripsi_transaksi' => $this->deskripsi_transaksi,
            'nama' => $this->category_name,
            'total_harga' => "Rp ".formatRupiah($this->total_harga)
        ];
    }
}
