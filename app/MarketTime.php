<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Self_;

class MarketTime extends Model
{
    protected $guarded=[];
    static public function getByDay($day,$start,$end){
        return self::where('market_id',1)->where('day',$day)->where('start',$start)->where('end',$end)->first();
    }
    //home

    static public function getForMenu($date,$day){
        return self::where('market_id',1)->where('start','<',$date)->where('end','>',$date)->where('day',$day)->get();
    }
}
