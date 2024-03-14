<?php

use App\Http\Controllers\Role\PermissionController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('permissions', [PermissionController::class, 'index'])
        ->name('permissions');

    Route::get('permissions/create', [PermissionController::class, 'create']);
    Route::post('permissions/create', [PermissionController::class, 'store'])->name('permissions.create');

//    Route::get('permissions/{id}/edit', [PermissionController::class, 'edit']);
//    Route::put('permissions/{id}', [PermissionController::class, 'update'])->name('permissions.update');
//    Route::delete('permissions/{id}', [PermissionController::class, 'destroy'])->name('permissions.destroy');
});
