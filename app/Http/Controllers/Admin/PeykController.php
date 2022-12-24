<?php

    namespace App\Http\Controllers\Admin;
    use App\City;
    use App\Http\Controllers\Admin\Auth\AdminController;
    use App\Http\Controllers\Functions\FunctionController;
    use App\Http\Resources\v1\ocms\PeykCollection;
    use App\Market;
    use App\Peyk;
    use Illuminate\Http\Request;

    class PeykController extends AdminController
    {
        public function peyks(){
            return view('ocms.Peyk.peyks');
        }

        public function index(){
            $peyks=Peyk::with('market')->latest()->paginate(20);
            return response()->json([
                'peyks'=>PeykCollection::collection($peyks),
                'paginate'=>[
                    'total' => $peyks->total(),
                    'count' => $peyks->count(),
                    'per_page' => $peyks->perPage(),
                    'current_page' => $peyks->currentPage(),
                    'last_page' => $peyks->lastPage()
                ],
                'status'=>'ok',
            ]);
        }

        public function show(Peyk $peyk)
        {
            try {
                return response()->json([
                    'data' => $peyk,
                    'status' => 'ok'
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'data' => $e->getMessage(),
                    'status' => 'fail'
                ], 422);
            }

}
        public function store(Request $request){
            try {
                $zones = fa2en($request->zones);
                $market=get_market(fa2en($request->market_id));
                $message='منطقه مورد نظر اضافه شد';
                $status="0";
                if ($request->status=='true')
                    $status='1';
                if ($request->id!='0'){
                    $peyk=Peyk::find((int)$request->id);
                    $peyk->update([
                        'zones'=>$zones,
                        'market_id'=>$market->id,
                        'price'=>fa2en($request->price),
                        'shippingTime'=>fa2en($request->shippingTime),
                        'courier'=>fa2en($request->courier),
                        'outOfCity'=>fa2en($request->outOfCity),
                        'status'=>$status
                    ]);
                    $message='ویرایش با موفقیت انجام شد';
                }else{
                    Peyk::create([
                        'zones'=>$zones,
                        'market_id'=>$market->id,
                        'price'=>fa2en($request->price),
                        'shippingTime'=>fa2en($request->shippingTime),
                        'courier'=>fa2en($request->courier),
                        'outOfCity'=>fa2en($request->outOfCity),
                        'status'=>$status
                    ]);
                }

                return response()->json([
                    'data' => [],
                    'message'=>$message,
                    'status' => 'ok'
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'data' =>[],
                    'message' => $e->getMessage(),
                    'status' => 'fail'
                ], 422);
            }
        }

        public function destroy(Peyk $peyk){
            try{
                if ($peyk->delete()){
                    return response([
                        'data'=>[],
                        'status'=>'ok',
                        'message'=> "منطقه مورد نظر حذف شد"
                    ]);
                }
            }catch(\Exception $e){
            return response([
            'data'=>$e->getMessage(),
            'status'=>'fail'
            ],422);
            }
        }
    }
