<?php

use App\Http\Controllers\PixController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/home');
});

Route::post('/webhook/pix',[PixController::class,'webhook']);
// api pix  routes

Route::post('/requestQrCode',[PixController::class,'gererateQrCode'])->name('pixgenerate');
Route::post('/requestPayment',[PixController::class,'pixCashout'])->name('paymentgenerate');