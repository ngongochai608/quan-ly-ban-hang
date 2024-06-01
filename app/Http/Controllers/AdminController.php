<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use DB;

session_start();

class AdminController extends Controller
{
    public function login () {
        $has_login = Session::get('admin_id');
        if (!empty($has_login)) {
            return Redirect::to('/dashboard');
        } else {
            return view('admin.login');
        }
    }
    
    public function logout () {
        Session::put('admin_username', null);
        Session::put('admin_id', null);
        return Redirect::to('/admin');
    }

    public function actionLogin (Request $request) {
        $username = $request->username;
        $password = md5($request->password);
        
        $result = DB::table('qlbh_users')->where('admin_username', $username)->where('admin_password', $password)->first();
        if(!empty($result)) {
            Session::put('admin_username', $result->admin_username);
            Session::put('admin_id', $result->admin_id);
            return Redirect::to('/dashboard');
        } else {
            Session::put('message', 'Sai tên đăng nhập hoặc mật khẩu');
            return Redirect::to('/admin');
        }
    }

    public function adminShowDashboard () {
        return view('admin.dashboard');
    }
}
