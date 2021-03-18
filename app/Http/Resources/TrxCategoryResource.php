<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class TrxCategoryResource extends JsonResource
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
            'category_name' => $this->category_name,
            'description' => $this->description,
            'type' => getTypeTrx($this->type),
            'status' => getStsMemberName($this->status),
            'created_at' => Carbon::parse($this->created_at)->diffForHumans()
        ];
    }
}
