<?php

    namespace App\Http\Controllers\Home;
    use App\Amazing;
    use App\Cart;
    use App\City;
    use App\FoodDay;
    use App\Holiday;
    use App\Http\Controllers\Functions\FunctionController;
    use App\Cargo;
    use App\Menu;
    use App\Peyk;
    use App\Market;
    use App\Comment;
    use App\MarketTime;
    use App\Address;
    use App\Http\Controllers\Controller;
    use Carbon\Carbon;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Storage;
    use Mobile_Detect;

    class MenuController extends Controller
    {
        public function index(){
            $market=get_market(1);
            if (!$market)
                return abort(404);
            $detect = new Mobile_Detect;
            return view('home.Menu.menu' , compact('market','detect'));
        }
    }
