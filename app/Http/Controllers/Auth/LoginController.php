<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //ログインフォームを表示
    public function showLoginForm() {
        return view('reservations.auth.login');
    }

    public function login(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
         
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            return redirect()->intended('/reservations')->with('success','ログイン完了!!');;
        }

        return redirect()->back()->withErrors(['email' => '認証に失敗しました'])->withInput();
    }


}
