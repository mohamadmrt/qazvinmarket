<?php

    namespace App\Http\Resources\v1\ocms;
    use App\Market;
    use Illuminate\Http\Resources\Json\JsonResource;
    use Morilog\Jalali\CalendarUtils;

    class CargoCollection extends JsonResource
    {
        /**
         * Transform the resource into an array.
         *
         * @param  \Illuminate\Http\Request
         * @return array
         */
        public function toArray($request)
        {
            $market=Market::find(1);
            return [
                'id'=>$this->id,
                'name' => $this->name,
                'image'=>file_exists(public_path().'/images/imagefood/'.$market->folder_name.'/'.$this->id.'.'.$this->file_format)?env('APP_URL').'/images/imagefood/'.$market->folder_name.'/'.$this->id.'.'.$this->file_format.'?v='.$this->image_version:"",
                'price'=>$this->price,
                'price_discount'=>$this->price_discount,
                'description'=>$this->description,
                'bazara_UnitName'=>$this->bazara_UnitName,
                'max_count'=>$this->max_count,
                'buy_count'=>$this->buy_count,
                'vote_average'=>$this->vote_average,
                'vote_count'=>$this->vote_count,
                'max_order'=>$this->max_order,
                'menus'=>$this->menus,
                'status'=>$this->status,
                'newest'=>$this->newest,
                'mfg_date'=>$this->manufacturing_date === null ? '' : CalendarUtils::strftime('Y/m/d  H:i:s', $this->manufacturing_date),
                'exp_date'=>$this->expiry_date === null ? '' : CalendarUtils::strftime('Y/m/d  H:i:s', $this->expiry_date),
                'mfg_date_show'=>$this->mfg_date_show,
                'exp_date_show'=>$this->exp_date_show
            ];
        }
    }
