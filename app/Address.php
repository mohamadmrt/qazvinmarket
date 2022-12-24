<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $dates=[
        'last_used'
    ];
    protected $guarded=[];
    //home
    static public function getByDefault($id){
        return Address::where('user_id',$id)->where('is_default',1)->first();
    }

    public function peyk()
    {
        return $this->belongsTo(Peyk::class);
    }
}
