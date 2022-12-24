<?php

namespace App;

use App\Casts\Json;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Morilog\Jalali\CalendarUtils;
use Morilog\Jalali\jDateTime;

class Order extends Model
{
    protected $guarded = [];
    protected $dates = [
        'verified_at',
        'deliver_timestamp',
        'payment_timestamp',
        'is_delayed_timestamp',
        'delay_response_timestamp',
        'confirm',
        'time_lock'
    ];
    protected $casts = [
        'cargos' => Json::class,
        'bads' => 'array'
    ];

    static public function orderofUser($tel)
    {
        return Order::where('tel', $tel)->where('market_id',1)->where('valid', '1')->where('status', '4')->count();
    }


    public function scopeSearch($query, $keywords)
    {
        $from_date = fa2en($keywords['search_by_start_date']);
        $to_date = fa2en($keywords['search_by_end_date']);
        $search_by_porder_date = fa2en($keywords['search_by_porder_date']);
        $search_by_is_delayed = fa2en($keywords['search_by_is_delayed']);

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

        $search_by_user_name = $keywords['search_by_user_name'];
        $search_by_area = $keywords['search_by_area'];
        if ($keywords['search_by_is_confirmed'] == '')
            $search_by_is_confirmed = ">=";
        elseif ($keywords['search_by_is_confirmed'] == "1")
            $search_by_is_confirmed = ">";
        else
            $search_by_is_confirmed = "=";
        $query
//            ->where('ResCode', 0)
            ->whereHas('user', function ($query) use ($search_by_user_name) {
                $query->where('name', 'LIKE', '%' . $search_by_user_name . '%');
            })
            ->whereHas('peyk', function ($query) use ($search_by_area) {
                $query->where('name', 'LIKE', '%' . $search_by_area . '%');
            })
            ->where('id', 'LIKE', '%' . $keywords['search_by_id'] . '%')
            ->whereBetween('created_at', [$from_date, $to_date])
//            ->whereDate('created_at' ,'>',$from_date)
//            ->whereDate('created_at' ,'<',$to_date)
            ->where('tel', 'LIKE', '%' . $keywords['search_by_user_tel'] . '%')
            ->where('address', 'LIKE', '%' . $keywords['search_by_address'] . '%')
            ->where('bank', 'LIKE', '%' . $keywords['search_by_bank'] . '%')
            ->where('market_id', 'LIKE', '%' . $keywords['search_by_market'] . '%')
            ->where('peyk_name', 'LIKE', '%' . $keywords['search_by_peyk_name'] . '%')
            ->where('type', 'LIKE', '%' . $keywords['search_by_type'] . '%')
            ->where('printed', 'LIKE', '%' . $keywords['search_by_printed'] . '%')
            ->where('sum_of_cargos_price', 'LIKE', $keywords['search_by_amount'] . '%')
            ->where('delayed', 'LIKE', '%' . $search_by_is_delayed . '%')
            ->whereDate('confirm', $search_by_is_confirmed, new Carbon('2000-01-01 00:00:00'));
        return $query;
    }

    public function can_vote()
    {
        return ($this->vote_status == null and ($this->status == '4' or $this->status == '5'));
    }

    public function market()
    {
        return $this->belongsTo(Market::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function peyk()
    {
        return $this->belongsTo(Peyk::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->where('status', '=', "1");
    }
}
