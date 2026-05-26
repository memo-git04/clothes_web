<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(){
        return view('admin.layouts.dashboard');
    }




    //admin login-logout
    public function login()
    {
        return view('admin.layouts.login.page-login');
    }
    public function loginProcess(Request $request)
    {
        $accounts = $request->only(['email', 'password']);
        //        dd($accounts);
        if (Auth::guard('admin')->attempt($accounts)) {
            //lay du lieu cuar nguoi dang nhap
            $admin = Auth::guard('admin')->user();
            Auth::guard('admin')->login($admin);
            //luu du lieu cua nguoi dang nhap len session
            session(['admin' => $admin]);
            return Redirect::route('admin.modules.brand.index_brand');
        } else {
            return redirect()->route(brand.index);
        }
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        session()->forget('admin');
        return Redirect::route('login');
    }
}
