<?php

    namespace App\Http\Controllers\Admin\Auth;

    use App\Admin;
    use App\Http\Controllers\Functions\session;
    use App\Market;
    use App\Sms;
    use Illuminate\Foundation\Auth\AuthenticatesUsers;
    use Illuminate\Http\Request;
    use App\Http\Controllers\Controller;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Hash;

    class AdminLoginController extends Controller
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
            $this->middleware('adminGuest', ['except' => 'logout']);
        }
        public function getAdminLogin(){
            return view('ocms.Auth.login');
        }
        public function adminAuth(Request $request)
        {
            $request['username'] = fa2en($request['username']);
            $request['password'] = fa2en($request['password']);

            $url=session()->get('url');

            $this->validate($request, [
                'username' => 'required',
                'password' => 'required',
            ]);
            $market=Market::find(1);
            $admin=Admin::where('username',$request->username)->where('market_id',$market->id)->first();

            if ($admin and Hash::check($request->password,$admin->password)){
                if (! $admin->password){
                    $admin->password = Hash::make($request->password);
                    $admin->save();
                }
                if (auth()->guard('admin')->attempt(['username' => $request->input('username'), 'password' => $request->input('password')])){
                    session()->forget('ADLoginERR');
                    $time_enter =  jdate(time())->format('Y/m/d - H:i:s');
                    $message ="هشدار!!"."\n\r"."ورود به پنل ".$market->name."\n\r"."تاریخ: ".$time_enter."آی پی: ".$request->ip();
                    Sms::Adminlogin('0',env('ADMIN_MOBILE_NUMBER'),$message);

                    if (session()->has('url'))
                        return redirect($url)->with(compact('market'));
                    else

                        return redirect()->route('ocms.dashboard');
                }
            }

            session()->put('ADLoginERR','رمز عبور اشتباه است');
            return back();

        }

        public function logout()
        {
            Auth::guard('admin')->logout();
            return redirect('/');
        }

    }
