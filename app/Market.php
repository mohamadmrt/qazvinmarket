<?php

namespace App;

use App\Casts\Json;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Market extends Authenticatable
{
    protected $guarded=[];
    protected $casts=[
        'support'=>'array',
        'delay_support'=>'array',
        'ipg'=>Json::class,
        'order_mobiles'=>'array',
        'tel'=>'array'

    ];

    public function menus()
    {
        return $this->hasMany(Menu::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function holidays(){
        return $this->hasMany(Holiday::class);
    }
}
