<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function dashboard(){
        if (!auth()->guard('admin')->user()) return redirect()->route('adminLogin');
        $admin = auth()->guard('admin')->user();
        return view('ocms.Home.home',compact('admin'));
    }


}
