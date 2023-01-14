<?php

namespace App\Http\Controllers\api\v1;

use App\Cargo;
use App\Cart;
use App\Coupon;
use App\Events\UserActivation;
use App\Holiday;
use App\Http\Controllers\Controller;
use App\Http\Resources\v1\CargoCollection;
use App\Http\Resources\v1\OrderCollection;
use App\Market;
use App\MarketTime;
use App\Menu;
use App\Order;
use App\Peyk;
use App\Sms;
use App\Token;
use App\User;
use App\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Morilog\Jalali\Jalalian;

class CartController extends Controller
{
    public function TestMrt()
    {

        $cartIds = Cart::pluck('id')->toArray();
        shuffle($cartIds);

        return $cartIds;
//        $cargo_menus = DB::table('cargo_menu')->where('pivot_parent_id', null)->get();
//
//        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
//
//        foreach ($cargo_menus as $item) {
//            $menu = Menu::where('id', $item->menu_id)->first();
//
//            DB::table('cargo_menu')
//                ->where('menu_id',$item->menu_id )->where('cargo_id',$item->cargo_id)
//                ->update(['pivot_parent_id' =>$menu->parent_id]);
//        }


//        $callback_url = env('APP_URL') . '/back/' . 1111111;
//        $params = array(
//            "terminalId" => env('MELLAT_TERMINALID'),
//            "userName" => env('MELLAT_USERNAME'),
//            "userPassword" => env('MELLAT_PASSWORD'),
//            "orderId" => 111111,
//            "amount" => 100000,
//            "localDate" => date("Ymd"),
//            "localTime" => date("His"),
//            "additionalData" => '111111 09300606049',
//            "callBackUrl" => $callback_url,
////                "payerId" => 6042
//        );
//
//        $i = 0;
//        do {
//            $err = $client->getError();
//            $i++;
//        } while (($err) and ($i < 25));


//        $SaleOrderId = 'F8B4660B5355F9D2';
//        $SaleReferenceId = 228559307490;
//        try {
//            $namespace=env('MELLAT_NAMESPACE');
//            $client = @new \SoapClient(env('MELLAT_WSDL'));
//            $parameters = array(
//                "terminalId" => env('MELLAT_TERMINALID'),
//                "userName" => env('MELLAT_USERNAME'),
//                "userPassword" => env('MELLAT_PASSWORD'),
//                'saleOrderId' => $SaleOrderId,
//                'orderId' => $SaleOrderId,
//                'saleReferenceId' => $SaleReferenceId);
//            $verify=$client->bpVerifyRequest($parameters, $namespace)->return;
//
//            return $verify;
//            if ($verify=="0"){
////                $settle=$client->bpSettleRequest($parameters, $namespace)->return;
////                if ($settle=="0"){
//                    return 0;
////                }
//            }
//            return 1;
//        } catch (\Exception $e) {
//            return $e->getMessage();
//        }

//        $cargos = Cargo::sellableCargos()->where('max_count', '!=', 0);
//        $amazings = clone $cargos;
//        $newest = clone $cargos;
//        $amazings_cargo_id = Amazing::select('cargo_id')->where('status','1')->where('start_at' ,'<', Carbon::now())->where('end_at' ,'>', Carbon::now())->orderBy('id', 'DESC')->get();
//        $cargos = array();
//        foreach ($amazings_cargo_id as $item){
//           $cargos[] = Cargo::find($item->cargo_id);
//        }
//        $amazings = CargoCollection::collection($cargos);
//

//        $newest = CargoCollection::collection($newest->where('newest', "1")->inRandomOrder()->take(20)->get());
//        $advertises = Advertise::select('url', 'image', 'title')->where('status', '1')->where('start_at', '<', \Carbon\Carbon::now())->where('end_at', '>', Carbon::now())->get();
//        foreach ($advertises as $advertise) {
//            $advertise->image = env('APP_URL') . "/images/adver/" . $advertise->image;
//        }
//        return response()->json([
//            'data' => [
//                'amazing' => $amazings,
////                'newest' => $newest,
////                'advertises' => $advertises,
//            ],
//            'status' => 'ok'
//        ], 200);
//        $startDate = Carbon::createFromFormat('d/m/Y', '06/11/2022');
//        $endDate = Carbon::createFromFormat('d/m/Y', '09/11/2022');
//
//        $users = User::where('check',0)->whereBetween('id', [87296, 88588])->get();
//        foreach ($users as $user){
//
//            $orders = Order::where('user_id',$user->id)->where('status','4')->get();
//            return $orders;
//       if ($orders){
//           return $orders;
//       }
//        }


//        $blocked_tel = DB::connection('mysql2')->table('blocked_tel')->get();
//        foreach ($blocked_tel as $item){
//            User::where('username',$item->tel)->update(['check'=>1]);
//        }

//        $order = DB::connection('mysql2')->table('order_user_archive')->first();
//        if ($order)
//        return $order;
//        $users = User::where('name','')->get();
//        foreach ($users as $user){
////                $order = Order::where('tel',$user->username)->where('status','4')->get();
//                $order = DB::connection('mysql2')->table('order_user')->where('tel',$user->username)->get();
//              if ($order){
//                  $i = 0 ;
//                  foreach ($order as $item){
//                      if ($i == 0){
//                          $user->name = $item->name;
//                          $user->save();
//                          $i++;
//                      }
//                  }
//              }
//
//        }
//
//        $startDate = Carbon::createFromFormat('d/m/Y', '01/09/2022');
//        $endDate = Carbon::createFromFormat('d/m/Y', '01/11/2022');
//        $orders = Order::select('user_id')->where('status','4')->whereBetween('created_at', [$startDate, $endDate])->groupBy('user_id')->get();
//        foreach ($orders as $order){
//            User::where('id',$order->user_id)->update(['check'=>1]);
//        }

//        $users = User::orderBy('id', 'DESC')->where('check', 0)->get();
//        foreach ($users as $user) {
//            Coupon::create(['market_id' => 1, 'user_id' => $user->id, 'title' => 'کدتخفیف', 'code' => $user->id, 'min_price' => 300000, 'used_count' => 0, 'max_count' => 1, 'max_discount' => 100000, 'discount_type' => 'price', 'discount_amount' => 35000, 'status' => '1', 'start_date' => '2022-11-01 00:00:00', 'end_date' => '2023-11-01 00:00:00']);
//        }


//        $orders0 = Order::select('user_id')->groupBy('user_id')->get();
//        foreach ($orders0 as $item) {
//            $favoriteCargosId = array();
//            $orders = Order::where('user_id', $item['user_id'])->where('status', '4')->get();
//
//            foreach ($orders as $order) {
//                foreach ($order['cargos'] as $item) {
//                    array_push($favoriteCargosId, $item['id']);
//                }
//            }
//            $countFavoriteCargosId = array_count_values($favoriteCargosId);
//            arsort($countFavoriteCargosId);
//            $favoriteCargosId = array_slice(array_keys($countFavoriteCargosId), 0, 20, true);
//
//            foreach ($favoriteCargosId as $item) {
//                $favorite = new Favorite();
//                $favorite->user_id = $order->user_id;
//                $favorite->cargo_id = $item;
//                $favorite->save();
//            }
//        }


//        $orders = Order::all();
//        foreach ($orders as $item) {
//            $cargos = array();
//            foreach ($item->cargos as $item1) {
//                if ($item1['id'] >= 111673) {
//                    $order = DB::connection('mysql2')->table('order')->select(['foodId'])->where('id', $item1['id'])->get();
//                    $item1['id'] = $order[0]->foodId;
//                    array_push($cargos, $item1);
//                }
//            }
//            $item->cargos = $cargos;
//            $item->save();
//        }
    }

    protected function user()
    {
        return auth()->guard('api')->user();
    }

    /**
     * sync cart of user with server and return sellable cargos.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sync_cart(Request $request)
    {
        try {
            $validData = Validator::make($request->all(), [
                'cargos' => 'array',
                'cargos.*.count' => "required|integer|between:1,20",
                'cargos.*.id' => "required|exists:cargos,id",
            ]);
            if ($validData->fails()) {
                return response()->json([
                    'data' => $validData->messages()->all(),
                    'message' => "اطلاعات وارد شده نامعتبر است.",
                    'status' => "invalid"
                ], 422);
            }
            $user = $this->user();
            $request_cargos = fa2en($request->cargos);
            // sync if user is logged in
            if ($request->bearerToken() and $user) {
                if (is_array($request_cargos)) {
                    $db_carts = Cart::where('user_id', $user->id)->get();
                    foreach ($db_carts as $db_cart) {
                        $db_cart->update([
                            'changed' => '0'
                        ]);
                    }
                    foreach ($request_cargos as $request_cargo) {
                        //delete from cart if is not sellable now!
                        $cargo = Cargo::sellableCargos()->where('id', $request_cargo['id'])->first();
                        $db_cart = Cart::where('user_id', $user->id)->where('cargo_id', $request_cargo['id'])->first();
                        if ($cargo) {
                            if ($request_cargo['count'] > $cargo->max_count) {
                                $count = $cargo->max_count;
                            } else if ($request_cargo['count'] > $cargo->max_order) {
                                $count = $cargo->max_order;
                            } else {
                                $count = $request_cargo['count'];
                            }
                            if ($db_cart) {
                                $db_cart->update([
                                    'count' => $count,
                                    'changed' => '1'
                                ]);
                            } else {
                                Cart::create([
                                    'user_id' => $user->id,
                                    'cargo_id' => $cargo->id,
                                    'count' => $count,
                                ]);
                            }
                        } else if ($db_cart and !$cargo) {
                            $db_cart->delete();
                        }
                    }
                    $db_carts_to_delete = Cart::where('user_id', $user->id)->where('changed', '0')->get();
                    foreach ($db_carts_to_delete as $db_cart) {
                        $db_cart->delete();
                    }
                }
                //finally get user synced cart again
                $carts = Cart::where('user_id', $user->id)->get();
                $cargos = collect([]);
                foreach ($carts as $cart) {
                    $cargo = collect(new CargoCollection($cart->cargo));
                    $cargo->put('count', $cart->count);
                    $cargos->push($cargo);
                }
//                    return $user;
                return response()->json([
                    'cart' => $cargos,
                    'status' => 'ok',
                    'message' => 'سبد خرید بروز شد.',
                    'loggedIn' => true
                ]);
                // sync if user is guest
            } else if (is_array($request_cargos)) {
                $cargos = collect([]);
                foreach ($request_cargos as $request_cargo) {
                    $cargo = Cargo::sellableCargos()->where('id', $request_cargo['id'])->first();
                    if ($cargo) {
                        $request_count = (int)$request_cargo['count'];
                        if ($request_count > $cargo->max_count) {
                            $count = $cargo->max_count;
                        } else if ($request_count > $cargo->max_order) {
                            $count = $cargo->max_order;
                        } else {
                            $count = $request_count;
                        }
                        $cargo = collect(new CargoCollection($cargo));
                        $cargo->put('count', $count);
                        $cargos->push($cargo);
                    }
                }
                return response()->json([
                    'cart' => $cargos,
                    'status' => 'ok',
                    'message' => 'سبد خرید بروز شد.',
                    'loggedIn' => false
                ]);
            }
            return response()->json([
                'cart' => [],
                'status' => 'ok',
                'message' => 'no data',
                'loggedIn' => true
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'data' => $e->getMessage(),
                'status' => 'fail',
                'message' => 'خطا در بروزرسانی سبد خرید.',
            ], 422);
        }
    }

    public function add_to_cart(Request $request)
    {
        try {
            $validData = Validator::make($request->all(), [
                'count' => 'required|integer',
                'cargo' => "required|exists:cargos,id",
            ]);
            if ($validData->fails()) {
                return response()->json([
                    'data' => $validData->messages()->all(),
                    'message' => "اطلاعات وارد شده نامعتبر است.",
                    'status' => "invalid"
                ], 422);
            }
            $request_count = fa2en($request->count);
            $request_cargo = fa2en($request->cargo);
            $cargo = Cargo::where('id', $request_cargo)
                ->sellableCargos()
                ->first();
            if ($request_count > $cargo->max_count) {
                return response([
                    "data" => [],
                    "message" => "موجودی کالا کافی نیست",
                    'status' => 'fail'
                ], 422);
            }
            if ($request_count > $cargo->max_order) {
                return response([
                    "data" => [],
                    "message" => "موجودی کالا کافی نیست",
                    'status' => 'fail'
                ], 422);
            }
            $user = $this->user();
            if ($request->bearerToken() and $user) {
                $found_cart = Cart::where('user_id', $user->id)->where('cargo_id', $cargo->id)->first();
                if ($found_cart)
                    $found_cart->delete();
                Cart::create([
                    'user_id' => $user->id,
                    'cargo_id' => $cargo->id,
                    'count' => $request_count,
                ]);
                return response([
                    'data' => new CargoCollection($cargo),
                    'status' => 'ok',
                    'loggedIn' => true,
                ], 200);
            } else {
                return response([
                    'data' => new CargoCollection($cargo),
                    'status' => 'ok',
                    'loggedIn' => false,
                ], 200);
            }
        } catch (\Exception $e) {
            return response([
                "data" => $e->getMessage(),
                'status' => 'fail'
            ], 422);
        }
    }

    public function remove_from_cart(Request $request)
    {
        try {
            $validData = Validator::make($request->all(), [
                'cargo' => "required",
                'count' => "required|integer|between:0,1",
            ]);
            if ($validData->fails()) {
                return response()->json([
                    'data' => $validData->messages()->all(),
                    'message' => "اطلاعات وارد شده نامعتبر است.",
                    'status' => "invalid"
                ], 422);
            }
            $request_cargo = fa2en($request->cargo);
            $request_count = fa2en($request->count);
            $cargo = Cargo::where('id', $request_cargo)
                ->sellableCargos()
                ->first();
            $user = $this->user();
            if ($cargo) {
                if ($request->bearerToken() and $user) {
                    $found_cart = Cart::where('user_id', $user->id)->where('cargo_id', $cargo->id)->first();
                    if ($found_cart) {
                        if ($found_cart->count == 1 or $request_count == 0)
                            $found_cart->delete();
                        else
                            $found_cart->update(['count' => $found_cart->count - 1]);
                    }
                    return response()->json([
                        'data' => new CargoCollection($cargo),
                        'status' => 'ok',
                        'loggedIn' => true,
                    ], 200);
                }
                return response()->json([
                    'data' => new CargoCollection($cargo),
                    'status' => 'ok',
                    'loggedIn' => false,
                ], 200);
            }
            return response()->json([
                'data' => [],
                'status' => 'fail',
                'message' => 'کالا یافت نشد',
                'loggedIn' => false,
            ], 422);
        } catch (\Exception $e) {
            return response([
                "data" => $e->getMessage(),
                'status' => 'fail'
            ], 422);
        }
    }

    public function checkout(Request $request)
    {
        try {
            $validData = Validator::make($request->all(), [
                'peyk_id' => "required|exists:peyks,id",
                'bank' => 'required|integer|between:1,4',
                'sendMethod' => ['required',
                    Rule::in(["express", "verbal", "scheduled"])
                ],
                'cargos' => "required|array",
                'cargos.*.count' => "required|integer|between:1,30",
                'cargos.*.id' => "required|exists:cargos,id",
                'cargos.*.main_price' => "required|integer",
                'tel' => 'required|regex:/(09)[0-9]{9}/',
                'name' => 'min:3',
                'address' => 'required|min:10',
                'comment' => 'nullable|min:10',
                'coupon' => 'nullable|exists:coupons,code',
                'confirm_code' => 'nullable|exists:users,confirm',
                'order' => 'nullable|exists:orders,url'
            ], [
                'name.regex' => 'برای نام فقط از فارسی و بدون اعداد استفاده کنید',
                'comment.min' => 'توضیحات اختیاری است اما نباید از 10 کاراکتر کمتر باشد',
                'comment.max' => 'توضیحات اختیاری است اما نباید از 100 کاراکتر کمتر باشد',
                'comment.regex' => 'برای توضیحات فقط از نام فارسی استفاده کنید',
                'cargos.*.main_price.required' => 'قیمت واحد کالاها را وارد کنید'
            ]);
            if ($validData->fails()) {
                return response()->json([
                    'data' => $validData->messages()->all(),
                    'error' => $validData->messages()->all(),
                    'message' => "اطلاعات وارد شده نامعتبر است.",
                    'status' => "invalid"
                ], 422);
            }
            //mellat=1; wallet=3; cash=4;
            $request_bank = fa2en($request->bank);
            $request_peyk_id = fa2en($request->peyk_id);
            $request_sendMethod = $request->sendMethod;
            $request_cargos = $request->cargos;
            $request_tel = fa2en($request->tel);
            $request_name = fa2en($request->name);
            $request_address = fa2en($request->address);
            $request_comment = fa2en($request->comment);
            $request_coupon = fa2en($request->coupon);
            $request_deliver_time = fa2en($request->deliver_time);
            $request_deliver_day = fa2en($request->deliver_day);
            $request_confirm_code = fa2en($request->confirm_code);
            $request_order_id = fa2en($request->order);
            $request_description = $request->description;
            $cart_changed = false;
            //if user has entered coupon
            $coupon = Coupon::findByCode($request_coupon);
//check if market is in service and is in open time
            $market = get_market(1);
            if ($request_coupon != "") {
                if (!$coupon) {
                    return response()->json([
                        'data' => [],
                        'message' => "کد تخفیف وارد شده معتبر نیست!",
                        'status' => 'fail',
                    ], 422);
                }
            }
            if ($market->service == '0') {
                return response()->json([
                    'data' => [],
                    'message' => "فروشگاه بدلیل " . $market->why_off . " تعطیل است. لطفاً در زمان دیگری مراجعه فرمایید. ",
                    'status' => 'fail'
                ], 422);
            }
            $today = Jalalian::now()->getDayOfWeek();
            $now = Carbon::now()->format('H:i:s');
            $market_time = MarketTime::where('market_id', 1)->where('day', $today)->where('start', '<', $now)->where('end', '>', $now)->first();
            if (!$market_time and $request_sendMethod == "express")
                return response()->json([
                    'data' => [],
                    'message' => "فروشگاه هم اکنون تعطیل است. لطفاً گزینه ارسال در آینده را انتخاب نمایید",
                    'status' => 'fail'
                ], 422);
            $holiday = Holiday::getHoliday(1);
            if ($holiday) {
                $holiday->start = gregorian2jalali($holiday->start);
                $holiday->end = gregorian2jalali($holiday->end);
                return response()->json([
                    'data' => [],
                    'message' => "فروشگاه بدلیل $holiday->why_off تعطیل است. لطفاً گزینه ارسال در آینده را انتخاب نمایید",
                    'status' => 'fail'
                ], 422);
            }
            if ($request->has('confirm_code') and $request_bank == '4') {
                $order = Order::where('url', $request_order_id)->first();
                if ($order) {
                    if ($order->used_coupon !== null) {
                        $coupon = Coupon::findByCode($order->used_coupon);
                        $coupon->used_count += 1;
                        $coupon->save();
                    }
                    $user = User::findByConfirmCode($request_confirm_code);
                    if ($user) {
                        if ($user->status == '2') {
                            return response()->json([
                                'data' => [],
                                'message' => "حساب شما توسط مدیر مسدود شده است",
                                'status' => "fail"
                            ], 422);
                        }
                        if ($user->is_ghasedak == "1" and $market->discount_ghasedak) {
                            $wallet = $user->wallet;
                            $deposit = $market->discount_ghasedak * $order->sum_of_cargos_price / 100;
                            $order->discount_ghasedak = $deposit;
                            $order->save();
                            Wallet::insert($user->id, $order->id, $order->sum_of_cargos_price, $deposit, '1', "4", "4", "افزایش اعتبار برای قاصدکی ها");
                            $user->update([
                                'wallet' => $deposit + $wallet
                            ]);
                        }

                        $token = auth()->guard('api')->login($user);
                        $existing_token = Token::where('user_id', $user->id)->first();
                        $ipg_token = bcrypt($user->id);
                        if ($existing_token)
                            $existing_token->update([
                                'jwt' => $token,
                            ]);
                        else
                            Token::create([
                                'jwt' => $token,
                                'user_id' => $user->id,
                                'ipg_token' => $ipg_token
                            ]);
                        $user->update([
                            'confirm' => 1
                        ]);
                        $order->update([
                            'status' => "4",
                            'valid' => "1"
                        ]);

                        return response()->json([
                            'order' => $order->url,
                            'token' => $token,
                            'status' => 'ok',
                            'action' => 'cash',
                            'message' => 'کد ارسال شده صحیح است.',

                        ]);
                    } else {
                        return response()->json([
                            'data' => array(),
                            'message' => 'کد ارسال شده وارد شده معتبر نیست',
                            'status' => "fail"
                        ], 422);
                    }
                } else {
                    return response()->json([
                        'data' => array(),
                        'message' => 'شناسه سفارش را ارسال کنید',
                        'status' => "fail"
                    ], 422);
                }
            }
            $user = User::findByUsername($request_tel);
            if (!$user) {
                $user = User::create([
                    'username' => $request_tel,
                    'name' => $request_name,
                    'group_id' => 1
                ]);
            } else {
                $user->name = $request_name;
                $user->save();
            }

            if (count($request_cargos) < 1) {
                return response()->json([
                    'status' => 'fail',
                    'data' => [],
                    'message' => 'کالایی ارسال نشده است'
                ]);
            }

            // sync cargos
            $cargos = collect();
            $changed_cargos = collect();
            foreach ($request_cargos as $request_cargo) {
                //delete from cart if is not sellable now!
                $db_cargo = Cargo::sellableCargos()->where('id', $request_cargo['id'])->first();
                if ($db_cargo) {
                    $cargo = collect(new CargoCollection($db_cargo));
                    if ($request_cargo['count'] > $db_cargo->max_count) {
                        $cargo->put('count', $db_cargo->max_count);
                        $cart_changed = true;
                        $changed_cargos->push($cargo);
                    } else if ($request_cargo['count'] > $db_cargo->max_order) {
                        $cargo->put('count', $db_cargo->max_order);
                        $cart_changed = true;
                        $changed_cargos->push($cargo);
                    } else {
                        $cargo->put('count', $request_cargo['count']);
                    }
                    $cargos->push($cargo);
                    if ($request_cargo['main_price'] != $db_cargo->main_price_method)
                        $cart_changed = true;
                } else {
                    $cart_changed = true;
                }
            }
            if ($request->bearerToken() and $user) {
                Cart::where('user_id', $user->id)->delete();
                foreach ($cargos as $cargo) {
                    Cart::create([
                        'user_id' => $user->id,
                        'cargo_id' => $cargo['id'],
                        'count' => $cargo['count']
                    ]);
                }
                $loggedIn = true;
            } else {
                $loggedIn = false;
            }
            if ($cart_changed) {
                return response()->json([
                    'cart' => $cargos,
                    'changed_cargoes' => $changed_cargos,
                    'status' => 'fail',
                    'message' => 'سبد خرید بروز شد.',
                    'loggedIn' => $loggedIn
                ], 422);
            }
            $pre_sum_of_cargos_price = 0;
            foreach ($cargos as $cargo) {
                $pre_sum_of_cargos_price += $cargo['count'] * $cargo['main_price'];
            }

//            $coupon = Coupon::where('user_id',10)->where('code',1)->first();

            //apply coupon if order total price is greater than coupon min_price
            if ($coupon) {
                if ($coupon->min_price < $pre_sum_of_cargos_price) {
                    if ($coupon->discount_type == 'percent') {
                        $sum_of_cargos_price = $pre_sum_of_cargos_price - ($pre_sum_of_cargos_price * $coupon->discount_amount / 100);
                    } else {
                        $sum_of_cargos_price = $pre_sum_of_cargos_price - $coupon->discount_amount;
                    }
                    if ($coupon->max_discount < $pre_sum_of_cargos_price - $sum_of_cargos_price) {
                        $sum_of_cargos_price = $pre_sum_of_cargos_price - $coupon->max_discount;
                    }
                } else {
                    return response()->json([
                        'data' => [],
                        'message' => 'برای استفاده از این کد تخفیف باید حداقل به میزان ' . $coupon->min_price . " تومان خرید کنید.",
                        'status' => 'fail'
                    ], 422);
                }
            } else {
                $sum_of_cargos_price = $pre_sum_of_cargos_price;
            }


            //shipping calculation
            $peyk = Peyk::find($request_peyk_id);
            $shipping_price = 0;
            if ($request_sendMethod == 'express' and $sum_of_cargos_price < $market->incity_express_peykPrice_threshold and $peyk->outOfCity == 0) {
                $shipping_price = $peyk->price;
            } elseif ($peyk->outOfCity == 1) {
                $shipping_price += $peyk->price;
            } elseif ($request_sendMethod == 'scheduled' and $sum_of_cargos_price < $market->incity_scheduled_peykPrice_threshold and $peyk->outOfCity == 0) {
                $shipping_price += $peyk->price;
            }
            $token = auth()->guard('api')->login($user);
            $deliver_timestamp = null;
            if ($request_sendMethod == 'verbal') {
                $deliver_timestamp = Carbon::now()->setHour($request_deliver_time)->startOfHour();
            }
            $order = Order::create([
                'user_id' => $user->id,
                'market_id' => $market->id,
                'comment' => $request_comment,
                'name' => $request_name,
                'tel' => $request_tel,
                'address' => $request_address,
                'description' => $request_description,
                'peyk_id' => $peyk->id,
                'peyk_price' => $shipping_price,
                'peyk_zones' => $peyk->zones,
                'type' => $request_sendMethod,
                'deliver_time' => $request_deliver_day . '-' . $request_deliver_time,
                'deliver_timestamp' => $deliver_timestamp,
                'sum_of_cargos_price' => $sum_of_cargos_price,
                'shipping_price' => $shipping_price,
                'valid' => "1",
                'invoice_amount' => $sum_of_cargos_price + $shipping_price,
                'used_coupon' => $coupon ? $coupon->code : null,
                'discount_type' => $coupon ? $coupon->discount_type : 'none',
                'cargos' => $cargos,
                'verified_at' => Carbon::now(),
                'ip' => $request->ip()
            ]);
            foreach ($cargos as $cargo) {
                $cargo_db = Cargo::where('id', $cargo['id'])->first();
                $cargo_db->max_count = $cargo_db->max_count - $cargo['count'];
                $cargo_db->save();
            }
            $order->update(['url' => 'QM' . \Str::random(3) . $order->id . mt_rand(1000, 9999)]);
//            event(new OrderEvent($order))

            //payment
            //mellat
            if ($request_bank == '1') {
                $ipg_token = bcrypt($user->id);
                $existing_token = Token::where('user_id', $user->id)->first();
                if ($existing_token)
                    $existing_token->update([
                        'jwt' => $token,
                        'ipg_token' => $ipg_token,
                    ]);
                else
                    Token::create([
                        'jwt' => $token,
                        'user_id' => $user->id,
                        'ipg_token' => $ipg_token,
                    ]);
                $order->update([
                    'bank' => "1",
                    'valid' => "1"
                ]);
                $source = "&source=pwa";
                if ($request->hasHeader('source')) {
                    $source = "&source=" . $request->header('source');
                }
                $callback_url = env('APP_URL') . '/back/' . $order->url . "?token=" . $ipg_token . "&t=" . $peyk->shippingTime . $source;
                $res = MellatPay($order, $order->invoice_amount * 10, $callback_url);
                if ($res[0] == 0) {
                    $order->update(['RefId' => $res[1]]);
                    return response([
                        'payment_url' => env('MELLAT_PAYMENT_GATE') . "?RefId=$res[1]&MobileNo=$order->tel",
                        'status' => 'ok',
                        'action' => "mellatPay",
                    ]);
                } else {
                    return response([
                        'data' => [],
                        'message' => 'اتصال به درگاه امکان پذیر نمی باشد',
                        'status' => 'fail',
//                        'token' => $token
                    ], 422);
                }
            } //cash
            elseif ($request_bank == '4') {
                $code = rand(1000, 9000);
                $user->update([
                    'confirm' => $code,
                    'confirm_expire' => Carbon::now()->addMinutes(2)
                ]);
                $message = "قزوین مارکت - کد تایید: " . $user->confirm . "\n\r" . env("ANDROID_SMS_KEY");
                $sms = Sms::insert($order->id, $user->username, $message);
                event(new UserActivation($sms));
                $order->update([
                    'bank' => '4',
                    'valid' => "0"
                ]);
                return response()->json([
                    'data' => 'کد ارسال شده به موبایل را وارد کنید',
                    'status' => 'ok',
                    'order' => $order->url,
                    'action' => 'verify',
                    'confirm_code_life_seconds' => 120,
//                    'token' => $token
                ]);

            } //wallet
            elseif ($request_bank == '3') {
                $order->update([
                    'bank' => "3",
                ]);
                Wallet::insert($user->id, $order->id, $sum_of_cargos_price, $order->invoice_amount, "0", "4", "3", 'خرید با کیف پول');
                $existing_token = Token::where('user_id', $user->id)->first();
                $ipg_token = bcrypt($user->id);
                if ($existing_token)
                    $existing_token->update([
                        'jwt' => $token,
                    ]);
                else
                    Token::create([
                        'jwt' => $token,
                        'user_id' => $user->id,
                        'ipg_token' => $ipg_token
                    ]);
                $wallet = $user->wallet;
                $remain = $wallet - $order->invoice_amount;
                if ($remain >= 0) {
                    $user->update([
                        'wallet' => $remain,
                    ]);
                    $order->update([
                        'bank' => "3",
                        'status' => "4",
                        'valid' => "1"
                    ]);
                    if ($request_coupon != "") {
                        if ($coupon) {
                            $coupon->used_count += 1;
                            $coupon->save();
                        }
                    }
                    if ($user) {
                        $market = Market::find(1);
                        if ($user->is_ghasedak == "1" and $market->discount_ghasedak) {
                            $wallet = $user->wallet;
                            $deposit = $market->discount_ghasedak * $sum_of_cargos_price / 100;
                            $order->discount_ghasedak = $deposit;
                            $order->save();
                            Wallet::insert($user->id, $order->id, $sum_of_cargos_price, $deposit, '1', "4", "4", "افزایش اعتبار برای قاصدکی ها");
                            $user->update([
                                'wallet' => $deposit + $wallet
                            ]);
                        }
                    }
                    Sms::sendSmsSupporters(1, $order->id);
                    Sms::sendSmsSuccessOrder($order->id);
                    return response([
                        'order' => $order->url,
                        'message' => 'پرداخت با موفقیت انجام شد.',
                        'status' => 'ok',
                        'action' => "wallet",
                    ]);
                } else {
                    return response([
                        'data' => [],
                        'message' => 'موجودی کیف پول شما کافی نیست',
                        'status' => 'fail'
                    ], 422);
                }
            } else {
                return response()->json([
                    'data' => [],
                    'message' => 'روش پرداخت را بدرستی انتخاب کنید',
                    'status' => 'fail'
                ], 422);
            }
        } catch (\Exception $e) {
            return response([
                'data' => [],
                'message' => $e->getMessage(),
                'status' => 'fail'
            ], 422);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Cart $cart
     * @return \Illuminate\Http\Response
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Cart $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    public function is_delayed(Order $order)
    {
        try {
            if ($order->delayed == "1") {
                return response([
                    'data' => [],
                    'message' => "درخواست شما قبلاً ارسال شده است!",
                    'status' => 'duplicate'
                ]);
            }
            $market = Market::find(1);
            $order->update([
                'delayed' => "1",
                "is_delayed_timestamp" => Carbon::now()
            ]);
            foreach ($market->delay_support as $support) {
                Sms::create([
                    'order_id' => $order->id,
                    'to' => $support,
                    'text' => "تاخیر در ارسال: " . $order->id,
                ]);
            }
            return response([
                'data' => [],
                'message' => "درخواست شما ثبت شد! لطفاً منتظر پاسخ باشید",
                'status' => 'ok'
            ]);
        } catch (\Exception $e) {
            return response([
                'data' => [],
                'message' => $e->getMessage(),
                'status' => 'fail'
            ]);
        }
    }

    public function vote(Order $order)
    {
        try {
            $user = User::where('id', $order->user_id)->first();
            $market = get_market(1);
            if ($order->user_id == $user->id) {
                $username = strlen($user->name) > 3 ? $user->name : 'کاربر';
                $dissatisfaction_items = DB::table('dissatisfaction_items')->get();
                $message = $order->status == '4' ? 'سفارش شما در حال پردازش می باشد' : 'سفارش شما تایید نشد. در صورت کسر وجه و عدم برگشت طی 72 ساعت، لطفا با پشتیبانی تماس حاصل فرمایید.';
                return response([
                    'order' => new OrderCollection($order),
                    'user' => $username,
                    'market' => $market->only('name'),
                    'dissatisfaction_items' => $dissatisfaction_items,
                    'status' => 'ok',
                    'message' => $message
                ]);
            }
            return response([
                'status' => 'ok',
                'message' => 'شما اجازه نظر درباره این سفارش را ندارید!'
            ], 422);
        } catch (\Exception $e) {
            return response([
                'data' => [],
                'message' => $e->getMessage(),
                'status' => 'fail'
            ], 422);
        }
    }

    public function set_vote(Order $order, Request $request)
    {
        try {
            $validData = Validator::make($request->all(), [
                'market_rating' => 'required|integer|between:1,3',
                'bads' => "array",
                'cargos' => "required|array",
                'cargos.*.id' => "required|exists:cargos,id",
                'cargos.*.count' => "required|integer|between:0,20",
                'cargos.*.rate' => "required|integer|between:1,5",
                'message' => "required|min:3|max:100",
                'is_private' => "required|boolean",
            ], [
                'is_private.boolean' => "آیا پیام خصوصی است فقط میتواند مقدار منطقی 0 یا 1 داشته باشد"
            ]);
            if ($validData->fails()) {
                return response()->json([
                    'data' => $validData->messages()->all(),
                    'message' => "اطلاعات وارد شده نامعتبر است.",
                    'status' => "invalid"
                ], 422);
            }
            if ($order->status != '4' and $order->vote_status == null) {
                return response()->json([
                    'message' => "امکان ثبت نظر فقط برای خریدهای موفق امکانپذیر است.",
                    'status' => "invalid"
                ], 422);
            }
            $request_market_rating = (int)$request->market_rating;
            $request_bads = $request->bads;
            $request_cargos = $request->cargos;
            $request_message = $request->message;
            $request_is_private = $request->is_private ? '1' : '0';
            if ($request_market_rating == 3)
                $bads = $request_bads;
            else
                $bads = [];
            foreach ($request_cargos as $request_cargo) {
                if ((int)$request_cargo['rate'] <= 0)
                    $voted_cargo_rate = 2.5;
                else
                    $voted_cargo_rate = (int)$request_cargo['rate'];
                $cargo = Cargo::find((int)$request_cargo['id']);
                $cargo->vote_average = ($cargo->vote_count * $cargo->vote_average + $voted_cargo_rate) / ($cargo->vote_count + 1);
                $cargo->vote_count = $cargo->vote_count + 1;
                $cargo->save();
            }
            $order->update([
                'vote_rate' => (int)$request_market_rating,
                'vote_message' => $request_message,
                'vote_private' => $request_is_private,
                'vote_bads' => $bads,
                'vote_status' => '0',
            ]);
            return response([
                'data' => [],
                'message' => 'نظر شما با موفقیت دریافت شد!',
                'status' => 'ok'
            ]);
        } catch (\Exception $e) {
            return response([
                'data' => [],
                'message' => $e->getMessage(),
                'status' => 'fail'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {
            $user = $this->user();
            if ($user) {
                Cart::where('user_id', $user->id)->delete();
                return response([
                    'data' => [],
                    'status' => 'ok'
                ]);
            }
            return response([
                'data' => [],
                'status' => 'ok'
            ]);
        } catch (\Exception $e) {
            return response([
                'data' => [],
                'message' => $e->getMessage(),
                'status' => 'fail'
            ]);
        }
    }
}
