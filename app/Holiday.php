<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    protected $guarded=[];
    protected $dates=[
        'start_gregorian',
        'end_gregorian'
    ];
    //home
    static public function getHoliday($market_id){
        return Holiday::where('market_id',$market_id)->where('start_gregorian','<',Carbon::now())->where('end_gregorian','>',Carbon::now())->where('status',"1")->first(['start_gregorian','end_gregorian','why_off']);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
