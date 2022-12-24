<?php

    namespace App\Http\Resources\v1\ocms;
    use App\Market;
    use Illuminate\Http\Resources\Json\JsonResource;
    use Morilog\Jalali\CalendarUtils;

    class AdvertiseCollection extends JsonResource
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
                'market_name'=>$this->market->name,
                'user_name' => $this->admin->name.' '.$this->admin->family,
                'image'=>env('APP_URL')."/images/adver/".$this->image,
                'title'=>$this->title,
                'status'=>$this->status=='1'?'فعال':'غیر فعال',
                'url'=>$this->url,
                'created_at'=>gregorian2jalali($this->created_at),
                'start_at'=> CalendarUtils::strftime('Y/m/d  H:i:s', $this->start_at),
                'end_at'=> CalendarUtils::strftime('Y/m/d  H:i:s', $this->end_at),
            ];
        }
    }
