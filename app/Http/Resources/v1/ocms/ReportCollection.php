<?php

namespace App\Http\Resources\v1\ocms;
use App\Market;
use Illuminate\Http\Resources\Json\JsonResource;
use Morilog\Jalali\CalendarUtils;

class ReportCollection extends JsonResource
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
            'sum'=>$this->sum,
            'tedad'=>$this->tedad,
            'created_at'=>CalendarUtils::strftime('l %d %B،%Y',$this->created_at)
        ];
    }
}
