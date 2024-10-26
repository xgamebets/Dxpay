<?php

use App\Http\Controllers\PixController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/home');
});


// api pix  routes

Route::post('/requestQrCode',[PixController::class,'gererateQrCode'])->name('pixgenerate');
