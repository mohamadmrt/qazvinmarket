<?php

namespace App\Http\Controllers\Admin;

use App\Amazing;
use App\Cargo;
use App\Http\Controllers\Admin\Auth\AdminController;
use App\Http\Resources\v1\ocms\AmazingCollection;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Morilog\Jalali\CalendarUtils;

class AmazingController extends AdminController
{
    public function amazing()
    {
        return view('ocms.Amazing.amazings');
    }

    public function amazing_List(Request $request)
    {
        $amazings = Amazing::with('cargo')->orderBy('order', 'DESC')->get();
        return response([
            'status' => 'ok',
            'data' => AmazingCollection::collection($amazings),
//            'paginate' => [
//                'total' => $amazings->total(),
//                'count' => $amazings->count(),
//                'per_page' => $amazings->perPage(),
//                'current_page' => $amazings->currentPage(),
//                'last_page' => $amazings->lastPage()
//            ]
        ]);
    }

    public function add_amazing(Cargo $cargo, Request $request)
    {
        try {
            $validData = Validator::make($request->all(), [
                'id' => 'required|integer',
                'price' => "required",
                'start_date' => "required",
                'end_date' => "required",
            ]);
            if ($validData->fails()) {
                return response()->json([
                    'data' => $validData->messages()->all(),
                    'message' => "اطلاعات وارد شده نامعتبر است.",
                    'status' => "invalid"
                ], 422);
            }

            $start_at = CalendarUtils::createCarbonFromFormat('Y/m/d  h:i:s', fa2en($request->start_date));
            $end_at = CalendarUtils::createCarbonFromFormat('Y/m/d  h:i:s', fa2en($request->end_date));
            if (!($start_at <= $end_at and $end_at > Carbon::now()))
                return response()->json([
                    'data' => [],
                    'status' => 'fail',
                    'message' => 'تاریخ شروع و پایان معتبر نیست!'
                ], 422);

            if ($request->id > 0) {
                $amazing = Amazing::find($request->id);
                $amazing->update([
                    'market_id' => 1,
                    'cargo_id' => $cargo->id,
                    'price' => str_replace(',', '', $cargo->price),
                    'price_discount' => str_replace(',', '', fa2en($request->price)),
                    'status' => "1",
                    'start_at' => $start_at,
                    'end_at' => $end_at
                ]);
            } else {
                Amazing::create([
                    'market_id' => 1,
                    'cargo_id' => $cargo->id,
                    'price' => str_replace(',', '', $cargo->price),
                    'price_discount' => fa2en($request->price),
                    'status' => "1",
                    'start_at' => $start_at,
                    'end_at' => $end_at
                ]);
            }
            return response()->json([
                'data' => [],
                'message' => 'عملیات با موفقیت انجام شد',
                'status' => 'ok'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'data' => $e->getMessage(),
                'status' => 'fail'
            ], 422);
        }

    }

    public function show(Amazing $amazing)
    {
        try {
            return response()->json([
                'data' => new AmazingCollection($amazing),
                'status' => 'ok'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'data' => $e->getMessage(),
                'status' => 'fail'
            ], 422);
        }

    }

    public function delete_amazing(Amazing $amazing)
    {
        if ($amazing->delete()) {
            return response()->json([
                'data' => [],
                'message' => 'عملیات موفقیت آمیز بود',
                'status' => 'ok'
            ]);
        }
    }

    public function sort_amazings(Request $request)
    {

        try {
            $amazings_sort = array_reverse($request->amazings);
            $amazing_index = 0;
            foreach ($amazings_sort as $item) {
                $found_amazing = Amazing::find((int)$item);
                $found_amazing->update([
                    'order' => $amazing_index
                ]);
                $amazing_index++;
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
