<?php

namespace App\Http\Controllers\Admin;

use App\Bazara;
use App\Coupon;
use App\Events\UserActivation;
use App\Http\Controllers\Admin\Auth\AdminController;
use App\Http\Resources\v1\ocms\OrderCollection;
use App\Market;
use App\Order;
use App\Sms;
use App\User;
use App\Wallet;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderController extends AdminController
{
    public function orders()
    {
        return view('ocms.Order.order');
    }

    public function orderList(Request $request)
    {
//            $from_date = fa2en($request->params['search_by_start_date']);
//            if ($from_date != ''){
//                $from_date=CalendarUtils::createCarbonFromFormat('Y/m/d',$from_date);
//            }else{
//                $from_date=Carbon::createFromFormat('Y/m/d','2000/01/01');
//            }
//            return $from_date->startOfDay();
        $orders = Order::search($request->params)->with('market')->orderBy('id', 'DESC')->with('peyk')->with('user')->orderBy('created_at', 'DESC')->paginate(20);
        return response(['status' => 'ok', 'data' => OrderCollection::collection($orders), 'paginate' => ['total' => $orders->total(), 'count' => $orders->count(), 'per_page' => $orders->perPage(), 'current_page' => $orders->currentPage(), 'last_page' => $orders->lastPage()]]);
    }

    public function factorPrint(Market $market, Order $order)
    {
        try {
            if (count($order->cargos) == 0) {
                return back();
            }
            $order->update(['printed' => '1']);
//            $order->verified_at = gregorian2jalali($order->verified_at);
            return view('ocms.Order.factorPrint', compact('order', 'market'));
        } catch (\Exception $e) {
            return response(['data' => [], 'message' => $e->getMessage(), 'status' => 'fail']);
        }
    }

    public function confirmOrder(Order $order)
    {
        $order->update(['confirm' => Carbon::now(), 'valid' => '1']);
        $text = 'سفارش شما تحویل پیک داده شد و به زودی به دست شما میرسد.قزوین مارکت';
        $sms = Sms::insert($order->id, $order->tel, $text);
        if (event(new UserActivation($sms))) {
            return response()->json(['data' => [], 'message' => 'عملیات با موفقیت انجام شد', 'status' => 'ok']);
        }
    }

    public function cancelOrder(Order $order)
    {
        $coupon = Coupon::findByCode($order->used_coupon);

        if ($coupon) {
            $coupon->used_count -= 1;
            $coupon->save();
        }
        $market = get_market(1);
        $user = User::where('username', $order->tel)->first();
        if ($order['bank'] == '3') {
            $user->update(['wallet' => $user->wallet + $order->invoice_amount - $order->discount_ghasedak]);
            Wallet::insert($order->user_id, $order->id, $order->invoice_amount, $order->invoice_amount, '0', '4', '3', 'بابت کنسلی سفارش' . $order->id);
        }
        $order->update(['valid' => '0', 'status' => '2', 'confirm' => new Carbon('2000-01-01 00:00:00')]);
        //mellat=1; wallet=3; cash=4;
        if ($order['bank'] == '3') $text = "با سلام؛\n\r با عرض پوزش سفارش شما لغو شد؛ مبلغ سفارش به حساب شما برگشت داده می شود. \n\r جهت انجام سفارش مجدد می توانید اقدام نمایید. \n\r-$market->name www.$market->url"; else
            $text = "با سلام؛\n\rبا عرض پوزش سفارش شما لغو شد؛\n\r جهت انجام سفارش مجدد می توانید اقدام نمایید.\n\r-$market->name www.$market->url";
        Sms::insert($order->id, $order->tel, $text);
        if ($order->name) $message = "با سلام؛\n\r سفارش $order->name لغو شد لطفا از ارسال آن خودداری کنید.-$market->name"; else
            $message = "با سلام؛ \n\r سفارش با شماره همراه $order->tel لغو شد لطفا از ارسال آن خودداری کنید.-$market->name";
        foreach ($market->support as $market_support) Sms::insert($order->id, $market_support, $message);
        return response()->json(['data' => [], 'message' => "عملیات با موفقیت انجام شد.", 'status' => 'ok']);
        return response()->json(['data' => [], 'message' => "عملیات  معتبر نیست", 'status' => 'ok']);
    }

    public function resendSms($id)
    {
        $sms = Sms::where('order_id', $id)->get();
        if ($sms->count()) {
            foreach ($sms as $s) $t = $s->update(['sent' => 0]);
            if ($t == 'true') return ['success' => true, 'message' => "عملیات با موفقیت انجام شد."];
        }
        return ['success' => false, 'message' => "عملیات  معتبر نیست"];
    }

    public function resend_factor(Order $order)
    {
        try {
            Bazara::send_factor($order);
            return response(['data' => [], 'status' => 'ok']);
        } catch (\Exception $e) {
            return response(['data' => $e->getMessage(), 'status' => 'fail'], 422);
        }
    }
}
