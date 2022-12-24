<?php

    namespace App;

    use Illuminate\Database\Eloquent\Model;

    class Amazing extends Model
    {
        protected $guarded=[];
        public function cargo()
        {
            return $this->belongsTo(Cargo::class);
        }
        public function market()
        {
            return $this->belongsTo(Market::class);
        }
    }
