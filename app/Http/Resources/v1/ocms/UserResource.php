<?php

namespace App\Http\Resources\v1\ocms;

use App\Http\Resources\v1\AddressCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Morilog\Jalali\CalendarUtils;

class UserResource extends JsonResource
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
            'id' => $this->id,
            'username' => $this->username,
            'name'=>$this->name,
            'birthday'=>$this->birthday > "1920-05-12"?CalendarUtils::strftime('Y/m/d', $this->birthday):null,
            'wallet'=>$this->wallet,
            'point'=>$this->point,
            'status'=>$this->status,
            'group_name'=>$this->group->title,
            'coupon_name'=>$this->group->coupon==null?'':$this->group->coupon->title,
            'addresses'=>AddressCollection::collection($this->addresses),
            'orders'=>OrderCollection::collection($this->orders),
        ];
    }
}
