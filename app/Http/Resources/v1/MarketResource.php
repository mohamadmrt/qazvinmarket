<?php

    namespace App\Http\Resources\v1;

    use App\Holiday;
    use App\Market;
    use App\MarketTime;
    use Carbon\Carbon;
    use Illuminate\Http\Resources\Json\JsonResource;
    use Mobile_Detect;
    use Morilog\Jalali\CalendarUtils;
    use Morilog\Jalali\Jalalian;

    class MarketResource extends JsonResource
    {
        /**
         * Transform the resource into an array.
         *
         * @param  \Illuminate\Http\Request
         * @return array
         */
        public function toArray($request)
        {
            $detect = new Mobile_Detect;
            $service=1;
            $why_off='';
            $open_time=null;
            $close_time=null;
            $holiday=Holiday::getHoliday(1);
            //market is closed
            if ($this->service=='0'){
                $service=0;
                $why_off=$this->why_off;
                //we have active holiday
            }else if ($holiday){
                $holiday->start=CalendarUtils::strftime('Y/m/d H:i',$holiday->start_gregorian);
                $holiday->end=CalendarUtils::strftime('Y/m/d H:i',$holiday->end_gregorian);
            }else{
                $today=Jalalian::now()->getDayOfWeek();
                $open_time=MarketTime::where('market_id',1)->where('day',$today)->orderBy('start')->first();
                $close_time=MarketTime::where('market_id',1)->where('day',$today)->orderBy('end','Desc')->first();
                if ($open_time){
                    $open_time=date('H:i',strtotime($open_time->start));
                    $close_time=date('H:i',strtotime($close_time->end));
                }else{
                    $holiday=new \stdClass();
                    $holiday->start=CalendarUtils::strftime('Y/m/d H:i:s',Carbon::now()->startOfDay());
                    $holiday->end=CalendarUtils::strftime('Y/m/d H:i:s',Carbon::now()->endOfDay());
                    $holiday->why_off='تعطیلی فروشگاه';
                }
            }


            return [
                'about' => $this->aboutUs_description,
                'address' => $this->address,
                'tel' => $this->tel,
                'post_code' => $this->post_code,
                'mail' => $this->email,
                'terms' => $this->terms,
                'about' => $this->about_us,
                'payment_methods'=>[
                    'cash'=>$this->cash=='1',
                    'ipg'=>true,
                    'wallet'=>true
                ],
                'shipping_methods'=>[
                    'express'=>$this->express=='1',
                    'scheduled'=>$this->scheduled=='1',
                    'verbal'=>$this->verbal=='1'
                ],
                'open_time'=>$open_time,
                'close_time'=>$close_time,
                'min_price_to_free_shipping'=>$this->incity_express_peykPrice_threshold,
                'percent_of_free_shipping'=>$this->incity_express_peykPrice_percent,
                'min_price_to_free_shipping_scheduled'=>$this->incity_scheduled_peykPrice_threshold,
                'percent_of_free_shipping_scheduled'=>$this->incity_scheduled_peykPrice_percent,
                'holiday'=>$holiday??false,
                'priceUnit'=>'تومان',
                'is_mobile'=>$detect->isMobile(),
                'service'=>$service,
                'why_off'=>$why_off
            ];
        }
    }
