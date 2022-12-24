<?php

namespace App\Http\Controllers\Admin;

use App\Cargo;
use App\Http\Controllers\Admin\Auth\AdminController;
use App\Http\Resources\v1\ocms\CargoCollection;
use App\Market;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Morilog\Jalali\CalendarUtils;

class CargoController extends AdminController
{
    public function cargos()
    {
        return view('ocms.Cargo.cargos');
    }

    public function cargoList(Request $request)
    {
        $market = get_market(1);
        $selected = collect([]);
        if ($request['params']['search_by_name' ]){
            $cargos = Cargo::searchadmin($request->params)->WhereRaw("MATCH(name) AGAINST('".$request['params']['search_by_name']."')")->get();
        }else{
            $cargos = Cargo::searchadmin($request->params)->get();
        }
        if ($request->params['search_by_image'] == "1") {
            foreach ($cargos as $cargo) {
                if (file_exists(public_path() . '/images/imagefood/' . $market->folder_name . '/' . $cargo->id . '.' . $cargo->file_format.'?v='.$cargo->image_version)) {
                    $selected->push($cargo);
                }
            }
        } elseif ($request->params['search_by_image'] == "0") {
            foreach ($cargos as $key => $cargo) {
                if (!file_exists(public_path() . '/images/imagefood/' . $market->folder_name . '/' . $cargo->id . '.' . $cargo->file_format)) {
                    $selected->push($cargo);
                }
            }
        } else {
            $selected = $cargos;
        }
        $cargos = $selected;
        $cargos = $cargos->paginate(20);
        return response([
            'status' => 'ok',
            'cargos' => CargoCollection::collection($cargos),
            'paginate' => [
                'total' => $cargos->total(),
                'count' => $cargos->count(),
                'per_page' => $cargos->perPage(),
                'current_page' => $cargos->currentPage(),
                'last_page' => $cargos->lastPage()
            ],
        ]);
    }

    //toggle show cargo
    public function show_cargo(Cargo $cargo)
    {
        try {
            if ($cargo->status == '0') {
                $cargo->update(['status' => '1']);
            } else {
                $cargo->update(['status' => '0']);
            }
            return response([
                'data' => [],
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

    public function newest_cargo(Cargo $cargo)
    {
        try {
            if ($cargo->newest == '0') {
                $cargo->update(['newest' => '1']);
            } else {
                $cargo->update(['newest' => '0']);
            }
            return response([
                'data' => [],
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

    public function edit_cargo(Cargo $cargo)
    {
        try {
            return response([
                'data' => new CargoCollection($cargo),
                'status' => 'ok'
            ]);
        } catch (\Exception $e) {
            return response([
                'data' => $e->getMessage(),
                'status' => 'fail'
            ], 422);
        }
    }

    public function update_cargo(Request $request, Cargo $cargo)
    {
        try{
            if ($request->hasFile('image')){
                $image = $request->file('image');
                $image_name = $cargo->id.'.jpg';
                $image->move(public_path('/images/imagefood/qazvin/'),$image_name);


//                $file=$request->File('image');
//                $file->storeAs('images/imagefood/qazvin/',$cargo->id.'.jpg','local');
//                $cargo->file_format=$file->guessExtension();
            }

            $integers = array_map('intval', explode(',', $request->cargo_menu));
            if (count($integers)>0 and $integers[0]!=0)
                $cargo->menus()->sync($integers);


            if ($request->mfg_date !== null){
                $mfg_date = CalendarUtils::createCarbonFromFormat('Y/m/d  h:i:s', convertPersianToEnglish($request->mfg_date));
                $cargo->manufacturing_date=$mfg_date;
            }
            if ($request->exp_date !== null){
                $exp_date = CalendarUtils::createCarbonFromFormat('Y/m/d  h:i:s', convertPersianToEnglish($request->exp_date));
                $cargo->expiry_date=$exp_date;
            }


            $cargo->description=$request->description;
            $cargo->max_order=$request->max_order;
            $cargo->max_count=$request->max_count;

            $cargo->file_format='jpg';
            $cargo->price_discount=$request->price_discount;
            $cargo->newest=$request->newest=="true"?"1":"0";
            if ($request->newest=="true"){
                $cargo->newest_order=Carbon::now();
            }
            $cargo->status=$request->status=="true"?"1":"0";
            $cargo->mfg_date_show=$request->mfg_date_show=="true"?1:0;
            $cargo->exp_date_show=$request->exp_date_show=="true"?1:0;
            $cargo->image_version = $cargo->image_version + 1;
            $cargo->save();
            return response([
                'data'=>[],
                'status'=>'ok'
            ]);
        }catch(\Exception $e){
            return response([
                'data'=>$e->getMessage(),
                'status'=>'fail'
            ],422);
        }
    }
}
