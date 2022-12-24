<?php

    namespace App;

    use Carbon\Carbon;
    use Illuminate\Database\Eloquent\Model;
    use Morilog\Jalali\CalendarUtils;

    class Wallet extends Model
    {
        protected $guarded=[];
        protected $casts=[
            'date'=>'timestamp'
        ];
        public function scopeSearch($query , $keywords)
        {
            $from_date = fa2en($keywords['search_by_from_date']);
            $to_date = fa2en($keywords['search_by_to_date']);
            if ($from_date != ''){
                $from_date=CalendarUtils::createCarbonFromFormat('Y/m/d',$from_date);
            }else{
                $from_date=Carbon::createFromFormat('Y/m/d','2000/01/01');
            }
            if ($to_date != ''){
                $to_date=CalendarUtils::createCarbonFromFormat('Y/m/d',$to_date)->endOfDay();
            }else{
                $to_date=Carbon::now()->format('Y/m/d H:i:s');
            }
            $search_by_username= $keywords['search_by_username'];
            $search_by_name= $keywords['search_by_name'];
            $query
                ->whereBetween('created_at' ,[$from_date,$to_date])
                ->where('id' , 'LIKE' , $keywords['search_by_id'] . '%')
                ->whereHas('user' , function ($query) use ($search_by_username){
                    $query->where('username' , 'LIKE' , '%' . $search_by_username . '%' );})
                ->whereHas('user' , function ($query) use ($search_by_name){
                    $query->where('name' , 'LIKE' , '%' . $search_by_name . '%' );})
                ->where('deposit' , 'LIKE' , $keywords['search_by_deposit'] . '%')
                ->where('type' , 'LIKE' , $keywords['search_by_type'] . '%')
                ->where('bank' , 'LIKE' , $keywords['search_by_bank'] . '%')
                ->where('total_current' , 'LIKE' , $keywords['search_by_total_current'] . '%')
                ->where('status' , 'LIKE' , $keywords['search_by_status'] . '%')
            ;
            return $query;
        }

        static public function insert($user_id,$order_id,$amount,$deposit,$type ,$status,$bank,$description){
            $last_wallet=User::find($user_id)->wallet;
            if ( $type=='1'){
                $last_price=$last_wallet+$deposit;
            }else{
                $last_price=$last_wallet-$deposit;
            }
            return self::create([
                'user_id' => $user_id,
                'order_id' => $order_id,
                'market_id'=>1,
                'order_total_price' => $amount,
                'total_current' => $last_price,
                'deposit' => $deposit,
                'type' => $type,
                'status' => $status,
                'bank' => $bank,
                'description' => $description,
            ]);
        }
        public function user()
        {
            return $this->belongsTo(User::class);
        }
    }
