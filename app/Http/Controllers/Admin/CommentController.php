<?php

namespace App\Http\Controllers\Admin;

use App\Comment;
use App\Http\Controllers\Admin\Auth\AdminController;
use App\Http\Controllers\Functions\FunctionController;
use App\Http\Resources\v1\ocms\CommentCollection;
use App\Market;
use App\Order;
use App\Setting;
use App\Sms;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentController extends AdminController
{
    public function comments(){
        return view('ocms.Comment.comment');
    }

    public function commentList(Request $request){
        $comments=Comment::search($request->params)->with('market')->with('user')->with('order')->orderby('id','desc')->paginate(20);
        return response([
            'comments'=>CommentCollection::collection($comments),
            'paginate'=>[
                'total' => $comments->total(),
                'count' => $comments->count(),
                'per_page' => $comments->perPage(),
                'current_page' => $comments->currentPage(),
                'last_page' => $comments->lastPage()
            ],
            'status'=>'ok'
        ]);
    }


    public function reply_admin(Comment $comment,Request $request){
        $text =fa2en($request->text);
        $order=Order::find($comment->order_id);
        $tel = $order->tel;
        $market=get_market(1);
        $comment->update([
            'replied_at'=>Carbon::now(),
            'admin_reply'=>$text,
            'status'=>'4'
        ]);
        if (strlen($tel)==11 && preg_match('/(09)[0-9]{9}/', $tel, $matches))
        {
            $text = "پاسخ $market->name به نظر شما :" . $text;
            Sms::insert($order->id,$tel,$text);
        }
        return response()->json([
            'data'=>[],
            'message'=>'با موفقیت ذخیره شد',
            'status'=>'ok'
        ]);
    }
    public function approve_comment(Comment $comment){
        if ($comment->status!='4'){
            $comment->update([
                'status'=>'4'
            ]);
        }else{
            $comment->update([
                'status'=>'1'
            ]);
        }
        return response()->json([
            'data'=>[],
            'message'=>'با موفقیت ذخیره شد',
            'status'=>'ok'
        ]);
    }

    public function delete_comment(Comment $comment)
    {
        try{
            if ($comment->delete())
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
