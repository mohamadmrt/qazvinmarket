<?php

namespace App\Http\Controllers\api\v1;

use App\Holiday;
use App\Http\Controllers\Controller;
use App\Market;
use App\MarketTime;
use App\Peyk;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Morilog\Jalali\CalendarUtils;
use Morilog\Jalali\Jalalian;
use phpDocumentor\Reflection\Types\Collection;

class PeykController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Address $address
     * @return \Illuminate\Http\Response
     */
    public function show(Address $address)
    {
        //
    }


    public function verbal_order()
    {
        try {
            $market = get_market(1);
            if ($market->service == '0') {
                return response([
                    'data' => [],
                    'message' => 'امکان ثبت سفارش بدلیل بسته بودن فروشگاه وجود ندارد',
                    'status' => 'ok'
                ], 422);
            }
            $holiday = Holiday::getHoliday(1);
            if ($holiday) {
                return response([
                    'data' => [],
                    'message' => "امکان دریافت حضوری بدلیل $holiday->why_off امکان پذیر نمی باشد. ",
                    'status' => 'ok'
                ], 422);
            }
            $service = 1;
            $why_off = '';
            $open_time = null;
            $close_time = null;
            $holiday = Holiday::getHoliday(1);
            //market is closed
            if ($market->service == '0') {
                $service = 0;
                $why_off = $this->why_off;
                //we have active holiday
            } else if ($holiday) {
                $holiday->start = CalendarUtils::strftime('Y/m/d H:i', $holiday->start_gregorian);
                $holiday->end = CalendarUtils::strftime('Y/m/d H:i', $holiday->end_gregorian);
            } else {
                $today = Jalalian::now()->getDayOfWeek();
                $open_time = MarketTime::where('market_id', 1)->where('day', $today)->orderBy('start')->first();
                $close_time = MarketTime::where('market_id', 1)->where('day', $today)->orderBy('end', 'Desc')->first();
                if ($open_time) {
                    $open_time = date('H:i', strtotime($open_time->start));
                    $close_time = date('H:i', strtotime($close_time->end));
                } else {
                    $holiday = new \stdClass();
                    $holiday->start = CalendarUtils::strftime('Y/m/d H:i:s', Carbon::now()->startOfDay());
                    $holiday->end = CalendarUtils::strftime('Y/m/d H:i:s', Carbon::now()->endOfDay());
                    $holiday->why_off = 'تعطیلی فروشگاه';
                }
            }
            return response([
                'address' => $market->address,
                'open_time' => $open_time,
                'close_time' => $close_time,
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

    public function pre_order()
    {

        $options = collect();
        $holidays = Holiday::query()->where('start_gregorian','>=',Carbon::today())->get();
        $times = [];
        if ($holidays->isEmpty()) {
            $day_name = CalendarUtils::strftime('l', Carbon::now());


            if (Carbon::now()->hour <= 11) {

                $times = ['ساعت 11 تا 13', 'ساعت 16 تا 18'];


                $options->push([
//                    'id' => 0,
                    'name' => $day_name . ' - ' . CalendarUtils::strftime('Y/m/d', Carbon::now()),
                    'times' => $times,
                ]);

                $day_name = CalendarUtils::strftime('l', Carbon::now()->addDay(1));
                $options->push([
//                    'id' => 0,
                    'name' => $day_name . ' - ' . CalendarUtils::strftime('Y/m/d', Carbon::now()->addDay(1)),
                    'times' => $times,
                ]);

            } elseif (Carbon::now()->hour <= 16) {

                $times = ['ساعت 16 تا 18'];


                $options->push([
//                    'id' => 0,
                    'name' => $day_name . ' - ' . CalendarUtils::strftime('Y/m/d', Carbon::now()),
                    'times' => $times,
                ]);


                $times = ['ساعت 11 تا 13', 'ساعت 16 تا 18'];

                $day_name = CalendarUtils::strftime('l', Carbon::now()->addDay(1));

                $options->push([
//                    'id' => 0,
                    'name' => $day_name . ' - ' . CalendarUtils::strftime('Y/m/d', Carbon::now()->addDay(1)),
                    'times' => $times,
                ]);
            }elseif (Carbon::now()->hour >= 18){

                $day_name = CalendarUtils::strftime('l', Carbon::now()->addDay(1) );
                $times = ['ساعت 11 تا 13', 'ساعت 16 تا 18'];



                $options->push([
//                    'id' => 0,
                    'name' => $day_name . ' - ' . CalendarUtils::strftime('Y/m/d', Carbon::now()->addDay(1)),
                    'times' => $times,
                ]);

                $day_name = CalendarUtils::strftime('l', Carbon::now()->addDay(2) );
                $options->push([
//                    'id' => 0,
                    'name' => $day_name . ' - ' . CalendarUtils::strftime('Y/m/d', Carbon::now()->addDay(2)),
                    'times' => $times,
                ]);
            }

            return response()->json(
                $options
            );

        } else {

            foreach ($holidays as $holiday) {
                if (Carbon::now() > $holiday->end_gregorian) {
                    $day_name = CalendarUtils::strftime('l', Carbon::now());
                    if (Carbon::now()->hour <= 11) {

                        $times = ['ساعت 11 تا 13', 'ساعت 16 تا 18'];


                        $options->push([
                            'id' => 0,
                            'name' => $day_name . ' - ' . CalendarUtils::strftime('Y/m/d', Carbon::now()),
                            'times' => $times,
                        ]);

                        $day_name = CalendarUtils::strftime('l', Carbon::now()->addDay(1));
                        $options->push([
                            'id' => 0,
                            'name' => $day_name . ' - ' . CalendarUtils::strftime('Y/m/d', Carbon::now()->addDay(1)),
                            'times' => $times,
                        ]);

                    } elseif (Carbon::now()->hour <= 13) {

                        $times = ['ساعت 16 تا 18'];


                        $options->push([
                            'id' => 0,
                            'name' => $day_name . ' - ' . CalendarUtils::strftime('Y/m/d', Carbon::now()),
                            'times' => $times,
                        ]);


                        $times = ['ساعت 11 تا 13', 'ساعت 16 تا 18'];

                        $day_name = CalendarUtils::strftime('l', Carbon::now()->addDay(1));

                        $options->push([
                            'id' => 0,
                            'name' => $day_name . ' - ' . CalendarUtils::strftime('Y/m/d', Carbon::now()->addDay(1)),
                            'times' => $times,
                        ]);
                    }

                    return response()->json(
                        $options
                    );

                } elseif (Carbon::now() <= $holiday->end_gregorian) {
                    $day_name = CalendarUtils::strftime('l', Carbon::parse($holiday->end_gregorian)->addDay(1) );
                    $times = ['ساعت 11 تا 13', 'ساعت 16 تا 18'];



                    $options->push([
                        'id' => 0,
                        'name' => $day_name . ' - ' . CalendarUtils::strftime('Y/m/d', Carbon::parse($holiday->end_gregorian)->addDay(1)),
                        'times' => $times,
                    ]);

                    $day_name = CalendarUtils::strftime('l', Carbon::parse($holiday->end_gregorian)->addDay(2) );
                    $options->push([
                        'id' => 0,
                        'name' => $day_name . ' - ' . CalendarUtils::strftime('Y/m/d', Carbon::parse($holiday->end_gregorian)->addDay(2)),
                        'times' => $times,
                    ]);
                }
            }
            return response()->json(
                $options
            );
        }


//        try{
//            $options= collect();
//            $market=get_market(1);
////                $scheduler_latency_day=$market->scheduler_latency_day;
//            $index=Carbon::now()->hour>18?1:0;
////                $index=$index+$scheduler_latency_day;
//            $j=2;
//            for($i=$index;$i<$index+2;$i++){
//                $day=Carbon::now()->addDays($i);
//                $day_name=CalendarUtils::strftime('l',$day);
//                $holiday=Holiday::getHoliday(1);
//                $start='';
//                $end='';
//
//                if (!$holiday or !($holiday and $day>=$holiday->start and $day<=$holiday->end)){
//                    if(($index==0 and $day->hour<10) or ($i!=0 and (($holiday and Carbon::parse($holiday->end)->hour<10)or(!$holiday)))){
//                        $start = 'ساعت 11 تا 13';
//                    }
//                    if(($index==0 and $day->hour<15) or ($i!=0 and (($holiday and Carbon::parse($holiday->end)->hour<15)or(!$holiday)))){
//                        $end = 'ساعت 16 تا 18';
//                    }
//                    $start_array=[];
//                    $end_array=[];
//                    $times=[];
//                    if ($start!=''){
//                        $start_array=[
//                            'id'=>$j++,
//                            'name'=>$start
//                        ];
//                    }
//                    if (count($start_array)>0){
//                        array_push($times,$start_array);
//                    }
//
//                    if ($end!=''){
//                        $end_array= [
//                            'id'=>$j++,
//                            'name'=>$end
//                        ];
//                    }
//                    if (count($end_array)>0){
//                        array_push($times,$end_array);
//                    }
//                    if (!($start=='' and $end==''))
//                        $options->push([
//                            'id'=>$i,
//                            'name'=>$day_name.' - '.CalendarUtils::strftime('Y/m/d',$day),
//                            'times'=>$times,
//                        ]);
//                }
//            }
//            return response()->json(
//                $options
//            );
//        }catch(\Exception $e){
//            return response([
//                'data'=>$e->getMessage(),
//                'status'=>'fail'
//            ],422);
//        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Address $address
     * @return \Illuminate\Http\Response
     */
    public function edit(Address $address)
    {
        //
    }

    public function get_post_area()
    {
        try {
            $areas = Peyk::where('market_id', 1)->where('id', '!=', 0)->select('id', 'zones', 'outOfCity')->get();
            $market = get_market(1);
            return response([
                'areas' => $areas,
//                    'tower_deliver_peykPrice'=>$market->tower,
                'incity_express_peykPrice_threshold' => $market->incity_express_peykPrice_threshold,
                'incity_scheduled_peykPrice_threshold' => $market->incity_scheduled_peykPrice_threshold,
                'status' => 'ok'
            ], 200);
        } catch (\Exception $e) {
            return response([
                'data' => $e->getMessage(),
                'status' => 'fail'
            ], 422);
        }

    }

    public function calculateShipment(Request $request)
    {
        try {
            $validData = Validator::make($request->all(), [
                'peyk_id' => 'required|exists:peyks,id',
                'totalPrice' => 'required|integer',
                'sendMethod' => ['required',
                    Rule::in(["express", "verbal", "scheduled"])
                ],
            ]);
            if ($validData->fails()) {
                return response()->json([
                    'data' => $validData->messages()->all(),
                    'message' => "اطلاعات وارد شده نامعتبر است.",
                    'status' => "invalid"
                ], 422);
            }
            $peyk_id = fa2en($request->peyk_id);
            $totalPrice = fa2en($request->totalPrice);
            $sendMethod = $request->sendMethod;
            $price = 0;
            $shippingTime = 0;
            //strait delivery has zero price
            if ($sendMethod == 'varbal' or $peyk_id == "0") {
                return response()->json([
                    'data' => [
                        'price' => $price,
                        'totalPrice' => $totalPrice,
                        'shippingTime' => $shippingTime
                    ],
                    'status' => 'ok'
                ], 200);
            }
            $peyk = Peyk::where('id', $peyk_id)->where('market_id', 1)->first();

            $market = get_market(1);
            $shippingTime = $peyk->shippingTime;
            if ($peyk) {
                if (!$peyk->outOfCity) {
                    if (($sendMethod === 'express' and $totalPrice < $market->incity_express_peykPrice_threshold)
                        or
                        ($sendMethod === 'scheduled' and $totalPrice < $market->incity_scheduled_peykPrice_threshold)) {
                        $price += $peyk->price;
                    }
                } else {
                    $price += $peyk->price;
                }
            }
            $totalPrice += $price;
            return response([
                'data' => [
                    'price' => $price,
                    'totalPrice' => $totalPrice,
                    'shippingTime' => $shippingTime
                ],
                'status' => 'ok'
            ], 200);
        } catch (\Exception $e) {
            return response([
                'data' => [],
                'message' => $e->getMessage(),
                'status' => 'fail'
            ], 422);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Address $address
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Address $address)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Address $address
     * @return \Illuminate\Http\Response
     */
    public function destroy(Address $address)
    {
    }
}
