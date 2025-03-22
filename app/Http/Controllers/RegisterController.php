<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class RegisterController extends Controller
{
    //ログインフォームを表示
    public function showRegisterForm() {
        return view('reservations.register');
    }

    public function customerRegister(Request $request) {

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:customers,email',
            'password' => 'required|string|min:8|confirmed',
            ],
            [
                'name.required' => '名前は必須です。',
                'name.string' => '名前は文字列でお願いします。',
                'name.max' => '名前は255文字以内でお願いします。',
                'email.required' => 'EMAILは必須です。',
                'email.email' => '不正なメールアドレス形式です。',
                'email.max' => 'EMAILは255文字以内でお願いします。',
                'email.unique' => 'そのEMAILは既に存在します。',
                'password.required' => 'パスワードは必須です。',
                'password.min:8' => 'パスワードは8文字以上にしてください。',
                'password.confirmed' => 'パスワードが確認用と一致しません。',
            ]);

            // ユーザーの作成処理
                Customer::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'delete_flg' => 0,  // 論理削除フラグ（デフォルト0）
                'is_member' => 1,   // 会員登録完了として1に設定
            ]);

            return redirect()->route('reservations.index')->with('success', '会員登録が完了しました！');

    }
}
