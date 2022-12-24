<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Morilog\Jalali\CalendarUtils;

class Coupon extends Model
{
    protected $dates = [
        'start_date',
        'end_date'
    ];
    protected $guarded=[];

    public function scopeSearch($query,$keywords){
        $from_date = fa2en($keywords['search_by_start_at']);
        $to_date = fa2en($keywords['search_by_end_at']);
        $created_at = fa2en($keywords['search_by_created_at']);

        if ($from_date != ''){
            $from_date_start=CalendarUtils::createCarbonFromFormat('Y/m/d',$from_date)->startOfDay();
            $from_date_end=CalendarUtils::createCarbonFromFormat('Y/m/d',$from_date)->endOfDay();
        }else{
            $from_date_start=Carbon::createFromFormat('Y/m/d','2000/01/01');
            $from_date_end=Carbon::createFromFormat('Y/m/d','3000/01/01');
        }
        if ($to_date != ''){
            $to_date_start=CalendarUtils::createCarbonFromFormat('Y/m/d',$to_date)->startOfDay();
            $to_date_end=CalendarUtils::createCarbonFromFormat('Y/m/d',$to_date)->endOfDay();
        }else{
            $to_date_start=Carbon::createFromFormat('Y/m/d','2000/01/01');
            $to_date_end=Carbon::createFromFormat('Y/m/d','3000/01/01');
        }
        if ($created_at != ''){
            $created_at_start=CalendarUtils::createCarbonFromFormat('Y/m/d',$created_at)->startOfDay();
            $created_at_end=CalendarUtils::createCarbonFromFormat('Y/m/d',$created_at)->endOfDay();
        }else{
            $created_at_start=Carbon::createFromTimestamp('2000/01/01 00:00:00');
            $created_at_end=Carbon::now();
        }

        $query
            ->where('market_id',1)
            ->whereBetween('created_at',[$created_at_start,$created_at_end])
            ->whereBetween('start_date' ,[$from_date_start,$from_date_end])
            ->whereBetween('end_date' ,[$to_date_start,$to_date_end])
            ->where('id' , 'LIKE' , $keywords['search_by_id'] . '%')
            ->where('title' , 'LIKE' , '%'.$keywords['search_by_title'] . '%')
            ->where('code' , 'LIKE' , '%'.$keywords['search_by_code'] . '%')
            ->where('min_price' , 'LIKE' , $keywords['search_by_min_price'] . '%')
            ->where('min_price' , 'LIKE' , $keywords['search_by_min_price'] . '%')
            ->where('discount_amount' , 'LIKE' , $keywords['search_by_discount_amount'] . '%')
            ->where('discount_type' , 'LIKE' , $keywords['search_by_discount_type'] . '%')
            ->where('max_count' , 'LIKE' , $keywords['search_by_max_count'] . '%')
            ->where('used_count' , 'LIKE' , $keywords['search_by_used_count'] . '%')
            ->where('max_discount' , 'LIKE' , $keywords['search_by_max_discount'] . '%')
            ->where('status' , 'LIKE' , $keywords['search_by_status'] . '%')

            ;
        return $query;
    }
public static function findByCode($coupon){
    if ($coupon!==null)
    return self::where('code',$coupon)->whereNotNull('code')->first();
    else
        return null;
}

    public static function validate($coupon)
    {
        $response=new \stdClass();
        $response->valid=true;
        $response->message="کد تخفیف با موفقیت اعمال شد";
        if (
        ($coupon->start_date>Carbon::now() or $coupon->end_date<Carbon::now())
        or
        ($coupon->used_count>=$coupon->max_count)
            or
        ($coupon->status=='0')
        ){
            $response->valid=false;
            $response->message="کد وارد شده معتبر نیست";
        }
        return $response;

}
}
