<?php

    namespace App\Http\Resources\v1\ocms;
    use App\Market;
    use App\Order;
    use Carbon\Carbon;
    use Illuminate\Http\Resources\Json\JsonResource;
    use Illuminate\Http\Resources\Json\ResourceCollection;
    use Morilog\Jalali\CalendarUtils;
    use Morilog\Jalali\Jalalian;

    class GroupCollection extends JsonResource
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
                'title'=>$this->title,
                'status'=>$this->status=="1"?'فعال':'غیر فعال',
                'coupon'=>$this->coupon->title,
                'coupon_id'=>$this->coupon->id,
                'created_at'=>gregorian2jalali($this->created_at),
            ];
        }
    }
