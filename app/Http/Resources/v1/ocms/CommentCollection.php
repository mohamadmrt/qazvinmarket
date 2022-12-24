<?php

    namespace App\Http\Resources\v1\ocms;
    use Carbon\Carbon;
    use Illuminate\Http\Resources\Json\JsonResource;
    use Illuminate\Http\Resources\Json\ResourceCollection;
    use Morilog\Jalali\CalendarUtils;
    use Morilog\Jalali\Jalalian;

    class CommentCollection extends JsonResource
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
                    $this->status='بررسی نشده';
                    break;
                case "1":
                    $this->status='تایید نشده';
                    break;
                case "4":
                    $this->status='تایید شده';
                    break;
            }

            return [
                'id'=>$this->id,
                'fullname'=>$this->user->name,
                'text'=>$this->text,
                'username'=>$this->user->username,
                'private'=>$this->private,
                'market_name'=>$this->market->name,
                'status'=>$this->status,
                'admin_reply'=>$this->admin_reply,
                'replied_at'=>gregorian2jalali($this->replied_at),
                'created_at'=>gregorian2jalali($this->created_at),
                'user_wallet'=>$this->user->wallet,
                'cargos'=>$this->order->cargos
            ];

        }
    }
