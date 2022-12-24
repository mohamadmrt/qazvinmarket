<?php

namespace App\Http\Controllers\Admin;

use App\Comment;
use App\Http\Controllers\Admin\Auth\AdminController;
use App\Http\Resources\v1\ocms\UserResource;
use App\Http\Resources\v1\ocms\WalletCollection;
use App\Order;
use App\Sms;
use App\User;
use App\Wallet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Morilog\Jalali\CalendarUtils;
use Morilog\Jalali\Jalalian;

class UserController extends AdminController
{
    public function users()
    {
        return view('ocms.User.user');
    }

    public function wallets()
    {
        return view('ocms.User.wallet');
    }

    public function walletsList(Request $request)
    {
        $wallets = Wallet::search($request->params)->with('user')->latest()->paginate(20);
        return response([
            'status' => 'OK',
            'data' => WalletCollection::collection($wallets),
            'paginate' => [
                'total' => $wallets->total(),
                'count' => $wallets->count(),
                'per_page' => $wallets->perPage(),
                'current_page' => $wallets->currentPage(),
                'last_page' => $wallets->lastPage()
            ]
        ]);
    }

    public function userList(Request $request)
    {
        $users = User::search($request->params)->with('addresses')->with('group')->paginate(20);

        return response([
            'status' => 'ok',
            'users' => UserResource::collection($users),
            'paginate' => [
                'total' => $users->total(),
                'count' => $users->count(),
                'per_page' => $users->perPage(),
                'current_page' => $users->currentPage(),
                'last_page' => $users->lastPage()
            ],
        ]);
    }

    public function increaseCredit(Request $request)
    {

        $balance = fa2en($request->balance);
        $order_id = fa2en($request->order_id);
        $balance = str_replace(',', '', $balance);
        //$comment=Comment::find($id);
        if (!empty($balance) and is_numeric($balance) and !empty($order_id)) {
            $order = Order::find($order_id);
            $user_id = $order->user_id;
            $user = User::find($user_id);
            if ($user) {
                $balance_old = $user->wallet;
                $balance_sum = $balance_old + (int)$balance;
                $user->update([
                    'wallet' => $balance_sum
                ]);
                $wallet = Wallet::insert($user->id, 0, 0, $balance, '1', '4', '0', 'افزایش اعتبار توسط مدیر');

                if ($wallet) {
                    $message = $request->message;
                    $message .= $balance;
                    $message .= $request->message2;
                    SMS::insert($user_id, $user->username, $message);
                    return response()->json([
                        'data' => [],
                        'message' => "اعتبار افزایش یافت",
                        'status' => 'ok'
                    ]);
                }
            }
        } elseif (!empty($balance) and is_numeric($balance) and !empty($request->id)) {
            $user = User::find($request->id);
            if ($user) {
                $balance_old = $user->wallet;
                $balance_sum = $balance_old + (int)$balance;
                $user->update([
                    'wallet' => $balance_sum
                ]);
                $wallet = Wallet::insert($user->id, 0, 0, $balance, '1', '4', '0', 'افزایش اعتبار توسط مدیر');

                if ($wallet) {
                    $message = $request->message;
                    $message .= ' ' . $balance . ' ';
                    $message .= $request->message2;
                    SMS::insert(0, $user->username, $message);
                    return response()->json([
                        'data' => [],
                        'message' => "اعتبار افزایش یافت",
                        'status' => 'ok'
                    ]);
                }
            }
        }
        return response()->json([
            'data' => [],
            'message' => "عملیات  معتبر نیست",
            'status' => 'fail'
        ]);
    }

    public function historyIncreaseCredit(Request $request)
    {
        try {
            $id = fa2en($request->id);
            $user = User::findOrFail($id);
            $wallets = Wallet::where('user_id', $id)->orderBy('id', 'desc')->get();
            return response()->json([
                'status' => 'ok',
                'data' => WalletCollection::collection($wallets),
                'username' => $user->username,
                'balance' => $user->wallet,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 'fail'
            ], 422);
        }

    }

    public function block_user(Request $request)
    {
        $user_id = fa2en($request->user_id);
        try {
            $user = User::find($user_id);
            if ($user->status === '2')
                $user->update([
                    'status' => '1'
                ]);
            else
                $user->update([
                    'status' => '2'
                ]);
            return response([
                'data' => $user,
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

    public function mostPurchasedView()
    {
        return view('ocms.User.most_purchased');
    }

    public function mostPurchased(Request $request)
    {
        $orderBy = $request->params['orderBy'];
        
        $from_date = fa2en($request->params['search_by_start_date']);
        $to_date = fa2en($request->params['search_by_end_date']);


        if ($from_date != '') {
            $from_date = CalendarUtils::createCarbonFromFormat('Y/m/d', $from_date);
        } else {
            $from_date = Carbon::createFromFormat('Y/m/d', '2000/01/01');
        }
        if ($to_date != '') {
            $to_date = CalendarUtils::createCarbonFromFormat('Y/m/d', $to_date)->endOfDay();
        } else {
            $to_date = Carbon::now()->format('Y/m/d H:i:s');
        }


        if ($orderBy == 0){
            $orders = Order::where('status', '4')->select('user_id', Order::raw('count(*) as total'))
                ->groupBy('user_id')
                ->orderByRaw('COUNT(*) DESC LIMIT 50')->whereBetween('created_at', [$from_date, $to_date])->get();
        }elseif ($orderBy == 1){
            $orders = Order::where('status', '4')->select('user_id', Order::raw('count(*) as total'))
                ->groupBy('user_id')
                ->orderByRaw('sum(invoice_amount) DESC LIMIT 50')->whereBetween('created_at', [$from_date, $to_date])->get();
        }


        $users = array();

        foreach ($orders as $order) {
            $user = User::find($order->user_id);
            $sum = Order::where('status', '4')->where('user_id',$order->user_id)->whereBetween('created_at', [$from_date, $to_date])->sum('invoice_amount');
            $user->order_count = $order->total;
            $user->save();
            $user->setAttribute('sum_of_orders', $sum);
            array_push($users, $user);
        }

        return response([
            'status' => 'ok',
            'users' => $users,
        ]);
    }
}
