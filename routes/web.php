<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use RealRashid\SweetAlert\Facades\Alert;

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('index');
Route::get('/fte_request', [App\Http\Controllers\HomeController::class, 'fteRequest'])->name('fte_request');

Route::post('/request_form', [App\Http\Controllers\RequestFormController::class, 'store'])->name('request_form.store');


Route::view('/tables',  'tables')->name('tables');

