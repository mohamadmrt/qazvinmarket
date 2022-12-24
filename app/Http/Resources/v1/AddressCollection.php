<?php

namespace App\Http\Resources\v1;

use App\Cargo;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressCollection extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
                return [
                    'id'=>$this->id,
                    'label' => $this->label,
                    'address' => $this->address,
                    'zones'=>$this->peyk->zones,
                    'peyk_id'=>$this->peyk->id,
                    'is_default'=>$this->is_default==='1'
        ];
    }
}
