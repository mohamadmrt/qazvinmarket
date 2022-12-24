<?php

namespace App\Http\Controllers\api\v1;

use App\Amazing;
use App\Cargo;
use App\Coupon;
use App\GhasedakCode;
use App\GhasedakDiscount;
use App\Http\Controllers\Controller;
use App\Address;
use App\Http\Controllers\Functions\FunctionController;
use App\Market;
use App\Order;
use App\Peyk;
use App\Setting;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CouponController extends Controller
{


    public function coupon($coupon, Request $request)
    {
        try {
            $validData = Validator::make($request->all(), ['cargos' => 'required|array', 'cargos.*.id' => 'required|exists:cargos,id', 'cargos.*.count' => "required|integer|between:1,10",]);
            if ($validData->fails()) {
                return response()->json(['data' => $validData->messages()->all(), 'message' => "اطلاعات وارد شده نامعتبر است.", 'status' => "invalid"], 422);
            }
            $request_cargos = $request->cargos;
            $invoice_amount = $request->invoice_amount;


            $cargos_price = 0;
            foreach ($request_cargos as $request_cargo) {
                $count = $request_cargo['count'];
                $cargo = Cargo::where('id', fa2en($request_cargo['id']))->sellableCargos()->first();
                $amazing = Amazing::where('cargo_id', $cargo->id)->first();
                if ($amazing) {
                    $cargos_price += $count * ($amazing->price_discount);
                } else {
                    $cargos_price += $count * ($cargo->price_discount);
                }
            }
            $coupon = Coupon::findByCode($coupon);

            if (!$coupon) {
                return response()->json(['status' => 'fail', 'data' => [], 'message' => 'کد وارد شده معتبر نیست']);
            }
            if ($coupon->start_date > Carbon::now() or $coupon->end_date < Carbon::now()) {
                return response()->json(['status' => 'fail', 'data' => [], 'message' => 'زمان استفاده از کد تخفیف معتبر نیست']);
            }
            if ($coupon->used_count >= $coupon->max_count) {
                return response()->json(['status' => 'fail', 'data' => [], 'message' => 'تعداد استفاده بیشتر از حد مجاز است']);
            }
            if ($cargos_price < $coupon->min_price) {
                return response()->json(['status' => 'fail', 'data' => [], 'message' => 'حداقل مبلغ خرید برای این کدتخفیف ' . $coupon->min_price . ' میباشد']);
            }

            $cargos_discounted_price = 0;
            $discountable_price = 0;
            $deducted_price = 0;
//                $col=collect([]);
            if ($coupon->discount_type == 'percent') {
                $deducted_price = ($cargos_price * $coupon->discount_amount / 100);
                $discountable_price = $cargos_price - ($cargos_price * $coupon->discount_amount / 100);
                if ($deducted_price >= $coupon->max_discount) {
                    $deducted_price = $coupon->max_discount;
                    $discountable_price = $cargos_price - $coupon->max_discount;
                }
        
            } else {
                $deducted_price = $coupon->discount_amount;
                $discountable_price = $cargos_price - $coupon->discount_amount;
           
            }

            return response()->json(['status' => 'ok', //                    'cols'=>$col,
                'data' => $request_cargos, 'discountable_price' => $discountable_price, 'deducted_price' => $deducted_price + $cargos_discounted_price]);
        } catch (\Exception $e) {
            return response(['status' => 'fail', 'message' => 'خطایی رخ داد']);
        }


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
     * Display the specified resource.
     *
     * @param \App\Address $address
     * @return \Illuminate\Http\Response
     */
    public function show(Address $address)
    {
        //
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

}
