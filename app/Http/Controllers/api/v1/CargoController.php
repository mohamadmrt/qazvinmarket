<?php

namespace App\Http\Controllers\api\v1;

use App\Cargo;
use App\Http\Controllers\Controller;
use App\Http\Resources\v1\CargoCollection;
use App\Token;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Console\Input\Input;

class CargoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $validData = Validator::make($request->all(), [
            'parent_id' => 'required|exists:menus,id',
            'page' => 'required|integer',

        ]);
        if ($validData->fails()) {
            return response()->json([
                'data' => $validData->messages()->all(),
                'message' => "اطلاعات وارد شده نامعتبر است.",
                'status' => "invalid"
            ], 422);
        }


        try {
            $cargos = Cargo::getByParent(fa2en($request->parent_id),$request->filter)->paginate(20);
            return response()->json([
                'status' => 'ok',
                'priceUnit' => 'تومان',
                'cargos' => CargoCollection::collection($cargos),
                'paginate' => [
                    'total' => $cargos->total(),
                    'current' => $cargos->currentPage(),
                    'last_page' => $cargos->lastPage(),
                    'per_page' => $cargos->perPage(),
                ]
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'data' => $e->getMessage(),
                'status' => 'fail'
            ], 422);
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
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return JsonResponse
     */
    public function show($id)
    {
        try {
            $validData = Validator::make(['cargo' => \request()->route('cargo')], [
                'cargo' => 'required|exists:cargos,id',
            ]);
            if ($validData->fails()) {
                return response()->json([
                    'data' => $validData->messages()->all(),
                    'message' => "اطلاعات وارد شده نامعتبر است.",
                    'status' => "invalid"
                ], 422);
            }
            $cargos = Cargo::getCargo($id);
            return response()->json(
                new CargoCollection($cargos)
            );
        } catch (Exception $e) {
            return response()->json([
                'data' => '[]',
                'msg' => $e->getMessage(),
                'status' => 'fail'
            ], 422);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Cargo $cargo
     * @return \Illuminate\Http\Response
     */
    public function edit(Cargo $cargo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Cargo $cargo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cargo $cargo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Cargo $cargo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cargo $cargo)
    {
        //
    }
}
