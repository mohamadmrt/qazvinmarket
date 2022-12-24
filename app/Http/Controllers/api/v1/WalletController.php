<?php

    namespace App\Http\Controllers\Api\v1;
    use App\Http\Resources\v1\WalletCollection;
    use App\Token;
    use App\Wallet;
    use Illuminate\Http\Request;
    use App\Http\Controllers\Controller;
    use Illuminate\Support\Facades\Validator;

    class WalletController extends Controller
    {
        protected function user(){
            return auth()->guard('api')->user();
        }
        public function walletList()
        {
            try{
                $user=$this->user();
                $wallets=Wallet::where('user_id',$user->id)->orderByDesc('id')->paginate(10);
                return response()->json([
                    'wallet_list'=>WalletCollection::collection($wallets),
                    'paginate'=>[
                        'total' => $wallets->total(),
                        'count' => $wallets->count(),
                        'per_page' => $wallets->perPage(),
                        'current_page' => $wallets->currentPage(),
                        'last_page' => $wallets->lastPage()
                    ],
                    'walletTotal'=>$user->wallet,
                    'status'=>'ok'
                ]);
            }catch(\Exception $e){
                return response([
                    'data'=>[],
                    'message'=>$e->getMessage(),
                    'status'=>'fail'
                ],422);
            }
        }
        public function walletCharge (Request $request){
            try{
                $validData = Validator::make($request->all(), [
                    'amount' => 'required|integer|min:1000',
                ]);
                if ($validData->fails()){
                    return response()->json([
                        'data'=>$validData->messages()->all(),
                        'message'=>"اطلاعات وارد شده نامعتبر است.",
                        'status'=>"invalid"
                    ],422);
                }
                $amount=fa2en($request->amount);
                $user=$this->user();

                $wallet=Wallet::insert($user->id,'0',$amount,$amount,'1','1','1','افزایش اعتبار بانک');
                if (!$wallet)
                    response()->json([
                        'data'=>[],
                        'message'=>'خطا در پردازش. دوباره تلاش نمایید.',
                        'status'=>'fail'
                    ],422);

                $exist_token=Token::where('user_id',$user->id)->first();
                $token = auth()->guard('api')->login($user);
                if(!$exist_token){
                    Token::create([
                        'user_id'=>$user->id,
                        'jwt'=>$token,
                        'ipg_token'=>bcrypt($user->id),
                    ]);
                }else{
                    $exist_token->update([
                        'jwt'=>$token,
                        'ipg_token'=>bcrypt($user->id)
                    ]);
                }
                $source="&source=pwa";
                if ($request->header('source')) {
                    $source = "&source=".$request->header('source');
                }
                $callback_url=env('MELLAT_CALLBACK_URL_WALLET_INCREASE').'/'.$wallet->id."?token=".$exist_token->ipg_token.$source;
                $res=MellatPay($wallet,$amount*10,$callback_url);
                if($res[0]==0){
                    $wallet->update(['RefId'=>$res[1]]);
                    return  response()->json([
                        'payment_url'=>env('MELLAT_PAYMENT_GATE')."?RefId=$res[1]&MobileNo=$user->username",
                        'status'=>'ok',
                        'action'=>"mellatPay",
                    ]);
                }else{
                    return response()->json([
                        'data'=>[],
                        'message'=>'اتصال به درگاه امکان پذیر نمی باشد',
                        'status'=>'fail'
                    ],422);
                }
            }catch(\Exception $e){
                return response()->json([
                    'data'=>[],
                    'message'=>$e->getMessage(),
                    'status'=>'fail'
                ]);
            }
        }
    }
