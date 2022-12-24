<?php

    namespace App;

    use App\Http\Controllers\Functions\FunctionController;
    use Carbon\Carbon;
    use Illuminate\Database\Eloquent\Model;
    use Morilog\Jalali\CalendarUtils;

    class Comment extends Model
    {
        protected $guarded=[];

        protected $dates=['replied_at'];
        public function scopeSearch($query , $keywords)
        {
            $from_date = fa2en($keywords['search_by_from_date']);
            $to_date = fa2en($keywords['search_by_to_date']);
            $created_at = fa2en($keywords['search_by_created_at']);
            $search_by_admin_reply_date = fa2en($keywords['search_by_admin_reply_date']);

            if ($from_date != '') {
                $from_date = CalendarUtils::createCarbonFromFormat('Y/m/d', $from_date);
            } else {
                $from_date = Carbon::createFromFormat('Y/m/d', '2010/01/01');
            }
            if ($to_date != '') {
                $to_date = CalendarUtils::createCarbonFromFormat('Y/m/d', $to_date)->endOfDay();
            } else {
                $to_date = Carbon::now()->format('Y/m/d H:i:s');
            }
            $search_by_user_name=$keywords['search_by_user_name'];
            $search_by_user_tel=$keywords['search_by_user_tel'];
            $search_by_market_name=$keywords['search_by_market_name'];

            $query
                ->where('id' , 'LIKE' , '%' . $keywords['search_by_id'] . '%')
                ->where('text' , 'LIKE' , '%' . $keywords['search_by_text'] . '%')
                ->where('status' , 'LIKE' , '%' . $keywords['search_by_status'] . '%')
                ->where('admin_reply' , 'LIKE' , '%' . $keywords['search_by_admin_reply'] . '%')
                ->whereBetween('created_at' ,[$from_date,$to_date])
                ->whereHas('user' , function ($query) use ($search_by_user_name){
                    $query->where('name' , 'LIKE' , '%' . $search_by_user_name . '%' );})
                ->whereHas('user' , function ($query) use ($search_by_user_tel){
                    $query->where('username' , 'LIKE' , $search_by_user_tel . '%' );})
                ->whereHas('market' , function ($query) use ($search_by_market_name){
                    $query->where('id' , 'LIKE' , $search_by_market_name . '%' );})
            ;
            return $query;
        }
        public function user()
        {
            return $this->belongsTo(User::class);
        }
        public function market()
        {
            return $this->belongsTo(Market::class);
        }
        public function order()
        {
            return $this->belongsTo(Order::class);
        }
    }
