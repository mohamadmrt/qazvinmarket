<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Address;
use App\Http\Resources\v1\AddressCollection;
use App\Peyk;
use App\Token;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AddressController extends Controller
{
    protected function user()
    {
        return auth()->guard('api')->user();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $user = $this->user();
            if ($user) {
                $addresses = AddressCollection::collection(Address::where('user_id', $user->id)->with('peyk')->orderByDesc('is_default')->get());

                if (count($addresses) > 0) {
                    return response()->json([
                        'addresses' => $addresses,
                        'status' => 'ok'
                    ]);
                } else {
                    return response()->json([
                        'addresses' => [],
                        'status' => 'ok'
                    ]);
                }
            }

        } catch (\Exception $e) {
            return response()->json([
                'data' => [],
                'message' => $e->getMessage(),
                'status' => 'fail'
            ]);
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {

        try {
            $validData = Validator::make($request->all(), [
                'peyk_id' => 'required|exists:peyks,id',
                'label' => 'required|min:3',
                'address' => 'required|min:10',
                'is_default' => 'required|integer|between:0,1',

            ]);
            if ($validData->fails()) {
                return response()->json([
                    'data' => $validData->messages()->all(),
                    'message' => "اطلاعات وارد شده نامعتبر است.",
                    'status' => "invalid"
                ], 422);
            }
            $user = $this->user();
            if (fa2en($request->is_default)) {
                Address::query()->where('user_id', $user->id)->update(['is_default' => "0"]);
            }
            $address = Address::create([
                'user_id' => $user->id,
                'peyk_id' => fa2en($request->peyk_id),
                'label' => fa2en($request->label),
                'is_default' => fa2en($request->is_default) ? "1" : "0",
                'address' => fa2en($request->address)
            ]);
            return response()->json([
                'data' => ['id' => $address->id],
                'message' => 'آدرس با موفقیت ذخیره شد',
                'status' => 'ok'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                "data" => $e->getMessage(),
                'status' => 'fail'
            ], 422);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Address $address
     * @return \Illuminate\Http\Response
     */
    public function show(Address $address)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Address $address
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(Address $address)
    {
        $user = $this->user();
        if ($user) {
            return response()->json([
                "data" => new AddressCollection($address),
                'status' => "ok"
            ]);
        } else {
            return response()->json([
                "data" => "user not found",
                'status' => "fail"
            ], 422);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Address $address
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Address $address)
    {

        try {
            $validData = Validator::make($request->all(), [
                'peyk_id' => 'required|exists:peyks,id',
                'label' => 'required|min:3',
                'address' => 'required|min:10',
                'is_default' => 'required|integer|between:0,1',

            ]);
            if ($validData->fails()) {
                return response()->json([
                    'data' => $validData->messages()->all(),
                    'message' => "اطلاعات وارد شده نامعتبر است.",
                    'status' => "invalid"
                ], 422);
            }
            $user = $this->user();
            if ($user) {
                if ($request->is_default) {
                    Address::query()->where('user_id', $user->id)->update(['is_default' => "0"]);
                }
                $address->peyk_id = Peyk::find(fa2en($request->peyk_id))->id;
                $address->label = fa2en($request->label);
                $address->address = fa2en($request->address);
                $address->is_default = fa2en($request->is_default) ? "1" : "0";
                $address->save();
                return response()->json([
                    'data' => array(),
                    'message' => "آدرس با موفقیت ویرایش شد",
                    'status' => 'ok'
                ]);
            }
            return response()->json([
                'data' => [],
                'message' => 'user not found',
                'status' => 'fail'
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'data' => $e->getMessage(),
                'status' => 'fail'
            ], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Address $address
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Address $address)
    {
        try {
            $user = $this->user();
            if ($user and $address->user_id == $user->id) {
                if ($address->delete()) {
                    return response()->json([
                        'data' => [],
                        'status' => 'ok'
                    ], 200);
                }
            } else {
                return response()->json([
                    'data' => array(),
                    'message' => "user not found",
                    'status' => 'fail'
                ], 422);
            }

        } catch (\Exception $e) {
            return response()->json([
                'data' => $e->getMessage(),
                'status' => 'ok'
            ], 422);
        }

    }
}
