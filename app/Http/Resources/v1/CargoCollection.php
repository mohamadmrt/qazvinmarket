<?php

    namespace App\Http\Resources\v1;

    use App\Amazing;
    use App\Cargo;
    use Illuminate\Http\Resources\Json\JsonResource;

    class CargoCollection extends JsonResource
    {
        /**
         * Transform the resource into an array.
         *
         * @param  \Illuminate\Http\Request
         * @return array
         */
        public function toArray($request)
        {
            $is_favorite=false;
            if ($request->bearerToken()){
                    $user=auth()->guard('api')->user();
                    if ($user) {
                        $user_favorites=$user->favorites;
                        if ($user_favorites->contains('cargo_id',$this->id)){
                            $is_favorite=true;
                        }
                    }
            }
            return [
                'id'=>$this->id,
                'name' => $this->name,
                'description' => $this->description,
                'max_count'=>$this->max_count,
                'image'=>Cargo::getLogo($this->id),
                'price'=>$this->price,
                'mfg_date_show'=>$this->mfg_date_show,
                'exp_date_show'=>$this->exp_date_show,
                'manufacturing_date'=>$this->manufacturing_date,
                'expiry_date'=>$this->expiry_date,
                'main_price'=>$this->main_price_method,
                'is_favorite'=>$is_favorite,
                'saleOff'=>$this->is_amazing()?round(100*($this->price-Amazing::where('cargo_id',$this->id)->first()->price_discount)/$this->price,1):round(100*($this->price-$this->price_discount)/$this->price,1),

            ];
        }
    }
