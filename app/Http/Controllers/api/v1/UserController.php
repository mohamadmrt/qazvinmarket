<?php

namespace App\Http\Controllers\Api\v1;
use App\Address;
use App\Cargo;
use App\Cart;
use App\Coupon;
use App\Events\UserActivation;
use App\Favorite;
use App\Http\Controllers\Controller;
use App\Http\Resources\v1\AddressCollection;
use App\Http\Resources\v1\CargoCollection;
use App\Http\Resources\v1\OrderCollection;
use App\Http\Resources\v1\TransactionCollection;
use App\Http\Resources\v1\UserResource;
use App\Order;
use App\Sms;
use App\Token;
use App\User;
use App\Wallet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Morilog\Jalali\CalendarUtils;
use Morilog\Jalali\Jalalian;


class UserController extends Controller
{
    protected function user(){
        return auth()->guard('api')->user();
    }
    public function register(Request $request)
    {
        try {
            $validData = Validator::make($request->all(), [
                'username' => 'required|regex:/(09)[0-9]{9}/',
            ]);
            if ($validData->fails()){
                return response()->json([
                    'data'=>$validData->messages()->all(),
                    'message'=>"اطلاعات وارد شده نامعتبر است.",
                    'status'=>"invalid"
                ],422);
            }
            $request_username=fa2en($request->username);
            $user=User::findByUsername($request_username);
            $code=rand(1111,9999);
            if ($user){
                if ($user->status=='2'){
                    return response()->json([
                        'data'=>[],
                        'message'=>"حساب شما توسط مدیر مسدود شده است",
                    ],422);
                }
                $user->confirm=$code;
                $user->confirm_expire=Carbon::now()->addMinutes(2);
                $user->password=bcrypt($code);
                $user->save();
            }else {
                $user = User::create([
                    'username' => $request_username,
                    'confirm' =>$code ,
                    'confirm_expire' =>Carbon::now()->addMinutes(2) ,
                    'password'=>bcrypt($code),
                ]);
            }
            $sms=Sms::insert(0,$user->username,"قزوین مارکت - کد تایید: ".$user->confirm."\n\r".env("ANDROID_SMS_KEY"));
            event(new UserActivation($sms));
            return response()->json([
                'data'=>"sms sent to mobile",
                'expires'=>$user->confirm_expire->format('Y/m/d H:i:s'),
                'status'=>'ok'
            ],200);
        }catch (\Exception $e){
            return response()->json([
                'data'=>[],
                'message'=>$e->getMessage(),
                'status'=>'fail'
            ]);
        }}

    public function verify_activation_code(Request $request)
    {

        $data=$request->all();
        if (array_key_exists('addresses',$data))
            if (is_array($data['addresses'])){
                foreach ($data['addresses'] as $key=>$ad){
                    $data['addresses'][$key]['is_default']=filter_var($data['addresses'][$key]['is_default'],FILTER_VALIDATE_BOOLEAN);
                }
            }
        $request->confirm_code=fa2en($request->confirm_code);

        $validData = Validator::make($data, [
//            'confirm_code' => 'required|digits:4|exists:users,confirm',
            'username'=>'required|digits:11',
            'addresses'=>'array',
            'addresses.*.peyk_id'=>"required|exists:peyks,id",
            'addresses.*.address'=>"required|min:10",
            'addresses.*.is_default'=>"required|boolean",
            'addresses.*.label'=>"required|min:3",
        ]);
        if ($validData->fails()){
            return response()->json([
                'data'=>$validData->messages()->all(),
                'message'=>"اطلاعات وارد شده نامعتبر است.",
                'status'=>"invalid"
            ],422);
        }
        $request_confirm_code=fa2en($request->confirm_code);
        $request_firebase_token=$request->firebase_token;
        $request_addresses=$request->addresses;
        $user=User::findByConfirmCode($request_confirm_code);
        if ($user){
            if ($user->status=='2'){
                return response()->json([
                    'data'=>[],
                    'message'=>"حساب شما توسط مدیر مسدود شده است",
                    'status'=>"fail"
                ],422);
            }

            $token=auth()->guard('api')->login($user);
            $ipg_token = bcrypt($user->id);
            $existing_token=Token::where('user_id',$user->id)->first();
            if ($existing_token)
                $existing_token->update([
                    'jwt'=>$token,
                ]);
            else
                Token::create([
                    'jwt'=>$token,
                    'user_id'=>$user->id,
                    'ipg_token' => $ipg_token
                ]);

            if ($request_firebase_token)
                $user->firebase_token = $request_firebase_token;

            if ($request->has('orderId')){
                $order = Order::where('url',$request->orderId)->first();
                $order->status = '4';
                $order->valid = '1';
                $order->save();
                foreach ($order['cargos'] as $item) {
                    $cargo = Cargo::find($item['id']);
                    $cargo->buy_count = $cargo->buy_count + $item['count'];
                    $cargo->save();
                }
                Sms::sendSmsSupporters(1,$order->id);
                Sms::sendSmsSuccessOrder($order->id);
                if ($order->used_coupon !== null) {
                    $coupon = Coupon::findByCode($order->used_coupon);
                    $coupon->used_count += 1;
                    $coupon->save();
                }
            }

            $existing_addresses=Address::where('user_id',$user->id);

            $favorites_array=array();
            $favorites=Favorite::where('user_id',$user->id)->with('cargos')->get();
            $orders=Order::select('user_id','id','created_at','sum_of_cargos_price')->where('user_id',$user->id)->latest()->get();

            if (!$existing_addresses->count()){
                if ($request->has('addresses')){
                    if (count($request_addresses)){
                        $existing_addresses->delete();
                        $local_storage_addresses=$request_addresses;
                        foreach ($local_storage_addresses as $local_storage_addresse){
                            if ((int)$local_storage_addresse['id'] ==0){
                                Address::create([
                                    'user_id'=>$user->id,
                                    'peyk_id'=>(int)$local_storage_addresse['peyk_id'],
                                    'label'=>$local_storage_addresse['label'],
                                    'address'=>$local_storage_addresse['address'],
                                    'is_default'=>$local_storage_addresse['is_default'],
                                ]);
                            }
                        }
                    }
                }
            }
            if($request->has('cart')){
                foreach ($request->cart as $item){
                    $cart = Cart::where('user_id',$user->id)->where('cargo_id',$item['id'])->first();
                    if ($cart){
                        $cart->update(['count' => $cart->count + $item['count']]);
                    }else{
                        Cart::create(['user_id' => $user->id, 'cargo_id'=>$item['id'],'count'=>$item['count'],'changed'=>'0']);
                    }
                }
            }
            $addresses=Address::where('user_id',$user->id)->get();
            $cart = Cart::where('user_id', $user->id)->get();
            $cargos = collect([]);

            if ($cart->count()>0){
                foreach ($cart as $item) {
                    $cargo = collect(new CargoCollection($item->cargo));
                    $cargo->put('count', $item->count);
                    $cargos->push($cargo);
                }
            }

            $user->confirm=1;
            $user->save();

            return response()->json([
                'data'=>[
                    "token"=>$token,
                    "bearer"=>"Bearer",
                    "wallet"=>$user->wallet,
                    "birthday"=>$user->birthday> "1920-05-12"?CalendarUtils::strftime('Y-m-d',strtotime($user->birthday)):null,
                    "points"=>$user->point,
                    'username'=>$user->name,
                    'mobile'=>$user->username,
                    'addresses'=>AddressCollection::collection($addresses),
                    'orders'=>$orders,
                    'pfavorites'=>$favorites,
                    "orderCount"=>$orders->count(),
                    "transactionCount"=>$orders->count(),
                    'cart'=>$cargos
                ],
                'status'=>"ok"
            ],200);
        }
        return response()->json([
            'data'=>array(),
            'message'=>'کد وارد شده معتبر نیست',
            'status'=>"fail"
        ],422);
    }

    public function profile()
    {
        try {
            $user=new UserResource(User::with('addresses')->with('orders')->find(auth()->guard('api')->user()->id));
            return response()->json([
                'user'=>$user,
                'status'=>'ok',
            ],200);

        }catch (\Exception $e){
            return response([
                'data'=>$e->getMessage(),
                'status'=>'fail'
            ],422);
        }
    }

    public function orderList(Request $requesشt)
    {
        try{
            $user=$this->user();
            $orders=Order::where('user_id',$user->id)->latest()->paginate(10);
            return response([
                'order_list'=>OrderCollection::collection($orders),
                'paginate'=>[
                    'total' => $orders->total(),
                    'count' => $orders->count(),
                    'per_page' => $orders->perPage(),
                    'current_page' => $orders->currentPage(),
                    'last_page' => $orders->lastPage()
                ],
                'status'=>'ok'
            ]);
        }catch(\Exception $e){
            return response([
                'data'=>[],
                'message'=>$e->getMessage(),
                'status'=>'fail'
            ]);
        }
    }
    public function total_transactions(Request $request)
    {
        try{
            $user=$this->user();
            $transactions=collect();
            $orders=Order::where('user_id',$user->id)->get();
            foreach ($orders as $order){
                $item=collect();
                switch ($order->status){
                    case "0":
                        $status='ناموفق';
                        break;
                    case "4":
                        $status='موفق';
                        break;
                    case "5":
                        $status='تحویل شده';
                        break;
                    default:
                        $status='ناموفق';
                }
                switch ($order->bank){
                    case "1":
                        $order_bank='ملت';
                        break;
                    case "4":
                        $order_bank='نقدی';
                        break;
                    case "3":
                        $order_bank='کیف پول';
                        break;
                    default:
                        $order_bank='نامشخص';
                }
                $item->put('price',$order->invoice_amount);
                $item->put('type','خرید');
                $item->put('date',$order->payment_timestamp==null?gregorian2jalali_without_seconds(Carbon::now()->format('Y/m/d H:i')):gregorian2jalali_without_seconds($order->payment_timestamp));
                $item->put('SaleReferenceId',$order->SaleReferenceId);
                $item->put('status',['id'=>intval($order->status),'label'=>$status]);
                $item->put('bank',$order_bank);
                $item->put('created_at',$order->created_at->format('Y/m/d H:i:s'));
                $transactions->push($item);
            }
            $wallets=Wallet::where('user_id',$user->id)->get();
            foreach ($wallets as $wallet){
                $item=collect();
                switch ($order->status){
                    case "0":
                        $status='ناموفق';
                        break;
                    case "4":
                        $status='موفق';
                        break;
                    case "5":
                        $status='تحویل شده';
                        break;
                    default:
                        $status='ناموفق';
                }
                switch ($wallet->bank){
                    case '0':
                        $wallet_bank='مدیر سیستم';
                        break;
                    case '1':
                        $wallet_bank='ملت ';
                        break;
                    case '2':
                        $wallet_bank='هدیه تولد';
                        break;
                    case '4':
                        $wallet_bank='افزایش اعتبار قاصدکی ها';
                        break;
                    case '5':
                        $wallet_bank='خرید ';
                        break;
                    default:
                        $wallet_bank='نامشخص';
                        break;
                }

                $item->put('price',$wallet->deposit);
                $item->put('type','کیف پول');
                $item->put('date',$wallet->payment_timestamp==null?gregorian2jalali_without_seconds(Carbon::now()->format('Y/m/d H:i')):gregorian2jalali_without_seconds($order->payment_timestamp));
                $item->put('SaleReferenceId',$wallet->salerefId);
                $item->put('status',['id'=>intval($wallet->status),'label'=>$status]);
                $item->put('bank',$wallet_bank);
                $item->put('created_at',$wallet->created_at?$wallet->created_at->format('Y/m/d H:i:s'):'2000/01/01 00:00:00');
                $transactions->push($item);
            }
            $transactions->sortBy('created_at');
            $transactions=$transactions->paginate(20);
            return response()->json([
                'transactions'=>$transactions->values(),
                'paginate'=>[
                    'total' => $transactions->total(),
                    'count' => $transactions->count(),
                    'per_page' => $transactions->perPage(),
                    'current_page' => $transactions->currentPage(),
                    'last_page' => $transactions->lastPage()
                ],
                'status'=>'ok'
            ]);
        }catch(\Exception $e){
            return response([
                'transactions'=>[],
                'message'=>$e->getMessage(),
                'status'=>'fail'
            ]);
        }
    }

    public function update_user_info(Request $request)
    {
        try {
            $validData = Validator::make($request->all(), [
                'name' => 'string',
                'birthday'=>'string',
            ]);
            if ($validData->fails()){
                return response()->json([
                    'data'=>$validData->messages()->all(),
                    'message'=>"اطلاعات وارد شده نامعتبر است.",
                    'status'=>"invalid"
                ],422);
            }
            $user=$this->user();
            $request_name=fa2en($request->name);
            $request_birthday=fa2en($request->birthday);
            $dates=explode('/',$request_birthday);
            $is_jalali= CalendarUtils::checkDate($dates[0],  $dates[1], $dates[2], true);
            if (
                $dates[0]>Jalalian::now()->subYears(5)->getYear() or !$is_jalali
            ){
                return response()->json([
                    'data'=>[],
                    'message'=>'فرمت تاریخ تولد باید YYYY/MM/DD و شمسی باشد و سن بیشتر از 5 سال باشد!',
                    'status'=>'ok'
                ],422);
            }
            $user->name=$request_name;
            $user->birthday=CalendarUtils::createCarbonFromFormat('Y/m/d',$request_birthday);
            $user->save();
            return response()->json([
                'data'=>[
                    'name'=>$user->name,
                    'birthday'=>$user->birthday > "1920-05-12" ? CalendarUtils::strftime('Y/m/d', $user->birthday) : null,
                ],
                'message'=>'اطلاعات با موفقیت ویرایش شد!',
                'status'=>'ok'
            ],200);
        }catch (\Exception $e){
            return response([
                'data'=>$e->getMessage(),
                'status'=>'fail'
            ],422);
        }
    }

    public function logout()
    {
        try {
            auth()->guard('api')->logout();
            return response()->json([
                'data' => [],
                'message'=>'کاربر با موفقیت خارج شد.',
                'status' => 'ok'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 'fail'
            ], 422);
        }
    }
}
