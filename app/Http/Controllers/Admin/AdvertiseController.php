<?php

namespace App\Http\Controllers\Admin;

use App\Advertise;
use App\Http\Resources\v1\ocms\AdvertiseCollection;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Morilog\Jalali\CalendarUtils;

class AdvertiseController extends Controller
{


    public function index()
    {
        return view('ocms.Advertise.advertises');
    }

    public function advertise_list(Request $request)
    {
        $advertises = Advertise::with('market')->latest()->paginate(20);
        return response([
            'status' => 'ok',
            'data' => AdvertiseCollection::collection($advertises),
            'paginate' => [
                'total' => $advertises->total(),
                'count' => $advertises->count(),
                'per_page' => $advertises->perPage(),
                'current_page' => $advertises->currentPage(),
                'last_page' => $advertises->lastPage()
            ]
        ]);
    }

    public function show(Advertise $advertise)
    {
        try {
            return response()->json([
                'data' => new AdvertiseCollection($advertise),
                'status' => 'ok'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'data' => $e->getMessage(),
                'status' => 'fail'
            ], 422);
        }
    }

    public function store(Request $request)
    {
        try {

            if ($request->title == null or $request->url == null or $request->status == null or $request->start_date == null or $request->end_date == null){
                return response()->json([
                    'data' => [],
                    'status' => 'fail',
                    'message' => 'همه ی فیلد ها باید تکمیل شوند!'
                ], 422);
            }
            $file_name = '';
            if ($request->hasFile('image')) {
                $file_name = $request->File('image')->getClientOriginalName();
            }


            $start_at = CalendarUtils::createCarbonFromFormat('Y/m/d  h:i:s', convertPersianToEnglish($request->start_date));
            $end_at = CalendarUtils::createCarbonFromFormat('Y/m/d  h:i:s', convertPersianToEnglish($request->end_date));
            if ($start_at >= $end_at and $end_at < Carbon::now()) {
                return response()->json([
                    'data' => [],
                    'status' => 'fail',
                    'message' => 'تاریخ شروع و پایان معتبر نیست!'
                ], 422);
            }
            $status = $request->status == 'true' ? '1' : '0';
            if ($request->id > 0) {
                $advertise = Advertise::find($request->id);
                $advertise->update([
                    'market_id' => 1,
                    'admin_id' => auth()->guard('admin')->user()->id,
                    'title' => $request->title,
                    'url' => $request->url,
                    'status' => $status,
                    'start_at' => $start_at,
                    'end_at' => $end_at
                ]);
            } else {
                $advertise = Advertise::create([
                    'market_id' => 1,
                    'admin_id' => auth()->guard('admin')->user()->id,
                    'title' => $request->title,
                    'url' => $request->url,
                    'image'=>$file_name,
                    'status' => $status,
                    'start_at' => $start_at,
                    'end_at' => $end_at
                ]);
            }
             if ($request->hasFile('image')) {
                 $file_name = $request->File('image')->getClientOriginalName();
                 if (file_exists(public_path() . "/images/adver/$file_name")) {
                     unlink(public_path() . "/images/adver/$file_name");
                 }
                 $file = $request->File('image');
                 $file->storeAs('images/adver/', $file_name, 'local');
                 $advertise->image = $file_name;
                 $advertise->save();
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

    public function destroy(Advertise $advertise)
    {
        if (file_exists(public_path() . "/images/adver/$advertise->image"))
            unlink(public_path() . "/images/adver/$advertise->image");
        if ($advertise->delete()) {
            return response()->json([
                'data' => [],
                'message' => 'عملیات موفقیت آمیز بود',
                'status' => 'ok'
            ]);
        }
    }


}

