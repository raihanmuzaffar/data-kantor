<?php

use App\Http\Controllers\ExportPdfController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/admin');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/export/employees/pdf', [ExportPdfController::class, 'employees'])
        ->name('export.employees.pdf');
    Route::get('/export/leave-requests/pdf', [ExportPdfController::class, 'leaveRequests'])
        ->name('export.leave-requests.pdf');
});
