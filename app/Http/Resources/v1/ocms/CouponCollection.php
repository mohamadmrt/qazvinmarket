<?php

    namespace App\Http\Resources\v1\ocms;
    use App\Market;
    use App\Order;
    use Carbon\Carbon;
    use Illuminate\Http\Resources\Json\JsonResource;
    use Illuminate\Http\Resources\Json\ResourceCollection;
    use Morilog\Jalali\CalendarUtils;
    use Morilog\Jalali\Jalalian;

    class CouponCollection extends JsonResource
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
                'code'=>$this->code,
                'min_price'=>$this->min_price,
                'discount_amount'=>$this->discount_amount,
                'max_count'=>$this->max_count,
                'used_count'=>$this->used_count,
                'max_discount'=>$this->max_discount,
                'discount_type'=>$this->discount_type=='percent'?'درصد':'مبلغ',
                'start_date'=>CalendarUtils::strftime('Y/m/d  H:i:s', $this->start_date),
                'end_date'=>CalendarUtils::strftime('Y/m/d  H:i:s',$this->end_date),
                'status'=>$this->status=="1"?'فعال':'غیر فعال',
                'created_at'=>gregorian2jalali($this->created_at),
            ];
        }
    }
