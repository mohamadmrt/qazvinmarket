<?php

namespace App\Http\Controllers\Home;

use App\Cargo;
use App\Cart;
use App\Coupon;
use App\Events\UserActivation;
use App\Http\Controllers\Controller;
use App\Market;
use App\Order;
use App\Sms;
use App\Token;
use App\Wallet;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PayController extends Controller
{
    public function back(Order $order, Request $request)
    {
        set_time_limit(180);
        $market = get_market(1);
        if ($order->bank == "4" or $order->bank == "3") {
            $user = Token::where('ipg_token', fa2en($request->token))->first()->user;
        }
        //mellat
        if ($order->bank == "1") {
            $user = Token::where('ipg_token', fa2en($request->token))->first()->user;
            auth()->guard('api')->login($user);
            $SaleReferenceId = fa2en($request->SaleReferenceId);
            $SaleOrderId = fa2en($request->SaleOrderId);
            $verify_payment = verify_payment($SaleReferenceId, $SaleOrderId);
            $order->update([
                'ResCode' => $request->ResCode,
                'valid' => "1"
            ]);
            if ($verify_payment == 0) {
                $order->update([
                    'status' => "4",
                    'valid' => "1",
                ]);
                foreach ($order['cargos'] as $item) {
                    $cargo = Cargo::find($item['id']);
                    $cargo->buy_count = $cargo->buy_count + $item['count'];
                    $cargo->save();
                }
                if ($user->is_ghasedak == "1" and $market->discount_ghasedak) {
                    $wallet = $user->wallet;
                    $deposit = $market->discount_ghasedak * $order->sum_of_cargos_price / 100;
                    Wallet::insert($user->id, $order->id, $order->sum_of_cargos_price, $deposit, '1', "4", "4", "افزایش اعتبار برای قاصدکی ها");
                    $user->update([
                        'wallet' => $wallet + $deposit
                    ]);
                }
            }
            $order->update([
                'SaleReferenceId' => $SaleReferenceId,
                'payment_timestamp' => Carbon::now()
            ]);
        }
        //do common tasks for success orders
        if ($order->status == '4') {
            //increment user order count
            $user->update([
                'order_count' => $user->order_count + 1,
                'point' => $user->point + json_decode(Market::find(1)->customer_club,true)['score_of_success_order']
            ]);
            //increment coupon used count
            $coupon = Coupon::where('code', $order->used_coupon)->first();
            if ($coupon)
                $coupon->update([
                    'used_count' => $coupon->used_count + 1
                ]);

            //empty cart
            Cart::where('user_id', $user->id)->delete();
            //send orders for market support
            Sms::sendSmsSupporters(1, $order->id);
            Sms::sendSmsSuccessOrder($order->id);
        }
        $address = "/track-order/$order->url";
        switch ($request->source) {
            case "web":
                $host = env('MELLAT_PAYMENT_URL_PWA') . $address;
                break;
            case "android":
                $host = env('MELLAT_PAYMENT_URL_ANDROID') . "/$order->url";
                break;
            default:
                $host = env('MELLAT_PAYMENT_URL_PWA') . $address;
        }
        if ($user)

            return view('home.Pay.back', compact('market', 'order', 'host'));
        return abort(404);
    }

    public function wallet_charge_back(Wallet $wallet, Request $request)
    {
        $RefId = fa2en($request->RefId);
        $ResCode = fa2en($request->ResCode);
        $SaleOrderId = fa2en($request->SaleOrderId);
        $SaleReferenceId = fa2en($request->SaleReferenceId);
        $wallet->refId = $RefId;
        $wallet->rescode = $ResCode;


        $user = Token::where('ipg_token', fa2en($request->token))->first()->user;
        $total_current = $user->wallet;
        if ($ResCode == 0) {
            $verify_payment = verify_payment($SaleReferenceId, $SaleOrderId);
            if ($verify_payment == 0) {
                $deposit = $wallet->deposit;
                $message = "با سلام؛\n\rاعتبار حساب شما به مبلغ $deposit تومان افزایش یافت.\n\rشماره پیگیری پرداخت:  $SaleReferenceId";
                $wallet->status = '4';
                $user->wallet = $total_current + $deposit;
                $user->save();
                $sms = Sms::insert($wallet->id, $user->username, $message);
                event(new UserActivation($sms));
            }
        } else {
            $wallet->total_current = $user->wallet;
        }
        $wallet->SaleRefId = $SaleReferenceId;
        $wallet->payment_timestamp = Carbon::now();
        $wallet->save();
        $status = $wallet->status == '4' ? 'true' : 'false';
        switch ($request->source) {
            case "web":
                $host = env('APP_HOST_WALLET_CHARGE_WEB');
                break;
            case "android":
                $host = env('APP_HOST_WALLET_CHARGE_ANDROID') . "/$status?amount=$wallet->deposit";
                break;
            default:
                $host = env('APP_HOST_WALLET_CHARGE_PWA');
        }
        return view('home.Pay.wallet_charge_back', compact('wallet', 'host'));

    }


    public function track_order()
    {
        return view('home.Pay.track_order');

    }

    public function index()
    {
        $user = '';
        if (auth()->check())
            $user = \auth()->user();
        return view('home.Pay.pay', compact('user'));
    }

    public function vote(Order $order)
    {
        try {
            $orderUser = $order;
            $orders = $order->cargos;
            return view('home.Vote.voting', compact('orderUser', 'orders'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

}
