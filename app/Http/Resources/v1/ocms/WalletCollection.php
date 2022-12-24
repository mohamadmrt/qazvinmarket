<?php

    namespace App\Http\Resources\v1\ocms;
    use Carbon\Carbon;
    use Illuminate\Http\Resources\Json\JsonResource;
    use Illuminate\Http\Resources\Json\ResourceCollection;
    use Morilog\Jalali\CalendarUtils;
    use Morilog\Jalali\Jalalian;

    class WalletCollection extends JsonResource
    {
        /**
         * Transform the resource into an array.
         *
         * @param  \Illuminate\Http\Request
         * @return array
         */
        public function toArray($request)
        {
            switch ($this->bank){
                case '0':
                    $this->bank='مدیر سیستم';
                    break;
                case '1':
                    $this->bank='ملت '.$this->salerefId;
                    break;
                case '2':
                    $this->bank='هدیه تولد';
                    break;
                case '4':
                    $this->bank='افزایش اعتبار قاصدکی ها';
                    break;
                case '5':
                    $this->bank='خرید '.$this->order_id;
                    break;
                default:
                    $this->bank='نامشخص';
                    break;

            }
            switch ($this->status){
                case '0':
                    $this->status='ناموفق';
                    break;
                case '4':
                    $this->status='موفق';
                    break;
                default:
                    $this->status='نامشخص';
                    break;

            }
                    return [
                        'id'=>$this->id,
                        'username'=>$this->user->username,
                        'deposit'=>$this->deposit,
                        'date' => CalendarUtils::strftime('Y/m/d H:i:s',$this->created_at),
                        'fullname'=>$this->user->name.' '.$this->user->family,
                        'description'=>$this->description,
                        'total_current'=>$this->total_current,
                        'type'=>$this->type=="0"?"برداشت":"واریز",
                        'payment_id'=>$this->refId,
                        'bank'=>$this->bank??'ملت',
                        'status' => $this->status,
                    ];

        }
    }
