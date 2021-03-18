<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ProdukResource extends JsonResource
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
            'id_produk' => $this->id,
            'nama_produk' => $this->nama_produk,
            'kategori' => $this->category_name,
            'stok' => $this->stok,
            'harga_modal' => "Rp ".formatRupiah($this->harga_modal),
            'harga_jual' => "Rp ".formatRupiah($this->harga_jual),
            'distributor' => $this->distributor,
            'deskripsi' => $this->deskripsi,
            'status' => getStsMemberName($this->status),
            'created_at' => Carbon::parse($this->created_at)->diffForHumans()
        ];  
    }
}
