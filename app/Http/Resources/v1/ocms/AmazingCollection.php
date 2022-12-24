<?php

    namespace App\Http\Resources\v1\ocms;
    use App\Market;
    use Carbon\Carbon;
    use Illuminate\Http\Resources\Json\JsonResource;
    use Illuminate\Http\Resources\Json\ResourceCollection;
    use Morilog\Jalali\CalendarUtils;
    use Morilog\Jalali\Jalalian;

    class AmazingCollection extends JsonResource
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
                'market_name'=>$this->market->name,
                'name' => $this->cargo->name,
                'image'=>file_exists(public_path().'/images/imagefood/'.$market->folder_name.'/'.$this->cargo_id.'.'.$this->cargo->file_format)?env('APP_URL').'/images/imagefood/'.$market->folder_name.'/'.$this->cargo_id.'.'.$this->cargo->file_format:"",
                'price'=>$this->price,
                'price_discount'=>$this->price_discount,
                'bazara_UnitName'=>$this->cargo->bazara_UnitName,
                'max_count'=>$this->cargo->max_count,
                'max_order'=>$this->cargo->max_order,
                'menus'=>$this->cargo->menus,
                'status'=>$this->cargo->status,
                'cargo_id'=>$this->cargo->id,
                'newest'=>$this->cargo->newest,
                'start_at'=> CalendarUtils::strftime('Y/m/d  H:i:s', $this->start_at),
                'end_at'=> CalendarUtils::strftime('Y/m/d  H:i:s', $this->end_at),
                'created_at'=>gregorian2jalali($this->created_at),
            ];
        }
    }
