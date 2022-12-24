<?php

    namespace App;

    use App\Http\Controllers\Functions\FunctionController;
    use Carbon\Carbon;
    use Illuminate\Contracts\Auth\MustVerifyEmail;
    use Illuminate\Foundation\Auth\User as Authenticatable;
    use Illuminate\Notifications\Notifiable;
    use Morilog\Jalali\CalendarUtils;
    use Tymon\JWTAuth\Contracts\JWTSubject;

    class User extends Authenticatable implements JWTSubject
    {
        use Notifiable;

        /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        protected $guarded = [
//        'name', 'email', 'password',
        ];

        /**
         * The attributes that should be hidden for arrays.
         *
         * @var array
         */
        protected $hidden = [
            'password', 'remember_token',
        ];

        /**
         * The attributes that should be cast to native types.
         *
         * @var array
         */
        protected $casts = [
            'email_verified_at' => 'datetime',
            'confirm_expire' => 'datetime',
            'birthday' => 'date',
        ];
        public function scopeSearch($query , $keywords)
        {
//            $from_date = '';
//            $from_date = fa2en($keywords['search_by_start_date']);
//            $to_date = '';
//            $to_date = fa2en($keywords['search_by_end_date']);
//            if ($from_date != ''){
//                $from_date=CalendarUtils::createCarbonFromFormat('Y/m/d',$from_date);
//            }else{
//                $from_date=Carbon::now()->format('Y/m/d H:i:s');
//            }
//            if ($to_date != ''){
//                $to_date=CalendarUtils::createCarbonFromFormat('Y/m/d',$to_date)->endOfDay();
//            }else{
//                $to_date=Carbon::now()->format('Y/m/d H:i:s');
//            }
            $query
//                ->whereBetween('created_at' ,[$from_date,$to_date])
                ->where('id' , 'LIKE' , $keywords['search_by_id'] . '%')
                ->where('username' , 'LIKE' , '%' . $keywords['search_by_username'] . '%')
                ->where('name' , 'LIKE' , '%' . $keywords['search_by_name'] . '%')
                ->where('wallet' , 'LIKE' , $keywords['search_by_wallet'] . '%')
                ->where('point' , 'LIKE' , $keywords['search_by_point'] . '%')
            ;
            return $query;
        }
        public static function findByUsername($username){
            return User::where('username',$username)->first();
        }
        public static function findByConfirmCode($confirm){
            return User::where('confirm',$confirm)->whereDate('confirm_expire','>=',Carbon::now())->first();
        }
        static public function getForRegister($phone){
            return User::where('username',$phone)->orderBy('id','ASC')->first();
        }
        static public function getByUserName($username){
            return User::where('username',$username)->first();
        }
        static public function setPassForRegister($id,$pass2){
            User::where('id',$id)->update([
                'password' => $pass2
            ]);
            return 1;
        }

        public function addresses()
        {
            return $this->hasMany(Address::class);
        }
        public function orders()
        {
            return $this->hasMany(Order::class);
        }
        public function menus()
        {
            return $this->hasMany(Menu::class);
        }

        public function favorites()
        {
            return $this->hasMany(Favorite::class);
        }
        static public function getUsersByUserName($username){
            return User::where('username',$username)->get();
        }
        public function points()
        {
            return $this->hasMany(Point::class);
        }

        public function getJWTIdentifier()
        {
            return $this->getKey();
        }

        public function tokens()
        {
            return $this->hasMany(Token::class);
        }

        public function getJWTCustomClaims()
        {
            return [];
        }

        public function group()
        {
            return $this->belongsTo(Group::class);
        }
    }
