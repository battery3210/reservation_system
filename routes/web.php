<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StylistController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Middleware\SimpleMiddleware;
use App\Http\Middleware\CustomAuthenticate;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/stylists',[StylistController::class,'index']);
Route::get('/reservations/customer',[CustomerController::class,'showCustomers'])->name('reservations.customer');

Route::get('/reservations/stylist',[StylistController::class,'showStylists'])->name('reservations.stylist')->middleware(SimpleMiddleware::class)->middleware(CustomAuthenticate::class); 

Route::get('/reservations',[ReservationController::class,'index'])->name('reservations.index');
Route::get('/reservations/api', [ReservationController::class, 'searchReservationJson']); 
Route::get('reservations/trash',[ReservationController::class,'trash'])->name('reservations.trash');
// Route::get('reservations/customer/trash',[StylistController::class,'trash'])->name('stylists.trash');
Route::match(['get', 'post'], 'reservations/stylists/trash', [StylistController::class, 'trash'])->name('stylists.trash');
Route::match(['get', 'post'], 'reservations/customers/trash', [CustomerController::class, 'trash'])->name('customers.trash');
Route::post('/reservations/create',[ReservationController::class,'create'])->name('reservations.create');
Route::get('/reservations/create',[ReservationController::class,'create'])->name('reservations.create');

Route::get('/reservations/auth/login',[LoginController::class,'showLoginForm'])->name('reservations.auth.login');
Route::post('/reservations/auth/login',[LoginController::class,'login'])->name('reservations.auth.login');

Route::get('/logout',function () { Auth::logout(); return redirect('/reservations/auth/login'); })->name('logout');

Route::get('/test', function () {
    return "ミドルウェア適用済みのページです";
})->middleware(SimpleMiddleware::class);  // ミドルウェアを直接指定

Route::get('/dashboard', function () {
    return "ダッシュボード（ログイン済みのみ閲覧可能）";
})->middleware(CustomAuthenticate::class);

Route::get('/test1', function () {
    return "これはGETのテストページです";
});

Route::post('/test2', function () {
    return "これはPOSTのテストページです";
});

Route::get('/test3', function () {
    return view('test');
});


