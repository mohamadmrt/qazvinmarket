<?php

namespace App\Http\Controllers\Admin;

use App\City;
use App\Holiday;
use App\Http\Controllers\Admin\Auth\AdminController;
use App\Http\Controllers\Functions\FunctionController;
use App\Http\Controllers\Functions\session;
use App\Http\Requests\Admin\ResturantRequest;
use App\Market;
use App\MarketTime;
use App\Order;
use App\Peyk;
use App\ResturantLog;
use App\SMS;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Morilog\Jalali\CalendarUtils;

class MarketController extends AdminController
{


    public function active_market(Request $request)
    {
        try {
            $id = fa2en($request->id);
            $market = get_market($id);
            if ($market->service == '1') {
                $market->update([
                    'service' => '0'
                ]);
            } else {
                $market->update([
                    'service' => '1'
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
            ], 422);
        }
    }

    public function get_markets()
    {
        try {
            $markets = Market::select('id', 'name')->get();
            $peyk_names = Peyk::select('courier')->groupBy('courier')->get();
            return response([
                'markets' => $markets,
                'peyk_names' => $peyk_names,
                'status' => 'ok'
            ]);
        } catch (\Exception $e) {
            return response([
                'data' => $e->getMessage(),
                'status' => 'fail'
            ], 422);
        }

    }


    public function setting()
    {
        return view('ocms.setting');
    }

    public function settingData(Market $market)
    {
        try {
            return response()->json([
                'data' => $market,
                'status' => 'ok'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'data' => $e->getMessage(),
                'status' => 'fail'
            ], 422);
        }
    }

    public function changeTel(Request $request)
    {
        $tel = fa2en($request->tel);
        $market = Market::find(1);
        $state = false;
        //10008566

        if ($tel == '3000') {
            $market->update([
                'sms_number' => '30005088'
            ]);
            $state = true;
        } elseif ($tel == '2000') {
            $market->update([
                'sms_number' => '20008580'
            ]);
            $state = true;
        } elseif ($tel == '1000') {
            $market->update([
                'sms_number' => '10008566'
            ]);
            $state = true;
        } elseif ($tel == '210002100') {
            $market->update([
                'sms_number' => '210002100'
            ]);
            $state = true;
        } elseif ($tel == '90002550') {
            $market->update([
                'sms_number' => '90002550'
            ]);
            $state = true;
        }
        if ($state)
            return response()->json([
                'number' => $market->sms_number,
                'message' => 'عملیات با موفقیت انجام شد',
                'status' => 'ok'
            ]);
        return response()->json([
            'data' => [],
            'message' => 'عملیات  معتبر نیست',
            'status' => 'fail'
        ], 422);

    }

    public function changeBank(Request $request)
    {

        try {
            $bank = fa2en($request->bank);
            $market = get_market(1);
            $ipg = $market->ipg;
            // $ipg=['mellat'=>['id'=>'0','bank'=>'mellat','name'=>'ملت','default'=>0],'pasargad'=>['id'=>'1','bank'=>'pasargad','name'=>'پاسارگاد','default'=>0]];
            if ($bank == '0') {
                $ipg['mellat']['default'] = 1;
                $ipg['pasargad']['default'] = 0;
                $market->update([
                    'ipg' => $ipg
                ]);
                return response()->json([
                    'data' => [],
                    'message' => 'ملت',
                    'status' => 'ok'
                ]);
            } elseif ($bank == '1') {
                $ipg['pasargad']['default'] = 1;
                $ipg['mellat']['default'] = 0;
                $market->update([
                    'ipg' => $ipg
                ]);
                return response()->json([
                    'data' => [],
                    'message' => 'پاسارگاد',
                    'status' => 'ok'
                ]);
            }
            return response()->json([
                'data' => [],
                'message' => 'عملیات  معتبر نیست',
                'status' => 'fail'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 'fail'
            ], 422);
        }

    }

    public function changeSupport(Request $request)
    {
        $market = get_market(1);
        $support = explode('-', fa2en($request->support));
        $market->update([
            'support' => $support
        ]);
        return response()->json([
            'data' => [],
            'message' => 'با موفقیت انجام شد',
            'status' => 'ok'
        ]);
    }

    public function changeDelayNum(Market $market, Request $request)
    {
        $delay = fa2en(explode('-', $request->delay));
        $market->update(['delay_support' => $delay]);
        return response()->json([
            'data' => [],
            'message' => 'با موفقیت انجام شد',
            'status' => 'ok'
        ]);
    }

    public function change_order_mobiles(Request $request)
    {
        try {

            $market = get_market(1);
            $market->update([
                'order_mobiles' => fa2en($request->order_mobiles)
            ]);
            return response()->json([
                'data' => [],
                'message' => 'تغییرات با موفقیت اعمال شد.',
                'status' => 'ok'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 'fail'
            ], 422);
        }
    }

    public function change_peyk_discount(Request $request)
    {
        $peyk_price_discount = array();

        $i = 0;
        foreach ($request->peyk_discount as $index => $item) {
            if ($index % 2 == 0) {
                if ($i < (count($request->peyk_discount))) {
                    array_push($peyk_price_discount, [$item => $request->peyk_discount[$i + 1]]);
                    $i += 2;
                }
            }
        }

        try {

            $market = get_market(1);
            $market->update([
                'peyk_price_discount' => $peyk_price_discount
            ]);
            return response()->json([
                'data' => [],
                'message' => 'تغییرات با موفقیت اعمال شد.',
                'status' => 'ok'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 'fail'
            ], 422);
        }
    }

    public function changeCustomerClub(Request $request)
    {

        $jayParsedAry = [
            "levels" => [
                "1" => [
                    "id" => 1,
                    "product" => "Pineapple",
                    "price" => 90
                ],
                "2" => [
                    "id" => 1,
                    "product" => "Pineapple",
                    "price" => 90
                ],
                "3" => [
                    "id" => 2,
                    "product" => "Orange",
                    "price" => 70
                ]
            ]
        ];

//        $a = array('green', 'red', 'yellow');
//        $b = array('avocado', 'apple', 'banana');
//        $c = array_combine($a, $b);
//        return $a;


//        return json_encode($jayParsedAry);


        $levelsForPay = array();


        $levels = array();
        $scores = array();
        foreach ($request->data['customer_club_levels'] as $index => $item) {
            array_push($levels, $item);
            array_push($scores, ['min_score' => $request->data['customer_club_levels_min'][$index], 'max_score' => $request->data['customer_club_levels_max'][$index]]);
        }
        $customer_club['levels'] = array_combine($levels, $scores);



        $levelsForPay = array();
        $scores = array();
        foreach ($request->data['customer_club_levels_for_pay'] as $index => $item) {
            array_push($levelsForPay, $item);
            array_push($scores, ['score' => $request->data['customer_club_levels_score_per_pay'][$index], 'amount' => $request->data['customer_club_levels_amount_per_pay'][$index]]);
        }
        $customer_club['convert_score_to_wallet_money'] = array_combine($levelsForPay, $scores);
        $customer_club['score_of_success_order'] = $request->data['score_of_success_order'];
        $customer_club['currency']= 'TMN';



        $market = Market::find(1);

        if ($market->update([
            'customer_club' => json_encode($customer_club)
        ])) {
            return response()->json([
                'data' => [],
                'message' => 'تغییرات با موفقیت اعمال شد.',
                'status' => 'ok'
            ]);
        }

    }

    public function change_market_tels(Request $request)
    {
        try {
            $market = get_market(1);
            $market->update([
                'tel' => fa2en($request->market_tels)
            ]);
            return response()->json([
                'data' => [],
                'message' => 'تغییرات با موفقیت اعمال شد.',
                'status' => 'ok'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 'fail'
            ], 422);
        }
    }

    public function change_market_address(Request $request)
    {
        try {

            $market = get_market(1);
            $market->update([
                'address' => fa2en($request->market_address)
            ]);
            return response()->json([
                'data' => [],
                'message' => 'تغییرات با موفقیت اعمال شد.',
                'status' => 'ok'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 'fail'
            ], 422);
        }
    }

    public function change_shipping_method(Request $request)
    {
        try {
            $market = get_market(1);
            $market->update([
                'express' => fa2en($request->express),
                'scheduled' => fa2en($request->scheduled),
                'cash' => fa2en($request->cash),
                'incity_express_peykPrice_percent' => fa2en($request->incity_express_peykPrice_percent),
                'incity_express_peykPrice_threshold' => fa2en($request->incity_express_peykPrice_threshold),
                'incity_scheduled_peykPrice_percent' => fa2en($request->incity_scheduled_peykPrice_percent),
                'incity_scheduled_peykPrice_threshold' => fa2en($request->incity_scheduled_peykPrice_threshold),
                'scheduler_latency_day' => fa2en($request->scheduler_latency_day),
            ]);
            return response()->json([
                'data' => [],
                'message' => 'تغییرات با موفقیت اعمال شد.',
                'status' => 'ok'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 'fail'
            ], 422);
        }
    }

    public function get_market_times()
    {
        try {
            $days = MarketTime::where('market_id', 1)->get();
            foreach ($days as $day) {
                $day->start = date('H:i', strtotime($day->start));
                $day->end = date('H:i', strtotime($day->end));
            }
            return response()->json([
                'data' => $days,
                'status' => 'ok'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 'fail'
            ], 422);
        }
    }

    public function market_times(Request $request)
    {
        try {
            MarketTime::truncate();
            $days = $request->days;
            foreach ($days as $day) {
                $day_item = fa2en($day['day']);
                $start_item = fa2en($day['start']);
                $end_item = fa2en($day['end']);

//    if ($found_item){
//        $found_item->delete();
//    }else{
                $day_label = '';
                switch ($day_item) {
                    case 0:
                        $day_label = 'شنبه';
                        break;
                    case 1:
                        $day_label = 'یک شنبه';
                        break;
                    case 2:
                        $day_label = 'دو شنبه';
                        break;
                    case 3:
                        $day_label = 'سه شنبه';
                        break;
                    case 4:
                        $day_label = 'چهار شنبه';
                        break;
                    case 5:
                        $day_label = 'پنج شنبه';
                        break;
                    case 6:
                        $day_label = 'جمعه';
                        break;
                }
                MarketTime::create([
                    'day' => $day_item,
                    'day_label' => $day_label,
                    'start' => $start_item . ":00",
                    'end' => $end_item . ":00",
                    'market_id' => 1
                ]);
            }

//}
            return response()->json([
                'data' => [],
                'message' => 'تغییرات با موفقیت اعمال شد.',
                'status' => 'ok'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 'fail'
            ], 422);
        }
    }

    public function toggle_market_service(Request $request)
    {
        try {
            $market = get_market(1);
            $service = fa2en($request->service);
            if ($service == '1') {
                $market->update([
                    'service' => $service
                ]);
            } else {
                $market->update([
                    'service' => '0'
                ]);
            }
            return response()->json([
                'data' => [],
                'status' => 'ok'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 'fail'
            ], 422);
        }
    }

    public function toggle_market_cash(Request $request)
    {
        try {
            $market = get_market(1);
            $cash = fa2en($request->cash);
            $message = 'خرید نقدی غیر فعال شد';
            if ($cash == '1') {
                $market->update([
                    'cash' => $cash
                ]);
            } else {
                $market->update([
                    'cash' => '0'
                ]);
                $message = 'خرید نقدی فعال شد';
            }
            return response()->json([
                'data' => [],
                'message' => $message,
                'status' => 'ok'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 'fail'
            ], 422);
        }
    }

    public function market_service_why_off(Request $request)
    {
        try {
            $why_off = fa2en($request->why_off);
            $market = get_market(1);
            if ($market->service == '0') {
                $market->update([
                    'why_off' => $why_off
                ]);
            }
            return response()->json([
                'data' => [],
                'message' => 'توضیحات با موفقیت ذخیره شد.',
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
