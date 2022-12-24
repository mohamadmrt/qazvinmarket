<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cart extends Model
{
    protected $guarded=[];
    static public function getByUserId($user_id){
        return Cart::where('user_id',$user_id)->get();
    }
    static public function insert($user_id,$product_id,$count)
    {
        Cart::create([
            'user_id' => $user_id,
            'cargo_id' => $product_id,
            'count' => $count,
        ]);
    }

    public function cargo()
    {
        return $this->belongsTo(Cargo::class);
   }

}
