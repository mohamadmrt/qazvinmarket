<?php

namespace App\Http\Controllers;

use App\Bazara;
use App\Cargo;
use App\Cart;
use App\FactorLog;
use App\Jobs\SendSms;
use App\Order;
use App\Sms;
use App\User;
use App\Wallet;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SchedulerController extends Controller
{
    public function get_products_from_bazara()
    {
        $bazara = new Bazara();
        return $bazara->get_products();
    }

    public function send_factors_to_bazara()
    {
        $bazara = new Bazara();
        return $bazara->send_factors();
    }

    public function send_sms_scheduler()
    {
        $smses = Sms::where('sent', '==', 0)->where('rescode', "<", 100)->orWhere("rescode", null)->get();
        foreach ($smses as $sms) {
            Sms::send($sms);
//                $job=new SendSms($sms);
//                dispatch($job);
        }
        return "done";
    }

    public function process_orders()
    {
        $orders = Order::where('delayed', '0')->where('valid', '1')->get();
        $changed_orders = 0;
        foreach ($orders as $order) {
            if (
                ($order->confirm != null and abs($order->confirm->diffInMinutes($order->created_at)) / 60 > 20)
                or
                ($order->confirm == null and $order->status == '4' and $order->verified_at->diffInMinutes($order->created_at) / 60 > 20)
            ) {
//                $order->lated = "1";
                $changed_orders++;
            }
            $order->save();
        }
        return $changed_orders . " processed";
    }

    public function birthday_scheduler()
    {
        $users = User::where('status', '!=', '2')->where('got_birthday', '!=', '1')->get();
        $count = 0;
        foreach ($users as $user) {
            if ($user->birthday == Carbon::today()) {
                $user->update([
                    'wallet' => (int)$user->wallet + 5000,
                    'got_birthday' => '1'
                ]);
                Wallet::insert($user->id, 0, 5000, 5000, '1', '4', '2', 'هدیه روز تولد');
                $count++;
            }
        }
        return $count;
    }

    public function unsuccess_orders_sms()
    {
        $market = get_market(1);
        $orders = Order::where('created_at', '<', Carbon::now()->subMinutes(30))->where('bank','1')->where('status', '!=', '4')->where('valid','1')->where('unsuccess_sms', 0)->get();

        foreach ($orders as $order) {
            $message = "با سلام\n\rخرید شما از سایت $market->name موفق نبوده است و چنانچه مبلغی از حساب شما کم شده است تا 48 ساعت آینده بطور اتوماتیک به حساب شما برگشت داده می شود.\n\rبا تشکر\n\r$market->name\n\rwww.$market->url";
            Sms::insert($order->id, $order->tel, $message);
            $order->update([
                'unsuccess_sms' => 1,
            ]);
        }
    }

    public function process_carts()
    {
        $incomplete_carts = Cart::where('created_at', '<', Carbon::now()->subDay()->startOfDay())->delete();
        return 'deleted carts: ' . $incomplete_carts;
    }

    public function increase_inventory()
    {
        $orders = Order::where('market_id', 1)->where('status', '!=', '4')->where('increase', 0)->orderBy('id', 'DESC')->get();
        foreach ($orders as $order) {
            foreach ($order->cargos as $sample) {
                $cargo = Cargo::where('id', $sample['id'])->first();
                if ($cargo) {
                    $cargo->max_count = $cargo->max_count + $sample['count'];
                    $cargo->save();
                }
            }
            $order->increase = 1;
            $order->save();
        }
    }
}
