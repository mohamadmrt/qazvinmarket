<?php

    namespace App\Http\Controllers\Admin;

    use App\City;
    use App\Holiday;
    use App\Http\Controllers\Functions\FunctionController;
    use App\Http\Resources\v1\ocms\HolidayCollection;
    use App\Market;
    use Carbon\Carbon;
    use Illuminate\Http\Request;
    use App\Http\Controllers\Controller;
    use Illuminate\Support\Facades\Validator;
    use Morilog\Jalali\CalendarUtils;

    class HolidayController extends Controller
    {
        public function index(){
            return view('ocms.Holiday.holidays');
        }
        public function holidaysList(Request $request){
            $holidays=Holiday::where('market_id',1)->with('admin')->orderBy('id','Desc')->paginate(20);
            return response([
                'status'=>'OK',
                'holidays'=>HolidayCollection::collection($holidays),
                'paginate'=>[
                    'total' => $holidays->total(),
                    'count' => $holidays->count(),
                    'per_page' => $holidays->perPage(),
                    'current_page' => $holidays->currentPage(),
                    'last_page' => $holidays->lastPage()
                ],
            ]);

        }

        public function show(Holiday $holiday)
        {
            try{
                return response([
                    'data'=>new HolidayCollection($holiday),
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
                $message='تعطیلات با موفقیت ایجاد شد';
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
//                        'code' => 'required|unique:holidays,code,' ,
//                        'max_discount' => 'required|numeric' ,
//                        'min_price' => 'required|numeric' ,
//                        'title' => 'required' ,
//                        'start_date' => 'required' ,
//                        'end_date' => 'required' ,
//                    ]);
//                    if ($validator->fails()) {
//                        return ['message' => $validator->errors() , 'state' => 'fails'];
//                    }
                    Holiday::create([
                        'market_id'=>1,
                        'user_id'=>auth()->guard('admin')->user()->id,
                        'why_off'=>$inputs['why_off'],
                        'status'=>$status,
                        'start_gregorian'=>$start_date,
                        'end_gregorian'=>$end_date,
                    ]);

                }else{
                    $holiday=Holiday::find(fa2en($request->id));
//                    $validator=Validator::make($inputs,[
//                        'discount_amount' => 'required|numeric' ,
//                        'max_count' => 'required|numeric' ,
//                        'code' => 'required|unique:holidays,code,'.$holiday ,
//                        'max_discount' => 'required|numeric' ,
//                        'min_price' => 'required|numeric' ,
//                        'title' => 'required' ,
//                        'start_date' => 'required' ,
//                        'end_date' => 'required' ,
//                    ]);
//                    if ($validator->fails()) {
//                        return ['message' => $validator->errors() , 'state' => 'fails'];
//                    }
                    $holiday->update([
                        'market_id'=>1,
                        'admin_id'=>auth()->guard('admin')->user()->id,
                        'why_off'=>$inputs['why_off'],
                        'status'=>$status,
                        'start_gregorian'=>$start_date,
                        'end_gregorian'=>$end_date,
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

        public function destroy(Holiday $holiday){

            if ($holiday->delete()){
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
