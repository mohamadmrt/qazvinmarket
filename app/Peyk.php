<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Peyk extends Model
{
    protected $guarded=[];

    public function market()
    {
        return $this->belongsTo(Market::class);
    }

}
