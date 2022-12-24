<?php

    namespace App\Http\Resources\v1\ocms;
    use App\Market;
    use Illuminate\Http\Resources\Json\JsonResource;
    use Morilog\Jalali\CalendarUtils;
    use Morilog\Jalali\Jalalian;

    class PeykCollection extends JsonResource
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
                'market_name' => $this->market->name,
                'price'=>$this->price,
                'zones'=>$this->zones,
                'outOfCity'=>$this->outOfCity==='1'?'بله':'خیر',
                'shippingTime'=>$this->shippingTime,
                'status'=>$this->status==='0'?'غیر فعال':'فعال',
                'courier'=>$this->courier,
                'created_at'=>gregorian2jalali($this->created_at)
            ];

        }
    }
