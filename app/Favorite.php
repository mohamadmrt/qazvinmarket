<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $guarded=[];

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function cargos()
    {
        return $this->belongsTo(Cargo::class,'cargo_id','id')->select('id','name','price_discount');
    }
}
