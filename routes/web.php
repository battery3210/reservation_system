<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StylistController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ReservationController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/stylists',[StylistController::class,'index']);
Route::get('/reservations/customer',[CustomerController::class,'showCustomers']);
Route::get('/reservations/stylist',[StylistController::class,'showStylists']);
Route::get('/reservations',[ReservationController::class,'index'])->name('reservations.index');
Route::get('reservations/trash',[ReservationController::class,'trash'])->name('reservations.trash');
