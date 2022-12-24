<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
   protected $guarded=[];

    public function user()
    {
        return $this->belongsTo(User::class);
   }
}
