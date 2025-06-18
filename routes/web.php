<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Controllers\FteRequestFormController;

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('index');

Route::view('/tables',  'tables')->name('tables');

Route::resource('fte_request', FteRequestFormController::class)->middleware('auth');

