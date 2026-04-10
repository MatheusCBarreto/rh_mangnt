<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    Route::redirect('/', '/home');
    Route::get('/home', function () {
        return view('home');
    })->name('home');
});
