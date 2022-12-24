<?php

    namespace App\Http\Resources\v1\ocms;
    use App\Market;
    use Illuminate\Http\Resources\Json\JsonResource;
    use Morilog\Jalali\CalendarUtils;
    use Morilog\Jalali\Jalalian;

    class MenuCollection extends JsonResource
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
                'image'=>env('APP_URL').'/images/imagefood/'.$market->folder_name.'/'.$this->id.'.jpg',
                'price'=>$this->price,
                'cargos_count'=>$this->cargos_count,
                'main_group_childs_count'=>$this->main_group_childs_count,
                'status'=>$this->status,
                'sub_menu'=>$this->sub_menu
            ];

        }
    }
