<?php

    namespace App\Http\Controllers\User;

    use App\Market;
    use App\User;
    use App\Http\Controllers\Controller;

    class UserController extends Controller
    {
        public function __construct(){
            $this->middleware('auth:user');
        }

        public function dashboard(){
            $market=get_market(1);
            return view('user.dashboard',compact('market'));
        }

        public function buyList(){
            return view('user.Buy.buyList');
        }
        public function transactionList(){
            return view('user.Transaction.transactionList');
        }

        public function point(){
            $market=get_market(1);
            return view('user.Point.point',compact('market'));
        }

        public function referral(){
            if (auth()->user()->code_friends == ''){
                $code=User::max('code_friends');
                $random =  $code + 1;
                $code_friends= $random;
                auth()->user()->update([
                    'code_friends'=>$random
                ]);
            }
            else{
                $code_friends= auth()->user()->code_friends;
            }
            $market=get_market(1);
            return view('user.referral',compact('code_friends','market'));
        }
        public function addresses(){
            return view('user.Profile.addresses');
        }
        public function profile(){
            return view('user.Profile.profile');
        }
        public function credit(){
            return view('user.Credit.credit');
        }


    }
