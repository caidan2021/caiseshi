<?php

namespace App\Http\Controllers\Admin\Login;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function addAdminUser(Request $request)
    {
        $newUser = new User();
        $newUser->name = 'caidan';
        $newUser->password = bcrypt('bixufada');
        $newUser->remember_token = str_random(10);
        $newUser->save();
    }

    public function logOut()
    {
        //清除cookie

        //重定向到登录表单页面
        
    }

}