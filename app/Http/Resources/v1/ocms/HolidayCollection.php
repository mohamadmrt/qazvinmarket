<?php

    namespace App\Http\Resources\v1\ocms;
    use App\Admin;
    use App\Market;
    use Illuminate\Http\Resources\Json\JsonResource;
    use Morilog\Jalali\CalendarUtils;

    class HolidayCollection extends JsonResource
    {
        /**
         * Transform the resource into an array.
         *
         * @param  \Illuminate\Http\Request
         * @return array
         */
        public function toArray($request)
        {
            $adminName = Admin::where('id',$this->user_id)->select('username')->get();
            return [
                'id'=>$this->id,
                'user_name' => $adminName[0]["username"],
                'start'=>CalendarUtils::strftime('Y/m/d  H:i:s',$this->start_gregorian),
                'end'=>CalendarUtils::strftime('Y/m/d  H:i:s',$this->end_gregorian),
                'why_off'=>$this->why_off,
                'status'=>$this->status,
                'created_at'=>CalendarUtils::strftime('Y/m/d  H:i:s',$this->created_at),
            ];
        }
    }
