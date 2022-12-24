<?php

    namespace App\Http\Resources\v1;
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
            switch ($this->status){
                case "0":
                    $status='ناموفق';
                    break;
                case "4":
                    $status='موفق';
                    break;
                default:
                    $status='ناموفق';
            }
                    return [
                        'id'=>$this->id,
                        'date' => CalendarUtils::strftime('Y/m/d H:i:s',$this->created_at),
                        'deposit'=>$this->deposit,
                        'description'=>$this->description,
                        'payment_id'=>$this->refId,
                        'bank'=>$this->bank,
                        'status' =>['id'=>intval($this->status),'label'=>$status],
                        'total' => $this->total_current  ,
                    ];

        }
    }
