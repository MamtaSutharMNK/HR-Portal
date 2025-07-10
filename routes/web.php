<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Controllers\FteRequestFormController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeLevelController;
use App\Http\Controllers\RequestingBranchController;
use App\Http\Controllers\SupportTicketController;

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->middleware('auth')->name('index');

Route::get('/fte_request/basic/{id}', [FteRequestFormController::class, 'fetchData'])->name('fte_request.blade');
Route::post('/fte_request/updatePosition/{id}', [FteRequestFormController::class, 'updatePosition']);

Route::resource('fte_request', FteRequestFormController::class)->middleware('auth');

Route::post('/fte_request/upload', [FteRequestFormController::class, 'upload'])->name('fte.upload')->middleware('auth');
Route::post('/fte_request/status-update', [FteRequestFormController::class, 'updateStatus'])->name('fte_request.status_update');

Route::post('/departments/batch', [DepartmentController::class, 'storeMultiple']);

Route::resource('employee-levels', EmployeeLevelController::class);

Route::resource('requesting-branches',RequestingBranchController::class);

Route::get('/edit-view', function () {
    return view('fte_list.edit');
});

//Datatables route
Route::get('/fte_request/list/ajax', [FteRequestFormController::class, 'ajaxList'])->name('fte_request.list.ajax');

Route::get('/fte_request/by-status', [FteRequestFormController::class, 'getByStatus'])->name('requests.byStatus');

Route::resource('support_tickets', SupportTicketController::class)->middleware('auth');








                                                                                                                                                                                                                                                                                                                                                                                               