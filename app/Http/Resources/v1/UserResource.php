<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;
use Morilog\Jalali\CalendarUtils;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $wallets_count = $this->wallets != null ? $this->wallets->count() : 0;
        $orders_count = $this->orders != null ? $this->orders->count() : 0;

        return [
            'username' => $this->username,
            'fullname' => $this->name,
            'addresses' => AddressCollection::collection($this->addresses),
            'orders' => OrderCollection::collection($this->orders),
            'birthday' => $this->birthday > "1920-05-12" ? CalendarUtils::strftime('Y/m/d', $this->birthday) : null,
            'wallet' => $this->wallet,
            'total_transactions' => $wallets_count + $orders_count
        ];
    }
}
