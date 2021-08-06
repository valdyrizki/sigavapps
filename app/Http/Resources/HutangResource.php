<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class HutangResource extends JsonResource
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
            'nama' => $this->nama,
            'deskripsi' => $this->deskripsi,
            'jumlah' => formatRupiah($this->jumlah),
            'status' => getStsHutang($this->status),
            'tanggal' => Carbon::parse($this->created_at)->format("Y-m-d H:i:s")
        ];
    }
}
