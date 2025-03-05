<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReservationController;

// Route::get('/reservations',[ReservationController::class,'search_reservation']);
Route::get('/reservations', [ReservationController::class, 'search_reservation']);