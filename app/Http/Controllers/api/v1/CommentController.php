<?php

namespace App\Http\Controllers\Api\v1;

use App\Comment;
use App\Order;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    protected function user()
    {
        return auth()->guard('api')->user();
    }

    public function store(Request $request)
    {
        try {
            $validData = Validator::make($request->all(), [
                'comment' => 'required|min:3|max:150',
                'id' => 'required|exists:orders,id'
            ], [
                'id.exists' => 'خطا! سفارش یافت نشد.'
            ]);
            if ($validData->fails()) {
                return response()->json([
                    'data' => $validData->messages()->all(),
                    'message' => "اطلاعات وارد شده نامعتبر است.",
                    'status' => "invalid"
                ], 422);
            }
            $request_id = fa2en($request->id);
            $request_comment = fa2en($request->comment);
            $user = $this->user();
            $order = Order::where('id', $request_id)->where('user_id', $user->id)->first();
            if (!$order) {
                return response([
                    'data' => [],
                    'message' => 'خطا! سفارش یافت نشد.',
                    'status' => 'fail'
                ]);
            }
            if ($user) {
                $message = 'نظر شما با موفقیت دریافت شد.';
                $comment = Comment::where('user_id', $user->id)->where('order_id', $request_id)->where('market_id', 1)->first();
                if ($comment) {
                    $message = "نظر شما قبلاً دریافت شده است";
                    return response([
                        'data' => [],
                        'message' => $message,
                        'status' => 'fail'
                    ], 422);
                } else {

                    $comment = new Comment();
                    $comment->market_id = 1;
                    $comment->user_id = $user->id;
                    $comment->order_id = $order->id;
                    $comment->name = $order->name;
                    $comment->text = $request_comment;
                    $comment->admin_reply = "";
                    $comment->status = "1";
                    $comment->private = "0";
                    $comment->save();
                }
                return response([
                    'data' => [],
                    'message' => $message,
                    'status' => 'ok'
                ]);

            } else {
                return response([
                    'data' => [],
                    'message' => 'خطایی رخ داد.',
                    'status' => 'fail'
                ]);
            }
        } catch (\Exception $e) {
            return response([
                'data' => [],
                'message' => $e->getMessage(),
                'status' => 'fail'
            ]);
        }
    }
}
