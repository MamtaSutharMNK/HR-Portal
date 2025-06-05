<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use RealRashid\SweetAlert\Facades\Alert;

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('index');

Route::view('/tables',  'tables')->name('tables');

Route::get('/hello', function(){
    Alert::success("welocme");
    return view('welcome');
});