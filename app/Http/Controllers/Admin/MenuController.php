<?php

namespace App\Http\Controllers\Admin;

use App\Cargo;
use App\Http\Controllers\Admin\Auth\AdminController;
use App\Http\Resources\v1\ocms\MenuCollection;
use App\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class MenuController extends AdminController
{
    public function menus()
    {
        return view('ocms.Menu.menus');
    }

    public function menuList(Request $request)
    {
        $menus = Menu::getMainGroupAdmin();
        foreach ($menus as $menu) {
            $subs = Menu::getSubParentsAdmin($menu->id);
            $menu->sub_menu = $subs;
        }
        $menus = MenuCollection::collection($menus);
        return response([
            'status' => 'ok',
            'menus' => $menus,
        ]);
    }

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

    public function add_menu(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' =>
                Rule::unique('menus', 'name')->where(function ($query) {
                    return $query->where('market_id', Auth::guard('resturant')->user()->id);
                })
        ]);

        if ($validator->fails())
            return response()->json([
                'data' => [],
                'message' => $validator->errors(),
                'status' => "fail"
            ], 422);

        $request['status'] == 'true' ? $status = "1" : $status = "0";


        $menus = Menu::where('market_id', 1)->where('parent_id', 0);
        $ord = $menus->max('ord') + 1;
        if ($request->menu_id > 0) {
            $menu = Menu::find($request->menu_id);
            $menu->update([
                'name' => $request->menu_name,
                'market_id' => 1,
                'status' => $status,
            ]);
        } else {
            $menu = Menu::create([
                'name' => $request->menu_name,
                'ord' => $ord,
                'market_id' => 1,
                'status' => $status,
            ]);
        }

        if ($request->hasFile('image')) {
            $extention = $request->File('image')->getClientOriginalExtension();
            array_map('unlink', glob(public_path() . "/images/parents/qazvin/$menu->id.*"));
            $file = $request->File('image');
            $file->storeAs('images/parents/qazvin/', $menu->id . '.' . $extention, 'local');
        }
        $menu->save();
        return response()->json([
            'data' => [],
            'message' => "منو اضافه شد",
            'status' => "ok"
        ]);
    }

    public function add_sub_menu(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' =>
                Rule::unique('menus', 'name')->where(function ($query) {
                    return $query->where('market_id', Auth::guard('resturant')->user()->id);
                })
        ]);

        if ($validator->fails())
            return response()->json([
                'message' => $validator->errors(),
                'state' => 'invalid'
            ]);

        $parent = Menu::find($request->sub_menu_parent);
        if (!$parent or !$request->sub_menu_name)
            return response()->json([
                'data' => '',
                'message' => 'عملیات نامعتبر است',
                'state' => 'fail'
            ]);
        $request['sub_menu_status'] == 'true' ? $status = "1" : $status = "0";
        $menuParents = Menu::where('market_id', 1)->where('parent_id', $request->sub_menu_parent);
        $ord = $menuParents->max('ord') + 1;
        $menu = Menu::where('id', $request->sub_menu_id)->first();
        if ($menu) {
            $menu->update(['name' => $request->sub_menu_name, 'status' => $status, 'parent_id' => $parent->id]);
            return response()->json([
                'data' => [],
                'message' => 'زیرمنو با موفقیت ویرایش شد',
                'status' => 'ok'
            ]);
        } else {
            Menu::create([
                'market_id' => 1,
                'name' => $request->sub_menu_name,
                'ord' => $ord,
                'status' => $status,
                'parent_id' => $parent->id
            ]);
            return response()->json([
                'data' => [],
                'message' => 'زیرمنو با موفقیت اضافه شد',
                'status' => 'ok'
            ]);
        }

    }

    public function delete_menu(Menu $menu)
    {
        try {
            if ($menu->delete())
                return response([
                    'data' => [],
                    'status' => 'ok'
                ]);
            else
                return response([
                    'data' => [],
                    'status' => 'fail',
                    'message' => "منو یافت نشد"
                ], 422);
        } catch (\Exception $e) {
            return response([
                'data' => $e->getMessage(),
                'status' => 'fail'
            ], 422);
        }

    }

    public function menu_edit_modal_content(Menu $menu)
    {
        try {
            return response([
                'data' => $menu,
                'status' => 'ok'
            ]);
        } catch (\Exception $e) {
            return response([
                'data' => $e->getMessage(),
                'status' => 'fail'
            ], 422);
        }
    }

    public function sort_menu(Request $request)
    {
//            return
        try {
            $sub_menus = $request->sub_menus;
            $menus = $request->menus;
            $menus_index = 0;
            $sub_menus_index = 0;
            foreach ($menus as $menu) {
                $found_menu = Menu::find((int)$menu);
                $found_menu->update([
                    'ord' => $menus_index
                ]);
                DB::table('cargo_menu')->where('menu_id', $menu)->update([
                    'order' => $menus_index
                ]);
                $menus_index++;
            }
            foreach ($sub_menus as $sub_menu) {
                $found_sub_menu = Menu::find((int)$sub_menu);
                $found_sub_menu->update([
                    'ord' => $sub_menus_index
                ]);
                DB::table('cargo_menu')->where('menu_id', (int)$sub_menu)->update([
                    'order' => $sub_menus_index
                ]);
                $sub_menus_index++;
            }
            return response([
                'data' => [],
                'status' => 'ok'
            ]);
        } catch (\Exception $e) {
            return response([
                'data' => $e->getMessage(),
                'status' => 'fail'
            ], 422);
        }
    }
}
