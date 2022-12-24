<?php

namespace App;

use App\Casts\Json;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Morilog\Jalali\CalendarUtils;
use Morilog\Jalali\jDateTime;

class Report extends Model
{
    public function scopeSearch($query, $keywords)
    {
        $from_date = fa2en($keywords['search_by_start_date']);
        $to_date = fa2en($keywords['search_by_end_date']);


        if ($from_date != '') {
            $from_date = CalendarUtils::createCarbonFromFormat('Y/m/d', $from_date);
        } else {
            $from_date = Carbon::createFromFormat('Y/m/d', '2000/01/01');
        }
        if ($to_date != '') {
            $to_date = CalendarUtils::createCarbonFromFormat('Y/m/d', $to_date)->endOfDay();
        } else {
            $to_date = Carbon::now()->format('Y/m/d H:i:s');
        }


        $query
            ->whereBetween('created_at', [$from_date, $to_date]);
        return $query;
    }

}