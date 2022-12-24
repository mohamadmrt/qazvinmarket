<?php

    namespace App\Http\Resources\v1;
    use Carbon\Carbon;
    use Illuminate\Http\Resources\Json\JsonResource;

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
            switch ($this->status){
                case "0":
                    $status='ناموفق';
                    break;
                case "4":
                    $status='موفق';
                    break;
                case "5":
                    $status='تحویل شده';
                    break;
                default:
                    $status='ناموفق';
            }
            switch ($this->vote_status){
                case "0":
                    $vote_status='بررسی نشده';
                    break;
                case "4":
                    $vote_status='تایید شده';
                    break;
                case "2":
                    $vote_status='رد شده';
                    break;
                default:
                    $vote_status='بررسی نشده';
            }

            $vote=strlen($this->vote_message)>0?['status'=>true,'message'=>$this->vote_message,'admin_reply'=>$this->vote_admin_replay,'vote_status'=>['id'=>$this->vote_status,'label'=>$vote_status]]:['status'=>false,'message'=>env('APP_URL').'/vote/'.$this->url];
            return [
                'id'=>$this->id,
                'date' => gregorian2jalali($this->created_at),
                'status' => ['id'=>intval($this->status),'label'=>$status],
                'total' => $this->sum_of_cargos_price,
                'bank'=>$this->bank,
                'invoice_amount'=>$this->invoice_amount,
                'cargos'=>$this->cargos,
                'shipping_type'=>$this->type,
                'shipping_price'=>$this->shipping_price,
                'shipping_time'=>$this->verified_at->addMinutes($this->peyk->shippingTime)>Carbon::now()?$this->verified_at->addMinutes($this->peyk->shippingTime)->diffInSeconds(Carbon::now()):0,
                'shipping_time_total'=>$this->peyk->shippingTime*60,
                'can_vote'=>$this->can_vote(),
                'address'=>$this->address,
                'area_name'=>$this->peyk->zones,
                'deliver_time'=>$this->deliver_time,
                'url'=>$this->url,
                'type'=>$this->type,
                'SaleRefId'=>$this->SaleReferenceId,
                'RefId'=>$this->RefId,
                'transaction_message'=>$this->ResCode,
                'username'=>$this->name,
                'tel'=>$this->tel,
                "ResCode"=>$this->ResCode,
                'market_name'=>$this->market->name,
                'vote'=>$vote,


            ];
        }
    }
