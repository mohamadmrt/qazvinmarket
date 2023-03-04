<?php

    namespace App\Http\Resources\v1\ocms;
    use App\Coupon;
    use App\Market;
    use App\Order;
    use Carbon\Carbon;
    use Illuminate\Http\Resources\Json\JsonResource;
    use Illuminate\Http\Resources\Json\ResourceCollection;
    use Morilog\Jalali\CalendarUtils;
    use Morilog\Jalali\Jalalian;

    class OrderCollection extends JsonResource
    {
        /**
         * Transform the resource into an array.
         *
         * @param  \Illuminate\Http\Request
         * @return array
         */
        public function toArray($request)
        {
            switch ($this->type){
                case('express'):
                    $this->type='سریع';
                    break;
                case('scheduled'):
                    $this->type='زمانبندی';
                    break;
                case('verbal'):
                    $this->type='حضوری';
                    break;
                default:
                    $this->type='نا مشخص';
            }
            //mellat=1; wallet=2; cash=4;
//            switch ($this->bank){
//                case('1'):
//                    $this->bank='ملت';
//                    break;
//                case('2'):
//                    $this->bank='کیف پول';
//                    break;
//                    case('4'):
//                    $this->bank='نقدی';
//                    break;
//                default:
//                    $this->bank='نامشخص';
//            }
            return [
                'id'=>$this->id,
                'is_confirm'=>gregorian2jalali($this->confirm),
                'gathering'=>$this->gathering,
                'delayed' => $this->delayed=='1',
//                'is_lated' => $this->confirm!=null?abs($this->confirm->diffInMinutes($this->created_at))/60>20:false,
                'created_at'=>gregorian2jalali($this->created_at),
                'comment'=>$this->comment,
                'deliver_timestamp'=>gregorian2jalali($this->deliver_timestamp),
                'buy_count' => Order::orderofUser($this->tel),
                'amount' =>$this->type_discount=="3"? ($this->Amount-($this->Amount_customer*10))/10:($this->Amount-($this->discount_ghasedak*10))/10,
                'status'=>$this->status,
                'peyk_price'=>$this->peyk_price,
                'market_name'=>$this->market->name,
                'market_tel'=>$this->market->tel,
                'market_mobile'=>$this->market->mobile,
                'name'=>$this->name,
                'tel'=>$this->tel,
                'peyk_zones'=>$this->peyk_zones,
                'peyk_name'=>$this->peyk_name,
                'address'=>$this->address,
                'description'=>$this->description,
                'peyk_price'=>$this->peyk_price,
                'sum_of_cargos_price'=>$this->sum_of_cargos_price,
                'discount_ghasedak'=>$this->discount_ghasedak,
                'bank'=>$this->bank,
                'os'=>$this->os,
                'type'=>$this->type,
                'deliver_time'=>$this->deliver_time,
                'printed'=>$this->printed,
                'porder_date'=>$this->porder_date,
                'porder_time'=>$this->porder_time,
                'user_wallet'=>$this->user->wallet,
                'valid'=>$this->valid,
                'user_isQasedak'=>$this->user->isQasedak,
                'cargos'=>$this->cargos,
                'user_id'=>$this->user_id,
                'coupon'=>Coupon::findByCode($this->used_coupon)
            ];
        }
    }
