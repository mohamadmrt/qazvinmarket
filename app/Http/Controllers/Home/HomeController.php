<?php

namespace App\Http\Controllers\home;

use App\Admin;
use App\Amazing;
use App\Cart;
use App\Cargo;
use App\City;
use App\Comment;
use App\FoodDay;
use App\Holiday;
use App\Http\Controllers\Functions\FunctionController;
use App\Jobs\SendSms;
use App\Market;
use App\MarketTime;
use App\Menu;
use App\Order;
use App\Sms;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Mobile_Detect;
use Morilog\Jalali\jDateTime;
use PHPUnit\Util\RegularExpressionTest;

class homeController extends Controller
{
    public function TestMrt()
    {
        return 111;
        $cargos = 122;
        Cart::sync_cart($cargos);
//        DB::table('admins')
//            ->where('id', 10)
//            ->update(['name' => 'admin','family'=>'admin','tel'=>'09300606049','username'=>'admin_qm','password'=>Hash::make('QM0350')]);

//        $market = Market::find(1);
//
//
//        $market->peyk_price_discount = [['name'=>'ali'],['name'=>'255']];
//        $market->save();
//
//
//        foreach ($market->peyk_price_discount as $item){
//            return $item;
//        }

    }

    public function index()
    {
        $market = get_market(1);
        if (!$market)
            return abort(404);
        $detect = new Mobile_Detect;
        return view('home.Index.index', compact('market', 'detect'));
    }

    public function downloadApk()
    {
        $file = public_path(). "/apk/qazvinmarket.apk";
        $headers = ['Content-Type: application/apk'];
        return \Response::download($file, 'qazvinmarket.apk',$headers);
    }

    public function termAndConditions()
    {
        return view('home.termAndConditions');
    }

    public function contactUs()
    {
        $market = get_market(1);
        return view('home.ContactUs.contactus', compact('market'));
    }


    public function rules()
    {
        return view('home.Rules.rules');
    }

    public function aboutUs()
    {
        $market = get_market(1);
        return view('home.AboutUs.aboutUs', compact('market'));
    }

    public function guideSite()
    {
        return view('home.guide');
    }


}
