<?php

namespace App\Http\Controllers\Api\v1;

use App\Advertise;
use App\Amazing;
use App\Cargo;
use App\Comment;
use App\Http\Controllers\Controller;
use App\Http\Resources\v1\CargoCollection;
use App\Http\Resources\v1\CommentCollection;
use App\Http\Resources\v1\MarketResource;
use App\Market;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use function MongoDB\BSON\fromJSON;
use function PHPUnit\Framework\isJson;

class HomeController extends Controller
{
    public function testMrt(Request $request)
    {

    }
    protected function user()
    {
        return auth()->guard('api')->user();
    }

    public function index()
    {
        $cargos = Cargo::sellableCargos()->where('max_count','>',0);
        $amazings = clone $cargos;
        $newest = clone $cargos;
        $amazings_cargo_id = Amazing::select('cargo_id')->where('status','1')->where('start_at' ,'<', \Illuminate\Support\Carbon::now())->where('end_at' ,'>', Carbon::now())->orderBy('order', 'DESC')->get();
        $cargos = array();
        foreach ($amazings_cargo_id as $item){
            $cargo = Cargo::sellableCargos()->where('max_count','>',0)->find($item->cargo_id);
            if ($cargo){
                $cargos[] = $cargo;
            }
        }
        $amazings = CargoCollection::collection($cargos);
        $newest = CargoCollection::collection($newest->where('newest', "1")->inRandomOrder()->take(20)->get());
        $advertises = Advertise::select('url', 'image', 'title')->where('status', '1')->where('start_at', '<', Carbon::now())->where('end_at', '>', Carbon::now())->get();
        foreach ($advertises as $advertise) {
            $advertise->image = env('APP_URL') . "/images/adver/" . $advertise->image;
        }
        return response()->json([
            'data' => [
                'amazing' => $amazings,
                'newest' => $newest,
                'advertises' => $advertises,
            ],
            'status' => 'ok'
        ], 200);
    }

    public function market_info(Request $request)
    {
        $info = get_market(1);
        return response()->json([
            'market_info' => new MarketResource($info),
            'status' => 'ok'
        ], 200);
    }

    public function comments()
    {
        $comments = Comment::where('market_id', 1)
            ->where('status', "4")
            ->where('private', "0")
            ->where('text', '!=', '')
            ->orderBy('id', 'DESC')->take(10)->get();
        return response([
            'comments' => CommentCollection::collection($comments),
            'status' => 'ok',
        ], 200);
    }

    public function search(Request $request)
    {

        $validData = Validator::make($request->all(), [
            'page' => 'integer'
        ]);

        if ($validData->fails()) {
            return response()->json([
                'data' => $validData->messages()->all(),
                'message' => "اطلاعات وارد شده نامعتبر است.",
                'status' => "invalid"
            ], 422);
        }

        $request_q = fa2en($request->q);
        $request_bearerToken = $request->bearerToken();
        if ($request_q == '' or $request_q == null or $request_q == 'null') {
            $cargos = Cargo::sellableCargos()->get();
        } else {
            $cargos1 = Cargo::where('name', 'like', '%' . $request_q . '%')
                ->orderByRaw("CASE WHEN name LIKE '" . $request_q . "%' THEN 1 WHEN name LIKE '%" . $request_q . "' THEN 3 ELSE 2 END")
                ->where('price', '>', 0) ->where('status', '1')->orderBy('name')->get();
            $cargos2 = Cargo::WhereRaw("MATCH(name) AGAINST('" . $request_q . "' IN BOOLEAN MODE)")->where('price', '>', 0) ->where('status', '1')->orderBy('name')->get();
            $cargos = $cargos1->merge($cargos2);
        }

        $not_finished_cargos = $cargos->where('max_count', '>', '0');
        $finished_cargos = $cargos->where('max_count', '=', '0');
        $cargos = $not_finished_cargos->concat($finished_cargos);
        $cargos = CargoCollection::collection($cargos->paginate(20));
        $is_favorite = false;
        foreach ($cargos as $cargo) {
            if ($request_bearerToken) {
                $user = $this->user();
                if ($user) {
                    $user_favorites = $user->favorites;
                    if ($user_favorites->contains('cargo_id', $cargo->id)) {
                        $is_favorite = true;
                    }
                }
            }
            $cargo->is_favorite = $is_favorite;
        }

        return response()->json([
            'priceUnit' => 'تومان',
            "cargos" => $cargos,
            'paginate' => [
                'total' => $cargos->total(),
                'current' => $cargos->currentPage(),
                'last_page' => $cargos->lastPage(),
                'per_page' => $cargos->perPage(),
            ],
            'status' => 'ok'
        ], 200);
    }

    public function android()
    {
        return response([
            "version" => 2,
            "force" => false,
            "features" => [
                "new features",
                "bug fix",
                "add wallet"
            ],
            "url" => "http://google.com"
        ]);
    }
}
