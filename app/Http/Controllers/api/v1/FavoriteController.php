<?php

namespace App\Http\Controllers\api\v1;
use App\Cargo;
use App\Cart;
use App\Favorite;
use App\Http\Controllers\Controller;
use App\Address;
use App\Http\Controllers\Functions\FunctionController;
use App\Http\Resources\v1\CargoCollection;
use App\Token;
use App\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use phpDocumentor\Reflection\Types\Array_;

class FavoriteController extends Controller
{
    protected function user(){
        return auth()->guard('api')->user();
    }
    /**
     * Display a listing of the resource.
     *
     * @return Application|ResponseFactory|Response
     */
    public function index()
    {
        $user=$this->user();

        $favorites=Favorite::where('user_id',$user->id)->pluck('cargo_id');

        $db_cargos=Cargo::whereIn('id',$favorites)->sellableCargos()->orderBy('max_count','DESC')->paginate(8);
        $cargos = CargoCollection::collection($db_cargos);

//            $carts=Cart::where('user_id',$user->id)->get();
//            $cargos = collect([]);

//            foreach ($db_cargos as $db_cargo) {
//                $cargo = collect(new CargoCollection($db_cargo));
//                $cargo->put('count', 0);
//                foreach ($carts as $cart){
//
//                    if ($cargo['id']==$cart->cargo_id){
//                        $cargo->put('count',$cart->count);
//                    }
//                }
//                $cargos->push($cargo);
//            }
//            return response([
//                'data' =>$cargos->paginate(10),
//                'status' => 'ok'
//            ], 200);

        return response([
            'data' => $cargos,
            'paginate' => [
                'total' => $cargos->total(),
                'count' => $cargos->count(),
                'per_page' => $cargos->perPage(),
                'current_page' => $cargos->currentPage(),
                'last_page' => $cargos->lastPage()
            ],
            'status' => 'ok'
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $validData = Validator::make($request->all(), [
                'cargo' => 'required|exists:cargos,id',
            ]);
            if ($validData->fails()){
                return response()->json([
                    'data'=>$validData->messages()->all(),
                    'message'=>"اطلاعات وارد شده نامعتبر است.",
                    'status'=>"invalid"
                ],422);
            }
            $user=$this->user();
            $request_cargo=fa2en($request->cargo);
            $cargo=Cargo::where('id',$request_cargo)->first();
            $is_favorite=false;
            if ($user and $cargo) {
                $favorite=Favorite::where('cargo_id',$cargo->id)->first();
                if ($favorite){
                    $favorite->delete();
                }else{
                    Favorite::create([
                        'user_id'=>$user->id,
                        'cargo_id'=>$cargo->id,
                    ]);
                    $is_favorite=true;
                }
                return response()->json([
                    'data' => [],
                    'is_favorite'=>$is_favorite,
                    'status' => 'ok'
                ], 200);
            }else{
                return response()->json([
                    'data' =>[],
                    'status' => 'fail'
                ], 422);
            }
        }catch (\Exception $e){
            return response()->json([
                "data"=>$e->getMessage(),
                'status'=>'fail'
            ],422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param $token
     * @return void
     */
    public function show($token)
    {
    }


    public function edit(Favorite $favorite)
    {
        //
    }


    public function update(Request $request, Favorite $favorite)
    {
        //
    }

    public function destroy(Favorite $favorite)
    {


    }
}
