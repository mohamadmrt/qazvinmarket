<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class   FactorLog extends Model
{
    protected $guarded=[];
    public $timestamps = false;
    protected $dates=[
        'created_at'
    ];
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_at = $model->freshTimestamp();
        });
    }
    static public function insert($order_id,$countRunWS,$response_login,$response_getPeople,$response_getAddress,$response_createNewOrder){
        FactorLog::create([
            'order_id' => $order_id,
            'countRunWS' => $countRunWS,
            'response_login' => $response_login,
            'response_getPeople' => $response_getPeople,
            'response_getAddress' => $response_getAddress,
            'response_createNewOrder' => $response_createNewOrder,
            'created_at'=>Carbon::now()
        ]);
    }

}
