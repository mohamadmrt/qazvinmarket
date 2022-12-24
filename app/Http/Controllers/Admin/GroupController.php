<?php

    namespace App\Http\Controllers\Admin;

    use App\City;
    use App\Group;
    use App\Http\Resources\v1\ocms\GroupCollection;
    use App\Market;
    use Carbon\Carbon;
    use Illuminate\Http\Request;
    use App\Http\Controllers\Controller;
    use Illuminate\Support\Facades\Validator;
    use Morilog\Jalali\CalendarUtils;

    class GroupController extends Controller
    {
        public function index(){
            return view('ocms.Group.groups');
        }
        public function groupsList(){
            $groups=Group::latest()->get();
            return response([
                'status'=>'ok',
                'groups'=>GroupCollection::collection($groups),
            ]);

        }

        public function show(Group $coupon)
        {
            try{
                return response([
                    'data'=>new GroupCollection($coupon->with('coupon')->first()),
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

                $message='گروه با موفقیت ایجاد شد';
                $status="1";
                $inputs=array();
                $data=parse_str($request->form,$inputs);
                if (!array_key_exists('status',$inputs)){
                    $status="0";
                }
                if ($request->id==0){
                    Group::create([
                        'admin_id'=>auth()->guard('admin')->user()->id,
                        'coupon_id'=>(int)fa2en($inputs['coupon_id']),
                        'title'=>fa2en($inputs['title']),
                        'status'=>$status,
                    ]);

                }else{
                    $coupon=Group::find(fa2en($request->id));
                    $coupon->update([
                        'admin_id'=>auth()->guard('admin')->user()->id,
                        'coupon_id'=>(int)fa2en($inputs['coupon_id']),
                        'title'=>fa2en($inputs['title']),
                        'status'=>$status,
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

        public function destroy(Group $group){
if ($group->id!=1){
    if ($group->delete()){
        {
            return response()->json([
                'data'=>[],
                'message'=>"فیلد مورد نظر حذف شد",
                'status'=>'ok'
            ]);
        }

    }
}else{
    return response()->json([
        'data'=>[],
        'message'=>"شما نمی توانید گروه پیش فرض را حذف کنید",
        'status'=>'fail'
    ],422);
}



        }
    }
