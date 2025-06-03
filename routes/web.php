<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


    Route::view('/',  'index')->name('index');
 Route::view('/demologin',  'demologin')->name('demologin');
    Route::view('/demoregister',  'demoregister')->name('demoregister');
    Route::view('/tables',  'tables')->name('tables');

// Route::middleware('guest')->group(function () {
//     Route::view('/demologin',  'demologin')->name('demologin');
//     Route::view('/demoregister',  'demoregister')->name('demoregister');
// });

// Route::middleware('auth')->group(function() {
//     Route::view('/tables',  'tables')->name('tables');
// });
