<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Advertise extends Model
{
    protected $guarded=[];
    public function market(){
        return $this->belongsTo(Market::class);
    }
    public function admin(){
        return $this->belongsTo(Admin::class);
    }
}
