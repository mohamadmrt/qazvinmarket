<?php

namespace App\Http\Controllers\Api\v1;
use App\Cargo;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Functions\FunctionController;
use App\Http\Resources\v1\CargoCollection;
use App\Http\Resources\v1\MenuCollection;
use App\Http\Resources\v1\UserResource;
use App\Menu;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class MenuController extends Controller
{
    public function index()
    {
        $menus=Menu::getMainGroup();
        foreach ($menus as $menu) {
            $subMenus = Menu::getSubParents($menu->id);
            $menu->subMenus=$subMenus;
        }
        $menus=MenuCollection::collection($menus);
        return response([
            'menus'=>$menus,
            'status'=>'ok'
        ],200);
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
     * @param  \Illuminate\Http\Request  $request
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $validData = Validator::make(['menu'=>\request()->route('menu')],[
                'menu' => 'required|exists:menus,id',
            ]);
            if ($validData->fails()){
                return response()->json([
                    'data'=>$validData->messages()->all(),
                    'message'=>"اطلاعات وارد شده نامعتبر است.",
                    'status'=>"invalid"
                ],422);
            }
            $cargos=Cargo::getByParent($id);
            return response()->json(
                CargoCollection::collection($cargos)
            );
        }catch (Exception $e){
            return response()->json([
                'data'=>'not found'
            ],422);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit(Menu $menu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Menu $menu)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu)
    {
        //
    }
}
