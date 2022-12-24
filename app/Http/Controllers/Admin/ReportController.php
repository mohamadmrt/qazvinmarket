<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Functions\FunctionController;
use App\Http\Resources\v1\ocms\ReportCollection;
use App\Order;
use App\OrderUser;
use App\Report;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Morilog\Jalali\CalendarUtils;

class ReportController extends Controller
{
    public function reports()
    {
        return view('ocms.Reports.report');
    }

    public function reportList(Request $request)
    {

        $from_date = fa2en($request['params']['search_by_start_date']);
        $to_date = fa2en($request['params']['search_by_end_date']);
        if ($from_date != '') {
            $from_date = CalendarUtils::createCarbonFromFormat('Y/m/d', $from_date);
        } else {
            $from_date = Carbon::today();
        }
        if ($to_date != '') {
            $to_date = CalendarUtils::createCarbonFromFormat('Y/m/d', $to_date)->endOfDay();
        } else {
            $to_date = Carbon::now();
        }
        $reports_all = Order::whereBetween('created_at', [$from_date->format('Y-m-d H:i:s'), $to_date->format('Y-m-d H:i:s')])->where('market_id', 1)->where('status',  '4')->where('ResCode', 0)->get();
        $reports_all_result = [];
        array_push($reports_all_result, ['sum' => $reports_all->sum('invoice_amount'), 'tedad' => $reports_all->count()]);
        $a = [];
        while ($from_date < $to_date) {
            $reports = Order::whereDate('created_at', $from_date)->where('market_id', 1)->where('status', '4')->where('ResCode', 0)->get();
            $online_orders = $reports->where('bank','1')->count();
            $cash_orders = $reports->where('bank','4')->count();
            $wallet_orders = $reports->where('bank','3')->count();
            array_push($a, ['sum' => $reports->sum('invoice_amount'), 'tedad' => $reports->count(),'online_orders'=>$online_orders, 'cash_orders'=>$cash_orders, 'wallet_orders'=>$wallet_orders,'created_at' => CalendarUtils::strftime('l %d %B،%Y', $from_date)]);
            $from_date->addDays(1);
        }
        return response()->json(['reports' => array_reverse($a),'reports_result' => $reports_all_result, 'status' => "ok"]);
    }
}
