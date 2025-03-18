<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route; // 追加
use Illuminate\Support\ServiceProvider;

use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Http\Request;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //// APIルートを手動で読み込む
        Route::prefix('api')
        ->middleware('api')
        ->group(base_path('routes/api.php'));

        // // 未認証ユーザーのリダイレクト先を設定
        // Authenticate::using(function (Request $request) {
        //     return redirect()->route('reservations')->with('error', 'ログインしてください');
        // });
    }
}
