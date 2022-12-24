<?php



    namespace App\Http\Controllers\Admin;



    use App\Coupon;

    use App\Http\Resources\v1\ocms\CouponCollection;

    use Carbon\Carbon;

    use Illuminate\Http\Request;

    use App\Http\Controllers\Controller;

    use Illuminate\Support\Facades\Validator;

    use Morilog\Jalali\CalendarUtils;



    class CouponController extends Controller

    {

        public function index(){

            return view('ocms.Coupon.coupons');

        }

        public function couponsList(Request $request){

            $coupons=Coupon::search($request->params)->latest()->paginate(20);

            return response([

                'status'=>'OK',

                'coupons'=>CouponCollection::collection($coupons),

                'paginate'=>[

                    'total' => $coupons->total(),

                    'count' => $coupons->count(),

                    'per_page' => $coupons->perPage(),

                    'current_page' => $coupons->currentPage(),

                    'last_page' => $coupons->lastPage()

                ],

            ]);



        }

        //get_copons_list for groups define select

        public function get_copons_list(){

            $coupons=Coupon::where('status','1')->where('id','!=',0)->orderBy('title')->get(['id','title']);

            return response([

                'status'=>'ok',

                'coupons'=>$coupons,

            ]);



        }



        public function show(Coupon $coupon)

        {

            try{

                return response([

                    'data'=>new CouponCollection($coupon),

                    'status'=>'ok'

                ]);

            }catch(\Exception $e){

                return response([

                    'data'=>$e->getMessage(),

                    'status'=>'fail'

                ],422);

            }

        }



        public function store(Request $request){

            try{



                $inputs=array();

                $data=parse_str($request->form,$inputs);

                $message='کد تخفیف با موفقیت ایجاد شد';

                $status="1";

                $start_date=CalendarUtils::createCarbonFromFormat("Y/m/d  H:i:s",fa2en($inputs['start_date']));

                $end_date=CalendarUtils::createCarbonFromFormat("Y/m/d  H:i:s",fa2en($inputs['end_date']));

                if (!($start_date<=$end_date and $end_date>Carbon::now()))

                    return response()->json([

                        'data'=>[],

                        'status'=>'fail',

                        'message'=>'تاریخ شروع و پایان معتبر نیست!'

                    ],422);

                if (!array_key_exists('status',$inputs)){

                    $status="0";

                }

                if ($request->id==0){

//                    $validator=Validator::make($inputs,[

//                        'discount_amount' => 'required|numeric' ,

//                        'max_count' => 'required|numeric' ,

//                        'code' => 'required|unique:coupons,code,' ,

//                        'max_discount' => 'required|numeric' ,

//                        'min_price' => 'required|numeric' ,

//                        'title' => 'required' ,

//                        'start_date' => 'required' ,

//                        'end_date' => 'required' ,

//                    ]);

//                    if ($validator->fails()) {

//                        return ['message' => $validator->errors() , 'state' => 'fails'];

//                    }

                    Coupon::create([

                        'market_id'=>1,

                        'user_id'=>auth()->guard('admin')->user()->id,

                        'title'=>$inputs['title'],

                        'code'=>$inputs['code'],

                        'min_price'=>$inputs['min_price'],

                        'max_count'=>$inputs['max_count'],

                        'max_discount'=>$inputs['max_discount'],

                        'discount_type'=>$inputs['discount_type'],

                        'discount_amount'=>$inputs['discount_amount'],

                        'status'=>$status,

                        'start_date'=>$start_date,

                        'end_date'=>$end_date,

                    ]);



                }else{

                    $coupon=Coupon::find(fa2en($request->id));

//                    $validator=Validator::make($inputs,[

//                        'discount_amount' => 'required|numeric' ,

//                        'max_count' => 'required|numeric' ,

//                        'code' => 'required|unique:coupons,code,'.$coupon ,

//                        'max_discount' => 'required|numeric' ,

//                        'min_price' => 'required|numeric' ,

//                        'title' => 'required' ,

//                        'start_date' => 'required' ,

//                        'end_date' => 'required' ,

//                    ]);

//                    if ($validator->fails()) {

//                        return ['message' => $validator->errors() , 'state' => 'fails'];

//                    }

                    $coupon->update([

                        'title'=>fa2en($inputs['title']),

                        'code'=>fa2en($inputs['code']),

                        'min_price'=>fa2en($inputs['min_price']),

                        'max_count'=>fa2en($inputs['max_count']),

                        'max_discount'=>fa2en($inputs['max_discount']),

                        'discount_type'=>fa2en($inputs['discount_type']),

                        'discount_amount'=>fa2en($inputs['discount_amount']),

                        'status'=>$status,

                        'start_date'=>CalendarUtils::createCarbonFromFormat("Y/m/d  H:i:s",fa2en($inputs['start_date'])),

                        'end_date'=>CalendarUtils::createCarbonFromFormat("Y/m/d  H:i:s",fa2en($inputs['end_date'])),

                    ]);

                    $message="تغییرات با موفقیت اعمال شد";

                }

                return response()->json([

                    'data'=>[],

                    'status'=>'ok',

                    'message'=>$message

                ]);

            }catch(\Exception $e){

                return response()->json([

                    'data'=>$e->getMessage(),

                    'status'=>'fail'

                ],422);

            }

        }



        public function destroy(Coupon $coupon){



            if ($coupon->delete()){

                {

                    return response()->json([

                        'data'=>[],

                        'message'=>"فیلد مورد نظر حذف شد",

                        'status'=>'ok'

                    ]);

                }



            }

            return response()->json([

                'data'=>[],

                'message'=>"عملیات  معتبر نیست",

                'status'=>'fail'

            ],422);



        }

    }

