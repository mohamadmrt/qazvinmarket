<?php

    namespace App\Http\Controllers\User\Auth;

    use App\Http\Controllers\Controller;
    use App\Http\Controllers\Functions\FunctionController;
    use App\Http\Controllers\Home\CartController;
    use App\Setting;
    use App\SMS;
    use App\User;
    use Illuminate\Auth\Authenticatable;
    use Illuminate\Foundation\Auth\AuthenticatesUsers;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Cookie;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Support\Facades\Validator;

    class UserLoginController extends Controller
    {
        use AuthenticatesUsers;
        protected $redirectTo = '/';
        /**
         * Create a new authentication controller instance.
         *
         * @return void
         */
        public function __construct()
        {
            $this->middleware('guest', ['except' => 'logout']);
        }
        public function userAuth(Request $request)
        {
            $request['username'] = fa2en($request['username']);
            $request['password'] = fa2en($request['password']);

            $validator=Validator::make($request->all(),[
                'username' => 'required|exists:users',
                'password' => 'required'
            ]);

            if ($validator->fails()) {
                return ['message' => $validator->errors() , 'state' => 'fails'];
            }
            $user=User::where('username',$request->username)->first();
            if ($user)
            {
                if (Hash::check($request->password,$user->password)){
                    if (auth()->guard("user")->attempt(['username' => $request->username, 'password' => $request->password],true)) {
                        return response([
                            'data'=>[],
                            'status' => 'ok'
                        ],200);
                    }
                }
            }
            return response([
                'data' => [],
                "message"=>"error",
                'status' => 'fail'
            ],422);
        }

        public function logout(){
            Auth::guard('user')->logout();
            Auth::guard('admin')->logout();

            Cookie::queue(Cookie::forget('token'));
            return redirect('/');
        }

    }
