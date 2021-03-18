<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class MemberResource extends JsonResource
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
            'no_hp' => $this->no_hp,
            'norek' => $this->norek,
            'bank' => $this->bank,
            'deskripsi' => $this->deskripsi,
            'status' => getStsMemberName($this->status),
            'created_at' => Carbon::parse($this->created_at)->diffForHumans()
        ];
    }
}
