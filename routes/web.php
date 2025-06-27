<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Controllers\FteRequestFormController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeLevelController;




Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->middleware('auth')->name('index');

Route::view('/tables',  'tables')->name('tables');

Route::resource('fte_request', FteRequestFormController::class)->middleware('auth');

Route::post('/fte_request/upload', [FteRequestFormController::class, 'upload'])->middleware('auth');
Route::post('/fte_request/status-update', [FteRequestFormController::class, 'updateStatus'])->name('fte_request.status_update');

Route::post('/fte_request/status-change', [FteRequestFormController::class, 'changeStatus'])->name('fte_request.status_change');

Route::post('/departments/batch', [DepartmentController::class, 'storeMultiple']);

Route::resource('employee-levels', EmployeeLevelController::class);

Route::post('/employeeLevels/batch', [EmployeeLevelController::class, 'storeBatch']);

Route::get('/edit-view', function () {
    return view('fte_list.edit');
});


                                                                                                                                                                                                                                                                                                                                                                                               