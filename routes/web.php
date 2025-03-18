<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StylistController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ReservationController;
use App\Http\Middleware\SimpleMiddleware;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/stylists',[StylistController::class,'index']);
Route::get('/reservations/customer',[CustomerController::class,'showCustomers'])->name('reservations.customer');
// Route::middleware(['auth.custom'])->group(function () {
Route::get('/reservations/stylist',[StylistController::class,'showStylists'])->name('reservations.stylist')->middleware(SimpleMiddleware::class)->middleware(SimpleMiddleware::class); 
//});

Route::get('/test', function () {
    return "ミドルウェア適用済みのページです";
})->middleware(SimpleMiddleware::class);  // ミドルウェアを直接指定

Route::get('/reservations',[ReservationController::class,'index'])->name('reservations.index');
Route::get('/reservations/api', [ReservationController::class, 'searchReservationJson']); 
Route::get('reservations/trash',[ReservationController::class,'trash'])->name('reservations.trash');
// Route::get('reservations/customer/trash',[StylistController::class,'trash'])->name('stylists.trash');
Route::match(['get', 'post'], 'reservations/stylists/trash', [StylistController::class, 'trash'])->name('stylists.trash');
Route::match(['get', 'post'], 'reservations/customers/trash', [CustomerController::class, 'trash'])->name('customers.trash');
// Route::get('/reservations/create',function (){return view('reservations.create');});
Route::post('/reservations/create',[ReservationController::class,'create'])->name('reservations.create');
Route::get('/reservations/create',[ReservationController::class,'create'])->name('reservations.create');

Route::get('/test1', function () {
    return "これはGETのテストページです";
});

Route::post('/test2', function () {
    return "これはPOSTのテストページです";
});

Route::get('/test3', function () {
    return view('test');
});


